<?
namespace models;
use models\Model;
class FileModel extends Model{
    public $name;
    public $size;
    public $postId;

    public function __construct($id, $name, $size, $postId) {
        $this->id = $id;
        $this->name = $name;
        $this->size = $size;
        $this->postId = $postId;
    }
}