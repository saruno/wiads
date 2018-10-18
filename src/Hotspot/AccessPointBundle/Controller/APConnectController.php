<?php
/*
 * http://127.0.0.1:8000/ap?called=C4-E9-84-F0-69-4C&challenge=c4d69c4cc3188bb1ef8910186bc5df1b&ip=172.16.10.2&mac=98-5A-EB-C6-DE-4B&md=EA353742863A5372379BE0D5F22CFACF&nasid=demogroup_nas01&res=notyet&sessionid=5716e27600000002&uamip=172.16.10.1&uamport=8000&userurl=http%3A%2F%2Fwww.facebook.com%2F
 * https://hotspotwifisystem.com/ap/?
 * called=C4-E9-84-F0-69-4C->Access Point
 * &challenge=c4d69c4cc3188bb1ef8910186bc5df1b
 * &ip=172.16.10.2
 * &mac=98-5A-EB-C6-DE-4B
 * &md=EA353742863A5372379BE0D5F22CFACF
 * &nasid=demogroup_nas01
 * &res=notyet
 * &sessionid=5716e27600000002
 * &uamip=172.16.10.1&uamport=8000
 * &userurl=http%3A%2F%2Fwww.facebook.com%2F
 */
/* Logged In
 * array(32) {
 * ["uamsecret"]=> string(16) "auth_9stub_09123"
 * ["userpassword"]=> int(1)
 * ["title"]=> string(27) "HotspotWifiSystem.com Login"
 * ["centerUsername"]=> string(8) "Username"
 * ["centerPassword"]=> string(8) "Password"
 * ["centerLogin"]=> string(5) "Login"
 * ["centerPleasewait"]=> string(18) "Please wait......."
 * ["centerLogout"]=> string(6) "Logout"
 * ["h1Login"]=> string(27) "HotspotWifiSystem.com Login"
 * ["h1Failed"]=> string(21) "HotspotWifiSystem.com"
 * ["h1Loggedin"]=> string(34) "Logged in to HotspotWifiSystem.com"
 * ["h1Loggingin"]=> string(35) "Logging in to HotspotWifiSystem.com"
 * ["h1Loggedout"]=> string(37) "Logged out from HotspotWifiSystem.com"
 * ["centerdaemon"]=> string(64) "Login must be performed through HotspotWifiSystem.com connection"
 * ["centerencrypted"]=> string(35) "Login must use encrypted connection"
 * ["loginpath"]=> string(16) "/app.php/ap/"
 * ["username"]=> string(0) ""
 * ["password"]=> string(0) ""
 * ["challenge"]=> string(0) ""
 * ["button"]=> string(0) ""
 * ["logout"]=> string(0) ""
 * ["prelogin"]=> string(0) ""
 * ["res"]=> string(7) "success"
 * ["uamip"]=> string(11) "172.16.10.1"
 * ["uamport"]=> string(4) "8000"
 * ["userurl"]=> string(21) "http://www.apple.com/"
 * ["timeleft"]=> string(4) "3600"
 * ["redirurl"]=> string(0) ""
 * ["reply"]=> string(0) ""
 * ["ip"]=> string(12) "172.16.10.11"
 * ["called"]=> string(17) "C4-E9-84-F0-69-4C"
 * ["mac"]=> string(17) "A4-5E-60-D4-FA-AB"
 * ["sessionid"]=> string(16) "57151d9e00000002"
 * ["userurldecode"]=> string(21) "http://www.apple.com/"
 * ["redirurldecode"]=> string(0) ""
 * ["result"]=> int(1) }
 */

namespace Hotspot\AccessPointBundle\Controller;

use AdvertiserBundle\Helper\ProvinceHelper;
use Common\DbBundle\Model\Advert;
use Common\DbBundle\Model\CustomerQuery;
use Common\DbBundle\Model\LocationQuery;
use Common\DbBundle\Model\Promotion;
use Common\DbBundle\Model\PromotionQuery;
use Hotspot\AccessPointBundle\Model\FirmwareQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

use Hotspot\AccessPointBundle\Model\ApConfig;
use Hotspot\AccessPointBundle\Model\ApConfigQuery;
use Hotspot\AccessPointBundle\Helper\ApLogHelper;
use Hotspot\AccessPointBundle\Helper\ApConfigHelper;
use Symfony\Component\Validator\Constraints\Date;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Hotspot\AccessPointBundle\Helper\AdvertHelper;
use Hotspot\AccessPointBundle\Model\AdsLog;
use Common\DbBundle\Model\User;
class APConnectController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('hotspot_login_check'))
            ->setMethod('POST')
            ->getForm();

        return $this->render('HotspotAccessPointBundle:APConnect:report_login.html.twig', array(
            // last username entered by the user
            //'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

	/**
	 * Captival Login
	 * @param Request $request
	 * @param array $params
	 *
	 * @return Response
	 *
	 */
	public function wifiLoginAction(Request $request){
		$api_service = $this->get("accesspoint.service");
		$uamsecret = "auth_9stub_09123";

		$userpassword=1;

		$loginpath = "http://enter.wiads.vn/ap/";//$_SERVER['PHP_SELF']."/ap/";

		/**
		 * config parameters
		 */
		$prefix="WiAds.vn";
		$params = array(
			"uamsecret"=>$uamsecret,
			"userpassword"=>$userpassword,
			"title"=>"$prefix Login",
			"centerUsername"=>"Username",
			"centerPassword"=>"Password",
			"centerLogin"=>"Login",
			"centerPleasewait"=>"Please wait.......",
			"centerLogout"=>"Logout",
			"h1Login"=>"$prefix Login",
			"h1Failed"=>"$prefix",
			"h1Loggedin"=>"Logged in to $prefix",
			"h1Loggingin"=>"Logging in to $prefix",
			"h1Loggedout"=>"Logged out from $prefix",
			"centerdaemon"=>"Login must be performed through $prefix connection",
			"centerencrypted"=>"Login must use encrypted connection",
			"loginpath"=>$loginpath
		);

		//$username	=	$request->get("UserName","");
		//$password	=	$request->get("Password","");
		$challenge	=	$request->get("challenge","");
		$button		=	$request->get("button","");

		$logout		=	$request->get("logout","");
		$prelogin	= 	$request->get("prelogin","");
		$res		=	$request->get("res","");
		$uamip		= 	$request->get("uamip","");
		$uamport	= 	$request->get("uamport","");
		$userurl	= 	$request->get("userurl","");
		$timeleft	= 	$request->get("timeleft","");
		$redirurl	= 	$request->get("redirurl","");
		$reply		= 	$request->get("reply","");
		$ip			= 	$request->get("ip","");
		$called		= 	trim($request->get("called",""));
		$mac		= 	$request->get("mac","");
		$sessionid	=	$request->get("sessionid","");
		$email	    =	$request->get("email","");
		$advertId	=	$request->get("advertId",'-1');

		$userurldecode = $userurl;
		$redirurldecode = $redirurl;

		$bw_profile = ApConfigHelper::getBwProfile($called);
		//dump($bw_profile);
		$username="wiads_free";
		$password="free_wifi_wiads";
		if(!empty($bw_profile)){
			$username=$bw_profile->getUsername();
			$password=$bw_profile->getPassword();
		}

		$mobileDetector = $this->get('mobile_detect.mobile_detector');
		$ua_info = parse_user_agent($mobileDetector->getUserAgent());
		$os=$ua_info['platform'];
		$params = array_merge($params,array(
			'os'=>$os
		));
		$wan_ip = $request->getClientIp();
		if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
			$wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];


		$params = array_merge($params,array(
			"uamsecret"=>$uamsecret,
			"userpassword"=>$userpassword,
			"username"=>$username,
			"password"=>$password,
			"challenge"=>$challenge,
			"button"=>$button,
			"logout"=>$logout,
			"prelogin"=>$prelogin,
			"res"=>$res,
			"uamip"=>$uamip,
			"uamport"=>$uamport,
			"userurl"=>$userurl,
			"timeleft"=>$timeleft,
			"redirurl"=>$redirurl,
			"reply"=>$reply,
			"ip"	=>$ip,
			"wan_ip"    => $wan_ip,
			"called" => $called,
			"mac"	=>$mac,
			"sessionid" =>$sessionid,
			"advertId"=>$advertId,
			"userurldecode"=>$userurldecode,
			"redirurldecode"=>$redirurldecode,
			"email"=>$email
		));

		$hexchal = pack("H32", $challenge);
		if ($uamsecret) {
			$newchal = pack ("H*", md5($hexchal . $uamsecret));
		} else {
			$newchal = $hexchal;
		}
		$response = md5("\0" . $password . $newchal);
		$newpwd = pack("a32", $password);
		$pappassword = implode ("", unpack("H32", ($newpwd ^ $newchal)));

		$params = array_merge($params,array(
			"response"=>$response,
			"pappassword"=>$pappassword
		));
		/** @var Advert $adv */
		//Query quảng cáo, bước này chỉ để làm màu, ko có ý nghĩa gì cả
		$adv=AdvertHelper::getWantedDisplayAds($params);
		if(empty($adv)){
			$params['userurl']="230"."___".$challenge."___".$userurl;
		}
		else{
			$params['userurl']=$adv->getId()."___".$challenge."___".$userurl;
		}
		$params['[user_url]']=$params['userurl'];
		if($params['called']=='C4-E9-84-F0-69-4C' || $params['called']=='EC-08-6B-89-DD-AF') {
			$loginpath = "http://welcome.hotspotwifisystem.com/ap/";
			$params['loginpath']=$loginpath;
		}
		//var_dump(ApConfigHelper::isActivated($params));
        //Kiểm tra nếu accesspoint không được activated thì khóa
		if(ApConfigHelper::isActivated($params)!=true){
			//return $this->render('HotspotAccessPointBundle:APConnect:not_activated.html.twig',$params);
			//$url = $this->generateUrl('hotspot_access_point_homepage_not_activated',$params);
			//$params['request']=$request;
			return $this->redirectToRoute('hotspot_access_point_homepage_not_activated');
			//	array('request' => $request),307);
		}

		$adsCookie=$params['sessionid'].rand();
		$adsCookieTime=time() + 2592000; //3600*24*30;
		$cookie=$request->cookies->get('adsCookie',0);
		if ($cookie!=0)
			$adsCookie=$cookie;
		$params = array_merge($params,array('adsCookie'=>$adsCookie));

		$params = array_merge($params,array(
			'apName'=>ApConfigHelper::getAPName($params['called']),
			'apImage'=>ApConfigHelper::getAPImage($params['called']),
			'apUrl'=>ApConfigHelper::getAPUrl($params['called'],$params),
            'apSlides'=>ApConfigHelper::getAPSlideImgs($params['called'])
		));
		//Quy dinh
		//QA0:1242x698
		//QA1: 842x740
		//QA2: 401x590
		//QA0_v4: 300x600
		//QA1_v4,QA2_v4: 336x280
		//QA3_v4: 300x250
		//QA4_v4: 335x114
		//QAF_v4: full screen ads
		//QAF_M:  MEGANET
		//QAF_VLP:  VALUEPOINT
		$params0_v3 = array(
			'os' => $params['os'],
			'called'=>$params['called'],
			'phase'=>'login',
			'position'=>"QA0");
		$ads0_v3=AdvertHelper::getAds($params0_v3);
		//
		$params1_v3=array(
			'os' => $params['os'],
			'called'=>$params['called'],
			'phase'=>'login',
			'position'=>"QA1");
		$ads1_v3=AdvertHelper::getAds($params1_v3);
		//
		$params2_v3=array(
			'os' => $params['os'],
			'called'=>$params['called'],
			'phase'=>'login',
			'position'=>"QA2");
		$ads2_v3=AdvertHelper::getAds($params2_v3);
		//
		$params0_v4 = array(
			'os' => $params['os'],
			'called'=>$params['called'],
			'phase'=>'login',
			'position'=>"QA0_v4");
		$ads0_v4=AdvertHelper::getAds($params0_v4);
		//
		$params1_v4=array(
			'os' => $params['os'],
			'called'=>$params['called'],
			'phase'=>'login',
			'position'=>"QA1_v4");
		$ads1_v4=AdvertHelper::getAds($params1_v4);
		//
		$params2_v4=array(
			'os' => $params['os'],
			'called'=>$params['called'],
			'phase'=>'login',
			'position'=>"QA2_v4");
		$ads2_v4=AdvertHelper::getAds($params2_v4);
		//
		$params3_v4=array(
			'os' => $params['os'],
			'called'=>$params['called'],
			'phase'=>'login',
			'position'=>"QA3_v4");
		$ads3_v4=AdvertHelper::getAds($params3_v4);
		//
		$params4_v4=array(
			'os' => $params['os'],
			'called'=>$params['called'],
			'phase'=>'login',
			'position'=>"QA4_v4");
		$ads4_v4=AdvertHelper::getAds($params4_v4);
		$paramsf_v4=array(
			'os' => $params['os'],
			'called'=>$params['called'],
			'phase'=>'login',
			'position'=>"QAF_v4");
		$adsf_v4=AdvertHelper::getAds($paramsf_v4);
		$paramsf_m=array(
			'os' => $params['os'],
			'called'=>$params['called'],
			'phase'=>'login',
			'position'=>"QAF_M");
		$adsf_m=AdvertHelper::getAds($paramsf_m);
		$paramsf_vlp=array(
			'os' => $params['os'],
			'called'=>$params['called'],
			'phase'=>'login',
			'position'=>"QAF_VLP");
		$adsf_m=AdvertHelper::getAds($paramsf_vlp);
		//
		//
		//
		$ads=array();
		if(!empty($ads0_v3)) {
			foreach ($ads0_v3 as $ad) {
				$ads['QA0'] = $ad;
			}
		}else{
			$ads['QA0']=null;
		}
		if(!empty($ads1_v3)) {
			foreach ($ads1_v3 as $ad) {
				$ads['QA1'] = $ad;
			}
		}else{
			$ads['QA1']=null;
		}
		if(!empty($ads2_v3)) {
			foreach ($ads2_v3 as $ad) {
				$ads['QA2'] = $ad;
			}
		}else{
			$ads['QA2']=null;
		}
		if(!empty($ads0_v4)) {
			foreach ($ads0_v4 as $ad) {
				$ads['QA0_v4'] = $ad;
			}
		}else{
			$ads['QA0_v4']=null;
		}
		if(!empty($ads1_v4)) {
			foreach ($ads1_v4 as $ad) {
				$ads['QA1_v4'] = $ad;
			}
		}else{
			$ads['QA1_v4']=null;
		}
		if(!empty($ads2_v4)) {
			foreach ($ads2_v4 as $ad) {
				$ads['QA2_v4'] = $ad;
			}
		}else{
			$ads['QA2_v4']=null;
		}
		if(!empty($ads3_v4)) {
			foreach ($ads3_v4 as $ad) {
				$ads['QA3_v4'] = $ad;
			}
		}else{
			$ads['QA3_v4']=null;
		}
		if(!empty($ads4_v4)) {
			foreach ($ads4_v4 as $ad) {
				$ads['QA4_v4'] = $ad;
			}
		}else{
			$ads['QA4_v4']=null;
		}
		if(!empty($adsf_v4)) {
			foreach ($adsf_v4 as $ad) {
				$ads['QAF_v4'] = $ad;
			}
		}else{
			$ads['QAF_v4']=null;
		}
		if(!empty($adsf_m)) {
			foreach ($adsf_m as $ad) {
				$ads['QAF_M'] = $ad;
			}
		}else{
			$ads['QAF_M']=null;
		}
		if(!empty($adsf_vlp)) {
			foreach ($adsf_vlp as $ad) {
				$ads['QAF_VLP'] = $ad;
			}
		}else{
			$ads['QAF_VLP']=null;
		}
		//dump($ads);
		//////////////////////////////////////////
		//var_dump($params);
		//FOR CPA
		$template = ApConfigHelper::getTemplate($params['called']);
		if(empty($template))
			$template = 'HotspotAccessPointBundle:APConnect:' . trim($params['called'] . '.html.twig');

		$is_privated=($template=='HotspotAccessPointBundle:APConnect:'.$params['called'].".html.twig");
		if($is_privated && !$this->get('templating')->exists($template)){
			$template = 'HotspotAccessPointBundle:APConnect:captival_full_screen_v6.html.twig';
		}

		//$rand=rand(0, 3);
		//get wanted ads
		$position="QAF_v4";
		$adv=AdvertHelper::getWantedDisplayAds($params);
		if(!empty($adv)) {
			$position = $adv->getHomePosition();
			if($position=="QAF_v4") $ads['QAF_v4']=$adv;
			if($position=="QAF_M") $ads['QAF_M']=$adv;
			if($position=="QAF_VLP") $ads['QAF_VLP']=$adv;
			if($position=="QA0_v4") $ads['QA0_v4']=$adv;
			if($position=="QA1_v4") $ads['QA1_v4']=$adv;
			if($position=="QA2_v4") $ads['QA2_v4']=$adv;
			if($position=="QA3_v4") $ads['QA3_v4']=$adv;
			if($position=="QA4_v4") $ads['QA4_v4']=$adv;
			if($position=="QA0") $ads['QA0']=$adv;
			if($position=="QA1") $ads['QA1']=$adv;
			if($position=="QA2") $ads['QA2']=$adv;
		}
		if ( !$this->get('templating')->exists($template) ){
			if($position=="QAF_v4") {
				$template = 'HotspotAccessPointBundle:APConnect:captival_full_screen_v6.html.twig';
				//if(!empty($adv) &&  $adv->getId()>=130 && $adv->getId()<=135 && AdvertHelper::checkEmailCollection($params)){
				//    $template = 'HotspotAccessPointBundle:APConnect:captival_full_screen_v4_ibig.html.twig';
				//}
			}

			elseif($position=="QAF_M")
				$template='HotspotAccessPointBundle:APConnect:captival_meganet.html.twig';
			//elseif($position=="QAF_VLP")
			//    $template='HotspotAccessPointBundle:APConnect:captival_vlp.html.twig';
			elseif($position=="QA0" || $position=="QA1" || $position=="QA2")
				$template='HotspotAccessPointBundle:APConnect:captival_v3.html.twig';
			else
				$template='HotspotAccessPointBundle:APConnect:captival_v4.html.twig';
		}
		//Direct login
		//if($params['called']=='EC-08-6B-89-DD-B0'){
		if( empty($template)
		    || (!$is_privated && $template == 'HotspotAccessPointBundle:APConnect:captival_full_screen_v6.html.twig')
		    || (!$is_privated && $template == 'HotspotAccessPointBundle:APConnect:captival_v6.html.twig')
		){
			if(!empty($adv)){
				$params['advertId'] = $adv->getId();
			}
			else {
				$params['advertId'] = 230;
			}
			//ghi log view
			//self::parseAndWriteTrack($request);
			//return $this->render('HotspotAccessPointBundle:APConnect:captival_direct_login.html.twig', $params);
		}
		if($params['advertId']==195){
			$params['position']="QAF_VLP";
			$ads=AdvertHelper::getAds($params);
			$linkTo=ApConfigHelper::getAPUrl($params['called'],$params);
			$template = "HotspotAccessPointBundle:APConnect:captival_vlp.success.html.twig";
			//$url = $request->getUri();
			//if(strpos($url, 'http://125.212.233.15/ap/')!==false){
			//return $this->redirect($this->generateUrl('hotspot_access_point_homepage', array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'adv' => $adv, 'linkTo'=>$linkTo)));
			//}
			//else
			//return $this->render($template,array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'adv' => $adv, 'linkTo'=>$linkTo) );
		}

		if($template == 'HotspotAccessPointBundle:APConnect:captival_full_screen_v4.html.twig'){
			$template = 'HotspotAccessPointBundle:APConnect:captival_full_screen_v6.html.twig';
		}
		$response =  $this->render($template,array('params' =>$params,'ads'=>$ads));

		$response->headers->setCookie(new Cookie('adsCookie', $adsCookie,$adsCookieTime));

		return $response;

	}
	public function wifiLoginSuccessAction(Request $request){
		$api_service = $this->get("accesspoint.service");
		$uamsecret = "auth_9stub_09123";

		$userpassword=1;

		$loginpath = "http://enter.wiads.vn/ap/";//$_SERVER['PHP_SELF']."/ap/";

		/**
		 * config parameters
		 */
		$prefix="WiAds.vn";
		$params = array(
			"uamsecret"=>$uamsecret,
			"userpassword"=>$userpassword,
			"title"=>"$prefix Login",
			"centerUsername"=>"Username",
			"centerPassword"=>"Password",
			"centerLogin"=>"Login",
			"centerPleasewait"=>"Please wait.......",
			"centerLogout"=>"Logout",
			"h1Login"=>"$prefix Login",
			"h1Failed"=>"$prefix",
			"h1Loggedin"=>"Logged in to $prefix",
			"h1Loggingin"=>"Logging in to $prefix",
			"h1Loggedout"=>"Logged out from $prefix",
			"centerdaemon"=>"Login must be performed through $prefix connection",
			"centerencrypted"=>"Login must use encrypted connection",
			"loginpath"=>$loginpath
		);

		//$username	=	$request->get("UserName","");
		//$password	=	$request->get("Password","");
		$challenge	=	$request->get("challenge","");
		$button		=	$request->get("button","");

		$logout		=	$request->get("logout","");
		$prelogin	= 	$request->get("prelogin","");
		$res		=	$request->get("res","");
		$uamip		= 	$request->get("uamip","");
		$uamport	= 	$request->get("uamport","");
		$userurl	= 	$request->get("userurl","");
		$timeleft	= 	$request->get("timeleft","");
		$redirurl	= 	$request->get("redirurl","");
		$reply		= 	$request->get("reply","");
		$ip			= 	$request->get("ip","");
		$called		= 	trim($request->get("called",""));
		$mac		= 	$request->get("mac","");
		$sessionid	=	$request->get("sessionid","");
		$email	    =	$request->get("email","");
		$advertId	=	$request->get("advertId",'-1');
		$recall     =   $request->get("recall", 'false'); //Duoc truyen vao khi advertId = -3

		$userurldecode = $userurl;
		$redirurldecode = $redirurl;

		$bw_profile = ApConfigHelper::getBwProfile($called);
		//dump($bw_profile);
		$username="wiads_free";
		$password="free_wifi_wiads";
		if(!empty($bw_profile)){
			$username=$bw_profile->getUsername();
			$password=$bw_profile->getPassword();
		}

		$mobileDetector = $this->get('mobile_detect.mobile_detector');
		$ua_info = parse_user_agent($mobileDetector->getUserAgent());
		$os=$ua_info['platform'];
		$params = array_merge($params,array(
			'os'=>$os
		));
		$wan_ip = $request->getClientIp();
		if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
			$wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];


		$params = array_merge($params,array(
			"uamsecret"=>$uamsecret,
			"userpassword"=>$userpassword,
			"username"=>$username,
			"password"=>$password,
			"challenge"=>$challenge,
			"button"=>$button,
			"logout"=>$logout,
			"prelogin"=>$prelogin,
			"res"=>$res,
			"uamip"=>$uamip,
			"uamport"=>$uamport,
			"userurl"=>$userurl,
			"timeleft"=>$timeleft,
			"redirurl"=>$redirurl,
			"reply"=>$reply,
			"ip"	=>$ip,
			"wan_ip"    => $wan_ip,
			"called" => $called,
			"mac"	=>$mac,
			"sessionid" =>$sessionid,
//			"advertId"=>$advertId,
			"userurldecode"=>$userurldecode,
			"redirurldecode"=>$redirurldecode,
			"email"=>$email
		));

		$adsCookie=$sessionid.rand();
		$adsCookieTime=time() + 2592000; //3600*24*30;
		$cookie=$request->cookies->get('adsCookie',0);

		if ($cookie!=0)
			$adsCookie=$cookie;
		$params = array_merge($params,array('adsCookie'=>$adsCookie));

		$urlEx=explode("___",$params['userurl']);//contain advertId
        if ($recall != 'true') {
            $advertId = $urlEx[0];
            $params['advertId'] = $advertId;
        }
		$params['challenge']=$urlEx[1];
		$params['[user_url]']=end($urlEx);

		//Tang click count của ads_daily_counting
		$responses = $this->forward('HotspotAccessPointBundle:Advert:callSuccessAds', array('request'=>$request,'params' =>$params));


		$params = array_merge($params,array(
			'phase'=>'login',
			'position'=>"QAF_v4",

			'limit'=>'1'
		));

		$apInfo = ApConfigHelper::getAPInfo($params['called']);
		$detailUrl = $apInfo->getDetailUrl();

		$params = array_merge($params,array(
			'apName'=>ApConfigHelper::getAPName($params['called']),
			'apImage'=>ApConfigHelper::getAPImage($params['called']),
			'apUrl'=>ApConfigHelper::getAPUrl($params['called'],$params),
            'apDetailUrl'=> $detailUrl
		));

		//
		if(trim($called)=='C0-4A-00-E9-FB-99' || trim($called)=='C0-4A-00-E9-FB-9A'){
			return $this->redirect("http://huebooking.vn",301);
		}
		//
        //Quảng cáo được lấy trực tiếp từ id của quảng cáo truyền vào
		$adv=AdvertHelper::getAdvById($advertId);
        //Quảng cáo được truy vấn từ thông tin : mac_addr, platform, ads_location của accesspoint
		$ads=AdvertHelper::getAds($params);
		//
		if(empty($adv) && !empty($ads))
			$adv=$ads[0];
		if(!empty($adv)){
			$ads[0]=$adv;
		}
		$template = ApConfigHelper::getTemplate($params['called']);
		$is_privated=($template=='HotspotAccessPointBundle:APConnect:'.$params['called'].".html.twig");
		if(!empty($template))
			$template = explode("html.twig",$template)[0]."success.html.twig";

		if(!$this->get('templating')->exists($template)){
			//$template = 'HotspotAccessPointBundle:APConnect:success_fullscreen_ads.html.twig';
			$template = 'HotspotAccessPointBundle:APConnect:captival_full_screen_v6.success.html.twig';
		}
		/*
		if($advertId==195){
			$params['position']="QAF_VLP";
			$ads=AdvertHelper::getAds($params);
			$linkTo=ApConfigHelper::getAPUrl($params['called'],$params);
			$template = "HotspotAccessPointBundle:APConnect:captival_vlp.success.html.twig";
			//$url = $request->getUri();
			//if(strpos($url, 'http://125.212.233.15/ap/')!==false){
			//return $this->redirect($this->generateUrl('hotspot_access_point_homepage', array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'adv' => $adv, 'linkTo'=>$linkTo)));
			//}
			//else
			return $this->render($template,array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'adv' => $adv, 'linkTo'=>$linkTo) );
		}
		if($advertId==230){
			$params['position']="QAF_V4";
			$ads=AdvertHelper::getAds($params);
			$linkTo=ApConfigHelper::getAPUrl($params['called']);
			$template = "HotspotAccessPointBundle:APConnect:meganet_05_2017.success.html.twig";
			//$url = $request->getUri();
			//if(strpos($url, 'http://125.212.233.15/ap/')!==false){
			//return $this->redirect($this->generateUrl('hotspot_access_point_homepage', array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'adv' => $adv, 'linkTo'=>$linkTo)));
			//}
			//else
			return $this->render($template,array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'adv' => $adv, 'linkTo'=>$linkTo) );
		}
		*/
		if($advertId==-3){
		    //Click vao nut Đăng nhập & Share Facebook o captival_fblogin_v3 de chuyen sang trang captival_fblogin_v3.success
		    $tempUrl='http://enter.wiads.vn/ap/?recall=true&called=' . $called . '&ip='.$ip . '&mac=' . $mac
                . '&md=F7BA0A6206F6C499AE0877D697CBF208&nasid=wiads_nasid&res=success&sessionid=' . $sessionid . '&timeleft=' . $timeleft
                . '&uamip=' . $uamip . '&uamport=' . $uamport . '&uid=wiads_free_unlimited&userurl=' . htmlspecialchars($params['userurl']);
            $linkTo = "/ap/go.html?id=-2" . "&link=" . trim(urlencode(trim($tempUrl))) . "&called=" . $params['called'] . "&mac=" . $params['mac'] . "&ip=" . $params['ip'] . "&userurl=" . htmlspecialchars($params['[user_url]']);
            return $this->redirect($linkTo,301);
        }
        //Mac dinh ko co advertId thi advertId = -1
		if($advertId==-2){
			$linkTo=ApConfigHelper::getAPUrl($params['called'],$params);

			if(!empty($linkTo))
				return $this->redirect($linkTo,301);
			if ($this->get('templating')->exists($template) ){
				return $this->render($template,array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'adv' => $adv, 'linkTo'=>$linkTo) );
			}
			if(empty($linkTo) && !empty($ads)){
				$linkTo=AdvertHelper::getAdvLink($ads[0]->getId(), $params);
				return $this->render($template,array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'adv' => $adv, 'linkTo'=>$linkTo) );
			}
			else {
				if(!empty($adv) && $adv->getHomePosition()=='QAF_v4') {
					return $this->render($template, array('responses' => $responses, 'params' => $params, 'ads' => $ads,'adv' => $adv,  'linkTo' => $linkTo));
				}
				else{
					return $this->render($template, array('responses' => $responses, 'params' => $params, 'ads' => $ads,'adv' => $adv,  'linkTo' => $linkTo));
				}
			}
		}
		if($advertId==-1 && !empty($ads)){
		    //Nếu click vào nút Kết nối và danh sách quảng cáo truy vấn từ params mà ko rỗng
			$linkTo="";
			if(empty($linkTo))
				$linkTo=AdvertHelper::getAdvLink($ads[0]->getId(), $params);
			if(!empty($adv))
				$linkTo=$linkTo."&id=".$adv->getId();
			return $this->render($template,array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'adv' => $adv, 'linkTo'=>$linkTo) );
		}
		else{
			$linkTo= AdvertHelper::getAdvLink($advertId,$params);
		}
		//// MEGANET
		//if($advertId==103 || $linkTo=='[user_url]'){
		/*
		if($advertId==103){
			AdvertHelper::writeDirectClickTrack($this, $request,$params);
			return $this->redirect(urldecode($params['[user_url]']));
		}
		*/
		//when user click an ads from system
		if(!empty($linkTo) && $advertId!=-1) {
			return $this->redirect($linkTo,301);
		}
		//if not, redirect to success page
		else{
			//return $this->render('HotspotAccessPointBundle:APConnect:success_ads_rows.html.twig',array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'linkTo'=>$linkTo) );
			//return $this->render('HotspotAccessPointBundle:APConnect:success_blank_v5.html.twig',array('responses'=>$responses,'params' =>$params,'adv' => $adv,'ads'=>$ads,'linkTo'=>$linkTo) );
			return $this->render($template,array('responses'=>$responses,'params' =>$params,'adv' => $adv,'ads'=>$ads,'linkTo'=>$linkTo) );
		}
		//For CPA
		//return $this->render('HotspotAccessPointBundle:APConnect:success_ads_rows.html.twig',array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'linkTo'=>$linkTo) );
		/*
		if($params['called']=='EC-08-6B-89-DD-AF')
			return $this->render('HotspotAccessPointBundle:APConnect:success_ads.html.twig',array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'linkTo'=>$linkTo) );
		else
		//for CPI
		return $this->redirect($linkTo);
		*/
	}
	public function wifiLoginSuccessFailed(Request $request){
		$api_service = $this->get("accesspoint.service");
		$uamsecret = "auth_9stub_09123";

		$userpassword=1;

		$loginpath = "http://enter.wiads.vn/ap/";//$_SERVER['PHP_SELF']."/ap/";

		/**
		 * config parameters
		 */
		$prefix="WiAds.vn";
		$params = array(
			"uamsecret"=>$uamsecret,
			"userpassword"=>$userpassword,
			"title"=>"$prefix Login",
			"centerUsername"=>"Username",
			"centerPassword"=>"Password",
			"centerLogin"=>"Login",
			"centerPleasewait"=>"Please wait.......",
			"centerLogout"=>"Logout",
			"h1Login"=>"$prefix Login",
			"h1Failed"=>"$prefix",
			"h1Loggedin"=>"Logged in to $prefix",
			"h1Loggingin"=>"Logging in to $prefix",
			"h1Loggedout"=>"Logged out from $prefix",
			"centerdaemon"=>"Login must be performed through $prefix connection",
			"centerencrypted"=>"Login must use encrypted connection",
			"loginpath"=>$loginpath
		);

		//$username	=	$request->get("UserName","");
		//$password	=	$request->get("Password","");
		$challenge	=	$request->get("challenge","");
		$button		=	$request->get("button","");

		$logout		=	$request->get("logout","");
		$prelogin	= 	$request->get("prelogin","");
		$res		=	$request->get("res","");
		$uamip		= 	$request->get("uamip","");
		$uamport	= 	$request->get("uamport","");
		$userurl	= 	$request->get("userurl","");
		$timeleft	= 	$request->get("timeleft","");
		$redirurl	= 	$request->get("redirurl","");
		$reply		= 	$request->get("reply","");
		$ip			= 	$request->get("ip","");
		$called		= 	trim($request->get("called",""));
		$mac		= 	$request->get("mac","");
		$sessionid	=	$request->get("sessionid","");
		$email	    =	$request->get("email","");
		$advertId	=	$request->get("advertId",'-1');

		$userurldecode = $userurl;
		$redirurldecode = $redirurl;

		$bw_profile = ApConfigHelper::getBwProfile($called);
		//dump($bw_profile);
		$username="wiads_free";
		$password="free_wifi_wiads";
		if(!empty($bw_profile)){
			$username=$bw_profile->getUsername();
			$password=$bw_profile->getPassword();
		}

		$mobileDetector = $this->get('mobile_detect.mobile_detector');
		$ua_info = parse_user_agent($mobileDetector->getUserAgent());
		$os=$ua_info['platform'];
		$params = array_merge($params,array(
			'os'=>$os
		));
		$wan_ip = $request->getClientIp();
		if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
			$wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];


		$params = array_merge($params,array(
			"uamsecret"=>$uamsecret,
			"userpassword"=>$userpassword,
			"username"=>$username,
			"password"=>$password,
			"challenge"=>$challenge,
			"button"=>$button,
			"logout"=>$logout,
			"prelogin"=>$prelogin,
			"res"=>$res,
			"uamip"=>$uamip,
			"uamport"=>$uamport,
			"userurl"=>$userurl,
			"timeleft"=>$timeleft,
			"redirurl"=>$redirurl,
			"reply"=>$reply,
			"ip"	=>$ip,
			"wan_ip"    => $wan_ip,
			"called" => $called,
			"mac"	=>$mac,
			"sessionid" =>$sessionid,
			"advertId"=>$advertId,
			"userurldecode"=>$userurldecode,
			"redirurldecode"=>$redirurldecode,
			"email"=>$email
		));
		$adsCookie=$sessionid.rand();
		$adsCookieTime=time() + 2592000; //3600*24*30;
		$cookie=$request->cookies->get('adsCookie',0);

		if ($cookie!=0)
			$adsCookie=$cookie;
		$params = array_merge($params,array('adsCookie'=>$adsCookie));

		$response_callLoginFail = $this->forward('HotspotAccessPointBundle:Advert:callFailAds', array('request'=>$request,'params' => $params));
		$result=json_decode($response_callLoginFail, true);
		if($result['code']==1){
			return $this->render('HotspotAccessPointBundle:APConnect:index.html.twig',$params);
		}

		$params = array_merge($params,array(
			'apName'=>ApConfigHelper::getAPName($params['called']),
			'apImage'=>ApConfigHelper::getAPImage($params['called'])
		));
		//Quy dinh
		//QA0:1242x698
		//QA1: 842x740
		//QA2: 401x590
		//QA0_v4: 300x600
		//QA1_v4,QA2_v4: 336x280
		//QA3_v4: 300x250
		//QA4_v4: 335x114
		//QAF_v4: full screen ads
		//QAF_M:  MEGANET
		//QAF_VLP:  VALUEPOINT
		$params0_v3 = array(
			'os' => $params['os'],
			'called'=>$called,
			'phase'=>'login',
			'position'=>"QA0");
		$ads0_v3=AdvertHelper::getAds($params0_v3);
		//dump($ads0_v3);
		//
		$params1_v3=array(
			'os' => $params['os'],
			'called'=>$called,
			'phase'=>'login',
			'position'=>"QA1");
		$ads1_v3=AdvertHelper::getAds($params1_v3);
		//
		$params2_v3=array(
			'os' => $params['os'],
			'called'=>$called,
			'phase'=>'login',
			'position'=>"QA2");
		$ads2_v3=AdvertHelper::getAds($params2_v3);
		//
		$params0_v4 = array(
			'os' => $params['os'],
			'called'=>$called,
			'phase'=>'login',
			'position'=>"QA0_v4");
		$ads0_v4=AdvertHelper::getAds($params0_v4);
		//
		$params1_v4=array(
			'os' => $params['os'],
			'called'=>$called,
			'phase'=>'login',
			'position'=>"QA1_v4");
		$ads1_v4=AdvertHelper::getAds($params1_v4);
		//
		$params2_v4=array(
			'os' => $params['os'],
			'called'=>$called,
			'phase'=>'login',
			'position'=>"QA2_v4");
		$ads2_v4=AdvertHelper::getAds($params2_v4);
		//
		$params3_v4=array(
			'os' => $params['os'],
			'called'=>$called,
			'phase'=>'login',
			'position'=>"QA3_v4");
		$ads3_v4=AdvertHelper::getAds($params3_v4);
		//
		$params4_v4=array(
			'os' => $params['os'],
			'called'=>$called,
			'phase'=>'login',
			'position'=>"QA4_v4");
		$ads4_v4=AdvertHelper::getAds($params4_v4);
		$paramsf_v4=array(
			'os' => $params['os'],
			'called'=>$called,
			'phase'=>'login',
			'position'=>"QAF_v4");
		$adsf_v4=AdvertHelper::getAds($paramsf_v4);
		$paramsf_m=array(
			'os' => $params['os'],
			'called'=>$called,
			'phase'=>'login',
			'position'=>"QAF_M");
		$adsf_m=AdvertHelper::getAds($paramsf_m);
		$paramsf_vlp=array(
			'os' => $params['os'],
			'called'=>$called,
			'phase'=>'login',
			'position'=>"QAF_VLP");
		$adsf_m=AdvertHelper::getAds($paramsf_vlp);
		//
		//
		//
		$ads=array();
		if(!empty($ads0_v3)) {
			foreach ($ads0_v3 as $ad) {
				$ads['QA0'] = $ad;
			}
		}else{
			$ads['QA0']=null;
		}
		if(!empty($ads1_v3)) {
			foreach ($ads1_v3 as $ad) {
				$ads['QA1'] = $ad;
			}
		}else{
			$ads['QA1']=null;
		}
		if(!empty($ads2_v3)) {
			foreach ($ads2_v3 as $ad) {
				$ads['QA2'] = $ad;
			}
		}else{
			$ads['QA2']=null;
		}
		if(!empty($ads0_v4)) {
			foreach ($ads0_v4 as $ad) {
				$ads['QA0_v4'] = $ad;
			}
		}else{
			$ads['QA0_v4']=null;
		}
		if(!empty($ads1_v4)) {
			foreach ($ads1_v4 as $ad) {
				$ads['QA1_v4'] = $ad;
			}
		}else{
			$ads['QA1_v4']=null;
		}
		if(!empty($ads2_v4)) {
			foreach ($ads2_v4 as $ad) {
				$ads['QA2_v4'] = $ad;
			}
		}else{
			$ads['QA2_v4']=null;
		}
		if(!empty($ads3_v4)) {
			foreach ($ads3_v4 as $ad) {
				$ads['QA3_v4'] = $ad;
			}
		}else{
			$ads['QA3_v4']=null;
		}
		if(!empty($ads4_v4)) {
			foreach ($ads4_v4 as $ad) {
				$ads['QA4_v4'] = $ad;
			}
		}else{
			$ads['QA4_v4']=null;
		}
		if(!empty($adsf_v4)) {
			foreach ($adsf_v4 as $ad) {
				$ads['QAF_v4'] = $ad;
			}
		}else{
			$ads['QAF_v4']=null;
		}
		if(!empty($adsf_m)) {
			foreach ($adsf_m as $ad) {
				$ads['QAF_M'] = $ad;
			}
		}else{
			$ads['QAF_M']=null;
		}
		if(!empty($adsf_vlp)) {
			foreach ($adsf_vlp as $ad) {
				$ads['QAF_VLP'] = $ad;
			}
		}else{
			$ads['QAF_VLP']=null;
		}
		//dump($ads);
		//////////////////////////////////////////
		//var_dump($params);
		//FOR CPA
		$template = ApConfigHelper::getTemplate($params['called']);
		if(empty($template))
			$template = 'HotspotAccessPointBundle:APConnect:' . trim($params['called'] . '.html.twig');

		//$rand=rand(0, 3);
		//get wanted ads
		$position="QAF_v4";
		$adv=AdvertHelper::getWantedDisplayAds($params);
		//dump($adv);
		if(!empty($adv)) {
			$position = $adv->getHomePosition();
			if($position=="QAF_v4") $ads['QAF_v4']=$adv;
			if($position=="QAF_M") $ads['QAF_M']=$adv;
			if($position=="QAF_VLP") $ads['QAF_VLP']=$adv;
			if($position=="QA0_v4") $ads['QA0_v4']=$adv;
			if($position=="QA1_v4") $ads['QA1_v4']=$adv;
			if($position=="QA2_v4") $ads['QA2_v4']=$adv;
			if($position=="QA3_v4") $ads['QA3_v4']=$adv;
			if($position=="QA4_v4") $ads['QA4_v4']=$adv;
			if($position=="QA0") $ads['QA0']=$adv;
			if($position=="QA1") $ads['QA1']=$adv;
			if($position=="QA2") $ads['QA2']=$adv;
		}
		if ( !$this->get('templating')->exists($template) ){
			if($position=="QAF_v4") {
				$template = 'HotspotAccessPointBundle:APConnect:captival_full_screen_v6.html.twig';
				//if(!empty($adv) &&  $adv->getId()>=130 && $adv->getId()<=135 && AdvertHelper::checkEmailCollection($params)){
				//    $template = 'HotspotAccessPointBundle:APConnect:captival_full_screen_v4_ibig.html.twig';
				//}
			}

			elseif($position=="QAF_M")
				$template='HotspotAccessPointBundle:APConnect:captival_meganet.html.twig';
			elseif($position=="QAF_VLP")
				$template='HotspotAccessPointBundle:APConnect:captival_vlp.html.twig';
			elseif($position=="QA0" || $position=="QA1" || $position=="QA2")
				$template='HotspotAccessPointBundle:APConnect:captival_v3.html.twig';
			else
				$template='HotspotAccessPointBundle:APConnect:captival_v4.html.twig';
			/*
			if($rand==0 && isset($ads['QAF_v4']) && !AdvertHelper::isDailyLimit($ads['QAF_v4']->getId())) {
			//if($rand==0) {
				$template='HotspotAccessPointBundle:APConnect:captival_full_screen_v4.html.twig';
			}
			*/
		}
		//$template='HotspotAccessPointBundle:APConnect:captival_fullscreen_v2.html.twig';
		//NHAT AP
		/*
		if($params['called']=='EC-08-6B-89-DD-B0'){
			$adsf_m=AdvertHelper::getAds_Dev($paramsf_m);
			if(!empty($adsf_m))
				foreach ($adsf_m as $ad){
					$ads['QAF_M']=$ad;
				}
			$template='HotspotAccessPointBundle:APConnect:captival_meganet.html.twig';
		}
		*/
		$response = $this->render($template,array('responses'=>$response_callLoginFail,'params' =>$params,'ads'=>$ads));
		$response->headers->setCookie(new Cookie('adsCookie', $adsCookie,$adsCookieTime));
		return $response;
	}
	/**
	 *
	 * @param Request $request
	 *
	 * @return string|Response
	 */
    public function indexAction(Request $request)
    {
        //$api_service = $this->get("accesspoint.service");
        $uamsecret = "auth_9stub_09123";

        $userpassword=1;

        $loginpath = "http://enter.wiads.vn/ap/";//$_SERVER['PHP_SELF']."/ap/";

        /**
         * config parameters
         */
        $prefix="WiAds.vn";

        $params = array(
            "uamsecret"=>$uamsecret,
            "userpassword"=>$userpassword,
            "title"=>"$prefix Login",
            "centerUsername"=>"Username",
            "centerPassword"=>"Password",
            "centerLogin"=>"Login",
            "centerPleasewait"=>"Please wait.......",
            "centerLogout"=>"Logout",
            "h1Login"=>"$prefix Login",
            "h1Failed"=>"$prefix",
            "h1Loggedin"=>"Logged in to $prefix",
            "h1Loggingin"=>"Logging in to $prefix",
            "h1Loggedout"=>"Logged out from $prefix",
            "centerdaemon"=>"Login must be performed through $prefix connection",
            "centerencrypted"=>"Login must use encrypted connection",
            "loginpath"=>$loginpath
        );

        //$username	=	$request->get("UserName","");
        //$password	=	$request->get("Password","");
        $challenge	=	$request->get("challenge","");
        $button		=	$request->get("button","");

        $logout		=	$request->get("logout","");
        $prelogin	= 	$request->get("prelogin","");
        $res		=	$request->get("res","");
        $uamip		= 	$request->get("uamip","");
        $uamport	= 	$request->get("uamport","");
        $userurl	= 	$request->get("userurl","");
        $timeleft	= 	$request->get("timeleft","");
        $redirurl	= 	$request->get("redirurl","");
        $reply		= 	$request->get("reply","");
        $ip			= 	$request->get("ip","");
        $called		= 	trim($request->get("called",""));
        $mac		= 	$request->get("mac","");
        $sessionid	=	$request->get("sessionid","");
        $email	    =	$request->get("email","");
        $advertId	=	$request->get("advertId",'-1');

        $userurldecode = $userurl;
        $redirurldecode = $redirurl;

	    $bw_profile = ApConfigHelper::getBwProfile($called);
	    $username="wiads_free";
	    $password="free_wifi_wiads";
	    if(!empty($bw_profile)){
		    $username=$bw_profile->getUsername();
		    $password=$bw_profile->getPassword();
	    }

        /**
         *
         */
        $result=-1;
        switch($res) {
            case 'success':     $result =  1; break; // If login successful
            case 'failed':      $result =  2; break; // If login failed
            case 'logoff':      $result =  3; break; // If logout successful
            case 'already':     $result =  4; break; // If tried to login while already logged in
            case 'notyet':      $result =  5; break; // If not logged in yet
            case 'smartclient': $result =  6; break; // If login from smart client
            case 'popup1':      $result = 11; break; // If requested a logging in pop up window
            case 'popup2':      $result = 12; break; // If requested a success pop up window
            case 'popup3':      $result = 13; break; // If requested a logout pop up window
            default: $result = 0;                    // Default: It was not a form request
        }
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $ua_info = parse_user_agent($mobileDetector->getUserAgent());
        $os=$ua_info['platform'];
        $params = array_merge($params,array(
            'os'=>$os
        ));
        //Địa chỉ IP tĩnh (ip của telco) mà client kết nối lên
        $wan_ip = $request->getClientIp();
        if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
            $wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];

        $params = array_merge($params,array(
            "uamsecret"=>$uamsecret,
            "userpassword"=>$userpassword,
            "username"=>$username,
            "password"=>$password,
            "challenge"=>$challenge,
            "button"=>$button,
            "logout"=>$logout,
            "prelogin"=>$prelogin,
            "res"=>$res,
            "uamip"=>$uamip,
            "uamport"=>$uamport,
            "userurl"=>$userurl,
            "timeleft"=>$timeleft,
            "redirurl"=>$redirurl,
            "reply"=>$reply,
            "ip"	=>$ip,
            "wan_ip"    => $wan_ip,
            "called" => $called,
            "mac"	=>$mac,
            "sessionid" =>$sessionid,
            "advertId"=>$advertId,
            "userurldecode"=>$userurldecode,
            "redirurldecode"=>$redirurldecode,
            "email"=>$email,
            "result"=>$result
        ));
	    /**
         * LOGING IN
         */
	    //Trong captival_full_screen_v6 co truong button = 'Free Internet' và loginpath chính là trang index này
        //Khi user bấm login thì đoạn hàm này chính là hàm xử lý login
        if ($button == 'Login' || $button == 'Free Internet') {
            $hexchal = pack ("H32", $challenge);
            if ($uamsecret) {
                $newchal = pack ("H*", md5($hexchal . $uamsecret));
            } else {
                $newchal = $hexchal;
            }
            $response = md5("\0" . $password . $newchal);
            $newpwd = pack("a32", $password);
            $pappassword = implode ("", unpack("H32", ($newpwd ^ $newchal)));

            $params = array_merge($params,array(
                "response"=>$response,
                "pappassword"=>$pappassword
            ));
            $params['userurl']=$advertId."___".$challenge."___".$userurl;
            //var_dump($params);
            $response_callLoginAds = $this->forward('HotspotAccessPointBundle:Advert:callLoginAds', array('request'=>$request,'params' => $params));
            //dump($params);
            return $this->render('HotspotAccessPointBundle:APConnect:loginning_progress.html.twig',$params);
        }
        //$params = array_merge($request->request->all(),$request->query->all());
        //var_dump($params);
        /**
         *
         */
        if ($result == 1 || $result == 4 || $result == 12) {
	        //return $this->redirect($this->generateUrl('hotspot_access_point_homepage_wifi_login_success',$params));
	        return $this->forward('HotspotAccessPointBundle:APConnect:wifiLoginSuccess',array('request'=>$request));
        }
        if ($result == 0) {
            return $this->render('HotspotAccessPointBundle:APConnect:fail.html.twig',$params);
        }

        if ($result == 2) {
	        //return $this->redirect($this->generateUrl('hotspot_access_point_homepage_wifi_login_failed',$params));
	        return $this->render('HotspotAccessPointBundle:APConnect:3.html.twig',$params);
        }
        if ($result == 3 || $result == 13) {
            return $this->render('HotspotAccessPointBundle:APConnect:3.html.twig',$params);
        }
        if ($result == 5) {
        	//172.16.17.1:4990/logoff
	        return $this->forward('HotspotAccessPointBundle:APConnect:wifiLogin',array('request'=>$request));
        }
        if ($result == 11) {
            return $this->render('HotspotAccessPointBundle:APConnect:loginning_progress.html.twig',$params);
        }
        return $this->render('HotspotAccessPointBundle:APConnect:index.html.twig',$params);
    }
    public function successNoLinkAction(Request $request){
        $id=$request->get('id',-1);
        $adv=AdvertHelper::getAdvById($id);
        return $this->render('HotspotAccessPointBundle:APConnect:success_nolink_v4.html.twig',array('adv'=>$adv));
    }
	public function keepaliveAction(Request $request){
		$wan_ip = $request->getClientIp();
		if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
			$wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
		//if(isset($_SERVER["HTTP_REFERER"]))
		//var_dump($_SERVER["HTTP_REFERER"]);
		$ap_mac = $request->get("ap_mac",'');
		$ap_mac=str_replace(":", "-", $ap_mac);
		$ap_mac=strtoupper($ap_mac);
		$mac = $request->get("mac",'');
		$mac=str_replace(":", "-", $mac);
		$mac=strtoupper($mac);
		$v=$request->get("v",'');
		$hw=$request->get("hw",'');
		$justboot=$request->get("justboot",'0');
		$challenge=$request->get("challenge",'');
		$hash=trim($request->get("hash",''));
		$secretkey=$this->getParameter('secret_hash_key');
		//$secretkey='((_(@&(*#%(&KJBC(&OP{SC:FVGP)(!{HCJLHCF!)(:KGP(!GF`9`70198212y-192ye12hjvcshvdc$#@';
		$hash_compare=md5(trim($challenge).trim($secretkey));

		if($v==""){
			return new Response("Hello World!",404);
		}
		if($hash!=$hash_compare && strcmp($v,"20160723.02")>=0){
			return new Response("Hello!",404);
		}
		$new_challenge=self::randStrGen(20);
		$new_hash=md5(trim($new_challenge).trim($secretkey));

		$params=array(
			"called"=>$mac,
			"ap_mac"=>$ap_mac,
			"v"=>$v,
			"hw"=>$hw,
			"justboot" => $justboot,
			"ip"=>$wan_ip
		);
		//if($params['ap_mac']=='D4-6E-0E-F3-C0-F0'){
		//	return new Response("Hello World!",404);
		//}
		//ApLogHelper::writeRequestLog($params);
		$mode = ApConfigHelper::updateAPKeepAlive($params);
		$option=
			"challenge:$new_challenge"."\n"
			."hash:$new_hash"."\n"
			.$mode."\n";

		//if($v=="20170715.01.bridge")
		//	$option= $option
		//	         ."option safe_sleep 0"."\n";

		return new Response($option);
	}

    /**
     * Accesspoint ket noi voi he thong khi duoc bat len
     * Accesspoint lan dau ket noi voi he thong khi moi duoc lap dat. Thong tin cua Accesspoint se duoc update vao table ap_config va table accesspoint
     * @param Request $request
     * @return Response
     */
    public function ssidAction(Request $request){
        $wan_ip = $request->getClientIp();
        if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
            $wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
        //if(isset($_SERVER["HTTP_REFERER"]))
        //var_dump($_SERVER["HTTP_REFERER"]);
        $ap_mac = $request->get("ap_mac",'');
        $ap_mac=str_replace(":", "-", $ap_mac);
        $ap_mac=strtoupper($ap_mac);
        $mac = $request->get("mac",'');
        $mac=str_replace(":", "-", $mac);
        $mac=strtoupper($mac);
        $v=$request->get("v",'');
        $hw=$request->get("hw",'');
        $ssid=$request->get("ssid",'');
	    $justboot=$request->get("justboot",'0');
        $uamdomains=$request->get("uamdomains",'');
        $uamformat=$request->get("uamformat",'');
        $uamhomepage=$request->get("uamhomepage",'');
        $macauth=$request->get("macauth",'');
        $htmode=$request->get("htmode",'');
        $htmode=str_replace("plus_sign", "+", $htmode);
        $hwmode=$request->get("hwmode",'');
        $channel=$request->get("channel",'');
        $noscan=$request->get("noscan",'');
        $encryption=$request->get("encryption",'');
        $key=$request->get("key",'');
        $wifi_status=$request->get("wifi_status",'');
        $iwinfo=$request->get("iwinfo",'');
        $challenge=$request->get("challenge",'');
        $hash=trim($request->get("hash",''));
        $secretkey=$this->getParameter('secret_hash_key');
        $network_lan=$request->get('network_lan', '172.17.17.1');

        //$secretkey='((_(@&(*#%(&KJBC(&OP{SC:FVGP)(!{HCJLHCF!)(:KGP(!GF`9`70198212y-192ye12hjvcshvdc$#@';
        $hash_compare=md5(trim($challenge).trim($secretkey));
        //var_dump($secretkey);
        //var_dump($challenge);
        //var_dump(trim($challenge).trim($secretkey));
        //var_dump($hash);
        //var_dump($hash_compare);
        if($v==""){
            return new Response("Hello World!",404);
        }

        /*
        if(false!==strpos($v, '20160822.01.bridge.lan.as.wan')){
            $mac='EC-08-6B-6E-C2-73';
        }
        if(false!==strpos($v, '20160821.01.lan.as.wan')){
            $mac='A4-2B-B0-AC-82-EF';
        }
        */

        if($hash!=$hash_compare && strcmp($v,"20160723.02")>=0){
            //return new Response("Hello World!",404);
        }
        $new_challenge=self::randStrGen(20);
        $new_hash=md5(trim($new_challenge).trim($secretkey));

	    $detects=self::detectWifiChannel($iwinfo);

        $params=array(
            "called"=>$mac,
            "ap_mac"=>$ap_mac,
            "v"=>$v,
            "hw"=>$hw,
            "ip"=>$wan_ip,
            "ssid"=>$ssid,
            "justboot" => $justboot,
            "uamdomains"=>$uamdomains,
            "uamformat"=>$uamformat,
            "uamhomepage"=>$uamhomepage,
            "macauth"	=>$macauth,
            "channel"=>$channel,
            "htmode"=>$htmode,
            'hwmode' => $hwmode,
            "noscan"=>$noscan,
            "encryption"=>$encryption,
            "key"=>$key,
            "wifi_status"=>$wifi_status,
            "iwinfo"=>$iwinfo,
	        "detects" =>$detects,
            "network_lan"=>$network_lan
        );
	    //if($params['ap_mac']=='D4-6E-0E-F3-C0-F0'){
		//    return new Response("Hello World!",404);
	    //}
        //ApLogHelper::writeRequestLog($params);
	    //$mode = ApConfigHelper::updateAPKeepAlive($params);
        $cfg = ApConfigHelper::updateAPStatus($params);

	    //if(count($detects)==2 && $detects[0]==1 && ( trim($hw)=='TP-Link TL-WR841N v13' || trim($hw)=='TP-Link TL-WR840N v4') ){
		//    $cfg['need_update'] = 1;
	    //}
        if($cfg['need_update']!=1) {
	        $option =
		        "challenge:$new_challenge" . "\n"
		        . "hash:$new_hash" . "\n"
		        . $cfg['mode']. "\n"
                . "option bw_profile ".$cfg['bw_profile_id']. "\n";
	        return new Response($option);
        }
        /***********************************************************/
        /**
         * AP UPDATE
         */
        /***********************************************************/
        $apConfig=ApConfigHelper::getAPStatus($params);
        //Reboot schedule, default system will reboot at 0AM,12PM UTC-> 7AM,7PM GMT+7
		/*
        if(		(!empty($apConfig) && $apConfig->getExclude()!=1)
            &&
            (strtotime(date('H:i:s')) > strtotime('12:00:00') )
            &&
            (strtotime(date('H:i:s')) < strtotime('12:05:00') )
        ){
            $apConfig->setNeedUpdate("1");
            $apConfig->setNeedReboot("option need_reboot 1");
        }

        if(		($apConfig!=null && $apConfig->getExclude()!=1)
                &&
                (strtotime(date('H:i:s')) > strtotime('18:00:00') )
                &&
                (strtotime(date('H:i:s')) < strtotime('18:05:00') )
                ){
                    //$apConfig->setNeedUpdate("1");
                    $apConfig->setNeedReboot("option need_reboot 1");
        }
		*/
        /*
        if(		(!empty($apConfig) && $apConfig->getExclude()!=1)
            &&
            (strtotime(date('H:i:s')) > strtotime('05:00:00') )
            &&
            (strtotime(date('H:i:s')) < strtotime('05:05:00') )
        ){
            $apConfig->setNeedUpdate("1");
            $apConfig->setNeedReboot("option need_reboot 1");
        }
        if(		(!empty($apConfig) && strcmp($v,"20160625.01")<0)
            &&
            (strtotime(date('H:i:s')) > strtotime('23:50:00') )
            &&
            (strtotime(date('H:i:s')) < strtotime('23:55:00') )
        ){
            $apConfig->setNeedUpdate("1");
            $apConfig->setNeedReboot("option need_reboot 1");
        }
		*/
        /////////
        if( (!empty($apConfig))
            && ($apConfig->getNeedUpdate()==1)
        )
        {
            /*
             * 	option fw_upgrade 0
             *	option ssid_update 0
             *	option ssid "WiAds Free Wifi"
             *	option safe_sleep 0
             *	option reset_to_default 0
             *	option update_uamdomains 0
             *	#HS_UAMDOMAINS
             */
            //$apConfig=new ApConfig();
            $fwUpgrade = trim($apConfig->getFwUpgrade());
            if($apConfig->getFwVersion()=='20180710.01.bridge' || $apConfig->getFwVersion()=='20180817.01.bridge'
                || $apConfig->getFwVersion()=='20180920.01.bridge') {
                if (strcmp($fwUpgrade, "option fw_upgrade 1") == 0) {
                    $fwUpgrade = 'option fw_upgrade 2';
                }
            }
            $option=
                "challenge:$new_challenge"."\n"
                ."hash:$new_hash"."\n"
                ./*$apConfig->getFwUpgrade()*/$fwUpgrade."\n"
                .$apConfig->getSsidUpdate()."\n"
                .$apConfig->getSsidNext()."\n"
                .$apConfig->getSafeSleep()."\n"
                .$apConfig->getResetNeed()."\n"
                .$apConfig->getUpdateUamdomains()."\n"
                .$apConfig->getUamdomainsNext()."\n"
                .$apConfig->getUpdateUamformat()."\n"
                .$apConfig->getUamformatNext()."\n"
                .$apConfig->getUpdateUamhomepage()."\n"
                .$apConfig->getUamhomepageNext()."\n"
                .$apConfig->getUpdateMacauth()."\n"
                .$apConfig->getMacauthNext()."\n"
                .$apConfig->getUpdateHtmode()."\n"
                .$apConfig->getHtmodeNext()."\n"
                .$apConfig->getUpdateHwmode()."\n"
                .$apConfig->getHwmodeNext()."\n"
                .$apConfig->getUpdateNoscan()."\n"
                .$apConfig->getNoscanNext()."\n"
                .$apConfig->getUpdateEncryption()."\n"
                .$apConfig->getEncryptionNext()."\n"
                .$apConfig->getWifiEnable()."\n"
                .$apConfig->getUpdateKey()."\n"
                .$apConfig->getUpdateLanNetwork()."\n"
                .$apConfig->getLanNetwork()."\n"
                .$apConfig->getUpdateHosts()."\n"
                .$apConfig->getHosts()."\n"
                .$apConfig->getKeyNext()."\n"
                .$apConfig->getNeedReboot()."\n"
                .$apConfig->getNormalMode()."\n"
                ."option bw_profile ".$apConfig->getBwProfileId()."\n";
            //////////////////////
            if (strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 1")!=0){
                $apConfig->setWifiEnable("option disabled 0");
                $apConfig->save();
            }
            if (strcmp(trim($apConfig->getFwUpgrade()),"option fw_upgrade 1")!=0 && trim($apConfig->getUpdateHosts())=="option hosts_update 1"){
                $apConfig->setUpdateHosts("option hosts_update 0");
                $apConfig->save();
            }
            if (trim($apConfig->getUpdateChannel())=="option channel_update 1"){
                //$apConfig->setChannelNext($tmpChannelNext);
                $apConfig->setUpdateChannel("option channel_update 0");
                $apConfig->save();
            }
            if ($apConfig->getNeedReboot()=="option need_reboot 1"){
                $apConfig->setNeedReboot("option need_reboot 0");
                $apConfig->save();
            }
            if ($apConfig->getUpdateLanNetwork()=="option network_lan_update 1"){
                $apConfig->setUpdateLanNetwork("option network_lan_update 0");
                $apConfig->save();
            }
            if ($apConfig->getResetNeed()=="option reset_to_default 1"){
                $apConfig->setResetNeed("option reset_to_default 0");
                $apConfig->save();
            }
            if(strcmp($apConfig->getFwUpgrade(),"option fw_upgrade 1")!=0){
                $apConfig->setNeedUpdate("0");
                $apConfig->save();
            }
            if (trim($apConfig->getNormalMode())=="option normal_mode 1"){
                //$apConfig->setNormalMode("option normal_mode 0");
                //$apConfig->save();
            }


	        ////////DETECT CONFLICT WIFI CHANNEL
	        /*
	        $detects=self::detectWifiChannel($iwinfo);
	        //$tmpChannelNext=$apConfig->getChannelNext();
	        if(count($detects)==2){
		        //if(!empty($apConfig) && $detects[0]==1){
		        if(!empty($apConfig) && $detects[0]==1 && $apConfig->getApMacaddr()!='EC-08-6B-89-DD-AF'){
			        //$apConfig->setNeedUpdate("1");
			        $apConfig->setUpdateChannel("option channel_update 1");
			        $apConfig->setChannelNext($detects[1]);
			        //$apConfig->save();
			        $option=$option
			                .$apConfig->getUpdateChannel()."\n"
			                .$apConfig->getChannelNext()."\n";
		        }
	        }
	        */
	        ////////
	        ///

            return new Response($option);
        }
        else {
            $option =
                "challenge:$new_challenge" . "\n"
                ."hash:$new_hash" . "\n"
                ."option bw_profile ".$apConfig->getBwProfileId()."\n";
	        if (!empty($apConfig))
	        $option = $option
                . $apConfig->getNormalMode(). "\n";

            if ((!empty($apConfig))
                && ($apConfig->getNeedUpdate() == 0)
                && (trim($apConfig->getResetNeed()) == "option reset_to_default 1")
            ) {
                $option = $option
                    . $apConfig->getResetNeed() . "\n";
                $apConfig->setResetNeed("option reset_to_default 0");
                $apConfig->save();
                return new Response($option);
            }

            if ((!empty($apConfig))
                && ($apConfig->getNeedUpdate() == 0)
                && (
                    trim($apConfig->getWifiEnable()) == "active wifi 0"
                    ||
                    trim($apConfig->getWifiEnable()) == "active wifi 1"
                )
            ) {
                $option = $option
                    . $apConfig->getWifiEnable() . "\n";
                //$apConfig->setWifiEnable("option disabled 0")->save();
            }
            ////
            if ((!empty($apConfig))
                && ($apConfig->getNeedUpdate() == 0)
                && (trim($apConfig->getNeedReboot()) == "option need_reboot 1")
            ) {
                $option = $option
                    . $apConfig->getNeedReboot() . "\n";
                $apConfig->setNeedReboot("option need_reboot 0");
                $apConfig->save();
                //return new Response($option);
            }
            /*
            if ((!empty($apConfig))
                && ($apConfig->getNeedUpdate() == 0)
                && (trim($apConfig->getNormalMode()) == "option normal_mode 1")
            ) {
                $option = $option
                    . $apConfig->getNormalMode() . "\n";
                //return new Response($option);
            }
            */
            /*
	        ////////DETECT CONFLICT WIFI CHANNEL
	        $detects=self::detectWifiChannel($iwinfo);
	        //$tmpChannelNext=$apConfig->getChannelNext();
	        if(count($detects)==2){
		        if(!empty($apConfig) && $detects[0]==1 && $apConfig->getApMacaddr()!='EC-08-6B-89-DD-AF'){
			        //$apConfig->setNeedUpdate("1");
			        $apConfig->setUpdateChannel("option channel_update 1");
			        $apConfig->setChannelNext($detects[1]);
			        //$apConfig->save();
			        $option=$option
			                .$apConfig->getUpdateChannel()."\n"
			                .$apConfig->getChannelNext()."\n";
		        }
	        }
            */
	        ////////
            return new Response($option);
        }

        /*
                if(		$mac=="F4:F2:6D:FD:27:8D" ){
                    $option =
        <<<OPTION
        option ssid_update 0
        option update_uamdomains 0
        HS_UAMDOMAINS=".youtube.com,.ytimg.com,.googleapis.com,.googlevideo.com,,.facebook.com,.bing.com,.yahoo.com,.hotspotwifisystem.com,.wiads.vn,.google.com,.microsoft.com,.apple.com,.akamaitechnologies.com,.icloud.com,.akamaihd.net,.akamaiedge.net,.akamaitechnologies.com"
        option ssid "Wifi T7"
        option safe_sleep 0
        OPTION;
                    return new Response($option);
                }
        */
        /*******************************************/
        return new Response(
            "challenge:$new_challenge"."\n"
            ."hash:$new_hash"."\n"
            ."option normal_mode 0"
            ."option safe_sleep 0");
    }
	public function notActivatedAction(Request $request,$params = array()){
		return $this->render('HotspotAccessPointBundle:APConnect:not_activated.html.twig',$params);
	}
    /**
     * UPGRADE FIRMWARE
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function fwAction(Request $request){
        $mac = $request->get("mac",'');
        $mac=strtoupper($mac);
        $mac=str_replace(":", "-", $mac);
        $v=$request->get("v",'');
        $hw=$request->get("hw",'');

        $challenge=$request->get("challenge",'');
        $hash=trim($request->get("hash",''));
        $secretkey=$this->getParameter('secret_hash_key');
        //$secretkey='((_(@&(*#%(&KJBC(&OP{SC:FVGP)(!{HCJLHCF!)(:KGP(!GF`9`70198212y-192ye12hjvcshvdc$#@';

        $hash_compare=md5(trim($challenge).trim($secretkey));
        //var_dump($secretkey);
        //var_dump($challenge);
        //var_dump(trim($challenge).trim($secretkey));
        //var_dump($hash);
        //var_dump($hash_compare);
        if($hash!=$hash_compare && strcmp($v,"20160723.02")>=0){
            //throw $this->createNotFoundException('Hello world!');
            return new Response("Hello World!",404);
        }
        /*
        if(false!==strpos($v, '20160822.01.bridge.lan.as.wan')){
            $mac='EC-08-6B-6E-C2-73';
        }
        if(false!==strpos($v, '20160821.01.lan.as.wan')){
            $mac='A4-2B-B0-AC-82-EF';
        }
        */
        $params=array(
            "called"=>$mac,
            "v"=>$v,
            "hw"=>$hw
        );
        $apConfig=ApConfigHelper::getAPStatus($params);
        if( ($apConfig!=null)
            && ($apConfig->getNeedUpdate()==1)
            && (strcmp($apConfig->getFwUpgrade(),"option fw_upgrade 1")==0)
        )
        {
            $apConfig->setNeedUpdate("1");
            $apConfig->setFwUpgrade("option fw_upgrade 0");
            $apConfig->setUpdateLanNetwork("option network_lan_update 0");
            $apConfig->setLanNetwork("option network_lan '172.16.16.1'");
            $apConfig->setWifiEnable("active wifi 1");
            $apConfig->save();
            $file=$apConfig->getFwFile();
            return $this->redirect($file);
        }
        /*******************************************/
        /*
                if(		$mac=="C4:E9:84:F0:69:4C"
                        && (strpos($hw, "TL-WR941N/ND v5") !== false)
                        && (strcmp($v,"20160512")!=0)
                ){
                    return $this->redirect("/fw/wiads.vn-wr941nd-v5-20160512.bin");
                }
        */
        return new Response();
    }
	public function refreshConfigAction(Request $request){
		$mac=$request->get('mac','');
		if(empty($mac)){
			$response = new Response(json_encode(array(
				'mac' => $mac,
				'message' => 'Vui lòng cung cấp địa chỉ MAC'
			)));
			$response->headers->set('Content-Type', 'application/json');
			return $response;
		}
		if(!empty($mac)){
			exec('wiads_config_helper '.strtoupper($mac));
			$response = new Response(json_encode(array(
				'mac' => $mac,
				'message' => 'Đã gửi yêu cầu cấu hình nhanh cho MAC:'.$mac
			)));
			$response->headers->set('Content-Type', 'application/json');
			return $response;
		}

	}
	public function refreshUserofCompanyAction(Request $request){
		$company =  $request->get('company','');
		$users= array();
		if(!empty($company)) {
			$users = ApLogHelper::getUserListOfCompany($company);
		}
		$template = 'HotspotAccessPointBundle:APConnect:user_list_of_company.html.twig';
		$response = $this->render( $template, array( 'users' => $users ) );
		return $response;

	}
    /**
     * CHECK MAC
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function verifyMacAction(Request $request){
        $mac=$request->get('mac','');

        $ap=ApConfigHelper::getAPInfo($mac);
        /** @var ApConfig $apConfig */
        $apConfig=ApConfigHelper::getAPConfig($mac);
        //$firmwares=ApConfigHelper::getUpdatFirmwareList();

        //$bwProfiles=ApConfigHelper::getBwProfileList();
        $isUsingKey=ApConfigHelper::isUsingKey($mac);
        if(empty($apConfig)){

	        //exec('wiads_config_helper '.$mac);

            $response = new Response(json_encode(array(
                'mac' => "Không có",
                'fw_version' => "Không có",
                'time' => "Không có",
                'key' => "Không có",
                'name' => "Không có",
                'address' => "Không có",
                'province' => "-1",
                'owner' => "-1",
                'isUsingKey' => false,
                'trash' => "0",
                'detail_url' => '',
                //'firmwares' => "Không có",
                //'bwProfiles' => "Không có"
            )));
        }else {

	        //exec('wiads_config_helper '.$ap->getMacaddr());

            $apSlideImgs = explode(',', $ap->getImgs());
            $image_slide_1 = isset($apSlideImgs[0]) ? $apSlideImgs[0] : '';
            $image_slide_2 = isset($apSlideImgs[1]) ? $apSlideImgs[1] : '';
            $image_slide_3 = isset($apSlideImgs[2]) ? $apSlideImgs[2] : '';

            $key=str_replace('"', '', $apConfig->getKeyNext());
	        $key=str_replace("'", '', $key);
	        $key=str_replace('option key', '', $key);
            $key=trim(str_replace("'", '', $key));
            $login_template=$ap->getLoginTemplate();
            if ($login_template==$ap->getApMacaddr().'.html.twig')
                $login_template='mac.html.twig';

	        $firmware=FirmwareQuery::create()->filterByPlatform(trim($apConfig->getPlatform()))->orderByFwVersion("desc")->findOne();
	        $hasNewFirmware=false;
	        if(!empty($firmware) &&  $firmware->getFwVersion()>$apConfig->getFwVersion())
	        	$hasNewFirmware=true;

	        $response = new Response(json_encode(array(
                'mac' => $ap->getMacaddr(),
                'fw_version' => $apConfig->getFwVersion(),
                'time' => date_format($ap->getUpdatedAt(), 'Y-m-d H:i:s'),
                'key' => $key,
                'name' => $ap->getName(),
                'ssid' => str_replace("'","",$ap->getSsid()),
                'address' => $ap->getAddress(),
                'province' => empty($ap->getProvince())?"-1":$ap->getProvince(),
                'owner' => empty($ap->getOwner())?"-1":$ap->getOwner(),
                'account' => empty($ap->getPostBy())?"-1":$ap->getPostBy(),
                'isUsingKey' => $isUsingKey,
                'trash' => $ap->getTrash(),
                'mode'  => $apConfig->getNormalMode(),
                'bw_profile' => $apConfig->getBwProfileId(),
                'login_template' => $login_template,
                'detail_url' => $ap->getDetailUrl(),
                'platform' => $apConfig->getPlatform(),
                'firmware' => empty($firmware)?'':$firmware->getPlatform()."-".$firmware->getFwVersion(),
                'hasNewFirmware' => $hasNewFirmware,
                'uamdomains' => $apConfig->getUamdomains(),
                'ap_image' => $ap->getImage(),
                'image_slide_1' => $image_slide_1,
                'image_slide_2' => $image_slide_2,
                'image_slide_3' => $image_slide_3,
                'network_lan' => $ap->getPreStatus()
                //'bwProfiles' => $bwProfiles
            )));
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * REPORT ACTION
     * @param Request $request
     */
    public function reportAction(Request $request){
        $url = $request->getUri();
        if(strpos($url, 'auth.wiads.vn/ap/report')!==false){
            return $this->redirect('http://enter.wiads.vn/ap/report');
        }
        //Update
        $saveStatus="";
        $macaddr=$request->get('macaddr','');
        $name=$request->get('name','');
        $province=$request->get('province','-1');
        $company=$request->get('company','-1');
        $address=$request->get('address','');
        $detail_url=$request->get('detail_url','');
        $wifipass=$request->get('wifipass','');
        $change_img=$request->get('change_img',0);
        $usewifipass=$request->get('usewifipass','0');
        $click_view=$request->get('click_view','0');
        $activated=$request->get('activated','0');
        $firmware_upgrade=$request->get('firmware_upgrade',0);
        $firmware_file=$request->get('firmware_file','');
        $bw_profile=$request->get('bw_profile',1);
        $reboot=$request->get('reboot',0);
	    $reset=$request->get('reset',0);
        $login_template=$request->get('login_template','');
        $uamdomains=$request->get('uamdomains', 'HS_UAMDOMAINS=\'.wiads.vn,.hotspotwifisystem.com,meganet.com.vn,.meganet.com.vn,.valuepotion.com,valuepotion.com,daumcdn.net,.daumcdn.net,bs.serving-sys.com,junoteam.com,.junoteam.com,.facebook.com,.facebook.net,.akamaitechnologies.com,.akamaihd.net,.akamaiedge.net,.akamaitechnologies.com,.fbcdn.net,.gstatic.com,.android.com\'');
        $ap_mode=$request->get('ap_mode','option normal_mode 0');
        $network_lan=$request->get('network_lan', 'option network_lan \'172.16.16.1\'');
        if($ap_mode!="option normal_mode 0" && $ap_mode!="option normal_mode 1")
            $ap_mode="option normal_mode 0";
        $disable_img=$request->get('disable_img','0');

        $provinces= LocationQuery::create()->orderById()->find();

        $templates = array('captival_full_screen_v4.html.twig'=>'Quảng cáo chung - 640x710',
                           'captival_fblogin_v3.html.twig'=>'Share Facebook để dùng Internet',
                            'captival_slides.html.twig'=>'Xem hết Slide ảnh để dùng Internet',
                            'captival_fblogin_v2.html.twig'=>'Thu thập thông tin Khách Hàng',
                           /*'captival_fb_share_login.html.twig'=>'Share Facebook để dùng Internet',
                           'captival_vlp.html.twig'=>'Value point Ads',
                           */
                           'mac.html.twig'=>'Giải pháp riêng theo MAC - Quảng cáo chung - 640x710');
        $form=$this->createFormBuilder()
            ->add('image_file', FileType::class, array('label' => 'Ảnh quán'))
            ->add('image_slide_1', FileType::class, array('label' => 'Ảnh quán'))
            ->add('image_slide_2', FileType::class, array('label' => 'Ảnh quán'))
            ->add('image_slide_3', FileType::class, array('label' => 'Ảnh quán'))
            ->getForm();
        $form->handleRequest($request);

        /////////
	    ///

	    $report_view=$request->get('report_view',0);

	    $status_view=$request->get('status_view',0);
	    $from_0 = $request->get('from',date("Y-m-d"));
	    $from_1=date_create(self::addDayswithdate($from_0,-1));
	    $from_1=$from_1->format('Y-m-d');
	    $date=date_create(self::addDayswithdate($from_0,1));
	    $to = $request->get('to',$date->format('Y-m-d'));
	    $year = explode("-",$from_0)[0];// $request->get('year',date("Y"));
	    $month = explode("-",$from_0)[1];//$request->get('month',date("m"));
	    $num_1=0;
	    $num_0=0;

	    $username=null;
	    if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')){
		    $username=$this->getUser()->getUsername();
	    }
	    echo "username : ".$this->getUser()->getUsername();
	    $owners=ApConfigHelper::getOwnerList($username);
	    $firmwares=ApConfigHelper::getUpdatFirmwareList();
	    $bwProfiles=ApConfigHelper::getBwProfileList();
        $customer = CustomerQuery::create()->filterByUsername($this->getUser()->getUsername())->findOne();
        $recordUserAccesspoint = ApConfigHelper::getUserAccesspoint($this->getUser()->getUsername());
        $arrUserAccesspoint = [];
        foreach ($recordUserAccesspoint as $oneRecord) {
            $arrUserAccesspoint[$oneRecord['ap_macaddr']] = ApConfigHelper::getAPName($oneRecord['ap_macaddr']);
        }

	    $params=array(
		    'user'=>$this->get('security.token_storage')->getToken()->getUser(),
		    'from_1'=>$from_1,
		    'from_0'=>$from_0,
		    'to' => $to,
		    'year'=>$year,
		    'month'=>$month,
		    'province' => $province,
		    'company'=>trim($company),
		    'user_company'=> '-1',
		    'post_by' => '-1',
            'customer_type' => $customer->getType(),
            'user_accesspoint' => $arrUserAccesspoint
	    );
	    //////////////////////////
        /// Quyền cao nhất, làm mọi thứ liên quan đến user,qc
        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
	    ) {
		    $params = array_merge($params, array(
			    'level' => 1
		    ));
	    }
	    if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')) {
		    $params = array_merge($params, array(
			    'level' => 2
		    ));
	    }
	    if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
		    $params = array_merge($params, array(
			    'level' => 3
		    ));
	    }
	    if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_04')) {
		    $params = array_merge($params, array(
			    'level' => 4
		    ));
	    }
	    //Chỉ view thông tin
	    if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_05')) {
		    $params = array_merge($params, array(
			    'level' => 5
		    ));
	    }
	    if(!key_exists('level',$params)){
		    return $this->redirectToRoute('hotspot_security_logout');
	    }
	    $params['company']=-1;
	    if ($params['level']>1){
		    $user=$this->getUser();
		    $params['company']=$user->getCompany();
		    //$params['post_by']=$user->getUsername();
	    }
	    if ($params['level']>2){
		    $user=$this->getUser();
		    $params['company']=$user->getCompany();
		    $params['post_by']=$user->getUsername();
	    }
	    if ($params['level']==5){
		    $user=$this->getUser();
		    $params['company']=$user->getCompany();
		    $params['post_by']=-1;
	    }
	    ////////////////////////
        if($macaddr!=""){
            if($form->isSubmitted() && $form->isValid()) {
                $baseDirImage = '/media/images/nhnhat/';
                //Ảnh Banner (Đổi tên ảnh)
                $fileName='';
                $file=$form['image_file']->getData();
                if(!empty($file)) {
                    $fileName = trim($macaddr) . '_logo.' . $file->guessExtension();
                }
                //Ảnh Slide (Đổi tên ảnh)
                $ap=ApConfigHelper::getAPInfo($macaddr);
                $arrApSlideImgs = explode(',', $ap->getImgs());
                $fileNameSlide1 = isset($arrApSlideImgs[0]) ? $arrApSlideImgs[0] : '';
                $fileNameSlide2 = isset($arrApSlideImgs[1]) ? $arrApSlideImgs[1] : '';
                $fileNameSlide3 = isset($arrApSlideImgs[2]) ? $arrApSlideImgs[2] : '';
                $file_slide_1=$form['image_slide_1']->getData();
                if(!empty($file_slide_1)) {
                    $fileNameSlide1=trim($macaddr) . '_slide1.' . $file_slide_1->guessExtension();
                    $fileNameSlide1=$baseDirImage.$fileNameSlide1;
                }
                $file_slide_2=$form['image_slide_2']->getData();
                if(!empty($file_slide_2)) {
                    $fileNameSlide2=trim($macaddr) . '_slide2.' . $file_slide_2->guessExtension();
                    $fileNameSlide2=$baseDirImage.$fileNameSlide2;
                }
                $file_slide_3=$form['image_slide_3']->getData();
                if(!empty($file_slide_3)) {
                    $fileNameSlide3=trim($macaddr) . '_slide3.' . $file_slide_3->guessExtension();
                    $fileNameSlide3=$baseDirImage.$fileNameSlide3;
                }
                $arrApFinalImg = [];
                if (isset($fileNameSlide1) && !empty($fileNameSlide1)) {
                    array_push($arrApFinalImg, $fileNameSlide1);
                }
                if (isset($fileNameSlide2) && !empty($fileNameSlide2)) {
                    array_push($arrApFinalImg, $fileNameSlide2);
                }
                if (isset($fileNameSlide3) && !empty($fileNameSlide3)) {
                    array_push($arrApFinalImg, $fileNameSlide3);
                }
                $apImgs = implode(",", $arrApFinalImg);
                $params= $params = array_merge($params,array(
                    'macaddr'=>trim($macaddr),
                    'name'=>trim($name),
                    'province'=>trim($province),
                    'company'=>trim($company),
                    'address'=>trim($address),
                    'wifipass'=>trim($wifipass),
                    'usewifipass'=>trim($usewifipass),
                    'change_img' => trim($change_img),
                    'activated'	=>trim($activated),
                    'firmware_upgrade'=>$firmware_upgrade,
                    'firmware_file'=>$firmware_file,
                    'bw_profile' => $bw_profile,
                    'reboot'=>$reboot,
                    'reset'=>$reset,
                    'login_template' => $login_template,
                    'ap_mode' => $ap_mode,
                    'disable_img' => $disable_img,
                    'file_name'=>$baseDirImage.$fileName,
                    'detail_url' => $detail_url,
                    'uamdomains' => $uamdomains,
                    'network_lan' => $network_lan,
                    'apImgs' => $apImgs
                    //'post_by'=>$this->get('security.token_storage')->getToken()->getUser()->getUsername(),
                    //'user'=>$this->get('security.token_storage')->getToken()->getUser()
                ));
                $api_service = $this->get("accesspoint.service");
                $saveStatus = ApConfigHelper::updateAPInfo($params, $api_service);
                if($saveStatus=='Saved!' && $change_img==1){
                    $file=$form['image_file']->getData();
                    //$fileName = md5(uniqid()).'.'.$file->guessExtension();
                    //dump($this->container->getParameter('kernel.root_dir') . DIRECTORY_SEPARATOR.'../web/media/images/nhnhat/');
	                if(!empty($file)) {
                        $file->move($this->container->getParameter('kernel.root_dir') . DIRECTORY_SEPARATOR . '../web/media/images/nhnhat/', $fileName);
                        exec("rsync -au -e 'ssh -p 2012' /var/www/enter.wiads.vn/web/media/images/nhnhat/$fileName root@125.212.233.60:/var/www/enter.wiads.vn/web/media/images/nhnhat/$fileName");
                    }
                }
                if($saveStatus=='Saved!') {
                    if(!empty($file_slide_1)) {
                        $file_slide_1->move($this->container->getParameter('kernel.root_dir') . DIRECTORY_SEPARATOR . '../web/media/images/nhnhat/', $fileNameSlide1);
                    }
                    if(!empty($file_slide_2)) {
                        $file_slide_2->move($this->container->getParameter('kernel.root_dir') . DIRECTORY_SEPARATOR . '../web/media/images/nhnhat/', $fileNameSlide2);
                    }
                    if(!empty($file_slide_3)) {
                        $file_slide_3->move($this->container->getParameter('kernel.root_dir') . DIRECTORY_SEPARATOR . '../web/media/images/nhnhat/', $fileNameSlide3);
                    }
                }
	            $saveStatus=$saveStatus." ".$macaddr;
            }
            //var_dump($params);
        }

        ///////
        $result=null;
        $popup_1=-1;
        $login_1=-1;
        $success_1=0;
        $fail_1=0;
        $popup_0=0;
        $login_0=0;
        $success_0=0;
        $fail_0=0;
        if($report_view==1){
	        $params['company']=$request->get('company','-1');
	        $params['user_company']=$request->get('user_company','-1');
            $page = $request->get('page',1);
            $maxPerPage = 50;
            $params = array_merge($params,array(
                'page'=>$page,
                'maxPerPage'=> $maxPerPage
            ));
            //ApConfigHelper::updateApInfoAll();

            $num_access=ApLogHelper::reportClientAccessLog($params);
            foreach  ($num_access as $row){
                if($popup_1==-1){
                    $popup_1=$row["popup"];
                    $login_1=$row["click_login"];
                    //$success_1=$row["success_login"];
                    //$fail_1=$row["fail"];
                }
                else{
                    $popup_0=$row["popup"];
                    $login_0=$row["click_login"];
                    //$success_0=$row["success_login"];
                    //$fail_0=$row["fail"];
                }
            }

            $result=ApLogHelper::reportLogAll_v2($params);
            //if($with_user_access_num==1){
            //	$result=ApLogHelper::reportLogAll($params);
            //}
            //else{
            //	$result=ApLogHelper::reportLogApStatus($params);
            //}
        }
        if($status_view==1){
	        $params['company']=$request->get('company','-1');
	        $params['user_company']=$request->get('user_company','-1');
	        $params['ap_name']=$request->get('ap_name', '-1');
	        $params['fw_version']=$request->get('fw_version', '-1');
            $page = $request->get('page',1);
            $maxPerPage = 50;
            $params = array_merge($params,array(
                'page'=>$page,
                'maxPerPage'=> $maxPerPage,
            ));
            if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')){
                $params = array_merge($params,array(
                    'level'=>1
                ));
            }
            if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')) {
                $params = array_merge($params, array(
                    'level' => 2
                ));
            }
            if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
                $params = array_merge($params, array(
                    'level' => 3
                ));
            }
	        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_04')) {
		        $params = array_merge($params, array(
			        'level' => 4
		        ));
	        }
	        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_05')) {
		        $params = array_merge($params, array(
			        'level' => 5
		        ));
	        }
            // dump($params);
            if ($params['level']>1){
                $user=$this->getUser();
                $params['company']=$user->getCompany();
                //$params['post_by']=$user->getUsername();
            }
            if ($params['level']>2){
                $user=$this->getUser();
                $params['company']=$user->getCompany();
                $params['post_by']=$user->getUsername();
            }
	        if ($params['level']==5){
		        $user=$this->getUser();
		        $params['company']=$user->getCompany();
		        $params['post_by']=-1;
	        }
            $result=ApLogHelper::reportLogApStatus($params);

        }
	    $ap_number = ApLogHelper::reportApNumber($params['province'],$params['user_company']);
        return $this->render('HotspotAccessPointBundle:APConnect:report.html.twig',array(
                'form'=>$form->createView(),
                'result'=>$result,
                'params'=>$params,
                'ap_number' => $ap_number,
                'report_view'=>$report_view,
                'status_view'=>$status_view,
                'popup_0'=>$popup_0,'popup_1'=>$popup_1,
                'login_0'=>$login_0,'login_1'=>$login_1,
                'success_0'=>$success_0,'success_1'=>$success_1,
                'fail_0'=>$fail_0,'fail_1'=>$fail_1,
                'saveStatus'=>$saveStatus,
                'owners'=>$owners,
                'firmwares'=>$firmwares,
                'bwProfiles' => $bwProfiles,
                'provinces' =>$provinces,
                'templates' => $templates,
                'company' => $params['company'],
                'user_company' => $params['user_company'],
                'click_view'=>trim($click_view),)
        );

    }
    public function report_v2Action(Request $request){
        //Update
        $saveStatus="";
        $province=$request->get('province','-1');
        $company=$request->get('company','-1');

        $report=$request->get('report',0);
        $year = $request->get('year',date("Y"));
        $month = $request->get('month',date("m"));
        //
        $username=null;
        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')){
            $username=$this->getUser()->getUsername();
        }
        $owners=ApConfigHelper::getOwnerList($username);
        $firmwares=ApConfigHelper::getUpdatFirmwareList();
        $params=array(
            'year'=>$year,
            'month'=>$month,
            'province' => $province,
            'company'=>trim($company),
            'post_by' => '-1'
        );
        $result=null;
        $popup_1=-1;
        $login_1=-1;
        $success_1=0;
        $fail_1=0;
        $popup_0=0;
        $login_0=0;
        $success_0=0;
        $fail_0=0;
        if($report==1){
            $page = $request->get('page',1);
            $maxPerPage = 50;
            $params = array_merge($params,array(
                'page'=>$page,
                'maxPerPage'=> $maxPerPage
            ));
            //ApConfigHelper::updateApInfoAll();
            $num_access=array();
            //$num_access=ApLogHelper::reportClientAccessLog($params);
            foreach  ($num_access as $row){
                if($popup_1==-1){
                    $popup_1=$row["popup"];
                    $login_1=$row["click_login"];
                    //$success_1=$row["success_login"];
                    //$fail_1=$row["fail"];
                }
                else{
                    $popup_0=$row["popup"];
                    $login_0=$row["click_login"];
                    //$success_0=$row["success_login"];
                    //$fail_0=$row["fail"];
                }
            }
            //$with_user_access_num=$request->get('with_user_access_num',0);
            if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')){
                $params = array_merge($params,array(
                    'level'=>1
                ));
            }
            if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')) {
                $params = array_merge($params, array(
                    'level' => 2
                ));
            }
            if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
                $params = array_merge($params, array(
                    'level' => 3
                ));
            }
            // dump($params);
            if ($params['level']>1){
                $user=$this->getUser();
                $params['company']=$user->getCompany();
                $params['post_by']=$user->getUsername();
            }
            $result=ApLogHelper::reportLogAll_v2($params);
        }
        return $this->render('HotspotAccessPointBundle:APConnect:report_v2.html.twig',array(
            'result'=>$result,'params'=>$params,
            'popup_0'=>$popup_0,'popup_1'=>$popup_1,
            'login_0'=>$login_0,'login_1'=>$login_1,
            'success_0'=>$success_0,'success_1'=>$success_1,
            'fail_0'=>$fail_0,'fail_1'=>$fail_1,
            'saveStatus'=>$saveStatus,'owners'=>$owners,'firmwares'=>$firmwares,) );

    }

    public function paymentAction(Request $request) {
        $uamsecret = "auth_9stub_09123";
        $userpassword=1;
        $loginpath = "http://enter.wiads.vn/ap/";//$_SERVER['PHP_SELF']."/ap/";

        $prefix="WiAds.vn";
        $params = array(
            "uamsecret"=>$uamsecret,
            "userpassword"=>$userpassword,
            "title"=>"$prefix Login",
            "centerUsername"=>"Username",
            "centerPassword"=>"Password",
            "centerLogin"=>"Login",
            "centerPleasewait"=>"Please wait.......",
            "centerLogout"=>"Logout",
            "h1Login"=>"$prefix Login",
            "h1Failed"=>"$prefix",
            "h1Loggedin"=>"Logged in to $prefix",
            "h1Loggingin"=>"Logging in to $prefix",
            "h1Loggedout"=>"Logged out from $prefix",
            "centerdaemon"=>"Login must be performed through $prefix connection",
            "centerencrypted"=>"Login must use encrypted connection",
            "loginpath"=>$loginpath
        );

        $challenge	=	$request->get("challenge","");
        $button		=	$request->get("button","");
        $uamip		= 	$request->get("uamip","");
        $uamport	= 	$request->get("uamport","");
        $userurl	= 	$request->get("userurl","");
        $ip			= 	$request->get("ip","");
        $called		= 	trim($request->get("called",""));
        $mac		= 	$request->get("mac","");
        $advertId	=	$request->get("advertId",'-1');
        $bw_id      =   $request->get("bw_id", '9');

        $userurldecode = $userurl;

//        $bw_profile = ApConfigHelper::getBwProfile($called);
        $bw_profile = ApConfigHelper::getBwProfileById($bw_id);
        $username="wiads_free";
        $password="free_wifi_wiads";
        if(!empty($bw_profile)){
            $username=$bw_profile->getUsername();
            $password=$bw_profile->getPassword();
        }
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $ua_info = parse_user_agent($mobileDetector->getUserAgent());
        $os=$ua_info['platform'];
        $params = array_merge($params,array(
            'os'=>$os
        ));
        //Địa chỉ IP tĩnh (ip của telco) mà client kết nối lên
        $wan_ip = $request->getClientIp();
        if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
            $wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];

        $params = array_merge($params,array(
            "uamsecret"=>$uamsecret,
            "userpassword"=>$userpassword,
            "username"=>$username,
            "password"=>$password,
            "challenge"=>$challenge,
            "button"=>$button,
            "uamip"=>$uamip,
            "uamport"=>$uamport,
            "ip"	=>$ip,
            "wan_ip"    => $wan_ip,
            "called" => $called,
            "mac"	=>$mac,
            "advertId"=>$advertId,
            "userurldecode"=>$userurldecode,
            "userurl"=>$userurl
        ));
        return $this->render('HotspotAccessPointBundle:APConnect:demo-payment.html.twig', array('params' =>$params));
    }

    public function updateReportAction(Request $request){
        $month=$request->get('m','01');
        $year=$request->get('y','2016');
        //AdvertHelper::updateAdsReport($year,$month);
        $api_service = $this->get("accesspoint.service");
        if($api_service!=null) {
            $y = date("Y");
            $m = date("m");
            //$d = date("d");
            //$api_service->updateAdsReport($y,$m);
            $api_service->updateAdsReport($y,$m);
        }
        return new Response('<html><body>OK</body></html>');
    }
    public function trackLoginAction( Request $request,$locale){
        $redirUrl=trim($request->get('userurl',""));
        //if(strpos($redirUrl, "/")===0  )	$redirUrl=$request->getHost().$redirUrl;
        //$response	=	$this->render('HotspotAccessPointBundle:Advert:redirectAdvert.html.twig', array('baseUrl'=>$request->getHost(),'url'=>$redirUrl));
        $adsCookie=$redirUrl.rand();
        $adsCookieTime=time() + 2592000; //3600*24*30;
        $cookie=$request->cookies->get('adsCookie',0);
        if ($cookie!=0)
            $adsCookie=$cookie;

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
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
            'called'		=> 	$request->get("called",""),
            'mac'		=> 	$request->get("mac",""),
            'ip'		=> 	$request->get("ip",""),
            'userurl'=>$redirUrl,
            'web_session'=>$adsCookie,
            'challenge' => $request->get("challenge",""),
            'phase'=>'view_login'
        ));
        //var_dump($params);
        ApLogHelper::writeTrackLoginLog($params);

        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, "track.png");
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/png');
        $response->setContent(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='));

        return $response;
    }
    /**
     * @param Request $request
     */
    public function promotionAction(Request $request){
        $customer = "";
        $id = $request->get('id',0);

        $adv = AdvertHelper::getAdvById($id);
        if(count($adv)>0){
            $cus=CustomerQuery::create()->filterById($adv->getCustomerId())->findOne();
            if(count($cus)>0)
                $customer=$cus->getCode();
        }

        $code="Chưa có mã!";
        $result = array();

        if(!empty($customer)){
            $i = 0;
            while (true){
                $i++;
                if($i >= 5){
                    $code = strtoupper($customer).rand(0, 999999);
                }else{
                    $code = strtoupper($customer).rand(0, 9999);
                }
                $one = PromotionQuery::create()->filterByArray(array('code' => $code, 'customer' => $customer))->findOne();
                if(!$one){
                    break;
                }
            }

            $promotion = new Promotion();
            $promotion->setCode($code);
            $promotion->setCustomer($customer);
            $promotion->setType(1);
            $promotion->setStatus(0);
            $promotion->save();

            $result['status'] = 1;
            $result['code']   = $code;
        }else{
            $result['status'] = 0;
        }
        return $this->render('HotspotAccessPointBundle:APConnect:promotion_fullscreen_v4.html.twig', array('code'=>$code,'adv'=>$adv,'id'=>$id));
    }
    public function testAction(Request $request){
        return $this->render('HotspotAccessPointBundle:APConnect:test.html.twig');
    }
    public function detectWifiChannelAction(Request $request){
        //$iwinfo='wlan0 ESSID: "JUNOTEAM 3" Access Point: F8:1A:67:5D:08:98 Mode: Master Channel: 1 (2.412 GHz) Tx-Power: 18 dBm Link Quality: unknown/70 Signal: unknown Noise: -95 dBm Bit Rate: unknown Encryption: WPA2 PSK (CCMP) Type: nl80211 HW Mode(s): 802.11bgn Hardware: unknown [Generic MAC80211] TX power offset: unknown Frequency offset: unknown Supports VAPs: yes PHY name: phy0 Cell 01 - Address: F4:F2:6D:FD:27:8E ESSID: "JUNOTEAM 2" Mode: Master Channel: 1 Signal: -20 dBm Quality: 70/70 Encryption: WPA2 PSK (CCMP) Cell 02 - Address: 90:94:E4:AE:7B:C4 ESSID: "KHAI HOAN 4" Mode: Master Channel: 1 Signal: -84 dBm Quality: 26/70 Encryption: mixed WPA/WPA2 PSK (TKIP, CCMP) Cell 03 - Address: 2C:30:33:EA:54:29 ESSID: "ThanhUyen07" Mode: Master Channel: 1 Signal: -89 dBm Quality: 21/70 Encryption: mixed WPA/WPA2 PSK (TKIP, CCMP) Cell 04 - Address: 14:CC:20:7F:B1:8E ESSID: "YEN SAO KHANH HOA" Mode: Master Channel: 3 Signal: -89 dBm Quality: 21/70 Encryption: WPA2 PSK (CCMP) Cell 05 - Address: AC:64:62:D1:09:8D ESSID: "Khai" Mode: Master Channel: 4 Signal: -85 dBm Quality: 25/70 Encryption: mixed WPA/WPA2 PSK (CCMP) Cell 06 - Address: EC:22:80:C9:E9:80 ESSID: "Khai_Hoang_t2" Mode: Master Channel: 4 Signal: -98 dBm Quality: 12/70 Encryption: mixed WPA/WPA2 PSK (TKIP, CCMP) Cell 07 - Address: 78:44:76:77:9F:C0 ESSID: "VIET LOC" Mode: Master Channel: 4 Signal: -87 dBm Quality: 23/70 Encryption: WPA2 PSK (CCMP) Cell 08 - Address: 2C:30:33:EA:53:75 ESSID: "ThanhUyen08" Mode: Master Channel: 7 Signal: -92 dBm Quality: 18/70 Encryption: mixed WPA/WPA2 PSK (TKIP, CCMP) Cell 09 - Address: C0:4A:00:71:1A:E6 ESSID: "Quan" Mode: Master Channel: 11 Signal: -80 dBm Quality: 30/70 Encryption: mixed WPA/WPA2 PSK (TKIP, CCMP) Cell 10 - Address: F4:28:53:64:31:EF ESSID: unknown Mode: Master Channel: 10 Signal: -87 dBm Quality: 23/70 Encryption: WPA2 PSK (CCMP) Cell 11 - Address: 78:44:76:3F:B2:36 ESSID: "TOTOLINK N300RT" Mode: Master Channel: 10 Signal: -94 dBm Quality: 16/70 Encryption: mixed WPA/WPA2 PSK (CCMP) Cell 12 - Address: 4C:F2:BF:23:7C:84 ESSID: "lux - anhben0985984010" Mode: Master Channel: 11 Signal: -87 dBm Quality: 23/70 Encryption: mixed WPA/WPA2 PSK (TKIP, CCMP) Cell 13 - Address: 70:9F:2D:FB:8C:CE ESSID: "KHAI HOAN 3" Mode: Master Channel: 11 Signal: -96 dBm Quality: 14/70 Encryption: mixed WPA/WPA2 PSK (CCMP) Cell 14 - Address: 90:F6:52:5A:89:0E ESSID: "LUX" Mode: Master Channel: 11 Signal: -86 dBm Quality: 24/70 Encryption: WPA PSK (TKIP)';
        $iwinfo='wlan0 ESSID: " Wifi HotSpot 2" Access Point: D4:6E:0E:7D:BF:56 Mode: Master Channel: 8 (2.447 GHz) Tx-Power: unknown Link Quality: unknown/70 Signal: unknown Noise: unknown Bit Rate: unknown Encryption: WPA2 PSK (CCMP) Type: nl80211 HW Mode(s): 802.11bgn Hardware: unknown [Generic MAC80211] TX power offset: unknown Frequency offset: unknown Supports VAPs: yes PHY name: phy0 Cell 01 - Address: 9C:50:EE:29:43:9C ESSID: "Anh Quoc" Mode: Master Channel: 1 Signal: -74 dBm Quality: 36/70 Encryption: mixed WPA/WPA2 PSK (TKIP, CCMP) Cell 02 - Address: 9C:50:EE:1C:AF:3C ESSID: "Su Bin" Mode: Master Channel: 1 Signal: -90 dBm Quality: 20/70 Encryption: mixed WPA/WPA2 PSK (TKIP, CCMP) Cell 03 - Address: C4:A3:66:F8:1E:24 ESSID: "Khong biet" Mode: Master Channel: 2 Signal: -85 dBm Quality: 25/70 Encryption: mixed WPA/WPA2 PSK (CCMP) Cell 04 - Address: F4:F2:6D:FD:27:8E ESSID: " Wifi Hotspot" Mode: Master Channel: 3 Signal: -12 dBm Quality: 70/70 Encryption: none Cell 05 - Address: C6:E9:84:F0:69:4C ESSID: "Wifi" Mode: Master Channel: 8 Signal: -39 dBm Quality: 70/70 Encryption: WPA2 PSK (CCMP) Cell 06 - Address: A0:65:18:3E:D3:4E ESSID: "Chau sa" Mode: Master Channel: 7 Signal: -78 dBm Quality: 32/70 Encryption: WPA2 PSK (CCMP) Cell 07 - Address: 92:F6:52:21:57:B6 ESSID: "Wifi" Mode: Master Channel: 8 Signal: -71 dBm Quality: 39/70 Encryption: WPA2 PSK (CCMP) Cell 08 - Address: 62:65:18:07:82:E4 ESSID: "PPPOE" Mode: Master Channel: 8 Signal: -9 dBm Quality: 70/70 Encryption: none Cell 09 - Address: A0:65:18:07:82:E5 ESSID: unknown Mode: Master Channel: 8 Signal: -8 dBm Quality: 70/70 Encryption: mixed WPA/WPA2 PSK (TKIP, CCMP) Cell 10 - Address: 00:1C:E0:54:3D:47 ESSID: "BICH THAO" Mode: Master Channel: 13 Signal: -70 dBm Quality: 40/70 Encryption: mixed WPA/WPA2 PSK (CCMP)';
        $matches=array();
        $iwinfo= str_replace("unknown/70", "0/70", $iwinfo);
        preg_match_all("/Channel:\s+(\d+)/", $iwinfo, $matches);
        if(count($matches)<2) return new Response(serialize(array('0',"option channel auto")));
        $channels=$matches[1];
        if(count($channels)<2) return new Response(serialize(array('0',"option channel auto")));
        //
        preg_match_all("/Quality:\s+(\d+)/", $iwinfo, $matches);
        if(count($matches)<2) return new Response(serialize(array('0',"option channel auto")));
        $qualities=$matches[1];
        if(count($qualities)<2) return new Response(serialize(array('0',"option channel auto")));
        //

        $qualities[0]="0";
        $currentWifiChannel=$channels[0];
        unset($channels[0]);
        unset($qualities[0]);
        arsort($qualities);
        $suppress=true;
        $threshold=30;

        if(count($qualities)>10) $threshold=35;
        if(count($qualities)>15) $threshold=40;
        while($suppress==true && count($qualities)>0){
            $index=array_search(min($qualities), $qualities);
            if(intval($qualities[$index])<intval($threshold)){
                unset($qualities[$index]);
                unset($channels[$index]);
            }
            else{
                $suppress=false;
            }
        }
        if(count($qualities)==0) return new Response(serialize(array('0',"option channel auto")));
        $range=array(1,2,3,4,5,6,7,8,9,10,11);
        $possible=array_diff($range,$channels);
        if(empty($possible)){
            $currentWifiChannel=$channels[array_search(min($qualities), $qualities)];
            dump( array('1',"option channel ".$currentWifiChannel));
        }
        elseif(false===array_search($currentWifiChannel, $possible)){
            dump(array('1',"option channel ".min($possible)));

        }
        else{
            dump(array('0',"option channel auto"));
        }

        return new Response('<html></html>');
    }
    private function detectWifiChannel($iwinfo){
        //return array('0',"option channel auto");
        //$iwinfo='wlan0 ESSID: "GSS-V4" Access Point: 90:F6:52:21:57:B6 Mode: Master Channel: 4 (2.427 GHz) Tx-Power: 18 dBm Link Quality: 33/70 Signal: -77 dBm Noise: -95 dBm Bit Rate: 39.0 MBit/s Encryption: WPA2 PSK (CCMP) Type: nl80211 HW Mode(s): 802.11bgn Hardware: unknown [Generic MAC80211] TX power offset: unknown Frequency offset: unknown Supports VAPs: yes PHY name: phy0
	    // Cell 01 - Address: EC:08:6B:89:DA:86 ESSID: "Wifi T2" Mode: Master Channel: 1 Signal: -46 dBm Quality: 64/70 Encryption: none
	    // Cell 02 - Address: C4:E9:84:F0:69:4C ESSID: "Wifi Phong Khach" Mode: Master Channel: 4 Signal: -61 dBm Quality: 49/70 Encryption: none
	    // Cell 03 - Address: A0:65:18:3E:D3:4E ESSID: "VNPT HUE" Mode: Master Channel: 7 Signal: -83 dBm Quality: 27/70 Encryption: WPA2 PSK (CCMP)
	    // Cell 04 - Address: 4C:F2:BF:23:BA:7C ESSID: "Dung Si" Mode: Master Channel: 7 Signal: -86 dBm Quality: 24/70 Encryption: mixed WPA/WPA2 PSK (TKIP, CCMP)
	    // Cell 05 - Address: A0:65:18:07:82:E5 ESSID: "Wifi" Mode: Master Channel: 11 Signal: -13 dBm Quality: 70/70 Encryption: WPA2 PSK (TKIP, CCMP)';
	    $matches=array();
	    $iwinfo= str_replace("unknown/70", "0/70", $iwinfo);
	    preg_match_all("/Channel:\s+(\d+)/", $iwinfo, $matches);
	    if(count($matches)<2) return new Response(serialize(array('0',"option channel auto")));
	    $channels=$matches[1];
	    if(count($channels)<2) return new Response(serialize(array('0',"option channel auto")));
	    //
	    preg_match_all("/Quality:\s+(\d+)/", $iwinfo, $matches);
	    if(count($matches)<2) return new Response(serialize(array('0',"option channel auto")));
	    $qualities=$matches[1];
	    if(count($qualities)<2) return new Response(serialize(array('0',"option channel auto")));
	    //

	    $qualities[0]="0";
	    $currentWifiChannel=$channels[0];
	    unset($channels[0]);
	    unset($qualities[0]);
	    arsort($qualities);
	    $suppress=true;
	    $threshold=30;

	    if(count($qualities)>10) $threshold=35;
	    if(count($qualities)>15) $threshold=40;
	    while($suppress==true && count($qualities)>0){
		    $index=array_search(min($qualities), $qualities);
		    if(intval($qualities[$index])<intval($threshold)){
			    unset($qualities[$index]);
			    unset($channels[$index]);
		    }
		    else{
			    $suppress=false;
		    }
	    }
	    if(count($qualities)==0) return new Response(serialize(array('0',"option channel auto")));
	    $range=array(1,2,3,4,5,6,7,8,9,10,11);
	    $possible=array_diff($range,$channels);
        if(empty($possible)){
            $currentWifiChannel=$channels[array_search(min($qualities), $qualities)];
            return array('1',"option channel '".$currentWifiChannel."'");
        }
        elseif(false===array_search($currentWifiChannel, $possible)){
            return array('1',"option channel '".min($possible)."'");

        }
        else{
            return array('0',"option channel 'auto'");
        }
    }
    private function randStrGen($len){
        $result = "";
        $chars = "abcdefghijklmnopqrstuvwxyz\$_?!-0123456789";
        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++){
            $randItem = array_rand($charArray);
            $result .= "".$charArray[$randItem];
        }
        return $result;
    }
    private function addDayswithdate($date,$days){

        $date = strtotime("+".$days." days", strtotime($date));
        return  date("Y-m-d", $date);

    }
    private function parseAndWriteTrack( Request $request)
    {
        $redirUrl = trim($request->get('userurl', ""));
        //if(strpos($redirUrl, "/")===0  )	$redirUrl=$request->getHost().$redirUrl;
        //$response	=	$this->render('HotspotAccessPointBundle:Advert:redirectAdvert.html.twig', array('baseUrl'=>$request->getHost(),'url'=>$redirUrl));
        $adsCookie = $redirUrl . rand();
        $adsCookieTime = time() + 2592000; //3600*24*30;
        $cookie = $request->cookies->get('adsCookie', 0);
        if ($cookie != 0)
            $adsCookie = $cookie;

        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $ua_info = parse_user_agent($mobileDetector->getUserAgent());
        $os = $ua_info['platform'];
        $browser = $ua_info['browser'];

        $wan_ip = $request->getClientIp();
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
            $wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];

        $params = array();
        $params = array_merge($params, array(
            //'wan_ip'=>$this->container->get('request')->server->get("REMOTE_ADDR"),
            'wan_ip' => $wan_ip,
            'isMobile' => ($mobileDetector->isMobile() || $mobileDetector->isTablet()),
            'os' => $os,
            'browser' => $browser,
            'userAgent' => $mobileDetector->getUserAgent(),
            'called' => $request->get("called", ""),
            'mac' => $request->get("mac", ""),
            'ip' => $request->get("ip", ""),
            'userurl' => $redirUrl,
            'web_session' => $adsCookie,
            'challenge' => $request->get("challenge", ""),
            'phase' => 'view_login'
        ));
        //var_dump($params);
        ApLogHelper::writeTrackLoginLog($params);
    }
    /*
    public function loggedAction(Request $request)
    {
        $uamsecret = "auth_9stub_09123";

        $userpassword=1;

        $loginpath = "/ap/";//$_SERVER['PHP_SELF']."/ap/";


        $prefix="HotspotWifiSystem.com";
        $params = array(
                "uamsecret"=>$uamsecret,
                "userpassword"=>$userpassword,
                "title"=>"$prefix Login",
                "centerUsername"=>"Username",
                "centerPassword"=>"Password",
                "centerLogin"=>"Login",
                "centerPleasewait"=>"Please wait.......",
                "centerLogout"=>"Logout",
                "h1Login"=>"$prefix Login",
                "h1Failed"=>"$prefix",
                "h1Loggedin"=>"Logged in to $prefix",
                "h1Loggingin"=>"Logging in to $prefix",
                "h1Loggedout"=>"Logged out from $prefix",
                "centerdaemon"=>"Login must be performed through $prefix connection",
                "centerencrypted"=>"Login must use encrypted connection",
                "loginpath"=>$loginpath
        );

        if(!$request->isSecure()){
            //return $this->render('HotspotAccessPointBundle:APConnect:nonsecure.html.twig',$params);
        }

        $username	=	$request->get("UserName","");
        $password	=	$request->get("Password","");
        $challenge	=	$request->get("challenge","");
        $button		=	$request->get("button","");
        if($button== "Free Internet"){
            $username="demo";
            $password="demohotspot";
            //var_dump($params);
            //return $this->render('HotspotAccessPointBundle:APConnect:index.html.twig',$params);
        }
        $logout		=	$request->get("logout","");
        $prelogin	= 	$request->get("prelogin","");
        $res		=	$request->get("res","");
        $uamip		= 	$request->get("uamip","");
        $uamport	= 	$request->get("uamport","");
        $userurl	= 	$request->get("userurl","");
        $timeleft	= 	$request->get("timeleft","");
        $redirurl	= 	$request->get("redirurl","");
        $reply		= 	$request->get("reply","");
        $ip			= 	$request->get("ip","");
        $called		= 	$request->get("called","");
        $mac		= 	$request->get("mac","");
        $sessionid	=	$request->get("sessionid","");

        $userurldecode = $userurl;
        $redirurldecode = $redirurl;


        $result=-1;
        switch($res) {
            case 'success':     $result =  1; break; // If login successful
            case 'failed':      $result =  2; break; // If login failed
            case 'logoff':      $result =  3; break; // If logout successful
            case 'already':     $result =  4; break; // If tried to login while already logged in
            case 'notyet':      $result =  5; break; // If not logged in yet
            case 'smartclient': $result =  6; break; // If login from smart client
            case 'popup1':      $result = 11; break; // If requested a logging in pop up window
            case 'popup2':      $result = 12; break; // If requested a success pop up window
            case 'popup3':      $result = 13; break; // If requested a logout pop up window
            default: $result = 0; // Default: It was not a form request
        }
        $params = array_merge($params,array(
                "uamsecret"=>$uamsecret,
                "userpassword"=>$userpassword,
                "username"=>$username,
                "password"=>$password,
                "challenge"=>$challenge,
                "button"=>$button,
                "logout"=>$logout,
                "prelogin"=>$prelogin,
                "res"=>$res,
                "uamip"=>$uamip,
                "uamport"=>$uamport,
                "userurl"=>$userurl,
                "timeleft"=>$timeleft,
                "redirurl"=>$redirurl,
                "reply"=>$reply,
                "ip"	=>$ip,
                "called" => $called,
                "mac"	=>$mac,
                "sessionid" =>$sessionid,
                "userurldecode"=>$userurldecode,
                "redirurldecode"=>$redirurldecode,
                "result"=>$result
        ));

        if ($button == 'Login' || $button == 'Free Internet') {
            $hexchal = pack ("H32", $challenge);
            if ($uamsecret) {
                $newchal = pack ("H*", md5($hexchal . $uamsecret));
            } else {
                $newchal = $hexchal;
            }
            $response = md5("\0" . $password . $newchal);
            $newpwd = pack("a32", $password);
            $pappassword = implode ("", unpack("H32", ($newpwd ^ $newchal)));

            $params = array_merge($params,array(
                    "response"=>$response,
                    "pappassword"=>$pappassword
            ));
        }
        //var_dump($params);
        $params = $this->getRequest()->request->all();
        var_dump($params);
        return new Response('Welcome to the homepage.');
    }
    */
}