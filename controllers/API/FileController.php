<?

namespace app\controllers\API;

use \core\BaseController;
use \app\providers\File;
use \core\FileStorage;

class FileController extends BaseController{

    private $model;

    public function __construct($request){
        parent::__construct($request);
        $this->model = new File();
    }

    public function download(){
        $this->GET();
        if(!$this->request->body['key']){
            $this->NotFound();
        }
        $key = $this->request->body['key'];
        if($file = $this->model->select()->where('key = :key', [
            'key' => $key
        ])->run()[0]){
            $this->model->update([
                'download_count' => $file['download_count'] + 1
            ])->where('id = :id', [
                'id' => $file['id']
            ])->run();
            
            header('Content-Type: '.$file['type']);
            header('Content-Disposition: attachment; filename="'.$file['name'].'"');
            header('Content-Length: '.$file['size']);  
            header("Content-Transfer-Encoding: binary");
            FileStorage::download($file['key'].DIRECTORY_SEPARATOR.$file['name']);
        }else{
            $this->NotFound();
        }
    }

}