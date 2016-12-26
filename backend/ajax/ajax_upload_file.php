<?php

//include('ajax_config.php');
 
// Здесь нужно сделать все проверки передаваемых файлов и вывести ошибки если нужно
 
// Переменная ответа
 
$data = array();
header("Content-Type: text/html; charset=UTF-8");
echo "<pre>";  print_r(var_dump( $_POST )); echo "</pre>";
if( isset( $_GET['uploadfiles'] ) ){
    $error = false;
    $files = array();
 
    $uploaddir = 'tmp/'; // . - текущая папка где находится submit.php
 
    // Создадим папку если её нет
 
    //if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
  echo '111';
    // переместим файлы из временной директории в указанную
    foreach( $_FILES as $file ){
		
		echo (file_get_contents( $file['tmp_name']));
		
	    if( move_uploaded_file( $file['tmp_name'], $uploaddir . basename($file['name']) ) ){
            $files[] = realpath( $uploaddir . $file['name'] );
        }
        else{
            $error = true;
        }
    }
 
    $data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('files' => $files );
 
   // echo json_encode( $data );
}
