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
use Common\DbBundle\Model\CustomerQuery;
use Hotspot\AccessPointBundle\Model\UserDataCollection;
use Hotspot\AccessPointBundle\Model\UserDataCollectionQuery;
use Hotspot\AccessPointBundle\Model\AccesspointQuery;

class AdvertiserHelper
{
	static public function getAdsReport($customer_id,$params,$post_by=null){
		$from_0	= $params["from_0"];
		$to = $params["to"];

		$query="(select b.title, b.id, b.link_to,IFNULL(sum(c.view_count),0) as impression, IFNULL(sum(c.click_count),0) as click, 
		c.date as `date` 
           from advert a,advert_i18n b
		right join ads_daily_counting c
		on b.id=c.advert_id
		and (c.`date` >= '$from_0' AND  c.`date`<='$to')
		where a.id=b.id
		and b.locale='vi' ";
        if(empty($post_by))
            $query=$query." and a.customer_id=".$customer_id;
        else{
            $query=$query." and b.post_by='".$post_by."'";
        }
		$query= $query." group by b.title, b.id, b.link_to
		order by b.id)";
		
		$query .= isset($params['offset']) && isset($params['limit']) ? " LIMIT {$params['offset']} {$params['limit']}" : "";

		$connection = Propel::getConnection();
		$stmt = $connection->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(2);
	}

	static public function getAdsReportTotal($userName,$params){
		$from_0	= $params["from_0"];
		$to = $params["to"];

		$query="(select b.id
           from advert a,advert_i18n b
		right join ads_daily_counting c
		on b.id=c.advert_id
		and (c.`date` >= '$from_0' AND  c.`date`<='$to')
		where a.id=b.id
		and b.locale='vi'
		and a.customer_id=(select `id` from customer where `username`='".$userName."')
		group by b.title, b.id, b.link_to
		order by b.id)";

		$connection = Propel::getConnection();
		$stmt = $connection->prepare($query);
		$stmt->execute(); 
		return count($stmt->fetchAll(2));
	}

	static function getAdsReportApMac($ap_mac, $params){

		$query="(select b.title, b.id, b.link_to,IFNULL(sum(c.view_count),0) as impression, IFNULL(sum(c.click_count),0) as click, 
			c.ap_macaddr
           from advert a,advert_i18n b
		right join ads_daily_counting c
		on b.id=c.advert_id
		where a.id=b.id
		and b.locale='vi'
		and c.ap_macaddr = '".$ap_mac."'
		group by b.title, b.id, b.link_to
		order by b.id) LIMIT {$params['offset']},{$params['limit']}";

		$connection = Propel::getConnection();
		$stmt = $connection->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(2);
	}

	static function getAdsReportApMacTotal($ap_mac, $params){

		$query="(select b.title, b.id, b.link_to,IFNULL(sum(c.view_count),0) as impression, IFNULL(sum(c.click_count),0) as click, 
			c.ap_macaddr
           from advert a,advert_i18n b
		right join ads_daily_counting c
		on b.id=c.advert_id
		where a.id=b.id
		and b.locale='vi'
		and c.ap_macaddr = '".$ap_mac."'
		group by b.title, b.id, b.link_to
		order by b.id)";

		$connection = Propel::getConnection();
		$stmt = $connection->prepare($query);
		$stmt->execute();
		return count($stmt->fetchAll(2));
	}
	static function approveAds(){
	    $query="truncate table  ads_distribution;";
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();


        //$query ="insert into `ads_distribution` (advert_id,ratio,location,platform)  (select id,ratio,location,platform from advert where `view_at_homepage`=1);";
		$query="insert into `ads_distribution` (advert_id,ratio,location,platform)  (select advert.id,ratio,location,platform from advert,advert_i18n where advert.id=advert_i18n.id and advert_i18n.locked=0);";
        $stmt = $connection->prepare($query);
        $stmt->execute();
    }
    static function getAdvertByCustomerAndLocation($customer_id, $province) {
	    $query = "SELECT * FROM advert WHERE customer_id = ".$customer_id." AND location LIKE '%".$province."%'";
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return count($stmt->fetchAll(2));
    }

    static public function getUserLoginReport($isAdmin,$params,$strListAccessPoint){
        $from_0	= $params["from_0"];
        $to = $params["to"];

        $query="SELECT * FROM user_login WHERE DATE(created_at) >= '" . $from_0 . "' AND DATE(created_at) <= '" . $to . "' ";
        if (!$isAdmin && $strListAccessPoint != '') {
            $query .= "AND ap_macaddr IN (" . $strListAccessPoint . ")";
        }

        $query .= isset($params['offset']) && isset($params['limit']) ? " LIMIT {$params['offset']} {$params['limit']}" : "";
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(2);
    }
}