<?php
date_default_timezone_set('Europe/Moscow');
    define('TMP_DIR', 'ru/');
    // HTTP
    define('HTTP_SERVER', 'http://shopsplum.com/'.TMP_DIR);
    
    // HTTPS
    define('HTTPS_SERVER', 'http://shopsplum.com/'.TMP_DIR);
    
    // DIR
    define('DIR_APPLICATION', '/var/www/agrig/data/www/shopsplum.com/'.TMP_DIR.'catalog/');
    define('DIR_SYSTEM', '/var/www/agrig/data/www/shopsplum.com/'.TMP_DIR.'system/');
    define('DIR_LANGUAGE', '/var/www/agrig/data/www/shopsplum.com/'.TMP_DIR.'catalog/language/');
    define('DIR_TEMPLATE', '/var/www/agrig/data/www/shopsplum.com/'.TMP_DIR.'catalog/view/theme/');
    define('DIR_CONFIG', '/var/www/agrig/data/www/shopsplum.com/'.TMP_DIR.'system/config/');
    define('DIR_IMAGE', '/var/www/agrig/data/www/shopsplum.com/'.TMP_DIR.'image/');
    define('DIR_CACHE', '/var/www/agrig/data/www/shopsplum.com/'.TMP_DIR.'system/storage/cache/');
    define('DIR_DOWNLOAD', '/var/www/agrig/data/www/shopsplum.com/'.TMP_DIR.'system/storage/download/');
    define('DIR_LOGS', '/var/www/agrig/data/www/shopsplum.com/'.TMP_DIR.'system/storage/logs/');
    define('DIR_MODIFICATION', '/var/www/agrig/data/www/shopsplum.com/'.TMP_DIR.'system/storage/modification/');
    define('DIR_UPLOAD', '/var/www/agrig/data/www/shopsplum.com/'.TMP_DIR.'system/storage/upload/');

    // DB
    define('DB_DRIVER', 'mysqli');
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'agrig_shopsplum');
    define('DB_PASSWORD', 'LKd2g3J5asdfH45Fdf');
    define('DB_DATABASE', 'agrig_shopsplum');
    define('DB_PORT', '3306');
    define('DB_PREFIX', 'fash_');

    $mysqli = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE) or die("Error " . mysqli_error($mysqli)); 
    mysqli_set_charset($mysqli,"utf8");
?>