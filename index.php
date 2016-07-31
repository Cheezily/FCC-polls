<?php
error_reporting(E_ALL &  ~E_NOTICE);
session_start();

include "model/database.php";

//handle if the user clicked the login button
if (isset($_POST['login'])) {
    $login = TRUE;
}

//handle if the user clicks a logout button or cancels login
if (isset($_POST['logout']) || isset($_POST['cancel'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
    die();
}

if (isset($_GET['newUser'])) {
    require_once "model/pollsDB.php";
    var_dump(getPollsForUser("1"));
}

//handles username and password being passed from the login page
if (isset($_POST['checkUsernamePW'])) {
    $username = filter_input(INPUT_POST, "username");
    $password = filter_input(INPUT_POST, "password");
    
    require_once "model/loginDB.php";
    $loginResult = checkUsernamePW($username, $password);
    
    if (!empty($loginResult)) {
        var_dump($loginResult);
        $_SESSION['userID'] = $loginResult['userId'];
        $_SESSION['username'] = $loginResult['username'];
        $_SESSION['loadingDashboard'] = TRUE;
    } else {
        $loginError = TRUE;
    }
    
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
    
    <?php if(isset($_SESSION['userID'])) {
        header("Location: dashboard.php");
        die();
    } ?>
    <!--called by default and if there's a login request ($login is set) so 
        it can fly off the screen-->
    <?php if(!isset($loginError) && !isset($_SESSION['userID'])) {include "greeting.php";} ?>
            
    <!--$login comes from whether a login request has been sent to the index page-->
    <?php if(isset($login)) { include "login.php"; } ?>
</body>
</html>
