<?php

namespace Common\DbBundle\Model;

use Common\DbBundle\Model\Base\Advertcache as BaseAdvertcache;

/**
 * Skeleton subclass for representing a row from the 'advertcache' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Advertcache extends BaseAdvertcache
{
	public function get1stImage(){
		$imgs=explode(",", self::getImgs());
		$pos0=false;
		if(count($imgs)>0)
			$pos0 = strpos($imgs[0], 'images/noimage.jpg');
	
			if($pos0===false)
				return $imgs[0];
				else
					return "";
	}
	public function get2ndImage(){
		$imgs=explode(",", self::getImgs());
		$pos0=false;
		$pos1=false;
		if(count($imgs)>0)
			$pos0 = strpos($imgs[0], 'images/noimage.jpg');
			if(count($imgs)>1)
				$pos1 = strpos($imgs[1], 'images/noimage.jpg');
	
				if($pos1!==false){
					if($pos0!==false)
						return "";
						else
							return $imgs[0];
				}
				else
					return $imgs[1];
	}
	public function get1stImageSize(){
		$imgs=explode(",", self::getImgs());
		$imgsSizes=explode(",", self::getImgsSizes());
		$pos0=false;
		if(count($imgs)>0)
			$pos0 = strpos($imgs[0], 'images/noimage.jpg');
	
			if($pos0===false)
				return $imgsSizes[0];
				else
					return "";
	}
	public function get2ndImageSize(){
		$imgs=explode(",", self::getImgs());
		$imgsSizes=explode(",", self::getImgsSizes());
		$imgsSizes[]="";
		$imgsSizes[]="";
		$pos0=false;
		$pos1=false;
		if(count($imgs)>0)
			$pos0 = strpos($imgs[0], 'images/noimage.jpg');
			if(count($imgs)>1)
				$pos1 = strpos($imgs[1], 'images/noimage.jpg');
	
				if($pos1!==false){
					if($pos0!==false)
						return "";
						else
							return $imgsSizes[0];
				}
				else
					return $imgsSizes[1];
	}
}
