<?php
function doDB() {
	global $mysqli;

	//connect to server and select database; you may need it
	//$mysqli = mysqli_connect("localhost", "root", "", "devforum");
	$mysqli = mysqli_connect("localhost", "lisabalbach_kavana7", "CIT200108", "lisabalbach_kavana7");
	
	//if connection fails, stop script execution
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
}
?>