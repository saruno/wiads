<?php

namespace AdvertiserBundle\Controller;

use Common\DbBundle\Model\Base\UserLoginQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Common\DbBundle\Model\UserLogin;
use Common\DbBundle\Model\UseronlineQuery;

class SaveRequestController extends Controller
{   

	public function UserLoginAction(Request $request)
    {	
    	$result = array();
    	$type 		= $request->get('type');
    	$fullname 	= $request->get('name');
    	$email 		= $request->get('email');
    	$phone 		= $request->get('phone');
    	$address 	= $request->get('address');
    	$mac 		= $request->get('mac');
    	$uid 		= $request->get('uid');

    	if(!empty($type) && $type == 'form'){
            $user_login = UserLoginQuery::create()
                ->filterByEmail($email)
                ->filterByApMacaddr($mac)
                ->findOneOrCreate();
            //if(!$user_login){
             //   $user = new UserLogin();
            $user_login->setType($type);
            $user_login->setEmail($email);
            $user_login->setAddress($address);
            $user_login->setFullname($fullname);
            $user_login->setPhone($phone);
            $user_login->setApMacaddr($mac);

            $user_login->save();
            $result['status'] = 1;
            //}else{
            //    $user_login->setCreatedAt(new \DateTime());
            //    $user_login->save();
             //   $result['status'] = 1;
            //}
    	}elseif(!empty($type) && $type == 'facebook'){
            $user_login = UserLoginQuery::create()->filterByUid($uid)->filterByApMacaddr($mac)->findOneOrCreate();
            //if(!$user_login) {
                //$user = new UserLogin();
            $user_login->setType($type);
            $user_login->setEmail($email);
            $user_login->setUid($uid);
            $user_login->setFullname($fullname);
            $user_login->setApMacaddr($mac);

            $user_login->save();
            $result['status'] = 1;
            //}else{
            //    $user_login->setCreatedAt(new \DateTime());
            //    $user_login->save();
            //    $result['status'] = 1;
            //}
        }

    	$response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}