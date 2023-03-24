<?
$error = false;
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'providers'.DIRECTORY_SEPARATOR.'UserProvider.php';
    $provider = new UserProvider();
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $provider->addUser($name, $email, $password);
    if($result == true) {
        header('Location: index.php');
    } else {
        $error = true;
    }
}
?>

<form action="registration.php" method="post">
    <input type="text" name="name" placeholder="Login">
    <input type="email" name="email">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Register">
</form>

<? if($error) { ?>
    <p>Registration failed</p>
<? } ?>