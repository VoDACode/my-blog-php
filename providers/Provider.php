<?

namespace app\providers;

use Exception;
use SQLite3;

// Older version of the Provider class. It was replaced by the DB class.
abstract class Provider
{
    protected $columns = [];
    protected $table = "";

    public static function all()
    {
        $provider = new static();
        return $provider->selectSQL();
    }

    public static function find($id)
    {
        $provider = new static();
        return $provider->selectSQL('id = ' . $id);
    }

    public static function create($data)
    {
        $provider = new static();
        return $provider->insertSQL($data);
    }

    public static function update($id, $data)
    {
        $provider = new static();
        return $provider->updateSQL('id = ' . $id, $data);
    }

    public static function updateWhere($where, $data)
    {
        $provider = new static();
        return $provider->updateSQL($where, $data);
    }

    public static function delete($id)
    {
        $provider = new static();
        return $provider->deleteSQL('id = ' . $id);
    }

    public static function where($column, $value)
    {
        $provider = new static();
        return $provider->selectSQL(null, $column, $value);
    }

    public static function select($where, $column, $values)
    {
        $provider = new static();
        return $provider->selectSQL($where, $column, $values);
    }

    public static function deleteWhere($where)
    {
        $provider = new static();
        return $provider->deleteSQL($where);
    }

    public function getColumns()
    {
        if (!isset($this->columns) || empty($this->columns))
            throw new Exception("Columns not set in provider: " . get_class($this));
        return array_keys($this->columns);
    }

    public function getTable()
    {
        if (!isset($this->table) || empty($this->table)) {
            $class = get_class($this);
            $class = explode('\\', $class);
            $class = end($class);
            $class = strtolower($class);
            $class = str_replace('provider', '', $class);
            $this->table = $class;
        }
        return $this->table;
    }

    private function insertSQL($data)
    {
        $db = new SQLite3($_ENV['DB_NAME']);
        $table = $this->getTable();
        $sql = "INSERT INTO $table (";
        $columns = [];
        foreach ($this->columns as $column => $options) {
            if ($column == 'id') continue;
            if (isset($options['default']) && !isset($data[$column])) continue;
            if (!in_array($column, $this->getColumns())) continue;
            if (!isset($data[$column])) {
                throw new Exception("Column '$column' is required");
            }
            $columns[] = $column;
        }
        $sql .= implode(', ', $columns);
        $sql .= ")";
        $sql .= " VALUES (";
        $values = [];
        foreach ($columns as $column) {
            if ($this->columns[$column]['type'] == 'TEXT')
                $values[] = "'" . $data[$column] . "'";
            else
                $values[] = $data[$column];
        }
        $sql .= implode(', ', $values);
        $sql .= ")";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db->close();
        return $this->selectSQL($db->lastInsertRowID());
    }

    private function selectSQL(string $where = null, $limit = null, $offset = null)
    {
        $db = new SQLite3($_ENV['DB_NAME']);
        $table = $this->getTable();
        $sql = "SELECT * FROM $table";
        if (isset($where)) {
            $sql .= " WHERE $where";
        }
        if (isset($limit)) {
            $sql .= " LIMIT $limit";
        }
        if (isset($offset)) {
            $sql .= " OFFSET $offset";
        }
        $stmt = $db->prepare($sql);
        $result = $stmt->execute();
        $data = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }
        $db->close();
        return $data;
    }

    private function updateSQL($data, string $where)
    {
        $db = new SQLite3($_ENV['DB_NAME']);
        $table = $this->getTable();
        $sql = "UPDATE $table SET ";
        $columns = [];

        foreach ($data as $column => $value) {
            if ($column == 'id') continue;
            if (!in_array($column, $this->getColumns())) continue;
            if ($this->columns[$column]['type'] == 'TEXT')
                $columns[] = "$column = '" . $data[$column] . "'";
            else
                $columns[] = "$column = " . $data[$column];
        }

        $columns[] = "updated_at = " . time();

        $sql .= implode(', ', $columns);
        $sql .= " WHERE $where";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db->close();
        return $this->selectSQL($where);
    }

    private function deleteSQL(string $where)
    {
        $deletedRow = $this->selectSQL($where);
        $db = new SQLite3($_ENV['DB_NAME']);
        $table = $this->getTable();
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db->close();
        return $deletedRow;
    }

    public function createTable()
    {
        $sql = "";
        try {
            $db = new SQLite3($_ENV['DB_NAME']);
            $table = $this->getTable();
            $sql = "CREATE TABLE IF NOT EXISTS $table (";
            $columns = [];
            foreach ($this->columns as $column => $options) {
                $col = $column . " " . $options['type'];
                if (isset($options['primary']) && $options['primary'] == true) {
                    $col .= " PRIMARY KEY";
                }
                if (isset($options['autoincrement']) && $options['autoincrement'] == true) {
                    $col .= " AUTOINCREMENT";
                }
                if (isset($options['default'])) {
                    $col .= " DEFAULT " . $options['default'];
                }
                if (isset($options['unique']) && $options['unique'] == true) {
                    $col .= " UNIQUE";
                }
                $columns[] = $col;
            }
            $sql .= implode(', ', $columns);
            $sql .= ")";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db->close();
        } catch (\Exception $e) {
            echo 'SQL: ' . $sql . '<br>';
            echo $e->getMessage();
            die();
        }
    }
}
