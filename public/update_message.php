<?php
require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$id 				= $_POST['id'];
$operator 			= $_POST['oper'];


if($operator =='del'){
	Message::get_by_id($id)->delete();
}

?>