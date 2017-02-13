<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
$type = 'baner_line';
$table = 'baner_line';
$catalog = 'baner_line';
$main_key = 'baner_line_id';
$uploaddir = '/'.TMP_DIR.'image/banners/'.$catalog.'/';

// Если прилетела форма - сохраним===============================
if(isset($_POST['key']) AND $_POST['key'] == 'add'){
     
	  $is_view = 0;
	  if(isset($_POST['enable'])) $is_view = '1';
	  
	  //Если это код 0 - новый
	    $sql = 'INSERT INTO '.DB_PREFIX.$table.' SET
					name = "'.$_POST['name'].'",
					href = "'.$_POST['href'].'",
					sort = "'.$_POST['sort'].'",
		    	 	enable = "'.$is_view.'"
			    ;';

	    $r = $mysqli->query($sql);
		
	echo "<H2>Добавлено! Подождите, идет сохранение.</H2><SCRIPT>\n\nvar i = setTimeout(\"window.location.href='/".TMP_DIR."backend/index.php?route=main_page/main_page.index.php&modul=main_page.baner_line.php'\", 500);\n</SCRIPT>";
}
?>
<br>
<h1>Строки для банера. Картинки размеров 50px</h1>
<!--h2>Обязательно наличие 3 активных банеров!</h2-->
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
$sql = 'SELECT * FROM '.DB_PREFIX.'baner_line ORDER BY name ASC;';
$r = $mysqli->query($sql);
?>
<div style="width: 50%">
    <div class="table_body">
        <table class="text">
		<tr>
			<th>#</th>
			<th>Банер с лева</th>
			<th>Банер с права</th>
			<th>Показывать</th>
			<th>Сорт</th>
			<th>Тексты</th>
			<th colspan="1"></th>
		</tr>
      
		<tr><form method=post>
			<td>новый<input type="hidden" name="id0" value=""></td>
			<td><!--img src="reklama/img/large_banner_help.jpg" width="250"--></td>
			<td><!--img src="reklama/img/large_banner_help.jpg" width="250"--></td>
			<td><input type="checkbox" name="enable" class="brand" data-id="0" checked></td>
			<td>
			  <br><b>Внутреннее название [на сайте не отображается]</b> : <input type="text" name="name" class="brand" data-id="0" style="width:600px;" value="" placeholder="Имя - для памятки">
			  <br><b>Куда ведет банер [url]</b> : <input type="text" name="href" id="href" class="brand" data-id="0" style="width:600px;" value="" placeholder="URL">
			  <br><b>Сорт</b> : <input type="text" name="sort" class="brand" data-id="0" style="width:40px;" value="1" placeholder="0">
			</td>
			<td colspan="1"><input type="submit" name="key" value="add" style="width:50px;"></td>
		</tr></form>

<?php while($value = $r->fetch_assoc()){ ?>
 <tr id="<?php echo $value[$main_key]; ?>">
      <td><?php echo $value[$main_key]; ?></td>
	  <td>
		<?php if($value['image_left'] != ''){ ?>
			<img src="<?php echo $value['image_left']; ?>" width="50px" height="50px" >
		<?php } ?>
			<form enctype="multipart/form-data" method="post" action="main_page/load_photo.php">
				<input type="hidden" name="type" value="<?php echo $type; ?>_left">
				<input type="hidden" name="MAX_FILE_SIZE" value="'.(1048*1048*1048).'">
				<input type="hidden" name="filename"  value="<?php echo $value[$main_key]; ?>">
				<input type="file" min="1" max="999" multiple="false" style="width:250px"  name="userfile" OnChange="submit();"/>
			</form>
	  <td>
		<?php if($value['image_right'] != ''){ ?>
			<img src="<?php echo $value['image_right']; ?>" width="50px" height="50px" >
		<?php } ?>
			<form enctype="multipart/form-data" method="post" action="main_page/load_photo.php">
				<input type="hidden" name="type" value="<?php echo $type; ?>_right">
				<input type="hidden" name="MAX_FILE_SIZE" value="'.(1048*1048*1048).'">
				<input type="hidden" name="filename"  value="<?php echo $value[$main_key]; ?>">
				<input type="file" min="1" max="999" multiple="false" style="width:250px"  name="userfile" OnChange="submit();"/>
			</form>
	  </td>
	  <td><input type="checkbox" id="enable<?php echo $value[$main_key]; ?>" class="brand edit" data-id="<?php echo $value[$main_key]; ?>" <?php if($value['enable'] == 1) echo ' checked '; ?> ></td>
      <td>
			<br><b>Внутреннее название [на сайте не отображается]</b> : <input type="text" id="name<?php echo $value[$main_key];?>" class="brand edit" data-id="<?php echo $value[$main_key];?>" style="width:600px;" value="<?php echo $value['name']; ?>">
			<br><b>Куда ведет банер [url]</b> : <input type="text" id="href<?php echo $value[$main_key]; ?>" class="brand edit" data-id="<?php echo $value[$main_key];?>" style="width:600px;" value="<?php echo $value['href']; ?>">
			<br><b>Сорт</b> : <input type="text" id="sort<?php echo $value[$main_key]; ?>" class="brand edit" data-id="<?php echo $value[$main_key];?>" style="width:40px;" value="<?php echo $value['sort']; ?>">
		  
			<?php
				$sql = 'SELECT * FROM '.DB_PREFIX.'language ORDER BY language_id ASC;';
				$r_lang = $mysqli->query($sql);
			?>
			<?php while($row = $r_lang->fetch_assoc()){ ?>
				<?php
					$sql = 'SELECT * FROM '.DB_PREFIX.'baner_line_description 
								WHERE baner_line_id = "'.$value[$main_key].'" AND language_id="'.$row['language_id'].'" LIMIT 1;';
					$r_desc = $mysqli->query($sql);
				
					if($r_desc->num_rows){
						$row_2 = $r_desc->fetch_assoc();
					}else{
						$row_2 = array(
									   'text'=>''
									   );
					}
				?>
					<br>
					<br><b><?php echo $row['name']; ?></b>
					<br><b>Текст</b> : <input type="text" id="text" style="width:600px;" data-id_name="baner_line_id" data-language_id="<?php echo $row['language_id']; ?>" class="brand edit_description" data-id="<?php echo $value[$main_key]; ?>" style="width:600px;" value="<?php echo $row_2['text']; ?>">
				<?php } ?>
	  </td>
  
	  <td>
		<a href="javascript:" class="dell" id="dell_<?php echo $value[$main_key]; ?>"><img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16"></a>
	  </td>

    </tr>
  
<?php } ?>

	</table>
	</div>
</div>
  <script>
	
	$(document).on('change','.edit_description', function(){
		var id = $(this).data('id');
		var id_name = $(this).data('id_name');
		var fild = $(this).attr('id');
		var value = $(this).val();
		var lang = $(this).data('language_id');
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_statik.php",
			dataType: "text",
			data: "id="+id+"&fild="+fild+"&value="+value+"&id_name="+id_name+"&lang="+lang+"&key=baner_line_description",
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
	
		if ($('#enable'+id).prop('checked')) {
            enable = '1' ;
        }
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			dataType: "text",
			data: "id="+id+"&enable="+enable+"&href="+href+"&name="+name+"&mainkey=<?php echo $main_key; ?>&table=<?php echo $table; ?>&key=edit",
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
		  data: "id="+id+"&table=<?php echo $table; ?>&mainkey=<?php echo $main_key; ?>&key=dell",
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
		  data: "id="+id+"&table=baner_line_description&mainkey=<?php echo $main_key; ?>&key=dell",
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