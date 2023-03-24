<?
include 'Model.php';
class UserModel extends Model {
    public $name;
    public $email;
    public $password;
    public $createdAt;
    public $canPublishPosts = false;

    public function __construct($id, $name, $email, $password, $canPublishPosts = false, $createdAt = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->canPublishPosts = $canPublishPosts;
        if($createdAt == null) {
            $this->createdAt = date('Y-m-d H:i:s');
        } else {
            $this->createdAt = $createdAt;
        }
    }
}