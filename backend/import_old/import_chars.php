<?
include("init.php");

?>
<form action="" method="get">
<table width="100%">
	<tr>
    	<td width="220">Ссылка для поиска на <b>m.ua</b>:</td> <td><input type="text" style="width:50%;" name="linkurl"></td></tr>
    <!--<tr><td rowspan="2">Настройки</td>
    	<td><input type="checkbox" name="testcategory" <? if($_POST['testcategory']){echo 'checked';} ?>>Тестирование категорий/Скрыть товары</td></tr>
    <tr><td><input type="checkbox" name="addautomate" <? if($_POST['addautomate']){echo 'checked';} ?>>Добавить определенные товары в базу и скрыть их</td></tr>
    --><tr><td><input type="submit" value="Следующий товар"> <input type="submit" value="Поиск"></td>
    </tr>
</table>
</form>

<style>
.safeimages{ border:#CCCCCC 1px solid; cursor:pointer; padding:1px; margin-right:20px;}
</style>

<?

$product=querytoarray("select * from products where imageok=0 order by id desc limit 0,1");

echo 'Название товара: '.$product[0]['name'].'<br><br>';

if($_GET['linkurl']){
	$html=iconv('cp1251','utf-8',file_get_contents($_GET['linkurl']));
	$tid=substr($html,strpos($html,'/m1_item.php?idg_=')+18,strlen($html));
	$tid=trim(substr($tid,0,strpos($tid,'&')));
	
	//get all chars
	$chars=iconv('cp1251','utf-8',file_get_contents("http://m.ua/mtools/mui_item_description_v2.php?idg_=".$tid."&mode_=full"));
	
	$chars=stripslashes($chars);
	$chars=strip_tags($chars,'<table><tr><td>');
	
	$chars=str_replace("')",'',$chars);
	$chars=str_replace("('",'',$chars);
	$chars=str_replace(' cellpadding="0" cellspacing="0" border="0" width="100%" id="help_table"','',$chars);
	$chars=str_replace(' valign="top"','',$chars);
	$chars=str_replace(' width="48%" class="op01"','',$chars);
	$chars=str_replace(' cellpadding="3" cellspacing="0" border="0" width="100%" ','',$chars);
	$chars=str_replace('<tr><td colspan="2" class="line11"></td>','',$chars);
	
	$chars_array=explode("</tr>",$chars);
	
	for($i=0;$i<sizeof($chars_array);$i++){
		//groups
		if(strpos($chars_array[$i],"op1'>") && !strpos($chars_array[$i],'op3">')){
			$category=substr($chars_array[$i],strpos($chars_array[$i],"op1'>")+5,strlen($chars_array[$i]));
			$categoryname=substr($category,0,strpos($category,"<"));
			echo '<b>'.$categoryname.'</b><br>';
		}
		elseif(strpos($chars_array[$i],"op1'>")){
		//menu
			$category=substr($chars_array[$i],strpos($chars_array[$i],"op1'>")+5,strlen($chars_array[$i]));
			$categoryname=substr($category,0,strpos($category,"<"));
			echo $categoryname.': ';
		}
		//value
		if(strpos($chars_array[$i],'op3">')){
			
			$category=substr($chars_array[$i],strpos($chars_array[$i],'op3">')+5,strlen($chars_array[$i]));
			$value=substr($category,0,strpos($category,"</td>"));
			
			echo $value.'<br>';
		}
	}
}

?>
