<?php

namespace Hotspot\AccessPointBundle\Model\Map;

use Hotspot\AccessPointBundle\Model\TrackLog;
use Hotspot\AccessPointBundle\Model\TrackLogQuery;
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
 * This class defines the structure of the 'track_log' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TrackLogTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Hotspot.AccessPointBundle.Model.Map.TrackLogTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'track_log';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Hotspot\\AccessPointBundle\\Model\\TrackLog';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Hotspot.AccessPointBundle.Model.TrackLog';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 17;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 17;

    /**
     * the column name for the id field
     */
    const COL_ID = 'track_log.id';

    /**
     * the column name for the ads_id field
     */
    const COL_ADS_ID = 'track_log.ads_id';

    /**
     * the column name for the ap_macaddr field
     */
    const COL_AP_MACADDR = 'track_log.ap_macaddr';

    /**
     * the column name for the device_macaddr field
     */
    const COL_DEVICE_MACADDR = 'track_log.device_macaddr';

    /**
     * the column name for the device field
     */
    const COL_DEVICE = 'track_log.device';

    /**
     * the column name for the wan_ip field
     */
    const COL_WAN_IP = 'track_log.wan_ip';

    /**
     * the column name for the device_ip field
     */
    const COL_DEVICE_IP = 'track_log.device_ip';

    /**
     * the column name for the ap_sessionid field
     */
    const COL_AP_SESSIONID = 'track_log.ap_sessionid';

    /**
     * the column name for the web_session field
     */
    const COL_WEB_SESSION = 'track_log.web_session';

    /**
     * the column name for the user_url field
     */
    const COL_USER_URL = 'track_log.user_url';

    /**
     * the column name for the is_mobile field
     */
    const COL_IS_MOBILE = 'track_log.is_mobile';

    /**
     * the column name for the os field
     */
    const COL_OS = 'track_log.os';

    /**
     * the column name for the browser field
     */
    const COL_BROWSER = 'track_log.browser';

    /**
     * the column name for the user_agent field
     */
    const COL_USER_AGENT = 'track_log.user_agent';

    /**
     * the column name for the phase field
     */
    const COL_PHASE = 'track_log.phase';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'track_log.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'track_log.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'AdsId', 'ApMacaddr', 'DeviceMacaddr', 'Device', 'WanIp', 'DeviceIp', 'ApSessionid', 'WebSession', 'UserUrl', 'IsMobile', 'Os', 'Browser', 'UserAgent', 'Phase', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'adsId', 'apMacaddr', 'deviceMacaddr', 'device', 'wanIp', 'deviceIp', 'apSessionid', 'webSession', 'userUrl', 'isMobile', 'os', 'browser', 'userAgent', 'phase', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(TrackLogTableMap::COL_ID, TrackLogTableMap::COL_ADS_ID, TrackLogTableMap::COL_AP_MACADDR, TrackLogTableMap::COL_DEVICE_MACADDR, TrackLogTableMap::COL_DEVICE, TrackLogTableMap::COL_WAN_IP, TrackLogTableMap::COL_DEVICE_IP, TrackLogTableMap::COL_AP_SESSIONID, TrackLogTableMap::COL_WEB_SESSION, TrackLogTableMap::COL_USER_URL, TrackLogTableMap::COL_IS_MOBILE, TrackLogTableMap::COL_OS, TrackLogTableMap::COL_BROWSER, TrackLogTableMap::COL_USER_AGENT, TrackLogTableMap::COL_PHASE, TrackLogTableMap::COL_CREATED_AT, TrackLogTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'ads_id', 'ap_macaddr', 'device_macaddr', 'device', 'wan_ip', 'device_ip', 'ap_sessionid', 'web_session', 'user_url', 'is_mobile', 'os', 'browser', 'user_agent', 'phase', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'AdsId' => 1, 'ApMacaddr' => 2, 'DeviceMacaddr' => 3, 'Device' => 4, 'WanIp' => 5, 'DeviceIp' => 6, 'ApSessionid' => 7, 'WebSession' => 8, 'UserUrl' => 9, 'IsMobile' => 10, 'Os' => 11, 'Browser' => 12, 'UserAgent' => 13, 'Phase' => 14, 'CreatedAt' => 15, 'UpdatedAt' => 16, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'adsId' => 1, 'apMacaddr' => 2, 'deviceMacaddr' => 3, 'device' => 4, 'wanIp' => 5, 'deviceIp' => 6, 'apSessionid' => 7, 'webSession' => 8, 'userUrl' => 9, 'isMobile' => 10, 'os' => 11, 'browser' => 12, 'userAgent' => 13, 'phase' => 14, 'createdAt' => 15, 'updatedAt' => 16, ),
        self::TYPE_COLNAME       => array(TrackLogTableMap::COL_ID => 0, TrackLogTableMap::COL_ADS_ID => 1, TrackLogTableMap::COL_AP_MACADDR => 2, TrackLogTableMap::COL_DEVICE_MACADDR => 3, TrackLogTableMap::COL_DEVICE => 4, TrackLogTableMap::COL_WAN_IP => 5, TrackLogTableMap::COL_DEVICE_IP => 6, TrackLogTableMap::COL_AP_SESSIONID => 7, TrackLogTableMap::COL_WEB_SESSION => 8, TrackLogTableMap::COL_USER_URL => 9, TrackLogTableMap::COL_IS_MOBILE => 10, TrackLogTableMap::COL_OS => 11, TrackLogTableMap::COL_BROWSER => 12, TrackLogTableMap::COL_USER_AGENT => 13, TrackLogTableMap::COL_PHASE => 14, TrackLogTableMap::COL_CREATED_AT => 15, TrackLogTableMap::COL_UPDATED_AT => 16, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'ads_id' => 1, 'ap_macaddr' => 2, 'device_macaddr' => 3, 'device' => 4, 'wan_ip' => 5, 'device_ip' => 6, 'ap_sessionid' => 7, 'web_session' => 8, 'user_url' => 9, 'is_mobile' => 10, 'os' => 11, 'browser' => 12, 'user_agent' => 13, 'phase' => 14, 'created_at' => 15, 'updated_at' => 16, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
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
        $this->setName('track_log');
        $this->setPhpName('TrackLog');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Hotspot\\AccessPointBundle\\Model\\TrackLog');
        $this->setPackage('src.Hotspot.AccessPointBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('ads_id', 'AdsId', 'INTEGER', false, null, 0);
        $this->addColumn('ap_macaddr', 'ApMacaddr', 'VARCHAR', false, 50, null);
        $this->addColumn('device_macaddr', 'DeviceMacaddr', 'VARCHAR', false, 50, null);
        $this->addColumn('device', 'Device', 'VARCHAR', false, 1000, null);
        $this->addColumn('wan_ip', 'WanIp', 'VARCHAR', false, 100, null);
        $this->addColumn('device_ip', 'DeviceIp', 'VARCHAR', false, 100, null);
        $this->addColumn('ap_sessionid', 'ApSessionid', 'VARCHAR', false, 200, null);
        $this->addColumn('web_session', 'WebSession', 'VARCHAR', false, 200, null);
        $this->addColumn('user_url', 'UserUrl', 'VARCHAR', false, 1000, null);
        $this->addColumn('is_mobile', 'IsMobile', 'INTEGER', false, null, 0);
        $this->addColumn('os', 'Os', 'VARCHAR', false, 200, null);
        $this->addColumn('browser', 'Browser', 'VARCHAR', false, 200, null);
        $this->addColumn('user_agent', 'UserAgent', 'VARCHAR', false, 1000, null);
        $this->addColumn('phase', 'Phase', 'VARCHAR', false, 50, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
            'query_cache' => array('backend' => 'custom', 'lifetime' => '600', ),
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

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
        return $withPrefix ? TrackLogTableMap::CLASS_DEFAULT : TrackLogTableMap::OM_CLASS;
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
     * @return array           (TrackLog object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TrackLogTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TrackLogTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TrackLogTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TrackLogTableMap::OM_CLASS;
            /** @var TrackLog $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TrackLogTableMap::addInstanceToPool($obj, $key);
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
            $key = TrackLogTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TrackLogTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TrackLog $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TrackLogTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TrackLogTableMap::COL_ID);
            $criteria->addSelectColumn(TrackLogTableMap::COL_ADS_ID);
            $criteria->addSelectColumn(TrackLogTableMap::COL_AP_MACADDR);
            $criteria->addSelectColumn(TrackLogTableMap::COL_DEVICE_MACADDR);
            $criteria->addSelectColumn(TrackLogTableMap::COL_DEVICE);
            $criteria->addSelectColumn(TrackLogTableMap::COL_WAN_IP);
            $criteria->addSelectColumn(TrackLogTableMap::COL_DEVICE_IP);
            $criteria->addSelectColumn(TrackLogTableMap::COL_AP_SESSIONID);
            $criteria->addSelectColumn(TrackLogTableMap::COL_WEB_SESSION);
            $criteria->addSelectColumn(TrackLogTableMap::COL_USER_URL);
            $criteria->addSelectColumn(TrackLogTableMap::COL_IS_MOBILE);
            $criteria->addSelectColumn(TrackLogTableMap::COL_OS);
            $criteria->addSelectColumn(TrackLogTableMap::COL_BROWSER);
            $criteria->addSelectColumn(TrackLogTableMap::COL_USER_AGENT);
            $criteria->addSelectColumn(TrackLogTableMap::COL_PHASE);
            $criteria->addSelectColumn(TrackLogTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(TrackLogTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.ads_id');
            $criteria->addSelectColumn($alias . '.ap_macaddr');
            $criteria->addSelectColumn($alias . '.device_macaddr');
            $criteria->addSelectColumn($alias . '.device');
            $criteria->addSelectColumn($alias . '.wan_ip');
            $criteria->addSelectColumn($alias . '.device_ip');
            $criteria->addSelectColumn($alias . '.ap_sessionid');
            $criteria->addSelectColumn($alias . '.web_session');
            $criteria->addSelectColumn($alias . '.user_url');
            $criteria->addSelectColumn($alias . '.is_mobile');
            $criteria->addSelectColumn($alias . '.os');
            $criteria->addSelectColumn($alias . '.browser');
            $criteria->addSelectColumn($alias . '.user_agent');
            $criteria->addSelectColumn($alias . '.phase');
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
        return Propel::getServiceContainer()->getDatabaseMap(TrackLogTableMap::DATABASE_NAME)->getTable(TrackLogTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TrackLogTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TrackLogTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TrackLogTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a TrackLog or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TrackLog object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TrackLogTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Hotspot\AccessPointBundle\Model\TrackLog) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TrackLogTableMap::DATABASE_NAME);
            $criteria->add(TrackLogTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = TrackLogQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TrackLogTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TrackLogTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the track_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TrackLogQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TrackLog or Criteria object.
     *
     * @param mixed               $criteria Criteria or TrackLog object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrackLogTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TrackLog object
        }

        if ($criteria->containsKey(TrackLogTableMap::COL_ID) && $criteria->keyContainsValue(TrackLogTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TrackLogTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = TrackLogQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TrackLogTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TrackLogTableMap::buildTableMap();
