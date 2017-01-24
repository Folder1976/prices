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
	/*
	include_once('class/product.class.php');
	$Product = new Product($mysqli, DB_PREFIX);
	include_once('class/designer.class.php');
	$Designer = new Designer($mysqli, DB_PREFIX);
	*/
	include_once('class/category.class.php');
	$Category = new Category($mysqli, DB_PREFIX);
	if(isset($_GET['modul'])){
		
		include_once('main_page/'.$_GET['modul']);
		
	}else{ ?>
	<!-- Меню выбора -->
		<style>
			.main_page_image{
				display: block;
				position: absolute;
				top: 100px;
				left: 50px;
			}
			.main_menu{
				display: block;
				position: absolute;
				top: 100px;
				left: 50px;
				width: 470px;
				height: 40px;
				opacity: 0.5;
				background-color: #ffffff;
				border: 2px solid #BABABA;
			}
			.left_menu{
				display: block;
				position: absolute;
				top: 140px;
				left: 50px;
				width: 135px;
				height: 300px;
				opacity: 0.5;
				background-color: #ffffff;
				border: 2px solid #BABABA;
			}
			.main_baner{
				display: block;
				position: absolute;
				top: 380px;
				left: 410px;
				width: 630px;
				height: 400px;
				opacity: 0.5;
				background-color: #ffffff;
				border: 2px solid #BABABA;
			}
			.baners{
				display: block;
				position: absolute;
				top: 380px;
				left: 1050px;
				width: 250px;
				height: 400px;opacity: 0.5;
				background-color: #ffffff;
				border: 2px solid #BABABA;
			}
			.season_products{
				display: block;
				position: absolute;
				top: 445px;
				left: 50px;
				width: 800px;
				height: 180px;
				opacity: 0.5;
				background-color: #ffffff;
				border: 2px solid #BABABA;
			}
			.link:hover{
				background: none;
				opacity: 1;
				border: 2px solid #FF0000;
				
			}
		</style>
		<h2>Главная страница сайта</h2>
		<div class="main_page_image">
			<img src="main_page/main_page.jpg">
		</div>
				
		<!--a href="/<?php echo TMP_DIR;?>backend/index.php?route=category/category.index.php" title="Редактор категорий"><div class="main_menu link"></div></a-->
		<!--a href="/<?php echo TMP_DIR;?>backend/index.php?route=main_page/main_page.index.php&modul=main_page.left_menu.php" title="Редактор главного списка категорий"><div class="left_menu link"></div></a-->
		<a href="/<?php echo TMP_DIR;?>backend/index.php?route=main_page/main_page.index.php&modul=main_page.main_baner.php" title="Основной банер"><div class="main_baner link"></div></a>
		<a href="/<?php echo TMP_DIR;?>backend/index.php?route=main_page/main_page.index.php&modul=main_page.baners.php" title="Дополнительные 2 банера"><div class="baners link"></div></a>
		<!--a href="/<?php echo TMP_DIR;?>backend/index.php?route=main_page/main_page.index.php&modul=main_page.season_products.php" title="Сезонные продукты"><div class="season_products link"></div></a-->
<?php } ?>
<!-- Конец меню выбора -->




<!-- ================================================================== -->
<!-- ================================================================== -->
<!--a href="javascript:;" class="category_tree select_category">выбрать [дерево]</a-->

<link rel="stylesheet" type="text/css" href="/<?php echo TMP_DIR;?>backend/libs/category_tree/type-for-get.css">
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/libs/category_tree/script-for-get.js"></script>
<script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/main_page/category_tree.js"></script>
		
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
/*
$Types = array();
$Types[0] = array("id"=>0,"name"=>"Главная");
//=======================================================================
	$sql = 'SELECT C.category_id AS id, C.parent_id, CD.name
					FROM `'.DB_PREFIX.'category` C
					LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
					WHERE parent_id = "0" AND category_id > 0 ORDER BY name ASC;';
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
				WHERE parent_id = "'.$parent.'" AND category_id > 0 ORDER BY name ASC;';
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

}*/
?>