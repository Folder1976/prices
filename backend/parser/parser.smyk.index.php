<?php
if(isset($_SESSION['x']) AND ($_SESSION['x']%2)){
    $sityName = 'Петропавловск-Камчатский';
    $_SESSION['x']++;
}else{
    $sityName = 'Львов';
    $_SESSION['x'] = 1;
}
?>
<?php
set_time_limit(0);
//include 'constants.php';
//define("GETCONTENTVIAPROXY", 1);
//define("GETCONTENTVIANAON", 1);
$uploaddir = DIR_IMAGE.'product/';
$uploaddir_s = 'product/';
$category_id = 565;
$postav_id = 1; //smyk
$pausa = 5;
$currency = 1;
$kurs = 6.8;
$skidka = 1;
$nacenka = 1.15; //Наценка на розницу! не на закуп!!!
$link_table = 'fash_parsing_smyk';
$error = 0;

		//$_GET['url'] = 'http://www.smyk.com/reima-kombinezon-zimowy-dwuczesciowy-kiddo-kide.html';
		//$_GET['url'] = 'http://www.smyk.com/catalog/product/view/id/196834/s/cool-club-spodnie-dresowe-dziewczece/';



$folder = $mysqli;

function sort_by_len($f,$s)
{
	if(strlen($f)<strlen($s)) return true;
	else return false;
}


//=================================================================================================================================
//=================================================================================================================================
//=================================================================================================================================
//=================================================================================================================================
//=================================================================================================================================
//=================================================================================================================================
//=================================================================================================================================
//=========================================== тут стрипты исправлений


?>
<br><br>
<a href="/backend/index.php?route=parser/parser.smyk.index.php&resetlinks">Обнулить сайтмап (заново)</a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="/backend/index.php?route=parser/parser.smyk.index.php&links"><b><font color="blue">Продолжить парсить</font></b></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="/backend/index.php?route=parser/parser.smyk.index.php&links&unset"><b><font color="orange">Пропустить товар</font></b></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<?php

$http = 'http://www.smyk.com/';
//просто парсим ссылки
if(isset($_GET['resetlinks'])){
	
	$sql = 'UPDATE '.$link_table.' SET view = \'0\' WHERE view = "1";';
	$folder->query($sql) or die('==' . $sql);

}

if(isset($_GET['links'])){
		include 'simple_html_dom/simple_html_dom.php';

		//тупо посчитаем все запись
		$sql = 'SELECT count(id) AS id FROM '.$link_table.';';
		$tmp = $folder->query($sql) or die('==' . $sql);
		$tmp = $tmp->fetch_assoc();
		$all = $tmp['id'];

		$sql = 'SELECT count(id) AS id FROM '.$link_table.' WHERE view = \'0\';';
		$tmp = $folder->query($sql) or die('==' . $sql);
		$tmp = $tmp->fetch_assoc();
		$none = $tmp['id'];
        
echo '<b>Всего ликов - '.$all.'. Пропарсено - '.($all - $none).'. Осталось - '.$none.'.</b>';
		
	 
	if(isset($_GET['unset'])){
		$sql = 'SELECT id FROM '.$link_table.' WHERE view = \'0\' LIMIT 1;';
		$url = $folder->query($sql) or die('==' . $sql);
		$list = $url->fetch_assoc();
		$sql = 'UPDATE '.$link_table.' SET view = \'2\' WHERE id = "'.$list['id'].'";';
		$url = $folder->query($sql) or die('==' . $sql);
		
		?>
			<script>
				function reload() {
					location.href() = 'main.php?func=add_products&supplier=militarist&links';
				}
			</script>
		<?php
	}
	    
			
		$and = '';// AND url = "http://www.smyk.com/reima-kombinezon-zimowy-dwuczesciowy-kiddo-kide.html" ';
		$sql = 'SELECT * FROM '.$link_table.' WHERE view = \'0\' '.$and.' LIMIT 1;';
		$url = $folder->query($sql) or die('==' . $sql);
    
	
	if($url->num_rows > 0){
				$list = $url->fetch_assoc();

echo ' <b>Урл ID - '.$list['id'].'. </b>'; 
			
			if(isset($_GET['url'])){
				$list['url'] = $_GET['url'];
			}
			
				$brand = '';
				$price = '';
				$view = '';
				$size = '';
				
				//Get content via proxy
				$html = @file_get_html($list['url']);
				
				echo '<br><br><br><h1>'.$list['url'].'</h1><br>';
				
				//Если это кривой линк - возможно удаленный товар
				if(!$html){
					$sql = 'UPDATE '.$link_table.' SET view = "1" WHERE `url` = \''.$list['url'].'\';';
					$folder->query($sql) or die('==' . $sql);
	
		
	
					?>
					<h3>Ошибка 404</h3>
						<script>
							$(document).ready(function(){
								<?php if($error == 0 OR $name == 'category'){ 
									echo 'setTimeout(reload, '.$pausa.'000);';
								 } ?>
							}
							);
							
							function reload() {
								location.reload();
							}
						</script>
					<?
					return false;
				}
	
    			//Хлебная крошка
				$tmp = $html->find('.breadcrumb',0);
				if($tmp){
					$breadcrumbs_html = $tmp->innertext();
					$html_tmp = str_get_html($breadcrumbs_html);
					$breadcrumbs_html = $html_tmp->find('li a');
					$breadcrumbs = array();
					foreach($breadcrumbs_html as $tt){
						$breadcrumbs[$tt->innertext()] = $tt->innertext();
					}
					echo 'Крошки родителя ($breadcrumbs_txt => $category_id)-> <b>'.implode('>',$breadcrumbs).'</b><br>';
					$breadcrumbs_txt = implode('>',$breadcrumbs);
				}else{
					$breadcrumbs_txt = '';
				}


				//Массив ссылок
				$str_tmp = $html->find('a');
				
				
				$artkl = '';
				//Это товар
				if($html->find('.main__header--product',0)){
					
					//============================================================================================
					
					$product_info = $memo = $html->find('#product-tab-2',0)->innertext();
                 	$memo .= $html->find('.short-description',0)->innertext();
                    $memo .= $html->find('#product-tab-3',0)->innertext();
                    
                    $name = $html->find('h1',0)->innertext();
                    
                    $product = array('artkl'=>'',
                                    'sostav'=>'',
									'url'=>$list['url'],
									'name'=>$name,
									'description'=>$memo,
                                    'color'=>'',
                                    'colection'=>'',
                                    'material'=>'',
                                    'sezon'=>'',
                                    'dress'=>'',
                                    'brand'=>'',
                                    'sex'=>'',
                                    'years'=>'',
                                    'marka'=>'',
                                    'made_year'=>'',
                                    'price'=>'',
                                    'size' => array()
                                    );
					
                    if(isset($product_info)){
                        
                        //Json
						$product_array = array();
                        $t1 = explode('var spConfig = new Product.Config(',$html);
						if(isset($t1[1])){
							$t2 = explode('</script>',$t1[1]);
							$t3 = trim($t2[0]);
							$t3 = trim($t3,';');
							$t3 = trim($t3,')');
							$t3 = trim($t3,'(');
							$product_array = json_decode($t3, true);
						}
                        
						//выдерем сначала фотки от туда
						$tmp_html = str_get_html($product_info);
                        
                        foreach($tmp_html->find('.table__row--stripped') as $row){
                            $row_data =  trim(strip_tags($row->innertext()));
                            
                            if(strpos($row_data, 'SKU:') !== false){
                                $product['artkl'] = $artkl = trim(str_replace('SKU:','',$row_data));
                            }
							elseif(strpos($row_data, 'Producent:') !== false){
                                $product['brand'] = trim(str_replace('Producent:','',$row_data));
                            }
                            elseif(strpos($row_data, 'Skład surowcowy:') !== false){
                                $product['attribute']['Композиция'] = trim(str_replace('Skład surowcowy:','',$row_data));
                            }
                            elseif(strpos($row_data, 'Kolor:') !== false){
                                $product['attribute']['Цвет'] = trim(str_replace('Kolor:','',$row_data));
                            }
                            elseif(strpos($row_data, 'Kolekcja:') !== false){
                                $product['attribute']['Коллекция'] = trim(str_replace('Kolekcja:','',$row_data));
                            }
                            elseif(strpos($row_data, 'Rodzaj materiału:') !== false){
                                $product['attribute']['Материал'] = trim(str_replace('Rodzaj materiału:','',$row_data));
                            }
                            elseif(strpos($row_data, 'Sezon:') !== false){
                                $product['attribute']['Сезон'] = trim(str_replace('Sezon:','',$row_data));
                            }
                            elseif(strpos($row_data, 'Odzież:') !== false){
                                $product['attribute']['Одежда'] = trim(str_replace('Odzież:','',$row_data));
                            }
                           elseif(strpos($row_data, 'Płeć:') !== false){
                                $product['attribute']['Пол'] = trim(str_replace('Płeć:','',$row_data));
                            }
                           elseif(strpos($row_data, 'Przedział wiekowy:') !== false){
                                $product['attribute']['Возраст'] = trim(str_replace('Przedział wiekowy:','',$row_data));
                            }
                           elseif(strpos($row_data, 'Marka:') !== false){
                                $product['attribute']['Марка'] = trim(str_replace('Marka:','',$row_data));
                            }
                            elseif(strpos($row_data, 'Rok wydania:') !== false){
                                $product['attribute']['Год модели'] = trim(str_replace('Rok wydania:','',$row_data));
                            }
                            
                            //echo '<br>'.$row_data;
                        }
                      
                        //============================================================================================
                        $brand = $product['brand'];
                        echo '<br>Бренд ($brand => $brand_id) -> <b><font color="red">'.$brand.'</font></b>';
                        //============================================================================================
                        echo '<br>Название ($name) -> <b><font color="red">'.$name.'</font></b>';
                        //============================================================================================
                        echo '<br>Актикл ($artkl) -> <b><font color="red">'.$artkl.'</font></b>';
                        //============================================================================================
                        //============================================================================================
                        
                        $product_id = $html->find('input[name="product"]',0)->value;
                        $price = trim($html->find('#product-price-'.$product_id, 0)->innertext());
                        $price = str_replace(',','.',$price);
						
						//Если не нашли цену - возьмем из метатега
						if(!$price){
							
							$t1 = explode('<meta itemprop="price" content="',$html);
								if(isset($t1[1])){
									$t2 = explode('">',$t1[1]);
									$t3 = trim($t2[0]);
									$t3 = trim($t3,';');
									$t3 = trim($t3,')');
									$t3 = trim($t3,'(');
									$price = (float)$t3;
								}
							
						}
						
                        $product['price'] = $price = preg_replace('/[^\d.]/','',$price);
                        
						//Это если на странице есть переменная Джисон
						//$product['zakup'] = (float)$product_array['basePrice'];
                     	//$product['price'] = $price = (int)($product_array['basePrice'] * $kurs * $nacenka);
                        
						$product['zakup'] = (float)$product['price'] ;
                     	$product['price'] = $price = (int)($product['price']  * $kurs * $nacenka);
                        
						
						echo '<br>Цена ($price) -> <b><font color="red">'.$price.'</font></b>';
                        //============================================================================================
                 	    
                        
                        $image = array();
                        $image_small = array();
                        
                        $t = $html->find('.product__gallery--img img');
                        foreach($t as $tt){
                            $image[] = str_replace('thumbnail/59x','image/750x750',$tt->src);
							$image_small[] = $tt->src;
                        }
                    
						$product['images'] = $image;
					
                        echo '<br>';
                        foreach($image_small as $index => $img){
                            if(is_string($img)){
                                echo '<img width="150" src="'.$img.'">';	
                            }
                        }
                    
                        //Просмотрим все таблицы - и охереем! НАйдем размеры
                        if(isset($product_array['attributes']['822']) AND isset($product_array['attributes']['822']['options'])){
                            
                            foreach($product_array['attributes']['822']['options'] as $row){
                                $product['size'][] = trim($row['label']);
                            }
                        }
                        
                        if(count($product['size'])){
                            echo '<br>Размер ($size) -> <b><font color="red">Размеры в массиве</font></b>';
                        }else{
                            echo '<br>Размер ($size) -> <b><font color="red">Без размера</font></b>';
                        }
                        //============================================================================================
                        //============================================================================================
    
                        //die();
                    
                    }
                    
                    $view = '0'; //Тоже в ноль его пока полное добавление не пройдет
				}else{
					$view = '0';
					$name = 'category';
				}
				
				echo '<h4>Найдены новые линки</h4>';
				$view = '0';
				foreach($str_tmp as $option){
				
					$href = str_get_html($option->href);
				
				/*
				 *
				 * Добавление линков в базу
				 *
				 *
				 */
					if(strpos($href, 'smyk.com') AND
                        strpos($href, 'smyk.com/media/') === false AND
                        strpos($href, 'smyk.com/customer') === false AND
                        strpos($href, 'smyk.com/marka') === false AND
                        strpos($href, 'myk.com/wishlist/index/add') === false AND
                        strpos($href, 'smyk.com/search') === false){
						
                        
                        
						$sql = 'SELECT id FROM '.$link_table.' WHERE url = \''.$href.'\';';
						$t = $folder->query($sql) or die('==' . $sql);
						
						if($t->num_rows == 0){
							$sql = 'INSERT INTO '.$link_table.' SET
										 `url` = \''.$href.'\',
										 `key` = "'.$name.'",
										 `view` = \''.$view.'\',
										 `date` = \''.date('Y-m-d H:i:s').'\',
										 `breadcrumbs` = \'\';';
							$folder->query($sql) or die('==' . $sql);
							echo $href.'<br>';
						}
					
					}
	 
				}
				
				if(!isset($size_n)){
					$size_n = array('nosize'=>'0');
				}
				
				$sql = 'UPDATE '.$link_table.' SET view = \'0\',
												`breadcrumbs` = \''.$breadcrumbs_txt.'\',
												`artkl` = \''.$artkl.'\',
												`brand` = \''. htmlspecialchars($brand,ENT_QUOTES).'\',
												`price` = \''.$price.'\',
												`size` = \''.implode(', ', $size_n).'\'
												
												WHERE url = \''.$list['url'].'\';';
				$folder->query($sql) or die('==' . $sql);
     
	 
		//============================================================================================================
		//============================== З А П И С Ь =================================================================
		//============================================================================================================
		//============================================================================================================
		if($name != 'category'){	
			
				//header("Content-Type: text/html; charset=UTF-8");
				//echo "<pre>";  print_r(var_dump( $product )); echo "</pre>"; die();
			
				include 'class/product.class.php';
				$Product = new Product($folder,DB_PREFIX);
				
				include 'class/manufacturer.class.php';
				$Manufacturer = new Manufacturer($folder,DB_PREFIX);
				
				include 'class/attribute.class.php';
				$Attribute = new Attribute($folder,DB_PREFIX);
				
				include 'class/option.class.php';
				$Option = new Option($folder,DB_PREFIX);
				
				
				$data_P = array();
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
				$data_P['product_description'][1]['description'] = htmlspecialchars($product['description'],ENT_QUOTES);
				$data_P['product_description'][1]['meta_title'] = 'Купить '.$product['name'].' в интернет магазине lazycat.com.ua';
				$data_P['product_description'][1]['meta_description'] = 'Купить '.$product['name'].' в интернет магазине lazycat.com.ua';
				$data_P['product_description'][1]['meta_keyword'] = 'Купить '.$product['name'].' в интернет магазине lazycat.com.ua';
				$data_P['product_description'][1]['tag'] = 'Купить '.$product['name'].' в интернет магазине lazycat.com.ua';
				$data_P['original_url'] = $product['url'];
				
				$data_P['original_code'] = $product['artkl'];
				$data_P['model'] = $product['artkl'];//strtolower(translitArtkl($shop_name.'-'.$data['id']));//$product['code'];
				$data_P['sku'] = $product['artkl'];//strtolower(translitArtkl($shop_name.'-'.$data['id']));//$product['code'];
				$data_P['price'] = $product['price'];
				$data_P['zakup'] = $product['zakup'];
				$data_P['quantity'] = 10;
				$data_P['minimum'] = 1;
				$data_P['shipping'] = 1;
				$data_P['keyword'] = strtolower(translitArtkl($product['artkl'].'-'.$product['name'])); //'product/view/'.
				$data_P['keyword_add_id'] = 1; //'product/view/'.
				$data_P['status'] = 1;
				$data_P['stock_status_id'] = 1;
				
				$data_P['moderation_id'] ='0';
				$data_P['manufacturer_id'] = $Manufacturer->getManufacturerOrAdd($product['brand']);
				$data_P['product_store'] = array(0 => 0);
				$data_P['product_shop'] = array(0 => $postav_id);
				$data_P['product_category'] = array(0 => $category_id);
				
				//Атрибуты
				if(isset($product['attribute']) AND is_array($product['attribute']) AND count($product['attribute'])){
					
					$product_attribute = array();
					
					foreach($product['attribute'] as $attr_group_name => $attr_name){
						
						$attribute_group_id = 0;
						$attribute_id = 0;
					
						$attribute_group_id = $Attribute->getAttributeGroupOrAdd($attr_group_name);
						$attribute_id = $Attribute->getAttributeOrAdd($attr_name, $attribute_group_id);
						
						$product_attribute[] = array(
												'attribute_id'=>$attribute_id,
												'product_attribute_description' => array(
													'1' => array(
														'text' => ''
													)
												)
											);
					}
					
					$data_P['product_attribute'] = $product_attribute;
				
				}
			
			
				//Размеры
				if(isset($product['size']) AND is_array($product['size']) AND count($product['size'])){
					
					$product_option = array();
					
					foreach($product['size'] as $option){
						
						$option_value_id = 0;
						$option_id = 11;
						
						$option_value_id = $Option->getOptionValueOrAdd($option, $option_id); // 11 - Это группа размеров Одежды 
					
						$product_option[] = array(
												'option_value_id' => $option_value_id,
												'option_id' => $option_id,
												'quantity' => $data_P['quantity'],
												'price' => $data_P['price'],
												'alternative_size' => $option_value_id,
												'price_prefix' => '',
												'points' => '',
												'points_prefix' => '',
												'weight' => '',
												'weight_prefix' => '',
												'subtract' => 1
											);
						
					}
					
					$data_P['product_option'][] = array(
												'product_option_id' => 0,
												'type' => 'radio',
												'option_id' => $option_id,
												'required' => 1,
												'product_option_value' => $product_option
												);
					
				
				}
			
			
				//header("Content-Type: text/html; charset=UTF-8");'
				//echo "<pre>";  print_r(var_dump( $product['size'] )); echo "</pre>";die();
		
		
				$product_id = $Product->getProductIdOnOriginUrl($product['url']);
				
				//Если продукт новый или принудительная перезагрузка по УРЛ
				
				if($product_id == 0 OR isset($_GET['url'])){
					//Картинки добавляем только при добавлении нового продукта
					//При записи все равно идет проверка на дубляж
					
					
					$data_P['image'] = '';
					$data_P['product_image'] = array();
					
					$count_image = 100;
					$count = -1;
					foreach($product['images'] as $index => $img){
						
						$new_image_name = strtolower(translitArtkl($product['artkl'].'-'.$product['name'])).'-'.$count_image;
						$tmp = explode('.', $img);
						$new_image_name .= '.'.$tmp[count($tmp)-1];
						
						//Может быть одна картинка на несколько товаров! не затираем их
						$download_images[$img][] = $new_image_name;
						
						echo '<br>'.$img;
						
						if($count > -1){
							$data_P['product_image'][$count]['image'] = $uploaddir_s.$new_image_name;
							$data_P['product_image'][$count]['sort_order'] = '0';
						}else{
							$data_P['image'] = $uploaddir_s.$new_image_name;
						}
						$count++;
						$count_image++;
					}
				}
				
				//Если новый продукт 
				if($product_id == 0){
					
					$product_id = $Product->addProduct($data_P);
					
					
					
				}else{
					
					$Product->editProduct($product_id, $data_P);
					
				}
				
				
				
				//Запишем фотки
				if(isset($download_images)){
					foreach($download_images as $image_from => $images){
						//Если такого файла нет - поставить в очередь на закачку
						foreach($images as $image_to){
							if(!file_exists($uploaddir.$image_to)){
								//Проверим или нет очереди уже
								$sql = 'SELECT `id` FROM `'.DB_PREFIX.'import_pic` WHERE `to`="'.$image_to.'";';
								//echo '<br>'.$sql;
								$r1 = $mysqli->query($sql) or die($sql);
								
								if($r1->num_rows == 0){
									$sql = 'INSERT INTO `'.DB_PREFIX.'import_pic` SET `from` = "'.$image_from.'", `to`="'.$image_to.'";';
									//echo '<br>'.$sql;
									$mysqli->query($sql) or die($sql);
								}
							}
			
						}
					}
				}
				
				
				
			
		}//else{
			
			//Если это была категория
			//Вот теперь когда все сделали - поставим этому линку статус вью 1
			$sql = 'UPDATE '.$link_table.' SET `view` = \'1\' WHERE `url` = \''.$list['url'].'\';';
			$folder->query($sql) or die('==' . $sql);
			
		//}
		
	}
	 
				
    }else{
        die('<h2>ЗАКОНЧИЛ!</h2>');
    }

function translitArtkl($str) {
    $rus = array('/',',','І','и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('-','','I','u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
   return str_replace($rus, $lat, $str);
}
?>
<script>
	
	//Тут прописать - если пролетели без ошибок - валим дальше
	$(document).ready(function(){
		<?php if(($error == 0 OR $name == 'category') AND !isset($_GET['url'])){ 
			echo 'setTimeout(reload, '.$pausa.'000);'; //'.($pausa * 1000).'
		 } ?>
	}
	);
	
	function reload() {
        location.reload();
    }


</script>