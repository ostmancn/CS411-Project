<?php
	require_once("../dashboard_loaders/query_objects/Group.php");

	$groupname = $_POST['groupname'];
	$start_money = intval($_POST['startmoney']);
	$password = $_POST['password'];

	$portfolio = $_POST['portfolio'];
 	$username = $_COOKIE["wolf_of_siebel_username"];

 	$user_object = User::get_user_object($username);
 	$new_group = new Group($groupname, $start_money, $username, $password);
	if ($user_object->join_group($new_group->GID, $portfolio, $password)) {
    }
?>