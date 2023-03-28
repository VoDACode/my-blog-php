<?
use providers\SessionProvider;
if(isset($_COOKIE['token'])) {
    $sessionProvider = new SessionProvider();
    $session = $sessionProvider->getSessionByToken($_COOKIE['token']);
    if($session != null) {
        header('Location: index.php');
        exit;
    }
}