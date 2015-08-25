<?php
require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$id 				= $_POST['id'];
$subject_id 		= $_POST['subject_id'];
$student_id 		= $_POST['student_id'];
$grades 			= $_POST['grade'];
$operator 			= $_POST['oper'];

if($operator =='add'){

	$rows = Grade::get_by_sql("SELECT * FROM ".T_STUDENT_GRADES." WHERE ".C_GRADE_SUBJECT_ID."=".$subject_id." AND ".C_GRADE_STUDENT_ID."=".$student_id);

	if(count($rows) > 0){
		die("exists");
	}

	$grade 					= new Grade();
	$grade->grade 			= $grades;
	$grade->subject_id 		= $subject_id;
	$grade->student_id 		= $student_id;
	$grade->create();

}else if($operator =='edit'){

	$grade 					= Grade::get_by_id($id);
	$grade->grade 			= $grades;
	$grade->subject_id 		= $subject_id;
	$grade->student_id 		= $student_id;
	$grade->update();

}else if($operator =='del'){
	Grade::get_by_id($id)->delete();
}

?>