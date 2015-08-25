<?php

require_once '../Classes/PHPExcel.php';

require_once("../includes/initialize.php");

if ($_FILES["file"]["error"] > 0)
{
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
}
else
{
	// FILE
	$inputFileName 	= $_FILES["file"]["name"];
	$inputFileType 	= PHPExcel_IOFactory::identify($inputFileName);
	$objReader 		= PHPExcel_IOFactory::createReader($inputFileType);
	$objPHPExcel 	= $objReader->load($inputFileName);
	$objPHPExcel->setActiveSheetIndex(0);
	$objWorksheet = $objPHPExcel->getActiveSheet();
	$highestRow = $objWorksheet->getHighestRow();

	// COLUMNS
	$SUBJECT 	= 0;
	$STUDENT_ID = 1;
	$NAME 		= 2;
	$GRADE 		= 3;

	//SUBJECT
	$subject_code = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, 2)->getValue();
	$subject = Subject::get_by_sql("SELECT * FROM tbl_subjects WHERE code = '".$subject_code."'")[0];

	if($subject)
	{
		$subject_id = Subject::get_by_sql("SELECT * FROM tbl_subjects WHERE code = '".$subject_code."'")[0]->id;

		for($row = 2; $row <= $highestRow; $row++)
		{
			$student_id = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($STUDENT_ID, $row)->getValue();
			$grade 		= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($GRADE, $row)->getValue();
			$student 	= Student::get_by_id($student_id);

			if($student)
			{
				$grades = Grade::get_by_sql("SELECT * FROM tbl_student_grades WHERE subject_id = '".$subject_id."' AND student_id = ".$student_id)[0];
				
				if($grades)
				{
					$grades->grade = $grade;
					$grades->update();
				}
				else
				{
					$newgrades = new Grade();
					$newgrades->grade = $grade;
					$newgrades->student_id = $student_id;
					$newgrades->subject_id = $subject_id;
					$newgrades->create();
				}
				
			}
		}
	}
	else
	{
		echo "*********SUBJECT CODE NOT FOUND*********";
	}
}

?>