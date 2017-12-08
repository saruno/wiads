<?php

namespace Common\DbBundle\Model\Map;

use Common\DbBundle\Model\Section;
use Common\DbBundle\Model\SectionQuery;
use Hotspot\AccessPointBundle\Model\Map\AccesspointTableMap;
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
 * This class defines the structure of the 'section' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SectionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Common.DbBundle.Model.Map.SectionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'section';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Common\\DbBundle\\Model\\Section';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Common.DbBundle.Model.Section';

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
     * the column name for the id field
     */
    const COL_ID = 'section.id';

    /**
     * the column name for the deep field
     */
    const COL_DEEP = 'section.deep';

    /**
     * the column name for the parent field
     */
    const COL_PARENT = 'section.parent';

    /**
     * the column name for the bundle_id field
     */
    const COL_BUNDLE_ID = 'section.bundle_id';

    /**
     * the column name for the orders field
     */
    const COL_ORDERS = 'section.orders';

    /**
     * the column name for the can_delete field
     */
    const COL_CAN_DELETE = 'section.can_delete';

    /**
     * the column name for the locked field
     */
    const COL_LOCKED = 'section.locked';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'section.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'section.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'Deep', 'Parent', 'BundleId', 'Orders', 'CanDelete', 'Locked', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'deep', 'parent', 'bundleId', 'orders', 'canDelete', 'locked', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(SectionTableMap::COL_ID, SectionTableMap::COL_DEEP, SectionTableMap::COL_PARENT, SectionTableMap::COL_BUNDLE_ID, SectionTableMap::COL_ORDERS, SectionTableMap::COL_CAN_DELETE, SectionTableMap::COL_LOCKED, SectionTableMap::COL_CREATED_AT, SectionTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'deep', 'parent', 'bundle_id', 'orders', 'can_delete', 'locked', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Deep' => 1, 'Parent' => 2, 'BundleId' => 3, 'Orders' => 4, 'CanDelete' => 5, 'Locked' => 6, 'CreatedAt' => 7, 'UpdatedAt' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'deep' => 1, 'parent' => 2, 'bundleId' => 3, 'orders' => 4, 'canDelete' => 5, 'locked' => 6, 'createdAt' => 7, 'updatedAt' => 8, ),
        self::TYPE_COLNAME       => array(SectionTableMap::COL_ID => 0, SectionTableMap::COL_DEEP => 1, SectionTableMap::COL_PARENT => 2, SectionTableMap::COL_BUNDLE_ID => 3, SectionTableMap::COL_ORDERS => 4, SectionTableMap::COL_CAN_DELETE => 5, SectionTableMap::COL_LOCKED => 6, SectionTableMap::COL_CREATED_AT => 7, SectionTableMap::COL_UPDATED_AT => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'deep' => 1, 'parent' => 2, 'bundle_id' => 3, 'orders' => 4, 'can_delete' => 5, 'locked' => 6, 'created_at' => 7, 'updated_at' => 8, ),
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
        $this->setName('section');
        $this->setPhpName('Section');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Common\\DbBundle\\Model\\Section');
        $this->setPackage('src.Common.DbBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('deep', 'Deep', 'INTEGER', false, null, 0);
        $this->addColumn('parent', 'Parent', 'INTEGER', false, null, -1);
        $this->addForeignKey('bundle_id', 'BundleId', 'INTEGER', 'bundle', 'id', false, null, -1);
        $this->addColumn('orders', 'Orders', 'INTEGER', false, null, null);
        $this->addColumn('can_delete', 'CanDelete', 'BOOLEAN', false, 1, false);
        $this->addColumn('locked', 'Locked', 'BOOLEAN', false, 1, false);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Bundle', '\\Common\\DbBundle\\Model\\Bundle', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':bundle_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', null, false);
        $this->addRelation('News', '\\Common\\DbBundle\\Model\\News', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'News', false);
        $this->addRelation('Comment', '\\Common\\DbBundle\\Model\\Comment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'Comments', false);
        $this->addRelation('Menu', '\\Common\\DbBundle\\Model\\Menu', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'Menus', false);
        $this->addRelation('Advert', '\\Common\\DbBundle\\Model\\Advert', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'Adverts', false);
        $this->addRelation('Place', '\\Common\\DbBundle\\Model\\Place', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'Places', false);
        $this->addRelation('Marker', '\\Common\\DbBundle\\Model\\Marker', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'Markers', false);
        $this->addRelation('Accesspoint', '\\Hotspot\\AccessPointBundle\\Model\\Accesspoint', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'Accesspoints', false);
        $this->addRelation('SectionI18n', '\\Common\\DbBundle\\Model\\SectionI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, 'SectionI18ns', false);
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
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'title, strip_title, brief, content,link', 'i18n_pk_column' => '', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => 'vi', 'locale_alias' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to section     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        NewsTableMap::clearInstancePool();
        CommentTableMap::clearInstancePool();
        MenuTableMap::clearInstancePool();
        AdvertTableMap::clearInstancePool();
        PlaceTableMap::clearInstancePool();
        MarkerTableMap::clearInstancePool();
        AccesspointTableMap::clearInstancePool();
        SectionI18nTableMap::clearInstancePool();
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
        return $withPrefix ? SectionTableMap::CLASS_DEFAULT : SectionTableMap::OM_CLASS;
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
     * @return array           (Section object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SectionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SectionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SectionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SectionTableMap::OM_CLASS;
            /** @var Section $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SectionTableMap::addInstanceToPool($obj, $key);
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
            $key = SectionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SectionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Section $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SectionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SectionTableMap::COL_ID);
            $criteria->addSelectColumn(SectionTableMap::COL_DEEP);
            $criteria->addSelectColumn(SectionTableMap::COL_PARENT);
            $criteria->addSelectColumn(SectionTableMap::COL_BUNDLE_ID);
            $criteria->addSelectColumn(SectionTableMap::COL_ORDERS);
            $criteria->addSelectColumn(SectionTableMap::COL_CAN_DELETE);
            $criteria->addSelectColumn(SectionTableMap::COL_LOCKED);
            $criteria->addSelectColumn(SectionTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(SectionTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.deep');
            $criteria->addSelectColumn($alias . '.parent');
            $criteria->addSelectColumn($alias . '.bundle_id');
            $criteria->addSelectColumn($alias . '.orders');
            $criteria->addSelectColumn($alias . '.can_delete');
            $criteria->addSelectColumn($alias . '.locked');
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
        return Propel::getServiceContainer()->getDatabaseMap(SectionTableMap::DATABASE_NAME)->getTable(SectionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SectionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SectionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SectionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Section or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Section object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Common\DbBundle\Model\Section) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SectionTableMap::DATABASE_NAME);
            $criteria->add(SectionTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SectionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SectionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SectionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the section table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SectionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Section or Criteria object.
     *
     * @param mixed               $criteria Criteria or Section object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Section object
        }

        if ($criteria->containsKey(SectionTableMap::COL_ID) && $criteria->keyContainsValue(SectionTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SectionTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SectionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SectionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SectionTableMap::buildTableMap();
