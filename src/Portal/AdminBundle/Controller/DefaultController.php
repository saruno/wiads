<?php

namespace Portal\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
class DefaultController extends Controller
{
	/*
    public function indexAction(Request $request)
    {
        return $this->render('PortalAdminBundle:Default:index.html.twig');
    }
    */
    public function indexAction(Request $request)
    {
    	/*
    	 $session = new Session();
    	 if($session->isStarted()!==true) $session->start();
    	 */
    	$locale = $this->container->getParameter('auth_locale');
    	
    	$request->setLocale($locale);
    	 
    	//$adm_path= $this->container->getParameter('auth_path');
    	$img_path=$this->container->getParameter('auth_site_img');
    	 
    	$param=array();
    	$param['locale']=$locale;
    	//$param['auth_path']=$adm_path;
    	$param['auth_site_img']=$img_path;
    	 
    	if($this->get('security.authorization_checker')->isGranted('ROLE_MEDIA_POST')){
    		/*
    		 $session = $this->getRequest()->getSession();
    
    		 // store an attribute for reuse during a later user request
    		 $session->set('MEDIA_POST', true);
    		 $session->set('USER_NAME', $this->container->get('security.authorization_checker')->getToken()->getUser()->getUserName());
    		 */
    
    		$_SESSION['MEDIA_POST']=true;
    		$_SESSION['USER_NAME']=$this->get('security.token_storage')->getToken()->getUser()->getUserName();
    
    
    
    	}
    	 
    	$response = $this->render('PortalAdminBundle:Default:index.html.twig',array('param'=>$param));
    	if($this->get('security.authorization_checker')->isGranted('ROLE_MEDIA_POST')){
    		$response->headers->setCookie(new Cookie('USER_NAME', $this->get('security.token_storage')->getToken()->getUser()->getUserName(), 0));
    		$response->headers->setCookie(new Cookie('MEDIA_POST', true, 0));
    	}
    	else{
    		$response->headers->setCookie(new Cookie('USER_NAME', "", time()-3600));
    		$response->headers->setCookie(new Cookie('MEDIA_POST', false,  time()-3600));
    	}
    	return $response;
    }
}
