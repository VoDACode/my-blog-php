<?

use providers\SessionProvider;

if(!isset($_COOKIE['token'])) {
    header('Location: login.php');
    exit;
}else{
    $sessionProvider = new SessionProvider();
    $session = $sessionProvider->getSessionByToken($_COOKIE['token']);
    if($session == null) {
        header('Location: login.php');
        exit;
    }
}