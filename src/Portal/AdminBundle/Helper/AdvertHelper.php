<?php
namespace Portal\AdminBundle\Helper;
use Common\DbBundle\Model\App;
use Common\DbBundle\Model\Advert;
use Common\DbBundle\Model\AdvertQuery;
use Common\DbBundle\Model\AdvertI18n;
use Common\DbBundle\Model\AdvertI18nQuery;
use Common\DbBundle\Model\Advertcache;
use Common\DbBundle\Model\AdvertcacheQuery;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;


class AdvertHelper{
	static public function getAdvert_Admin($id, $lang)
	{
		$advert = AdvertQuery::create()
		->joinWithI18n($lang,Criteria::INNER_JOIN)
		->addAnd('advert.ID',$id,Criteria::EQUAL)
		->findOne();
		if ($advert != null)
			$advert->setLocale($lang);
		return $advert;
	}
	static public function getAdvertWithPaging_Admin($page,$pagesize,$sectionId,$locale)
	{
		$c = new Criteria();
		$arr=array();
		$s_id=array();
		$s_id[]="$sectionId";
		$sectionType=1;
		SectionHelper::getSectionIdRecursive_Admin($arr, $sectionId, $locale,$sectionType);
		foreach ($arr as $sid){
			$s_id[]=$sid['ID'];
		}
		
		$crit1 = $c->getNewCriterion('advert.SECTION_ID',($s_id) ,Criteria::IN);
		/*
		$c = new Criteria();
		$crit1 = $c->getNewCriterion('advert.SECTION_ID, $sectionId);
		*/
		if ($sectionId != -1){
			$crit2 = $c->getNewCriterion('advert.SUBSECTION_IDS', '%,'.$sectionId.',%', Criteria::LIKE);
			$crit1->addOr($crit2);;
		}
		
		$midrange = 7;
		$itemsCount = 0;
		$listAdvert = array();
		
		$itemCountQuery = AdvertQuery::create()
			->addAnd(`advert_i18n`.`TRASH`,"(`advert_i18n`.`TRASH` is null or `advert_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
			->joinWithI18n($locale,Criteria::INNER_JOIN);

		$itemCountQuery->add($crit1);
			
		$itemsCount = $itemCountQuery->count();

		$listAdvertQuery=AdvertQuery::create()
			->addAnd(`advert_i18n`.`TRASH`,"(`advert_i18n`.`TRASH` is null or `advert_i18n`.`TRASH` <>true)",Criteria::CUSTOM)
			->joinWithI18n($locale,Criteria::INNER_JOIN);

		$listAdvertQuery->add($crit1);
		
		$listAdvert = $listAdvertQuery->offset(($page-1)*$pagesize)
			->limit($pagesize)
			->orderByCreatedAt('asc')
			->find();
	
		$paginator = new PaginatorHelper($itemsCount, $page , $pagesize, $midrange);
	
		return array('items' => $listAdvert, 'paginator' => $paginator);
			
	}
	static public function getAdvertWithPagingForCustomer_Admin($page,$pagesize,$customerId,$locale,$filterUser=false,$username=null)
	{
		//var_dump($locale);
		$advertQuery = AdvertQuery::create()
		->joinWithI18n($locale,Criteria::INNER_JOIN)
		->addAnd(`advert_i18n`.`TRASH`,"(`advert_i18n`.`TRASH` is null or `advert_i18n`.`TRASH` <>1)",Criteria::CUSTOM);
		
		if($customerId!=-1)
			$advertQuery->addAnd('advert.CUSTOMER_ID', $customerId);
		
		if($filterUser===true)
			$advertQuery->addAnd('advert_i18n.POST_BY',$username);
		
		$pager	=	$advertQuery->paginate($page, $pagesize);
		return $pager;
		/*
		$midrange = 7;
		$itemsCount = 0;
		$listAdvert = array();
	
		$itemCountQuery = AdvertQuery::create()
		->addAnd('advert_i18n.DELETED, true, Criteria::NOT_EQUAL)
		->joinWithI18n($locale);
		if($customerId!=-1)
			$itemCountQuery->addAnd('advert.CUSTOMER_ID, $customerId);
		$itemsCount = $itemCountQuery->count();
	
		$listAdvertQuery=AdvertQuery::create()
		->addAnd('advert_i18n.DELETED, true, Criteria::NOT_EQUAL)
		->joinWithI18n($locale);	
	
		if($customerId!=-1)
			$listAdvertQuery->addAnd('advert.CUSTOMER_ID, $customerId);
		
		$listAdvert = $listAdvertQuery->offset(($page-1)*$pagesize)
		->limit($pagesize)
		->orderByCreatedAt('asc')
		->find();
	
		$paginator = new PaginatorHelper($itemsCount, $page , $pagesize, $midrange);
	
		return array('items' => $listAdvert, 'paginator' => $paginator);
		*/
			
	}
	static public function add($lang, $title,$keywords, $tags, $imgs, $brief,$isAtHomePage, $isAtSection, $homeZone
							,$sectionZone, $publishDate,$expireDate, $sectionType,$sectionId
    						, $sectionIds, $advert_type,$sectionLinkType,$sectionLinkId,$link, $customer,$postBy
							, $rootDir)
   	{
	   	if($sectionLinkId==-1) $link="/";/*mean link to home page*/
	   	$hUrl=UtilsHelper::getHostUrl();
	   	$hUrl=str_replace("/", "\/", $hUrl);
	   	if (preg_match("/^(.*?)$hUrl(.*?)\?preview=true(.*?)$/", $link, $matches)){
	   		$link=$matches[2];
	   	}
	   	if (preg_match("/^(.*?)$hUrl(.*?)$/", $link, $matches)){
	   		$link=$matches[2];
	   	}
	   	if($sectionLinkId>0) $link=SectionHelper::generateWebLink($sectionLinkId, $lang);
   		
		$advert = new Advert();
		
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
		/*setImgSize*/
		$imgArr				= explode(",", $imgs);
		$imgs_size="";
		
		foreach ($imgArr as $img){
			$file=$rootDir."/../web/".$img;
			$size=getimagesize($file);
			$imgs_size.=$size[0]."x".$size[1].",";
		}
		$advert->setImgsSizes($imgs_size);
		
		$advert->setBrief($brief);
		$advert->setLocked(true);
		$advert->setBundleId($sectionType);
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
		
		$advert->setTrash(false);
		
		$advert->save();
		self::updateAdvertCache($advert->getId(),$lang,$sectionZone, $isAtSection, $sectionId,$sectionIds,$rootDir);
		return null;
   }
   
   static public function update($id,$lang, $title,$keywords, $tags, $imgs, $brief,$isAtHomePage, $isAtSection, $homeZone
							,$sectionZone, $publishDate,$expireDate, $sectionType,$sectionId
    						, $sectionIds, $advert_type,$sectionLinkType,$sectionLinkId,$link, $customer,$postBy
   							,$rootDir)
   {
	   	if($sectionLinkId==-1) $link="/";/*mean link to home page*/
	   	$hUrl=UtilsHelper::getHostUrl();
	   	$hUrl=str_replace("/", "\/", $hUrl);
	   	if (preg_match("/^(.*?)$hUrl(.*?)\?preview=true(.*?)$/", $link, $matches)){
	   		$link=$matches[2];
	   	}
	   	if (preg_match("/^(.*?)$hUrl(.*?)$/", $link, $matches)){
	   		$link=$matches[2];
	   	}
	   	if($sectionLinkId>0) $link=SectionHelper::generateWebLink($sectionLinkId, $lang);
	   	
	   	$advert=AdvertQuery::create()->findPk($id);

		if ($advert == null)
			return array("AdvertId=".$id." does not exists");
   	
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
		/*setImgSize*/
		$imgArr				= explode(",", $imgs);
		$imgs_size="";
		
		foreach ($imgArr as $img){
			//$file=$this->getRootDir()."/../web/".$img;
			$file=$rootDir."/../web/".$img;
			$size=getimagesize($file);
			$imgs_size.=$size[0]."x".$size[1].",";
		}
		$advert->setImgsSizes($imgs_size);
		
		$advert->setBrief($brief);
		$advert->setLocked(true);
		$advert->setBundleId($sectionType);
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
		$advert->setTrash(false);
   	
		$advert->save();
		self::updateAdvertCache($advert->getId(),$lang,$sectionZone, $isAtSection, $sectionId,$sectionIds,$rootDir);
		return null;
   }	
   static public function delete($id,$lang){
   
   
   	$result = array();
   	//check is have childs
   	
   
   	$advert = AdvertI18nQuery::create()
   	->addAnd('advert_i18n.ID', $id)
   	->addAnd('advert_i18n.LOCALE', $lang)
   	->findOne();
   
   	if ($advert == null)
   	{
   		array_push($result, "AdvertId=".$id." does not exists");
   		return $result;
   	}
   	
	$advert->setTrash(true);   
	$advert->save();
   	
   
   	return $result;
   }
   	
   
   static public function setPublish($lang,$id,$isPublish)
   {
   
   	$advert = AdvertQuery::create()->findPk($id);
   
   	if ($advert == null)
   		return array("AdvertId=".$id." does not exists");
  	
   	$advert->setLocale($lang);
   	$advert->setLocked($isPublish);
   	$advert->save();
   
   	return null;
   
   }	
   static public function togglePublish($lang,$id,$rootDir)
   {
   	 
   	$advert = AdvertQuery::create()->findPk($id);
   	 
   	if ($advert == null)
   		return array("AdvertId=".$id." does not exists");
   	 
   	$advert->setLocale($lang);
   	$advert->setLocked(!$advert->getLocked());
   	$advert->save();
   	
   	self::updateAdvertCache($advert->getId(),$lang,$advert->getSectionPosition(), $advert->getViewAtSection(), $advert->getSectionId(),$advert->getSubsectionIds(),$rootDir);
   	
   	return $advert->getLocked();
   	 
   }
   static public function setHeadline($id,$isHeadline)
   {
   	 
   	$advert = AdvertQuery::create()->findPk($id);
   	 
   	if ($advert == null)
   		return array("AdvertId=".$id." does not exists");
   	 
   	$advert->setFrontPage($isHeadline);
   	$advert->save();
   	 
   	return null;
   	 
   }	
   static public function toggleHeadline($locale,$id)
   {
   	 
   	$advert = AdvertQuery::create()->findPk($id);
   	 
   	if ($advert == null)
   		return array("AdvertId=".$id." does not exists");
   	 
   	/*$advert->setLocale($locale);*/
   	$advert->setFrontPage(!$advert->getFrontPage());
   	$advert->save();
   	 
   	return $advert->getFrontPage();
   	 
   }
   static public function setComment($id,$isComment)
   {
   	 
   	$advert = AdvertQuery::create()->findPk($id);
   	 
   	if ($advert == null)
   		return array("AdvertId=".$id." does not exists");
   	 $advert = new Advert();
   	
   	$advert->setHasComment($isComment);
   	$advert->save();
   	 
   	return null;
   	 
   }			
   static public function toggleComment($locale,$id)
   {
   	 
   	$advert = AdvertQuery::create()->findPk($id);
   	 
   	if ($advert == null)
   		return array("AdvertId=".$id." does not exists");
   	
   	/*$advert->setLocale($locale);*/
   	$advert->setHasComment(!$advert->getHasComment());
   	$advert->save();
   	 
   	return $advert->getHasComment();
   	 
   }
   static function updateAdvertCache($id,$locale,$sectionZone,$viewAtSection,$sectionId,$sectionIds,$rootDir){
   	if(!$viewAtSection){
   		$connection = Propel::getConnection();
		$query = "DELETE FROM %s WHERE %s=?";
		$query = sprintf($query,
				'advertcache',
				'advertcache.ADVERT_ID'
		);
		$stmt = $connection->prepare($query);
		$stmt->bindValue(1,$id,PDO::PARAM_INT);
		$stmt->execute();
		return;
   	}
   		
   	$sections	=	explode(",", $sectionIds);
   	
   	$advert = AdvertQuery::create()
   	->findPk($id);
   	if($advert)
   		$advert->setLocale($locale);
   	else
   		return;
   	/**
   	 Delete section does not exits in advert table
   	 */
   	$trashItems=AdvertcacheQuery::create()
   	->findByAdvertId($id);
   	foreach ($trashItems as $trash){
   		if(in_array($trash->getSectionId(),$sections) ==false ){
   			$trash->delete();
   		}
   	}

   	$item = AdvertcacheQuery::create()
   	->findPk(array($sectionId,$id,$locale));
   	if($item){
	   	$item->setSectionId($sectionId);
   		$item->setAdvertId($id);
   		$item->setLocale($locale);
   		$item->setSectionPosition($advert->getSectionPosition());
   		$item->setLink($advert->getLink());
   		$item->setLinkTo($advert->getLinkTo());
   		$item->setTitle($advert->getTitle());
   		$item->setBrief($advert->getBrief());
   		$item->setImgs($advert->getImgs());
   		/*setImgSize*/
   		$imgArr				= explode(",", $advert->getImgs());
   		$imgs_size="";
   		
   		foreach ($imgArr as $img){
   			$file=$rootDir."/../web/".$img;
   			$size=getimagesize($file);
   			$imgs_size.=$size[0]."x".$size[1].",";
   		}
   		$item->setImgsSizes($imgs_size);
   		
   		$item->setLocked($advert->getLocked());
   		$item->setPublishedAt($advert->getPublishedAt());
   		$item->setExpiredAt($advert->getExpiredAt());
   		$item->save();
   	}
   	else{
   		if($sectionId!=-1){
	   		$item=new Advertcache();
	   		$item->setSectionId($sectionId);
	   		$item->setAdvertId($id);
	   		$item->setLocale($locale);
	   		$item->setSectionPosition($advert->getSectionPosition());
	   		$item->setLink($advert->getLink());
	   		$item->setLinkTo($advert->getLinkTo());
	   		$item->setTitle($advert->getTitle());
	   		$item->setBrief($advert->getBrief());
	   		$item->setImgs($advert->getImgs());
	   		/*setImgSize*/
	   		$imgArr				= explode(",", $advert->getImgs());
	   		$imgs_size="";
	   		
	   		foreach ($imgArr as $img){
	   			$file=$rootDir."/../web/".$img;
	   			$size=getimagesize($file);
	   			$imgs_size.=$size[0]."x".$size[1].",";
	   		}
	   		$item->setImgsSizes($imgs_size);
	   		
	   		$item->setLocked($advert->getLocked());
	   		$item->setPublishedAt($advert->getPublishedAt());
	   		$item->setExpiredAt($advert->getExpiredAt());
	   		$item->save();
   		}
   	}
   
   	for ($i = 0; $i< count($sections); $i++){
   		$order=NULL;
   		$sectionId=$sections[$i];
   		if($sectionId==0) continue;
   		 
   		$item = AdvertcacheQuery::create()
   		->findPk(array($sectionId,$id,$locale));
   		 
   		if($item){
   			$item->setSectionId($sectionId);
	   		$item->setAdvertId($id);
	   		$item->setLocale($locale);
	   		$item->setSectionPosition($advert->getSectionPosition());
	   		$item->setLink($advert->getLink());
   			$item->setLinkTo($advert->getLinkTo());
   			$item->setTitle($advert->getTitle());
   			$item->setBrief($advert->getBrief());
   			$item->setImgs($advert->getImgs());
   			/*setImgSize*/
   			$imgArr				= explode(",", $advert->getImgs());
   			$imgs_size="";
   			
   			foreach ($imgArr as $img){
   				$file=$rootDir."/../web/".$img;
   				$size=getimagesize($file);
   				$imgs_size.=$size[0]."x".$size[1].",";
   			}
   			$item->setImgsSizes($imgs_size);
   			
	   		$item->setLocked($advert->getLocked());
	   		$item->setPublishedAt($advert->getPublishedAt());
	   		$item->setExpiredAt($advert->getExpiredAt());
   			$item->save();
   		}
   		else{
   			$item=new Advertcache();
   			$item->setSectionId($sectionId);
	   		$item->setAdvertId($id);
	   		$item->setLocale($locale);
	   		$item->setSectionPosition($advert->getSectionPosition());
	   		$item->setLink($advert->getLink());
   			$item->setLinkTo($advert->getLinkTo());
   			$item->setTitle($advert->getTitle());
   			$item->setBrief($advert->getBrief());
   			$item->setImgs($advert->getImgs());
   			/*setImgSize*/
   			$imgArr				= explode(",", $advert->getImgs());
   			$imgs_size="";
   			
   			foreach ($imgArr as $img){
   				$file=$rootDir."/../web/".$img;
   				$size=getimagesize($file);
   				$imgs_size.=$size[0]."x".$size[1].",";
   			}
   			$item->setImgsSizes($imgs_size);
   			
	   		$item->setLocked($advert->getLocked());
	   		$item->setPublishedAt($advert->getPublishedAt());
	   		$item->setExpiredAt($advert->getExpiredAt());
   			$item->save();
   		}
   	}
   }	
}