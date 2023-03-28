<?
namespace models;
use models\Model;
class PostModel extends Model{
    public $title;
    public $content;
    public $rating;
    public $authorId;
    public $createdAt;
    public $updatedAt;
    public $canHaveComments = true;

    public function __construct($id, $title, $content, $rating, $authorId, $canHaveComments = true, $createdAt = null, $updatedAt = null) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->rating = $rating;
        $this->authorId = $authorId;
        $this->canHaveComments = $canHaveComments;
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