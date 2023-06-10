<?

use core\Router;
use core\View;
use core\Auth;
use core\Locale;
use app\controllers\API\UserController;
use app\controllers\API\AuthController;
use app\controllers\API\FileController;
use app\controllers\Http\CommentController;
use app\controllers\Http\PostController;
use app\providers\User;

View::layout('partials.layout');
View::defaultStyles([
    '/css/app.css',
    '/css/header.css'
]);

Router::get('/lang/:lang', Locale::class . '@Router');

Router::any('/api/users', UserController::class);
Router::any('/api/auth', AuthController::class);

Router::get("/test/lw_1", function ($req) {
    View::render('lw_1', [
        'params' => $req->params
    ]);
});

Router::get("/registration", function ($req) {
    View::render('registration', [
        'styles' => [
            '/css/registration.css'
        ]
    ]);
});

Router::get("/login", function ($req) {
    View::render('login', [
        'styles' => [
            '/css/login.css'
        ]
    ]);
});

Router::get("/users/:id/edit", function ($req) {
    $model = new User();
    $user = $model->select()->where('id = :id',[
        ':id' => $req->params['id']
    ])->run();
    if(empty($user)){
        $req->redirect('/users');
    }
    View::render('edit_user', [
        'styles' => [
            '/css/edit_user.css'
        ],
        'user' => $user[0]
    ]);
});

Router::get("/users/:id/delete", function ($req) {
    $model = new User();
    $user = $model->select()->where('id = :id',[
        ':id' => $req->params['id']
    ])->run();
    if(empty($user)){
        $req->redirect('/users');
    }
    echo 'Delete user: ' . $user[0]['name'];
});

Router::get("/users", function ($req) {
    View::render('users', [
        'styles' => [
            '/css/users.css'
        ],
        'users' => User::all()
    ]);
});

Router::get("/logout", function ($req) {
    Auth::logout();
    $req->redirect('/');
});

Router::get("/", PostController::class . '@index');
Router::any("/posts", PostController::class);

Router::get("/fs", FileController::class);

Router::any("/api/comment", CommentController::class);
