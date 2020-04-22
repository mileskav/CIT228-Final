<?php
//start session
session_start();
?>
<?php
include 'connect.php';
doDB();

//check for required fields from the form
if ((!$_POST['f_name']) || (!$_POST['l_name']) || (!$_POST['email']) || (!$_POST['username']) || (!$_POST['password'])) {
	header("Location: register.html");
	exit;
}

//create safe values for input into the database
$clean_first_name = mysqli_real_escape_string($mysqli, $_POST['f_name']);
$clean_last_name = mysqli_real_escape_string($mysqli, $_POST['l_name']);
$clean_email = mysqli_real_escape_string($mysqli, $_POST['email']);
$clean_username = mysqli_real_escape_string($mysqli, $_POST['username']);
$clean_password = mysqli_real_escape_string($mysqli, $_POST['password']);

//create and issue the first query
$add_user_sql = "INSERT INTO auth_users (f_name, l_name, email, username, password) VALUES ('".$clean_first_name ."', '".$clean_last_name."', '".$clean_email."', '".$clean_username."', 
'".$clean_password."')";

$add_user_res = mysqli_query($mysqli, $add_user_sql) or die(mysqli_error($mysqli));

//close connection to MySQL
mysqli_close($mysqli);

//create nice message for user
$display_block = "<p>The user <strong>".$_POST["username"]."</strong> has been created.</p>
<form>
<input type='button' name='login' id='login' value='Login' onclick='location.href=\"userlogin.html\"'>
<input type='button' name='delete' id='delete' value='Delete User' onclick='location.href=\"deleteuser.html\"'>
</form>";
include 'BeginNav.php';
echo $display_block;
include 'EndNav.php';
?>
