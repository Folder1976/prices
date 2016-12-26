<?
include("init.php");

if($_GET['searchindatabase']){
	$product=querytoarray("select * from products where name like '%".$_GET['searchindatabase']."%' order by name");
}


?>
<form action="" method="get">
<table width="1000">
<tr><td colspan="100%"><b>Совмещение в группы - Массовое изминение брендов</b></td></tr>
	<tr><td width="170">Найти группу товаров:</td> <td><input autocomplete="off" type="text" style="width:100%;" id="searchindatabaseint" name="searchindatabase" value="<?=$_GET['searchindatabase']?>"></td></tr>
    <tr><td>Общее название товара:</td> <td><input autocomplete="off" type="text" style="width:100%;" id="searchindatabaseintx" name="searchindatabasex" value="<?=$product[0]['name']?>"></td></tr>
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
$menu=querytoarray("select * from brend where status=1 order by name");
$menuhtml='';
for($j=0;$j<$menu['rows'];$j++){
	$menuhtml.='<option value="'.$menu[$j]['id'].'">'.$menu[$j]['name'].'</option>';
}
?>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td width="15">Гл.</td>
    <td width="15">Выб</td>
    <td width="10%">Бренд</td>
    <td>Название и путь</td>
</tr>
<?
for($i=0;$i<$product['rows'];$i++){
	?>
<tr style="height:25px;<?=($i%2)?'background:#E3E9EF;':''?>">	
	<td><input type="radio" onclick="$('#searchindatabaseintx').val('<?=$product[$i]['name']?>');" name="rad" value="<?=$product[$i]['id']?>"></td>
    <td><input type="checkbox" name="products[]" id="productno<?=$product[$i]['id']?>" class="products" value="<?=$product[$i]['id']?>"></td>
    <td style="padding-right:10px;"><select name="menuid" onfocus="$('#productno<?=$product[$i]['id']?>').attr('checked','checked');" onchange="brchangemenuidall(this.value)" id="menuidselectno<?=$product[$i]['id']?>">
    	<?
        echo str_replace('value="'.$product[$i]['brendid'].'"','value="'.$product[$i]['brendid'].'" selected="selected"',$menuhtml);
		?>
    </select></td>
     <td><?=$product[$i]['name']?>
     <?
     $menupath=array();
	 $testmid=$product[$i]['wmotmenuid'];
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