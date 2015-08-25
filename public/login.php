<?php

require_once("../includes/initialize.php");

if(isset($_POST)){
	$username = htmlentities(trim($_POST['login_username']));
	$password = htmlentities(trim($_POST['login_password']));
	$found_user = User::login($username, $password);
	if($found_user){
		$session->login($found_user);
		echo "success";
	}else{
		echo "Username or Password is incorrect.";
	}
}

?>