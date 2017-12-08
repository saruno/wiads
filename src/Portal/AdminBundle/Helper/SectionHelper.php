<?php
namespace Portal\AdminBundle\Helper;
use Common\DbBundle\Model\App;
use Common\DbBundle\Model\Section;
use Common\DbBundle\Model\SectionQuery;
use Common\DbBundle\Model\SectionI18n;
use Common\DbBundle\Model\SectionI18nQuery;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;

class SectionHelper
{
    static public function getAllSection_Admin(&$arr,$locale,$sectionType=-1,$useException=false,$exceptionId=-1)
    {
        //self::getSectionWithRootId_Admin($arr,-1,$locale,$sectionType,$useException,$exceptionId);
        $arr=array();
        $s_id=array();
        $s_id[]="-1";
        self::getSectionIdRecursive_Admin($arr, -1, $locale,$sectionType,$useException,$exceptionId);
        //if(count($arr)==0) return null;
        foreach ($arr as $sid){
            $s_id[]=$sid['id'];
        }
//var_dump($sectionType);
        $query=SectionQuery::create()
            ->joinWithI18n($locale,Criteria::INNER_JOIN)
            ->filterById($s_id)
            ->filterByBundleId($sectionType);
            //->addAnd(section.id,($s_id) ,Criteria::IN)
            //->addAnd(section.BUNDLE_ID, $sectionType,Criteria::EQUAL);
        if(count($s_id>0))
            $query->addAscendingOrderByColumn("FIELD( "."section.id".", ".implode(',',$s_id).")");

        $sections=$query->find();

        $arr=$sections;
    }
    static private function getSectionWithRootId_Admin(&$arr,$id,$locale,$sectionType=-1)
    {
        self::getPathRecursive_Admin($arr,$id,$locale,$sectionType);

    }
    static private function getPathRecursive_Admin(&$arr,$pid,$locale,$sectionType=-1){
        static $order_=0;
        $connection = Propel::getConnection();

        $query = "SELECT %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s FROM %s,%s 
        		WHERE %s=%s AND %s=? AND %s=? AND %s=? ORDER BY %s";
        $query = sprintf($query,
            "section.id",
            "section.deep",
            "section.parent",
            "section.bundle_id",
            "section.ORDERS",
            "section_i18n.title",
            "section.locked",
            "section_18n.strip_title",
            "section_i18n.locale",
            "section.CREATED_AT",
            "section.EDITED_AT",


            "section",
            "section_i18n",

            "section.id",
            "section_i18n.id",

            "section_i18n.locale",

            "section.PARENT",

            "section.BUNDLE_ID",

            "section.ORDERS"
        //Section::ID

        );

        //$query = "SELECT ?,?,?,?,?,?,?,? FROM ?,? WHERE ?=? AND ?=? AND ?=? AND ?=? ORDER BY ?";
        $stmt = $connection->prepare($query);


        $stmt->bindValue(1,$locale);
        $stmt->bindValue(2,$pid,PDO::PARAM_INT);
        $stmt->bindValue(3,$sectionType,PDO::PARAM_INT);

        $stmt->execute();
        while($row = $stmt->fetch()) {
            $pid_=$row['id'];
            $arr[$order_++]=array('id'=>$row['id'],'parent'=>$row['parent'],'locked'=>$row['locked'],'bundle_id'=>$row['bundle_id'],'title'=>$row['title'],'locale'=>$row['locale'],'deep'=>$row['deep'],'stripTitle'=>$row['strip_title'],'orders'=>$row['orders'],'created_at'=>$row['created_at'],'edited_at'=>$row['edited_at']);
            if($pid_>-20){
                self::getPathRecursive_Admin($arr,$pid_,$locale,$sectionType);
            }
        }
    }
    static public function getSectionWithPaging_Admin($page,$pagesize,$sectionId,$locale,$sectionType=-1)
    {
        $arr=array();
        $s_id=array();
        $s_id[]="$sectionId";
        self::getSectionIdRecursive_Admin($arr, $sectionId, $locale,$sectionType);
        //if(count($arr)==0) return null;
        foreach ($arr as $sid){
            $s_id[]=$sid['id'];
        }

        $midrange = 2;

        $itemsCount=$sections=SectionQuery::create()
            ->joinWithI18n($locale,Criteria::INNER_JOIN)
            ->filterById($s_id)
            ->filterByBundleId($sectionType)
            //->addAnd(section.ID,($s_id) ,Criteria::IN)
            //->addAnd(section.BUNDLE_ID, $sectionType,Criteria::EQUAL)
            ->count();

        $query=SectionQuery::create()
            ->joinWithI18n($locale,Criteria::INNER_JOIN)
            ->filterById($s_id)
            ->filterByBundleId($sectionType)
            //->addAnd(section::ID,($s_id) ,Criteria::IN)
            //->addAnd(section::BUNDLE_ID, $sectionType,Criteria::EQUAL)
            ->offset(($page-1)*$pagesize)
            ->limit($pagesize);
        if(count($s_id>0))
            $query->addAscendingOrderByColumn("FIELD( "."section.ID".", ".implode(',',$s_id).")");

        $sections=$query->find();

        $paginator = new PaginatorHelper($itemsCount, $page , $pagesize, $midrange);

        return array('items' => $sections, 'paginator' => $paginator);
    }
    static public function getSectionIdRecursive_Admin(&$arr,$pid,$locale,$sectionType=-1, $useException=false,$exceptionId=-1){
        static $order_=0;
        $connection = Propel::getConnection();

        $query = "SELECT %s FROM %s,%s WHERE %s=%s AND %s=? AND %s=? AND %s=? ORDER BY %s";
        $query = sprintf($query,
            "section.id",

            "section",
            "section_i18n",

            "section.id",
            "section_i18n.id",

            "section_i18n.LOCALE",


            "section.PARENT",

            "section.BUNDLE_ID",

            "section.ORDERS"

        );
        $statement = $connection->prepare($query);
        $statement->bindValue(1,$locale);
        $statement->bindValue(2,$pid,PDO::PARAM_INT);
        $statement->bindValue(3,$sectionType,PDO::PARAM_INT);
        $statement->execute();
        $pid_=-20;
        while($row = $statement->fetch()) {
            $pid_=$row['id'];
            if ($useException && ($pid_ == $exceptionId)) continue;
            $arr[$order_++]=array('id'=>$row['id']);
            if($pid_>-20){
                self::getSectionIdRecursive_Admin($arr,$pid_,$locale,$sectionType,$useException,$exceptionId);
            }
        }

    }
    static public function getSections_OrderByDeep($s_ids,$order="DESC")
    {

        $sections 	= array();
        if (strtoupper($order)=="DESC")
            $sections = SectionQuery::create()
                ->addDescendingOrderByColumn("section.DEEP")
                ->findPks(explode(",", $s_ids));
        else
            $sections = SectionQuery::create()
                ->addDescendingOrderByColumn("section.DEEP")
                ->findPks(explode(",", $s_ids));

        return $sections;
    }
    static public function save($sectionType,$lang,$parentId,$title,$publish,$description)
    {
    	$s=new Section();
    	
    	$s->setBundleId($sectionType);
    	$s->setLocale($lang);
    	$s->setParent($parentId);
    	$s->setDeep(self::calculateDeep($parentId));
    	$s->setTitle($title);
    	$s->setStripTitle(UtilsHelper::utf8_to_ascii($title));
    	$s->setOrders(self::getNextIndex($parentId));
    	$s->setLocked($publish);
    	$s->setBrief($description);
    	//$s->setCreatedAt(date("Y-m-d H:i:s"));
    	//if ($s->validate()){
    		$s->save();
    		$s->setLink(self::generateWebLink($s->getId(), $lang));
    		$s->save();
    	//	return null;
    	//} else {
    	//	return UtilsHelper::extractFieldOnly($s->getValidationFailures());
    	
    	//}
        //return null;
    }
    static public function update($id,$sectionType,$lang,$parentId,$title,$order,$publish,$description)
    {
        $s=SectionQuery::create()->findPk($id);

        if ($s == null)
            return array("SectionId=".$id." does not exists");

        $oldParentId = $s->getParent();
        $oldOrder	 = $s->getOrders();

        $s->setBundleId($sectionType);
        $s->setLocale($lang);
        $s->setParent($parentId);
        $s->setDeep(self::calculateDeep($parentId));
        $s->setTitle($title);
        $s->setStripTitle(UtilsHelper::utf8_to_ascii($title));

        $s->setLink(self::generateWebLink($id, $lang));

        if ($oldParentId != $parentId)
        {

            $s->setOrders(self::getNextIndex($parentId));
        }

        $s->setLocked($publish);
        $s->setBrief($description);
        //$s->setEditedAt(date("Y-m-d H:i:s"));
        
        //if ($s->validate()){
        $s->save();
        return null;
        //} else {
        //    return UtilsHelper::extractFieldOnly($s->getValidationFailures());
        //}
    }
    /**
     *
     * @param Int $parentId
     */
    static private function calculateDeep($parentId)
    {
        $deep  = 1;

        $s=SectionQuery::create()->findPk($parentId);
        if ($s != null)
            $deep = $s->getDeep() + 1;

        return $deep;

    }

    /**
     *
     * @param Int $id
     * @param String $lang
     */
    static public function getSection_Admin($id, $lang)
    {
        $s = SectionQuery::create()
            ->joinWithI18n($lang,Criteria::INNER_JOIN)
            ->addAnd("section.ID",$id,Criteria::EQUAL)
            ->findOne();
        if ($s != null)
            $s->setLocale($lang);
        return $s;

    }
    /**
     *
     * @param Int $id
     * @param String $lang
     */
    static public function delete($id,$lang){


        $result = array();
        //check is have childs
        $isValid = true;
        /*
        $s = SectionQuery::create()
        ->joinWithI18n($lang,Criteria::INNER_JOIN)
        ->addAnd(SectionPeer::ID,$id,Criteria::EQUAL)
        ->addAnd(SectionI18nPeer::LOCALE,$lang,Criteria::EQUAL)
        ->findOne();
        */

        $s = SectionI18nQuery::create()
            ->addAnd("section_i18n.ID", $id)
            ->addAnd("section_i18n.LOCALE", $lang)
            ->findOne();

        if ($s == null)
        {
            array_push($result, "SectionId=".$id." does not exists");
            return $result;
        }

        if (self::hasChilds($id, $lang))
        {
            array_push($result, $s->getTitle()." have child(s)");
            $isValid = false;
        }

        if (self::hasNews($id, $lang))
        {
            array_push($result, $s->getTitle()." have news");
            $isValid = false;
        }


        if ($isValid)
        {
            $s->delete();
            if (!$s->isDeleted())
                array_push($result, "Delete Error");

            $s = SectionI18nQuery::create()
                ->addAnd("section_i18n.ID", $id)
                ->count();

            if ($s == 0)
            {
                $s= SectionQuery::create()->findPk($id);
                $s->delete();

                if (!$s->isDeleted())
                    array_push($result, "Delete Error");

            }
        }

        return $result;
    }
    static private function hasNews($id, $lang)
    {
        return false;

    }
    /**
     *
     * @param Int $id
     * @param String $lang
     */
    static private function hasChilds($id,$lang)
    {
        $s = SectionQuery::create()
            ->joinWithI18n($lang,Criteria::INNER_JOIN)
            ->addAnd("section.PARENT",$id,Criteria::EQUAL)
            ->addAnd("section_i18n.LOCALE",$lang,Criteria::EQUAL)
            ->findOne();

        return ($s != null)? true : false;
    }

    static public function publish($id,$isPublish)
    {

        $s = SectionQuery::create()->findPk($id);

        if ($s == null)
            return array("SectionId=".$id." does not exists");

        $s->setLocked($isPublish);
        $s->save();

        return $s->getLocked();

    }
    static public function togglePublish($id)
    {

        $s = SectionQuery::create()->findPk($id);

        if ($s == null)
            return array("SectionId=".$id." does not exists");
        $s->setLocked(!$s->getLocked());
        $s->save();

        return $s->getLocked();

    }
    static public function moveUp($id)
    {
        $section = SectionQuery::create()->findPk($id);

        if ($section == null) return;

        $order = $section->getOrders();
        $parentId = $section->getParent();

        $count = SectionQuery::create()
            ->add("section.PARENT",$parentId)
            ->addAnd("section.ORDERS",$order)
            ->count();
        
        $upSection = SectionQuery::create()
            ->add("section.PARENT",$parentId)
            ->addAnd("section.ORDERS",$order,Criteria::LESS_THAN)
            ->orderByOrders('desc')
            ->findOne();

        if ($upSection != null){ 	
            $section->setOrders($upSection->getOrders());
            $section->save();

            $upSection->setOrders($order);
            $upSection->save();
        }
        else{
        	if($count>1){
        		$section->setOrders($order-1);
        		$section->save();
        		 
        		$upSection->setOrders($order);
        		$upSection->save();
        	}
        }
    }
    static public function moveDown($id)
    {
        $section = SectionQuery::create()->findPk($id);

        if ($section == null) return;

        $order = $section->getOrders();
        $parentId = $section->getParent();

        $count = SectionQuery::create()
        ->add("section.PARENT",$parentId)
        ->orderByOrders('desc')
        ->count();
        
        $downSection = SectionQuery::create()
            ->filterByParent($parentId)
            ->addAnd("section.ORDERS",$order,Criteria::GREATER_THAN)
            ->orderByOrders('asc')
            ->findOne();

        if ($downSection != null)
        {
            $section->setOrders($downSection->getOrders());
            $section->save();

            $downSection->setOrders($order);
            $downSection->save();
        }
        else{
        	if($count>1){
        		$section->setOrders($order+1);
        		$section->save();
        		
        		$downSection->setOrders($order);
        		$downSection->save();
        	}
        }


    }
    /**
     * Move up sections have order great than $order
     * @param Int $parentid
     * @param Int $order
     */

    static private function getNextIndex($parentId)
    {
        $s = SectionQuery::create()
            ->filterByParent($parentId)
            ->orderByOrders('desc')
            ->findOne();

        return $s != null? $s->getOrders()+1 : 0;

    }
    /**
     *
     * Generate web link for a particular section
     * @param int $id
     * @param string $culture
     */
    static public function generateWebLink($id,$locale){
        /*
            $section=SectionQuery::create()
        ->joinWithI18n($culture,Criteria::INNER_JOIN)
        ->findPk($id);
        */
        $section=SectionQuery::create()->findPk($id);
        if(!$section)
            return "/";
        $section->setLocale($locale);
        $stripTitle=$section->getStripTitle();
        /*
                //$stripTitle="~";
                // $news->setLocale($culture);
                //	$date=$news->getCreatedAt();
                //    $d= strftime("%H:%M' %Y/%m/%d",strtotime($date));
                // $ext=strftime("%Y/%m",strtotime($date));
                //http://xxx.vn/home/d/2010/12/232/n/index.html

                if($n->getBundleId()==1)
                    return  "/".$locale."/s/news/".$id."/".$stripTitle."/";
        */
        if($section->getBundleId()==1)
            return  "/".$locale."/".$id."/".$stripTitle;
        if($section->getBundleId()==2)
            return  "/".$locale."/".$id."/".$stripTitle;
    }
    static public function reUpdateWebLink($locale){
        $sections=SectionQuery::create()->find();
        foreach ($sections as $section){
            if(!$section) return;
            $section->setLocale($locale);
            $section->setLink(self::generateWebLink($section->getId(),$locale));
            $section->save();
        }
    }
    /**
     *
     * Update web link for a section.
     * @param int $id
     * @param string $culture
     */
    static public function updateWebLink($id,$locale){
        $section=SectionQuery::create()->findById($id);
        if(!$section) return;
        $section->setLocale($locale);
        $section->setLink(self::generateWebLink($id,$locale));
        $section->save();
    }
}