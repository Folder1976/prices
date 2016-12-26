<?
include("init.php");

if($_GET['searchindatabase']){
	$product=querytoarray("select * from products where imageok=0 and name like '%".$_GET['searchindatabase']."%' order by name");
}
else{
	$product=querytoarray("select * from products where imageok=0 order by id desc limit 0,1");
}
?>
<form action="" method="get">
<table width="1000">
<tr><td colspan="100%"><b>Добавление характеристик и описания товара</b></td></tr>
	<tr><td width="120">Найти группу товаров:</td> <td><input autocomplete="off" type="text" style="width:100%;" id="searchindatabaseint" name="searchindatabase" value="<?=$_GET['searchindatabase']?>"></td></tr>
    <tr><td width="120">Поиск в Google:</td> <td><input autocomplete="off" type="text" style="width:100%;" name="searchinsite" value="<?=$_GET['searchinsite']?>"></td></tr>
	<tr>
    	<td>Страница:</td> <td><select name="linkno">
        <?
        for($i=1;$i<10;$i++){
			?>
			<option value="<?=$i?>" <?=($_GET['linkno']==$i)?'selected="selected"':''?>><?=$i?></option>
			<?
		}
		?>
        </select></td></tr>
    <tr><td rowspan="2">Настройки</td>
    	<td><input type="checkbox" name="testimagesize" <? if($_POST['testimagesize']){echo 'checked';} ?>>Определять подходящие картинки(понижает скорость обработки)</td></tr>
    <tr>
    	<td><input type="checkbox" name="retestallimage">Перепроверить все товары на наличие картинок(Займет немного времени)</td></tr>
    <tr><td><input type="submit" value="Поиск"></td>
    </tr>
</table>
</form>

<style>
.safeimages{ border:#CCCCCC 1px solid; cursor:pointer; padding:1px; margin-right:20px;}
</style>

<?
if($_GET['retestallimage']){
	$data=querytoarray("select * from products where imageok=1");
	$p=0;
	for($i=0;$i<$data['rows'];$i++){
		if(!queryresult("select id from product_fotos where productid=".$data[$i]['id'],"id")){
			mysql_query("update products set imageok=0 where id=".$data[$i]['id']);
			$p++;
		}
	}
	echo 'Проверка завершена! Проверено '.$data['rows'].' изменено '.$p.' товаров!<br><br>';
}


if(!$product['rows']){echo '<font style="font-size:15px;"><b>Товаров не найдено!</b></font><br>';}
else{
?>
<a href="javascript:;" onclick="$('.products').attr('checked','checked');">Выбрать все</a><br><br>
<?
}

for($i=0;$i<$product['rows'];$i++){
	?>
	<input type="checkbox" name="products[]" class="products" value="<?=$product[$i]['id']?>"> <?=$product[$i]['name']?><br>
	<?
}

if($_GET['searchinsite'] && $product['rows']){
	unset($images);
	$images=array();
	
	
	$fpp=($_GET['fpp'])?$_GET['fpp']:'10';
	$testgoogle="http://www.google.com/search?num=".$fpp."&hl=ru&q=".urlencode($_GET['searchinsite']);

	
	$resource=@file_get_contents($testgoogle);
	preg_match_all("/\<h3 class=\"r\"\>\<a href=\"(.*?)\"(.*?)\>/is",$resource,$result);
	
	
	
	$no=intval($_GET['linkno']);
	for($j=(($no)?$no:0);$j<(($no)?$no+1:0);$j++){
		$url=substr($result[1][$j],strpos($result[1][$j],"/url?q=")+7,strlen($result[1][$j]));
		$url=substr($url,0,strpos($url,'&amp;sa='));
		
		$parseurl=parse_url($url);
		$host_orig=$parseurl['host'];
		
		if($url){
			
		
			unset($matches);
			$htmlin=@file_get_contents(urldecode($url));
			
			$htmlin=str_replace('src="/','src="http://'.$host_orig.'/',$htmlin);
			$htmlin=str_replace("src='/","src='http://".$host_orig."/",$htmlin);
			$htmlin=str_replace('src=/','src=http://'.$host_orig.'/',$htmlin);
			$htmlin=str_replace('href="/','href="http://'.$host_orig.'/',$htmlin);
			$htmlin=str_replace('rel="/','rel="http://'.$host_orig.'/',$htmlin);
			
			
			echo 'Поиск картинки для: '.$_GET['searchindatabase'].'<hr><br>';
unset($doc);
$doc = new DOMDocument();
@$doc->loadHTML($htmlin);
$a = $doc->getElementsByTagName('a');
foreach ($a as $tag) {
	 $url=$tag->getAttribute('rel');
	 $ext=substr($url,strrpos($url,'.'),strlen($url));
	 if($url!='' && in_array($ext,array('.png','.jpg','.jpeg','.gif'))){
		array_push($images,$url);	
	 }
}

$href = $doc->getElementsByTagName('a');
foreach ($href as $tag) {
	 $url=$tag->getAttribute('href');
	 if($url!='/' && $url!='#' && $url!=''){
		 
		 $ext=substr($url,strrpos($url,'.'),strlen($url));
		 if($url!='' && in_array($ext,array('.png','.jpg','.jpeg','.gif'))){
			array_push($images,$url);	
		 }
	 }
}

$tags = $doc->getElementsByTagName('img');
foreach ($tags as $tag) {
	 $url=$tag->getAttribute('src');
	 
	 $ext=substr($url,strrpos($url,'.'),strlen($url));
	 if($url!='' && in_array($ext,array('.png','.jpg','.jpeg','.gif'))){
		array_push($images,$url);	
	 }
}
		
		
			echo '<div style="float:left;width:100%;clear:both;">Похожие изображения:<br>';
			$max=10;
			$namearray=explode(' ',$product[$i]['name']);
			$imgarray=querytoarray("select * from products where name like '%".$namearray[0].' '.$namearray[1]."%' and imageok=1 or name like '%".$namearray[1]."%' and imageok=1 order by rand() limit 0,20");
			for($k=0;$k<$imgarray['rows'];$k++){
				if(!$max)break;
				$image=queryresult("select image from product_fotos where productid=".$imgarray[$k]['id'],'image');
				if($image!=''){
					echo '<div style="float:left;margin-right:10px;position:relative;">
					<img align="left" src="'.$image.'" height="100" class="safeimages" pid="'.$product[$i]['id'].'"></div>';
					$max--;
				}
			}
			
			echo '</div><div style="float:left;width:100%;clear:both;"><hr> Найденные изображения:<br>';
			/*echo '<pre>';
			print_r($images);
			
			
			echo htmlspecialchars($htmlin);
			exit();*/
			for($k=0;$k<sizeof($images);$k++){
					
				if(!strpos($images[$k],'ttp://')){
					$images[$k]='http://'.$host_orig.'/'.$images[$k];
				}	
					
				if($_GET['testimagesize']){$sizer=0;
					unset($size);
					$size=@getimagesize($images[$k]);
				}else{$sizer=1;}
				
				
				if($size[0]>100 && $size[1]>100 || $sizer){
					echo '<div style="float:left;margin-right:10px;position:relative;">
					<img align="left" height="100" title="'.$size[0].'x'.$size[1].' - '.$host_orig.'"  src="'.$images[$k].'" class="safeimages" pid="'.$product[$i]['id'].'">
					<div style="position:absolute;">'.$size[0].'x'.$size[1].'</div></div>';
				}
			}
			echo '</div>';
		}
	}
}
?>
<script>

$("img.safeimages").click(function() {
	addfoto($(this));
});
</script>