<?php

namespace Common\DbBundle\Model\Map;

use Common\DbBundle\Model\Marker;
use Common\DbBundle\Model\MarkerQuery;
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
 * This class defines the structure of the 'marker' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MarkerTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Common.DbBundle.Model.Map.MarkerTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'marker';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Common\\DbBundle\\Model\\Marker';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Common.DbBundle.Model.Marker';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 18;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 18;

    /**
     * the column name for the id field
     */
    const COL_ID = 'marker.id';

    /**
     * the column name for the image field
     */
    const COL_IMAGE = 'marker.image';

    /**
     * the column name for the category_id field
     */
    const COL_CATEGORY_ID = 'marker.category_id';

    /**
     * the column name for the longitude field
     */
    const COL_LONGITUDE = 'marker.longitude';

    /**
     * the column name for the latitude field
     */
    const COL_LATITUDE = 'marker.latitude';

    /**
     * the column name for the detail_url_id field
     */
    const COL_DETAIL_URL_ID = 'marker.detail_url_id';

    /**
     * the column name for the section_id field
     */
    const COL_SECTION_ID = 'marker.section_id';

    /**
     * the column name for the subsection_ids field
     */
    const COL_SUBSECTION_IDS = 'marker.subsection_ids';

    /**
     * the column name for the orders field
     */
    const COL_ORDERS = 'marker.orders';

    /**
     * the column name for the suborder_ids field
     */
    const COL_SUBORDER_IDS = 'marker.suborder_ids';

    /**
     * the column name for the front_page field
     */
    const COL_FRONT_PAGE = 'marker.front_page';

    /**
     * the column name for the has_comment field
     */
    const COL_HAS_COMMENT = 'marker.has_comment';

    /**
     * the column name for the can_delete field
     */
    const COL_CAN_DELETE = 'marker.can_delete';

    /**
     * the column name for the published_at field
     */
    const COL_PUBLISHED_AT = 'marker.published_at';

    /**
     * the column name for the imgs field
     */
    const COL_IMGS = 'marker.imgs';

    /**
     * the column name for the relative_news field
     */
    const COL_RELATIVE_NEWS = 'marker.relative_news';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'marker.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'marker.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'Image', 'CategoryId', 'Longitude', 'Latitude', 'DetailUrlId', 'SectionId', 'SubsectionIds', 'Orders', 'SuborderIds', 'FrontPage', 'HasComment', 'CanDelete', 'PublishedAt', 'Imgs', 'RelativeNews', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'image', 'categoryId', 'longitude', 'latitude', 'detailUrlId', 'sectionId', 'subsectionIds', 'orders', 'suborderIds', 'frontPage', 'hasComment', 'canDelete', 'publishedAt', 'imgs', 'relativeNews', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(MarkerTableMap::COL_ID, MarkerTableMap::COL_IMAGE, MarkerTableMap::COL_CATEGORY_ID, MarkerTableMap::COL_LONGITUDE, MarkerTableMap::COL_LATITUDE, MarkerTableMap::COL_DETAIL_URL_ID, MarkerTableMap::COL_SECTION_ID, MarkerTableMap::COL_SUBSECTION_IDS, MarkerTableMap::COL_ORDERS, MarkerTableMap::COL_SUBORDER_IDS, MarkerTableMap::COL_FRONT_PAGE, MarkerTableMap::COL_HAS_COMMENT, MarkerTableMap::COL_CAN_DELETE, MarkerTableMap::COL_PUBLISHED_AT, MarkerTableMap::COL_IMGS, MarkerTableMap::COL_RELATIVE_NEWS, MarkerTableMap::COL_CREATED_AT, MarkerTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'image', 'category_id', 'longitude', 'latitude', 'detail_url_id', 'section_id', 'subsection_ids', 'orders', 'suborder_ids', 'front_page', 'has_comment', 'can_delete', 'published_at', 'imgs', 'relative_news', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Image' => 1, 'CategoryId' => 2, 'Longitude' => 3, 'Latitude' => 4, 'DetailUrlId' => 5, 'SectionId' => 6, 'SubsectionIds' => 7, 'Orders' => 8, 'SuborderIds' => 9, 'FrontPage' => 10, 'HasComment' => 11, 'CanDelete' => 12, 'PublishedAt' => 13, 'Imgs' => 14, 'RelativeNews' => 15, 'CreatedAt' => 16, 'UpdatedAt' => 17, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'image' => 1, 'categoryId' => 2, 'longitude' => 3, 'latitude' => 4, 'detailUrlId' => 5, 'sectionId' => 6, 'subsectionIds' => 7, 'orders' => 8, 'suborderIds' => 9, 'frontPage' => 10, 'hasComment' => 11, 'canDelete' => 12, 'publishedAt' => 13, 'imgs' => 14, 'relativeNews' => 15, 'createdAt' => 16, 'updatedAt' => 17, ),
        self::TYPE_COLNAME       => array(MarkerTableMap::COL_ID => 0, MarkerTableMap::COL_IMAGE => 1, MarkerTableMap::COL_CATEGORY_ID => 2, MarkerTableMap::COL_LONGITUDE => 3, MarkerTableMap::COL_LATITUDE => 4, MarkerTableMap::COL_DETAIL_URL_ID => 5, MarkerTableMap::COL_SECTION_ID => 6, MarkerTableMap::COL_SUBSECTION_IDS => 7, MarkerTableMap::COL_ORDERS => 8, MarkerTableMap::COL_SUBORDER_IDS => 9, MarkerTableMap::COL_FRONT_PAGE => 10, MarkerTableMap::COL_HAS_COMMENT => 11, MarkerTableMap::COL_CAN_DELETE => 12, MarkerTableMap::COL_PUBLISHED_AT => 13, MarkerTableMap::COL_IMGS => 14, MarkerTableMap::COL_RELATIVE_NEWS => 15, MarkerTableMap::COL_CREATED_AT => 16, MarkerTableMap::COL_UPDATED_AT => 17, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'image' => 1, 'category_id' => 2, 'longitude' => 3, 'latitude' => 4, 'detail_url_id' => 5, 'section_id' => 6, 'subsection_ids' => 7, 'orders' => 8, 'suborder_ids' => 9, 'front_page' => 10, 'has_comment' => 11, 'can_delete' => 12, 'published_at' => 13, 'imgs' => 14, 'relative_news' => 15, 'created_at' => 16, 'updated_at' => 17, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
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
        $this->setName('marker');
        $this->setPhpName('Marker');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Common\\DbBundle\\Model\\Marker');
        $this->setPackage('src.Common.DbBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('image', 'Image', 'VARCHAR', false, 1000, null);
        $this->addForeignKey('category_id', 'CategoryId', 'INTEGER', 'marker_category', 'id', false, null, null);
        $this->addColumn('longitude', 'Longitude', 'VARCHAR', false, 1000, null);
        $this->addColumn('latitude', 'Latitude', 'VARCHAR', false, 1000, null);
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
        $this->addRelation('MarkerCategory', '\\Common\\DbBundle\\Model\\MarkerCategory', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':category_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('MarkerI18n', '\\Common\\DbBundle\\Model\\MarkerI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, 'MarkerI18ns', false);
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
     * Method to invalidate the instance pool of all tables related to marker     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        MarkerI18nTableMap::clearInstancePool();
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
        return $withPrefix ? MarkerTableMap::CLASS_DEFAULT : MarkerTableMap::OM_CLASS;
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
     * @return array           (Marker object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MarkerTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MarkerTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MarkerTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MarkerTableMap::OM_CLASS;
            /** @var Marker $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MarkerTableMap::addInstanceToPool($obj, $key);
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
            $key = MarkerTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MarkerTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Marker $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MarkerTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MarkerTableMap::COL_ID);
            $criteria->addSelectColumn(MarkerTableMap::COL_IMAGE);
            $criteria->addSelectColumn(MarkerTableMap::COL_CATEGORY_ID);
            $criteria->addSelectColumn(MarkerTableMap::COL_LONGITUDE);
            $criteria->addSelectColumn(MarkerTableMap::COL_LATITUDE);
            $criteria->addSelectColumn(MarkerTableMap::COL_DETAIL_URL_ID);
            $criteria->addSelectColumn(MarkerTableMap::COL_SECTION_ID);
            $criteria->addSelectColumn(MarkerTableMap::COL_SUBSECTION_IDS);
            $criteria->addSelectColumn(MarkerTableMap::COL_ORDERS);
            $criteria->addSelectColumn(MarkerTableMap::COL_SUBORDER_IDS);
            $criteria->addSelectColumn(MarkerTableMap::COL_FRONT_PAGE);
            $criteria->addSelectColumn(MarkerTableMap::COL_HAS_COMMENT);
            $criteria->addSelectColumn(MarkerTableMap::COL_CAN_DELETE);
            $criteria->addSelectColumn(MarkerTableMap::COL_PUBLISHED_AT);
            $criteria->addSelectColumn(MarkerTableMap::COL_IMGS);
            $criteria->addSelectColumn(MarkerTableMap::COL_RELATIVE_NEWS);
            $criteria->addSelectColumn(MarkerTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(MarkerTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.image');
            $criteria->addSelectColumn($alias . '.category_id');
            $criteria->addSelectColumn($alias . '.longitude');
            $criteria->addSelectColumn($alias . '.latitude');
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
        return Propel::getServiceContainer()->getDatabaseMap(MarkerTableMap::DATABASE_NAME)->getTable(MarkerTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(MarkerTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(MarkerTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new MarkerTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Marker or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Marker object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MarkerTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Common\DbBundle\Model\Marker) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MarkerTableMap::DATABASE_NAME);
            $criteria->add(MarkerTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = MarkerQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            MarkerTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                MarkerTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the marker table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MarkerQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Marker or Criteria object.
     *
     * @param mixed               $criteria Criteria or Marker object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MarkerTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Marker object
        }

        if ($criteria->containsKey(MarkerTableMap::COL_ID) && $criteria->keyContainsValue(MarkerTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MarkerTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = MarkerQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // MarkerTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MarkerTableMap::buildTableMap();
