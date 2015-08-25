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
 
$count = count(EvaluatedSubject::get_by_sql("SELECT * FROM " . T_EVALUATED_SUBJECTS));

if( $count > 0 && $limit > 0) { 
	$total_pages = ceil($count / $limit); 
} else { 
	$total_pages = 0; 
} 
 
if ($page > $total_pages) $page = $total_pages;
 
$start = $limit * $page - $limit;
 
if($start <0) $start = 0; 
if(!$sidx) $sidx = 1;

$result = mysql_query("SELECT DISTINCT ".C_EVALUATED_STUDENT_ID." FROM " . T_EVALUATED_SUBJECTS);

$distinct_ids = array();

while($row = mysql_fetch_array($result)){
  array_push($distinct_ids, $row['student_id']);
}

header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
foreach($distinct_ids as $id) {

    $this_student = Student::get_by_id($id);

    $s .= "<row id='". $this_student->id."'>";
    $s .= "<cell></cell>"; 
    $s .= "<cell>". $this_student->id."</cell>";        
    $s .= "<cell>". $this_student->student_id."</cell>";          
    $s .= "<cell>". $this_student->password."</cell>";
    $s .= "<cell>". $this_student->first_name."</cell>";
    $s .= "<cell>". $this_student->middle_name."</cell>";
    $s .= "<cell>". $this_student->last_name."</cell>";
    $s .= "<cell>". Course::get_by_id($this_student->course_id)->code."</cell>";
    $s .= "<cell>". $this_student->semester."</cell>";
    $s .= "<cell>". $this_student->year."</cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
 
echo $s;
?>