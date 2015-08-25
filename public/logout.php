<?php 

require_once("../includes/initialize.php");

global $session;

if($session->is_logged_in()){
	$session->logout();	
}

redirect_to("index.php");

?>