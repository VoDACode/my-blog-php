<?

namespace core;

abstract class BaseController
{
    protected $request;
    protected $httpUser;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function requireAuth()
    {
        $token = $_ENV['AUTH_TOKEN_MODEL']::getToken();
        if (!isset($token)) {
            $this->Unauthorized();
        }
        $user = $_ENV['AUTH_TOKEN_MODEL']::checkToken($token);
        $this->httpUser = Auth::get();
        if ($user === false) {
            $this->Unauthorized();
        }
    }

    protected function validate($rules)
    {
        $validator = new Validator($rules);
        $validator->validate($this->request->body);
        if ($validator->hasErrors()) {
            $this->BadRequest($validator->getErrors());
        }
    }

    protected function POST()
    {
        if ($this->request->method != 'POST') {
            $this->MethodNotAllowed();
        }
    }

    protected function GET()
    {
        if ($this->request->method != 'GET') {
            $this->MethodNotAllowed();
        }
    }

    protected function PUT()
    {
        if ($this->request->method != 'PUT') {
            $this->MethodNotAllowed();
        }
    }

    protected function DELETE()
    {
        if ($this->request->method != 'DELETE') {
            $this->MethodNotAllowed();
        }
    }

    protected function PATCH()
    {
        if ($this->request->method != 'PATCH') {
            $this->MethodNotAllowed();
        }
    }

    protected function OPTIONS()
    {
        if ($this->request->method != 'OPTIONS') {
            $this->MethodNotAllowed();
        }
    }

    protected function HEAD()
    {
        if ($this->request->method != 'HEAD') {
            $this->MethodNotAllowed();
        }
    }

    protected function Unauthorized($content = 'Unauthorized')
    {
        $this->sendResponse($content, 401);
        die();
    }

    protected function NotFound($content = 'Not found')
    {
        $this->sendResponse($content, 404);
        die();
    }

    protected function BadRequest($content = 'Bad request')
    {
        $this->sendResponse($content, 400);
        die();
    }

    protected function Ok($content = 'Ok')
    {
        $this->sendResponse($content, 200);
        die();
    }

    protected function Created($content = 'Created')
    {
        $this->sendResponse($content, 201);
        die();
    }

    protected function File($path)
    {
        $file = file_get_contents($path);
        header('Content-Type: ' . mime_content_type($path));
        header('Content-Length: ' . filesize($path));
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
        file_put_contents('php://output', $file);
        die();
    }

    protected function SendJson($content, $code = 200)
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($content);
        die();
    }

    protected function MethodNotAllowed()
    {
        $this->sendResponse('Method not allowed', 405);
        die();
    }

    protected function Redirect($url)
    {
        header('Location: ' . $url);
        die();
    }

    private function sendResponse($content, $code = 200)
    {
        http_response_code($code);
        if (is_array($content) || is_object($content)) {
            header('Content-Type: application/json');
            $content = json_encode($content);
        }
        echo $content;
        die();
    }

    protected function getRandomString(int $len)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $str;
    }
}
