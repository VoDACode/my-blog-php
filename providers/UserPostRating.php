<?

namespace app\providers;

use core\DB;

class UserPostRating extends DB{
    public $table = 'user_post_rating';
    public $fields = [
        'id' => [
            'type' => 'INTEGER',
            'primary' => true,
            'autoincrement' => true
        ],
        'user_id' => [
            'type' => 'INTEGER',
            'notnull' => true
        ],
        'post_id' => [
            'type' => 'INTEGER',
            'notnull' => true
        ],
        'rating' => [
            'type' => 'INTEGER',
            'notnull' => true
        ]
    ];
}