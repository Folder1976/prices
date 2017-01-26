<?php

include("init.php");
 

class Import_productsV1{
	public $language_id = 1;

	public function qa($query_txt,$closerows=0){

		global $mysqli;
		$query_result=array();

		$query=$mysqli->query($query_txt) or die(mysql_error().'<br>'.htmlspecialchars($query_txt));
		$query_rows=$query->num_rows;

		for($i=0;$i<$query_rows;$i++){
			array_push($query_result,$query->fetch_assoc());
		}

		if(!$closerows){

			$query_result['rows']=$query_rows;

		}

		//mysql_free_result($query);

		return $query_result;

	}

	public function qr($query_txt,$colname=''){
		global $mysqli;
		$query=$mysqli->query($query_txt) or die(mysql_error().'<br>'.htmlspecialchars($query_txt));
		$query_rows = $query->num_rows;
		$row = $query->fetch_assoc();
		return $row[$colname];

	}

	public function Detect_brend_with_products($name){

		$name=str_replace('  ',' ',stripslashes($name));
		$dbr=explode(' ',strtolower(ltrim(rtrim(str_replace('/',' ',$name)))));
		if(strpos('x'.strtolower($dbr[0]),'intel')){$dbr[0]='Intel';}
		elseif(strpos('x'.strtolower($dbr[1]),'intel')){$dbr[1]='Intel';}

		$totalkeys=array();

		for($i=0;$i<sizeof($dbr);$i++){

			array_push($totalkeys,$dbr[$i]);

			$mybrendid_test=$this->qr("select manufacturer_id from ".DB_PREFIX."manufacturer where  upper(`name`) LIKE '".mb_strtoupper(addslashes(trim($dbr[$i])))."'","manufacturer_id");

			if(!$mybrendid_test){
				$mybrendid_test=$this->qr("select brand_id from ".DB_PREFIX."manufacturer_alternative where upper(`name`)LIKE '".mb_strtoupper(addslashes(trim($dbr[$i])))."'",'brand_id');
			}

			if($mybrendid_test){return $mybrendid_test;}
			
			if(isset($dbr[$i+1])){
				array_push($totalkeys,$dbr[$i].' '.$dbr[$i+1]);
	
				$mybrendid_test=$this->qr("select manufacturer_id from ".DB_PREFIX."manufacturer where  upper(`name`) LIKE '".mb_strtoupper(addslashes(trim($dbr[$i].' '.$dbr[$i+1])))."'","manufacturer_id");
	
				if(!$mybrendid_test){
					$mybrendid_test=$this->qr("select brand_id from ".DB_PREFIX."manufacturer_alternative where upper(`name`)LIKE '".mb_strtoupper(addslashes(trim($dbr[$i].' '.$dbr[$i+1])))."'",'brand_id');
				}
	
				if($mybrendid_test){return $mybrendid_test;}
			}

			if(isset($dbr[$i+2])){
				array_push($totalkeys,$dbr[$i].' '. $dbr[$i+1].' '.$dbr[$i+2]);
				$mybrendid_test=$this->qr("select manufacturer_id from ".DB_PREFIX."manufacturer where  upper(`name`)LIKE'".mb_strtoupper(addslashes(trim($dbr[$i].' '.$dbr[$i+1].' '.$dbr[$i+2])))."'","manufacturer_id");

				if(!$mybrendid_test){
					$mybrendid_test=$this->qr("select brand_id from ".DB_PREFIX."manufacturer_alternative where upper(`name`)LIKE'".mb_strtoupper(addslashes(trim($dbr[$i].' '.$dbr[$i+1].' '.$dbr[$i+2])))."'",'brand_id');
				}
	
				if($mybrendid_test){return $mybrendid_test;}
			}

		}
		
		
		return intval($mybrendid_test);

	}

	public function ressetCategoryForMagazin($magazinid){

	}

}


$import=new Import_productsV1();
?>

<style>

.error{ padding:10px; background:#E1F4FB; border:#EE471C 2px solid; margin:10px;}

.error2{ padding:10px; background:#E3F4FC; border:#95B800 2px solid; margin:10px;}

</style>

<?php

$start_time = microtime(true);
?>

<form action="" method="post" enctype="multipart/form-data">

<table>

<input type="hidden" name="importlist" value="1">

	<tr>
    	<td>Тип файла:</td> <td><select name="importtype">

    	<option <?php if(!isset($_POST['importtype'])){echo 'selected="selected"';} ?> value="">Выберите тип файла</option>

        <?php
        $r=$mysqli->query("select * from ".DB_PREFIX."shop where status=1 and importopt!='' order by name");
		while($row = $r->fetch_assoc()){
		?>
        	<option <?php if(isset($_POST['importtype']) AND $_POST['importtype']==$row['importopt'].','.$row['id']){$selectedmagazinid=$row['id'];echo 'selected="selected"';} ?> value="<?php echo $row['importopt']?>,<?php echo $row['id']?>">
            	<?php echo $row['name']?>
            </option>
        <?php } ?>

        <!--
        Стандарт значение -  это 
		Название - Цена - гарантия - cells
        -->

    </select></td></tr>
    <tr><td>Выберите файл: <td><input type="file" name="import" value="<?php echo $_FILES['import']?>"></td></tr>
    <tr><td rowspan="13">Настройки</td><td><input type="checkbox" name="testcategory" <?php if(isset($_POST['testcategory'])){echo 'checked';} ?>>Тестирование категорий(Товары будут скрыты)</td></tr>
    <tr><td><input type="checkbox" name="addautomate" <?php if(isset($_POST['addautomate'])){echo 'checked';} ?>>Добавить определенные товары в базу и показать только не неопределенные товары</td></tr>
        <tr><td><input type="checkbox" name="addautomateprices" <?php if(isset($_POST['addautomateprices'])){echo 'checked';} ?>>Автоматически добавлять цены</td></tr>
<tr><td><input type="checkbox" name="testfile" <?php if(isset($_POST['testfile'])){echo 'checked';} ?>>FILE STRUCTURE TEST</td></tr>
<tr><td><input type="checkbox" name="testimporting" <?php if(isset($_POST['testimporting'])){echo 'checked';} ?>>ONLY TEST</td></tr>
<tr><td><input type="checkbox"  name="clearbefore" <?php if(isset($_POST['clearbefore'])){echo 'checked';} ?>>Clear ald prices BEFORE UPLOAD</td></tr>
<tr><td><input type="checkbox"  name="activatestatus1" <?php if(isset($_POST['activatestatus1'])){echo 'checked';} ?>>Проверка на активность категории</td></tr>
<tr><td><input type="checkbox"  name="sbrosnastroyki" <?php if(isset($_POST['sbrosnastroyki'])){echo 'checked';} ?>>Сбросить настройки отмеченных категорий всех товаров для импортируемого магазина</td></tr>
<tr><td><input type="checkbox"  name="updateproperties" <?php if(isset($_POST['updateproperties'])){echo 'checked';} ?>>Обновлять характеристики</td></tr>
<tr><td><input type="checkbox"  name="hide_no" <?php if(isset($_POST['hide_no'])){echo 'checked';} ?>>Скрыть неопределенные</td></tr>
<tr><td><input type="checkbox"  name="hide_yes" <?php if(isset($_POST['hide_yes'])){echo 'checked';} ?>>Скрыть определенные</td></tr>
<tr><td><input type="checkbox"  name="no_brand" <?php if(isset($_POST['no_brand'])){echo 'checked';} ?>>Товары без брендов</td></tr>
<tr><td><input type="checkbox"  name="select_cat" <?php if(isset($_POST['select_cat'])){echo 'checked';} ?>>Выделить определенные категори</td></tr>
    <tr><td><input type="submit" value="Импортировать"></td>
</table>
<div>
<?php
$dater=date("Y-m-d");

if(isset($_POST['importlist'])){

	if(isset($_POST['clearbefore'])){$mysqli->query("delete from ".DB_PREFIX."product_prices where magazinid=$selectedmagazinid"); echo "Магазин очищен"; die(); }
	$k = '';

	if(isset($_POST['activatestatus1'])){$k=" and status=1";}

	$menu=querytoarray("select CD.category_id AS id, CD.name from ".DB_PREFIX."category_description CD
							LEFT JOIN ".DB_PREFIX."category C ON C.category_id = CD.category_id
							where language_id = '1' AND parent_id=0 $k");

	$file=$_FILES['import']['tmp_name'];
	$conect=explode(',',$_POST['importtype']);
	
	$list = array();

	require('PHPExcel/PHPExcel.php');
	require_once 'PHPExcel/PHPExcel/IOFactory.php';
	$objPHPExcel = PHPExcel_IOFactory::load($file);
	$objPHPExcel->setActiveSheetIndex($conect[3]);
	
	$list = array();
	
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet){

		$highestRow         = $worksheet->getHighestRow();
		$highestColumn      = $worksheet->getHighestColumn();
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

		for ($row = 1; $row <= $highestRow; ++ $row){

			for ($col = 0; $col < $highestColumnIndex; ++ $col){

				$cell = $worksheet->getCellByColumnAndRow($col, $row);
	            $val = $cell->getCalculatedValue();

				if (empty($val)) $val = $cell->getValue();

				$list[$row][$col+1] = $val;
			}

		}

	}

	echo '<pre>';

	if(isset($_POST['testfile'])){print_r($list);exit();}
		$mymenuid=0;
		$mymenuidtmp=0;
		$mybrendid=0;
		$purCategory = 0;
		$allCategory = array();
		
		$allPrevCheckres = querytoarray("select * from ".DB_PREFIX."parser_prev");

		$allPrevCheckresKey = array();

		foreach ($allPrevCheckres as $PrevCheckres) {

			if (!empty($PrevCheckres["name"]) && $PrevCheckres["shop_id"] == $conect[5])
			$allPrevCheckresKey[$PrevCheckres["name"]][$PrevCheckres["prev_name"]][$PrevCheckres["last_name"]] = $PrevCheckres;

		}

		$allBrenddopnames = querytoarray("select * from ".DB_PREFIX."manufacturer_alternative");
		$allBrenddopnamesKey = array();

		foreach ($allBrenddopnames as $Brenddopnames) {
			$bname = explode(",", $Brenddopnames["name"]);

			foreach ($bname as $bdopname) {

			if (!empty($bdopname))
				$allBrenddopnamesKey[$bdopname] = $Brenddopnames["brand_id"];
			}

		}

		$allCatRes = querytoarray("select category_id AS id, parent_id AS wmotmenuid from ".DB_PREFIX."category");

		foreach ($allCatRes as $catRes)

			$allCategory[$catRes["id"]] = $catRes["wmotmenuid"];
			$allProperties = array();	
			$allPropertiesRegular = array();
			
			$allPropertiesRes = querytoarray("select attribute_id, name from ".DB_PREFIX."attribute_description where language_id = '1'");
			foreach ($allPropertiesRes as $propRes)
				$allProperties[$propRes["attribute_id"]] = $propRes;

			$allPropertiesRegularRes = querytoarray("select * from ".DB_PREFIX."attribute_regular where 0");

	
			foreach ($allPropertiesRegularRes as $propRegRes) {
		
				if(is_array($propRegRes) AND isset($propRegRes["properties_id"])){
		
					$propRegRes["name"] = $allProperties[$propRegRes["properties_id"]]["name"];
		
				}
		
				$allPropertiesRegular[$propRegRes["prioritet"]][] = $propRegRes;
		
			}

		

	ksort($allPropertiesRegular);

	

	$allParserDivision = array();

	$allParserDivisionR = querytoarray("select * from ".DB_PREFIX."parser_division where magazin_id='".$conect[5]."'");

	

	foreach ($allParserDivisionR as $ParserDivisionRes) {

		if(!empty($ParserDivisionRes["category_name"])) {

			$ParserDivisionRes["division"] = explode(",", $ParserDivisionRes["division_name"]);

			$allParserDivision[$ParserDivisionRes["category_name"]][] = $ParserDivisionRes;

		}

	}



	//получаем данные по каким категориям игнорировать импорт

	$ParserDivision_exclus = array();

	//$ParserDivisionR_exclus = querytoarray("select * from parser_division_exclusion where magazin_id='".$conect[5]."'");

	$ParserDivisionR_exclus = querytoarray("select * from ".DB_PREFIX."parser_division_exclusion where magazin_id='".$conect[5]."'");

	foreach ($ParserDivisionR_exclus as $Parser_exclusion_Res) {

		if(!empty($Parser_exclusion_Res["category_name"])) {

			$Parser_exclusion_Res["division_ex"] = explode(",", $Parser_exclusion_Res["division_name_ex"]);

			$ParserDivision_exclus[] = $Parser_exclusion_Res;

			

		}

	}

	;

	//print_r($ParserDivision_exclus);

	$noShowTovar = false;

	$curParserDivision = array();

	$prevCategory = "";

	$allPrevCheckresID = 0;

	$rand = 0;

	$firstBrandMarker = false;

	$ignoreArray = Array();

	

	// Сравнение прайса

	

	$compareArray = array();

	$compareArray2 = array();

	

	for($i=1;$i<sizeof($list)+1;$i++){

		

		$price=ltrim(rtrim($list[$i][$conect[1]]));

		

		if(!isset($list[$i]['type'])){

			$list[$i]['type'] = '1';

		}

		

		if( $list[$i]['type']!='unknown'){

			

			if ((strlen($price) < 1 || !is_numeric($price)) && strlen(rtrim($list[$i][$conect[2]])) < 1) {

				$name = ltrim(rtrim($list[$i][$conect[4]]));

				$name = trim($name);

				

				$compareArray[] = $name;

			}

		}

	}

	

	$parser_magazin=queryresult("select compare from ".DB_PREFIX."parser_magazin where magazin_id='".$conect[5]."'","compare");

	

	$diff = array();

	

	if ($parser_magazin) {

		$compareArray2 = unserialize($parser_magazin);

		

		$diff = array_diff_assoc($compareArray2, $compareArray); 

		

		if (empty($diff)) $diff = array_diff_assoc($compareArray, $compareArray2); 

		//print_r($diff);

		

		if ($diff) {

			echo "Найдены изменения<br>";

			echo '<a href="#" onclick="update_slepok(\''.$conect[5].'\', \''. base64_encode(serialize($compareArray)) .'\')">Обновить слепок</a>';

			echo "<br>";

			echo "<br>";

			

			foreach ($diff as $key=>$dif) {

				if (empty($dif) && empty($compareArray[$key]))

					continue;

				

				if (!empty($compareArray[$key]))

					echo '<a href="#hrefid'.$key.'" style="text-decoration: none; background: #ff0000; color: #ffffff; display: inline-block; text-align: center; width: 15px; height: 15px;">!</a>&nbsp;';

				

				echo $dif . "=>" . (isset($compareArray[$key]) ? $compareArray[$key] : '') . "<br><br>";

			}

		}

		else {

			//echo "Изменений нет<br>";

		}

	}

	else {

		$mysqli->query("insert into ".DB_PREFIX."parser_magazin(magazin_id,compare) values('$conect[5]', '". serialize($compareArray) ."')");

	}
	$currDif = 0;

	$DelParserCategotyname='';

	// /Сравнение прайса

	

	for($i=1;$i<sizeof($list)+1;$i++){

		unset($tesifpr);

		$price=ltrim(rtrim($list[$i][$conect[1]]));
		$tesifpr=explode(' ',ltrim(rtrim($list[$i][$conect[0]])));

		if($list[$i]['type']!='unknown'){
			if ((strlen($price) < 1 || !is_numeric($price)) && strlen(rtrim($list[$i][$conect[2]])) < 1) {
				$name = ltrim(rtrim($list[$i][$conect[4]]));
				$name = trim($name);

				$currDif++;

				/*Проверить наличие категории в перечне "игнор", запоминаем категорию, чтобы потом использовать.*/
				foreach ($ParserDivision_exclus as $ParseIgnorCategory) {

				if (strtolower(trim($name))==strtolower(trim($ParseIgnorCategory['category_name'])))

				{

					$DelParserCategotyname=$ParseIgnorCategory['category_name'];

					break;

				}

				else 

				{

					$brand_name=queryresult("select name from ".DB_PREFIX."manufacturer where
													upper(`name`) LIKE '".mb_strtoupper(addslashes($name),'UTF-8')."' OR
													upper(`code`) LIKE '".mb_strtoupper(addslashes($name),'UTF-8')."'","name");

					if (!$brand_name)

					 {$DelParserCategotyname='';}

						

				}

				}

				//echo '<br>'.'$Parser_exclus_obj='.$DelParserCategotyname.'<BR> nAme='.$name.' cat_name='.$ParserDivision_exclus['category_name'];
				/*------------------*/
				if (empty($name)) continue;

				$nextCategory = $compareArray[$currDif];

				if (isset($allPrevCheckresKey[$name][$prevCategory][$nextCategory])) {
					$allPrevCheckresID = $allPrevCheckresKey[$name][$prevCategory][$nextCategory]["category_id"];
				}

				else {

					$allPrevCheckresID = 0;

				}

				

				$prevCategory = $name;

				

				$mybrendid_test=queryresult("select manufacturer_id from ".DB_PREFIX."manufacturer where
														upper(`name`) LIKE '".mb_strtoupper(addslashes($name),'UTF-8')."' OR
														upper(`code`) LIKE '".mb_strtoupper(addslashes($name),'UTF-8')."'","manufacturer_id");

				if(!$mybrendid_test){

					$mybrendid_test = '';

					if(isset($allBrenddopnamesKey[$name])){

						$mybrendid_test = $allBrenddopnamesKey[$name];

					}

				}

				if($mybrendid_test && $allPrevCheckresID == 0){ continue;}

				

				$mymenublacklist_test=queryresult("select * from ".DB_PREFIX."parser_menublacklist where name='".$name."'", 'no_shop');

				if($mymenublacklist_test){ 

					$no_shop = explode(",", $mymenublacklist_test['no_shop']);

					

					if (array_search($conect[5], $no_shop) === false && $allPrevCheckresID == 0)

						continue;

				}

				

				if(!empty($allParserDivision[$name])) 

					$curParserDivision = $allParserDivision[$name];

				else

					$curParserDivision = array();

				

				$curID = 0;

				$purID = 0;

				

				$sql = "select C.category_id AS id, C.parent_id AS wmotmenuid from ".DB_PREFIX."category C
										LEFT JOIN ".DB_PREFIX."category_description CD ON C.category_id = CD.category_id 
										WHERE language_id = '1' AND CD.name='$name'";

				$r = $mysqli->query($sql);

				//$mtestid = querytoarray("select id, wmotmenuid from menu where name='$name'");

				

				if($r->num_rows > 0){

					$mtestid = $r->fetch_assoc(); 

					$curID = $mtestid["id"];

					$purID = $mtestid["wmotmenuid"];

				}

				else {

					

					//$mtestides = querytoarray("select wmotmenuid from menudopnames where name='$name'");

					$sql = "select category_id from ".DB_PREFIX."category_alternative where alt_category_name='$name'";

					$r2 = $mysqli->query($sql);

					

					if($r2->num_rows > 0){

						while ($wmotmenuid = $r2->fetch_assoc()) {

							

							//$id = querytoarray("select id, wmotmenuid from menu where id=".$wmotmenuid["wmotmenuid"]);

							$sql = "select C.category_id AS id, C.parent_id AS wmotmenuid from ".DB_PREFIX."category C where C.category_id=".$wmotmenuid["wmotmenuid"];

							$r1 = $mysqli->query($sql);

				

							if($r1->num_rows > 0){

								$id = $r1->fetch_assoc(); 

			

								if (!empty($id)) {

									$curID = $id["id"];

									$purID = $id["wmotmenuid"];

								}

							}

						}

					}

				}

				

				$mtestid = $curID;

								

				if (isset($_POST['hide_no']) && empty($curID)) {

					$noShowTovar = true;

					continue;

				}

				

				if (isset($_POST['hide_yes']) && !empty($curID)) {

					$noShowTovar = true;

					continue;

				}

				

				$noShowTovar = false;

				

				$rand = rand(0, 100000);

				

				if (!empty($allPrevCheckresID))

					$mtestid = $allPrevCheckresID;

				

				if(!empty($mtestid)){

					

					$checkboxClass = "";

					

					$whileCat = $mtestid;

					

					while (true) {

						$whileCat = isset($allCategory[$whileCat]) ? $allCategory[$whileCat] : null;

						if (empty($whileCat)) break;

						$checkboxClass .= "checkboxImport".$whileCat." ";

					}

					

					if (isset($_POST["select_cat"])) 

						$_POST['selectmenues'][$mtestid] = true;

					

					?></div>

						<div>

							<input type="checkbox" class="checkboxImportMain<?php echo $mtestid?> <?php echo $checkboxClass?>" onclick="checkboxClick(<?php echo $mtestid?>, this);" <?php echo (isset($_POST['selectmenues'][$mtestid]))?'checked':''?> name="selectmenues[<?php echo $mtestid?>]" value="1"> 

					<?php

					

										echo '<b>Категория:</b> ';



					$testsubcategory=queryresult("select parent_id from ".DB_PREFIX."category where category_id=".$mtestid,'parent_id');



					if($testsubcategory){

						echo queryresult("select name from ".DB_PREFIX."category_description where language_id = '1' AND category_id=".$testsubcategory,'name').' / ';

						$testsubcategory=queryresult("select parent_id from ".DB_PREFIX."category where category_id=".$testsubcategory,'parent_id');

						if($testsubcategory){echo queryresult("select name from ".DB_PREFIX."category_description where language_id = '1' AND category_id=".$testsubcategory,'name').' / ';}

							

					}



					?>	

					<script>

					$(document).ready(function(){

						if($('#blockno<?php echo $mtestid.$rand?>').html().length<5){

					$('#blocknokliker<?php echo $mtestid.$rand?>').hide();



					}

					});

					</script>						

					<?php

						if (isset($diff[$currDif - 1])) {

							echo '<span id="hrefid'. ($currDif - 1) .'" style="background: #ff0000; color: #ffffff; display: inline-block; text-align: center; width: 20px; height: 20px;">!</span>';

							echo $diff[$currDif - 1] . '&nbsp;&nbsp; => &nbsp;&nbsp;';

						}

						echo $name;  

						echo '- <a href="javascript:;" id="blocknokliker'.$mtestid.$rand.'" onclick="$(\'#blockno'.$mtestid.$rand.'\').slideToggle();">OPEN</a></div>';

						

						echo '<span class="bullID bullID'.$mtestid.$rand.'" style="display: none; color: #ff0000;">&nbsp;&nbsp;&nbsp;&bull;</span>';

						

						if (!empty($allPrevCheckresID)) {

							echo "&nbsp;&nbsp;&nbsp;--->&nbsp;&nbsp;&nbsp;";

							

							echo queryresult("select name from ".DB_PREFIX."category_description where language_id = '1' AND category_id=".$allPrevCheckresID,'name');

						}

						

						echo '<br><div id="blockno'.$mtestid.$rand.'" style="display:none;">';

						$mymenuid=$mtestid;

				}

				else {

					$mymenuid=0;

					

					$id = $rand;



					echo '</div><div style="display:inline-block" id="panel_row_'.$id.'" class="panel_row">';

					

					if (isset($diff[$currDif - 1])) {
						echo '<span id="hrefid'. ($currDif - 1) .'" style="background: #ff0000; color: #ffffff; display: inline-block; text-align: center; width: 20px; height: 20px;">!</span>';
					}

					echo '<div class="error2" style="display: inline-block; float=left; width:300px;"><b>Категория не определена: ## </b> ';

					if (isset($diff[$currDif - 1])) {
						echo $diff[$currDif - 1] . '&nbsp;&nbsp; => &nbsp;&nbsp;';
					}

					echo '<div id="category_name_'.$id.'" class="category_name" >'.$name.'</div>';

					echo '</div><div style="display:inline-block"> <div style="margin:3px"><a href="javascript:;" onclick="addbrend(\''.str_replace(array("'",'"','+'),array('`','`','--PLUS--'),$name).'\',\''.$id.'\');" id="addbrendid'.$id.'">[Add Brands]</a> -
					
						<span id="categoryblokno'.$id.'">
						<a href="javascript:;" id="blocknokliker'.$mtestid.$rand.'" onclick="$(\'#blockno'.$mtestid.$rand.'\').slideToggle();">OPEN</a>';

					?>
					<select id="set_subcategory0_<?php echo $id?>"  style="width:100px;" onChange="setnewlist(<?php echo $id?>,1,this.value);">
					<option value="0">Выберите категорию</option>
					
					<?php for($j=0;$j<$menu['rows'];$j++){

						echo '<option value="'.$menu[$j]['id'].'">'.$menu[$j]['name'].'</option>';

					} ?>
					</select>

					<script>

					$(document).ready(function(){
						if($('#blockno<?php echo $mtestid.$rand?>').html().length<5){
							$('#blocknokliker<?php echo $mtestid.$rand?>').hide();
					}

					});

					</script>	

					<select id="set_subcategory1_<?php echo $id?>"  onChange="setnewlist(<?php echo $id?>,2,this.value); "></select><select 

					id="set_subcategory2_<?php echo $id?>" onChange="setnewlist(<?php echo $id?>,3,this.value);"></select><select 

					id="set_subcategory3_<?php echo $id?>" onChange="setnewlist(<?php echo $id?>,4,this.value);"></select><select 

					id="set_subcategory4_<?php echo $id?>"></select> 

					<input type='text' size="10" id="ignor_key_<?php echo $id?>" style="placeholder=keyword"> <?php echo "</div><div>";?>

					Добавить как: 

					<a href="javascript:;" onClick="addcategory('<?php echo str_replace(array("'",'"','+'),array('`','`','--PLUS--'),$name)?>',<?php echo $id?>);">Новая запись</a> 

					- <a href="javascript:;" onClick="addcategoryas('<?php echo str_replace(array("'",'"','+'),array('`','`','--PLUS--'),$name)?>',<?php echo $id?>);">Доп.назв.</a>

					- <a href="javascript:;" onClick="addblacklist('<?php echo urlencode(str_replace("+", "--PLUS--", $name))?>',<?php echo $id?>);">BL</a>

					- <a href="javascript:;" onClick="addignorlist(<?php echo $conect[5]?>,'<?php echo urlencode(str_replace("+", "--PLUS--", $name))?>',<?php echo $id?>);">Ignor</a>

					- <a href="javascript:;" onClick="addparserprev(<?php echo $conect[5]?>,'<?php echo urlencode(str_replace("+", "--PLUS--", $name))?>',<?php echo $id?>);">Сорт.тов.</a>

					- <a href="javascript:;" onClick="addparsdivision(<?php echo $conect[5]?>,'<?php echo urlencode(str_replace("+", "--PLUS--", $name))?>',<?php echo $id?>);">Др.кат.</a>

					<?php

					

					echo '</span></div></div></div><div id="blockno'.$mtestid.$rand.'" style="display:none;">';

				}

				

				$firstBrandMarker = false;

			}

            elseif($list[$i][$conect[0]]!=''){

				

				if ($noShowTovar)

					continue;



                $name=$list[$i][$conect[0]];

                $name=str_replace("\n",' ',$name);

                //$name=iconv('windows-1251','utf-8',$name);

				

				//$name=iconv('utf-8','windows-1251',$name);

				//$name=iconv('windows-1251','utf-8',$name);

                $name=ltrim(rtrim($name));

                $name=str_replace('  ',' ',stripslashes($name));

                $name=str_replace('  ',' ',stripslashes($name));

                $name=str_replace('  ',' ',stripslashes($name));

				

				if (!empty($allPrevCheckresID)) {

					$mymenuid = $allPrevCheckresID;

					$allPrevCheckresID = 0;

				}

				/*вставить проверку название на наличие игнора по каждому слову для данной категории*/

				  //проверка находимся ли мы в нужной категории, и не сменили ее. 

				foreach ($ParserDivision_exclus as $ParseIgnorCat){

					if ($ParseIgnorCat['category_name']==$DelParserCategotyname){

					 foreach ($ParseIgnorCat['division_ex'] as $key_word){

					  if(strpos($name,$key_word)>0) {

						  $ignoreArray[]=$name;

						  echo ' <div style="color:red;">IGNOR - '.$name.'</div>';

						$del_position=true;

						break;

					  } else {$del_position=false;}

					} 

					break;

					}

				}	

				//if ($del_position) continue;

				

				 //и если находит то пишем в массив игнора и на выход, а массив вывести в конце.

				

				/*--------------------------*/

				$mymenuidtmp = $mymenuid;

				$find = false;

				

				if (!empty($curParserDivision)) {

					foreach ($curParserDivision as $div) {

						$find = false;

						

						foreach ($div["division"] as $division) {

							$division = trim($division);

							

							if (stripos($name, $division) !== false)

								$find = true;

							else

								$find = false;

						}

						

						if ($find) {

							$mymenuid = $div["category_id"];

						}

					}

				}

    

                $price=ltrim(rtrim($list[$i][$conect[1]]));

                $price=str_replace(',','.',$price);

                $price=number_format($price,2,'.','');

    

                $mybrendid=$import->Detect_brend_with_products($name);

                if(!$mybrendid){

                    echo '<div class="error">Невозможность определить бренд по товару: '.$name.'</div>';

					if (!$firstBrandMarker)

						echo '<script>$(document).ready(function(){ $(".bullID'.$mtestid.$rand.'").show(); })</script>';

					

					$firstBrandMarker = true;

                }

				else if(isset($_POST['no_brand'])){

					continue;

				}

				$arProp = array();

				foreach ($allPropertiesRegular as $arPrior) {

					foreach ($arPrior as $arReg) {

						if($arReg["regular"] != ''){

							preg_match($arReg["regular"], $name, $matchesProp);
							$prop = trim($matchesProp[0]);

						}

						if (isset($prop) AND !empty($prop)) 
							$arProp[$arReg["properties_id"]] = array('value'=>$prop, 'id'=>$arReg["properties_id"], "name"=>$arReg["name"]);

					}

				}

				

				$xmlProp = "";

				

				if (!empty($arProp)) {

					$xmlProp .= '<?phpxml version="1.0" encoding="utf-8"?><root>';

					foreach ($arProp as $prop) {
						if (!empty($prop["id"]))
							$xmlProp .= '<items><id>'.$prop["id"].'</id><title>'.$prop["name"].'</title><value>'.$prop["value"].'</value></items>';
					}
					$xmlProp .= '<limiter></limiter><selectedmenuid>'.$mymenuid.'</selectedmenuid></root>';

				}

				// отключение характеристик
				$xmlProp = "";
				if (!$mybrendid) $mybrendid = 0;
				$mymenuid = $mymenuidtmp;

               	if (isset($del_position) AND $del_position) continue;

				if($mymenuid){

                    $pid=queryresult("select product_id from ".DB_PREFIX."product_description where language_id = '1' AND name='$name'",'product_id');

                    if(!$pid){

                        $pid=queryresult("select productid from ".DB_PREFIX."productdopnames where dopname='$name'",'productid');

                    }

                    

                    if(!$pid){

                        if(!isset($_POST['testcategory']) && !isset($_POST['addautomate'])){

                           // echo '- - '.$mymenuid.' - '.(($mybrendid)?queryresult("select name from brend where id=$mybrendid","name"):'No').' - Товар: '.$name.'<br>';

                        }

                        if(isset($_POST['addautomate']) && $mymenuid>0){

							//if($_POST['selectmenues'][$mymenuid]){
							if($mymenuid){

								$mysqli->query("insert into ".DB_PREFIX."product SET
												moderation_id = 0,
												quantity = 10,
												garant = '".ltrim(rtrim($list[$i][$conect[2]]))."',
												status = 1,
												price = $price,
												date_added = '$dater',
												manufacturer_id = $mybrendid");
								
								$pid = $mysqli->insert_id;
								//$pid=queryresult("select product_id from ".DB_PREFIX."product order by product_id desc limit 0,1",'product_id');
								
								$mysqli->query("insert into ".DB_PREFIX."product_description SET product_id = $pid, name = '$name', description = '".$xmlProp."', language_id = 1") or die('1');
								$mysqli->query("insert into ".DB_PREFIX."product_description SET product_id = $pid, name = '$name', description = '".$xmlProp."', language_id = 3") or die('2');
								$mysqli->query("insert into ".DB_PREFIX."product_description SET product_id = $pid, name = '$name', description = '".$xmlProp."', language_id = 4") or die('3');
												
								$mysqli->query("insert into ".DB_PREFIX."product_to_category SET product_id = $pid, is_main = 1, category_id = $mymenuid");
								$mysqli->query("insert into ".DB_PREFIX."product_to_layout SET product_id = $pid, store_id = 0, layout_id = 0");
								$mysqli->query("insert into ".DB_PREFIX."product_to_shop SET product_id = $pid, shop_id = '".number_format($conect[5],2,',','')."'");
								$mysqli->query("insert into ".DB_PREFIX."product_to_store SET product_id = $pid, store_id = '0'");
								$mysqli->query("insert into ".DB_PREFIX."url_alias SET `query` = 'product_id=$pid', keyword = '$name'");
								$mysqli->query("insert into ".DB_PREFIX."product_prices SET productid = $pid, garant = '".ltrim(rtrim($list[$i][$conect[2]]))."', price = $price, magazinid = '".number_format($conect[5],2,',','')."',dater=curdate()");
												
						//die();	

							}

                        }

                    }else{

						if(!isset($_POST['testimporting'])){

							$oldprice=queryresult("select price from ".DB_PREFIX."product_prices where productid=$pid and magazinid=".$conect[5]." and dater=curdate() order by id desc limit 0,1",'price');

							if($_POST['addautomateprices'] && $oldprice<$price){

								if($_POST['selectmenues'][$mymenuid]){

									echo 'Imported - ';

									

									if($oldprice>0){

										$did=queryresult("select id from ".DB_PREFIX."product_prices where productid=$pid and magazinid=".$conect[5]." and dater=curdate() order by id desc limit 0,1",'id');

										$mysqli->query("delete from product_prices where id=$did");

									}

									$mysqli->query("insert into ".DB_PREFIX."product_prices(name,productid,status,magazinid,price,garant,dater) 
												values('$name','$pid','1','".intval($conect[5])."','".number_format($price,2,',','')."','".ltrim(rtrim($list[$i][$conect[2]]))."','$dater')");

								}

							}
						

							//Обновление характеристик
							/*
							$productRes=queryresults("select PD.product_id, P2C.category_id, PD.description from ".DB_PREFIX."product_description PD
																		LEFY JOIN ".DB_PREFIX."product_to_category P2C ON P2C.product_id = PD.product_id AND is_main = '1'
																		LEFY JOIN ".DB_PREFIX."product_description PD ON PD.product_id = P.product_id
																		LEFY JOIN ".DB_PREFIX."product_to_shop P2S ON P2S.product_id = P.product_id
																		where P.product_id=$pid and P2S.shop_id=".$conect[5]);

							if ($productRes) {

									if ($_POST['updateproperties'] && $productRes["description"] != $xmlProp)
										$mysqli->query("UPDATE ".DB_PREFIX."product_description SET description='$xmlProp' where product_id=$pid");
								
									//Folder comment 2016-12-27
									if ($_POST['sbrosnastroyki'] && $productRes["category_id"] != $mymenuid){
										//mysql_query("UPDATE ".DB_PREFIX."product SET menuid1='0', wmotmenuid='$mymenuid' where product_id=$pid");
									}

							}*/

						}

                    }

                    if($pid){

						$name=queryresult("select name from ".DB_PREFIX."product_description where language_id=1 AND product_id=$pid","name");

					}

                    echo '- - '.$mymenuid.' - '.(($mybrendid)?queryresult("select name from ".DB_PREFIX."manufacturer where manufacturer_id=$mybrendid","name"):'No').' - Товар: '.$pid.' ->'.htmlspecialchars($name).'<br>';

                }else{
                    //$name=iconv('','utf-8',$list[$i][$conect[0]]);$name=ltrim(rtrim($name));
                    echo '- - '.$mymenuid.' - '.(($mybrendid)?queryresult("select name from ".DB_PREFIX."manufacturer where manufacturer_id=$mybrendid","name"):'No').' - Товар: '.htmlspecialchars($name).'<br>';
                    //echo "x ";

                }

				$mymenuid = $mymenuidtmp;

            }

		}

	}

	



}

	$end_time = microtime(true);

	

?>
</div></form><?php echo '<br>Выполнено за '.round(($end_time-$start_time),5)." сек";	?>
