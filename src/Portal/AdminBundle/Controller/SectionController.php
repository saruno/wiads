<?php

namespace Portal\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Portal\AdminBundle\Helper\SectionHelper;
use Portal\AdminBundle\Helper\LanguageHelper;

class SectionController  extends Controller
{
    public function indexAction(Request $request, $page=1, $pageSize=20)
    {
    	$action 		= $request->get('action','list');
    	$sectionType		= 1;
    	$lang				= "en";
    	$locale				= $this->container->getParameter('auth_locale');
    	$page_size			= $request->get('page_size',$pageSize);

    	if ($request->getMethod()=="POST")
    	{
    		$sectionType		= $request->request->get('section_type',1);
    		$lang 				= $request->request->get('lang',$locale);
    	}
    	else
    	{
    		$sectionType		= $request->get('section_type',1);
    		$lang 				= $request->get('lang',$this->container->getParameter('auth_locale'));
    	}
    
    	$langs=LanguageHelper::getAllLanguage_Admin($locale);
    
    	$sections =array();
    	$paginator= null;
    	switch ($action)
    	{
    
    		case "list":
    			$pager = SectionHelper::getSectionWithPaging_Admin($page, $page_size, -1, $lang,$sectionType);
    			$sections=$pager["items"];
    			$paginator=$pager["paginator"];
    			break;
    		case "delete":
    			$responses = $this->forward('PortalAdminBundle:Section:delete',array('request'=>$request));
    			
    			$pager = SectionHelper::getSectionWithPaging_Admin($page, $page_size, -1, $lang,$sectionType);
    			$sections=$pager["items"];
    			$paginator=$pager["paginator"];
    			
    			break;
    		case "up":
    			$this->forward('PortalAdminBundle:Section:move',array("request"=>$request));
    			$pager = SectionHelper::getSectionWithPaging_Admin($page, $page_size, -1, $lang,$sectionType);
    			$sections=$pager["items"];
    			$paginator=$pager["paginator"];
    			break;
    		case "down":
    			$this->forward('PortalAdminBundle:Section:move',array("request"=>$request));
    			$pager = SectionHelper::getSectionWithPaging_Admin($page, $page_size, -1, $lang,$sectionType);
    			$sections=$pager["items"];
    			$paginator=$pager["paginator"];
    			break;
    		default:
    			break;
    	}
    	//SectionHelper::reUpdateWebLink('vi');
    
    	return $this->render('PortalAdminBundle:Section:index.html.twig',
    			array('langs'=>$langs
    					,'sections'=>$sections
    					,'paginator'=>$paginator
    					,'action'=>$action
    					,'section_type'=>$sectionType
    					,'page_size'=>$page_size
    					,'page'=>$page
    					,'lang'=>$lang
    			));
    }
    public function moveAction(Request $request)
    {
        $session		= $request->getSession();

        $action 		= $request->get('action');
        $id				= $request->get('action_id','0');  
        switch($action)
        {
            case "up":
                SectionHelper::moveUp($id);
                break;
            case "down":
                SectionHelper::moveDown($id);
                break;
        }
        return new Response(null);
    }
    public function addAction(Request $request)
    {
        $locale				= $this->container->getParameter('auth_locale');
        $action 			= $request->get('action','');
        $sectionType		= 1;
        $lang				= $locale;

        if ($request->getMethod()=="POST")
        {
            $sectionType		= $request->request->get('section_type',1);
            $lang 				= $request->request->get('lang',$locale);
        }
        else
        {
            $sectionType		= $request->get('section_type',1);
            $lang 				= $request->get('lang',$this->container->getParameter('auth_locale'));
        }

        $parentId			= $request->get('parent_section',-1);
        $title				= $request->get('title','');
        $order				= $request->get('order',0);
        $publish			= $request->get('publish',time());
        $description		= $request->get('description','');

        $errors = null;
		
        //var_dump($action);var_dump($description);

        switch ($action)
        {
            case "save":
                $errors = SectionHelper::save($sectionType,$lang,$parentId,$title,$publish,$description);
                if ($errors == null)
                {
                    $action = "add";
                    $title = "";
                    $parentId = -1;
                    $title = "";
                    $order = 0;
                    $publish = 0;
                    $description = "";
                }
                break;
            default:

        }

        $langs=LanguageHelper::getAllLanguage_Admin($locale);

        $parentSections =array();
        SectionHelper::getAllSection_Admin($parentSections,$lang,$sectionType);
        return $this->render('PortalAdminBundle:Section:add.html.twig',
            array(
            'langs'=>$langs
            , 'lang'=>$lang
            , 'section_type'=> $sectionType
            , 'parent_sections'=>$parentSections
            , 'current_parent_section'=>$parentId
            , 'title' =>$title
            , 'order' =>$order
            , 'publish' =>$publish
            , 'errors' => $errors
            ));
    }
    public function deleteAction(Request $request)
    {
        $locale			= $this->container->getParameter('auth_locale');
        $responses		= array();

        $s_ids			= $request->get('action_id','');
        $lang			= $request->get('lang',$locale);
        //$page			= $request->get('page',1);

        $sections		= SectionHelper::getSections_OrderByDeep($s_ids);

        if ($sections != null)
        {
            foreach ($sections as $section )
            {
                $result = SectionHelper::delete($section->getId(), $lang);

                $responses = array_merge($responses,$result);
            }
        }
        return new Response(json_encode($responses));
        //$this->setFlash("responses", $responses);

        //return $this->forward('PortalAdminBundle:Section:index', array('page'=>$page,'responses'=>$responses));
    }
    public function updateAction(Request $request)
    {
        $locale			= $this->container->getParameter('auth_locale');

        //$session=$request->getSession();
        
        $id					= $request->get('id',-1);
        $sectionType		= $request->get('section_type',1);
        $lang				= $request->get('lang',$locale);
        $parentId			= $request->get('parent_section',-1);
        $title				= $request->get('title','No title');
        $order				= $request->get('order',0);
        $publish			= $request->get('publish',0);
        $description		= $request->get('description','');
        $responses = SectionHelper::update($id,$sectionType,$lang,$parentId,$title,$order,$publish,$description);
        if ($responses == null)
            $responses = array("Save Successful");
        
		return new Response(json_encode($responses));
        //$session->setFlash("responses",array("errors"=>$responses));

        //return $this->forward('PortalAdminBundle:Section:view', array('id'=>$id, 'lang'=>$lang));
    }
    public function viewAction(Request $request,$id,$lang)
    {
        //$session=$request->getSession();
        //Form Action
        $action 		= $request->get('action','');

        //Languagues
        $locale			= $this->container->getParameter('auth_locale');
        $langs			= LanguageHelper::getAllLanguage_Admin($locale);
        $responses		= array();
        //Section
        $section		= SectionHelper::getSection_Admin($id, $lang);
        $sectionType 	= $section->getBundleID();
        if (!$section) {
            throw $this->createNotFoundException('The section does not exist');
        }
        switch ($action)
        {
            case "changeSectionType":
                $sectionType = $request->get('section_type',1);
                $section->setBundleID($sectionType);
                $section->setTitle($request->get('title',''));
                $section->setOrders($request->get('order',0));
                $section->setLocked($request->get('publish',0));
                $section->setBrief($request->get('description',''));
                break;
            case "save":
                $responses = $this->forward('PortalAdminBundle:Section:update');
                break;
            default:
                $sectionType 	= $section->getBundleID();
                break;

        }
        
        //Parent sections
        $parentSections = array();
        SectionHelper::getAllSection_Admin($parentSections,$lang,$sectionType,true,$id);
        //Render View
        return $this->render('PortalAdminBundle:Section:view.html.twig',
            array('section'=>$section
            , 'langs'=>$langs
            , 'parent_sections'=>$parentSections
            , 'errors' => $responses));


    }
    /**
     *
     * @param Int $id
     * @param Boolean $isPublish
     */
    public function publishAction(Request $request,$id, $isPublish)
    {
        $result = SectionHelper::publish($id, $isPublish);

        $json = array();
        $json["status"] = ($result == true | $result == false )?"OK":"FAIL";
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
        $result = SectionHelper::togglePublish($id);

        $json = array();
        $json["status"] = ($result == true | $result == false )?"OK":"FAIL";
        $json["message"] = $result;

        $response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

        return $response;

    }
}