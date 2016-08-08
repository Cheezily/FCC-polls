
<?php if(isset($loginError)) { ?>
    <div class="loginGreeting loginStatic">
<?php } elseif ($dashboardLoad == TRUE) { ?>

    <div class="loginGreeting loginGreetingUnload">
<?php } else { ?>
    <div class="loginGreeting">
<?php } ?>
        <div class='formWrapper'>
            <h1>User Login:</h1>
            <form method="post" action="">
                <label for='loginName'>Username
                <?php if(isset($loginError)) {
                    echo "<span class='loginWarning'>Invalid Username or Password</span>";
                } ?>
                </label>
                <br>
                <input type='text' name='username'><br>
                <label for='loginPW'>Password</label><br>
                <input type='password' name='password'><br>
                <input class='loginButtonLoginPage' type='submit' name='checkUsernamePW' value='Login'>
                <input class='cancelButtonLoginPage' type='submit' name='cancel' value='Cancel'>
            </form>
        </div>
    </div>
