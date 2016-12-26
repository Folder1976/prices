<?php
//echo __DIR__;die();
//$config = "/var/www/fashion/config_cron_develop.php";
//$file = "/var/www/fashion/sitemap.xml";

$config = "/var/www/agrig/data/www/shopsplum.com/ru/config_cron_shopsplum.php";
$file = "/var/www/agrig/data/www/shopsplum.com/ru/sitemap.xml";

	if(!defined('TMP_DIR')){
		include ($config);
	}
	
	
	//Нужно для даты
	define('DATE_FORMAT_RFC822','c');
	// Создаем документ
	$xml = new DomDocument('1.0','utf-8');
	
	//Заголовки
	$urlset = $xml->appendChild($xml->createElement('urlset'));
	$urlset->setAttribute('xmlns:xsi','http://www.w3.org/2001/XMLSchema-instance');
	$urlset->setAttribute('xsi:schemaLocation','http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');
	$urlset->setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');
	
	

	
	$rows = array(
				  '1' => '',
				  '2' => 'brands_and_shops'
				  );
	
	foreach($rows as $row){
		// Вы можете сконвертировать свою дату в нужный формат DATE_FORMAT_RFC822
		$date_edited = date('Y-m-d');	
		$lastmod_value = date(DATE_FORMAT_RFC822, strtotime($date_edited));
		
		$url = $urlset->appendChild($xml->createElement('url'));
		$loc = $url->appendChild($xml->createElement('loc'));
		$lastmod = $url->appendChild($xml->createElement('lastmod'));
		$changefreq = $url->appendChild($xml->createElement('changefreq'));
		$priority = $url->appendChild($xml->createElement('priority'));
		$loc->appendChild($xml->createTextNode(HTTP_SERVER.''.$row));
		$lastmod->appendChild($xml->createTextNode($lastmod_value));
		$changefreq->appendChild($xml->createTextNode('monthly'));
		//Укажем средний приоритет
		if($row == ''){
			$priority->appendChild($xml->createTextNode('1'));
		}else{
			$priority->appendChild($xml->createTextNode('0.5'));
		}
	}
	
	//Категории
	$categorys = array();
	$sql = "SELECT category_id, keyword AS url, date_modified AS date_edited
							FROM ".DB_PREFIX."category
							LEFT JOIN ".DB_PREFIX."url_alias ON query = CONCAT('category_id=',category_id)
							WHERE parent_id = 0";
	$r = $mysqli->query($sql) or die($sql);
	
	$category_ids = array();
	if ($r->num_rows) {
		while($row=$r->fetch_assoc()) {
			$categorys[$row['url']]['url'] = $row['url'];
			$categorys[$row['url']]['date_edited'] = $row['date_edited'];
			$category_ids[] = $row['category_id'];
		}
	}
	
	//Второй уровень
	$sql = "SELECT category_id, keyword AS url, date_modified AS date_edited
							FROM ".DB_PREFIX."category
							LEFT JOIN ".DB_PREFIX."url_alias ON query = CONCAT('category_id=',category_id)
							WHERE parent_id IN (".implode(',',$category_ids).")";
	$r = $mysqli->query($sql) or die($sql);
	
	$category_ids = array();
	if ($r->num_rows) {
		while($row=$r->fetch_assoc()) {
			$categorys[$row['url']]['url'] = $row['url'];
			$categorys[$row['url']]['date_edited'] = $row['date_edited'];
			$category_ids[] = $row['category_id'];
		}
	}
	
	//Третий уровень
	$sql = "SELECT keyword AS url, date_modified AS date_edited
							FROM ".DB_PREFIX."category
							LEFT JOIN ".DB_PREFIX."url_alias ON query = CONCAT('category_id=',category_id)
							WHERE parent_id IN (".implode(',',$category_ids).")";
	$r = $mysqli->query($sql) or die($sql);
	
	if ($r->num_rows) {
		while($row=$r->fetch_assoc()) {
			$categorys[$row['url']]['url'] = $row['url'];
			$categorys[$row['url']]['date_edited'] = $row['date_edited'];
		}
	}
	
	foreach($categorys as $row) {

		//if(strtotime($row['date_edited'])<strtotime('2016-08-01')){
		//	$date_edited = date('Y-m-d', strtotime('2016-08-01'));	
		//}else{
		//	$date_edited = date('Y-m-d', strtotime($row['date_edited']));
		//}
		
		// Вы можете сконвертировать свою дату в нужный формат DATE_FORMAT_RFC822
		$lastmod_value = date(DATE_FORMAT_RFC822, strtotime($date_edited));
		
		$url = $urlset->appendChild($xml->createElement('url'));
		$loc = $url->appendChild($xml->createElement('loc'));
		$lastmod = $url->appendChild($xml->createElement('lastmod'));
		$changefreq = $url->appendChild($xml->createElement('changefreq'));
		$priority = $url->appendChild($xml->createElement('priority'));
		$loc->appendChild($xml->createTextNode(HTTP_SERVER.''.$row['url']));
		$lastmod->appendChild($xml->createTextNode($lastmod_value));
		$changefreq->appendChild($xml->createTextNode('monthly'));
		//Укажем средний приоритет
		$priority->appendChild($xml->createTextNode('0.8'));
	}

	
	//Фильтры
	$r = $mysqli->query("SELECT url, date_edited FROM ".DB_PREFIX."alias_description ORDER BY `id` ASC");
	if ($r->num_rows) {//2
		while($row=$r->fetch_assoc()) {
	
			//if(strtotime($row['date_edited'])<strtotime('2016-08-01')){
			//	$date_edited = date('Y-m-d', strtotime('2016-08-01'));	
			//}else{
			//	$date_edited = date('Y-m-d', strtotime($row['date_edited']));
			//}
			
			// Вы можете сконвертировать свою дату в нужный формат DATE_FORMAT_RFC822
			$lastmod_value = date(DATE_FORMAT_RFC822, strtotime($date_edited));
			
			$url = $urlset->appendChild($xml->createElement('url'));
			$loc = $url->appendChild($xml->createElement('loc'));
			$lastmod = $url->appendChild($xml->createElement('lastmod'));
			$changefreq = $url->appendChild($xml->createElement('changefreq'));
			$priority = $url->appendChild($xml->createElement('priority'));
			$loc->appendChild($xml->createTextNode(HTTP_SERVER.''.$row['url']));
			$lastmod->appendChild($xml->createTextNode($lastmod_value));
			$changefreq->appendChild($xml->createTextNode('monthly'));
			//Укажем средний приоритет
			$priority->appendChild($xml->createTextNode('0.5'));
		}
	
	}
	
	$xml->formatOutput = true;
	//Записываем файл
	$xml->save($file);

	//echo 'done';
?>
