<div class="background">
    <div class="login-panel">
        <h1 class="header-sign-in">Log in as a user</h1>
        <form action="/api/auth/login" method="post">
            <p class="username-header sub-header">Username</p>
            <input class="username" type="text" name="login" />
            <br /><br />
            <p class="password-header sub-header">Password</p>
            <input class="password" type="password" name="password" />
            <input class="apply" type="submit" value="Login" />
        </form>
        <div class="reg-offer">
            <p class="reg-offer-header">Don't have an account?</p>
            <a class="reg-a" href="/registration">Register</a>
        </div>
    </div>
</div>