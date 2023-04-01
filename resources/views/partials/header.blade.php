<link rel="stylesheet" href="{{ URL::asset('css/header.css') }}">
<header class="header-for-nav">
    <p class="logo">My Blog</p>
    <nav class="main-top-nav">
        <a class="chat-link link" href="/">Chat</a>
        <a class="users-link link" href="/users">Users</a>
    </nav>
    <nav class="extra-top-nav">
        @guest
            <a class="login-link link" href="/login">Log in</a>
            <a class="reg-link link" href="/register">Register</a>
        @endguest
        @auth
            <a class="logout-link link" href="/logout">Log out</a>
        @endauth
    </nav>
</header>
