<?
abstract class Model {
    public $id;
    
    public function __construct($id) {
        $this->id = $id;
    }
}