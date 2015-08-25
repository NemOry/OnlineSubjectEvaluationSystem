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

$students = Student::get_by_sql("SELECT * FROM " . T_STUDENTS);


$s = "<table>";
$s .= "<tr>";
$s .= "<td>ID</td>";
$s .= "<td>FIRST NAME</td>";
$s .= "<td>MIDDLE NAME</td>";
$s .= "<td>LAST NAME</td>";
$s .= "<td>COURSE</td>";
$s .= "<td>SEMESTER</td>";
$s .= "<td>YEAR</td>";
$s .= "</tr>";

foreach($students as $student) {
    $s .= "<tr>";
    $s .= "<td>". $student->student_id."</td>";          
    $s .= "<td>". $student->first_name."</td>";
    $s .= "<td>". $student->middle_name."</td>";
    $s .= "<td>". $student->last_name."</td>";
    $s .= "<td>". Course::get_by_id($student->course_id)->code."</td>";
    $s .= "<td>". $student->semester."</td>";
    $s .= "<td>". $student->year."</td>";
    $s .= "</tr>";
}
$s .= "</table>"; 
 
echo $s;
?>