<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$isteacher = false;

if(User::get_by_id($session->user_id)->level == LEVEL_TEACHER)
{
  $isteacher = true;
}

$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];
 
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

if(isset($_GET['searchString']) && isset($_GET['searchField'])){

    $searchString = $_GET['searchString'];
    $searchField = $_GET['searchField'];

    $subjects = Subject::get_by_sql("SELECT * FROM " . T_SUBJECTS . " WHERE ".$searchField." LIKE '%".$searchString."%' ORDER BY $sidx $sord LIMIT $start , $limit");

}else{
    $subjects = Subject::get_by_sql("SELECT * FROM " . T_SUBJECTS . " ORDER BY $sidx $sord LIMIT $start , $limit");
}

if($isteacher)
{
    $subjects = TeacherSubject::get_by_teacher_id($session->user_id);
}

header("Content-type: text/xml;charset=utf-8");
 
$s =  "<?xml version='1.0' encoding='utf-8'?>";
$s .= "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
foreach($subjects as $subjectobject) 
{
    $subject = $subjectobject;

    if($isteacher)
    {
        $subject = Subject::get_by_id($subjectobject->subject_id);
    }

    $s .= "<row id='". $subject->id."'>";
    $s .= "<cell></cell>"; 
    $s .= "<cell>". $subject->id."</cell>";        
    $s .= "<cell>". $subject->code."</cell>";       
    $s .= "<cell>". $subject->description."</cell>";
    $s .= "<cell>". $subject->units."</cell>";
    $subject_code = ($subject->prereq_subject_id == 0) ? "NONE" : Subject::get_by_id($subject->prereq_subject_id)->code;
    $s .= "<cell>". $subject_code."</cell>";
    $s .= "<cell>". Course::get_by_id($subject->course_id)->code."</cell>";
    $s .= "<cell>". $subject->year."</cell>";
    $s .= "<cell>". $subject->semester."</cell>";

    $failed_grades = Grade::get_by_sql("SELECT * FROM ".T_STUDENT_GRADES." WHERE ".C_GRADE_SUBJECT_ID."=".$subject->id." AND grade < 75");

    $s .= "<cell>". count($failed_grades)."</cell>";
    $s .= "<cell>". Curriculum::get_by_id($subject->curriculum_id)->curriculum."</cell>";
    $s .= "<cell>". $subject->curriculum_id."</cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
 
echo $s;
?>