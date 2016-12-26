<?php
include('../../config.php');
include('../config.php');
$pp = DB_PREFIX;

//Если все прилетело и есть массив с иД-шками товаров - работаем
$res = $mysqli->query('SELECT * FROM '.DB_PREFIX.'redirect ORDER BY url_from');;

require_once ('../libs/docs/PHPExcel/IOFactory.php');

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Fashion")
	 ->setLastModifiedBy("Fashion")
	 ->setTitle("Fashion")
	 ->setSubject("Fashion")
	 ->setDescription("Fashion");

$objPHPExcel->setActiveSheetIndex(0);
/*
$objPHPExcel->getActiveSheet()
	->setTitle('Sheet1')
	->setCellValue('A1', "code")
	->setCellValue('B1', "model")
	->setCellValue('C1', "on_ware")
	->setCellValue('D1', "parent")
	->setCellValue('E1', "group")
	->setCellValue('F1', "name")
	->setCellValue('G1', "brand")
	->setCellValue('H1', "price2")
	->setCellValue('I1', "currency")
	->setCellValue('J1', "dimm")
	->setCellValue('K1', "photo")
	->setCellValue('L1', "video")
	->setCellValue('M1', "size")
	->setCellValue('N1', "memo");
*/

//Ширина колонок
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);

// Пишем основные данные
$L = 1;
while($row = $res->fetch_assoc()){
   
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$L, $row['url_from'], PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$L, $row['url_to'], PHPExcel_Cell_DataType::TYPE_STRING);
                
    $L += 1;
}

//Данные
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('../tmp/fashion_redirects.xls');


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="fashion_redirects.xls');
header('Cache-Control: max-age=0');
readfile('../tmp/fashion_redirects.xls');
unlink('../tmp/fashion_redirects.xls');

?>