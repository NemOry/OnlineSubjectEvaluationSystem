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
 
$count = count(Message::get_by_sql("SELECT * FROM " . T_MESSAGES));

if( $count > 0 && $limit > 0) { 
	$total_pages = ceil($count / $limit); 
} else { 
	$total_pages = 0; 
}
 
if ($page > $total_pages) $page = $total_pages;
 
$start = $limit * $page - $limit;
 
if($start <0) $start = 0;
if(!$sidx) $sidx = 1;

$messages = Message::get_by_sql("SELECT * FROM " . T_MESSAGES . " ORDER BY $sidx $sord LIMIT $start , $limit");

header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
foreach($messages as $message) {
    $s .= "<row id='". $message->id."'>";
     $s .= "<cell></cell>"; 
    $s .= "<cell>". $message->id."</cell>";        
    $s .= "<cell>". $message->message."</cell>";       
    $s .= "<cell>". Student::get_by_id($message->student_id)->student_id."</cell>";
    $s .= "</row>";
}
$s .= "</rows>"; 
 
echo $s;
?>