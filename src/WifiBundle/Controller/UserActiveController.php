<?php

namespace WifiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Common\DbBundle\Model\UserQuery;
use Common\DbBundle\Model\User;

class UserActiveController extends Controller
{
    public function indexAction(Request $request)
    {	
    	$email  = $request->get('email', '');
    	$code  = $request->get('code', '');

        $status = 0;

    	if(!empty($email) && !empty($code)){
    	    $user = UserQuery::create()->findOneByEmail($email);
    	    if($user){
                if($user->getConfirm() === $code){
                    if($user->getIsActive() == 0){
                        $user->setIsActive(1);
                        $user->save();
                        $status = 1;
                    }else{
                        $status = 2;
                    }
                }else{
                    $status = -2;
                }
            }else{
                $status = -1;
            }
        }
        $param = array(
            'email'     =>  $email,
            'code'      =>  $code
        );

    	return $this->render('WifiBundle:UserActive:index.html.twig', array(
            'status'    =>  $status,
            'param'     =>  $param
        ));
    } 
}