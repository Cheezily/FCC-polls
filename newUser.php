
<?php if(isset($newUserError)) { ?>
    <div class="loginGreeting loginStatic">
<?php } elseif ($dashboardLoad == TRUE) { ?>
    <div class="loginGreeting loginGreetingUnload">
<?php } else { ?>
    <div class="loginGreeting">
<?php } ?>
        <div class='formWrapper'>
            <h1>New user registration:</h1>
            <form method="post" action="">
                <label for='loginName'>Username
                <?php if($newUserTaken) {
                    echo " <span class='loginWarning'>Username already taken</span>";
                } elseif ($newUserMissing) {
                    echo " <span class='loginWarning'>Username required</span>";
                } ?>
                </label>
                <br>
                <input type='text' name='username' 
                <?php if(!$newUserTaken) {
                    echo "value='".$usernameCheck."' ";
                } ?>       
                ><br>
                <label for='newUserPW'>Password (Min 8 characters)
                <?php if($newUserPWmatch) {
                    echo "<span class='loginWarning'>Passwords don't match</span>";
                } ?>
                <?php if($newUserPWshort) {
                    echo "<span class='loginWarning'>Password too short</span>";
                } ?>
                <?php if($newUserPWmissing) {
                    echo "<span class='loginWarning'>Password required</span>";
                } ?>
                </label>
                <br>
                <input id='newUserPW' type='password' name='password'><br>
                <label for='newUserPWconfirm'>Confirm Password</label><br>
                <input id='newUserPWconfirm' type='password' name='passwordConfirm'><br>
                <input class='cancelButtonLoginPage' type='submit' name='cancel' value='Cancel'>
                <input class='loginButtonLoginPage' type='submit' name='newUserSubmit' value='Create User'>
            </form>
        </div>
    </div>