<style>
    .header-for-nav {
        position: relative;
        display: flex;
        background-color: #333;
        position: fixed;
        display: block;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
    }

    .logo {
        position: absolute;
        cursor: default;
        top: 50%;
        left: 10px;
        transform: translateY(-55%);
        color: #f2f2f2;
        font-size: 30px;
        font-weight: 700;
    }

    .main-top-nav {
        overflow: hidden;
        margin-left: 170px;
    }

    .extra-top-nav {
        position: absolute;
        top: 0;
        right: 0;
    }

    .link {
        user-select: none;
        float: left;
        color: #f2f2f2;
        text-align: center;
        padding-block: 24px;
        padding-inline: 16px;
        text-decoration: none;
        font-size: 18px;
    }



    .link:hover {
        background-color: #ddd;
        color: black;
    }

    .link.active {
        background-color: #0465aa;
        color: white;
    }
</style>
<header class="header-for-nav">
    <p class="logo">My Blog</p>
    <nav class="main-top-nav">
        <a class="chat-link link" href="/">Chat</a>
        <a class="users-link link" href="/users.php">Users</a>
    </nav>
    <nav class="extra-top-nav">
        <?php if ($_COOKIE['token'] == null): ?>
            <a class="login-link link" href="/login.php">Log in</a>
            <a class="reg-link link" href="/registration.php">Register</a>
        <?php else: ?>
            <a class="logout-link link" href="/logout.php">Log out</a>
        <?php endif; ?>
    </nav>
</header>