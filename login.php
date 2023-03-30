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

<!DOCTYPE html>
<html>

<head>
    <title>Sign in</title>
    <link rel="stylesheet" href="assets/css/general.css" />
    <link rel="stylesheet" href="assets/css/login.css" />
</head>

<body>
    <? include "objects/header.php"; ?>
    <div class="background">
        <div class="login-panel">
            <h1 class="header-sign-in">Log in as a user</h1>
            <form action="login.php" method="post">
                <p class="username-header sub-header">Username</p>
                <input class="username" type="text" name="username" />
                <br /><br />
                <p class="password-header sub-header">Password</p>
                <input class="password" type="password" name="password" />
                <input class="apply" type="submit" value="Login" />
            </form>
            <div class="reg-offer">
                <p class="reg-offer-header">Don't have an account?</p>
                <a class="reg-a" href="http://blog.local/registration.php">Register</a>
            </div>
        </div>
    </div>
</body>

</html>

<?php echo $error; ?>