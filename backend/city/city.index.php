<!-- Sergey Kotlyarov 2016 folder.list@gmail.com -->
<?php
$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}

//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================


if(isset( $_FILES['import_file']['tmp_name'])){
	
	$tmpFilename = $_FILES['import_file']['tmp_name'];
	require_once ('libs/docs/PHPExcel/IOFactory.php');
	
	$worksheet = PHPExcel_IOFactory::load($tmpFilename)->getSheet(0);
	
	if(!$worksheet) {die('<h2>Ошибка: лист c данными не найден</h2>');}
	
	$rows = $worksheet->getHighestRow();

	$count =2;
	while('' != $worksheet->getCellByColumnAndRow(1,$count)->getValue()){
		
		//Прочитаесм строчку
		$x = 0;
		$row = array();
		while('' != $worksheet->getCellByColumnAndRow($x,1)->getValue()){
			$row[$worksheet->getCellByColumnAndRow($x,1)->getValue()] = $worksheet->getCellByColumnAndRow($x,$count)->getCalculatedValue();
			$x++;
		}
		$count++;
		
		if(!isset($row['CityID'])){
			$sql = 'INSERT INTO 	'.DB_PREFIX.'citys SET
						`Domain` = "'.htmlentities($row['Domain'],ENT_QUOTES, 'UTF-8').'",
						`is_domain` = "'.(int)$row['IsDomain'].'",
						`CityLable` = "'.htmlentities($row['CityLable'],ENT_QUOTES, 'UTF-8').'",
						`CityLableKuda` = "'.htmlentities($row['CityLableKuda'],ENT_QUOTES, 'UTF-8').'",
						`CityLablePoChemu` = "'.htmlentities($row['CityLablePoChemu'],ENT_QUOTES, 'UTF-8').'",
						`CityLableChego` = "'.htmlentities($row['CityLableChego'],ENT_QUOTES, 'UTF-8').'",
						`Region` = "'.htmlentities($row['Region'],ENT_QUOTES, 'UTF-8').'",
						`poRegionu` = "'.htmlentities($row['poRegionu'],ENT_QUOTES, 'UTF-8').'",
						`ChegoRegiona` = "'.htmlentities($row['ChegoRegiona'],ENT_QUOTES, 'UTF-8').'",
						`People` = "'.htmlentities($row['People'],ENT_QUOTES, 'UTF-8').'",
						`LitlleCity` = "'.htmlentities($row['LitlleCity'],ENT_QUOTES, 'UTF-8').'",
						`KodGoroda` = "'.htmlentities($row['KodGoroda'],ENT_QUOTES, 'UTF-8').'",
						`Population` = "'.htmlentities($row['Population'],ENT_QUOTES, 'UTF-8').'"
		
						
						
						;';
			//echo '<br>'.$sql;
		}else{
			$sql = 'UPDATE 	'.DB_PREFIX.'citys SET
						`Domain` = "'.htmlentities($row['Domain'],ENT_QUOTES, 'UTF-8').'",
						`is_domain` = "'.(int)$row['IsDomain'].'",
						`CityLable` = "'.htmlentities($row['CityLable'],ENT_QUOTES, 'UTF-8').'",
						`CityLableKuda` = "'.htmlentities($row['CityLableKuda'],ENT_QUOTES, 'UTF-8').'",
						`CityLablePoChemu` = "'.htmlentities($row['CityLablePoChemu'],ENT_QUOTES, 'UTF-8').'",
						`CityLableChego` = "'.htmlentities($row['CityLableChego'],ENT_QUOTES, 'UTF-8').'",
						`Region` = "'.htmlentities($row['Region'],ENT_QUOTES, 'UTF-8').'",
						`poRegionu` = "'.htmlentities($row['poRegionu'],ENT_QUOTES, 'UTF-8').'",
						`ChegoRegiona` = "'.htmlentities($row['ChegoRegiona'],ENT_QUOTES, 'UTF-8').'",
						`People` = "'.htmlentities($row['People'],ENT_QUOTES, 'UTF-8').'",
						`LitlleCity` = "'.htmlentities($row['LitlleCity'],ENT_QUOTES, 'UTF-8').'",
						`KodGoroda` = "'.htmlentities($row['KodGoroda'],ENT_QUOTES, 'UTF-8').'",
						`Population` = "'.htmlentities($row['Population'],ENT_QUOTES, 'UTF-8').'"
		
						WHERE `CityID` = '.(int)$row['CityID'].';';
			//echo '<br>'.$sql;
		}
		$mysqli->query($sql) or die('<br>Ошибка импорта : '.$sql);
		
	}

}
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================


$table = 'citys';
$main_key = 'CityID';

$sql = 'SELECT * FROM '.DB_PREFIX.$table.' ORDER BY Domain, CityLable;';
$r = $mysqli->query($sql);

$arr = array();
while($row = $r->fetch_assoc()){
	$arr[$row['CityID']] = $row;
}

?>
<br>
<!--script type="text/javascript" src="/<?php echo TMP_DIR;?>backend/js/backend/ajax_edit_attributes.js"></script-->
<h1>Справочник : Города</h1>
<div style="width: 90%">
<div class="table_body">

<!-- ============================================================ -->
	<div class="top_header">
		<h1 style="margin-bottom: 10px;" class="header">Импорт / экспорт Сео тегов для категорий и фильтров</h1>
	</div>

    <div style="max-width: 1375px;">
    <div class="table_body">
        
        <div class="navigation">
            <form name="import_exel_carfit" method="post" enctype="multipart/form-data">
            
			        <div class="top_select">
						ИМПОРТ
                       <div class="select_top get_file_wrapper"  style="margin-top: 10px;">
                            <label class="select_lable">Фаил</label>
                            <!--input type="file" name="file" style="width:300px;"-->
                            <input type="file" name="import_file"> <!--accept=".txt,image/*"-->
                                <div class="ajax-respond"></div>
                        </div>
					    <br>
						<div class="select_top shop">
                            <label class="select_lable">Фаил</label>
                            <input type="submit" value="Загрузить" style="width:300px;">
                        </div>
					</div>
            </form>                
                    <div class="top_select">
                        <div class="select_top shop">
							ЭКПОРТ<br><br>
                            <button style="width:300px;height: 50px;" id="export">Сказать фаил</button>
						</div>
                    </div>
       
					<div class="top_select" style="margin-top: -0px;height: 230px;">
                        <div class="select_top shop">
							<ul style="font-size: 12px;">Памятка по полям:
								<li><b>CityID</b> - ид города (оставьте это поле пустым если хотите добавить новый город)</li>
								<li><b>Domain</b> - ключ поддомена</li>
								<li><b>IsDomain</b> - (0 , 1) Домен или путь</li>
								<li><b>CityLable</b> - Город [именительный] (Москва)</li>
								<li><b>CityLableKuda</b> - Город [дательный] (В Москву)</li>
								<li><b>CityLablePoChemu</b> - Город [предложный](По Москве)</li>
								<li><b>CityLableChego</b> - Город [родительный](Чего? Москвы)</li>
								
								<li><b>Region</b> - ***</li>
								<li><b>poRegionu</b> - ***</li>
								<li><b>ChegoRegiona</b> - ***</li>
								<li><b>People</b> - ***</li>
								<li><b>LitlleCity</b> - ***</li>
								<li><b>KodGoroda</b> - ***</li>
								<li><b>Population</b> - ***</li>
								
							</ul>
                         </div>
                    </div>
       
        </div>
		<div style="clear: both"></div>

<script>
    $(document).on('click', '#export', function(){  
      location.href = '/<?php echo TMP_DIR; ?>backend/city/get_excel.php';
    });

</script>
<!-- ============================================================ -->



<table class="text">
    <tr>
        <th>id</th>
        <th>Домен</th>
        <th>Это Домен</th>
     	<th>Город [именительный] (Москва)</th>
        <th>Город [дательный] (В Москву)</th>
        <th>Город [предложный](По Москве)</th>
		<th>Город [родительный](Чего? Москвы)</th>
		
		<th><b>Region</b> - ***</th>
		<th><b>poRegionu</b> - ***</th>
		<th><b>ChegoRegiona</b> - ***</th>
		<th><b>People</b> - ***</th>
		<th><b>LitlleCity</b> - ***</th>
		<th><b>KodGoroda</b> - ***</th>
		<th><b>Population</b> - ***</th>

		<th></th>
    </tr>

    <tr>
        <td class="mixed">новый</td>
        <td class="mixed"><input type="text"        id="Domain" style="width:100px;" value="" placeholder="Название фильтра"></td>
        <td class="mixed"><input type="checkbox"    id="IsDomain"></td>
        <td class="mixed"><input type="text"        id="CityLable" style="width:200px;" value=""></td>
        <td class="mixed"><input type="text"        id="CityLableKuda" style="width:200px;" value=""></td>
        <td class="mixed"><input type="text"        id="CityLablePoChemu" style="width:200px;" value=""></td>
		<td class="mixed"><input type="text"        id="CityLableChego" style="width:200px;" value=""></td>
    
		<td class="mixed"><input type="text"        id="Region" style="width:200px;" value=""></td>
    	<td class="mixed"><input type="text"        id="poRegionu" style="width:200px;" value=""></td>
    	<td class="mixed"><input type="text"        id="ChegoRegiona" style="width:200px;" value=""></td>
    	<td class="mixed"><input type="text"        id="People" style="width:200px;" value=""></td>
    	<td class="mixed"><input type="text"        id="LitlleCity" style="width:200px;" value=""></td>
    	<td class="mixed"><input type="text"        id="KodGoroda" style="width:200px;" value=""></td>
    	<td class="mixed"><input type="text"        id="Population" style="width:200px;" value=""></td>
    
	    <td>        
            <a href="javascript:" class="add">
                <img src="/<?php echo TMP_DIR; ?>backend/img/add.png" title="Добавить" width="16" height="16">
            </a>
        </td>              
    </tr>
    <td>
        <td colspan="6">&nbsp;</td>
    </td>

<?php foreach($arr as $index => $ex){ ?>
    <tr id="<?php echo $ex['CityID'];?>">
        <td class="mixed"><?php echo $ex['CityID'];?></td>
        <td class="mixed"><input type="text" class="edit" id="Domain<?php echo $ex['CityID'];?>" style="width:100px;" value="<?php echo $ex['Domain']; ?>"></td>
        <td class="mixed"><input type="checkbox" class="edit" id="IsDomain<?php echo $ex['CityID'];?>" <?php if($ex['IsDomain'] == 1) echo ' checked '; ?>></td>
        <td class="mixed"><input type="text" class="edit" id="CityLable<?php echo $ex['CityID'];?>" style="width:200px;" value="<?php echo $ex['CityLable']; ?>"></td>
        <td class="mixed"><input type="text" class="edit" id="CityLableKuda<?php echo $ex['CityID'];?>" style="width:200px;" value="<?php echo $ex['CityLableKuda']; ?>"></td>
        <td class="mixed"><input type="text" class="edit" id="CityLablePoChemu<?php echo $ex['CityID'];?>" style="width:200px;" value="<?php echo $ex['CityLablePoChemu']; ?>"></td>
        <td class="mixed"><input type="text" class="edit" id="CityLableChego<?php echo $ex['CityID'];?>" style="width:200px;" value="<?php echo $ex['CityLableChego']; ?>"></td>
    
	    <td class="mixed"><input type="text" class="edit" id="Region<?php echo $ex['CityID'];?>" style="width:200px;" value="<?php echo $ex['Region']; ?>"></td>
        <td class="mixed"><input type="text" class="edit" id="poRegionu<?php echo $ex['CityID'];?>" style="width:200px;" value="<?php echo $ex['poRegionu']; ?>"></td>
        <td class="mixed"><input type="text" class="edit" id="ChegoRegiona<?php echo $ex['CityID'];?>" style="width:200px;" value="<?php echo $ex['ChegoRegiona']; ?>"></td>
        <td class="mixed"><input type="text" class="edit" id="People<?php echo $ex['CityID'];?>" style="width:200px;" value="<?php echo $ex['People']; ?>"></td>
        <td class="mixed"><input type="text" class="edit" id="LitlleCity<?php echo $ex['CityID'];?>" style="width:200px;" value="<?php echo $ex['LitlleCity']; ?>"></td>
        <td class="mixed"><input type="text" class="edit" id="KodGoroda<?php echo $ex['CityID'];?>" style="width:200px;" value="<?php echo $ex['KodGoroda']; ?>"></td>
        <td class="mixed"><input type="text" class="edit" id="Population<?php echo $ex['CityID'];?>" style="width:200px;" value="<?php echo $ex['Population']; ?>"></td>
       
	    <td>        
            <a href="javascript:;" class="dell" data-id="<?php echo $ex['CityID'];?>">
                <img src="/<?php echo TMP_DIR; ?>backend/img/cancel.png" title="удалить" width="16" height="16">
            </a>
        </td>              
    </tr>
<?php } ?>

</table>
<input type="hidden" id="table" value="<?php echo $table; ?>">
<script>

    
</script>



</div>

</div>

<style>
	.top_select{
		float: left;
		padding: 10px;
		border: solid 1px #aacfe4;
		margin: 10px;
        height: 100px;
	}
	.table_body{
		margin: 10px;
	}
    .top_header{
        margin: 10px;
    }
	
	body{
		overflow: auto;
	}
</style>

<script>
	 //======================================================================   
    
    $(document).on('change','.edit', function(){
		var id = jQuery(this).parent('td').parent('tr').attr('id');
	
		var Domain = $('#Domain'+id).val();
		var IsDomain = 0;
		var CityLable = $('#CityLable'+id).val();
		var CityLableKuda = $('#CityLableKuda'+id).val();
		var CityLablePoChemu = $('#CityLablePoChemu'+id).val();
		var CityLableChego = $('#CityLableChego'+id).val();
	
		var Region = $('#Region'+id).val();
		var poRegionu = $('#poRegionu'+id).val();
		var ChegoRegiona = $('#ChegoRegiona'+id).val();
		var People = $('#People'+id).val();
		var LitlleCity = $('#LitlleCity'+id).val();
		var KodGoroda = $('#KodGoroda'+id).val();
		var Population = $('#Population'+id).val();
		
		if ($('#IsDomain'+id).prop('checked') == true) {
            IsDomain = 1;
        }
	
		//name = name.replace('&','@*@');
		//href = href.replace('&','@*@');
		
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			dataType: "text",
			data: "id="+id+"&IsDomain="+IsDomain+"&Domain="+Domain+"&Region="+Region+"&poRegionu="+poRegionu+"&ChegoRegiona="+ChegoRegiona+"&People="+People+"&LitlleCity="+LitlleCity+"&KodGoroda="+KodGoroda+"&Population="+Population+"&CityLableChego="+CityLableChego+"&CityLable="+CityLable+"&CityLableKuda="+CityLableKuda+"&CityLablePoChemu="+CityLablePoChemu+"&mainkey=<?php echo $main_key;?>&table=<?php echo $table; ?>&key=edit",
			beforeSend: function(){
			},
			success: function(msg){
			  console.log(  msg );
			}
		});
	});
	
	//Add
	$(document).on('click','.add', function(){
	
		var Domain = $('#Domain').val();
		var IsDomain = 0;
		var CityLable = $('#CityLable').val();
		var CityLableKuda = $('#CityLableKuda').val();
		var CityLablePoChemu = $('#CityLablePoChemu').val();
		var CityLableChego = $('#CityLableChego').val();
		
		var Region = $('#Region').val();
		var poRegionu = $('#poRegionu').val();
		var ChegoRegiona = $('#ChegoRegiona').val();
		var People = $('#People').val();
		var LitlleCity = $('#LitlleCity').val();
		var KodGoroda = $('#KodGoroda').val();
		var Population = $('#Population').val();
	
		//name = name.replace('&','@*@');
		//href = href.replace('&','@*@');
		
		if ($('#IsDomain').prop('checked') == true) {
            IsDomain = 1;
        }
		
		if (CityLable == '') {
            alert('Название города пустое!');
			return false;
        }
		$.ajax({
			type: "POST",
			url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
			dataType: "text",
			data: "&IsDomain="+IsDomain+"&Domain="+Domain+"&Region="+Region+"&poRegionu="+poRegionu+"&ChegoRegiona="+ChegoRegiona+"&People="+People+"&LitlleCity="+LitlleCity+"&KodGoroda="+KodGoroda+"&Population="+Population+"&CityLable="+CityLable+"&CityLableChego="+CityLableChego+"&CityLableKuda="+CityLableKuda+"&CityLablePoChemu="+CityLablePoChemu+"&mainkey=<?php echo $main_key;?>&table=<?php echo $table; ?>&key=add",
			beforeSend: function(){
			},
			success: function(msg){
			  console.log(  msg );
			  location.reload();
			}
		});
		
	});
	
   	//Удаление
   $(document).on('click','.dell', function(){
       var id = jQuery(this).parent('td').parent('tr').attr('id');
      
	  if (confirm('Вы действительно желаете удалить город?')){
		$.ajax({
		  type: "POST",
		  url: "/<?php echo TMP_DIR; ?>backend/ajax/ajax_edit_universal.php",
		  dataType: "text",
		  data: "id="+id+"&table=<?php echo $table; ?>&mainkey=<?php echo $main_key;?>&key=dell",
		  beforeSend: function(){
			
		  },
		  success: function(msg){
			console.log(  msg );
			location.reload;
			jQuery('#'+id).hide()
		  }
		});
	  }
    });
    //======================================================================
</script>
