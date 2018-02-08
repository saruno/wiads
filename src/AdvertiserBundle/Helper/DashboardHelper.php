<?php

namespace AdvertiserBundle\Helper;

use Hotspot\AccessPointBundle\Model\ApConfig;
use Hotspot\AccessPointBundle\Model\Base\AdsDailyCountingQuery;
use Hotspot\AccessPointBundle\Model\Base\ApConfigQuery;
use Hotspot\AccessPointBundle\Model\Base\TrackLogQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Common\DbBundle\Model\App;
use Common\DbBundle\Model\Advert;
use Common\DbBundle\Model\AdvertQuery;
use Common\DbBundle\Model\AdvertI18n;
use Common\DbBundle\Model\AdvertI18nQuery;
use Common\DbBundle\Model\Advertcache;
use Common\DbBundle\Model\AdvertcacheQuery;

use Hotspot\AccessPointBundle\Model\AdsLog;
use Hotspot\AccessPointBundle\Model\AdsLogQuery;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;
use Hotspot\AccessPointBundle\Model\TrackLog;
use Hotspot\AccessPointBundle\Model\AccesspointQuery;

class DashboardHelper
{	
	private $owner;
	private $customer_id;

	public function __construct($owner, $customer_id){
		$this->owner = $owner;
		$this->customer_id = $customer_id;
	}

	public function getTotalAccessPoint($province = null, $time = array())
	{

		$sql = "SELECT COUNT(a.id) AS total ";
		
		$sql .= "FROM accesspoint a,accesspoint_i18n b  WHERE a.id = b.id AND 1 = 1 AND a.province IS NOT NULL ";
		if($this->owner != ''){
			$sql .= "AND b.post_by = '".$this->owner."' ";
		}
		if($province != null){
			$sql .= "AND a.province = '".$province."' ";
		}
		
		if(!empty($time) && isset($time['start'], $time['end'])){ 
			$sql .= "AND (created_at >= '".$time['start']."' AND created_at <= '".$time['end']."')";
		}
		
		$connection = Propel::getConnection();
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(2)[0];
	}

	public function getTotalAccessPointOnline($province = null, $time = array())
	{

		$sql = "SELECT COUNT(a.id) AS total ";
		
		$sql .= "FROM accesspoint a,accesspoint_i18n b  WHERE a.id = b.id AND 1 = 1 AND a.province IS NOT NULL AND a.updated_at >=  DATE_SUB(NOW(), INTERVAL 24 HOUR) ";
		if($this->owner != ''){
			$sql .= "AND b.post_by = '".$this->owner."' ";
		}
		if($province != null){
			$sql .= "AND a.province = '".$province."' ";
		}
		
		if(!empty($time) && isset($time['start'], $time['end'])){ 
			$sql .= "AND (a.created_at >= '".$time['start']."' AND a.created_at <= '".$time['end']."')";
		}
		
		$connection = Propel::getConnection();
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(2)[0];
	}

	public function getTotalUser($time = array())
	{
		$sql = "SELECT COUNT(C.id) AS total ";
		
		$sql .= "FROM customer AS C LEFT JOIN user AS U ON C.username = U.username WHERE 1 = 1 ";
		if($this->owner != ''){
			$sql .= "AND owner = '".$this->owner."' ";
		}
		if(!empty($time) && isset($time['start'], $time['end'])){ 
			$sql .= "AND (created_at >= '".$time['start']."' AND created_at <= '".$time['end']."')";
		}

		$connection = Propel::getConnection();
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(2)[0];
	}

	public function getTotalConnect($time = array(), $option = array())
	{
		$sql = "SELECT COUNT(TL.id) AS total ";
		
		$sql .= "FROM track_log AS TL LEFT JOIN accesspoint AS AC ON TL.ap_macaddr = AC.ap_macaddr WHERE 1 = 1 ";
		if($this->owner != ''){
			$sql .= "AND AC.owner = '".$this->owner."' ";
		}
		if(!empty($time) && isset($time['start'], $time['end'])){ 
			$sql .= "AND (TL.created_at >= '".$time['start']."' AND TL.created_at <= '".$time['end']."') ";
		}

		if(!empty($option)){
			foreach ($option as $key => $value) {
				$sql .= "AND {$key} = '".$value."' ";
			}
		}
		
		$connection = Propel::getConnection();
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(2)[0];
	}

	public function getTotalConnectOS($province = '', $time = array(), $os = null) {
        $sql = "SELECT SUM(count) AS total ";

        $sql .= "FROM report_platform WHERE 1 = 1 ";
        if($province != ''){
            $sql .= "AND province = '".$province."' ";
        }
        if(!empty($time) && isset($time['start'], $time['end'])){
            $sql .= "AND (time_created >= '".$time['start']."' AND time_created <= '".$time['end']."') ";
        }
        if($os != null){
            $sql .= "AND os = '".$os."' ";
        }
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(2)[0];
    }

    public function getTotalConnectBrowser($province = '', $time = array(), $browser = null) {
        $sql = "SELECT SUM(count) AS total ";

        $sql .= "FROM report_browser WHERE 1 = 1 ";
        if($province != ''){
            $sql .= "AND province = '".$province."' ";
        }
        if(!empty($time) && isset($time['start'], $time['end'])){
            $sql .= "AND (time_created >= '".$time['start']."' AND time_created <= '".$time['end']."') ";
        }
        if($browser != null){
            $sql .= "AND browser = '".$browser."' ";
        }
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(2)[0];
    }

	public function getDataIndex($_province = null, $time_ = array())
	{	
		$data = array();

		//$province 			= \AdvertiserBundle\Helper\ProvinceHelper::getProvince();
		//count($province);
		$data['province'] 	= $this->getCountProvince();

    	$ap_total 			= $this->getTotalAccessPoint($_province);
    	$ap_total_online 	= $this->getTotalAccessPointOnline($_province);
    	$user_total 		= $this->getTotalUser();

    	$data['ap_total']  	= $ap_total['total'];
    	$data['ap_total_online']  	= $ap_total_online['total'];
    	$data['user_total'] = $user_total['total'];

    	$conn_total 		= /*"n/a";*/$this->getTotalConnectOS($_province, $time_);
    	$conn_total_mobile 	= "n/a";//$this->getTotalConnect($time_, array('is_mobile' => 1));
    	$conn_total_pc 		= "n/a";//$this->getTotalConnect($time_, array('is_mobile' => 0));

    	$data['conn_total'] 		= /*"n/a";*/$conn_total['total'];
    	$data['conn_total_mobile'] 	= "n/a";//$conn_total_mobile['total'];
    	$data['conn_total_pc'] 		= "n/a";//$conn_total_pc['total'];

    	$conn_android 				= $this->getTotalConnectOS($_province, $time_, 'Android');//"n/a";//$this->getTotalConnect($time_, array('os' => 'Android'));
    	$conn_iphone 				= $this->getTotalConnectOS($_province, $time_, 'iPhone');//"n/a";//$this->getTotalConnect($time_, array('os' => 'iPhone'));
    	$conn_windows 				= $this->getTotalConnectOS($_province, $time_, 'Windows');//"n/a";//$this->getTotalConnect($time_, array('os' => 'Windows'));
    	$conn_windows_phone 		= $this->getTotalConnectOS($_province, $time_, 'Windows Phone');//"n/a";//$this->getTotalConnect($time_, array('os' => 'Windows Phone'));
    	$conn_ipad 					= $this->getTotalConnectOS($_province, $time_, 'iPad');//"n/a";//$this->getTotalConnect($time_, array('os' => 'iPad'));
    	$conn_macintosh 			= $this->getTotalConnectOS($_province, $time_, 'Macintosh');//"n/a";//$this->getTotalConnect($time_, array('os' => 'Macintosh'));
    	$conn_blackBerry 			= $this->getTotalConnectOS($_province, $time_, 'BlackBerry');//"n/a";//$this->getTotalConnect($time_, array('os' => 'BlackBerry'));

        var_dump($conn_android);

    	$data['conn_android'] 		= /*"n/a";*/$conn_android['total'];
    	$data['conn_iphone'] 		= /*"n/a";*/$conn_iphone['total'];
    	$data['conn_windows'] 		= /*"n/a";*/$conn_windows['total'];
    	$data['conn_windows_phone'] = /*"n/a";*/$conn_windows_phone['total'];
    	$data['conn_ipad'] 			= /*"n/a";*/$conn_ipad['total'];
    	$data['conn_macintosh'] 	= /*"n/a";*/$conn_macintosh['total'];
    	$data['conn_blackBerry'] 	= /*"n/a";*/$conn_blackBerry['total'];

        $conn_total['total'] = $data['conn_android'] + $data['conn_iphone'] + $data['conn_windows']
            + $data['conn_windows_phone'] + $data['conn_ipad'] 	+ $data['conn_macintosh'] + $data['conn_blackBerry'];
    	
    	$conn_browser_chrome 		= $this->getTotalConnectBrowser($_province, $time_, 'Chrome');//"n/a";//$this->getTotalConnect($time_, array('browser' => 'Chrome'));
    	$conn_browser_firefox 		= $this->getTotalConnectBrowser($_province, $time_, 'Firefox');//"n/a";//$this->getTotalConnect($time_, array('browser' => 'Firefox'));
    	$conn_browser_appleWebKit 	= $this->getTotalConnectBrowser($_province, $time_, 'AppleWebKit');//"n/a";//$this->getTotalConnect($time_, array('browser' => 'AppleWebKit'));
    	$conn_browser_safari 		= $this->getTotalConnectBrowser($_province, $time_, 'Safari');//"n/a";//$this->getTotalConnect($time_, array('browser' => 'Safari'));
    	$conn_browser_opera 		= $this->getTotalConnectBrowser($_province, $time_, 'Opera Next');//"n/a";//$this->getTotalConnect($time_, array('browser' => 'Opera Next'));
    	$conn_browser_ieMobile 		= $this->getTotalConnectBrowser($_province, $time_, 'IEMobile');//"n/a";//$this->getTotalConnect($time_, array('browser' => 'IEMobile'));
    	$conn_browser_uc 			= $this->getTotalConnectBrowser($_province, $time_, 'UC Browser');//"n/a";//$this->getTotalConnect($time_, array('browser' => 'UC Browser'));

    	$data['conn_browser_chrome'] 		= /*"n/a";*/$conn_browser_chrome['total'];
    	$data['conn_browser_firefox'] 		= /*"n/a";*/$conn_browser_firefox['total'];
    	$data['conn_browser_appleWebKit'] 	= /*"n/a";*/$conn_browser_appleWebKit['total'];
    	$data['conn_browser_safari'] 		= /*"n/a";*/$conn_browser_safari['total'];
    	$data['conn_browser_opera'] 		= /*"n/a";*/$conn_browser_opera['total'];
    	$data['conn_browser_ieMobile'] 		= /*"n/a";*/$conn_browser_ieMobile['total'];
    	$data['conn_browser_uc'] 			= /*"n/a";*/$conn_browser_uc['total'];

    	
    	$data['android']	 	= /*"n/a";*/$conn_total['total'] > 0 ? round($conn_android['total']/$conn_total['total']*100, 2) : 0;
    	$data['iphone'] 		= /*"n/a";*/$conn_total['total'] > 0 ? round($conn_iphone['total']/$conn_total['total']*100, 2) : 0;
    	$data['windows'] 		= /*"n/a";*/$conn_total['total'] > 0 ? round($conn_windows['total']/$conn_total['total']*100, 2) : 0;
    	$data['windows_phone'] 	= /*"n/a";*/$conn_total['total'] > 0 ? round($conn_windows_phone['total']/$conn_total['total']*100, 2) : 0;
    	$data['blackBerry'] 	= /*"n/a";*/$conn_total['total'] > 0 ? round($conn_blackBerry['total']/$conn_total['total']*100, 2) : 0;
    	$data['other_platform'] = /*"n/a";*/$conn_total['total'] > 1 ? 100 - $data['android'] - $data['iphone'] - $data['windows'] - $data['windows_phone'] - $data['blackBerry'] : 0;

    	$data['chrome']	 		= /*"n/a";*/$conn_total['total'] > 0 ? round($conn_browser_chrome['total']/$conn_total['total']*100, 2) : 0;
    	$data['firefox']	 	= /*"n/a";*/$conn_total['total'] > 0 ? round($conn_browser_firefox['total']/$conn_total['total']*100, 2) : 0;
    	$data['appleWebKit']	= /*"n/a";*/$conn_total['total'] > 0 ? round($conn_browser_appleWebKit['total']/$conn_total['total']*100, 2) : 0;
    	$data['safari']			= /*"n/a";*/$conn_total['total'] > 0 ? round($conn_browser_safari['total']/$conn_total['total']*100, 2) : 0;
    	$data['opera']			= /*"n/a";*/$conn_total['total'] > 0 ? round($conn_browser_opera['total']/$conn_total['total']*100, 2) : 0;
    	$data['other_browser']	= /*"n/a";*/$conn_total['total'] > 1 ? 100 - $data['chrome']	- $data['firefox'] - $data['appleWebKit'] - $data['safari'] - $data['opera'] : 0;

    	return $data;
	}

	public function getTotalAdvertiser($province = null, $time = array())
	{
		$sql = "SELECT COUNT(a.id) AS total ";
		
		$sql .= "FROM advert a, advert_i18n b WHERE a.id=b.id AND  1 = 1 AND location IS NOT NULL ";
		if($province != null){
			$sql .= "AND a.location LIKE '%".$province."%' ";
		}
		if($this->customer_id != ''){
			$sql .= "AND a.customer_id = ".$this->customer_id." ";
		}
        if($this->owner != ''){
            $sql .= "AND b.post_by = '".$this->owner."' ";
        }
		if(!empty($time) && isset($time['start'], $time['end'])){ 
			$sql .= "AND (created_at >= '".$time['start']."' AND created_at <= '".$time['end']."')";
		} 
		
		$connection = Propel::getConnection();
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(2)[0];
	}

	public function getAdvRunInTime($province = null, $time = array()) {
        $sql = "SELECT COUNT(DISTINCT c.advert_id) AS total  ";

        $sql .= "FROM advert a,advert_i18n b RIGHT JOIN ads_daily_counting c on b.id = c.advert_id ";

        $sql .= "WHERE a.id = b.id AND b.locale = 'vi' ";
        if($this->customer_id != ''){
            $sql .= "AND a.customer_id = ".$this->customer_id." ";
        }
        if($this->owner != ''){
            $sql .= "AND b.post_by = '".$this->owner."' ";
        }
        if($province != null){
            $sql .= "AND a.location LIKE '%".$province."%' ";
        }

        if(!empty($time) && isset($time['start'], $time['end'])){
            $sql .= "AND (c.date >= '".$time['start']."' AND c.date <= '".$time['end']."') ";
        }


        $sql .= "ORDER BY c.advert_id";

        $connection = Propel::getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(2)[0];
        return $result;
    }

    public function getTotalRunningAds($province = null, $time = array()) {
        $sql = "SELECT COUNT(a.id) AS total ";

        $sql .= "FROM advert a, advert_i18n b WHERE a.id=b.id AND  1 = 1 AND location IS NOT NULL AND (b.locked=0 or b.locked is null) ";
        if($province != null){
            $sql .= "AND a.location LIKE '%".$province."%' ";
        }
        if($this->customer_id != ''){
            $sql .= "AND a.customer_id = ".$this->customer_id." ";
        }
        if($this->owner != ''){
            $sql .= "AND b.post_by = '".$this->owner."' ";
        }
        if(!empty($time) && isset($time['start'], $time['end'])){
            $sql .= "AND (published_at <= '".date('Y-m-d', time())."' AND expired_at <= '".date('Y-m-d', time())."')";
        }

        $connection = Propel::getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(2)[0];
    }

	public function getChartLineAds($province = null, $time = array())
	{
		
		$sql = "SELECT IFNULL(SUM(c.view_count),0) as impression, IFNULL(SUM(c.click_count),0) as click,c.date as date  ";
		
		$sql .= "FROM advert a,advert_i18n b RIGHT JOIN ads_daily_counting c on b.id = c.advert_id ";
		
		$sql .= "WHERE a.id = b.id AND b.locale = 'vi' ";
		if($this->customer_id != ''){
			$sql .= "AND a.customer_id = ".$this->customer_id." ";
		}
        if($this->owner != ''){
            $sql .= "AND b.post_by = '".$this->owner."' ";
        }
		if($province != null){
			$sql .= "AND a.location LIKE '%".$province."%' ";
		}
		
		if(!empty($time) && isset($time['start'], $time['end'])){ 
			$sql .= "AND (c.date >= '".$time['start']."' AND c.date <= '".$time['end']."') ";
		}


		$sql .= "GROUP BY DATE(c.date) ORDER BY c.date"; 
		
		$connection = Propel::getConnection();
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(2);

		$total_imp = 0;
		$total_click = 0;

		$data = array();

		$impression = new \stdClass();
		$impression->type = 'spline';
		$impression->showInLegend = true;
		$impression->name = 'Impression';

		$data_im = array();

		$click = new \stdClass();
		$click->type = 'spline';
		$click->showInLegend = true;
		$click->name = 'Click';

		$data_cl = array();

		foreach ($result as $key => $value) {
			$pxy_i = new \stdClass();
			$pxy_i->label = $value['date'];
			$pxy_i->y = (int)$value['impression'];
			

			$pxy_c = new \stdClass();
			$pxy_c->label = $value['date'];
			$pxy_c->y = (int)$value['click'];

			$data_im[] = $pxy_i;
			$data_cl[] = $pxy_c;

			$total_imp += $value['impression'];
			$total_click += $value['click'];
		}

		$impression->dataPoints = $data_im;
		$click->dataPoints = $data_cl;

		$data[] = $impression; $data[] = $click; 

		return array('chart' => json_encode($data), 'impression' => $total_imp, 'click' => $total_click);
	}

	public function getCountProvince(){

		if($this->owner != ''){
			$sql = "SELECT a.province ";
		
			$sql .= "FROM accesspoint a,accesspoint_i18n b  WHERE a.id = b.id AND 1 = 1 AND a.province IS NOT NULL ";
			if($this->owner != ''){
				$sql .= "AND b.post_by = '".$this->owner."' ";
			}
			
			$sql .= "GROUP BY a.province";
			
			
			$connection = Propel::getConnection();
			$stmt = $connection->prepare($sql);
			$stmt->execute();
			return count($stmt->fetchAll(2));
		}else{
			$province 			= \AdvertiserBundle\Helper\ProvinceHelper::getProvince();
			return count($province);
		}
	}

	public function getProvince(){
		$province 			= \AdvertiserBundle\Helper\ProvinceHelper::getProvince();
		$list = array();
		if($this->owner != ''){
			$sql = "SELECT province ";
		
			$sql .= "FROM accesspoint WHERE 1 = 1 AND province IS NOT NULL ";
			//if($this->owner != ''){
			//	$sql .= "AND owner = '".$this->owner."' ";
			//}
			
			$sql .= "GROUP BY province"; 
			
			
			$connection = Propel::getConnection();
			$stmt = $connection->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(2);

			foreach ($result as $key => $value) {
				$list[$value['province']] = $province[$value['province']];
			}
			return $list;
		}else{
			//$province 			= \AdvertiserBundle\Helper\ProvinceHelper::getProvince();
			return $province;
		}
	}

	public function getChartLineAds2($province = null, $time = array())
	{
		
		$sql = "SELECT IFNULL(SUM(c.view_count),0) as impression, IFNULL(SUM(c.click_count),0) as click,c.date as date  ";
		
		$sql .= "FROM advert a,advert_i18n b RIGHT JOIN ads_daily_counting c on b.id = c.advert_id ";
		
		$sql .= "WHERE a.id = b.id AND b.locale = 'vi' ";
		if($this->customer_id != ''){
			$sql .= "AND a.customer_id = ".$this->customer_id." ";
		}
        if($this->owner != ''){
            $sql .= "AND b.post_by = '".$this->owner."' ";
        }
		if($province != null){
			$sql .= "AND a.location LIKE '%".$province."%' ";
		}
		
		if(!empty($time) && isset($time['start'], $time['end'])){ 
			$sql .= "AND (c.date >= '".$time['start']."' AND c.date <= '".$time['end']."') ";
		}


		$sql .= "GROUP BY DATE(c.date) ORDER BY c.date"; 
		
		$connection = Propel::getConnection();
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(2);

		$data = array();
		$total_imp = 0;
		$total_click = 0;

		foreach ($result as $key => $value) {
			$total_imp += $value['impression'];
			$total_click += $value['click'];
		}

		$data['result'] = $result;
		$data['impression'] = $total_imp;
		$data['click'] = $total_click;

		return $data;
	}

}