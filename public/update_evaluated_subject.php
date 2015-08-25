<?php

require_once("../includes/initialize.php");

$student_id = $_GET['student_id'];

$subject_ids2 = $_POST['subject_ids2'];

$message = "success";

foreach ($subject_ids2 as $id) 
{
	$subject_id = EvaluatedSubject::get_by_id($id)->subject_id;

	$newgrade = Grade::get_by_subj_stud($subject_id, $student_id);
	
	if($newgrade != null)
	{
		$newgrade->delete();
	}

	$object = EvaluatedSubject::get_by_id($id);

	if($object != null)
	{
		$object->delete();
	}
}

echo $message;

?>