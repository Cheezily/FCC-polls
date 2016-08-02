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

//JUST A TEST. DISREGARD
if (isset($_GET['newUser'])) {
    require_once "model/pollsDB.php";
    var_dump(getPollsForUser(1));
}

//handles username and password being passed from the login page
if (isset($_POST['checkUsernamePW'])) {
    $username = filter_input(INPUT_POST, "username");
    $password = filter_input(INPUT_POST, "password");
    
    require_once "model/loginDB.php";
    $loginResult = checkUsernamePW($username, $password);
    
    if (!empty($loginResult)) {
        //var_dump($loginResult);
        $_SESSION['userID'] = $loginResult['userId'];
        $_SESSION['username'] = $loginResult['username'];
        $dashboardLoad = TRUE;
    } else {
        $loginError = TRUE;
    }
}


//Handles the requests for creating a new poll as well as cancelling a request
if (isset($_POST['newPoll'])) {
    $newPoll = TRUE;
    $dashboardLoaded = TRUE;
    $numPollOptions = 2;
    $addedPollOptions = 0;
    $pollDialogOpen = FALSE;
    $options = array();
}
if (isset($_POST['newPollCancel'])) {
    $numPollOptions = filter_input(INPUT_POST, "numPollOptions", FILTER_VALIDATE_INT);
    $newPollCancel = TRUE;
}
if (isset($_POST['newPollSubmit'])) {
    $newPollSubmit = TRUE;
    var_dump($_POST['options']);
}
if (isset($_POST['addPollOption'])) {
    $numPollOptions = filter_input(INPUT_POST, "numPollOptions", FILTER_VALIDATE_INT);
    $numPollOptions += 1;
    $newPoll = TRUE;
    $dashboardLoaded = TRUE;
    $pollDialogOpen = TRUE;
    $keepDashboardFaded = TRUE;
    $pollTitle = filter_input(INPUT_POST, 'pollTitle');
    $options = $_POST['options'];
    //$options = filter_input(INPUT_POST, "options");
    var_dump($options);
}
if (isset($_POST['removeOption'])) {
    $newPoll = TRUE;
    $dashboardLoaded = TRUE;
    $pollDialogOpen = TRUE;
    $keepDashboardFaded = TRUE;
    $removeOption = filter_input(INPUT_POST, 'removeOption');
    $pollTitle = filter_input(INPUT_POST, 'pollTitle');
    $options = $_POST['options'];
    echo "INDEX: ".$removeOption - 1;
    var_dump($options);
    
    array_splice($options, $removeOption - 1, 1);
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
    
    <!--$login comes from whether a login request has been sent to the index page-->
    <?php if(isset($login) || $loginError) { include "login.php"; } ?>
    
    <?php if(isset($_SESSION['userID'])) {
        include "dashboard.php";
        if ($newPoll || $newPollCancel) {
            include "newPoll.php";
        }
        die();
    } ?>
    <!--called by default and if there's a login request ($login is set) so 
        it can fly off the screen-->
    <?php if(!isset($loginError) && !isset($_SESSION['userID'])) {include "greeting.php";} ?>
            

    
</body>
</html>
