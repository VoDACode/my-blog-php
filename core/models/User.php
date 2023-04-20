<?
namespace core\models;

use core\DB;
use core\interfaces\IAuthUser;

class User extends DB implements IAuthUser{

    public $table = 'users';

    public $fields = [
        'id' => [
            'type' => 'integer',
            'primary' => true,
            'autoincrement' => true
        ],
        'password' => [
            'type' => 'string',
            'required' => true,
            'min' => 3,
            'max' => 255
        ],
        'name' => [
            'type' => 'string',
            'required' => true,
            'min' => 3,
            'max' => 255
        ],
        'email' => [
            'type' => 'string',
            'required' => true,
            'min' => 3,
            'max' => 255
        ],
        'role' => [
            'type' => 'string',
            'required' => true,
            'min' => 3,
            'max' => 255
        ],
        'created_at' => [
            'type' => 'string',
            'default' => 'CURRENT_TIMESTAMP',
            'min' => 3,
            'max' => 255
        ],
        'updated_at' => [
            'type' => 'string',
            'default' => 'CURRENT_TIMESTAMP',
            'min' => 3,
            'max' => 255
        ]
    ];

    public $rules = [
        'login' => [
            'required' => true,
            'min' => 3,
            'max' => 255
        ],
        'password' => [
            'required' => true,
            'min' => 3,
            'max' => 255
        ],
        'name' => [
            'required' => true,
            'min' => 3,
            'max' => 255
        ],
        'email' => [
            'required' => true,
            'min' => 3,
            'max' => 255
        ],
        'phone' => [
            'required' => true,
            'min' => 3,
            'max' => 255
        ],
        'role' => [
            'required' => true,
            'min' => 3,
            'max' => 255
        ]
    ];

    public $timestamps = true;

    public function check(){
        if(!isset($_SESSION['user']))
            return false;
        $token = $_SESSION['user']['token'];

        return AuthToken::checkToken($token);
    }

    public function login($login, $password){
        $user = $this->select()->where('login = :login', [':login' => $login])->first()->run();
        if($user && password_verify($password, $user['password'])){
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    public function logout(){
        unset($_SESSION['user']);
    }

    public function get(){
        return $_SESSION['user'];
    }
}