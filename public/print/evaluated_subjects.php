<style>

    table{
        width: 100%;
    }

    td{
        border-bottom: 1px solid black;
    }

</style>

<?php

require_once("../../includes/initialize.php");

$student_id     = $_GET['student_id'];
$date           = $_GET['date'];

$eval_subjects = EvaluatedSubject::get_by_sql("SELECT * FROM ".T_EVALUATED_SUBJECTS." WHERE ".C_EVALUATED_STUDENT_ID."=".$student_id." AND date = '".$date."'");

$s = "<table>";
$s .= "<tr>";
$s .= "<td>CODE</td>";
$s .= "<td>DESCRIPTION</td>";
$s .= "<td>UNITS</td>";
$s .= "<td>PREREQUISITE</td>";
$s .= "<td>COURSE</td>";
$s .= "<td>YEAR</td>";
$s .= "<td>SEMESTER</td>";
$s .= "<td>DATE EVALUATED</td>";
$s .= "</tr>";

foreach($eval_subjects as $eval_subject) {

    $subject = Subject::get_by_id($eval_subject->subject_id);

    $s .= "<tr>"; 
    $s .= "<td>". $subject->code."</td>";       
    $s .= "<td>". $subject->description."</td>";
    $s .= "<td>". $subject->units."</td>";
    $subject_code = ($subject->prereq_subject_id == 0) ? "NONE" : Subject::get_by_id($subject->prereq_subject_id)->code;
    $s .= "<td>". $subject_code."</td>";
    $s .= "<td>". Course::get_by_id($subject->course_id)->code."</td>";
    $s .= "<td>". $subject->year."</td>";
    $s .= "<td>". $subject->semester."</td>";
    $s .= "<td>". $eval_subject->date."</td>";
    $s .= "</tr>";
}

$s .= "</table>"; 
 
echo $s;

?>