<?

namespace app\providers;

use core\DB;

class Image extends DB {
    public $table = 'images';
    public $fields = [
        'id' => [
            'type' => 'INTEGER',
            'primary' => true,
            'autoincrement' => true
        ],
        'name' => [
            'type' => 'TEXT',
            'min' => 1,
            'max' => 255,
            'notnull' => true
        ],
        'size' => [
            'type' => 'INTEGER',
            'notnull' => true
        ],
    ];
}