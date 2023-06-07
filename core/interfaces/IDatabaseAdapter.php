<?

namespace core\interfaces;

interface IDatabaseAdapter{
    public function select($columns = '*');
    public static function all();
    public function where($template, $params = []);
    public function delete();
    public function update($data);
    public function insert($data);
    public function orderBy($column, $order = 'ASC');
    public function limit($limit);
    public function first();
    public function last();
    public function run();
    public function createTable();
}