<?php

namespace Propel\Bundle\PropelBundle\Model\Acl\Base;

use \Exception;
use \PDO;
use Propel\Bundle\PropelBundle\Model\Acl\AclClass as ChildAclClass;
use Propel\Bundle\PropelBundle\Model\Acl\AclClassQuery as ChildAclClassQuery;
use Propel\Bundle\PropelBundle\Model\Acl\EntryQuery as ChildEntryQuery;
use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity as ChildObjectIdentity;
use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery as ChildObjectIdentityQuery;
use Propel\Bundle\PropelBundle\Model\Acl\SecurityIdentity as ChildSecurityIdentity;
use Propel\Bundle\PropelBundle\Model\Acl\SecurityIdentityQuery as ChildSecurityIdentityQuery;
use Propel\Bundle\PropelBundle\Model\Acl\Map\EntryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'acl_entries' table.
 *
 *
 *
 * @package    propel.generator.Propel.Bundle.PropelBundle.Model.Acl.Base
 */
abstract class Entry implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\Map\\EntryTableMap';


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
     * The value for the object_identity_id field.
     *
     * @var        int
     */
    protected $object_identity_id;

    /**
     * The value for the security_identity_id field.
     *
     * @var        int
     */
    protected $security_identity_id;

    /**
     * The value for the field_name field.
     *
     * @var        string
     */
    protected $field_name;

    /**
     * The value for the ace_order field.
     *
     * @var        int
     */
    protected $ace_order;

    /**
     * The value for the mask field.
     *
     * @var        int
     */
    protected $mask;

    /**
     * The value for the granting field.
     *
     * @var        boolean
     */
    protected $granting;

    /**
     * The value for the granting_strategy field.
     *
     * @var        string
     */
    protected $granting_strategy;

    /**
     * The value for the audit_success field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $audit_success;

    /**
     * The value for the audit_failure field.
     *
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $audit_failure;

    /**
     * @var        ChildAclClass
     */
    protected $aAclClass;

    /**
     * @var        ChildObjectIdentity
     */
    protected $aObjectIdentity;

    /**
     * @var        ChildSecurityIdentity
     */
    protected $aSecurityIdentity;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->audit_success = false;
        $this->audit_failure = true;
    }

    /**
     * Initializes internal state of Propel\Bundle\PropelBundle\Model\Acl\Base\Entry object.
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
     * Compares this with another <code>Entry</code> instance.  If
     * <code>obj</code> is an instance of <code>Entry</code>, delegates to
     * <code>equals(Entry)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Entry The current object, for fluid interface
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
     * Get the [object_identity_id] column value.
     *
     * @return int
     */
    public function getObjectIdentityId()
    {
        return $this->object_identity_id;
    }

    /**
     * Get the [security_identity_id] column value.
     *
     * @return int
     */
    public function getSecurityIdentityId()
    {
        return $this->security_identity_id;
    }

    /**
     * Get the [field_name] column value.
     *
     * @return string
     */
    public function getFieldName()
    {
        return $this->field_name;
    }

    /**
     * Get the [ace_order] column value.
     *
     * @return int
     */
    public function getAceOrder()
    {
        return $this->ace_order;
    }

    /**
     * Get the [mask] column value.
     *
     * @return int
     */
    public function getMask()
    {
        return $this->mask;
    }

    /**
     * Get the [granting] column value.
     *
     * @return boolean
     */
    public function getGranting()
    {
        return $this->granting;
    }

    /**
     * Get the [granting] column value.
     *
     * @return boolean
     */
    public function isGranting()
    {
        return $this->getGranting();
    }

    /**
     * Get the [granting_strategy] column value.
     *
     * @return string
     */
    public function getGrantingStrategy()
    {
        return $this->granting_strategy;
    }

    /**
     * Get the [audit_success] column value.
     *
     * @return boolean
     */
    public function getAuditSuccess()
    {
        return $this->audit_success;
    }

    /**
     * Get the [audit_success] column value.
     *
     * @return boolean
     */
    public function isAuditSuccess()
    {
        return $this->getAuditSuccess();
    }

    /**
     * Get the [audit_failure] column value.
     *
     * @return boolean
     */
    public function getAuditFailure()
    {
        return $this->audit_failure;
    }

    /**
     * Get the [audit_failure] column value.
     *
     * @return boolean
     */
    public function isAuditFailure()
    {
        return $this->getAuditFailure();
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[EntryTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [class_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     */
    public function setClassId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->class_id !== $v) {
            $this->class_id = $v;
            $this->modifiedColumns[EntryTableMap::COL_CLASS_ID] = true;
        }

        if ($this->aAclClass !== null && $this->aAclClass->getId() !== $v) {
            $this->aAclClass = null;
        }

        return $this;
    } // setClassId()

    /**
     * Set the value of [object_identity_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     */
    public function setObjectIdentityId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->object_identity_id !== $v) {
            $this->object_identity_id = $v;
            $this->modifiedColumns[EntryTableMap::COL_OBJECT_IDENTITY_ID] = true;
        }

        if ($this->aObjectIdentity !== null && $this->aObjectIdentity->getId() !== $v) {
            $this->aObjectIdentity = null;
        }

        return $this;
    } // setObjectIdentityId()

    /**
     * Set the value of [security_identity_id] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     */
    public function setSecurityIdentityId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->security_identity_id !== $v) {
            $this->security_identity_id = $v;
            $this->modifiedColumns[EntryTableMap::COL_SECURITY_IDENTITY_ID] = true;
        }

        if ($this->aSecurityIdentity !== null && $this->aSecurityIdentity->getId() !== $v) {
            $this->aSecurityIdentity = null;
        }

        return $this;
    } // setSecurityIdentityId()

    /**
     * Set the value of [field_name] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     */
    public function setFieldName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->field_name !== $v) {
            $this->field_name = $v;
            $this->modifiedColumns[EntryTableMap::COL_FIELD_NAME] = true;
        }

        return $this;
    } // setFieldName()

    /**
     * Set the value of [ace_order] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     */
    public function setAceOrder($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ace_order !== $v) {
            $this->ace_order = $v;
            $this->modifiedColumns[EntryTableMap::COL_ACE_ORDER] = true;
        }

        return $this;
    } // setAceOrder()

    /**
     * Set the value of [mask] column.
     *
     * @param int $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     */
    public function setMask($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->mask !== $v) {
            $this->mask = $v;
            $this->modifiedColumns[EntryTableMap::COL_MASK] = true;
        }

        return $this;
    } // setMask()

    /**
     * Sets the value of the [granting] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     */
    public function setGranting($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->granting !== $v) {
            $this->granting = $v;
            $this->modifiedColumns[EntryTableMap::COL_GRANTING] = true;
        }

        return $this;
    } // setGranting()

    /**
     * Set the value of [granting_strategy] column.
     *
     * @param string $v new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     */
    public function setGrantingStrategy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->granting_strategy !== $v) {
            $this->granting_strategy = $v;
            $this->modifiedColumns[EntryTableMap::COL_GRANTING_STRATEGY] = true;
        }

        return $this;
    } // setGrantingStrategy()

    /**
     * Sets the value of the [audit_success] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     */
    public function setAuditSuccess($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->audit_success !== $v) {
            $this->audit_success = $v;
            $this->modifiedColumns[EntryTableMap::COL_AUDIT_SUCCESS] = true;
        }

        return $this;
    } // setAuditSuccess()

    /**
     * Sets the value of the [audit_failure] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     */
    public function setAuditFailure($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->audit_failure !== $v) {
            $this->audit_failure = $v;
            $this->modifiedColumns[EntryTableMap::COL_AUDIT_FAILURE] = true;
        }

        return $this;
    } // setAuditFailure()

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
            if ($this->audit_success !== false) {
                return false;
            }

            if ($this->audit_failure !== true) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EntryTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EntryTableMap::translateFieldName('ClassId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->class_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EntryTableMap::translateFieldName('ObjectIdentityId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->object_identity_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EntryTableMap::translateFieldName('SecurityIdentityId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->security_identity_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EntryTableMap::translateFieldName('FieldName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->field_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EntryTableMap::translateFieldName('AceOrder', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ace_order = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : EntryTableMap::translateFieldName('Mask', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mask = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : EntryTableMap::translateFieldName('Granting', TableMap::TYPE_PHPNAME, $indexType)];
            $this->granting = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : EntryTableMap::translateFieldName('GrantingStrategy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->granting_strategy = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : EntryTableMap::translateFieldName('AuditSuccess', TableMap::TYPE_PHPNAME, $indexType)];
            $this->audit_success = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : EntryTableMap::translateFieldName('AuditFailure', TableMap::TYPE_PHPNAME, $indexType)];
            $this->audit_failure = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = EntryTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\Entry'), 0, $e);
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
        if ($this->aObjectIdentity !== null && $this->object_identity_id !== $this->aObjectIdentity->getId()) {
            $this->aObjectIdentity = null;
        }
        if ($this->aSecurityIdentity !== null && $this->security_identity_id !== $this->aSecurityIdentity->getId()) {
            $this->aSecurityIdentity = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(EntryTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEntryQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAclClass = null;
            $this->aObjectIdentity = null;
            $this->aSecurityIdentity = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Entry::setDeleted()
     * @see Entry::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EntryTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEntryQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EntryTableMap::DATABASE_NAME);
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
                EntryTableMap::addInstanceToPool($this);
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

            if ($this->aObjectIdentity !== null) {
                if ($this->aObjectIdentity->isModified() || $this->aObjectIdentity->isNew()) {
                    $affectedRows += $this->aObjectIdentity->save($con);
                }
                $this->setObjectIdentity($this->aObjectIdentity);
            }

            if ($this->aSecurityIdentity !== null) {
                if ($this->aSecurityIdentity->isModified() || $this->aSecurityIdentity->isNew()) {
                    $affectedRows += $this->aSecurityIdentity->save($con);
                }
                $this->setSecurityIdentity($this->aSecurityIdentity);
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

        $this->modifiedColumns[EntryTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EntryTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EntryTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(EntryTableMap::COL_CLASS_ID)) {
            $modifiedColumns[':p' . $index++]  = 'class_id';
        }
        if ($this->isColumnModified(EntryTableMap::COL_OBJECT_IDENTITY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'object_identity_id';
        }
        if ($this->isColumnModified(EntryTableMap::COL_SECURITY_IDENTITY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'security_identity_id';
        }
        if ($this->isColumnModified(EntryTableMap::COL_FIELD_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'field_name';
        }
        if ($this->isColumnModified(EntryTableMap::COL_ACE_ORDER)) {
            $modifiedColumns[':p' . $index++]  = 'ace_order';
        }
        if ($this->isColumnModified(EntryTableMap::COL_MASK)) {
            $modifiedColumns[':p' . $index++]  = 'mask';
        }
        if ($this->isColumnModified(EntryTableMap::COL_GRANTING)) {
            $modifiedColumns[':p' . $index++]  = 'granting';
        }
        if ($this->isColumnModified(EntryTableMap::COL_GRANTING_STRATEGY)) {
            $modifiedColumns[':p' . $index++]  = 'granting_strategy';
        }
        if ($this->isColumnModified(EntryTableMap::COL_AUDIT_SUCCESS)) {
            $modifiedColumns[':p' . $index++]  = 'audit_success';
        }
        if ($this->isColumnModified(EntryTableMap::COL_AUDIT_FAILURE)) {
            $modifiedColumns[':p' . $index++]  = 'audit_failure';
        }

        $sql = sprintf(
            'INSERT INTO acl_entries (%s) VALUES (%s)',
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
                    case 'object_identity_id':
                        $stmt->bindValue($identifier, $this->object_identity_id, PDO::PARAM_INT);
                        break;
                    case 'security_identity_id':
                        $stmt->bindValue($identifier, $this->security_identity_id, PDO::PARAM_INT);
                        break;
                    case 'field_name':
                        $stmt->bindValue($identifier, $this->field_name, PDO::PARAM_STR);
                        break;
                    case 'ace_order':
                        $stmt->bindValue($identifier, $this->ace_order, PDO::PARAM_INT);
                        break;
                    case 'mask':
                        $stmt->bindValue($identifier, $this->mask, PDO::PARAM_INT);
                        break;
                    case 'granting':
                        $stmt->bindValue($identifier, (int) $this->granting, PDO::PARAM_INT);
                        break;
                    case 'granting_strategy':
                        $stmt->bindValue($identifier, $this->granting_strategy, PDO::PARAM_STR);
                        break;
                    case 'audit_success':
                        $stmt->bindValue($identifier, (int) $this->audit_success, PDO::PARAM_INT);
                        break;
                    case 'audit_failure':
                        $stmt->bindValue($identifier, (int) $this->audit_failure, PDO::PARAM_INT);
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
        $pos = EntryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getObjectIdentityId();
                break;
            case 3:
                return $this->getSecurityIdentityId();
                break;
            case 4:
                return $this->getFieldName();
                break;
            case 5:
                return $this->getAceOrder();
                break;
            case 6:
                return $this->getMask();
                break;
            case 7:
                return $this->getGranting();
                break;
            case 8:
                return $this->getGrantingStrategy();
                break;
            case 9:
                return $this->getAuditSuccess();
                break;
            case 10:
                return $this->getAuditFailure();
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

        if (isset($alreadyDumpedObjects['Entry'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Entry'][$this->hashCode()] = true;
        $keys = EntryTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getClassId(),
            $keys[2] => $this->getObjectIdentityId(),
            $keys[3] => $this->getSecurityIdentityId(),
            $keys[4] => $this->getFieldName(),
            $keys[5] => $this->getAceOrder(),
            $keys[6] => $this->getMask(),
            $keys[7] => $this->getGranting(),
            $keys[8] => $this->getGrantingStrategy(),
            $keys[9] => $this->getAuditSuccess(),
            $keys[10] => $this->getAuditFailure(),
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
            if (null !== $this->aObjectIdentity) {

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

                $result[$key] = $this->aObjectIdentity->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSecurityIdentity) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'securityIdentity';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'acl_security_identities';
                        break;
                    default:
                        $key = 'SecurityIdentity';
                }

                $result[$key] = $this->aSecurityIdentity->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EntryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry
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
                $this->setObjectIdentityId($value);
                break;
            case 3:
                $this->setSecurityIdentityId($value);
                break;
            case 4:
                $this->setFieldName($value);
                break;
            case 5:
                $this->setAceOrder($value);
                break;
            case 6:
                $this->setMask($value);
                break;
            case 7:
                $this->setGranting($value);
                break;
            case 8:
                $this->setGrantingStrategy($value);
                break;
            case 9:
                $this->setAuditSuccess($value);
                break;
            case 10:
                $this->setAuditFailure($value);
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
        $keys = EntryTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setClassId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setObjectIdentityId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSecurityIdentityId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setFieldName($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAceOrder($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setMask($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setGranting($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setGrantingStrategy($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setAuditSuccess($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setAuditFailure($arr[$keys[10]]);
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
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object, for fluid interface
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
        $criteria = new Criteria(EntryTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EntryTableMap::COL_ID)) {
            $criteria->add(EntryTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(EntryTableMap::COL_CLASS_ID)) {
            $criteria->add(EntryTableMap::COL_CLASS_ID, $this->class_id);
        }
        if ($this->isColumnModified(EntryTableMap::COL_OBJECT_IDENTITY_ID)) {
            $criteria->add(EntryTableMap::COL_OBJECT_IDENTITY_ID, $this->object_identity_id);
        }
        if ($this->isColumnModified(EntryTableMap::COL_SECURITY_IDENTITY_ID)) {
            $criteria->add(EntryTableMap::COL_SECURITY_IDENTITY_ID, $this->security_identity_id);
        }
        if ($this->isColumnModified(EntryTableMap::COL_FIELD_NAME)) {
            $criteria->add(EntryTableMap::COL_FIELD_NAME, $this->field_name);
        }
        if ($this->isColumnModified(EntryTableMap::COL_ACE_ORDER)) {
            $criteria->add(EntryTableMap::COL_ACE_ORDER, $this->ace_order);
        }
        if ($this->isColumnModified(EntryTableMap::COL_MASK)) {
            $criteria->add(EntryTableMap::COL_MASK, $this->mask);
        }
        if ($this->isColumnModified(EntryTableMap::COL_GRANTING)) {
            $criteria->add(EntryTableMap::COL_GRANTING, $this->granting);
        }
        if ($this->isColumnModified(EntryTableMap::COL_GRANTING_STRATEGY)) {
            $criteria->add(EntryTableMap::COL_GRANTING_STRATEGY, $this->granting_strategy);
        }
        if ($this->isColumnModified(EntryTableMap::COL_AUDIT_SUCCESS)) {
            $criteria->add(EntryTableMap::COL_AUDIT_SUCCESS, $this->audit_success);
        }
        if ($this->isColumnModified(EntryTableMap::COL_AUDIT_FAILURE)) {
            $criteria->add(EntryTableMap::COL_AUDIT_FAILURE, $this->audit_failure);
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
        $criteria = ChildEntryQuery::create();
        $criteria->add(EntryTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Propel\Bundle\PropelBundle\Model\Acl\Entry (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setClassId($this->getClassId());
        $copyObj->setObjectIdentityId($this->getObjectIdentityId());
        $copyObj->setSecurityIdentityId($this->getSecurityIdentityId());
        $copyObj->setFieldName($this->getFieldName());
        $copyObj->setAceOrder($this->getAceOrder());
        $copyObj->setMask($this->getMask());
        $copyObj->setGranting($this->getGranting());
        $copyObj->setGrantingStrategy($this->getGrantingStrategy());
        $copyObj->setAuditSuccess($this->getAuditSuccess());
        $copyObj->setAuditFailure($this->getAuditFailure());
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
     * @return \Propel\Bundle\PropelBundle\Model\Acl\Entry Clone of current object.
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
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
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
            $v->addEntry($this);
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
                $this->aAclClass->addEntries($this);
             */
        }

        return $this->aAclClass;
    }

    /**
     * Declares an association between this object and a ChildObjectIdentity object.
     *
     * @param  ChildObjectIdentity $v
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     * @throws PropelException
     */
    public function setObjectIdentity(ChildObjectIdentity $v = null)
    {
        if ($v === null) {
            $this->setObjectIdentityId(NULL);
        } else {
            $this->setObjectIdentityId($v->getId());
        }

        $this->aObjectIdentity = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildObjectIdentity object, it will not be re-added.
        if ($v !== null) {
            $v->addEntry($this);
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
    public function getObjectIdentity(ConnectionInterface $con = null)
    {
        if ($this->aObjectIdentity === null && ($this->object_identity_id !== null)) {
            $this->aObjectIdentity = ChildObjectIdentityQuery::create()->findPk($this->object_identity_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aObjectIdentity->addEntries($this);
             */
        }

        return $this->aObjectIdentity;
    }

    /**
     * Declares an association between this object and a ChildSecurityIdentity object.
     *
     * @param  ChildSecurityIdentity $v
     * @return $this|\Propel\Bundle\PropelBundle\Model\Acl\Entry The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSecurityIdentity(ChildSecurityIdentity $v = null)
    {
        if ($v === null) {
            $this->setSecurityIdentityId(NULL);
        } else {
            $this->setSecurityIdentityId($v->getId());
        }

        $this->aSecurityIdentity = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSecurityIdentity object, it will not be re-added.
        if ($v !== null) {
            $v->addEntry($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSecurityIdentity object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSecurityIdentity The associated ChildSecurityIdentity object.
     * @throws PropelException
     */
    public function getSecurityIdentity(ConnectionInterface $con = null)
    {
        if ($this->aSecurityIdentity === null && ($this->security_identity_id !== null)) {
            $this->aSecurityIdentity = ChildSecurityIdentityQuery::create()->findPk($this->security_identity_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSecurityIdentity->addEntries($this);
             */
        }

        return $this->aSecurityIdentity;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aAclClass) {
            $this->aAclClass->removeEntry($this);
        }
        if (null !== $this->aObjectIdentity) {
            $this->aObjectIdentity->removeEntry($this);
        }
        if (null !== $this->aSecurityIdentity) {
            $this->aSecurityIdentity->removeEntry($this);
        }
        $this->id = null;
        $this->class_id = null;
        $this->object_identity_id = null;
        $this->security_identity_id = null;
        $this->field_name = null;
        $this->ace_order = null;
        $this->mask = null;
        $this->granting = null;
        $this->granting_strategy = null;
        $this->audit_success = null;
        $this->audit_failure = null;
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
        } // if ($deep)

        $this->aAclClass = null;
        $this->aObjectIdentity = null;
        $this->aSecurityIdentity = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EntryTableMap::DEFAULT_STRING_FORMAT);
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
