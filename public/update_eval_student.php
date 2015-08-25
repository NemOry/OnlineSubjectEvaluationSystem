<?php
require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

if($_POST['oper']=='add'){

	$eval_student = new EvaluatedStudent();
	$eval_student->code 			= $_POST['code'];
	$eval_student->description 	= $_POST['description'];
	$eval_student->year 			= $_POST['year'];
	$eval_student->semester 		= $_POST['semester'];
	$eval_student->create();

}else if($_POST['oper']=='edit'){

	$eval_student = EvaluatedStudent::get_by_id($_POST['id']);
	$eval_student->code 			= $_POST['code'];
	$eval_student->description 	= $_POST['description'];
	$eval_student->year 			= $_POST['year'];
	$eval_student->semester 		= $_POST['semester'];
	$eval_student->update();

}else if($_POST['oper']=='del'){
	EvaluatedStudent::get_by_id($_POST['id'])->delete();
}

?>