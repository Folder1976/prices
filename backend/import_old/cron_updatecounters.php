<?
session_start();
header("Content-Type: text/html; charset=utf-8");

define('A2', true);
define('A2_CNFG', true);


include("../a2_config.php");
$db=mysql_connect($db_host,$db_username,$db_password) or die('Mysql cant connect to server!');
mysql_select_db($db_name,$db) or die('Mysql cant select DB!');
mysql_query("SET NAMES 'utf8'");

include("../advaweb.classes/advaweb.class.php");
include("../advaweb.classes/modules.class.php");
include("../advaweb.classes/priced.md.class.php");

$site=new Priced();



/*
unset($data);
$data=$site->qa("select id,dopname from productdopnames order by id desc");
for($i=0;$i<$data['rows'];$i++){
	$name=str_replace('  ',' ',$data[$i]['dopname']);
	echo 'SR:'.$name.'<br>';
	mysql_query("update productdopnames set dopname='$name' where id=".$data[$i]['id']);
}

unset($data);
$data=$site->qa("select id from brend");
for($i=0;$i<$data['rows'];$i++){
	$counter=queryresult("select count(*) as total from products where brendid=".$data[$i]['id'],"total");
	mysql_query("update brend set counter=$counter where id=".$data[$i]['id']);
}
*/
unset($data);
$data=$site->qa("select id,wmotmenuid from products where menuid1=0 limit 0,1000");

for($i=0;$i<$data['rows'];$i++){
	unset($menudata,$liner);
	$liner=array();
	$menudata=$site->qa("select wmotmenuid,tip,id from menu where id=".$data[$i]['wmotmenuid']);
	
	$pricetest=($site->qr("select id from product_prices where productid=".$data[$i]['id'],'id'))?1:0;

	mysql_query("update products set priceok='$pricetest',menuid".($menudata[0]['tip']+1)."=".$data[$i]['wmotmenuid']." where id=".$data[$i]['id']);
	$testid=$data[$i]['wmotmenuid'];
	array_push($liner,$testid);	
	while($testid){
		if($testid){
		
		unset($menudatax);
			$menudatax=$site->qa("select wmotmenuid,id,tip from menu where id=".$testid);
			if($menudatax[0]['tip']){
				mysql_query("update products set menuid".$menudatax[0]['tip']."=".$menudatax[0]['wmotmenuid']." where id=".$data[$i]['id']);
				array_push($liner,$menudatax[0]['wmotmenuid']);	
				//echo htmlspecialchars("update products set menuid".$menudatax[0]['tip']."=".$menudatax[0]['wmotmenuid']." where id=".$data[$i]['id']).'<br>';
				
			
			}
			
			$testid=$menudatax[0]['wmotmenuid'];
		}
	}
	mysql_query("update products set menues='".implode(',',$liner)."' where id=".$data[$i]['id']);
	
}

echo '<br>PRODUCTS: '.$data['rows'].'<br>';

/*

unset($data);
$data=$site->qa("select id,wmotmenuid from products");
for($i=0;$i<$data['rows'];$i++){
	$pricetest=(queryresult("select id from product_prices where productid=".$data[$i]['id'],'id'))?1:0;

	mysql_query("update products set priceok='$pricetest' where id=".$data[$i]['id']);
}
echo '<br>PRODUCTS: '.$data['rows'].'<br>';

unset($data);*/


mysql_query("update menu set counter=0");
$data=$site->qa("select id,tip from menu");
for($i=0;$i<$data['rows'];$i++){
	
	$counter=$site->qr("select count(*) as total from products where find_in_set(".$data[$i]['id'].",menues)","total");
	//echo htmlspecialchars("select count(*) as total from products where menuid".($data[$i]['tip']+1)."=".$data[$i]['id']).'<br>';
	
	mysql_query("update menu set counter=$counter where id=".$data[$i]['id']);
}

echo 'OK';
?>