<?php
    require_once "model/pollsDB.php";
    $pollList = getLatestPolls();
    //var_dump($pollList);
    $items = '';
    for($i = 0; $i < 12; $i++) {
        if (!empty($pollList[$i])) {
            $items .= "<div class='item'>".
                "<form method='get' action=''>".
                "<button class='greetingOption' name='poll' value=".$pollList[$i]['pollID']."><h1>".
                $pollList[$i]['title']."</h2></button></form></div>";
        } else {
            $items .= "<div class='item'>".
                "<h1>Coming Soon!</h1>".
                "</div>";
        }
    }
?>


<?php if(isset($login) || $newUser) { ?>
        <div class="container hideContainer">
    <?php } else { ?>
        <div class="container">
    <?php } ?>

        <div class='greeting'>
          <div class='leftSideStuff'>
            <h1>Already have a user name?</h1>
            <form method="post" action="">
                <input class='loginButton' type="submit" value="Login" name="login">
            </form>
            <hr>
            <h1>Or... </h1>
            <h2>Create a new user name and set up some polls!</h2>
            <form method="post" action="">
                <input class='newUserButton' type="submit" value="New User" name="newUser">
            </form>
            <!-- keyword search function will be added later
            <hr>
            <h1>Search for polls by keyword:</h1>
            <form method='get' action=''>
                <label for='keywords'>*Separate each keyword with a comma</label>
                <br>
                <input type='text' name='keywords' placeholder='keywords'>
                <input type='submit' value='Search!'>
            </form>
            -->
          </div>

          <div class="itemsLabel">Most Recent Polls - Click to Vote!</div>
          <div class='items'>
<?php
    echo $items;
    echo $items;
?>
          </div>
            <div class="shadowLayer">

            </div>
        </div>
    </div>
