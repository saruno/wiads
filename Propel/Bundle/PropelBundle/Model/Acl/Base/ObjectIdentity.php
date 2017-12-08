<?php

namespace Propel\Bundle\PropelBundle\Model\Acl\Base;

use \Exception;
use \PDO;
use Propel\Bundle\PropelBundle\Model\Acl\AclClass as ChildAclClass;
use Propel\Bundle\PropelBundle\Model\Acl\AclClassQuery as ChildAclClassQuery;
use Propel\Bundle\PropelBundle\Model\Acl\Entry as ChildEntry;
use Propel\Bundle\PropelBundle\Model\Acl\EntryQuery as ChildEntryQuery;
use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity as ChildObjectIdentity;
use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor as ChildObjectIdentityAncestor;
use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestorQuery as ChildObjectIdentityAncestorQuery;
use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery as ChildObjectIdentityQuery;
use Propel\Bundle\PropelBundle\Model\Acl\Map\EntryTableMap;
use Propel\Bundle\PropelBundle\Model\Acl\Map\ObjectIdentityAncestorTableMap;
use Propel\Bundle\PropelBundle\Model\Acl\Map\ObjectIdentityTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'acl_object_identities' table.
 *
 *
 *
 * @package    propel.generator.Propel.Bundle.PropelBundle.Model.Acl.Base
 */
abstract class ObjectIdentity implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\Map\\ObjectIdentityTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the class_id field.
     *
     * @var        int
     */
    protected $class_id;

    /**
     * The value for the object_identifier field.
     *
     * @var        string
     */
    protected $object_identifier;

    /**
     * The value for the parent_object_identity_id field.
     *
     * @var        int
     */
    protected $parent_object_identity_id;

    /**
     * The value for the entries_inheriting field.
     *
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $entries_inheriting;

    /**
     * @var        ChildAclClass
     */
    protected $aAclClass;

    /**
     * @var        ChildObjectIdentity
     */
    protected $aObjectIdentityRelatedByParentObjectIdentityId;

    /**
     * @var        ObjectCollection|ChildObjectIdentity[] Collection to store aggregation of ChildObjectIdentity objects.
     */
    protected $collObjectIdentitiesRelatedById;
    protected $collObjectIdentitiesRelatedByIdPartial;

    /**
     * @var        ObjectCollection|ChildObjectIdentityAncestor[] Collection to store aggregation of ChildObjectIdentityAncestor objects.
     */
    protected $collObjectIdentityAncestorsRelatedByObjectIdentityId;
    protected $collObjectIdentityAncestorsRelatedByObjectIdentityIdPartial;

    /**
     * @var        ObjectCollection|ChildObjectIdentityAncestor[] Collection to store aggregation of ChildObjectIdentityAncestor objects.
     */
    protected $collObjectIdentityAncestorsRelatedByAncestorId;
    protected $collObjectIdentityAncestorsRelatedByAncestorIdPartial;

    /**
     * @var        ObjectCollection|ChildEntry[] Collection to store aggregation of ChildEntry objects.
     */
    protected $collEntries;
    protected $collEntriesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildObjectIdentity[]
     */
    protected $objectIdentitiesRelatedByIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildObjectIdentityAncestor[]
     */
    protected $objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildObjectIdentityAncestor[]
     */
    protected $objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEntry[]
     */
    protected $entriesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->entries_inheriting = true;
    }

    /**
     * Initializes internal state of Propel\Bundle\PropelBundle\Model\Acl\Base\ObjectIdentity object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>ObjectIdentity</code> instance.  If
     * <code>obj</code> is an instance of <code>ObjectIdentity</code>, delegates to
     * <code>equals(ObjectIdentity)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|ObjectIdentity The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [class_id] column value.
     *
     * @return int
     */
    public function getClassId()
    {
        return $this->class_id;
    }

    /**
     * Get the [object_identifier] column value.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->object_identifier;
    }

    /**
     * Get the [parent_object_identity_id] column value.
     *
     * @return int
     */
    public function getParentObjectIdentityId()
    {
        return $this->parent_object_identity_id;
    }

    /**
     * Get the [entries_inheriting] column value.
     *
     * @return boolean
     */
    public function getEntriesInheriting()
    {
        return $this->entries_inheriting;
    }

    /**
     * Get the [entries_inheriting] column value.
     *
     * @return boolean
     */
    public function isEntriesInheriting()
    {
        return $this->getEntriesInheriting();
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ObjectIdentityTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [class_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object (for fluent API support)
     */
    public function setClassId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->class_id !== $v) {
            $this->class_id = $v;
            $this->modifiedColumns[ObjectIdentityTableMap::COL_CLASS_ID] = true;
        }

        if ($this->aAclClass !== null && $this->aAclClass->getId() !== $v) {
            $this->aAclClass = null;
        }

        return $this;
    } // setClassId()

    /**
     * Set the value of [object_identifier] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object (for fluent API support)
     */
    public function setIdentifier($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->object_identifier !== $v) {
            $this->object_identifier = $v;
            $this->modifiedColumns[ObjectIdentityTableMap::COL_OBJECT_IDENTIFIER] = true;
        }

        return $this;
    } // setIdentifier()

    /**
     * Set the value of [parent_object_identity_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object (for fluent API support)
     */
    public function setParentObjectIdentityId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parent_object_identity_id !== $v) {
            $this->parent_object_identity_id = $v;
            $this->modifiedColumns[ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID] = true;
        }

        if ($this->aObjectIdentityRelatedByParentObjectIdentityId !== null && $this->aObjectIdentityRelatedByParentObjectIdentityId->getId() !== $v) {
            $this->aObjectIdentityRelatedByParentObjectIdentityId = null;
        }

        return $this;
    } // setParentObjectIdentityId()

    /**
     * Sets the value of the [entries_inheriting] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object (for fluent API support)
     */
    public function setEntriesInheriting($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->entries_inheriting !== $v) {
            $this->entries_inheriting = $v;
            $this->modifiedColumns[ObjectIdentityTableMap::COL_ENTRIES_INHERITING] = true;
        }

        return $this;
    } // setEntriesInheriting()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->entries_inheriting !== true) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ObjectIdentityTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ObjectIdentityTableMap::translateFieldName('ClassId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->class_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ObjectIdentityTableMap::translateFieldName('Identifier', TableMap::TYPE_PHPNAME, $indexType)];
            $this->object_identifier = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ObjectIdentityTableMap::translateFieldName('ParentObjectIdentityId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parent_object_identity_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ObjectIdentityTableMap::translateFieldName('EntriesInheriting', TableMap::TYPE_PHPNAME, $indexType)];
            $this->entries_inheriting = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = ObjectIdentityTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\ObjectIdentity'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aAclClass !== null && $this->class_id !== $this->aAclClass->getId()) {
            $this->aAclClass = null;
        }
        if ($this->aObjectIdentityRelatedByParentObjectIdentityId !== null && $this->parent_object_identity_id !== $this->aObjectIdentityRelatedByParentObjectIdentityId->getId()) {
            $this->aObjectIdentityRelatedByParentObjectIdentityId = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ObjectIdentityTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildObjectIdentityQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAclClass = null;
            $this->aObjectIdentityRelatedByParentObjectIdentityId = null;
            $this->collObjectIdentitiesRelatedById = null;

            $this->collObjectIdentityAncestorsRelatedByObjectIdentityId = null;

            $this->collObjectIdentityAncestorsRelatedByAncestorId = null;

            $this->collEntries = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ObjectIdentity::setDeleted()
     * @see ObjectIdentity::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ObjectIdentityTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildObjectIdentityQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ObjectIdentityTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ObjectIdentityTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAclClass !== null) {
                if ($this->aAclClass->isModified() || $this->aAclClass->isNew()) {
                    $affectedRows += $this->aAclClass->save($con);
                }
                $this->setAclClass($this->aAclClass);
            }

            if ($this->aObjectIdentityRelatedByParentObjectIdentityId !== null) {
                if ($this->aObjectIdentityRelatedByParentObjectIdentityId->isModified() || $this->aObjectIdentityRelatedByParentObjectIdentityId->isNew()) {
                    $affectedRows += $this->aObjectIdentityRelatedByParentObjectIdentityId->save($con);
                }
                $this->setObjectIdentityRelatedByParentObjectIdentityId($this->aObjectIdentityRelatedByParentObjectIdentityId);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->objectIdentitiesRelatedByIdScheduledForDeletion !== null) {
                if (!$this->objectIdentitiesRelatedByIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->objectIdentitiesRelatedByIdScheduledForDeletion as $objectIdentityRelatedById) {
                        // need to save related object because we set the relation to null
                        $objectIdentityRelatedById->save($con);
                    }
                    $this->objectIdentitiesRelatedByIdScheduledForDeletion = null;
                }
            }

            if ($this->collObjectIdentitiesRelatedById !== null) {
                foreach ($this->collObjectIdentitiesRelatedById as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion !== null) {
                if (!$this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion->isEmpty()) {
                    \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestorQuery::create()
                        ->filterByPrimaryKeys($this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion = null;
                }
            }

            if ($this->collObjectIdentityAncestorsRelatedByObjectIdentityId !== null) {
                foreach ($this->collObjectIdentityAncestorsRelatedByObjectIdentityId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion !== null) {
                if (!$this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion->isEmpty()) {
                    \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestorQuery::create()
                        ->filterByPrimaryKeys($this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion = null;
                }
            }

            if ($this->collObjectIdentityAncestorsRelatedByAncestorId !== null) {
                foreach ($this->collObjectIdentityAncestorsRelatedByAncestorId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->entriesScheduledForDeletion !== null) {
                if (!$this->entriesScheduledForDeletion->isEmpty()) {
                    \Propel\Bundle\PropelBundle\Model\Acl\EntryQuery::create()
                        ->filterByPrimaryKeys($this->entriesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->entriesScheduledForDeletion = null;
                }
            }

            if ($this->collEntries !== null) {
                foreach ($this->collEntries as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[ObjectIdentityTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ObjectIdentityTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ObjectIdentityTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ObjectIdentityTableMap::COL_CLASS_ID)) {
            $modifiedColumns[':p' . $index++]  = 'class_id';
        }
        if ($this->isColumnModified(ObjectIdentityTableMap::COL_OBJECT_IDENTIFIER)) {
            $modifiedColumns[':p' . $index++]  = 'object_identifier';
        }
        if ($this->isColumnModified(ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'parent_object_identity_id';
        }
        if ($this->isColumnModified(ObjectIdentityTableMap::COL_ENTRIES_INHERITING)) {
            $modifiedColumns[':p' . $index++]  = 'entries_inheriting';
        }

        $sql = sprintf(
            'INSERT INTO acl_object_identities (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'class_id':
                        $stmt->bindValue($identifier, $this->class_id, PDO::PARAM_INT);
                        break;
                    case 'object_identifier':
                        $stmt->bindValue($identifier, $this->object_identifier, PDO::PARAM_STR);
                        break;
                    case 'parent_object_identity_id':
                        $stmt->bindValue($identifier, $this->parent_object_identity_id, PDO::PARAM_INT);
                        break;
                    case 'entries_inheriting':
                        $stmt->bindValue($identifier, (int) $this->entries_inheriting, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ObjectIdentityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getClassId();
                break;
            case 2:
                return $this->getIdentifier();
                break;
            case 3:
                return $this->getParentObjectIdentityId();
                break;
            case 4:
                return $this->getEntriesInheriting();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['ObjectIdentity'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ObjectIdentity'][$this->hashCode()] = true;
        $keys = ObjectIdentityTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getClassId(),
            $keys[2] => $this->getIdentifier(),
            $keys[3] => $this->getParentObjectIdentityId(),
            $keys[4] => $this->getEntriesInheriting(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAclClass) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'aclClass';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'acl_classes';
                        break;
                    default:
                        $key = 'AclClass';
                }

                $result[$key] = $this->aAclClass->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aObjectIdentityRelatedByParentObjectIdentityId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'objectIdentity';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'acl_object_identities';
                        break;
                    default:
                        $key = 'ObjectIdentity';
                }

                $result[$key] = $this->aObjectIdentityRelatedByParentObjectIdentityId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collObjectIdentitiesRelatedById) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'objectIdentities';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'acl_object_identitiess';
                        break;
                    default:
                        $key = 'ObjectIdentities';
                }

                $result[$key] = $this->collObjectIdentitiesRelatedById->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collObjectIdentityAncestorsRelatedByObjectIdentityId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'objectIdentityAncestors';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'acl_object_identity_ancestorss';
                        break;
                    default:
                        $key = 'ObjectIdentityAncestors';
                }

                $result[$key] = $this->collObjectIdentityAncestorsRelatedByObjectIdentityId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collObjectIdentityAncestorsRelatedByAncestorId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'objectIdentityAncestors';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'acl_object_identity_ancestorss';
                        break;
                    default:
                        $key = 'ObjectIdentityAncestors';
                }

                $result[$key] = $this->collObjectIdentityAncestorsRelatedByAncestorId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collEntries) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'entries';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'acl_entriess';
                        break;
                    default:
                        $key = 'Entries';
                }

                $result[$key] = $this->collEntries->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ObjectIdentityTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setClassId($value);
                break;
            case 2:
                $this->setIdentifier($value);
                break;
            case 3:
                $this->setParentObjectIdentityId($value);
                break;
            case 4:
                $this->setEntriesInheriting($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ObjectIdentityTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setClassId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setIdentifier($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setParentObjectIdentityId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEntriesInheriting($arr[$keys[4]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ObjectIdentityTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ObjectIdentityTableMap::COL_ID)) {
            $criteria->add(ObjectIdentityTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ObjectIdentityTableMap::COL_CLASS_ID)) {
            $criteria->add(ObjectIdentityTableMap::COL_CLASS_ID, $this->class_id);
        }
        if ($this->isColumnModified(ObjectIdentityTableMap::COL_OBJECT_IDENTIFIER)) {
            $criteria->add(ObjectIdentityTableMap::COL_OBJECT_IDENTIFIER, $this->object_identifier);
        }
        if ($this->isColumnModified(ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID)) {
            $criteria->add(ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID, $this->parent_object_identity_id);
        }
        if ($this->isColumnModified(ObjectIdentityTableMap::COL_ENTRIES_INHERITING)) {
            $criteria->add(ObjectIdentityTableMap::COL_ENTRIES_INHERITING, $this->entries_inheriting);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildObjectIdentityQuery::create();
        $criteria->add(ObjectIdentityTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setClassId($this->getClassId());
        $copyObj->setIdentifier($this->getIdentifier());
        $copyObj->setParentObjectIdentityId($this->getParentObjectIdentityId());
        $copyObj->setEntriesInheriting($this->getEntriesInheriting());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getObjectIdentitiesRelatedById() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addObjectIdentityRelatedById($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getObjectIdentityAncestorsRelatedByObjectIdentityId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addObjectIdentityAncestorRelatedByObjectIdentityId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getObjectIdentityAncestorsRelatedByAncestorId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addObjectIdentityAncestorRelatedByAncestorId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEntries() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEntry($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildAclClass object.
     *
     * @param  ChildAclClass $v
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAclClass(ChildAclClass $v = null)
    {
        if ($v === null) {
            $this->setClassId(NULL);
        } else {
            $this->setClassId($v->getId());
        }

        $this->aAclClass = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAclClass object, it will not be re-added.
        if ($v !== null) {
            $v->addObjectIdentity($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAclClass object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAclClass The associated ChildAclClass object.
     * @throws PropelException
     */
    public function getAclClass(ConnectionInterface $con = null)
    {
        if ($this->aAclClass === null && ($this->class_id !== null)) {
            $this->aAclClass = ChildAclClassQuery::create()->findPk($this->class_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAclClass->addObjectIdentities($this);
             */
        }

        return $this->aAclClass;
    }

    /**
     * Declares an association between this object and a ChildObjectIdentity object.
     *
     * @param  ChildObjectIdentity $v
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object (for fluent API support)
     * @throws PropelException
     */
    public function setObjectIdentityRelatedByParentObjectIdentityId(ChildObjectIdentity $v = null)
    {
        if ($v === null) {
            $this->setParentObjectIdentityId(NULL);
        } else {
            $this->setParentObjectIdentityId($v->getId());
        }

        $this->aObjectIdentityRelatedByParentObjectIdentityId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildObjectIdentity object, it will not be re-added.
        if ($v !== null) {
            $v->addObjectIdentityRelatedById($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildObjectIdentity object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildObjectIdentity The associated ChildObjectIdentity object.
     * @throws PropelException
     */
    public function getObjectIdentityRelatedByParentObjectIdentityId(ConnectionInterface $con = null)
    {
        if ($this->aObjectIdentityRelatedByParentObjectIdentityId === null && ($this->parent_object_identity_id !== null)) {
            $this->aObjectIdentityRelatedByParentObjectIdentityId = ChildObjectIdentityQuery::create()->findPk($this->parent_object_identity_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aObjectIdentityRelatedByParentObjectIdentityId->addObjectIdentitiesRelatedById($this);
             */
        }

        return $this->aObjectIdentityRelatedByParentObjectIdentityId;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ObjectIdentityRelatedById' == $relationName) {
            $this->initObjectIdentitiesRelatedById();
            return;
        }
        if ('ObjectIdentityAncestorRelatedByObjectIdentityId' == $relationName) {
            $this->initObjectIdentityAncestorsRelatedByObjectIdentityId();
            return;
        }
        if ('ObjectIdentityAncestorRelatedByAncestorId' == $relationName) {
            $this->initObjectIdentityAncestorsRelatedByAncestorId();
            return;
        }
        if ('Entry' == $relationName) {
            $this->initEntries();
            return;
        }
    }

    /**
     * Clears out the collObjectIdentitiesRelatedById collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addObjectIdentitiesRelatedById()
     */
    public function clearObjectIdentitiesRelatedById()
    {
        $this->collObjectIdentitiesRelatedById = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collObjectIdentitiesRelatedById collection loaded partially.
     */
    public function resetPartialObjectIdentitiesRelatedById($v = true)
    {
        $this->collObjectIdentitiesRelatedByIdPartial = $v;
    }

    /**
     * Initializes the collObjectIdentitiesRelatedById collection.
     *
     * By default this just sets the collObjectIdentitiesRelatedById collection to an empty array (like clearcollObjectIdentitiesRelatedById());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initObjectIdentitiesRelatedById($overrideExisting = true)
    {
        if (null !== $this->collObjectIdentitiesRelatedById && !$overrideExisting) {
            return;
        }

        $collectionClassName = ObjectIdentityTableMap::getTableMap()->getCollectionClassName();

        $this->collObjectIdentitiesRelatedById = new $collectionClassName;
        $this->collObjectIdentitiesRelatedById->setModel('\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity');
    }

    /**
     * Gets an array of ChildObjectIdentity objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildObjectIdentity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildObjectIdentity[] List of ChildObjectIdentity objects
     * @throws PropelException
     */
    public function getObjectIdentitiesRelatedById(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collObjectIdentitiesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collObjectIdentitiesRelatedById || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collObjectIdentitiesRelatedById) {
                // return empty collection
                $this->initObjectIdentitiesRelatedById();
            } else {
                $collObjectIdentitiesRelatedById = ChildObjectIdentityQuery::create(null, $criteria)
                    ->filterByObjectIdentityRelatedByParentObjectIdentityId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collObjectIdentitiesRelatedByIdPartial && count($collObjectIdentitiesRelatedById)) {
                        $this->initObjectIdentitiesRelatedById(false);

                        foreach ($collObjectIdentitiesRelatedById as $obj) {
                            if (false == $this->collObjectIdentitiesRelatedById->contains($obj)) {
                                $this->collObjectIdentitiesRelatedById->append($obj);
                            }
                        }

                        $this->collObjectIdentitiesRelatedByIdPartial = true;
                    }

                    return $collObjectIdentitiesRelatedById;
                }

                if ($partial && $this->collObjectIdentitiesRelatedById) {
                    foreach ($this->collObjectIdentitiesRelatedById as $obj) {
                        if ($obj->isNew()) {
                            $collObjectIdentitiesRelatedById[] = $obj;
                        }
                    }
                }

                $this->collObjectIdentitiesRelatedById = $collObjectIdentitiesRelatedById;
                $this->collObjectIdentitiesRelatedByIdPartial = false;
            }
        }

        return $this->collObjectIdentitiesRelatedById;
    }

    /**
     * Sets a collection of ChildObjectIdentity objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $objectIdentitiesRelatedById A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildObjectIdentity The current object (for fluent API support)
     */
    public function setObjectIdentitiesRelatedById(Collection $objectIdentitiesRelatedById, ConnectionInterface $con = null)
    {
        /** @var ChildObjectIdentity[] $objectIdentitiesRelatedByIdToDelete */
        $objectIdentitiesRelatedByIdToDelete = $this->getObjectIdentitiesRelatedById(new Criteria(), $con)->diff($objectIdentitiesRelatedById);


        $this->objectIdentitiesRelatedByIdScheduledForDeletion = $objectIdentitiesRelatedByIdToDelete;

        foreach ($objectIdentitiesRelatedByIdToDelete as $objectIdentityRelatedByIdRemoved) {
            $objectIdentityRelatedByIdRemoved->setObjectIdentityRelatedByParentObjectIdentityId(null);
        }

        $this->collObjectIdentitiesRelatedById = null;
        foreach ($objectIdentitiesRelatedById as $objectIdentityRelatedById) {
            $this->addObjectIdentityRelatedById($objectIdentityRelatedById);
        }

        $this->collObjectIdentitiesRelatedById = $objectIdentitiesRelatedById;
        $this->collObjectIdentitiesRelatedByIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ObjectIdentity objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ObjectIdentity objects.
     * @throws PropelException
     */
    public function countObjectIdentitiesRelatedById(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collObjectIdentitiesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collObjectIdentitiesRelatedById || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collObjectIdentitiesRelatedById) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getObjectIdentitiesRelatedById());
            }

            $query = ChildObjectIdentityQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByObjectIdentityRelatedByParentObjectIdentityId($this)
                ->count($con);
        }

        return count($this->collObjectIdentitiesRelatedById);
    }

    /**
     * Method called to associate a ChildObjectIdentity object to this object
     * through the ChildObjectIdentity foreign key attribute.
     *
     * @param  ChildObjectIdentity $l ChildObjectIdentity
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object (for fluent API support)
     */
    public function addObjectIdentityRelatedById(ChildObjectIdentity $l)
    {
        if ($this->collObjectIdentitiesRelatedById === null) {
            $this->initObjectIdentitiesRelatedById();
            $this->collObjectIdentitiesRelatedByIdPartial = true;
        }

        if (!$this->collObjectIdentitiesRelatedById->contains($l)) {
            $this->doAddObjectIdentityRelatedById($l);

            if ($this->objectIdentitiesRelatedByIdScheduledForDeletion and $this->objectIdentitiesRelatedByIdScheduledForDeletion->contains($l)) {
                $this->objectIdentitiesRelatedByIdScheduledForDeletion->remove($this->objectIdentitiesRelatedByIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildObjectIdentity $objectIdentityRelatedById The ChildObjectIdentity object to add.
     */
    protected function doAddObjectIdentityRelatedById(ChildObjectIdentity $objectIdentityRelatedById)
    {
        $this->collObjectIdentitiesRelatedById[]= $objectIdentityRelatedById;
        $objectIdentityRelatedById->setObjectIdentityRelatedByParentObjectIdentityId($this);
    }

    /**
     * @param  ChildObjectIdentity $objectIdentityRelatedById The ChildObjectIdentity object to remove.
     * @return $this|ChildObjectIdentity The current object (for fluent API support)
     */
    public function removeObjectIdentityRelatedById(ChildObjectIdentity $objectIdentityRelatedById)
    {
        if ($this->getObjectIdentitiesRelatedById()->contains($objectIdentityRelatedById)) {
            $pos = $this->collObjectIdentitiesRelatedById->search($objectIdentityRelatedById);
            $this->collObjectIdentitiesRelatedById->remove($pos);
            if (null === $this->objectIdentitiesRelatedByIdScheduledForDeletion) {
                $this->objectIdentitiesRelatedByIdScheduledForDeletion = clone $this->collObjectIdentitiesRelatedById;
                $this->objectIdentitiesRelatedByIdScheduledForDeletion->clear();
            }
            $this->objectIdentitiesRelatedByIdScheduledForDeletion[]= $objectIdentityRelatedById;
            $objectIdentityRelatedById->setObjectIdentityRelatedByParentObjectIdentityId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ObjectIdentity is new, it will return
     * an empty collection; or if this ObjectIdentity has previously
     * been saved, it will retrieve related ObjectIdentitiesRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ObjectIdentity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildObjectIdentity[] List of ChildObjectIdentity objects
     */
    public function getObjectIdentitiesRelatedByIdJoinAclClass(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildObjectIdentityQuery::create(null, $criteria);
        $query->joinWith('AclClass', $joinBehavior);

        return $this->getObjectIdentitiesRelatedById($query, $con);
    }

    /**
     * Clears out the collObjectIdentityAncestorsRelatedByObjectIdentityId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addObjectIdentityAncestorsRelatedByObjectIdentityId()
     */
    public function clearObjectIdentityAncestorsRelatedByObjectIdentityId()
    {
        $this->collObjectIdentityAncestorsRelatedByObjectIdentityId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collObjectIdentityAncestorsRelatedByObjectIdentityId collection loaded partially.
     */
    public function resetPartialObjectIdentityAncestorsRelatedByObjectIdentityId($v = true)
    {
        $this->collObjectIdentityAncestorsRelatedByObjectIdentityIdPartial = $v;
    }

    /**
     * Initializes the collObjectIdentityAncestorsRelatedByObjectIdentityId collection.
     *
     * By default this just sets the collObjectIdentityAncestorsRelatedByObjectIdentityId collection to an empty array (like clearcollObjectIdentityAncestorsRelatedByObjectIdentityId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initObjectIdentityAncestorsRelatedByObjectIdentityId($overrideExisting = true)
    {
        if (null !== $this->collObjectIdentityAncestorsRelatedByObjectIdentityId && !$overrideExisting) {
            return;
        }

        $collectionClassName = ObjectIdentityAncestorTableMap::getTableMap()->getCollectionClassName();

        $this->collObjectIdentityAncestorsRelatedByObjectIdentityId = new $collectionClassName;
        $this->collObjectIdentityAncestorsRelatedByObjectIdentityId->setModel('\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor');
    }

    /**
     * Gets an array of ChildObjectIdentityAncestor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildObjectIdentity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildObjectIdentityAncestor[] List of ChildObjectIdentityAncestor objects
     * @throws PropelException
     */
    public function getObjectIdentityAncestorsRelatedByObjectIdentityId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collObjectIdentityAncestorsRelatedByObjectIdentityIdPartial && !$this->isNew();
        if (null === $this->collObjectIdentityAncestorsRelatedByObjectIdentityId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collObjectIdentityAncestorsRelatedByObjectIdentityId) {
                // return empty collection
                $this->initObjectIdentityAncestorsRelatedByObjectIdentityId();
            } else {
                $collObjectIdentityAncestorsRelatedByObjectIdentityId = ChildObjectIdentityAncestorQuery::create(null, $criteria)
                    ->filterByObjectIdentityRelatedByObjectIdentityId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collObjectIdentityAncestorsRelatedByObjectIdentityIdPartial && count($collObjectIdentityAncestorsRelatedByObjectIdentityId)) {
                        $this->initObjectIdentityAncestorsRelatedByObjectIdentityId(false);

                        foreach ($collObjectIdentityAncestorsRelatedByObjectIdentityId as $obj) {
                            if (false == $this->collObjectIdentityAncestorsRelatedByObjectIdentityId->contains($obj)) {
                                $this->collObjectIdentityAncestorsRelatedByObjectIdentityId->append($obj);
                            }
                        }

                        $this->collObjectIdentityAncestorsRelatedByObjectIdentityIdPartial = true;
                    }

                    return $collObjectIdentityAncestorsRelatedByObjectIdentityId;
                }

                if ($partial && $this->collObjectIdentityAncestorsRelatedByObjectIdentityId) {
                    foreach ($this->collObjectIdentityAncestorsRelatedByObjectIdentityId as $obj) {
                        if ($obj->isNew()) {
                            $collObjectIdentityAncestorsRelatedByObjectIdentityId[] = $obj;
                        }
                    }
                }

                $this->collObjectIdentityAncestorsRelatedByObjectIdentityId = $collObjectIdentityAncestorsRelatedByObjectIdentityId;
                $this->collObjectIdentityAncestorsRelatedByObjectIdentityIdPartial = false;
            }
        }

        return $this->collObjectIdentityAncestorsRelatedByObjectIdentityId;
    }

    /**
     * Sets a collection of ChildObjectIdentityAncestor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $objectIdentityAncestorsRelatedByObjectIdentityId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildObjectIdentity The current object (for fluent API support)
     */
    public function setObjectIdentityAncestorsRelatedByObjectIdentityId(Collection $objectIdentityAncestorsRelatedByObjectIdentityId, ConnectionInterface $con = null)
    {
        /** @var ChildObjectIdentityAncestor[] $objectIdentityAncestorsRelatedByObjectIdentityIdToDelete */
        $objectIdentityAncestorsRelatedByObjectIdentityIdToDelete = $this->getObjectIdentityAncestorsRelatedByObjectIdentityId(new Criteria(), $con)->diff($objectIdentityAncestorsRelatedByObjectIdentityId);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion = clone $objectIdentityAncestorsRelatedByObjectIdentityIdToDelete;

        foreach ($objectIdentityAncestorsRelatedByObjectIdentityIdToDelete as $objectIdentityAncestorRelatedByObjectIdentityIdRemoved) {
            $objectIdentityAncestorRelatedByObjectIdentityIdRemoved->setObjectIdentityRelatedByObjectIdentityId(null);
        }

        $this->collObjectIdentityAncestorsRelatedByObjectIdentityId = null;
        foreach ($objectIdentityAncestorsRelatedByObjectIdentityId as $objectIdentityAncestorRelatedByObjectIdentityId) {
            $this->addObjectIdentityAncestorRelatedByObjectIdentityId($objectIdentityAncestorRelatedByObjectIdentityId);
        }

        $this->collObjectIdentityAncestorsRelatedByObjectIdentityId = $objectIdentityAncestorsRelatedByObjectIdentityId;
        $this->collObjectIdentityAncestorsRelatedByObjectIdentityIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ObjectIdentityAncestor objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ObjectIdentityAncestor objects.
     * @throws PropelException
     */
    public function countObjectIdentityAncestorsRelatedByObjectIdentityId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collObjectIdentityAncestorsRelatedByObjectIdentityIdPartial && !$this->isNew();
        if (null === $this->collObjectIdentityAncestorsRelatedByObjectIdentityId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collObjectIdentityAncestorsRelatedByObjectIdentityId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getObjectIdentityAncestorsRelatedByObjectIdentityId());
            }

            $query = ChildObjectIdentityAncestorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByObjectIdentityRelatedByObjectIdentityId($this)
                ->count($con);
        }

        return count($this->collObjectIdentityAncestorsRelatedByObjectIdentityId);
    }

    /**
     * Method called to associate a ChildObjectIdentityAncestor object to this object
     * through the ChildObjectIdentityAncestor foreign key attribute.
     *
     * @param  ChildObjectIdentityAncestor $l ChildObjectIdentityAncestor
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object (for fluent API support)
     */
    public function addObjectIdentityAncestorRelatedByObjectIdentityId(ChildObjectIdentityAncestor $l)
    {
        if ($this->collObjectIdentityAncestorsRelatedByObjectIdentityId === null) {
            $this->initObjectIdentityAncestorsRelatedByObjectIdentityId();
            $this->collObjectIdentityAncestorsRelatedByObjectIdentityIdPartial = true;
        }

        if (!$this->collObjectIdentityAncestorsRelatedByObjectIdentityId->contains($l)) {
            $this->doAddObjectIdentityAncestorRelatedByObjectIdentityId($l);

            if ($this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion and $this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion->contains($l)) {
                $this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion->remove($this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildObjectIdentityAncestor $objectIdentityAncestorRelatedByObjectIdentityId The ChildObjectIdentityAncestor object to add.
     */
    protected function doAddObjectIdentityAncestorRelatedByObjectIdentityId(ChildObjectIdentityAncestor $objectIdentityAncestorRelatedByObjectIdentityId)
    {
        $this->collObjectIdentityAncestorsRelatedByObjectIdentityId[]= $objectIdentityAncestorRelatedByObjectIdentityId;
        $objectIdentityAncestorRelatedByObjectIdentityId->setObjectIdentityRelatedByObjectIdentityId($this);
    }

    /**
     * @param  ChildObjectIdentityAncestor $objectIdentityAncestorRelatedByObjectIdentityId The ChildObjectIdentityAncestor object to remove.
     * @return $this|ChildObjectIdentity The current object (for fluent API support)
     */
    public function removeObjectIdentityAncestorRelatedByObjectIdentityId(ChildObjectIdentityAncestor $objectIdentityAncestorRelatedByObjectIdentityId)
    {
        if ($this->getObjectIdentityAncestorsRelatedByObjectIdentityId()->contains($objectIdentityAncestorRelatedByObjectIdentityId)) {
            $pos = $this->collObjectIdentityAncestorsRelatedByObjectIdentityId->search($objectIdentityAncestorRelatedByObjectIdentityId);
            $this->collObjectIdentityAncestorsRelatedByObjectIdentityId->remove($pos);
            if (null === $this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion) {
                $this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion = clone $this->collObjectIdentityAncestorsRelatedByObjectIdentityId;
                $this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion->clear();
            }
            $this->objectIdentityAncestorsRelatedByObjectIdentityIdScheduledForDeletion[]= clone $objectIdentityAncestorRelatedByObjectIdentityId;
            $objectIdentityAncestorRelatedByObjectIdentityId->setObjectIdentityRelatedByObjectIdentityId(null);
        }

        return $this;
    }

    /**
     * Clears out the collObjectIdentityAncestorsRelatedByAncestorId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addObjectIdentityAncestorsRelatedByAncestorId()
     */
    public function clearObjectIdentityAncestorsRelatedByAncestorId()
    {
        $this->collObjectIdentityAncestorsRelatedByAncestorId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collObjectIdentityAncestorsRelatedByAncestorId collection loaded partially.
     */
    public function resetPartialObjectIdentityAncestorsRelatedByAncestorId($v = true)
    {
        $this->collObjectIdentityAncestorsRelatedByAncestorIdPartial = $v;
    }

    /**
     * Initializes the collObjectIdentityAncestorsRelatedByAncestorId collection.
     *
     * By default this just sets the collObjectIdentityAncestorsRelatedByAncestorId collection to an empty array (like clearcollObjectIdentityAncestorsRelatedByAncestorId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initObjectIdentityAncestorsRelatedByAncestorId($overrideExisting = true)
    {
        if (null !== $this->collObjectIdentityAncestorsRelatedByAncestorId && !$overrideExisting) {
            return;
        }

        $collectionClassName = ObjectIdentityAncestorTableMap::getTableMap()->getCollectionClassName();

        $this->collObjectIdentityAncestorsRelatedByAncestorId = new $collectionClassName;
        $this->collObjectIdentityAncestorsRelatedByAncestorId->setModel('\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor');
    }

    /**
     * Gets an array of ChildObjectIdentityAncestor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildObjectIdentity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildObjectIdentityAncestor[] List of ChildObjectIdentityAncestor objects
     * @throws PropelException
     */
    public function getObjectIdentityAncestorsRelatedByAncestorId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collObjectIdentityAncestorsRelatedByAncestorIdPartial && !$this->isNew();
        if (null === $this->collObjectIdentityAncestorsRelatedByAncestorId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collObjectIdentityAncestorsRelatedByAncestorId) {
                // return empty collection
                $this->initObjectIdentityAncestorsRelatedByAncestorId();
            } else {
                $collObjectIdentityAncestorsRelatedByAncestorId = ChildObjectIdentityAncestorQuery::create(null, $criteria)
                    ->filterByObjectIdentityRelatedByAncestorId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collObjectIdentityAncestorsRelatedByAncestorIdPartial && count($collObjectIdentityAncestorsRelatedByAncestorId)) {
                        $this->initObjectIdentityAncestorsRelatedByAncestorId(false);

                        foreach ($collObjectIdentityAncestorsRelatedByAncestorId as $obj) {
                            if (false == $this->collObjectIdentityAncestorsRelatedByAncestorId->contains($obj)) {
                                $this->collObjectIdentityAncestorsRelatedByAncestorId->append($obj);
                            }
                        }

                        $this->collObjectIdentityAncestorsRelatedByAncestorIdPartial = true;
                    }

                    return $collObjectIdentityAncestorsRelatedByAncestorId;
                }

                if ($partial && $this->collObjectIdentityAncestorsRelatedByAncestorId) {
                    foreach ($this->collObjectIdentityAncestorsRelatedByAncestorId as $obj) {
                        if ($obj->isNew()) {
                            $collObjectIdentityAncestorsRelatedByAncestorId[] = $obj;
                        }
                    }
                }

                $this->collObjectIdentityAncestorsRelatedByAncestorId = $collObjectIdentityAncestorsRelatedByAncestorId;
                $this->collObjectIdentityAncestorsRelatedByAncestorIdPartial = false;
            }
        }

        return $this->collObjectIdentityAncestorsRelatedByAncestorId;
    }

    /**
     * Sets a collection of ChildObjectIdentityAncestor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $objectIdentityAncestorsRelatedByAncestorId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildObjectIdentity The current object (for fluent API support)
     */
    public function setObjectIdentityAncestorsRelatedByAncestorId(Collection $objectIdentityAncestorsRelatedByAncestorId, ConnectionInterface $con = null)
    {
        /** @var ChildObjectIdentityAncestor[] $objectIdentityAncestorsRelatedByAncestorIdToDelete */
        $objectIdentityAncestorsRelatedByAncestorIdToDelete = $this->getObjectIdentityAncestorsRelatedByAncestorId(new Criteria(), $con)->diff($objectIdentityAncestorsRelatedByAncestorId);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion = clone $objectIdentityAncestorsRelatedByAncestorIdToDelete;

        foreach ($objectIdentityAncestorsRelatedByAncestorIdToDelete as $objectIdentityAncestorRelatedByAncestorIdRemoved) {
            $objectIdentityAncestorRelatedByAncestorIdRemoved->setObjectIdentityRelatedByAncestorId(null);
        }

        $this->collObjectIdentityAncestorsRelatedByAncestorId = null;
        foreach ($objectIdentityAncestorsRelatedByAncestorId as $objectIdentityAncestorRelatedByAncestorId) {
            $this->addObjectIdentityAncestorRelatedByAncestorId($objectIdentityAncestorRelatedByAncestorId);
        }

        $this->collObjectIdentityAncestorsRelatedByAncestorId = $objectIdentityAncestorsRelatedByAncestorId;
        $this->collObjectIdentityAncestorsRelatedByAncestorIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ObjectIdentityAncestor objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ObjectIdentityAncestor objects.
     * @throws PropelException
     */
    public function countObjectIdentityAncestorsRelatedByAncestorId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collObjectIdentityAncestorsRelatedByAncestorIdPartial && !$this->isNew();
        if (null === $this->collObjectIdentityAncestorsRelatedByAncestorId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collObjectIdentityAncestorsRelatedByAncestorId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getObjectIdentityAncestorsRelatedByAncestorId());
            }

            $query = ChildObjectIdentityAncestorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByObjectIdentityRelatedByAncestorId($this)
                ->count($con);
        }

        return count($this->collObjectIdentityAncestorsRelatedByAncestorId);
    }

    /**
     * Method called to associate a ChildObjectIdentityAncestor object to this object
     * through the ChildObjectIdentityAncestor foreign key attribute.
     *
     * @param  ChildObjectIdentityAncestor $l ChildObjectIdentityAncestor
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object (for fluent API support)
     */
    public function addObjectIdentityAncestorRelatedByAncestorId(ChildObjectIdentityAncestor $l)
    {
        if ($this->collObjectIdentityAncestorsRelatedByAncestorId === null) {
            $this->initObjectIdentityAncestorsRelatedByAncestorId();
            $this->collObjectIdentityAncestorsRelatedByAncestorIdPartial = true;
        }

        if (!$this->collObjectIdentityAncestorsRelatedByAncestorId->contains($l)) {
            $this->doAddObjectIdentityAncestorRelatedByAncestorId($l);

            if ($this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion and $this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion->contains($l)) {
                $this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion->remove($this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildObjectIdentityAncestor $objectIdentityAncestorRelatedByAncestorId The ChildObjectIdentityAncestor object to add.
     */
    protected function doAddObjectIdentityAncestorRelatedByAncestorId(ChildObjectIdentityAncestor $objectIdentityAncestorRelatedByAncestorId)
    {
        $this->collObjectIdentityAncestorsRelatedByAncestorId[]= $objectIdentityAncestorRelatedByAncestorId;
        $objectIdentityAncestorRelatedByAncestorId->setObjectIdentityRelatedByAncestorId($this);
    }

    /**
     * @param  ChildObjectIdentityAncestor $objectIdentityAncestorRelatedByAncestorId The ChildObjectIdentityAncestor object to remove.
     * @return $this|ChildObjectIdentity The current object (for fluent API support)
     */
    public function removeObjectIdentityAncestorRelatedByAncestorId(ChildObjectIdentityAncestor $objectIdentityAncestorRelatedByAncestorId)
    {
        if ($this->getObjectIdentityAncestorsRelatedByAncestorId()->contains($objectIdentityAncestorRelatedByAncestorId)) {
            $pos = $this->collObjectIdentityAncestorsRelatedByAncestorId->search($objectIdentityAncestorRelatedByAncestorId);
            $this->collObjectIdentityAncestorsRelatedByAncestorId->remove($pos);
            if (null === $this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion) {
                $this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion = clone $this->collObjectIdentityAncestorsRelatedByAncestorId;
                $this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion->clear();
            }
            $this->objectIdentityAncestorsRelatedByAncestorIdScheduledForDeletion[]= clone $objectIdentityAncestorRelatedByAncestorId;
            $objectIdentityAncestorRelatedByAncestorId->setObjectIdentityRelatedByAncestorId(null);
        }

        return $this;
    }

    /**
     * Clears out the collEntries collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEntries()
     */
    public function clearEntries()
    {
        $this->collEntries = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEntries collection loaded partially.
     */
    public function resetPartialEntries($v = true)
    {
        $this->collEntriesPartial = $v;
    }

    /**
     * Initializes the collEntries collection.
     *
     * By default this just sets the collEntries collection to an empty array (like clearcollEntries());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEntries($overrideExisting = true)
    {
        if (null !== $this->collEntries && !$overrideExisting) {
            return;
        }

        $collectionClassName = EntryTableMap::getTableMap()->getCollectionClassName();

        $this->collEntries = new $collectionClassName;
        $this->collEntries->setModel('\Propel\Bundle\PropelBundle\Model\Acl\Entry');
    }

    /**
     * Gets an array of ChildEntry objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildObjectIdentity is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEntry[] List of ChildEntry objects
     * @throws PropelException
     */
    public function getEntries(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEntriesPartial && !$this->isNew();
        if (null === $this->collEntries || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEntries) {
                // return empty collection
                $this->initEntries();
            } else {
                $collEntries = ChildEntryQuery::create(null, $criteria)
                    ->filterByObjectIdentity($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEntriesPartial && count($collEntries)) {
                        $this->initEntries(false);

                        foreach ($collEntries as $obj) {
                            if (false == $this->collEntries->contains($obj)) {
                                $this->collEntries->append($obj);
                            }
                        }

                        $this->collEntriesPartial = true;
                    }

                    return $collEntries;
                }

                if ($partial && $this->collEntries) {
                    foreach ($this->collEntries as $obj) {
                        if ($obj->isNew()) {
                            $collEntries[] = $obj;
                        }
                    }
                }

                $this->collEntries = $collEntries;
                $this->collEntriesPartial = false;
            }
        }

        return $this->collEntries;
    }

    /**
     * Sets a collection of ChildEntry objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $entries A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildObjectIdentity The current object (for fluent API support)
     */
    public function setEntries(Collection $entries, ConnectionInterface $con = null)
    {
        /** @var ChildEntry[] $entriesToDelete */
        $entriesToDelete = $this->getEntries(new Criteria(), $con)->diff($entries);


        $this->entriesScheduledForDeletion = $entriesToDelete;

        foreach ($entriesToDelete as $entryRemoved) {
            $entryRemoved->setObjectIdentity(null);
        }

        $this->collEntries = null;
        foreach ($entries as $entry) {
            $this->addEntry($entry);
        }

        $this->collEntries = $entries;
        $this->collEntriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Entry objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Entry objects.
     * @throws PropelException
     */
    public function countEntries(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEntriesPartial && !$this->isNew();
        if (null === $this->collEntries || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEntries) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEntries());
            }

            $query = ChildEntryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByObjectIdentity($this)
                ->count($con);
        }

        return count($this->collEntries);
    }

    /**
     * Method called to associate a ChildEntry object to this object
     * through the ChildEntry foreign key attribute.
     *
     * @param  ChildEntry $l ChildEntry
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity The current object (for fluent API support)
     */
    public function addEntry(ChildEntry $l)
    {
        if ($this->collEntries === null) {
            $this->initEntries();
            $this->collEntriesPartial = true;
        }

        if (!$this->collEntries->contains($l)) {
            $this->doAddEntry($l);

            if ($this->entriesScheduledForDeletion and $this->entriesScheduledForDeletion->contains($l)) {
                $this->entriesScheduledForDeletion->remove($this->entriesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildEntry $entry The ChildEntry object to add.
     */
    protected function doAddEntry(ChildEntry $entry)
    {
        $this->collEntries[]= $entry;
        $entry->setObjectIdentity($this);
    }

    /**
     * @param  ChildEntry $entry The ChildEntry object to remove.
     * @return $this|ChildObjectIdentity The current object (for fluent API support)
     */
    public function removeEntry(ChildEntry $entry)
    {
        if ($this->getEntries()->contains($entry)) {
            $pos = $this->collEntries->search($entry);
            $this->collEntries->remove($pos);
            if (null === $this->entriesScheduledForDeletion) {
                $this->entriesScheduledForDeletion = clone $this->collEntries;
                $this->entriesScheduledForDeletion->clear();
            }
            $this->entriesScheduledForDeletion[]= $entry;
            $entry->setObjectIdentity(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ObjectIdentity is new, it will return
     * an empty collection; or if this ObjectIdentity has previously
     * been saved, it will retrieve related Entries from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ObjectIdentity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildEntry[] List of ChildEntry objects
     */
    public function getEntriesJoinAclClass(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildEntryQuery::create(null, $criteria);
        $query->joinWith('AclClass', $joinBehavior);

        return $this->getEntries($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ObjectIdentity is new, it will return
     * an empty collection; or if this ObjectIdentity has previously
     * been saved, it will retrieve related Entries from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ObjectIdentity.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildEntry[] List of ChildEntry objects
     */
    public function getEntriesJoinSecurityIdentity(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildEntryQuery::create(null, $criteria);
        $query->joinWith('SecurityIdentity', $joinBehavior);

        return $this->getEntries($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aAclClass) {
            $this->aAclClass->removeObjectIdentity($this);
        }
        if (null !== $this->aObjectIdentityRelatedByParentObjectIdentityId) {
            $this->aObjectIdentityRelatedByParentObjectIdentityId->removeObjectIdentityRelatedById($this);
        }
        $this->id = null;
        $this->class_id = null;
        $this->object_identifier = null;
        $this->parent_object_identity_id = null;
        $this->entries_inheriting = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collObjectIdentitiesRelatedById) {
                foreach ($this->collObjectIdentitiesRelatedById as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collObjectIdentityAncestorsRelatedByObjectIdentityId) {
                foreach ($this->collObjectIdentityAncestorsRelatedByObjectIdentityId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collObjectIdentityAncestorsRelatedByAncestorId) {
                foreach ($this->collObjectIdentityAncestorsRelatedByAncestorId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEntries) {
                foreach ($this->collEntries as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collObjectIdentitiesRelatedById = null;
        $this->collObjectIdentityAncestorsRelatedByObjectIdentityId = null;
        $this->collObjectIdentityAncestorsRelatedByAncestorId = null;
        $this->collEntries = null;
        $this->aAclClass = null;
        $this->aObjectIdentityRelatedByParentObjectIdentityId = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ObjectIdentityTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
