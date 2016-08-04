<?php
session_start();

//if there's no full session variable, you shouldn't be here!
if ($_SESSION['username'] == '') {
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
}

require_once "model/pollsDB.php";

$polls = getPollsForUser($_SESSION['userID']);

?>
<!--
<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='css/main.css' />
<title>
    Polls!
</title>
</head>
<body>
-->
    <?php if ($dashboardLoad == TRUE) {include "login.php"; ?>
        <div class='dashboard dashboardLoad'>
    <?php 
    } else { ?>
        <div class='dashboard'>
    <?php } ?>
        <?php if($newPoll && !$keepDashboardFaded) { ?>
            <div class="dashboardFadeOut">
        <?php } elseif ($newPollCancel) { ?>
            <div class="dashboardFadeIn">
        <?php } elseif ($keepDashboardFaded) { ?>
            <div class='keepDashboardFaded'>
        <?php } else { ?>
            <div>   
        <?php } ?>
                <?php 
                    echo "<div class='dashboardUsername'>";
                    echo "<span>Welcome, ".$_SESSION['username']."!</span>";
                ?>
                <form class='dashboardLogout' method='post' action='index.php'>
                    <input type='submit' name='logout' value='Log Out'>
                </form>
                <?php echo "</div>"; ?>
                <?php if(!empty($polls)) {
                    forEach($polls as $poll) {
                        var_dump($poll);
                        $optionList = unserialize($poll['options']);
                        
                        $votes = 0;
                        forEach($optionList as $option) {
                            $votes += $option[1];
                        }
                        
                        echo "<div class='dashboardPoll'>";
                        echo "<div class='dashboardPollTitle'>".$poll['title']."</div>";
                        echo "<div class='dashboardPollInfo'>";
                        echo "<ps class='dashboardVotes'>Votes: ".$votes."</p>";
                        if (substr($poll['dateExpiration'],0,4) != '0000') {
                            echo "<p class='dashboardExp'>Expiration: ".$poll['dateExpiration']."</p>";
                        } else {
                            echo "<p class='dashboardExp'>Expiration: None</p>";
                        }
                        echo "</div>";
                        echo "<form method='get' action='index.php'>";
                        echo "<input type='hidden' name='poll' value='".$poll['pollID']."'>";
                        echo "<button class='goToPoll' type='submit' value='poll'>Go To Poll</button>";
                        echo "</form>";
                        echo "<form method='post' action='index.php'>";
                        echo "<input type='hidden' name='poll' value='".$poll['pollID']."'>";
                        echo "<button class='deletePoll' type='submit' value='delete'>Delete Poll</button>";
                        echo "</form>";
                        echo "</div>";
                    }
                } else { ?>
                <h2>There are no polls to display! Click below to create a new one.</h2>
                <?php } ?>
                <form method="post" action="index.php">
                    <input type="submit" name="newPoll" value="Create New Poll">
                </form>
            </div>
        </div>

<!--
</body>
</html>
-->