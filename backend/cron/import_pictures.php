<?php

header("Content-Type: text/html; charset=UTF-8");

function timer(){
    global $time;
    $msg = number_format((microtime(true) - $time),3,'.','');
    $time = microtime(true);
    //echo '<br>'.$msg;
    return $msg;
}
// функция раскодирует строку из URL
function my_url_decode($s){ 
$s= strtr ($s, array ("%20"=>" ", "%D0%B0"=>"а", "%D0%90"=>"А", "%D0%B1"=>"б", "%D0%91"=>"Б", "%D0%B2"=>"в", "%D0%92"=>"В", "%D0%B3"=>"г", "%D0%93"=>"Г", "%D0%B4"=>"д", "%D0%94"=>"Д", "%D0%B5"=>"е", "%D0%95"=>"Е", "%D1%91"=>"ё", "%D0%81"=>"Ё", "%D0%B6"=>"ж", "%D0%96"=>"Ж", "%D0%B7"=>"з", "%D0%97"=>"З", "%D0%B8"=>"и", "%D0%98"=>"И", "%D0%B9"=>"й", "%D0%99"=>"Й", "%D0%BA"=>"к", "%D0%9A"=>"К", "%D0%BB"=>"л", "%D0%9B"=>"Л", "%D0%BC"=>"м", "%D0%9C"=>"М", "%D0%BD"=>"н", "%D0%9D"=>"Н", "%D0%BE"=>"о", "%D0%9E"=>"О", "%D0%BF"=>"п", "%D0%9F"=>"П", "%D1%80"=>"р", "%D0%A0"=>"Р", "%D1%81"=>"с", "%D0%A1"=>"С", "%D1%82"=>"т", "%D0%A2"=>"Т", "%D1%83"=>"у", "%D0%A3"=>"У", "%D1%84"=>"ф", "%D0%A4"=>"Ф", "%D1%85"=>"х", "%D0%A5"=>"Х", "%D1%86"=>"ц", "%D0%A6"=>"Ц", "%D1%87"=>"ч", "%D0%A7"=>"Ч", "%D1%88"=>"ш", "%D0%A8"=>"Ш", "%D1%89"=>"щ", "%D0%A9"=>"Щ", "%D1%8A"=>"ъ", "%D0%AA"=>"Ъ", "%D1%8B"=>"ы", "%D0%AB"=>"Ы", "%D1%8C"=>"ь", "%D0%AC"=>"Ь", "%D1%8D"=>"э", "%D0%AD"=>"Э", "%D1%8E"=>"ю", "%D0%AE"=>"Ю", "%D1%8F"=>"я", "%D0%AF"=>"Я")); 
return $s; 
} 

if(isset($_GET['config'])){
    include __DIR__.'/'.$_GET['config'].'.php';
}else{
    include __DIR__.'/config.php';
}
// ================= ЗАГРУЗКА КАРТИНОК
//================================================================== ИМПОРТ
	
	$uploaddir_s = 'product/';
	include_once(__DIR__.'/../class/shops.class.php');
	$Shops = new Shops($mysqli, $prefix);
	
    include_once(__DIR__.'/../class/size.class.php');
	$Size = new Size($mysqli, $prefix);
	
    include_once(__DIR__.'/../class/product.class.php');
	$Product = new Product($mysqli, $prefix);
	
    include_once(__DIR__.'/../class/designer.class.php');
	$Designer = new Designer($mysqli, $prefix);
	
    include_once(__DIR__.'/../class/category.class.php');
	$Category = new Category($mysqli, $prefix);

	include_once(__DIR__.'/../class/shops.parse.class.php');
	$ShopImportParse = new ShopImportParse($mysqli, $prefix);

	
	$material_error	= array();
		
	
set_time_limit(0);
ini_set("max_execution_time","0");
ini_set("memory_limit","256G");
error_reporting(E_ALL ^ E_DEPRECATED);

//echo phpinfo();
	if(isset($_GET['picture_load'])){
	
		include_once(__DIR__.'/../import/import_url_getfile.php');
		include_once(__DIR__.'/../import/init.class.upload_0.31.php');
		
		$count = 1;
	
	//if(!isset($_SESSION['load_files'])){$_SESSION['load_files'] = 1;}
	
	$time = microtime(true);
	$timer_start = timer();
	
	$load_files = (int)$_SESSION['load_files'];
	if($load_files < 1) $load_files = 1;
	if($load_files > 30) $load_files = 30; //Лимит по файлам
	
	
		$sql = 'SELECT * FROM '.$prefix.'import_pic LIMIT 0, '.$load_files.';';
		$r = $mysqli->query($sql);

		if($r->num_rows > 0){
				while($tmp = $r->fetch_assoc()){
					$image_from = $tmp['from'];
					$image_to = $tmp['to'];
				
				//Декодируем %20
				$image_from = urldecode($image_from);
				
					//$image_from = 'http://svitlanochka.com.ua/userfiles/superbig/2651.jpg';
					//$image_to = 'b1ec0dee47e47fb0bc3075978c0a89e4140.jpg';
					
					//Сраные урл с пробелами
					$s = $image_from;
					$i = parse_url($s); 
					$p = ''; 
					foreach(explode('/',trim($i['path'],'/')) as $v) {$p .= '/'.rawurlencode($v);} 
					$image_from = $i['scheme'].'://'.$i['host'].$p; 
					
					$image_from = str_replace('svitlanochka.com.ua/userfiles/superbig/','svitlanochka.com.ua/userfiles/big/', $image_from);
					
					
					$image_from = urldecode($image_from);
					$TdateCode = DownloadFileNoCode($image_from);
					//$TdateCode1 = DownloadFile($image_from);
			
					//echo '<br>'.$uploaddir.$image_to;	
					if(!file_exists($uploaddir.$image_to) OR isset($_GET['file_reload'])){
						$TdateCode = DownloadFileNoCode($image_from);
						//$TdateCode1 = DownloadFile($image_from);
						if(file_exists($uploaddir.$image_to)){
							unlink($uploaddir.$image_to);
						}
						
						if($TdateCode){
						
							if(!file_put_contents($uploaddir.$image_to, $TdateCode)){
							//if(!file_put_contents($uploaddir.'from_url_tmp1_'.$count.'.jpg', $TdateCode)){
								echo '<br>Не удалось загрузить фаил - '.$image_from;
								continue;
							}else{
								$count++;
							}
						}
						
						echo ' - Загрузил';
			
					}else{
						echo '<br>Фаил есть.';
					}
					
					echo '<br><img src="'.$image_from.'" width="100px"> <img src="/image/product/'.$image_to.'" width="100px">';
					echo '<br>'.$image_from.'<br>'.$uploaddir.$image_to;


					//$sql = 'DELETE FROM fash_import_pic WHERE `from` = "'.my_url_decode($tmp['from']).'" AND `to`="'.$image_to.'";';
					$sql = 'DELETE FROM fash_import_pic WHERE `id` = "'.(int)$tmp['id'].'";';
					//echo '<br>'.$sql;
					$mysqli->query($sql);
						
				}
		$timer_end = timer();

		
		if($timer_end < 30){
			$_SESSION['load_files']++;
		}
		if($timer_end > 30){
			$_SESSION['load_files']--;
		}
				echo '<br><br><b>Идет загрузка картинок. Пауза 10 сек. Пачка '.$load_files.' шт.</b>';
				?>
					<script>
						jQuery(document).ready(function(){
							console.log('reload 5 s');
							setTimeout(function(){
									location.reload();
							}, 10000);
						});
					</script>
				<?php
				
		}else{
			echo '<br>Картинки загружены';
			?>
			<script>
				jQuery(document).ready(function(){
					setTimeout(function(){
							location.href = '/<?php echo TMP_DIR; ?>backend/index.php';
					}, 15000);
				});
			</script>
			<?php
		}
		return true;
	}
				
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================				
				
		$replaces = $ShopImportParse->getAutoReplaces();
		
        $dir = __DIR__."/../uploads";
        $dh  = opendir($dir);
        while (false !== ($filename = readdir($dh))) {
            
            if($filename != '.' AND $filename != '..'){
                
                $files[] = $filename;
        
            }
        }
        
        if(!isset($files)) die('нет файлов');
        
        $file_name = $dir.'/'.array_shift($files);
        
        $filesize = filesize($file_name);
        
 		//Если фаил больеш 30 метров, рубим его на куски и отправляем в крон - отправим его в крон
		if($filesize > (30 * 1024 * 1024)){
			
			//Делим большйо фаил
			$lines = file($file_name); 
			
			$fc = 1; 
			
			$lc = 900000; // по сколько строк в файле 
			
			$data = array();
			
			$items = 0;
			
            while(file_exists($dir."/file_".$fc.".txt")) {
                $fc++;
            }
            $fp = fopen($dir."/file_".$fc.".txt", "a"); 

            
        	for ($i=0; $i<count($lines); $i++){
				
                //echo '<br>'.count($lines);
                
				if(strpos($lines[$i], '<?xml') !== false) $data[0] = $lines[$i];
				if(strpos($lines[$i], '<yml_catalog') !== false) $data[1] = $lines[$i];
				if(strpos($lines[$i], '<company') !== false) $data[2] = $lines[$i];
				
				fwrite($fp, $lines[$i]); 
				
				if(strpos($lines[$i], '</offer>') !== false) $items++;
				
				if (($i/$lc==floor($i/$lc) and $i!=0) OR $items > 1000){
					fwrite($fp, '</offers>'); 
					fclose($fp);
					
					$items = 0;
					$fc += 1; 
				
                    while(file_exists($dir."/file_".$fc.".txt")) {
                        $fc++;
                    }     
                    $fp = fopen($dir."/file_".$fc.".txt", "a");
                    
					fwrite($fp, $data[0]);
					fwrite($fp, $data[1]);
					fwrite($fp, $data[2]); 
				}
				
			} 
			fclose($fp); 
			
			
			//echo '<br><font color="red">Фил слишком большой! Он будет разделен на части и загружен в автоматическом режиме! Вы можете закрыть это окно.</font>';
			unlink($file_name);
            die();
		}

	
        $simple = file_get_contents($file_name);
	
		
		//Если стоит самоопределение магазина
		if(isset($simple)){
		
			//if(mb_detect_encoding($simple) == 'UTF-8'){
			if(isset($_POST['is_utf8'])){
				$html_utf8_1251 = $simple;
			}else{
				//$html_utf8_1251 = mb_convert_encoding($simple, "UTF-8", "windows-1251");
			}
	$html_utf8_1251 = $simple;
	//$html_utf8_1251 = mb_convert_encoding($simple, "UTF-8", "windows-1251");
        	//$html_utf8_1251 = mb_convert_encoding($simple, "UTF-8", "auto");
				
			//Ищем все возможные теги в которых может быть магазин
			$html_utf8 = explode('<offers>', $html_utf8_1251);
			$names = array();
			
			$pat = 'company';
			$s = eregi("<$pat>(.*)</$pat>",$html_utf8_1251,$regs);
			$names[] = $regs[1];
			
			$pat = 'firmName';
			$s = eregi("<$pat>(.*)</$pat>",$html_utf8_1251,$regs);
			$names[] = $regs[1];
		}
		
        $shop_id = 0;
        foreach($names as $name){
            if($shop_id == 0){
                $shop_id = $Shops->getShopOnXmlName($name);
            }
        }
	
		
		if(isset($html_utf8_1251)){
			
			//Получим массив из файла
			//$category_datas = $ShopImportParse->getArrayCategory($html_utf8_1251, $shop_id);
			//Получим массив из файла
			$datas = $ShopImportParse->getArray($html_utf8_1251, $shop_id);

		}
		
		
		//===============================================================================================================	
		//===============================================================================================================	
		//===============================================================================================================	
		//Получим список дизайнеров
		$download_images = array();
		foreach($datas as $index => $data){
	
			//Определим есть ли такой товар
			$product_id = $Product->getProductIdOnOriginUrl($data['url']);
			
			//Изменяем поля
			if($product_id > 0){
				
				$sql = 'DELETE FROM `'.$prefix.'product_image` WHERE product_id = "'.$product_id.'"';
				$mysqli->query($sql);
				//echo '<br>'.$sql;	
				
				//Картинки добавляем только при добавлении нового продукта
				$data_P['image'] = '';
				$data_P['product_image'] = array();
				
				$count_image = 100;
				$count = -1;
				foreach($data['images'] as $index => $img){
					$new_image_name = $product_id.'-'.$count_image;
					$tmp = explode('.', $img);
					$new_image_name .= '.'.$tmp[count($tmp)-1];
					
					//Может быть одна картинка на несколько товаров! не затираем их
					$download_images[$img][] = $new_image_name;
					
					
					if($count > -1){
						$data_P['product_image'][$count]['image'] = $uploaddir_s.$new_image_name;
						$data_P['product_image'][$count]['sort_order'] = '0';
					}else{
						$data_P['image'] = $uploaddir_s.$new_image_name;
					}
					$count++;
					$count_image++;
				}
				
				$sql = 'UPDATE `'.$prefix.'product` SET image="'.$data_P['image'].'" WHERE product_id = "'.$product_id.'"';
				$mysqli->query($sql) or die($sql);
				//echo '<br>'.$sql;
				
				foreach($data_P['product_image'] as $image){
					$sql = 'INSERT INTO `'.$prefix.'product_image` SET
								image="'.$image['image'].'",
								product_id = "'.$product_id.'",
								sort_order = 0';
					//echo '<br>'.$sql;								
					$mysqli->query($sql) or die($sql);
				}
			
			}
		
		}
	
		$count_all = 0;
		foreach($download_images as $image_from => $images){
			//Если такого файла нет - поставить в очередь на закачку
			foreach($images as $image_to){
				if(!file_exists($uploaddir.$image_to)){
					
					//Проверим или нет очереди уже
					$sql = 'SELECT `id` FROM `'.$prefix.'import_pic` WHERE `to`="'.$image_to.'";';
					//echo '<br>'.$sql;
					$r1 = $mysqli->query($sql) or die($sql);
					
					if($r1->num_rows == 0){
						$sql = 'INSERT INTO `'.$prefix.'import_pic` SET `from` = "'.$image_from.'", `to`="'.$image_to.'";';
						//echo '<br>'.$sql;
						$mysqli->query($sql) or die($sql);
					}
				}

			}
		}

echo '<br><br>'.$file_name;
chmod($file_name, 0777);
unlink($file_name);
//die();
//========================================


if(isset($_GET['rotation'])){ ?>
	<script type="text/javascript" src="/<?php echo $tmp_dir;?>backend/js/jquery.js"></script>
	<script type="text/javascript" src="/<?php echo $tmp_dir;?>backend/js/ui/jquery-ui.js"></script>
	
		<script>
			jQuery(document).ready(function(){
				console.log('reload 5 s');
				setTimeout(function(){
						location.reload();
				}, 5000);
			});
		</script>
	<?php
}


function translit($str) {
    $rus = array('и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
   return str_replace($rus, $lat, $str);
  }
    function clear_str($str) {
    $find = array('&quot;','\'');
    $replace = array('','');
    return str_replace($find, $replace, $str);
  }

  function translitArtkl($str) {
    $rus = array('и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
   return str_replace($rus, $lat, $str);
  }
  
 function image_resize(
    $source_path, 
    $destination_path, 
    $newwidth,
    $newheight = FALSE, 
    $quality = FALSE // качество для формата jpeg
    ) {

    ini_set("gd.jpeg_ignore_warning", 1); // иначе на некотоых jpeg-файлах не работает
    
    list($oldwidth, $oldheight, $type) = getimagesize($source_path);
    
		
    switch ($type) {
        case IMAGETYPE_JPEG: $typestr = 'jpeg'; break;
        case IMAGETYPE_GIF: $typestr = 'gif' ;break;
        case IMAGETYPE_PNG: $typestr = 'png'; break;
    }
	if($type == '')$typestr = 'jpeg';
	
    $function = "imagecreatefrom$typestr";
    $src_resource = @$function($source_path);
	
	if(!$src_resource) return false;
    
    if (!$newheight) { $newheight = round($newwidth * $oldheight/$oldwidth); }
    elseif (!$newwidth) { $newwidth = round($newheight * $oldwidth/$oldheight); }
    $destination_resource = imagecreatetruecolor($newwidth,$newheight);
    
    imagecopyresampled($destination_resource, $src_resource, 0, 0, 0, 0, $newwidth, $newheight, $oldwidth, $oldheight);
    
    if ($type = 2) { # jpeg
        imageinterlace($destination_resource, 1); // чересстрочное формирование изображение
        imagejpeg($destination_resource, $destination_path, $quality);      
    }
    else { # gif, png
        $function = "image$typestr";
        $function($destination_resource, $destination_path);
    }
    
    imagedestroy($destination_resource);
    imagedestroy($src_resource);
}

?>
