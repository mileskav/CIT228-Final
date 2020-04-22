<?php
//start session
session_start();
?>
<?php
include 'connect.php';
doDB();

//check for required fields from the form
if ((!$_POST['devtopic_owner']) || (!$_POST['devtopic_title']) || (!$_POST['devpost_text'])) {
	header("Location: addtopic.html");
	exit;
}

//create safe values for input into the database
$clean_topic_owner = mysqli_real_escape_string($mysqli, $_POST['devtopic_owner']);
$clean_topic_title = mysqli_real_escape_string($mysqli, $_POST['devtopic_title']);
$clean_post_text = mysqli_real_escape_string($mysqli, $_POST['devpost_text']);

//create and issue the first query
$add_topic_sql = "INSERT INTO dev_topics (devtopic_title, devtopic_time, devtopic_owner) VALUES ('".$clean_topic_title ."', now(), '".$clean_topic_owner."')";

$add_topic_res = mysqli_query($mysqli, $add_topic_sql) or die(mysqli_error($mysqli));

//get the id of the last query
$topic_id = mysqli_insert_id($mysqli);
$_SESSION["devtopic_id"] = $topic_id;
$_SESSION['devtopic_title'] = $clean_topic_title;
$_SESSION['devpost_text'] = $clean_post_text;

//create and issue the second query
$add_post_sql = "INSERT INTO dev_posts (devtopic_id, devpost_text, devpost_time, devpost_owner) VALUES ('".$topic_id."', '".$clean_post_text."',  now(), '".$clean_topic_owner."')";

$add_post_res = mysqli_query($mysqli, $add_post_sql) or die(mysqli_error($mysqli));

//close connection to MySQL
mysqli_close($mysqli);

//create nice message for user
$display_block = "<p>The <strong>".$_POST["devtopic_title"]."</strong> topic has been created.</p>
<form>
<input type='button' name='edit' id='edit' value='Edit Post' onclick='location.href=\"editpost.php\"'>
<input type='button' name='delete' id='delete' value='Delete Post' onclick='location.href=\"deletepost.php\"'>
</form>";
include 'BeginNav.php';
echo $display_block;
include 'EndNav.php';
?>
