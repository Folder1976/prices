<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
	
	$uploaddir = DIR_IMAGE.'product/';
	$uploaddir_s = 'product/';
	include_once('class/shops.class.php');
	$Shops = new Shops($mysqli, DB_PREFIX);
	include_once('class/product.class.php');
	$Product = new Product($mysqli, DB_PREFIX);
	include_once('class/designer.class.php');
	
	$Designer = new Designer($mysqli, DB_PREFIX);
	include_once('class/category.class.php');
	$Category = new Category($mysqli, DB_PREFIX);

	include_once('class/shops.parse.class.php');
	$ShopImportParse = new ShopImportParse($mysqli, DB_PREFIX);
	
	
?>

<style>
	.find_table{
		width: 100%;
		margin-top: 15px;
		margin-bottom: 15px;
		border-bottom: 1px solid gray;
		border-top: 1px solid gray;
		background-color: #E4FFC9;
	}
	.find_table th{
		padding: 10px;
		text-align: center;
		font-weight: bold;
	}
	.find_table td{
		padding: 5px;
		border-top: 1px solid gray;
	}
	.product_sort{
		width: 300px;
		padding: 5px;
		
	}
	.pagination{
		padding: 5px;
		border: 1px solid gray;
		background-color: #E2E2E2;
		text-align: center;
	}
	.pagination_active{
		background-color: #A6DD96;
		margin-bottom: 15px;
	}
	.result{
		margin-top: 20px;
		width: 100%;
	}
	.result th{
		padding: 4px;
		margin-left: 5px; 
	}
	.result td{
		padding: 4px;
		margin-left: 5px;
		font-size: 12px;
		border-top: 1px solid gray;
	}
	
</style>		

<form method="GET">
	<input type="hidden" class="product_sort" name="route" value="<?php echo $_GET['route']; ?>">
<table class="find_table">
	<tr>
		<th colspan="4">Выборка продуктов</th>
	</tr>
	<tr>
		<td>Название товара</td>
		<td><input type="text" class="product_sort" name="product_name" value="<?php echo (isset($_GET['product_name'])) ? $_GET['product_name'] : '' ;?>" placeholder="Часть названия или кода"></td>
		<td>Магазин</td>
		<td>
			<?php $shops = $Shops->getShops(); ?>
			<SELECT class="product_sort" name="product_shop" >
				<option value="0">все</option>
				<?php foreach($shops as $index => $value){ ?>
					<?php if(isset($_GET['product_shop']) AND is_numeric($_GET['product_shop']) AND $_GET['product_shop'] == $index){ ?>
						<option value="<?php echo $index; ?>" selected><?php echo $value['name']; ?></option>
					<?php }else{ ?>
						<option value="<?php echo $index; ?>"><?php echo $value['name']; ?></option>
					<?php } ?>
				<?php } ?>
			</SELECT>
		</td>
	</tr>
	
	<tr>
		<td>Категория</td>
		<td><a href="javascript:;" class="category_tree select_category">выбрать [дерево]</a> (<span class="selected_category">Все...</span>)
			<input type="hidden" name="category" class="selected_category_id" value="">
			</td>
		<td>Дизайнер</td>
		<td>
			<?php $designer = $Designer->getDesigners(); ?>
			<SELECT class="product_sort" name="product_design" >
				<option value="0">все</option>
				<?php foreach($designer as $index => $value){ ?>
					<?php if(isset($_GET['product_design']) AND is_numeric($_GET['product_design']) AND $_GET['product_design'] == $index){ ?>
						<option value="<?php echo $index; ?>" selected><?php echo $value['name']; ?></option>
					<?php }else{ ?>
						<option value="<?php echo $index; ?>"><?php echo $value['name']; ?></option>
					<?php } ?>
				<?php } ?>
			</SELECT>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Статус</td>
		<td>
			<SELECT class="product_sort" name="product_status" >
				<?php $status = array(-1 => 'Все', 0 => 'На сайте', 1 => 'Модерация', 2 => 'Брак/Закрыт' ) ?>
				<?php foreach($status as $index => $value){ ?>
					<?php if(isset($_GET['product_status']) AND is_numeric($_GET['product_status']) AND $_GET['product_status'] == $index){ ?>
						<option value="<?php echo $index; ?>" selected><?php echo $value; ?></option>
					<?php }else{ ?>
						<option value="<?php echo $index; ?>"><?php echo $value; ?></option>
					<?php } ?>
				<?php } ?>
			</SELECT>
		</td>
	</tr>
	<tr>
		<td colspan="4" style="text-align: center;"><input type="submit" name="submit" class="product_sort" value="submit"></td>
	</tr>
</table>
</form>
<!-- ================================================================== -->
<!-- ================================================================== -->

<?php if(isset($_GET['submit'])){ ?>
<?php
	$filters = array();
	//$filters['start'] = 0;
	
	$name = '';
	if(isset($_GET['product_name']) AND $_GET['product_name'] != ''){
		$filters['filter_model'] = $filters['filter_name'] = $name = $_GET['product_name'];
	}
	$shop_id = 0;
	if(isset($_GET['product_shop']) AND $_GET['product_shop'] > 0){
		$filters['filter_shop'] = $shop_id = $_GET['product_shop'];
	}
	$filter_manufacturer = 0;
	if(isset($_GET['product_design']) AND $_GET['product_design'] > 0){
		$filters['filter_manufacturer'] = $filter_manufacturer = $_GET['product_design'];
	}
	$filter_moderation = -1;
	if(isset($_GET['product_status']) AND $_GET['product_status'] > -1){
		$filters['filter_moderation'] = $filter_moderation = $_GET['product_status'];
	}
	
	$filter_category = 0;
	if(isset($_GET['category']) AND $_GET['category'] > 0){
		$filters['filter_category'] = $filter_category = $_GET['category'];
	}
	
	$products_ID = $Product->getProductsID($filters);
	
	$filters['start'] = 0;
	$filters['limit'] = 50;
	
	if(isset($_GET['page']) AND $_GET['page'] == 'all'){
		$filters['start'] = 0;
		$filters['limit'] = 100000;
	}else{
		if(isset($_GET['page'])) $filters['start'] = (int)($_GET['page']-1);
	
		if($filters['start'] < 0)$filters['start']  = 1;
		if($filters['start'] > (count($products_ID) / $filters['limit'])) $filters['start']  = (int)(count($products_ID) / $filters['limit']);
	
		$filters['start'] = $filters['start'] * $filters['limit'];
	}

	$tmp = $products = $Product->getProducts($filters);
	$page_ids = array();
	foreach($tmp as $tt => $ttt){
		$page_ids[$tt] = $tt;
	}
	
	//echo "<pre>";  print_r(var_dump( $products )); echo "</pre>";
	if(count($products) > 0){
		$max = ceil(count($products_ID) / $filters['limit']);
		$href = '/'.TMP_DIR.'backend/index.php?route=product%2Fproduct.index.php&product_name='.$name.'&product_shop='.$shop_id.'&category='.$filter_category.'&product_design='.$filter_manufacturer.'&product_status='.$filter_moderation.'&submit=submit';
		$count = 1;
		echo '<a href="'.$href.'&page=all" class="pagination pagination_active">Все</a>';	
		while($count <= $max){
			if(isset($_GET['page']) AND is_numeric($_GET['page']) AND $_GET['page'] == $count){
				echo '<a href="'.$href.'&page='.$count.'" class="pagination pagination_active">'.$count.'</a>';	
			}else{ 
				echo '<a href="'.$href.'&page='.$count.'" class="pagination">'.$count.'</a>';
			}
			if($count == 40 OR $count == 80 OR $count == 120){
				echo '<br><br>';
			}
			$count++;
		}

?>
	<table class="result">
		<tr>
			<th>#</th>
			<th>Код</th>
			<th>Картинка</th>
			<th>Название</th>
			<th>* * *</th>
			<th>Модерация</th>
			<th>Магазин</th>
			<th>Дизайнер</th>
			<th>ВСЕ 
				<input type="checkbox" class="dell_check_all" id="dellall">
				<a href="javascript:;" class="dell_key_all" data-id="all">
					<img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16">
				</a>
			</th>
		</tr>
		<?php $ids = implode(',', $page_ids); ?>
		<?php foreach($products as $index => $data){ ?>
			<tr id="<?php echo $data['product_id']; ?>">
				<td><?php echo $data['product_id']; ?></td>
				<td><?php echo $data['model']; ?></td>				
				<td><img src="<?php echo '/'.TMP_DIR.'image/'.$data['image']; ?>" style="max-height:50px;max-width:50px;"></td>
				<td><?php echo $data['name']; ?></td>
				<td>
					<!--a href="/<?php echo TMP_DIR;?>backend/#/backend/product/edit/?id=<?php echo $data['product_id'];?>" target="_blank">
						<img src="/<?php echo TMP_DIR;?>backend/img/edit_icon.png" title="редактировать" width="16" height="16">
					</a-->
					
					<a href="/<?php echo TMP_DIR;?>backend/index.php?route=moderation/product.list.php&id=<?php echo $data['product_id'];?>&products=<?php echo $ids; ?>" target="_blank">
						<img src="/<?php echo TMP_DIR;?>backend/img/remit_c_icon4.png" title="модерировать" width="32" height="32">
					</a>
					
					<!--a href="javascript: void(0);" onclick="if (confirm('Вы действительно хотите удалить эту запись?'))  go('/backend/product/delete/?id=<?php echo $data['product_id'];?>'); return false;">
						<img src="/<?php echo TMP_DIR;?>backend/img/delete_icon.png" title="удалить" width="16" height="16">
					</a-->
				</td>
				<td><?php echo $status[$data['moderation_id']]; ?></td>				
				<td><?php echo $shops[$data['shop_id']]['name']; ?></td>				
				<td><?php echo (isset($designer[$data['manufacturer_id']]['name'])) ? $designer[$data['manufacturer_id']]['name'] : 'ошибка'; ?></td>				
				<td class="mixed">
					<input type="checkbox" class="dell_check" id="dell<?php echo $data['product_id'];?>" data-id="<?php echo $data['product_id'];?>">
					<a href="javascript:;" class="dell_key" data-id="<?php echo $data['product_id'];?>">
						<img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16">
					</a>
				</td>
			</tr>		
		<?php } ?>
	</table>
<script>
	$(document).on('change', '#dellall', function(){
		$.each($('.dell_check'), function( index, value ) {
			
			$(this).prop('checked', $('#dellall').prop('checked'));	
				
		});
		//product_dell();
	});
	
	$(document).on('click', '.dell_key_all', function(){
		
		product_dell();
	});
	
	$(document).on('click', '.dell_key', function(){
		
		var id = jQuery(this).data('id');
		
		$('#dell'+id).prop('checked', true);	
		
		product_dell();
	});
	
	function product_dell() {
		if (confirm('Вы действительно желаете удалить товар?\n\r\n\rНЕ ЗАБЫВАЙТЕ ЧИСТИТЬ ФОТО ПОСЛЕ УДАЛЕНИЯ ТОВАРА!')){
		
			$.each($('.dell_check'), function( index, value ) {
				//debugger;	
				if($(this).prop('checked') == true){
					
					var id = jQuery(this).data('id');
						//console.log($(this).prop('checked')+' '+id);
					jQuery.ajax({
						type: "POST",
						url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_product.php",
						dataType: "text",
						data: "id="+id+"&key=dell",
						beforeSend: function(){
						},
						success: function(msg){
							console.log( msg );
							jQuery('#'+id).hide();
						}
				
					});
					
				}
				
			});
		}
    }
	
</script>

<?php
	}
} ?>

<!-- ================================================================== -->
<!-- ================================================================== -->

<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR;?>backend/libs/category_tree/type-for-get.css">
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/libs/category_tree/script-for-get.js"></script>
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/product/category_tree.js"></script>
		
<script>
	$(document).on('click', '.select_category', function(){
		var id = $(this).data('id');
		$('#target_categ_id').val(id);
		$('#target_categ_name').val($('#categ_name'+id).html());
		$('#container').show();
		$('#container_back').show();
	});
	$(document).on('click', '.close_tree', function(){
		$('#container').hide();
		$('#container_back').hide();
	});
	$(document).on('click', '#container_back', function(){
		$('#container').hide();
		$('#container_back').hide();
	});
</script>
	<div id="container_back"></div>
	<style>
		#container_back{width: 100%;height: 100%;z-index:11000;opacity: 0.7;display: none;position: absolute;background-color: gray;top:0;left:0;}
		#container{z-index:11001;}
	</style>
	
<?php
$Types = array();
$Types[0] = array("id"=>0,"name"=>"Главная");
//=======================================================================
	$sql = 'SELECT C.category_id AS id, C.parent_id, CD.name
					FROM `'.DB_PREFIX.'category` C
					LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
					WHERE parent_id = "0" ORDER BY name ASC;';
	//echo '<br>'.$sql;
	$rs = $mysqli->query($sql) or die ("Get product type list ".mysqli_error($mysqli));
	
	$body = "
			<input type='hidden' id=\"target_categ_id\" value='0'>
			<input type='hidden' id=\"target_categ_name\" value=''>
			<div id=\"container\" class = \"product-type-tree\">
				<h4>Выбрать категорию <span class='close_tree'>[закрыть]</span></h4><ul  id=\"celebTree\">
		";
	while ($Type = $rs->fetch_assoc()) {

	if($Type['parent_id'] == 0){

		$body .=  "<li><span id=\"span_".$Type['id']."\"> <a class = \"tree category_id_".$Type['id']."\" href=\"javascript:\" id=\"".$Type['id']."\">".$Type['name']."</a>";
		$body .= "</span>".readTree($Type['id'],$mysqli);
		$body .= "</li>";
	}
	$Types[$Type['id']]['id'] = $Type['id'];
	$Types[$Type['id']]['name'] = $Type['name'];
	}
	$body .= "</ul>
		</li></ul></div>";

	echo $body;
				
  //Рекурсия=================================================================
function readTree($parent,$mysqli){
	$sql = 'SELECT C.category_id AS id, C.parent_id, CD.name
				FROM `'.DB_PREFIX.'category` C
				LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
				WHERE parent_id = "'.$parent.'" ORDER BY name ASC;';
	//echo $sql.'<br>';
	$rs1 = mysqli_query( $mysqli, $sql) or die ("Get product type list");

	$body = "";

	 while ($Type = mysqli_fetch_assoc($rs1)) {
		$body .=  "<li><span id=\"span_".$Type['id']."\"><a class = \"tree category_id_".$Type['id']."\" href=\"javascript:\" id=\"".$Type['id']."\">".$Type['name']."</a>";
		$body .= "</span>".readTree($Type['id'],$mysqli);
		$body .= "</li>";
	}
	if($body != "") $body = "<ul>$body</ul>";
	return $body;

}
?>