<?php
header("Content-Type: text/html; charset=utf-8");
/**
 * Created by JetBrains PhpStorm.
 * User: STEMIZER
 * Date: 15.09.2012
 * Time: 15:21
 * To change this template use File | Settings | File Templates.
 */
require('reader.php');
$connection = new Spreadsheet_Excel_Reader();
$connection->setOutputEncoding('UTF-8');
$connection->read('report.xls');


echo '<pre>';
print_r($connection->sheets);
echo '</pre>';