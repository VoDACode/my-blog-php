<?

namespace app\providers;

use core\DB;

class Post extends DB{
    public $table = 'posts';

    public $fields = [
        'id' => [
            'type' => 'INTEGER',
            'primary' => true,
            'autoincrement' => true
        ],
        'title' => [
            'type' => 'TEXT',
            'min' => 1,
            'max' => 255,
            'notnull' => true
        ],
        'content' => [
            'type' => 'TEXT',
            'min' => 0,
            'max' => 65535,
        ],
        'user_id' => [
            'type' => 'INTEGER',
            'foreign' => 'users.id'
        ],
        'can_have_comments' => [
            'type' => 'INTEGER',
            'default' => 1
        ],
        'rating' => [
            'type' => 'INTEGER',
            'default' => 0
        ],
        'created_at' => [
            'type' => 'TEXT',
            'default' => 'CURRENT_TIMESTAMP'
        ],
        'updated_at' => [
            'type' => 'TEXT',
            'default' => 'CURRENT_TIMESTAMP'
        ]
    ];
}