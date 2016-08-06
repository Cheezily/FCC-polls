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
            <h1>Already a registered user?</h1>
            <form method="post" action="">
                <input type="submit" value="Login" name="login">
            </form>
            <form method="post" action="">
                <input type="submit" value="New User" name="newUser">
            </form>
            <hr>
            <h1>Search for polls by keyword:</h1>
            <form method='get' action=''>
                <label for='keywords'>*Separate each keyword with a comma</label>
                <br>
                <input type='text' name='keywords' placeholder='keywords'>
                <input type='submit' value='Search!'>
            </form>
          </div>

          <div class="itemsLabel">Recent Polls -- Click to Participate</div>
          <div class='items'>
<!--
            <div class='item'>
              <h1>Box #12</h1>
            </div>
            <div class='item'>
              <h1>Box #11</h1>
            </div>
            <div class='item'>
              <h1>Box #10</h1>
            </div>
            <div class='item'>
              <h1>Box #9</h1>
            </div>
            <div class='item'>
              <h1>Box #8</h1>
            </div>
            <div class='item'>
              <h1>Box #7</h1>
            </div>
            <div class='item'>
              <h1>Box #6</h1>
            </div>
            <div class='item'>
              <h1>Box #5</h1>
            </div>
            <div class='item'>
              <h1>Box #4</h1>
            </div>
            <div class='item'>
              <h1>Box #3</h1>
            </div>
            <div class='item'>
              <h1>Box #2</h1>
            </div>
            <div class='item'>
              <h1>Box #1</h1>
            </div>

            <div class="repeatList">
            <div class='item'>
              <h1>Box #12</h1>
            </div>
            <div class='item'>
              <h1>Box #11</h1>
            </div>
            <div class='item'>
              <h1>Box #10</h1>
            </div>
            <div class='item'>
              <h1>Box #9</h1>
            </div>
            <div class='item'>
              <h1>Box #8</h1>
            </div>
            <div class='item'>
              <h1>Box #7</h1>
            </div>
            <div class='item'>
              <h1>Box #6</h1>
            </div>
            <div class='item'>
              <h1>Box #5</h1>
            </div>
            <div class='item'>
              <h1>Box #4</h1>
            </div>
            <div class='item'>
              <h1>Box #3</h1>
            </div>
            <div class='item'>
              <h1>Box #2</h1>
            </div>
   ?php echo $items; ?>         <div class='item'>
              <h1>Box #1</h1>
            </div>
-->
<?php 
    echo $items;
    //echo "<div class='repeatList'>";
    echo $items;
    //echo "</div>";
?>
          </div>
            <div class="shadowLayer">

            </div>
        </div>
    </div>