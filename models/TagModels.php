<?

class TagModel extends Model{
    public $name;
    public $createdAt;

    public function __construct($id, $name, $createdAt = null){
        $this->id = $id;
        $this->name = $name;
        if($createdAt == null){
            $this->createdAt = date('Y-m-d H:i:s');
        } else {
            $this->createdAt = $createdAt;
        }
    }
}