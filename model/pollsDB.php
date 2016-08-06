<?php
require_once "database.php";


function getPollsForUser($pollUserID) {
    global $db;
    
    $query = "SELECT * FROM polls WHERE userID=:userID ORDER BY dateCreated DESC";
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
    
};


function getPollsByID($pollID) {
    global $db;
    
    $query = "SELECT * FROM polls WHERE pollID=:pollID";
    $statement = $db->prepare($query);
    $statement->bindValue(":pollID", $pollID);
    $statement->execute();
    
    return $statement->fetch();
};


function saveVote($options, $pollID) {
    global $db;
    
    $query = "UPDATE polls SET options=:options WHERE pollID=:pollID";
    
    $statement = $db->prepare($query);
    $statement->bindValue(":options", $options);
    $statement->bindValue(":pollID", $pollID);
    $statement->execute();
}


function getLatestPolls() {
    global $db;
    
    $query = "SELECT * FROM polls ORDER BY dateCreated DESC LIMIT 12";
    $statement = $db->prepare($query);
    $statement->bindValue(":userID", $pollUserID);
    $statement->execute();
    
    return $statement->fetchAll();
}
?>