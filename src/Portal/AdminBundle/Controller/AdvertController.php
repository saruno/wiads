<?php

namespace Portal\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Portal\AdminBundle\Helper\AdvertHelper;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Security\Core\SecurityContext;

use Portal\AdminBundle\Helper\SectionHelper;
use Portal\AdminBundle\Helper\LanguageHelper;
use Portal\AdminBundle\Helper\CustomerHelper;
use Portal\AdminBundle\Helper\UtilsHelper;

class AdvertController extends Controller
{
    
    public function indexAction(Request $request, $lang, $customerId=-1, $page=1, $pageSize=20)
    {
    	//Response Message
    	$responses 		= array();
    	
    	$action 		= $request->get('action','list');
    	
    	$locale				= $this->getParameter('auth_locale');
    	 
    	$lang	= ($lang != "")? $lang : $locale;
    	
    	$langs=LanguageHelper::getAllLanguage_Admin($locale);
    	
    	
    	$customers=array();
    	$customers=CustomerHelper::getAllCustomer_Admin();
    	
    	$sections = array();
    	SectionHelper::getAllSection_Admin($sections, $lang,1);
    	 
    	switch ($action)
    	{
    		 
    		case "delete":
    			$responses = $this->forward('PortalAdminBundle:Advert:delete', array('request' =>$request,'customerId' => $customerId));
    		case "list":
    			$advertPager=null;
    			if($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE'))
    				$advertPager = AdvertHelper::getAdvertWithPagingForCustomer_Admin($page, $pageSize, $customerId, $lang);
    				else{
    					$postBy	= $this->get('security.token_storage')->getToken()->getUser()->getUserName();
    					$advertPager = AdvertHelper::getAdvertWithPagingForCustomer_Admin($page, $pageSize, $customerId, $lang,true,$postBy);
    				}
    				break;    			
    		case "up":
    			//return $this->forward('PortalAdminBundle:News:move');
    			break;
    		case "down":
    			//return $this->forward('PortalAdminBundle:Section:move');
    			break;
    		default:
    			break;
    	
    	}
    	
    	return $this->render('PortalAdminBundle:Advert:index.html.twig',
    			array('langs'=>$langs
    					,'currentCustomer'	=>	$customerId
    					,'sections'		=>	$sections
    					,'customers' 	=> $customers
    					/*
    					,'listAdvert'=>$listAdvert
    					,'paginator'=>$paginator
    					*/
    					,'advertPager'	=>	$advertPager
    					,'action'	=>	$action
    					,'page_size'	=>$pageSize
    					,'page'	=>	$page
    					,'lang'	=>	$lang
    					,'responses'	=>	$responses
    			));
    }
    public function addAction(Request $request)
    {
		$locale				= $this->getParameter('auth_locale');
	
    	$action 			= $request->get('action','');
    	$lang				= $request->get('lang',$locale);
    	$sectionType		= $request->get('section_type',1);//mean bundle_id 1:Portal,2:Place, 3:Link, 4:QC, 5: Vote
    	$sectionLinkType	= $request->get('section_link_type',2); //1:portal, 2:link, 3:ads, 4:Voting
    	//var_dump($sectionLinkType);
    	$sectionLinkId    	= $request->get('section_link_id',-2);
    	$advert_type    	= $request->get('advert_type',2);
    	$link				= $request->get('link_to','');
    	$customer			= $request->get('customer','0');
    	//$pos				= $request->get('pos','0');
    	$sectionId			= $request->get('sectionId',null);
    	if ($request->getMethod()=="POST")
    	{
    		$lang 			= $request->request->get('lang',$locale);
    		$sectionId		= $request->request->get('sectionId',null);
    	}
    	$title				= $request->get('title','');
    	$keywords			= $request->get('keywords','');
    	$tags				= $request->get('tags','');
    	$isAtHomePage		= $request->get('chk_homepage',0);
    	$homeZone			= $request->get('home-position','');
    	$isAtSection		= $request->get('chk_section',0);
    	$sectionZone		= $request->get('section-position','');
    	$sectionIds			= $request->get('subsection_ids',null);
    	//$orderIds			= $request->get('suborder_ids','');
    	//$order 				= 0;
    	$imgs				= $request->get('imgs','');
    	//var_dump($imgs);
    	//$getImagefromContent= $request->get('chk_getImagefromContent',true);
    	$brief				= $request->get('brief',"");
    	//$content			= $request->get('content',"");
    	$publishDate		= $request->get('publish_date',time());
    	$expireDate			= $request->get('expired_date',time());
    	$postBy				= $this->get('security.token_storage')->getToken()->getUser()->getUserName();
    	$errors = null;
    	
    	switch ($action)
    	{
    		case "save":
    			$errors = AdvertHelper::add($lang, $title,$keywords, $tags, $imgs, $brief
    									, $isAtHomePage, $isAtSection, $homeZone,$sectionZone, $publishDate,$expireDate, $sectionType,$sectionId
    									, $sectionIds, $advert_type,$sectionLinkType,$sectionLinkId,$link, $customer,$postBy,$this->get('kernel')->getRootDir());
    			
    			if ($errors === null)
    			{
    				return $this->redirect($this->generateUrl('Advert_add'));
    			}
    			
    			break;
    		default:
    	}
    	
    	$langs=LanguageHelper::getAllLanguage_Admin($locale);


        $customers=array();
    	$customers=CustomerHelper::getAllCustomer_Admin();
    	
    	$sectionsForTypes =array();
    	SectionHelper::getAllSection_Admin($sectionsForTypes,$lang,$sectionType);
    	//var_dump($sectionsForTypes);
    	$sectionsForLinkTypes =array();
    	SectionHelper::getAllSection_Admin($sectionsForLinkTypes,$lang,$sectionLinkType);//mean bundles
    	
    	//var_dump($sectionLinkType);
    	
    	return $this->render('PortalAdminBundle:Advert:add.html.twig',
    			array(
    					'langs'=>$langs
    					, 'lang'=>$lang
    					, 'title' =>$title
    					, 'keywords'=>$keywords
    					, 'tags'=>$tags
    					, 'customers'=>$customers
    					, 'customer' =>$customer
    					, 'link'=>$link
    					, 'isAtSection' =>$isAtSection
    					, 'isAtSection' => $isAtSection
    					, 'homeZone' => $homeZone
    					, 'sectionZone' => $sectionZone
    					, 'advert_type'=>$advert_type
    					, 'section_link_type'=>$sectionLinkType
    					, 'sectionsForLinkTypes'=>$sectionsForLinkTypes
    					, 'sectionLinkId'=>$sectionLinkId
    					, 'section_type'=>$sectionType
    					, 'sectionsForTypes'=>$sectionsForTypes
    					, 'sectionId'=>$sectionId
    					, 'subsection_ids'=>$sectionIds
    					, 'imgs'=>$imgs
    					, 'brief'=>$brief
    					, 'publishDate'=>$publishDate
    					, 'expireDate'=>$expireDate
    					, 'errors' => $errors
    					));
    	
    }
	public function deleteAction(Request $request, $customerId=-1)
    {
    	$locale			= $this->getParameter('auth_locale');
    	
    	$responses		= array();
    	 
    	/*$id			= $request->get('action_id',-1);*/
    	$ids			= $request->get('action_id',-1);
    	$ids=explode(",", $ids);
    	$lang			= $request->get('lang',$locale);
    	$sectionId		= $request->get('sectionId',1);
    	
    	//var_dump($ids);
    	if ($ids != null)
    	{
    		foreach ($ids as $id )
    		{
    			$result = AdvertHelper::delete($id, $lang);
    			$responses = array_merge($responses,$result);
    		}
    	}
    	return new Response(json_encode($responses));
    	//return $this->forward('PortalAdminBundle:Advert:index', array('lang'=>$lang, 'sectionId'=>$sectionId,'customerId'	=>	$customerId));
    }
    public function updateAction(Request $request,$advert)
    {
    	$responses = AdvertHelper::update($advert->getId(), $advert->getLocale(), $advert->getTitle(),$advert->getKeyword(), $advert->getTag(),
    			$advert->getImgs(), $advert->getBrief(),$advert->getViewAtHomepage(), $advert->getViewAtSection(),
    			$advert->getHomePosition(),$advert->getSectionPosition(),$advert->getPublishedAt(),$advert->getExpiredAt(),
    			$advert->getBundleId(),$advert->getSectionId(),$advert->getSubsectionIds(), 
    			$advert->getType(),$advert->getBundleLinkId(),$advert->getSectionLinkId(),$advert->getLinkTo(), 
    			$advert->getCustomerId(),$advert->getPostBy(),$this->get('kernel')->getRootDir());
    	
    	if ($responses == null)
    		$responses = array("Save Successful");
    	 
    	//return $this->forward('PortalAdminBundle:Advert:view', array('id'=>$advert->getId(), 'lang'=>$advert->getLocale()));
    	return new Response(json_encode($responses));
    }
    private function updateChangeOrSaveRequest(Request $request,&$advert,$lang){
    	
    	$locale				= $this->getParameter('auth_locale');
    	
    	$lang				= ($lang == "")? $locale :  $lang;
    	
    	$sectionType		= $request->get('section_type',1);
    	$sectionLinkType	= $request->get('section_link_type',null);
    	 
    	$sectionLinkId    	= $request->get('section_link_id',-2);
    	$advert_type    	= $request->get('advert_type',2);
    	$link				= $request->get('link_to','');
    	$customer			= $request->get('customer','0');
    	//$pos				= $request->get('pos','0');
    	$sectionId			= $request->get('sectionId',null);
    	if($sectionId==-1)	$sectionId=null;
    	$title				= $request->get('title','');
    	$keywords			= $request->get('keywords','');
    	$tags				= $request->get('tags','');
    	$isAtHomePage		= $request->get('chk_homepage',0);
    	$homeZone			= $request->get('home-position','');
    	$isAtSection		= $request->get('chk_section',0);
    	$sectionZone		= $request->get('section-position','');
    	$sectionIds			= $request->get('subsection_ids',null);
    	if($sectionIds==-1)	$sectionIds=null;
    	//$orderIds			= $request->get('suborder_ids','');
    	//$order 				= 0;
    	$imgs				= $request->get('imgs','');
    	//$getImagefromContent= $request->get('chk_getImagefromContent',true);
    	$brief				= $request->get('brief',"");
    	//$content			= $request->get('content',"");
    	$publishDate		= $request->get('publish_date',time());
    	$expireDate			= $request->get('expired_date',time());
    	$postBy				= $this->get('security.token_storage')->getToken()->getUser()->getUserName();
    	 
    	/*update tu change*/
    	$advert->setLocale($lang);
		$advert->setTitle($title);
		$advert->setStripTitle(UtilsHelper::utf8_to_ascii($title));
		$advert->setKeyword($keywords);
		$advert->setTag($tags);
		$advert->setViewAtHomepage($isAtHomePage);
		$advert->setViewAtSection($isAtSection);
		$advert->setHomePosition($homeZone);
		$advert->setSectionPosition($sectionZone);
		$advert->setImgs($imgs);
		$advert->setBrief($brief);
		$advert->setLocked(true);
		$advert->setBundleId($sectionType);
		//var_dump($sectionId);
		if($sectionId!=null)
			$advert->setSectionId($sectionId);
		if($sectionIds!=null)
			$advert->setSubsectionIds($sectionIds);
		$advert->setPublishedAt($publishDate);
		$advert->setExpiredAt($expireDate);
		$advert->setPostBy($postBy);
		$advert->setCustomerId($customer);
		$advert->setType($advert_type);
		$advert->setSectionLinkId($sectionLinkId);
		if($sectionLinkType!=null)
			$advert->setBundleLinkId($sectionLinkType);
		$advert->setLinkTo($link);
    }
    public function viewAction(Request $request, $id, $lang)
    {
    	$locale				= $this->getParameter('auth_locale');
    	//Response Message
    	$responses 		= array();
    	$errors=null;
    	if($responses!=null)
    	foreach ($responses as $key=>$value){
    		$errors[$key]=$value;
    	}
    	//Form Action
    	$action 		= $request->get('action','');
    	 
    	if ($request->getMethod()=="POST")
    	{
    		$lang 			= $request->request->get('lang',$locale);
    	}
    	//Languagues
    	$langs			= LanguageHelper::getAllLanguage_Admin($locale);
    	
    	//Advert
    	$advert		= AdvertHelper::getAdvert_Admin($id, $lang);
    	 /*
    	$imgs				= explode(",", $advert->getImgs());
    	$file=$this->get('kernel')->getRootDir()."/../web/".$imgs[0];
    	print_r(getimagesize($file));
    	*/
    	
    	if (!$advert) {
    	
    		throw $this->createNotFoundException('The news does not exist');
    	}
    	switch ($action)
    	{
    		case "change":
    			self::updateChangeOrSaveRequest($request,$advert,$lang);
    			break;
    		case "save":
    			self::updateChangeOrSaveRequest($request,$advert,$lang);
    			$responses = $this->forward('PortalAdminBundle:Advert:update',array('request' => $request,'advert' => $advert));
    			break;
    		case "delete":
    			$responses = $this->forward('PortalAdminBundle:Advert:delete',array('request' => $request));
    			break;
    		default:		 
    			break;
    	}
    	
    	$customers=array();
    	$customers=CustomerHelper::getAllCustomer_Admin();
    	 
    	$sectionsForTypes =array();
    	SectionHelper::getAllSection_Admin($sectionsForTypes,$lang,$advert->getBundleId());
    	 
    	$sectionsForLinkTypes =array();
    	SectionHelper::getAllSection_Admin($sectionsForLinkTypes,$lang,$advert->getBundleLinkId());//mean bundles
    	
    	//Parent sections
    	//$sections = array();
    	//SectionHelper::getAllSection_Admin($sections,$lang,1,true,-1);

    	//Render View
    	return $this->render('PortalAdminBundle:Advert:view.html.twig',
    			array(	'advert'=>$advert
    					, 'langs'=>$langs
    					, 'customers'=>$customers   					
    					, 'sectionsForLinkTypes'=>$sectionsForLinkTypes
    					, 'sectionsForTypes'=>$sectionsForTypes
    					, 'errors' => $errors
    					));
    }
    public function togglePublishAction($lang,$id)
    {
    	$result = AdvertHelper::togglePublish($lang,$id,$this->get('kernel')->getRootDir());
    
    	$json = array();
    	$json["status"] = ($result == true | $result == false )?"OK":"FAIL";
    	$json["message"] = $result;
    
    	$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));
    
    	return $response;
    
    }
}
