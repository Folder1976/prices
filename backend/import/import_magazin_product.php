<?php
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



$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}

// ================= ЗАГРУЗКА КАРТИНОК
//================================================================== ИМПОРТ
	$uploaddir = DIR_IMAGE.'product/';
	$uploaddir_s = 'product/';
	include_once('class/shops.class.php');
	$Shops = new Shops($mysqli, DB_PREFIX);
	include_once('class/product.class.php');
	$Product = new Product($mysqli, DB_PREFIX);
	include_once('class/designer.class.php');
	
	$Designer = new Designer($mysqli, DB_PREFIX);
	include_once('class/category.class.php');
	$Category = new Category($mysqli, DB_PREFIX);

	include_once('class/shops.parse.class.php');
	$ShopImportParse = new ShopImportParse($mysqli, DB_PREFIX);

	$count_image = 100;
	$material_error	= array();
	//Чистка
	/*
	$sql = 'SELECT id, origin_url FROM shop_product WHERE origin_url LIKE "%stilnaya.com.ua%"';
	$r = $mysqli->query($sql);
	while($tmp = $r->fetch_assoc()){
		
		$sql = 'UPDATE shop_product SET origin_url = "'.str_replace('stilnaya.com.ua/','stilnaya.com.ua/product/view/',$tmp['origin_url']).'" WHERE id = "'.$tmp['id'].'"';
		$mysqli->query($sql);
		
		//$Product->dellProduct($tmp['id']);
	}
	die();
	*/
	
	/*
	$mysqli_stilnaya = mysqli_connect(ST__DB_SERVER_NAME,ST__DB_USER,ST__DB_PASS,ST__DB_NAME) or die("Error " . mysqli_error($mysqli_stilnaya)); 
	mysqli_set_charset($mysqli_stilnaya,"utf8");
	
	$sql = 'SELECT id, full_name AS name FROM shop_users WHERE group_id = 1';
	$r = $mysqli_stilnaya->query($sql) or die('ajax_replace_editor.php 11 '.$sql);
	$ST_postav = array();
	if($r->num_rows > 0){
		while($tmp = $r->fetch_assoc()){
			$ST_postav[$tmp['id']]['name'] = $tmp['name'];
		}
	}
	*/
	
//echo '<h1>Импорт УНИВЕРСАЛ</h1>';
set_time_limit(0);
ini_set("max_execution_time","0");
ini_set("memory_limit","256G");
error_reporting(E_ALL ^ E_DEPRECATED);

//echo phpinfo();

$sql = 'SELECT * FROM `'.DB_PREFIX.'shops` WHERE enable="1" ORDER BY name;';
$r = $mysqli->query($sql) or die($sql);

$shops = array();
while($tmp = $r->fetch_assoc()){
    $shops[$tmp['id']] = $tmp;
}

$shop_id = 0;
if(isset($_POST['shop'])) $shop_id = $_POST['shop'];

echo '<br>Кодировка сервера - '.mb_internal_encoding();



?>
<style>
	.top_select{
		float: left;
		padding: 10px;
		border: solid 1px #aacfe4;
		margin: 10px;
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
		<h1 style="margin-bottom: 10px;" class="header">Импорт товаров</h1>
	</div>

    <div style="max-width: 1375px;">
    <div class="table_body">
    
	
	<?php if(!isset($_GET['picture_load'])){ ?>
        <div class="navigation">
            <form name="import_exel_carfit" method="post" enctype="multipart/form-data">
                   
                    <div class="top_select">
						
						<div class="select_top shop" >
                            <label class="select_lable">Определи магазин сам</label>
                            <input type="checkbox" name="find_shop" checked>
                        </div>
						
                        <div class="select_top shop">
                            <label class="select_lable">Магазин</label>
                            <select class="select" name="shop" id="shop" style="width:300px;">
                                <option value="0">Выбрать...</option>
                                <?php foreach($shops as $index => $value){ 
                                        echo '<option value="'.$index.'" ';
											if($shop_id == $index) echo 'selected';
										echo ' >'.$value['name'].'</option>';
                                } ?>
                            </select>
                        </div>
						<?php
							include_once('class/size.class.php');
							$Size = new Size($mysqli, DB_PREFIX);
							include_once('class/brand.class.php');
							$Brand = new Brand($mysqli, DB_PREFIX);
						?>
		                <div class="select_top size"  style="margin-top: 10px;">
                            <label class="select_lable">Система размеров</label>
                            <select class="select" name="size" id="size" style="width:200px;">
                                <option value="0" selected>Определи сам</option>
                                <?php foreach($Size->getSizeGroups() as $index => $value){ ?>
									<?php if($index == 1){ ?>
										<option value="<?php echo $index;?>" ><?php echo $value['name'];?></option>
									<?php }else{ ?>
										<option value="<?php echo $index;?>"><?php echo $value['name'];?></option>
									<?php } ?>
								<?php } ?>
                            </select>
                        </div>
						
						<div class="select_top brand"  style="margin-top: 10px;">
                            <label class="select_lable">Дизайнер/Бренд</label>
                            <select class="select" name="designer" id="designer" style="width:200px;">
                                <option value="0">Определи сам</option>
								<?php foreach($Brand->getBrands() as $index => $value){ ?>
									<?php if(isset($_POST['designer']) AND $_POST['designer'] == $index){ ?>
										<option value="<?php echo $index;?>" select><?php echo $value['name'];?></option>
									<?php }else{ ?>
										<option value="<?php echo $index;?>"><?php echo $value['name'];?></option>
									<?php } ?>
								<?php } ?>
                            </select>
                        </div>
						
						
                    </div>
	
                    <div class="top_select">
                        <div class="select_top get_url_wrapper">
                            <label class="select_lable">УРЛ на данные</label>
                            <!--input type="file" name="file" style="width:300px;"-->
                            <input type="text" id="import_url" name="import_url" style="width: 250px;" value="<?php if(isset($_POST['import_url'])) echo $_POST['import_url'];?>"> <!--accept=".txt,image/*"-->
                                
                        </div>
						<div class="select_top get_file_wrapper"  style="margin-top: 10px;">
                            <label class="select_lable">Фаил</label>
                            <!--input type="file" name="file" style="width:300px;"-->
                            <input type="file" name="import_file"> <!--accept=".txt,image/*"-->
                                
                                <div class="ajax-respond"></div>
                            
                        </div>
						<div class="select_top get_postav_wrapper" style="display: none;">
                            <div class="no_file" style="font-size:20px;color:green;margin: 20px;">Фаил не требуется</div>
							<label class="select_lable">Выбрать поставщика</label>
								<select class="select" name="postav" id="postav" style="width:300px;">
									<option value="0">Все</option>
									<?php foreach($ST_postav as $index => $value){ 
											echo '<option value="'.$index.'" ';
												if($shop_id == $index) echo 'selected';
											echo ' >'.$value['name'].'</option>';
									} ?>
								</select>
                        </div>
						<div class="select_top get_file_wrapper"  style="margin-top: 10px;">
                            <label class="select_lable" style="color: #AA0000;">Удалить все товары и фото из этого файла!</label>
                            <input type="checkbox" name="delete_product" >
                        </div>
						<div class="select_top get_file_wrapper"  style="margin-top: 10px;">
                            <label class="select_lable" style="color: #AA0000;"
								<?php
									if(isset($_POST['is_utf8'])) echo ' checked ';
								?>
								>Фаил в кодировке UTF-8!</label>
                            <input type="checkbox" name="is_utf8" >
                        </div>
					</div>
                            
                    <div class="top_select">
                        <div class="select_top shop">
                            <label class="select_lable">Фаил</label>
                            <input type="submit" value="Загрузить" style="width:300px;">
                         </div>
                    </div>
       
                   <div class="top_select">
                        <div class="select_top shop">
							<a href="/<?php echo TMP_DIR; ?>backend/index.php?route=import/import_magazin_product.php&picture_load=true" class="load_pic">Запустить загрузчик картинок</a>
							<a href="/<?php echo TMP_DIR; ?>backend/index.php?route=import/import_magazin_product.php&picture_load=true&file_reload=true" class="load_pic">Запустить загрузчик картинок<br>Режим перезаписи</a>
                        </div>
                    </div>
       
            </form>
        </div>
		<div style="clear: both"></div>
		<style>
			.load_pic{
				padding: 5px;
				border: 1px solid gray;
				width: 300px;
				margin-top: 10px;
				display: block;
				text-align: center;
			}
		</style>
		<?php
	}
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================				
	if(isset($_GET['picture_load'])){
	
		include_once('import/import_url_getfile.php');
		include_once('import/init.class.upload_0.31.php');
		
		$count = 1;
	
	if(!isset($_SESSION['load_files'])){$_SESSION['load_files'] = 1;}
	
	$time = microtime(true);
	
	
	$load_files = (int)$_SESSION['load_files'];
	if($load_files < 1){
		$_SESSION['load_files'] = $load_files = 1;
	}
	if($load_files > 10){
		$_SESSION['load_files'] = $load_files = 10; //Лимит по файлам
	}
	
	
		//Проверим или это не устаревший фаил
		/*
		$sql = 'SELECT `id`, `to` FROM '.DB_PREFIX.'import_pic LIMIT 0, 300;';
		$r = $mysqli->query($sql) or die($sql);

		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				
				$dell = 1;
				
				$sql = 'SELECT product_id FROM '.DB_PREFIX.'product WHERE image LIKE "product/'.$row['to'].'" LIMIT 0, 1';
				$r1 = $mysqli->query($sql) or die($sql);
				if($r1->num_rows > 0){
					continue;
				}
			
				$sql = 'SELECT product_id FROM '.DB_PREFIX.'product_image WHERE image LIKE "product/'.$row['to'].'" LIMIT 0, 1';
				$r1 = $mysqli->query($sql) or die($sql);
				if($r1->num_rows > 0){
					continue;
				}
				
				
				$sql = 'DELETE FROM '.DB_PREFIX.'import_pic WHERE id = "'.$row['id'].'"';
				$mysqli->query($sql) or die($sql);
				//echo '<br>'.$sql;
			
			}
		}
	*/
	$timer_start = timer();
		$sql = 'SELECT * FROM '.DB_PREFIX.'import_pic LIMIT 0, '.$load_files.';';
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
						
						//echo ' - Загрузил';
						echo '+';
					}else{
						echo '<br>Фаил есть.';
					}
					
					
					//echo '<br><img src="'.$image_from.'" width="100px"> <img src="/'.TMP_DIR.'image/product/'.$image_to.'" width="100px">';
					//echo '<br>'.$image_from.'<br>'.$uploaddir.$image_to;


					//$sql = 'DELETE FROM fash_import_pic WHERE `from` = "'.my_url_decode($tmp['from']).'" AND `to`="'.$image_to.'";';
					$sql = 'DELETE FROM fash_import_pic WHERE `id` = "'.(int)$tmp['id'].'";';
					//echo '<br>'.$sql;
					$mysqli->query($sql);
						
				}
		$timer_end = timer();
		
echo '<br>'./*$timer_start.*/'<br>Затрачено : ';		
echo $timer_end.'c.
	<br>Количество файлов = '.$load_files.'
';

		
		if((int)$timer_end < 30){
			$_SESSION['load_files']++;
		}
		if((int)$timer_end > 30){
			$_SESSION['load_files']--;
		}
				echo '<br><br><b>Идет загрузка картинок. Пауза 3 сек. Пачка '.$load_files.' шт.</b> => '.$_SESSION['load_files'];
				?>
					<script>
						jQuery(document).ready(function(){
							console.log('reload 3 s');
							setTimeout(function(){
									location.reload();
							}, 3000);
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
				//echo "<pre>";  print_r(var_dump( $replaces )); echo "</pre>";
		
//echo phpinfo(); die();		
		?>
		
		<div class="navigation_editor" style="margin-top: 20px;">
			<div class="top_editor">
				<div class="select_top shop">
					<table>
						<tr>
							<th>#</th>
							<th>Найти слово</th>
							<th>Заменить слово</th>
							<th>Название</th>
							<th>Описание</th>
							<th>Параметры</th>
							
							<th>&nbsp;</th>
						</tr>
						<tr id="new_row">
							<td>#</td>
							<td><input type="text" class="new" id="find" placeholder="Найти фразу" value="" style="width: 300px;"></td>
							<td><input type="text" class="new" id="rep" placeholder="Заменить фразу" value="" style="width: 300px;"></td>
							<td align="center"><input type="checkbox" class="new" name="" id="name" checked></td>
							<td align="center"><input type="checkbox" class="new" name="" id="desc" checked></td>
							<td align="center"><input type="checkbox" class="new" name="" id="params" checked></td>
							<td align="center"> <a href="javascript:" class="add"><img src="/<?php echo TMP_DIR; ?>backend/img/add.png" title="удалить" width="16" height="16"></a>
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
										<img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16">
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
			<?php $table = DB_PREFIX.'import_replace'; ?>
			
			
			
			jQuery(document).on('change','#shop', function(){
				id = $(this).val();
				//console.log(id);
				jQuery.ajax({
						type: "POST",
						url: "/<?php echo TMP_DIR; ?>backend/import/ajax_replace_editor.php",
						dataType: "json",
						data: "id="+id+"&key=get_shop",
						beforeSend: function(){
							jQuery('.get_postav_wrapper').hide();
					
							jQuery('.get_url_wrapper').show();
							jQuery('.get_file_wrapper').show();
						},
						success: function(msg){
							console.log(msg );
							if (msg.modul != '') {
								jQuery('.get_postav_wrapper').show();
								jQuery('.get_url_wrapper').hide();
								jQuery('.get_file_wrapper').hide();
							}
							
							$('#import_url').val(msg['xml_url']);
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
						url: "/<?php echo TMP_DIR; ?>backend/import/ajax_replace_editor.php",
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
				 url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_guideuniversal.php",
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
					url: "/<?php echo TMP_DIR; ?>backend/import/ajax_replace_editor.php",
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
	
	echo '<br>Смена кодировки- '.mb_internal_encoding();
	
	$shop = $Shops->getShop($shop_id);
	
	$postav_id = 0;
	if(isset($_POST['postav'])){
		$postav_id = $_POST['postav'];
	}
		
	if(isset( $_FILES['import_file']['tmp_name']) OR (isset($_POST['import_url']) AND $_POST['import_url'] != '')){
	
		//Если фаил больеш 30 метров, рубим его на куски и отправляем в крон - отправим его в крон
		if($_FILES['import_file']['size'] > (30 * 1024 * 1024)){
			
			//Делим большйо фаил
			$dir = 'uploads/';
			$f = $_FILES['import_file']['tmp_name'];//'/var/www/fashion/backend/import/111/wildberries-ru_products_20161007_132243.xml';            // yназания файла базы 
			$lines = file($f); 
			
			$fc = 1; 
			
			$lc = 200; // по сколько строк в файле 
			
			$data = array();
			
			$items = 0;
			
			$fp = fopen($dir."file_".$fc.".txt", "a"); 
			//for ($i=0; $i<count($lines); $i++){ 
			for ($i=0; $i<count($lines); $i++){
				
				if(strpos($lines[$i], '<?xml') !== false) $data[0] = $lines[$i];
				if(strpos($lines[$i], '<yml_catalog') !== false) $data[1] = $lines[$i];
				if(strpos($lines[$i], '<company') !== false) $data[2] = $lines[$i];
				
				fwrite($fp, $lines[$i]); 
				
				if(strpos($lines[$i], '</offer>') !== false) $items++;
				
				if (($i/$lc==floor($i/$lc) and $i!=0) OR $items > 10){
					fwrite($fp, '</offers>'); 
					fclose($fp);
					
					$items = 0;
					$fc += 1; 
				
					$fp = fopen($dir."file_".$fc.".txt", "a");
					fwrite($fp, $data[0]);
					fwrite($fp, $data[1]);
					fwrite($fp, $data[2]); 
				}
				
			} 
			fclose($fp); 
			
			
			echo '<br><font color="red">Фил слишком большой! Он будет разделен на части и загружен в автоматическом режиме! Вы можете закрыть это окно.</font>';
			die();
		}

	
		if(isset($shop['modul']) AND $shop['modul'] != '' AND is_array($shop)){
			echo 'Какойто бред тут!';
		}elseif(isset($_FILES['import_file']['tmp_name']) AND $_FILES['import_file']['tmp_name'] != ''){
			 $tmpFilename = $_FILES['import_file']['tmp_name'];
			 $simple = file_get_contents($tmpFilename, true);
			 echo ' Получили фаил';
		}elseif( $_POST['import_url'] != ''){
			 $simple = file_get_contents($_POST['import_url']);
		}

		
		//Если стоит самоопределение магазина
		if(isset($simple)){
		
		echo '<br>Кодировка файла: '.mb_detect_encoding($simple).'<br>'; //die();
			
			//if(mb_detect_encoding($simple) == 'UTF-8'){
			if(isset($_POST['is_utf8'])){
				$html_utf8_1251 = $simple;
			}else{
				$html_utf8_1251 = mb_convert_encoding($simple, "UTF-8", "windows-1251");
			}
		$html_utf8_1251 = mb_convert_encoding($simple, "UTF-8", "auto");
				
			//Ищем все возможные теги в которых может быть магазин
			$html_utf8 = explode('<offers>', $html_utf8_1251);
			$names = array();
			
			$pat = 'company';
			$s = eregi("<$pat>(.*)</$pat>",$html_utf8_1251,$regs);
			$names[] = $regs[1];
			
			$pat = 'firmName';
			$s = eregi("<$pat>(.*)</$pat>",$html_utf8_1251,$regs);
			$names[] = $regs[1];
			/*
			$pat = 'name';
			$s = eregi("<$pat>(.*)</$pat>",$html_utf8[0],$regs);
			$names[] = $regs[1];
			*/
		}
	
		if(isset($names)){
			echo '<br>Нашел ключи магазина - '.implode(', ', $names).'<br>';
		}
		
		if(isset($_POST['find_shop']) AND $shop_id == 0){
			foreach($names as $name){
				
				if($shop_id == 0){
					$shop_id = $Shops->getShopOnXmlName($name);
				}
				
			}
		}

		
		if(isset($html_utf8_1251)){
			
			//Получим массив из файла
			$category_datas = $ShopImportParse->getArrayCategory($html_utf8_1251, $shop_id);
			//Получим массив из файла
			$datas = $ShopImportParse->getArray($html_utf8_1251, $shop_id);

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
			<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR;?>backend/libs/category_tree/type-for-get.css">
			<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/libs/category_tree/script-for-get.js"></script>
			<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/import/category_tree.js"></script>
			
			<!--script src="/js/backend/ajax_alternative_categs.js"></script-->
			<!--script>
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
				
			</script-->
		<?php
			$category_for_find = array();
			foreach($category_datas as $index => $value){
				$id = $Category->getCategoryIdOnAlternativeName($index, $value, $shop_id);


				if(is_array($id)){
				}else{
					
					$category_for_find[$index]['name'] = $category_datas[$index];
					$category_for_find[$index]['my_id'] = $id['id'];
					$category_for_find[$index]['my_name'] = $id['name'];
				}
			}
		
			if(count($category_for_find) > 0){ ?>
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
						<th>Название</th>
					</tr>
				
				<?php foreach($category_for_find as $index => $value){ ?>
					<tr id="<?php echo $index;?>" data-id="<?php echo $index;?>" data-name="<?php echo $value['name'];?>">
						<td><?php echo $index;?></td>
						<td id="categ_name<?php echo $index;?>">
						<?php if(mb_detect_encoding($value['name'], 'windows-1251', true)){
							$value['name'] = $value['name'];
						}else{
							$value['name'] = mb_convert_encoding($value['name'], "windows-1251", "utf-8");
						} ?>
					
						<?php echo $value['name']; ?></td>
						<td>
							<a href="javascript:" class="select_category" id="select_category<?php echo $index;?>" data-id="<?php echo $index;?>">Привязать...</a>
							<!--button class="btn_yes" data-id="podcategory<?php echo $index;?>">Запомнить</button-->
						</td>
					</tr>
				<?php } ?>
				</table >
				<input type="hidden" id="shop_id" value="<?php echo $shop_id;?>">
				</div>
				<?php echo '<h3>Есть не синхронизированные категории. Импорт остановлен.</h3>';
				?>
				<script>
					$(document).on('click', '.select_category', function(){
						var id = $(this).data('id');
						$('#target_categ_id').val(id);
						$('#target_categ_name').val($('#categ_name'+id).html());
						$('#container').show();
					});
					$(document).on('click', '.close_tree', function(){
						$('#container').hide();
					});
				</script>
				<?php
				$Types = array();
				$Types[0] = array("id"=>0,"name"=>"Главная");
				//=======================================================================
					$sql = 'SELECT C.category_id AS id, C.parent_id, CD.name
									FROM `'.DB_PREFIX.'category` C
									LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
									WHERE parent_id = "0" ORDER BY name ASC;';
					//echo '<br>'.$sql;
					$rs = $mysqli->query($sql) or die ("Get product type list ".mysqli_error($mysqli));
					
					$body = "
							<input type='hidden' id=\"target_categ_id\" value='0'>
							<input type='hidden' id=\"target_categ_name\" value=''>
							<input type='hidden' id=\"shop_id\" value='$shop_id'>
							<div id=\"container\" class = \"product-type-tree\"><h4>Выбрать категорию <span class='close_tree'>[закрыть]</span></h4><ul  id=\"celebTree\">
						<!--li><span id=\"span_0\"><a class = \"tree\" href=\"javascript:\" id=\"0\">Автомобили</a></span><ul-->";
					while ($Type = $rs->fetch_assoc()) {
				
					if($Type['parent_id'] == 0){
				
						$body .=  "<li><span id=\"span_".$Type['id']."\"> <a class = \"tree category_id_".$Type['id']."\" href=\"javascript:\" id=\"".$Type['id']."\">".$Type['name']."</a>";
						$body .= "</span>".readTree($Type['id'],$mysqli);
						$body .= "</li>";
					}
					$Types[$Type['id']]['id'] = $Type['id'];
					$Types[$Type['id']]['name'] = $Type['name'];
					}
					$body .= "</ul>
						</li></ul></div>";
				
					echo $body;
				
				
				
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
			echo '<br><font color="red">STOP! Не получил(не смог зачитать) данных. Возможно не верная структура файла.</font>';
			die();
		}
		
		if(count($shop_id) == 0 OR $shop_id == 0){
			echo '<br><font color="red">STOP! Не получил(не определил) магазин. Попробуйте выбрать из списка.</font>';
			die();
		}else{
			echo '<br><font color="green">Магазин определен</font>';
		}
		
		
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
		//Проверим дизайнеров (если он не насильный)
		$set_stop = 0;
		if(isset($_POST['designer']) AND is_numeric($_POST['designer']) AND $_POST['designer'] > 0){
		}else{
			
			$designers = $Designer->getDesigners();
			$finded = array();
			$count = 1;
			foreach($datas as $index => $data){
				
				if($Designer->getDesignerIdOnName($data['manufacture_name'], $shop_id) < 1){
					
					if($set_stop == 0){ ?>
					<div style="clear: both;"></div>
						<h3 style="margin-top: 20px;">Найдены новые бренды</h3>
						<table>
						<tr>
							<th>Найден бренд</th>
							<th>Выбрать из имеющихся</th>
							<th>Создать новый</th>
						</tr>
					<?php }
						$set_stop = 1;
					
					if(!isset($finded[$data['manufacture_name']])){ ?>
						<tr id="<?php echo $count++;?>"  data-name="<?php echo $data['manufacture_name'];?>">
							<td><?php echo $data['manufacture_name'];?></td>
							<td>
								<select class="edit_category_detail new_brands" id="brand_select<?php echo $count;?>" data-id="<?php echo $count;?>" style="width:300px;">
									<option label="Выбор..." value="0">Выбор...</option>
									<?php foreach($designers as $index_d => $value){ ?>
										<option value="<?php echo $index_d; ?>"><?php echo $value['name'];?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<button class="btn_add_brand" id="brand_key<?php echo $count;?>" data-name="<?php echo $data['manufacture_name'];?>" data-id="<?php echo $count;?>">Создать</button>
							</td>
						</tr>
					<?php
					}
					$finded[$data['manufacture_name']] = $data['manufacture_name'];					
				}
				
			}
			
			

			if($set_stop == 1){
				echo '</table>'; ?>
				
				<script>
				jQuery(document).on('click','.btn_add_brand', function(){
					var element = jQuery(this);
					var name = jQuery(this).data('name');
					name = name.replace("&",'@@@@');
					name = name.replace("\\",'@##@');
					
					console.log(name);
					
					jQuery.ajax({
						type: "POST",
						url: "/backend/import/ajax_replace_editor.php",
						dataType: "text",
						data: "name="+name+"&enable=1&table=fash_manufacturer&key=add",
						beforeSend: function(){
						},
						success: function(msg){
							console.log(msg);
							element.parent('td').parent('tr').css('background-color','green');
							var target = element.data('id');
							jQuery('#brand_select'+target).hide();
							element.hide();
						}
					});
						
				});
				
				jQuery(document).on('change','.new_brands', function(){
					var element = jQuery(this);
					var shop_id = <?php echo $shop_id; ?>;
					var name = jQuery(this).parent('td').parent('tr').data('name');
					var brand_id = jQuery(this).val();
					name = name.replace("&",'@@@@');
					name = name.replace("\\",'@##@');
					
					jQuery.ajax({
						type: "POST",
						url: "/backend/import/ajax_replace_editor.php",
						dataType: "text",
						data: "enable=1&brand_id="+brand_id+"&shop_id="+shop_id+"&name="+name+"&table=fash_manufacturer_alternative&key=add",
						beforeSend: function(){
						},
						success: function(msg){
							console.log(msg);
							element.parent('td').parent('tr').css('background-color','green');
							var target = element.data('id');
							jQuery('#brand_key'+target).hide();
							element.hide();
						}
					});
						
				});
				</script>
				<?php
			}
			
		}
	
	if($set_stop == 1){
		return true;
	}
		//Получим список дизайнеров
		$sql = 'SELECT * FROM '.DB_PREFIX.'manufacturer';
		$r = $mysqli->query($sql) or die($sql);
		$manuf = array();
		while($tmp = $r->fetch_assoc()){
			$manuf[$tmp['manufacturer_id']] = $tmp['name'];
		}
	
		//Начинаем писать товар ================================================================
		$Size->resetAllProductQantityOnShopId($shop_id);
	
		$shop_name = $Shops->getShopName($shop_id);
		
		$download_images = array();
		foreach($datas as $index => $data){
			//Получим недостающие поля
	
	//echo "<pre>";  print_r(var_dump( $data )); echo "</pre>";die();
	
			//Если дизайнер прилетел насильно... или же найдем его в таблицах (Дизайнер находится в таблице Юзерс группа 1, там же и альтернативные названия)			
			if(isset($_POST['designer']) AND is_numeric($_POST['designer']) AND $_POST['designer'] > 0){
				$data['designer_id'] = $designer_id = $_POST['designer'];
			}else{
				$data['designer_id'] = $designer_id = $Designer->getDesignerIdOnName($data['manufacture_name'], $shop_id);
			}
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

	
				
				$product['text'] = $ShopImportParse->getAutoReplacesIndex($data['description'],'desc');	
				if(isset($data['realparametrs']['material']) AND count($data['realparametrs']['material']) > 0){
					
					$product['text'] .= '<br><br><b>Характеристики:</b>';
					$product['text'] .= $ShopImportParse->getAutoReplacesIndex('<br><b>Материал : </b>', 'params');		
					foreach($data['realparametrs']['material'] as $index2 => $value2){
						
						$value2 = mb_strtoupper(addslashes(trim($value2)),'UTF-8');
						if(strlen($value2) > 2){
						
							$product['text'] .= $ShopImportParse->getAutoReplacesIndex(' <i>'.$value2.'</i>,', 'params');
							
							$sql = 'SELECT attribute_id, name FROM '.DB_PREFIX.'attribute_description AD
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
				//$data_P['moderation_id'] =''; //0 - Показать, 1 - Модерация, 2 - Закрыт
				//echo '<br>'.$product['name'];
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
				$data_P['product_description'][1]['description'] = htmlspecialchars($product['text'],ENT_QUOTES);
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
						$sql = 'SELECT size_id FROM `'.DB_PREFIX.'size` WHERE group_id="'.$product['size_standart'].'" AND name LIKE "'.$index.'" ';
						$rs = $mysqli->query($sql);
						if($rs->num_rows > 0){
							$tmp = $rs->fetch_assoc();
							$size_id = $tmp['size_id'];
						}else{
							$sql = 'INSERT INTO `'.DB_PREFIX.'size` SET group_id="'.$product['size_standart'].'", name = "'.$index.'", `enable`="1", sort="0";';
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
			
			//echo "<pre>";  print_r(var_dump( $download_images )); echo "</pre>";
			//die('После добавления '.$product_id);
	
		}
	
		
		
		if(isset($_POST['delete_product'])){
			$product_id = $Product->dellImages();
			die('Удалено');
		}
	
		if(count($material_error) > 0){
			echo '<h3>Не найдены материалы:</h3>';
			foreach($material_error as $index => $value){
				echo $index.', ';
			}
		}
	
		$_SESSION['reload'] = 0; //Ключ на несколько этапов
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
  //Рекурсия=================================================================
function readTree($parent,$mysqli){
	$sql = 'SELECT C.category_id AS id, C.parent_id, CD.name
				FROM `'.DB_PREFIX.'category` C
				LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
				WHERE parent_id = "'.$parent.'" ORDER BY name ASC;';
	//echo $sql.'<br>';
	$rs1 = mysqli_query( $mysqli, $sql) or die ("Get product type list");

	$body = "";

	 while ($Type = mysqli_fetch_assoc($rs1)) {
		$body .=  "<li><span id=\"span_".$Type['id']."\"><a class = \"tree category_id_".$Type['id']."\" href=\"javascript:\" id=\"".$Type['id']."\">".$Type['name']."</a>";
		$body .= "</span>".readTree($Type['id'],$mysqli);
		$body .= "</li>";
	}
	if($body != "") $body = "<ul>$body</ul>";
	return $body;

}
?>
