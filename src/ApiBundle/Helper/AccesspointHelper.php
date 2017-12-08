<?php
namespace ApiBundle\Helper;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;

class AccesspointHelper
{
	static public function getCountAccesspointLocation($lat, $lng, $radius)
	{
		$sql = "SELECT *
					FROM (
					  SELECT 
					    COUNT(A.id) as total
					  FROM accesspoint AS A LEFT JOIN accesspoint_i18n AS AI ON (A.id = AI.id AND AI.locale = 'vi')
					  WHERE
					    lat
					      BETWEEN {$lat} - ({$radius} / 69) 
					      AND {$lat} + ({$radius} / 69)
					    AND lng 
					      BETWEEN {$lng} - ({$radius} / (69 * COS(RADIANS({$lat})))) 
					      AND {$lng} + ({$radius} / (69* COS(RADIANS({$lat}))))
					      AND AI.trash = 0
					) r ";

		$connection = Propel::getConnection();
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll(2); 
		return $result[0]['total'];	
	} 

	static public function getAccesspointLocation($lat, $lng, $radius, $start, $limit)
	{
		$sql = "SELECT *
					FROM (
					  SELECT 
					    A.id,A.macaddr,AI.name,AI.address,A.province,A.ssid,A.key,A.lat,A.lng,A.created_at,A.updated_at,
					    3956 * ACOS(COS(RADIANS({$lat})) * COS(RADIANS(lat)) * COS(RADIANS({$lng}) - RADIANS(lng)) + SIN(RADIANS({$lat})) * SIN(RADIANS(lat))) AS distance
					  FROM accesspoint AS A LEFT JOIN accesspoint_i18n AS AI ON (A.id = AI.id AND AI.locale = 'vi')
					  WHERE
					    lat
					      BETWEEN {$lat} - ({$radius} / 69) 
					      AND {$lat} + ({$radius} / 69)
					    AND lng 
					      BETWEEN {$lng} - ({$radius} / (69 * COS(RADIANS({$lat})))) 
					      AND {$lng} + ({$radius} / (69* COS(RADIANS({$lat}))))
					      AND AI.trash = 0
					) r 
					WHERE distance < {$radius} 
					ORDER BY distance ASC LIMIT {$start}, {$limit}";

		$connection = Propel::getConnection();
		$stmt = $connection->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(2);
	}
}