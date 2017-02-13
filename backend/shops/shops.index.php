<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
$type = 'shops';
$table = 'shop';
$catalog = 'shops';
$main_key = 'id';
$uploaddir = '/'.TMP_DIR.'image/'.$catalog.'/';

// Если прилетела форма - сохраним===============================
if(isset($_POST['key']) AND $_POST['key'] == 'add'){
     
	  $status = 0;
	  if(isset($_POST['status'])) $status = '1';
	  
	  //Если это код 0 - новый
	    $sql = 'INSERT INTO '.DB_PREFIX.$table.' SET
				  `name` = "'.$_POST['name'].'",
		    	  `href` = "'.$_POST['href'].'",
				  `siteurl` = "'.$_POST['siteurl'].'",
				  `sort` = "'.$_POST['sort'].'",
				  `status` = "'.$status.'"
			    ;';
			//echo $sql;
	    $r = $mysqli->query($sql);
		
	echo "<H2>Добавлено! Подождите, идет сохранение.</H2><SCRIPT>\n\nvar i = setTimeout(\"window.location.href='/".TMP_DIR."backend/index.php?route=shops/shops.index.php'\", 500);\n</SCRIPT>";
}

?>
<br>
<h3>Магазины</h3>
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

$shop_id = 0;

if(isset($_GET['shop_id']) AND is_numeric($_GET['shop_id'])){
	$shop_id = (int)$_GET['shop_id'];
	$sql = 'SELECT * FROM '.DB_PREFIX.$table.' WHERE id = '.(int)$_GET['shop_id'].';';
	$r = $mysqli->query($sql);
	$row = $r->fetch_assoc();
?>
	<a href="/backend/index.php?route=shops/shops.index.php">К списку магазинов</a>
	<div style="width: 90%">
		<div class="table_body">
			<table class="text">
			<tr>
				<th>Название поля</th>
				<th>Значение</th>
			</tr>
		  
			<tr>
				<td>Название RUS</td>
				<td><input  value="<?php echo $row['name']; ?>" type="text" id="name" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
			<tr>
				<td>Metatitle RUS</td>
				<td><input  value="<?php echo $row['metatitle']; ?>" type="text" id="metatitle" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
			<tr>
				<td>Metakeywords RUS</td>
				<td><input  value="<?php echo $row['metakeywords']; ?>" type="text" id="metakeywords" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
			<tr>
				<td>Metadesc RUS</td>
				<td><input  value="<?php echo $row['metakeywords']; ?>" type="text" id="metadesc" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	
			<tr>
				<td>Название RM</td>
				<td><input  value="<?php echo $row['name_rm']; ?>" type="text" id="name_rm" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
			<tr>
				<td>Metatitle RM</td>
				<td><input  value="<?php echo $row['metatitle_rm']; ?>" type="text" id="metatitle_rm" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
			<tr>
				<td>Metakeywords RM</td>
				<td><input  value="<?php echo $row['metakeywords_rm']; ?>" type="text" id="metakeywords_rm" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
			<tr>
				<td>Metadesc RM</td>
				<td><input  value="<?php echo $row['metakeywords_rm']; ?>" type="text" id="metadesc_rm" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	
			<tr>
				<td>Название EN</td>
				<td><input  value="<?php echo $row['name_en']; ?>" type="text" id="name_en" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
			<tr>
				<td>Metatitle EN</td>
				<td><input  value="<?php echo $row['metatitle_en']; ?>" type="text" id="metatitle_en" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
			<tr>
				<td>Metakeywords EN</td>
				<td><input  value="<?php echo $row['metakeywords_en']; ?>" type="text" id="metakeywords_en" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
			<tr>
				<td>Metadesc EN</td>
				<td><input  value="<?php echo $row['metakeywords_en']; ?>" type="text" id="metadesc_en" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	
			<tr>
				<td>Телефон</td>
				<td><input  value="<?php echo $row['phone']; ?>" type="text" id="phone" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	
			<tr>
				<td>Город</td>
				<td><input  value="<?php echo $row['cityid']; ?>" type="text" id="cityid" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	
			<tr>
				<td>Адрес</td>
				<td><input  value="<?php echo $row['address']; ?>" type="text" id="address" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
		
			<tr>
				<td>Рабочее время</td>
				<td><input  value="<?php echo $row['worktime']; ?>" type="text" id="worktime" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
		
	<tr><td colspan="2">&nbsp;</td></tr>

			<tr>
				<td>Кредит</td>
				<td><input  value="<?php echo $row['credit']; ?>" type="text" id="credit" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	
			<tr>
				<td>Counter</td>
				<td><input  value="<?php echo $row['counter']; ?>" type="text" id="counter" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
		
			<tr>
				<td>VIP</td>
				<td><input  value="<?php echo $row['vip']; ?>" type="text" id="vip" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
		
			<tr><td colspan="2">&nbsp;</td></tr>

			<tr>
				<td>опции импорта</td>
				<td><input  value="<?php echo $row['importopt']; ?>" type="text" id="importopt" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	
			<tr>
				<td>Слайдер</td>
				<td><input  value="<?php echo $row['slider']; ?>" type="text" id="slider" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
		
			<tr>
				<td>Валюта</td>
				<td><input  value="<?php echo $row['valuteid']; ?>" type="text" id="valuteid" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	
			</table>
		</div>
		
	<script type="text/javascript" src="/<?php echo TMP_DIR; ?>admin/view/javascript/bootstrap/js/bootstrap.min.js"></script>
	<link href="/<?php echo TMP_DIR; ?>admin/view/stylesheet/bootstrap.css" type="text/css" rel="stylesheet" />
	<link href="/<?php echo TMP_DIR; ?>admin/view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
	<link href="/<?php echo TMP_DIR; ?>admin/view/javascript/summernote/summernote.css" rel="stylesheet" />
	<script type="text/javascript" src="/<?php echo TMP_DIR; ?>admin/view/javascript/summernote/summernote.js"></script>
	<script>

	</script>
	
<?php }else{

	$sql = 'SELECT * FROM '.DB_PREFIX.$table.' ORDER BY sort, name;';
	$r = $mysqli->query($sql);
	?>
	<div style="width: 90%">
		<div class="table_body">
			<table class="text">
			<tr>
				<th>#</th>
				<th> + + + </th>
				<th>Показывать</th>
				<th>На главную</th>
				<th></th>
				<th>Тексты</th>
				<th colspan="2"></th>
			</tr>
		  
			<tr><form method=post>
				<td>новый<input type="hidden" name="id0" value=""></td>
				<td><!--img src="reklama/img/large_banner_help.jpg" width="125"--></td>
				<td><input type="checkbox" name="status" class="status" data-id="0" checked></td>
				<td></td>
				<td></td>
				<td>
					<br><b>Название</b> : <input type="text" name="name" class="name" data-id="0" style="width:400px;" value="" placeholder="Название магазина">
					<br><b>Сайт</b> : <input type="text" name="siteurl" class="name" data-id="0" style="width:400px;" value="" placeholder="Сайт">
					<br><b>ЧПУ</b> : <input type="text" name="href" id="href" class="href" data-id="0" style="width:400px;" value="" placeholder="URL">
					<br><b>Сортировка</b> : <input type="sort" name="sort" class="sort" data-id="0" style="width:40px;" value="0" placeholder="0">
				</td>
				<td colspan="1"><input type="submit" name="key" value="add" style="width:50px;"></td>
				<td colspan="2">Фото после добавляния</td>
			</tr></form>
	
	<?php while($value = $r->fetch_assoc()){ ?>
	 <tr id="<?php echo $value['id']; ?>">
		  <td><?php echo $value['id']; ?></td>
		  <td><img src="<?php echo $value['image']; ?>" width="125" height="125">
		  </td>
		  <td><input type="checkbox" id="status<?php echo $value['id']; ?>" class="status edit" data-id="<?php echo $value['id']; ?>" <?php if($value['status'] == 1) echo ' checked '; ?> ></td>
		  <td><input type="checkbox" id="on_main_page<?php echo $value['id']; ?>" class="on_main_page edit" value="<?php echo $value['id']; ?>" data-id="<?php echo $value['id']; ?>"
			<?php if($value['on_main_page'] == 1) echo ' checked '; ?>
		  ></td>
		  <td style="text-align: center;">
			<a href="/<?php echo TMP_DIR;?>backend/index.php?route=shops/shops.index.php&shop_id=<?php echo $value['id'];?>">ДЕТАЛЬНО</a><br><br>
			<a href="/<?php echo TMP_DIR;?>backend/index.php?route=shops/address.index.php&shop_id=<?php echo $value['id'];?>">АДРЕСА</a>
		  </td>
		  <td>
			<br><b>Название</b> : <input type="text" id="name<?php echo $value['id'];?>" class="name edit" data-id="<?php echo $value['id'];?>" style="width:400px;" value="<?php echo $value['name']; ?>">
			<br><b>Сайт</b> : <input type="text" id="siteurl<?php echo $value['id'];?>" class="siteurl edit" data-id="<?php echo $value['id'];?>" style="width:400px;" value="<?php echo $value['siteurl']; ?>">
			<br><b>ЧПУ</b> : <input type="text" id="href<?php echo $value['id']; ?>" class="href edit" data-id="<?php echo $value['id'];?>" style="width:400px;" value="<?php echo $value['href']; ?>">
			<br><b>Сортировка</b> : <input type="text" id="sort<?php echo $value['id'];?>" class="sort edit" data-id="<?php echo $value['id']; ?>" style="width:40px;" value="<?php echo $value['sort']; ?>">
		  </td>
	  
		  <td>
			<a href="javascript:" class="dell" id="dell_<?php echo $value['id']; ?>"><img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16"></a>
		  </td>
		
		  <td>
			<form enctype="multipart/form-data" method="post" action="main_page/load_photo.php">
			  <input type="hidden" name="type" value="<?php echo $type; ?>">
			  <input type="hidden" name="MAX_FILE_SIZE" value="'.(1048*1048*1048).'">
			  <input type="hidden" name="filename"  value="<?php echo $value['id']; ?>">
			  <input type="file" min="1" max="999" multiple="false" style="width:250px"  name="userfile" OnChange="submit();"/>
			</form>
		  </td>
		  
		  </tr>
	  
	<?php } ?>
	
		</table>
		</div>
	</div>
	
<?php } ?>
  <script>
/*
		$('#description').summernote({
			height: 500,
			width: 700
		});
		
		$("#description").summernote({
			onChange: function(e) {
					var id = "<?php echo $shop_id; ?>";
					var name = 'description';
					var value = e;
					
					value = value.replace('&','@*@');
					
					$.ajax({
						type: "POST",
						url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
						dataType: "text",
						data: "id="+id+"&"+name+"="+value+"&mainkey=<?php echo $main_key;?>&table=<?php echo $table; ?>&key=edit",
						beforeSend: function(){
						},
						success: function(msg){
						}
					});		
				
				}    // callback as option 
		});

	*/
	/*
	$(document).on('change','.on_main_page', function(){
			
		var id = $(this).val();
		var radio_name = "on_main_page";
		console.log(id);
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			dataType: "text",
			data: "id="+id+"&radio_name="+radio_name+"&mainkey=<?php echo $main_key;?>&table=<?php echo $table; ?>&key=set_radio",
			beforeSend: function(){
			},
			success: function(msg){
			  console.log(  msg );
			  //$('#msg').html('Изменил');
			  //setTimeout($('#msg').html(''), 1000);
			}
		});
	
	});
	*/
	
	$(document).on('change','.edit2', function(){
		//debugger;
		var id = jQuery(this).data('id');
		var name = $(this).attr('id');
		var value = $(this).val();
		
		value = value.replace('&','@*@');
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			dataType: "text",
			data: "id="+id+"&"+name+"="+value+"&mainkey=<?php echo $main_key;?>&table=<?php echo $table; ?>&key=edit",
			beforeSend: function(){
			},
			success: function(msg){
			  console.log(  msg );
			  //$('#msg').html('Изменил');
			  //setTimeout($('#msg').html(''), 1000);
			}
		});
		
	});
	
	$(document).on('change','.edit', function(){
		
		
		var id = jQuery(this).parent('td').parent('tr').attr('id');
		var status = '0';
		var on_main_page = '0';
		var name = $('#name'+id).val();
		var href = $('#href'+id).val();
		var siteurl = $('#siteurl'+id).val();
		var sort = $('#sort'+id).val();
		
		if ($('#status'+id).prop('checked')) {
            status = '1' ;
        }
		
		if ($('#on_main_page'+id).prop('checked')) {
            on_main_page = '1' ;
        }
		
		 $.ajax({
		type: "POST",
		url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
		dataType: "text",
		data: "id="+id+"&on_main_page="+on_main_page+"&siteurl="+siteurl+"&siteurl="+siteurl+"&status="+status+"&name="+name+"&href="+href+"&mainkey=<?php echo $main_key;?>&table=<?php echo $table; ?>&key=edit",
		beforeSend: function(){
		},
		success: function(msg){
		  console.log(  msg );
		  //$('#msg').html('Изменил');
		  //setTimeout($('#msg').html(''), 1000);
		}
	  });
		
	});
	
	
   	//Удаление
   $(document).on('click','.dell', function(){
       var id = jQuery(this).parent('td').parent('tr').attr('id');
      
		if (confirm('Вы действительно желаете удалить баннер?')){
			$.ajax({
				type: "POST",
				url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
				dataType: "text",
				data: "id="+id+"&table=shop_address&mainkey=magazinid&key=dell",
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
		  
		} 
    });
  </script>