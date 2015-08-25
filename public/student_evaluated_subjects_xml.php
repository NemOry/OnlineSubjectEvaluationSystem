<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];

$student = Student::get_by_id($_GET['student_id']);

$count = count(Subject::get_by_sql("SELECT * FROM " . T_SUBJECTS));

if( $count > 0 && $limit > 0) { 

    $total_pages = ceil($count / $limit); 

} else {

    $total_pages = 0;

}
 
if ($page > $total_pages) $page = $total_pages;
 
$start = $limit * $page - $limit;
 
if($start <0) $start = 0;
if(!$sidx) $sidx = 1;

$first = $_GET['first'];

if($first == "true")
{
    $future_sem = 1;
}
else if($first == "2nd")
{
    $future_sem = 2;
}
else
{
    $future_sem = ($student->semester == 1) ? 2 : 1;
}

//$student_subjects = Grade::get_by_sql("SELECT * FROM " . T_STUDENT_GRADES . " WHERE ".C_GRADE_STUDENT_ID."=".$student->id);

$future_subjects = Subject::get_by_sql("SELECT * FROM " . T_SUBJECTS . " WHERE ".C_SUBJECT_COURSE_ID."=".$student->course_id." AND ".C_SUBJECT_SEMESTER." = ".$future_sem." ORDER BY $sidx $sord LIMIT $start , $limit");

// $student_current_subjects = array();

// foreach($student_subjects as $student_subject) 
// {
//     array_push($student_current_subjects, Subject::get_by_id($student_subject->subject_id));
// }

header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";

if(count($future_subjects) > 0)
{
    foreach($future_subjects as $final_subject) 
    {
        $s .= "<row id='". $final_subject->id."'>";
        $s .= "<cell>". $final_subject->id."</cell>";        
        $s .= "<cell>". $final_subject->code."</cell>";       
        $s .= "<cell>". $final_subject->description."</cell>";
        $s .= "<cell>". $final_subject->units."</cell>";
        $subject_code = ($final_subject->prereq_subject_id == 0) ? "NONE" : Subject::get_by_id($final_subject->prereq_subject_id)->code;
        $s .= "<cell>". $subject_code."</cell>";
        $s .= "<cell>". Course::get_by_id($final_subject->course_id)->code."</cell>";
        $s .= "<cell>". $final_subject->semester."</cell>";
        $s .= "<cell>". $final_subject->year."</cell>";
        $s .= "</row>";
    }
}
 


$s .= "</rows>"; 
 
echo $s;
?>