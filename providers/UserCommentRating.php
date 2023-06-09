<?

namespace app\providers;

use core\DB;

class UserCommentRating extends DB{
    
    public $table = 'user_comment_rating';

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
        'comment_id' => [
            'type' => 'INTEGER',
            'notnull' => true
        ],
        'rating' => [
            'type' => 'INTEGER',
            'notnull' => true
        ]
    ];
}