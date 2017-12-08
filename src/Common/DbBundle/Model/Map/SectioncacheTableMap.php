<?php

namespace Common\DbBundle\Model\Map;

use Common\DbBundle\Model\Sectioncache;
use Common\DbBundle\Model\SectioncacheQuery;
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
 * This class defines the structure of the 'sectioncache' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SectioncacheTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Common.DbBundle.Model.Map.SectioncacheTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'sectioncache';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Common\\DbBundle\\Model\\Sectioncache';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Common.DbBundle.Model.Sectioncache';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the section_id field
     */
    const COL_SECTION_ID = 'sectioncache.section_id';

    /**
     * the column name for the news_id field
     */
    const COL_NEWS_ID = 'sectioncache.news_id';

    /**
     * the column name for the locale field
     */
    const COL_LOCALE = 'sectioncache.locale';

    /**
     * the column name for the link field
     */
    const COL_LINK = 'sectioncache.link';

    /**
     * the column name for the orders field
     */
    const COL_ORDERS = 'sectioncache.orders';

    /**
     * the column name for the read field
     */
    const COL_READ = 'sectioncache.read';

    /**
     * the column name for the published_at field
     */
    const COL_PUBLISHED_AT = 'sectioncache.published_at';

    /**
     * the column name for the locked field
     */
    const COL_LOCKED = 'sectioncache.locked';

    /**
     * the column name for the front_page field
     */
    const COL_FRONT_PAGE = 'sectioncache.front_page';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('SectionId', 'NewsId', 'Locale', 'Link', 'Orders', 'Read', 'PublishedAt', 'Locked', 'FrontPage', ),
        self::TYPE_CAMELNAME     => array('sectionId', 'newsId', 'locale', 'link', 'orders', 'read', 'publishedAt', 'locked', 'frontPage', ),
        self::TYPE_COLNAME       => array(SectioncacheTableMap::COL_SECTION_ID, SectioncacheTableMap::COL_NEWS_ID, SectioncacheTableMap::COL_LOCALE, SectioncacheTableMap::COL_LINK, SectioncacheTableMap::COL_ORDERS, SectioncacheTableMap::COL_READ, SectioncacheTableMap::COL_PUBLISHED_AT, SectioncacheTableMap::COL_LOCKED, SectioncacheTableMap::COL_FRONT_PAGE, ),
        self::TYPE_FIELDNAME     => array('section_id', 'news_id', 'locale', 'link', 'orders', 'read', 'published_at', 'locked', 'front_page', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('SectionId' => 0, 'NewsId' => 1, 'Locale' => 2, 'Link' => 3, 'Orders' => 4, 'Read' => 5, 'PublishedAt' => 6, 'Locked' => 7, 'FrontPage' => 8, ),
        self::TYPE_CAMELNAME     => array('sectionId' => 0, 'newsId' => 1, 'locale' => 2, 'link' => 3, 'orders' => 4, 'read' => 5, 'publishedAt' => 6, 'locked' => 7, 'frontPage' => 8, ),
        self::TYPE_COLNAME       => array(SectioncacheTableMap::COL_SECTION_ID => 0, SectioncacheTableMap::COL_NEWS_ID => 1, SectioncacheTableMap::COL_LOCALE => 2, SectioncacheTableMap::COL_LINK => 3, SectioncacheTableMap::COL_ORDERS => 4, SectioncacheTableMap::COL_READ => 5, SectioncacheTableMap::COL_PUBLISHED_AT => 6, SectioncacheTableMap::COL_LOCKED => 7, SectioncacheTableMap::COL_FRONT_PAGE => 8, ),
        self::TYPE_FIELDNAME     => array('section_id' => 0, 'news_id' => 1, 'locale' => 2, 'link' => 3, 'orders' => 4, 'read' => 5, 'published_at' => 6, 'locked' => 7, 'front_page' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('sectioncache');
        $this->setPhpName('Sectioncache');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Common\\DbBundle\\Model\\Sectioncache');
        $this->setPackage('src.Common.DbBundle.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('section_id', 'SectionId', 'INTEGER', true, null, null);
        $this->addPrimaryKey('news_id', 'NewsId', 'INTEGER', true, null, null);
        $this->addPrimaryKey('locale', 'Locale', 'VARCHAR', true, 30, null);
        $this->addColumn('link', 'Link', 'VARCHAR', false, 1000, null);
        $this->addColumn('orders', 'Orders', 'INTEGER', false, null, null);
        $this->addColumn('read', 'Read', 'INTEGER', false, null, null);
        $this->addColumn('published_at', 'PublishedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('locked', 'Locked', 'BOOLEAN', false, 1, true);
        $this->addColumn('front_page', 'FrontPage', 'BOOLEAN', false, 1, true);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \Common\DbBundle\Model\Sectioncache $obj A \Common\DbBundle\Model\Sectioncache object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getSectionId() || is_scalar($obj->getSectionId()) || is_callable([$obj->getSectionId(), '__toString']) ? (string) $obj->getSectionId() : $obj->getSectionId()), (null === $obj->getNewsId() || is_scalar($obj->getNewsId()) || is_callable([$obj->getNewsId(), '__toString']) ? (string) $obj->getNewsId() : $obj->getNewsId()), (null === $obj->getLocale() || is_scalar($obj->getLocale()) || is_callable([$obj->getLocale(), '__toString']) ? (string) $obj->getLocale() : $obj->getLocale())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \Common\DbBundle\Model\Sectioncache object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Common\DbBundle\Model\Sectioncache) {
                $key = serialize([(null === $value->getSectionId() || is_scalar($value->getSectionId()) || is_callable([$value->getSectionId(), '__toString']) ? (string) $value->getSectionId() : $value->getSectionId()), (null === $value->getNewsId() || is_scalar($value->getNewsId()) || is_callable([$value->getNewsId(), '__toString']) ? (string) $value->getNewsId() : $value->getNewsId()), (null === $value->getLocale() || is_scalar($value->getLocale()) || is_callable([$value->getLocale(), '__toString']) ? (string) $value->getLocale() : $value->getLocale())]);

            } elseif (is_array($value) && count($value) === 3) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1]), (null === $value[2] || is_scalar($value[2]) || is_callable([$value[2], '__toString']) ? (string) $value[2] : $value[2])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Common\DbBundle\Model\Sectioncache object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('NewsId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('NewsId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('NewsId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('NewsId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('NewsId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('NewsId', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)])]);
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
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('NewsId', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 2 + $offset
                : self::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
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
        return $withPrefix ? SectioncacheTableMap::CLASS_DEFAULT : SectioncacheTableMap::OM_CLASS;
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
     * @return array           (Sectioncache object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SectioncacheTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SectioncacheTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SectioncacheTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SectioncacheTableMap::OM_CLASS;
            /** @var Sectioncache $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SectioncacheTableMap::addInstanceToPool($obj, $key);
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
            $key = SectioncacheTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SectioncacheTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Sectioncache $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SectioncacheTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SectioncacheTableMap::COL_SECTION_ID);
            $criteria->addSelectColumn(SectioncacheTableMap::COL_NEWS_ID);
            $criteria->addSelectColumn(SectioncacheTableMap::COL_LOCALE);
            $criteria->addSelectColumn(SectioncacheTableMap::COL_LINK);
            $criteria->addSelectColumn(SectioncacheTableMap::COL_ORDERS);
            $criteria->addSelectColumn(SectioncacheTableMap::COL_READ);
            $criteria->addSelectColumn(SectioncacheTableMap::COL_PUBLISHED_AT);
            $criteria->addSelectColumn(SectioncacheTableMap::COL_LOCKED);
            $criteria->addSelectColumn(SectioncacheTableMap::COL_FRONT_PAGE);
        } else {
            $criteria->addSelectColumn($alias . '.section_id');
            $criteria->addSelectColumn($alias . '.news_id');
            $criteria->addSelectColumn($alias . '.locale');
            $criteria->addSelectColumn($alias . '.link');
            $criteria->addSelectColumn($alias . '.orders');
            $criteria->addSelectColumn($alias . '.read');
            $criteria->addSelectColumn($alias . '.published_at');
            $criteria->addSelectColumn($alias . '.locked');
            $criteria->addSelectColumn($alias . '.front_page');
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
        return Propel::getServiceContainer()->getDatabaseMap(SectioncacheTableMap::DATABASE_NAME)->getTable(SectioncacheTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SectioncacheTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SectioncacheTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SectioncacheTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Sectioncache or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Sectioncache object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SectioncacheTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Common\DbBundle\Model\Sectioncache) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SectioncacheTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(SectioncacheTableMap::COL_SECTION_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(SectioncacheTableMap::COL_NEWS_ID, $value[1]));
                $criterion->addAnd($criteria->getNewCriterion(SectioncacheTableMap::COL_LOCALE, $value[2]));
                $criteria->addOr($criterion);
            }
        }

        $query = SectioncacheQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SectioncacheTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SectioncacheTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the sectioncache table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SectioncacheQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Sectioncache or Criteria object.
     *
     * @param mixed               $criteria Criteria or Sectioncache object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SectioncacheTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Sectioncache object
        }


        // Set the correct dbName
        $query = SectioncacheQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SectioncacheTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SectioncacheTableMap::buildTableMap();
