<?php

require_once 'Classes/PHPExcel.php';

$inputFileName = 'grades.xls';
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($inputFileName);

$test = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, 2)->getValue();

echo $test;

?>