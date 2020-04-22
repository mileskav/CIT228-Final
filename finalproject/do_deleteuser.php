<?php
    //$mysqli = mysqli_connect("localhost", "root", "", "devforum");
    $mysqli = mysqli_connect("localhost","lisabalbach_kavana7","CIT200108","lisabalbach_kavana7");
    
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    } else {
        $clean_username= mysqli_real_escape_string($mysqli, $_POST['username']);
        $clean_password = mysqli_real_escape_string($mysqli, $_POST['password']);
        $clean_username =test_input($clean_username);
        $clean_password = test_input($clean_password);

        $sql = "DELETE FROM auth_users WHERE username='".$clean_username."' AND password='".$clean_password."'";
        $res = mysqli_query($mysqli, $sql);
        if ($res === TRUE) {
            $display_block = "<p>The user <strong>".$_POST["username"]."</strong> has been deleted.</p>
            <form>
            <input type='button' name='login' id='login' value='Login' onclick='location.href=\"userlogin.html\"'>
            </form>";
        } else {
            $display_block = printf("<p>Could not delete user: %s\n</p>", mysqli_error($mysqli));
        }
        mysqli_close($mysqli);
        }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

//create nice message for user

include 'BeginNav.php';
echo $display_block;
include 'EndNav.php';
?>