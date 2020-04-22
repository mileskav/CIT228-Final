<?php
$xmlList = simplexml_load_file("users.xml") or die("Error: Cannot create object");
foreach($xmlList->user as $user){
	$first=$user->first;
	$last=$user->last;
	$username=$user->username;
	echo "<body style='background-color:black;'><div style='margin:auto;width:40%'><p style='color:green;border-bottom:2px rgb(2, 158, 201) solid;font-family:Arial, Helvetica, sans-serif;'>" . 
	"<span style='color:white;'>Name: " . $first . " " . $last . "<br>" .
	"Username: " . $username . "</span></p></div></body>";
}
?>