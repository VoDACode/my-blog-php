<?

use core\Auth;
use core\Locale;

?>
<header class="header-for-nav">
    <p class="logo">My Blog</p>
    <nav class="main-top-nav">
        <a class="chat-link link" href="/">Blog</a>
        <? if (Auth::check() && Auth::get()['id'] == 1) : ?>
            <a class="users-link link" href="/users"><?= Locale::get('header.users') ?></a>
        <? endif; ?>
    </nav>
    <nav class="extra-top-nav">
        <div class="lang">
            <img class="lang-menu" />
            <div class="drop-content">
                <p class="lang-var">
                    <a href="/lang/en">English</a>
                </p>
                <p class="lang-var">
                    <a href="/lang/ua">Українська</a>
                </p>
                <p class="lang-var">
                    <a href="/lang/ru">Русский</a>
                </p>
            </div>
        </div>
        <? if (Auth::check()) : ?>
            <a class="logout-link link" href="/logout"><?= Locale::get('header.logout') ?></a>
        <? else : ?>
            <a class="login-link link" href="/login"><?= Locale::get('header.login') ?></a>
            <a class="reg-link link" href="/registration"><?= Locale::get('header.register') ?></a>
        <? endif; ?>
    </nav>
</header>