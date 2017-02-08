<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}

	$table = 'baner_products';
	$main_key = 'baner_products_id';
	
	$uploaddir = DIR_IMAGE.'product/';
	$uploaddir_s = 'product/';
	include_once('class/product.class.php');
	$Product = new Product($mysqli, DB_PREFIX);
	
	
	
	$sql = 'SELECT * FROM '.DB_PREFIX.'baner_products ORDER BY sort';
	$r = $mysqli->query($sql) or die($sql);
	?>
	
		<h2>Товары на банер</h2>
	
	<!-- Поиск -->
	<div style="width: 90%">
    <div class="table_body">	
		<table class="table">
			<tr>
				<th>Поиска продукта</th>
				<th></th>
			</tr>
			<tr>
				<form method=post>
					<td>
						<input type="text" name="findname" class="name" data-id="0" style="width:600px;" value="" placeholder="Название товара или sku">
					</td>
					<td><input type="submit" name="Find" value="Find" style="width:150px;"></td>
				</form>
			</tr>
		</table>
		
			<?php if(isset($_POST['findname']) AND $_POST['findname'] != ''){ 
				
					$sql = 'SELECT distinct P.product_id FROM '.DB_PREFIX.'product P
								LEFT JOIN '.DB_PREFIX.'product_description PD ON P.product_id = PD.product_id
								WHERE (P.sku LIKE "'.$_POST['findname'].'%" OR
									P.model LIKE "'.$_POST['findname'].'%" OR
									PD.name LIKE "%'.str_replace(' ','%',$_POST['findname']).'%")
									AND
									P.product_id NOT IN (SELECT distinct product_id	FROM '.DB_PREFIX.'baner_products)
								';
					//echo $sql;			
					$r_f = $mysqli->query($sql);	?>		
								
					
					<div style="width: 90%">
						<div class="table_body"><h4>Результаты поиска</h4>		
							<table class="table">
								<tr>
									<th>#</th>
									<th>Статус</th>
									<th>Сортировка</th>
									<th>Продукт</th>
									<th colspan="2"></th>
								</tr>
							<?php while($value = $r_f->fetch_assoc()){ ?>
								<?php $product = $Product->getProduct($value['product_id']); ?>
									
									<?php $value[$main_key] = 'F'.$value['product_id'];?>
									<tr id="<?php echo $value[$main_key]; ?>">
										<td><?php echo $value[$main_key]; ?></td>
										<td><input type="checkbox" id="status<?php echo $value[$main_key]; ?>" class="status" data-id="<?php echo $value[$main_key]; ?>" checked ></td>
										<td>
											<input type="text" id="sort<?php echo $value[$main_key];?>" class="sort" data-id="<?php echo $value[$main_key];?>" style="width:40px;" value="0">
										</td>
										<td><?php echo $product['sku'].' '.$product['name']; ?></td>
										<td>
											<a href="javascript:" class="add">
												<img src="/backend/img/add.png" title="Добавить" width="16" height="16">
											</a>
										</td>
										</tr>
								  
								<?php } ?>
							</table>	
						</div>
					</div>
			<?php } ?>
		
	
<div style="width: 90%">
    <div class="table_body"><h4>Уже в базе</h4>	
		<table class="table">
			<tr>
				<th>#</th>
				<th>Статус</th>
				<th>Сортировка</th>
				<th>Продукт</th>
				<th colspan="2"></th>
			</tr>
			
			<?php while($value = $r->fetch_assoc()){ ?>
			
				<?php $product = $Product->getProduct($value['product_id']); ?>
			
				<tr id="<?php echo $value[$main_key]; ?>">
					<td><?php echo $value[$main_key]; ?></td>
					<td><input type="checkbox" id="status<?php echo $value[$main_key]; ?>" class="status edit" data-id="<?php echo $value[$main_key]; ?>" <?php if($value['status'] == 1) echo ' checked '; ?> ></td>
					<td>
						<input type="text" id="sort<?php echo $value[$main_key];?>" class="sort edit" data-id="<?php echo $value[$main_key];?>" style="width:40px;" value="<?php echo $value['sort']; ?>">
					</td>
					<td><?php echo $product['sku'].' '.$product['name']; ?></td>
					<td>
						<a href="javascript:" class="dell" id="dell_<?php echo $value['baner_id']; ?>"><img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16"></a>
					</td>
					</tr>
			  
			<?php } ?>
		</table>	
	</div>
</div>
			
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
	   padding: 10px 5px 10px 5px;
	}
	.table {
	   border: 1px solid gray;
	   margin: 0;
	   border-spacing: 0;
	   border-collapse: collapse;
	}

</style>
  <script>
		
	$(document).on('change','.edit', function(){
		var id = jQuery(this).parent('td').parent('tr').attr('id');
		var status = '0';
		var sort = $('#sort'+id).val();
		
		if ($('#status'+id).prop('checked')) {
            status = '1' ;
        }
			
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			dataType: "text",
			data: "id="+id+"&sort="+sort+"&status="+status+"&mainkey=<?php echo $main_key;?>&table=<?php echo $table; ?>&key=edit",
			beforeSend: function(){
			},
			success: function(msg){
			  console.log(  msg );
			}
		});
	});
	
	$(document).on('click','.add', function(){
		var id = jQuery(this).parent('td').parent('tr').attr('id');
			id = id.replace("F", "");
		var status = '0';
		var sort = $('#sortF'+id).val();
		
		if ($('#statusF'+id).prop('checked')) {
            status = '1' ;
        }
			
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			dataType: "text",
			data: "product_id="+id+"&sort="+sort+"&status="+status+"&mainkey=<?php echo $main_key;?>&table=<?php echo $table; ?>&key=add",
			beforeSend: function(){
			},
			success: function(msg){
			  console.log(  msg );
			  jQuery('#F'+id).hide()
			}
		});
	});
	
   	//Удаление
	$(document).on('click','.dell', function(){
		var id = jQuery(this).parent('td').parent('tr').attr('id');
      
		if (confirm('Вы действительно желаете удалить продукт?')){
			$.ajax({
			  type: "POST",
			  url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			  dataType: "text",
			  data: "id="+id+"&table=<?php echo $table; ?>&mainkey=<?php echo $main_key;?>&key=dell",
			  beforeSend: function(){
				
			  },
			  success: function(msg){
				console.log(  msg );
				//location.reload;
				jQuery('#'+id).hide()
			  }
			});
		} 
    });
  </script>