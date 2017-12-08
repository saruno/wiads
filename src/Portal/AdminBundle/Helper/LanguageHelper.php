<?php
/**
 * Created by PhpStorm.
 * User: nhnhat
 * Date: 4/12/16
 * Time: 2:58 PM
 */

namespace Portal\AdminBundle\Helper;

use Common\DbBundle\Model\Language;
use Common\DbBundle\Model\LanguageQuery;

use Propel\Runtime\ActiveQuery\Criteria;
use \PDO;
class LanguageHelper
{

    /**
     *
     * @param String $culture
     */
    static public function getAllLanguage_Admin($locale)
    {
        $langs=LanguageQuery::create()
            ->joinWithI18n($locale)
            ->find();
        return $langs;
    }
    static public function getLanguageWithPaging_Admin($page,$pagesize,$locale)
    {

        $midrange = 7;
        $itemsCount = 0;
        $listLanguage = array();

        $itemsCount = LanguageQuery::create()
            ->joinWithI18n($locale)
            ->count();


        $listLanguage=LanguageQuery::create()
            ->joinWithI18n($locale)
            ->offset(($page-1)*$pagesize)
            ->limit($pagesize)
            ->orderByCode('asc')
            ->find();

        $paginator = new PaginatorHelper($itemsCount, $page , $pagesize, $midrange);

        return array('items' => $listLanguage, 'paginator' => $paginator);

    }
    static public function togglePublish($lang,$id)
    {

        $language = LanguageQuery::create()->findPk($id);

        if ($language == null)
            return array("LanguageId=".$id." does not exists");

        $language->setLocale($lang);
        $language->setLocked(!$language->getLocked());
        $language->save();

        return $language->getLocked();

    }
}