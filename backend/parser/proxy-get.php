<?php

class GetViaProxy {
    public $debug_info       =   array();
    public $debug_log        =   false;
    public $console_mode  =   false;
	protected $array_proxy          =   array();
	protected $array_useragent      =   array();
	protected $useragent = 0;
	protected $CNX = 0;
	protected $ProxyToCheck = array();

	protected $curProxyInd = 0;
	protected $curProxy = array();

    protected $options = array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_TIMEOUT => 30
    );


	function __construct($SQ = "") {
		$this->CNX = $SQ;
	}

	//Get list of proxy for get
	public function GetListOfProxy() {
		
		$r=mysqli_query($this->CNX, "SELECT `Host_ID`, `proxyhosts`, `proxytype`
		FROM `tbl_parser_hosts` WHERE 1 ORDER BY proxy_deny_count ASC LIMIT 0,20;") or die($this->add_debug_msg("Can't get proxy - no proxy in proxylist"));
	
		if(mysqli_num_rows($r) == 0) {
			$this->add_debug_msg("Can't get proxy - SQL query return null");
			return false;
		}
	
		$tmp = array();
		while($tPr = mysqli_fetch_assoc($r)) {
			$this->ProxyToCheck[] = $tPr;
		}

		echo "<pre>";
		//print_r($tmp);
		//echo "<hr>Random";
/*
		$this->ProxyToCheck[] = $tmp[$rndPoz];
		
		for($i=0;$i<4;$i++) {
			$rndPoz = mt_rand(0, count($tmp)-1);
			//echo "<li>".$i." : ".$rndPoz."</li>";
			if (isset($tmp[$rndPoz])) {
				$this->ProxyToCheck[] = $tmp[$rndPoz];
				unset($tmp[$rndPoz]);
			}else {
				$i--;
			}
		}
		*/
		
		//print_r($this->ProxyToCheck);
		//die();
		$this->GetNextProxy();
	
		return true;
	}

	//Get next proxy from list
	public function GetNextProxy() {
		if(count($this->ProxyToCheck) == 0) {
			echo "<li>No one from 5 proxy didn't work, tring again</li><script>location.reload();</script>";
			//$this->add_debug_msg("Can't get proxy - list is null");
			die();
			return false;
		}
		$this->curProxy = array();
		$this->curProxy = array_shift($this->ProxyToCheck);
		print_r($this->curProxy);
		return true;
	}

	//Get next useragent from list
	public function GetUserAgent() {
		$r=mysqli_query($this->CNX, "SELECT `UA_Value`
		FROM `tbl_parser_useragents` WHERE 1 ORDER BY rand() LIMIT 0,1;") or die($this->add_debug_msg("Can't get useragent - table empty"));
		$this->array_useragent = mysqli_fetch_assoc($r);
	}

	//increase counter of bad requests
	public function SetBadProxy() {
		$r=mysqli_query($this->CNX, "UPDATE `tbl_parser_hosts` SET `proxy_deny_count`=`proxy_deny_count`+1 WHERE `Host_ID`='".$this->curProxy["Host_ID"]."';") or die($this->add_debug_msg("Can't increase proxy bad requests counter"));
	}

	
	public function GetURL ($Url, $method = "GET", $post_data = null, $headers = null) {

		$this->GetListOfProxy();
		$this->GetUserAgent();

		$options = $this->options;
		$options[CURLOPT_URL] = $Url;

		$options[CURLOPT_USERAGENT] = $this->array_useragent["UA_Value"];

		if ($headers) {
			$options[CURLOPT_HEADER] = 0;
			$options[CURLOPT_HTTPHEADER] = $headers;
		}
		
		if ($method == "POST" || is_array($post_data)) {
			$options[CURLOPT_POST] = 1;
			$options[CURLOPT_POSTFIELDS] = $post_data;
		}

		$output = "";
		while($output == "") {
			if (!isset($this->curProxy["proxyhosts"]) || $this->curProxy["proxyhosts"] == "") {
				throw new CurlGetException("(!) Error: no proxy available for request.");
			}

			$options[CURLOPT_PROXY] = $this->curProxy["proxyhosts"];
			if ($this->curProxy["proxytype"] == 'socks5') {
				$options[CURLOPT_PROXYTYPE] = CURLPROXY_SOCKS5;
			}

			$ch = curl_init();
			curl_setopt_array($ch, $options);
			$output = curl_exec($ch);
			$info = curl_getinfo($ch);
			if ($output == "") {
				$this->SetBadProxy();
				$this->GetNextProxy();
				$this->GetUserAgent();
				curl_close($ch);

			}
			
			echo '<br>-result- : '.$output.'<br>';
		}

		
		$ForRetun = array(
			"output" => $output,
			"info" => $info,
			"options" => $options
		);
		unset($options);
		return $ForRetun;
	}

   /**
     * Logging method
     *
     * @access public
     * @param string $msg message
     * @return void
     */
    public function add_debug_msg($msg)
    {
        if($this->debug_log)
        {
            $this->debug_info[] = $msg;
        }
        
        if($this->console_mode)
        {
            echo htmlspecialchars($msg)."\r\n";
        }
    }

}

/**
 * AngryCurl custom exception
 */
class CurlGetException extends Exception
{
    public function __construct($message = "", $code = 0 /*For PHP < 5.3 compatibility omitted: , Exception $previous = null*/)
    {
		echo htmlspecialchars($message)."\r\n";
       //GetViaProxy::add_debug_msg($message);
    }
}

?>