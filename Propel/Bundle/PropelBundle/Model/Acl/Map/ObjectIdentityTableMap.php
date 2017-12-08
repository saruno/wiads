<?php

namespace Propel\Bundle\PropelBundle\Model\Acl\Map;

use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity;
use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery;
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
 * This class defines the structure of the 'acl_object_identities' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ObjectIdentityTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Propel.Bundle.PropelBundle.Model.Acl.Map.ObjectIdentityTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'acl_object_identities';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\ObjectIdentity';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Propel.Bundle.PropelBundle.Model.Acl.ObjectIdentity';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id field
     */
    const COL_ID = 'acl_object_identities.id';

    /**
     * the column name for the class_id field
     */
    const COL_CLASS_ID = 'acl_object_identities.class_id';

    /**
     * the column name for the object_identifier field
     */
    const COL_OBJECT_IDENTIFIER = 'acl_object_identities.object_identifier';

    /**
     * the column name for the parent_object_identity_id field
     */
    const COL_PARENT_OBJECT_IDENTITY_ID = 'acl_object_identities.parent_object_identity_id';

    /**
     * the column name for the entries_inheriting field
     */
    const COL_ENTRIES_INHERITING = 'acl_object_identities.entries_inheriting';

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
        self::TYPE_PHPNAME       => array('Id', 'ClassId', 'Identifier', 'ParentObjectIdentityId', 'EntriesInheriting', ),
        self::TYPE_CAMELNAME     => array('id', 'classId', 'identifier', 'parentObjectIdentityId', 'entriesInheriting', ),
        self::TYPE_COLNAME       => array(ObjectIdentityTableMap::COL_ID, ObjectIdentityTableMap::COL_CLASS_ID, ObjectIdentityTableMap::COL_OBJECT_IDENTIFIER, ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID, ObjectIdentityTableMap::COL_ENTRIES_INHERITING, ),
        self::TYPE_FIELDNAME     => array('id', 'class_id', 'object_identifier', 'parent_object_identity_id', 'entries_inheriting', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ClassId' => 1, 'Identifier' => 2, 'ParentObjectIdentityId' => 3, 'EntriesInheriting' => 4, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'classId' => 1, 'identifier' => 2, 'parentObjectIdentityId' => 3, 'entriesInheriting' => 4, ),
        self::TYPE_COLNAME       => array(ObjectIdentityTableMap::COL_ID => 0, ObjectIdentityTableMap::COL_CLASS_ID => 1, ObjectIdentityTableMap::COL_OBJECT_IDENTIFIER => 2, ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID => 3, ObjectIdentityTableMap::COL_ENTRIES_INHERITING => 4, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'class_id' => 1, 'object_identifier' => 2, 'parent_object_identity_id' => 3, 'entries_inheriting' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('acl_object_identities');
        $this->setPhpName('ObjectIdentity');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\ObjectIdentity');
        $this->setPackage('Propel.Bundle.PropelBundle.Model.Acl');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('class_id', 'ClassId', 'INTEGER', 'acl_classes', 'id', true, null, null);
        $this->addColumn('object_identifier', 'Identifier', 'VARCHAR', true, 200, null);
        $this->addForeignKey('parent_object_identity_id', 'ParentObjectIdentityId', 'INTEGER', 'acl_object_identities', 'id', false, null, null);
        $this->addColumn('entries_inheriting', 'EntriesInheriting', 'BOOLEAN', true, 1, true);
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
), 'RESTRICT', 'CASCADE', null, false);
        $this->addRelation('ObjectIdentityRelatedByParentObjectIdentityId', '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\ObjectIdentity', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':parent_object_identity_id',
    1 => ':id',
  ),
), 'RESTRICT', 'CASCADE', null, false);
        $this->addRelation('ObjectIdentityRelatedById', '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\ObjectIdentity', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':parent_object_identity_id',
    1 => ':id',
  ),
), 'RESTRICT', 'CASCADE', 'ObjectIdentitiesRelatedById', false);
        $this->addRelation('ObjectIdentityAncestorRelatedByObjectIdentityId', '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\ObjectIdentityAncestor', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':object_identity_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'ObjectIdentityAncestorsRelatedByObjectIdentityId', false);
        $this->addRelation('ObjectIdentityAncestorRelatedByAncestorId', '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\ObjectIdentityAncestor', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ancestor_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'ObjectIdentityAncestorsRelatedByAncestorId', false);
        $this->addRelation('Entry', '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\Entry', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':object_identity_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Entries', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to acl_object_identities     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ObjectIdentityAncestorTableMap::clearInstancePool();
        EntryTableMap::clearInstancePool();
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
        return $withPrefix ? ObjectIdentityTableMap::CLASS_DEFAULT : ObjectIdentityTableMap::OM_CLASS;
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
     * @return array           (ObjectIdentity object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ObjectIdentityTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ObjectIdentityTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ObjectIdentityTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ObjectIdentityTableMap::OM_CLASS;
            /** @var ObjectIdentity $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ObjectIdentityTableMap::addInstanceToPool($obj, $key);
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
            $key = ObjectIdentityTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ObjectIdentityTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ObjectIdentity $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ObjectIdentityTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ObjectIdentityTableMap::COL_ID);
            $criteria->addSelectColumn(ObjectIdentityTableMap::COL_CLASS_ID);
            $criteria->addSelectColumn(ObjectIdentityTableMap::COL_OBJECT_IDENTIFIER);
            $criteria->addSelectColumn(ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID);
            $criteria->addSelectColumn(ObjectIdentityTableMap::COL_ENTRIES_INHERITING);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.class_id');
            $criteria->addSelectColumn($alias . '.object_identifier');
            $criteria->addSelectColumn($alias . '.parent_object_identity_id');
            $criteria->addSelectColumn($alias . '.entries_inheriting');
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
        return Propel::getServiceContainer()->getDatabaseMap(ObjectIdentityTableMap::DATABASE_NAME)->getTable(ObjectIdentityTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ObjectIdentityTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ObjectIdentityTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ObjectIdentityTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ObjectIdentity or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ObjectIdentity object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ObjectIdentityTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ObjectIdentityTableMap::DATABASE_NAME);
            $criteria->add(ObjectIdentityTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ObjectIdentityQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ObjectIdentityTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ObjectIdentityTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the acl_object_identities table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ObjectIdentityQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ObjectIdentity or Criteria object.
     *
     * @param mixed               $criteria Criteria or ObjectIdentity object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ObjectIdentityTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ObjectIdentity object
        }

        if ($criteria->containsKey(ObjectIdentityTableMap::COL_ID) && $criteria->keyContainsValue(ObjectIdentityTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ObjectIdentityTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ObjectIdentityQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ObjectIdentityTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ObjectIdentityTableMap::buildTableMap();
