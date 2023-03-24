<?
include 'db.php';
include 'config.php';
class Provider{
    protected $db;
    public function __construct(){
        $this->db = new Database();
    }

    public function __destruct(){
        $this->db->close();
    }

    protected function getTableName(string $className){
        return PROVIDERS_TABLE[$className];
    }
}