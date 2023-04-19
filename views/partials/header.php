<?

use core\Auth;
?>
<header class="header-for-nav">
    <p class="logo">My Blog</p>
    <nav class="main-top-nav">
        <a class="chat-link link" href="/">Blog</a>
        <? if (Auth::check() && Auth::get()['id'] == 1) : ?>
            <a class="users-link link" href="/users">Users</a>
        <? endif; ?>
    </nav>
    <nav class="extra-top-nav">
        <? if (Auth::check()) : ?>
            <a class="logout-link link" href="/logout">Log out</a>
        <? else : ?>
            <a class="login-link link" href="/login">Log in</a>
            <a class="reg-link link" href="/registration">Register</a>
        <? endif; ?>
    </nav>
</header>