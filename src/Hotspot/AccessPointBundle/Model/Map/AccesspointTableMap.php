<?php

namespace Hotspot\AccessPointBundle\Model\Map;

use Hotspot\AccessPointBundle\Model\Accesspoint;
use Hotspot\AccessPointBundle\Model\AccesspointQuery;
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
 * This class defines the structure of the 'accesspoint' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AccesspointTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Hotspot.AccessPointBundle.Model.Map.AccesspointTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'accesspoint';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Hotspot\\AccessPointBundle\\Model\\Accesspoint';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Hotspot.AccessPointBundle.Model.Accesspoint';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 29;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 29;

    /**
     * the column name for the id field
     */
    const COL_ID = 'accesspoint.id';

    /**
     * the column name for the macaddr field
     */
    const COL_MACADDR = 'accesspoint.macaddr';

    /**
     * the column name for the ap_macaddr field
     */
    const COL_AP_MACADDR = 'accesspoint.ap_macaddr';

    /**
     * the column name for the fw_version field
     */
    const COL_FW_VERSION = 'accesspoint.fw_version';

    /**
     * the column name for the isp field
     */
    const COL_ISP = 'accesspoint.isp';

    /**
     * the column name for the ssid field
     */
    const COL_SSID = 'accesspoint.ssid';

    /**
     * the column name for the key field
     */
    const COL_KEY = 'accesspoint.key';

    /**
     * the column name for the province field
     */
    const COL_PROVINCE = 'accesspoint.province';

    /**
     * the column name for the ads_location field
     */
    const COL_ADS_LOCATION = 'accesspoint.ads_location';

    /**
     * the column name for the login_template field
     */
    const COL_LOGIN_TEMPLATE = 'accesspoint.login_template';

    /**
     * the column name for the image field
     */
    const COL_IMAGE = 'accesspoint.image';

    /**
     * the column name for the category_id field
     */
    const COL_CATEGORY_ID = 'accesspoint.category_id';

    /**
     * the column name for the lng field
     */
    const COL_LNG = 'accesspoint.lng';

    /**
     * the column name for the lat field
     */
    const COL_LAT = 'accesspoint.lat';

    /**
     * the column name for the detail_url_id field
     */
    const COL_DETAIL_URL_ID = 'accesspoint.detail_url_id';

    /**
     * the column name for the section_id field
     */
    const COL_SECTION_ID = 'accesspoint.section_id';

    /**
     * the column name for the subsection_ids field
     */
    const COL_SUBSECTION_IDS = 'accesspoint.subsection_ids';

    /**
     * the column name for the orders field
     */
    const COL_ORDERS = 'accesspoint.orders';

    /**
     * the column name for the suborder_ids field
     */
    const COL_SUBORDER_IDS = 'accesspoint.suborder_ids';

    /**
     * the column name for the front_page field
     */
    const COL_FRONT_PAGE = 'accesspoint.front_page';

    /**
     * the column name for the has_comment field
     */
    const COL_HAS_COMMENT = 'accesspoint.has_comment';

    /**
     * the column name for the can_delete field
     */
    const COL_CAN_DELETE = 'accesspoint.can_delete';

    /**
     * the column name for the published_at field
     */
    const COL_PUBLISHED_AT = 'accesspoint.published_at';

    /**
     * the column name for the imgs field
     */
    const COL_IMGS = 'accesspoint.imgs';

    /**
     * the column name for the relative_news field
     */
    const COL_RELATIVE_NEWS = 'accesspoint.relative_news';

    /**
     * the column name for the owner field
     */
    const COL_OWNER = 'accesspoint.owner';

    /**
     * the column name for the customer_id field
     */
    const COL_CUSTOMER_ID = 'accesspoint.customer_id';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'accesspoint.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'accesspoint.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'Macaddr', 'ApMacaddr', 'FwVersion', 'Isp', 'Ssid', 'Key', 'Province', 'AdsLocation', 'LoginTemplate', 'Image', 'CategoryId', 'Lng', 'Lat', 'DetailUrlId', 'SectionId', 'SubsectionIds', 'Orders', 'SuborderIds', 'FrontPage', 'HasComment', 'CanDelete', 'PublishedAt', 'Imgs', 'RelativeNews', 'Owner', 'CustomerId', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'macaddr', 'apMacaddr', 'fwVersion', 'isp', 'ssid', 'key', 'province', 'adsLocation', 'loginTemplate', 'image', 'categoryId', 'lng', 'lat', 'detailUrlId', 'sectionId', 'subsectionIds', 'orders', 'suborderIds', 'frontPage', 'hasComment', 'canDelete', 'publishedAt', 'imgs', 'relativeNews', 'owner', 'customerId', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(AccesspointTableMap::COL_ID, AccesspointTableMap::COL_MACADDR, AccesspointTableMap::COL_AP_MACADDR, AccesspointTableMap::COL_FW_VERSION, AccesspointTableMap::COL_ISP, AccesspointTableMap::COL_SSID, AccesspointTableMap::COL_KEY, AccesspointTableMap::COL_PROVINCE, AccesspointTableMap::COL_ADS_LOCATION, AccesspointTableMap::COL_LOGIN_TEMPLATE, AccesspointTableMap::COL_IMAGE, AccesspointTableMap::COL_CATEGORY_ID, AccesspointTableMap::COL_LNG, AccesspointTableMap::COL_LAT, AccesspointTableMap::COL_DETAIL_URL_ID, AccesspointTableMap::COL_SECTION_ID, AccesspointTableMap::COL_SUBSECTION_IDS, AccesspointTableMap::COL_ORDERS, AccesspointTableMap::COL_SUBORDER_IDS, AccesspointTableMap::COL_FRONT_PAGE, AccesspointTableMap::COL_HAS_COMMENT, AccesspointTableMap::COL_CAN_DELETE, AccesspointTableMap::COL_PUBLISHED_AT, AccesspointTableMap::COL_IMGS, AccesspointTableMap::COL_RELATIVE_NEWS, AccesspointTableMap::COL_OWNER, AccesspointTableMap::COL_CUSTOMER_ID, AccesspointTableMap::COL_CREATED_AT, AccesspointTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'macaddr', 'ap_macaddr', 'fw_version', 'isp', 'ssid', 'key', 'province', 'ads_location', 'login_template', 'image', 'category_id', 'lng', 'lat', 'detail_url_id', 'section_id', 'subsection_ids', 'orders', 'suborder_ids', 'front_page', 'has_comment', 'can_delete', 'published_at', 'imgs', 'relative_news', 'owner', 'customer_id', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Macaddr' => 1, 'ApMacaddr' => 2, 'FwVersion' => 3, 'Isp' => 4, 'Ssid' => 5, 'Key' => 6, 'Province' => 7, 'AdsLocation' => 8, 'LoginTemplate' => 9, 'Image' => 10, 'CategoryId' => 11, 'Lng' => 12, 'Lat' => 13, 'DetailUrlId' => 14, 'SectionId' => 15, 'SubsectionIds' => 16, 'Orders' => 17, 'SuborderIds' => 18, 'FrontPage' => 19, 'HasComment' => 20, 'CanDelete' => 21, 'PublishedAt' => 22, 'Imgs' => 23, 'RelativeNews' => 24, 'Owner' => 25, 'CustomerId' => 26, 'CreatedAt' => 27, 'UpdatedAt' => 28, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'macaddr' => 1, 'apMacaddr' => 2, 'fwVersion' => 3, 'isp' => 4, 'ssid' => 5, 'key' => 6, 'province' => 7, 'adsLocation' => 8, 'loginTemplate' => 9, 'image' => 10, 'categoryId' => 11, 'lng' => 12, 'lat' => 13, 'detailUrlId' => 14, 'sectionId' => 15, 'subsectionIds' => 16, 'orders' => 17, 'suborderIds' => 18, 'frontPage' => 19, 'hasComment' => 20, 'canDelete' => 21, 'publishedAt' => 22, 'imgs' => 23, 'relativeNews' => 24, 'owner' => 25, 'customerId' => 26, 'createdAt' => 27, 'updatedAt' => 28, ),
        self::TYPE_COLNAME       => array(AccesspointTableMap::COL_ID => 0, AccesspointTableMap::COL_MACADDR => 1, AccesspointTableMap::COL_AP_MACADDR => 2, AccesspointTableMap::COL_FW_VERSION => 3, AccesspointTableMap::COL_ISP => 4, AccesspointTableMap::COL_SSID => 5, AccesspointTableMap::COL_KEY => 6, AccesspointTableMap::COL_PROVINCE => 7, AccesspointTableMap::COL_ADS_LOCATION => 8, AccesspointTableMap::COL_LOGIN_TEMPLATE => 9, AccesspointTableMap::COL_IMAGE => 10, AccesspointTableMap::COL_CATEGORY_ID => 11, AccesspointTableMap::COL_LNG => 12, AccesspointTableMap::COL_LAT => 13, AccesspointTableMap::COL_DETAIL_URL_ID => 14, AccesspointTableMap::COL_SECTION_ID => 15, AccesspointTableMap::COL_SUBSECTION_IDS => 16, AccesspointTableMap::COL_ORDERS => 17, AccesspointTableMap::COL_SUBORDER_IDS => 18, AccesspointTableMap::COL_FRONT_PAGE => 19, AccesspointTableMap::COL_HAS_COMMENT => 20, AccesspointTableMap::COL_CAN_DELETE => 21, AccesspointTableMap::COL_PUBLISHED_AT => 22, AccesspointTableMap::COL_IMGS => 23, AccesspointTableMap::COL_RELATIVE_NEWS => 24, AccesspointTableMap::COL_OWNER => 25, AccesspointTableMap::COL_CUSTOMER_ID => 26, AccesspointTableMap::COL_CREATED_AT => 27, AccesspointTableMap::COL_UPDATED_AT => 28, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'macaddr' => 1, 'ap_macaddr' => 2, 'fw_version' => 3, 'isp' => 4, 'ssid' => 5, 'key' => 6, 'province' => 7, 'ads_location' => 8, 'login_template' => 9, 'image' => 10, 'category_id' => 11, 'lng' => 12, 'lat' => 13, 'detail_url_id' => 14, 'section_id' => 15, 'subsection_ids' => 16, 'orders' => 17, 'suborder_ids' => 18, 'front_page' => 19, 'has_comment' => 20, 'can_delete' => 21, 'published_at' => 22, 'imgs' => 23, 'relative_news' => 24, 'owner' => 25, 'customer_id' => 26, 'created_at' => 27, 'updated_at' => 28, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, )
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
        $this->setName('accesspoint');
        $this->setPhpName('Accesspoint');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Hotspot\\AccessPointBundle\\Model\\Accesspoint');
        $this->setPackage('src.Hotspot.AccessPointBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('macaddr', 'Macaddr', 'VARCHAR', false, 50, null);
        $this->addColumn('ap_macaddr', 'ApMacaddr', 'VARCHAR', false, 50, null);
        $this->addColumn('fw_version', 'FwVersion', 'VARCHAR', false, 50, null);
        $this->addColumn('isp', 'Isp', 'VARCHAR', false, 255, null);
        $this->addColumn('ssid', 'Ssid', 'VARCHAR', false, 50, null);
        $this->addColumn('key', 'Key', 'VARCHAR', false, 50, null);
        $this->addColumn('province', 'Province', 'VARCHAR', false, 500, null);
        $this->addColumn('ads_location', 'AdsLocation', 'VARCHAR', false, 500, null);
        $this->addColumn('login_template', 'LoginTemplate', 'VARCHAR', false, 500, null);
        $this->addColumn('image', 'Image', 'VARCHAR', false, 1000, null);
        $this->addForeignKey('category_id', 'CategoryId', 'INTEGER', 'accesspoint_category', 'id', false, null, null);
        $this->addColumn('lng', 'Lng', 'VARCHAR', false, 1000, null);
        $this->addColumn('lat', 'Lat', 'VARCHAR', false, 1000, null);
        $this->addColumn('detail_url_id', 'DetailUrlId', 'VARCHAR', false, 50, null);
        $this->addForeignKey('section_id', 'SectionId', 'INTEGER', 'section', 'id', false, null, null);
        $this->addColumn('subsection_ids', 'SubsectionIds', 'VARCHAR', false, 1000, null);
        $this->addColumn('orders', 'Orders', 'INTEGER', false, null, null);
        $this->addColumn('suborder_ids', 'SuborderIds', 'VARCHAR', false, 1000, null);
        $this->addColumn('front_page', 'FrontPage', 'BOOLEAN', false, 1, null);
        $this->addColumn('has_comment', 'HasComment', 'BOOLEAN', false, 1, null);
        $this->addColumn('can_delete', 'CanDelete', 'BOOLEAN', false, 1, null);
        $this->addColumn('published_at', 'PublishedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('imgs', 'Imgs', 'VARCHAR', false, 1000, null);
        $this->addColumn('relative_news', 'RelativeNews', 'LONGVARCHAR', false, null, null);
        $this->addColumn('owner', 'Owner', 'VARCHAR', false, 500, null);
        $this->addForeignKey('customer_id', 'CustomerId', 'INTEGER', 'customer', 'id', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Customer', '\\Common\\DbBundle\\Model\\Customer', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':customer_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', null, false);
        $this->addRelation('Section', '\\Common\\DbBundle\\Model\\Section', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', null, false);
        $this->addRelation('AccesspointCategory', '\\Hotspot\\AccessPointBundle\\Model\\AccesspointCategory', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':category_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('AccesspointI18n', '\\Hotspot\\AccessPointBundle\\Model\\AccesspointI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, 'AccesspointI18ns', false);
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
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'name,address,pcontact,detail_url,title, strip_title, brief, content, tag, keyword, post_by, edit_by,short_link,link,locked,trash, status, pre_status, status_note,draft,read', 'i18n_pk_column' => '', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => 'vi', 'locale_alias' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to accesspoint     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AccesspointI18nTableMap::clearInstancePool();
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
        return $withPrefix ? AccesspointTableMap::CLASS_DEFAULT : AccesspointTableMap::OM_CLASS;
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
     * @return array           (Accesspoint object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AccesspointTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AccesspointTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AccesspointTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AccesspointTableMap::OM_CLASS;
            /** @var Accesspoint $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AccesspointTableMap::addInstanceToPool($obj, $key);
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
            $key = AccesspointTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AccesspointTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Accesspoint $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AccesspointTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AccesspointTableMap::COL_ID);
            $criteria->addSelectColumn(AccesspointTableMap::COL_MACADDR);
            $criteria->addSelectColumn(AccesspointTableMap::COL_AP_MACADDR);
            $criteria->addSelectColumn(AccesspointTableMap::COL_FW_VERSION);
            $criteria->addSelectColumn(AccesspointTableMap::COL_ISP);
            $criteria->addSelectColumn(AccesspointTableMap::COL_SSID);
            $criteria->addSelectColumn(AccesspointTableMap::COL_KEY);
            $criteria->addSelectColumn(AccesspointTableMap::COL_PROVINCE);
            $criteria->addSelectColumn(AccesspointTableMap::COL_ADS_LOCATION);
            $criteria->addSelectColumn(AccesspointTableMap::COL_LOGIN_TEMPLATE);
            $criteria->addSelectColumn(AccesspointTableMap::COL_IMAGE);
            $criteria->addSelectColumn(AccesspointTableMap::COL_CATEGORY_ID);
            $criteria->addSelectColumn(AccesspointTableMap::COL_LNG);
            $criteria->addSelectColumn(AccesspointTableMap::COL_LAT);
            $criteria->addSelectColumn(AccesspointTableMap::COL_DETAIL_URL_ID);
            $criteria->addSelectColumn(AccesspointTableMap::COL_SECTION_ID);
            $criteria->addSelectColumn(AccesspointTableMap::COL_SUBSECTION_IDS);
            $criteria->addSelectColumn(AccesspointTableMap::COL_ORDERS);
            $criteria->addSelectColumn(AccesspointTableMap::COL_SUBORDER_IDS);
            $criteria->addSelectColumn(AccesspointTableMap::COL_FRONT_PAGE);
            $criteria->addSelectColumn(AccesspointTableMap::COL_HAS_COMMENT);
            $criteria->addSelectColumn(AccesspointTableMap::COL_CAN_DELETE);
            $criteria->addSelectColumn(AccesspointTableMap::COL_PUBLISHED_AT);
            $criteria->addSelectColumn(AccesspointTableMap::COL_IMGS);
            $criteria->addSelectColumn(AccesspointTableMap::COL_RELATIVE_NEWS);
            $criteria->addSelectColumn(AccesspointTableMap::COL_OWNER);
            $criteria->addSelectColumn(AccesspointTableMap::COL_CUSTOMER_ID);
            $criteria->addSelectColumn(AccesspointTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(AccesspointTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.macaddr');
            $criteria->addSelectColumn($alias . '.ap_macaddr');
            $criteria->addSelectColumn($alias . '.fw_version');
            $criteria->addSelectColumn($alias . '.isp');
            $criteria->addSelectColumn($alias . '.ssid');
            $criteria->addSelectColumn($alias . '.key');
            $criteria->addSelectColumn($alias . '.province');
            $criteria->addSelectColumn($alias . '.ads_location');
            $criteria->addSelectColumn($alias . '.login_template');
            $criteria->addSelectColumn($alias . '.image');
            $criteria->addSelectColumn($alias . '.category_id');
            $criteria->addSelectColumn($alias . '.lng');
            $criteria->addSelectColumn($alias . '.lat');
            $criteria->addSelectColumn($alias . '.detail_url_id');
            $criteria->addSelectColumn($alias . '.section_id');
            $criteria->addSelectColumn($alias . '.subsection_ids');
            $criteria->addSelectColumn($alias . '.orders');
            $criteria->addSelectColumn($alias . '.suborder_ids');
            $criteria->addSelectColumn($alias . '.front_page');
            $criteria->addSelectColumn($alias . '.has_comment');
            $criteria->addSelectColumn($alias . '.can_delete');
            $criteria->addSelectColumn($alias . '.published_at');
            $criteria->addSelectColumn($alias . '.imgs');
            $criteria->addSelectColumn($alias . '.relative_news');
            $criteria->addSelectColumn($alias . '.owner');
            $criteria->addSelectColumn($alias . '.customer_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(AccesspointTableMap::DATABASE_NAME)->getTable(AccesspointTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AccesspointTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AccesspointTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AccesspointTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Accesspoint or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Accesspoint object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Hotspot\AccessPointBundle\Model\Accesspoint) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AccesspointTableMap::DATABASE_NAME);
            $criteria->add(AccesspointTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = AccesspointQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AccesspointTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AccesspointTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the accesspoint table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AccesspointQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Accesspoint or Criteria object.
     *
     * @param mixed               $criteria Criteria or Accesspoint object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Accesspoint object
        }

        if ($criteria->containsKey(AccesspointTableMap::COL_ID) && $criteria->keyContainsValue(AccesspointTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AccesspointTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = AccesspointQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AccesspointTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AccesspointTableMap::buildTableMap();
