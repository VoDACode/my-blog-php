<?
namespace app\controllers\API;

use app\providers\User;

class UserController extends \core\BaseController
{
    private $userProvider;

    public function __construct()
    {
        $this->userProvider = new User();
    }

    public function index()
    {
        $this->SendJson($this->userProvider->select()->run());
    }

    public function info(int $id)
    {
        $this->requireAuth();
        echo json_encode($this->userProvider->select()->where("id = $id")->run());
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        var_dump($this->userProvider->insert($data)->run());
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = $this->userProvider->update($data)->where("id = $id")->run();
        echo json_encode($user);
    }

    public function destroy($id)
    {
        $this->userProvider->delete()->where("id = $id")->run();
        echo 'User deleted';
    }
}