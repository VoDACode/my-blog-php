<?
namespace models;
use models\Model;
class CommentModel extends Model {
    public $authorId;
    public $postId;
    public $content;
    public $commentId;
    public $rating = 0;
    public $createdAt;
    public $updatedAt;

    public function __construct($id, $authorId, $postId, $content, $commentId = null, $rating = 0, $createdAt = null, $updatedAt = null) {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->postId = $postId;
        $this->content = $content;
        $this->commentId = $commentId;
        $this->rating = $rating;
        if($createdAt == null) {
            $this->createdAt = date('Y-m-d H:i:s');
        } else {
            $this->createdAt = $createdAt;
        }
        if($updatedAt == null) {
            $this->updatedAt = date('Y-m-d H:i:s');
        } else {
            $this->updatedAt = $updatedAt;
        }
    }

}