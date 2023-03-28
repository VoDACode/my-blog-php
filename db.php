<?
namespace root;
include_once 'config.php';
use SQLite3;
class Database extends SQLite3
{
    private static $firstRun = true;
    function __construct()
    {
        if(file_exists(\root\AppConfig::$DB_FILE) && filesize(\root\AppConfig::$DB_FILE) > 0) {
            self::$firstRun = false;
        }
        if(!file_exists(\root\AppConfig::$DB_FILE) || filesize(\root\AppConfig::$DB_FILE) == 0) {
            self::$firstRun = true;
        }
        $this->open(\root\AppConfig::$DB_FILE);
        $this->createTables();
    }

    public function createTables()
    {
        if(!self::$firstRun) {
            return;
        }
        foreach (\root\AppConfig::$DB_TABLES as $table => $query) {
            $this->exec($query);
        }
        self::$firstRun = false;
    }
}