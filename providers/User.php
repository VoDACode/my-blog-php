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
        'name' => [
            'type' => 'TEXT',
            'unique' => true,
            'min' => 3,
            'max' => 255,
            'notnull' => true,
        ],
        'email' => [
            'type' => 'TEXT',
            'unique' => true,
            'min' => 3,
            'max' => 255,
            'notnull' => true,
        ],
        'password' => [
            'type' => 'TEXT',
            'min' => 3,
            'max' => 255,
            'notnull' => true,
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
        if (!isset($_SESSION['user']))
            return false;
        return AuthToken::checkToken(AuthToken::getToken());
    }

    public function get()
    {
        return $_SESSION['user'];
    }

    public function login($login, $password)
    {
        $user = $this->select()->where("name = :name OR email = :email", [
            ':name' => $login,
            ':email' => $login
        ])->run();
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
        $user = $this->select()->where("email = :email", [
            ':email' => $email
        ])->run();
        if (count($user) == 0) {
            return false;
        }
        return $user[0];
    }

    public function getByName($name)
    {
        $user = $this->select()->where("name = :name", [
            ':name' => $name
        ])->run();
        if (count($user) == 0) {
            return false;
        }
        return $user[0];
    }
}
