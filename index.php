<?php
include "model/database.php";
    
if (isset($_GET['login'])) {
    $login = TRUE;
}   
?>

<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='css/main.css' />
<title>
    Polls!
</title>
</head>
<body>
    <?php if(isset($login)) { ?>
        <div class="container hideContainer">
    <?php } else { ?>
        <div class="container">
    <?php } ?>
            
        <div class='greeting'>
          <div class='leftSideStuff'>
            <h2>Already a registered user?</h2>
            <form method="get" action="">
                <input type="submit" value="Login" name="login">
            </form>
            <form method="get" action="">
                <input type="submit" value="New User" name="newUser">
            </form>
          </div>

          <div class="itemsLabel">Recent Polls -- Click to Participate</div>
          <div class='items'>

            <div class='item'>
              <h1>Box #12</h1>
            </div>
            <div class='item'>
              <h1>Box #11</h1>
            </div>
            <div class='item'>
              <h1>Box #10</h1>
            </div>
            <div class='item'>
              <h1>Box #9</h1>
            </div>
            <div class='item'>
              <h1>Box #8</h1>
            </div>
            <div class='item'>
              <h1>Box #7</h1>
            </div>
            <div class='item'>
              <h1>Box #6</h1>
            </div>
            <div class='item'>
              <h1>Box #5</h1>
            </div>
            <div class='item'>
              <h1>Box #4</h1>
            </div>
            <div class='item'>
              <h1>Box #3</h1>
            </div>
            <div class='item'>
              <h1>Box #2</h1>
            </div>
            <div class='item'>
              <h1>Box #1</h1>
            </div>
            <!--repeat box 1 through 6-->
            <div class='item'>
              <h1>Box #12</h1>
            </div>
            <div class='item'>
              <h1>Box #11</h1>
            </div>
            <div class='item'>
              <h1>Box #10</h1>
            </div>
            <div class='item'>
              <h1>Box #9</h1>
            </div>
            <div class='item'>
              <h1>Box #8</h1>
            </div>
            <div class='item'>
              <h1>Box #7</h1>
            </div>
            <div class='item'>
              <h1>Box #6</h1>
            </div>
            <div class='item'>
              <h1>Box #5</h1>
            </div>
            <div class='item'>
              <h1>Box #4</h1>
            </div>
            <div class='item'>
              <h1>Box #3</h1>
            </div>
            <div class='item'>
              <h1>Box #2</h1>
            </div>
            <div class='item'>
              <h1>Box #1</h1>
            </div>
          </div>
            <div class="shadowLayer">

            </div>
        </div>
    </div>
            
    <?php if(isset($login)) { ?>
        <div class="loginGreeting">
            <form method="post" action="">
                <label for='loginName'>Username</label>
                <input type='text' name='username'>
                <label for='loginPW'>Password</label>
                <input type='password' name='password'>
                <input type='submit' value='Login'>
            </form>
        </div>
    <?php } ?>
</body>
</html>
