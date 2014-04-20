<?php
    require_once("../dashboard_loaders/query_objects/Group.php");

	$portfolio = $_POST['portfolio'];
	$password = $_POST['password'];
	$GID = intval($_POST['groupnum']);

    $username = $_COOKIE["wolf_of_siebel_username"];
    echo "|" . $GID . "|";

    $my_user = User::get_user_object($username);
	if ($my_user->join_group($GID, $portfolio, $password)) {
        
    }
?>