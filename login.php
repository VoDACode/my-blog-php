<?
include 'providers' . DIRECTORY_SEPARATOR . 'include.php';
include 'OnlyAnonymous.php';

use providers\SessionProvider;

$error = '';
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sessionProvider = new SessionProvider();
    $user = $sessionProvider->authUser($username, $password);
    if ($user != null) {
        setcookie('token', $sessionProvider->addSession($user->id), time() + 604800, '/');
        header('Location: index.php');
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<form action="login.php" method="post">
    <input type="text" name="username" />
    <input type="password" name="password" />
    <input type="submit" value="Login" />
</form>
<?php echo $error; ?>