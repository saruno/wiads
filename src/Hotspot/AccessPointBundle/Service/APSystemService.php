<?php
namespace Hotspot\AccessPointBundle\Service;
use Hotspot\AccessPointBundle\Model\ApLog;
use Hotspot\AccessPointBundle\Model\ApLogQuery;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;
class APSystemService{
	
	private $session=null;
	private $request=null;
	private $response=null;
	
	public function __construct(Session $session, Request $request, Response $response)
	{
		$this->session  = $session;
		$this->request  = $request;
		$this->response = $response;
	}
	public function login($username,$password){
		//$action = $request->request->get('action');
		$ch = curl_init();
		$restUrl="http://localhost:1337/auth/signin";
		$method="POST";
		$params = array("username" => $username, "password" => $password);
		
		curl_setopt($ch, CURLOPT_URL, $restUrl);
		curl_setopt($ch, CURLOPT_COOKIESESSION, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		
		if ($params != null) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		}
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	public function createDevice($token,$nasId,$mac){
		//$action = $request->request->get('action');
		$ch = curl_init();
		$restUrl="http://localhost:1337/user/createdevice";
		$method="POST";
		$params = array("nasId" => $nasId, "MAC" => $mac);
		$authorization= "Authorization:".$token;
		curl_setopt($ch, CURLOPT_URL, $restUrl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization' , $authorization ));
		curl_setopt($ch, CURLOPT_COOKIESESSION, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	
		if ($params != null) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		}
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	public function geocoding($address){
		//	https://maps.googleapis.com/maps/api/geocode/json?address=28%20Lý%20Thường%20Kiệt+Huế,+VN&key=AIzaSyCkELm-TmZ7O8NX8Ifa46s7hbH18IkvLpQ
		//$action = $request->request->get('action');
		//$address=str_replace(" ", "+", $address);
		//$address=urlencode($address);
		$ch = curl_init();
		$restUrl="https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=AIzaSyCkELm-TmZ7O8NX8Ifa46s7hbH18IkvLpQ";
		//echo $restUrl;
		
		$method="GET";
		//$params = array("key" => 'AIzaSyCkELm-TmZ7O8NX8Ifa46s7hbH18IkvLpQ', "address" => $address);
		
		curl_setopt($ch, CURLOPT_URL, $restUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_COOKIESESSION, false);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	
		$result = curl_exec($ch);
		curl_close($ch);
		
		//$result= file_get_contents($restUrl);
		//var_dump($result);
		return $result;
	}
	public function ipLocation($address){
		//	https://maps.googleapis.com/maps/api/geocode/json?address=28%20Lý%20Thường%20Kiệt+Huế,+VN&key=AIzaSyCkELm-TmZ7O8NX8Ifa46s7hbH18IkvLpQ
		//$action = $request->request->get('action');
		//$address=str_replace(" ", "+", $address);
		//$address=urlencode($address);
		$ch = curl_init();
		$restUrl="http://ip-api.com/json/$address";
		//echo $restUrl;
	
		$method="GET";
		//$params = array("key" => 'AIzaSyCkELm-TmZ7O8NX8Ifa46s7hbH18IkvLpQ', "address" => $address);
	
		curl_setopt($ch, CURLOPT_URL, $restUrl);
		curl_setopt($ch, CURLOPT_COOKIESESSION, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	
		$result = curl_exec($ch);
		curl_close($ch);
	
		//$result= file_get_contents($restUrl);
		//var_dump($result);
		return $result;
	}
    public function getAdsmeeLinkPortal($accesspoint_id, $ssid, $fullname,$ip, $address,$geo,$status = 'ON')
    {
        $url = 'http://api.wbonus.net/pub/UpdateSub';
        //$ip = '';
        $data = array(
            'id'			=>  $accesspoint_id,
            'sid' 			=>  $ssid,
            'address'       =>  $address,
            'geo'           =>  $geo,
            'status' 		=>  $status,
            'fullname'  	=>  $fullname,
            'sign'  		=>  md5($accesspoint_id.$ssid.$ip.$fullname.$status),
            'image'         =>  ''
        );
//var_dump($data);
        $token = self::do_post_request($url, $data);

        $result = json_decode($token, true);
        return $result;
    }

    function do_post_request($url, $data) {
        $query = http_build_query($data);
        $ch = curl_init(); // Init cURL

        curl_setopt($ch, CURLOPT_URL, $url); // Post location
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 1 = Return data, 0 = No return
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ignore HTTPS
        curl_setopt($ch, CURLOPT_POST, 1); // This is POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query); // Add the data to the request

        $response = curl_exec($ch); // Execute the request
        curl_close($ch); // Finish the request

        if ($response) {
            return $response;
        } else {
            return NULL;
        }
    }
    static public function updateAdsReportMonth($y,$m){
        $cal=cal_days_in_month(CAL_GREGORIAN,intval($m),intval($y));
        $d=substr("0".(intval($cal)),-2);
        $y1=$y;
        $m=substr("0".(intval($m)),-2);
        $m1=substr("0".(intval($m)),-2);
        $d1=substr("0".(intval($d)+1),-2);
        if(intval($d)>=$cal) {
            $d1='01';
            $m1=substr("0".(intval($m)+1),-2);
            if(intval($m)==12) {
                $m1="01";
                $y1=substr("0".(intval($y)+1),-4);
            }

        }

        $query="
	    insert into ap_report (ap_macaddr,`year`,`month`) (select ap_macaddr, $y,$m from accesspoint where ap_macaddr not in (select ap_macaddr from ap_report where `year`=$y and `month`=$m))
	    ";
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        ///
        $query="
                update ap_report set `01`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-01' and b.`date`<'$y-$m-02'
                ),
                `01_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-01' and b.`date`<'$y-$m-02'
                )
                ,`02`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-02' and b.`date`<'$y-$m-03'
                ),
                `02_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-02' and b.`date`<'$y-$m-03'
                )
                ,`03`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-03' and b.`date`<'$y-$m-04'
                ),
                `03_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-03' and b.`date`<'$y-$m-04'
                )
                 ,`04`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-04' and b.`date`<'$y-$m-05'
                ),
                `04_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-04' and b.`date`<'$y-$m-05'
                )
                 ,`05`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-05' and b.`date`<'$y-$m-06'
                ),
                `05_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-05' and b.`date`<'$y-$m-06'
                )
                ,`06`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-06' and b.`date`<'$y-$m-07'
                ),
                `06_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-06' and b.`date`<'$y-$m-07'
                )
                 ,`07`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-07' and b.`date`<'$y-$m-08'
                ),
                `07_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-07' and b.`date`<'$y-$m-08'
                )
                ,`08`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-08' and b.`date`<'$y-$m-09'
                ),
                `08_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-08' and b.`date`<'$y-$m-09'
                )
                ,`09`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-09' and b.`date`<'$y-$m-10'
                ),
                `09_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-09' and b.`date`<'$y-$m-10'
                )
                ,`10`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-10' and b.`date`<'$y-$m-11'
                ),
                `10_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-10' and b.`date`<'$y-$m-11'
                )
                 ,`11`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-11' and b.`date`<'$y-$m-12'
                ),
                `11_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-11' and b.`date`<'$y-$m-12'
                )
                 ,`12`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-12' and b.`date`<'$y-$m-13'
                ),
                `12_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-12' and b.`date`<'$y-$m-13'
                )
                 ,`13`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-13' and b.`date`<'$y-$m-14'
                ),
                `13_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-13' and b.`date`<'$y-$m-14'
                )
                 ,`14`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-14' and b.`date`<'$y-$m-15'
                ),
                `14_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-14' and b.`date`<'$y-$m-15'
                )
                 ,`15`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-15' and b.`date`<'$y-$m-16'
                ),
                `15_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-15' and b.`date`<'$y-$m-16'
                )
                 ,`16`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-16' and b.`date`<'$y-$m-17'
                ),
                `16_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-16' and b.`date`<'$y-$m-17'
                )
                 ,`17`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-17' and b.`date`<'$y-$m-18'
                ),
                `17_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-17' and b.`date`<'$y-$m-18'
                )
                 ,`18`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-18' and b.`date`<'$y-$m-19'
                ),
                `18_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-18' and b.`date`<'$y-$m-19'
                )
                 ,`19`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-19' and b.`date`<'$y-$m-20'
                ),
                `19_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-19' and b.`date`<'$y-$m-20'
                )
                 ,`20`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-20' and b.`date`<'$y-$m-21'
                ),
                `20_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-20' and b.`date`<'$y-$m-21'
                )
                 ,`21`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-21' and b.`date`<'$y-$m-22'
                ),
                `21_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-21' and b.`date`<'$y-$m-22'
                )
                 ,`22`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-22' and b.`date`<'$y-$m-23'
                ),
                `22_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-22' and b.`date`<'$y-$m-23'
                )
                 ,`23`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-23' and b.`date`<'$y-$m-24'
                ),
                `23_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-23' and b.`date`<'$y-$m-24'
                )
                 ,`24`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-24' and b.`date`<'$y-$m-25'
                ),
                `24_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-24' and b.`date`<'$y-$m-25'
                )
                 ,`25`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-25' and b.`date`<'$y-$m-26'
                ),
                `25_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-25' and b.`date`<'$y-$m-26'
                )
                 ,`26`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-26' and b.`date`<'$y-$m-27'
                ),
                `26_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-26' and b.`date`<'$y-$m-27'
                )
                 ,`27`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-27' and b.`date`<'$y-$m-28'
                ),
                `27_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-27' and b.`date`<'$y-$m-28'
                )
                 ,`28`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-28' and b.`date`<'$y-$m-29'
                ),
                `28_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-28' and b.`date`<'$y-$m-29'
                )
                 ,`29`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-29' and b.`date`<'$y-$m-30'
                ),
                `29_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-29' and b.`date`<'$y-$m-30'
                )
                 ,`30`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-30' and b.`date`<'$y-$m-31'
                ),
                `30_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-30' and b.`date`<'$y-$m-31'
                )
                 ,`31`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-31' and b.`date`<'$y1-$m1-$d1'
                ),
                `31_click` =
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-31' and b.`date`<'$y1-$m1-$d1'
                )
                 where `month`=$m
        ";
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();

    }
    static public function updateAdsReportDay($y,$m,$d){
        $cal=cal_days_in_month(CAL_GREGORIAN,intval($m),intval($y));
        $y1=$y;
        $m=substr("0".(intval($m)),-2);
        $m1=substr("0".(intval($m)),-2);
        $d1=substr("0".(intval($d)+1),-2);
        if(intval($d)>=$cal) {
            $d1='01';
            $m1=substr("0".(intval($m)+1),-2);
            if(intval($m)==12) {
                $m1="01";
                $y1=substr("0".(intval($y)+1),-4);
            }

        }

        $query="
	    insert into ap_report (ap_macaddr,`year`,`month`) (select ap_macaddr, $y,$m from accesspoint where ap_macaddr is not null and ap_macaddr not in (select ap_macaddr from ap_report where ap_macaddr is not null and `year`=$y and `month`=$m))
	    ";
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        ///
        $query="
                update ap_report set `".$d."`=
                (select IFNULL(sum(b.view_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-$d' and b.`date`<'$y1-$m1-$d1'
                ),
                `".$d."_click`=
                (select IFNULL(sum(b.click_count),0) from accesspoint a, ads_daily_counting b  where ap_report.`ap_macaddr` = a.`ap_macaddr` and a.`ap_macaddr`=b.`ap_macaddr` and  b.advert_id=-1 and b.`date`>='$y-$m-$d' and b.`date`<'$y1-$m1-$d1'
                )
                 where `month`=$m
        ";
        //echo $query;
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();

    }
	static public function pollDevice(){
    	$date=date("Y-m-d H:i:s");
		$dateC=date("Y-m-d H:i:s",strtotime("-5 minutes"));
		$dateA=date("Y-m-d H:i:s",strtotime("-10 minutes"));
		$dateB=date("Y-m-d H:i:s",strtotime("-6 hours"));
		$query = " select macaddr from accesspoint where  updated_at<'".$dateA."' and updated_at>'".$dateB."' and macaddr not in (select ap_macaddr from ap_log where updated_at>'".$dateC."') order by updated_at limit 1000";
		$connection = Propel::getConnection();
		$stmt = $connection->prepare($query);
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			$apLog = ApLogQuery::create()->filterByApMacaddr($row['macaddr'])->findOneOrCreate();

			if($apLog->getUpdatedAt('Y-m-d H:i:s')>$dateC) continue;

			$apLog->setUpdatedAt($date)->save();
			exec('wiads_config_helper '.$row['macaddr']);
			sleep(1);
		}

	}
	static public function pollUpdatingDevice(){
		$date=date("Y-m-d H:i:s");
		$dateC=date("Y-m-d H:i:s",strtotime("-1 minutes"));
		$dateA=date("Y-m-d H:i:s",strtotime("-1 minutes"));
		$dateB=date("Y-m-d H:i:s",strtotime("-2 hours"));
		//$query = " select ap_macaddr from ap_config where need_update = 1 and updated_at<'".$dateA."' and updated_at>'".$dateB."' and ap_macaddr not in (select ap_macaddr from ap_log where updated_at>'".$dateC."') order by updated_at limit 1000";
		$query = " select ap_macaddr from ap_config where (need_update = 1 or trim(ssid)='option ssid \' Wifi Free\'') and updated_at<'".$dateA."' and updated_at>'".$dateB."' order by updated_at limit 100";
		$connection = Propel::getConnection();
		$stmt = $connection->prepare($query);
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			//$apLog = ApLogQuery::create()->filterByApMacaddr($row['macaddr'])->findOneOrCreate();

			//if($apLog->getUpdatedAt('Y-m-d H:i:s')>$dateC) continue;

			//$apLog->setUpdatedAt($date)->save();
			exec('wiads_config_helper '.$row['ap_macaddr']);
			sleep(1);
		}

	}
}