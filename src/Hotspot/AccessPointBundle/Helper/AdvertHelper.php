<?php

namespace Hotspot\AccessPointBundle\Helper;

use Hotspot\AccessPointBundle\Model\AdsDistribution;
use Hotspot\AccessPointBundle\Model\AdsDistributionQuery;
use Hotspot\AccessPointBundle\Model\ApConfig;
use Hotspot\AccessPointBundle\Model\Base\AdsDailyCountingQuery;
use Hotspot\AccessPointBundle\Model\Base\ApConfigQuery;
use Hotspot\AccessPointBundle\Model\Base\TrackLogQuery;
use SunCat\MobileDetectBundle\DeviceDetector\MobileDetector;
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
use Symfony\Component\HttpFoundation\Request;

class AdvertHelper{
	static public function updateRead($id, $lang)
	{
		$connection = Propel::getConnection();
	
		$query = "UPDATE %s SET %s=%s+1 WHERE %s=? AND %s=?";
		$query = sprintf($query,
				'advert_i18n',
					
				'advert_i18n.READ',
				'advert_i18n.READ',
	
				'advert_i18n.LOCALE',
				'advert_i18n.ID'
					
				);
		$stmt = $connection->prepare($query);
	
		$stmt->bindValue(1,$lang);
		$stmt->bindValue(2,$id,PDO::PARAM_INT);
	
		$stmt->execute();
	
		$query = "UPDATE %s SET %s=%s+1 WHERE %s=? AND %s=?";
		$query = sprintf($query,
				'advertcache',
					
				'advertcache.READ',
				'advertcache.READ',
	
				'advertcache.LOCALE',
				'advertcache.ADVERT_ID'
					
				);
	
		//$query = "SELECT ?,?,?,?,?,?,?,? FROM ?,? WHERE ?=? AND ?=? AND ?=? AND ?=? ORDER BY ?";
		$stmt = $connection->prepare($query);
	
		$stmt->bindValue(1,$lang);
		$stmt->bindValue(2,$id,PDO::PARAM_INT);
	
		$stmt->execute();
	}
	static public function writeRequestLog($params)
    {
		/*
		 * temporary pause this feature

        $query = AdsLogQuery::create()
            ->filterByApMacaddr($params['called'])
            ->filterByDeviceMacaddr($params['mac'])
            ->filterByDeviceIp($params['ip'])
            ->filterByWanIp($params['wan_ip'])
            ->filterByPhase($params['phase']);
        if (array_key_exists('challenge', $params)) {
            $query->filterByApSessionid($params['challenge']);
        }
        $adsLog = $query->findOne();
        if ($adsLog == null)
            $adsLog = new AdsLog();

        if (array_key_exists('called', $params))
            $adsLog->setApMacaddr($params['called']);
        if (array_key_exists('mac', $params))
            $adsLog->setDeviceMacaddr($params['mac']);
        $adsLog->setDevice(null);
        if (array_key_exists('wan_ip', $params))
            $adsLog->setWanIp($params['wan_ip']);
        if (array_key_exists('ip', $params))
            $adsLog->setDeviceIp($params['ip']);
        if (array_key_exists('challenge', $params))
            //$trackLog->setApSessionid($params['sessionid']);
            $adsLog->setApSessionid($params['challenge']);
        if (array_key_exists('web_session', $params))
            $adsLog->setWebSession($params['web_session']);
        if (array_key_exists('adsCookie', $params))
            $adsLog->setWebSession($params['adsCookie']);
        if (array_key_exists('userurl', $params))
            $adsLog->setUserUrl($params['userurl']);
        if (array_key_exists('isMobile', $params))
            $adsLog->setIsMobile($params['isMobile']);
        if (array_key_exists('os', $params))
            $adsLog->setOs($params['os']);
        if (array_key_exists('browser', $params))
            $adsLog->setBrowser($params['browser']);
        if (array_key_exists('userAgent', $params))
            $adsLog->setUserAgent($params['userAgent']);
        if (array_key_exists('phase', $params))
            $adsLog->setPhase($params['phase']);
        $adsLog->save();
		*/
        /////
        ///////////////
        if ($params['phase'] == 'login') {
            $adsCount = AdsDailyCountingQuery::create()
                ->filterByAdvertId(-1)
                ->filterByApMacaddr($params['called'])
                ->filterByDate(date('Y-m-d'))
                ->findOneOrCreate();
            //if($params['phase']=='view_login')
            //    $adsCount->setClickCount($adsCount->getClickCount()+1);
            //if ($params['phase'] == 'success')
            $adsCount->setClickCount($adsCount->getClickCount() + 1);
            $adsCount->setApMacaddr($params['called']);
            $adsCount->save();
        }
	}
	static public function writeTrackLog($params){
		/*
		 * temporary pause this feature

		$trackLog = new TrackLog();
		if(array_key_exists('called',$params))
			$trackLog->setApMacaddr($params['called']);
		if(array_key_exists('mac',$params))
			$trackLog->setDeviceMacaddr($params['mac']);
		$trackLog->setDevice(null);
		if(array_key_exists('wan_ip',$params))
			$trackLog->setWanIp($params['wan_ip']);
		if(array_key_exists('ip',$params))
			$trackLog->setDeviceIp($params['ip']);
		if(array_key_exists('id',$params))
			$trackLog->setAdsId($params['id']);
		if(array_key_exists('sessionid',$params))
			$trackLog->setApSessionid($params['sessionid']);
		if(array_key_exists('web_session',$params))
			$trackLog->setWebSession($params['web_session']);
		if(array_key_exists('adsCookie',$params))
			$trackLog->setWebSession($params['adsCookie']);
		if(array_key_exists('userurl',$params))
			$trackLog->setUserUrl($params['userurl']);
		if(array_key_exists('isMobile',$params))
			$trackLog->setIsMobile($params['isMobile']);
		if(array_key_exists('os',$params))
			$trackLog->setOs($params['os']);
		if(array_key_exists('browser',$params))
			$trackLog->setBrowser($params['browser']);
		if(array_key_exists('userAgent',$params))
			$trackLog->setUserAgent($params['userAgent']);
		if(array_key_exists('phase',$params))
			$trackLog->setPhase($params['phase']);
		$trackLog->save();
		*/
        //
        ///////////////

        $adsCount=AdsDailyCountingQuery::create()
            ->filterByAdvertId($params['id'])
            ->filterByApMacaddr($params['called'])
            ->filterByDate(date('Y-m-d'))
            ->findOneOrCreate();
        if($params['phase']=='click_ads')
            $adsCount->setClickCount($adsCount->getClickCount()+1);
        if($params['phase']=='view_ads')
            $adsCount->setViewCount($adsCount->getViewCount()+1);
        $adsCount->setApMacaddr($params['called']);
        $adsCount->save();

	}
    static public function getWantedDisplayAds($params){
        //$ap_macaddr_order=array("'".$params["called"]."'","'".UtilHelper::add1ToMac($params['called'])."'","'".UtilHelper::subtract1ToMac($params['called'])."'");
        //$ap_macaddr_order=array("'".$params["called"]."'");
        $ap_macaddr_order=array("'".$params["called"]."'","'".UtilHelper::subtract1ToMac($params['called'])."'");
        //$ap_macaddr=array($params["called"],UtilHelper::add1ToMac($params['called']),UtilHelper::subtract1ToMac($params['called']));
        //$ap_macaddr=array($params["called"]);
        $ap_macaddr=array($params["called"],UtilHelper::subtract1ToMac($params['called']));
        $ap=AccesspointQuery::create()
            ->filterByApMacaddr($ap_macaddr,Criteria::IN)
            ->joinWithI18n('vi')
            //->orderBy('accesspoint.ap_macaddr',Criteria::DESC)
            ->addOrderByField('accesspoint.ap_macaddr', $ap_macaddr_order)
            ->findOne();

        if(empty($ap)) return null;
        $location=$ap->getAdsLocation();
        $mac_location=$ap->getMacaddr();
        if(empty($ap->getAdsLocation())) {
            //Neu accesspoint do khong co config ads_location thi lay location bang province ma acesspoint đặt
            $location = $ap->getProvince();
            $mac_location = $ap->getMacaddr();
        }
        //os này parse từ user-agent
        $os=$params['os'];
        //Query tu bang ads_distribution
        $ads=AdsDistributionQuery::create()
            ->withColumn('current/(ratio+0.00001)', 'current_fix')
            ->where("(locate('$location',location)>0 or locate('$mac_location',location)>0)")
            ->where("(locate('$os',platform)>0 or platform ='' or platform is null)")
            //->orderByCurrent(Criteria::ASC)
            ->orderBy('current_fix',Criteria::ASC)
            ->find();
//        dump($ads);
        /** @var AdsDistribution $ad */
        foreach ($ads as $ad){
            $apLocation=null;
            $id=$ad->getAdvertId();
            //dump($id);
            $adv=AdvertQuery::create()
                ->joinWithI18n('vi',Criteria::INNER_JOIN)
                ->filterByViewAtHomepage(1)
                ->where('(advert_i18n.locked is null or advert_i18n.locked = 0)')
                ->filterById($id)
                ->findOne();
            if($adv) {
                $apLocation = explode(";",$adv->getLocation());
                //dump($apLocation);
                if (!empty($apLocation)) {
                    if (in_array($location,$apLocation) || in_array($mac_location,$apLocation)) {
                        //Giới hạn 1 ngày click bao nhiêu lần, hiển thị bao nhiêu lần, quảng cáo nào thỏa mãn limit mới cho hiện
                        if(self::isDailyLimit($adv->getId())==false) {
                            //dump($apLocation);
                            //dump($adv);
                            return $adv;
                        }
                        else
                            continue;
                    }
                    else
                        continue;
                } else
                    return $adv;
            }
        }
        return null;
    }
	static public function getAds($params){
        //$ap_macaddr_order=array("'".$params["called"]."'","'".UtilHelper::add1ToMac($params['called'])."'","'".UtilHelper::subtract1ToMac($params['called'])."'");
        //$ap_macaddr_order=array("'".$params["called"]."'");
        $ap_macaddr_order=array("'".$params["called"]."'","'".UtilHelper::subtract1ToMac($params['called'])."'");
        //$ap_macaddr=array($params["called"],UtilHelper::add1ToMac($params['called']),UtilHelper::subtract1ToMac($params['called']));
        //$ap_macaddr=array($params["called"]);
        $ap_macaddr=array($params["called"],UtilHelper::subtract1ToMac($params['called']));

        //$apLocation = explode(";",$adv->getLocation());
        //var_dump($params);
		if(array_key_exists('limit',$params))
			$limit=$params['limit'];
		else 
			$limit=1;
        $ap=AccesspointQuery::create()
            ->filterByApMacaddr($ap_macaddr,Criteria::IN)
            ->joinWithI18n('vi')
            ->addOrderByField('accesspoint.ap_macaddr', $ap_macaddr_order)
            ->findOne();
		if(empty($ap)) return null;

        $location=$ap->getAdsLocation();
        $mac_location=$ap->getMacaddr();
        if(empty($ap->getAdsLocation())) {
            $location = $ap->getProvince();
            $mac_location = $ap->getMacaddr();
        }
        $os=$params['os'];
        //
		$ads=AdvertQuery::create()
            ->addAnd('advert.HOME_POSITION',$params['position'])
            ->addAnd('advert.VIEW_AT_HOMEPAGE',1)
            ->joinAdvertI18n('vi', Criteria::INNER_JOIN)
            ->where('(advert_i18n.locked=0 or advert_i18n.locked is null)')
            ->addAnd('advert.PUBLISHED_AT', time(),Criteria::LESS_EQUAL)
            ->addAnd('advert.EXPIRED_AT', time(),Criteria::GREATER_EQUAL)
            //->where('( INSTR(advert.location,"'.$location.'")>0 or INSTR(advert.location,"'.$mac_location.'")>0 )')
            ->where("(locate('$location',advert.location)>0 or locate('$mac_location',advert.location)>0)")
            ->where("(locate('$os',advert.platform)>0 or advert.platform ='' or advert.platform is null)")
            //->where('(ads_distribution.is_showing=?) and  (advert.LOCATION is null or trim(advert.location)="" or advert.LOCATION=?)',"1",$location)
            //->where('(advert.LOCATION is null or trim(advert.location)="" or advert.LOCATION=?)',$location)
            ->where('advert.id in (select advert_id from ads_distribution where advert_id=advert.id and ads_distribution.is_showing=?)',1)
            ->addAscendingOrderByColumn('rand()')
            ->addDescendingOrderByColumn('advert.id')
            ->limit($limit)
            ->find();
		//dump($ads);
        if(count($ads)==0) return null;
		//$pager	=	$query->paginate($page, $pageSize);
		foreach ($ads as $ad){
			$links=explode("|",$ad->getLinkTo());
			if($params['os']=='Android'){
				$ad->setLink($links[count($links)-1]);
			}
			else{
				$ad->setLink($links[0]);
			}
			if(trim($params['called'])=='EC-08-6B-6E-E0-CD' || trim($params['called'])=='EC-08-6B-6E-E0-CE'){
				if($ad->getId()==48 || $ad->getId()==49)
					return null;
			}
			if(trim($params['called'])=='EC-08-6B-6E-C2-47' || trim($params['called'])=='EC-08-6B-6E-C2-48'){
				if($ad->getId()==48 || $ad->getId()==49)
					return null;
			}
			if(trim($params['called'])=='18-A6-F7-53-C1-5F' || trim($params['called'])=='18-A6-F7-53-C1-60'){
				if($ad->getId()==48 || $ad->getId()==49)
					return null;
			}
		}
		return ($ads);
	}
    static public function getAds_Dev($params){
        //var_dump($params);
        if(array_key_exists('limit',$params))
            $limit=$params['limit'];
        else
            $limit=1;
        $ap=AccesspointQuery::create()
            ->filterByApMacaddr(array($params['called'],UtilHelper::add1ToMac($params['called']),UtilHelper::subtract1ToMac($params['called'])),Criteria::IN)
            ->joinWithI18n('vi')
            ->findOne();
        if(empty($ap)) return null;
        $location='';
        //if(!empty($ap->getProvince())) $location=$ap->getProvince();
        $ads=AdvertQuery::create()
            ->addAnd('advert.HOME_POSITION',$params['position'])
            ->joinWithI18n('vi', Criteria::INNER_JOIN)
            ->addAnd('advert.PUBLISHED_AT', time(),Criteria::LESS_EQUAL)
            ->addAnd('advert.EXPIRED_AT', time(),Criteria::GREATER_EQUAL)
            //->where('(advert.LOCATION is null or trim(advert.location)="" or advert.LOCATION=?)',$location)
            ->addAscendingOrderByColumn('rand()')
            ->addDescendingOrderByColumn('advert.id')
            ->limit($limit)
            ->find();

        //$pager	=	$query->paginate($page, $pageSize);
        foreach ($ads as $ad){
            $links=explode("|",$ad->getLinkTo());
            if($params['os']=='Android'){
                $ad->setLink($links[count($links)-1]);
            }
            else{
                $ad->setLink($links[0]);
            }
        }
        //dump($ads);
        return ($ads);
    }
	static public function getAdvLink($advertId,$params){
		$adv=AdvertQuery::create()
		->joinWithI18n('vi', Criteria::INNER_JOIN)
		->addAnd('advert.PUBLISHED_AT', time(),Criteria::LESS_EQUAL)
		->addAnd('advert.EXPIRED_AT', time(),Criteria::GREATER_EQUAL)
		->filterById($advertId)
		->findOne();
		//$pager	=	$query->paginate($page, $pageSize);
		if($adv){
            $platforms=explode(";",$adv->getPlatform());
			$links=explode("|",$adv->getLinkTo());
			if(trim($params['os'])=='Android'){
				$adv->setLink($links[count($links)-1]);
			}
			else{
				$adv->setLink($links[0]);
			}
		}
		if($adv && !empty($adv->getLink())) {
            if($adv->getLink()!='[user_url]')
                return "/ap/go.html?id=" . trim($adv->getId()) . "&link=" . trim(urlencode(trim($adv->getLink()))) . "&called=" . $params['called'] . "&mac=" . $params['mac'] . "&ip=" . $params['ip'] . "&userurl=" . htmlspecialchars($params['userurl']);
            else{
                //return '[user_url]';
                return "/ap/go.html?id=" . trim($adv->getId()) . "&link=" . trim(urlencode(trim($adv->getLink()))) . "&called=" . $params['called'] . "&mac=" . $params['mac'] . "&ip=" . $params['ip'] . "&userurl=" . htmlspecialchars($params['[user_url]']);
            }
        }
		else 
			return "";
	}
	static public function getAdsmeeLink($params,$api_service){
        /*
	    $apInfo=AccesspointQuery::create()
            ->filterByMacaddr($params['called'])
            ->findOne();
        */
        $apInfo=AccesspointQuery::create()->filterByApMacaddr(array($params['called'],UtilHelper::add1ToMac($params['called']),UtilHelper::subtract1ToMac($params['called'])),Criteria::IN)
            ->joinWithI18n('vi',Criteria::INNER_JOIN)
            ->findOne();
        if($apInfo){
            $accesspoint_id="1";
            $ip=$params['wan_ip'];
            $ssid=$apInfo->getSsid();
            $fullname=$apInfo->getApMacaddr();
            $address=$apInfo->getAddress().",".$apInfo->getProvince();
            $geo=$apInfo->getLat().",".$apInfo->getLng();
            $status="ON";
            //{"status":true,"message":"http:\/\/portal.wbonus.net\/pub?pubid=32"}
            $json_decode = $api_service->getAdsmeeLinkPortal($accesspoint_id, $ssid, $fullname,$ip, $address,$geo,$status);
            //var_dump($json_decode);
            //var_dump($json_decode['message']);
            if(!empty($json_decode) && $json_decode['status']==true){

                //return $json_decode['message'];
                return "/ap/go.html?id="."1000"."&link=".trim($json_decode['message'])."&called=".$params['called']."&mac=".$params['mac']."&ip=".$params['ip']."&userurl=".htmlspecialchars($params['userurl']);
            }

        }
        return "";
    }
	static public function saveUserEmail($email,$params=null){
		if(trim($email)=="" || empty($params)) return;
        if(!self::checkEmailCollection($params)) return;

		$userData=UserDataCollectionQuery::create()
            ->filterByData(trim($email))
            ->filterByAdvertId($params['advertId'])
            ->findOne();
		if($userData==null){
			$userData=new UserDataCollection();
			$userData->setData(trim($email))->setAdvertId($params['advertId'])->setDeviceMac($params['mac'])->save();
		}
	}
    static public function checkEmailCollection($params=array()){
        if(UserDataCollectionQuery::create()
                ->filterByDeviceMac($params['mac'])
                ->filterByAdvertId(array(130,131,132,133,134,135),Criteria::IN)
                ->count()
            >0) return false;
        return true;
    }
	static public function getAdvImg($id,$params){
	    //var_dump($link);
		$adv=AdvertQuery::create()
            ->filterById($id)
            ->joinWithI18n('vi', Criteria::INNER_JOIN)
            //->addAnd('advert.HOME_POSITION',$params['position'])
            ->addAnd('advert.PUBLISHED_AT', time(),Criteria::LESS_EQUAL)
            ->addAnd('advert.EXPIRED_AT', time(),Criteria::GREATER_EQUAL)
            ->findOne();
            //->addAnd('advert_i18n.link_to', trim($link),Criteria::EQUAL)
            //->findOne();
        //$pager	=	$query->paginate($page, $pageSize);
        if($adv)
            if(key_exists('img_pos',$params) && $params['img_pos']==2)
                return trim($adv->get2ndImage());
            else
                return trim($adv->get1stImage());
        else
            return "";
	}
    static public function getAdvImg2($link,$params){
        $adv=AdvertQuery::create()
            ->joinWithI18n('vi', Criteria::INNER_JOIN)
            ->addAnd('advert.HOME_POSITION',$params['position'])
            ->addAnd('advert.PUBLISHED_AT', time(),Criteria::LESS_EQUAL)
            ->addAnd('advert.EXPIRED_AT', time(),Criteria::GREATER_EQUAL)
            ->addAnd('advert_i18n.link_to', trim($link),Criteria::EQUAL)
            ->findOne();
        //$pager	=	$query->paginate($page, $pageSize);
        if($adv)
            return trim($adv->get2ndImage());
        else
            return "";
    }
    static public function getAdvById($id){
        return AdvertQuery::create()
            ->joinWithI18n('vi', Criteria::INNER_JOIN)
            ->filterById($id)
            ->findOne();
    }
	static public function countAdsDisplay($id){
	    /*
        $adsCount=AdsDailyCountingQuery::create()
            ->filterByAdvertId($id)
            ->filterByDate(date('Y-m-d'))
            ->findOneOrCreate();
        return $adsCount->getViewCount();
	    */
        $adsCount=AdsDailyCountingQuery::create()
            ->filterByAdvertId($id)
            ->filterByDate(date('Y-m-d'))
            ->withColumn('sum(view_count)','view')
            ->select(array('advert_id','date','view'))
            ->findOne();
        if(!empty($limit) && count($adsCount)>0)
            return $adsCount['view'];
        else
            return 0;
    }
    static public function countAdsClick($id){
        $adsCount=AdsDailyCountingQuery::create()
            ->filterByAdvertId($id)
            ->filterByDate(date('Y-m-d'))
            ->findOneOrCreate();
        return $adsCount->getClickCount();
    }
    static public function isDailyLimit($id){
        $adsCount=AdsDailyCountingQuery::create()
            ->filterByAdvertId($id)
            ->filterByDate(date('Y-m-d'))
            ->withColumn('sum(click_count)','click')
            ->select(array('advert_id','date','click'))
            ->findOne();
        //dump($adsCount);
        $adv=AdvertQuery::create()
            ->filterById($id)
            ->findOne();
        $limit=null;
        if(count($adv)>0)
            $limit=$adv->getDailyLimit();

        //dump($limit);
        //var_dump($adsCount);
        //dump($adsCount['click']);
        if(!empty($limit) && count($adsCount)>0) {
            $dd=AdsDistributionQuery::create()
                ->filterByAdvertId($id)
                ->findOne();
            if($dd) {
                $isShowing=0;
                if($adsCount['click'] < $limit) $isShowing=1;
                $dd->setIsShowing($isShowing)->save();
            }
            return $adsCount['click'] >= $limit;
        }
        else {
            //dump($adsCount['click']);
            return false;
        }
    }
    public static function writeDirectClickTrack(Controller $controller, Request $request, $in_params){
        $redirUrl=$in_params['redirurl'];
        if(strpos($redirUrl, "/")===0  )	$redirUrl=$request->getHost().$redirUrl;
        //var_dump($redirUrl);
        //return new Response();
        $adsCookie=$redirUrl.rand();
        $adsCookieTime=time() + 2592000; //3600*24*30;
        $cookie=$request->cookies->get('adsCookie',0);
        if ($cookie!=0)
            $adsCookie=$cookie;

        /** @var MobileDetector $mobileDetector */
        $mobileDetector = $controller->get('mobile_detect.mobile_detector');
        $ua_info = parse_user_agent($mobileDetector->getUserAgent());
        $os=$ua_info['platform'];
        $browser=$ua_info['browser'];

        $wan_ip = $request->getClientIp();
        if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
            $wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];

        $params=array();
        $params = array_merge($params,array(
            //'wan_ip'=>$this->container->get('request')->server->get("REMOTE_ADDR"),
            'wan_ip'=>$wan_ip,
            'isMobile'=>($mobileDetector->isMobile() || $mobileDetector->isTablet()),
            'os' => $os,
            'browser' => $browser,
            'userAgent'	=>$mobileDetector->getUserAgent(),
            'called'		=> 	$in_params["called"],
            'mac'		=> 	$in_params["mac"],
            'ip'		=> 	$in_params["ip"],
            'id'		=> 	$in_params['advertId'],
            'userurl'   =>$in_params['redirurl'],
            'web_session'=>$adsCookie,
            'phase'=>'click_ads'
        ));
        //var_dump($params);
        AdvertHelper::writeTrackLog($params);
    }
	static public function getAdsReport($userName,$params){
		$from_0=$params["from_0"];
		$from_1=$params["from_1"];
		$to=$params["to"];
		/*
		$query="(select b.title, b.id, b.link_to,SUM(if(c.phase='view_ads',1,0)) as impression, SUM(if(c.phase='click_ads',1,0)) as click, 'từ $from_0 đến $to' as `date` from advert a,advert_i18n b
		right join track_log c
		on b.id=c.ads_id
		and (c.created_at BETWEEN '$from_0' AND '$to')
		where a.id=b.id
		and b.locale='vi'
		and a.customer_id=(select `id` from customer where `username`='".$userName."')
		group by b.title, b.id, b.link_to
		order by b.id)";
        */
		$query="(select b.title, b.id, IFNULL(b.link,b.link_to) as 'link_to',IFNULL(sum(c.view_count),0) as impression, IFNULL(sum(c.click_count),0) as click, 
		'từ $from_0 đến $to' as `date` 
           from advert a,advert_i18n b
		right join ads_daily_counting c
		on b.id=c.advert_id
		and (c.`date` >= '$from_0' AND  c.`date`<'$to')
		where a.id=b.id
		and b.locale='vi'
		and a.customer_id=(select `id` from customer where `username`='".$userName."')
		group by b.title, b.id, link_to
		order by b.id)";

		//var_dump($query);
		$connection = Propel::getConnection();
		$stmt = $connection->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(2);
		//}
		//return null;
	}
    static private function addDayswithdate($date,$days){

        $date = strtotime("+".$days." days", strtotime($date));
        return  date("Y-m-d", $date);

    }
}