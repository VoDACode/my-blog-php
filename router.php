<?

use core\Router;
use core\View;
use core\Auth;
use core\Locale;
use app\controllers\API\UserController;
use app\controllers\API\AuthController;
use app\controllers\API\FileController;
use app\controllers\API\PhotoGalleryApiController;
use app\controllers\Http\CommentController;
use app\controllers\Http\PhotoGalleryController;
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

Router::get("/photo-gallery", PhotoGalleryController::class);

Router::any("/api/photo-gallery", PhotoGalleryApiController::class);

Router::get("/api/photo-gallery/file", PhotoGalleryApiController::class.'@getFile');
Router::post("/api/photo-gallery/delete", PhotoGalleryApiController::class.'@deleteFile');

Router::any("/api/comment", CommentController::class);

Router::any('/test/post', function ($req) {
    View::render('posts', [
        'styles' => [
            '/css/post.css'
        ],
        'after_load_scripts' => [
            '/js/post.js'
        ],

        'posts' => [
            [
                'id' => 1,
                'title' => 'Title 1',
                'created_at' => '2020-01-01',
                'rating' => 0,
                'images' => [
                    'http://placeimg.com/640/480/any',
                    'http://placeimg.com/640/480',
                    'http://placeimg.com/640/480/random',
                    'http://placeimg.com/640/480/food',
                    'http://placeimg.com/640/480/animals',
                    'http://placeimg.com/640/480/any',
                    'http://placeimg.com/640/480',
                    'http://placeimg.com/640/480/random',
                    'http://placeimg.com/640/480/food',
                    'http://placeimg.com/640/480/animals'
                ],
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl sit amet ultricies lacinia, nisl nisl aliquam libero, eget lacinia nisl nisl eget nisl. Sed euismod, nisl sit amet ultricies lacinia, nisl nisl aliquam libero, eget lacinia nisl nisl eget nisl.',
                'user' => [
                    'id' => 1,
                    'name' => 'User 1'
                ],
                'files' => [
                    [
                        'id' => 1,
                        'name' => 'file1',
                        'size' => 5946,
                    ]
                ],
                'can_have_comments' => true,
                'comments' => [
                    [
                        'id' => 2,
                        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl sit amet ultricies lacinia, nisl nisl aliquam libero, eget lacinia nisl nisl eget nisl. Sed euismod, nisl sit amet ultricies lacinia, nisl nisl aliquam libero, eget lacinia nisl nisl eget nisl.',
                        'date' => '2020-01-01',
                        'rating' => 0,
                        'user' => [
                            'id' => 2,
                            'name' => 'User 2'
                        ],
                        'has_replies' => false,
                    ]
                ]
            ]
        ]
    ]);
});
