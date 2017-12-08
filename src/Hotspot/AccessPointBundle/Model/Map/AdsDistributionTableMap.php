<?php

namespace Hotspot\AccessPointBundle\Model\Map;

use Hotspot\AccessPointBundle\Model\AdsDistribution;
use Hotspot\AccessPointBundle\Model\AdsDistributionQuery;
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
 * This class defines the structure of the 'ads_distribution' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AdsDistributionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Hotspot.AccessPointBundle.Model.Map.AdsDistributionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'ads_distribution';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Hotspot\\AccessPointBundle\\Model\\AdsDistribution';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Hotspot.AccessPointBundle.Model.AdsDistribution';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'ads_distribution.id';

    /**
     * the column name for the advert_id field
     */
    const COL_ADVERT_ID = 'ads_distribution.advert_id';

    /**
     * the column name for the current field
     */
    const COL_CURRENT = 'ads_distribution.current';

    /**
     * the column name for the ratio field
     */
    const COL_RATIO = 'ads_distribution.ratio';

    /**
     * the column name for the location field
     */
    const COL_LOCATION = 'ads_distribution.location';

    /**
     * the column name for the platform field
     */
    const COL_PLATFORM = 'ads_distribution.platform';

    /**
     * the column name for the platform_version field
     */
    const COL_PLATFORM_VERSION = 'ads_distribution.platform_version';

    /**
     * the column name for the is_showing field
     */
    const COL_IS_SHOWING = 'ads_distribution.is_showing';

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
        self::TYPE_PHPNAME       => array('Id', 'AdvertId', 'Current', 'Ratio', 'Location', 'Platform', 'PlatformVersion', 'IsShowing', ),
        self::TYPE_CAMELNAME     => array('id', 'advertId', 'current', 'ratio', 'location', 'platform', 'platformVersion', 'isShowing', ),
        self::TYPE_COLNAME       => array(AdsDistributionTableMap::COL_ID, AdsDistributionTableMap::COL_ADVERT_ID, AdsDistributionTableMap::COL_CURRENT, AdsDistributionTableMap::COL_RATIO, AdsDistributionTableMap::COL_LOCATION, AdsDistributionTableMap::COL_PLATFORM, AdsDistributionTableMap::COL_PLATFORM_VERSION, AdsDistributionTableMap::COL_IS_SHOWING, ),
        self::TYPE_FIELDNAME     => array('id', 'advert_id', 'current', 'ratio', 'location', 'platform', 'platform_version', 'is_showing', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'AdvertId' => 1, 'Current' => 2, 'Ratio' => 3, 'Location' => 4, 'Platform' => 5, 'PlatformVersion' => 6, 'IsShowing' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'advertId' => 1, 'current' => 2, 'ratio' => 3, 'location' => 4, 'platform' => 5, 'platformVersion' => 6, 'isShowing' => 7, ),
        self::TYPE_COLNAME       => array(AdsDistributionTableMap::COL_ID => 0, AdsDistributionTableMap::COL_ADVERT_ID => 1, AdsDistributionTableMap::COL_CURRENT => 2, AdsDistributionTableMap::COL_RATIO => 3, AdsDistributionTableMap::COL_LOCATION => 4, AdsDistributionTableMap::COL_PLATFORM => 5, AdsDistributionTableMap::COL_PLATFORM_VERSION => 6, AdsDistributionTableMap::COL_IS_SHOWING => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'advert_id' => 1, 'current' => 2, 'ratio' => 3, 'location' => 4, 'platform' => 5, 'platform_version' => 6, 'is_showing' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('ads_distribution');
        $this->setPhpName('AdsDistribution');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Hotspot\\AccessPointBundle\\Model\\AdsDistribution');
        $this->setPackage('src.Hotspot.AccessPointBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('advert_id', 'AdvertId', 'INTEGER', false, null, null);
        $this->addColumn('current', 'Current', 'INTEGER', false, null, 0);
        $this->addColumn('ratio', 'Ratio', 'FLOAT', false, null, 1);
        $this->addColumn('location', 'Location', 'VARCHAR', false, 1024, null);
        $this->addColumn('platform', 'Platform', 'VARCHAR', false, 500, null);
        $this->addColumn('platform_version', 'PlatformVersion', 'VARCHAR', false, 500, null);
        $this->addColumn('is_showing', 'IsShowing', 'INTEGER', false, null, 1);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

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
        return $withPrefix ? AdsDistributionTableMap::CLASS_DEFAULT : AdsDistributionTableMap::OM_CLASS;
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
     * @return array           (AdsDistribution object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AdsDistributionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AdsDistributionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AdsDistributionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AdsDistributionTableMap::OM_CLASS;
            /** @var AdsDistribution $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AdsDistributionTableMap::addInstanceToPool($obj, $key);
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
            $key = AdsDistributionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AdsDistributionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AdsDistribution $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AdsDistributionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AdsDistributionTableMap::COL_ID);
            $criteria->addSelectColumn(AdsDistributionTableMap::COL_ADVERT_ID);
            $criteria->addSelectColumn(AdsDistributionTableMap::COL_CURRENT);
            $criteria->addSelectColumn(AdsDistributionTableMap::COL_RATIO);
            $criteria->addSelectColumn(AdsDistributionTableMap::COL_LOCATION);
            $criteria->addSelectColumn(AdsDistributionTableMap::COL_PLATFORM);
            $criteria->addSelectColumn(AdsDistributionTableMap::COL_PLATFORM_VERSION);
            $criteria->addSelectColumn(AdsDistributionTableMap::COL_IS_SHOWING);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.advert_id');
            $criteria->addSelectColumn($alias . '.current');
            $criteria->addSelectColumn($alias . '.ratio');
            $criteria->addSelectColumn($alias . '.location');
            $criteria->addSelectColumn($alias . '.platform');
            $criteria->addSelectColumn($alias . '.platform_version');
            $criteria->addSelectColumn($alias . '.is_showing');
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
        return Propel::getServiceContainer()->getDatabaseMap(AdsDistributionTableMap::DATABASE_NAME)->getTable(AdsDistributionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AdsDistributionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AdsDistributionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AdsDistributionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a AdsDistribution or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AdsDistribution object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AdsDistributionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Hotspot\AccessPointBundle\Model\AdsDistribution) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AdsDistributionTableMap::DATABASE_NAME);
            $criteria->add(AdsDistributionTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = AdsDistributionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AdsDistributionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AdsDistributionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ads_distribution table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AdsDistributionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AdsDistribution or Criteria object.
     *
     * @param mixed               $criteria Criteria or AdsDistribution object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdsDistributionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AdsDistribution object
        }

        if ($criteria->containsKey(AdsDistributionTableMap::COL_ID) && $criteria->keyContainsValue(AdsDistributionTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AdsDistributionTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = AdsDistributionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AdsDistributionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AdsDistributionTableMap::buildTableMap();
