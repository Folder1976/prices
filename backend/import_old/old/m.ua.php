<?
include("init.php");

if($_GET['searchindatabase']){
	$product=querytoarray("select * from products where charstatus=0 and name='".$_GET['searchindatabase']."' order by id desc limit 0,1");
}
else{
	$product=querytoarray("select * from products where charstatus=0 order by id desc limit 0,1");
}
?>
<form action="" method="get">
<table width="100%">
<tr><td colspan="100%"><b>Добавление характеристик и описания товара</b></td></tr>
	<tr><td width="220">Найти товар:</td> <td><input type="text" style="width:50%;" name="searchindatabase" value="<?=$product[0]['name']?>"></td></tr>
    <tr><td width="220">Ссылка для поиска на <b>m.ua</b>:</td> <td><input type="text" style="width:50%;" name="linkurl"></td></tr>
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

if($product[0]['wmotmenuid']){
	echo 'Категория: '.queryresult("select name from menu where id=".$product[0]['wmotmenuid'],'name').'<br>';
}
else{
	echo 'Категория не определена! Данные характеристик записались сразу в товар!';
}

if($_GET['linkurl'] && $product[0]['id']){
	$html=iconv('cp1251','utf-8',file_get_contents($_GET['linkurl']));
	$tid=substr($html,strpos($html,'/m1_item.php?idg_=')+18,strlen($html));
	$tid=trim(substr($tid,0,strpos($tid,'&')));
	
	//get all chars
	$chars=iconv('cp1251','utf-8',file_get_contents("http://m.ua/mtools/mui_item_description_v2.php?idg_=".$tid."&mode_=full"));
	
	$chars=stripslashes($chars);
	
	
	
	$chars=str_replace('<img src="/img/icons/bul_141.gif','Есть<img src="/img/icons/bul_141.gif',$chars);
	
	$chars=strip_tags($chars,'<table><tr><td>');
	$chars=str_replace("')",'',$chars);
	$chars=str_replace("('",'',$chars);
	$chars=str_replace(' cellpadding="0" cellspacing="0" border="0" width="100%" id="help_table"','',$chars);
	$chars=str_replace(' valign="top"','',$chars);
	$chars=str_replace(' width="48%" class="op01"','',$chars);
	$chars=str_replace(' cellpadding="3" cellspacing="0" border="0" width="100%" ','',$chars);
	$chars=str_replace('<tr><td colspan="2" class="line11"></td>','',$chars);
	
	$chars_array=explode("</tr>",$chars);
	
	$values=array();
	$newxml='';
	$limitnmi=array();
	for($i=0;$i<sizeof($chars_array);$i++){
		//groups
		if(strpos($chars_array[$i],"op1'>") && !strpos($chars_array[$i],'op3">')){
			$category=substr($chars_array[$i],strpos($chars_array[$i],"op1'>")+5,strlen($chars_array[$i]));
			$categoryname=ltrim(rtrim(substr($category,0,strpos($category,"<"))));
			echo '<b>'.$categoryname.'</b><br>';
			$menuid=queryresult("select id from properties where name='$categoryname'",'id');
			if(!queryresult("select id from properties where name='$categoryname'",'id')){
				mysql_query("insert into properties(name,menuid,status) values('$categoryname','0','1')");
				$menuid=queryresult("select id from properties where name='$categoryname'",'id');
			}
			
		}
		elseif(strpos($chars_array[$i],"op1'>")){
		//menu
			$category=substr($chars_array[$i],strpos($chars_array[$i],"op1'>")+5,strlen($chars_array[$i]));
			$categoryname=ltrim(rtrim(substr($category,0,strpos($category,"<"))));
			echo $categoryname.': ';
			$testid=queryresult("select id from properties where name='$categoryname'",'id');
			if(!$testid){
				mysql_query("insert into properties(name,menuid,status) values('$categoryname','$menuid','1')");
				$testid=queryresult("select id from properties where name='$categoryname'",'id');
			}
			
			array_push($limitnmi,$testid);
		}
		//value
		if(strpos($chars_array[$i],'op3">') && strpos($chars_array[$i],"op1'>")){
			
			$category=substr($chars_array[$i],strpos($chars_array[$i],'op3">')+5,strlen($chars_array[$i]));
			$value=ltrim(rtrim(substr($category,0,strpos($category,"</td>"))));
			
			echo $value.'<br>';
			array_push($values,$value);
		}
	}
	
	$newxml='';
	for($p=0;$p<sizeof($limitnmi);$p++){
		$val=str_replace('&nbsp;',' ',$values[$p]);
		if(trim($val)!=''){
			$newxml.="<items><id>".$limitnmi[$p]."</id><value>".$val."</value></items>";
		}
	}
	
	
	$limiter_str=implode(',',$limitnmi);
		
	$queryvalue=addslashes('<?xml version="1.0" encoding="utf-8"?><root>'.$newxml.'<limiter>'.$limiter_str.'</limiter></root>');
	if($product[0]['wmotmenuid']){
		mysql_query("update menu set properties='$queryvalue' where id=".$product[0]['wmotmenuid']);
	}
	mysql_query("update products set properties='$queryvalue' where id=".$product[0]['id']) or die(mysql_error());
	
}

?>
