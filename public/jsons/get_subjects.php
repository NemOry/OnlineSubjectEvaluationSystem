<?php

require_once("../../includes/initialize.php");

if(isset($_GET['course_id']) && isset($_GET['year']) && isset($_GET['semester'])){

	$course_id 	= $_GET['course_id'];
	$year 		= $_GET['year'];
	$semester 	= $_GET['semester'];

	$rows = mysql_query("SELECT * FROM ".T_SUBJECTS." WHERE ".C_SUBJECT_COURSE_ID."=".$course_id." AND ".C_SUBJECT_YEAR."=".$year." AND ".C_SUBJECT_SEMESTER."=".$semester);

}else{
	$rows = mysql_query("SELECT * FROM ".T_SUBJECTS);
}

$subjects = array();

$o = new StdClass;

while($row = mysql_fetch_array($rows)){
	$o->code = $row['code'];
	array_push($subjects, $o);
}

echo json_encode($subjects);
?>