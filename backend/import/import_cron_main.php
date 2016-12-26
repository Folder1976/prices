<style>
	.top_select{
		float: left;
		padding: 10px;
		border: solid 1px #aacfe4;
		margin-right: 10px;
        height: 100px;
	}
	.table_body{
		margin: 10px;
	}
    .top_header{
        margin: 10px;
    }
	
	body{
		overflow: auto;
	}
</style>

<!-- Заголовок -->
	<div class="top_header">
		<h1 style="margin-bottom: 10px;" class="header">Импорт товаров, настройка</h1>
	</div>

    <div style="max-width: 1375px;">
    <div class="table_body">
 
<?php				
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================				
	
	$sql = 'SELECT * FROM '.$pp.'import_cron;';
	$r = $mysqli->query($sql) or die($sql);
	
		?>
		
		<div class="navigation_editor" style="margin-top: 20px;">
			<div class="top_editor">
				<div class="select_top shop">
					<table>
						<tr>
							<th>#</th>
							<th>Периодичность</th>
							<th>Магазин</th>
							<th>Источник данных</th>
							<th>Дополнительные параметры</th>
							<th>&nbsp;</th>
						</tr>
						<tr id="new_row">
							<td>#</td>
							<td><input type="text" class="new" id="find" placeholder="Найти фразу" value="" style="width: 300px;"></td>
							<td><input type="text" class="new" id="rep" placeholder="Заменить фразу" value="" style="width: 300px;"></td>
							<td align="center"><input type="checkbox" class="new" name="" id="name" checked></td>
							<td align="center"><input type="checkbox" class="new" name="" id="desc" checked></td>
							<td align="center"><input type="checkbox" class="new" name="" id="params" checked></td>
							<td align="center"> <a href="javascript:" class="add"><img src="/img/add.png" title="удалить" width="16" height="16"></a>
							</td>
						</tr>
						
						<tr id="next_row">
							<td colspan="7">&nbsp;</td>
						</tr>
						<?php foreach($replaces as $index => $value){ ?>
						
							<tr id="<?php echo $index; ?>">
								<td><?php echo $index; ?></td>
								<td><input type="text" class="edit" id="find<?php echo $index; ?>" value="<?php echo $value['find']; ?>" style="width: 300px;"></td>
								<td><input type="text" class="edit" id="rep<?php echo $index; ?>" value="<?php echo $value['rep']; ?>" style="width: 300px;"></td>
								<td align="center"><input type="checkbox" class="edit" id="name<?php echo $index; ?>" <?php if(strpos($value['params'],'name') !== false) echo ' checked '; ?>></td>
								<td align="center"><input type="checkbox" class="edit" id="desc<?php echo $index; ?>" <?php if(strpos($value['params'],'desc') !== false) echo ' checked '; ?>></td>
								<td align="center"><input type="checkbox" class="edit" id="params<?php echo $index; ?>" <?php if(strpos($value['params'],'params') !== false) echo ' checked '; ?>></td>
								<td align="center">
									<a href="javascript:;" class="dell_detail" data-id="<?php echo $index;?>">
										<img src="/img/cancel.png" title="удалить" width="16" height="16">
									</a>
								</td>
							</tr>
						
						<?php  } ?>
					</table>
				</div>
				<div style="clear: both"></div>
			</div>
			<div style="clear: both"></div>
		</div>
		<div style="clear: both"></div>
		
		
		
		<script>
			<?php $table = $pp.'import_replace'; ?>
			
			
			
			jQuery(document).on('change','#shop', function(){
				id = $(this).val();
				
				jQuery.ajax({
						type: "POST",
						url: "/backend_new/import/ajax_replace_editor.php",
						dataType: "json",
						data: "id="+id+"&key=get_shop",
						beforeSend: function(){
							jQuery('.get_postav_wrapper').hide();
					
							jQuery('.get_url_wrapper').show();
							jQuery('.get_file_wrapper').show();
						},
						success: function(msg){
							console.log( msg );
							if (msg.modul != '') {
								
								/*
								jQuery("#postav"+target).empty();
								jQuery("#postav"+target).append('<option value="0" select>Выбрать. . .</option>');
								jQuery.each(msg.postav, function( index, value ) {
									jQuery.each(value.options, function( index2, value2 ) {
										jQuery("#postav").append( '<option value="'+index2+'" select>'+value2+'</option>');
									});
								});
								*/
                        		jQuery('.get_postav_wrapper').show();
								jQuery('.get_url_wrapper').hide();
								jQuery('.get_file_wrapper').hide();
							}
						}
					});
			});
			
			
			jQuery(document).on('click','.add', function(){
				
				
				var id = 0;
				var find = jQuery('#find').val();
				var rep = jQuery('#rep').val();
				
				var param = '';
				
				if (jQuery('#name').prop('checked')) {
					 param = param + 'name;';
				}
				if (jQuery('#desc').prop('checked')) {
					 param = param + 'desc;';
				}
				if (jQuery('#params').prop('checked')) {
					 param = param + 'params;';
				}
				
				if (find != "" && rep != "") {
					jQuery.ajax({
						type: "POST",
						url: "/backend_new/import/ajax_replace_editor.php",
						dataType: "text",
						data: "id="+id+"&find="+find+"&rep="+rep+"&params="+param+"&table=<?php echo $table; ?>&key=add",
						beforeSend: function(){
						},
						success: function(msg){
							/*
							console.log( msg );
							
							var html = jQuery('#new_row').html();
							
							html = html.replace(/new/g, 'edit');
							console.log(html);
							
							html = html.replace('<a href="javascript:" class="add"><img src="/img/add.png" title="удалить" width="16" height="16"></a>', '<a href="javascript:;" class="dell_detail" data-id="'+msg+'"><img src="/img/cancel.png" title="удалить" width="16" height="16"></a>');
							html = '<tr id="'+msg+'">'+html+'</tr>';

							jQuery(html).insertAfter('#next_row');
							
							//console.log(html);
							*/
							location.reload();
						}
					});
				}
			});
			
		jQuery(document).on('change','.edit', function(){
			
			var id = jQuery(this).parent('td').parent('tr').attr('id');
			var find = jQuery('#find'+id).val();
			var rep = jQuery('#rep'+id).val();
			
			var param = '';
			
			if (jQuery('#name'+id).prop('checked')) {
				 param = param + 'name;';
			}
			if (jQuery('#desc'+id).prop('checked')) {
				 param = param + 'desc;';
			}
			if (jQuery('#params'+id).prop('checked')) {
				 param = param + 'params;';
			}
			 
			jQuery.ajax({
				 type: "POST",
				 url: "/backend/ajax/ajax_guideuniversal.php",
				 dataType: "text",
				 data: "id="+id+"&find="+find+"&rep="+rep+"&params="+param+"&table=<?php echo $table; ?>&key=edit",
				 beforeSend: function(){
				 },
				 success: function(msg){
					 console.log( msg );
				 }
			 });
			 
		});	
				 
		jQuery(document).on('click','.dell_detail', function(){
			var id = jQuery(this).data('id');
			
			if (confirm('Вы действительно желаете удалить фильтр?')){
				jQuery.ajax({
					type: "POST",
					url: "/backend_new/import/ajax_replace_editor.php",
					dataType: "text",
					data: "id="+id+"&table=<?php echo $table; ?>&key=dell",
					beforeSend: function(){
					},
					success: function(msg){
						console.log( msg );
						jQuery('#'+id).hide();
					}
				});
			}
		});
		</script>
<?php
$i_name = array();
$i_name[1] = 'front';
$i_name[2] = 'back';
$i_name[3] = 'middle';
$i_name[4] = 'other';
	
	
	$shop = $Shops->getShop($shop_id);
	
	$postav_id = 0;
	if(isset($_POST['postav'])){
		$postav_id = $_POST['postav'];
	}
	
				
	if(isset( $_FILES['import_file']['tmp_name']) OR (isset($_POST['import_url']) AND $_POST['import_url'] != '')){
	   
		if(isset($shop['modul']) AND $shop['modul'] != ''){
			
		}elseif(isset($_FILES['import_file']['tmp_name']) AND $_FILES['import_file']['tmp_name'] != ''){
			 $tmpFilename = $_FILES['import_file']['tmp_name'];
			 $simple = file_get_contents($tmpFilename);
		}elseif( $_POST['import_url'] != ''){
			 $simple = file_get_contents($_POST['import_url']);
		}

		//Если стоит самоопределение магазина
		if(isset($simple) AND isset($_POST['find_shop']) AND $shop_id > 0){
			
			$html_utf8 = mb_convert_encoding($simple, "utf-8", "windows-1251");
			
			$html_utf8 = explode('<offers>', $html_utf8);
		
			$pat = 'name';
			$s = eregi("<$pat>(.*)</$pat>",$html_utf8[0],$regs);
			$name = $regs[1];
			
			$shop_id = $Shops->getShopOnXmlName($name);
			
		}
	
	
		
		if(isset($simple)){
			//Получим массив из файла
			$datas = $ShopImportParse->getArray($simple, $shop_id);
			//Получим массив из файла
			$category_datas = $ShopImportParse->getArrayCategory($simple, $shop_id);
		}else{
			//Получим массив из файла
			$datas = $ShopImportParse->getArray(0, $shop_id, $postav_id);
			
			$ids = array();
			foreach($datas as $index => $value){
				$ids[] = $value['id'];
			}
			
			//Получим массив из файла
			$category_datas = $ShopImportParse->getArrayCategoryStilnaia($ids);
		}
		
		//==================================================== Определение категорий =====================================
		//================================================================================================================
		?>
			<script src="/js/backend/ajax_alternative_categs.js"></script>
			<script>
				//jQuery.getScript('/js/backend/ajax_alternative_categs.js');
				jQuery(document).ready(function(){
					jQuery.each(jQuery('.categorys'), function(index, value){
						var id = jQuery(this).parent('td').parent('tr').attr('id');
						jQuery('#category'+id).trigger('change');
					});
					jQuery('#shop').trigger('change');
					
					
				});
			
				//Запоминание альтернативной категории Тригер-кнопка
				jQuery(document).on('click','.btn_yes', function(){
					var target = jQuery(this).data('id');
					jQuery('#'+target).trigger('change');
				});
			</script>
		<?php
			foreach($category_datas as $index => $value){
				$id = $Category->getCategoryIdOnAlternativeName($index, $value, $shop_id);
				
				if($id > 0){
					unset($category_datas[$index]);
				}
			}
			
			if(count($category_datas) > 0){ ?>
				<div class="category_select" style="margin-top: 20px;">
					<h3>Выбрать синхронизацию категорий</h3>
				<table>
					<tr>
						<th colspan="2" width="50%">Категория поставщика</th>
						<th colspan="2" width="50%">Категория у нас</th>
					</tr>
					<tr>
						<th>ид</th>
						<th>Название</th>
						<th>ид</th>
						<th>Название</th>
					</tr>
				
				<?php foreach($category_datas as $index => $value){ ?>
					<tr id="<?php echo $index;?>" data-id="<?php echo $index;?>" data-name="<?php echo $value;?>">
						<td><?php echo $index;?></td>
						<td><?php echo $value;?></td>
						<td>
							<select class="main_category" id="category<?php echo $index;?>" data-id="<?php echo $index;?>" style="width:200px;">
								<option value="1">Для мужчин</option>
								<option value="2" selected>Для женщин</option>
							</select>
						</td>
						<td>
							<select class="edit_category_detail categorys" id="podcategory<?php echo $index;?>" data-def="<?php echo $index;?>" style="width:300px;">
								<option label="Выбор..." value="">Выбор...</option>
							</select>
							<button class="btn_yes" data-id="podcategory<?php echo $index;?>">Запомнить</button>
						</td>
					</tr>
				<?php } ?>
				</table >
				<input type="hidden" id="shop_id" value="<?php echo $shop_id;?>">
				</div>
				<?php echo '<h3>Есть не синхронизированные категории. Импорт остановлен.</h3>';
				return false;
			}
		?>

	<?php
		//===============================================================================================================	
		//===============================================================================================================	
		//===============================================================================================================	
	
		//$size_sistem = '0';
		//if(isset($_POST['size'])) $size = $_POST['size'];
		
		if(count($datas) == 0){
			echo 'Не получил данных';
			die();
		}
		if(count($shop_id) == 0){
			echo 'Не получил магазин';
			die();
		}
		/*
		if(count($size_sistem) == 0){
			echo 'Не получил систему размеров';
			die();
		}*/
		
		//Получаем массив размеров
		$size = 1;
		if(isset($_POST['size'])){
			$size = (int)$_POST['size'];
		}
		$tmp = $Size->getSizesOnGroup($size);
		$sizes = array();
		foreach($tmp as $index => $value){
			$sizes[$value['name']] = $index;
		}
		
		//echo $shop_id;
		//echo $size_sistem;
	
		//Начинаем писать товар ================================================================
		$Size->resetAllProductQantityOnShopId($shop_id);
		
		$download_images = array();
		foreach($datas as $index => $data){
			//Получим недостающие поля
	
	//echo "<pre>";  print_r(var_dump( $data )); echo "</pre>";die();
	
			//Если дизайнер прилетел насильно... или же найдем его в таблицах (Дизайнер находится в таблице Юзерс группа 1, там же и альтернативные названия)			
			if(isset($_POST['designer']) AND is_numeric($_POST['designer']) AND $_POST['designer'] > 0){
				$data['desigber_id'] = $designer_id = $_POST['designer'];
			}else{
				$data['desigber_id'] = $designer_id = $Designer->getDesignerIdOnName($data['manufacture_name'], $shop_id);	
			}
			$data['designer'] = $Designer->getDesigner($designer_id);
			
			//Определим категорию
			$data['category_id'] = $podcategory_id = $Category->getCategoryIdOnAlternativeName($data['categoryid'], $data['categoryname'], $data['shop_id']);
		
		//echo '<br>---- '.$podcategory_id. $data['categoryname'].$data['shop_id'];
			
			//Категории и подкатегории	
			if($podcategory_id == 0){
				$podcategory_id = 14;
			}	
			//Определим категорию
			$sql = 'SELECT `category_id` FROM `'.$pp.'podcategory` WHERE `id` = "'.$podcategory_id.'";';
			$r = $mysqli->query($sql) or die($sql);
			
			if($r->num_rows > 0){
				$tmp = $r->fetch_assoc();
				$category_id = $tmp['category_id'];
					
			}
		
			//Определим есть ли такой товар
			$product_id = $Product->getProductIdOnOriginUrl($data['url']);
			
			
			//Добавляем если нашли
			if($product_id == 0){
				
				$product = array();
				$product['name'] = $ShopImportParse->getAutoReplacesIndex($data['name'], 'name');
				$product['full_name'] = $product['name'];
				
				$product['category_id'] = $category_id;
				if($data['designer'] AND isset($data['designer']['name']) AND $data['designer']['name'] != ''){
					$product['full_name'] .= ' от ' . $data['designer']['name'];
				}
				$product['origin_url'] = $data['url'];
				$product['user_id'] = $designer_id;
				$product['code'] = $data['url'];
				$product['designer_code'] = $data['id'];
				$product['is_hidden'] = 1;
				$product['text'] = '';
				
				if(isset($data['params'])){
					$product['text'] .= '<b>Характеристики:</b>';		
					foreach($data['params'] as $index2 => $value2){
						$product['text'] .= '<br><b>'.$index2.' : </b><i>'.$value2.'</i>';		
					}
					$product['text'] = $ShopImportParse->getAutoReplacesIndex($product['text'], 'params');		
				}
				$product['text'] .= $ShopImportParse->getAutoReplacesIndex($data['description'],'desc');		
				
				$product_id = $Product->addProduct($product);
				
			}
		
			unset($product);
			unset($datas[$index]['name']);
			unset($datas[$index]['url']);
			unset($datas[$index]['description']);
			unset($datas[$index]['params']);
			unset($datas[$index]['manufacture_name']);
			unset($datas[$index]['manufacture_id']);
			unset($datas[$index]['index']);
			
			//Изменяем поля
			if($product_id > 0){
				
				$product = array();
				$product['category_id'] = $category_id;
				$product['podcategory_id'] = $podcategory_id;
				$product['categorize_id'] = $podcategory_id;
				
				$product['cost'] = $data['price'];
				$product['real_cost'] = $data['price'];
				if($data['oldprice'] == 0) $data['oldprice'] = $data['price'];
				$product['old_cost'] = $data['oldprice'];
				
				
				$images = array();
				$count = 1;
				foreach($data['images'] as $image_1){
					if(strpos($image_1, '/') !== false){
						$tmp = explode('/', $image_1);
						$image = $tmp[count($tmp) - 1];
					}
					$images[$image] = $product_id.'_'.$image;
				//echo '<br>'.$count.' '.$i_name[$count];
					if(!isset($download_images[$image_1])){
						$download_images[$image_1] = $i_name[$count].'_'.$images[$image];
					}
					
					$count++;
				}
				$product['images'] = $images;
				
				if(isset($data['sizes']) AND is_array($data['sizes'])){
					$product['sizes'] = $data['sizes'];
					
					if(isset($_POST['size']) AND $_POST['size'] != '0'){
						$product['size_standart'] = $_POST['size'];
					}else{
						$product['size_standart'] = 1;
					}
				}
		
				unset($datas[$index]['price']);
				unset($datas[$index]['oldprice']);
				
				//echo '<br>'.$product['size_standart'].' -> '.$_POST['size'];
				
				$Product->editProduct($product, $product_id);
				
				//Индивидуальные данные
				$sql = 'SELECT product_id FROM `'.$pp.'product2shop` WHERE product_id="'.$product_id.'" AND shop_id="'.$shop_id.'" LIMIT 0,1;';
				$r = $mysqli->query($sql);
				if($r->num_rows == 0){
					$sql = 'INSERT INTO `'.$pp.'product2shop` SET product_id="'.$product_id.'", shop_id="'.$shop_id.'";';
					$mysqli->query($sql);
				}
				
				if(isset($data['realparametrs'])){
					if(isset($data['realparametrs']['material'])){
						foreach($data['realparametrs']['material'] as $material){
							
							$sql = 'SELECT id FROM `'.$pp.'guidematerial` WHERE upper(`name`) LIKE "'.mb_strtoupper(addslashes($material),'UTF-8').'"';
							$r = $mysqli->query($sql) or die($sql);
							if($r->num_rows > 0){
								$tmp = $r->fetch_assoc();
								
								$sql = 'DELETE FROM `'.$pp.'product2material` WHERE
												material_id = "'.$tmp['id'].'" AND product_id = "'.$product_id.'"';
								$mysqli->query($sql) or die($sql);	
								
								$sql = 'INSERT INTO `'.$pp.'product2material` SET
												material_id = "'.$tmp['id'].'",
												product_id = "'.$product_id.'"
												';
								$mysqli->query($sql) or die($sql);	
							}else{
								echo '<br>Не смог определить материал - '.$material;
							}
						}
						
					}
					
					
				}
				
				
				
			}
	
		}
	
		$_SESSION['reload'] = 0; //Ключ на несколько этапов
		$count_all = 0;
		
		foreach($download_images as $image_from => $image_to){
			//$image_to = str_replace('');
			$sql = 'INSERT INTO shop_import_pic SET `from` = "'.$image_from.'", `to`="'.$image_to.'";';
			//echo '<br>'.$sql;
			$mysqli->query($sql);
		}
		
		
	}
?>
    </div>
    </div>
	<div style="clear: both"></div>


<?php 
	echo '<h3>Данные загружены. Запустите загрузку картинок</h3>';
/*

$p = xml_parser_create();
xml_parse_into_struct($p, $simple, $vals, $index);
xml_parser_free($p);
//echo "Index array\n";
//print_r($index);
echo "\nМассив Vals\n";


header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";  print_r(var_dump( $vals )); echo "</pre>";
*/


//========================================

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
