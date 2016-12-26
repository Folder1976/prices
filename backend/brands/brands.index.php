<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
$type = 'brands';
$table = 'manufacturer';
$catalog = 'brands';
$main_key = 'manufacturer_id';
$uploaddir = '/'.TMP_DIR.'image/'.$catalog.'/';

//=========================================================================================================================
$sql = 'SELECT manufacturer_id, name FROM '.DB_PREFIX.$table.' WHERE href = "";';
$r = $mysqli->query($sql);
while($row = $r->fetch_assoc()){
	$href = $row['name'];
	$href = strtolower(translitArtkl(trim($href)));
	$sql = 'UPDATE '.DB_PREFIX.$table.' SET href = "'.$href.'" WHERE manufacturer_id = "'.$row['manufacturer_id'].'";';
	$mysqli->query($sql);
	
	$sql = 'DELETE FROM '.DB_PREFIX.'url_alias SET query = "manufacturer_id='.$row['manufacturer_id'].'";';
	$mysqli->query($sql);
	$sql = 'INSERT INTO '.DB_PREFIX.'url_alias SET query = "manufacturer_id='.$row['manufacturer_id'].'", keyword="'.$href.'";';
	$mysqli->query($sql);
}
function translitArtkl($str) {
  $rus = array('и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
  $lat = array('u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
 return str_replace($rus, $lat, $str);
}
//=========================================================================================================================


// Если прилетела форма - сохраним===============================
if(isset($_POST['key']) AND $_POST['key'] == 'add'){
     
	  $enable = 0;
	  if(isset($_POST['enable'])) $enable = '1';
	   $on_main_page = 0;
	  if(isset($_POST['on_main_page'])) $on_main_page = '1';
	  
	  //Если это код 0 - новый
	    $sql = 'INSERT INTO '.DB_PREFIX.$table.' SET
				  `name` = "'.$_POST['name'].'",
		    	  `href` = "'.$_POST['href'].'",
				  `sort_order` = "'.$_POST['sort_order'].'",
				  `enable` = "'.$enable.'",
				  `on_main_page` = "'.$on_main_page.'"
			    ;';
			//echo $sql;
	    $r = $mysqli->query($sql);
		
		$manufacturer_id = $mysqli->insert_id;
		
		$sql = 'INSERT INTO '.DB_PREFIX.'url_alias SET query = "manufacturer_id='.$manufacturer_id.'", keyword="'.$_POST['href'].'";';
		$mysqli->query($sql);
		echo "<H2>Добавлено! Подождите, идет сохранение.</H2><SCRIPT>\n\nvar i = setTimeout(\"window.location.href='/".TMP_DIR."backend/index.php?route=brands/brands.index.php'\", 500);\n</SCRIPT>";
}
?>
<br>
<h1>Бренды/Дизайнеры</h1>
<h2>Лого магазина. Размер 115 х 58 px!</h2>
<style>
 .table tr td {
	border: 1px solid gray;
	margin: 0;
	border-spacing: 0;
	border-collapse: collapse;
	padding: 10px 5px 10px 5px;
 }
 .table tr th {
	border: 1px solid gray;
	margin: 0;
	border-spacing: 0;
	border-collapse: collapse;
 }
 .table {
	border: 1px solid gray;
	margin: 0;
	border-spacing: 0;
	border-collapse: collapse;
 }

</style>
<?php

//Загоним массив СЕО алиасов
$sql = 'SELECT id, url FROM `'.DB_PREFIX.'alias_description`;';
$r = $mysqli->query($sql) or die('Не удалось получить Фильтры '.$sql);

$aliases = array();

if($r->num_rows > 0){
	while($tmp = $r->fetch_assoc()){
		$aliases[strtolower($tmp['url'])] = $tmp['id'];
	}
}

$sql = 'SELECT
				T.manufacturer_id,
				T.name,
				T.on_main_page,
				T.image,
				T.sort_order,
				T.enable,
				ua.keyword AS href
			FROM '.DB_PREFIX.$table.' T
			LEFT JOIN ' . DB_PREFIX . 'url_alias ua ON ua.query = CONCAT("manufacturer_id=",T.manufacturer_id)
		ORDER BY sort_order, name;';
$r = $mysqli->query($sql);

//echo "<pre>";  print_r(var_dump( $aliases )); echo "</pre>";
?>
<div style="width: 90%">
    <div class="table_body">
        <table class="text">
		<tr>
			<th>#</th>
			<th> + + + </th>
			<th>Показывать</th>
			<th>На главной странице</th>
			<th>Тексты</th>
			<th style="width: 70px;">CEO</th>
			<th colspan="2"></th>
		</tr>
      
		<tr><form method=post>
			<td>новый<input type="hidden" name="id0" value=""></td>
			<td><!--img src="reklama/img/large_banner_help.jpg" width="125"--></td>
			<td><input type="checkbox" name="enable" class="enable" data-id="0" checked></td>
			<td><input type="checkbox" name="on_main_page" class="on_main_page" data-id="0" checked></td>
			<td>
			  <br>Название</b> : <input type="text" name="name" class="name" data-id="0" style="width:400px;" value="" placeholder="Название магазина">
			  <br>ЧПУ</b> : <input type="text" name="href" id="href" class="href" data-id="0" style="width:400px;" value="" placeholder="URL">
			  <br>Сортировка</b> : <input type="sort_order" name="sort_order" class="sort_order" data-id="0" style="width:400px;" value="0" placeholder="0">
			</td>
			<td></td>
			<td colspan="1"><input type="submit" name="key" value="add" style="width:50px;"></td>
			<td colspan="2">Фото после добавляния</td>
		</tr></form>

<?php while($value = $r->fetch_assoc()){ ?>
 <tr id="<?php echo $value[$main_key]; ?>">
      <td><?php echo $value[$main_key]; ?></td>
	  <td><img src="<?php echo $uploaddir.$value['image']; ?>" width="115" height="58">
	  </td>
	  <td><input type="checkbox" id="enable<?php echo $value[$main_key]; ?>" class="enable edit" data-id="<?php echo $value[$main_key]; ?>" <?php if($value['enable'] == 1) echo ' checked '; ?> ></td>
      <td><input type="checkbox" id="on_main_page<?php echo $value[$main_key]; ?>" class="on_main_page edit" data-id="<?php echo $value[$main_key]; ?>" <?php if($value['on_main_page'] == 1) echo ' checked '; ?> ></td>
      <td>
		  <br>Название</b> : <input type="text" id="name<?php echo $value[$main_key];?>" class="name edit" data-id="<?php echo $value[$main_key];?>" style="width:400px;" value="<?php echo $value['name']; ?>">
		  <br>ЧПУ</b> : <input type="text" id="href<?php echo $value[$main_key]; ?>" class="href edit" data-id="<?php echo $value[$main_key];?>" style="width:400px;" value="<?php echo $value['href']; ?>">
		  <br>Сортировка</b> : <input type="text" id="sort_order<?php echo $value[$main_key];?>" class="sort_order edit" data-id="<?php echo $value[$main_key]; ?>" style="width:400px;" value="<?php echo $value['sort_order']; ?>">
	  </td>
		<td>
			<?php if(isset($aliases[ $value['href']])){ ?>
				<a href="/backend/index.php?route=seo/seo.index.php&amp;seoedit=<?php echo $aliases[ $value['href']]; ?>" target="_blank">тут СЕО</a>
			<?php }else{ ?>
				<a href="/backend/index.php?route=seo/seo.index.php&amp;seoedit=0" target="_blank">нет сео</a>
			<?php } ?>
			
		</td>
	  <td>
		<a href="javascript:" class="dell" id="dell_<?php echo $value['baner_id']; ?>"><img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16"></a>
	  </td>
	
	  <td>
		<form enctype="multipart/form-data" method="post" action="main_page/load_photo.php">
		  <input type="hidden" name="type" value="<?php echo $type; ?>">
		  <input type="hidden" name="MAX_FILE_SIZE" value="'.(1048*1048*1048).'">
		  <input type="hidden" name="filename"  value="<?php echo $value[$main_key]; ?>">
		  <input type="file" min="1" max="999" multiple="false" style="width:250px"  name="userfile" OnChange="submit();"/>
		</form>
	  </td>
	  
      </tr>
  
<?php } ?>

	</table>
	</div>
</div>
  <script>
		
	  $(document).on('change','.edit', function(){
		var id = jQuery(this).parent('td').parent('tr').attr('id');
		var enable = '0';
		var on_main_page = '0';
		var name = $('#name'+id).val();
		var href = $('#href'+id).val();
		var sort_order = $('#sort_order'+id).val();
		
		name = name.replace('&','@*@');
		href = href.replace('&','@*@');
		
		//console.log($('#enable'+id).prop('checked'));
		if ($('#enable'+id).prop('checked')) {
            enable = '1' ;
        }
		
		if ($('#on_main_page'+id).prop('checked')) {
            on_main_page = '1' ;
        }
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			dataType: "text",
			data: "id="+id+"&on_main_page="+on_main_page+"&enable="+enable+"&name="+name+"&href="+href+"&sort_order="+sort_order+"&mainkey=<?php echo $main_key;?>&table=<?php echo $table; ?>&key=edit",
			beforeSend: function(){
			},
			success: function(msg){
			  console.log(  msg );
			  //$('#msg').html('Изменил');
			  //setTimeout($('#msg').html(''), 1000);
			}
		});
		
		$.ajax({
		  type: "POST",
		  url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
		  dataType: "text",
		  data: "id=manufacturer_id*1*"+id+"&table=url_alias&mainkey=query&key=dell",
		  beforeSend: function(){
			
		  },
		  success: function(msg){
			 console.log(  msg );
			  }
		});
		setTimeout(function(){
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			dataType: "text",
			data: "query=manufacturer_id*1*"+id+"&keyword="+href+"&mainkey=query&table=url_alias&key=add",
			beforeSend: function(){
			},
			success: function(msg){
			  console.log(  msg );
			  //$('#msg').html('Изменил');
			  //setTimeout($('#msg').html(''), 1000);
			}
		})
		 }, 1000);
		
	});
	
   	//Удаление
   $(document).on('click','.dell', function(){
       var id = jQuery(this).parent('td').parent('tr').attr('id');
      
	  if (confirm('Вы действительно желаете удалить баннер?')){
		$.ajax({
		  type: "POST",
		  url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
		  dataType: "text",
		  data: "id="+id+"&table=<?php echo $table; ?>&mainkey=<?php echo $main_key;?>&key=dell",
		  beforeSend: function(){
			
		  },
		  success: function(msg){
			console.log(  msg );
			location.reload;
			jQuery('#'+id).hide()
			//$('#msg').html('Удалил');
			//setTimeout($('#msg').html(''), 1000);
		  }
		});
		$.ajax({
		  type: "POST",
		  url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
		  dataType: "text",
		  data: "id=manufacturer_id*1*"+id+"&table=url_alias&mainkey=query&key=dell",
		  beforeSend: function(){
			
		  },
		  success: function(msg){
			console.log(  msg );
			location.reload;
			jQuery('#'+id).hide()
			//$('#msg').html('Удалил');
			//setTimeout($('#msg').html(''), 1000);
		  }
		});
	  } 
    });
  </script>