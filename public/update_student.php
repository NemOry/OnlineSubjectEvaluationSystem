<?php
require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$course_id = Course::get_by_sql("SELECT * FROM ".T_COURSES." WHERE ".C_COURSE_CODE."='".trim($_POST['course_code'])."'")[0]->id;

if($_POST['oper']=='add'){

	$student = new Student();
	$student->student_id 		= $_POST['student_id'];
	$student->password 			= $_POST['password'];
	$student->first_name 		= $_POST['first_name'];
	$student->middle_name 		= $_POST['middle_name'];
	$student->last_name 		= $_POST['last_name'];
	$student->course_id 		= $course_id;
	$student->semester 			= $_POST['semester'];
	$student->year 				= $_POST['year'];
	$student->create();

}else if($_POST['oper']=='edit'){

	$student 					= Student::get_by_id($_POST['id']);
	$student->student_id 		= $_POST['student_id'];
	$student->password 			= $_POST['password'];
	$student->first_name 		= $_POST['first_name'];
	$student->middle_name 		= $_POST['middle_name'];
	$student->last_name 		= $_POST['last_name'];
	$student->course_id 		= $course_id;
	$student->semester 			= $_POST['semester'];
	$student->year 				= $_POST['year'];
	$student->update();

}else if($_POST['oper']=='del'){
	Student::get_by_id($_POST['id'])->delete();
}

?>