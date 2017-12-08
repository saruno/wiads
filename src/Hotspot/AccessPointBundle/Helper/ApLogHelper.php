<?php
namespace Hotspot\AccessPointBundle\Helper;

use Hotspot\AccessPointBundle\Model\Base\AdsDailyCountingQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Common\DbBundle\Model\App;
use Common\DbBundle\Model\Advert;
use Common\DbBundle\Model\AdvertQuery;
use Common\DbBundle\Model\AdvertI18n;
use Common\DbBundle\Model\AdvertI18nQuery;
use Common\DbBundle\Model\Advertcache;
use Common\DbBundle\Model\AdvertcacheQuery;

use Hotspot\AccessPointBundle\Model\ApLog;
use Hotspot\AccessPointBundle\Model\ApLogQuery;
use Hotspot\AccessPointBundle\Model\Accesspoint;
use Hotspot\AccessPointBundle\Model\AccesspointQuery;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;
use Hotspot\AccessPointBundle\Model\AdsLog;
use Hotspot\AccessPointBundle\Model\AdsLogQuery;


class ApLogHelper{
	static public function writeRequestLog($params){
		//$apLog=ApLogQuery::create()
		//->filterByApMacaddr($params['mac'])
		//->findOne();
		//if($apLog==null)
		$apLog = new ApLog();
		$apLog->setApMacaddr(trim($params['called']));
		$apLog->setFwVersion(trim($params['v']));
		$apLog->setPlatform(trim($params['hw']));
		$apLog->setIp($params['ip']);
		$apLog->setSsid(trim($params['ssid']));
		$apLog->setUpdatedAt(date('Y-m-d H:i:s'));
		$apLog->save();
		
		$ap=AccesspointQuery::create()
		->findOneByApMacaddr(trim($params['called']));
		if($ap){
			$ap->setUpdatedAt(date('Y-m-d H:i:s'));
			$ap->save();
		}
	}
	static public function writeTrackLoginLog($params){
		$isNewRq=true;
		/*
		 * temporary pause this feature
		*/
		$isNewRq=false;
		$query=AdsLogQuery::create()
		->filterByApMacaddr($params['called'])
		->filterByDeviceIp($params['ip'])
		->filterByWanIp($params['wan_ip'])
		->filterByPhase($params['phase']);
		if(array_key_exists('challenge',$params)){
			$query->filterByApSessionid($params['challenge']);
		}
		$trackLog = $query->findOne();

		if($trackLog == null) {
            $isNewRq=true;
            $trackLog = new AdsLog();
        }
		
		if(array_key_exists('called',$params))
			$trackLog->setApMacaddr($params['called']);
		if(array_key_exists('mac',$params))
			$trackLog->setDeviceMacaddr($params['mac']);
		$trackLog->setDevice(null);
		if(array_key_exists('wan_ip',$params))
			$trackLog->setWanIp($params['wan_ip']);
		if(array_key_exists('ip',$params))
			$trackLog->setDeviceIp($params['ip']);
		if(array_key_exists('challenge',$params))
			//$trackLog->setApSessionid($params['sessionid']);
			$trackLog->setApSessionid($params['challenge']);
			
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
		/**/
		$ap=AccesspointQuery::create()
		->findOneByApMacaddr(trim($params['called']));
		if($ap){
			$ap->setUpdatedAt(date('Y-m-d H:i:s'));
			$ap->save();
		}

        ///////////////

        if ($isNewRq && ($params['phase'] == 'view_login')) {
            $adsCount = AdsDailyCountingQuery::create()
                ->filterByAdvertId(-1)
                ->filterByApMacaddr($params['called'])
                ->filterByDate(date('Y-m-d'))
                ->findOneOrCreate();
            //if($params['phase']=='view_login')
            //    $adsCount->setClickCount($adsCount->getClickCount()+1);
            //if ($params['phase'] == 'success')
            $adsCount->setViewCount($adsCount->getViewCount() + 1);
            $adsCount->setApMacaddr($params['called']);
            $adsCount->save();
        }
	}
	static public function reportClientAccessLog($params){
		$from_0=$params["from_0"];
		$from_1=$params["from_1"];
		$to=$params["to"];
		
		$province_subquery=' ';
		if($params['province']==-1){
			$province_subquery=' ';
		}
		else{
			$province_subquery=" and a.province='".$params['province']."' ";
		}
		$company_subquery=' ';
		if($params['company']==-1){
			$company_subquery=' ';
		}
		else{
			$company_subquery=" and a.owner='".$params['company']."' ";
		}
		
		$connection = Propel::getConnection();
		/*
		$query="(select SUM(if( b.phase='view_login', 1, 0)) as popup,SUM(if( b.phase='login', 1, 0)) as click_login ,SUM(if( b.phase='success', 1, 0)) as success_login,SUM(if( b.phase='fail', 1, 0)) as fail
				from accesspoint a, ads_log b 
				where a.`ap_macaddr`=b.`ap_macaddr` 
					and (b.`created_at` BETWEEN '$from_1' AND '$from_0') 
					$province_subquery $company_subquery
					and (b.phase='view_login' or b.phase='login' or b.phase='success' or b.phase='fail'))
				union
				(select SUM(if( b.phase='view_login', 1, 0)) as popup,SUM(if( b.phase='login', 1, 0)) as click_login ,SUM(if( b.phase='success', 1, 0)) as success_login,SUM(if( b.phase='fail', 1, 0)) as fail
				from accesspoint a,ads_log b 
				where a.`ap_macaddr`=b.`ap_macaddr`
					and (b.`created_at` BETWEEN '$from_0' AND '$to')
					$province_subquery $company_subquery
					and (b.phase='view_login' or b.phase='login' or b.phase='success' or b.phase='fail')
				)";
		//var_dump($query);
		*/
        $query="(select IFNULL(sum(b.view_count),0) as popup, IFNULL(sum(b.click_count),0) as click_login
				from accesspoint a, ads_daily_counting b 
				where a.`ap_macaddr`=b.`ap_macaddr` 
				    and advert_id=-1
					and (b.`date` >= '$from_1' AND  b.`date`<'$from_0')
					$province_subquery $company_subquery
				limit 500
			    )
				union
				(select IFNULL(sum(b.view_count),0) as popup, IFNULL(sum(b.click_count),0) as click_login
				from accesspoint a,ads_daily_counting b 
				where a.`ap_macaddr`=b.`ap_macaddr`
				    and advert_id=-1
					and (b.`date` >= '$from_0' AND b.`date`<'$to')
					$province_subquery $company_subquery
				limit 500
				)";
        //var_dump($query);
		$stmt = $connection->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(2);
	}
	/**
	 * 
	 * @param unknown $params
	 */
	static public function reportLogAll($params){
		$page = $params['page']-1;
		$maxPerPage = $params['maxPerPage'];
		$connection = Propel::getConnection();
		/*
		$query="insert into accesspoint (ap_macaddr)  
				select ap_macaddr  from ap_config where ap_config.ap_macaddr not in 
				(select ap_macaddr from accesspoint)";
		$stmt = $connection->prepare($query);
		$stmt->execute();
		
		$query="update accesspoint set created_at=(select created_at from ap_config where ap_config.ap_macaddr=accesspoint.ap_macaddr),updated_at=(select updated_at from ap_config where ap_config.ap_macaddr=accesspoint.ap_macaddr)";
		$stmt = $connection->prepare($query);
		$stmt->execute();
		*/
		$province_subquery=' ';
		if($params['province']==-1){
			$province_subquery=' ';
		}
		else{
			$province_subquery=" and a.province='".$params['province']."' ";
		}
		$company_subquery=' ';
		if($params['company']==-1){
			$company_subquery=' ';
		}
		else{
			$company_subquery=" and a.owner='".$params['company']."' ";
		}
		if(key_exists('level', $params)){
			if($params['level']==2){
				$query="(select a.`macaddr`, a.province,c.name, c.address,a.lat,a.lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, IFNULL(sum(b.view_count),0) as popup,IFNULL(sum(b.click_count),0) as `access_num` from accesspoint a, ads_daily_counting b , accesspoint_i18n c
					where a.`ap_macaddr`=b.`ap_macaddr`
					and a.id=c.id
					".$province_subquery."
					".$company_subquery."
					and b.`date`>='".$params['from_0']."'
					and b.`date`<'".$params['to']."'
					and b.advert_id=-1
					and (c.trash is null or c.trash!=1)
					and b.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					group by a.`macaddr`
					order by updated_at, created_at, `access_num`
					limit 500
					)";
				$stmt = $connection->prepare($query);
				$stmt->execute();
				return $stmt->fetchAll(2);
			}
		}
		//echo $company_subquery;

			//$from=$params["from"];
			//$to=$params["to"];
            /*
			$query="(select a.`macaddr`, a.province,c.name, c.address,a.lat,a.lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, SUM(if( b.phase='view_login', 1, 0)) as `access_num` from accesspoint a, ads_log b , accesspoint_i18n c
					where a.`ap_macaddr`=b.`ap_macaddr`
					and a.id=c.id
					".$province_subquery."
					".$company_subquery."
					and b.created_at>'".$params['from_0']."'
					and b.created_at<'".$params['to']."'
					and (b.phase='view_login' or b.phase='login' or b.phase='success')
					and (c.trash is null or c.trash!=1)
					and b.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					group by a.`macaddr`
					order by updated_at, created_at, `access_num`
					)
					union
					(
					select a.`macaddr`, a.province,'---Chưa có tên---' as name, '' as address,'' as lat, '' as lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, SUM(if( b.phase='view_login', 1, 0)) as `access_num` from accesspoint a, ads_log b
					where a.`ap_macaddr`=b.`ap_macaddr`
					and b.created_at>'".$params['from_0']."'
					and b.created_at<'".$params['to']."'
					and (b.phase='view_login' or b.phase='login' or b.phase='success')
					and b.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					and a.id not in (select id from accesspoint_i18n)
					group by a.`macaddr`
					order by updated_at, created_at, `access_num`
					)
					union 
					(select a.`macaddr`, a.province,c.name, c.address,a.lat,a.lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, 0 as `access_num` from accesspoint a, accesspoint_i18n c
					where  a.id=c.id
					".$province_subquery."
					".$company_subquery."
					and (c.trash is null or c.trash!=1)
					and a.`ap_macaddr` not in (select `ap_macaddr` from ads_log where (`ap_macaddr` !='' or `ap_macaddr` is not null) group by `ap_macaddr`)
					and a.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					group by a.`macaddr`
					order by a.updated_at,`access_num`
					)
					union
					(
					select a.`macaddr`, a.province,'---Chưa có tên---' as name, '' as address, '' as lat, '' as lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, 0 as `access_num` from accesspoint a 
					where  a.`ap_macaddr` not in (select `ap_macaddr` from ads_log where (`ap_macaddr` !='' or `ap_macaddr` is not null) group by `ap_macaddr`)
					and a.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					and a.id not in (select id from accesspoint_i18n)
					group by a.`macaddr`
					order by a.updated_at,`access_num`
					)
					order by province,updated_at, created_at, `access_num`";
            */
        $query="(select a.`macaddr`, a.province,c.name, c.address,a.lat,a.lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, IFNULL(sum(b.view_count),0) as popup,IFNULL(sum(b.click_count),0) as `access_num` from accesspoint a, ads_daily_counting b , accesspoint_i18n c
					where a.`ap_macaddr`=b.`ap_macaddr`
					and a.id=c.id
					".$province_subquery."
					".$company_subquery."
					and b.`date`>='".$params['from_0']."'
					and b.`date`<'".$params['to']."'
					and b.advert_id=-1
					and (c.trash is null or c.trash!=1)
					and b.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					group by a.`macaddr`
					order by updated_at, created_at, `access_num`
					limit 500
					)
					union
					(
					select a.`macaddr`, a.province,'---Chưa có tên---' as name, '' as address,'' as lat, '' as lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, IFNULL(sum(b.click_count),0) as popup,IFNULL(sum(b.view_count),0) as `access_num` from accesspoint a, ads_daily_counting b
					where a.`ap_macaddr`=b.`ap_macaddr`
					and b.`date`>='".$params['from_0']."'
					and b.`date`<'".$params['to']."'
					and b.advert_id=-1
					and b.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					and a.id not in (select id from accesspoint_i18n)
					group by a.`macaddr`
					order by updated_at, created_at, `access_num`
					limit 500
					)
					union 
					(select a.`macaddr`, a.province,c.name, c.address,a.lat,a.lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, 0 as popup,0 as `access_num` from accesspoint a, accesspoint_i18n c
					where  a.id=c.id
					".$province_subquery."
					".$company_subquery."
					and (c.trash is null or c.trash!=1)
					and a.`ap_macaddr` not in (select `ap_macaddr` from ads_daily_counting where (`ap_macaddr` !='' or `ap_macaddr` is not null) group by `ap_macaddr`)
					and a.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					group by a.`macaddr`
					order by a.updated_at,`access_num`
					limit 500
					)
					union
					(
					select a.`macaddr`, a.province,'---Chưa có tên---' as name, '' as address, '' as lat, '' as lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, 0 as popup,0 as `access_num` from accesspoint a 
					where  a.`ap_macaddr` not in (select `ap_macaddr` from ads_daily_counting where (`ap_macaddr` !='' or `ap_macaddr` is not null) group by `ap_macaddr`)
					and a.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					and a.id not in (select id from accesspoint_i18n)
					group by a.`macaddr`
					order by a.updated_at,`access_num`
					limit 500
					)
					order by province,updated_at, created_at, `access_num`";

		//echo $query;
		$stmt = $connection->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(2);
	}
	static public function reportApNumber($province=null,$post_by=null){
		$connection = Propel::getConnection();
		$query ="select count(*) as total from accesspoint a, accesspoint_i18n b where a.id=b.id and (b.trash=0 or b.trash is null) and a.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)";
		if(!empty($province) && $province!=-1){
			$query = $query." and a.province='$province'";
		}
		if(!empty($post_by) && $post_by!=-1){
			$query = $query." and b.post_by='$post_by'";
		}
		//$query = $query." group by province";

		$stmt = $connection->prepare($query);
		$stmt->execute();
		$result =  $stmt->fetchAll(2);
		foreach ($result as $r)
			return $r['total'];
	}
    static public function reportLogAll_v2($params){
        $page = $params['page']-1;
        $maxPerPage = $params['maxPerPage'];
        $connection = Propel::getConnection();
        $province_subquery=' ';
        if($params['province']==-1){
            $province_subquery=' ';
        }
        else{
            $province_subquery=" and b.province='".$params['province']."' ";
        }
        $company_subquery=' ';
        if($params['company']==-1){
            $company_subquery=' ';
        }
        else{
            $company_subquery=" and (b.owner='".$params['company']."' or b.owner is null or b.owner='') ";
        }
        $post_by_subquery=' ';
        if($params['post_by']==-1){
            $post_by_subquery=' ';
        }
        else{
            $post_by_subquery=" and (c.post_by='".$params['post_by']."' or c.post_by is null or c.post_by='') ";
        }

        $year=$params['year'];
        $month=$params['month'];
        if(key_exists('level', $params)){
            if($params['level']==2){
                $query="select b.macaddr,b.created_at,b.updated_at,c.name, c.address,b.province, a.* from ap_report a, accesspoint b, accesspoint_i18n c  where b.id=c.id 
                        ".$province_subquery."
				        ".$company_subquery."
				        ".$post_by_subquery."
				        and (c.trash is null or c.trash!=1)
                        and b.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
                        and c.locale='vi' and a.ap_macaddr=b.ap_macaddr and a.`year`=".$year." and a.`month`=".$month
                        ." order by b.province,b.updated_at limit 500";
                $stmt = $connection->prepare($query);
                $stmt->execute();
                return $stmt->fetchAll(2);
            }
        }
        $query="select b.macaddr,b.created_at,b.updated_at,c.name, c.address,b.province, a.* from ap_report a, accesspoint b, accesspoint_i18n c  where b.id=c.id 
                ".$province_subquery."
				".$company_subquery."
				".$post_by_subquery."
				and (c.trash is null or c.trash!=1)
                and b.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
                and c.locale='vi' and a.ap_macaddr=b.ap_macaddr and  a.`year`=".$year." and a.`month`=".$month
                ." order by b.province,b.updated_at limit 500";

        //dump($query);
        $stmt = $connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(2);
    }
	static public function reportLogApStatus($params){
		$page = $params['page']-1;
		$maxPerPage = $params['maxPerPage'];
		$connection = Propel::getConnection();
		
		/*
			$query="insert into accesspoint (ap_macaddr)
			select ap_macaddr  from ap_config where ap_config.ap_macaddr not in
			(select ap_macaddr from accesspoint)";
			$stmt = $connection->prepare($query);
			$stmt->execute();
	
			$query="update accesspoint set created_at=(select created_at from ap_config where ap_config.ap_macaddr=accesspoint.ap_macaddr),updated_at=(select updated_at from ap_config where ap_config.ap_macaddr=accesspoint.ap_macaddr)";
			$stmt = $connection->prepare($query);
			$stmt->execute();
			*/
		$province_subquery=' ';
		if($params['province']==-1){
			$province_subquery=' ';
		}
		else{
			$province_subquery=" and a.province='".$params['province']."' ";
		}
		$company_subquery=' ';
		if($params['company']==-1){
			$company_subquery=' ';
		}
		else{
			$company_subquery=" and (a.owner='".$params['company']."' or a.owner is null or a.owner='') ";
		}
        $post_by_subquery=' ';
        if($params['post_by']==-1){
            $post_by_subquery=' ';
        }
        else{
            $post_by_subquery=" and (c.post_by='".$params['post_by']."' or c.post_by is null or c.post_by='') ";
        }
        if($params['user_company']==-1){
            $user_company_subquery=' ';
        }
        else{
            $user_company_subquery=" and c.post_by='".$params['user_company']."'";
        }
        if($params['ap_name']==-1){
            $ap_name_subquery=' ';
        }
        else{
            $ap_name_subquery=" and c.name like '%".$params['ap_name']."%'";
        }
		if(key_exists('level', $params)){
			if($params['level']==2){
				$query="(select a.`macaddr`, a.province,c.name, c.address,a.lat,a.lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner,'-' as popup,  '-' as `access_num`  from accesspoint a, accesspoint_i18n c
					where a.id=c.id
					".$ap_name_subquery."
					".$province_subquery."
					".$company_subquery."
					".$post_by_subquery."
					".$user_company_subquery."
									and (c.trash is null or c.trash!=1)
									and a.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
									group by a.`macaddr`
									order by updated_at, created_at
									limit 500
									)";
				$stmt = $connection->prepare($query);
				$stmt->execute();
				return $stmt->fetchAll(2);
			}
		}
		//echo $company_subquery;
		if($params==null){
			$query="(select a.`macaddr`, a.province,c.name, c.address,a.lat,a.lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner,'-' as popup,  '-' as `access_num` 
			from accesspoint a, accesspoint_i18n c
					where a.id=c.id
					".$ap_name_subquery."
					".$province_subquery."
					".$company_subquery."
					".$post_by_subquery."
					".$user_company_subquery."
					and (c.trash is null or c.trash!=1)
					and a.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					group by a.`macaddr`
					order by updated_at, created_at
					limit 500
					)
					union
					(
					select a.`macaddr`, a.province,'---Chưa có tên---' as name, '' as address, '' as lat,'' as lng,a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, '-' as `access_num`  from accesspoint a
					where a.id not in (select id from accesspoint_i18n)
					and a.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					group by a.`macaddr`
					order by updated_at, created_at
					limit 500
					)
					
					order by province,updated_at, created_at";
		}
		else{
			//$from=$params["from"];
			//$to=$params["to"];
			$query="(select a.`macaddr`, a.province,c.name, c.address,a.lat,a.lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, '-' as popup, '-' as `access_num`  from accesspoint a, accesspoint_i18n c
					where a.id=c.id
					".$ap_name_subquery."
					".$province_subquery."
					".$company_subquery."
					".$post_by_subquery."
					".$user_company_subquery."
					and (c.trash is null or c.trash!=1)
					and a.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					group by a.`macaddr`
					order by updated_at, created_at
					limit 500
					)
					union
					(
					select a.`macaddr`, a.province,'---Chưa có tên---' as name, '' as address,'' as lat, '' as lng, a.ssid,a.key,a.isp,a.created_at, a.updated_at,a.owner, '-' as popup, '-' as `access_num`  from accesspoint a
					where a.id not in (select id from accesspoint_i18n)
					and a.`ap_macaddr` not in (select `ap_macaddr` from ap_config where exclude=1 group by `ap_macaddr`)
					group by a.`macaddr`
					order by updated_at, created_at
					limit 500
					)
					
					order by province,updated_at, created_at";
		}
//		echo $query;
		$stmt = $connection->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(2);
	}
	static public function updateApInfoAll(){
		$connection = Propel::getConnection();
		
		$query="insert into accesspoint (ap_macaddr)
				select ap_macaddr  from ap_config where ap_config.ap_macaddr not in
				(select ap_macaddr from accesspoint)";
		$stmt = $connection->prepare($query);
		$stmt->execute();
		
		$query="update accesspoint set created_at=(select created_at from ap_config where ap_config.ap_macaddr=accesspoint.ap_macaddr),updated_at=(select updated_at from ap_config where ap_config.ap_macaddr=accesspoint.ap_macaddr)";
		$stmt = $connection->prepare($query);
		$stmt->execute();

	}
	static public function getUserListOfCompany($company){
		$connection = Propel::getConnection();
		$query      = "select username from `user` where company='$company'";
		$stmt       = $connection->prepare( $query );
		$stmt->execute();
		return $stmt->fetchAll( 2 );
	}
}