<?php
require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$rows = User::get_by_sql("SELECT * FROM ".T_USERS." WHERE ".C_USER_USERNAME."='".$_POST['username']."'");

if($_POST['oper']=='add'){

	if(count($rows) > 0){
		die("exists");
	}

	$user = new User();
	$user->name 			= $_POST['name'];
	$user->username 		= $_POST['username'];
	$user->password 		= $_POST['password'];
	$user->level 			= $_POST['level'];
	$user->create();

}else if($_POST['oper']=='edit'){
	
	$user = User::get_by_id($_POST['id']);
	$user->name 			= $_POST['name'];
	$user->username 		= $_POST['username'];
	$user->password 		= $_POST['password'];
	$user->level 			= $_POST['level'];
	$user->update();

}else if($_POST['oper']=='del'){

	if($_POST['id'] == $session->user_id){
		die("cannot delete yourself");
	}

	User::get_by_id($_POST['id'])->delete();
}

?>