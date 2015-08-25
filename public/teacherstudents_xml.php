<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$subject_id = $_GET['subject_id'];

$page = $_GET['page'];
$limit = $_GET['rows'];
$sidx = $_GET['sidx'];
$sord = $_GET['sord'];

$where = " WHERE subject_id = ".$subject_id;
 
$count = count(Grade::get_by_sql("SELECT * FROM " . T_STUDENT_GRADES.$where));

if( $count > 0 && $limit > 0) { 
    $total_pages = ceil($count / $limit); 
} else { 
    $total_pages = 0; 
} 
 
if ($page > $total_pages) $page = $total_pages;
 
$start = $limit * $page - $limit;
 
if($start <0) $start = 0; 
if(!$sidx) $sidx = 1;

$grades = Grade::get_by_sql("SELECT * FROM " . T_STUDENT_GRADES.$where. " ORDER BY $sidx $sord LIMIT $start , $limit");

header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
foreach($grades as $grade) 
{
    $student = Student::get_by_id($grade->student_id);

    $s .= "<row id='". $grade->id."'>";
    $s .= "<cell></cell>"; 
    $s .= "<cell>". $grade->id."</cell>";        
    $s .= "<cell>". $grade->grade."</cell>";       
    $s .= "<cell>". $grade->subject_id."</cell>";
    $s .= "<cell>". $student->id."</cell>";
    $s .= "<cell>". $student->get_full_name()."</cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
 
echo $s;
?>