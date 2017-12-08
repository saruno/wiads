<?php

namespace AdvertiserBundle\Helper;


class CurlHelper
{
	private $ch;

	 /**
     * @param string $url
     * @param array  $options
     */
    public function __construct($url, array $params = array(), $method = 'GET')
    {	
    	$data = '';
    	foreach($params as $k => $v) { 
		    $data .= $k . '='.$v.'&'; 
		}
		$data = rtrim($data, '&');

        $this->ch = curl_init();
		$timeout = 5;

		if($method == 'GET'){
			$url .= '?'.$data;
		} 
       
		curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $timeout);


		if($method == 'POST'){
			curl_setopt($this->ch, CURLOPT_POST, count($data));
        	curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);    
		}
    }


    public function __destruct()
    {
        if (is_resource($this->ch)) {
            curl_close($this->ch);
        }
    }

    public function getResult()
    {
        return curl_exec($this->ch);
    }
}