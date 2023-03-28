<?
include 'Authorized.php';

$result = new ArrayObject();
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include 'providers' . DIRECTORY_SEPARATOR . 'UserProvider.php';
    $provider = new UserProvider();
    if (isset($_GET['event']) && $_GET['event'] == 'delete') {
        $id = $_GET['id'];
        if($id == 1) {
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


<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Can Publish Posts</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($result as $user) : ?>
        <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo $user->name; ?></td>
            <td><?php echo $user->email; ?></td>
            <td><?php echo $user->canPublishPosts ? 'Yes' : 'No'; ?></td>
            <td><?php echo $user->createdAt; ?></td>
            <td>
                <a href="user.php?id=<?php echo $user->id; ?>" class="btn btn-primary">Edit</a>
                <? if ($user->id != 1) : ?>
                    <a href="users.php?id=<?php echo $user->id; ?>&event=delete" class="btn btn-danger">Delete</a>
                <? endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>