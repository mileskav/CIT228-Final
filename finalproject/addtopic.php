<?php
include 'BeginNav.php';
echo '
<form method="post" action="do_addtopic.php">

<p><label for="devtopic_owner">Your Email Address:</label><br/>
<input type="email" id="devtopic_owner" name="devtopic_owner" size="40"
        maxlength="150" required="required" /></p>

<p><label for="devtopic_title">Topic Title:</label><br/>
<input type="text" id="devtopic_title" name="devtopic_title" size="40"
        maxlength="150" required="required" /></p>

<p><label for="devpost_text">Post Text:</label><br/>
<textarea id="devpost_text" name="devpost_text" rows="8"
          cols="40" ></textarea></p>

<button type="submit" name="submit" value="submit">Add Topic</button>
<input type="button" name="menu" id="menu" value="Return to Menu" onclick="location.href=\'discussionMenu.html\'">
</form>';

include 'EndNav.php';
?>

