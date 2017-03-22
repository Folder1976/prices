<?php

$id = 0;
if(isset($_GET['id'])) $id = $_GET['id'];

$key = 0;
if(isset($_GET['key'])) $key = $_GET['key'];

$address = 0;
if(isset($_GET['address'])) $address = $_GET['address'];

$google = 0;
if(isset($_GET['google'])) $google = $_GET['google'];

$magazin = 0;
if(isset($_GET['magazin'])) $magazin = $_GET['magazin'];

$phone = 0;
if(isset($_GET['phone'])) $phone = $_GET['phone'];

$status = 0;
if(isset($_GET['status'])) $status = $_GET['status'];

$lat = 0;
if(isset($_GET['lat'])) $lat = $_GET['lat'];

$lng = 0;
if(isset($_GET['lng'])) $lng = $_GET['lng'];

   
switch($key){
    
    case 'get_coordiname' :
        
        $google = str_replace(' ', '%20', $google);
        
         // Обращение к http-геокодеру
        $xml = simplexml_load_file('http://maps.google.com/maps/api/geocode/xml?address='.$google.'&sensor=false');
        // Если геокодировать удалось, то записываем в БД
        
		echo 'http://maps.google.com/maps/api/geocode/xml?address='.$google.'&sensor=false';
		
        $return = array();
        
        $status = $xml->status;
		
		echo '111111';
		header("Content-Type: text/html; charset=UTF-8");
		echo "<pre>";  print_r(var_dump( $xml )); echo "</pre>";
	
		
		if ($status == 'OK') {
           
            $return['lat'] = $lat = $xml->result->geometry->location->lat;
			$return['lng'] = $lng = $xml->result->geometry->location->lng;
           
        } else {
            $return['lat'] = '0';
            $return['lng'] = '0';
        }
        
        echo json_encode($return);
    break;
    
    
}



?>