<?
include 'providers'.DIRECTORY_SEPARATOR.'include.php';
include 'Authorized.php';

use providers\SessionProvider;

if(isset($_COOKIE['token'])) {
    $sessionProvider = new SessionProvider();
    $session = $sessionProvider->getSessionByToken($_COOKIE['token']);
    if($session != null) {
        $sessionProvider->deleteSession($session->id);
    }
    setcookie('token', '', time() - 3600, '/');
}
header('Location: index.php');