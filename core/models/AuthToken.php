<?

namespace core\models;

use core\DB;

class AuthToken extends DB
{
    public static function getToken(){
        return $_COOKIE['token'] ?? null;
    }
    
    public static function setToken(string $token){
        setcookie('token', $token, time() + $_ENV['AUTH_TOKEN_LIFETIME'], '/');
    }

    public $table = 'auth_tokens';

    public $fields = [
        'token' => [
            'type' => 'string',
            'primary' => true,
            'required' => true,
            'min' => 3,
            'max' => 255
        ],
        'user_id' => [
            'type' => 'integer',
            'required' => true,
            'min' => 3,
            'max' => 255
        ],
        'created_at' => [
            'type' => 'string',
            'default' => 'CURRENT_TIMESTAMP',
            'min' => 3,
            'max' => 255
        ],
        'updated_at' => [
            'type' => 'string',
            'default' => 'CURRENT_TIMESTAMP',
            'min' => 3,
            'max' => 255
        ]
    ];

    public static function generateToken(string $user_id)
    {
        $provider = new AuthToken();
        $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $token = '';
        for($i = 0; $i < $_ENV['AUTH_TOKEN_SIZE']; $i++)
            $token .= $str[rand(0, strlen($str) - 1)];
        $token .= '_'.md5(uniqid(rand() + time() + $user_id, true));
        $provider->insert([
            'token' => $token,
            'user_id' => $user_id
        ])->run();
        return $token;
    }

    public static function checkToken($token)
    {
        $provider = new AuthToken();
        $result = $provider->select('user_id')->where('token = '.$token)->run();
        if(count($result) > 0)
            return $result[0]['user_id'];
        else
            return false;
    }

    public static function deleteToken($token)
    {
        (new AuthToken())->delete()->where('token = \''.$token.'\'')->run();
        setcookie('token', '', time() - 3600, '/');
        session_destroy();
    }

    public static function deleteAllTokens($user_id)
    {
        (new AuthToken())->delete()->where('user_id = '.$user_id)->run();
        setcookie('token', '', time() - 3600, '/');
        session_destroy();
    }

    public static function updateToken($token)
    {
        (new AuthToken())->update(['updated_at' => 'CURRENT_TIMESTAMP'])->where('token = '.$token)->run();
        self::setToken($token);
    }
}
