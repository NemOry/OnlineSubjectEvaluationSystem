<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in())
{
    redirect_to("index.php");
}

$id 				= $_POST['id'];
$teacher_id 		= $_POST['teacher_id'];
$subject_id 		= $_POST['subject_id'];
$operator 			= $_POST['oper'];

if($operator =='add')
{
	$object 					= new TeacherSubject();
	$object->teacher_id 		= $teacher_id;
	$object->subject_id 		= $subject_id;
	
	if(Subject::get_by_id($object->subject_id) != null && User::get_by_id($object->teacher_id) != null)
	{
		$object->create();
	}
}
else if($operator =='edit')
{
	$object 					= TeacherSubject::get_by_id($id);
	$object->teacher_id 		= $teacher_id;
	$object->subject_id 		= $subject_id;

	if(Subject::get_by_id($object->subject_id) != null && User::get_by_id($object->teacher_id) != null)
	{
		$object->update();
	}
}
else if($operator =='del')
{
	TeacherSubject::get_by_id($id)->delete();
}

?>