
<?php if(isset($newUserError)) { ?>
    <div class="loginGreeting loginStatic">
<?php } elseif ($dashboardLoad == TRUE) { ?>
    <div class="loginGreeting loginGreetingUnload">
<?php } else { ?>
    <div class="loginGreeting">
<?php } ?>
        <h1>New user registration:</h1>
        <form method="post" action="">
            <label for='loginName'>Username</label>
            <?php if(isset($newUserTaken)) {
                echo "<span class='loginWarning'>Username already taken!</span>";
            } ?>
            <br>
            <input type='text' name='username'><br>
            <label for='newUserPW'>Password</label>
            <?php if(isset($newUserPWmatch)) {
                echo "<span class='loginWarning'>Passwords don't match!</span>";
            } ?>
            <?php if(isset($newUserPWshort)) {
                echo "<span class='loginWarning'>Password too short!</span>";
            } ?>
            <br>
            <input id='newUserPW' type='password' name='password'><br>
            <label for='newUserPWconfirm'>Password</label><br>
            <input id='newUserPWconfirm' type='password' name='password'><br>
            <input type='submit' name='newUserSubmit' value='Create User'><br>
            <input type='submit' name='cancel' value='Cancel'>
        </form>
    </div>