<?php
include 'connect.php';
doDB();

//check to see if we're showing the form or adding the post
if (!$_POST) {
   // showing the form; check for required item in query string
   if (!isset($_GET['devpost_id'])) {
      header("Location: topiclist.php");
      exit;
   }

   //create safe values for use
   $safe_post_id = mysqli_real_escape_string($mysqli, $_GET['devpost_id']);

   //still have to verify topic and post
   $verify_sql = "SELECT dt.devtopic_id, dt.devtopic_title FROM dev_posts
                  AS dp LEFT JOIN dev_topics AS dt ON dp.devtopic_id =
                  dt.devtopic_id WHERE dp.devpost_id = '".$safe_post_id."'";

   $verify_res = mysqli_query($mysqli, $verify_sql)
                 or die(mysqli_error($mysqli));

   if (mysqli_num_rows($verify_res) < 1) {
      //this post or topic does not exist
      header("Location: topiclist.php");
      exit;
   } else {
      //get the topic id and title
      while($topic_info = mysqli_fetch_array($verify_res)) {
         $topic_id = $topic_info['devtopic_id'];
         $topic_title = stripslashes($topic_info['devtopic_title']);
      }
      include 'BeginNav.php';
?>
      <section>
      <h1>Post Your Reply in <?php echo $topic_title; ?></h1>
      <form method="post" action="replytopost.php">
      <p><label for="devpost_owner">Your Email Address:</label><br/>
      <input type="email" id="devpost_owner" name="devpost_owner" size="40"
         maxlength="150" required="required"></p>
      <p><label for="devpost_text">Post Text:</label><br/>
      <textarea id="devpost_text" name="devpost_text" rows="8" cols="40"
         required="required"></textarea></p>
      <input type="hidden" name="devtopic_id" value="<?php echo $topic_id; ?>">
      <button type="submit" name="submit" value="submit">Add Post</button>
      </form>
      </section>
<?php
      include 'EndNav.php';
      //free result
      mysqli_free_result($verify_res);

      //close connection to MySQL
      mysqli_close($mysqli);
   }

} else if ($_POST) {
      //check for required items from form
      if ((!$_POST['devtopic_id']) || (!$_POST['devpost_text']) ||
          (!$_POST['devpost_owner'])) {
          header("Location: topiclist.php");
          exit;
      }

      //create safe values for use
      $safe_topic_id = mysqli_real_escape_string($mysqli, $_POST['devtopic_id']);
      $safe_post_text = mysqli_real_escape_string($mysqli, $_POST['devpost_text']);
      $safe_post_owner = mysqli_real_escape_string($mysqli, $_POST['devpost_owner']);

      //add the post
      $add_post_sql = "INSERT INTO dev_posts (devtopic_id,devpost_text,
                       devpost_time,devpost_owner) VALUES
                       ('".$safe_topic_id."', '".$safe_post_text."',
                       now(),'".$safe_post_owner."')";
      $add_post_res = mysqli_query($mysqli, $add_post_sql)
                      or die(mysqli_error($mysqli));

      //close connection to MySQL
      mysqli_close($mysqli);

      //redirect user to topic
      header("Location: showtopic.php?devtopic_id=".$_POST['devtopic_id']);
      exit;
}
?>

