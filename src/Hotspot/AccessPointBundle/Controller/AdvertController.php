<?php

namespace Hotspot\AccessPointBundle\Controller;

use Common\DbBundle\Model\Advert;
use Common\DbBundle\Model\AdvertQuery;
use Hotspot\AccessPointBundle\Model\Base\AdsDistributionQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
//use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Hotspot\AccessPointBundle\Helper\AdvertHelper;

class AdvertController extends Controller
{
	public function goAction( Request $request,$locale){
		$redirUrl=trim($request->get('link',$request->getHost()));
		if(strpos($redirUrl, "/")===0  )	$redirUrl=$request->getHost().$redirUrl;
        //var_dump($redirUrl);
        //return new Response();
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

		$autoRedirect = $request->get('autoRedirect', "0");
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
				'id'		=> 	$request->get("id","0"),
				'userurl'=>$redirUrl,
				'web_session'=>$adsCookie,
				'phase'=>'click_ads'
		));
		//var_dump($params);
		AdvertHelper::writeTrackLog($params);
        //$redirUrl=$redirUrl."&id=".$params['id'];
        if ($autoRedirect == 0) {
            $response = $this->render('HotspotAccessPointBundle:Advert:redirectAdvert.html.twig', array('baseUrl' => $request->getHost(), 'url' => $redirUrl . "?called=" . $params['called'] . "&mac=" . $params['mac'] . "&ip=" . $params['ip']));
            //AdvertHelper::updateRead($redirUrl, $locale);
            $response->headers->setCookie(new Cookie('adsCookie', $adsCookie, $adsCookieTime));
            return $response;
        } else {
            return $this->redirect(rawurldecode($redirUrl),301);
        }
	}
	public function displayAction( Request $request,$locale){
        $redirUrl=trim($request->get('link',$request->getHost()));

        $img_pos=intval($request->get('img_pos',1));

        $id=intval($request->get('id',-1));
        /** @var Advert $adv */
        $adv = AdvertHelper::getAdvById($id);

        if(empty($adv)){
            $response = new Response();
            $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, "track.png");
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-Type', 'image/png');
            $response->setContent(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='));

            return $response;
        }

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
            'img_pos'=>$img_pos,
            //'wan_ip'=>$this->container->get('request')->server->get("REMOTE_ADDR"),
            'wan_ip'=>$wan_ip,
            'id'=> 	$request->get("id","0"),
            'isMobile'=>($mobileDetector->isMobile() || $mobileDetector->isTablet()),
            'os' => $os,
            'browser' => $browser,
            'userAgent'	=>$mobileDetector->getUserAgent(),
            'called'		=> 	$request->get("called",""),
            'mac'		=> 	$request->get("mac",""),
            'ip'		=> 	$request->get("ip",""),
            'position'	=> 	$request->get("position","QA0"),
            'userurl'=>$redirUrl,
            'web_session'=>$adsCookie,
            'phase'=>'view_ads'
        ));

        AdvertHelper::writeTrackLog($params);

        $ads_dis=AdsDistributionQuery::create()
            ->filterByAdvertId($id)
            ->findOneOrCreate();
        $ads_dis->setCurrent($ads_dis->getCurrent()+1);
        $ads_dis->save();

        //AdvertHelper::updateRead($redirUrl, $locale);

		//$urlImg=$adv->get1stImage();
		//$imgName=explode("/",$urlImg);
		//$image=$this->get('kernel')->getRootDir()."/../web/".$urlImg;

        $urlImg=AdvertHelper::getAdvImg($id,$params);
        $imgName=explode("/",$urlImg);
        $image=$this->get('kernel')->getRootDir()."/../web/".$urlImg;
        $response = new Response();

        if($adv->getHomePosition()=='QAF_M'){
            $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, "track.png");
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-Type', 'image/png');
            $response->setContent(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='));
        }
        elseif($adv->getHomePosition()=='QAF_VLP'){
            $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, "track.png");
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-Type', 'image/png');
            $response->setContent(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='));
        }
        else {
            $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, end($imgName));
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-Type', 'image/jpeg');
            $content=false;
            if(file_exists($image))
                $content=file_get_contents($image);
            if($content==false){
                $response->setContent(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='));
            }
            else
                $response->setContent(file_get_contents($image));
            //$response->setContent(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='));
        }
        return $response;
	}
    public function display2Action( Request $request,$locale){
        $adv = AdvertHelper::getAdvById($request->get('id',-1));
        if(empty($adv) || $adv->getHomePosition()=='QAF_M' || $adv->getHomePosition()=='QAF_VLP'){
            $response = new Response();
            $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, "track.png");
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-Type', 'image/png');
            $response->setContent(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='));

            return $response;
        }
        $urlImg=$adv->get2ndImage();
        $imgName=explode("/",$urlImg);
        $image=$this->get('kernel')->getRootDir()."/../web/".$urlImg;
        $response = new Response();
        if(empty($urlImg)){
            $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, "track.png");
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-Type', 'image/png');
            $response->setContent(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='));
        }
        else {


            $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, end($imgName));
            $response->headers->set('Content-Disposition', $disposition);
            $response->headers->set('Content-Type', 'image/jpeg');
            $content=false;
            if(file_exists($image))
                $content=file_get_contents($image);
            if($content==false){
                $response->setContent(base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='));
            }
            else
                $response->setContent(file_get_contents($image));
        }
        return $response;
    }
	public function callSuccessAdsAction( Request $request, $params){
		/*
		 * Desktop
		 Windows
		 Linux
		 Macintosh
		 Chrome OS
		 * Mobile
		 Android
		 iPhone
		 iPad / iPod Touch
		 Windows Phone OS
		 Kindle
		 Kindle Fire
		 BlackBerry
		 Playbook
		 Tizen
		 */
		/*
		 * Android Browser
		 BlackBerry Browser
		 Camino
		 Kindle / Silk
		 Firefox / Iceweasel
		 Safari
		 Internet Explorer
		 IEMobile
		 Chrome
		 Opera
		 Midori
		 Vivaldi
		 TizenBrowser
		 Lynx
		 Wget
		 Curl
		 */
		$mobileDetector = $this->get('mobile_detect.mobile_detector');
		$ua_info = parse_user_agent($mobileDetector->getUserAgent());
		$os=$ua_info['platform'];
		$browser=$ua_info['browser'];
	/*
		$params = array('called'=>'C4-E9-84-F0-69-4C',
			'challenge'=>'c4d69c4cc3188bb1ef8910186bc5df1b',
			'ip'=>'172.16.10.2',
			'mac'=>'98-5A-EB-C6-DE-4B',
			'md'=>'EA353742863A5372379BE0D5F22CFACF',
			'nasid'=>'demogroup_nas01',
			'res'=>'notyet',
			'sessionid'=>'5716e27600000002',
			'uamip'=>'172.16.10.1',
			'userurl'=>'http%3A%2F%2Fwww.facebook.com%2F',
			'wan_ip'=>$this->container->get('request')->server->get("REMOTE_ADDR"),
			'isMobile'=>($mobileDetector->isMobile() || $mobileDetector->isTablet()),
			'os' => $os,
			'browser' => $browser,
			'userAgent'	=>$mobileDetector->getUserAgent(),
			'phase'=>'success'
		);
	*/
		$wan_ip = $request->getClientIp();
		if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
			$wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
		
		$params = array_merge($params,array(
			//'wan_ip'=>$this->container->get('request')->server->get("REMOTE_ADDR"),
			'wan_ip'=>$wan_ip,
			'isMobile'=>($mobileDetector->isMobile() || $mobileDetector->isTablet()),
			'os' => $os,
			'browser' => $browser,
			'userAgent'	=>$mobileDetector->getUserAgent(),
			'phase'=>'success'
		));
		AdvertHelper::writeRequestLog($params);
		
		return new Response(json_encode($params));
	}
	public function callLoginAdsAction( Request $request,$params){
		/*
		 * Desktop
		 Windows
		 Linux
		 Macintosh
		 Chrome OS
		 * Mobile
		 Android
		 iPhone
		 iPad / iPod Touch
		 Windows Phone OS
		 Kindle
		 Kindle Fire
		 BlackBerry
		 Playbook
		 Tizen
		 */
		/*
		 * Android Browser
		 BlackBerry Browser
		 Camino
		 Kindle / Silk
		 Firefox / Iceweasel
		 Safari
		 Internet Explorer
		 IEMobile
		 Chrome
		 Opera
		 Midori
		 Vivaldi
		 TizenBrowser
		 Lynx
		 Wget
		 Curl
		 */
		$mobileDetector = $this->get('mobile_detect.mobile_detector');
		$ua_info = parse_user_agent($mobileDetector->getUserAgent());
		$os=$ua_info['platform'];
		$browser=$ua_info['browser'];
/*
		$params = array('called'=>'C4-E9-84-F0-69-4C',
			'challenge'=>'c4d69c4cc3188bb1ef8910186bc5df1b',
			'ip'=>'172.16.10.2',
			'mac'=>'98-5A-EB-C6-DE-4B',
			'md'=>'EA353742863A5372379BE0D5F22CFACF',
			'nasid'=>'demogroup_nas01',
			'res'=>'notyet',
			'sessionid'=>'5716e27600000002',
			'uamip'=>'172.16.10.1',
			'userurl'=>'http%3A%2F%2Fwww.facebook.com%2F',
			'wan_ip'=>$this->container->get('request')->server->get("REMOTE_ADDR"),
			'isMobile'=>($mobileDetector->isMobile() || $mobileDetector->isTablet()),
			'os' => $os,
			'browser' => $browser,
			'userAgent'	=>$mobileDetector->getUserAgent(),
			'phase'=>'login'
		);
*/
		$wan_ip = $request->getClientIp();
		if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
			$wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
		$params = array_merge($params,array(
			'wan_ip'=>$wan_ip,
			'isMobile'=>($mobileDetector->isMobile() || $mobileDetector->isTablet()),
			'os' => $os,
			'browser' => $browser,
			'userAgent'	=>$mobileDetector->getUserAgent(),
			'phase'=>'login',
			'position'=>"QA0",
			'code'=>'0'
		));
		if(trim($browser)!="Camera360"
				&& trim($browser)!="Version"
				&& $os!="" 
				&& $os!=null
				){
			AdvertHelper::writeRequestLog($params);
		}
		else{
			$params['code']=1;
		}

		///
        if(key_exists('email',$params) && !empty($params['email'])){
            AdvertHelper::saveUserEmail(trim($params['email']),$params);
        }


		return new Response(json_encode($params));
	}
	public function callFailAdsAction( Request $request,$params){
		/*
		 * Desktop
		 Windows
		 Linux
		 Macintosh
		 Chrome OS
		 * Mobile
		 Android
		 iPhone
		 iPad / iPod Touch
		 Windows Phone OS
		 Kindle
		 Kindle Fire
		 BlackBerry
		 Playbook
		 Tizen
		 */
		/*
		 * Android Browser
		 BlackBerry Browser
		 Camino
		 Kindle / Silk
		 Firefox / Iceweasel
		 Safari
		 Internet Explorer
		 IEMobile
		 Chrome
		 Opera
		 Midori
		 Vivaldi
		 TizenBrowser
		 Lynx
		 Wget
		 Curl
		 */
		$mobileDetector = $this->get('mobile_detect.mobile_detector');
		$ua_info = parse_user_agent($mobileDetector->getUserAgent());
		$os=$ua_info['platform'];
		$browser=$ua_info['browser'];
		/*
			$params = array('called'=>'C4-E9-84-F0-69-4C',
			'challenge'=>'c4d69c4cc3188bb1ef8910186bc5df1b',
			'ip'=>'172.16.10.2',
			'mac'=>'98-5A-EB-C6-DE-4B',
			'md'=>'EA353742863A5372379BE0D5F22CFACF',
			'nasid'=>'demogroup_nas01',
			'res'=>'notyet',
			'sessionid'=>'5716e27600000002',
			'uamip'=>'172.16.10.1',
			'userurl'=>'http%3A%2F%2Fwww.facebook.com%2F',
			'wan_ip'=>$this->container->get('request')->server->get("REMOTE_ADDR"),
			'isMobile'=>($mobileDetector->isMobile() || $mobileDetector->isTablet()),
			'os' => $os,
			'browser' => $browser,
			'userAgent'	=>$mobileDetector->getUserAgent(),
			'phase'=>'login'
			);
			*/
		$wan_ip = $request->getClientIp();
		if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
			$wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
			$params = array_merge($params,array(
					'wan_ip'=>$wan_ip,
					'isMobile'=>($mobileDetector->isMobile() || $mobileDetector->isTablet()),
					'os' => $os,
					'browser' => $browser,
					'userAgent'	=>$mobileDetector->getUserAgent(),
					'phase'=>'fail',
					'position'=>"QA0",
					'code'=>'0'
			));
			if(trim($browser)!="Camera360"
					&& trim($browser)!="Version"
					&& $os!=""
					&& $os!=null
					){
						AdvertHelper::writeRequestLog($params);
			}
			else{
				$params['code']=1;
			}
			return new Response(json_encode($params));
	}
	public function bbqEmailSuccessAction( Request $request){
		$email=$request->get('email','');
		if(trim($email)!=""){
			AdvertHelper::saveUserEmail(trim($email));
			return $this->redirect("http://www.giaybq.com.vn");
		}
		return $this->render('HotspotAccessPointBundle:Advert:bbq_email_success.html.twig');
	}
    public function ibigAction( Request $request){
	    $advert_id=$request->get('advert_id',0);
        $email=$request->get('email','');
        if(trim($email)!=""){
            AdvertHelper::saveUserEmail(trim($email));
            return $this->redirect("http://www.giaybq.com.vn");
        }
        return $this->render('HotspotAccessPointBundle:Advert:bbq_email_success.html.twig');
    }
	public function bbqYoutubeSuccessAction( Request $request){
		return $this->render('HotspotAccessPointBundle:Advert:bbq_youtube_success.html.twig');
	}
	public function memberAction(Request $request){ 
		$report=$request->get('report',0);
		$from_0 = $request->get('from',date("Y-m-d"));
		$from_1=date_create(self::addDayswithdate($from_0,-1));
		$from_1=$from_1->format('Y-m-d');
		$date=date_create(self::addDayswithdate($from_0,1));
		$to = $request->get('to',$date->format("Y-m-d"));
		$to=date_create(self::addDayswithdate($to,0));
		$to=$to->format('Y-m-d');
		$num_1=0;
		$num_0=0;
		$params=array(
				'from_1'=>$from_1,
				'from_0'=>$from_0,
				'to' => $to
		);
		//var_dump($params);
		$user= $this->getUser();
		//var_dump($user);
		$result=null;
		if($report==1){ 
			$result=AdvertHelper::getAdsReport($user->getUserName(),$params);
			//var_dump($result);
		}
		return $this->render('HotspotAccessPointBundle:Advert:member.html.twig',array('result'=>$result,'params'=>$params) );
	}
	private function addDayswithdate($date,$days){
		//var_dump($days);
		//var_dump($date);
		$date = strtotime("+".$days." days", strtotime($date));
		return  date("Y-m-d", $date);
	}
}