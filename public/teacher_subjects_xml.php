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
 
$count = count(TeacherSubject::get_by_sql("SELECT * FROM " . T_TEACHER_SUBJECTS));

if( $count > 0 && $limit > 0) { 
	$total_pages = ceil($count / $limit); 
} else { 
	$total_pages = 0; 
} 
 
if ($page > $total_pages) $page = $total_pages;
 
$start = $limit * $page - $limit;
 
if($start <0) $start = 0; 
if(!$sidx) $sidx = 1;

$TeacherSubjects = TeacherSubject::get_by_sql("SELECT * FROM " . T_TEACHER_SUBJECTS . " ORDER BY $sidx $sord LIMIT $start , $limit");

header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
foreach($TeacherSubjects as $TeacherSubject) 
{
    $subject = Subject::get_by_id($TeacherSubject->subject_id);
    $teacher = User::get_by_id($TeacherSubject->teacher_id);

    $s .= "<row id='". $TeacherSubject->id."'>";
    $s .= "<cell></cell>"; 
    $s .= "<cell>". $TeacherSubject->id."</cell>";        
    $s .= "<cell>". $teacher->id."</cell>";       
    $s .= "<cell>". $teacher->name."</cell>";
    $s .= "<cell>". $subject->id."</cell>";
    $s .= "<cell>". $subject->code."</cell>";
    $s .= "<cell>". $subject->description."</cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
 
echo $s;
?>