<?

namespace app\controllers\API;

use app\providers\User;
use core\Auth;
use core\BaseController;

class AuthController extends BaseController
{

    protected $userProvider;

    public function __construct($request)
    {
        parent::__construct($request);
        $this->userProvider = new User();
    }

    public function login()
    {
        $this->POST();
        $this->validate([
            'login' => [
                'required' => true,
                'min' => 3,
                'max' => 255
            ],
            'password' => [
                'required' => true,
                'min' => 3,
                'max' => 255
            ]
        ]);

        $login = $this->request->body['login'];
        $password = $this->request->body['password'];
        if (Auth::login($login, $password)) {
            $this->Redirect('/');
        } else {
            $this->Unauthorized('Invalid login or password');
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->Redirect('/');
    }

    public function check()
    {
        if (Auth::check()) {
            $this->Ok();
        } else {
            $this->BadRequest();
        }
    }

    public function regin()
    {
        $this->POST();

        $this->validate([
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
                'max' => 255,
                'email' => true
            ]
        ]);

        $password = $this->request->body['password'];
        $name = $this->request->body['name'];
        $email = $this->request->body['email'];

        if ($this->userProvider->getByName($name) != false) {
            $this->BadRequest(['name' => 'This name is already taken']);
        }

        if ($this->userProvider->getByEmail($email) != false) {
            $this->BadRequest(['email' => 'This email is already taken']);
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $this->userProvider->insert([
            'password' => $password,
            'name' => $name,
            'email' => $email
        ])->run();
        $this->Redirect('/login');
    }
}
