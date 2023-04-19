<div class="background">
        <div class="reg-panel">
            <h1 class="header-create-acc">Create new account</h1>
            <form action="/api/auth/regin" method="post">
                <p class="username-header sub-header">Username</p>
                <input class="username" type="text" name="name">
                <br /><br />
                <p class="email-header sub-header">Email</p>
                <input class="email" type="email" name="email">
                <br /><br />
                <p class="password-header sub-header">Password</p>
                <input class="password" type="password" name="password">
                <br /><br />
                <p class="password-header sub-header">Confirm Password</p>
                <input class="password" type="password" name="password_confirmation">
                <input class="apply" type="submit" value="Register">
            </form>
        </div>
    </div>