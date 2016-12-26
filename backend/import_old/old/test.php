<?
$htmlin=file_get_contents("http://mag.md/catalog/02_noutbuki/nb_hp_compaq/hp_compaq_650_15_6_hd_intel_pentium_b970_2_30ghz_2gb_ddr3_ram_320gb_hdd_intel_hd_graphics_dvdrw8x_ca.html");
$host_orig='mag.md';
			
$htmlin=str_replace('src="/','src="http://'.$host_orig.'/',$htmlin);
$htmlin=str_replace('href="/','href="http://'.$host_orig.'/',$htmlin);
$htmlin=str_replace('rel="/','rel="http://'.$host_orig.'/',$htmlin);
		

$images=array();
$doc = new DOMDocument();
@$doc->loadHTML($htmlin);
$a = $doc->getElementsByTagName('a');
foreach ($a as $tag) {
     $url=$tag->getAttribute('rel');
	 if($url!=''){
		array_push($images,$url);	
	 }
}

$tags = $doc->getElementsByTagName('img');
foreach ($tags as $tag) {
     $url=$tag->getAttribute('src');
	 if($url!=''){
		array_push($images,$url);	
	 }
}



foreach ($images as $img) {
     print_r(getimagesize($img));
}



?>