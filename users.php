<?
include 'providers' . DIRECTORY_SEPARATOR . 'include.php';
include 'Authorized.php';
use providers\UserProvider;

$result = new ArrayObject();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $provider = new UserProvider();
    if (isset($_GET['event']) && $_GET['event'] == 'delete') {
        $id = $_GET['id'];
        if ($id == 1) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            return;
        }
        $provider->delete($id);
        header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
        $result = $provider->getAllUsers();
    }
    $result = $provider->getAllUsers();
} else {
    header('Location: index.php');
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
    <br /><br /><br /><br /><br />
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Can Publish Posts</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($result as $user): ?>
            <tr>
                <td>
                    <?php echo $user->id; ?>
                </td>
                <td>
                    <?php echo $user->name; ?>
                </td>
                <td>
                    <?php echo $user->email; ?>
                </td>
                <td>
                    <?php echo $user->canPublishPosts ? 'Yes' : 'No'; ?>
                </td>
                <td>
                    <?php echo $user->createdAt; ?>
                </td>
                <td>
                    <a href="user.php?id=<?php echo $user->id; ?>" class="btn btn-primary">Edit</a>
                    <? if ($user->id != 1): ?>
                        <a href="users.php?id=<?php echo $user->id; ?>&event=delete" class="btn btn-danger">Delete</a>
                    <? endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>