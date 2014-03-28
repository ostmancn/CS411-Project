<?php
	$username = $_POST['username'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	$email = $_POST['email'];
	$name = $_POST['name'];

	if (strcmp($password, $repassword) != 0)
		echo "Password Mismatch";

	//TODO check lengh of input make sure its shorter than 20char

	$con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
    if (mysqli_connect_errno($con))
        echo "Failed to connect to MySQL: " , mysqli_connect_error();
    
    $stmt = mysqli_prepare($con, "INSERT INTO  Users (name, userName, password, email) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $name, $username, $password, $email);

    if (!mysqli_stmt_execute($stmt)) {
    	echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        setcookie("wolf_of_siebel_username", $username, time()+3600, "/");
        setcookie("wolf_of_siebel_password", $password, time()+3600, "/");
        setcookie("wolf_of_siebel_name", $name, time()+3600, "/");
    }
?>