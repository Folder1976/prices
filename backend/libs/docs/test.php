<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once 'PHPExcel.php';
$objPHPExcel = PHPExcel_IOFactory::load("tov_nakl-249.xls");

$objPHPExcel->getActiveSheet()->setCellValue('AF28', "255")
                              ->setCellValue('AK28', date("d.m.Y H:i:s"))
                              ->setCellValue('H57', date("d.m.Y H:i:s"));
$c = 34;
for ($i=0; $i<6; $i++) {
	$n = $c + $i;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($n, 1);

	$objPHPExcel->getActiveSheet()->mergeCells('A'.$n.':C'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('D'.$n.':P'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('R'.$n.':T'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('U'.$n.':W'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('X'.$n.':Z'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('AA'.$n.':AC'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('AD'.$n.':AF'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('AG'.$n.':AH'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('AI'.$n.':AK'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('AL'.$n.':AN'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('AO'.$n.':AQ'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('AR'.$n.':AT'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('AU'.$n.':AW'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('AX'.$n.':BA'.$n);
	$objPHPExcel->getActiveSheet()->mergeCells('BB'.$n.':BE'.$n);

}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="test.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');




?>