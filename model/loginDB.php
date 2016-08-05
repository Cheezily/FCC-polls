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

function checkForUsername($usernameCheck) {
    global $db;
    $query = "SELECT * FROM users WHERE username=:usernameCheck";
    
    $statement = $db->prepare($query);
    $statement->bindValue(":usernameCheck", $usernameCheck);
    $statement->execute();
    
    return $statement->fetch();
}

function saveNewUser($usernameCheck, $password) {
    global $db;
    $query = "INSERT INTO users(username, passwordHash) VALUES (:usernameCheck, :password)";
    
    $statement = $db->prepare($query);
    $statement->bindValue(":usernameCheck", $usernameCheck);
    $statement->bindValue(":password", $password);
    $statement->execute();
    
    return checkUsernamePW($usernameCheck, $password);
}
?>