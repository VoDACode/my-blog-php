<?
namespace app\config;

$_ENV['ENABLE_AUTH'] = true;

$_ENV['AUTH_TOKEN_MODEL'] = 'core\models\AuthToken';
$_ENV['USER_MODEL'] = 'app\providers\User';
$_ENV['AUTH_TOKEN_SIZE'] = 256;
$_ENV['AUTH_TOKEN_LIFETIME'] = 3600 * 24 * 30; // 30 days