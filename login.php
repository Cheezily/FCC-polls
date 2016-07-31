
<?php session_start();
if(isset($loginError)) { ?>
    <div class="loginGreeting loginStatic">
<?php } else { ?>
    <div class="loginGreeting loginGreetingLoad">
<?php } ?>
        <form method="post" action="">
            <label for='loginName'>Username</label>
            <?php if(isset($loginError)) {
                echo "<span class='loginWarning'>Invalid Username or Password</span>";
            } ?>
            <br>
            <input type='text' name='username'><br>
            <label for='loginPW'>Password</label><br>
            <input type='password' name='password'><br>
            <input type='submit' name='checkUsernamePW' value='Login'>
        </form>
    </div>
