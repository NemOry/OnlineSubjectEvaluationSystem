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

$student_id = $_GET['student_id'];

$student = Student::get_by_id($student_id);

$count = count(Grade::get_by_sql("SELECT * FROM " . T_STUDENT_GRADES));

if( $count > 0 && $limit > 0) { 
    $total_pages = ceil($count / $limit); 
} else { 
    $total_pages = 0; 
} 
 
if ($page > $total_pages) $page = $total_pages;
 
$start = $limit * $page - $limit;
 
if($start <0) $start = 0; 
if(!$sidx) $sidx = 1;

$grades = Grade::get_by_sql("SELECT * FROM " . T_STUDENT_GRADES . " WHERE ".C_GRADE_STUDENT_ID." = ".$student_id." ORDER BY $sidx $sord LIMIT $start , $limit");

header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
foreach($grades as $grade) {

    if(Subject::get_by_id($grade->subject_id)->course_id != $student->course_id){
        continue;
    }

    if(Subject::get_by_id($grade->subject_id)->semester != $student->semester){
        //continue;
    }

    $s .= "<row id='". $grade->id."'>";
    $s .= "<cell>". $grade->id."</cell>";
    $s .= "<cell>". Subject::get_by_id($grade->subject_id)->code."</cell>";
    $s .= "<cell>". Subject::get_by_id($grade->subject_id)->description."</cell>";
    $s .= "<cell>". $grade->grade."</cell>";
    $s .= "<cell>". Subject::get_by_id($grade->subject_id)->units."</cell>";
    $s .= "<cell>". Subject::get_by_id($grade->subject_id)->year."</cell>";
    
    if($grade->grade >= 75){
        $remarks = "PASSED";
    }else{
        $remarks = "FAILED";
    }

    $s .= "<cell>". $remarks."</cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
 
echo $s;
?>