<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
$type = 'large';
$catalog = 'mainpage_large';
if($type == 'medium') $catalog = 'mainpage_medium';
if($type == 'large') $catalog = 'mainpage_large';
$uploaddir = '/'.TMP_DIR.'image/banners/'.$catalog.'/';

// Если прилетела форма - сохраним===============================
if(isset($_POST['key']) AND $_POST['key'] == 'add'){
     
	  $is_view = 0;
	  if(isset($_POST['is_view'])) $is_view = '1';
	  
	  //Если это код 0 - новый
	    $sql = 'INSERT INTO '.DB_PREFIX.'baner SET
				  baner_name = "'.$_POST['name'].'",
		    	  baner_place = "'.$_POST['place'].'",
				  baner_text_color = "'.$_POST['baner_text_color'].'",
				  baner_url = "'.$_POST['url'].'",
				  baner_type = "'.$type.'",
				  is_view = "'.$is_view.'"
			    ;';

	    $r = $mysqli->query($sql);
		
	echo "<H2>Добавлено! Подождите, идет сохранение.</H2><SCRIPT>\n\nvar i = setTimeout(\"window.location.href='/".TMP_DIR."backend/index.php?route=main_page/main_page.index.php&modul=main_page.main_baner.php'\", 500);\n</SCRIPT>";
}
?>
<br>
<h1>Загрузка банера для главной страницы. Размер 2460 х 905!</h1>
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
$sql = 'SELECT * FROM '.DB_PREFIX.'baner WHERE baner_type="'.$type.'" ORDER BY is_view DESC, baner_name ASC;';
$r = $mysqli->query($sql);
?>
<div style="width: 50%">
    <div class="table_body">
        <table class="text">
		<tr>
			<th>#</th>
			<th> + + + </th>
			<th>Показывать</th>
			<th>Тексты</th>
			<th style="min-width:200px;">Параметры</th>
			<th colspan="2"></th>
		</tr>
      
		<tr><form method=post>
			<td>новый<input type="hidden" name="id0" value=""></td>
			<td><!--img src="reklama/img/large_banner_help.jpg" width="250"--></td>
			<td><input type="checkbox" name="is_view" class="brand" data-id="0"></td>
			<td>
			  <br><b>Внутреннее название [на сайте не отображается]</b> : <input type="text" name="name" class="brand" data-id="0" style="width:600px;" value="" placeholder="Имя - для памятки">
			  <br><b>Куда ведет банер [url]</b> : <input type="text" name="url" id="url" class="brand" data-id="0" style="width:600px;" value="" placeholder="URL">
			 
			 
			  <!--br><b>Заголовок банера [title]</b> : <input type="text" name="header" class="brand" data-id="0" style="width:600px;" value="" placeholder="Заголовок банера">
			  <br><b>Текст банера</b> : <input type="text" name="text" class="brand" data-id="0" style="width:600px;" value="" placeholder="Текст на банере">
			  <br--><b>Текст для кнопки</b> : <input type="text" name="title" class="brand" data-id="0" style="width:600px;" value="" placeholder="Текст для кнопки">
			
			</td>
			<td>
			  <br><b>Расположение текста</b> : <br><input type="radio" name="place" data-id="0" value="text_left" checked> Текст слева :
												<br><input type="radio" name="place" data-id="0" value="text_right"> Текст справа :
												<br><input type="radio" name="place" data-id="0" value="text_bottom"> Текст под банером
			  <br><br><b>Цвет текста</b> : <br><input type="radio" name="baner_text_color" data-id="0" value="#000000" checked> Черный :
												<br><input type="radio" name="baner_text_color" data-id="0" value="#FFFFFF"> Белый
												
			</td>
			<td colspan="1"><input type="submit" name="key" value="add" style="width:50px;"></td>
			<td colspan="2">Фото после добавляния</td>
		</tr></form>

<?php while($value = $r->fetch_assoc()){ ?>
 <tr id="<?php echo $value['baner_id']; ?>">
      <td><?php echo $value['baner_id']; ?></td>
	  <td><img src="<?php echo $uploaddir.$value['baner_pic']; ?>" width="250">
	  </td>
	  <td><input type="checkbox" id="is_view<?php echo $value['baner_id']; ?>" class="brand edit" data-id="<?php echo $value['baner_id']; ?>" <?php if($value['is_view'] == 1) echo ' checked '; ?> ></td>
      <td>
		  <br><b>Внутреннее название [на сайте не отображается]</b> : <input type="text" id="name<?php echo $value['baner_id'];?>" class="brand edit" data-id="<?php echo $value['baner_id'];?>" style="width:600px;" value="<?php echo $value['baner_name']; ?>">
		  <br><b>Куда ведет банер [url]</b> : <input type="text" id="url<?php echo $value['baner_id']; ?>" class="brand edit" data-id="<?php echo $value['baner_id'];?>" style="width:600px;" value="<?php echo $value['baner_url']; ?>">
		  <!--br><b>Заголовок банера [title]</b> : <input type="text" id="header<?php echo $value['baner_id']; ?>" class="brand edit" data-id="<?php echo $value['baner_id']; ?>" style="width:600px;" value="<?php echo $value['baner_header']; ?>">
		  <br><b>Текст банера</b> : <input type="text" id="text<?php echo $value['baner_id']; ?>" class="brand edit" data-id="<?php echo $value['baner_id']; ?>" style="width:600px;" value="<?php echo $value['baner_text']; ?>">
		  <br><b>Текст для кнопки</b> : <input type="text" id="title<?php echo $value['baner_id'];?>" class="brand edit" data-id="<?php echo $value['baner_id']; ?>" style="width:600px;" value="<?php echo $value['baner_title']; ?>">
		  -->
		  	<?php
					$sql = 'SELECT * FROM '.DB_PREFIX.'language ORDER BY language_id ASC;';
					$r_lang = $mysqli->query($sql);
				?>
				<?php while($row = $r_lang->fetch_assoc()){ ?>
					<?php
						$sql = 'SELECT * FROM '.DB_PREFIX.'baner_description 
									WHERE baner_id = "'.$value['baner_id'].'" AND language_id="'.$row['language_id'].'" LIMIT 1;';
						$r_desc = $mysqli->query($sql);
					
						if($r_desc->num_rows){
							$row_2 = $r_desc->fetch_assoc();
						}else{
							$row_2 = array(
										   'header'=>'',
										   'title'=>'',
										   'text'=>''
										   );
						}
					?>
						<br>
						<br><b><?php echo $row['name']; ?></b>
						<br><b><b>Заголовок банера [title]</b> : <input type="text" id="header" style="height:15px;width:600px;" data-language_id="<?php echo $row['language_id']; ?>" class="brand edit_description" data-id="<?php echo $value['baner_id']; ?>" style="width:600px;" value="<?php echo $row_2['header']; ?>">
						<br>Текст банера</b> : <input type="text" id="text" data-language_id="<?php echo $row['language_id']; ?>" class="brand edit_description" data-id="<?php echo $value['baner_id']; ?>" style="width:600px;" value="<?php echo $row_2['text']; ?>">
						<br><b>Текст для кнопки</b> : <input type="text" id="title" data-language_id="<?php echo $row['language_id']; ?>" class="brand edit_description" data-id="<?php echo $value['baner_id']; ?>" style="width:600px;" value="<?php echo $row_2['title']; ?>">
				<?php } ?>
	  </td>
	  <td>
		  <br><b>Расположение текста</b> :
			<br><input type="radio" id="place<?php echo $value['baner_id'];?>" name="place<?php echo $value['baner_id'];?>" class="brand edit" value="text_left" <?php if($value['baner_place'] == 'text_left') echo 'checked'; ?> > Текст слева :
			<br><input type="radio" id="place<?php echo $value['baner_id'];?>" name="place<?php echo $value['baner_id'];?>" class="brand edit" value="text_right" <?php if($value['baner_place'] == 'text_right') echo 'checked'; ?> > Текст справа : 
			<br><input type="radio" id="place<?php echo $value['baner_id'];?>" name="place<?php echo $value['baner_id'];?>" class="brand edit" value="text_bottom" <?php if($value['baner_place'] == 'text_bottom') echo 'checked'; ?> > Текст под банером
		  <br><br><b>Цвет текста</b> :
			<br><input type="radio" id="baner_text_color<?php echo $value['baner_id'];?>" name="baner_text_color<?php echo $value['baner_id'];?>" class="brand edit" value="#000000" <?php if($value['baner_text_color'] == '#000000') echo 'checked'; ?> > Черный :
			<br><input type="radio" id="baner_text_color<?php echo $value['baner_id'];?>" name="baner_text_color<?php echo $value['baner_id'];?>" class="brand edit" value="#FFFFFF" <?php if($value['baner_text_color'] == '#FFFFFF') echo 'checked'; ?> > Белый : 
	  </td>
  
	  <td>
		<a href="javascript:" class="dell" id="dell_<?php echo $value['baner_id']; ?>"><img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16"></a>
	  </td>
	
	  <td>
		<form enctype="multipart/form-data" method="post" action="main_page/load_photo.php">
		  <input type="hidden" name="type" value="<?php echo $type; ?>">
		  <input type="hidden" name="MAX_FILE_SIZE" value="'.(1048*1048*1048).'">
		  <input type="hidden" name="filename"  value="<?php echo $value['baner_id']; ?>">
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
		var view = '0';
		var name = $('#name'+id).val();
		var burl = $('#url'+id).val();
		var header = $('#header'+id).val();
		var title = $('#title'+id).val();
		var text = $('#text'+id).val();
		var place = $('#place'+id+':checked').val();
		var baner_text_color = $('#baner_text_color'+id+':checked').val();
		
		if ($('#is_view'+id).prop('checked')) {
            view = '1' ;
        }
		
		 $.ajax({
		type: "POST",
		url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
		dataType: "text",
		data: "id="+id+"&baner_text_color="+baner_text_color+"&baner_place="+place+"&baner_text="+text+"&is_view="+view+"&baner_url="+burl+"&baner_name="+name+"&baner_header="+header+"&baner_title="+title+"&mainkey=baner_id&table=baner&baner_type=<?php echo $type; ?>&key=edit",
		beforeSend: function(){
		},
		success: function(msg){
		  console.log(  msg );
		  //$('#msg').html('Изменил');
		  //setTimeout($('#msg').html(''), 1000);
		}
	  });
		
	});
	
	$(document).on('change','.edit_description', function(){
		var id = $(this).data('id');
		var fild = $(this).attr('id');
		var value = $(this).val();
		var lang = $(this).data('language_id');
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_statik.php",
			dataType: "text",
			data: "id="+id+"&fild="+fild+"&value="+value+"&lang="+lang+"&key=baner_description",
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
		  data: "id="+id+"&table=baner&mainkey=baner_id&key=dell",
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
		  data: "id="+id+"&table=baner_description&mainkey=baner_id&key=dell",
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