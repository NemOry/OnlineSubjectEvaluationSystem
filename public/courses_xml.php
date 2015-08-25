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
 
$count = count(Course::get_by_sql("SELECT * FROM " . T_COURSES));

if( $count > 0 && $limit > 0) { 
	$total_pages = ceil($count / $limit); 
} else { 
	$total_pages = 0; 
} 
 
if ($page > $total_pages) $page = $total_pages;
 
$start = $limit * $page - $limit;
 
if($start <0) $start = 0; 
if(!$sidx) $sidx = 1;

$courses = Course::get_by_sql("SELECT * FROM " . T_COURSES . " ORDER BY $sidx $sord LIMIT $start , $limit");

if(isset($_GET['searchString']) && isset($_GET['searchField'])){

    $searchString = $_GET['searchString'];
    $searchField = $_GET['searchField'];

    $courses = Course::get_by_sql("SELECT * FROM " . T_COURSES . " WHERE ".$searchField." LIKE '%".$searchString."%' ORDER BY $sidx $sord LIMIT $start , $limit");

}else{
    $courses = Course::get_by_sql("SELECT * FROM " . T_COURSES . " ORDER BY $sidx $sord LIMIT $start , $limit");
}

header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
foreach($courses as $course) {
    $s .= "<row id='". $course->id."'>";
     $s .= "<cell></cell>"; 
    $s .= "<cell>". $course->id."</cell>";        
    $s .= "<cell>". $course->code."</cell>";       
    $s .= "<cell>". $course->description."</cell>";
    $s .= "<cell>". Curriculum::get_by_id($course->curriculum_id)->curriculum."</cell>";
    $s .= "<cell>". $course->curriculum_id."</cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
 
echo $s;
?>