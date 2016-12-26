<form action="" method="post" enctype="multipart/form-data">
<input type="text" name="name" value="<?=$_POST["name"]?>" size="100">
<input type="submit" value="ok">
</form>
<?

if (!empty($_POST["name"])) {
	
	ob_start();
	include("init.php");
	ob_end_clean();
	
	$allProperties = array();	
	$allPropertiesRegular = array();
	
	$allPropertiesRes = querytoarray("select id, name from properties");
	
	foreach ($allPropertiesRes as $propRes)
		$allProperties[$propRes["id"]] = $propRes;
		
	$allPropertiesRegularRes = querytoarray("select * from properties_regular");
	
	foreach ($allPropertiesRegularRes as $propRegRes) {
		$propRegRes["name"] = $allProperties[$propRegRes["properties_id"]]["name"];
		$allPropertiesRegular[$propRegRes["prioritet"]][] = $propRegRes;
	}
	
	ksort($allPropertiesRegular);
	
	
	$arProp = array();
	
	foreach ($allPropertiesRegular as $arPrior) {
		foreach ($arPrior as $arReg) {
			preg_match($arReg["regular"], $_POST["name"], $matchesProp);
			
			$prop = trim($matchesProp[0]);
			
			if (!empty($prop)) 
				$arProp[$arReg["properties_id"]] = array('value'=>$prop, 'id'=>$arReg["properties_id"], "name"=>$arReg["name"]);
		}
	}
	
	echo "<pre>";
	print_r($arProp);
	echo "</pre>";
	
}