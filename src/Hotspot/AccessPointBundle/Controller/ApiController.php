<?php
namespace Hotspot\AccessPointBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Hotspot\AccessPointBundle\Helper\AdvertHelper;
use Hotspot\AccessPointBundle\Helper\ApConfigHelper;

class ApiController extends Controller{
	public function loginAction(Request $request){
		$session = new Session();
		$session->start();
		
		
		$api = $this->get("accesspoint.service");
		$result=$api->login("demo","demo");
		$result=json_decode($result,true);
		if($result["code"] && $result["code"]=="OK"){
			$session->set('token', 'JWT '.$result["data"]["token"]);
			return new Response($result["data"]["token"]);
		}
		$session->remove('token');
		return new Response('<html></body>Welcome to the homepage.</body></html>');
	
	}
	public function createDeviceAction(Request $request){
		$session = new Session();
		$token = $session->get("token","");
		
		$api = $this->get("accesspoint.service");
		var_dump($token);
		
		$result=$api->createDevice($token, "demo","demo");
		$result=json_decode($result,true);
		//if($result["code"] && $result["code"]=="OK")
			return new Response(var_dump($result));
			//var_dump($result["data"]["token"]);
			//return new Response('<html></body>Welcome to the homepage.</body></html>');
	
	}
	public function geoCodingAction(Request $request){
		$api = $this->get("accesspoint.service");
		ApConfigHelper::updateAllAPIGEO($api);
		return new Response('<html></body>OK.</body></html>');
	
	}
	public function updateISPAction(Request $request){
		$api = $this->get("accesspoint.service");
		ApConfigHelper::updateAllAPISP($api);
		return new Response('<html></body>OK.</body></html>');
	
	}
	public function getApListAction(Request $request){
		$list=ApConfigHelper::getAPList($request->get("province",''));
		/*
		foreach ($list as $l){
			var_dump($l);
			break;
		}
		*/
		//var_dump($list);
		$response = new Response();
		$response->setContent(json_encode($list));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}
}