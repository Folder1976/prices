<?php
header ('Content-Type: text/html; charset=utf8');
include('../../config.php');
include('../config.php');

$pp = DB_PREFIX;

set_time_limit(0);
ini_set("max_execution_time","0");
ini_set("memory_limit","256G");
error_reporting(E_ALL ^ E_DEPRECATED);

if(!isset($_GET['target'])) die('no key');

if($_GET['target'] == 'main'){
$sql = 'SELECT 	*
                FROM '.DB_PREFIX.'alias_description
                ORDER BY name ASC;';
}else{
$sql = 'SELECT 	DD.*, D.url, D.category_id
                FROM '.DB_PREFIX.'alias_description_domain DD
				LEFT JOIN '.DB_PREFIX.'alias_description D ON D.id = DD.id
				
                ORDER BY DD.name ASC;';
}
$r = $mysqli->query($sql) or die($sql);


$all = array();
while($row = $r->fetch_assoc()){
	$all[$row['id']]['id'] = $row['id'];
	$all[$row['id']]['category_id'] = $row['category_id'];
	$all[$row['id']]['name'] = htmlspecialchars_decode($row['name'],ENT_QUOTES);
	$all[$row['id']]['url'] = $row['url'];
	$all[$row['id']]['title'] = htmlspecialchars_decode($row['title'],ENT_QUOTES);
	$all[$row['id']]['title_h1'] = htmlspecialchars_decode($row['title_h1'],ENT_QUOTES);
	$all[$row['id']]['text1'] = htmlspecialchars_decode($row['text1'],ENT_QUOTES);
	$all[$row['id']]['text2'] = htmlspecialchars_decode($row['text2'],ENT_QUOTES);
}

require_once ('../libs/docs/PHPExcel/IOFactory.php');

$objPHPExcel = new PHPExcel();

if($_GET['target'] == 'main'){
	$objPHPExcel->getProperties()->setCreator("Fashion")
		 ->setLastModifiedBy("Fashion")
		 ->setTitle("Fashion_seo")
		 ->setSubject("Fashion_seo")
		 ->setDescription("Fashion_seo");
}else{
	$objPHPExcel->getProperties()->setCreator("Fashion")
		 ->setLastModifiedBy("Fashion")
		 ->setTitle("Fashion_seo_domain")
		 ->setSubject("Fashion_seo_domain")
		 ->setDescription("Fashion_seo_domain");
}

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()
	->setTitle('Sheet1')
	->setCellValue('A1', "id")
	->setCellValue('B1', "category_id")
	->setCellValue('C1', "name")
	->setCellValue('D1', "url")
	->setCellValue('E1', "title")
	->setCellValue('F1', "title_h1")
	->setCellValue('G1', "text1")
	->setCellValue('H1', "text2");

$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(55);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(55);


// Пишем основные данные
$L = 2;
foreach($all as $row){
   
	//$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$L, $Product['id'], PHPExcel_Cell_DataType::TYPE_STRING);
	//$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$L, $Product['model'], PHPExcel_Cell_DataType::TYPE_STRING);
	
    $objPHPExcel->getActiveSheet()
	            ->setCellValue('A'.$L, $row["id"])
                ->setCellValue('B'.$L, $row["category_id"])
                ->setCellValue('C'.$L, $row["name"])
                ->setCellValue('D'.$L, $row["url"])
                ->setCellValue('E'.$L, $row["title"])
                ->setCellValue('F'.$L, $row["title_h1"])
                ->setCellValue('G'.$L, $row["text1"])
                ->setCellValue('H'.$L, $row["text2"]);
	$L++;
}

//Данные
if($_GET['target'] == 'main'){
	$date = '-main-'.date('Y-m-d_H-i-s');
}else{
	$date = '-domain-'.date('Y-m-d_H-i-s');
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('../tmp/Fashion-seo'.$date.'.xls');


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Fashion-seo'.$date.'.xls');
header('Cache-Control: max-age=0');
readfile('../tmp/Fashion-seo'.$date.'.xls');
unlink('../tmp/Fashion-seo'.$date.'.xls');

?>