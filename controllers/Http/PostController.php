<?

namespace app\controllers\Http;

use core\BaseController;
use core\View;
use app\providers\Post;
use app\providers\File;
use app\providers\User;

use core\FileStorage;

class PostController extends BaseController
{
    private $model;

    public function __construct($request)
    {
        parent::__construct($request);
        $this->model = new Post();
    }

    public function index()
    {
        $userModel = new User();
        $fileModel = new File();
        $posts = $this->model->all();
        foreach ($posts as $key => $post) {
            $files = $fileModel->select()->where('post_id = :post_id', [
                ':post_id' => $post['id']
            ])->run();

            // $file['type'] --> image/png
            // get only image files
            $posts[$key]['images'] = array_filter($files, function ($file) {
                return strpos($file['type'], 'image') === 0;
            });
            // get only other files
            $posts[$key]['files'] = array_filter($files, function ($file) {
                return strpos($file['type'], 'image') !== 0;
            });

            $posts[$key]['user'] = $userModel->select()->where('id = :id', [
                ':id' => $post['user_id']
            ])->run()[0];

            $posts[$key]['comments'] = [];
        }
        View::render('posts', [
            'styles' => [
                '/css/post.css'
            ],
            'after_load_scripts' => [
                '/js/post.js'
            ],
            'posts' => $posts
        ]);
    }

    public function create()
    {
        $this->POST();
        $this->requireAuth();
        if ($this->httpUser['id'] != 1 && $this->httpUser['can_create_post'] == 0)
            $this->Unauthorized();
        $this->validate([
            'title' => [
                'required',
                'min:1',
                'max:255'
            ],
            'content' => [
                'max:2048'
            ]
        ]);
        $id = $this->model->insert([
            'title' => $this->request->body['title'],
            'content' => $this->request->body['content'],
            'user_id' => $this->httpUser['id'],
            'can_have_comments' => $this->request->body['can_have_comments'] == 'on' ? 1 : 0
        ])->run();

        $fileCount = count($_FILES['file']['name']);

        $fileModel = new File();
        for ($i = 0; $i < $fileCount; $i++) {
            $key = $this->getRandomString(32).'_'.$i.$id;
            $file = [
                'name' => $_FILES['file']['name'][$i],
                'type' => $_FILES['file']['type'][$i],
                'tmp_name' => $_FILES['file']['tmp_name'][$i],
                'error' => $_FILES['file']['error'][$i],
                'size' => $_FILES['file']['size'][$i]
            ];
            FileStorage::upload($file, $key);
            $fileModel->insert([
                'name' => $file['name'],
                'type' => $file['type'],
                'size' => $file['size'],
                'post_id' => $id,
                'key' => $key
            ])->run();
        }
        $this->Redirect('/');
    }

    // TODO: ITS TEST METHOD
    public function remove(){
        $this->DELETE();
        $id = $this->request->body['id'];
        $this->model->delete()->where('id = :id', [':id' => $id])->run();
        $fileModel = new File();
        $files = $fileModel->select()->where('post_id = :post_id', [
            ':post_id' => $id
        ])->run();
        foreach($files as $file){
            FileStorage::delete($file['key'].DIRECTORY_SEPARATOR.$file['name']);
        }
        $fileModel->delete()->where('post_id = :post_id', [
            ':post_id' => $id
        ])->run();
        $this->Ok();
    }
}
