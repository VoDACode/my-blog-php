<?

namespace core\adapters;

use core\interfaces\IDatabaseAdapter;

class MongoDatabaseAdapter implements IDatabaseAdapter
{
    private $connection;
    
    public function select($columns = '*')
    {
        throw new \Exception('Not Implemented');
    }
    public static function all()
    {
        throw new \Exception('Not Implemented');
    }
    public function where($template, $params = [])
    {
        throw new \Exception('Not Implemented');
    }
    public function delete()
    {
        throw new \Exception('Not Implemented');
    }
    public function update($data)
    {
        throw new \Exception('Not Implemented');
    }
    public function insert($data)
    {
        throw new \Exception('Not Implemented');
    }
    public function orderBy($column, $order = 'ASC')
    {
        throw new \Exception('Not Implemented');
    }
    public function limit($limit)
    {
        throw new \Exception('Not Implemented');
    }
    public function first()
    {
        throw new \Exception('Not Implemented');
    }
    public function last()
    {
        throw new \Exception('Not Implemented');
    }
    public function run()
    {
        throw new \Exception('Not Implemented');
    }
    public function createTable()
    {
        throw new \Exception('Not Implemented');
    }
}
