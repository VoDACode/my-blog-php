<?

namespace app\controllers\Http;

use core\BaseController;
use core\View;
use app\providers\Post;
use app\providers\File;
use app\providers\User;
use app\providers\Comment;
use app\providers\UserPostRating;
use app\providers\UserCommentRating;

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
        $commentModel = new Comment();
        $userPostRatingModel = new UserPostRating();
        $userCommentRatingModel = new UserCommentRating();
        $posts = $this->model->select()->orderBy('created_at', 'DESC')->run();
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

            $posts[$key]['comments'] = $commentModel->select()->where('post_id = :post_id', [
                ':post_id' => $post['id']
            ])->run();

            foreach ($posts[$key]['comments'] as $commentKey => $comment) {
                $posts[$key]['comments'][$commentKey]['user'] = $userModel->select()->where('id = :id', [
                    ':id' => $comment['user_id']
                ])->run()[0];
                $posts[$key]['comments'][$commentKey]['my_rating'] = 0;
                if ($this->httpUser != false) {
                    $data = $userCommentRatingModel->select()->where('user_id = :user_id AND comment_id = :comment_id', [
                        ':user_id' => $this->httpUser['id'],
                        ':comment_id' => $comment['id']
                    ])->run();
                    if ($data != []) {
                        $posts[$key]['comments'][$commentKey]['my_rating'] = $data[0]['rating'];
                    }
                }
            }

            $posts[$key]['my_rating'] = 0;
            if ($this->httpUser != false) {
                $data = $userPostRatingModel->select()->where('user_id = :user_id AND post_id = :post_id', [
                    ':user_id' => $this->httpUser['id'],
                    ':post_id' => $post['id']
                ])->run();
                if ($data != []) {
                    $posts[$key]['my_rating'] = $data[0]['rating'];
                }
            }
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
            $key = $this->getRandomString(32) . '_' . $i . $id;
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

    public function rating()
    {
        $this->GET();
        $this->requireAuth();
        if ($this->request->body['rating'] < -1 || $this->request->body['rating'] > 1)
            $this->BadRequest();
        $userPostRatingModel = new UserPostRating();
        $userRating = $userPostRatingModel->select('rating')->where('user_id = :user_id AND post_id = :post_id', [
            ':user_id' => $this->httpUser['id'],
            ':post_id' => $this->request->body['post_id']
        ])->run();
        $currentRating = $this->model->select('rating')->where('id = :id', [
            ':id' => $this->request->body['post_id']
        ])->run();

        if ($currentRating == [])
            $this->BadRequest('Post not found');
        $currentRating = $currentRating[0]['rating'];

        // if user removes his rating
        if ($this->request->body['rating'] == 0) {
            // remove user rating
            $userPostRatingModel->delete()->where('user_id = :user_id AND post_id = :post_id', [
                ':user_id' => $this->httpUser['id'],
                ':post_id' => $this->request->body['post_id']
            ])->run();
            // update post rating
            $this->model->update([
                'rating' => $currentRating - $userRating[0]['rating']
            ])->where('id = :id', [
                ':id' => $this->request->body['post_id']
            ])->run();
        } else {
            // if user has not rated this post before
            if ($userRating == []) {
                // insert user rating
                $userPostRatingModel->insert([
                    'user_id' => $this->httpUser['id'],
                    'post_id' => $this->request->body['post_id'],
                    'rating' => $this->request->body['rating']
                ])->run();
                // update post rating
                $this->model->update([
                    'rating' => $currentRating + $this->request->body['rating']
                ])->where('id = :id', [
                    ':id' => $this->request->body['post_id']
                ])->run();
            } else if ($this->request->body['rating'] != $userRating[0]['rating']) {
                // update user rating
                $userPostRatingModel->update([
                    'rating' => $this->request->body['rating']
                ])->where('user_id = :user_id AND post_id = :post_id', [
                    ':user_id' => $this->httpUser['id'],
                    ':post_id' => $this->request->body['post_id']
                ])->run();
                // update post rating
                $this->model->update([
                    'rating' => $currentRating - $userRating[0]['rating'] + $this->request->body['rating']
                ])->where('id = :id', [
                    ':id' => $this->request->body['post_id']
                ])->run();
            }
        }

        $this->Redirect('/#post-' . $this->request->body['post_id']);
    }

    // TODO: ITS TEST METHOD
    public function remove()
    {
        $this->DELETE();
        $this->requireAuth();
        $id = $this->request->body['id'];
        $this->model->delete()->where('id = :id', [':id' => $id])->run();
        $fileModel = new File();
        $files = $fileModel->select()->where('post_id = :post_id', [
            ':post_id' => $id
        ])->run();
        foreach ($files as $file) {
            FileStorage::delete($file['key'] . DIRECTORY_SEPARATOR . $file['name']);
        }
        $fileModel->delete()->where('post_id = :post_id', [
            ':post_id' => $id
        ])->run();
        $this->Ok();
    }
}
