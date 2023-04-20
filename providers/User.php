<?

namespace app\providers;

use core\DB;
use core\interfaces\IAuthUser;

class User extends DB implements IAuthUser
{
    public $table = 'users';
    public $fields = [
        'id' => [
            'type' => 'INTEGER',
            'primary' => true,
            'autoincrement' => true
        ],
        'name' =>[
            'type' => 'TEXT',
            'unique' => true,
            'min' => 3,
            'max' => 255,
        ],
        'email' => [
            'type' => 'TEXT',
            'unique' => true,
            'min' => 3,
            'max' => 255,
        ],
        'password' => [
            'type' => 'TEXT',
            'min' => 3,
            'max' => 255
        ],
        'created_at' => [
            'type' => 'TEXT',
            'default' => 'CURRENT_TIMESTAMP'
        ],
        'updated_at' => [
            'type' => 'TEXT',
            'default' => 'CURRENT_TIMESTAMP'
        ],
        'can_make_post' => [
            'type' => 'INTEGER',
            'default' => 0
        ],
        'active' => [
            'type' => 'INTEGER',
            'default' => 1
        ]
    ];

    public function check()
    {
        return isset($_SESSION['user']);
    }

    public function get()
    {
        return $_SESSION['user'];
    }

    public function login($login, $password)
    {
        $login = DB::cleanString($login);
        $password = DB::cleanString($password);
        $user = $this->select()->where("name = '$login' OR email = '$login'")->run();
        if (count($user) == 0) {
            return false;
        }
        $user = $user[0];
        if (password_verify($password, $user['password'])) {
            $token = AuthToken::generateToken($user['id']);
            AuthToken::setToken($token);
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
        AuthToken::deleteToken(AuthToken::getToken());
        return true;
    }

    public function getByEmail($email)
    {
        $email = DB::cleanString($email);
        $user = $this->select()->where("email = '$email'")->run();
        if (count($user) == 0) {
            return false;
        }
        return $user[0];
    }

    public function getByName($name)
    {
        $name = DB::cleanString($name);
        $user = $this->select()->where("name = '$name'")->run();
        if (count($user) == 0) {
            return false;
        }
        return $user[0];
    }
}
