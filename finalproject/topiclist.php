<?php
include 'connect.php';
doDB();

//gather the topics
$get_topics_sql = "SELECT devtopic_id, devtopic_title, DATE_FORMAT(devtopic_time,  '%b %e %Y at %r') as fmt_devtopic_time, devtopic_owner FROM dev_topics ORDER BY devtopic_time DESC";
$get_topics_res = mysqli_query($mysqli, $get_topics_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_topics_res) < 1) {
	//there are no topics, so say so
	$display_block = "<p><em>No topics exist.</em></p>";
} else {
	//create the display string
    $display_block = <<<END_OF_TEXT
    <table class="table table-hover" style="margin:auto;">
    <tr>
    <th>TOPIC TITLE</th>
    <th># of POSTS</th>
    </tr>
END_OF_TEXT;

	while ($topic_info = mysqli_fetch_array($get_topics_res)) {
		$topic_id = $topic_info['devtopic_id'];
		$topic_title = stripslashes($topic_info['devtopic_title']);
		$topic_create_time = $topic_info['fmt_devtopic_time'];
		$topic_owner = stripslashes($topic_info['devtopic_owner']);

		//get number of posts
		$get_num_posts_sql = "SELECT COUNT(devpost_id) AS devpost_count FROM dev_posts WHERE devtopic_id = '".$topic_id."'";
		$get_num_posts_res = mysqli_query($mysqli, $get_num_posts_sql) or die(mysqli_error($mysqli));

		while ($posts_info = mysqli_fetch_array($get_num_posts_res)) {
			$num_posts = $posts_info['devpost_count'];
		}

		//add to display
		$display_block .= <<<END_OF_TEXT
		<tr>
		<td><a href="showtopic.php?devtopic_id=$topic_id"><strong>$topic_title</strong></a><br/>
		Created on $topic_create_time by $topic_owner</td>
		<td class="num_posts_col" style="text-align:center;">$num_posts</td>
		</tr>
END_OF_TEXT;
	}
	//free results
	mysqli_free_result($get_topics_res);
	mysqli_free_result($get_num_posts_res);

	//close connection to MySQL
	mysqli_close($mysqli);

	//close up the table
	$display_block .= "</table>";
}
include 'BeginNav.php';
echo $display_block;
include 'EndNav.php';
?>