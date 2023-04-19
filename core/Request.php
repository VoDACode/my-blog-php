<?
namespace core;

class Request{
    public $url;
    public $method;
    public $params;
    public $headers;
    public $body;
    public function __construct($url, $method, $params, $headers){
        $this->url = $url;
        $this->method = $method;
        $this->params = $params;
        $this->headers = $headers;
        if($method == 'POST' || $method == 'PUT' || $method == 'PATCH'){
            $this->body = $_POST;
        }else{
            $this->body = $_GET;
        }      
    }

    public function redirect($url){
        header('Location: ' . $url);
        exit;
    }
}