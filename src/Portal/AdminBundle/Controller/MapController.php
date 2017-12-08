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
use Portal\AdminBundle\Helper\MarkerHelper;
use Portal\AdminBundle\Helper\MapHelper;
use Portal\AdminBundle\Helper\UtilsHelper;

class MapController extends Controller
{

	public function indexAction(Request $request, $lang='en', $sectionId=-1, $page=1, $pageSize=20)
	{
		//Response Message
		$responses 		= array();
		$errors=null;
		
		$action 		= $request->get('action','list');
		
		$locale				= $this->getParameter('auth_locale');
		 
		$lang	= ($lang != "")? $lang : $locale;

		$langs=LanguageHelper::getAllLanguage_Admin($locale);

		$sections = array();
		 
		/*$sectionType=2: place*/
		SectionHelper::getAllSection_Admin($sections, $lang,2);

		$reqStatus=$request->get('status',null);
		$txtSearch = $request->get('txtSearch','');
		$status= array();
		//MarkerHelper::reUpdateWebLink($locale);
		$markerCategories = MapHelper::getAllMarkerCategories($locale);
		 
		$onlyDraft=false;
		switch ($action)
		{
			case "delete":
				$responses = $this->forward('PortalAdminBundle:Map:delete');
			case "list":
				if($reqStatus==""){
					$status=null;
				}
				if($reqStatus=="draft"){
					$status=array();
					$status[]="draft";
					$onlyDraft=true;
				}
				if($reqStatus=="submit"){
					$status=array();
					$status[]="submit";
					$status[]="waiting approved";
				}
				if($reqStatus=="approved"){
					$status=array();
					$status[]="approved";
				}
				if($reqStatus=="back"){
					$status=array();
					$status[]="back";
				}
				
				$postBy	= $this->get('security.token_storage')->getToken()->getUser()->getUserName();
				$newsPager = MarkerHelper::getMarkerWithPagingandFilter_Admin($page, $pageSize, $sectionId, $lang,$txtSearch, $status,$onlyDraft,true,$postBy);
				/*
				 $listNews=$pager["items"];
				 $paginator=$pager["paginator"];
				 */
				break;
			default:
				break;

		}
		// MarkerHelper::reUpdateWebLink($locale);
		return $this->render('PortalAdminBundle:Map:index.html.twig',
				array('langs'=>$langs
						,'currentSection'=>$sectionId
						,'status'=> $reqStatus
						,'sections'=>$sections
						,'markerCategories' => $markerCategories
						,'txtSearch'=>$txtSearch
						/*
						 ,'listNews'=>$listNews
		,'paginator'=>$paginator
		*/
						,'newsPager'=>$newsPager
						,'action'=>$action
						,'page_size'=>$pageSize
						,'page'=>$page
						,'lang'=>$lang
						,'errors'=>$responses
				));

	}
	public function relativeFormAction(Request $request,$lang, $sectionId, $page=1, $pageSize=20)
	{
		//Response Message
		$responses 		= array();
		$errors=null;
		
		$action 		= $request->get('action','list');
		
		$locale				= $this->getParameter('auth_locale');

		$lang	= ($lang != "")? $lang : $locale;

		$langs=LanguageHelper::getAllLanguage_Admin($locale);

		$sections = array();
		SectionHelper::getAllSection_Admin($sections, $lang,2);

		$markerCategories = MapHelper::getAllMarkerCategories($locale);

		$reqStatus=$request->get('status',null);
		$txtSearch = $request->get('txtSearch','');
		$status= array();

		$onlyDraft=false;
		switch ($action)
		{
			 
			case "list":
				if($reqStatus==""){
					$status=null;
				}
				if($reqStatus=="draft"){
					$status=array();
					$status[]="draft";
					$onlyDraft=true;
				}
				if($reqStatus=="submit"){
					$status=array();
					$status[]="submit";
					$status[]="waiting approved";
				}
				if($reqStatus=="approved"){
					$status=array();
					$status[]="approved";
				}
				if($reqStatus=="back"){
					$status=array();
					$status[]="back";
				}
				$postBy	= $this->get('security.token_storage')->getToken()->getUser()->getUserName();
				$newsPager = MarkerHelper::getMarkerWithPagingandFilter_Admin($page, $pageSize, $sectionId, $lang, $txtSearch,$status,$onlyDraft,false,$postBy);
				/*
				 $listNews=$pager["items"];
				 $paginator=$pager["paginator"];
				 */
				break;
			default:
				break;

		}

		return $this->render('PortalAdminBundle:Map:relativeForm.html.twig',
				array('langs'=>$langs
						,'currentSection'=>$sectionId
						,'status'=> $reqStatus
						,'sections'=>$sections
						,'markerCategories' => $markerCategories
						,'txtSearch'=>$txtSearch
						/*
						 ,'listNews'=>$listNews
		,'paginator'=>$paginator
		*/
						,'newsPager'=>$newsPager
						,'action'=>$action
						,'page_size'=>$pageSize
						,'page'=>$page
						,'lang'=>$lang
						,'errors'=>$errors
				));

	}
	public function approveAction(Request $request,$lang, $sectionId, $page=1, $pageSize=20)
	{
		//Response Message
		$responses 		= array();
		$errors=null;
		
		$action 		= $request->get('action','list');
		
		$locale				= $this->getParameter('auth_locale');

		$lang	= ($lang != "")? $lang : $locale;

		$langs=LanguageHelper::getAllLanguage_Admin($locale);

		$sections = array();
		SectionHelper::getAllSection_Admin($sections, $lang,2);

		$reqStatus=$request->get('status',null);
		$txtSearch = $request->get('txtSearch','');
		$status= array();

		switch ($action)
		{
			 
			case "list":
				if($reqStatus==""){
					$status=null;
				}
				/*
				 if($reqStatus=="draft"){
				 $status=array();
				 $status[]="draft";
				 $onlyDraft=true;
				 }
				 */
				if($reqStatus=="submit"){
					$status=array();
					$status[]="submit";
					$status[]="waiting approved";
				}
				if($reqStatus=="approved"){
					$status=array();
					$status[]="approved";
				}
				if($reqStatus=="back"){
					$status=array();
					$status[]="back";
				}
				$pager = MarkerHelper::getMarkerForApproveWithPagingAndFilter_Admin($page, $pageSize, $sectionId, $lang,$txtSearch, $status);

				$listNews=$pager["items"];
				$paginator=$pager["paginator"];

				break;
			case "delete":
				$responses = $this->forward('PortalAdminBundle:Map:delete');
				break;
			case "up":
				//return $this->forward('PortalAdminBundle:Map:move');
				break;
			case "down":
				//return $this->forward('PortalAdminBundle:Section:move');
				break;
			default:
				break;
		}
		return $this->render('PortalAdminBundle:Map:approve.html.twig',
				array('langs'=>$langs
						,'currentSection'=>$sectionId
						,'status'=> $reqStatus
						,'sections'=>$sections
						,'listNews'=>$listNews
						,'txtSearch'=>$txtSearch
						,'paginator'=>$paginator
						,'action'=>$action
						,'page_size'=>$pageSize
						,'page'=>$page
						,'lang'=>$lang
						,'errors'=>$errors
				));

	}
	public function addAction(Request $request,$lang,$sectionId)
	{
		
		$locale				= $this->getParameter('auth_locale');
		

		$action 			= $request->get('action','');
		 
		$lang				= ($lang == "")? $locale :  $lang;
		 
		if ($request->getMethod()=="POST")
		{
			$lang 			= $request->request->get('lang',$locale);
			$sectionId		= $request->request->get('sectionId',-1);
		}
		 
		$address			= $request->get('address','');
		$contact			= $request->get('contact','');
		$longitude			= $request->get('longitude','');
		$latitude			= $request->get('latitude','');
		$category_id		= $request->get('category_id','');
		 
		$title				= $request->get('title','');
		$keywords			= $request->get('keywords','');
		$tags				= $request->get('tags','');
		$isHeadline			= $request->get('chk_headline','');
		$isPublish			= $request->get('chk_publish','');
		$isComment			= $request->get('chk_comment','');
		$relativeMarkers	= $request->get('hi_relative_markers','');
		$detailNews			= $request->get('hi_relative_news','');
		$sectionIds			= $request->get('subsection_ids','');
		$orderIds			= $request->get('suborder_ids','');
		$order 				= $request->get('main_section_order','1');
		$imgs				= $request->get('imgs','');
		$getImagefromContent= $request->get('chk_getImagefromContent',true);
		$brief				= $request->get('brief',"");
		$content			= $request->get('content',"");
		$publishDate		= $request->get('publish_date',time());
		$postBy				= $this->get('security.token_storage')->getToken()->getUser()->getUserName();
		$errors = null;
		 
		switch ($action)
		{
			case "save":
				$errors = MarkerHelper::add($lang,$address,$contact,$longitude,$latitude, $category_id,$title, $keywords, $tags, $relativeMarkers, $detailNews, $imgs, $brief, $content
				, $isHeadline, $isPublish, $isComment, $publishDate, $sectionId, $order
				, $sectionIds, $orderIds, false,$postBy);
				 
				if ($errors == null)
				{
					return $this->redirect($this->generateUrl('Map_list_page_pagesize', array('lang' => $lang, 'sectionId'=>$sectionId,'page'=>1), true));

				}
				 
				break;
			case "draft":
				$errors = MarkerHelper::add($lang,$address,$contact,$longitude,$latitude, $category_id, $title, $keywords, $tags,  $relativeMarkers, $detailNews,  $imgs, $brief, $content
				, $isHeadline, $isPublish, $isComment, $publishDate, $sectionId, $order
				, $sectionIds, $orderIds, true,$postBy);

				if ($errors == null)
				{
					return $this->redirect($this->generateUrl('Map_list_page_pagesize', array('lang' => $lang, 'sectionId'=>$sectionId,'page'=>1), true));
				}
				break;
			default:
				break;
		}
		 
		$langs=LanguageHelper::getAllLanguage_Admin($locale);
		 
		$sections =array();
		SectionHelper::getAllSection_Admin($sections,$lang,2);
		 
		$markerCategories = MapHelper::getAllMarkerCategories($locale);
		 
		return $this->render('PortalAdminBundle:Map:add.html.twig',
				array(
						'langs'=>$langs
						,'lang'=>$lang
						,'address'=>$address
						,'contact'=>$contact
						,'longitude'=>$longitude
						,'latitude' =>$latitude
						,'category_id'=>$category_id
						, 'title' =>$title
						, 'keywords'=>$keywords
						, 'tags'=>$tags
						, 'isHeadline'=>$isHeadline
						, 'isPublish'=>$isPublish
						, 'isComment'=>$isComment
						, 'sectionId'=>$sectionId
						, 'sections'=>$sections
						, 'markerCategories' => $markerCategories
						, 'subsection_ids'=>$sectionIds
						, 'suborders_ids'=>$orderIds
						, 'imgs'=>$imgs
						, 'getImagefromContent'=>$getImagefromContent
						, 'brief'=>$brief
						, 'content'=>$content
						, 'publishDate'=>$publishDate
						, 'errors' => $errors
				));	 
	}
	public function deleteAction(Request $request)
	{
		$locale			= $this->getParameter('auth_locale');
		$responses		= array();

		/*$id			= $request->get('action_id',-1);*/
		$ids			= $request->get('action_id',-1);
		$ids=explode(",", $ids);
		$lang			= $request->get('lang',$locale);
		$sectionId		= $request->get('section',1);
		 
		if ($ids != null)
		{
			foreach ($ids as $id )
			{
				$result = MarkerHelper::delete($id, $lang);
				$responses = array_merge($responses,$result);
			}
		}
		 
		return new Response(json_encode($responses));
	}
	public function viewAction(Request $request,$id, $lang)
	{
		//Response Message
		$responses 		= array();
		$errors=null;
		 
		//Form Action
		$action 		= $request->get('action','');
		if(!isset($back))
			$back			= $request->get('back','index');
			
			//Languagues
			$locale			= $this->getParameter('auth_locale');
			$langs			= LanguageHelper::getAllLanguage_Admin($locale);

			if ($request->getMethod()=="POST")
			{
				$lang 			= $request->request->get('lang',$locale);
			}
			 
			//News
			$news		= MarkerHelper::getMarker_Admin($id, $lang);
			 
			if (!$news) {

				throw $this->createNotFoundException('The news does not exist');
			}

			switch ($action)
			{
				case "save":
					$responses = $this->forward('PortalAdminBundle:Map:update', array('action'=>$action,'back' => $back));
					break;
				case "draft":
					$responses = $this->forward('PortalAdminBundle:Map:update', array('action'=>$action));
					break;
				case "delete":
					$responses = $this->forward('PortalAdminBundle:Map:delete');
					return $this->forward('PortalAdminBundle:Map:index');
					break;
				default:
					 
					break;

			}
			//Relative News
			$relativeNewsObjs=MarkerHelper::getRelativeMarkers_Admin($news->getId(), $lang);
			
			$detailNews=MarkerHelper::getDetailNewsUrl_Admin($news->getDetailUrlId(), $lang);
			//Parent sections
			$sections = array();
			SectionHelper::getAllSection_Admin($sections,$lang,2,true,-1);
			 
			$markerCategories = MapHelper::getAllMarkerCategories($locale);
			 
			//Render View
			return $this->render('PortalAdminBundle:Map:view.html.twig',
					array('news'=>$news
							, 'relativeNewsObjs' => $relativeNewsObjs
							, 'detailNews' => $detailNews
							, 'back' => $back
							, 'langs'=>$langs
							, 'sections'=>$sections
							, 'markerCategories' => $markerCategories
							, 'errors' => $responses));
	}
	public function updateAction(Request $request,$action,$back="index")
	{
		 
		$locale			= $this->getParameter('auth_locale');

	
		$id					= $request->get('action_id',-1);
		$lang				= $request->get('lang',$locale);
		 
		$address			= $request->get('address','');
		$contact			= $request->get('contact','');
		$longitude			= $request->get('longitude','');
		$latitude			= $request->get('latitude','');
		$category_id			= $request->get('cagegory_id','');
		 
		$title				= $request->get('title','');
		$keywords			= $request->get('keywords','');
		$tags				= $request->get('tags','');
		$isHeadline			= $request->get('chk_headline',false);
		$isPublish			= $request->get('chk_publish',false);
		$isComment			= $request->get('chk_comment',false);
		$sectionId			= $request->request->get('sectionId',-1);
		$relativeMarkers	= $request->get('hi_relative_markers','');
		$detailNews			= $request->get('hi_relative_news','');
		$sectionIds			= $request->get('subsection_ids','');
		$orderIds			= $request->get('suborder_ids','');
		$order 				= $request->get('main_section_order','1');
		$imgs				= $request->get('imgs','');
		$getImagefromContent= $request->get('chk_getImagefromContent',true);
		$brief				= $request->get('brief','');
		$content			= $request->get('content','');
		$publishDate		= $request->get('publish_date','');
		$editBy				= $this->get('security.token_storage')->getToken()->getUser()->getUserName();
		 
		$responses = null;
		 
		if (false === (
				$this->get('security.authorization_checker')->isGranted('ROLE_NEWS_POST')
				||
				$this->get('security.authorization_checker')->isGranted('ROLE_NEWS_APPROVE')
				))
		{
			//return $this->forward('PortalAdminBundle:Map:view', array('id'=>$id, 'lang'=>$lang));
			return new Response(null);
		}
		 
		switch ($action)
		{
			case "save":
				$responses = MarkerHelper::update($id, $lang, $address,$contact,$longitude,$latitude, $category_id, $title, $keywords, $tags,  $relativeMarkers, $detailNews, $imgs, $brief, $content
				, $isHeadline, $isPublish, $isComment, $publishDate, $sectionId, $order
				, $sectionIds, $orderIds, false,$editBy);
				break;
			case "draft":
				$responses = MarkerHelper::update($id, $lang, $address,$contact,$longitude,$latitude, $category_id, $title, $keywords, $tags,  $relativeMarkers, $detailNews, $imgs, $brief, $content
				, $isHeadline, $isPublish, $isComment, $publishDate, $sectionId, $order
				, $sectionIds, $orderIds, true,$editBy);
				break;
			default:
				break;
		}
		 
		 
		if ($responses == null)
			$responses = array("Save Successful");
			if(!isset($back)) $back="index";
			
			return new Response(json_encode($responses));
	}
	public function publishAction(Request $request,$lang, $id, $isPublish)
	{
		$result = MarkerHelper::setPublish($lang, $id, $isPublish);

		$json = array();
		$json["status"] = ($result == null)?"OK":"FAIL";
		$json["message"] = $result;

		$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

		return $response;

	}
	public function togglePublishAction(Request $request,$lang,$id)
	{
		$result = MarkerHelper::togglePublish($lang,$id);

		$json = array();
		$json["status"] = ($result == true | $result == false )?"OK":"FAIL";
		$json["message"] = $result;

		$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

		return $response;

	}
	public function headlineAction(Request $request,$id, $isHeadline)
	{
		$result = MarkerHelper::setHeadline($id, $isHeadline);

		$json = array();
		$json["status"] = ($result == null)?"OK":"FAIL";
		$json["message"] = $result;

		$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

		return $response;

	}
	public function toggleHeadlineAction(Request $request,$lang,$id)
	{
		$locale			= $this->getParameter('auth_locale');
		$lang 			= $request->get('lang',$locale);
		 
		$result = MarkerHelper::toggleHeadline($lang,$id);

		$json = array();
		$json["status"] = ($result == true | $result == false )?"OK":"FAIL";
		$json["message"] = $result;

		$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

		return $response;

	}
	public function commentAction(Request $request,$id, $isComment)
	{
		$result = MarkerHelper::setComment($id, $isComment);

		$json = array();
		$json["status"] = ($result == null)?"OK":"FAIL";
		$json["message"] = $result;

		$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

		return $response;

	}
	public function toggleCommentAction(Request $request,$lang,$id)
	{
		$request		= $this->getRequest();
		$locale			= $this->getParameter('auth_locale');
		$lang 			= $request->get('lang',$locale);
		 
		$result = MarkerHelper::toggleComment($lang,$id);

		$json = array();
		$json["status"] = ($result == true | $result == false )?"OK":"FAIL";
		$json["message"] = $result;

		$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

		return $response;

	}
	public function previewAction(Request $request,$locale,$markerId)
	{
		return $this->render('PortalFrontBundle:Map:preview.html.twig'
				,array(	'locale'	=>	$locale,
						'markerId'	=>  $markerId
				)
				);
	}
	public function getmarkerAction(Request $request)
	{
		$_locale=$request->get('locale',$request->getLocale());
		$id=$request->get('id',0);

		$marker=MapHelper::getMarker($id,$_locale);
		$response = new Response(json_encode($marker));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}
}
