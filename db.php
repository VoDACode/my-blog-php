<?
include 'config.php';
class Database extends SQLite3
{
    private static $firstRun = true;
    function __construct()
    {
        if(file_exists(DB_FILE) && filesize(DB_FILE) > 0) {
            self::$firstRun = false;
        }
        if(!file_exists(DB_FILE) || filesize(DB_FILE) == 0) {
            self::$firstRun = true;
        }
        $this->open(DB_FILE);
        $this->createTables();
    }

    public function createTables()
    {
        if(!self::$firstRun) {
            return;
        }
        foreach (DB_TABLES as $table => $query) {
            $this->exec($query);
        }
        self::$firstRun = false;
    }
}