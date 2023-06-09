<?

namespace app\providers;

use core\DB;

class Comment extends DB
{
    public $table = 'comments';
    public $fields = [
        'id' => [
            'type' => 'INTEGER',
            'primary' => true,
            'autoincrement' => true
        ],
        'text' => [
            'type' => 'TEXT',
            'min' => 1,
            'max' => 1000,
            'notnull' => true
        ],
        'post_id' => [
            'type' => 'INTEGER',
            'notnull' => true,
        ],
        'user_id' => [
            'type' => 'INTEGER',
        ],
        'created_at' => [
            'type' => 'TEXT',
            'default' => 'CURRENT_TIMESTAMP'
        ],
        'modified' => [
            'type' => 'TEXT',
            'default' => NULL
        ],
        'rating' => [
            'type' => 'INTEGER',
            'default' => 0
        ]
    ];
}