<?php
namespace Portal\AdminBundle\Helper;
use Common\DbBundle\Model\App;
use Common\DbBundle\Model\Menu;
use Common\DbBundle\Model\MenuQuery;
use Common\DbBundle\Model\MenuI18n;
use Common\DbBundle\Model\MenuI18nQuery;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;

class MenuHelper{

	/**
	 *
	 * @param Int $page
	 * @param Int $pagesize
	 * @param Int $menuId
	 * @param Atring $locale
	 * @return Array :\Netcodo\AdminBundle\Helper\PaginatorHelper
	 */
	static public function getMenus_Admin($menuId,$locale,$position)
	{
		$arr=array();
		$s_id=array();
		$s_id[]="$menuId";
		self::getMenuIdRecursive_Admin($arr, $menuId, $locale,$position);
		foreach ($arr as $sid){
			$s_id[]=$sid['ID'];
		}


		$menus=MenuQuery::create()
		->joinWithI18n($locale,Criteria::INNER_JOIN)
		->addAnd("menu.ID",($s_id) ,Criteria::IN)
		->addAnd("menu.POS", $position,Criteria::EQUAL)
		->addAscendingOrderByColumn("FIELD( "."menu.ID".", ".implode(',',$s_id).")")
		->find();


		return $menus;
			
	}
	/**
	 *
	 * @param Array $arr
	 * @param string $locale
	 * @param string $position
	 * @param bool $useException
	 * @param int $exceptionId
	 */
	static public function getAllMenu_Admin(&$arr,$locale,$position,$useException=false,$exceptionId=-1)
	{
		$arr=array();
		$s_id=array();
		$s_id[]="-1";
		self::getMenuIdRecursive_Admin($arr, -1, $locale,$position,$useException,$exceptionId);
		foreach ($arr as $sid){
			$s_id[]=$sid['ID'];
		}

		$menus=MenuQuery::create()
		->joinWithI18n($locale,Criteria::INNER_JOIN)
		->addAnd("menu.ID",($s_id) ,Criteria::IN)
		->addAnd("menu.POS", $position,Criteria::EQUAL)
		->addAscendingOrderByColumn("FIELD( "."menu.ID".", ".implode(',',$s_id).")")
		->find();

		$arr=$menus;
			
	}
	////////////////////////////////////////////////////////////////////////////////////////////////
	// PAGING//
	////////////////////////////////////////////////////////////////////////////////////////////////
	/**
	*
	* @param Int $page
	* @param Int $pagesize
	* @param Int $menuId
	* @param Atring $locale
	* @return Array :\Netcodo\AdminBundle\Helper\PaginatorHelper
	*/
	static public function getMenuWithPaging_Admin($page,$pagesize,$menuId,$locale,$position)
	{
		$arr=array();
		$s_id=array();
		$s_id[]="$menuId";
		self::getMenuIdRecursive_Admin($arr, $menuId, $locale,$position);
		foreach ($arr as $sid){
			$s_id[]=$sid['id'];
		}

		$midrange = 7;

		$itemsCount=$menus=MenuQuery::create()
		->joinWithI18n($locale,Criteria::INNER_JOIN)
		->addAnd("menu.ID",($s_id) ,Criteria::IN)
		->addAnd("menu.POS", $position,Criteria::EQUAL)
		->count();

		$menus=MenuQuery::create()
		->joinWithI18n($locale,Criteria::INNER_JOIN)
		->addAnd(menu.ID,($s_id) ,Criteria::IN)
		->addAnd(menu.POS, $position,Criteria::EQUAL)
		->offset(($page-1)*$pagesize)
		->limit($pagesize)
		->addAscendingOrderByColumn("FIELD( "."menu.ID".", ".implode(',',$s_id).")")
		->find();

		$paginator = new PaginatorHelper($itemsCount, $page , $pagesize, $midrange);

		return array('items' => $menus, 'paginator' => $paginator);
			
	}
	/**
	 *
	 * @param Array $arr
	 * @param Int $pid
	 * @param String $locale
	 * @param Int $menuType
	 */
	static private function getMenuIdRecursive_Admin(&$arr,$pid,$locale,$position, $useException=false,$exceptionId=-1){
		static $order_=0;
		$connection = Propel::getConnection();

		$query = "SELECT %s FROM %s,%s WHERE %s=%s AND %s=? AND %s=? AND %s=? ORDER BY %s";
		$query = sprintf($query,
				"menu.ID",

				"menu",
				"menu_i18n",

				"menu.ID",
				"menu_i18n.ID",

				"menu_i18n.LOCALE",
					

				"menu.PARENT",
					
				"menu.POS",

				"menu.ORDERS"

				);
		$statement = $connection->prepare($query);
		$statement->bindValue(1,$locale);
		$statement->bindValue(2,$pid,PDO::PARAM_INT);
		$statement->bindValue(3,$position);

		$statement->execute();
		$pid_=-20;
		while($row = $statement->fetch()) {
			$pid_=$row['ID'];
			if ($useException && ($pid_ == $exceptionId)) continue;
			$arr[$order_++]=array('ID'=>$row['ID']);
			if($pid_>-20){
				self::getMenuIdRecursive_Admin($arr,$pid_,$locale,$position,$useException,$exceptionId);
			}
		}

	}

	/**
	 *
	 * @param Int $menuType
	 * @param String $lang
	 * @param Int $parentId
	 * @param Int $deep
	 * @param String $title
	 * @param Int $order
	 * @param Bool $publish
	 * @param String $description
	 */
	static public function save($title,$publish,$position,$parentId,$description,$link,$sectionId,$sectionType,$lang)
	{
		if($sectionId==-1) $link="/";/*mean link to home page*/
		$hUrl=UtilsHelper::getHostUrl();
		$hUrl=str_replace("/", "\/", $hUrl);
		if (preg_match("/^(.*?)$hUrl(.*?)\?preview=true(.*?)$/", $link, $matches)){
			$link=$matches[2];
		}
		if (preg_match("/^(.*?)$hUrl(.*?)$/", $link, $matches)){
			$link=$matches[2];
		}
		if($sectionId>0) $link=SectionHelper::generateWebLink($sectionId, $lang);

		$s=new Menu();
		$s->setLocale($lang);
		$s->setTitle($title);
		$s->setLocked($publish);
		$s->setPos($position);
		$s->setParent($parentId);
		$s->setBrief($description);
		$s->setLinkTo($link);
		$s->setSectionId($sectionId);
		$s->setBundleId($sectionType);

		$s->setDeep(self::calculateDeep($parentId));

		$s->setStripTitle(UtilsHelper::utf8_to_ascii($title));
		$s->setOrders(self::getNextIndex($parentId));

		//$s->setCreatedAt(date("Y-m-d H:i:s"));
		//if ($s->validate()){
		//	$s->save();
		//	return null;
		//} else {
		//	return UtilsHelper::extractFieldOnly($s->getValidationFailures());
		//}
		$s->save();
		return null;
	}
	static public function update($id,$title,$publish,$position,$parentId,$description,$link,$sectionId,$sectionType,$lang)
	{
		if($sectionId==-1) $link="/";/*mean link to home page*/
		$hUrl=UtilsHelper::getHostUrl();
		$hUrl=str_replace("/", "\/", $hUrl);
		if (preg_match("/^(.*?)$hUrl(.*?)\?preview=true(.*?)$/", $link, $matches)){
			$link=$matches[2];
		}
		if (preg_match("/^(.*?)$hUrl(.*?)$/", $link, $matches)){
			$link=$matches[2];
		}
		if($sectionId>0) $link=SectionHelper::generateWebLink($sectionId, $lang);

		$s=MenuQuery::create()->findPk($id);

		$oldParentId = $s->getParent();

		$s->setLocale($lang);
		$s->setTitle($title);
		$s->setLocked($publish);
		$s->setPos($position);
		$s->setParent($parentId);
		$s->setBrief($description);
		$s->setLinkTo($link);
		$s->setSectionId($sectionId);
		$s->setBundleId($sectionType);

		$s->setDeep(self::calculateDeep($parentId));

		$s->setStripTitle(UtilsHelper::utf8_to_ascii($title));
		if ($oldParentId != $parentId)
		{

			$s->setOrders(self::getNextIndex($parentId));
		}
		//if ($s->validate()){
		//	$s->save();
		//	return null;
		//} else {
		//	return UtilsHelper::extractFieldOnly($s->getValidationFailures());
		//}
		$s->save();
		return null;
	}
	/**
	 *
	 * @param Int $parentId
	 */
	static private function calculateDeep($parentId)
	{
		$deep  = 1;

		$s=MenuQuery::create()->findPk($parentId);
		if ($s != null)
			$deep = $s->getDeep() + 1;

			return $deep;

	}

	/**
	 *
	 * @param Int $id
	 * @param String $lang
	 */
	static public function getMenu_Admin($id, $lang)
	{
		$s = MenuQuery::create()
		->joinWithI18n($lang,Criteria::INNER_JOIN)
		->addAnd("menu.ID",$id,Criteria::EQUAL)
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


		$s = MenuI18nQuery::create()
		->addAnd("menu_i18n.ID", $id)
		->addAnd("menu_i18n.LOCALE", $lang)
		->findOne();

		if ($s == null)
		{
			array_push($result, "MenuId=".$id." does not exists");
			return $result;
		}

		if (self::hasChilds($id, $lang))
		{
			array_push($result, $s->getTitle()." have child(s)");
			$isValid = false;
		}



		if ($isValid)
		{
			$s->delete();
			if (!$s->isDeleted())
				array_push($result, "Delete Error");
					
				$s = MenuI18nQuery::create()
				->addAnd("menu_i18n.ID", $id)
				->count();
					
				if ($s == 0)
				{
					$s= MenuQuery::create()->findPk($id);
					$s->delete();

					if (!$s->isDeleted())
						array_push($result, "Delete Error");

				}
		}

		return $result;
	}
	/**
	 *
	 * @param String $s_ids
	 * @param String $order
	 */
	static public function getMenus_OrderByDeep($s_ids,$order="DESC")
	{

		$menus 	= array();
		if (strtoupper($order)=="DESC")
			$menus = MenuQuery::create()
			->addDescendingOrderByColumn("menu.DEEP")
			->findPks(explode(",", $s_ids));
			else
				$menus = MenuQuery::create()
				->addDescendingOrderByColumn("menu.DEEP")
				->findPks(explode(",", $s_ids));

				return $menus;
	}
	/**
	 *
	 * @param Int $id
	 * @param String $lang
	 */
	static private function hasChilds($id,$lang)
	{
		$s = MenuQuery::create()
		->joinWithI18n($lang,Criteria::INNER_JOIN)
		->addAnd("menu.PARENT",$id,Criteria::EQUAL)
		->addAnd("menu_i18n.LOCALE",$lang,Criteria::EQUAL)
		->findOne();

		return ($s != null)? true : false;
	}

	static public function publish($id,$isPublish)
	{

		$s = MenuQuery::create()->findPk($id);

		if ($s == null)
			return array("MenuId=".$id." does not exists");

			$s->setLocked($isPublish);
			$s->save();

			return $s->getLocked();

	}
	static public function togglePublish($id)
	{

		$s = MenuQuery::create()->findPk($id);

		if ($s == null)
			return array("SectionId=".$id." does not exists");
			$s->setLocked(!$s->getLocked());
			$s->save();

			return $s->getLocked();

	}
	static public function moveUp($id)
	{
		$menu = MenuQuery::create()->findPk($id);

		if ($menu == null) return;

		$order = $menu->getOrders();
		$parentId = $menu->getParent();

		$count = MenuQuery::create()
		->add("menu.PARENT",$parentId)
		->addAnd("menu.POS",$menu->getPos())
		->addAnd("menu.ORDERS",$order)
		->count();
		
		$upMenu = MenuQuery::create()
		->add("menu.PARENT",$parentId)
		->addAnd("menu.POS",$menu->getPos())
		->addAnd("menu.ORDERS",$order,Criteria::LESS_THAN)
		->orderByOrders('desc')
		->findOne();

		if ($upMenu != null)
		{
			$menu->setOrders($upMenu->getOrders());
			$menu->save();
				
			$upMenu->setOrders($order);
			$upMenu->save();
				
		}
		else{
			if($count>1){
				$menu->setOrders($order-1);
				$menu->save();
					
				$upMenu->setOrders($order);
				$upMenu->save();
			}
		}

	}
	static public function moveDown($id)
	{
		$menu = MenuQuery::create()->findPk($id);

		if ($menu == null) return;

		$order = $menu->getOrders();
		$parentId = $menu->getParent();

		$count = MenuQuery::create()
		->add("menu.PARENT",$parentId)
		->addAnd("menu.POS",$menu->getPos())
		->addAnd("menu.ORDERS",$order)
		->count();
		
		$downMenu = MenuQuery::create()
		->add("menu.PARENT",$parentId)
		->addAnd("menu.POS",$menu->getPos())
		->addAnd("menu.ORDERS",$order,Criteria::GREATER_THAN)
		->orderByOrders('asc')
		->findOne();

		if ($downMenu != null)
		{
			$menu->setOrders($downMenu->getOrders());
			$menu->save();
				
			$downMenu->setOrders($order);
			$downMenu->save();
		}
		else{
			if($count>1){
				$menu->setOrders($order+1);
				$menu->save();
				
				$downMenu->setOrders($order);
				$downMenu->save();
			}
		}


	}
	/**
	 * Move up menus have order great than $order
	 * @param Int $parentid
	 * @param Int $order
	 */

	static private function getNextIndex($parentId)
	{
		$s = MenuQuery::create()
		->add("menu.PARENT",$parentId)
		->orderByOrders('desc')
		->findOne();

		return $s != null? $s->getOrders()+1 : 0;

	}
	static public function reUpdateWebLink($locale){
		$menus=MenuQuery::create()->find();
		foreach ($menus as $menu){
			if(!$menu) return;
			$menu->setLocale($locale);
			$menu->setLinkTo(SectionHelper::generateWebLink($menu->getSectionId(),$locale));
			$menu->save();
		}
	}
}