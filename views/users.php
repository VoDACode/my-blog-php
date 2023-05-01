<?

use \core\Auth;
use \core\Locale;

Auth::needAdmin();
?>

<h1 class="main-header"><?= Locale::get('users-page.title') ?></h1>
<div class="user-list">
    <div class="user-list-header">
        <div class="user-list-header__name user-list-header-prop"><?= Locale::get('users-page.table.username') ?></div>
        <div class="user-list-header__email user-list-header-prop"><?= Locale::get('users-page.table.email') ?></div>
        <div class="user-list-header__can-publish-posts user-list-header-prop"><?= Locale::get('users-page.table.can-publish-posts') ?></div>
        <div class="user-list-header__created-at user-list-header-prop"><?= Locale::get('users-page.table.created-at') ?></div>
        <div class="user-list-header__actions user-list-header-prop"><?= Locale::get('users-page.table.actions') ?></div>
    </div>
    <? foreach ($users as $user) : ?>
        <div class="user-record">
            <div class="user-record__name user-record-prop">
                <?= $user['name'] ?>
            </div>
            <div class="user-record__email user-record-prop">
                <?= $user['email'] ?>
            </div>
            <div class="user-record__can-publish-posts user-record-prop">
                <?= $user['can_make_post'] ? Locale::get('users-page.table.yes') : Locale::get('users-page.table.no') ?>
            </div>
            <div class="user-record__created-at user-record-prop">
                <?= $user['created_at'] ?>
            </div>
            <div class="user-record__actions user-record-prop">
                <div class="buttons">
                    <div class="user-record-button-cont">
                        <a class="edit-user-link user-record-button" href="user?id=<?= $user['id'] ?>"><?= Locale::get('users-page.table.edit') ?></a>
                    </div>
                    <? if ($user['id'] != 1) : ?>
                        <div class="user-record-button-cont">
                            <a class="delete-user-link user-record-button" href="user?id=<?= $user['id'] ?>&event=delete"><?= Locale::get('users-page.table.delete') ?></a>
                        </div>
                    <? endif; ?>
                </div>
            </div>
            <div></div>
        </div>
    <? endforeach; ?>
</div>
</table>