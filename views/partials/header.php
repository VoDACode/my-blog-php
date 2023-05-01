<?

use core\Auth;
use core\Locale;

?>
<header class="header-for-nav">
    <p class="logo">My Blog</p>
    <nav class="main-top-nav">
        <a class="chat-link link" href="/">Blog</a>
        <? if (Auth::check() && Auth::get()['id'] == 1): ?>
            <a class="users-link link" href="/users">Users</a>
        <? endif; ?>
    </nav>
    <nav class="extra-top-nav">
        <div class="lang">
            <img class="lang-menu" />
            <div class="drop-content">
                <p class="lang-var">English</p>
                <p class="lang-var">Русский</p>
                <p class="lang-var">Українська</p>
            </div>
        </div>
        <? if (Auth::check()): ?>
            <a class="logout-link link" href="/logout">Log out</a>
        <? else: ?>
            <a class="login-link link" href="/login">Log in</a>
            <a class="reg-link link" href="/registration">Register</a>
        <? endif; ?>
    </nav>
</header>