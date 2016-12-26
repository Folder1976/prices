<?php

    //date_default_timezone_set('Europe/moscow');
	date_default_timezone_set('Europe/Berlin');

    $__server_host = 'stilnaya.com.ua';
	$dbhost = $__db_server_host = 'localhost';
	$dbuser = $__db_user = 'agrig_shopsplum';
	$dbpasswd = $__db_pass = 'LKd2g3J5asdfH45Fdf';
	$dbbase = $__db_name = 'agrig_shopsplum';
    
	$prefix = 'fash_';
$uploaddir_s = $uploaddir = __DIR__.'/../../image/product/';
 	
	$tmp_dir = 'ru/';
	
    //Новое соединение с базой
    $mysqli= mysqli_connect($dbhost,$dbuser,$dbpasswd,$dbbase) or die("Error " . mysqli_error($mysqli)); 
    mysqli_set_charset($mysqli,"utf8");
        
function save_log($cron, $msg, $mysqli){
    
    $sql = 'INSERT INTO tbl_cron_log SET
            `date`="'.date('Y-m-d H:i:s').'",
            `cron`="'.$cron.'",
            `msg`="'.$msg.'";';
            
    $mysqli->query($sql)or die($sql);
    
}
?>