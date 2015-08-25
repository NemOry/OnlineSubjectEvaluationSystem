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
 
$count = count(User::get_by_sql("SELECT * FROM " . T_USERS));

if( $count > 0 && $limit > 0) { 
	$total_pages = ceil($count / $limit); 
} else { 
	$total_pages = 0; 
} 
 
if ($page > $total_pages) $page = $total_pages;
 
$start = $limit * $page - $limit;
 
if($start <0) $start = 0; 
if(!$sidx) $sidx = 1;

$users = User::get_by_sql("SELECT * FROM " . T_USERS . " ORDER BY $sidx $sord LIMIT $start , $limit");

if(isset($_GET['searchString']) && isset($_GET['searchField'])){

    $searchString = $_GET['searchString'];
    $searchField = $_GET['searchField'];

    $users = User::get_by_sql("SELECT * FROM " . T_USERS . " WHERE ".$searchField." LIKE '%".$searchString."%' ORDER BY $sidx $sord LIMIT $start , $limit");

}else{
    $users = User::get_by_sql("SELECT * FROM " . T_USERS . " ORDER BY $sidx $sord LIMIT $start , $limit");
}

header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
 
foreach($users as $user) 
{
    $userlevel = "";

    switch ($user->level) {
        case 0:
            $userlevel = "ADMIN";
            break;
        
        case 1:
            $userlevel = "EVALUATOR";
            break;

        case 2:
            $userlevel = "TEACHER";
            break;
    }

    $s .= "<row id='". $user->id."'>";
    $s .= "<cell></cell>"; 
    $s .= "<cell>". $user->id."</cell>";        
    $s .= "<cell>". $user->name."</cell>";       
    $s .= "<cell>". $user->username."</cell>";
    $s .= "<cell>". $user->password."</cell>";
    $s .= "<cell>". $userlevel."</cell>";
    $s .= "</row>";
}

$s .= "</rows>"; 
 
echo $s;
?>