<?php
error_reporting(E_ALL &  ~E_NOTICE);
session_start();

include "model/database.php";

//handle voting on a poll
if (isset($_GET['vote'])) {
    $votedPoll = filter_input(INPUT_GET, 'poll', FILTER_VALIDATE_INT);
    if ($votedPoll && $_SESSION['votedPoll'] != $votedPoll) {
        require_once 'model/pollsDB.php';
        $_SESSION['votedPoll'] = $votedPoll;
        $voteOption = filter_input(INPUT_GET, 'vote', FILTER_VALIDATE_INT);
        $pollInfo = getPollsByID($votedPoll);
        $options = unserialize($pollInfo['options']);
        $options[$voteOption][1]++;
        $pollInfo['options'] = serialize($options);
        saveVote($pollInfo['options'], $votedPoll);
    } else {
        $results = TRUE;
    }
}

//handle displaying the selected poll
if (isset($_GET['poll'])) {
    $pollID = filter_input(INPUT_GET, 'poll', FILTER_VALIDATE_INT);
    if (isset($_GET['vote'])) {
        $voted = TRUE;
    }
    if (isset($_GET['results'])) {
        $results = TRUE;
    }
    if ($pollID == $_SESSION['votedPoll']) {
        $results = TRUE;
    }
}


//handles request by the user to delete a poll
if (isset($_POST['deleteConfirm'])) {
  $deleteConfirm = TRUE;
  $pollIDdelete = filter_input(INPUT_POST, 'deleteConfirm', FILTER_VALIDATE_INT);

  echo "POLLID: ".$pollID;
}

//handle if the user wants to delete a poll from their dashboard
if (isset($_POST['delete'])) {
    require_once 'model/pollsDB.php';
    $pollID = filter_input(INPUT_POST, 'delete', FILTER_VALIDATE_INT);
    $pollInfo = getPollsByID($pollID);
    $pollUserID = $pollInfo['userID'];
    if ($_SESSION['userID'] == $pollUserID) {
        deletePoll($pollID, $pollUserID);
        header("Location: index.php");
    }
}


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

//handle request for new user registration
if (isset($_POST['newUser'])) {
    $newUser = TRUE;
}
if (isset($_POST['newUserSubmit'])) {
    require_once "model/loginDB.php";
    $newUser = TRUE;
    $password = filter_input(INPUT_POST, 'password');
    $passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm');
    $usernameCheck = filter_input(INPUT_POST, 'username');

    if (strlen($usernameCheck) == 0) {
        $newUserError = TRUE;
        $newUserMissing = TRUE;
    }
    if (strlen($password) == 0) {
        $newUserError = TRUE;
        $newUserPWmissing = TRUE;
    }
    if (strlen($password) >= 1 && strlen($password) < 8) {
        $newUserError = TRUE;
        $newUserPWshort = TRUE;
    }
    if (!empty(checkForUsername($usernameCheck))) {
        $newUserError = TRUE;
        $newUserTaken = TRUE;
        $usernameCheck = '';
    }
    if (!$newUserError && $password !== $passwordConfirm) {
        $newUserError = TRUE;
        $newUserPWmatch = TRUE;
    }
    //if all checks pass, save the user info and then log the user in
    if (!$newUserError) {
        $saveUserAndLogin = saveNewUser($usernameCheck, $password);
        if (!empty($saveUserAndLogin)) {
            $_SESSION['userID'] = $saveUserAndLogin['userId'];
            $_SESSION['username'] = $saveUserAndLogin['username'];
            $dashboardLoad = TRUE;
        }
    }
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
    $pollTitle = filter_input(INPUT_POST, 'pollTitle');
    $options = $_POST['options'];
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
    array_splice($options, $removeOption, 1);
    $numPollOptions = count($options);
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
    <?php if($pollID) { include "poll.php"; } ?>

    <?php if($newUser) { include "newUser.php";} ?>

    <!--$login comes from whether a login request has been sent to the index page-->
    <?php if($login || $loginError) { include "login.php"; } ?>

    <?php if(isset($_SESSION['userID']) && !$pollID) {
        include "dashboard.php";
        if ($newPoll || $newPollCancel || $newPollSubmit) {
            include "newPoll.php";
        }
        die();
    } ?>
    <!--called by default and if there's a login request ($login is set) so
        it can fly off the screen-->
    <?php if(!$pollID && !$newUserError && !$loginError && !isset($_SESSION['userID'])) {
        include "greeting.php";
    } ?>
</body>
</html>
