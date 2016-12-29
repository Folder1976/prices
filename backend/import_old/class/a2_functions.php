<?
if(!defined('A2_CNFG')){die("Доступ Запрещён!");}
define('AW_FNCTN', true);

function utftowin($data){return iconv('utf-8','windows-1251',$data);}

function num2str($num) {
    $nul='ноль';
    $ten=array(
        array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
        array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
    );
    $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
    $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
    $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
    $unit=array( // Units
        array('копейка' ,'копейки' ,'копеек',	 1),
        array('рубль'   ,'рубля'   ,'рублей'    ,0),
        array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
        array('миллион' ,'миллиона','миллионов' ,0),
        array('миллиард','милиарда','миллиардов',0),
    );
    //
    list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub)>0) {
        foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit)-$uk-1; // unit key
            $gender = $unit[$uk][3];
            list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
            else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
        }
    }
    else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
    $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5) {
    $n = abs(intval($n)) % 100;
    if ($n>10 && $n<20) return $f5;
    $n = $n % 10;
    if ($n>1 && $n<5) return $f2;
    if ($n==1) return $f1;
    return $f5;
}

function kiriltolatin($text){
	$kiril=array('Р','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','  ','&','!',' ','/','(',')','|','.',',','+',':',']','[','-','"',"'",'__','—',"№","«","»","/","\.",";","%",'*',"#","?","$","@","’","™","%");
	$latin=array('r','a','b','v','g','d','e','yo','zh','z','i','y','k','l','m','n','o','p','s','t','u','f','h','c','ch','sh','sh','','y','','e','yu','ya','a','b','v','g','d','e','yo','zh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sh','','y','','e','yu','ya',' ','','','_','','','','','','_','','','','','','_','_','','','','','','','','','','','','','','','','','');
	
	$text=str_replace($kiril,$latin,$text);
	
	$text = strtolower($text);
	$text=urlencode($text);
	$text = str_replace("%",'',$text);
	return $text;
}

function getip(){return (!empty($HTTP_SERVER_VARS['REMOTE_ADDR']))?$HTTP_SERVER_VARS['REMOTE_ADDR']:((!empty($HTTP_ENV_VARS['REMOTE_ADDR']))?$HTTP_ENV_VARS['REMOTE_ADDR']:getenv('REMOTE_ADDR'));}

function api_connection($url,$referer='',$header='',$timeout=30){
	global $config;
	
	$curl = curl_init();
	if(strstr($referer,"://")){
		curl_setopt ($curl, CURLOPT_REFERER, $referer);
	}
	curl_setopt ($curl, CURLOPT_URL, $url);
	curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout);
	curl_setopt ($curl, CURLOPT_USERAGENT,$config['sitename']);
	curl_setopt ($curl, CURLOPT_HEADER, (int)$header);
	curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$html = curl_exec ($curl);
	curl_close ($curl);
	return $html;
}

function geo2loc($ip){
	global $config;
	return explode('/',api_connection("http://api.advaweb.ru/ip2location.xml?ip=".$ip."&var=3"));
}

function getcity($ip){
	return '-';
}
function getcountry($ip){
	return '-';
}

function text($page){
	$text=queryresult("select text from statiktext where secretkey='$page' and status=1",'text');
	$text=stripslashes($text);
	return $text;
}

function insertsystemlogs($work,$result){
	mysql_query("insert into systemlogs(time,tardate,work,result) values('".date("H:i:s")."','".date("Y-m-d")."','".addslashes($work)."','".addslashes($result)."')");
}

function title($page){
	$text=queryresult("select name from statiktext where secretkey='$page' and status=1",'name');
	$text=stripslashes($text);
	return $text;
}

function grt_sid($table_name,$where)
{
	global $db;
	do 
	{
		 $value=md5(rand_sid(20));
		 $sql="SELECT * FROM ".$table_name." WHERE ".$where."='$value'";
		 $sorgu=mysql_query($sql,$db);
	}
 	while (mysql_num_rows($sorgu)!=0);
	return $value;
}
function xmltransferto($text){
	$text=str_replace('&','&amp;',$text);
	$text=str_replace('<','&lt;',$text);
	$text=str_replace('>','&gt;',$text);
	$text=addslashes($text);
	return $text;
}
function xmltransferfrom($text){
	$text=str_replace('&amp;','&',$text);
	$text=str_replace('&lt;','<',$text);
	$text=str_replace('&gt;','>',$text);
	return $text;
}



function curlpost($url,$xml,$as){
	$data=http_build_query(array($xml));
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $as."=".$data);
	$result=curl_exec($ch);
	curl_close($ch);
return $result;
}

function calculatedate($date1,$date2){//Y-m-d H:i:s
	$mountfix=array(0,31,28,31,30,31,30,31,31,30,31,30,31);
	$mountfixc=explode('-',$date1);
	$mfix=$mountfix[intval($mountfixc[1])];
	
	$diff = abs(strtotime($date2) - strtotime($date1));
	 
	$result['year']   = floor($diff / (365*60*60*24));
	$result['mount']  = floor(($diff - $result['year'] * 365*60*60*24) / ($mfix*60*60*24));
	$result['day']    = floor(($diff - $result['year'] * 365*60*60*24 - $result['mount']*$mfix*60*60*24)/ (60*60*24));
	$result['hour']   = floor(($diff - $result['year'] * 365*60*60*24 - $result['mount']*$mfix*60*60*24 - $result['day']*60*60*24)/ (60*60));
	$result['minute']  = floor(($diff - $result['year'] * 365*60*60*24 - $result['mount']*$mfix*60*60*24 - $result['day']*60*60*24 - $result['hour']*60*60)/ 60);
	$result['second'] = floor(($diff - $result['year'] * 365*60*60*24 - $result['mount']*$mfix*60*60*24 - $result['day']*60*60*24 - $result['hour']*60*60 - $result['minute']*60));

	if($result['mount']>1){
		$result['day']+=$result['mount']*$mfix;
	}


	if(strlen($result['hour'])==1){$result['hour']='0'.$result['hour'];}
	if(strlen($result['minute'])==1){$result['minute']='0'.$result['minute'];}
	if(strlen($result['second'])==1){$result['second']='0'.$result['second'];}
	return $result; 
}

function get_user_browser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = '';
    if(preg_match('/MSIE/i',$u_agent))
    {
        $ub = "ie";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $ub = "firefox";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $ub = "safari";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $ub = "chrome";
    }
    elseif(preg_match('/Flock/i',$u_agent))
    {
        $ub = "flock";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $ub = "opera";
    }
   
    return $ub;
}

function setconfig(){
	/*
	global $db;
	$query=$db->query("select value,secretkey from advaweb_configs");
	$query_rows=$query->num_rows;
	for($i=0;$i<$query_rows;$i++){
		$query_result_fetch=mysqli_fetch_array($query);
		$query_result[$query_result_fetch['secretkey']]=stripslashes($query_result_fetch['value']);
	}
	$query_result['rows']=$query_rows;
	//mysqli_free_result($query);
	
	return $query_result;
	*/
	return array();
}

function querytoarray($query_txt,$merge='',$order=''){

	global $mysqli;
	
	if($order){$query_txt=$query_txt;}
	
	$query=$mysqli->query($query_txt);
	if(!$query){
		return false;
	}
	$query_rows=$query->num_rows;
	
	for($i=0;$i<$query_rows;$i++){
		$query_result[$i]=$query->fetch_assoc();
	}
	
	$query_result['rows']=$query_rows;
	
	return $query_result;
}


function queryresult($query_txt,$colname){
	global $mysqli;
	
	$query = $mysqli->query($query_txt) or die($query_txt);
	$query_rows=$query->num_rows;
	if($query_rows>0){
		$row = $query->fetch_assoc();
		return $row[$colname];
	}else{
		return 0;
	}
}

function askii($text){
	$text=str_replace('"','&#34',$text);
	$text=str_replace("'",'&#39',$text);
	return $text;
}

function recoveryemail($email,$secpass){
	global $config;
	$key=$config['aw_path'].'?seckey='.$secpass;
	$key_title=substr($key,0,200);
	$html='
Здравствуйте!<br><br>
Для установки нового пароля пройдите по ссылке:<br><br>
<a href="'.$key.'" target="_blank">'.$key_title.'</a><br><br>
--
C уважением,
Администрация '.strtoupper($config['sitename']).'
	';
	mail_gonder($email,strtoupper($config['sitename']).': Восстановление пароля',$html);
}

function mail_gonder($kime,$konu,$metin)
{
	global $config;
$kaynak = 'l <noreply@'.$config['sitename'].'>';
$header = "Reply-To: $kaynak\n";
$header.= "From: $kaynak\n";
$header.= "Sender: $kaynak\n";
$header.= "Return-Path: $kaynak\n";
$header.= "Date: ".date("D, d M Y H:i:s") . " UT\n";
$header.= "MIME-Version: 1.0\n";
$header.= "Content-Type: text/html;charset=utf-8\n";
$header.= "Content-transfer-encoding: 8bit\nDate: ".date('r', time())."\n";
$header.= "Priority: urgent\n";
$header.= "X-Priority: 1\n";
$header.= "X-MSMail-Priority: Highest\n";
$header.= "X-Mailer: PHP/".phpversion()."\n";
$header.= "X-MimeOLE: ";
$header.= "X-AW-Origin: lunevsales.ru http://".$config['sitename']."\n";

mail($kime,$konu,$metin,$header);
}


$searchf = array ('@<script[^>]*?>.*?</script>@si', // Strip out javascript
                 '@<[\/\!]*?[^<>]*?>@si',          // Strip out HTML tags
                 '@([\r\n])[\s]+@',                // Strip out white space
                 '@&(quot|#34);@i',                // Replace HTML entities
                 '@&(amp|#38);@i',
                 '@&(lt|#60);@i',
                 '@&(gt|#62);@i',
                 '@&(nbsp|#160);@i',
                 '@&(iexcl|#161);@i',
                 '@&(cent|#162);@i',
                 '@&(pound|#163);@i',
                 '@&(copy|#169);@i',
                 '@&#(\d+);@e',
				 '/\s\s+/');                    // evaluate as php

$replacef = array ('',
                  '',
                  '',
                  '',
                  '',
                  '',
                  '',
                  '',
                  '',
                  '',
                  '',
                  '',
                  '',
				  ' ');

function getUrl($link)
{
	$html='';
	if (!($fp = fopen($link, "r"))) return '';
	while ($data = fread($fp, 4096)) 
	{
		$html.=$data;
	}
	return $html;
}



function rand_sid($k)//rasgele karakter dizisi üretir
{
	$confirm_chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',  'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',  'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9','a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j',  'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',  'u', 'v', 'w', 'x', 'y', 'z');
	$max_chars = count($confirm_chars) - 1;
	$code = '';
	for ($i = 0; $i < $k; $i++)$code .= $confirm_chars[mt_rand(0, $max_chars)];
	return $code;
}
function rand_chars($k)//rasgele karakter dizisi üretir
{
	$confirm_chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j',  'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',  'u', 'v', 'w', 'x', 'y', 'z');
	$max_chars = count($confirm_chars) - 1;
	$code = '';
	for ($i = 0; $i < $k; $i++)$code .= $confirm_chars[mt_rand(0, $max_chars)];
	return $code;
}
function clr_username($value)
{
	global $searchf,$replacef;
	$value=preg_replace($searchf, $replacef,$value);
	$value=trim($value);
	return $value;
}
function clr_text($value)
{
	global $searchf,$replacef;
	$value=preg_replace($searchf, $replacef,$value);
	$value=trim($value);
	return $value;
}
?>