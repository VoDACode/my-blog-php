<?

use \core\Locale;
use \core\Auth;

Auth::needAdmin();

?>

<h1 class="page-header">Edit "<?= $user['name'] ?>"</h1>
<form class="user-info" method="post" action="/api/users/update">
    <input type="hidden" name="id" value="<?= $user['id'] ?>" />
    <div class="user-info-input">
        <div class="titles">
            <div><span class="name-input-title input-title">Name:</span></div>
            <div><span class="email-input-title input-title">Email:</span></div>
        </div>
        <div class="inputs">
            <div><input class="name-input-info input-info" type="text" name="name" value="<?= $user['name'] ?>" /></div>
            <div><input class="email-input-info input-info" type="email" name="email" value="<?= $user['email'] ?>" /></div>
        </div>
    </div>
    <div class="publish-input-cont checkbox-input-cont">
        <span class="publish-input-title input-title">Can publish posts:</span>
        <input class="publish-input" type="checkbox" name="can_make_post" <? if ($user['can_make_post'] == 1) : ?> checked <? endif; ?> />
    </div>
    <div class="confirm-panel">
        <a href="/users"><button class="canceling" type="button">Cancel</button></a>
        <button class="saving" type="submit">Save</button>
    </div>
</form>