<?
include("init.php");

?>
<form action="" method="get">
<table>
	<tr>
    	<td>Ссылка для поиска:</td> <td><select name="linkno">
        <?
        for($i=1;$i<10;$i++){
			?>
			<option value="<?=$i?>" <?=($_GET['linkno']==$i)?'selected="selected"':''?>><?=$i?></option>
			<?
		}
		?>
        </select></td></tr>
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
function ranger($url){
    $headers = array(
    "Range: bytes=0-32768"
    );

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}


$product=querytoarray("select * from products where imageok=0 order by id desc limit 0,1");
for($i=0;$i<$product['rows'];$i++){
	unset($images);
	$images=array();
	
	$html=@file_get_contents("http://www.google.com/search?q=".urlencode($product[$i]['name']));
	
	$fpp=($_GET['fpp'])?$_GET['fpp']:'10';
	$testgoogle="http://www.google.com/search?num=".$fpp."&hl=ru&q=".urlencode($product[$i]['name']);


	
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
			
			
			echo 'Поиск картинки для: #'.$product[$i]['id'].' '.$product[$i]['name'].'<hr><br>';
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
					
			//	unset($size);
			//	$size=@getimagesize($images[$k]);
				
				//if($size[0]>100 && $size[1]>100){
					echo '<div style="float:left;margin-right:10px;position:relative;">
					<img align="left" height="100" title="'.$size[0].'x'.$size[1].' - '.$host_orig.'"  src="'.$images[$k].'" class="safeimages" pid="'.$product[$i]['id'].'">
					<div style="position:absolute;">'.$size[0].'x'.$size[1].'</div></div>';
				//}
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