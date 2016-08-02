
<?php if($newPollCancel || $newPollSubmit) { ?>
    <div class="newPoll newPollUnload">
<?php } elseif ($pollDialogOpen) { ?>
    <div class="newPoll">
<?php } else { ?>
    <div class="newPoll newPollLoad">
<?php } ?>
        <form method="post" action="index.php">
            <label for='pollTitle'>Title</label><br>
            <input type='text' name='pollTitle' value="<?php echo $pollTitle; ?>" required><br>
            <?php for ($i = 1; $i < $numPollOptions + 1; $i++) {
                if (!empty($options[$i])) {
                    $thisOption = htmlspecialchars($options[$i]);
                } else {
                    $thisOption = '';
                }
                if ($i <= 2) {
                    echo "<label for='option".$i."'>Option ".$i."</label><br>";
                    echo "<input type='text' id='option".$i."' name='options[".$i."]' value='".$thisOption."' required><br>"; 
                } else {
                    echo "<label for='option".$i."'>Option ".$i."</label><br>";
                    echo "<input type='text' id='option".$i."' name='options[".$i."]' value=".$thisOption.">";
                    echo "<button type='submit' name='removeOption' value=".$i." class='removeOption'>-</button><br>";
                }
            } ?>
            <input type="hidden" name='numPollOptions' value=<?php echo $numPollOptions; ?>>
            <input type='submit' name='addPollOption' value='Add Option'>
            <input type='submit' name='submitPoll' value='Submit'>
        </form>
        <form method="post" action="index.php">
            <input type="hidden" name='numPollOptions' value=<?php echo $numPollOptions; ?>>
            <input type='submit' name='newPollCancel' value='Cancel'>
        </form>
        <form method="post" action="index.php">

        </form>
    </div>