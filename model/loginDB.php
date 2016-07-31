<?php
require_once 'database.php';


function checkUsernamePW($usernameCheck, $pwCheck) {
    global $db;
    $query = "SELECT * FROM users WHERE username=:usernameCheck AND passwordHash=:pwCheck";
    
    $statement = $db->prepare($query);
    $statement->bindValue(":usernameCheck", $usernameCheck);
    $statement->bindValue(":pwCheck", $pwCheck);
    $statement->execute();
    
    return $statement->fetch();
}

?>