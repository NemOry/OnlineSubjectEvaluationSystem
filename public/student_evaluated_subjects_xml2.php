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

$count = count(EvaluatedSubject::get_by_sql("SELECT * FROM " . T_EVALUATED_SUBJECTS. " WHERE ".C_EVALUATED_STUDENT_ID."=".$student->id));

if( $count > 0 && $limit > 0) { 
    $total_pages = ceil($count / $limit); 
} else {
    $total_pages = 0;
}
 
if ($page > $total_pages) $page = $total_pages;
 
$start = $limit * $page - $limit;
 
if($start <0) $start = 0;
if(!$sidx) $sidx = 1;

$eval_subjects = EvaluatedSubject::get_by_sql("SELECT * FROM " . T_EVALUATED_SUBJECTS . " WHERE ".C_EVALUATED_STUDENT_ID."=".$student->id." ORDER BY $sidx $sord LIMIT $start , $limit");

header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
foreach($eval_subjects as $eval_subject) {

    $final_subject = Subject::get_by_id($eval_subject->subject_id);

    $s .= "<row id='". $eval_subject->id."'>";
    $s .= "<cell>". $final_subject->id."</cell>";        
    $s .= "<cell>". $final_subject->code."</cell>";       
    $s .= "<cell>". $final_subject->description."</cell>";
    $s .= "<cell>". $final_subject->units."</cell>";
    $subject_code = ($final_subject->prereq_subject_id == 0) ? "NONE" : Subject::get_by_id($final_subject->prereq_subject_id)->code;
    $s .= "<cell>". $subject_code."</cell>";
    $s .= "<cell>". Course::get_by_id($final_subject->course_id)->code."</cell>";
    $s .= "<cell>". $final_subject->semester."</cell>";
    $s .= "<cell>". $final_subject->year."</cell>";
    $s .= "<cell>". $eval_subject->date."</cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
 
echo $s;
?>