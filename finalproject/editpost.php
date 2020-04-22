<?php
// Start the session
session_start();
?>
<?php
include 'connect.php';
doDB();
if (!$_POST) {
	//haven't seen the selection form, so show it
	$display_block = "<h1>Edit Post</h1>";
	$saved_id = $_SESSION['devtopic_id'];
	$saved_title = $_SESSION['devtopic_title'];
	$saved_post_text = $_SESSION['devpost_text'];
	//get record from topics table
	$get_topic_sql = "SELECT * FROM dev_topics WHERE devtopic_id = $saved_id;";
	$get_topic_res = mysqli_query($mysqli, $get_topic_sql) or die(mysqli_error($mysqli));
	// get record from topic posting table
	$get_post_sql = "SELECT * FROM dev_posts WHERE devtopic_id = $saved_id;";
	$get_post_res = mysqli_query($mysqli, $get_post_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_topic_res) < 1) {
		//no records
		$display_block .= "<p><em>There was an error retrieving your topic!</em></p>";
	} else {
		//topic record exists, so display topic and post information for editing
		$rec = mysqli_fetch_array($get_topic_res);
		$display_id = stripslashes($rec['devtopic_id']);
		$display_title = stripslashes($rec['devtopic_title']);
		$display_block .= "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
		$display_block .="<p>Topic Title: <input type='text' id='devtopic_title' name='devtopic_title' value='".$display_title."'></p>";
		$postRec = mysqli_fetch_array($get_post_res);
		$display_post = stripslashes($postRec['devpost_text']);
		$display_block .="<p>Post Text: <textarea  style='vertical-align:text-top;' id='devpost_text' name='devpost_text'>".$display_post."</textarea></p>";
		$display_block .= "<button type='submit' id='change' name='change' value='change'>Change entry</button></p>";
		$display_block .="</form>";
	}
	//free result
	mysqli_free_result($get_post_res);
	mysqli_free_result($get_topic_res);
}
// posted form, so tables should update
else
{
	$clean_topic_title = mysqli_real_escape_string($mysqli, $_POST['devtopic_title']);
	$clean_post_text = mysqli_real_escape_string($mysqli, $_POST['devpost_text']);

	//create and issue the forum_topic update
	$update_topic_sql = "UPDATE dev_topics SET devtopic_title = '".$clean_topic_title ."' WHERE devtopic_id =".$_SESSION['devtopic_id'];
	$update_topic_res = mysqli_query($mysqli, $update_topic_sql) or die(mysqli_error($mysqli));

	//create and issue the forum_post update
	$update_post_sql = "UPDATE dev_posts SET devpost_text='" .$clean_post_text."' WHERE devtopic_id= ".$_SESSION['devtopic_id'];
	$update_post_res = mysqli_query($mysqli, $update_post_sql) or die(mysqli_error($mysqli));

	//close connection to MySQL
	mysqli_close($mysqli);

	//create nice message for user
	$display_block ="<h2>Your posting has been modified...</h2>";
	$display_block.="<p>The topic title has been modified to: <strong><em>".$clean_topic_title."</em></strong><br>";
	$display_block.="The topic text has been modified to: <strong><em>".$clean_post_text."</em></strong></p>";

}
include 'BeginNav.php';
echo $display_block;
include 'EndNav.php';
?>

