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

<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='css/main.css' />
<title>
    Polls!
</title>
</head>
<body>

<?php if(isset($_SESSION['userID'])) { ?>
    <?php if(isset($_SESSION['loadingDashboard'])) { ?>
        <div class='dashboard dashboardLoad'>
    <?php $_SESSION['loadingDashboard'] = FALSE; } else { ?>
        <div class='dashboard'>
    <?php } ?>
            <form method='post' action='index.php'>
                <input type='submit' name='logout' value='Log Out'>
            </form>
            <h1>this is the dashboard</h1>
        </div>

<?php } ?>

</body>
</html>
        