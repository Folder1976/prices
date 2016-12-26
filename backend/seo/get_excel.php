<?php
header ('Content-Type: text/html; charset=utf8');
include('../../config.php');
include('../config.php');

$pp = DB_PREFIX;

//Закрыли экспорт из категории
$sql = 'SELECT 	category_id as id,
				name,
				name_sush,
				name_rod,
				name_several,
				keyword AS url
                FROM '.DB_PREFIX.'category_description
                LEFT JOIN '.DB_PREFIX.'url_alias ON query = CONCAT("category_id=", category_id)
			    ORDER BY name ASC
				;';
$categories = $mysqli->query($sql) or die($sql);

$sql = 'SELECT 	id,
				name,
				name_sush,
				name_rod,
				name_several,
				url
                FROM '.DB_PREFIX.'alias_description
                ORDER BY name ASC;';
$filters = $mysqli->query($sql) or die($sql);

$alias = array();

$all = array();

while($row = $filters->fetch_assoc()){
	$all[$row['id']]['id'] = $row['id'];
	$all[$row['id']]['name'] = $row['name'];
	$all[$row['id']]['name_sush'] = $row['name_sush'];
	$all[$row['id']]['name_rod'] = $row['name_rod'];
	$all[$row['id']]['name_several'] = $row['name_several'];
	$all[$row['id']]['url'] = $row['url'];
	$all[$row['id']]['type'] = 'filter';
	$alias[$row['url']] = '1';
}

//Недостающие алиасы (фильтры+категории)
$sql = 'SELECT 	CD.category_id,
				CD.name AS category_name,
				A.keyword AS category_url,
				AT.attribute_id,
				AT.filter_name AS attribute_url,
				ATD.name AS attribute_name
				FROM '.DB_PREFIX.'category_to_attribute C2A
                LEFT JOIN '.DB_PREFIX.'attribute AT ON AT.attribute_id = C2A.attribute_id
                LEFT JOIN '.DB_PREFIX.'attribute_description ATD ON AT.attribute_id = ATD.attribute_id
                LEFT JOIN '.DB_PREFIX.'category_description CD ON CD.category_id = C2A.category_id
                LEFT JOIN '.DB_PREFIX.'url_alias A ON A.query = CONCAT("category_id=", CD.category_id)
                ORDER BY CD.name ASC;';
$r = $mysqli->query($sql) or die($sql);

$count = 1;
while($row = $r->fetch_assoc()){
	
	$alias_tmp = $row['attribute_url'].'-'.$row['category_url'];
	
	if($row['attribute_url'] AND $row['category_url']){
	
		if(!isset($alias[$alias_tmp])){
			
			$all['new'.$count]['id'] = '';
			$all['new'.$count]['name'] = $row['category_name'].'-'.$row['attribute_name'];
			$all['new'.$count]['name_sush'] = '';
			$all['new'.$count]['name_rod'] = '';
			$all['new'.$count]['name_several'] = '';
			$all['new'.$count]['url'] = $alias_tmp;
			$all['new'.$count]['type'] = 'filter';
			$count++;
		}
	}
	
}

//Недостающие категории
while($row = $categories->fetch_assoc()){
	
	if(!isset($alias[$row['url']])){
	
		$all[$row['id']]['id'] = '';//$row['id'];
		$all[$row['id']]['name'] = $row['name'];
		$all[$row['id']]['name_sush'] = $row['name_sush'];
		$all[$row['id']]['name_rod'] = $row['name_rod'];
		$all[$row['id']]['name_several'] = $row['name_several'];
		$all[$row['id']]['url'] = $row['url'];
		$all[$row['id']]['type'] = 'filter';//'category';
		$alias[$row['url']] = '1';
	}
}

require_once ('../libs/docs/PHPExcel/IOFactory.php');

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Fashion")
	 ->setLastModifiedBy("Fashion")
	 ->setTitle("Fashion")
	 ->setSubject("Fashion")
	 ->setDescription("Fashion");

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()
	->setTitle('Sheet1')
	->setCellValue('A1', "type")
	->setCellValue('B1', "id")
	->setCellValue('C1', "name")
	->setCellValue('D1', "url")
	->setCellValue('E1', "block_name")
	->setCellValue('F1', "block_name_rod")
	->setCellValue('G1', "block_name_several");

$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);


// Пишем основные данные
$L = 2;
foreach($all as $row){
   
	//$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$L, $Product['id'], PHPExcel_Cell_DataType::TYPE_STRING);
	//$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$L, $Product['model'], PHPExcel_Cell_DataType::TYPE_STRING);
	
    $objPHPExcel->getActiveSheet()
	            ->setCellValue('A'.$L, $row["type"])
                ->setCellValue('B'.$L, $row["id"])
                ->setCellValue('C'.$L, $row["name"])
                ->setCellValue('D'.$L, $row["url"])
                ->setCellValue('E'.$L, $row["name_sush"])
                ->setCellValue('F'.$L, $row["name_rod"])
                ->setCellValue('G'.$L, $row["name_several"]);
	$L++;
}

//Данные

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('../tmp/Fashion-tags.xls');


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Fashion-tags.xls');
header('Cache-Control: max-age=0');
readfile('../tmp/Fashion-tags.xls');
unlink('../tmp/Fashion-tags.xls');

?>