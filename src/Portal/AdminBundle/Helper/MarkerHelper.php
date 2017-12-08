<?php
namespace Portal\AdminBundle\Helper;

use JMS\DiExtraBundle\Annotation\AfterSetup;

use Common\DbBundle\Model\App;
use Common\DbBundle\Model\Marker;
use Common\DbBundle\Model\MarkerQuery;
use Common\DbBundle\Model\MarkerI18nQuery;

use Common\DbBundle\Model\NewsQuery;
use Common\DbBundle\Model\NewsI18nQuery;


use Common\DbBundle\Model\Sectioncache;
use Common\DbBundle\Model\SectioncacheQuery;

use Common\DbBundle\Model\Section;
use Common\DbBundle\Model\SectionQuery;
use Common\DbBundle\Model\SectionI18nQuery;

use Common\DbBundle\Model\Logs;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;


#use Portal\AdminBundle\Model;

class MarkerHelper{
	static public function getMarker_Admin($id, $lang)
	{
		$marker = MarkerQuery::create()
		->joinWithI18n($lang,Criteria::INNER_JOIN)
		->addAnd('marker.ID',$id,Criteria::EQUAL)
		->findOne();
		if ($marker != null)
			$marker->setLocale($lang);
		return $marker;
	}
	static public function getRelativeMarkers_Admin($id,$locale){
		$marker = MarkerQuery::create()
				->joinWithI18n($locale,Criteria::INNER_JOIN)
				->findPk($id);
		if ($marker == null) return null;
		$ids=explode(",", $marker->getRelativeNews());

		$relativesMarkers = MarkerQuery::create()
						->addAnd('marker.ID',($ids),Criteria::IN)
						->joinWithI18n($locale,Criteria::INNER_JOIN)
						->find();
		return $relativesMarkers;
		
	}
	static public function getDetailNewsUrl_Admin($id,$locale){
		return NewsQuery::create()
		->joinWithI18n($locale,Criteria::INNER_JOIN)
		->findPk($id);
	}
	static public function getDetailNewsUrlLink_Admin($idStr,$locale){
		
		$ids=explode(",", $idStr);
		if(count($ids)>0) $id=$ids[0];
		return NewsHelper::generateWebLink($id,-1, $locale).".html";
	
	}
	static public function getMarkerWithPaging_Admin($page,$pagesize,$sectionId,$locale,$status =null,$onlyDraft=false,$filterUser=false,$username=null)
	{
		$c = new Criteria();
		$arr=array();
		$s_id=array();
		$s_id[]="$sectionId";
		$sectionType=2;
		SectionHelper::getSectionIdRecursive_Admin($arr, $sectionId, $locale,$sectionType);
		//if(count($arr)==0) return null;
		foreach ($arr as $sid){
			$s_id[]=$sid['id'];
		}
		
		$crit1 = $c->getNewCriterion('marker.SECTION_ID',($s_id) ,Criteria::IN);
		//$c->getNewCriterion('marker.SECTION_ID', $sectionId);
		
		if ($sectionId != -1){
			$crit2 = $c->getNewCriterion('marker.SUBSECTION_IDS', '%,'.$sectionId.',%', Criteria::LIKE);
			$crit1->addOr($crit2);
		}
		
		$MarkerQuery=MarkerQuery::create()
		->addAnd($crit1)
		->addAnd('marker_i18n.TRASH', true, Criteria::NOT_EQUAL)
		->joinWithI18n($locale,Criteria::INNER_JOIN);
		
		if($status!==null){
			$MarkerQuery->addAnd('marker_i18n.STATUS',($status) ,Criteria::IN);
		}
		if($onlyDraft===true)
			$MarkerQuery->addAnd('marker_i18n.DRAFT',true);
		
		if($filterUser===true)
			$MarkerQuery->addAnd('marker_i18n.POST_BY',$username);
		
		$pager	=	$MarkerQuery->paginate($page, $pagesize);
		
		return $pager;
	}
	static public function getMarkerWithPagingandFilter_Admin($page,$pagesize,$sectionId,$locale,$txtSearch="",$status =null,$onlyDraft=false,$filterUser=false,$username=null)
	{
		$c = new Criteria();
		$arr=array();
		$s_id=array();
		$s_id[]="$sectionId";
		$sectionType=2;
		SectionHelper::getSectionIdRecursive_Admin($arr, $sectionId, $locale,$sectionType);
		//if(count($arr)==0) return null;
		foreach ($arr as $sid){
			$s_id[]=$sid['id'];
		}
	
		$crit1 = $c->getNewCriterion('marker.SECTION_ID',($s_id) ,Criteria::IN);
		//$c->getNewCriterion('marker.SECTION_ID, $sectionId);
	
		if ($sectionId != -1){
			$crit2 = $c->getNewCriterion('marker.SUBSECTION_IDS', '%,'.$sectionId.',%', Criteria::LIKE);
			$crit1->addOr($crit2);
		}
	
		$MarkerQuery=MarkerQuery::create()
		->addAnd($crit1)
		//->addAnd('marker_i18n.TRASH', true, Criteria::NOT_EQUAL)
		->addAnd(`marker_i18n`.`TRASH`,"(`marker_i18n`.`TRASH` is null or `marker_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
		->joinWithI18n($locale);
	
		if($status!==null){
			$MarkerQuery->addAnd('marker_i18n.STATUS',($status) ,Criteria::IN);
		}
		if($txtSearch!=""){
			$MarkerQuery->addAnd('marker_i18n.TITLE',"%$txtSearch%" ,Criteria::LIKE);
		}
		if($onlyDraft===true)
			$MarkerQuery->addAnd('marker_i18n.DRAFT',true);
	
		if($filterUser===true)
			$MarkerQuery->addAnd('marker_i18n.POST_BY',$username);
	
		$pager	=	$MarkerQuery->paginate($page, $pagesize);
	
		return $pager;
	}
	static public function getMarkerForApproveWithPaging_Admin($page,$pagesize,$sectionId,$locale,$status =null)
	{
		$c = new Criteria();
		
		$arr=array();
		$s_id=array();
		$s_id[]="$sectionId";
		$sectionType=2;
		SectionHelper::getSectionIdRecursive_Admin($arr, $sectionId, $locale,$sectionType);
		//if(count($arr)==0) return null;
		foreach ($arr as $sid){
			$s_id[]=$sid['id'];
		}
		
		$crit1 = $c->getNewCriterion('marker.SECTION_ID',($s_id) ,Criteria::IN);
		//$c->getNewCriterion('marker.SECTION_ID, $sectionId);
		
		if ($sectionId != -1){
			$crit2 = $c->getNewCriterion('marker.SUBSECTION_IDS', '%,'.$sectionId.',%', Criteria::LIKE);
			$crit1->addOr($crit2);
		}
		$midrange = 7;
		$itemsCount = 0;
		$listNews = array();
	
		$itemCountQuery = MarkerQuery::create()
		//->addAnd('marker_i18n.TRASH', true, Criteria::NOT_EQUAL)
		//->addAnd('marker_i18n.DRAFT', true, Criteria::NOT_EQUAL)
		->addAnd(`marker_i18n`.`TRASH`,"(`marker_i18n`.`TRASH` is null or `marker_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
		->addAnd(`marker_i18n`.`DRAFT`,"(`marker_i18n`.`DRAFT` is null or `marker_i18n`.`DRAFT` <>true)",Criteria::CUSTOM)
		->joinWithI18n($locale);
		
		$itemCountQuery->addAnd($crit1);
		
		if($status!=null)
			$itemCountQuery->addAnd('marker_i18n.STATUS',($status) ,Criteria::IN);
	
		/*if ($sectionId != -1)
		{
			$itemCountQuery->addAnd($crit1);
			//$itemCountQuery->addAnd('marker.SECTION_ID,$sectionId);
			//$itemCountQuery->addOr('marker.SUBSECTION_IDS, "%,".$sectionId.",%", Criteria::LIKE);
	
		}
		*/
		$itemsCount = $itemCountQuery->count();
	
		$listMarkerQuery=MarkerQuery::create()
		//->addAnd('marker_i18n.TRASH', true, Criteria::NOT_EQUAL)
		//->addAnd('marker_i18n.DRAFT', true, Criteria::NOT_EQUAL)
		->addAnd(`marker_i18n`.`TRASH`,"(`marker_i18n`.`TRASH` is null or `marker_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
		->addAnd(`marker_i18n`.`DRAFT`,"(`marker_i18n`.`DRAFT` is null or `marker_i18n`.`DRAFT` <>true)",Criteria::CUSTOM)
		->joinWithI18n($locale,Criteria::INNER_JOIN);
	
		$listMarkerQuery->addAnd($crit1);
		
		if($status!=null)
			$listMarkerQuery->addAnd('marker_i18n.STATUS',($status) ,Criteria::IN);
	
		/*
		if ($sectionId != -1)
		{
			$listMarkerQuery->addAnd($crit1);
			//$listMarkerQuery->addAnd('marker.SECTION_ID,$sectionId);
			//$listMarkerQuery->addOr('marker.SUBSECTION_IDS, "%,".$sectionId.",%", Criteria::LIKE);
			
		}
		*/
		$listNews = $listMarkerQuery->offset(($page-1)*$pagesize)
		->limit($pagesize)
		->orderByUpdatedAt('desc')
		->orderByCreatedAt('desc')
		->find();
	
		$paginator = new PaginatorHelper($itemsCount, $page , $pagesize, $midrange);
	
		return array('items' => $listNews, 'paginator' => $paginator);
			
	}
	static public function getMarkerForApproveWithPagingAndFilter_Admin($page,$pagesize,$sectionId,$locale,$txtSearch,$status =null)
	{
		$c = new Criteria();
	
		$arr=array();
		$s_id=array();
		$s_id[]="$sectionId";
		$sectionType=2;
		SectionHelper::getSectionIdRecursive_Admin($arr, $sectionId, $locale,$sectionType);
		//if(count($arr)==0) return null;
		foreach ($arr as $sid){
			$s_id[]=$sid['id'];
		}
	
		$crit1 = $c->getNewCriterion('marker.SECTION_ID',($s_id) ,Criteria::IN);
		//$c->getNewCriterion('marker.SECTION_ID, $sectionId);
		if($txtSearch!=""){
			$crit3 = $c->getNewCriterion('marker_i18n.TITLE',"%$txtSearch%" ,Criteria::LIKE);
			$crit1->addAnd($crit3);
		}
		if ($sectionId != -1){
			$crit2 = $c->getNewCriterion('marker.SUBSECTION_IDS', '%,'.$sectionId.',%', Criteria::LIKE);
			$crit1->addOr($crit2);
		}

		$midrange = 7;
		$itemsCount = 0;
		$listNews = array();
	
		$itemCountQuery = MarkerQuery::create()
		->addAnd(`marker_i18n`.`TRASH`,"(`marker_i18n`.`TRASH` is null or `marker_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
		->addAnd(`marker_i18n`.`DRAFT`,"(`marker_i18n`.`DRAFT` is null or `marker_i18n`.`DRAFT` <>true)",Criteria::CUSTOM)
		->joinWithI18n($locale);

		$itemCountQuery->addAnd($crit1);
	
		if($status!=null)
			$itemCountQuery->addAnd('marker_i18n.STATUS',($status) ,Criteria::IN);
	
		/*if ($sectionId != -1)
			{
		$itemCountQuery->addAnd($crit1);
		//$itemCountQuery->addAnd('marker.SECTION_ID',$sectionId);
		//$itemCountQuery->addOr('marker.SUBSECTION_IDS', "%,".$sectionId.",%", Criteria::LIKE);
	
		}
		*/
		$itemsCount = $itemCountQuery->count();
	
		$listMarkerQuery=MarkerQuery::create()
		->addAnd(`marker_i18n`.`TRASH`,"(`marker_i18n`.`TRASH` is null or `marker_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
		->addAnd(`marker_i18n`.`DRAFT`,"(`marker_i18n`.`DRAFT` is null or `marker_i18n`.`DRAFT` <>true)",Criteria::CUSTOM)
		->joinWithI18n($locale);
	
		$listMarkerQuery->addAnd($crit1);
	
		if($status!=null)
			$listMarkerQuery->addAnd('marker_i18n.STATUS',($status) ,Criteria::IN);
	
		/*
			if ($sectionId != -1)
			{
		$listMarkerQuery->addAnd($crit1);
		//$listMarkerQuery->addAnd('marker.SECTION_ID',$sectionId);
		//$listMarkerQuery->addOr('marker.SUBSECTION_IDS', "%,".$sectionId.",%", Criteria::LIKE);
			
		}
		*/
		$listNews = $listMarkerQuery->offset(($page-1)*$pagesize)
		->limit($pagesize)
		->orderByUpdatedAt('desc')
		->orderByCreatedAt('desc')
		->find();
	
		$paginator = new PaginatorHelper($itemsCount, $page , $pagesize, $midrange);
	
		return array('items' => $listNews, 'paginator' => $paginator);
			
	}
	static public function add($lang,$address,$contact,$longitude,$latitude, $cagegory_id, $title, $keywords, $tags, $relativeMarkers, $detailNews,$imgs, $brief
    									, $content, $isHeadline, $isPublish, $isComment
    									, $publishDate, $sectionId, $order, $sectionIds, $orderIds,$draft,$postBy)
   {
		$marker = new Marker();
		
		$marker->setLocale($lang);
		
		$marker->setName($title);
		$marker->setAddress($address);
		$marker->setPcontact($contact);
		$marker->setLongitude($longitude);
		$marker->setLatitude($latitude);
		$marker->setCategoryId($cagegory_id);
		$marker->setDetailUrl(self::getDetailNewsUrlLink_Admin($detailNews, $lang));
		
		$dIds=explode(",", $detailNews);
		if(count($dIds)>0)
			$marker->setDetailUrlId($dIds[0]);
		else
			$marker->setDetailUrlId("");
		
		$marker->setTitle($title);
		$marker->setStripTitle(UtilsHelper::utf8_to_ascii($title));
		$marker->setKeyword($keywords);
		$marker->setTag($tags);
		$marker->setImgs($imgs);
		$marker->setImage($marker->get1stImage());
		$marker->setBrief($brief);
		$marker->setContent($content);
		$marker->setFrontPage($isHeadline);
		/*$marker->setLocked($isPublish);*/
		$marker->setHasComment($isComment);
		$marker->setSectionId($sectionId);
		$marker->setOrders($order);
		$marker->setSubsectionIds($sectionIds);
		$marker->setSuborderIds($orderIds);
		$marker->setPublishedAt($publishDate);
		$marker->setRelativeNews($relativeMarkers);
		$marker->setDraft($draft);
		$marker->setPostBy($postBy);
		$marker->setTrash(false);
				
		$marker->setLocked(true);
		if($draft)
			$marker->setStatus("draft");
		else
			$marker->setStatus("submit");
		
		$marker->setPreStatus("initial");
		
		$marker->save();
		$marker->setLink(self::generateWebLink($marker->getId(), $sectionId, $lang));
		$marker->setShortLink(self::generateWebShortLink($marker->getId(), $lang));
		$marker->save();
   }
   
   static public function update($id, $lang,$address,$contact,$longitude,$latitude, $cagegory_id, $title, $keywords, $tags, $relativeMarkers, $detailNews,$imgs, $brief
    									, $content, $isHeadline, $isPublish, $isComment
    									, $publishDate,$sectionId, $order,  $sectionIds, $orderIds,$draft,$editBy)
   {
   		
   		$marker=MarkerQuery::create()->findPk($id);

   		/* Write log */
   		if(( $marker->getTitle() != $title) || ($marker->getContent() != $content) ){
   			$log=new Logs();
   			$log->setOld($marker->getTitle() ."/". $marker->getContent());
	   		$log->setCurrent($title ."/". $content);
	   		$log->setTable("MARKER");
	   		$log->setEditBy($editBy); 
	   		$log->save();
   		}
		if ($marker == null)
			return array("MapId=".$id." does not exists");
   	
   		$marker->setLocale($lang);
   		
   		$marker->setName($title);
   		$marker->setAddress($address);
   		$marker->setPcontact($contact);
   		$marker->setLongitude($longitude);
   		$marker->setLatitude($latitude);
   		$marker->setCategoryId($cagegory_id);
   		
   		$marker->setDetailUrl(self::getDetailNewsUrlLink_Admin($detailNews, $lang));
   		
   		$dIds=explode(",", $detailNews);
   		if(count($dIds)>0)
   			$marker->setDetailUrlId($dIds[0]);
   		else
   			$marker->setDetailUrlId("");
   		
		$marker->setTitle($title);
		$marker->setStripTitle(UtilsHelper::utf8_to_ascii($title));
		$marker->setLink(self::generateWebLink($id, $sectionId, $lang));
		$marker->setShortLink(self::generateWebShortLink($id, $lang));
		$marker->setKeyword($keywords);
		$marker->setTag($tags);
		$marker->setImgs($imgs);
		$marker->setImage($marker->get1stImage());
		$marker->setBrief($brief);
		$marker->setContent($content);
		$marker->setFrontPage($isHeadline);
		/*$marker->setLocked($isPublish);*/
		$marker->setHasComment($isComment);
		$marker->setSectionId($sectionId);
		$marker->setOrders($order);
		$marker->setSubsectionIds($sectionIds);
		$marker->setSuborderIds($orderIds);
		$marker->setRelativeNews($relativeMarkers);
		$marker->setPublishedAt($publishDate);
		$marker->setDraft($draft);
		$marker->setEditBy($editBy);
		/*$marker->setTrash(0);*/
   	
		$marker->setLocked(true);
		
		if($draft){
			if($marker->getStatus()!=="draft"){
				$marker->setPreStatus($marker->getStatus());
			}
			$marker->setStatus("draft");
		}
		else{
			if($marker->getStatus()!=="submit"){
				$marker->setPreStatus($marker->getStatus());
			}
			$marker->setStatus("submit");
		}
		
		$marker->save();
		self::updateSectionCache($id,$lang,$sectionId,$order, $sectionIds, $orderIds);
		return null;
   }	
   static public function delete($id,$lang){
   	$result = array();
   
   	$marker = MarkerI18nQuery::create()
   	->addAnd('marker_i18n.ID', $id)
   	->addAnd('marker_i18n.LOCALE', $lang)
   	->findOne();
   
   	if ($marker == null)
   	{
   		array_push($result, "NewsId=".$id." does not exists");
   		return $result;
   	}
   	
	$marker->setTrash(true);   
	$marker->save();
   	
	self::flushSectionCache($marker->getId(),$marker->getLocale());
   
   	return $result;
   }
   static public function setPublish($lang,$id,$isPublish)
   {
   
   	$marker = MarkerQuery::create()->findPk($id);
   
   	if ($marker == null)
   		return array("NewsId=".$id." does not exists");
  	
   	$marker->setLocale($lang);
   	$marker->setLocked($isPublish);
   	$marker->save();
   
   	return null;
   
   }	
   static public function togglePublish($lang,$id)
   {
   	 
   	$marker = MarkerQuery::create()->findPk($id);
   	 
   	if ($marker == null)
   		return array("NewsId=".$id." does not exists");
   	 
   	$marker->setLocale($lang);
   	if($marker->getLocked()==true){
   		if($marker->getStatus()!="approved")
   			$marker->setPreStatus($marker->getStatus());
   		$marker->setStatus("approved");
   	}
   	else{
   		if($marker->getStatus()!="waiting approved")
   			$marker->setPreStatus($marker->getStatus());
   		$marker->setStatus("waiting approved");
   	}
   	$marker->setLocked(!$marker->getLocked());
   	$marker->save();

   	self::updateSectionCache($marker->getId(), $marker->getLocale(), $marker->getSectionId(), $marker->getOrders(), $marker->getSubsectionIds(), $marker->getSuborderIds()); 

   	return $marker->getLocked();
   	 
   }
   static public function setHeadline($id,$isHeadline)
   {
   	 
   	$marker = MarkerQuery::create()->findPk($id);
   	 
   	if ($marker == null)
   		return array("NewsId=".$id." does not exists");
   	 
   	$marker->setFrontPage($isHeadline);
   	$marker->save();
   	 
   	return null;
   	 
   }	
   static public function toggleHeadline($locale,$id)
   {
   	 
   	$marker = MarkerQuery::create()->findPk($id);
   	 
   	if ($marker == null)
   		return array("NewsId=".$id." does not exists");
   	 
   	/*$marker->setLocale($locale);*/
   	$marker->setFrontPage(!$marker->getFrontPage());
   	$marker->save();
   	 
   	self::updateSectionCache($marker->getId(), $marker->getLocale(), $marker->getSectionId(), $marker->getOrders(), $marker->getSubsectionIds(), $marker->getSuborderIds());
   	
   	return $marker->getFrontPage();
   	 
   }
   static public function setComment($id,$isComment)
   {
   	 
   	$marker = MarkerQuery::create()->findPk($id);
   	 
   	if ($marker == null)
   		return array("NewsId=".$id." does not exists");
   	 $marker = new Marker();
   	
   	$marker->setHasComment($isComment);
   	$marker->save();
   	 
   	return null;
   	 
   }			
   static public function toggleComment($locale,$id)
   {
   	 
   	$marker = MarkerQuery::create()->findPk($id);
   	 
   	if ($marker == null)
   		return array("NewsId=".$id." does not exists");
   	
   	/*$marker->setLocale($locale);*/
   	$marker->setHasComment(!$marker->getHasComment());
   	$marker->save();
   	 
   	return $marker->getHasComment();
   	/**
   	 Delete section does not exits in advert table
   	 */
   	$trashItems=SectioncacheQuery::create()
   	->findByNewsId($id);
   	foreach ($trashItems as $trash){
   		if(in_array($trash->getSectionId(),$sections) ==false ){
   			$trash->delete();
   		}
   	}
   }
   static function flushSectionCache($id,$locale){
     /**
   	 Delete news that do not belong sections
   	 */
   	$trashItems	=	SectioncacheQuery::create()
			   		->addAnd('sectioncache.LOCALE',$locale)
			   		->findByNewsId($id);
   	foreach ($trashItems as $trash){
   			$trash->delete();
   	}
   }
   static function updateSectionCache($id,$locale,$sectionId,$order,$sectionIds,$sectionOrders){
   	$marker = MarkerQuery::create()
   					->findPk($id);
   	if($marker)
   		$marker->setLocale($locale);
   	else 
   		return;
   	$sections	=	explode(",", $sectionIds);
   	$orders		=	explode(",", $sectionOrders);
   	
   	
   	/**
   	 Delete news that do not belong sections
   	 */
   	$trashItems	=	SectioncacheQuery::create()
			   		->addAnd('sectioncache.LOCALE',$locale)
			   		->findByNewsId($id);
   	foreach ($trashItems as $trash){
   		if(in_array($trash->getSectionId(),$sections) ==false ){
   			$trash->delete();
   		}
   	}
   	
   	$item = SectioncacheQuery::create()
   			->findPk(array($sectionId,$id,$locale));
   	if($item){
   		$item->setSectionId($sectionId);
   		$item->setNewsId($id);
   		$item->setLocale($locale);
   		$item->setLink(self::generateWebLink($id, $sectionId, $locale));
   		$item->setLocked($marker->getLocked());
   		$item->setFrontPage($marker->getFrontPage());
   		$item->setOrders($order);
   		$item->setPublishedAt($marker->getPublishedAt());
   		$item->save();
   	}
   	else{
   		$item=new Sectioncache();
   		$item->setSectionId($sectionId);
   		$item->setNewsId($id);
   		$item->setLocale($locale);
   		$item->setLink(self::generateWebLink($id, $sectionId, $locale));
   		$item->setLocked($marker->getLocked());
   		$item->setFrontPage($marker->getFrontPage());
   		$item->setOrders($order);
   		$item->setPublishedAt($marker->getPublishedAt());
   		$item->save();
   	}
   	
   	for ($i = 0; $i< count($sections); $i++){
   		$order=10;
   		$sectionId=$sections[$i];
   		if($sectionId==0) continue;
   		if($i<count($orders))
   			$order=$orders[$i];
   		
   		$item = SectioncacheQuery::create()
   				->findPk(array($sectionId,$id,$locale));
   		
   		if($item){
   			$item->setSectionId($sectionId);
   			$item->setNewsId($id);
   			$item->setLocale($locale);
   			$item->setLink(self::generateWebLink($id, $sectionId, $locale));
   			$item->setOrders($order);
   			$item->setLocked($marker->getLocked());
   			$item->setFrontPage($marker->getFrontPage());
   			$item->setPublishedAt($marker->getPublishedAt());
   			$item->save();
   		}
   		else{
   			$item=new Sectioncache();
   			$item->setSectionId($sectionId);
   			$item->setNewsId($id);
   			$item->setLocale($locale);
   			$item->setLink(self::generateWebLink($id, $sectionId, $locale));
   			$item->setLocked($marker->getLocked());
   			$item->setFrontPage($marker->getFrontPage());
   			$item->setOrders($order);
   			$item->setPublishedAt($marker->getPublishedAt());
   			$item->save();
   		}
   	}
   	
   }
   static public function generateWebLink($id,$sectionId,$locale){
   	$marker=MarkerQuery::create()->findPk($id);
   	if(!$marker)
   		return "#";
   	$marker->setLocale($locale);
   	//$sectionLink=SectionHelper::generateWebLink($sectionId, $locale);
   	//return  $sectionLink."/".$id."/".$stripTitle;
   	$section=SectionQuery::create()->findPk($sectionId);
   	if($section == null) return "/";
   	$section->setLocale($locale);
 	return "/".$locale."/".$sectionId."/".$marker->getId()."/".$section->getStripTitle()."/".$marker->getStripTitle();
   }	
   static public function generateWebShortLink($id,$locale){
   	$marker=MarkerQuery::create()->findPk($id);
   	if(!$marker)
   		return "#";
   	$marker->setLocale($locale);
   	$stripTitle=$marker->getStripTitle();
   	$sectionLink=SectionHelper::generateWebLink($marker->getSectionId(), $locale);
   	return  $id."/".$stripTitle;
   }
   static public function reUpdateWebLink($locale){
   	$marker=MarkerQuery::create()->find();
   	foreach ($marker as $n){
   		if(!$n) return;
   		$n->setLocale($locale);
   		$n->setLink(self::generateWebLink($n->getId(), $n->getSectionId(), $locale));
		$n->setShortLink(self::generateWebShortLink($n->getId(), $locale));
   		$n->save();
   	}
   }
}