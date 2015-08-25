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
 
$count = count(Student::get_by_sql("SELECT * FROM " . T_STUDENTS));

if( $count > 0 && $limit > 0) { 
	$total_pages = ceil($count / $limit); 
} else { 
	$total_pages = 0; 
} 
 
if ($page > $total_pages) $page = $total_pages;
 
$start = $limit * $page - $limit;
 
if($start <0) $start = 0; 
if(!$sidx) $sidx = 1;

$students = Student::get_by_sql("SELECT * FROM " . T_STUDENTS . " ORDER BY $sidx $sord LIMIT $start , $limit");

if(isset($_GET['searchString']) && isset($_GET['searchField'])){

    $searchString = $_GET['searchString'];
    $searchField = $_GET['searchField'];

    $students = Student::get_by_sql("SELECT * FROM " . T_STUDENTS . " WHERE ".$searchField." LIKE '%".$searchString."%' ORDER BY $sidx $sord LIMIT $start , $limit");

}else{
    $students = Student::get_by_sql("SELECT * FROM " . T_STUDENTS . " ORDER BY $sidx $sord LIMIT $start , $limit");
}

header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
foreach($students as $student) {
    $s .= "<row id='". $student->id."'>";
     $s .= "<cell></cell>"; 
    $s .= "<cell>". $student->id."</cell>";        
    $s .= "<cell>". $student->student_id."</cell>";          
    $s .= "<cell>". $student->password."</cell>";
    $s .= "<cell>". $student->first_name."</cell>";
    $s .= "<cell>". $student->middle_name."</cell>";
    $s .= "<cell>". $student->last_name."</cell>";
    $s .= "<cell>". Course::get_by_id($student->course_id)->code."</cell>";
    $s .= "<cell>". $student->semester."</cell>";
    $s .= "<cell>". $student->year."</cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
 
echo $s;
?>