<?php
require_once "database.php";

function getPollsForUser($pollUserID) {
    global $db;
    
    $query = "SELECT * FROM polls WHERE userId=:userID ORDER BY dateCreated DESC";
    $statement = $db->prepare($query);
    $statement->bindValue(":userID", $pollUserID);
    $statement->execute();
    
    return $statement->fetchAll();
};



function savePoll($userID, $pollTitle, $optionsToSave, $pollExpiration, $keywordString) {
    global $db;
    $optionsAsText = serialize($options);
    
    $query = "INSERT INTO polls(userID, title, options, dateCreated, dateExpiration, keywordList) ".
            "VALUES (:userID, :title, :options, :dateCreated, :expiration, :keywords)";
    $statement = $db->prepare($query);
    $statement->bindValue(":userID", $userID);
    $statement->bindValue(":title", $pollTitle);
    $statement->bindValue(":options", $optionsToSave);
    $statement->bindValue(":dateCreated", date("Y-m-d H:i:s"));
    $statement->bindValue(":expiration", $pollExpiration);
    $statement->bindValue(":keywords", $keywordString);
    $statement->execute();
    
    /*Get the keywords in an array to be pushed to the keywords table*/
    $rawKeywordArray = explode(",", $keywordString);
    $keywordArray = array();
    
    forEach($rawKeywordArray as $kw) {
        $scrubedKeyword = trim(htmlspecialchars($kw));
        array_push($keywordArray, $scrubedKeyword);
    }
    
    //var_dump($keywordArray);
    
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