<?
include("init.php");
if($_GET['searchindatabase']){
	$product=querytoarray("select * from products where name like '%".$_GET['searchindatabase']."%' order by name");
}


?>
<link rel="stylesheet" href="sources/chosen.min.css" />

<form action="" method="get">
<table width="1000">
<tr><td colspan="100%"><b>Совмещение в группы - Массовое изминение категорий</b></td></tr>
	<tr><td width="170">Найти группу товаров:</td> <td><input autocomplete="off" type="text" style="width:100%;" id="searchindatabaseint" name="searchindatabase" value="<?=$_GET['searchindatabase']?>"></td></tr>
    <tr><td>Общее название товара:</td> <td><input autocomplete="off" type="text" style="width:100%;" id="searchindatabaseintx" name="searchindatabasex" value="<?=$product[0]['name']?>"></td></tr>
    <tr><td>Group:</td> <td>
	<select name="group[]" style="width:200px;height:200px;" multiple id="group">
<?
$group=array();
foreach($_GET['group'] as $value)$group[$value]=$value;
$_GET['group']=$group;
?>
<option value="" selected="selected">Выберите из списка</option>
	<option value="brand" <?=isset($_GET['group']['brand'])?'selected':''?>>brand</option>
	<option value="memory" <?=isset($_GET['group']['memory'])?'selected':''?>>memory</option>
	<option value="ddr" <?=isset($_GET['group']['ddr'])?'selected':''?>>ddr</option>
	<option value="frequency_video" <?=isset($_GET['group']['frequency_video'])?'selected':''?>>frequency_video</option>
	<option value="bit" <?=isset($_GET['group']['bit'])?'selected':''?>>bit</option>
	</select>
	<script src="sources/chosen.jquery.min.js" type="text/javascript"></script>

	</td></tr>
	
	<tr>
	<td>Model:</td><td>
<input type="checkbox" value="1" <?=isset($_GET['model'])?'checked':''?> name="model"> 
<input value="<?=isset($_GET['model'])?$_GET['model_expr']:'([A-z]{2}\d{3})'?>" name="model_expr">
<br/>
<?echo '<pre>';
//var_dump($_GET['group']);
echo '</pre>';?>
<span>
Все что в скобках это сама модель<br/>
\s* - 0 пробелов или несколько пробелов<br/>
\d+ - 1 цифра или больше<br/>
\d* - 0 цифр или больше<br/>
\d - 1 цифра<br/>
[A-z] - буквы от A-z<br/>
{1,5} - сколько раз повторяется символ - в данном случае от 1 до 5<br/>
{5} - сколько раз повторяется символ - в данном случае 5<br/>
* - сколько раз повторяется символ - 0 или больше раз<br/>
+ - сколько раз повторяется символ - 1 или больше раз<br/>
\s - пробел<br/>
\d - цифра<br/> 
[A-z] - буква от A-Z<br/> 
</span>
	<script src="sources/chosen.jquery.min.js" type="text/javascript"></script>
	</td>
	</tr>
    <tr><td colspan="100%"><input type="submit" value="ПОИСК"> <input type="submit" value="ОБНОВИТЬ"></td></tr>
   
</table>
</form>

<style>
.safeimages{ border:#CCCCCC 1px solid; cursor:pointer; padding:1px; margin-right:20px;}
a{ color:#000;}
</style>

<?



if(!$product['rows']){echo '<font style="font-size:15px;"><b>Товаров не найдено!</b></font><br>';}
else{
?>
<a href="javascript:;" onclick="$('.products').attr('checked','checked');">Выбрать</a>/<a href="javascript:;" onclick="$('.products').attr('checked','');">Убрать</a> все&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="saveasoneproducts();">Отметить выбранное как один товар</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="javascript:;" title="В качестве название группы будет ключевое слово что вы ищите!" onclick="savetogroups();">Объединить выбранные товары в группу</a><br><br>
<?
}
$menu=querytoarray("select * from menu where status=1 and wmotmenuid='' order by name");
$menuhtml='';
for($j=0;$j<$menu['rows'];$j++){
	$menuhtml.='<optgroup label="'.$menu[$j]['name'].'">';
	$menuhtml.='<option value="'.$menu[$j]['id'].'">'.$menu[$j]['name'].'</option>';

	unset($menu1);
	$menu1=querytoarray("select * from menu where status=1 and wmotmenuid=".$menu[$j]['id'].' order by name');
	for($k=0;$k<$menu1['rows'];$k++){
		$menuhtml.='<optgroup label="'.$menu1[$k]['name'].'">';
		$menuhtml.='<option value="'.$menu1[$k]['id'].'">'.$menu1[$k]['name'].'</option>';
		
		unset($menu2);
		$menu2=querytoarray("select * from menu where status=1 and wmotmenuid=".$menu1[$k]['id'].' order by name');
		for($l=0;$l<$menu2['rows'];$l++){
			$menuhtml.='<option value="'.$menu2[$l]['id'].'">'.$menu2[$l]['name'].'</option>';
			
			unset($menu3);
			$menu3=querytoarray("select * from menu where status=1 and wmotmenuid=".$menu2[$l]['id'].' order by name');
			for($x=0;$x<$menu3['rows'];$x++){
				$menuhtml.='<option value="'.$menu3[$x]['id'].'">'.$menu3[$x]['name'].'</option>';
				
				unset($menu4);
				$menu4=querytoarray("select * from menu where status=1 and wmotmenuid=".$menu3[$x]['id'].' order by name');
				for($y=0;$y<$menu4['rows'];$y++){
					$menuhtml.='<option value="'.$menu4[$y]['id'].'">'.$menu4[$y]['name'].'</option>';
					
					unset($menu5);
					$menu5=querytoarray("select * from menu where status=1 and wmotmenuid=".$menu4[$y]['id'].' order by name');
					for($w=0;$w<$menu5['rows'];$w++){
						$menuhtml.='<option value="'.$menu5[$w]['id'].'">'.$menu5[$w]['name'].'</option>';
					}
				}
			}
		}
		$menuhtml.='</optgroup>';
	}
	$menuhtml.='</optgroup>';
}
?>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td width="15">Гл.</td>
    <td width="15">Выб</td>
    <td width="10%">Категория</td>
    <td>Название и путь</td>
</tr>
<?
function parseTitle($title){
$results=array();


if(isset($_GET['model'])){
	//model
	$result= array();
		preg_match_all('/'.$_GET['model_expr'].'/i', $title, $result, PREG_PATTERN_ORDER);
	$results['model'] = $result[1][0];
	//
}

if(isset($_GET['group']['brand'])){
	//brands
	$query = mysql_query("select `name` from brend");
	while($brand = mysql_fetch_assoc($query)){
		if(strpos(strtolower($title),strtolower($brand['name']))!== false){
			$results['brand']=strtolower($brand['name']);
			break;
		}
	}
	//
}

if(isset($_GET['group']['memory'])){
//memory
$result= array();
	preg_match_all(' /(\d+)\s*MB/i', $title, $result, PREG_PATTERN_ORDER);
	if(empty($result[1][0])){
	preg_match_all(' /(\d+)\s*GB/i', $title, $result, PREG_PATTERN_ORDER);
	$result[1][0]=$result[1][0]*1024;
	}
$results['memory'] = $result[1][0];

//
}
if(isset($_GET['group']['ddr'])){
//DDR
$result= array();
preg_match_all(' /DDR\s*(\d+)/i', $title, $result, PREG_PATTERN_ORDER);
$results['ddr'] = $result[1][0];
//
}
if(isset($_GET['group']['frequency_video'])){
//frequency
$result= array();
if(substr_count(strtolower($title), 'mhz')==1){
preg_match_all('/(\d+)\/(\d+)\s*MHZ/i', $title, $result, PREG_PATTERN_ORDER);
$results['frequency_video'] = $result[1][0].'/'.$result[2][0];

}else{
preg_match_all(' /engine\s*(\d+)/i', $title, $result, PREG_PATTERN_ORDER);
$engine=$result[1][0];
preg_match_all(' /memory\s*(\d+)/i', $title, $result, PREG_PATTERN_ORDER);
$memory_2=$result[1][0];
$results['frequency_video'] = $engine.'/'.$memory_2;
}
//
}
if(isset($_GET['group']['bit'])){
//bit
$result= array();
preg_match_all(' /(\d+)\s*\-*bit/i', $title, $result, PREG_PATTERN_ORDER);
$results['bit'] = $result[1][0];
// 
}


$color='';
$response='';
foreach($results as $key=>$res){
$color.= $res;
$response .= $res."<sup>$key</sup> ";
}
return array(substr(md5($color),0,6),($response));

}

function cmp($a, $b)
{
    return strcmp($a["sku"][1], $b["sku"][1]);
}


foreach($product as $key=>&$prod){if($key!='rows')$prod['sku']=parseTitle($prod['name']);}

uasort($product,'cmp');

foreach($product as $key=>$prod){
    if($key==='rows')continue;
	?>
	<tr style="height:25px;<?=($i%2)?'background:#E3E9EF;':''?>">	
		<td><input type="radio" onclick="$('#searchindatabaseintx').val('<?=$prod['name']?>');" name="rad" value="<?=$prod['id']?>"></td>
		<td><input type="checkbox" name="products[]" id="productno<?=$prod['id']?>" class="products" value="<?=$prod['id']?>"></td>
		<td style="padding-right:10px;"><select name="menuid" onfocus="$('#productno<?=$prod['id']?>').attr('checked','checked');" onchange="changemenuidall(this.value)" id="menuidselectno<?=$prod['id']?>">
			<?
			echo str_replace('value="'.$prod['wmotmenuid'].'"','value="'.$prod['wmotmenuid'].'" selected="selected"',$menuhtml);
			?>
		</select></td>
		 <td>
		 <?$params= parseTitle($prod['name']);?>
		 <span style="font-weight:bold;color:#<?=$params[0]?>"><?=$params[1]?> | </span>
		 <?=$prod['name']?>
		 <?
		 $menupath=array();
		 $testmid=$prod['wmotmenuid'];
		while($testmid){

			$submenuid=querytoarray("select wmotmenuid,id,name from menu where id=".$testmid);
			$testmid=$submenuid[0]['wmotmenuid'];
			array_push($menupath,' > <a '.(($submenuid[0]['id']==$data['wmotmenuid'])?'class="on"':'').' href="?showcid='.$submenuid[0]['id'].'">'.$submenuid[0]['name'].'</a>');
		}
		for($c=sizeof($menupath)-1;$c>=0;$c--){
		
			echo $menupath[$c];
		}
		 ?></td>
	</tr>
	<?
}

?></table>