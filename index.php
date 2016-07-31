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
    <!--called by default and if there's a login request ($login is set) so 
        it can fly off the screen-->
    <?php include "greeting.php"; ?>
            
    <!--$login comes from whether a login request has been sent to the index page-->
    <?php if(isset($login)) { include "login.php"; } ?>
</body>
</html>
