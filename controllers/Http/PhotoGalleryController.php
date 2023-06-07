<?

namespace app\controllers\Http;

use core\BaseController;
use core\View;

class PhotoGalleryController extends BaseController
{
    private $model;
    public function __construct($request)
    {
        parent::__construct($request);
        $this->model = new \app\providers\Image();
    }

    public function index()
    {
        View::renderPartial('photo-gallery.index', [
            'images' => $this->model->select()->run(),
            'styles' => [
                '/css/gallery.css'
            ]
        ]);
    }
}
