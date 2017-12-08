<?php

namespace Portal\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Portal\AdminBundle\Helper\SiteHelper;
use Portal\AdminBundle\Helper\MenuHelper;
use Portal\AdminBundle\Helper\SectionHelper;
use Portal\AdminBundle\Helper\LanguageHelper;

use Portal\AdminBundle\Model\PortalMenu as Menu;

class HomeNewsSlotController extends Controller
{
    public function indexAction(Request $request,$lang, $position)
    {
    	//Response Message
    	$responses 		= array();
    	$action 		= $request->get('action','list');
    	$locale				= $this->getParameter('auth_locale');

    	if ($lang == "")
    		$lang 				= $locale ;
    	
    	$langs=LanguageHelper::getAllLanguage_Admin($locale);
    	
    	$menus =array();

    	switch ($action)
    	{
    		
    		case "list":
    			//SectionHelper::getAllSection_Admin($sections,$lang,$section_type);
    			//$menus = MenuHelper::getMenus_Admin(-1, $lang, $position);

    			break;
    		case "delete":
    			$responses = $this->forward('PortalAdminBundle:HomeNewsSlot:delete');
    			break;
    		case "up":
    			$responses = $this->forward('PortalAdminBundle:HomeNewsSlot:move');
    			break;
    		case "down":
    			$responses = $this->forward('PortalAdminBundle:HomeNewsSlot:move');
    			break;
    		default: 
    			break;
    			
    	}
    	
    	$menus = MenuHelper::getMenus_Admin(-1, $lang, $position);
    	
    	return $this->render('PortalAdminBundle:HomeNewsSlot:index.html.twig',
    			array('langs'=>$langs
    					,'menus'=>$menus
    					,'action'=>$action
    					,'position'=>$position
    					,'lang'=>$lang
    					,'responses'=>$responses
    					));
    }
    public function moveAction(Request $request)
    {
    	$action 		= $request->get('action');
    	$id				= $request->get('action_id','0');
    	$lang			= $request->request->get('lang');
    	$position		= $request->request->get('position');
    
    	switch($action)
    	{
    		case "up":
    			MenuHelper::moveUp($id);
    			break;
    		case "down":
    			MenuHelper::moveDown($id);
    			break;
    	}
    	return new Response(null);
    }
    public function addAction(Request $request)
    {
    	
    	$locale				= $this->getParameter('auth_locale');
    	
    	$action 			= $request->get('action','');
    	 
    	$position		= "A";
    	$lang				= $locale;
    	 
    	$sectionType		= $request->get('section_type',1);
    	
    	if ($request->getMethod()=="POST")
    	{
    		$position		= $request->request->get('position','top');
    		$lang 			= $request->request->get('lang',$locale);
    	}
    	else
    	{
    		$position		= $request->get('position','A');
    		$lang 				= $request->get('lang',$this->getParameter('auth_locale'));
    	}
    	 
    	$parentId			= $request->get('parent_section',-1);
    	$title				= $request->get('title','');
    	$order				= $request->get('order',0);
    	$publish			= $request->get('publish',time());
    	$description		= $request->get('description','');
    	
    	$link=$request->get('link_to','');
    	$sectionId=$request->get('section','');
    	$errors = null;
    	 
    	switch ($action)
    	{
    		case "save":
    			$errors = MenuHelper::save($title,$publish,$position,$parentId,$description,$link,$sectionId,$sectionType,$lang);
    			 
    			if ($errors == null)
    			{
    				$action = "add";
    				$title = "";
    				$parentId = -1;
    				$title = "";
    				$link="";
    				$order = 0;
    				$publish = 0;
    				$description = "";
    				 
    			}
    			break;
    		default:
    			 
    	}
    	 
    	$langs=LanguageHelper::getAllLanguage_Admin($locale);
    	 
    	
    	$parentMenus=MenuHelper::getMenus_Admin(-1,$lang,$position);
    	$sections =array();
    	SectionHelper::getAllSection_Admin($sections,$lang,$sectionType);
    	 
    	return $this->render('PortalAdminBundle:HomeNewsSlot:add.html.twig',
    			array(
    					'langs'=>$langs
    					, 'lang'=>$lang
    					, 'position'=> $position
    					, 'section_type' => $sectionType
    					, 'sections' =>$sections
    					, 'parent_menus'=>$parentMenus
    					, 'current_parent_menu'=>$parentId
    					, 'title' =>$title
    					, 'order' =>$order
    					, 'publish' =>$publish
    					, 'errors' => $errors
    						
    			));
    	
    }
    public function viewAction(Request $request,$id,$lang)
    {
    	
    	//Response Message
    	$responses 		= array();
    	//Form Action
    	$action 		= $request->get('action','');
    	
    	//Languagues
    	$locale			= $this->getParameter('auth_locale');
    	$langs			= LanguageHelper::getAllLanguage_Admin($locale);
    	
    	//Menu
    	$menu		= MenuHelper::getMenu_Admin($id, $lang);
    	//print_r($menu);
    	//echo $menu->getTitle();
    	//$sectionType 	= -1;
    	
    	if (!$menu) {
    		throw $this->createNotFoundException('The menu does not exist');
    	}
    	

    	switch ($action)
    	{
    		case "save":
    			return $this->forward('PortalAdminBundle:HomeNewsSlot:update');
    			break;
    		case "change":
    			$sectionType		= $request->get('section_type',-2);
    			$position			= $request->get('position','top');
    			$parentId			= $request->get('parent_section',-1);
    			$title				= $request->get('title','');
    			$order				= $request->get('order',0);
    			$publish			= $request->get('publish',0);
    			$description		= $request->get('description','');
    			$link=$request->get('link_to','');
    			$sectionId=$request->get('section','');
    			
    			$menu->setTitle($title);
    			$menu->setLocked($publish);
    			$menu->setPos($position);
    			$menu->setParent($parentId);
    			$menu->setBrief($description);
    			if($sectionType==-2)
    				$menu->setLinkTo($link);
    			$menu->setSectionId($sectionId);
    			$menu->setBundleId($sectionType);
    			
    			break;
    		default:
    			
    			break;
    		
    	}
    
    	$parentMenus = array();
    	MenuHelper::getAllMenu_Admin($parentMenus,$lang,$menu->getPos(),true,$id);
    	$sections =array();
    	SectionHelper::getAllSection_Admin($sections,$lang,$menu->getBundleId());
    
    	return $this->render('PortalAdminBundle:HomeNewsSlot:view.html.twig',
    			array(
    					'langs'=>$langs
    					, 'menu'=>$menu
    					, 'sections' =>$sections
    					, 'parent_menus'=>$parentMenus
    					, 'errors' => $responses
    
    			));
    	 
    }    
	function deleteAction(Request $request)
    {
    	
    	$locale			= $this->getParameter('auth_locale');
    	
    	
    	
    	
    	$responses		= array();
    	 
    	$s_ids			= $request->get('action_id','');
    	$lang			= $request->request->get('lang');
    	$position		= $request->request->get('position');
    	
    	$menus		= MenuHelper::getMenus_OrderByDeep($s_ids);
   	
    	if ($menus != null)
    	{
    		foreach ($menus as $menu )
    		{
    			$result = MenuHelper::delete($menu->getId(), $lang);
    			
    			$responses = array_merge($responses,$result);
    		}
    	}
    	
    	
    	return $this->forward('PortalAdminBundle:HomeNewsSlot:index', array('lang'=>$lang,'position'=>$position));
    }
    public function updateAction(Request $request)
    {
    	
    	$locale			= $this->getParameter('auth_locale');
    	 
    	$id					= $request->get('id',-1);
    	$lang				= $request->get('lang',$locale);
    	$sectionType		= $request->get('section_type',-2);
    	$position		 	= $request->get('position','top');
    	$parentId			= $request->get('parent_section',-1);
    	$title				= $request->get('title','');
    	$order				= $request->get('order',0);
    	$publish			= $request->get('publish',0);
    	$description		= $request->get('description','');
    	$link=$request->get('link_to','');
    	$sectionId=$request->get('section','');
    	
    	$responses = MenuHelper::update($id,$title,$publish,$position,$parentId,$description,$link,$sectionId,$sectionType,$lang);
    	if ($responses == null)
    		$responses = array("Save Successful");
    	 
    	return new Response(null);
    }
    /**
     *
     * @param Int $id
     * @param Boolean $isPublish
     */
    public function publishAction(Request $request,$id, $isPublish)
    {
    	$result = MenuHelper::publish($id, $isPublish);
    	 
    	$json = array();
    	$json["status"] = ($result == null)?"OK":"FAIL";
    	$json["message"] = $result;
    	 
    	$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));
    
    	return $response;
    
    }
    /**
     *
     * @param Int $id
     */
    public function togglePublishAction(Request $request,$id)
    {
    	$result = MenuHelper::togglePublish($id);
    
    	$json = array();
    	$json["status"] = ($result == true | $result == false )?"OK":"FAIL";
    	$json["message"] = $result;
    
    	$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));
    
    	return $response;
    
    }    
}
