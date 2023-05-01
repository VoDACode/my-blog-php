<?
use core\Locale;
?>

<div class="background">
        <div class="reg-panel">
            <h1 class="header-create-acc"><?= Locale::get('register-panel.title') ?></h1>
            <form action="/api/auth/regin" method="post">
                <p class="username-header sub-header"><?= Locale::get('register-panel.username') ?></p>
                <input class="username" type="text" name="name">
                <br /><br />
                <p class="email-header sub-header"><?= Locale::get('register-panel.email') ?></p>
                <input class="email" type="email" name="email">
                <br /><br />
                <p class="password-header sub-header"><?= Locale::get('register-panel.password') ?></p>
                <input class="password" type="password" name="password">
                <br /><br />
                <p class="password-header sub-header"><?= Locale::get('register-panel.repeat-password') ?></p>
                <input class="password" type="password" name="repeat_password">
                <input class="apply" type="submit" value="<?= Locale::get('register-panel.register') ?>">
            </form>
        </div>
    </div>