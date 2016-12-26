<?php

include('../../config.php');
include('../config.php');
session_start();


$key = $_GET['key'];


if($key == 'add_log'){
	
	$log_key 	= $_GET['log_key'];
	$log_target = $_GET['log_target'];
	$log_text 	= $_GET['log_text'];
	$log_date = date('Y-m-d H:i:s');
	$log_user = $_SESSION['default']['user_id'];
	

	$sql = 'INSERT INTO ' . DB_PREFIX . 'user_log SET
						log_key 	= "'.$log_key.'",
						log_target 	= "'.$log_target.'",
						log_text 	= "'.$log_text.'",
						log_date 	= "'.$log_date.'",
						log_user 	= "'.$log_user.'"
						';
	
	$mysqli->query($sql) or die('saldvh ;asfk '.$sql);
}

?>