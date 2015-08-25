<?php

require_once("../includes/initialize.php");

if(isset($_POST)){

	$student_login_student_id = htmlentities(trim($_POST['student_login_student_id']));
	$student_login_password = htmlentities(trim($_POST['student_login_password']));
	$found_student = Student::login($student_login_student_id, $student_login_password);

	if($found_student){

		$session->login($found_student);
		echo "success";

	}else{
		echo "Student ID or Password is incorrect.";
	}
	
}

?>