<?php
	//connect to server and select database; you may need it
	//$mysqli = mysqli_connect("localhost", "root", "", "devforum");
	$mysqli = mysqli_connect("localhost:3306", "lisabalbach_kavana7", "CIT200108", "lisabalbach_kavana7");

	//if connection fails, stop script execution
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	$get_auth_users = "SELECT f_name, l_name, username FROM auth_users";
	$get_auth_res = mysqli_query($mysqli, $get_auth_users) or die(mysqli_error($mysqli));

	$xml = "<userList>";
	while($r = mysqli_fetch_array($get_auth_res)){
	 $xml .= "<user>";
	 $xml .= "<first>".$r['f_name']."</first>";  
 	 $xml .= "<last>".$r['l_name']."</last>";
	 $xml .= "<username>".$r['username']."</username>";  
	 $xml .= "</user>";
	}
$xml .= "</userList>";
$sxe = new SimpleXMLElement($xml);
$sxe->asXML("users.xml");
echo "<h2>users.xml has been created</h2>";
echo "<p><a href='viewUsers.php'>[View User List]</a>";
?>