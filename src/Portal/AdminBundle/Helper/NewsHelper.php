<?php
namespace Portal\AdminBundle\Helper;
use Common\DbBundle\Model\App;
use Common\DbBundle\Model\News;
use Common\DbBundle\Model\NewsQuery;
use Common\DbBundle\Model\NewsI18n;
use Common\DbBundle\Model\NewsI18nQuery;

use Common\DbBundle\Model\Section;
use Common\DbBundle\Model\SectionQuery;
use Common\DbBundle\Model\SectionI18n;
use Common\DbBundle\Model\SectionI18nQuery;

use Common\DbBundle\Model\Sectioncache;
use Common\DbBundle\Model\SectioncacheQuery;
use Common\DbBundle\Model\Logs as Logs;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;

class NewsHelper{
	static public function getNews_Admin($id, $lang)
	{
		$news = NewsQuery::create()
		->joinWithI18n($lang,Criteria::INNER_JOIN)
		->addAnd('news.ID',$id,Criteria::EQUAL)
		->findOne();
		if ($news != null)
			$news->setLocale($lang);
			return $news;
	}
	static public function getRelativeNews_Admin($id,$locale){
		$news = NewsQuery::create()
		->joinWithI18n($locale,Criteria::INNER_JOIN)
		->findPk($id);
		if ($news == null) return null;
		$ids=explode(",", $news->getRelativeNews());

		$relativesNews = NewsQuery::create()
		->addAnd('news.ID',($ids),Criteria::IN)
		->joinWithI18n($locale)
		->find();
		return $relativesNews;

	}
	static public function getNewsWithPaging_Admin($page,$pagesize,$sectionId,$locale,$status =null,$onlyDraft=false,$filterUser=false,$username=null)
	{
		$c = new Criteria();
		$arr=array();
		$s_id=array();
		$s_id[]="$sectionId";
		$sectionType=1;
		SectionHelper::getSectionIdRecursive_Admin($arr, $sectionId, $locale,$sectionType);
		//if(count($arr)==0) return null;
		foreach ($arr as $sid){
			$s_id[]=$sid['ID'];
		}

		$crit1 = $c->getNewCriterion('news.SECTION_ID',($s_id) ,Criteria::IN);
		//$c->getNewCriterion('news.SECTION_ID, $sectionId);

		if ($sectionId != -1){
			$crit2 = $c->getNewCriterion('news.SUBSECTION_IDS', '%,'.$sectionId.',%', Criteria::LIKE);
			$crit1->addOr($crit2);
		}

		$newsQuery=NewsQuery::create()
		->addAnd($crit1)
		//->addAnd('news_i18n.DELETED', true, Criteria::NOT_EQUAL)
		->addAnd(`news_i18n`.`TRASH`,"(`news_i18n`.`TRASH` is null or `news_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
		->joinWithI18n($locale,Criteria::INNER_JOIN);

		if($status!==null){
			$newsQuery->addAnd('news_i18n.STATUS',($status) ,Criteria::IN);
		}
		if($onlyDraft===true)
			$newsQuery->addAnd('news_i18n.DRAFT',true);

			if($filterUser===true)
				$newsQuery->addAnd('news_i18n.POST_BY',$username);

				$pager	=	$newsQuery->paginate($page, $pagesize);

				return $pager;
	}
	static public function getNewsWithPagingandFilter_Admin($page,$pagesize,$sectionId,$locale,$txtSearch="",$status =null,$onlyDraft=false,$filterUser=false,$username=null)
	{
		$c = new Criteria();
		$arr=array();
		$s_id=array();
		$s_id[]="$sectionId";
		$sectionType=1;
		SectionHelper::getSectionIdRecursive_Admin($arr, $sectionId, $locale,$sectionType);
		//if(count($arr)==0) return null;
		foreach ($arr as $sid){
			$s_id[]=$sid['id'];
		}

		$crit1 = $c->getNewCriterion('news.SECTION_ID',($s_id) ,Criteria::IN);
		//$c->getNewCriterion('news.SECTION_ID', $sectionId);

		if ($sectionId != -1){
			$crit2 = $c->getNewCriterion('news.SUBSECTION_IDS', '%,'.$sectionId.',%', Criteria::LIKE);
			$crit1->addOr($crit2);
		}

		$newsQuery=NewsQuery::create()
		->addAnd($crit1)
		//->addAnd('news_i18n.DELETED', true, Criteria::NOT_EQUAL)
		->addAnd(`news_i18n`.`TRASH`,"(`news_i18n`.`TRASH` is null or `news_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
		->joinWithI18n($locale,Criteria::INNER_JOIN);

		if($status!==null){
			$newsQuery->addAnd('news_i18n.STATUS',($status) ,Criteria::IN);
		}
		if($txtSearch!=""){
			$newsQuery->addAnd('news_i18n.TITLE',"%$txtSearch%" ,Criteria::LIKE);
		}
		if($onlyDraft===true)
			$newsQuery->addAnd('news_i18n.DRAFT',true);

			if($filterUser===true)
				$newsQuery->addAnd('news_i18n.POST_BY',$username);

				$pager	=	$newsQuery->paginate($page, $pagesize);

				return $pager;


	}
	static public function getNewsForApproveWithPaging_Admin($page,$pagesize,$sectionId,$locale,$status =null)
	{
		$c = new Criteria();

		$arr=array();
		$s_id=array();
		$s_id[]="$sectionId";
		$sectionType=1;
		SectionHelper::getSectionIdRecursive_Admin($arr, $sectionId, $locale,$sectionType);
		//if(count($arr)==0) return null;
		foreach ($arr as $sid){
			$s_id[]=$sid['id'];
		}

		$crit1 = $c->getNewCriterion('news.SECTION_ID',($s_id) ,Criteria::IN);
		//$c->getNewCriterion('news.SECTION_ID, $sectionId);

		if ($sectionId != -1){
			$crit2 = $c->getNewCriterion('news.SUBSECTION_IDS', '%,'.$sectionId.',%', Criteria::LIKE);
			$crit1->addOr($crit2);
		}
		$midrange = 7;
		$itemsCount = 0;
		$listNews = array();

		$itemCountQuery = NewsQuery::create()
		->addAnd(`news_i18n`.`TRASH`,"(`news_i18n`.`TRASH` is null or `news_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
		->addAnd(`news_i18n`.`DRAFT`,"(`news_i18n`.`DRAFT` is null or `news_i18n`.`DRAFT` <>true)",Criteria::CUSTOM)
		//->addAnd('news_i18n.DELETED', true, Criteria::NOT_EQUAL)
		//->addAnd('news_i18n.DRAFT', true, Criteria::NOT_EQUAL)
		->joinWithI18n($locale,Criteria::INNER_JOIN);

		$itemCountQuery->addAnd($crit1);

		if($status!=null)
			$itemCountQuery->addAnd('news_i18n.STATUS',($status) ,Criteria::IN);

			/*if ($sectionId != -1)
			 {
			 $itemCountQuery->addAnd($crit1);
			 //$itemCountQuery->addAnd('news.SECTION_ID',$sectionId);
			 //$itemCountQuery->addOr('news.SUBSECTION_IDS', "%,".$sectionId.",%", Criteria::LIKE);

			 }
			 */
			$itemsCount = $itemCountQuery->count();

			$listNewsQuery=NewsQuery::create()
			->addAnd(`news_i18n`.`TRASH`,"(`news_i18n`.`TRASH` is null or `news_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
			->addAnd(`news_i18n`.`DRAFT`,"(`news_i18n`.`DRAFT` is null or `news_i18n`.`DRAFT` <>true)",Criteria::CUSTOM)
			//->addAnd('news_i18n.DELETED', true, Criteria::NOT_EQUAL)
			//->addAnd('news_i18n.DRAFT', true, Criteria::NOT_EQUAL)
			->joinWithI18n($locale,Criteria::INNER_JOIN);

			$listNewsQuery->addAnd($crit1);

			if($status!=null)
				$listNewsQuery->addAnd('news_i18n.STATUS',($status) ,Criteria::IN);

				/*
				 if ($sectionId != -1)
				 {
				 $listNewsQuery->addAnd($crit1);
				 //$listNewsQuery->addAnd('news.SECTION_ID,$sectionId);
				 //$listNewsQuery->addOr('news.SUBSECTION_IDS, "%,".$sectionId.",%", Criteria::LIKE);
				 	
				 }
				 */
				$listNews = $listNewsQuery->offset(($page-1)*$pagesize)
				->limit($pagesize)
				->orderByUpdatedAt('desc')
				->orderByCreatedAt('desc')
				->find();

				$paginator = new PaginatorHelper($itemsCount, $page , $pagesize, $midrange);

				return array('items' => $listNews, 'paginator' => $paginator);
					
	}
	static public function getNewsForApproveWithPagingAndFilter_Admin($page,$pagesize,$sectionId,$locale,$txtSearch,$status =null)
	{
		$c = new Criteria();

		$arr=array();
		$s_id=array();
		$s_id[]="$sectionId";
		$sectionType=1;
		SectionHelper::getSectionIdRecursive_Admin($arr, $sectionId, $locale,$sectionType);
		//if(count($arr)==0) return null;
		foreach ($arr as $sid){
			$s_id[]=$sid['id'];
		}

		$crit1 = $c->getNewCriterion('news.SECTION_ID',($s_id) ,Criteria::IN);
		//$c->getNewCriterion('news.SECTION_ID, $sectionId);
		if($txtSearch!=""){
			$crit3 = $c->getNewCriterion('news_i18n.TITLE',"%$txtSearch%" ,Criteria::LIKE);
			$crit1->addAnd($crit3);
		}
		if ($sectionId != -1){
			$crit2 = $c->getNewCriterion('news.SUBSECTION_IDS', '%,'.$sectionId.',%', Criteria::LIKE);
			$crit1->addOr($crit2);
		}

		$midrange = 7;
		$itemsCount = 0;
		$listNews = array();

		$itemCountQuery = NewsQuery::create()
		->addAnd(`news_i18n`.`TRASH`,"(`news_i18n`.`TRASH` is null or `news_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
		->addAnd(`news_i18n`.`DRAFT`,"(`news_i18n`.`DRAFT` is null or `news_i18n`.`DRAFT` <>true)",Criteria::CUSTOM)
		//->addAnd('news_i18n.DELETED', true, Criteria::NOT_EQUAL)
		//->addAnd('news_i18n.DRAFT', true, Criteria::NOT_EQUAL)
		->joinWithI18n($locale,Criteria::INNER_JOIN);

		$itemCountQuery->addAnd($crit1);

		if($status!=null)
			$itemCountQuery->addAnd('news_i18n.STATUS',($status) ,Criteria::IN);

			/*if ($sectionId != -1)
			 {
			 $itemCountQuery->addAnd($crit1);
			 //$itemCountQuery->addAnd('news.SECTION_ID,$sectionId);
			 //$itemCountQuery->addOr('news.SUBSECTION_IDS, "%,".$sectionId.",%", Criteria::LIKE);

			 }
			 */
			$itemsCount = $itemCountQuery->count();

			$listNewsQuery=NewsQuery::create()
			->addAnd(`news_i18n`.`TRASH`,"(`news_i18n`.`TRASH` is null or `news_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
			->addAnd(`news_i18n`.`DRAFT`,"(`news_i18n`.`DRAFT` is null or `news_i18n`.`DRAFT` <>true)",Criteria::CUSTOM)
			//->addAnd('news_i18n.DELETED', true, Criteria::NOT_EQUAL)
			//->addAnd('news_i18n.DRAFT', true, Criteria::NOT_EQUAL)
			->joinWithI18n($locale,Criteria::INNER_JOIN);

			$listNewsQuery->addAnd($crit1);

			if($status!=null)
				$listNewsQuery->addAnd('news_i18n.STATUS',($status) ,Criteria::IN);

				/*
				 if ($sectionId != -1)
				 {
				 $listNewsQuery->addAnd($crit1);
				 //$listNewsQuery->addAnd('news.SECTION_ID,$sectionId);
				 //$listNewsQuery->addOr('news.SUBSECTION_IDS, "%,".$sectionId.",%", Criteria::LIKE);
				 	
				 }
				 */
				$listNews = $listNewsQuery->offset(($page-1)*$pagesize)
				->limit($pagesize)
				->orderByUpdatedAt('desc')
				->orderByCreatedAt('desc')
				->find();

				$paginator = new PaginatorHelper($itemsCount, $page , $pagesize, $midrange);

				return array('items' => $listNews, 'paginator' => $paginator);
					
	}
	static public function add($lang, $title, $keywords, $tags, $relativeNews,$imgs, $brief
			, $content, $isHeadline, $isPublish, $isComment
			, $publishDate, $sectionId, $order, $sectionIds, $orderIds,$draft,$postBy)
	{
		$news = new News();

		$news->setLocale($lang);
		$news->setTitle($title);
		$news->setStripTitle(UtilsHelper::utf8_to_ascii($title));
		$news->setKeyword($keywords);
		$news->setTag($tags);
		$news->setImgs($imgs);
		$brief=str_replace("autostart=true", "autostart=false", $brief);
		$news->setBrief($brief);
		$news->setContent($content);
		$news->setFrontPage($isHeadline);
		/*$news->setLocked($isPublish);*/
		$news->setHasComment($isComment);
		$news->setSectionId($sectionId);
		$news->setOrders($order);
		$news->setSubsectionIds($sectionIds);
		$news->setSuborderIds($orderIds);
		$news->setPublishedAt($publishDate);
		$news->setRelativeNews($relativeNews);
		$news->setDraft($draft);
		$news->setPostBy($postBy);
		$news->setTrash(false);

		$news->setLocked(true);
		if($draft)
			$news->setStatus("draft");
			else
				$news->setStatus("submit");

				$news->setPreStatus("initial");

				$news->save();
				$news->setLink(self::generateWebLink($news->getId(), $sectionId, $lang));
				$news->setShortLink(self::generateWebShortLink($news->getId(), $lang));
				$news->save();
				self::updateSectionCache($news->getId(),$lang,$sectionId,$order, $sectionIds, $orderIds);
				return null;
	}
	 
	static public function update($id, $lang, $title, $keywords, $tags, $relativeNews,$imgs, $brief
			, $content, $isHeadline, $isPublish, $isComment
			, $publishDate,$sectionId, $order,  $sectionIds, $orderIds,$draft,$editBy)
	{
		 
		$news=NewsQuery::create()->findPk($id);

		/* Write log */
		if(( $news->getTitle() != $title) || ($news->getContent() != $content) ){
			$log=new Logs();
			$log->setOld($news->getTitle() ."/". $news->getContent());
			$log->setCurrent($title ."/". $content);
			$log->setTable("NEWS");
			$log->setEditBy($editBy);
			$log->save();
		}
		if ($news == null)
			return array("NewsId=".$id." does not exists");

			$news->setLocale($lang);
			$news->setTitle($title);
			$news->setStripTitle(UtilsHelper::utf8_to_ascii($title));
			$news->setLink(self::generateWebLink($id, $sectionId, $lang));
			$news->setShortLink(self::generateWebShortLink($id, $lang));
			$news->setKeyword($keywords);
			$news->setTag($tags);
			$news->setImgs($imgs);
			$brief=str_replace("autostart=true", "autostart=false", $brief);
			$news->setBrief($brief);
			$news->setContent($content);
			$news->setFrontPage($isHeadline);
			/*$news->setLocked($isPublish);*/
			$news->setHasComment($isComment);
			$news->setSectionId($sectionId);
			$news->setOrders($order);
			$news->setSubsectionIds($sectionIds);
			$news->setSuborderIds($orderIds);
			$news->setRelativeNews($relativeNews);
			$news->setPublishedAt($publishDate);
			$news->setDraft($draft);
			$news->setEditBy($editBy);
			/*$news->setTrash(0);*/

			$news->setLocked(true);

			if($draft){
				if($news->getStatus()!=="draft"){
					$news->setPreStatus($news->getStatus());
				}
				$news->setStatus("draft");
			}
			else{
				if($news->getStatus()!=="submit"){
					$news->setPreStatus($news->getStatus());
				}
				$news->setStatus("submit");
			}

			$news->save();
			self::updateSectionCache($id,$lang,$sectionId,$order, $sectionIds, $orderIds);
			return null;
	}
	static public function delete($id,$lang){
		$result = array();
		 
		$news = NewsI18nQuery::create()
		->addAnd('news_i18n.ID', $id)
		->addAnd('news_i18n.LOCALE', $lang)
		->findOne();
		 
		if ($news == null)
		{
			array_push($result, "NewsId=".$id." does not exists");
			return $result;
		}

		$news->setTrash(true);
		$news->save();

		self::flushSectionCache($news->getId(),$news->getLocale());
		 
		return $result;
	}
	static public function setPublish($lang,$id,$isPublish)
	{
		 
		$news = NewsQuery::create()->findPk($id);
		 
		if ($news == null)
			return array("NewsId=".$id." does not exists");
			 
			$news->setLocale($lang);
			$news->setLocked($isPublish);
			$news->save();
			 
			return null;
			 
	}
	static public function togglePublish($lang,$id)
	{
		 
		$news = NewsQuery::create()->findPk($id);
		 
		if ($news == null)
			return array("NewsId=".$id." does not exists");
			 
			$news->setLocale($lang);
			if($news->getLocked()==true){
				if($news->getStatus()!="approved")
					$news->setPreStatus($news->getStatus());
					$news->setStatus("approved");
			}
			else{
				if($news->getStatus()!="waiting approved")
					$news->setPreStatus($news->getStatus());
					$news->setStatus("waiting approved");
			}
			$news->setLocked(!$news->getLocked());
			$news->save();

			self::updateSectionCache($news->getId(), $news->getLocale(), $news->getSectionId(), $news->getOrders(), $news->getSubsectionIds(), $news->getSuborderIds());

			return $news->getLocked();
			 
	}
	static public function setHeadline($id,$isHeadline)
	{
		 
		$news = NewsQuery::create()->findPk($id);
		 
		if ($news == null)
			return array("NewsId=".$id." does not exists");
			 
			$news->setFrontPage($isHeadline);
			$news->save();
			 
			return null;
			 
	}
	static public function toggleHeadline($locale,$id)
	{
		 
		$news = NewsQuery::create()->findPk($id);
		 
		if ($news == null)
			return array("NewsId=".$id." does not exists");
			 
			/*$news->setLocale($locale);*/
			$news->setFrontPage(!$news->getFrontPage());
			$news->save();
			 
			self::updateSectionCache($news->getId(), $news->getLocale(), $news->getSectionId(), $news->getOrders(), $news->getSubsectionIds(), $news->getSuborderIds());

			return $news->getFrontPage();
			 
	}
	static public function setComment($id,$isComment)
	{
		 
		$news = NewsQuery::create()->findPk($id);
		 
		if ($news == null)
			return array("NewsId=".$id." does not exists");
			$news = new News();

			$news->setHasComment($isComment);
			$news->save();
			 
			return null;
			 
	}
	static public function toggleComment($locale,$id)
	{
		 
		$news = NewsQuery::create()->findPk($id);
		 
		if ($news == null)
			return array("NewsId=".$id." does not exists");

			/*$news->setLocale($locale);*/
			$news->setHasComment(!$news->getHasComment());
			$news->save();
			 
			return $news->getHasComment();
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
		$news = NewsQuery::create()
		->findPk($id);
		if($news)
			$news->setLocale($locale);
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
					$item->setLocked($news->getLocked());
					$item->setFrontPage($news->getFrontPage());
					$item->setOrders($order);
					$item->setPublishedAt($news->getPublishedAt());
					$item->save();
				}
				else{
					$item=new Sectioncache();
					$item->setSectionId($sectionId);
					$item->setNewsId($id);
					$item->setLocale($locale);
					$item->setLink(self::generateWebLink($id, $sectionId, $locale));
					$item->setLocked($news->getLocked());
					$item->setFrontPage($news->getFrontPage());
					$item->setOrders($order);
					$item->setPublishedAt($news->getPublishedAt());
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
							$item->setLocked($news->getLocked());
							$item->setFrontPage($news->getFrontPage());
							$item->setPublishedAt($news->getPublishedAt());
							$item->save();
						}
						else{
							$item=new Sectioncache();
							$item->setSectionId($sectionId);
							$item->setNewsId($id);
							$item->setLocale($locale);
							$item->setLink(self::generateWebLink($id, $sectionId, $locale));
							$item->setLocked($news->getLocked());
							$item->setFrontPage($news->getFrontPage());
							$item->setOrders($order);
							$item->setPublishedAt($news->getPublishedAt());
							$item->save();
						}
				}

	}
	static public function generateWebLink($id,$sectionId,$locale){
		$news=NewsQuery::create()
		->joinWithI18n($locale,Criteria::INNER_JOIN)
		->findPk($id);
		if(!$news)
			return "#";
			//$sectionLink=SectionHelper::generateWebLink($sectionId, $locale);
			//return  $sectionLink."/".$id."/".$stripTitle;
			if($sectionId==-1){
				$sectionId=$news->getSectionId();
			}
			$section=SectionQuery::create()
			->joinWithI18n($locale,Criteria::INNER_JOIN)
			->findPk($sectionId);
			if($section == null) return "/";

			return "/".$locale."/".$sectionId."/".$news->getId()."/".$section->getStripTitle()."/".$news->getStripTitle();
	}
	static public function generateWebShortLink($id,$locale){
		$news=NewsQuery::create()->findPk($id);
		if(!$news)
			return "#";
			$news->setLocale($locale);
			$stripTitle=$news->getStripTitle();
			$sectionLink=SectionHelper::generateWebLink($news->getSectionId(), $locale);
			return  $id."/".$stripTitle;
	}
	static public function reUpdateWebLink($locale){
		$news=NewsQuery::create()->find();
		foreach ($news as $n){
			if(!$n) return;
			$n->setLocale($locale);
			$n->setLink(self::generateWebLink($n->getId(), $n->getSectionId(), $locale));
			$n->setShortLink(self::generateWebShortLink($n->getId(), $locale));
			$n->save();
		}
	}
}