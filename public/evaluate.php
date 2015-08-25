<?php

require_once("../includes/initialize.php");

function has_prerequisite($id, $subjects)
{
	foreach ($subjects as $subject) 
	{
		if($id == $subject->id)
		{
			return true;
		}
	}

	return false;
}

$student_id = $_GET['student_id'];

$subject_ids = $_POST['subject_ids'];

$student_grades = Grade::get_by_sql("SELECT * FROM " . T_STUDENT_GRADES . " WHERE ".C_GRADE_STUDENT_ID."=".$student_id);

$student_subjects = array();

foreach($student_grades as $student_subject) 
{
    array_push($student_subjects, Subject::get_by_id($student_subject->subject_id));
}

$warnings = "";

foreach ($subject_ids as $id) 
{
	$thestudent = Student::get_by_id($student_id);
	$thestudent->semester = Subject::get_by_id($id)->semester;
	$thestudent->update();

	if(Grade::exists($id, $student_id))
	{
		$newgrade = Grade::get_by_subj_stud($id, $student_id);
		$newgrade->delete();
	}
	
	$newgrade = new Grade();
	$newgrade->subject_id = $id;
	$newgrade->student_id = $student_id;
	$newgrade->grade = 0;
	$newgrade->create();

	$pre_subject = Subject::get_by_id($id);

	if(!EvaluatedSubject::exists($id, $student_id))
	{
		$grade = Grade::get_by_subj_stud($pre_subject->id, $student_id);
		$gradepre = Grade::get_by_subj_stud($pre_subject->prereq_subject_id, $student_id);

		if(has_prerequisite($pre_subject->prereq_subject_id, $student_subjects))
		{
			if($gradepre != null)
			{
				if(Grade::get_by_subj_stud($pre_subject->prereq_subject_id, $student_id)->grade <= 74)
				{
					$warnings .= "Cannot add ". $pre_subject->code . " because it's previous subject:". Subject::get_by_id($pre_subject->prereq_subject_id)->code ." is failed\n\n";
				}
				else
				{
					$eval_subject = new EvaluatedSubject();
					$eval_subject->student_id = $student_id;
					$eval_subject->subject_id = $id;
					$eval_subject->create();
				}
			}
		}
		else
		{
			$eval_subject = new EvaluatedSubject();
			$eval_subject->student_id = $student_id;
			$eval_subject->subject_id = $id;
			$eval_subject->create();
		}
	}
}

if($warnings != "")
{
	echo $warnings;
}
else
{
	if(!EvaluatedStudent::exists($student_id))
	{
		$evaluatedstudent = new EvaluatedStudent();
		$evaluatedstudent->student_id = $student_id;
		$evaluatedstudent->create();
	}

	echo "success";
}

?>