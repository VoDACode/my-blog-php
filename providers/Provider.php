<?
namespace providers;
use root\Database;
use root\AppConfig;
class Provider{
    protected $db;
    public function __construct(){
        $this->db = new Database();
    }

    public function __destruct(){
        $this->db->close();
    }

    protected function getTableName(string $className){
        $className = explode('\\', $className)[1];
        return AppConfig::$PROVIDERS_TABLE[$className];
    }
}