<?php

namespace Common\DbBundle\Model\Map;

use Common\DbBundle\Model\Advert;
use Common\DbBundle\Model\AdvertQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'advert' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AdvertTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Common.DbBundle.Model.Map.AdvertTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'advert';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Common\\DbBundle\\Model\\Advert';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Common.DbBundle.Model.Advert';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 27;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 27;

    /**
     * the column name for the id field
     */
    const COL_ID = 'advert.id';

    /**
     * the column name for the section_id field
     */
    const COL_SECTION_ID = 'advert.section_id';

    /**
     * the column name for the subsection_ids field
     */
    const COL_SUBSECTION_IDS = 'advert.subsection_ids';

    /**
     * the column name for the bundle_id field
     */
    const COL_BUNDLE_ID = 'advert.bundle_id';

    /**
     * the column name for the section_link_id field
     */
    const COL_SECTION_LINK_ID = 'advert.section_link_id';

    /**
     * the column name for the bundle_link_id field
     */
    const COL_BUNDLE_LINK_ID = 'advert.bundle_link_id';

    /**
     * the column name for the view_at_homepage field
     */
    const COL_VIEW_AT_HOMEPAGE = 'advert.view_at_homepage';

    /**
     * the column name for the home_position field
     */
    const COL_HOME_POSITION = 'advert.home_position';

    /**
     * the column name for the view_at_section field
     */
    const COL_VIEW_AT_SECTION = 'advert.view_at_section';

    /**
     * the column name for the section_position field
     */
    const COL_SECTION_POSITION = 'advert.section_position';

    /**
     * the column name for the location field
     */
    const COL_LOCATION = 'advert.location';

    /**
     * the column name for the company field
     */
    const COL_COMPANY = 'advert.company';

    /**
     * the column name for the platform field
     */
    const COL_PLATFORM = 'advert.platform';

    /**
     * the column name for the platform_version field
     */
    const COL_PLATFORM_VERSION = 'advert.platform_version';

    /**
     * the column name for the can_delete field
     */
    const COL_CAN_DELETE = 'advert.can_delete';

    /**
     * the column name for the published_at field
     */
    const COL_PUBLISHED_AT = 'advert.published_at';

    /**
     * the column name for the expired_at field
     */
    const COL_EXPIRED_AT = 'advert.expired_at';

    /**
     * the column name for the customer_id field
     */
    const COL_CUSTOMER_ID = 'advert.customer_id';

    /**
     * the column name for the ratio field
     */
    const COL_RATIO = 'advert.ratio';

    /**
     * the column name for the daily_limit field
     */
    const COL_DAILY_LIMIT = 'advert.daily_limit';

    /**
     * the column name for the draft field
     */
    const COL_DRAFT = 'advert.draft';

    /**
     * the column name for the img field
     */
    const COL_IMG = 'advert.img';

    /**
     * the column name for the imgs field
     */
    const COL_IMGS = 'advert.imgs';

    /**
     * the column name for the imgs_sizes field
     */
    const COL_IMGS_SIZES = 'advert.imgs_sizes';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'advert.type';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'advert.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'advert.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    // i18n behavior

    /**
     * The default locale to use for translations.
     *
     * @var string
     */
    const DEFAULT_LOCALE = 'vi';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'SectionId', 'SubsectionIds', 'BundleId', 'SectionLinkId', 'BundleLinkId', 'ViewAtHomepage', 'HomePosition', 'ViewAtSection', 'SectionPosition', 'Location', 'Company', 'Platform', 'PlatformVersion', 'CanDelete', 'PublishedAt', 'ExpiredAt', 'CustomerId', 'Ratio', 'DailyLimit', 'Draft', 'Img', 'Imgs', 'ImgsSizes', 'Type', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'sectionId', 'subsectionIds', 'bundleId', 'sectionLinkId', 'bundleLinkId', 'viewAtHomepage', 'homePosition', 'viewAtSection', 'sectionPosition', 'location', 'company', 'platform', 'platformVersion', 'canDelete', 'publishedAt', 'expiredAt', 'customerId', 'ratio', 'dailyLimit', 'draft', 'img', 'imgs', 'imgsSizes', 'type', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(AdvertTableMap::COL_ID, AdvertTableMap::COL_SECTION_ID, AdvertTableMap::COL_SUBSECTION_IDS, AdvertTableMap::COL_BUNDLE_ID, AdvertTableMap::COL_SECTION_LINK_ID, AdvertTableMap::COL_BUNDLE_LINK_ID, AdvertTableMap::COL_VIEW_AT_HOMEPAGE, AdvertTableMap::COL_HOME_POSITION, AdvertTableMap::COL_VIEW_AT_SECTION, AdvertTableMap::COL_SECTION_POSITION, AdvertTableMap::COL_LOCATION, AdvertTableMap::COL_COMPANY, AdvertTableMap::COL_PLATFORM, AdvertTableMap::COL_PLATFORM_VERSION, AdvertTableMap::COL_CAN_DELETE, AdvertTableMap::COL_PUBLISHED_AT, AdvertTableMap::COL_EXPIRED_AT, AdvertTableMap::COL_CUSTOMER_ID, AdvertTableMap::COL_RATIO, AdvertTableMap::COL_DAILY_LIMIT, AdvertTableMap::COL_DRAFT, AdvertTableMap::COL_IMG, AdvertTableMap::COL_IMGS, AdvertTableMap::COL_IMGS_SIZES, AdvertTableMap::COL_TYPE, AdvertTableMap::COL_CREATED_AT, AdvertTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'section_id', 'subsection_ids', 'bundle_id', 'section_link_id', 'bundle_link_id', 'view_at_homepage', 'home_position', 'view_at_section', 'section_position', 'location', 'company', 'platform', 'platform_version', 'can_delete', 'published_at', 'expired_at', 'customer_id', 'ratio', 'daily_limit', 'draft', 'img', 'imgs', 'imgs_sizes', 'type', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'SectionId' => 1, 'SubsectionIds' => 2, 'BundleId' => 3, 'SectionLinkId' => 4, 'BundleLinkId' => 5, 'ViewAtHomepage' => 6, 'HomePosition' => 7, 'ViewAtSection' => 8, 'SectionPosition' => 9, 'Location' => 10, 'Company' => 11, 'Platform' => 12, 'PlatformVersion' => 13, 'CanDelete' => 14, 'PublishedAt' => 15, 'ExpiredAt' => 16, 'CustomerId' => 17, 'Ratio' => 18, 'DailyLimit' => 19, 'Draft' => 20, 'Img' => 21, 'Imgs' => 22, 'ImgsSizes' => 23, 'Type' => 24, 'CreatedAt' => 25, 'UpdatedAt' => 26, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'sectionId' => 1, 'subsectionIds' => 2, 'bundleId' => 3, 'sectionLinkId' => 4, 'bundleLinkId' => 5, 'viewAtHomepage' => 6, 'homePosition' => 7, 'viewAtSection' => 8, 'sectionPosition' => 9, 'location' => 10, 'company' => 11, 'platform' => 12, 'platformVersion' => 13, 'canDelete' => 14, 'publishedAt' => 15, 'expiredAt' => 16, 'customerId' => 17, 'ratio' => 18, 'dailyLimit' => 19, 'draft' => 20, 'img' => 21, 'imgs' => 22, 'imgsSizes' => 23, 'type' => 24, 'createdAt' => 25, 'updatedAt' => 26, ),
        self::TYPE_COLNAME       => array(AdvertTableMap::COL_ID => 0, AdvertTableMap::COL_SECTION_ID => 1, AdvertTableMap::COL_SUBSECTION_IDS => 2, AdvertTableMap::COL_BUNDLE_ID => 3, AdvertTableMap::COL_SECTION_LINK_ID => 4, AdvertTableMap::COL_BUNDLE_LINK_ID => 5, AdvertTableMap::COL_VIEW_AT_HOMEPAGE => 6, AdvertTableMap::COL_HOME_POSITION => 7, AdvertTableMap::COL_VIEW_AT_SECTION => 8, AdvertTableMap::COL_SECTION_POSITION => 9, AdvertTableMap::COL_LOCATION => 10, AdvertTableMap::COL_COMPANY => 11, AdvertTableMap::COL_PLATFORM => 12, AdvertTableMap::COL_PLATFORM_VERSION => 13, AdvertTableMap::COL_CAN_DELETE => 14, AdvertTableMap::COL_PUBLISHED_AT => 15, AdvertTableMap::COL_EXPIRED_AT => 16, AdvertTableMap::COL_CUSTOMER_ID => 17, AdvertTableMap::COL_RATIO => 18, AdvertTableMap::COL_DAILY_LIMIT => 19, AdvertTableMap::COL_DRAFT => 20, AdvertTableMap::COL_IMG => 21, AdvertTableMap::COL_IMGS => 22, AdvertTableMap::COL_IMGS_SIZES => 23, AdvertTableMap::COL_TYPE => 24, AdvertTableMap::COL_CREATED_AT => 25, AdvertTableMap::COL_UPDATED_AT => 26, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'section_id' => 1, 'subsection_ids' => 2, 'bundle_id' => 3, 'section_link_id' => 4, 'bundle_link_id' => 5, 'view_at_homepage' => 6, 'home_position' => 7, 'view_at_section' => 8, 'section_position' => 9, 'location' => 10, 'company' => 11, 'platform' => 12, 'platform_version' => 13, 'can_delete' => 14, 'published_at' => 15, 'expired_at' => 16, 'customer_id' => 17, 'ratio' => 18, 'daily_limit' => 19, 'draft' => 20, 'img' => 21, 'imgs' => 22, 'imgs_sizes' => 23, 'type' => 24, 'created_at' => 25, 'updated_at' => 26, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('advert');
        $this->setPhpName('Advert');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Common\\DbBundle\\Model\\Advert');
        $this->setPackage('src.Common.DbBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('section_id', 'SectionId', 'INTEGER', 'section', 'id', false, null, null);
        $this->addColumn('subsection_ids', 'SubsectionIds', 'VARCHAR', false, 2000, null);
        $this->addForeignKey('bundle_id', 'BundleId', 'INTEGER', 'bundle', 'id', false, null, null);
        $this->addColumn('section_link_id', 'SectionLinkId', 'INTEGER', false, null, null);
        $this->addColumn('bundle_link_id', 'BundleLinkId', 'INTEGER', false, null, null);
        $this->addColumn('view_at_homepage', 'ViewAtHomepage', 'BOOLEAN', false, 1, null);
        $this->addColumn('home_position', 'HomePosition', 'VARCHAR', false, 30, null);
        $this->addColumn('view_at_section', 'ViewAtSection', 'BOOLEAN', false, 1, null);
        $this->addColumn('section_position', 'SectionPosition', 'VARCHAR', false, 30, null);
        $this->addColumn('location', 'Location', 'VARCHAR', false, 1024, null);
        $this->addColumn('company', 'Company', 'VARCHAR', false, 1024, null);
        $this->addColumn('platform', 'Platform', 'VARCHAR', false, 500, null);
        $this->addColumn('platform_version', 'PlatformVersion', 'VARCHAR', false, 500, null);
        $this->addColumn('can_delete', 'CanDelete', 'BOOLEAN', false, 1, null);
        $this->addColumn('published_at', 'PublishedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('expired_at', 'ExpiredAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('customer_id', 'CustomerId', 'INTEGER', 'customer', 'id', false, null, null);
        $this->addColumn('ratio', 'Ratio', 'FLOAT', false, null, 1);
        $this->addColumn('daily_limit', 'DailyLimit', 'INTEGER', false, null, null);
        $this->addColumn('draft', 'Draft', 'BOOLEAN', false, 1, null);
        $this->addColumn('img', 'Img', 'VARCHAR', false, 1000, null);
        $this->addColumn('imgs', 'Imgs', 'VARCHAR', false, 1000, null);
        $this->addColumn('imgs_sizes', 'ImgsSizes', 'VARCHAR', false, 500, null);
        $this->addColumn('type', 'Type', 'INTEGER', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Section', '\\Common\\DbBundle\\Model\\Section', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', null, false);
        $this->addRelation('Customer', '\\Common\\DbBundle\\Model\\Customer', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':customer_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', null, false);
        $this->addRelation('Bundle', '\\Common\\DbBundle\\Model\\Bundle', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':bundle_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', null, false);
        $this->addRelation('AdvertI18n', '\\Common\\DbBundle\\Model\\AdvertI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, 'AdvertI18ns', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'title, description, campagin, strip_title, brief, tag, keyword, post_by, edit_by,link, link_to,view,locked,trash,read', 'i18n_pk_column' => '', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => 'vi', 'locale_alias' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to advert     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdvertI18nTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? AdvertTableMap::CLASS_DEFAULT : AdvertTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Advert object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AdvertTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AdvertTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AdvertTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AdvertTableMap::OM_CLASS;
            /** @var Advert $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AdvertTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = AdvertTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AdvertTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Advert $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AdvertTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AdvertTableMap::COL_ID);
            $criteria->addSelectColumn(AdvertTableMap::COL_SECTION_ID);
            $criteria->addSelectColumn(AdvertTableMap::COL_SUBSECTION_IDS);
            $criteria->addSelectColumn(AdvertTableMap::COL_BUNDLE_ID);
            $criteria->addSelectColumn(AdvertTableMap::COL_SECTION_LINK_ID);
            $criteria->addSelectColumn(AdvertTableMap::COL_BUNDLE_LINK_ID);
            $criteria->addSelectColumn(AdvertTableMap::COL_VIEW_AT_HOMEPAGE);
            $criteria->addSelectColumn(AdvertTableMap::COL_HOME_POSITION);
            $criteria->addSelectColumn(AdvertTableMap::COL_VIEW_AT_SECTION);
            $criteria->addSelectColumn(AdvertTableMap::COL_SECTION_POSITION);
            $criteria->addSelectColumn(AdvertTableMap::COL_LOCATION);
            $criteria->addSelectColumn(AdvertTableMap::COL_COMPANY);
            $criteria->addSelectColumn(AdvertTableMap::COL_PLATFORM);
            $criteria->addSelectColumn(AdvertTableMap::COL_PLATFORM_VERSION);
            $criteria->addSelectColumn(AdvertTableMap::COL_CAN_DELETE);
            $criteria->addSelectColumn(AdvertTableMap::COL_PUBLISHED_AT);
            $criteria->addSelectColumn(AdvertTableMap::COL_EXPIRED_AT);
            $criteria->addSelectColumn(AdvertTableMap::COL_CUSTOMER_ID);
            $criteria->addSelectColumn(AdvertTableMap::COL_RATIO);
            $criteria->addSelectColumn(AdvertTableMap::COL_DAILY_LIMIT);
            $criteria->addSelectColumn(AdvertTableMap::COL_DRAFT);
            $criteria->addSelectColumn(AdvertTableMap::COL_IMG);
            $criteria->addSelectColumn(AdvertTableMap::COL_IMGS);
            $criteria->addSelectColumn(AdvertTableMap::COL_IMGS_SIZES);
            $criteria->addSelectColumn(AdvertTableMap::COL_TYPE);
            $criteria->addSelectColumn(AdvertTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(AdvertTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.section_id');
            $criteria->addSelectColumn($alias . '.subsection_ids');
            $criteria->addSelectColumn($alias . '.bundle_id');
            $criteria->addSelectColumn($alias . '.section_link_id');
            $criteria->addSelectColumn($alias . '.bundle_link_id');
            $criteria->addSelectColumn($alias . '.view_at_homepage');
            $criteria->addSelectColumn($alias . '.home_position');
            $criteria->addSelectColumn($alias . '.view_at_section');
            $criteria->addSelectColumn($alias . '.section_position');
            $criteria->addSelectColumn($alias . '.location');
            $criteria->addSelectColumn($alias . '.company');
            $criteria->addSelectColumn($alias . '.platform');
            $criteria->addSelectColumn($alias . '.platform_version');
            $criteria->addSelectColumn($alias . '.can_delete');
            $criteria->addSelectColumn($alias . '.published_at');
            $criteria->addSelectColumn($alias . '.expired_at');
            $criteria->addSelectColumn($alias . '.customer_id');
            $criteria->addSelectColumn($alias . '.ratio');
            $criteria->addSelectColumn($alias . '.daily_limit');
            $criteria->addSelectColumn($alias . '.draft');
            $criteria->addSelectColumn($alias . '.img');
            $criteria->addSelectColumn($alias . '.imgs');
            $criteria->addSelectColumn($alias . '.imgs_sizes');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(AdvertTableMap::DATABASE_NAME)->getTable(AdvertTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AdvertTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AdvertTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AdvertTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Advert or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Advert object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Common\DbBundle\Model\Advert) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AdvertTableMap::DATABASE_NAME);
            $criteria->add(AdvertTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = AdvertQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AdvertTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AdvertTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the advert table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AdvertQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Advert or Criteria object.
     *
     * @param mixed               $criteria Criteria or Advert object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Advert object
        }

        if ($criteria->containsKey(AdvertTableMap::COL_ID) && $criteria->keyContainsValue(AdvertTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AdvertTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = AdvertQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AdvertTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AdvertTableMap::buildTableMap();
