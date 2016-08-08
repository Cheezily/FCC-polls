<?php
require_once 'database.php';


function checkUsernamePW($usernameCheck, $pwCheck) {
    global $db;
    $query = "SELECT * FROM users WHERE username=:usernameCheck";
    
    $statement = $db->prepare($query);
    $statement->bindValue(":usernameCheck", $usernameCheck);
    $statement->execute();
    
    $userInfo = $statement->fetch();
    
    if (password_verify($pwCheck, $userInfo['passwordHash'])) {
        return $userInfo;
    } else {
        return FALSE;
    }
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
    
    $hashOptions = ['cost' => 11];
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, $hashOptions);
    $statement = $db->prepare($query);
    $statement->bindValue(":usernameCheck", $usernameCheck);
    $statement->bindValue(":password", $passwordHash);
    $statement->execute();
    
    return checkUsernamePW($usernameCheck, $password);
}
?>