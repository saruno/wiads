<?php

namespace Portal\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
//use Symfony\Component\Security\Core\SecurityContext;

use Portal\FrontBundle\Helper\AdvertHelper;

class AdvertController extends Controller
{
	public function goAction( Request $request,$locale){
		$redirUrl=trim($request->get('link',$request->getHost()));
		if(strpos($redirUrl, "/")===0  )	$redirUrl=$request->getHost().$redirUrl;
		$response	=	$this->render('PortalFrontBundle:Advert:redirectAdvert.html.twig', array('baseUrl'=>$request->getHost(),'url'=>$redirUrl));
		$adsCookie=$redirUrl.rand();
		$adsCookieTime=time() + 2592000; //3600*24*30;
		$cookie=$request->cookies->get('adsCookie',0);
		if ($cookie!=0)
			$adsCookie=$cookie;
		AdvertHelper::updateRead($redirUrl, $locale);
		$response->headers->setCookie(new Cookie('adsCookie', $adsCookie,$adsCookieTime));
		return $response;
			
	}
}