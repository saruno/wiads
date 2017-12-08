<?php

namespace Portal\FrontBundle\Helper;

use Common\DbBundle\Model\App;
use Common\DbBundle\Model\Advert;
use Common\DbBundle\Model\AdvertQuery;
use Common\DbBundle\Model\AdvertI18n;
use Common\DbBundle\Model\AdvertI18nQuery;
use Common\DbBundle\Model\Advertcache;
use Common\DbBundle\Model\AdvertcacheQuery;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;

class AdvertHelper{
	static public function updateRead($id, $lang)
	{
		$connection = Propel::getConnection();
	
		$query = "UPDATE %s SET %s=%s+1 WHERE %s=? AND %s=?";
		$query = sprintf($query,
				'advert_i18n',
					
				'advert_i18n.READ',
				'advert_i18n.READ',
	
				'advert_i18n.LOCALE',
				'advert_i18n.ID'
					
				);
		$stmt = $connection->prepare($query);
	
		$stmt->bindValue(1,$lang);
		$stmt->bindValue(2,$id,PDO::PARAM_INT);
	
		$stmt->execute();
	
		$query = "UPDATE %s SET %s=%s+1 WHERE %s=? AND %s=?";
		$query = sprintf($query,
				'advertcache',
					
				'advertcache.READ',
				'advertcache.READ',
	
				'advertcache.LOCALE',
				'advertcache.ADVERT_ID'
					
				);
	
		//$query = "SELECT ?,?,?,?,?,?,?,? FROM ?,? WHERE ?=? AND ?=? AND ?=? AND ?=? ORDER BY ?";
		$stmt = $connection->prepare($query);
	
		$stmt->bindValue(1,$lang);
		$stmt->bindValue(2,$id,PDO::PARAM_INT);
	
		$stmt->execute();
	}
}