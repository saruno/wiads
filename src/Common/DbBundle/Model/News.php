<?php

namespace Common\DbBundle\Model;

use Common\DbBundle\Model\Section;
use Common\DbBundle\Model\SectionQuery;

use Common\DbBundle\Model\Base\News as BaseNews;

/**
 * Skeleton subclass for representing a row from the 'news' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class News extends BaseNews
{
	public function get1stImage(){
		$imgs=explode(",", self::getImgs());
		$pos0=false;
		$pos1=false;
		$pos2=false;
		if(count($imgs)>0)
			$pos0 = strpos($imgs[0], 'images/noimage.jpg');
			if(count($imgs)>1)
				$pos1 = strpos($imgs[1], 'images/noimage.jpg');
				if(count($imgs)>2)
					$pos2 = strpos($imgs[2], 'images/noimage.jpg');
	
					if($pos0!==false){
						if($pos1!==false)
							return "";
							else
								return $imgs[1];
					}
					else
						return $imgs[0];
	}
	public function get2ndImage(){
		$imgs=explode(",", self::getImgs());
		$pos0=false;
		$pos1=false;
		$pos2=false;
		if(count($imgs)>0)
			$pos0 = strpos($imgs[0], 'images/noimage.jpg');
			if(count($imgs)>1)
				$pos1 = strpos($imgs[1], 'images/noimage.jpg');
				if(count($imgs)>2)
					$pos2 = strpos($imgs[2], 'images/noimage.jpg');
	
					if($pos1!==false){
						if($pos0!==false)
							return "";
							else
								return $imgs[0];
					}
					else
						return $imgs[1];
	}
	public function get3rdImage(){
		$imgs=explode(",", self::getImgs());
		$pos0=false;
		$pos1=false;
		$pos2=false;
		if(count($imgs)>0)
			$pos0 = strpos($imgs[0], 'images/noimage.jpg');
			if(count($imgs)>1)
				$pos1 = strpos($imgs[1], 'images/noimage.jpg');
				if(count($imgs)>2)
					$pos2 = strpos($imgs[2], 'images/noimage.jpg');
	
					if($pos2!==false){
						if($pos1!==false){
							if($pos0!==false)
								return "";
								else
									return $imgs[0];
						}
						else
							return $imgs[1];
					}
					else
						return $imgs[2];
	}
	public function getSectionName(){
		$id = self::getSectionId();
		$section=SectionQuery::create()
		->joinWithI18n(self::getLocale())
		->findPk($id);
		if($section!=null)
			return $section->getTitle();
			else
				return "No Section";
	}
}
