<?php
include('../../config.php');
include('../config.php');

$count=0;

  if($_FILES['userfile']['error'][0] != 0)
  {
      switch($_FILES['userfile']['error'])
      {
		case 1: echo "UPLOAD_MAX_FILE_SIZE error!<br>";break;
		case 2: echo "MAX_FILE_SIZE erroe!<br>";break;
		case 3: echo "Not file loading, breaking process.<br>";break;
		case 4: echo "Not load<br>";break;
		case 6: echo "tmp folder error<br>";break;
		case 7: echo "write file error<br>";break;
		case 8: echo "php stop your load<br>";break;
      }
  }
  
  $type= "medium";
  if(isset($_POST['type'])) $type = $_POST['type'];
 
  $name = $_POST['filename'];
 
	$catalog = 'mainpage_large';
	if($type == 'medium') $catalog = 'banners/'.'mainpage_medium';
	if($type == 'large') $catalog = 'banners/'.'mainpage_large';
	if($type == 'season_pro') $catalog = 'banners/'.'season_products';
	if($type == 'shops') $catalog = 'shops';
	if($type == 'brands') $catalog = 'brands';

	if($type == 'baner_line_left') $catalog = 'banners/baner_line';
	if($type == 'baner_line_right') $catalog = 'banners/baner_line';

  $uploaddir = DIR_IMAGE . $catalog.'/';

  $filename = $_POST['filename'].'_'.$_FILES['userfile']['name'];
  
  $uploadfile = $uploaddir . $filename;

  

  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
	 
	 if($type == 'medium' OR $type == 'large' OR $type == 'season_pro'){
		$sql = 'UPDATE '.DB_PREFIX.'baner SET baner_pic = \''. $filename .'\' WHERE baner_id=\''.$_POST['filename'].'\';';
	 }
	 
	 if($type == 'shops'){
		$sql = 'UPDATE '.DB_PREFIX.'shop SET image = \'/image/shops/'. $filename .'\' WHERE id=\''.$_POST['filename'].'\';';
	 }
	 
	if($type == 'baner_line_left'){
		$sql = 'UPDATE '.DB_PREFIX.'baner_line SET image_left = \'/image/banners/baner_line/'. $filename .'\' WHERE baner_line_id=\''.$_POST['filename'].'\';';
	}
	 
	if($type == 'baner_line_right'){
		$sql = 'UPDATE '.DB_PREFIX.'baner_line SET image_right = \'/image/banners/baner_line/'. $filename .'\' WHERE baner_line_id=\''.$_POST['filename'].'\';';
	}
	 
	 if($type == 'brands'){
		$sql = 'UPDATE '.DB_PREFIX.'manufacturer SET image = \''. $filename .'\' WHERE manufacturer_id=\''.$_POST['filename'].'\';';
	 }
	 
	 $mysqli->query($sql) or die($sql);
	 
		//echo $sql;
		//echo "<font color=\"green\">Файл корректен и был успешно загружен.</font>";
		//die();
  } else {
	  //echo "<font color=\"green\">Возможная атака с помощью файловой загрузки!</font>";
  }
	if($type == 'medium') header('Location: /'.TMP_DIR.'backend/index.php?route=main_page/main_page.index.php&modul=main_page.baners.php');
	if($type == 'large') header('Location: /'.TMP_DIR.'backend/index.php?route=main_page/main_page.index.php&modul=main_page.main_baner.php');
	if($type == 'season_pro') header('Location: /'.TMP_DIR.'backend/index.php?route=main_page/main_page.index.php&modul=main_page.season_products.php');
	if($type == 'shops') header('Location: /'.TMP_DIR.'backend/index.php?route=shops/shops.index.php');
	if($type == 'brands') header('Location: /'.TMP_DIR.'backend/index.php?route=brands/brands.index.php');
	
	if($type == 'baner_line_left' OR $type == 'baner_line_right') header('Location: /'.TMP_DIR.'backend/index.php?route=main_page/main_page.index.php&modul=main_page.baner_line.php');

?>
