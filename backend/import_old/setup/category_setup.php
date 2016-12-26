<title>Настройки парса</title>
<h1>Настройки категорий</h1>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<link href="/admin/css/main_menu.css" rel="stylesheet" type="text/css">

<?php
	
	if(!isset($_GET['menu'])){
		$_GET['menu'] = 'category_setup';
	}

	$step = 20;
    $page = 1;
    if(isset($_GET['page'])) $page = (int)$_GET['page'];
   
	$find = '';
	$where_find= '';
	if(isset($_GET['find'])){
		$find = $_GET['find'];
		$where_find = 'WHERE prev_name LIKE "%'.$find.'%" OR name LIKE "%'.$find.'%" OR last_name LIKE "%'.$find.'%" ';
	}
	
	
	//Получим Магазины
	$sql = 'SELECT id, name FROM magazin ORDER BY name ASC;';
    //echo $sql;            
	$r = $mysqli->query($sql) or die('Ошибка в выборке магазинов' . mysqli_error($mysqli));
	$Magazines = array();	
	if($r->num_rows > 0){
		while($tmp = $r->fetch_assoc()){
			$Magazines[$tmp['id']] = $tmp['name'];
		}
	}
	
	//Получим Категории
	$sql = 'SELECT id, name FROM menu ORDER BY name ASC;';
    //echo $sql;            
	$r = $mysqli->query($sql) or die('Ошибка в выборке магазинов' . mysqli_error($mysqli));
	$Categories = array();	
	if($r->num_rows > 0){
		while($tmp = $r->fetch_assoc()){
			$Categories[$tmp['id']] = $tmp['name'];
		}
	}

	//Получим основной массив
	$sql = 'SELECT count(id) total FROM parser_prev '.$where_find.';';
	$r = $mysqli->query($sql);
    if($r->num_rows == 0){
        $total_count = 0;
    }else{
        $t = $r->fetch_assoc();
        $total_count = $t['total'];
    }
	
				
	//Получим атрибуты	
	$sql = 'SELECT * FROM parser_prev '.$where_find.' ORDER BY prev_name ASC, name ASC LIMIT '.(($page-1)*$step).', '.$step.';';
	//echo $sql;            
	$rm = $mysqli->query($sql) or die('Ошибка в атрибутах ' . mysqli_error($mysqli));
	
?>
	<form method="GET" action="/import/parser_setup.php">
		<input type="hidden" name="menu" value="category_setup">
		<b>Поиск : </b><input type="text" name="find" style="width:350px;" value='<?php echo $find; ?>' placeholder="Поиск по части названия" onChange="submit();">
	</form>
	<table class="attributes_table">
		<tr>
			<th>id</th>
			<th>Магазин</th>
			<th>Категория</th>
			<th>ПредИмя</th>
			<th>Имя</th>
			<th>Посл. Имя</th>
			<th>*</th>
		</tr>
		
		<tr id="new">
			<td align="left">*</td>
			<td align="left">
						<select type="text" id="shop_id" style="width:150px;">
							<option value="0">Выбрать магазин</option>
							<?php foreach($Magazines as $id => $value){ ?>
								<option value="<?php echo $id; ?>"><?php echo $value; ?></option>
							<?php } ?>
						</select>
			</td>
			<td align="left">
						<select type="text" id="category_id" style="width:150px;">
							<option value="0">Выбрать категорию</option>
							<?php foreach($Categories as $id => $value){ ?>
								<option value="<?php echo $id; ?>"><?php echo $value; ?></option>
							<?php } ?>
						</select>
			</td>
			<td align="left"><input type="text"   id="prev_name"  style="width:250px;" value='' placeholder="Предыдущее название"></td>
			<td align="left"><input type="text"   id="name" style="width:150px;" value='' placeholder="Название"></td>
			<td align="left"><input type="text"   id="last_name" style="width:150px;" value='' placeholder="Конечное название"></td>
			<td align="center"><a href='javascript:' id="add" class="add"><b>Добавить</b></a></td>
		</tr>

		<tr>
			<td colspan="12" style="color: red;">Изменение моментальное!  <span class="msg"></span></td>
		</tr>
            
		<?php while($tmp = $rm->fetch_assoc()){ ?>
			<tr id="<?php echo $tmp['id']; ?>">
				<td align="left"><input type="text" disabled class="id" value='<?php echo $tmp['id']; ?>' style="width:50px;" ></td>
				<td align="left">
						<select type="text" class="edit" id="shop_id<?php echo $tmp['id']; ?>" style="width:150px;">
							<option value="0">Выбрать магазин</option>
							<?php foreach($Magazines as $id => $value){ ?>
								<?php if($tmp['shop_id'] == $id){?>
									<option value="<?php echo $id; ?>" selected><?php echo $value; ?></option>
								<?php }else{ ?>
									<option value="<?php echo $id; ?>"><?php echo $value; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
				</td>
        		<td align="left">
						<select type="text" class="edit" id="category_id<?php echo $tmp['id']; ?>" style="width:150px;">
							<option value="0">Выбрать магазин</option>
							<?php foreach($Categories as $id => $value){ ?>
								<?php if($tmp['category_id'] == $id){?>
									<option value="<?php echo $id; ?>" selected><?php echo $value; ?></option>
								<?php }else{ ?>
									<option value="<?php echo $id; ?>"><?php echo $value; ?></option>
								<?php } ?>
							<?php } ?>
						</select>
				</td>
        		<td align="left"><input type="text" class="edit" id="prev_name<?php echo $tmp['id']; ?>" style="width:250px;" value='<?php echo $tmp['prev_name']; ?>'></td>
				<td align="left"><input type="text" class="edit" id="name<?php echo $tmp['id']; ?>"  style="width:150px;" value='<?php echo $tmp['name']; ?>'></td>
				<td align="left"><input type="text" class="edit" id="last_name<?php echo $tmp['id']; ?>" style="width:150px;" value='<?php echo $tmp['last_name']; ?>'></td>
				
				<td align="center"><a href='javascript:' id="<?php echo $tmp['id']; ?>" class="dell"><b>X</b></a></td>
			</tr>
		<?php } ?>                
    </table>    
				
		
	<script>
    //Сохранение элемента
    $(document).on('change', '.edit', function(){
        var elem = $(this);
        var target = elem.parent('td').parent('tr').attr('id');
        
		var table = 'parser_prev';
		
        var shop_id = $('#shop_id'+target).val();
        var category_id = $('#category_id'+target).val();
        var prev_name = $('#prev_name'+target).val();
        var name = $('#name'+target).val();
        var last_name = $('#last_name'+target).val();
		
		$.ajax({
            type: "GET",
            url: "setup/ajax/ajax_save_category.php",
            dataType: "text",
            data: "id="+target+"&table="+table+"&shop_id="+shop_id+"&category_id="+category_id+"&prev_name="+prev_name+"&name="+name+"&last_name="+last_name+"&key=edit",
            beforeSend: function(){
            },
            success: function(msg){
                
                $('.msg').html(msg);
                $('.msg').show();
                $('.msg').hide(1000);
                
                console.log( msg );
            }
        });
    });
        
    $(document).on('click', '#add', function(){

		var table = 'parser_prev';
        var shop_id = $('#shop_id').val();
        var category_id = $('#category_id').val();
        var prev_name = $('#prev_name').val();
        var name = $('#name').val();
        var last_name = $('#last_name').val();

		$.ajax({
			type: "GET",
			url: "setup/ajax/ajax_save_category.php",
			dataType: "text",
			data: "shop_id="+shop_id+"&table="+table+"&category_id="+category_id+"&prev_name="+prev_name+"&name="+name+"&last_name="+last_name+"&key=add",
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
		var table = 'parser_prev';
        //console.log("id="+target+"&filter="+filter+"&disable="+disable+"&sort="+sort);
        
        $.ajax({
            type: "GET",
            url: "setup/ajax/ajax_save_category.php",
            dataType: "text",
            data: "id="+target+"&table="+table+"&key=dell",
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


<!-- Пагинация -->
<div class="pagination" style="margin: 10px;">
<?php
    $count = 1;
    do{
        
        if($count == $page){
            echo '<a href="/import/parser_setup.php?menu='.$_GET['menu'].'&page='.$count.'" style="color:red;">'.$count.'</a>';
        }else{
            echo '<a href="/import/parser_setup.php?menu='.$_GET['menu'].'&page='.$count.'">'.$count.'</a>';
        }
        
		$total_count = $total_count - ($step);
        $count++;
        
    }while($total_count > 0);
?>
</div>
<style>
	.attributes_table{
		border-spacing: 0px;
	}
	.attributes_table table, td, th, tr{
		border-collapse: collapse;
		border-spacing: 0px;
		margin: 0px;
		border: 1px solid gray;
		padding-left: 5px;
		padding-right: 5px;
	}
    .pagination a{
        margin: 10px;
        padding: 5px;
        border: 1px solid gray;
        background-color: #d5dcd3;
    }
</style>

