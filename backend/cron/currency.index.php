<?php

//header("Content-Type: text/html; charset=UTF-8");

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

if(isset($_GET['config'])){
    include __DIR__.'/'.$_GET['config'].'.php';
}else{
    include __DIR__.'/config.php';
}


$api = 'https://query.yahooapis.com/v1/public/yql?q=select+*+from+yahoo.finance.xchange+where+pair+=+%22USDEUR,USDRUB,USDMDL%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=';

$currency = json_decode(file_get_contents($api), true);


//Сохраним предыдущее значение - если прошлое обновление было больше чем сутки
$sql = 'SELECT ';

foreach($currency['query']['results']['rate'] as $row){
	
	$code = str_replace('USD/','',$row['Name']);
	$kurs = $row['Ask'];
	
	$sql = 'SELECT * FROM ' . DB_PREFIX . 'currency WHERE code = "'.$code.'" LIMIT 1;';
	$r = $mysqli->query($sql);
	
	if($r->num_rows){
		
		$row_base = $r->fetch_assoc();
		
		//Если курс изменился
		if($row_base['value'] != $kurs){
			
			$sql = 'UPDATE ' . DB_PREFIX . 'currency SET `last_value` = `value`, date_modified = NOW() WHERE code = "'.$code.'";';
			$mysqli->query($sql);
			//echo '<br>'.$sql;

			$sql = 'UPDATE ' . DB_PREFIX . 'currency SET `value` = "'.$kurs.'", date_modified = NOW() WHERE code = "'.$code.'";';
			$mysqli->query($sql);
			//echo '<br>'.$sql;
			
		}
		
		
	}
	
	
}


?>
