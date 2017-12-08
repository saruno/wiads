<?php

namespace Common\DbBundle\Model\Map;

use Common\DbBundle\Model\UserLogin;
use Common\DbBundle\Model\UserLoginQuery;
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
 * This class defines the structure of the 'user_login' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UserLoginTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Common.DbBundle.Model.Map.UserLoginTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'user_login';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Common\\DbBundle\\Model\\UserLogin';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Common.DbBundle.Model.UserLogin';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the id field
     */
    const COL_ID = 'user_login.id';

    /**
     * the column name for the uid field
     */
    const COL_UID = 'user_login.uid';

    /**
     * the column name for the username field
     */
    const COL_USERNAME = 'user_login.username';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'user_login.email';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'user_login.type';

    /**
     * the column name for the fullname field
     */
    const COL_FULLNAME = 'user_login.fullname';

    /**
     * the column name for the address field
     */
    const COL_ADDRESS = 'user_login.address';

    /**
     * the column name for the phone field
     */
    const COL_PHONE = 'user_login.phone';

    /**
     * the column name for the location field
     */
    const COL_LOCATION = 'user_login.location';

    /**
     * the column name for the ap_macaddr field
     */
    const COL_AP_MACADDR = 'user_login.ap_macaddr';

    /**
     * the column name for the advert_id field
     */
    const COL_ADVERT_ID = 'user_login.advert_id';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'user_login.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'user_login.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'Uid', 'Username', 'Email', 'Type', 'Fullname', 'Address', 'Phone', 'Location', 'ApMacaddr', 'AdvertId', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'uid', 'username', 'email', 'type', 'fullname', 'address', 'phone', 'location', 'apMacaddr', 'advertId', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(UserLoginTableMap::COL_ID, UserLoginTableMap::COL_UID, UserLoginTableMap::COL_USERNAME, UserLoginTableMap::COL_EMAIL, UserLoginTableMap::COL_TYPE, UserLoginTableMap::COL_FULLNAME, UserLoginTableMap::COL_ADDRESS, UserLoginTableMap::COL_PHONE, UserLoginTableMap::COL_LOCATION, UserLoginTableMap::COL_AP_MACADDR, UserLoginTableMap::COL_ADVERT_ID, UserLoginTableMap::COL_CREATED_AT, UserLoginTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'uid', 'username', 'email', 'type', 'fullname', 'address', 'phone', 'location', 'ap_macaddr', 'advert_id', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Uid' => 1, 'Username' => 2, 'Email' => 3, 'Type' => 4, 'Fullname' => 5, 'Address' => 6, 'Phone' => 7, 'Location' => 8, 'ApMacaddr' => 9, 'AdvertId' => 10, 'CreatedAt' => 11, 'UpdatedAt' => 12, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'uid' => 1, 'username' => 2, 'email' => 3, 'type' => 4, 'fullname' => 5, 'address' => 6, 'phone' => 7, 'location' => 8, 'apMacaddr' => 9, 'advertId' => 10, 'createdAt' => 11, 'updatedAt' => 12, ),
        self::TYPE_COLNAME       => array(UserLoginTableMap::COL_ID => 0, UserLoginTableMap::COL_UID => 1, UserLoginTableMap::COL_USERNAME => 2, UserLoginTableMap::COL_EMAIL => 3, UserLoginTableMap::COL_TYPE => 4, UserLoginTableMap::COL_FULLNAME => 5, UserLoginTableMap::COL_ADDRESS => 6, UserLoginTableMap::COL_PHONE => 7, UserLoginTableMap::COL_LOCATION => 8, UserLoginTableMap::COL_AP_MACADDR => 9, UserLoginTableMap::COL_ADVERT_ID => 10, UserLoginTableMap::COL_CREATED_AT => 11, UserLoginTableMap::COL_UPDATED_AT => 12, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'uid' => 1, 'username' => 2, 'email' => 3, 'type' => 4, 'fullname' => 5, 'address' => 6, 'phone' => 7, 'location' => 8, 'ap_macaddr' => 9, 'advert_id' => 10, 'created_at' => 11, 'updated_at' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
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
        $this->setName('user_login');
        $this->setPhpName('UserLogin');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Common\\DbBundle\\Model\\UserLogin');
        $this->setPackage('src.Common.DbBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('uid', 'Uid', 'VARCHAR', false, 250, null);
        $this->addColumn('username', 'Username', 'VARCHAR', false, 250, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 250, null);
        $this->addColumn('type', 'Type', 'VARCHAR', false, 250, null);
        $this->addColumn('fullname', 'Fullname', 'VARCHAR', false, 250, null);
        $this->addColumn('address', 'Address', 'VARCHAR', false, 250, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 250, null);
        $this->addColumn('location', 'Location', 'VARCHAR', false, 250, null);
        $this->addColumn('ap_macaddr', 'ApMacaddr', 'VARCHAR', false, 250, null);
        $this->addColumn('advert_id', 'AdvertId', 'INTEGER', false, null, null);
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
        return $withPrefix ? UserLoginTableMap::CLASS_DEFAULT : UserLoginTableMap::OM_CLASS;
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
     * @return array           (UserLogin object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UserLoginTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UserLoginTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserLoginTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserLoginTableMap::OM_CLASS;
            /** @var UserLogin $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserLoginTableMap::addInstanceToPool($obj, $key);
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
            $key = UserLoginTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UserLoginTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var UserLogin $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UserLoginTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(UserLoginTableMap::COL_ID);
            $criteria->addSelectColumn(UserLoginTableMap::COL_UID);
            $criteria->addSelectColumn(UserLoginTableMap::COL_USERNAME);
            $criteria->addSelectColumn(UserLoginTableMap::COL_EMAIL);
            $criteria->addSelectColumn(UserLoginTableMap::COL_TYPE);
            $criteria->addSelectColumn(UserLoginTableMap::COL_FULLNAME);
            $criteria->addSelectColumn(UserLoginTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(UserLoginTableMap::COL_PHONE);
            $criteria->addSelectColumn(UserLoginTableMap::COL_LOCATION);
            $criteria->addSelectColumn(UserLoginTableMap::COL_AP_MACADDR);
            $criteria->addSelectColumn(UserLoginTableMap::COL_ADVERT_ID);
            $criteria->addSelectColumn(UserLoginTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(UserLoginTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.uid');
            $criteria->addSelectColumn($alias . '.username');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.fullname');
            $criteria->addSelectColumn($alias . '.address');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.location');
            $criteria->addSelectColumn($alias . '.ap_macaddr');
            $criteria->addSelectColumn($alias . '.advert_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(UserLoginTableMap::DATABASE_NAME)->getTable(UserLoginTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UserLoginTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UserLoginTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UserLoginTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a UserLogin or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or UserLogin object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserLoginTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Common\DbBundle\Model\UserLogin) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserLoginTableMap::DATABASE_NAME);
            $criteria->add(UserLoginTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = UserLoginQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserLoginTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UserLoginTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the user_login table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UserLoginQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a UserLogin or Criteria object.
     *
     * @param mixed               $criteria Criteria or UserLogin object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserLoginTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from UserLogin object
        }

        if ($criteria->containsKey(UserLoginTableMap::COL_ID) && $criteria->keyContainsValue(UserLoginTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UserLoginTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = UserLoginQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UserLoginTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UserLoginTableMap::buildTableMap();
