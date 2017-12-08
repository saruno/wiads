<?php 
namespace Portal\AdminBundle\Helper;

use JMS\DiExtraBundle\Annotation\AfterSetup;

use Common\DbBundle\Model\App;
use Common\DbBundle\Model\AppQuery;

use Common\DbBundle\Model\Marker;
use Common\DbBundle\Model\MarkerQuery;
use Common\DbBundle\Model\MarkerI18nQuery;

use Common\DbBundle\Model\MarkerCategory;
use Common\DbBundle\Model\MarkerCategoryQuery;
use Common\DbBundle\Model\MarkerCategoryI18nQuery;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;

class MapHelper{
static public function getAllMarkers($locale){
		/*
		return MarkerQuery::create()
		->joinWithI18n($locale)
		->limit(2)
		->find();
		*/
		$connection = Propel::getConnection();
		
		$query = "SELECT %s,%s as cid,%s,%s,%s,%s,%s,%s,%s FROM %s,%s,%s WHERE %s=%s AND %s=? AND %s=%s ";
		$query = sprintf($query,
						
				'marker.ID',
				'marker.CATEGORY_ID',
				'marker.LONGITUDE',
				'marker.LATITUDE',
				
				'marker_i18n.NAME',
				'marker_i18n.ADDRESS',
				'marker_i18n.PCONTACT',
				'marker_i18n.DETAIL_URL',
				
				'marker_category.ICON',
				
				'marker',
				'marker_i18n',
				'marker_category',
				
				'marker.ID',
				'marker_i18n.ID',
				
				'marker_i18n.LOCALE',
				/*?*/
				
				'marker.CATEGORY_ID',
				'marker_category.ID'
				
				//'section.ID
					
		);
		
		//$query = "SELECT ?,?,?,?,?,?,?,? FROM ?,? WHERE ?=? AND ?=? AND ?=? AND ?=? ORDER BY ?";
		$stmt = $connection->prepare($query);
		
		$stmt->bindValue(1,$locale,PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		
	}
	static public function getAllMarkerCategories($locale){
		return MarkerCategoryQuery::create()
		->joinWithI18n($locale)
		->find();
	}
	static public function getMarkersWithPaging_Admin($page,$pagesize,$type,$locale,$status =null,$onlyDraft=false,$filterUser=false,$username=null)
	{
		$markerQuery=MarkerQuery::create()
		->joinWithI18n($locale);
		if($type>-1)
			$markerQuery->addAnd('marker.CATEGORY_ID',$type);
		if($status!==null){
		//	$markerQuery->addAnd('news_i18n.STATUS',($status) ,Criteria::IN);
		}
		
		$pager	=	$markerQuery->paginate($page, $pagesize);
	
		return $pager;

	}
	static public function getMarker($id,$locale){
		/*
		return $markerQuery=MarkerQuery::create()
		->joinWithI18n($locale)
		->findPk($id);
		*/
		$connection = Propel::getConnection();
		
		$query = "SELECT %s,%s as cid,%s,%s,%s,%s,%s,%s,%s,%s FROM %s,%s,%s WHERE %s=%s AND %s=? AND %s=%s AND %s=? AND %s=? ";
		$query = sprintf($query,
		
				'marker.ID',
				'marker.CATEGORY_ID',
				'marker.LONGITUDE',
				'marker.LATITUDE',
				'marker.IMAGE',
		
				'marker_i18n.NAME',
				'marker_i18n.ADDRESS',
				'marker_i18n.PCONTACT',
				'marker_i18n.DETAIL_URL',
		
				'marker_category.ICON',
		
				'marker',
				'marker_i18n',
				'marker_category',
		
				'marker.ID',
				'marker_i18n.ID',
		
				'marker_i18n.LOCALE',
				/*?*/
		
				'marker.CATEGORY_ID',
				'marker_category.ID',
		
				//'section.ID'
				//'marker_i18n.LOCKED',
		
				'marker_i18n.DELETED',
		
				'marker.ID'
		
		);
		
		//$query = "SELECT ?,?,?,?,?,?,?,? FROM ?,? WHERE ?=? AND ?=? AND ?=? AND ?=? ORDER BY ?";
		$stmt = $connection->prepare($query);
		
		$stmt->bindValue(1,$locale,PDO::PARAM_STR);
		$stmt->bindValue(2,0,PDO::PARAM_INT);
		$stmt->bindValue(3,$id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}