<?

namespace app\controllers\API;

use \core\BaseController;
use core\FileStorage;

class PhotoGalleryApiController extends BaseController
{
    private $model;
    public function __construct($request)
    {
        parent::__construct($request);
        $this->model = new \app\providers\Image();
    }

    public function add()
    {
        $this->POST();

        $fileCount = count($_FILES['file']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $file = [
                'name' => $_FILES['file']['name'][$i],
                'type' => $_FILES['file']['type'][$i],
                'tmp_name' => $_FILES['file']['tmp_name'][$i],
                'error' => $_FILES['file']['error'][$i],
                'size' => $_FILES['file']['size'][$i]
            ];
            $fileExt = explode('.', $file['name']);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = ['jpg', 'jpeg', 'png'];

            if (in_array($fileActualExt, $allowed)) {
                if ($file['error'] === 0) {
                    // 100 MB
                    if ($file['size'] < 107374182400) {
                        $id = $this->model->insert([
                            'name' => $file['name'],
                            'size' => $file['size']
                        ])->run();

                        FileStorage::upload($file, $id);
                    } else {
                        $this->BadRequest("Your file is too big!");
                    }
                } else {
                    $this->BadRequest("There was an error uploading your file!");
                }
            } else {
                $this->BadRequest("You cannot upload files of this type!");
            }
        }
        $this->Redirect('/photo-gallery');
    }

    public function getFile()
    {
        $this->GET();

        if (!isset($this->request->body['id'])) {
            $this->NotFound();
        }

        $id = $this->request->body['id'];

        $image = $this->model->select()->where('id = :id', [
            ':id' => $id
        ])->run()[0];

        header('Content-Type: image/jpeg');
        header('Content-Length: ' . $image['size']);

        FileStorage::show($image['id'] . DIRECTORY_SEPARATOR . $image['name']);
    }

    public function deleteFile()
    {
        $this->POST();

        if (!isset($this->request->body['id'])) {
            $this->NotFound();
        }

        $id = $this->request->body['id'];

        $image = $this->model->select()->where('id = :id', [
            ':id' => $id
        ])->run()[0];

        $this->model->delete()->where('id = :id', [
            ':id' => $id
        ])->run();

        FileStorage::delete($image['id'] . DIRECTORY_SEPARATOR . $image['name']);

        $this->Redirect('/photo-gallery');
    }
}
