<?php
require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

if($_POST['oper']=='add'){

	$course = new Course();
	$course->code 			= $_POST['code'];
	$course->description 	= $_POST['description'];
	$course->curriculum_id 	= $_POST['curriculum_id'];
	$course->create();

}else if($_POST['oper']=='edit'){

	$course 				= Course::get_by_id($_POST['id']);
	$course->code 			= $_POST['code'];
	$course->description 	= $_POST['description'];
	$course->curriculum_id 	= $_POST['curriculum_id'];
	$course->update();
	
}else if($_POST['oper']=='del'){
	Course::get_by_id($_POST['id'])->delete();
}

?>