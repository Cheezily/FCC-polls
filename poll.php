<?php
require_once 'model/pollsDB.php';
session_start();

//if a poll id has not been passed, jump back to the home page
if (!$pollID) {
    header("Location: index.php");
}

$pollInfo = getPollsByID($pollID);
$options = unserialize($pollInfo['options']);

//var_dump($pollInfo);

?>

<?php echo "ASDFASDFASDF ".$votedPoll;
    echo "VOTED OPTION: ".$voteOption;
?>

<div class="pollContainer">
    <div class='pollHeader'>
        <?php if(!empty($_SESSION['votedPoll']) && $_SESSION['votedPoll'] == $pollInfo['pollID']) { ?>
            <h2 class='pollTitle'>Thanks for voting!</h2>
            <form method='get' action=''>
                <input type='submit' value="Back to Main Page">
            </form>
        <?php } elseif ($results) { ?>
            <h2 class='pollTitle'><?php echo $pollInfo['title']; ?> - Results!</h2>
            <form method='get' action=''>
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

        
    </div>
    <?php for($i = 0; $i < count($options); $i++) { ?>
        <form method='get' action='index.php'>
            <input type='hidden' name='poll' value='<?php echo $pollID; ?>'>
            <button class="pollOption" type='submit' name='vote' value='<?php echo $i; ?>'>
                <?php echo $options[$i][0];?>
                <?php if(!empty($_SESSION['votedPoll']) && $_SESSION['votedPoll'] == $pollInfo['pollID']) {
                    echo "<span class='voteCount'> - ".$options[$i][1]." Votes</span>";
                } ?>
            </button>
        </form>
    <?php } ?>
</div>