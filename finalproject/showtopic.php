<?php
include 'connect.php';
doDB();

//check for required info from the query string
if (!isset($_GET['devtopic_id'])) {
	header("Location: topiclist.php");
	exit;
}

//create safe values for use
$safe_topic_id = mysqli_real_escape_string($mysqli, $_GET['devtopic_id']);

//verify the topic exists
$verify_topic_sql = "SELECT devtopic_title FROM dev_topics WHERE devtopic_id = '".$safe_topic_id."'";
$verify_topic_res =  mysqli_query($mysqli, $verify_topic_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($verify_topic_res) < 1) {
	//this topic does not exist
	$display_block = "<p><em>You have selected an invalid topic.<br/>
	Please <a href=\"topiclist.php\">try again</a>.</em></p>";
} else {
	//get the topic title
	while ($topic_info = mysqli_fetch_array($verify_topic_res)) {
		$topic_title = stripslashes($topic_info['devtopic_title']);
	}

	//gather the posts
	$get_posts_sql = "SELECT devpost_id, devpost_text, DATE_FORMAT(devpost_time, '%b %e %Y<br/>%r') AS fmt_devpost_time, devpost_owner FROM dev_posts WHERE devtopic_id = '".$safe_topic_id."' ORDER BY devpost_time ASC";
	$get_posts_res = mysqli_query($mysqli, $get_posts_sql) or die(mysqli_error($mysqli));

	//create the display string
	$display_block = <<<END_OF_TEXT
	<p>Showing posts for the <strong>$topic_title</strong> topic:</p>
	<table class="table table-hover">
	<tr>
	<th>AUTHOR</th>
	<th>POST</th>
	</tr>
END_OF_TEXT;

	while ($posts_info = mysqli_fetch_array($get_posts_res)) {
		$post_id = $posts_info['devpost_id'];
		$post_text = nl2br(stripslashes($posts_info['devpost_text']));
		$post_create_time = $posts_info['fmt_devpost_time'];
		$post_owner = stripslashes($posts_info['devpost_owner']);

		//add to display
	 	$display_block .= <<<END_OF_TEXT
		<tr>
		<td>$post_owner<br/><br/>created on:<br/>$post_create_time</td>
		<td>$post_text<br/><br/>
		<a href="replytopost.php?devpost_id=$post_id"><strong>REPLY TO POST</strong></a></td>
		</tr>
END_OF_TEXT;
	}

	//free results
	mysqli_free_result($get_posts_res);
	mysqli_free_result($verify_topic_res);

	//close connection to MySQL
	mysqli_close($mysqli);

	//close up the table
	$display_block .= "</table>";
	include 'BeginNav.php';
	echo '<h1>Posts in Topic</h1>';
	echo $display_block;
	include 'EndNav.php';
}
?>