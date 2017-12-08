<?php

namespace Portal\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Portal\AdminBundle\Helper\UtilsHelper;
class FileManagerController extends Controller
{

	private function checkAuthorize(){
		/*if($this->get('security.authorization_checker')->isGranted('ROLE_MEDIA_POST')){
			$_SESSION['MEDIA_POST']='true';
			$_SESSION['USER_NAME']=$this->container->get('security.authorization_checker')->getToken()->getUser()->getUserName();
			}
			*/
		return $this->get('security.authorization_checker')->isGranted('ROLE_MEDIA_POST');
	}
	public function indexAction(Request $request){
		if(!self::checkAuthorize()) return $this->redirect($this->generateUrl('Portal_adminpage'), 301);

		$act=$request->get('act','');
		if($act=='back')
		{
			return $this->redirect($this->generateUrl('Portal_adminpage'), 301);
		}
		/*
		 $session = $this->getRequest()->getSession();

		 // store an attribute for reuse during a later user request
		 $session->set('MEDIA_POST', true);
		 $session->set('USER_NAME', $this->container->get('security.authorization_checker')->getToken()->getUser()->getUserName());
		 $session->set('CKFinder_UserRole', $this->container->get('security.authorization_checker')->getToken()->getUser()->getUserName());
		 */
		/*
		 $session = $this->getRequest()->getSession();
		 // store an attribute for reuse during a later user request
		 $session->set('MEDIA_POST', true);
		 $session->set('USER_NAME', $this->container->get('security.authorization_checker')->getToken()->getUser()->getUserName());

		 $session->set('CKFinder_UserRole', $this->container->get('security.authorization_checker')->getToken()->getUser()->getUserName());
		 */
		return $this->render('PortalAdminBundle:FileManager:index.html.twig'/*,array('param'=>$param)*/);
	}
	public function embeddedAction(Request $request){
		if(!self::checkAuthorize()) return $this->redirect($this->generateUrl('Portal_adminpage'), 301);

		$act=$request->get('act','');
		if($act=='back')
		{
			return $this->redirect($this->generateUrl('Portal_adminpage'), 301);
		}
		/*
		 $session = $this->getRequest()->getSession();
		 // store an attribute for reuse during a later user request
		 $session->set('MEDIA_POST', true);
		 $session->set('USER_NAME', $this->container->get('security.authorization_checker')->getToken()->getUser()->getUserName());
		 */
		return $this->render('PortalAdminBundle:FileManager:embedded.html.twig'/*,array('param'=>$param)*/);
	}
}