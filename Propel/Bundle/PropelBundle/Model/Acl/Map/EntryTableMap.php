<?php

namespace Propel\Bundle\PropelBundle\Model\Acl\Map;

use Propel\Bundle\PropelBundle\Model\Acl\Entry;
use Propel\Bundle\PropelBundle\Model\Acl\EntryQuery;
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
 * This class defines the structure of the 'acl_entries' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class EntryTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Bundle.PropelBundle.Model.Acl.Map.EntryTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'acl_entries';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\Entry';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Bundle.PropelBundle.Model.Acl.Entry';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the id field
     */
    const COL_ID = 'acl_entries.id';

    /**
     * the column name for the class_id field
     */
    const COL_CLASS_ID = 'acl_entries.class_id';

    /**
     * the column name for the object_identity_id field
     */
    const COL_OBJECT_IDENTITY_ID = 'acl_entries.object_identity_id';

    /**
     * the column name for the security_identity_id field
     */
    const COL_SECURITY_IDENTITY_ID = 'acl_entries.security_identity_id';

    /**
     * the column name for the field_name field
     */
    const COL_FIELD_NAME = 'acl_entries.field_name';

    /**
     * the column name for the ace_order field
     */
    const COL_ACE_ORDER = 'acl_entries.ace_order';

    /**
     * the column name for the mask field
     */
    const COL_MASK = 'acl_entries.mask';

    /**
     * the column name for the granting field
     */
    const COL_GRANTING = 'acl_entries.granting';

    /**
     * the column name for the granting_strategy field
     */
    const COL_GRANTING_STRATEGY = 'acl_entries.granting_strategy';

    /**
     * the column name for the audit_success field
     */
    const COL_AUDIT_SUCCESS = 'acl_entries.audit_success';

    /**
     * the column name for the audit_failure field
     */
    const COL_AUDIT_FAILURE = 'acl_entries.audit_failure';

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
        self::TYPE_PHPNAME       => array('Id', 'ClassId', 'ObjectIdentityId', 'SecurityIdentityId', 'FieldName', 'AceOrder', 'Mask', 'Granting', 'GrantingStrategy', 'AuditSuccess', 'AuditFailure', ),
        self::TYPE_CAMELNAME     => array('id', 'classId', 'objectIdentityId', 'securityIdentityId', 'fieldName', 'aceOrder', 'mask', 'granting', 'grantingStrategy', 'auditSuccess', 'auditFailure', ),
        self::TYPE_COLNAME       => array(EntryTableMap::COL_ID, EntryTableMap::COL_CLASS_ID, EntryTableMap::COL_OBJECT_IDENTITY_ID, EntryTableMap::COL_SECURITY_IDENTITY_ID, EntryTableMap::COL_FIELD_NAME, EntryTableMap::COL_ACE_ORDER, EntryTableMap::COL_MASK, EntryTableMap::COL_GRANTING, EntryTableMap::COL_GRANTING_STRATEGY, EntryTableMap::COL_AUDIT_SUCCESS, EntryTableMap::COL_AUDIT_FAILURE, ),
        self::TYPE_FIELDNAME     => array('id', 'class_id', 'object_identity_id', 'security_identity_id', 'field_name', 'ace_order', 'mask', 'granting', 'granting_strategy', 'audit_success', 'audit_failure', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ClassId' => 1, 'ObjectIdentityId' => 2, 'SecurityIdentityId' => 3, 'FieldName' => 4, 'AceOrder' => 5, 'Mask' => 6, 'Granting' => 7, 'GrantingStrategy' => 8, 'AuditSuccess' => 9, 'AuditFailure' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'classId' => 1, 'objectIdentityId' => 2, 'securityIdentityId' => 3, 'fieldName' => 4, 'aceOrder' => 5, 'mask' => 6, 'granting' => 7, 'grantingStrategy' => 8, 'auditSuccess' => 9, 'auditFailure' => 10, ),
        self::TYPE_COLNAME       => array(EntryTableMap::COL_ID => 0, EntryTableMap::COL_CLASS_ID => 1, EntryTableMap::COL_OBJECT_IDENTITY_ID => 2, EntryTableMap::COL_SECURITY_IDENTITY_ID => 3, EntryTableMap::COL_FIELD_NAME => 4, EntryTableMap::COL_ACE_ORDER => 5, EntryTableMap::COL_MASK => 6, EntryTableMap::COL_GRANTING => 7, EntryTableMap::COL_GRANTING_STRATEGY => 8, EntryTableMap::COL_AUDIT_SUCCESS => 9, EntryTableMap::COL_AUDIT_FAILURE => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'class_id' => 1, 'object_identity_id' => 2, 'security_identity_id' => 3, 'field_name' => 4, 'ace_order' => 5, 'mask' => 6, 'granting' => 7, 'granting_strategy' => 8, 'audit_success' => 9, 'audit_failure' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('acl_entries');
        $this->setPhpName('Entry');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\Entry');
        $this->setPackage('Propel.Bundle.PropelBundle.Model.Acl');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('class_id', 'ClassId', 'INTEGER', 'acl_classes', 'id', true, null, null);
        $this->addForeignKey('object_identity_id', 'ObjectIdentityId', 'INTEGER', 'acl_object_identities', 'id', false, null, null);
        $this->addForeignKey('security_identity_id', 'SecurityIdentityId', 'INTEGER', 'acl_security_identities', 'id', true, null, null);
        $this->addColumn('field_name', 'FieldName', 'VARCHAR', false, 50, null);
        $this->addColumn('ace_order', 'AceOrder', 'INTEGER', true, null, null);
        $this->addColumn('mask', 'Mask', 'INTEGER', true, null, null);
        $this->addColumn('granting', 'Granting', 'BOOLEAN', true, 1, null);
        $this->addColumn('granting_strategy', 'GrantingStrategy', 'VARCHAR', true, 30, null);
        $this->addColumn('audit_success', 'AuditSuccess', 'BOOLEAN', true, 1, false);
        $this->addColumn('audit_failure', 'AuditFailure', 'BOOLEAN', true, 1, true);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AclClass', '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\AclClass', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':class_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('ObjectIdentity', '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\ObjectIdentity', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':object_identity_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('SecurityIdentity', '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\SecurityIdentity', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':security_identity_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
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
        return $withPrefix ? EntryTableMap::CLASS_DEFAULT : EntryTableMap::OM_CLASS;
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
     * @return array           (Entry object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = EntryTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = EntryTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EntryTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EntryTableMap::OM_CLASS;
            /** @var Entry $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EntryTableMap::addInstanceToPool($obj, $key);
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
            $key = EntryTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = EntryTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Entry $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                EntryTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(EntryTableMap::COL_ID);
            $criteria->addSelectColumn(EntryTableMap::COL_CLASS_ID);
            $criteria->addSelectColumn(EntryTableMap::COL_OBJECT_IDENTITY_ID);
            $criteria->addSelectColumn(EntryTableMap::COL_SECURITY_IDENTITY_ID);
            $criteria->addSelectColumn(EntryTableMap::COL_FIELD_NAME);
            $criteria->addSelectColumn(EntryTableMap::COL_ACE_ORDER);
            $criteria->addSelectColumn(EntryTableMap::COL_MASK);
            $criteria->addSelectColumn(EntryTableMap::COL_GRANTING);
            $criteria->addSelectColumn(EntryTableMap::COL_GRANTING_STRATEGY);
            $criteria->addSelectColumn(EntryTableMap::COL_AUDIT_SUCCESS);
            $criteria->addSelectColumn(EntryTableMap::COL_AUDIT_FAILURE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.class_id');
            $criteria->addSelectColumn($alias . '.object_identity_id');
            $criteria->addSelectColumn($alias . '.security_identity_id');
            $criteria->addSelectColumn($alias . '.field_name');
            $criteria->addSelectColumn($alias . '.ace_order');
            $criteria->addSelectColumn($alias . '.mask');
            $criteria->addSelectColumn($alias . '.granting');
            $criteria->addSelectColumn($alias . '.granting_strategy');
            $criteria->addSelectColumn($alias . '.audit_success');
            $criteria->addSelectColumn($alias . '.audit_failure');
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
        return Propel::getServiceContainer()->getDatabaseMap(EntryTableMap::DATABASE_NAME)->getTable(EntryTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(EntryTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(EntryTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new EntryTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Entry or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Entry object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(EntryTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Bundle\PropelBundle\Model\Acl\Entry) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EntryTableMap::DATABASE_NAME);
            $criteria->add(EntryTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = EntryQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EntryTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                EntryTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the acl_entries table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return EntryQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Entry or Criteria object.
     *
     * @param mixed               $criteria Criteria or Entry object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EntryTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Entry object
        }

        if ($criteria->containsKey(EntryTableMap::COL_ID) && $criteria->keyContainsValue(EntryTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.EntryTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = EntryQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // EntryTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
EntryTableMap::buildTableMap();
