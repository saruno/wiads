<?php
namespace Portal\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Portal\AdminBundle\Helper\AdvertHelper;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Portal\AdminBundle\Helper\NewsHelper;
use Portal\AdminBundle\Helper\SectionHelper;
use Portal\AdminBundle\Helper\LanguageHelper;
use Portal\AdminBundle\Helper\CustomerHelper;
use Portal\AdminBundle\Helper\UtilsHelper;

class NewsController extends Controller
{

	public function indexAction(Request $request, $lang, $sectionId, $page=1, $pageSize=20)
	{
		//Response Message
		$responses 		= array();
		

		$action 		= $request->get('action','list');
		
		$locale				= $this->getParameter('auth_locale');
		 
		$lang	= ($lang != "")? $lang : $locale;

		$langs=LanguageHelper::getAllLanguage_Admin($locale);

		$sections = array();
		SectionHelper::getAllSection_Admin($sections, $lang,1);
		 
		 
		$reqStatus=$request->get('status',null);
		$txtSearch = $request->get('txtSearch','');
		$status= array();
		//NewsHelper::reUpdateWebLink($locale);
		 
		$onlyDraft=false;
		switch ($action)
		{
			case "delete":
				$responses = $this->forward('PortalAdminBundle:News:delete',array('request' =>$request));
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
				 
				$postBy				= $this->get('security.token_storage')->getToken()->getUser()->getUserName();
				$newsPager = NewsHelper::getNewsWithPagingandFilter_Admin($page, $pageSize, $sectionId, $lang,$txtSearch, $status,$onlyDraft,true,$postBy);
				/*
				 $listNews=$pager["items"];
				 $paginator=$pager["paginator"];
				 */
				break;
			default:
				break;

		}
		// NewsHelper::reUpdateWebLink($locale);
		return $this->render('PortalAdminBundle:News:index.html.twig',
				array('langs'=>$langs
						,'currentSection'=>$sectionId
						,'status'=> $reqStatus
						,'sections'=>$sections
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
		SectionHelper::getAllSection_Admin($sections, $lang,1);


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
				$postBy				= $this->get('security.token_storage')->getToken()->getUser()->getUserName();
				$newsPager = NewsHelper::getNewsWithPagingandFilter_Admin($page, $pageSize, $sectionId, $lang, $txtSearch,$status,$onlyDraft,false,$postBy);
				/*
				 $listNews=$pager["items"];
				 $paginator=$pager["paginator"];
				 */
				break;
			default:
				break;

		}

		return $this->render('PortalAdminBundle:News:relativeForm.html.twig',
				array('langs'=>$langs
						,'currentSection'=>$sectionId
						,'status'=> $reqStatus
						,'sections'=>$sections
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
	public function approveAction(Request $request,$lang, $sectionId, $page=1, $pageSize=20)
	{
		//Response Message
		$responses 		= array();
		$errors=null;
		if($responses!=null)
			foreach ($responses as $key=>$value){
				$errors[$key]=$value;
		}
		$action 		= $request->get('action','list');
		
		$locale				= $this->getParameter('auth_locale');

		$lang	= ($lang != "")? $lang : $locale;

		$langs=LanguageHelper::getAllLanguage_Admin($locale);

		$sections = array();
		SectionHelper::getAllSection_Admin($sections, $lang,1);

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
				$pager = NewsHelper::getNewsForApproveWithPagingAndFilter_Admin($page, $pageSize, $sectionId, $lang,$txtSearch, $status);

				$listNews=$pager["items"];
				$paginator=$pager["paginator"];

				break;
			case "delete":
				return $this->forward('PortalAdminBundle:News:delete');
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

		return $this->render('PortalAdminBundle:News:approve.html.twig',
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
		 
		 
		$title				= $request->get('title','');
		$keywords			= $request->get('keywords','');
		$tags				= $request->get('tags','');
		$isHeadline			= $request->get('chk_headline','');
		$isPublish			= $request->get('chk_publish','');
		$isComment			= $request->get('chk_comment','');
		$relativeNews		= $request->get('hi_relative_news','');
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
				$errors = NewsHelper::add($lang, $title, $keywords, $tags, $relativeNews, $imgs, $brief, $content
				, $isHeadline, $isPublish, $isComment, $publishDate, $sectionId, $order
				, $sectionIds, $orderIds, false,$postBy);
				 
				if ($errors == null)
				{
					return $this->redirect($this->generateUrl('News_list_page_pagesize', array('lang' => $lang, 'sectionId'=>$sectionId,'page'=>1), true));


				}
				 
				break;
			case "draft":
				$errors = NewsHelper::add($lang, $title, $keywords, $tags, $relativeNews, $imgs, $brief, $content
				, $isHeadline, $isPublish, $isComment, $publishDate, $sectionId, $order
				, $sectionIds, $orderIds, true,$postBy);

				if ($errors == null)
				{
					return $this->redirect($this->generateUrl('News_list_page_pagesize', array('lang' => $lang, 'sectionId'=>$sectionId,'page'=>1), true));
				}
				break;
			default:
				break;
		}
		 
		$langs=LanguageHelper::getAllLanguage_Admin($locale);
		 
		$sections =array();
		SectionHelper::getAllSection_Admin($sections,$lang,1);
		 
		return $this->render('PortalAdminBundle:News:add.html.twig',
				array(
						'langs'=>$langs
						, 'lang'=>$lang
						, 'title' =>$title
						, 'keywords'=>$keywords
						, 'tags'=>$tags
						, 'isHeadline'=>$isHeadline
						, 'isPublish'=>$isPublish
						, 'isComment'=>$isComment
						, 'sectionId'=>$sectionId
						, 'sections'=>$sections
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
				$result = NewsHelper::delete($id, $lang);
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
		if(!isset($back))	$back = $request->get('back','index');
		//Languagues
		$locale			= $this->getParameter('auth_locale');
		$langs			= LanguageHelper::getAllLanguage_Admin($locale);
		
		if ($request->getMethod()=="POST")
		{
			$lang 			= $request->request->get('lang',$locale);
		}
		
		//News
		$news		= NewsHelper::getNews_Admin($id, $lang);
		
		if (!$news) {
		
			throw $this->createNotFoundException('The news does not exist');
		}
		switch ($action)
		{
			case "save":
				$responses = $this->forward('PortalAdminBundle:News:update', array('request'=>$request, 'action'=>$action,'back' => $back));
				break;
			case "draft":
				$responses =  $this->forward('PortalAdminBundle:News:update', array('request'=>$request, 'action'=>$action));
				break;
			case "delete":
				$responses =  $this->forward('PortalAdminBundle:News:delete',array('request'=>$request));
				break;
			default:
		
				break;
		
		}
		//Relative News
		$relativeNewsObjs=NewsHelper::getRelativeNews_Admin($news->getId(), $lang);
		//Parent sections
		$sections = array();
		SectionHelper::getAllSection_Admin($sections,$lang,1,true,-1);
		
		//Render View
		return $this->render('PortalAdminBundle:News:view.html.twig',
				array('news'=>$news
						, 'relativeNewsObjs' => $relativeNewsObjs
						, 'back' => $back
						, 'langs'=>$langs
						, 'sections'=>$sections
						, 'errors' => $responses));
	}
	public function updateAction(Request $request,$action,$back="index")
	{
		$locale			= $this->getParameter('auth_locale');

		
		$id					= $request->get('action_id',-1);
		$lang				= $request->get('lang',$locale);
		$title				= $request->get('title','');
		$keywords			= $request->get('keywords','');
		$tags				= $request->get('tags','');
		$isHeadline			= $request->get('chk_headline',false);
		$isPublish			= $request->get('chk_publish',false);
		$isComment			= $request->get('chk_comment',false);
		$sectionId			= $request->request->get('sectionId',-1);
		$relativeNews			= $request->get('hi_relative_news','');
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
			return new Response(null);
		}
		 
		switch ($action)
		{
			case "save":
				$responses = NewsHelper::update($id, $lang, $title, $keywords, $tags, $relativeNews,$imgs, $brief, $content
				, $isHeadline, $isPublish, $isComment, $publishDate, $sectionId, $order
				, $sectionIds, $orderIds, false,$editBy);
				break;
			case "draft":
				$responses = NewsHelper::update($id, $lang, $title, $keywords, $tags, $relativeNews,$imgs, $brief, $content
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
		$result = NewsHelper::setPublish($lang, $id, $isPublish);

		$json = array();
		$json["status"] = ($result == null)?"OK":"FAIL";
		$json["message"] = $result;

		$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

		return $response;

	}
	public function togglePublishAction(Request $request,$lang,$id)
	{
		$result = NewsHelper::togglePublish($lang,$id);

		$json = array();
		$json["status"] = ($result == true | $result == false )?"OK":"FAIL";
		$json["message"] = $result;

		$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

		return $response;

	}
	public function headlineAction(Request $request,$id, $isHeadline)
	{
		$result = NewsHelper::setHeadline($id, $isHeadline);

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
		 
		$result = NewsHelper::toggleHeadline($lang,$id);

		$json = array();
		$json["status"] = ($result == true | $result == false )?"OK":"FAIL";
		$json["message"] = $result;

		$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

		return $response;

	}
	public function commentAction(Request $request,$id, $isComment)
	{
		$result = NewsHelper::setComment($id, $isComment);

		$json = array();
		$json["status"] = ($result == null)?"OK":"FAIL";
		$json["message"] = $result;

		$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

		return $response;

	}
	public function toggleCommentAction(Request $request, $lang,$id)
	{
		$locale			= $this->getParameter('auth_locale');
		$lang 			= $request->get('lang',$locale);
		 
		$result = NewsHelper::toggleComment($lang,$id);

		$json = array();
		$json["status"] = ($result == true | $result == false )?"OK":"FAIL";
		$json["message"] = $result;

		$response = new Response(json_encode($json),200,array('Content-Type'=>'application/json; charset=utf-8'));

		return $response;

	}
	public function previewAction(Request $request, $locale,$sectionId,$sectionTitle,$newsId,$newsTitle)
	{
		$news=NewsHelper::getNews_Admin($newsId, $locale);
		$relativesNews= FrontNewsHelper::getRelativeNews($newsId, $locale);
		$olderNews = FrontNewsHelper::getOlderNews($newsId, $sectionId, $locale);
		$section=SectionHelper::getSection_Admin($sectionId,$locale);

		$zoneN_VIDEO=FrontNewsHelper::getHomeNewsSlot('N_VIDEO', $locale);
		$zoneN_PHOTO=FrontNewsHelper::getHomeNewsSlot('N_PHOTO', $locale);

		return $this->render('PortalFrontBundle:News:detail.html.twig',
				array(	'locale'	=>	$locale
						,'news'		=>	$news
						,'relativesNews' => $relativesNews
						,'olderNews'	=> $olderNews
						,'section' => $section
						,'zoneN_VIDEO'	=>	$zoneN_VIDEO
						,'zoneN_PHOTO'	=>	$zoneN_PHOTO
				));
	}
}
