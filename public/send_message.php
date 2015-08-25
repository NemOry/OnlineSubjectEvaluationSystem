<?php
require_once("../includes/initialize.php");

$response = "no response";

if(isset($_POST['message'])){

	$message = new Message();
	$message->message 		= $_POST['message'];
	$message->student_id 	= $session->student_id;
	$message->create();

	$response = "success";

}else{
	$response = "error";
}

echo "success";

?>