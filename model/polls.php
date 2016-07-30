<?php
include "database.php";

function getPollsForUser($userID) {
    
};

function savePoll($userID, $title, $options, $expiration, $keywords) {
    global $db;
    $query = "INSERT INTO polls('userID', 'title', 'options', 'dateCreated', 'dateExpiration', 'keywordList') ".
            "VALUES (:userID, :title, :options, :expiration)";
    $statement = $db->prepare($query);
    
    
}


function addUser($user) {
    global $db;
    $query = "INSERT INTO users (username, account_created, first_name,".
            "last_name, email, passwordHash, role) VALUES (:username, ".
            ":account_created, :first_name, :last_name, :email, :passwordHash, ".
            ":role)";
    $accountCreated = date("Y-m-d H:i:s");
    
    $passwordOptions = ['cost' => 11];
    $passwordHash = password_hash($user['password'], PASSWORD_BCRYPT, $passwordOptions);
    
    $statement = $db->prepare($query);
    $statement->bindValue(":username", strtolower($user['username']));
    $statement->bindValue(":account_created", $accountCreated);
    $statement->bindValue(":first_name", $user['firstName']);
    $statement->bindValue(":last_name", $user['lastName']);
    $statement->bindValue(":email", $user['email']);
    $statement->bindValue(":passwordHash", $passwordHash);
    $statement->bindValue(":role", $user['role']);
    $statement->execute();

}
?>