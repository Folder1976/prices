<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
$type = 'season_pro';
$catalog = 'season_products';
$uploaddir = '/'.TMP_DIR.'image/banners/'.$catalog.'/';

// Если прилетела форма - сохраним===============================
if(isset($_POST['key']) AND $_POST['key'] == 'add'){
     
	  $is_view = 0;
	  if(isset($_POST['is_view'])) $is_view = '1';
	  
	  //Если это код 0 - новый
	    $sql = 'INSERT INTO '.DB_PREFIX.'baner SET
				  baner_name = "'.$_POST['name'].'",
		    	  baner_header = "'.$_POST['header'].'",
				  baner_title = "'.$_POST['title'].'",
				  baner_url = "'.$_POST['url'].'",
				  baner_type = "'.$type.'",
				  is_view = "'.$is_view.'"
			    ;';

	    $r = $mysqli->query($sql);
		
	echo "<H2>Добавлено! Подождите, идет сохранение.</H2><SCRIPT>\n\nvar i = setTimeout(\"window.location.href='/".TMP_DIR."backend/index.php?route=main_page/main_page.index.php&modul=main_page.season_products.php'\", 500);\n</SCRIPT>";
}
?>
<br>
<h1>Загрузка банера для главной страницы. Размер 259 х 259 px!</h1>
<h2>Обязательно наличие 5 активных банеров!</h2>
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
			<th colspan="2"></th>
		</tr>
      
		<tr><form method=post>
			<td>новый<input type="hidden" name="id0" value=""></td>
			<td><!--img src="reklama/img/large_banner_help.jpg" width="125"--></td>
			<td><input type="checkbox" name="is_view" class="brand" data-id="0"></td>
			<td>
			  <br>Внутреннее название [на сайте не отображается]</b> : <input type="text" name="name" class="brand" data-id="0" style="width:400px;" value="" placeholder="Имя - для памятки">
			  <br>Куда ведет банер [url]</b> : <input type="text" name="url" id="url" class="brand" data-id="0" style="width:400px;" value="" placeholder="URL">
			  <br>Заголовок банера [title]</b> : <input type="text" name="header" class="brand" data-id="0" style="width:400px;" value="" placeholder="Заголовок банера">
			  <br>Текст для кнопки</b> : <input type="text" name="title" class="brand" data-id="0" style="width:400px;" value="" placeholder="Текст для кнопки">
			</td>
			<td colspan="1"><input type="submit" name="key" value="add" style="width:50px;"></td>
			<td colspan="2">Фото после добавляния</td>
		</tr></form>

<?php while($value = $r->fetch_assoc()){ ?>
 <tr id="<?php echo $value['baner_id']; ?>">
      <td><?php echo $value['baner_id']; ?></td>
	  <td><img src="<?php echo $uploaddir.$value['baner_pic']; ?>" width="125" height="125">
	  </td>
	  <td><input type="checkbox" id="is_view<?php echo $value['baner_id']; ?>" class="brand edit" data-id="<?php echo $value['baner_id']; ?>" <?php if($value['is_view'] == 1) echo ' checked '; ?> ></td>
      <td>
		  <br>Внутреннее название [на сайте не отображается]</b> : <input type="text" id="name<?php echo $value['baner_id'];?>" class="brand edit" data-id="<?php echo $value['baner_id'];?>" style="width:400px;" value="<?php echo $value['baner_name']; ?>">
		  <br>Куда ведет банер [url]</b> : <input type="text" id="url<?php echo $value['baner_id']; ?>" class="brand edit" data-id="<?php echo $value['baner_id'];?>" style="width:400px;" value="<?php echo $value['baner_url']; ?>">
		  <br>Заголовок банера [title]</b> : <input type="text" id="header<?php echo $value['baner_id']; ?>" class="brand edit" data-id="<?php echo $value['baner_id']; ?>" style="width:400px;" value="<?php echo $value['baner_header']; ?>">
		  <br>Текст для кнопки</b> : <input type="text" id="title<?php echo $value['baner_id'];?>" class="brand edit" data-id="<?php echo $value['baner_id']; ?>" style="width:400px;" value="<?php echo $value['baner_title']; ?>">
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
		
		if ($('#is_view'+id).prop('checked')) {
            view = '1' ;
        }
		
		 $.ajax({
		type: "POST",
		url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
		dataType: "text",
		data: "id="+id+"&is_view="+view+"&baner_url="+burl+"&baner_name="+name+"&baner_header="+header+"&baner_title="+title+"&mainkey=baner_id&table=baner&baner_type=<?php echo $type; ?>&key=edit",
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
	  } 
    });
  </script>