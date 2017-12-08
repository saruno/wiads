<?php
namespace Hotspot\AccessPointBundle\Helper;

use Common\DbBundle\Model\User;
use Hotspot\AccessPointBundle\Model\ApConfig;
use Hotspot\AccessPointBundle\Model\ApConfigQuery;
use Hotspot\AccessPointBundle\Model\Accesspoint;
use Hotspot\AccessPointBundle\Model\AccesspointQuery;
use Hotspot\AccessPointBundle\Model\Base\BwProfileQuery;
use Hotspot\AccessPointBundle\Service\APSystemService;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;
use Hotspot\AccessPointBundle\Model\FirmwareQuery;

class ApConfigHelper{
	static public function getAPInfo($mac){
		$ap= AccesspointQuery::create()
		                     ->filterByMacaddr(trim($mac))
		                     ->joinWithI18n('vi')
		                     ->findOne();
		if(empty($ap)){
			$ap=new Accesspoint();
			$ap->setMacaddr(trim($mac));
			$ap->setName('Chưa có trên hệ thống');
			$ap->setAddress('Chưa có trên hệ thống');
		};
		return $ap;
	}
	static public function getUpdatFirmwareList(){
		return FirmwareQuery::create()->find();
	}
	static public function getBwProfileList (){
		return BwProfileQuery::create()->find();
	}
	static public function getAPConfig($mac){
		$apConfig=null;
		$ap= AccesspointQuery::create()
		                     ->filterByMacaddr(trim($mac))
		                     ->joinWithI18n('vi')
		                     ->findOne();
		if(!empty($ap)){
			$apConfig=ApConfigQuery::create()->filterByApMacaddr($ap->getApMacaddr())->findOne();
		};
		return $apConfig;
	}
	static public function isUsingKey($mac){
		$ap= AccesspointQuery::create()
		                     ->filterByMacaddr(trim($mac))
		                     ->joinWithI18n('vi')
		                     ->findOne();
		if(!empty($ap)){
			$config= ApConfigQuery::create()
			                      ->filterByApMacaddr($ap->getApMacaddr())
			                      ->findOne();

			if(empty($config)) return false;

			if(!empty($config) &&
			   (trim($config->getEncryption())=="option encryption 'none'"
			   ||
			   trim($config->getEncryption())=="option encryption none"
			   )
			)
				return false;
			else
				return true;
		}
		return false;
	}
	static public function updateAPKeepAlive($params){
		$mac="";
		if(key_exists('ap_mac', $params) && !empty($params['ap_mac'])){
			$mac=$params['ap_mac'];
		}
		if($mac=="") return "-1";

		//////////
		$ap=AccesspointQuery::create()
			                ->filterByMacaddr($mac)
		                    ->findOneOrCreate();
		if($ap->isNew())
			$ap->setApMacaddr($mac);

		$ap->setUpdatedAt(date('Y-m-d H:i:s'));
		$ap->save();

		$old_ap_mac=$ap->getApMacaddr();
		$apConfig=ApConfigQuery::create()
		                       ->filterByApMacaddr($old_ap_mac)
		                       ->findOneOrCreate();

		if($apConfig==null)
			$apConfig = new ApConfig();
		$apConfig->setFwVersion(trim($params['v']));
		$apConfig->setPlatform(trim($params['hw']));
		$apConfig->setUpdatedAt(date('Y-m-d H:i:s'));

		$need_update = 'need_update 0';
		if( $apConfig->getNeedUpdate() == 1)
			$need_update = 'need_update 1';
		if(trim($apConfig->getSsid())!=trim($apConfig->getSsidNext())) {
			$need_update = 'need_update 1';
			$apConfig->setNeedUpdate(1);
		}
		if($params['justboot']==1 || trim($apConfig->getSsid())=='option ssid \'Wifi Free\''){
			if($params['v']=='20170719.02.fix.bridge'
			   || $params['v']=='20170719.02.bridge'
			   || $params['v']=='20170812.01.bridge'
			   //|| $params['v']=='20170804.02.bridge'
			   //|| $params['v']=='20170804.02.fix.bridge'
			) {
				if(trim($apConfig->getSsid())!=trim($apConfig->getSsidNext())) {
					$need_update = 'need_update 1';
					$apConfig->setNeedUpdate( 1 );
				}
			}
		}
		if($need_update=='need_update 1'){
			exec('wiads_config_helper '.$ap->getApMacaddr());
		}
		$apConfig->save();

		return $apConfig->getNormalMode()."\n"
		       .$need_update;
	}
	static public function updateAPStatus($params){
		if(key_exists('ap_mac', $params) && !empty($params['ap_mac'])){
			$newMac=$params['ap_mac'];
		}
		else{
			if(false===strpos(trim($params['v']), 'bridge')){
				$newMac=self::add1ToMac(trim($params['called']));
			}
			else{
				$newMac=self::subtract1ToMac(trim($params['called']));
			}
		}
		if($newMac=="") return "-1";

		//////////Add mac_address vao table accesspoint (Neu query ra ma khong co)
		$ap=AccesspointQuery::create()
			//->filterByApMacaddr($params['called'])
			                ->filterByMacaddr($newMac)
		                    ->findOneOrCreate();
		//if($ap==null){
		//	$ap = new Accesspoint();
		//	$ap->setMacAddr($newMac);
		//	//$ap->setApMacaddr(trim($params['called']));
		//}
		$old_ap_mac=$ap->getApMacaddr();
		$ssid_fix=str_replace("escape_and","&",trim($params['ssid']));
		$ap->setApMacaddr(trim($params['called']));
		$ap->setSsid(str_replace("option ssid", "", $ssid_fix));
		if(
			trim($params['encryption'])!='option encryption none'
			&&
			trim($params['encryption'])!="option encryption 'none'"
		) {
			$key =str_replace( "option key", "", trim( $params['key'] ) );
			$key=str_replace('"', '', $key);
			$key=str_replace("'", '', $key);
			$ap->setKey($key);
		}
		else
			$ap->setKey("");
		$ap->setUpdatedAt(date('Y-m-d H:i:s')); //Cap nhat thong tin truong update_at cua accesspoint
		$ap->save();
		//re update APInfo, when change firmware from normal to bridge and vise visa
        //Cap nhat vao table ap_config
		$oldApConfig=ApConfigQuery::create()
		                          ->filterByApMacaddr($old_ap_mac)
		                          ->findOne();
		if(!empty($old_ap_mac) && $old_ap_mac!=$params['called']){
			$oldApConfig->setApMacaddr($params['called']);
			$oldApConfig->setNeedUpdate("1");
			$oldApConfig->save();
		}

		$apConfig=ApConfigQuery::create()
		                       ->filterByApMacaddr($params['called'])
		                       ->findOne();
		if($apConfig==null)
			$apConfig = new ApConfig();
		$apConfig->setApMacaddr(trim($params['called']));
		$apConfig->setFwVersion(trim($params['v']));
		$apConfig->setPlatform(trim($params['hw']));
		$apConfig->setIp(trim($params['ip']));
		$apConfig->setSsid($ssid_fix);
		$apConfig->setUpdatedAt(date('Y-m-d H:i:s'));
		$apConfig->setUamdomains(trim($params['uamdomains']));
		$apConfig->setUamformat(trim($params['uamformat']));
		$apConfig->setUamhomepage(trim($params['uamhomepage']));
		$apConfig->setMacauth($params['macauth']);
		$apConfig->setChannel($params['channel']);
		$apConfig->setHtmode($params['htmode']);
		$apConfig->setHwmode($params['hwmode']);
		$apConfig->setChannel($params['channel']);
		$apConfig->setNoscan($params['noscan']);
		$apConfig->setEncryption($params['encryption']);
		$apConfig->setKey($params['key']);
		$apConfig->setIwinfo(trim($params['iwinfo']));
		//if($params['justboot']==1 && trim($ap->getSsid())=='Wifi Free'){
		if($params['justboot']==1 || trim($apConfig->getSsid())=='option ssid \'Wifi Free\'') {
			/*if ( $params['v'] == '20170719.02.fix.bridge'
			     || $params['v'] == '20170719.02.bridge'
			     || $params['v'] == '20170804.02.bridge'
			     || $params['v'] == '20170804.02.fix.bridge'
			     || $params['v'] == '20170812.01.bridge'
			     || $params['v'] > '20170812.01.bridge'
			)*/
			{
				$apConfig->setNeedUpdate( 1 );
				if ( ! empty( $apConfig->getSsidNext())
				     &&
				     (
					     trim($apConfig->getSsid())!=trim($apConfig->getSsidNext())
				     )
				) {
					$apConfig->setSsidUpdate( 'option ssid_update 1' );
				}
				if ( ! empty( $apConfig->getEncryptionNext() )
				     &&
				     trim($apConfig->getEncryption() ) != trim($apConfig->getEncryptionNext() )
				) {
					$apConfig->setUpdateEncryption( 'option encryption_update 1' );
				}
				if ( ! empty( $apConfig->getKeyNext() )
				     &&
				     trim($apConfig->getKey() ) != trim($apConfig->getKeyNext() )
				) {
					$apConfig->setUpdateKey( 'option key_update 1' );
				}
				if ( ! empty( $apConfig->getUamformatNext() )
				     &&
				     trim($apConfig->getUamformat() ) != trim($apConfig->getUamformatNext() )
				) {
					$apConfig->setUpdateUamformat( 'option update_uamformat 1' );
				}
				if ( ! empty( $apConfig->getUamdomainsNext() )
				     &&
				     trim($apConfig->getUamdomains() ) != trim($apConfig->getUamdomainsNext() )
				) {
					$apConfig->setUpdateUamdomains( 'option update_uamdomains 1' );
				}
				if ( ! empty( $apConfig->getUamhomepageNext() )
				     &&
				     trim($apConfig->getUamhomepage() ) != trim($apConfig->getUamhomepageNext() )
				) {

					$apConfig->setUpdateUamhomepage( 'option update_uamhomepage 1' );
				}
				//if ( ! empty( $apConfig->getHosts() ) ) {
				//	$apConfig->setUpdateHosts( 'option hosts_update 1' );
				//}
			}
		}
		$apConfig->save();
		return array('need_update'=>$apConfig->getNeedUpdate(),'mode'=>$apConfig->getNormalMode());

	}
	static public function updateAPInfo($params,$api_service=null){
		/** @var User $user */
		$user=$params['user'];

		$name=trim($params['name']);
		$name = str_replace("'","\"",$name);
		while (strpos($name,"  ")!== FALSE){
			$name = str_replace("  "," ",$name);
		}

		$wifiname=substr($name, 0, min(30,strlen($name)));

		$apInfo=AccesspointQuery::create()
		                        ->filterByMacaddr($params['macaddr'])
		                        ->findOne();
		if ( empty( $apInfo ) ) {
			return 'Không tìm thấy thiết bị';
		}
		if($params['post_by']!=-1 && $params['level']>2) {
			if (!empty( $apInfo->getPostBy()) && $apInfo->getPostBy() != $params['post_by']  ) {
				return 'Không tìm thấy thiết bị';
			}
		}
		if($params['level']!=1 && !empty($apInfo->getOwner()) && $apInfo->getOwner()!=$params['company']){
			return 'Không tìm thấy thiết bị';
		}
		//
		$apConfig=ApConfigQuery::create()
		                       ->filterByApMacaddr(trim($apInfo->getApMacaddr()))
		                       ->findOne();
		if(empty($apConfig) ) {
			return 'Không tìm thấy thiết bị';
		}
		if($params['reboot']==1 && !empty($apConfig)){
			$apConfig->setNeedUpdate(1);
			$apConfig->setNeedReboot('option need_reboot 1')->keepUpdateDateUnchanged()->setNeedUpdate(1)->save();
			exec('wiads_config_helper '.$apInfo->getApMacaddr());
			return "Thiết bị sẽ khởi động lại trong 5 phút nữa!";
		}
		if($params['reset']==1 && !empty($apConfig)){
			$apConfig->setNeedUpdate(1);
			$apConfig->setResetNeed('option reset_to_default 1')->keepUpdateDateUnchanged()->setNeedUpdate(1)->save();
			exec('wiads_config_helper '.$apInfo->getApMacaddr());
			return "Thiết bị sẽ xoá cấu hình trong vài phút nữa!";
		}
		if(!empty($apInfo)){
			$apInfo->setLocale('vi');
			if(trim($params['name'])!="")	$apInfo->setName($name);
			if(trim($params['province'])!="")	$apInfo->setProvince(trim($params['province']));
			if(
			(trim($apInfo->getAdsLocation())!=trim($apInfo->getApMacaddr()))
			)
				$apInfo->setAdsLocation(trim($params['province']));
			if(trim($params['address'])!="")	$apInfo->setAddress(trim($params['address']));
			if($params['change_img']==1)    $apInfo->setImage($params['file_name']);
			if($params['disable_img']==1) $apInfo->setImage("");
			if(trim($params['company'])!="" && trim($params['company'])!="-1"){
				if($params['level']==1 || empty($apInfo->getOwner())) {
					$apInfo->setOwner( trim( $params['company'] ) );
				}
			//else{
			//	return 'Vui lòng kiểm tra lại tài khoản đăng nhập';
			}
			if(trim($params['post_by'])!="" && $params['post_by']!=-1 && empty($apInfo->getPostBy()))	$apInfo->setPostBy($params['post_by']);
			/** @var APSystemService $api_service */
			if($api_service!=null){
				$address=urlencode($apInfo->getAddress());
				$province=str_replace("TTHUE", "Hue", trim($apInfo->getProvince()));
				$json=$api_service->geocoding($address.",+".$province.",+VN");
				//var_dump($json);
				$json_decode=json_decode($json,true);
				//var_dump($json_decode);
				//if($result["code"] && $result["code"]=="OK")
				//$json = json_decode($content, true);
				if(trim($json_decode['status']) =="OK"){
					$latlng=$json_decode['results'][0]['geometry']['location'];
					$lat=$latlng['lat'];
					$lng=$latlng['lng'];
					if(!empty($lat) && !empty($lng)) {
						$apInfo->setLat( trim( $lat ) )->setLng( trim( $lng ) );
					}
				}
			}
			if($params['activated']==1){
				$ap=ApConfigQuery::create()->filterByApMacaddr($apInfo->getApMacaddr())->findOne();
				if($ap) $ap->setActivated(1);
				$apInfo->setTrash(0);
			}else{
				$ap=ApConfigQuery::create()->filterByApMacaddr($apInfo->getApMacaddr())->findOne();
				if($ap) $ap->setActivated(0);
				$apInfo->setTrash(1);
			}
			if(!empty($params['login_template'])){
				if ($params['login_template']=='mac.html.twig')
					//$params['login_template']=$params['macaddr'].'.html.twig';
					$params['login_template']=$apInfo->getApMacaddr().'.html.twig';
				$apInfo->setLoginTemplate(trim($params['login_template']));
			}
			if(!empty($params['detail_url'])){
				$apInfo->setDetailUrl($params['detail_url']);
			}
			if(!empty($params['detail_url']) && trim(strtolower($params['detail_url']))=='del'){
				$apInfo->setDetailUrl('');
			}
			$apInfo->keepUpdateDateUnchanged();
			$apInfo->save();

			//---------------------------------//

			if(!empty($apConfig)){
				$apConfig->keepUpdateDateUnchanged();
				if(trim($apConfig->getSsid())!=trim("option ssid ' ".$wifiname."'")) {
					$apConfig->setNeedUpdate("1");
					$apConfig->setSsidUpdate( "option ssid_update 1" );
					$apConfig->setSsidNext("option ssid ' ".$wifiname."'");
				}
				//$apConfig->setUpdateHosts('option hosts_update 1');
				//$apConfig->setHosts('125.212.233.15 enter.wiads.vn');
				//$apConfig->setUamformatNext('HS_UAMFORMAT=http://enter.wiads.vn/ap');
				//$apConfig->setUpdateUamformat('option update_uamformat 1');
				$apConfig->setUamdomainsNext("HS_UAMDOMAINS='.wiads.vn,.hotspotwifisystem.com,meganet.com.vn,.meganet.com.vn,.valuepotion.com,valuepotion.com,daumcdn.net,.daumcdn.net,bs.serving-sys.com,junoteam.com,.junoteam.com,.facebook.com,.facebook.net,.akamaitechnologies.com,.akamaihd.net,.akamaiedge.net,.akamaitechnologies.com,.fbcdn.net'");
				if(trim($apConfig->getUamdomains()!=$apConfig->getUamdomainsNext())) {
					$apConfig->setNeedUpdate("1");
					$apConfig->setUpdateUamdomains( 'option update_uamdomains 1' );
				}
				$apConfig->setNormalMode($params['ap_mode']);
				if(isset($params['bw_profile']) && intval($params['bw_profile']>0)) $apConfig->setBwProfileId($params['bw_profile']);
				if($params['usewifipass']==1 && strlen(trim($params['wifipass']))>=8 && trim($apConfig->getEncryption()!="option encryption 'psk2'")){
					$apConfig->setKeyNext("option key '".trim($params['wifipass'])."'");
					$apConfig->setUpdateKey("option key_update 1");
					$apConfig->setUpdateEncryption("option encryption_update 1");
					$apConfig->setEncryptionNext(" option encryption 'psk2'");
					$apConfig->setNeedUpdate("1");
				}
				if($params['usewifipass']==0 && trim($apConfig->getEncryption()!="option encryption 'none'")){
					$apConfig->setEncryptionNext(" option encryption 'none'");
					$apConfig->setUpdateEncryption("option encryption_update 1");
					$apConfig->setNeedUpdate("1");
				}
				if($params['activated']==1){
					$apConfig->setActivated(1);
				}
				if($params['activated']==0){
					$apConfig->setActivated(0);
				}
				if($params['firmware_upgrade']==1){
					$firmware=FirmwareQuery::create()->findOneByFile($params['firmware_file']);
					if(!empty($firmware)
					   &&
					   (   $firmware->getFwVersion()!=$apConfig->getFwVersion()
					       ||
					       $firmware->getFwVersion()=='20170804.02.fix.bridge'
						   ||
						   $firmware->getFwVersion()=='20170719.02.fix.bridge'
					   )
					){
						$apConfig->setFwUpgrade('option fw_upgrade 1');
						//$apConfig->setUpdateHosts("option hosts_update 1");
						$apConfig->setUpdateLanNetwork("option network_lan_update 0");
						$apConfig->setLanNetwork("option network_lan '172.16.16.1'");
						$apConfig->setUpdateMacauth("option update_macauth 0");
						$apConfig->setMacauthNext('HS_MACAUTH=off');
						$apConfig->setWifiEnable("active wifi 1");
						$apConfig->setFwVersionNext($firmware->getFwVersion());
						$apConfig->setFwFile($params['firmware_file']);
					}
				}
				else{
					$apConfig->setFwUpgrade('option fw_upgrade 0');
					$apConfig->setFwFile(null);
				}
				$json=$api_service->ipLocation($apConfig->getIp());
				$json_decode=json_decode($json,true);
				if(isset($json_decode['isp']))
					$apConfig->setIsp($json_decode['isp']);
				$apConfig->keepUpdateDateUnchanged()->save();
				//reupdate accespoint
				//$apInfo=AccesspointQuery::create()
				//    ->filterByMacaddr($params['macaddr'])
				//    ->findOne();
				//if($apInfo!=null){
				//if(empty($apInfo->getPostBy()) || $apInfo->getPostBy()==$params['post_by']) {
				$apInfo->setIsp($apConfig->getIsp());
				//$apInfo->setPostBy($params['post_by']);
				$apInfo->keepUpdateDateUnchanged()->save();
				//}
				//}
				exec('wiads_config_helper '.$apInfo->getApMacaddr());
			}
			//---------------------------------//
			//return "Đã lưu thông tin MAC: ".$apInfo->getMacaddr();
			return "Saved!";
		}
		return "Not found!";
	}
	static public function updateAllAPIGEO($api_service=null){
		$apInfoArr=AccesspointQuery::create()
		                           ->add("`lat`",'`lat` is null or `lat` =""',Criteria::CUSTOM)
		                           ->limit(300)
		                           ->find();
		foreach ($apInfoArr as $apInfo){
			//var_dump($apInfo)."\n";
			$apInfo->setLocale('vi');
			if(trim($apInfo->getAddress())=="" || trim($apInfo->getProvince())=="") continue;
			if($api_service!=null){
				sleep(0.5);
				$json=$api_service->geocoding($apInfo->getAddress().",+".trim($apInfo->getProvince()).",+VN");
				//var_dump($json);

				//var_dump($result);
				//if($result["code"] && $result["code"]=="OK")
				$json_decode=json_decode($json,true);
				if(trim($json_decode['status']) =="OK"){
					$latlng=$json_decode['results'][0]['geometry']['location'];
					$lat=$latlng['lat'];
					$lng=$latlng['lng'];
					//var_dump($lat.$lng);
					$apInfo->setLat(trim($lat));
					$apInfo->setLng(trim($lng));
					$apInfo->save();
				}

			}
		}
		return "Saved!";
	}
	static public function updateAllAPISP($api_service=null){
		$apConfigArr=ApConfigQuery::create()
		                          ->find();
		foreach ($apConfigArr as $apConfig){
			//update isp

			if($api_service!=null){
				$json=$api_service->ipLocation($apConfig->getIp());
				$json_decode=json_decode($json,true);
				sleep(1);
				$apConfig->setIsp($json_decode['isp']);
				$apConfig->save();
				//reupdate accespoint
				$apInfo=AccesspointQuery::create()
				                        ->filterByMacaddr($apConfig->getApMacaddr())
				                        ->findOne();
				if($apInfo!=null){
					$apInfo->setIsp($apConfig->getIsp());
					$apInfo->save();
				}
			}

		}
		return "Saved!";
	}
	static public function getAPStatus($params){
		$apConfig=ApConfigQuery::create()
		                       ->filterByApMacaddr($params['called'])
		                       ->findOne();
		$needToSave=0;
		if($apConfig)
		{
			if(trim(empty($apConfig->getKeyNext())) || strpos($apConfig->getKeyNext(),'option key')===false)
				$apConfig->setEncryptionNext("option encryption 'none'")->save();

			//$apConfig=new ApConfig();
			if (strcmp(trim($apConfig->getFwVersion()),trim($apConfig->getFwVersionNext()))==0 && strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 1")==0){
				if($apConfig->getFwVersion()!='20170719.02.fix.bridge' && $apConfig->getFwVersion()!='20170804.02.fix.bridge') {
					$apConfig->setFwUpgrade( "option fw_upgrade 0" );
					$needToSave = 1;
				}
			}
			if (/*$apConfig->getNeedUpdate()!=1 &&*/ strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 0")==0 && strcmp(trim($apConfig->getSsid()),trim($apConfig->getSsidNext()))==0 && strcmp(trim($apConfig->getSsidUpdate()),"option ssid_update 1")==0){
				$apConfig->setSsidUpdate("option ssid_update 0");
				$needToSave=1;
			}
			if (/*$apConfig->getNeedUpdate()!=1 &&*/ strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 0")==0 && strcmp(trim($apConfig->getUamdomains()),trim($apConfig->getUamdomainsNext()))==0 && strcmp(trim($apConfig->getUpdateUamdomains()),"option update_uamdomains 1")==0){
				$apConfig->setUpdateUamdomains("option update_uamdomains 0");
				$needToSave=1;
			}
			if (/*$apConfig->getNeedUpdate()!=1 &&*/ strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 0")==0 && strcmp(trim($apConfig->getUamformat()),trim($apConfig->getUamformatNext()))==0 && strcmp(trim($apConfig->getUpdateUamformat()),"option update_uamformat 1")==0){
				$apConfig->setUpdateUamformat("option update_uamformat 0");
				$needToSave=1;
			}
			if (/*$apConfig->getNeedUpdate()!=1 &&*/ strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 0")==0 && strcmp(trim($apConfig->getUamhomepage()),trim($apConfig->getUamhomepageNext()))==0 && strcmp(trim($apConfig->getUpdateUamhomepage()),"option update_uamhomepage 1")==0){
				$apConfig->setUpdateUamhomepage("option update_uamhomepage 0");
				$needToSave=1;
			}
			if (/*$apConfig->getNeedUpdate()!=1 &&*/ strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 0")==0 && strcmp(trim($apConfig->getMacauth()),trim($apConfig->getMacauthNext()))==0 && strcmp(trim($apConfig->getUpdateMacauth()),"option update_macauth 1")==0){
				$apConfig->setUpdateMacauth("option update_macauth 0");
				$needToSave=1;
			}
			if (/*$apConfig->getNeedUpdate()!=1 &&*/ strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 0")==0 && strcmp(trim($apConfig->getChannel()),trim($apConfig->getChannelNext()))==0 && strcmp(trim($apConfig->getUpdateChannel()),"option channel_update 1")==0){

				$apConfig->setUpdateChannel("option channel_update 0");
				$needToSave=1;
			}
			if (/*$apConfig->getNeedUpdate()!=1 &&*/strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 0")==0 && strcmp(trim($apConfig->getHtmode()),trim($apConfig->getHtmodeNext()))==0&& strcmp(trim($apConfig->getUpdateHtmode()),"option htmode_update 1")==0){
				$apConfig->setUpdateHtmode("option htmode_update 0");
				$needToSave=1;
			}
			if (/*$apConfig->getNeedUpdate()!=1 &&*/strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 0")==0 && strcmp(trim($apConfig->getHwmode()),trim($apConfig->getHwmodeNext()))==0&& strcmp(trim($apConfig->getUpdateHwmode()),"option hwmode_update 1")==0){
				$apConfig->setUpdateHwmode("option hwmode_update 0");
				$needToSave=1;
			}
			if (/*$apConfig->getNeedUpdate()!=1 &&*/strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 0")==0 && strcmp(trim($apConfig->getNoscan()),trim($apConfig->getNoscanNext()))==0&& strcmp(trim($apConfig->getUpdateNoscan()),"option noscan_update 1")==0){
				$apConfig->setUpdateNoscan("option noscan_update 0");
				$needToSave=1;
			}
			if (/*$apConfig->getNeedUpdate()!=1 &&*/strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 0")==0 && strcmp(trim($apConfig->getEncryption()),trim($apConfig->getEncryptionNext()))==0&& strcmp(trim($apConfig->getUpdateEncryption()),"option encryption_update 1")==0){
				$apConfig->setUpdateEncryption("option encryption_update 0");
				$needToSave=1;
			}
			if (/*$apConfig->getNeedUpdate()!=1 &&*/strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 0")==0 && strcmp(trim($apConfig->getKey()),trim($apConfig->getKeyNext()))==0&& strcmp(trim($apConfig->getUpdateKey()),"option key_update 1")==0){
				$apConfig->setUpdateKey("option key_update 0");
				$needToSave=1;
			}
		}
		if($needToSave==1){
			$apConfig->save();
		}
		return $apConfig;
	}
	static public function getAPList($province=null){
		$query="select b.name as name ,concat(b.address) as address,a.province as province,a.lat as lat ,a.lng as lng from accesspoint a,accesspoint_i18n b where a.id=b.id and (a.lat is not null or a.lat !='') and (b.trash is null or b.trash !=1)";
		if(trim($province!=null)){
			$query=$query. "and a.province='".trim($province)."'";
		}
		//var_dump($query);
		$connection = Propel::getConnection();
		$stmt = $connection->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(2);
	}
	static public function isActivated($params){
		$apConfig=ApConfigQuery::create()
		                       ->filterByApMacaddr($params['called'])
		                       ->findOne();
		//$apConfig=new ApConfig();
		if($apConfig)
			return $apConfig->getActivated();
		else
			return true;
	}
	static public function getAPName($mac){
		$apConfig=AccesspointQuery::create()
		                          ->joinWithI18n('vi',Criteria::INNER_JOIN)
		                          ->filterByApMacaddr(trim($mac))
		                          ->findOne();

		if($apConfig)
			return $apConfig->getName();
		else
			return "";
	}
	static public function getAPImage($mac){
		$apConfig=AccesspointQuery::create()
		                          ->joinWithI18n('vi',Criteria::INNER_JOIN)
		                          ->filterByApMacaddr(trim($mac))
		                          ->findOne();

		if($apConfig) {
			if(
				(strpos(strtolower($apConfig->getImage()), "png")!==false)
				||
				(strpos(strtolower($apConfig->getImage()), "jpg")!==false)
				||
				(strpos(strtolower($apConfig->getImage()), "jpeg")!==false)
			)
				return $apConfig->getImage();
			else
				return "";
		}
		else
			return "";
	}
	static public function getAPUrl($mac,$params = array()){
		$apConfig=AccesspointQuery::create()
		                          ->joinWithI18n('vi',Criteria::INNER_JOIN)
		                          ->filterByApMacaddr(trim($mac))
		                          ->findOne();

		$url=$apConfig->getDetailUrl();
		if(!empty($url)) {
				return "/ap/go.html?id=-2" . "&link=" . trim(urlencode(trim($url))) . "&called=" . $params['called'] . "&mac=" . $params['mac'] . "&ip=" . $params['ip'] . "&userurl=" . htmlspecialchars($params['[user_url]']);
		}
		else
			return "";
	}
	static public function getTemplate($mac){
		$apConfig=AccesspointQuery::create()
			//->joinWithI18n('vi',Criteria::INNER_JOIN)
			                      ->filterByApMacaddr(trim($mac))
		                          ->findOne();
		if($apConfig)
			return 'HotspotAccessPointBundle:APConnect:'.$apConfig->getLoginTemplate();
		else
			return "";
	}
	/**
	 * Update new AP and update time
	 */
	static public function updateApInfoAll(){
		$connection = Propel::getConnection();

		$query="insert into accesspoint (ap_macaddr,province,ssid,updated_at,created_at)
				select ap_macaddr,'' as province,ssid,updated_at,created_at  from ap_config where ap_config.ap_macaddr not in
				(select ap_macaddr from accesspoint)";
		$stmt = $connection->prepare($query);
		$stmt->execute();
		/*
		$query="update accesspoint set created_at=(select created_at from ap_config where ap_config.ap_macaddr=accesspoint.ap_macaddr)
				,updated_at=(select updated_at from ap_config where ap_config.ap_macaddr=accesspoint.ap_macaddr)
				,ssid=(select REPLACE(ssid, 'option ssid', '') from ap_config where ap_config.ap_macaddr=accesspoint.ap_macaddr)
				";
		$stmt = $connection->prepare($query);
		$stmt->execute();
		*/
		//////////
		//////////
		$apConfig=AccesspointQuery::create()
		                          ->addAnd("`macaddr`",'`macaddr` is null or `macaddr` =""',Criteria::CUSTOM)
		                          ->find();
		foreach ($apConfig as $ap){
			$a=ApConfigQuery::create()->filterByApMacaddr($ap->getApMacaddr())->findOne();
			if(empty($a)) continue;
			//must revise
			if(false===strpos($a->getFwVersion(), 'bridge.lan.as.wan')){
				$newMac=self::add1ToMac($ap->getApMacaddr());
			}
			else{
				$newMac=self::subtract1ToMac($ap->getApMacaddr());
			}
			//$newMac=self::add1ToMac($ap->getApMacaddr());
			$ap->setMacAddr($newMac);
			//var_dump($newMac);
			$ap->save();
		}
	}
	static public function getOwnerList($username=null){
		$connection = Propel::getConnection();

		$query="select company, name from user where type= 1 group by company,name order by company desc";
		if($username!=null)
			$query="select company,name from user where type= 1 and username='".$username."'group by company,name order by company desc";
		$stmt = $connection->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(2);
	}
	/**
	 * Update AP time from Ads_log
	 */
	static public function updateApTimeFromAds_log($params){
		$connection = Propel::getConnection();

		$query="update accesspoint set created_at=(select max(created_at) as created_at from ads_log where ads_log.ap_macaddr=accesspoint.ap_macaddr)
				,updated_at=(select max(updated_at) as updated_at from ads_log where ads_log.ap_macaddr=accesspoint.ap_macaddr)
				";
		$stmt = $connection->prepare($query);
		$stmt->execute();

		//////////
		//////////
		$apConfig=AccesspointQuery::create()
		                          ->addAnd("`macaddr`",'`macaddr` is null or `macaddr` =""',Criteria::CUSTOM)
		                          ->find();
		foreach ($apConfig as $ap){
			$a=ApConfigQuery::create()->filterByApMacaddr($ap->getApMacaddr())->findOne();
			if(empty($a)) continue;
			//must revise
			if(false===strpos($a->getFwVersion(), 'bridge.lan.as.wan')){
				$newMac=self::add1ToMac($ap->getApMacaddr());
			}
			else{
				$newMac=self::subtract1ToMac($ap->getApMacaddr());
			}
			//$newMac=self::add1ToMac($ap->getApMacaddr());
			$ap->setMacAddr($newMac);
			//var_dump($newMac);
			$ap->save();
		}
	}
	static public function add1ToMac($mac){
		//$mac='A4-2B-B0-AC-78-9C';
		$sub=explode("-",$mac);

		//var_dump($sub[4]);
		//var_dump($sub[5]);
		if(count($sub)<5) return "";
		if($sub[5]=="FF"){
			$sub[5]="00";
			$sub[4]=dechex(hexdec($sub[4])+1);
			if(strlen($sub[4])==1) $sub[4]="0".$sub[4];

		}
		else{
			$sub[5]=dechex(hexdec($sub[5])+1);
			if(strlen($sub[5])==1) $sub[5]="0".$sub[5];
		}

		$newMac=strtoupper(implode("-",$sub));
		//var_dump($newMac);
		return $newMac;
	}
	static public function subtract1ToMac($mac){
		//return self::add1ToMac($mac);
		//$mac='A4-2B-B0-AC-78-9C';
		$sub=explode("-",$mac);
		//var_dump($sub[4]);
		//var_dump($sub[5]);
		if(count($sub)<5) return "";
		if($sub[5]=="00"){
			$sub[5]="FF";
			$sub[4]=dechex(hexdec($sub[4])-1);
			if(strlen($sub[4])==1) $sub[4]="0".$sub[4];

		}
		else{
			$sub[5]=dechex(hexdec($sub[5])-1);
			if(strlen($sub[5])==1) $sub[5]="0".$sub[5];
		}

		$newMac=strtoupper(implode("-",$sub));
		//var_dump($newMac);
		return $newMac;
	}
	static public function getBwProfile($called){
		$apConfig = ApConfigQuery::create()
		                         ->filterByApMacaddr(trim($called))
		                         ->withColumn('bw_profile_id','bw_profile_id')
		                         ->select(array('bw_profile_id','ap_macaddr'))
		                         ->findOne();
		if(!empty($apConfig)){
			$bw_id=$apConfig['bw_profile_id'];
			//dump($bw_id);
			return BwProfileQuery::create()
			                     ->filterById($bw_id)
			                     ->findOne();
		}
		return null;
	}
}