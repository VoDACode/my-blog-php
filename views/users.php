<?
use \core\Auth;

Auth::needAdmin();
?>

<br /><br /><br /><br />
<h1 class="main-header">User list</h1>
<div class="user-list">
    <div class="user-list-header">
        <div class="user-list-header__name user-list-header-prop">Name</div>
        <div class="user-list-header__email user-list-header-prop">Email</div>
        <div class="user-list-header__can-publish-posts user-list-header-prop">Can publish posts</div>
        <div class="user-list-header__created-at user-list-header-prop">Created at</div>
        <div class="user-list-header__actions user-list-header-prop">Actions</div>
    </div>
    <? foreach ($users as $user): ?>
        <div class="user-record">
            <div class="user-record__name user-record-prop">
                <?= $user['name'] ?>
            </div>
            <div class="user-record__email user-record-prop">
                <?= $user['email'] ?>
            </div>
            <div class="user-record__can-publish-posts user-record-prop">
                <?= $user['can_make_post'] ? 'Yes' : 'No' ?>
            </div>
            <div class="user-record__created-at user-record-prop">
                <?= $user['created_at'] ?>
            </div>
            <div class="user-record__actions user-record-prop">
                <div class="buttons">
                    <div class="user-record-button-cont">
                        <a class="edit-user-link user-record-button" href="user?id=<?= $user['id'] ?>">Edit</a>
                    </div>
                    <? if ($user['id'] != 1): ?>
                        <div class="user-record-button-cont">
                            <a class="delete-user-link user-record-button"
                                href="user?id=<?= $user['id'] ?>&event=delete">Delete</a>
                        </div>
                    <? endif; ?>
                </div>
            </div>
            <div></div>
        </div>
    <? endforeach; ?>
</div>
</table>