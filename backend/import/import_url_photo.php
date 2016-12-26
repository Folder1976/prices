<?php
	if(!isset($direct_load)){
		include_once ('../config/config.php');
	}
	if(!isset($noload)){
		include_once ('../import/import_url_getfile.php');	
	}

    $uploaddir = UPLOAD_DIR;
    global $folder, $setup;
    $separator = $setup['tovar artikl-size sep'];


    //echo 'ajax load photo - ok';
    // print_r(var_dump($_GET));  
    if(!isset($IMGPath)){
		$IMGPath = $_GET['url'];
	}
//echo '<br><b>'.$IMGPath.'</b>';

	$Tdate = DownloadFileNoCode($IMGPath);
    $TdateCode = DownloadFile($IMGPath);
	
 
	if (!$Tdate === null) {
		return false;
    }

    touch($uploaddir);
    
    if(!file_put_contents($uploaddir.'from_url_tmp.jpg', $Tdate)){
		echo 'Не удалось загрузить фаил';
		//exit();
    }
	if(!file_put_contents($uploaddir.'from_url_tmp1.jpg', $TdateCode)){
		echo 'Не удалось загрузить фаил';
		//exit();
    }

	if(!isset($product_id)){
		$product_id = $_GET['tovar_id'];
	}
	
    $res = $folder->query('SELECT tovar_artkl FROM tbl_tovar WHERE tovar_id = \''.$product_id.'\';') or die('123'.mysql_error());

    if($res->num_rows == 0){
		echo '<br><font color="red"><b>Не нащел товар - id : '.$product_id . '<br>Не смог назначить фото! Сделайте это вручную или найдите в чем ошибка</b></font>';
		//return false;
    }else{
    
		$tmp = $res->fetch_assoc();
		if(!isset($str_artkl)){
			$tmp1 = $tmp['tovar_artkl'];
		}else{
			$tmp1 = $str_artkl;
		}
		
		if(strpos($tmp1, $separator) !== false){
			$tmp1 = explode($separator, $tmp1);
			$name = $artkl = $tmp1[0];
		}else{
			$name = $artkl = $tmp1;
		}
		
		$image_count = 0;
		//Если нет даже папки - создадим
		if(!file_exists($uploaddir.$name)){ 
			mkdir($uploaddir.$name,0777);
			chmod($uploaddir.$name,0777);
		}else{ //Если папка есть - найдем последнюю номерацию для добавления
		
		//Находим дырку для фотки.. или же в конец очереди
		while(file_exists($uploaddir.$name.'/'.$name.'.'.$image_count.'.small.jpg')){
			$image_count++;
		}
	
		}
	   
		//Запишем в таблицу имя картинки - не проверяем наличие этой записи 
		$firstname = "$name/$name.0.small.jpg";
		$sql = "INSERT INTO tbl_tovar_pic SET pic_name = '".$firstname."', tovar_artkl = '".$name."' ON DUPLICATE KEY UPDATE pic_name = '".$firstname."'";;
		$folder->query($sql);
	   
		if(file_exists('../init.class.upload_0.31.php')){
			include_once '../init.class.upload_0.31.php';
		}else{
			include_once 'init.class.upload_0.31.php';
		}
		$ext = 'jpg';
	 
		//Обрещаем фотку и копируем ее в папку товара БОЛЬШОЙ РАЗМЕР
		//die('11111111111');
		//Если влетел PNG - конвертируем его в JPG
		if(strpos($IMGPath, '.png') !== false){
			
			$image = imagecreatefrompng($uploaddir.'from_url_tmp.jpg');
			imagejpeg($image, $uploaddir.'from_url_tmp.jpg', 100);
			imagedestroy($image);
			
			$image = imagecreatefrompng($uploaddir.'from_url_tmp1.jpg');
			imagejpeg($image, $uploaddir.'from_url_tmp1.jpg', 100);
			imagedestroy($image);
			
		}
		
		$handle = new upload($uploaddir.'from_url_tmp.jpg');
		$handle1 = new upload($uploaddir.'from_url_tmp1.jpg');
		//www.verot.net/php_class_upload_docs.htm
	
		
		
		if(!$handle->uploaded)
		{
			$handle = $handle1;
			
			echo '<br><font color="orange">Не смог загрузить фото - попробую перекодировать урл.</font>';
			
			if(!$handle->uploaded){
				
				echo '<br><font color="red">Не смог загрузить даже перекодированный урл! Останавливаю загрузку.</font>';
				return false;
			
			}
		}
		
			$new_name = $name.".".$image_count.".large";
			$handle->file_new_name_body = $new_name;
			$handle->mime_check         = true; 
			$handle->image_resize		= true;
			$handle->image_background_color = '#FFFFFF';
			$handle->image_ratio_fill 	= "C";
			$handle->image_x			= 900; 
			$handle->image_y			= 900; 
			$handle->image_convert 		= "jpg";
			$handle->jpeg_quality 		= 60;
			$handle->file_overwrite		= true;
			$handle->process($uploaddir);
			$handle->clean($uploaddir);
			
		
		//die($uploaddir.$new_name.".".$ext);
		copy($uploaddir.$new_name.".".$ext, $uploaddir.$name."/".$new_name.".".$ext);
		
	 
		//Обрещаем фотку и копируем ее в папку товара СРЕДНИЙ РАЗМЕР
		$handle = new upload($uploaddir.$new_name.".".$ext);//www.verot.net/php_class_upload_docs.htm
		if($handle->uploaded)
		{
		$new_name = $name.".".$image_count.".medium";
		  $handle->file_new_name_body = $new_name;
		  $handle->image_resize=true;
		  $handle->image_background_color = '#FFFFFF';
		  $handle->image_ratio_fill = "C";
		  $handle->image_x= 450; 
		  $handle->image_y= 450; 
		 // $handle->file_overwrite=true;
		 // $handle->file_auto_rename=false;
		  $handle->process($uploaddir);
		  $handle->clean($uploaddir);
		}
		copy($uploaddir.$new_name.".".$ext,$uploaddir.$name."/".$new_name.".".$ext);
		
		
		//Обрещаем фотку и копируем ее в папку товара МАЛЫЙ РАЗМЕР
		$handle = new upload($uploaddir.$new_name.".".$ext);//www.verot.net/php_class_upload_docs.htm
		if($handle->uploaded)
		{
		$new_name = $name.".".$image_count.".small";
		  $handle->file_new_name_body = $new_name;
		  $handle->image_resize=true;
		  $handle->image_background_color = '#FFFFFF';
		  $handle->image_ratio_fill = "C";
		  $handle->image_x= 150; 
		  $handle->image_y= 150; 
		 // $handle->file_overwrite=true;
		 // $handle->file_auto_rename=false;
		  $handle->process($uploaddir);
		  $handle->clean($uploaddir);
		}
		copy($uploaddir.$new_name.".".$ext,$uploaddir.$name."/".$new_name.".".$ext);
		
		unlink($uploaddir.$new_name.".".$ext);
  
   
		//Выплюнем путь к фото для подключения его в родительском модуле   
		echo '../resources/products/'.$name."/".$new_name.".".$ext.'<br>';
	}		
   
   
    
    


?>
