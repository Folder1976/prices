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

	$count_image = 100;
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
	if($load_files > 70) $load_files = 70; //Лимит по файлам
	
	
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
	
		
		
		//Получаем массив размеров
		$size = 1;
		$tmp = $Size->getSizesOnGroup($size);
		$sizes = array();
		foreach($tmp as $index => $value){
			$sizes[$value['name']] = $index;
		}
		
		//Проверим дизайнеров (если он не насильный)
		$set_stop = 0;
			
        $designers = $Designer->getDesigners();
        $finded = array();
        $count = 1;
        foreach($datas as $index => $data){
            
			
            if($Designer->getDesignerIdOnName($data['manufacture_name'], $shop_id) < 1){
                echo '<br>'.$data['manufacture_name'];
				echo ' NONE!';
				
                if(!isset($finded[$data['manufacture_name']])){
                    
                    $manuf_data = array(
                                        'name'=>$data['manufacture_name'],
                                        'name_sush'=>$data['manufacture_name'],
                                        'name_rod'=>$data['manufacture_name'],
                                        'name_several'=>$data['manufacture_name'],
                                        'keyword'=>translitArtkl($data['manufacture_name']),
                                        'href'=>translitArtkl($data['manufacture_name']),
                                        'sort_order'=>0,
                                        'manufacturer_description'=>array(
                                                'title_h1'=>$data['manufacture_name'],
                                                'description'=>$data['manufacture_name'],
                                                'meta_title'=>$data['manufacture_name'],
                                                'meta_description'=>$data['manufacture_name'],
                                                'meta_keyword'=>$data['manufacture_name']
                                            )
                                        );
                    $Designer->addManufacturer($manuf_data);
                    
                }
                $finded[$data['manufacture_name']] = $data['manufacture_name'];					
            }
            
        }
        
		//Получим список дизайнеров
		$sql = 'SELECT * FROM '.$prefix.'manufacturer';
		$r = $mysqli->query($sql) or die($sql);
		$manuf = array();
		while($tmp = $r->fetch_assoc()){
			$manuf[$tmp['manufacturer_id']] = $tmp['name'];
		}
	
		//Начинаем писать товар ================================================================
		$Size->resetAllProductQantityOnShopId($shop_id);
	
		$shop_name = $Shops->getShopName($shop_id);
		$shop_info = $Shops->getShopInfo($shop_id);
		
		$download_images = array();
		foreach($datas as $index => $data){
			//Получим недостающие поля
	
    
    		//Если дизайнер прилетел насильно... или же найдем его в таблицах (Дизайнер находится в таблице Юзерс группа 1, там же и альтернативные названия)			
			$data['designer_id'] = $designer_id = $Designer->getDesignerIdOnName($data['manufacture_name'], $shop_id);
			$data['designer'] = $Designer->getDesigner($designer_id);
			
			//Определим категорию
			$data['category'] = $podcategory = $Category->getCategoryIdOnAlternativeName($data['categoryid'], $data['categoryname'], $data['shop_id']);
		
			$podcategory_id = $podcategory['id'];
			//Категории и подкатегории	
			if($podcategory_id == 0){
				$podcategory_id = 14;
			}	
				
			//Определим есть ли такой товар
			$product_id = $Product->getProductIdOnOriginUrl($data['url']);
			
			$category_id = $podcategory_id;	
			
				$product = array();
				$product['product_attribute'] = array();
				$product['name'] = $ShopImportParse->getAutoReplacesIndex($data['name'], 'name');
				$product['full_name'] = $product['name'];
				
				$product['category_id'] = $category_id;
				if($data['designer'] AND isset($data['designer']['name']) AND $data['designer']['name'] != ''){
					$product['full_name'] .= ' от ' . $data['designer']['name'];
				}
				
				if($shop_id == 4){
					$product['original_url'] = $data['url'];
				}else{
					$product['original_url'] = $data['url'];
				}
				
				$product['designer_id'] = $product['user_id'] = $designer_id;
				$product['code'] = $data['url'];
				$product['designer_code'] = $data['id'];
				$product['is_hidden'] = 1;
				$product['text'] = '';

                if(isset($data['params']) AND is_array($data['params'])){
                    foreach($data['params'] as $index => $value){
                        $data['description'] .= '<br><b>'.$index.'</b>: '.$value.'';
                    }
                }
                
				
	
				
				$product['text'] = $ShopImportParse->getAutoReplacesIndex($data['description'],'desc');	
				if(isset($data['realparametrs']['material']) AND count($data['realparametrs']['material']) > 0){
					
					$product['text'] .= '<br><br><b>Характеристики:</b>';
					$product['text'] .= $ShopImportParse->getAutoReplacesIndex('<br><b>Материал : </b>', 'params');		
					foreach($data['realparametrs']['material'] as $index2 => $value2){
						
						$value2 = mb_strtoupper(addslashes(trim($value2)),'UTF-8');
						if(strlen($value2) > 2){
						
							$product['text'] .= $ShopImportParse->getAutoReplacesIndex(' <i>'.$value2.'</i>,', 'params');
							
							$sql = 'SELECT attribute_id, name FROM '.$prefix.'attribute_description AD
										WHERE upper(`name`) LIKE "%'.$value2.'%"';
							
							$ra = $mysqli->query($sql) or die(';jsadhgfasdnb '.$sql);
							if($ra->num_rows > 0){
								while($tmp_a = $ra->fetch_assoc()){
									$product['product_attribute'][$tmp_a['attribute_id']]['name'] = $tmp_a['name'];
									$product['product_attribute'][$tmp_a['attribute_id']]['attribute_id'] = $tmp_a['attribute_id'];
									$product['product_attribute'][$tmp_a['attribute_id']]['product_attribute_description'][1]['text'] = '1';
								}
							}else{
								$material_error[$value2] = $value2;
							}
						}	
					}
					$product['text'] = trim($product['text'],',');
					//$product['text'] .= $ShopImportParse->getAutoReplacesIndex($product['text'], 'params');		
				}
	
	//==ПЕРЕВОДИМ ДАННЫЕ В ФОРМАТ ОПЕНКАРТА=======================================================	==
				$data_P['upc'] = '';
				$data_P['ean'] = '';
				$data_P['jan'] = '';
				$data_P['isbn'] = '';
				$data_P['mpn'] = '';
				$data_P['location'] = '';
				$data_P['subtract'] = '';
				$data_P['points'] = '';
				$data_P['weight'] = '';
				$data_P['weight_class_id'] = '';
				$data_P['length'] = '';
				$data_P['width'] = '';
				$data_P['height'] = '';
				$data_P['stock_status_id'] = '';
				$data_P['date_available'] = date('Y-m-d', strtotime('-1 day'));
				$data_P['length_class_id'] = '';
				$data_P['tax_class_id'] = '';
				$data_P['sort_order'] = 0;
				$data_P['product_description'][1]['name'] = $product['name'];
				$data_P['product_description'][1]['description'] = htmlspecialchars($product['text'],ENT_QUOTES, 'UTF-8');
				$data_P['product_description'][1]['meta_title'] = $product['name'];
				$data_P['product_description'][1]['meta_description'] = $product['name'];
				$data_P['product_description'][1]['meta_keyword'] = $product['name'];
				$data_P['product_description'][1]['tag'] = $product['name'];
				$data_P['original_url'] = $product['original_url'];
				$data_P['product_attribute'] = $product['product_attribute'];
				$data_P['original_code'] = $product['code'];
				$data_P['model'] = strtolower(translitArtkl($shop_name.'-'.$data['id']));//$product['code'];
				$data_P['sku'] = strtolower(translitArtkl($shop_name.'-'.$data['id']));//$product['code'];
				//echo $data_P['sku'];
				$data_P['price'] = 0;
				if($data['instock'] == 1){
					$data_P['quantity'] = 1;
				}else{
					$data_P['quantity'] = 0;
				}
				$data_P['minimum'] = 1;
				$data_P['shipping'] = 1;
				$data_P['keyword'] = strtolower(translitArtkl($product['name'])); //'product/view/'.
				$data_P['keyword_add_id'] = 1; //'product/view/'.
				$data_P['status'] = 1;
				$data_P['stock_status_id'] = 1;
				if(isset($manuf[$product['designer_id']])){
					$data_P['manufacturer'] = $manuf[$product['designer_id']];
					$data_P['manufacturer_id'] = $product['designer_id'];
				}else{
					$data_P['manufacturer'] = '';
					$data_P['manufacturer_id'] = 0;
				}
			
			//header("Content-Type: text/html; charset=UTF-8");
			//echo "<pre>";  print_r(var_dump( $shop_info )); echo "</pre>";die();
				
				if(strpos($shop_info['modul'],'no_size_reset') !== false){
					$data_P['no_size_reset'] = true;
				}
				
			$data_P['product_store'] = array(0 => 0);
				$data_P['product_category'] = array(0 => $podcategory_id);
				$data_P['product_category'] = array(0 => $podcategory_id);

		//Если выбрано удаление - удаляем товар и закольцовываем цыкл		
		if(isset($_POST['delete_product'])){
			if($product_id > 0){
				$product_id = $Product->dellProduct($product_id);	
			}
			continue;
		}
        
        
        
		//echo "<pre>";  print_r(var_dump( $data )); echo "</pre>";die();
        
		//Добавляем если нашли
		if($product_id == 0){
			//Если новый продукт - тогда его на модерацию
			$data_P['moderation_id'] ='1';
		
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
	
			$product_id = $Product->addProduct($data_P);
			
		}
			
	
			
			//Изменяем поля
			if($product_id > 0){
				
				$product = array();
				$data_P['price'] = $data['price'];
				if($data['instock'] == 1){
					$data_P['quantity'] = 1;
				}else{
					$data_P['quantity'] = 0;
				}
				
				
				if((isset($data['sizes']) AND is_array($data['sizes'])) OR (isset($data['size_array']))){
					
					$product['size_standart'] = $Size->getProductSizeStandart($product_id);
					
					//$product['sizes'] = $data['sizes'];
					if($product['size_standart'] == 0){
						if(isset($_POST['size']) AND $_POST['size'] != '0'){
						
							$product['size_standart'] = $_POST['size'];
						
						}else{
							
							$product['size_standart'] = 1;
						
						}
					}
					
					//Для новых размеров (стандарт указывается в файле)
					if(isset($data['size_standart'])){
						$product['size_standart'] = $data['size_standart'];
					}
					
					$data_P['product_size'] = array();
					
					if(isset($data['size_array'])){
						$data['sizes'] = $data['size_array'];
					}else{
						$data['sizes'] = array();
					}
					
					foreach($data['sizes'] as $index => $value){
						$sql = 'SELECT size_id FROM `'.$prefix.'size` WHERE group_id="'.$product['size_standart'].'" AND name LIKE "'.$index.'" ';
						$rs = $mysqli->query($sql);
						if($rs->num_rows > 0){
							$tmp = $rs->fetch_assoc();
							$size_id = $tmp['size_id'];
						}else{
							$sql = 'INSERT INTO `'.$prefix.'size` SET group_id="'.$product['size_standart'].'", name = "'.$index.'", `enable`="1", sort="0";';
							$mysqli->query($sql);
							$size_id = $mysqli->insert_id;
						}
						
						$data_P['product_size'][$size_id] = $product['size_standart'];
					}
					
					if(isset($data['size_array']) AND count($data['size_array']) == 0){
						unset($data_P['product_size']);
					}
					
				}
		
				$data_P['product_shop'][$shop_id] = $shop_id;
				
				$data_P['oldprice'] = $data['oldprice'];
	
				unset($datas[$index]['price']);
				unset($datas[$index]['oldprice']);
					
				//Ни каких перемещений для уже созданых товаров
				unset($data_P['product_category']);
				$data_P['ignore_attribute'] = true;
				$Product->editProduct($product_id, $data_P);
				
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
