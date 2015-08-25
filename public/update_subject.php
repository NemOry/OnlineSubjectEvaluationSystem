<?php
require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

if($_POST['oper']=='del'){
	Subject::get_by_id($_POST['id'])->delete();
}

if($_POST['prereq_subject_code'] == "NOTHING" || $_POST['prereq_subject_code'] == ""){
	$prereq_subject_id = 0;
}else{
	$prereq_subject_id 	= Subject::get_by_sql("SELECT * FROM ".T_SUBJECTS." WHERE ".C_SUBJECT_CODE."='".trim($_POST['prereq_subject_code'])."'")[0]->id;
}

$course_id = Course::get_by_sql("SELECT * FROM ".T_COURSES." WHERE ".C_COURSE_CODE."='".trim($_POST['course_code'])."'")[0]->id;

$rows = Subject::get_by_sql("SELECT * FROM ".T_SUBJECTS." WHERE ".C_SUBJECT_CODE."='".$_POST['code']."' AND ".C_SUBJECT_COURSE_ID."=".$course_id);

if($_POST['oper']=='add'){

	if(count($rows) > 0){
		die("exists");
	}

	$subject = new Subject();
	$subject->code 				= $_POST['code'];
	$subject->description 		= $_POST['description'];
	$subject->units 			= $_POST['units'];
	$subject->prereq_subject_id = $prereq_subject_id;
	$subject->course_id 		= $course_id;
	$subject->year 				= $_POST['year'];
	$subject->semester 			= $_POST['semester'];
	$subject->curriculum_id 	= $_POST['curriculum_id'];
	$subject->create();

}else if($_POST['oper']=='edit'){

	$subject = Subject::get_by_id($_POST['id']);
	$subject->code 				= $_POST['code'];
	$subject->description 		= $_POST['description'];
	$subject->units 			= $_POST['units'];
	$subject->prereq_subject_id = $prereq_subject_id;
	$subject->course_id 		= $course_id;
	$subject->year 				= $_POST['year'];
	$subject->semester 			= $_POST['semester'];
	$subject->curriculum_id 	= $_POST['curriculum_id'];
	$subject->update();

}

?>