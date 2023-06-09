<?
namespace app\controllers\API;

use app\providers\User;

class UserController extends \core\BaseController
{
    private $userProvider;

    public function __construct($request)
    {
        parent::__construct($request);
        $this->userProvider = new User();
    }

    public function index()
    {
        $this->SendJson($this->userProvider->select()->run());
    }

    public function info(int $id)
    {
        $this->requireAuth();
        echo json_encode($this->userProvider->select()->where("id = :id", [':id' => $id])->run());
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        var_dump($this->userProvider->insert($data)->run());
    }

    // /api/users/update
    public function update()
    {
        $this->POST();
        $this->requireAuth();
        $this->validate([
            'id' => [
                'required' => true,
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
            ],
        ]);

        $id = $this->request->body['id'];
        $name = $this->request->body['name'];
        $email = $this->request->body['email'];
        $can_make_post = $this->request->body['can_make_post'] == "on" ? 1 : 0;

        $user = $this->userProvider->update([
            'name' => $name,
            'email' => $email,
            'can_make_post' => $can_make_post
        ])->where("id = :id", [':id' => $id])->run();
        
        $this->GoToBack();
    }

    public function destroy()
    {
        $this->POST();
        $this->requireAuth();

        $id = $this->request->body['id'];

        $this->userProvider->delete()->where("id = :id", [':id' => $id])->run();
    }
}