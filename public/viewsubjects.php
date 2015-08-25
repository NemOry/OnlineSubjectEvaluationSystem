<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in())
{
    redirect_to("index.php");
}

$curriculumid = $_GET["curriculumid"];

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8" />
	<title>View Subjects By Curriculum</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>

	<table class="table table-striped">
		<thead>
			<tr>
				<td>CODE</td>
				<td>DESCRIPTION</td>
				<td>UNITS</td>
				<td>PREREQUISITE</td>
				<td>COURSE</td>
				<td>YEAR</td>
				<td>SEMESTER</td>
				<td>CURRICULUM</td>
			</tr>
		</thead>
		<?php

		$subjects = Subject::getByCurriculum($curriculumid);

		if(count($subjects) > 0)
		{
			foreach ($subjects as $subject)
			{
				$course 	= Course::get_by_id($subject->course_id);
				$curriculum = Curriculum::get_by_id($subject->curriculum_id);

				if($subject->prereq_subject_id != "")
				{
					$prerequisitesubject 	= Subject::get_by_id($subject->prereq_subject_id);

					if(!$prerequisitesubject)
					{
						$prerequisitesubject = new Subject();
						$prerequisitesubject->code = "NONE";
					}
				}
				else
				{
					$prerequisitesubject = new Subject();
					$prerequisitesubject->code = "NONE";
				}

				if($subject->semester == 1)
				{
					$subject->semester = "First";
				}
				else if($subject->semester == 2)
				{
					$subject->semester = "Second";
				}

				echo "<tr>";
				echo "	<td>".$subject->code."</td>";
				echo "	<td>".$subject->description."</td>";
				echo "	<td>".$subject->units."</td>";
				echo "	<td>".$prerequisitesubject->code."</td>";
				echo "	<td>".$course->code."</td>";
				echo "	<td>".$subject->year."</td>";
				echo "	<td>".$subject->semester."</td>";
				echo "	<td>".$curriculum->curriculum."</td>";
				echo "</tr>";
			}
		}
		else
		{
			echo "<tr>";
			echo "	<td>NO SUBJECTS</td>";
			echo "</tr>";
		}

		?>
	</table>

</body>
</html>