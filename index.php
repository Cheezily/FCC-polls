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
    require "model/pollsDB.php";
    $numPollOptions = filter_input(INPUT_POST, "numPollOptions", FILTER_VALIDATE_INT);
    $newPollSubmit = TRUE;
    $pollTitle = filter_input(INPUT_POST, 'pollTitle');
    $options = $_POST['options'];
    if (!empty($_POST['pollExpiration'])) {
        $pollExpiration = returnDBTime($_POST['pollExpiration']);
    } else {
        $pollExpiration = '';
    }
    
    $keywordString = '';
    //get the list of submitted options into an array ("option" -> votes)
    //the last option that is submitted can be blank, so it will be removed
    $optionsToSave = array();
    foreach($options as $option) {
        if ($option != "") {
            $optionWithZeroVotes[0] = htmlspecialchars($option);
            $optionWithZeroVotes[1] = 0;
            array_push($optionsToSave, $optionWithZeroVotes);
        }
    }
    $optionsToSave = serialize($optionsToSave);
    
    savePoll($_SESSION['userID'], $pollTitle, $optionsToSave, $pollExpiration, $keywordString);
    
    
}
if (isset($_POST['addPollOption'])) {
    $numPollOptions = filter_input(INPUT_POST, "numPollOptions", FILTER_VALIDATE_INT);
    $numPollOptions += 1;
    $newPoll = TRUE;
    $dashboardLoaded = TRUE;
    $pollDialogOpen = TRUE;
    $keepDashboardFaded = TRUE;
    $pollExpiration = $_POST['pollExpiration'];
    //echo "EXP to save: ".$dateToSave."<br>";
    //echo "EXP: ".$_POST['pollExpiration']."<br>";
    $pollTitle = filter_input(INPUT_POST, 'pollTitle');
    $options = $_POST['options'];
    //$options = filter_input(INPUT_POST, "options");
    //var_dump($options);
}
if (isset($_POST['removeOption'])) {
    $numPollOptions = filter_input(INPUT_POST, "numPollOptions", FILTER_VALIDATE_INT);
    $newPoll = TRUE;
    $dashboardLoaded = TRUE;
    $pollDialogOpen = TRUE;
    $keepDashboardFaded = TRUE;
    $removeOption = $_POST['removeOption'];
    $pollExpiration = $_POST['pollExpiration'];
    $pollTitle = filter_input(INPUT_POST, 'pollTitle');
    $options = $_POST['options'];
    echo "INDEX: ".$removeOption."<br>";
    echo "BEFORE: ".var_dump($options)."<br>";
    
    array_splice($options, $removeOption, 1);
    $numPollOptions = count($options);
    echo "AFTER: ".var_dump($options);
}

//for getting the correct time format for the poll expiration. 
//This is what will be saved in the db for the expiration time
function returnDBTime($htmlToConvert) {
    $htmlDate = substr($htmlToConvert, 0, 10)." ";
    $htmlTime = substr($htmlToConvert, 11);
    return date("Y-m-d H:i:s", strtotime($htmlDate.$htmlTime));
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
        if ($newPoll || $newPollCancel || $newPollSubmit) {
            include "newPoll.php";
        }
        die();
    } ?>
    <!--called by default and if there's a login request ($login is set) so 
        it can fly off the screen-->
    <?php if(!isset($loginError) && !isset($_SESSION['userID'])) {include "greeting.php";} ?>
            

    
</body>
</html>
