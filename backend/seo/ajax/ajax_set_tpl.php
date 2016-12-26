<?php

include('../../../config.php');
include('../../config.php');

$pp = DB_PREFIX;
	
    $target = '';
	if(isset($_POST['target'])) $target = $_POST['target'];
	
	$value = '';
	if(isset($_POST['value'])) $value = $_POST['value'];
	
    echo $target;
	//die();
	switch ($target) {
	case 'domain_text1':
		
		$sql1 = 'UPDATE ' . DB_PREFIX . 'category_description_domain SET description = "'.$value.'"';
		$sql2 = 'UPDATE ' . DB_PREFIX . 'alias_description_domain SET text2 = "'.$value.'"';
		
		break;
	case 'title':
		
		$sql1 = 'UPDATE ' . DB_PREFIX . 'category_description SET meta_title = "'.$value.'"';
		$sql2 = 'UPDATE ' . DB_PREFIX . 'alias_description SET title = "'.$value.'"';
		
		break;
	case 'title_h1':
		
		$sql1 = 'UPDATE ' . DB_PREFIX . 'category_description SET title_h1 = "'.$value.'"';
		$sql2 = 'UPDATE ' . DB_PREFIX . 'alias_description SET title_h1 = "'.$value.'"';
		
		break;
	case 'meta_keywords':
		
		$sql1 = 'UPDATE ' . DB_PREFIX . 'category_description SET meta_keyword = "'.$value.'"';
		$sql2 = '';
		
		break;
	case 'title_h1':
		
		$sql1 = 'UPDATE ' . DB_PREFIX . 'category_description SET title_h1 = "'.$value.'"';
		$sql2 = 'UPDATE ' . DB_PREFIX . 'alias_description SET title_h1 = "'.$value.'"';
		
		break;

	case 'meta_description':
		
		$sql1 = 'UPDATE ' . DB_PREFIX . 'category_description SET meta_description = "'.$value.'"';
		$sql2 = 'UPDATE ' . DB_PREFIX . 'alias_description SET text1 = "'.$value.'"';
		
		break;

	case 'domain_title_h1':
		
		$sql1 = 'UPDATE ' . DB_PREFIX . 'category_description_domain SET title_h1 = "'.$value.'"';
		$sql2 = 'UPDATE ' . DB_PREFIX . 'alias_description_domain SET title_h1 = "'.$value.'"';
		
		break;

	case 'domain_title':
		
		$sql1 = 'UPDATE ' . DB_PREFIX . 'category_description_domain SET meta_title = "'.$value.'"';
		$sql2 = 'UPDATE ' . DB_PREFIX . 'alias_description_domain SET title = "'.$value.'"';
		
		break;

	case 'domain_meta_keywords':
		
		$sql1 = 'UPDATE ' . DB_PREFIX . 'category_description_domain SET meta_keyword = "'.$value.'"';
		$sql2 = '';
			
		break;

	case 'domain_meta_description':
		
		$sql1 = 'UPDATE ' . DB_PREFIX . 'category_description_domain SET meta_description = "'.$value.'"';
		$sql2 = 'UPDATE ' . DB_PREFIX . 'alias_description_domain SET text1 = "'.$value.'"';
		
		break;

	}
	
	
	if(isset($sql1) AND $sql1 != '') $mysqli->query($sql1) or die('Не удалось удалить сео '.$sql1);
	if(isset($sql2) AND $sql2 != '') $mysqli->query($sql2) or die('Не удалось удалить сео '.$sql2);
	echo $sql1;
	echo $sql2;
	

?>