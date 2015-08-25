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

$student = Student::get_by_id($_GET['student_id']);

$grades = Grade::get_by_sql("SELECT * FROM " . T_STUDENT_GRADES . " WHERE ".C_GRADE_STUDENT_ID." = ".$student->id);

$s = "<table>";
$s .= "<tr>";
$s .= "<td>SUBJECT</td>";
$s .= "<td>GRADE</td>";
$s .= "<td>REMARKS</td>";
$s .= "</tr>";

foreach($grades as $grade) {

    $s .= "<tr>";

    if(Subject::get_by_id($grade->subject_id)->course_id != $student->course_id){
        continue;
    }

    if(Subject::get_by_id($grade->subject_id)->semester != $student->semester){
        continue;
    }

    $s .= "<td>". Subject::get_by_id($grade->subject_id)->code."</td>";
    $s .= "<td>". $grade->grade."</td>";
    
    if($grade->grade >= 75){
        $remarks = "PASSED";
    }else{
        $remarks = "FAILED";
    }

    $s .= "<td>". $remarks."</td>";
    $s .= "</tr>";
}

$s .= "</table>"; 
 
echo $s;
?>