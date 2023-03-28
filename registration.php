<?
include 'models' . DIRECTORY_SEPARATOR . 'include.php';
include 'providers' . DIRECTORY_SEPARATOR . 'include.php';
include 'OnlyAnonymous.php';

use providers\UserProvider;

$error = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $provider = new UserProvider();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = $provider->addUser($name, $email, $password);
    if ($user != null) {
        header('Location: login.php');
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign in</title>
    <link rel="stylesheet" href="assets/css/general.css" />
    <link rel="stylesheet" href="assets/css/registration.css" />
</head>

<body>
    <div class="background">
        <div class="reg-panel">
            <h1 class="header-create-acc">Create new account</h1>
            <form action="registration.php" method="post">
                <p class="username-header sub-header">Username</p>
                <input class="username" type="text" name="name">
                <br /><br />
                <p class="email-header sub-header">Email</p>
                <input class="email" type="email" name="email">
                <br /><br />
                <p class="password-header sub-header">Password</p>
                <input class="password" type="password" name="password">
                <input class="apply" type="submit" value="Register">
            </form>
        </div>
    </div>
</body>

<? if ($error) { ?>
    <p>Registration failed</p>
<? } ?>