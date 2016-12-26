<!-- Sergey Kotlyarov 2016 folder.list@gmail.com -->
<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
?>
<script type="text/javascript" src="/<?php echo TMP_DIR; ?>admin/view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="/<?php echo TMP_DIR; ?>admin/view/stylesheet/bootstrap.css" type="text/css" rel="stylesheet" />
<link href="/<?php echo TMP_DIR; ?>admin/view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

<link href="/<?php echo TMP_DIR; ?>admin/view/javascript/summernote/summernote.css" rel="stylesheet" />
<script type="text/javascript" src="/<?php echo TMP_DIR; ?>admin/view/javascript/summernote/summernote.js"></script>
<?php 
$table = 'seo_tpl';
$main_key = 'seo_tpl_id';

$sql = 'SELECT * FROM '.DB_PREFIX.$table.' ORDER BY target;';
$r = $mysqli->query($sql);

$arr = array();
while($row = $r->fetch_assoc()){
	$arr[$row[$main_key]] = $row;
}

?>
<br>
<!--script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/js/backend/ajax_edit_attributes.js"></script-->
<h1>Справочник : Шаблоны. После исправления не забывайте Назначать!</h1>
<div style="width: 90%">
<div class="table_body">

<table class="text">
    <tr>
        <th>id</th>
        <th>Название поля</th>
        <th>Значение (фаблон/формула)</th>
        <th>Назначить</th>
    </tr>

 
<?php foreach($arr as $index => $ex){ ?>
	<?php if(strpos($ex['target'], '_text') === false){ ?>
		<tr id="<?php echo $ex[$main_key];?>">
			<td class="mixed"><?php echo $ex[$main_key];?></td>
			<td class="mixed" style="text-align: left;"><?php echo $ex['memo']; ?></td>
			<td class="mixed">
					<input type="hidden" class="edit" id="target<?php echo $ex[$main_key];?>" value="<?php echo $ex['target']; ?>">
					<input type="text" class="edit" id="value<?php echo $ex[$main_key];?>" style="width:700px;" value="<?php echo $ex['value']; ?>"></td>
			<td>        
				<a href="javascript:;" class="set" data-id="<?php echo $ex[$main_key];?>">
					назначить
				</a>
			</td>              
		</tr>
	<?php }else{
		
		$texts[$ex['target']][$main_key] = $ex[$main_key];
		$texts[$ex['target']]['target'] = $ex['target'];
		$texts[$ex['target']]['value'] = $ex['value'];
		$texts[$ex['target']]['memo'] = $ex['memo'];
			
	}?>
	
<?php } ?>
	
	<?php foreach($texts as $index => $ex){ ?>
		<tr id="<?php echo $ex[$main_key];?>">
			<td></td>
			<td valign="top"><?php echo $ex['memo']; ?></td>
			<td>
				<input type="hidden" class="edit" id="target<?php echo $ex[$main_key];?>" value="<?php echo $ex['target']; ?>">
				<textarea style="width: 100%; height: 200px;" id="value<?php echo $ex[$main_key];?>" class="textarea calculation_text edit product_names main_text_textarea" name="domain_text1"><?php echo htmlspecialchars_decode($ex['value'], ENT_QUOTES); ?></textarea>
			</td>
			<td>        
				<a href="javascript:;" class="set" data-id="<?php echo $ex[$main_key]; ?>">
					назначить
				</a>
			</td> 
		</tr>
	<?php } ?>
</table>
<input type="hidden" id="table" value="<?php echo $table; ?>">
<br><br>
 <ul>Памятка по кодам
                    <li>* <b>@min_price@</b> - Минимальная цена</li>
                    <li>* <b>@products_count@</b> - Количество продуктов</li>
                    <li>* <b>@shops_count@</b> - Количество магазинов</li>
                    <li>* <b>@design_count@</b> - Количество дизайнеров</li>
                    <li>* <b>@prev_year@</b> - Предыдущий год</li>
                    <li>* <b>@now_year@</b> - Текущий год</li>
                    <li>* <b>@next_year@</b> - Следующий год</li>
                    <li>* <b>@dinamic_year@</b> - Динамический диапазон 2016-2016</li>
                    <li>* <b>@city@</b> - Город [именительный] (<i>Москва</i>)</li>
                    <li>* <b>@sity_to@</b> - Город [дательный] (<i>В Москву</i>)</li>
                    <li>* <b>@city_on@</b> - Город [предложный](<i>По Москве</i>)</li>
                    <li>* <b>@city_rod@</b> - Город [родительный](<i>Чего? Москвы</i>)</li>
                    <li></li>
                    <li>* <b>@Region@</b> - ***</li>
                    <li>* <b>@poRegionu@</b> - ***</li>
                    <li>* <b>@ChegoRegiona@</b> - ***</li>
                    <li>* <b>@People@</b> - ***</li>
                    <li>* <b>@LitlleCity@</b> - ***</li>
                    <li>* <b>@KodGoroda@</b> - ***</li>
                    <li>* <b>@Population@</b> - ***</li>
                     <li></li>
                    <li>* <b>@DateandTime@</b> - дата и время - текущее автоматом</li>
                     <li></li>
                    <li>* <b>@block_name@</b> - Существительный (<i>белая блузка</i>)</li>
                    <li>* <b>@block_name_rod@</b> - Родительный (<i>белую блузку</i>)</li>
                    <li>* <b>@block_name_several@</b> - Множина (<i>белые блузки</i>)</li>
                  </ul>



</div>

</div>


<script>
	 //======================================================================   
    
    $(document).on('click','.set', function(){
		var id = jQuery(this).data('id');
	
		var target = $('#target'+id).val();
		var value = $('#value'+id).val();

		value = value.replace('&','@*@');
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/seo/ajax/ajax_set_tpl.php",
			dataType: "text",
			data: "id="+id+"&value="+value+"&target="+target+"",
			beforeSend: function(){
			},
			success: function(msg){
			  console.log(  msg );
			}
		});
	});
	
  $(document).on('change','.edit', function(){
		var id = jQuery(this).parent('td').parent('tr').attr('id');
	
		var value = $('#value'+id).val();
		
		value = value.replace('&','@*@');
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			dataType: "text",
			data: "id="+id+"&value="+value+"&mainkey=<?php echo $main_key;?>&table=<?php echo $table; ?>&key=edit",
			beforeSend: function(){
			},
			success: function(msg){
			  console.log(  msg );
			}
		});
	});
	/*
	$('#text1').summernote({
		height: 300,
		width: 700
	});
*/
    //======================================================================
</script>
