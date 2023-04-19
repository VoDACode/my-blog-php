<?

namespace core;

use core\Request;
/*
    /some/url/:param1/:param2
    /some/url/* - any sub url
    /some/url/ - exact url
    /some/url - exact url
*/

class Router
{
    private static $routes = [];
    static function add($regexp, $route)
    {
        self::$routes[$regexp] = $route;
    }

    static function get($url, $callback)
    {
        self::add($url, new RouteRecord('GET', $url, $callback));
    }
    static function post($url, $callback)
    {
        self::add($url, new RouteRecord('POST', $url, $callback));
    }
    static function put($url, $callback)
    {
        self::add($url, new RouteRecord('PUT', $url, $callback));
    }
    static function delete($url, $callback)
    {
        self::add($url, new RouteRecord('DELETE', $url, $callback));
    }
    static function patch($url, $callback)
    {
        self::add($url, new RouteRecord('PATCH', $url, $callback));
    }
    static function options($url, $callback)
    {
        self::add($url, new RouteRecord('OPTIONS', $url, $callback));
    }
    static function head($url, $callback)
    {
        self::add($url, new RouteRecord('HEAD', $url, $callback));
    }
    static function any($url, $callback)
    {
        self::add($url, new RouteRecord('*', $url, $callback));
    }
    static function run()
    {
        foreach (self::$routes as $route) {
            if ($route->run()) {
                return true;
            }
        }
        return false;
    }
}

class RouteRecord
{
    public $callback;
    public $pattern;
    public $method;
    public function __construct($method, $pattern, $callback)
    {
        $this->method = $method;
        $this->pattern = $pattern;
        if (is_string($callback)) {
            $path = explode('@', $callback);
            if (count($path) == 1) {
                $this->callback = $path[0];
            } else {
                $this->callback = [new $path[0], $path[1]];
            }
        } else if (is_callable($callback))
            $this->callback = $callback;
        else
            throw new \Exception('Invalid callback');
    }

    public function run()
    {
        $request_url = $_SERVER['REQUEST_URI'];
        $request_method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == $request_method || $this->method == '*') {
            $params = $this->parseUrl($request_url);
            if ($params === false) {
                return false;
            }
            $request = new Request($request_url, $request_method, $params, getallheaders());
            if (is_callable($this->callback) || is_array($this->callback)) {
                call_user_func($this->callback, $request);
            } else if (is_string($this->callback)) {
                $controller = new $this->callback($request);
                $action = str_replace($this->pattern, '', $request_url);
                $funcNameAndParams = explode('/', $action);
                {
                    $tmp = [];
                    foreach ($funcNameAndParams as $key => $value) {
                        if ($value != '' && $value != ' ') {
                            $tmp[] = $value;
                        }
                    }
                    $funcNameAndParams = $tmp;
                }
                if(count($funcNameAndParams) == 0){
                    $action = $funcNameAndParams;
                }else{
                    $action = $funcNameAndParams[0];
                }
                $methods = get_class_methods($controller);
                if (in_array($action, $methods) == false) {
                    if(in_array('index', $methods) == false)
                        return false;
                    $action = 'index';
                }else{
                    $funcRef = new \ReflectionMethod($this->callback, $action);
                    $funcParams = $funcRef->getParameters();
                    if(count($funcNameAndParams) - 1 != count($funcParams)){
                        return false;
                    }
                    $params = [];
                    foreach ($funcParams as $key => $value) {
                        if(is_numeric($funcNameAndParams[$key+1]) && $value->getType() == 'int'){
                            $params[] = (int)$funcNameAndParams[$key+1];
                        }elseif(is_numeric($funcNameAndParams[$key+1]) && $value->getType() == 'float'){
                            $params[] = (float)$funcNameAndParams[$key+1];
                        }elseif(is_numeric($funcNameAndParams[$key+1]) && $value->getType() == 'double'){
                            $params[] = (double)$funcNameAndParams[$key+1];
                        }elseif(is_string($funcNameAndParams[$key+1]) && $value->getType() == 'string'){
                            $params[] = $funcNameAndParams[$key+1];
                        }elseif(is_bool($funcNameAndParams[$key+1]) && $value->getType() == 'bool'){
                            $params[] = (bool)$funcNameAndParams[$key+1];
                        }elseif(is_bool($funcNameAndParams[$key+1]) && $value->getType() == 'boolean'){
                            $params[] = (boolean)$funcNameAndParams[$key+1];
                        }else{
                            return false;
                        }
                    }
                }
                $controller->{$action}(...$params);
            }
            return true;
        }
        return false;
    }

    private function parseUrl($requestUrl)
    {
        $patternParts = explode('/', $this->pattern);
        $requestUrlParts = explode('/', $requestUrl);

        $params = [];
        for ($i = 0; $i < count($patternParts); $i++) {
            $patternPart = $patternParts[$i];
            $requestPart = isset($requestUrlParts[$i]) ? $requestUrlParts[$i] : null;

            if ($patternPart === '*') {
                break;
            } else if (substr($patternPart, 0, 1) === ':') {
                $key = substr($patternPart, 1);
                $params[$key] = $requestPart;
            } else if ($patternPart !== $requestPart) {
                return false;
            }
        }

        foreach ($params as $key => $value) {
            if (isset($value) == false || $value === "") {
                return false;
            }
        }

        return $params;
    }
}
