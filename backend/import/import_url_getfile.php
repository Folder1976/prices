   <?php
    /**
     * The function to download files
     *
     * @param string $url
     * @return mixed|null
     */
    function DownloadFile($url)
    {
		$s = $url;
		$i = parse_url($s); 
		$p = ''; 
		foreach(explode('/',trim($i['path'],'/')) as $v) {$p .= '/'.rawurlencode($v);} 
		$url = $i['scheme'].'://'.$i['host'].$p; 
	
	
	//echo '====='.$url;die();	
	
	
	if (!extension_loaded('curl')) {
            return null;
        }

        $ch = curl_init();
       
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_AUTOREFERER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => 100,
                CURLOPT_TIMEOUT => 220,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.155 Safari/537.3',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Encoding:gzip, deflate, sdch',
                    'Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
                    'Cache-Control:max-age=0',
                    'Connection:keep-alive',
		    )
            )
        );


        $data = curl_exec($ch);
        if (curl_errno($ch) != CURLE_OK) {
            return null;
        }

        return $data;
    }
	 function DownloadFileNoCode($url)
    {
	
	if (!extension_loaded('curl')) {
            return null;
        }

        $ch = curl_init();
       
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_AUTOREFERER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CONNECTTIMEOUT => 100,
                CURLOPT_TIMEOUT => 420,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Encoding:gzip, deflate, sdch',
                    'Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
                    'Cache-Control:max-age=0',
                    'Connection:keep-alive',
		    )
            )
        );

	    $data = curl_exec($ch);
		
		//echo "<pre>";  print_r(var_dump( $data )); echo "</pre>";
		
        if (curl_errno($ch) != CURLE_OK) {
			echo '<br><br><font color="red">Ошибка curl: ' . curl_error($ch).'</font>';

            return null;
        }

        return $data;
    }
    ?>
