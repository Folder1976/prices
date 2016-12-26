<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
$type = 'shops';
$table = 'shops';
$catalog = 'shops';
$main_key = 'id';
$uploaddir = '/'.TMP_DIR.'image/'.$catalog.'/';

// Если прилетела форма - сохраним===============================
if(isset($_POST['key']) AND $_POST['key'] == 'add'){
     
	  $enable = 0;
	  if(isset($_POST['enable'])) $enable = '1';
	  
	  //Если это код 0 - новый
	    $sql = 'INSERT INTO '.DB_PREFIX.$table.' SET
				  `name` = "'.$_POST['name'].'",
		    	  `href` = "'.$_POST['href'].'",
				  `sort` = "'.$_POST['sort'].'",
				  `enable` = "'.$enable.'"
			    ;';
			//echo $sql;
	    $r = $mysqli->query($sql);
		
	echo "<H2>Добавлено! Подождите, идет сохранение.</H2><SCRIPT>\n\nvar i = setTimeout(\"window.location.href='/".TMP_DIR."backend/index.php?route=shops/shops.index.php'\", 500);\n</SCRIPT>";
}

?>
<br>
<h1>Магазины</h1>
<h2>Лого магазина. Размер 200 х 100 px!</h2>
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
	<div style="width: 90%">
		<div class="table_body">
			<table class="text">
			<tr>
				<th>Название поля</th>
				<th>Значение</th>
			</tr>
		  
			<tr>
				<td>Название</td>
				<td><input  value="<?php echo $row['name']; ?>" type="text" id="name" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	
			<tr>
				<td>Алиас</td>
				<td><input  value="<?php echo $row['href']; ?>" type="text" id="href" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	
			<tr><td colspan="2">&nbsp;</td></tr>

			<tr>
				<td>Ссылка на фаил</td>
				<td><input  value="<?php echo $row['xml_url']; ?>" type="text" id="xml_url" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	
			<tr>
				<td>Имя магазина в файле &#5176;company&#5171; или &#5176;firmName&#5171; </td>
				<td><input  value="<?php echo $row['xml_name']; ?>" type="text" id="xml_name" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
		
			<tr>
				<td>Спецмодуль (флаг)</td>
				<td><input  value="<?php echo $row['modul']; ?>" type="text" id="modul" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
		
			<tr><td colspan="2">&nbsp;</td></tr>

			<tr>
				<td>@block_name@ (белая блузка)</td>
				<td><input  value="<?php echo $row['name_sush']; ?>" type="text" id="name_sush" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	
			<tr>
				<td>@block_name_rod@ (белую блузку)</td>
				<td><input  value="<?php echo $row['name_rod']; ?>" type="text" id="name_rod" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
		
			<tr>
				<td>@block_name_several@ (белые блузки)</td>
				<td><input  value="<?php echo $row['name_several']; ?>" type="text" id="name_several" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
		
			<tr><td colspan="2">&nbsp;</td></tr>

			<tr>
				<td>Заголово Н1</td>
				<td><input  value="<?php echo $row['title_h1']; ?>" type="text" id="title_h1" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	
			<tr>
				<td>Meta_title</td>
				<td><input  value="<?php echo $row['meta_title']; ?>" type="text" id="meta_title" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
		
			<tr>
				<td>Meta_keyword</td>
				<td><input  value="<?php echo $row['meta_keyword']; ?>" type="text" id="meta_keyword" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
	
			<tr>
				<td>Meta_description</td>
				<td><input  value="<?php echo $row['meta_description']; ?>" type="text" id="meta_description" data-id="<?php echo $row['id'];?>" class="edit2" style="width:700px;"></td>
			</tr>
		
			<tr>
				<td>Описание</td>
				<td>
					<!--input  value="<?php echo $row['description']; ?>" type="text" id="description" data-id="<?php echo $row['id'];?>" class="edit" style="width:700px;"-->
					<textarea style="width: 100%; height: 400px;" id="description" data-id="<?php echo $row['id'];?>" class="edit description calculation_text product_names main_text_textarea" name="description"><?php echo htmlspecialchars_decode($row['description'], ENT_QUOTES); ?></textarea>
				</td>
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
				<td><input type="checkbox" name="enable" class="enable" data-id="0" checked></td>
				<td></td>
				<td></td>
				<td>
					<table><tr><td>
						<br>Название</b></td><td><input type="text" name="name" class="name" data-id="0" style="width:400px;" value="" placeholder="Название магазина">
						</td></tr><tr><td>
						<br>ЧПУ</b></td><td><input type="text" name="href" id="href" class="href" data-id="0" style="width:400px;" value="" placeholder="URL">
						</td></tr><tr><td>
						<br>Сортировка</b></td><td><input type="sort" name="sort" class="sort" data-id="0" style="width:400px;" value="0" placeholder="0">
					</td></tr></table>
				</td>
				<td colspan="1"><input type="submit" name="key" value="add" style="width:50px;"></td>
				<td colspan="2">Фото после добавляния</td>
			</tr></form>
	
	<?php while($value = $r->fetch_assoc()){ ?>
	 <tr id="<?php echo $value['id']; ?>">
		  <td><?php echo $value['id']; ?></td>
		  <td><img src="<?php echo $uploaddir.$value['image']; ?>" width="125" height="125">
		  </td>
		  <td><input type="checkbox" id="enable<?php echo $value['id']; ?>" class="enable edit" data-id="<?php echo $value['id']; ?>" <?php if($value['enable'] == 1) echo ' checked '; ?> ></td>
		  <td><input type="radio" name="on_main_page" class="on_main_page" value="<?php echo $value['id']; ?>" data-id="<?php echo $value['id']; ?>"
			<?php if($value['on_main_page'] == 1) echo ' checked '; ?>
		  ></td>
		  <td style="text-align: center;"><a href="/<?php echo TMP_DIR;?>backend/index.php?route=shops/shops.index.php&shop_id=<?php echo $value['id'];?>">ДЕТАЛЬНО</a></td>
		  <td>
			<table><tr><td>
				<br>Название</b></td><td><input type="text" id="name<?php echo $value['id'];?>" class="name edit" data-id="<?php echo $value['id'];?>" style="width:400px;" value="<?php echo $value['name']; ?>">
				</td></tr><tr><td>
				<br>ЧПУ</b></td><td><input type="text" id="href<?php echo $value['id']; ?>" class="href edit" data-id="<?php echo $value['id'];?>" style="width:400px;" value="<?php echo $value['href']; ?>">
				</td></tr><tr><td>
				<br>Сортировка</b></td><td><input type="text" id="sort<?php echo $value['id'];?>" class="sort edit" data-id="<?php echo $value['id']; ?>" style="width:400px;" value="<?php echo $value['sort']; ?>">
				
			</td></tr></table>
		  </td>
	  
		  <td>
			<a href="javascript:" class="dell" id="dell_<?php echo $value['baner_id']; ?>"><img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16"></a>
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
		var enable = '0';
		var name = $('#name'+id).val();
		var href = $('#href'+id).val();
		var sort = $('#sort'+id).val();
		
		//console.log($('#enable'+id).prop('checked'));
		if ($('#enable'+id).prop('checked')) {
            enable = '1' ;
        }
		
		 $.ajax({
		type: "POST",
		url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
		dataType: "text",
		data: "id="+id+"&enable="+enable+"&name="+name+"&href="+href+"&mainkey=<?php echo $main_key;?>&table=<?php echo $table; ?>&key=edit",
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