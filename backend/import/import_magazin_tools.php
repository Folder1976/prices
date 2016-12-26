<?php
function timer(){
    global $time;
    $msg = number_format((microtime(true) - $time),3,'.','');
    $time = microtime(true);
    //echo '<br>'.$msg;
    return $msg;
}
// функция раскодирует строку из URL
function my_url_decode($s){ 
$s= strtr ($s, array ("%20"=>" ", "%D0%B0"=>"а", "%D0%90"=>"А", "%D0%B1"=>"б", "%D0%91"=>"Б", "%D0%B2"=>"в", "%D0%92"=>"В", "%D0%B3"=>"г", "%D0%93"=>"Г", "%D0%B4"=>"д", "%D0%94"=>"Д", "%D0%B5"=>"е", "%D0%95"=>"Е", "%D1%91"=>"ё", "%D0%81"=>"Ё", "%D0%B6"=>"ж", "%D0%96"=>"Ж", "%D0%B7"=>"з", "%D0%97"=>"З", "%D0%B8"=>"и", "%D0%98"=>"И", "%D0%B9"=>"й", "%D0%99"=>"Й", "%D0%BA"=>"к", "%D0%9A"=>"К", "%D0%BB"=>"л", "%D0%9B"=>"Л", "%D0%BC"=>"м", "%D0%9C"=>"М", "%D0%BD"=>"н", "%D0%9D"=>"Н", "%D0%BE"=>"о", "%D0%9E"=>"О", "%D0%BF"=>"п", "%D0%9F"=>"П", "%D1%80"=>"р", "%D0%A0"=>"Р", "%D1%81"=>"с", "%D0%A1"=>"С", "%D1%82"=>"т", "%D0%A2"=>"Т", "%D1%83"=>"у", "%D0%A3"=>"У", "%D1%84"=>"ф", "%D0%A4"=>"Ф", "%D1%85"=>"х", "%D0%A5"=>"Х", "%D1%86"=>"ц", "%D0%A6"=>"Ц", "%D1%87"=>"ч", "%D0%A7"=>"Ч", "%D1%88"=>"ш", "%D0%A8"=>"Ш", "%D1%89"=>"щ", "%D0%A9"=>"Щ", "%D1%8A"=>"ъ", "%D0%AA"=>"Ъ", "%D1%8B"=>"ы", "%D0%AB"=>"Ы", "%D1%8C"=>"ь", "%D0%AC"=>"Ь", "%D1%8D"=>"э", "%D0%AD"=>"Э", "%D1%8E"=>"ю", "%D0%AE"=>"Ю", "%D1%8F"=>"я", "%D0%AF"=>"Я")); 
return $s; 
} 

$file = explode('/', __FILE__);
if(strpos($_SERVER['PHP_SELF'], $file[count($file)-1]) !== false){
	header("Content-Type: text/html; charset=UTF-8");
	die('Прямой запуск запрещен!');
}

// ================= ЗАГРУЗКА КАРТИНОК
//================================================================== ИМПОРТ
	$uploaddir = DIR_IMAGE.'product/';
	$uploaddir_s = 'product/';
	include_once('class/shops.class.php');
	$Shops = new Shops($mysqli, DB_PREFIX);
	include_once('class/product.class.php');
	$Product = new Product($mysqli, DB_PREFIX);
	include_once('class/designer.class.php');
	
	$Designer = new Designer($mysqli, DB_PREFIX);
	include_once('class/category.class.php');
	$Category = new Category($mysqli, DB_PREFIX);

	include_once('class/shops.parse.class.php');
	$ShopImportParse = new ShopImportParse($mysqli, DB_PREFIX);

	$count_image = 100;
	$material_error	= array();
	
//echo '<h1>Импорт УНИВЕРСАЛ</h1>';
set_time_limit(0);
ini_set("max_execution_time","0");
ini_set("memory_limit","256G");
error_reporting(E_ALL ^ E_DEPRECATED);


?>
<style>
	.top_select{
		float: left;
		padding: 10px;
		border: solid 1px #aacfe4;
		margin-right: 10px;
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

<!-- Заголовок -->
	<div class="top_header">
		<h1 style="margin-bottom: 10px;" class="header">Импорт товаров</h1>
	</div>

    <div style="max-width: 1375px;">
    <div class="table_body">
        
        <div class="navigation">
            <form name="import_exel_carfit" method="post" enctype="multipart/form-data">
                   
                    <div class="top_select">
						
						<div class="select_top shop">
                            <label class="select_lable">Магазин</label>
                            <select class="select" name="operation" id="operation" style="width:300px;">
                                <option value="0">Выбрать операцию</option>
                                <option value="1">ЧасНаБуты Продюсеры</option>
                            </select>
                        </div>
						
                    </div>
	
                    <div class="top_select">
                        <div class="select_top get_url_wrapper">
                            <label class="select_lable">УРЛ на данные</label>
                            <!--input type="file" name="file" style="width:300px;"-->
                            <input type="text" name="import_url" value="<?php if(isset($_POST['import_url'])) echo $_POST['import_url'];?>"> <!--accept=".txt,image/*"-->
                                
                        </div>
						<div class="select_top get_file_wrapper"  style="margin-top: 10px;">
                            <label class="select_lable">Фаил</label>
                            <!--input type="file" name="file" style="width:300px;"-->
                            <input type="file" name="import_file"> <!--accept=".txt,image/*"-->
                                
                                <div class="ajax-respond"></div>
                            
                        </div>
						
                    </div>
                            
                    <div class="top_select">
                        <div class="select_top shop">
                            <label class="select_lable">Фаил</label>
                            <input type="submit" value="Загрузить" style="width:300px;">
                        </div>
                    </div>
       
            </form>
        </div>
		<div style="clear: both"></div>
		<style>
			.load_pic{
				padding: 5px;
				border: 1px solid gray;
				width: 300px;
				margin-top: 10px;
				display: block;
				text-align: center;
			}
		</style>
		<div style="clear: both"></div>
<?php
//====================================================================================================================				
//====================================================================================================================				
//====================================================================================================================				
?>
	
<?php
		
	if(isset( $_FILES['import_file']['tmp_name']) OR (isset($_POST['import_url']) AND $_POST['import_url'] != '')){
	
		if(isset($shop['modul']) AND $shop['modul'] != '' AND is_array($shop)){
			echo 'Какойто бред тут!';
		}elseif(isset($_FILES['import_file']['tmp_name']) AND $_FILES['import_file']['tmp_name'] != ''){
			 $tmpFilename = $_FILES['import_file']['tmp_name'];
			 $simple = file_get_contents($tmpFilename);
		}elseif( $_POST['import_url'] != ''){
			 $simple = file_get_contents($_POST['import_url']);
		}

		//Если стоит самоопределение магазина
		if(isset($simple)){
			
			if(mb_detect_encoding($simple, 'UTF-8', true)){
				$html_utf8_1251 = $simple;
			}else{
				$html_utf8_1251 = mb_convert_encoding($simple, "utf-8", "windows-1251");
			}
		}
	
		
		if(isset($_POST['operation']) AND $_POST['operation'] > 0){
			
			//Продюсеры час на буты
			if($_POST['operation'] == 1){	
				
				$pat = '<producer ';
				$rows = explode($pat, $html_utf8_1251);
				
				
				foreach($rows as $row){
					
					if(strpos($row, 'id=') !== false){
						
						$rows2 = explode('"', $row);
						
						$name = $rows2[3];
						
						$sql = "SELECT manufacturer_id FROM ".DB_PREFIX."manufacturer WHERE
									upper(`name`) LIKE '%".mb_strtoupper(addslashes($name),'UTF-8')."%' or
									upper(`href`) LIKE '%".mb_strtoupper(addslashes($name),'UTF-8')."%'
									";
						$r = $mysqli->query($sql) or die($sql);
						
						if($r->num_rows == 0){
							
							$href = strtolower(translitArtkl(trim($name)));
							
							$sql = "INSERT INTO ".DB_PREFIX."manufacturer SET
									`name` = '".$name."',
									`href` = '".$href."',
									`image` = '',
									`sort_order` = '0',
									`enable` = '1'
									";
							$r = $mysqli->query($sql) or die($sql);
						}
							
					}
							
				}
				
	
			}
			
			
			
			
			
			echo '<h3>Данные загружены.</h3>';
		}else{
			echo '<h3>не выбранна операция.</h3>';
		}
	
	}else{
		
		echo '<h3>Ничего не прилетело</h3>';
	}
	

	
	
	

//========================================

function translit($str) {
    $rus = array('и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
   return str_replace($rus, $lat, $str);
  }
    function clear_str($str) {
    $find = array('&quot;','\'');
    $replace = array('','');
    return str_replace($find, $replace, $str);
  }

  function translitArtkl($str) {
    $rus = array('и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
   return str_replace($rus, $lat, $str);
  }
 
 
  //Рекурсия=================================================================
function readTree($parent,$mysqli){
	$sql = 'SELECT C.category_id AS id, C.parent_id, CD.name
				FROM `'.DB_PREFIX.'category` C
				LEFT JOIN `'.DB_PREFIX.'category_description` CD ON C.category_id = CD.category_id
				WHERE parent_id = "'.$parent.'" ORDER BY name ASC;';
	//echo $sql.'<br>';
	$rs1 = mysqli_query( $mysqli, $sql) or die ("Get product type list");

	$body = "";

	 while ($Type = mysqli_fetch_assoc($rs1)) {
		$body .=  "<li><span id=\"span_".$Type['id']."\"><a class = \"tree category_id_".$Type['id']."\" href=\"javascript:\" id=\"".$Type['id']."\">".$Type['name']."</a>";
		$body .= "</span>".readTree($Type['id'],$mysqli);
		$body .= "</li>";
	}
	if($body != "") $body = "<ul>$body</ul>";
	return $body;

}
?>
