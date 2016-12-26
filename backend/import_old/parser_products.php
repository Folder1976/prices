<?
include("init.php");

//include("../advaweb.classes/advaweb.class.php");
//include("../advaweb.classes/modules.class.php");

class Import_productsV1{

	public function qa($query_txt,$closerows=0){
		$query_result=array();
		$query=mysql_query($query_txt) or die(mysql_error().'<br>'.htmlspecialchars($query_txt));
		$query_rows=mysql_num_rows($query);
		
		for($i=0;$i<$query_rows;$i++){
			array_push($query_result,mysql_fetch_assoc($query));
		}
		if(!$closerows){
			$query_result['rows']=$query_rows;
		}
		mysql_free_result($query);
		return $query_result;
	}
	
	public function qr($query_txt,$colname=''){
		$query=mysql_query($query_txt) or die(mysql_error().'<br>'.htmlspecialchars($query_txt));
		$query_rows=mysql_num_rows($query);
		if($query_rows>0){
			return ($colname)?mysql_result($query,0,$colname):mysql_fetch_assoc($query);
		}
		
		return;
	}

	public function Detect_brend_with_products($name){
		$name=str_replace('  ',' ',stripslashes($name));


		$dbr=explode(' ',strtolower(ltrim(rtrim(str_replace('/',' ',$name)))));
		if(strpos('x'.strtolower($dbr[0]),'intel')){$dbr[0]='Intel';}
		elseif(strpos('x'.strtolower($dbr[1]),'intel')){$dbr[1]='Intel';}
		

		
		$totalkeys=array();
		for($i=0;$i<sizeof($dbr);$i++){
			array_push($totalkeys,$dbr[$i]);
		
			$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[$i])."'","id");
			if(!$mybrendid_test){
				$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[$i])."'",'brendid');
			}
			if($mybrendid_test){return $mybrendid_test;}
		
			array_push($totalkeys,$dbr[$i].' '.$dbr[$i+1]);
		
			$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[$i].' '.$dbr[$i+1])."'","id");
			if(!$mybrendid_test){
				$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[$i].' '.$dbr[$i+1])."'",'brendid');
			}
			if($mybrendid_test){return $mybrendid_test;}
		
			array_push($totalkeys,$dbr[$i].' '.$dbr[$i+1].' '.$dbr[$i+2]);
		
		
			$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[$i].' '.$dbr[$i+1].' '.$dbr[$i+2])."'","id");
			if(!$mybrendid_test){
				$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[$i].' '.$dbr[$i+1].' '.$dbr[$i+2])."'",'brendid');
			}
			if($mybrendid_test){return $mybrendid_test;}
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
<?$start_time = microtime(true);?>
<form action="" method="post" enctype="multipart/form-data">
<table>
<input type="hidden" name="importlist" value="1">
	<tr>
    	<td>Тип файла:</td> <td><select name="importtype">
    	<option <? if(!isset($_POST['importtype'])){echo 'selected="selected"';} ?> value="">Выберите тип файла</option>
        <?
        $data=querytoarray("select * from magazin where status=1 and importopt!='' order by name");
		for($i=0;$i<$data['rows'];$i++){
		?>
        	<option <? if(isset($_POST['importtype']) AND $_POST['importtype']==$data[$i]['importopt'].','.$data[$i]['id']){$selectedmagazinid=$data[$i]['id'];echo 'selected="selected"';} ?> value="<?=$data[$i]['importopt']?>,<?=$data[$i]['id']?>">
            	<?=$data[$i]['name']?>
            </option>
        <?
		}
		?>
        <!--
        Стандарт значение -  это 
        Название - Цена - гарантия - cells
        -->
    </select></td></tr>
    <tr><td>Выберите файл: <td><input type="file" name="import" value="<?=$_FILES['import']?>"></td></tr>
    <tr><td rowspan="13">Настройки</td><td><input type="checkbox" name="testcategory" <? if(isset($_POST['testcategory'])){echo 'checked';} ?>>Тестирование категорий(Товары будут скрыты)</td></tr>
    <tr><td><input type="checkbox" name="addautomate" <? if(isset($_POST['addautomate'])){echo 'checked';} ?>>Добавить определенные товары в базу и показать только не неопределенные товары</td></tr>
        <tr><td><input type="checkbox" name="addautomateprices" <? if(isset($_POST['addautomateprices'])){echo 'checked';} ?>>Автоматически добавлять цены</td></tr>
<tr><td><input type="checkbox" name="testfile" <? if(isset($_POST['testfile'])){echo 'checked';} ?>>FILE STRUCTURE TEST</td></tr>

<tr><td><input type="checkbox" name="testimporting" <? if(isset($_POST['testimporting'])){echo 'checked';} ?>>ONLY TEST</td></tr>
<tr><td><input type="checkbox"  name="clearbefore" <? if(isset($_POST['clearbefore'])){echo 'checked';} ?>>Clear ald prices BEFORE UPLOAD</td></tr>
<tr><td><input type="checkbox"  name="activatestatus1" <? if(isset($_POST['activatestatus1'])){echo 'checked';} ?>>Проверка на активность категории</td></tr>
<tr><td><input type="checkbox"  name="sbrosnastroyki" <? if(isset($_POST['sbrosnastroyki'])){echo 'checked';} ?>>Сбросить настройки отмеченных категорий всех товаров для импортируемого магазина</td></tr>

<tr><td><input type="checkbox"  name="updateproperties" <? if(isset($_POST['updateproperties'])){echo 'checked';} ?>>Обновлять характеристики</td></tr>
<tr><td><input type="checkbox"  name="hide_no" <? if(isset($_POST['hide_no'])){echo 'checked';} ?>>Скрыть неопределенные</td></tr>

<tr><td><input type="checkbox"  name="hide_yes" <? if(isset($_POST['hide_yes'])){echo 'checked';} ?>>Скрыть определенные</td></tr>

<tr><td><input type="checkbox"  name="no_brand" <? if(isset($_POST['no_brand'])){echo 'checked';} ?>>Товары без брендов</td></tr>

<tr><td><input type="checkbox"  name="select_cat" <? if(isset($_POST['select_cat'])){echo 'checked';} ?>>Выделить определенные категори</td></tr>

    <tr><td><input type="submit" value="Импортировать"></td>
</table>
<div>
<?

$dater=date("Y-m-d");
if(isset($_POST['importlist'])){

	

if(isset($_POST['clearbefore'])){mysql_query("delete from product_prices where magazinid=$selectedmagazinid"); echo "Магазин очищен"; die(); }

$k = '';
if(isset($_POST['activatestatus1'])){$k=" and status=1";}
$menu=querytoarray("select * from menu where tip=0 $k");
$file=$_FILES['import']['tmp_name'];

$conect=explode(',',$_POST['importtype']);

$list = array();

require('PHPExcel/PHPExcel.php');
require_once 'PHPExcel/PHPExcel/IOFactory.php';
$objPHPExcel = PHPExcel_IOFactory::load($file);

$objPHPExcel->setActiveSheetIndex($conect[3]);
$list = array();

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
{
	$highestRow         = $worksheet->getHighestRow();
	$highestColumn      = $worksheet->getHighestColumn();
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	
    for ($row = 1; $row <= $highestRow; ++ $row)
    {
        for ($col = 0; $col < $highestColumnIndex; ++ $col) 
        {
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
	
    $allPrevCheckres = querytoarray("select * from parser_prev");
	$allPrevCheckresKey = array();
	
	foreach ($allPrevCheckres as $PrevCheckres) {
		if (!empty($PrevCheckres["name"]) && $PrevCheckres["shop_id"] == $conect[5])
			$allPrevCheckresKey[$PrevCheckres["name"]][$PrevCheckres["prev_name"]][$PrevCheckres["last_name"]] = $PrevCheckres;
	}
	
	$allBrenddopnames = querytoarray("select * from brenddopnames");
	$allBrenddopnamesKey = array();
	
	foreach ($allBrenddopnames as $Brenddopnames) {
		$bname = explode(",", $Brenddopnames["name"]);
		
		foreach ($bname as $bdopname) {
			if (!empty($bdopname))
				$allBrenddopnamesKey[$bdopname] = $Brenddopnames["brendid"];
		}
	}
	
	$allCatRes = querytoarray("select id, wmotmenuid from menu");
	
	foreach ($allCatRes as $catRes)
		$allCategory[$catRes["id"]] = $catRes["wmotmenuid"];
		
	$allProperties = array();	
	$allPropertiesRegular = array();
	
	$allPropertiesRes = querytoarray("select id, name from properties");
	
	foreach ($allPropertiesRes as $propRes)
		$allProperties[$propRes["id"]] = $propRes;
		
	$allPropertiesRegularRes = querytoarray("select * from properties_regular");
	
	foreach ($allPropertiesRegularRes as $propRegRes) {
		if(is_array($propRegRes) AND isset($propRegRes["properties_id"])){
			$propRegRes["name"] = $allProperties[$propRegRes["properties_id"]]["name"];
		}
		$allPropertiesRegular[$propRegRes["prioritet"]][] = $propRegRes;
	}
		
	ksort($allPropertiesRegular);
	
	$allParserDivision = array();
	$allParserDivisionR = querytoarray("select * from parser_division where magazin_id='".$conect[5]."'");
	
	foreach ($allParserDivisionR as $ParserDivisionRes) {
		if(!empty($ParserDivisionRes["category_name"])) {
			$ParserDivisionRes["division"] = explode(",", $ParserDivisionRes["division_name"]);
			$allParserDivision[$ParserDivisionRes["category_name"]][] = $ParserDivisionRes;
		}
	}
	
	//получаем данные по каким категориям игнорировать импорт
	$ParserDivision_exclus = array();
	//$ParserDivisionR_exclus = querytoarray("select * from parser_division_exclusion where magazin_id='".$conect[5]."'");
	$ParserDivisionR_exclus = querytoarray("select * from parser_division_exclusion where magazin_id='".$conect[5]."'");
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
	
	$parser_magazin=queryresult("select compare from parser_magazin where magazin_id='".$conect[5]."'","compare");
	
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
				
				echo $dif . "=>" . $compareArray[$key] . "<br><br>";
			}
		}
		else {
			//echo "Изменений нет<br>";
		}
	}
	else {
		mysql_query("insert into parser_magazin(magazin_id,compare) values('$conect[5]', '". serialize($compareArray) ."')");
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
					$brand_name=queryresult("select name from brend where name='".mysql_real_escape_string($name)."'","name");
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
				
				$mybrendid_test=queryresult("select id from brend where name='".mysql_real_escape_string($name)."'","id");
				if(!$mybrendid_test){
					$mybrendid_test = '';
					if(isset($allBrenddopnamesKey[$name])){
						$mybrendid_test = $allBrenddopnamesKey[$name];
					}
				}
				if($mybrendid_test && $allPrevCheckresID == 0){ continue;}
				
				$mymenublacklist_test=queryresult("select * from menublacklist where name='".mysql_real_escape_string($name)."'", 'no_shop');
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
				
				$sql = "select id, wmotmenuid from menu where name='$name'";
				$r = $mysqli->query($sql);
				//$mtestid = querytoarray("select id, wmotmenuid from menu where name='$name'");
				
				if($r->num_rows > 0){
					$mtestid = $r->fetch_assoc(); 
					$curID = $mtestid["id"];
					$purID = $mtestid["wmotmenuid"];
				}
				else {
					
					//$mtestides = querytoarray("select wmotmenuid from menudopnames where name='$name'");
					$sql = "select wmotmenuid from menudopnames where name='$name'";
					$r2 = $mysqli->query($sql);
					
					if($r2->num_rows > 0){
						while ($wmotmenuid = $r2->fetch_assoc()) {
							
							//$id = querytoarray("select id, wmotmenuid from menu where id=".$wmotmenuid["wmotmenuid"]);
							$sql = "select id, wmotmenuid from menu where id=".$wmotmenuid["wmotmenuid"];
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
						
						$whileCat = $allCategory[$whileCat];
						
						if (empty($whileCat))
							break;
						
						$checkboxClass .= "checkboxImport".$whileCat." ";
					}
					
					if (isset($_POST["select_cat"])) 
						$_POST['selectmenues'][$mtestid] = true;
					
					?></div>
						<div>
							<input type="checkbox" class="checkboxImportMain<?=$mtestid?> <?=$checkboxClass?>" onclick="checkboxClick(<?=$mtestid?>, this);" <?php echo (isset($_POST['selectmenues'][$mtestid]))?'checked':''?> name="selectmenues[<?=$mtestid?>]" value="1"> 
					<?
					
										echo '<b>Категория:</b> ';

					$testsubcategory=queryresult("select wmotmenuid from menu where id=".$mtestid,'wmotmenuid');

					if($testsubcategory){
						echo queryresult("select name from menu where id=".$testsubcategory,'name').' / ';
						$testsubcategory=queryresult("select wmotmenuid from menu where id=".$testsubcategory,'wmotmenuid');
						if($testsubcategory){echo queryresult("select name from menu where id=".$testsubcategory,'name').' / ';}
							
					}

					?>	
					<script>
					$(document).ready(function(){
						if($('#blockno<?=$mtestid.$rand?>').html().length<5){
					$('#blocknokliker<?=$mtestid.$rand?>').hide();

					}
					});
					</script>						
					<?
						if (isset($diff[$currDif - 1])) {
							echo '<span id="hrefid'. ($currDif - 1) .'" style="background: #ff0000; color: #ffffff; display: inline-block; text-align: center; width: 20px; height: 20px;">!</span>';
							echo $diff[$currDif - 1] . '&nbsp;&nbsp; => &nbsp;&nbsp;';
						}
						echo $name;  
						echo '- <a href="javascript:;" id="blocknokliker'.$mtestid.$rand.'" onclick="$(\'#blockno'.$mtestid.$rand.'\').slideToggle();">OPEN</a></div>';
						
						echo '<span class="bullID bullID'.$mtestid.$rand.'" style="display: none; color: #ff0000;">&nbsp;&nbsp;&nbsp;&bull;</span>';
						
						if (!empty($allPrevCheckresID)) {
							echo "&nbsp;&nbsp;&nbsp;--->&nbsp;&nbsp;&nbsp;";
							
							echo queryresult("select name from menu where id=".$allPrevCheckresID,'name');
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
					
					echo '</div><div style="display:inline-block"> <div style="margin:3px"><a href="javascript:;" onclick="addbrend(\''.str_replace(array("'",'"','+'),array('`','`','--PLUS--'),$name).'\',\''.$id.'\');" id="addbrendid'.$id.'">[Add Brands]</a> - <span id="categoryblokno'.$id.'"> <a href="javascript:;" id="blocknokliker'.$mtestid.$rand.'" onclick="$(\'#blockno'.$mtestid.$rand.'\').slideToggle();">OPEN</a>';
					?><select id="set_subcategory0_<?=$id?>"  style="width:100px;" onChange="setnewlist(<?=$id?>,1,this.value);"><option value="0">Выберите категорию</option>
					
					<?
					for($j=0;$j<$menu['rows'];$j++){
						echo '<option value="'.$menu[$j]['id'].'">'.$menu[$j]['name'].'</option>';
					}
					?>
					</select>
					<script>
					$(document).ready(function(){
						if($('#blockno<?=$mtestid.$rand?>').html().length<5){
					$('#blocknokliker<?=$mtestid.$rand?>').hide();

					}
					});
					</script>	
					<select id="set_subcategory1_<?=$id?>"  onChange="setnewlist(<?=$id?>,2,this.value); "></select><select 
					id="set_subcategory2_<?=$id?>" onChange="setnewlist(<?=$id?>,3,this.value);"></select><select 
					id="set_subcategory3_<?=$id?>" onChange="setnewlist(<?=$id?>,4,this.value);"></select><select 
					id="set_subcategory4_<?=$id?>"></select> 
					<input type='text' size="10" id="ignor_key_<?=$id?>" style="placeholder=keyword"> <?echo "</div><div>";?>
					Добавить как: 
					<a href="javascript:;" onClick="addcategory('<?=str_replace(array("'",'"','+'),array('`','`','--PLUS--'),$name)?>',<?=$id?>);">Новая запись</a> 
					- <a href="javascript:;" onClick="addcategoryas('<?=str_replace(array("'",'"','+'),array('`','`','--PLUS--'),$name)?>',<?=$id?>);">Доп.назв.</a>
					- <a href="javascript:;" onClick="addblacklist('<?=urlencode(str_replace("+", "--PLUS--", $name))?>',<?=$id?>);">BL</a>
					- <a href="javascript:;" onClick="addignorlist(<?=$conect[5]?>,'<?=urlencode(str_replace("+", "--PLUS--", $name))?>',<?=$id?>);">Ignor</a>
					- <a href="javascript:;" onClick="addparserprev(<?=$conect[5]?>,'<?=urlencode(str_replace("+", "--PLUS--", $name))?>',<?=$id?>);">Сорт.тов.</a>
					- <a href="javascript:;" onClick="addparsdivision(<?=$conect[5]?>,'<?=urlencode(str_replace("+", "--PLUS--", $name))?>',<?=$id?>);">Др.кат.</a>
					<?
					
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
                $name=mysql_real_escape_string(ltrim(rtrim($name)));
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
						preg_match($arReg["regular"], $name, $matchesProp);
						
						$prop = trim($matchesProp[0]);
						
						if (!empty($prop)) 
							$arProp[$arReg["properties_id"]] = array('value'=>$prop, 'id'=>$arReg["properties_id"], "name"=>$arReg["name"]);
					}
				}
				
				$xmlProp = "";
				
				if (!empty($arProp)) {
					$xmlProp .= '<?xml version="1.0" encoding="utf-8"?><root>';
					
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
				
               	if ($del_position) continue;
				
				if($mymenuid){
                    $pid=queryresult("select id from products where name='$name'",'id');
                    if(!$pid){
                        $pid=queryresult("select productid from productdopnames where dopname='$name'",'productid');
                    }
                    
                    if(!$pid){
                        if(!isset($_POST['testcategory']) && !isset($_POST['addautomate'])){
                           // echo '- - '.$mymenuid.' - '.(($mybrendid)?queryresult("select name from brend where id=$mybrendid","name"):'No').' - Товар: '.$name.'<br>';
                        }
                        if(isset($_POST['addautomate']) && $mymenuid>0){
							if($_POST['selectmenues'][$mymenuid]){
								mysql_query("insert into products(name,status,wmotmenuid,brendid,properties) values('$name','1','$mymenuid','$mybrendid','$xmlProp')");
								$pid=queryresult("select id from products order by id desc limit 0,1",'id');
                            
								mysql_query("insert into product_prices(name,productid,status,magazinid,price,garant,dater) values('$name','$pid','1','".number_format($conect[5],2,',','')."','$price','".mysql_real_escape_string(ltrim(rtrim($list[$i][$conect[2]])))."','$dater')");
							}
                        }
                        
                    }else{
						if(!isset($_POST['testimporting'])){
							$oldprice=queryresult("select price from product_prices where productid=$pid and magazinid=".$conect[5]." and dater=curdate() order by id desc limit 0,1",'price');
							if($_POST['addautomateprices'] && $oldprice<$price){
								if($_POST['selectmenues'][$mymenuid]){
									echo 'Imported - ';
									
									if($oldprice>0){
										$did=queryresult("select id from product_prices where productid=$pid and magazinid=".$conect[5]." and dater=curdate() order by id desc limit 0,1",'id');
										mysql_query("delete from product_prices where id=$did");
									}
									
									mysql_query("insert into product_prices(name,productid,status,magazinid,price,garant,dater) 
									values('$name','$pid','1','".intval($conect[5])."','".number_format($price,2,',','')."','".ltrim(rtrim($list[$i][$conect[2]]))."','$dater')");
								}
							}
							
							//Обновление характеристик
							$productRes=queryresult("select id,wmotmenuid,properties from products where id=$pid and magazinid=".$conect[5]);
							
							if ($productRes) {
									if ($_POST['updateproperties'] && $productRes["properties"] != $xmlProp)
										mysql_query("UPDATE products SET properties='$xmlProp',wmotmenuid='$mymenuid' where id=$pid");
								
									if ($_POST['sbrosnastroyki'] && $productRes["wmotmenuid"] != $mymenuid)
										mysql_query("UPDATE products SET menuid1='0', wmotmenuid='$mymenuid' where id=$pid");
								
							}
						}
                    }
   
                    if($pid){
						$name=queryresult("select name from products where id=$pid","name");
					}
					
                    echo $test.'- - '.$mymenuid.' - '.(($mybrendid)?queryresult("select name from brend where id=$mybrendid","name"):'No').' - Товар: '.$pid.' ->'.htmlspecialchars($name).'<br>';
                                    
                }else{
                    //$name=iconv('','utf-8',$list[$i][$conect[0]]);$name=ltrim(rtrim($name));
                    echo $test.'- - '.$mymenuid.' - '.(($mybrendid)?queryresult("select name from brend where id=$mybrendid","name"):'No').' - Товар: '.htmlspecialchars($name).'<br>';
                    //echo "x ";
                }
				
				$mymenuid = $mymenuidtmp;
            }
		
		}
		
	}
	

/*
		if(sizeof($dbr)){
			$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[0])."'","id");
			if(!$mybrendid_test){
				$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[0])."'",'brendid');
			}
		
		
			if($mybrendid_test){$mybrendid=$mybrendid_test;}
			else{
				$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[1])."'","id");
		
				if(!$mybrendid_test){
					$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[1])."'",'brendid');
				}
		
		
				if($mybrendid_test){$mybrendid=$mybrendid_test;}
				else{
					$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[2])."'","id");
		
		
					if(!$mybrendid_test){
						$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[2])."'",'brendid');
					}
		
					if($mybrendid_test){$mybrendid=$mybrendid_test;}
					else{
						$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[3])."'","id");

		
						if($mybrendid_test){$mybrendid=$mybrendid_test;}
						else{
							$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[4])."'","id");
	
			
							if($mybrendid_test){$mybrendid=$mybrendid_test;}
							else{
								$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[5])."'","id");
		
				
								if($mybrendid_test){$mybrendid=$mybrendid_test;}
								else{
									$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[6])."'","id");
			
					
									if($mybrendid_test){
										$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[6])."'",'brendid');
									}
									
									if($mybrendid_test){$mybrendid=$mybrendid_test;}
								}
							}
						}
					}
				}
			}
		}
		
		return $mybrendid;
			if($mybrendid_test){$mybrendid=$mybrendid_test;}
			else{
				$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[1])."'","id");
		
				if(!$mybrendid_test){
					$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[1])."'",'brendid');
				}
		
		
				if($mybrendid_test){$mybrendid=$mybrendid_test;}
				else{
					$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[2])."'","id");
		
		
					if(!$mybrendid_test){
						$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[2])."'",'brendid');
					}
		
					if($mybrendid_test){$mybrendid=$mybrendid_test;}
					else{
						$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[3])."'","id");

		
						if($mybrendid_test){$mybrendid=$mybrendid_test;}
						else{
							$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[4])."'","id");
	
			
							if($mybrendid_test){$mybrendid=$mybrendid_test;}
							else{
								$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[5])."'","id");
		
				
								if($mybrendid_test){$mybrendid=$mybrendid_test;}
								else{
									$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[6])."'","id");
			
					
									if($mybrendid_test){
										$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[6])."'",'brendid');
									}
									
									if($mybrendid_test){$mybrendid=$mybrendid_test;}
								}
							}
						}
					}
				}
			}
		}
		
		return $mybrendid;
			if($mybrendid_test){$mybrendid=$mybrendid_test;}
			else{
				$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[1])."'","id");
		
				if(!$mybrendid_test){
					$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[1])."'",'brendid');
				}
		
		
				if($mybrendid_test){$mybrendid=$mybrendid_test;}
				else{
					$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[2])."'","id");
		
		
					if(!$mybrendid_test){
						$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[2])."'",'brendid');
					}
		
					if($mybrendid_test){$mybrendid=$mybrendid_test;}
					else{
						$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[3])."'","id");

		
						if($mybrendid_test){$mybrendid=$mybrendid_test;}
						else{
							$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[4])."'","id");
	
			
							if($mybrendid_test){$mybrendid=$mybrendid_test;}
							else{
								$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[5])."'","id");
		
				
								if($mybrendid_test){$mybrendid=$mybrendid_test;}
								else{
									$mybrendid_test=$this->qr("select id from brend where name='".mysql_real_escape_string($dbr[6])."'","id");
			
					
									if($mybrendid_test){
										$mybrendid_test=$this->qr("select brendid from brenddopnames where name='".mysql_real_escape_string($dbr[6])."'",'brendid');
									}
									
									if($mybrendid_test){$mybrendid=$mybrendid_test;}
								}
							}
						}
					}
				}
			}
		}
		
		return $mybrendid;*/
						/*
                        if($_POST['sbrosnastroyki']){
                            $pid_cat=queryresult("select wmotmenuid from products where id=$pid",'wmotmenuid');
                            if(!$pid_cat){
                               // echo '-------> WILLNEWSET: '.$pid.' -> WMOTID:'.$mymenuid.'<br>';
                            }
                            else{
                                //echo '-------> WILLDELSET: '.$pid.'<br>';
                            }
                        }
						*/		
	/*
var_dump($curID);
var_dump($purID);
var_dump($purCategory);
*/
/*
if ($purID != 0 && $purID != 283 && $purCategory != 0) {
	$mtestid = queryresult("select id, wmotmenuid from menu where name='$name' and wmotmenuid = " . $purCategory);
	
	var_dump($mtestid);
	
	if (!empty($mtestid["id"])) {
		$curID = $mtestid["id"];
		$purID = $mtestid["wmotmenuid"];
	}
	else {
		$mtestides = querytoarray("select wmotmenuid from menudopnames where name='$name'");
		
		foreach ($mtestides as $wmotmenuid) {
			
			$id = queryresult("select id, wmotmenuid from menu where id=".$wmotmenuid["wmotmenuid"]. " and wmotmenuid = " . $purCategory);
			
			if (!empty($id)) {
				$curID = $id["id"];
				$purID = $id["wmotmenuid"];
			}
			else {
				$curID = 0;
			}
		}
	}
}
else {
	if ($curID != 0)
		$purCategory = $curID;
}*/
/*
$level = 1;
echo "<pre>";
print_r($list);

for($i=1;$i<sizeof($list);$i++){
	$price = ltrim(rtrim($list[$i][$conect[1]]));
	$tesifpr=explode(' ',ltrim(rtrim($list[$i][$conect[0]])));
	
	if($list[$i]['type']!='unknown'){
		
		//var_dump($list[$i][$conect[4]]);
	
		if (empty($price) && strlen($list[$i][$conect[0]])<100) {
			
			$name = ltrim(rtrim($list[$i][$conect[4]]));
			$pad = 20 * $level;
			
			echo '<p style="margin-left: '.$pad.' px;">';
			echo $name;
			echo "</p>";
			
			if (!empty($list[$i + 1])) {
				$next = $list[$i + 1];
				$priceNext = ltrim(rtrim(next[$conect[1]]));
				
				if (!empty($price) && strlen($list[$conect[0]])<100) {
					$level + 1;
				}
			}
			
			
		}
	}
}

die();

//print_r($conect);
/*
echo "<pre>";
print_r($list);

//die();
//if($_POST['sbrosnastroyki']){$site->ressetCategoryForMagazin($selectedmagazinid);}

//require('excel_reader/reader.php');
//require('excel_reader/excel_reader2.php');
/*
$connection = new Spreadsheet_Excel_Reader();
//$connection->setInputEncoding('windows-1251');
//$connection->setOutputEncoding('windows-1251');
$connection->setUTFEncoder('iconv');
$connection->setOutputEncoding('UTF-8');
$connection->read($file);
*/
/*
require('excel_reader/excel_reader2.php');
$connection = new Spreadsheet_Excel_Reader();
$connection->setOutputEncoding('UTF-8');
$connection->read($file);
*/
				/*
				$currentCategoryId = 0;
				$purrentCategoryId = 0;
				
				$startCategory = $currentCategory;
				
				while (true) {
					$mtestid = queryresult("select id, wmotmenuid from menu where name='$name'" . (!empty($currentCategory[0]) ? " and wmotmenuid = " . $currentCategory[0] : ''));
					
					if (!empty($mtestid["id"])) {
						$currentCategoryId = $mtestid["id"];
						$purrentCategoryId = $mtestid["wmotmenuid"];
					}
					else {
						$mtestides = querytoarray("select wmotmenuid from menudopnames where name='$name'");
						
						foreach ($mtestides as $wmotmenuid) {
							
							$id = queryresult("select id, wmotmenuid from menu where id=".$wmotmenuid[0]. (!empty($currentCategory[0]) ? " and wmotmenuid = " . $currentCategory[0] : ''));
							
							if (!empty($id)) {
								$currentCategoryId = $id["id"];
								$purrentCategoryId = $id["wmotmenuid"];
							}
						}
					}
					
					if (empty($currentCategoryId))
						array_shift($currentCategory);
					else
						break;
					
					if (empty($currentCategory))
						break;	
				}
				
				$searchFalse = false;
				
				$currentCategoryId = intval($currentCategoryId);
				
				if (empty($currentCategoryId)) {
					$currentCategory = $startCategory;
					$searchFalse = true;
					$findPrevCategory = false;
				}
				else {
					$findPrevCategory = true;
					//$allCategory[$currentCategoryId] = $purrentCategoryId;
					
					$currentCategory = array($currentCategoryId);
					
					$whileCat = $currentCategoryId;
					
					while (true) {
						
						$whileCat = $allCategory[$whileCat];
						
						if (empty($whileCat))
							break;
						
						$currentCategory[] = $whileCat;
					}
				}
				
				if ($_POST['hide_no'] && $searchFalse) {
					$noShowTovar = true;
 					continue;
				}
				
				$noShowTovar = false;
				
				if ($searchFalse || array_search($mtestid, $allArray) !== false) {
					$mtestid = 0;
				}
				else {
					$mtestid = $currentCategory[0];
					$allArray[] = $mtestid;
				}
				*/
				
				/*
				echo $name . "<br>";
				print_r($currentCategory);
				continue;
				*/
				
				//continue;
		
		/*
		continue;
		
		
		if($list[$i]['type']!='unknown'){
			
			*
			//Это не товар так как нет цены
			if(!$price && strlen($list[$i][$conect[0]])<100){
		  		
				
				if(!$list[$i][$conect[1]] && !$list[$i+1][$conect[1]] || $list[$i][$conect[1]] && !$list[$i-1][$conect[1]]){
					//Значит это начало вложенной группы
				}	
				///////////echo 'Test name: '.$list[$i][$conect[4]].'<br>';
				if($site->dublecatstatus==2 && !trim($list[$i][$conect[1]]) && !trim($list[$i-2][$conect[1]]) && !trim($list[$i-1][$conect[1]])){
					$site->dublecatstatus=3;
				}
				elseif($site->dublecatstatus==1 && !trim($list[$i][$conect[1]]) && !trim($list[$i-1][$conect[1]])){
					$site->dublecatstatus=2;
				}
				elseif(!trim($list[$i][$conect[1]]) && !trim($list[$i+1][$conect[1]])){
					$site->dublecatstatus=1;
				}
				
					
				
		  		//меняем статус вложенности на 1
				///////////echo ' --- CURNTSTATUS: '.$site->dublecatstatus.' - '.(trim($list[$i][$conect[1]]).' = '.trim($list[$i+1][$conect[1]])).' - '.$list[$i][$conect[4]].'<br>';
				/*
				echo "<pre>";
				print_r($list[$i]);
				echo "</pre>";
				*
		  
				$name=ltrim(rtrim($list[$i][$conect[4]]));
				$name=iconv('windows-1251','utf-8',$name);
				$id=rand(111111,99999999);

				/*
				echo "=================";
				echo $name;
				echo "================";*
				
			
				
				//Ищем только в главных категориях
				if($site->dublecatstatus==1){
					$mtestid=queryresult("select id from menu where name='$name' and wmotmenuid=0","id");
					if(!$mtestid){
						unset($mtestides);
						$mtestides=querytoarray("select wmotmenuid from menudopnames where name='$name'");
						for($p=0;$p<$mtestides['rows'];$p++){
							//echo 'ZAPROS: '.htmlspecialchars("select id from menu where id=".intval($mtestides[$p]['wmotmenuid'])." and wmotmenuid=0").'<br>';
							$id=queryresult("select id from menu where id=".intval($mtestides[$p]['wmotmenuid'])." and wmotmenuid=0",'id');
							if($id){
								$mtestid=$id;
								break;
							}
						}


						//esli ne nashli kategoriyu kak glavneyu smitrim esli li voobshe sovpadeniya
						if(!$mtestid){
							$mtestid=queryresult("select id from menu where name='$name' limit 0,1","id");
							if(!$mtestid){
								$mtestides=querytoarray("select wmotmenuid from menudopnames where name='$name'");
								for($p=0;$p<$mtestides['rows'];$p++){
									//echo 'ZAPROS: '.htmlspecialchars("select id from menu where id=".intval($mtestides[$p]['wmotmenuid'])." and wmotmenuid=0").'<br>';
									$id=queryresult("select id from menu where id=".intval($mtestides[$p]['wmotmenuid'])."",'id');
									if($id){
										$mtestid=$id;
										break;
									}
								}
							}
						}

						$site->dublecatstatus_menuid1=$mtestid;
					}else{$site->dublecatstatus_menuid1=$mtestid;}
					
					echo $mtestid;
					
				}
				//Ищем в под категориях
				elseif($site->dublecatstatus_menuid1 && $site->dublecatstatus>1){
				///////////echo "QUERY: select id from menu where name='$name' and wmotmenuid=".intval($site->dublecatstatus_menuid1).'<br>';
					$mtestid=queryresult("select id from menu where name='$name' and wmotmenuid=".intval($site->dublecatstatus_menuid1),"id");
					if(!$mtestid){
						unset($mtestides);
						$mtestides=querytoarray("select wmotmenuid from menudopnames where name='$name'");

						for($p=0;$p<$mtestides['rows'];$p++){
						$id=queryresult("select id from menu where id=".intval($mtestides[$p]['wmotmenuid'])." and wmotmenuid=0",'id');
							if($id){
								$mtestid=$id;
							}
						}
					}
				}
				
				
				/*
				else{
					///////////echo '<div class="error2" style=" width:300px;">Вложенность категории не определена!</div>';
					//--$mtestid=queryresult("select id from menu where name='$name'","id");
					//--if(!$mtestid){
					//--	$mtestid=queryresult("select wmotmenuid from menudopnames where name='$name'",'wmotmenuid');
					//--}
				}*
				if(!$mtestid){
					///////$mtestid=queryresult("select id from menu where name='$name'","id");
					///////if(!$mtestid){
					///////	$mtestid=queryresult("select wmotmenuid from menudopnames where name='$name'",'wmotmenuid');
					///////}
					
					$wmotmenuidfortest=queryresult("select wmotmenuid from menu where name='$name'","wmotmenuid");
					if($wmotmenuidfortest){$site->dublecatstatus_menuid1=$wmotmenuidfortest;$site->dublecatstatus=2;}
					else{$site->dublecatstatus_menuid1=0;$site->dublecatstatus=1;}
				}
				
				$mtestid = 398;
				

				if($mtestid){
?></div><input type="checkbox" <?=($_POST['selectmenues'][$mtestid])?'checked':''?> name="selectmenues[<?=$mtestid?>]" value="1"> <?

					echo '<b>Категория:</b> ';

$testsubcategory=queryresult("select wmotmenuid from menu where id=".$mtestid,'wmotmenuid');

echo $testsubcategory;

if($testsubcategory){
	echo queryresult("select name from menu where id=".$testsubcategory,'name').' / ';
	$testsubcategory=queryresult("select wmotmenuid from menu where id=".$testsubcategory,'wmotmenuid');
	if($testsubcategory){echo queryresult("select name from menu where id=".$testsubcategory,'name').' / ';}
}

?>		
<script>
$(document).ready(function(){
	if($('#blockno<?=$mtestid?>').html().length<5){
$('#blocknokliker<?=$mtestid?>').hide();

}
});
</script>		
<?
	echo ''.$name.' - <a href="javascript:;" id="blocknokliker'.$mtestid.'" onclick="$(\'#blockno'.$mtestid.'\').slideToggle();">OPEN</a><br>
<div id="blockno'.$mtestid.'" style="display:none;">';
					$mymenuid=$mtestid;
				}
				elseif(!$import->Detect_brend_with_products($name)){
				
					$mymenuid=0;

					echo '</div><div class="error2" style=" width:300px;"><b>Категория не определена: ##'.$site->dublecatstatus.' </b> '.$name.'</div> <a href="javascript:;" onclick="addbrend(\''.str_replace(array("'",'"','+'),array('`','`','--PLUS--'),$name).'\',\''.$id.'\');" id="addbrendid'.$id.'">[Добавить в бренды]</a> -  <span id="categoryblokno'.$id.'">[';
					?><select id="set_subcategory0_<?=$id?>" onChange="setnewlist(<?=$id?>,1,this.value);"><option value="0">Выберите категорию</option>
					<?
					for($j=0;$j<$menu['rows'];$j++){
						echo '<option value="'.$menu[$j]['id'].'">'.$menu[$j]['name'].' <a href="javascript:;" id="blocknokliker'.$mtestid.'" onclick="$(\'#blockno'.$name.'\').slideToggle();">OPEN</a></option>';
					}
					?>
                    </select><select id="set_subcategory1_<?=$id?>" onChange="setnewlist(<?=$id?>,2,this.value);"></select><select 
                    id="set_subcategory2_<?=$id?>" onChange="setnewlist(<?=$id?>,3,this.value);"></select><select 
                    id="set_subcategory3_<?=$id?>" onChange="setnewlist(<?=$id?>,4,this.value);"></select><select 
                    id="set_subcategory4_<?=$id?>"></select> Добавить как: <a href="javascript:;" onClick="addcategory('<?=str_replace(array("'",'"','+'),array('`','`','--PLUS--'),$name)?>',<?=$id?>);">новая запись</a> - <a href="javascript:;" onClick="addcategoryas('<?=str_replace(array("'",'"','+'),array('`','`','--PLUS--'),$name)?>',<?=$id?>);">доп.название</a><?
                    
                    echo ']</span><br><div id="blockno'.$name.'" style="display:none;">';
                }
else{
?></div>		
<script>
$(document).ready(function(){
	if($('#blockno<?=$mtestid?>').html().length<5){
$('#blocknokliker<?=$mtestid?>').hide();

}
});
</script>		
<?
	echo 'CATEGORY NOT FOUND: '.$name.'  <a href="javascript:;" id="blocknokliker'.$mtestid.'" onclick="$(\'#blockno'.$name.'\').slideToggle();">OPEN</a><br>
<div id="blockno'.$name.'" style="display:none;">';
					




//echo '<div class="error2" style=" width:500px;"><b>CATEGORY NOT FOUND: ###'.$site->dublecatstatus.' </b> '.$name.'</div><div class="r">';

}


            }
			*/


/*	unset($data);
	$data=querytoarray("select id,wmotmenuid from products");
	for($i=0;$i<$data['rows'];$i++){
		$pricetest=(queryresult("select id from product_prices where productid=".$data[$i]['id'],'id'))?1:0;
	
		mysql_query("update products set priceok='$pricetest' where id=".$data[$i]['id']);
	}*/
}
	$end_time = microtime(true);
	
?></div></form><?echo '<br>Выполнено за '.round(($end_time-$start_time),5)." сек";	?>