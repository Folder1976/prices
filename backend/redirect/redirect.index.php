<?php

$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}
?>
<style>
	h2{
		margin: 15px;
		font-size: 22px;
		font-weight: bold;
	}
	h3{
		margin: 10px;
		font-size: 18px;
		font-weight: bold;
	}
	h4{
		margin: 10px;
		font-size: 16px;
		font-weight: bold;
	}
	a{
		color: #003B56;
	}
	table {
		border-collapse: separate;
		border-spacing: 0;
		margin-top: 20px;
		width: 100%;
		border: 1px solid #2B2B2B;
	}
	td{
		padding: 5px 5px 5px 20px;
		border-bottom: 1px solid #2B2B2B;
		font-size:12px;
		
	}
	th{
		padding: 5px 5px 5px 20px;
		border-bottom: 1px solid #2B2B2B;
		border-top: 1px solid #2B2B2B;
		font-size:12px;
		font-weight: bold;
	}

	ul{
		margin-left: 30px;
	}
</style>



<h3>Редиректы</h3>


<?php
	//Импортируем файлы
	if(isset( $_FILES['excel_kottem']['tmp_name'])){
	
		//Получим фаил	
		$tmpFilename = $_FILES['excel_kottem']['tmp_name'];
	
		//Подключим библиотеку экселя
		require_once ('libs/docs/PHPExcel/IOFactory.php');
		
		//Если прилетело название листа - откроем его
		if(isset($_POST['excel_table_name']) AND $_POST['excel_table_name'] != ''){
			$worksheet = PHPExcel_IOFactory::load($tmpFilename)->getSheetByName($_POST['excel_table_name']);
		}else{
			$worksheet = PHPExcel_IOFactory::load($tmpFilename)->getSheet(0);
		}
		
		//Если лист кривой
		if(!$worksheet){
			echo '<h2>Ошибка: лист c данными не найден</h2>';
		}else{
			$rows = $worksheet->getHighestRow();
			
			//Очистим таблицу - перезапись с нуля
			$mysqli->query('DELETE FROM '.DB_PREFIX.'redirect');
			
			//читаем фаил
			$count = 1;
			while('' != $worksheet->getCellByColumnAndRow(0,$count)->getValue()){
				
				//Прочитаем строчку - если колонки именные
				$row = array();
				
				$row['from'] = $worksheet->getCellByColumnAndRow(0,$count)->getCalculatedValue();
				$row['to'] = $worksheet->getCellByColumnAndRow(1,$count)->getCalculatedValue();
				
				//Пишем в базу
				$sql = 'INSERT INTO '.DB_PREFIX.'redirect SET url_from="'.$row['from'].'", url_to="'.$row['to'].'";';
				$mysqli->query($sql) or die('<br>Ошибка! '.$count.' '.mysqli_error($mysqli));
				
				$count++;
			}
			
			echo '<h3><font color="green">Импортировано '.$count.' строк</font></H3>';
		}
	
	} ?>

<h4><a href="javascript:;" id="export">Получить фаил</a></h4>
<script>
    $(document).on('click', '#export', function(){  
      location.href = '/backend/redirect/get_excel.php';
    });
</script>
<h4>Загрузить фаил</h4>
    <form name="import_exel" method="post" enctype="multipart/form-data" style="width: 100%; background-color: #D6D6FF;">
            <table>
                <tr>
                    <td style="width:100px;"><b>Лист:</b></td>
                    <td><input type="text" name="excel_table_name" style="width:300px;" placeholder="Имя листа! по умолчанию - первый"></td>
                </tr>
                <tr>
                    <td><b>Фаил для импорта (Excel2007 *.xls):</b></td>
                    <td><input type="file" name="excel_kottem" style="width:300px;"></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="Загрузить" style="width:300px;">
                    </td>
                </tr>
            </table>
    </form>
    <h4>Памятка по колонкам</h4>
    <ul>
        <li><b>A</b> - Урл с которого редиректим</li>
        <li><b>A</b> - Урл куда редиректим</font></li>
        <li>Урл пишем без доменного имени и без начального слеш!!!</li>
    </ul>


<br><br>	<hr>

<h3>Уже имеющиеся записи</h3>
<?php
	$r = $mysqli->query('SELECT * FROM '.DB_PREFIX.'redirect ORDER BY url_from');
	if($r->num_rows){ ?>
		
		<table style="background-color: #F7FFFC;"><tr><th>FROM</th><th>TO</th></tr>
		
		<?php while($row = $r->fetch_assoc()){ ?>
			
			<tr>
				<td><?php echo $row['url_from']; ?></td>
				<td><?php echo $row['url_to']; ?></td>
			</tr>
			
		<?php } ?> 
		
		</table>
		
	<?php }
?>