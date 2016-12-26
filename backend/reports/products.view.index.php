<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
?>
<br>
<h1>Просмотры товаров</h1>
<style>
	h1{
		font-size: 20px;
		margin: 20px;
	}
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
 .settings{
	margin: 10px;
	width: 400px;
	float: left;
	display: block;
 }
 .settings select{
	width: 200px;	
 } 
 
</style>
<form method="GET" action="/backend/index.php">
	<input type="hidden" name="route" value="<?php echo $_GET['route']; ?>">
	<div class="settings">Групировать :
		<select name="order">
			<option value="all">По товару</option>
			<option value="day">По дням</option>
		</select>
	</div>
	<div class="settings">Сортировать :
		<select name="order">
			<option value="date">По дате</option>
			<option value="items">По просмотрам</option>
			<option value="shops">По магазинам</option>
		</select>
	</div>
</form>
	  
<?php
	
	$order = 'ORDER BY views DESC';
	if(isset($_GET['order'])){
		if($_GET['order'] == 'date'){
			$order = 'ORDER BY PV.date DESC';
		}elseif($_GET['order'] == 'items'){
			$order = 'ORDER BY views DESC';
		}elseif($_GET['order'] == 'shops'){
			$order = 'ORDER BY P2S.id ASC';
		}
	}

	$group = 'GROUP BY PV.product_id';
	if(isset($_GET['group'])){
		if($_GET['group'] == 'all'){
			$group = 'GROUP BY PV.product_id';
		}
	}
	
	$sql = 'SELECT count(PV.product_id) AS views,
					PV.product_id,
					PV.date,
					PV.user,
					PD.name,
					S.id AS shop_id,
					S.name AS shop_name
					
					FROM '.DB_PREFIX.'product_views PV
					LEFT JOIN '.DB_PREFIX.'product_description PD ON PD.product_id = PV.product_id
					LEFT JOIN '.DB_PREFIX.'product_to_shop P2S ON PV.product_id = P2S.product_id
					LEFT JOIN '.DB_PREFIX.'shops S ON S.id = P2S.shop_id
					'.$group.'
					'.$order.'
					';
	$r = $mysqli->query($sql) or die('<br>Ошибка запроса: <br>'.$sql);
	//echo '<br>'.$sql.'<br>';
?>

<div style="width: 90%">
    <div class="table_body">
        <table class="text">
		<tr>
			<th>#</th>
			<th>Продукт</th>
			<th>Показов</th>
			<th>Дата</th>
			<th>Магазин</th>
		</tr>
      
<?php while($value = $r->fetch_assoc()){ ?>

	<?php $date = date('Y-m-d', strtotime($value['date'])); ?>

 <tr id="<?php echo $value['product_id']; ?>">
      <td><?php echo $value['product_id']; ?></td>
	  <td><?php echo $value['name']; ?></td>
	  <td style="text-align: center;"><b><?php echo $value['views']; ?></b></td>
	  <td><?php echo $date; ?></td>
	  <td><?php echo $value['shop_name']; ?></td>
    </tr>
  
<?php } ?>

	</table>
	</div>
</div>
