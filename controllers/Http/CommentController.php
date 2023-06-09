<?

namespace app\controllers\Http;

use app\providers\UserCommentRating;
use core\BaseController;

class CommentController extends BaseController
{
    private $model;
    public function __construct($request)
    {
        parent::__construct($request);
        $this->model = new \app\providers\Comment();
    }

    public function create()
    {
        $this->POST();
        $this->validate([
            'text' => [
                'required',
                'min:1',
                'max:1000'
            ],
            'post_id' => [
                'required'
            ]
        ]);

        $postModel = new \app\providers\Post();

        if($postModel->select()->where('id = :id', [':id' => $this->request->body['post_id']])->run() === []) {
            $this->Redirect('/');
        }

        $insertModelDate = [
            'text' => $this->request->body['text'],
            'post_id' => $this->request->body['post_id'],
            'user_id' => null
        ];
        if($this->httpUser != false){
            $insertModelDate['user_id'] = $this->httpUser['id'];
        }

        $this->model->insert($insertModelDate)->run();

        $this->Redirect('/#post-' . $this->request->body['post_id']);
    }

    public function rating()
    {
        $this->GET();
        $this->requireAuth();
        if ($this->request->body['rating'] < -1 || $this->request->body['rating'] > 1)
            $this->BadRequest();
        $userCommentRating = new UserCommentRating();
        $userRating = $userCommentRating->select('rating')->where('user_id = :user_id AND comment_id = :comment_id', [
            ':user_id' => $this->httpUser['id'],
            ':comment_id' => $this->request->body['comment_id']
        ])->run();
        $currentRating = $this->model->select('rating')->where('id = :id', [
            ':id' => $this->request->body['comment_id']
        ])->run();

        if ($currentRating == [])
            $this->BadRequest('Comment not found');
        $currentRating = $currentRating[0]['rating'];

        // if user removes his rating
        if ($this->request->body['rating'] == 0) {
            // remove user rating
            $userCommentRating->delete()->where('user_id = :user_id AND comment_id = :comment_id', [
                ':user_id' => $this->httpUser['id'],
                ':comment_id' => $this->request->body['comment_id']
            ])->run();
            // update comment rating
            $this->model->update([
                'rating' => $currentRating - $userRating[0]['rating']
            ])->where('id = :id', [
                ':id' => $this->request->body['comment_id']
            ])->run();
        } else {
            // if user has not rated this comment before
            if ($userRating == []) {
                // insert user rating
                $userCommentRating->insert([
                    'user_id' => $this->httpUser['id'],
                    'comment_id' => $this->request->body['comment_id'],
                    'rating' => $this->request->body['rating']
                ])->run();
                // update comment rating
                $this->model->update([
                    'rating' => $currentRating + $this->request->body['rating']
                ])->where('id = :id', [
                    ':id' => $this->request->body['comment_id']
                ])->run();
            } else if ($this->request->body['rating'] != $userRating[0]['rating']) {
                // update user rating
                $userCommentRating->update([
                    'rating' => $this->request->body['rating']
                ])->where('user_id = :user_id AND comment_id = :comment_id', [
                    ':user_id' => $this->httpUser['id'],
                    ':comment_id' => $this->request->body['comment_id']
                ])->run();
                // update comment rating
                $this->model->update([
                    'rating' => $currentRating - $userRating[0]['rating'] + $this->request->body['rating']
                ])->where('id = :id', [
                    ':id' => $this->request->body['comment_id']
                ])->run();
            }
        }

        $this->Redirect('/#comment-' . $this->request->body['comment_id']);
    }
}