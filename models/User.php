<?
namespace app\models;

class User{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;
    public $can_make_post;
    public $active = true;

    public function __construct($id, $name, $email, $password, $created_at, $updated_at, $can_make_post = false){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->can_make_post = $can_make_post;
    }
}