<?
include 'models'.DIRECTORY_SEPARATOR.'include.php';
include 'providers'.DIRECTORY_SEPARATOR.'include.php';
include 'OnlyAnonymous.php';

use providers\UserProvider;

$error = false;
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $provider = new UserProvider();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = $provider->addUser($name, $email, $password);
    if($user != null) {
        header('Location: login.php');
    } else {
        $error = true;
    }
}
?>

<form action="registration.php" method="post">
    <input type="text" name="name" placeholder="Username">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Register">
</form>

<? if($error) { ?>
    <p>Registration failed</p>
<? } ?>