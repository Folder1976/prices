<?
if(!defined('A2')){die("Доступ Запрещён!");}

function a2tpl_header(){
	global $config;
	$meta=querytoarray("select * from seo where url='".addslashes(clr_text(str_replace("/".$config['sitename'],'',$_SERVER['REQUEST_URI'])))."' and status=1 ");

$metakeywords = '';
if(isset($meta[0]['metakeywords'])){
	$metakeywords = stripslashes($meta[0]['metakeywords']);
}

$metadesc = '';
if(isset($meta[0]['metadesc'])){
	$metadesc = stripslashes($meta[0]['metadesc']);
}

$metatitle = '';
if(isset($meta[0]['metatitle'])){
	$metatitle = stripslashes($meta[0]['metatitle']);
}
	
echo 
	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta content="no-cache" http-equiv="Cache-Control" />
	<meta name="">
	<meta name="Copyright" content="Copyright (c)">
	<meta name="Keywords" content="'.$metakeywords.'">
	<meta name="Description" content="'.$metadesc.'">
	<meta name="Content-Language" content="Russian" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>'.$metatitle.'</title>';
	return;
}
?>