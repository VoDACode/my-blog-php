<?

use \core\Locale;

?>

<div class="background">
    <div class="login-panel">
        <h1 class="header-sign-in"><?= Locale::get('login-panel.title') ?></h1>
        <form action="/api/auth/login" method="post">
            <p class="username-header sub-header"><?= Locale::get('login-panel.username') ?></p>
            <input class="username" type="text" name="login" />
            <br /><br />
            <p class="password-header sub-header"><?= Locale::get('login-panel.password') ?></p>
            <input class="password" type="password" name="password" />
            <input class="apply" type="submit" value="<?= Locale::get('login-panel.login') ?>" />
        </form>
        <div class="reg-offer">
            <p class="reg-offer-header"><?= Locale::get('login-panel.do-not-have-account') ?></p>
            <a class="reg-a" href="/registration"><?= Locale::get('login-panel.register') ?></a>
        </div>
    </div>
</div>