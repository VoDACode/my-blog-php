<?

namespace core;

class DB
{
    private $connection;
    private $sql;
    public $table = '';
    public $fields = [];
    public $rules = [];

    public $timestamps = false;

    public function __construct()
    {
        $this->connection = new \SQLite3($_ENV['DB_NAME']);
        if ($this->connection->lastErrorCode() != 0) {
            throw new \Exception($this->connection->lastErrorMsg());
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }

    public static function all(){
        $db = new static();
        return $db->select()->run();
    } 

    public function select($columns = '*')
    {
        $this->sql = "SELECT $columns FROM $this->table";
        return $this;
    }

    public function where($where)
    {
        $this->sql .= " WHERE $where";
        return $this;
    }

    public function delete()
    {
        $this->sql = "DELETE FROM $this->table";
        return $this;
    }

    public function update($data)
    {
        $this->sql = "UPDATE $this->table SET ";
        $i = 0;
        foreach ($data as $key => $value) {
            $value = self::cleanString($value);
            $this->sql .= "$key = '$value'";
            if ($i < count($data) - 1) {
                $this->sql .= ', ';
            }
            $i++;
        }
        return $this;
    }

    public function insert($data)
    {
        $this->sql = "INSERT INTO $this->table (";
        $i = 0;
        foreach ($data as $key => $value) {
            $this->sql .= "$key";
            if ($i < count($data) - 1) {
                $this->sql .= ', ';
            }
            $i++;
        }
        $this->sql .= ') VALUES (';
        $i = 0;
        foreach ($data as $key => $value) {
            $value = self::cleanString($value);
            $this->sql .= "'$value'";
            if ($i < count($data) - 1) {
                $this->sql .= ', ';
            }
            $i++;
        }
        $this->sql .= ')';
        return $this;
    }

    public function like($column, $value)
    {
        $value = self::cleanString($value);
        $this->sql .= " WHERE $column LIKE '%$value%'";
        return $this;
    }

    public function orderBy($column, $order = 'ASC')
    {
        $this->sql .= " ORDER BY $column $order";
        return $this;
    }

    public function limit(int $limit)
    {
        $this->sql .= " LIMIT $limit";
        return $this;
    }

    public function first()
    {
        $this->sql .= " LIMIT 1";
        return $this;
    }

    public function last()
    {
        $this->sql .= " ORDER BY id DESC LIMIT 1";
        return $this;
    }

    public function run()
    {
        if (empty($this->sql)) {
            return [];
        }    
        $stmt = $this->connection->prepare($this->sql);
        $result = $stmt->execute();
        if ($this->connection->lastErrorCode() != 0) {
            throw new \Exception($this->connection->lastErrorMsg());
        }
        if(strpos($this->sql, 'SELECT') !== false) {
            $data = [];
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $data[] = $row;
            }
            $this->sql = '';
            return $data;
        } else {
            $this->sql = '';
            return $this->connection->lastInsertRowID();
        }
    }

    public function count($where = null)
    {
        $this->sql = "SELECT COUNT(*) FROM $this->table";
        if ($where != null) {
            $this->sql .= " WHERE $where";
        }
        $stmt = $this->connection->prepare($this->sql);
        $result = $stmt->execute();
        if ($this->connection->lastErrorCode() != 0) {
            throw new \Exception($this->connection->lastErrorMsg());
        }
        $data = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }
        $this->sql = '';
        return $data[0]['COUNT(*)'];
    }

    public function createTable()
    {
        $this->sql = "CREATE TABLE IF NOT EXISTS $this->table (";
        $i = 0;
        foreach ($this->fields as $key => $value) {
            $this->sql .= "$key ";
            $this->sql .= $value['type'];

            if (isset($value['primary']) && $value['primary'] == true) {
                $this->sql .= ' PRIMARY KEY';
            }
            if (isset($value['autoincrement']) && $value['autoincrement'] == true) {
                $this->sql .= ' AUTOINCREMENT';
            }
            if (isset($value['default'])) {
                $this->sql .= " DEFAULT $value[default]";
            }
            if(isset($value['notnull']) && $value['notnull'] == true) {
                $this->sql .= ' NOT NULL';
            }
            if (isset($value['unique']) && $value['unique'] == true) {
                $this->sql .= ' UNIQUE';
            }
            if ($i < count($this->fields) - 1) {
                $this->sql .= ', ';
            }
            $i++;
        }
        $this->sql .= ')';
        $this->connection->exec($this->sql);
        if ($this->connection->lastErrorCode() != 0) {
            throw new \Exception($this->connection->lastErrorMsg());
        }
        return $this;
    }

    public static function cleanString($str) {
        $str = strip_tags($str); // remove HTML and PHP tags
        $str = htmlentities($str, ENT_QUOTES); // encode special characters
        $str = str_replace("'", "\'", $str); // escape single quotes
        $str = str_replace('"', '\"', $str); // escape double quotes
        // fix sql injection
        $str = str_replace(';', '', $str);
        $str = str_replace('--', '', $str);
        $str = str_replace('/*', '', $str);
        $str = str_replace('*/', '', $str);
        $str = str_replace('xp_', '', $str);
        return $str;
    }
}
