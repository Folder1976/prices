<div class="main_wrapper">
<title>Адреса магазинов</title>
<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
?>

<!--script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script-->
<link href="/backend/css/main_menu.css" rel="stylesheet" type="text/css">
<?php
		$sql = 'SELECT id, name FROM '.DB_PREFIX.'shop ORDER BY name ASC;';
        //echo $sql;            
		$r = $mysqli->query($sql) or die('Ошибка в выборке магазинов ' . mysqli_error($mysqli));
		
		if($r->num_rows > 0){
			
            $menu = array();
			while($tmp = $r->fetch_assoc()){
                
                $menu[$tmp['id']] = $tmp['name'];
                
            }
?>
            
            <h4>Редактировать адреса магазинов<h4>
	    <a href="/backend/index.php?route=shops/shops.index.php">К списку магазинов</a>				
	    <form>		
                Всключить определение расстояний : <input type="checkbox" class="setup_checbox" id="enable_distance_calculate" <?php if(isset($Setup['enable_distance_calculate']) AND $Setup['enable_distance_calculate'] == '1') echo 'checked' ?>><br>
                Выбрать магазин : <select name="shop_id" class="shop_id" style="width:250px;" onchange="Submit();">
                
<?php            
                foreach($menu as $id => $value){
						//echo "<pre>";  print_r(var_dump( $value )); echo "</pre>";
                    if(isset($_GET['shop_id']) AND $_GET['shop_id'] == $id){ ?>
                        <option value="<?php echo $id; ?>" selected><?php echo $value; ?></option>
                    <?php }else{ ?>
                        <option value="<?php echo $id; ?>"><?php echo $value; ?></option>
                    <?php }
                }
?>
				</select>
		<input type="hidden" name="route" value="shops/address.index.php">
		<input type="submit" name="submit" value="Показать"></form>

<?php } ?>

<?php 
		if(!isset($_GET['shop_id'])){
			
			echo '<h1>Данный модуль следует запускать исключительно из редактора Магазинов</h1>';
			return 'Нет магазина';
		}
		if(isset($_GET['shop_id'])){ 
				$sql = 'SELECT * FROM '.DB_PREFIX.'shop_address WHERE shop_id = \''.$_GET['shop_id'].'\';';
				//echo $sql;            
				$rm = $mysqli->query($sql) or die('Ошибка в меню ' . mysqli_error());
				
			
?>
		<table style="margin-top:20px;">
				<tr>
						<th rowspan="2">id</th>
						<th rowspan="2">Актив.</th>
						<th rowspan="2" align="left">
								1 - Адрес для информации<br>
								2 - Адрес для google<br>
								3 - Телефон
						</th>
						<th rowspan="2" align="center">
								Координаты
						</th>
						<th colspan="7">Время работы (Если круглосуточно 00:00! Если выходно - оставьте поле пустым)</th>
						<th rowspan="2">*</th>
				</tr>
				<tr>
						<th>пндл</th>
						<th>втор</th>
						<th>сред</th>
						<th>черт</th>
						<th>пятн</th>
						<th>субб</th>
						<th>воск</th>
				</tr>
		
				<tr id="new">
						<td align="left">*</td>
						<td align="center"><input type="checkbox"   id="status" checked></td>
						<td align="left">1 - <input type="text"   id="address"  style="width:200px;" value='' placeholder="Кишинев, ул. Ворничень 7"><br>
										2 - <input type="text"   id="google"  style="width:200px;" value='' placeholder="Кишинев, ул. Ворничень 7"><br>
										3 - <input type="text"   id="phone" style="width:200px;" value='' placeholder="+38067 123 4568"></td>
						<td align="right">
										Д - <input type="text"   id="lat" style="width:60px;" value='' placeholder="123.123"><br>
										Ш - <input type="text"   id="lng" style="width:60px;" value='' placeholder="456.456"></td>
						<td align="center"><input type="text"   id="worktime1" style="width:80px;" value='' placeholder="10:00-16:00"></td>
						<td align="center"><input type="text"   id="worktime2" style="width:80px;" value='' placeholder="10:00-16:00"></td>
						<td align="center"><input type="text"   id="worktime3" style="width:80px;" value='' placeholder="10:00-16:00"></td>
						<td align="center"><input type="text"   id="worktime4" style="width:80px;" value='' placeholder="10:00-16:00"></td>
						<td align="center"><input type="text"   id="worktime5" style="width:80px;" value='' placeholder="10:00-16:00"></td>
						<td align="center"><input type="text"   id="worktime6" style="width:80px;" value='' placeholder="10:00-16:00"></td>
						<td align="center"><input type="text"   id="worktime7" style="width:80px;" value='' placeholder="10:00-16:00"></td>
					<td align="center"><a href='javascript:' id="add" class="add"><b>Добавить</b></a></td>
                </tr>

                <tr>
                    <td colspan="12" style="color: red;">Изменение моментальное!  <span class="msg"></span></td>
                </tr>
            
                <?php while($tmp = $rm->fetch_assoc()){ ?>
                    <tr id="<?php echo $tmp['id']; ?>">
                        <td align="left"><input type="text" disabled class="id" value='<?php echo $tmp['id']; ?>' style="width:30px;" ></td>
						<?php	$status = '';
								if($tmp['status'] == 1){
										$status = ' checked ';				
								}
						?>
						<td align="center"><input type="checkbox"  class="edit"  id="status<?php echo $tmp['id']; ?>" <?php echo $status ?>></td>
					    <td align="center">1 - <input type="text" class="edit" id="address<?php echo $tmp['id']; ?>" style="width:200px;" value='<?php echo $tmp['address']; ?>'><br>
										2 - <input type="text"  class="edit"  id="google<?php echo $tmp['id']; ?>"  style="width:200px;" value='<?php echo $tmp['google']; ?>'><br>
										3 - <input type="text" class="edit" id="phone<?php echo $tmp['id']; ?>" style="width:200px;" value='<?php echo $tmp['phone']; ?>'></td>
	
						<td align="right">
								Д - <input type="text" class="edit" id="lat<?php echo $tmp['id']; ?>" style="width:70px;" value='<?php echo $tmp['lat']; ?>' placeholder="123.123">
								<br>
								Ш - <input type="text" class="edit" id="lng<?php echo $tmp['id']; ?>" style="width:70px;" value='<?php echo $tmp['lng']; ?>' placeholder="456.456">
								<br>
								<a href="javascript:" class="setcoordinate">Определить</a>
						</td>
	                    <td align="center"><input type="text" class="edit" id="worktime1<?php echo $tmp['id']; ?>" style="width:80px;" value='<?php echo $tmp['worktime1']; ?>' placeholder="10:00-16:00"></td>
                        <td align="center"><input type="text" class="edit" id="worktime2<?php echo $tmp['id']; ?>" style="width:80px;" value='<?php echo $tmp['worktime2']; ?>' placeholder="10:00-16:00"></td>
                        <td align="center"><input type="text" class="edit" id="worktime3<?php echo $tmp['id']; ?>" style="width:80px;" value='<?php echo $tmp['worktime3']; ?>' placeholder="10:00-16:00"></td>
                        <td align="center"><input type="text" class="edit" id="worktime4<?php echo $tmp['id']; ?>" style="width:80px;" value='<?php echo $tmp['worktime4']; ?>' placeholder="10:00-16:00"></td>
                        <td align="center"><input type="text" class="edit" id="worktime5<?php echo $tmp['id']; ?>" style="width:80px;" value='<?php echo $tmp['worktime5']; ?>' placeholder="10:00-16:00"></td>
                        <td align="center"><input type="text" class="edit" id="worktime6<?php echo $tmp['id']; ?>" style="width:80px;" value='<?php echo $tmp['worktime6']; ?>' placeholder="10:00-16:00"></td>
                        <td align="center"><input type="text" class="edit" id="worktime7<?php echo $tmp['id']; ?>" style="width:80px;" value='<?php echo $tmp['worktime7']; ?>' placeholder="10:00-16:00"></td>
						<td align="center"><a href='javascript:' id="<?php echo $tmp['id']; ?>" class="dell"><b>X</b></a></td>
                    </tr>
                <?php } ?>                
            </table>    
				
		<?php } ?>
		</table>
</div>		
		   <script>
		//Определение координат
		$(document).on('click', '.setcoordinate', function(){
				var elem = $(this);
				var target = elem.parent('td').parent('tr').attr('id');
				var address = $('#google'+target).val();
				
				//console.log("id="+target+"&google="+google+"&key=get_coordiname");
				
				$.ajax({
					url: 'http://maps.googleapis.com/maps/api/geocode/json',
					data: {
						sensor: false,
						address: address
					},
					dataType:'json',
					success: function (data) {
						
						//console.log(data);
						//console.log(data['results']['0']['geometry']['location']['lat']);
						
						$('#lat'+target).val(data['results']['0']['geometry']['location']['lat']);
						$('#lng'+target).val(data['results']['0']['geometry']['location']['lng']);
						
						$('#lat'+target).trigger('change');
					}
				});
	
	
				
		});
		
		
    	//Сохранение элемента
        $(document).on('change', '.edit', function(){
        var elem = $(this);
        var target = elem.parent('td').parent('tr').attr('id');
        
		var post = "";
        post = post + "id="+target;
        post = post + "&address="+$('#address'+target).val();
        post = post + "&google="+$('#google'+target).val();
        post = post + "&phone="+$('#phone'+target).val();
        post = post + "&lat="+$('#lat'+target).val();
        post = post + "&lng="+$('#lng'+target).val();
        post = post + "&worktime1="+$('#worktime1'+target).val();
        post = post + "&worktime2="+$('#worktime2'+target).val();
        post = post + "&worktime3="+$('#worktime3'+target).val();
        post = post + "&worktime4="+$('#worktime4'+target).val();
        post = post + "&worktime5="+$('#worktime5'+target).val();
        post = post + "&worktime6="+$('#worktime6'+target).val();
        post = post + "&worktime7="+$('#worktime7'+target).val();
        post = post + "&mainkey=id";
        post = post + "&table=shop_address";
        
		var status = 0;
		if($('#status'+target).prop('checked') == true){
				status = 1;	
		}
        post = post + "&status="+status;
        
		
		//console.log("id="+target+"&filter="+filter+"&disable="+disable+"&sort="+sort);
        
        $.ajax({
            type: "POST",
            url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
            dataType: "text",
            data: post+"&key=edit",
            beforeSend: function(){
            },
            success: function(msg){
                
                console.log( msg );
            }
        });
        
    });
        
    $(document).on('click', '#add', function(){
		
		var post = "";
        post = post + "shop_id=<?php echo $_GET['shop_id']; ?>";
        post = post + "&address="+$('#address').val();
        post = post + "&google="+$('#google').val();
        post = post + "&phone="+$('#phone').val();
        post = post + "&lat="+$('#lat').val();
        post = post + "&lng="+$('#lng').val();
        post = post + "&worktime1="+$('#worktime1').val();
        post = post + "&worktime2="+$('#worktime2').val();
        post = post + "&worktime3="+$('#worktime3').val();
        post = post + "&worktime4="+$('#worktime4').val();
        post = post + "&worktime5="+$('#worktime5').val();
        post = post + "&worktime6="+$('#worktime6').val();
        post = post + "&worktime7="+$('#worktime7').val();
        post = post + "&mainkey=id";
        post = post + "&table=shop_address";
        
		var status = 0;
		if($('#status').prop('checked') == true){
				status = 1;	
		}
        post = post + "&status="+status;
    
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			dataType: "text",
		   data: post+"&key=add",
		beforeSend: function(){
			},
			success: function(msg){
				location.reload();
				console.log( msg );
			}
		});
		
    });
    
    $(document).on('click', '.dell', function(){
        var elem = $(this);
        var target = elem.parent('td').parent('tr').attr('id');
         
        //console.log("id="+target+"&filter="+filter+"&disable="+disable+"&sort="+sort);
        
        $.ajax({
            type: "GET",
            url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
            dataType: "text",
            data: "id="+id+"&table=shop_address&mainkey=id&key=dell",
            beforeSend: function(){
            },
            success: function(msg){
                $('#'+target).hide(1000);
                
                $('.msg').html(msg);
                $('.msg').show();
                $('.msg').hide(1000);
                
                console.log( msg );
            }
        });
        
    });
    
    
   </script>
		<style>
			 .msg{
					 color: #0e7100;
					 display: none;
				 }
		</style>
	<style>
		.main_wrapper{
			margin-left: 30px;
			margin-top: 20px;
		}
		table{
		   margin-left: 30px;
		}
		table tr td {
		   border: 1px solid gray;
		   margin: 0;
		   border-spacing: 0;
		   border-collapse: collapse;
		   padding: 10px 5px 10px 5px;
		}
		table tr th {
		   border: 1px solid gray;
		   margin: 0;
		   border-spacing: 0;
		   border-collapse: collapse;
		}
		table {
		   border: 1px solid gray;
		   margin: 0;
		   border-spacing: 0;
		   border-collapse: collapse;
		}
		.product_type:hover {
		   cursor: pointer;
		}
</style>		   