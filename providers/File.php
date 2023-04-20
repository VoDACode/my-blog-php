<?

namespace app\providers;

use core\DB;

class File extends DB
{
    public $table = 'files';
    public $fields = [
        'id' => [
            'type' => 'INTEGER',
            'primary' => true,
            'autoincrement' => true
        ],
        'name' => [
            'type' => 'TEXT',
            'min' => 3,
            'max' => 255,
            'notnull' => true
        ],
        'type' => [
            'type' => 'TEXT',
            'min' => 3,
            'max' => 255,
            'notnull' => true
        ],
        'key' => [
            'type' => 'TEXT',
            'min' => 3,
            'max' => 255,
            'notnull' => true
        ],
        'post_id' => [
            'type' => 'INTEGER',
            'foreign' => 'posts.id'
        ],
        'download_count' => [
            'type' => 'INTEGER',
            'default' => 0
        ],
        'size' => [
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
