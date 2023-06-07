<?
namespace app\views\lw_1;

class Users{
    protected $name = "";
    protected $login = "";
    protected $password = "";

    public function __construct($name, $login, $password){
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
    }

    public function getInfo(){
        return [
            'name' => $this->name,
            'login' => $this->login,
            'password' => $this->password
        ];
    }

    public function __clone(){
        $this->name = "User";
        $this->login = "User";
        $this->password = "qwerty";
    }
}

$tmp = !isset($params['user_1']) ? false : json_decode(urldecode($params['user_1']), true);

$user1 = new Users(!$tmp ? 'Vasya' : $tmp["name"], !$tmp ? 'vasya' : $tmp["login"], !$tmp ? '123' : $tmp["password"]);
$user2 = new Users('Petya', 'petya', '123');
$user3 = new Users('Kolya', 'kolya', '123');

echo "<h1>Taks 2</h1>";

echo "<pre>" . var_dump($user1->getInfo())."</pre>";
echo "<pre>" . var_dump($user2->getInfo())."</pre>";
echo "<pre>" . var_dump($user3->getInfo())."</pre>";

$user4 = clone $user1;

echo "<h1>Taks 4</h1>";

echo "<pre>" . var_dump($user4->getInfo())."</pre>";

class SuperUsers extends Users{
    protected $character = "admin";

    public function __construct($name, $login, $password, $character){
        parent::__construct($name, $login, $password);
        $this->character = $character;
    }

    public function getInfo(){
        return [
            'name' => $this->name,
            'login' => $this->login,
            'password' => $this->password,
            'character' => $this->character
        ];
    }
}

$superUser1 = new SuperUsers('Vasya', 'vasya', '123', 'admin');

echo "<h1>Taks 5</h1>";

echo "<pre>" . var_dump($superUser1->getInfo())."</pre>";