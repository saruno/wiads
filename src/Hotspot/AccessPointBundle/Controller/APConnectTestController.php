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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
class APConnectTestController extends Controller
{
	public function indexAction(Request $request)
	{
		$uamsecret = "auth_9stub_09123";

		$userpassword=1;

		$loginpath = "/ap/";//$_SERVER['PHP_SELF']."/ap/";
		
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
		if(!$request->isSecure()){
			//return $this->render('HotspotAccessPointBundle:APConnectTest:nonsecure.html.twig',$params);
		}
		
		$username	=	$request->get("UserName","");
		$password	=	$request->get("Password","");
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
		$called		= 	$request->get("called","");
		$mac		= 	$request->get("mac","");
		$sessionid	=	$request->get("sessionid","");
		$advertId	=	$request->get("advertId",'-1');
		
		$userurldecode = $userurl;
		$redirurldecode = $redirurl;
		
		if($button== "Free Internet"){
			$username="wiads_free";
			$password="free_wifi_wiads";
			//FOR CPI, only use with act.html.twig
			//$userurl = $advertId;
			//var_dump($params);
			//return $this->render('HotspotAccessPointBundle:APConnectTest:success.html.twig',array('params' =>$params));
			//if(trim($called)=='F8-1A-67-5D-08-98'){
			//	$username="xuongcafe_nas01_free";
			//	$password="938@347864%";
			//}
			if(trim($called)=='C0-4A-00-E9-FB-99'){
				$username="kangaroo_nas01_free";
				$password="31vothisau";
			}
			if(trim($called)=='C0-4A-00-E9-FB-99'){
				$username="kangaroo_nas01_free";
				$password="31vothisau";
			}
			//30mins timeout
			//if(trim($called)=='EC-08-6B-89-DA-1F'){
			//	$username="wiads_free_30mins";
			//}
			//if(trim($called)=='A4-2B-B0-AC-38-CD'){
			//	$username="wiads_free_30mins";
			//}
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
				"advertId"=>$advertId,
				"userurldecode"=>$userurldecode,
				"redirurldecode"=>$redirurldecode,
				"result"=>$result
		));
		$mobileDetector = $this->get('mobile_detect.mobile_detector');
		$ua_info = parse_user_agent($mobileDetector->getUserAgent());
		$os=$ua_info['platform'];
		$params = array_merge($params,array(
				'os'=>$os
		));
		//var_dump(strcmp("WiAds Free Wifi","Halo.WiAds Free Wifi"));
		//return $this->render('HotspotAccessPointBundle:APConnectTest:5.html.twig',array('responses'=>null,'params' =>$params));
		/**
		 * LOGING IN
		 */
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
			return $this->render('HotspotAccessPointBundle:APConnectTest:loginning_progress.html.twig',$params);
		}
		//$params = array_merge($request->request->all(),$request->query->all());
		//var_dump($params);
		/**
		 * 
		 */
		if ($result == 1 || $result == 4 || $result == 12) {
			//set mode for exception
			/*
			if($params['called']=='EC-08-6B-89-DA-85'){
				$apConfig=ApConfigHelper::getAPStatus($params);
				$apConfig->setNeedUpdate("1");
				$apConfig->setNormalMode("option normal_mode 1");
				$apConfig->save();
				return new Response("Will be disconnected! Please return in 5 minutes!",200);
			}
			*/
			/*
			if($userurldecode!="" && $userurldecode!="http:///")
				return $this->redirect($userurldecode);
			else{
				//var_dump($params);
				return $this->redirect("http://hotspotwifisystem.com/index.html");
			}
			*/
			$adsCookie=$sessionid.rand();
			$adsCookieTime=time() + 2592000; //3600*24*30;
			$cookie=$request->cookies->get('adsCookie',0);
				
			if ($cookie!=0)
				$adsCookie=$cookie;
				$params = array_merge($params,array('adsCookie'=>$adsCookie));
			
			$urlEx=explode("___",$params['userurl']);//contain advertId
			$advertId=$urlEx[0];
			$params['challenge']=$urlEx[1];
			
			$responses = $this->forward('HotspotAccessPointBundle:Advert:callSuccessAds', array('request'=>$request,'params' =>$params));
			/*
			if($userurldecode!="" && $userurldecode!="http:///")
				return $this->redirect($userurldecode);
			else
				return $this->render('HotspotAccessPointBundle:APConnectTest:success.html.twig',array('responses'=>$responses,'params' =>$params) );
			*/
			
			
			$params = array_merge($params,array(
					'phase'=>'login',
					'position'=>"QA2",
					'limit'=>'1'
			));
			//http://auth2.wiads.vn/ap/?called=EC-08-6B-89-DD-AF&ip=172.16.17.4&mac=A4-5E-60-D4-FA-AB&md=5F8F620A206F519C9952F5AC355A8869&nasid=wiads_nasid&res=success&sessionid=579f2f1200000002&timeleft=3600&uamip=172.16.17.1&uamport=8000&uid=wiads_free&userurl=-1___http%3A%2F%2Fsoku.vn%2Fnews%2Fhop-tac%2Fda-nang-day-manh-mang-ket-noi-wifi-mien-phi.html
			//var_dump($params);
			$params = array_merge($params,array(
					'apName'=>ApConfigHelper::getAPName($params['called']),
					'apImage'=>ApConfigHelper::getAPImage($params['called']),
					'apUrl'=>ApConfigHelper::getAPUrl($params['called'])
			));
			if($advertId==-2){
				$linkTo=ApConfigHelper::getAPUrl($params['called']);
			}
			else{
				$linkTo= AdvertHelper::getAdvLink($advertId,$params);
			}
			
			$ads=AdvertHelper::getAds($params);
			//
			if(trim($called)=='C0-4A-00-E9-FB-99'){
				return $this->redirect("http://huebooking.vn",301);
			}
			//when user click an ads from system
			if($linkTo!="")
				//return $this->redirect($linkTo);
				return $this->render('HotspotAccessPointBundle:APConnectTest:success.html.twig',array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'linkTo'=>$linkTo) );
			//if not, redirect to success page
			else{
				
				//return $this->render('HotspotAccessPointBundle:APConnectTest:success_ads_rows.html.twig',array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'linkTo'=>$linkTo) );
				return $this->render('HotspotAccessPointBundle:APConnectTest:success_blank.html.twig',array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'linkTo'=>$linkTo) );
			}
			//For CPA
			//return $this->render('HotspotAccessPointBundle:APConnectTest:success_ads_rows.html.twig',array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'linkTo'=>$linkTo) );
			/*
			if($params['called']=='EC-08-6B-89-DD-AF')
				return $this->render('HotspotAccessPointBundle:APConnectTest:success_ads.html.twig',array('responses'=>$responses,'params' =>$params,'ads'=>$ads,'linkTo'=>$linkTo) );
			else
			//for CPI
			return $this->redirect($linkTo);
			*/
		}
		if ($result == 0) {
			return $this->render('HotspotAccessPointBundle:APConnectTest:fail.html.twig',$params);
		}
		/*
		if ($result == 1) {
			return $this->render('HotspotAccessPointBundle:APConnectTest:1.html.twig',$params);
		}
		*/
		if ($result == 2) {
			$adsCookie=$sessionid.rand();
			$adsCookieTime=time() + 2592000; //3600*24*30;
			$cookie=$request->cookies->get('adsCookie',0);
			
			if ($cookie!=0)
				$adsCookie=$cookie;
			$params = array_merge($params,array('adsCookie'=>$adsCookie));
				
			$response_callLoginFail = $this->forward('HotspotAccessPointBundle:Advert:callFailAds', array('request'=>$request,'params' => $params));
			$result=json_decode($response_callLoginFail, true);
			if($result['code']==1){
				return $this->render('HotspotAccessPointBundle:APConnectTest:index.html.twig',$params);
			}
			$params = array_merge($params,array(
					'phase'=>'login',
					'position'=>"QA0"
			));
			$ads=AdvertHelper::getAds($params);
			 $params = array_merge($params,array(
			 		'apName'=>ApConfigHelper::getAPName($params['called']),
			 		'apImage'=>ApConfigHelper::getAPImage($params['called'])
			 ));
			 $params1=array(
			 		'os' => $params['os'],
			 		'called'=>$called,
			 		'phase'=>'login',
			 		'position'=>"QA1");
			 $ads1=AdvertHelper::getAds($params1);
			 
			 //return $this->render('HotspotAccessPointBundle:APConnectTest:act.html.twig',array('responses'=>$responses,'params' =>$params,'ads'=>$ads));
			 $template='HotspotAccessPointBundle:APConnectTest:'.trim($params['called'].'.html.twig');
			 if ( $this->get('templating')->exists($template) ) {
			 	$response =  $this->render($template,array('params' =>$params,'params1' =>$params1,'ads'=>$ads,'ads1'=>$ads1));
			 }
			 else{
			 	$response = $this->render('HotspotAccessPointBundle:APConnectTest:captival_v3.html.twig',array('responses'=>$response_callLoginFail,'params' =>$params,'ads'=>$ads));
			 }
			 $response->headers->setCookie(new Cookie('adsCookie', $adsCookie,$adsCookieTime));
			 return $response;
		}
		if ($result == 3 || $result == 13) {
			return $this->render('HotspotAccessPointBundle:APConnectTest:3.html.twig',$params);
		}
		/*
		if (($result == 4) || ($result == 12)) {
			
			$params = array_merge($params,array(
					'phase'=>'login',
					'position'=>"QA0"
			));
			$ads=AdvertHelper::getAds($params);
			
			 $params = array_merge($params,array(
			 		'apName'=>ApConfigHelper::getAPName($params['called']),
			 		'apImage'=>ApConfigHelper::getAPImage($params['called'])
			 ));
			 
			 //var_dump($params);
			 //return $this->render('HotspotAccessPointBundle:APConnectTest:4.html.twig',$params);
			 return $this->render('HotspotAccessPointBundle:APConnectTest:act.html.twig',array('responses'=>$responses,'params' =>$params,'ads'=>$ads));
		}
		*/
		if ($result == 5) {
			//var_dump(ApConfigHelper::isActivated($params));
			if(ApConfigHelper::isActivated($params)!=true){
				return $this->render('HotspotAccessPointBundle:APConnectTest:not_activated.html.twig',$params);
			}
			
			$adsCookie=$sessionid.rand();
			$adsCookieTime=time() + 2592000; //3600*24*30;
			$cookie=$request->cookies->get('adsCookie',0);
			if ($cookie!=0)
				$adsCookie=$cookie;
			$params = array_merge($params,array('adsCookie'=>$adsCookie));
			/*
			$response_callLoginAds = $this->forward('HotspotAccessPointBundle:Advert:callLoginAds', array('request'=>$request,'params' => $params));
			$result=json_decode($response_callLoginAds, true);
			if($result['code']==1){
				return $this->render('HotspotAccessPointBundle:APConnectTest:index.html.twig',$params);
			}
			*/
			$params = array_merge($params,array(
					'phase'=>'login',
					'limit'=>1,
					'position'=>"QA0"
			));
			$ads=AdvertHelper::getAds($params);
			$params1=array(
					'os' => $params['os'],
					'called'=>$called,
					'limit'=>1,
					'phase'=>'login',
					'position'=>"QA1");
			$ads1=AdvertHelper::getAds($params1);
			/*
			if($params['called']=='F4-F2-6D-FD-27-8D' || $params['called']=='EC-08-6B-89-DD-AF'){
				return $this->render('HotspotAccessPointBundle:APConnectTest:F4_F2_6D_FD_27_8D.html.twig',array('responses'=>$responses,'params' =>$params));
			}
			else 
			*/
			
			$params = array_merge($params,array(
					'apName'=>ApConfigHelper::getAPName($params['called']),
					'apImage'=>ApConfigHelper::getAPImage($params['called']),
					'apUrl'=>ApConfigHelper::getAPUrl($params['called'])
			));
			//var_dump($params);
			//FOR CPA
			$template='HotspotAccessPointBundle:APConnectTest:'.trim($params['called'].'.html.twig');
			if ( $this->get('templating')->exists($template) ) {
				$response =  $this->render($template,array('params' =>$params,'params1' =>$params1,'ads'=>$ads,'ads1'=>$ads1));
			}
			else{
				$response =  $this->render('HotspotAccessPointBundle:APConnectTest:captival_v3.html.twig',array(/*'responses'=>$response_callLoginAds,*/'params' =>$params,'params1' =>$params1,'ads'=>$ads,'ads1'=>$ads1));
			}
			/*
			if($params['called']=='EC-08-6B-89-DD-AF')
				$response =  $this->render('HotspotAccessPointBundle:APConnectTest:5.html.twig',array('responses'=>$response_callLoginAds,'params' =>$params,'ads'=>$ads));
			else //FOR CPI
				$response =	 $this->render('HotspotAccessPointBundle:APConnectTest:act.html.twig',array('responses'=>$response_callLoginAds,'params' =>$params,'ads'=>$ads));
			*/
			$response->headers->setCookie(new Cookie('adsCookie', $adsCookie,$adsCookieTime));
			
			return $response;
		}
		if ($result == 11) {
			return $this->render('HotspotAccessPointBundle:APConnectTest:loginning_progress.html.twig',$params);
		}
		return $this->render('HotspotAccessPointBundle:APConnectTest:index.html.twig',$params);
	}
	public function ssidAction(Request $request){
		$wan_ip = $request->getClientIp();
		if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
			$wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
			//if(isset($_SERVER["HTTP_REFERER"]))
				//var_dump($_SERVER["HTTP_REFERER"]);
		$mac = $request->get("mac",'');
		$mac=str_replace(":", "-", $mac);
		$mac=strtoupper($mac);
		$v=$request->get("v",'');
		$hw=$request->get("hw",'');
		$ssid=$request->get("ssid",'');
		$uamdomains=$request->get("uamdomains",'');
		$uamformat=$request->get("uamformat",'');
		$uamhomepage=$request->get("uamhomepage",'');
		$macauth=$request->get("macauth",'');
		$channel=$request->get("channel",'');
		$htmode=$request->get("htmode",'');
		$htmode=str_replace("plus_sign", "+", $htmode);
		$channel=$request->get("channel",'');
		$noscan=$request->get("noscan",'');
		$encryption=$request->get("encryption",'');
		$key=$request->get("key",'');
		$iwinfo=$request->get("iwinfo",'');
		$iwinfo=$request->get("iwinfo",'');
		$challenge=$request->get("challenge",'');
		$hash=trim($request->get("hash",''));
		$secretkey=$this->getParameter('secret_hash_key');
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
			//throw $this->createNotFoundException('Hello world!');
			return new Response("Hello World!",404);
		}
		$new_challenge=self::randStrGen(20);
		$new_hash=md5(trim($new_challenge).trim($secretkey));
		
		$params=array(
					"called"=>$mac,
					"v"=>$v,
					"hw"=>$hw,
					"ip"=>$wan_ip,
					"ssid"=>$ssid,
					"uamdomains"=>$uamdomains,
					"uamformat"=>$uamformat,
					"uamhomepage"=>$uamhomepage,
					"macauth"	=>$macauth,
					"channel"=>$channel,
					"htmode"=>$htmode,
					"channel"=>$channel,
					"noscan"=>$noscan,
					"encryption"=>$encryption,
					"key"=>$key,
					"iwinfo"=>$iwinfo
		);
		
		//ApLogHelper::writeRequestLog($params);
		ApConfigHelper::updateAPStatus($params);
/***********************************************************/
/**
 * AP UPDATE
 */
/***********************************************************/
		$apConfig=ApConfigHelper::getAPStatus($params);
		//Reboot schedule, default system will reboot at 0AM,12PM UTC-> 7AM,7PM GMT+7
		//var_dump(date('H:i:s'));
		if(		($apConfig!=null && $apConfig->getExclude()!=1)
				&&
				(strtotime(date('H:i:s')) > strtotime('12:00:00') )
				&&
				(strtotime(date('H:i:s')) < strtotime('12:05:00') )
		  ){
					$apConfig->setNeedUpdate("1");
					$apConfig->setNeedReboot("option need_reboot 1");
		}
		/*
		if(		($apConfig!=null && $apConfig->getExclude()!=1)
				&&
				(strtotime(date('H:i:s')) > strtotime('18:00:00') )
				&&
				(strtotime(date('H:i:s')) < strtotime('18:05:00') )
				){
					$apConfig->setNeedUpdate("1");
					$apConfig->setNeedReboot("option need_reboot 1");
		}
		*/
		if(		($apConfig!=null && $apConfig->getExclude()!=1)
				&&
				(strtotime(date('H:i:s')) > strtotime('05:00:00') )
				&&
				(strtotime(date('H:i:s')) < strtotime('05:05:00') )
				){
					$apConfig->setNeedUpdate("1");
					$apConfig->setNeedReboot("option need_reboot 1");
		}
		if(		($apConfig!=null && strcmp($v,"20160625.01")<0)
				&&
				(strtotime(date('H:i:s')) > strtotime('23:50:00') )
				&&
				(strtotime(date('H:i:s')) < strtotime('23:55:00') )
				){
					$apConfig->setNeedUpdate("1");
					$apConfig->setNeedReboot("option need_reboot 1");
		}
		////////
		////////DETECT CONFLICT WIFI CHANNEL
		$detects=self::detectWifiChannel($iwinfo);
		//$tmpChannelNext=$apConfig->getChannelNext();
		if(count($detects)==2){
			if($detects[0]==1){
				$apConfig->setNeedUpdate("1");
				$apConfig->setUpdateChannel("option channel_update 1");
				$apConfig->setChannelNext($detects[1]);
				$apConfig->save();
			}
		}
		/////////
		if( ($apConfig!=null)
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
			$option=
			"challenge:$new_challenge"."\n"
			."hash:$new_hash"."\n"
			.$apConfig->getFwUpgrade()."\n"
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
			.$apConfig->getUpdateChannel()."\n"
			.$apConfig->getChannelNext()."\n"
			.$apConfig->getUpdateHtmode()."\n"
			.$apConfig->getHtmodeNext()."\n"
			.$apConfig->getUpdateNoscan()."\n"
			.$apConfig->getNoscanNext()."\n"
			.$apConfig->getUpdateEncryption()."\n"
			.$apConfig->getEncryptionNext()."\n"
			.$apConfig->getUpdateKey()."\n"
			.$apConfig->getKeyNext()."\n"
			.$apConfig->getNeedReboot()."\n"
			.$apConfig->getNormalMode()."\n";
			
			
			
			if (trim($apConfig->getUpdateChannel())=="option channel_update 1"){
				//$apConfig->setChannelNext($tmpChannelNext);
				$apConfig->setUpdateChannel("option channel_update 0");
				$apConfig->save();
			}
			if ($apConfig->getNeedReboot()=="option need_reboot 1"){
				$apConfig->setNeedReboot("option need_reboot 0");
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
			return new Response($option);
		}
		if( ($apConfig!=null)
				&& ($apConfig->getNeedUpdate()==0)
				&& (trim($apConfig->getNormalMode())=="option normal_mode 1")
				)
		{
			$option=
			"challenge:$new_challenge"."\n"
			."hash:$new_hash"."\n"
			.$apConfig->getNormalMode()."\n";
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
			$apConfig->setNeedUpdate("0");
			$apConfig->setFwUpgrade("option fw_upgrade 0");
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
	/**
	 * CHECK MAC
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function verifyMacAction(Request $request){
		$mac=$request->get('mac','');
		$ap=ApConfigHelper::getAPInfo($mac);
		$isUsingKey=ApConfigHelper::isUsingKey($mac);
		
		$response = new Response(json_encode(array(
				'mac'=>$ap->getMacaddr(),
				'key'=>str_replace('"','',$ap->getKey()),
				'name'=>$ap->getName(),
				'address'=>$ap->getAddress(),
				'province'=>$ap->getProvince(),
				'isUsingKey'=>$isUsingKey,
				'trash'=>$ap->getTrash()
				)));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}
	/**
	 * REPORT ACTION
	 * @param Request $request
	 */
	public function reportAction(Request $request){
		//Update
		$saveStatus="";
		$macaddr=$request->get('macaddr','');
		$name=$request->get('name','');
		$province=$request->get('province','-1');
		$company=$request->get('company','-1');
		$address=$request->get('address','');
		$wifipass=$request->get('wifipass','');
		$usewifipass=$request->get('usewifipass','0');
		$activated=$request->get('activated','0');
		
		if($macaddr!=""){
			$params=array(
				'macaddr'=>trim($macaddr),
				'name'=>trim($name),
				'province'=>trim($province),
				'company'=>trim($company),
				'address'=>trim($address),
				'wifipass'=>trim($wifipass),
				'usewifipass'=>trim($usewifipass),
				'activated'	=>trim($activated)
			);
			$api_service = $this->get("accesspoint.service");
			$saveStatus=ApConfigHelper::updateAPInfo($params,$api_service);
			//var_dump($params);
		}
		
		$report=$request->get('report',0);
		$from_0 = $request->get('from',date("Y-m-d"));
		$from_1=date_create(self::addDayswithdate($from_0,-1));
		$from_1=$from_1->format('Y-m-d');
		$date=date_create(self::addDayswithdate($from_0,1));
		$to = $request->get('to',$date->format('Y-m-d'));
		$num_1=0;
		$num_0=0;
		//
		$username=null;
		if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')){
			$username=$this->getUser()->getUsername();
		}
		$owners=ApConfigHelper::getOwnerList($username);
		$params=array(
				'from_1'=>$from_1,
				'from_0'=>$from_0,
				'to' => $to,
				'province' => $province,
				'company'=>trim($company)
		);
		$result=null;
		$popup_1=0;
		$login_1=0;
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
			//var_dump($params);
			//return new Response('a');
			ApConfigHelper::updateApInfoAll();
			
			$num_access=ApLogHelper::reportClientAccessLog($params);
			foreach  ($num_access as $row){
				if($popup_1==0){
					$popup_1=$row["popup"];
					$login_1=$row["click_login"];
					$success_1=$row["success_login"];
					$fail_1=$row["fail"];
				}
				else{
					$popup_0=$row["popup"];
					$login_0=$row["click_login"];
					$success_0=$row["success_login"];
					$fail_0=$row["fail"];
				}
			}
			$with_user_access_num=$request->get('with_user_access_num',0);
			if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')){
				$params = array_merge($params,array(
						'level'=>1
				));
			}
			if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')){
				$params = array_merge($params,array(
						'level'=>2
				));
				$user=$this->getUser();
				$params['company']=$user->getCompany();
			}
			if($with_user_access_num==1){
				$result=ApLogHelper::reportLogAll($params);
			}
			else{
				$result=ApLogHelper::reportLogApStatus($params);
			}
		}
		return $this->render('HotspotAccessPointBundle:APConnectTest:report.html.twig',array(
				'result'=>$result,'params'=>$params,
				'popup_0'=>$popup_0,'popup_1'=>$popup_1,
				'login_0'=>$login_0,'login_1'=>$login_1,
				'success_0'=>$success_0,'success_1'=>$success_1,
				'fail_0'=>$fail_0,'fail_1'=>$fail_1,
				'saveStatus'=>$saveStatus,'owners'=>$owners) );
		
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
	public function testAction(Request $request){
		return $this->render('HotspotAccessPointBundle:APConnectTest:test.html.twig');
	}
	
	public function detectWifiChannelAction(Request $request){
		//$iwinfo='wlan0 ESSID: "GSS-V4" Access Point: 90:F6:52:21:57:B6 Mode: Master Channel: 8 (2.447 GHz) Tx-Power: 18 dBm Link Quality: 65/70 Signal: -45 dBm Noise: -95 dBm Bit Rate: 51.7 MBit/s Encryption: WPA2 PSK (CCMP) Type: nl80211 HW Mode(s): 802.11bgn Hardware: unknown [Generic MAC80211] TX power offset: unknown Frequency offset: unknown Supports VAPs: yes PHY name: phy0 Cell 01 - Address: 00:1D:AA:D1:42:48 ESSID: "GSS-V2" Mode: Master Channel: 8 Signal: -55 dBm Quality: 55/70 Encryption: WPA2 PSK (CCMP) Cell 02 - Address: EC:08:6B:DA:DE:CE ESSID: "APEC-HUE" Mode: Master Channel: 2 Signal: -77 dBm Quality: 33/70 Encryption: none Cell 03 - Address: 78:44:76:3F:B5:DA ESSID: "MAKALOT" Mode: Master Channel: 1 Signal: -52 dBm Quality: 58/70 Encryption: mixed WPA/WPA2 PSK (CCMP) Cell 04 - Address: F4:EC:38:C8:50:AE ESSID: unknown Mode: Master Channel: 4 Signal: -76 dBm Quality: 34/70 Encryption: none Cell 05 - Address: 78:44:76:4B:91:F1 ESSID: "Photo Ngoc Vinh" Mode: Master Channel: 4 Signal: -83 dBm Quality: 27/70 Encryption: WPA2 PSK (CCMP)';
		$iwinfo='wlan0 ESSID: " QUÁN 87-WIADS" Access Point: EC:08:6B:89:E3:9E Mode: Master Channel: 6 (2.437 GHz) Tx-Power: 18 dBm Link Quality: 21/70 Signal: -89 dBm Noise: -95 dBm Bit Rate: 1.0 MBit/s Encryption: none Type: nl80211 HW Mode(s): 802.11bgn Hardware: unknown [Generic MAC80211] TX power offset: unknown Frequency offset: unknown Supports VAPs: yes PHY name: phy0 Cell 01 - Address: D4:4C:9C:02:74:36 ESSID: "An" Mode: Master Channel: 1 Signal: -57 dBm Quality: 53/70 Encryption: WPA PSK (CCMP) Cell 02 - Address: 98:F4:28:B2:98:BF ESSID: "home123" Mode: Master Channel: 1 Signal: -7 dBm Quality: 70/70 Encryption: WPA2 PSK (TKIP, CCMP) Cell 03 - Address: 98:F4:28:B8:8B:4D ESSID: "Happy" Mode: Master Channel: 6 Signal: -90 dBm Quality: 20/70 Encryption: mixed WPA/WPA2 PSK (CCMP)';
		preg_match_all("/Channel:\s+(\d+)/", $iwinfo, $matches);
		if(count($matches)<2) return array('0',"option channel auto");
		$channels=$matches[1];
		if(count($channels)<2) return array('0',"option channel auto");
		//
		preg_match_all("/Quality:\s+(\d+)/", $iwinfo, $matches);
		if(count($matches)<2) return array('0',"option channel auto");
		$qualities=$matches[1];
		if(count($qualities)<2) return array('0',"option channel auto");
		//
		
		$qualities[0]="0";
		$currentWifiChannel=$channels[0];
		unset($channels[0]);
		unset($qualities[0]);
		arsort($qualities);
		$range=array(1,2,3,4,5,6,7,8,9,10,11);
		$possible=array_diff($range,$channels);
		//var_dump($possible);
		if(empty($possible)){
			$currentWifiChannel=$channels[array_search(min($qualities), $qualities)];
			var_dump('1',"option channel ".$currentWifiChannel);
		}
		if(false===array_search($currentWifiChannel, $possible)){
			var_dump('1',"option channel ".min($possible));
			
		}
		else{
			var_dump('0',"option channel auto");
		}
		
		return new Response('<html></html');
	}
	private function detectWifiChannel($iwinfo){
		//$iwinfo='wlan0 ESSID: "GSS-V4" Access Point: 90:F6:52:21:57:B6 Mode: Master Channel: 4 (2.427 GHz) Tx-Power: 18 dBm Link Quality: 33/70 Signal: -77 dBm Noise: -95 dBm Bit Rate: 39.0 MBit/s Encryption: WPA2 PSK (CCMP) Type: nl80211 HW Mode(s): 802.11bgn Hardware: unknown [Generic MAC80211] TX power offset: unknown Frequency offset: unknown Supports VAPs: yes PHY name: phy0 Cell 01 - Address: EC:08:6B:89:DA:86 ESSID: "Wifi T2" Mode: Master Channel: 1 Signal: -46 dBm Quality: 64/70 Encryption: none Cell 02 - Address: C4:E9:84:F0:69:4C ESSID: "Wifi Phong Khach" Mode: Master Channel: 4 Signal: -61 dBm Quality: 49/70 Encryption: none Cell 03 - Address: A0:65:18:3E:D3:4E ESSID: "VNPT HUE" Mode: Master Channel: 7 Signal: -83 dBm Quality: 27/70 Encryption: WPA2 PSK (CCMP) Cell 04 - Address: 4C:F2:BF:23:BA:7C ESSID: "Dung Si" Mode: Master Channel: 7 Signal: -86 dBm Quality: 24/70 Encryption: mixed WPA/WPA2 PSK (TKIP, CCMP) Cell 05 - Address: A0:65:18:07:82:E5 ESSID: "Wifi" Mode: Master Channel: 11 Signal: -13 dBm Quality: 70/70 Encryption: WPA2 PSK (TKIP, CCMP)';
		$iwinfo= str_replace("unknown/70", "0/70", $iwinfo);
		preg_match_all("/Channel:\s+(\d+)/", $iwinfo, $matches);
		if(count($matches)<2) return array('0',"option channel auto");
		$channels=$matches[1];
		if(count($channels)<2) return array('0',"option channel auto");
		//
		preg_match_all("/Quality:\s+(\d+)/", $iwinfo, $matches);
		if(count($matches)<2) return array('0',"option channel auto");
		$qualities=$matches[1];
		if(count($qualities)<2) return array('0',"option channel auto");
		//
		
		$qualities[0]="0";
		$currentWifiChannel=$channels[0];
		unset($channels[0]);
		unset($qualities[0]);
		arsort($qualities);
		$range=array(1,2,3,4,5,6,7,8,9,10,11);
		$possible=array_diff($range,$channels);
		if(empty($possible)){
			$currentWifiChannel=$channels[array_search(min($qualities), $qualities)];
			return array('1',"option channel ".$currentWifiChannel);
		}
		if(false===array_search($currentWifiChannel, $possible)){
			return array('1',"option channel ".min($possible));
				
		}
		else{
			return array('0',"option channel auto");
		}
		//var_dump($qualities);
		/*
		$key = array_search(max($qualities), $qualities);
		
		if($key>0 && abs($channels[0]-$channels[$key])<2 && $qualities[$key]>60){
			$channels[0]=($channels[$key]+2)%11+1;
			return array('1',"option channel ".$channels[0]);
		}
		else{
			return array('0',"option channel auto");
		}
		*/
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
			//return $this->render('HotspotAccessPointBundle:APConnectTest:nonsecure.html.twig',$params);
		}
		
		$username	=	$request->get("UserName","");
		$password	=	$request->get("Password","");
		$challenge	=	$request->get("challenge","");
		$button		=	$request->get("button","");
		if($button== "Free Internet"){
			$username="demo";
			$password="demohotspot";
			//var_dump($params);
			//return $this->render('HotspotAccessPointBundle:APConnectTest:index.html.twig',$params);
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
