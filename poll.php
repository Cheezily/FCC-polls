<?php
require_once 'model/pollsDB.php';
session_start();

//have you already voted on this poll?
if (!empty($_SESSION['votedPoll']) && $_SESSION['votedPoll'] == $pollInfo['pollID']) {
    $pollMatch = TRUE;
}

//if a poll id has not been passed, jump back to the home page. You shouldn't be here
if (!$pollID) {
    header("Location: index.php");
}

//get poll info from DB
$pollInfo = getPollsByID($pollID);
$options = unserialize($pollInfo['options']);

$voteCount = 0;
forEach($options as $option) {
    $voteCount += $option[1];
}

?>

<div class="pollContainer">
    <div class='pollHeader'>
        <?php if($results || !empty($_SESSION['votedPoll']) && $_SESSION['votedPoll'] == $pollInfo['pollID']) { ?>
            <h2 class='pollTitle'><span class='resultTitle'>Results for </span>
                <?php echo $pollInfo['title'];?><span class='resultTitle'> - Total Votes: <?php echo $voteCount; ?></span><h2>
            <form class='resultsButton' method='get' action=''>
                <input type='submit' value="Back to Main Page">
            </form>
        <?php } else { ?>
            <h2 class='pollTitle'><?php echo $pollInfo['title']; ?> - Please vote!</h2>
            <form class='resultsButton' method='get' action=''>
                <input type='hidden' name='poll' value=<?php echo $pollInfo['pollID']; ?>>
                <button type='submit' name='results' value="true">
                    Poll Results
                </button>
            </form>
        <?php } ?>

        
    </div><br>
    <?php for($i = 0; $i < count($options); $i++) { ?>
    
                <?php if ($results || $pollMatch) {
                    if ($voteCount > 0) {
                        $bgWidth = floor(840 * $options[$i][1] / $voteCount);
                    } else {
                        $bgWidth = 1;
                    }
                ?>
                    <div class='pollOption resultGraph'
                         <?php echo "style='box-shadow: inset ".$bgWidth."px 0 0 -15px lightgreen;'" ?>>
                        <span class='voteCount'>
                            <?php 
                                echo $options[$i][0]." - ".$options[$i][1];
                            ?> Votes
                        </span>
                    </div>
                <?php } else { ?>
                    <form method='get' action='index.php'>
                    <input type='hidden' name='poll' value='<?php echo $pollID; ?>'>
                    <button class="pollOption" type='submit' name='vote' value='<?php 
                        echo $i; ?>'><?php echo $options[$i][0];
                        ?></button>
                    </form>
                <?php } ?>
        
    <?php } ?>
</div>