<?

namespace app\providers;

use core\DB;

class Statistics extends DB
{
    public $table = 'statistics';
    public $fields = [
        'id' => [
            'type' => 'INTEGER',
            'primary' => true,
            'autoincrement' => true
        ],
        'username' => [
            'type' => 'TEXT',
            'unique' => true,
            'notnull' => true,
        ],
        'last_visit_date' => [
            'type' => 'TEXT',
            'notnull' => true
        ],
        'count' => [
            'type' => 'INTEGER',
            'notnull' => true
        ]
    ];
}