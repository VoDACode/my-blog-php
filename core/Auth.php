<?
namespace core;

class Auth{

    static private $user = null;

    static public $token = null;

    static public function user(){
        if(self::$user == null){
            self::$user = new $_ENV['USER_MODEL'];
            if(!self::$user instanceof \core\interfaces\IAuthUser){
                throw new \Exception('User model must implement "\core\interfaces\IAuthUser" interface');
            }
        }
        return self::$user;
    }

    static public function get(){
        return self::user()->get();
    }

    static public function check(){
        return self::user()->check();
    }

    static public function login($login, $password){
        return self::user()->login($login, $password);
    }

    static public function logout(){
        return self::user()->logout();
    }

    static public function needAuth(){
        if(!self::check()){
            header('Location: /login');
            exit;
        }
    }

    static public function needAdmin(){
        if(!self::check() || self::get()['id'] != 1){
            header('Location: /');
            exit;
        }
    }
}