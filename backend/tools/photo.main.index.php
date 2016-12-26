<!-- Sergey Kotlyarov 2016 folder.list@gmail.com -->
<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}

set_time_limit(0);
ini_set("max_execution_time","0");
ini_set("memory_limit","256G");
error_reporting(E_ALL ^ E_DEPRECATED);

	include_once('class/product.class.php');
	$Product = new Product($mysqli, DB_PREFIX);
	
	$x = $Product->dellImages();
	
	die('Готoво!');
	if(!isset($_SESSION['dell_files'])) $_SESSION['dell_files'] = 0;
	
	//Проверим или это не устаревший фаил
	$sql = 'SELECT `id`, `to` FROM '.DB_PREFIX.'import_pic LIMIT '.(int)$_SESSION['dell_files'].', 1000;';
	$r = $mysqli->query($sql) or die($sql);
$i = 0;
		if($r->num_rows > 0){
			while($row = $r->fetch_assoc()){
				
				$dell = 1;
				
				$sql = 'SELECT product_id FROM '.DB_PREFIX.'product WHERE image LIKE "product/'.$row['to'].'" LIMIT 0, 1';
				$r1 = $mysqli->query($sql) or die($sql);
				if($r1->num_rows > 0){
					continue;
				}
			
				$sql = 'SELECT product_id FROM '.DB_PREFIX.'product_image WHERE image LIKE "product/'.$row['to'].'" LIMIT 0, 1';
				$r1 = $mysqli->query($sql) or die($sql);
				if($r1->num_rows > 0){
					continue;
				}
				
				
				$sql = 'DELETE FROM '.DB_PREFIX.'import_pic WHERE id = "'.$row['id'].'"';
				$mysqli->query($sql) or die($sql);
				$i++;
				//echo '<br>'.$sql;
			
			}
		
				
			
	
		}else{
			echo 'Почистил все!';die();
		}
		
		$_SESSION['dell_files'] += 1000;
		?>
			<script>
				jQuery(document).ready(function(){
					console.log('reload 5 s');
					setTimeout(function(){
							location.reload();
					}, 5000);
				});
			</script>
		<?php
		echo 'Удалено - '.$i.' => старт от '.$_SESSION['dell_files'];


	