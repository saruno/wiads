<?php

namespace AdvertiserBundle\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use AdvertiserBundle\Model\Employee as ChildEmployee;
use AdvertiserBundle\Model\EmployeeQuery as ChildEmployeeQuery;
use AdvertiserBundle\Model\InventoryDeliveryVoucher as ChildInventoryDeliveryVoucher;
use AdvertiserBundle\Model\InventoryDeliveryVoucherQuery as ChildInventoryDeliveryVoucherQuery;
use AdvertiserBundle\Model\InventoryReceivingVoucher as ChildInventoryReceivingVoucher;
use AdvertiserBundle\Model\InventoryReceivingVoucherQuery as ChildInventoryReceivingVoucherQuery;
use AdvertiserBundle\Model\Product as ChildProduct;
use AdvertiserBundle\Model\ProductQuery as ChildProductQuery;
use AdvertiserBundle\Model\Warehouse as ChildWarehouse;
use AdvertiserBundle\Model\WarehouseQuery as ChildWarehouseQuery;
use AdvertiserBundle\Model\Map\InventoryDeliveryVoucherTableMap;
use AdvertiserBundle\Model\Map\InventoryReceivingVoucherTableMap;
use AdvertiserBundle\Model\Map\ProductTableMap;
use AdvertiserBundle\Model\Map\WarehouseTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'warehouse' table.
 *
 *
 *
 * @package    propel.generator.src.AdvertiserBundle.Model.Base
 */
abstract class Warehouse implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\AdvertiserBundle\\Model\\Map\\WarehouseTableMap';


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
     * The value for the employee_id field.
     *
     * @var        int
     */
    protected $employee_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the address field.
     *
     * @var        string
     */
    protected $address;

    /**
     * The value for the phone field.
     *
     * @var        string
     */
    protected $phone;

    /**
     * The value for the created_at field.
     *
     * @var        DateTime
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     *
     * @var        DateTime
     */
    protected $updated_at;

    /**
     * @var        ChildEmployee
     */
    protected $aEmployee;

    /**
     * @var        ObjectCollection|ChildInventoryReceivingVoucher[] Collection to store aggregation of ChildInventoryReceivingVoucher objects.
     */
    protected $collInventoryReceivingVouchers;
    protected $collInventoryReceivingVouchersPartial;

    /**
     * @var        ObjectCollection|ChildProduct[] Collection to store aggregation of ChildProduct objects.
     */
    protected $collProducts;
    protected $collProductsPartial;

    /**
     * @var        ObjectCollection|ChildInventoryDeliveryVoucher[] Collection to store aggregation of ChildInventoryDeliveryVoucher objects.
     */
    protected $collInventoryDeliveryVouchers;
    protected $collInventoryDeliveryVouchersPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInventoryReceivingVoucher[]
     */
    protected $inventoryReceivingVouchersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildProduct[]
     */
    protected $productsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInventoryDeliveryVoucher[]
     */
    protected $inventoryDeliveryVouchersScheduledForDeletion = null;

    /**
     * Initializes internal state of AdvertiserBundle\Model\Base\Warehouse object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>Warehouse</code> instance.  If
     * <code>obj</code> is an instance of <code>Warehouse</code>, delegates to
     * <code>equals(Warehouse)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Warehouse The current object, for fluid interface
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
     * Get the [employee_id] column value.
     *
     * @return int
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [address] column value.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get the [phone] column value.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTimeInterface ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTimeInterface ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[WarehouseTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [employee_id] column.
     *
     * @param int $v new value
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object (for fluent API support)
     */
    public function setEmployeeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->employee_id !== $v) {
            $this->employee_id = $v;
            $this->modifiedColumns[WarehouseTableMap::COL_EMPLOYEE_ID] = true;
        }

        if ($this->aEmployee !== null && $this->aEmployee->getId() !== $v) {
            $this->aEmployee = null;
        }

        return $this;
    } // setEmployeeId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[WarehouseTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [address] column.
     *
     * @param string $v new value
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[WarehouseTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Set the value of [phone] column.
     *
     * @param string $v new value
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[WarehouseTableMap::COL_PHONE] = true;
        }

        return $this;
    } // setPhone()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[WarehouseTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[WarehouseTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : WarehouseTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : WarehouseTableMap::translateFieldName('EmployeeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->employee_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : WarehouseTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : WarehouseTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : WarehouseTableMap::translateFieldName('Phone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : WarehouseTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : WarehouseTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = WarehouseTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\AdvertiserBundle\\Model\\Warehouse'), 0, $e);
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
        if ($this->aEmployee !== null && $this->employee_id !== $this->aEmployee->getId()) {
            $this->aEmployee = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(WarehouseTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildWarehouseQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEmployee = null;
            $this->collInventoryReceivingVouchers = null;

            $this->collProducts = null;

            $this->collInventoryDeliveryVouchers = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Warehouse::setDeleted()
     * @see Warehouse::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(WarehouseTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildWarehouseQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(WarehouseTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(WarehouseTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(WarehouseTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(WarehouseTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                WarehouseTableMap::addInstanceToPool($this);
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

            if ($this->aEmployee !== null) {
                if ($this->aEmployee->isModified() || $this->aEmployee->isNew()) {
                    $affectedRows += $this->aEmployee->save($con);
                }
                $this->setEmployee($this->aEmployee);
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

            if ($this->inventoryReceivingVouchersScheduledForDeletion !== null) {
                if (!$this->inventoryReceivingVouchersScheduledForDeletion->isEmpty()) {
                    foreach ($this->inventoryReceivingVouchersScheduledForDeletion as $inventoryReceivingVoucher) {
                        // need to save related object because we set the relation to null
                        $inventoryReceivingVoucher->save($con);
                    }
                    $this->inventoryReceivingVouchersScheduledForDeletion = null;
                }
            }

            if ($this->collInventoryReceivingVouchers !== null) {
                foreach ($this->collInventoryReceivingVouchers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->productsScheduledForDeletion !== null) {
                if (!$this->productsScheduledForDeletion->isEmpty()) {
                    foreach ($this->productsScheduledForDeletion as $product) {
                        // need to save related object because we set the relation to null
                        $product->save($con);
                    }
                    $this->productsScheduledForDeletion = null;
                }
            }

            if ($this->collProducts !== null) {
                foreach ($this->collProducts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->inventoryDeliveryVouchersScheduledForDeletion !== null) {
                if (!$this->inventoryDeliveryVouchersScheduledForDeletion->isEmpty()) {
                    foreach ($this->inventoryDeliveryVouchersScheduledForDeletion as $inventoryDeliveryVoucher) {
                        // need to save related object because we set the relation to null
                        $inventoryDeliveryVoucher->save($con);
                    }
                    $this->inventoryDeliveryVouchersScheduledForDeletion = null;
                }
            }

            if ($this->collInventoryDeliveryVouchers !== null) {
                foreach ($this->collInventoryDeliveryVouchers as $referrerFK) {
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

        $this->modifiedColumns[WarehouseTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . WarehouseTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(WarehouseTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_EMPLOYEE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`employee_id`';
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = '`address`';
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`phone`';
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `warehouse` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`employee_id`':
                        $stmt->bindValue($identifier, $this->employee_id, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`address`':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case '`phone`':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case '`created_at`':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case '`updated_at`':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $pos = WarehouseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getEmployeeId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getAddress();
                break;
            case 4:
                return $this->getPhone();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
                return $this->getUpdatedAt();
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

        if (isset($alreadyDumpedObjects['Warehouse'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Warehouse'][$this->hashCode()] = true;
        $keys = WarehouseTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getEmployeeId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getAddress(),
            $keys[4] => $this->getPhone(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
        );
        if ($result[$keys[5]] instanceof \DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aEmployee) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'employee';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'employee';
                        break;
                    default:
                        $key = 'Employee';
                }

                $result[$key] = $this->aEmployee->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collInventoryReceivingVouchers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'inventoryReceivingVouchers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'inventory_receiving_vouchers';
                        break;
                    default:
                        $key = 'InventoryReceivingVouchers';
                }

                $result[$key] = $this->collInventoryReceivingVouchers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProducts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'products';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'products';
                        break;
                    default:
                        $key = 'Products';
                }

                $result[$key] = $this->collProducts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collInventoryDeliveryVouchers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'inventoryDeliveryVouchers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'inventory_delivery_vouchers';
                        break;
                    default:
                        $key = 'InventoryDeliveryVouchers';
                }

                $result[$key] = $this->collInventoryDeliveryVouchers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\AdvertiserBundle\Model\Warehouse
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = WarehouseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\AdvertiserBundle\Model\Warehouse
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setEmployeeId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setAddress($value);
                break;
            case 4:
                $this->setPhone($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
                $this->setUpdatedAt($value);
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
        $keys = WarehouseTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEmployeeId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setAddress($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPhone($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCreatedAt($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUpdatedAt($arr[$keys[6]]);
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
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object, for fluid interface
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
        $criteria = new Criteria(WarehouseTableMap::DATABASE_NAME);

        if ($this->isColumnModified(WarehouseTableMap::COL_ID)) {
            $criteria->add(WarehouseTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_EMPLOYEE_ID)) {
            $criteria->add(WarehouseTableMap::COL_EMPLOYEE_ID, $this->employee_id);
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_NAME)) {
            $criteria->add(WarehouseTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_ADDRESS)) {
            $criteria->add(WarehouseTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_PHONE)) {
            $criteria->add(WarehouseTableMap::COL_PHONE, $this->phone);
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_CREATED_AT)) {
            $criteria->add(WarehouseTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(WarehouseTableMap::COL_UPDATED_AT)) {
            $criteria->add(WarehouseTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildWarehouseQuery::create();
        $criteria->add(WarehouseTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \AdvertiserBundle\Model\Warehouse (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEmployeeId($this->getEmployeeId());
        $copyObj->setName($this->getName());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getInventoryReceivingVouchers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInventoryReceivingVoucher($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProduct($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getInventoryDeliveryVouchers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInventoryDeliveryVoucher($relObj->copy($deepCopy));
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
     * @return \AdvertiserBundle\Model\Warehouse Clone of current object.
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
     * Declares an association between this object and a ChildEmployee object.
     *
     * @param  ChildEmployee $v
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEmployee(ChildEmployee $v = null)
    {
        if ($v === null) {
            $this->setEmployeeId(NULL);
        } else {
            $this->setEmployeeId($v->getId());
        }

        $this->aEmployee = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildEmployee object, it will not be re-added.
        if ($v !== null) {
            $v->addWarehouse($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEmployee object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildEmployee The associated ChildEmployee object.
     * @throws PropelException
     */
    public function getEmployee(ConnectionInterface $con = null)
    {
        if ($this->aEmployee === null && ($this->employee_id !== null)) {
            $this->aEmployee = ChildEmployeeQuery::create()->findPk($this->employee_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEmployee->addWarehouses($this);
             */
        }

        return $this->aEmployee;
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
        if ('InventoryReceivingVoucher' == $relationName) {
            $this->initInventoryReceivingVouchers();
            return;
        }
        if ('Product' == $relationName) {
            $this->initProducts();
            return;
        }
        if ('InventoryDeliveryVoucher' == $relationName) {
            $this->initInventoryDeliveryVouchers();
            return;
        }
    }

    /**
     * Clears out the collInventoryReceivingVouchers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInventoryReceivingVouchers()
     */
    public function clearInventoryReceivingVouchers()
    {
        $this->collInventoryReceivingVouchers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collInventoryReceivingVouchers collection loaded partially.
     */
    public function resetPartialInventoryReceivingVouchers($v = true)
    {
        $this->collInventoryReceivingVouchersPartial = $v;
    }

    /**
     * Initializes the collInventoryReceivingVouchers collection.
     *
     * By default this just sets the collInventoryReceivingVouchers collection to an empty array (like clearcollInventoryReceivingVouchers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInventoryReceivingVouchers($overrideExisting = true)
    {
        if (null !== $this->collInventoryReceivingVouchers && !$overrideExisting) {
            return;
        }

        $collectionClassName = InventoryReceivingVoucherTableMap::getTableMap()->getCollectionClassName();

        $this->collInventoryReceivingVouchers = new $collectionClassName;
        $this->collInventoryReceivingVouchers->setModel('\AdvertiserBundle\Model\InventoryReceivingVoucher');
    }

    /**
     * Gets an array of ChildInventoryReceivingVoucher objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWarehouse is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildInventoryReceivingVoucher[] List of ChildInventoryReceivingVoucher objects
     * @throws PropelException
     */
    public function getInventoryReceivingVouchers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collInventoryReceivingVouchersPartial && !$this->isNew();
        if (null === $this->collInventoryReceivingVouchers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collInventoryReceivingVouchers) {
                // return empty collection
                $this->initInventoryReceivingVouchers();
            } else {
                $collInventoryReceivingVouchers = ChildInventoryReceivingVoucherQuery::create(null, $criteria)
                    ->filterByWarehouse($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collInventoryReceivingVouchersPartial && count($collInventoryReceivingVouchers)) {
                        $this->initInventoryReceivingVouchers(false);

                        foreach ($collInventoryReceivingVouchers as $obj) {
                            if (false == $this->collInventoryReceivingVouchers->contains($obj)) {
                                $this->collInventoryReceivingVouchers->append($obj);
                            }
                        }

                        $this->collInventoryReceivingVouchersPartial = true;
                    }

                    return $collInventoryReceivingVouchers;
                }

                if ($partial && $this->collInventoryReceivingVouchers) {
                    foreach ($this->collInventoryReceivingVouchers as $obj) {
                        if ($obj->isNew()) {
                            $collInventoryReceivingVouchers[] = $obj;
                        }
                    }
                }

                $this->collInventoryReceivingVouchers = $collInventoryReceivingVouchers;
                $this->collInventoryReceivingVouchersPartial = false;
            }
        }

        return $this->collInventoryReceivingVouchers;
    }

    /**
     * Sets a collection of ChildInventoryReceivingVoucher objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $inventoryReceivingVouchers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildWarehouse The current object (for fluent API support)
     */
    public function setInventoryReceivingVouchers(Collection $inventoryReceivingVouchers, ConnectionInterface $con = null)
    {
        /** @var ChildInventoryReceivingVoucher[] $inventoryReceivingVouchersToDelete */
        $inventoryReceivingVouchersToDelete = $this->getInventoryReceivingVouchers(new Criteria(), $con)->diff($inventoryReceivingVouchers);


        $this->inventoryReceivingVouchersScheduledForDeletion = $inventoryReceivingVouchersToDelete;

        foreach ($inventoryReceivingVouchersToDelete as $inventoryReceivingVoucherRemoved) {
            $inventoryReceivingVoucherRemoved->setWarehouse(null);
        }

        $this->collInventoryReceivingVouchers = null;
        foreach ($inventoryReceivingVouchers as $inventoryReceivingVoucher) {
            $this->addInventoryReceivingVoucher($inventoryReceivingVoucher);
        }

        $this->collInventoryReceivingVouchers = $inventoryReceivingVouchers;
        $this->collInventoryReceivingVouchersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related InventoryReceivingVoucher objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related InventoryReceivingVoucher objects.
     * @throws PropelException
     */
    public function countInventoryReceivingVouchers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collInventoryReceivingVouchersPartial && !$this->isNew();
        if (null === $this->collInventoryReceivingVouchers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInventoryReceivingVouchers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInventoryReceivingVouchers());
            }

            $query = ChildInventoryReceivingVoucherQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByWarehouse($this)
                ->count($con);
        }

        return count($this->collInventoryReceivingVouchers);
    }

    /**
     * Method called to associate a ChildInventoryReceivingVoucher object to this object
     * through the ChildInventoryReceivingVoucher foreign key attribute.
     *
     * @param  ChildInventoryReceivingVoucher $l ChildInventoryReceivingVoucher
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object (for fluent API support)
     */
    public function addInventoryReceivingVoucher(ChildInventoryReceivingVoucher $l)
    {
        if ($this->collInventoryReceivingVouchers === null) {
            $this->initInventoryReceivingVouchers();
            $this->collInventoryReceivingVouchersPartial = true;
        }

        if (!$this->collInventoryReceivingVouchers->contains($l)) {
            $this->doAddInventoryReceivingVoucher($l);

            if ($this->inventoryReceivingVouchersScheduledForDeletion and $this->inventoryReceivingVouchersScheduledForDeletion->contains($l)) {
                $this->inventoryReceivingVouchersScheduledForDeletion->remove($this->inventoryReceivingVouchersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildInventoryReceivingVoucher $inventoryReceivingVoucher The ChildInventoryReceivingVoucher object to add.
     */
    protected function doAddInventoryReceivingVoucher(ChildInventoryReceivingVoucher $inventoryReceivingVoucher)
    {
        $this->collInventoryReceivingVouchers[]= $inventoryReceivingVoucher;
        $inventoryReceivingVoucher->setWarehouse($this);
    }

    /**
     * @param  ChildInventoryReceivingVoucher $inventoryReceivingVoucher The ChildInventoryReceivingVoucher object to remove.
     * @return $this|ChildWarehouse The current object (for fluent API support)
     */
    public function removeInventoryReceivingVoucher(ChildInventoryReceivingVoucher $inventoryReceivingVoucher)
    {
        if ($this->getInventoryReceivingVouchers()->contains($inventoryReceivingVoucher)) {
            $pos = $this->collInventoryReceivingVouchers->search($inventoryReceivingVoucher);
            $this->collInventoryReceivingVouchers->remove($pos);
            if (null === $this->inventoryReceivingVouchersScheduledForDeletion) {
                $this->inventoryReceivingVouchersScheduledForDeletion = clone $this->collInventoryReceivingVouchers;
                $this->inventoryReceivingVouchersScheduledForDeletion->clear();
            }
            $this->inventoryReceivingVouchersScheduledForDeletion[]= $inventoryReceivingVoucher;
            $inventoryReceivingVoucher->setWarehouse(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related InventoryReceivingVouchers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInventoryReceivingVoucher[] List of ChildInventoryReceivingVoucher objects
     */
    public function getInventoryReceivingVouchersJoinProvider(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInventoryReceivingVoucherQuery::create(null, $criteria);
        $query->joinWith('Provider', $joinBehavior);

        return $this->getInventoryReceivingVouchers($query, $con);
    }

    /**
     * Clears out the collProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addProducts()
     */
    public function clearProducts()
    {
        $this->collProducts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collProducts collection loaded partially.
     */
    public function resetPartialProducts($v = true)
    {
        $this->collProductsPartial = $v;
    }

    /**
     * Initializes the collProducts collection.
     *
     * By default this just sets the collProducts collection to an empty array (like clearcollProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProducts($overrideExisting = true)
    {
        if (null !== $this->collProducts && !$overrideExisting) {
            return;
        }

        $collectionClassName = ProductTableMap::getTableMap()->getCollectionClassName();

        $this->collProducts = new $collectionClassName;
        $this->collProducts->setModel('\AdvertiserBundle\Model\Product');
    }

    /**
     * Gets an array of ChildProduct objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWarehouse is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildProduct[] List of ChildProduct objects
     * @throws PropelException
     */
    public function getProducts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collProductsPartial && !$this->isNew();
        if (null === $this->collProducts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProducts) {
                // return empty collection
                $this->initProducts();
            } else {
                $collProducts = ChildProductQuery::create(null, $criteria)
                    ->filterByWarehouse($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collProductsPartial && count($collProducts)) {
                        $this->initProducts(false);

                        foreach ($collProducts as $obj) {
                            if (false == $this->collProducts->contains($obj)) {
                                $this->collProducts->append($obj);
                            }
                        }

                        $this->collProductsPartial = true;
                    }

                    return $collProducts;
                }

                if ($partial && $this->collProducts) {
                    foreach ($this->collProducts as $obj) {
                        if ($obj->isNew()) {
                            $collProducts[] = $obj;
                        }
                    }
                }

                $this->collProducts = $collProducts;
                $this->collProductsPartial = false;
            }
        }

        return $this->collProducts;
    }

    /**
     * Sets a collection of ChildProduct objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $products A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildWarehouse The current object (for fluent API support)
     */
    public function setProducts(Collection $products, ConnectionInterface $con = null)
    {
        /** @var ChildProduct[] $productsToDelete */
        $productsToDelete = $this->getProducts(new Criteria(), $con)->diff($products);


        $this->productsScheduledForDeletion = $productsToDelete;

        foreach ($productsToDelete as $productRemoved) {
            $productRemoved->setWarehouse(null);
        }

        $this->collProducts = null;
        foreach ($products as $product) {
            $this->addProduct($product);
        }

        $this->collProducts = $products;
        $this->collProductsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Product objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Product objects.
     * @throws PropelException
     */
    public function countProducts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collProductsPartial && !$this->isNew();
        if (null === $this->collProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProducts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProducts());
            }

            $query = ChildProductQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByWarehouse($this)
                ->count($con);
        }

        return count($this->collProducts);
    }

    /**
     * Method called to associate a ChildProduct object to this object
     * through the ChildProduct foreign key attribute.
     *
     * @param  ChildProduct $l ChildProduct
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object (for fluent API support)
     */
    public function addProduct(ChildProduct $l)
    {
        if ($this->collProducts === null) {
            $this->initProducts();
            $this->collProductsPartial = true;
        }

        if (!$this->collProducts->contains($l)) {
            $this->doAddProduct($l);

            if ($this->productsScheduledForDeletion and $this->productsScheduledForDeletion->contains($l)) {
                $this->productsScheduledForDeletion->remove($this->productsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildProduct $product The ChildProduct object to add.
     */
    protected function doAddProduct(ChildProduct $product)
    {
        $this->collProducts[]= $product;
        $product->setWarehouse($this);
    }

    /**
     * @param  ChildProduct $product The ChildProduct object to remove.
     * @return $this|ChildWarehouse The current object (for fluent API support)
     */
    public function removeProduct(ChildProduct $product)
    {
        if ($this->getProducts()->contains($product)) {
            $pos = $this->collProducts->search($product);
            $this->collProducts->remove($pos);
            if (null === $this->productsScheduledForDeletion) {
                $this->productsScheduledForDeletion = clone $this->collProducts;
                $this->productsScheduledForDeletion->clear();
            }
            $this->productsScheduledForDeletion[]= $product;
            $product->setWarehouse(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related Products from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildProduct[] List of ChildProduct objects
     */
    public function getProductsJoinCategoryProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildProductQuery::create(null, $criteria);
        $query->joinWith('CategoryProduct', $joinBehavior);

        return $this->getProducts($query, $con);
    }

    /**
     * Clears out the collInventoryDeliveryVouchers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInventoryDeliveryVouchers()
     */
    public function clearInventoryDeliveryVouchers()
    {
        $this->collInventoryDeliveryVouchers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collInventoryDeliveryVouchers collection loaded partially.
     */
    public function resetPartialInventoryDeliveryVouchers($v = true)
    {
        $this->collInventoryDeliveryVouchersPartial = $v;
    }

    /**
     * Initializes the collInventoryDeliveryVouchers collection.
     *
     * By default this just sets the collInventoryDeliveryVouchers collection to an empty array (like clearcollInventoryDeliveryVouchers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInventoryDeliveryVouchers($overrideExisting = true)
    {
        if (null !== $this->collInventoryDeliveryVouchers && !$overrideExisting) {
            return;
        }

        $collectionClassName = InventoryDeliveryVoucherTableMap::getTableMap()->getCollectionClassName();

        $this->collInventoryDeliveryVouchers = new $collectionClassName;
        $this->collInventoryDeliveryVouchers->setModel('\AdvertiserBundle\Model\InventoryDeliveryVoucher');
    }

    /**
     * Gets an array of ChildInventoryDeliveryVoucher objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWarehouse is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildInventoryDeliveryVoucher[] List of ChildInventoryDeliveryVoucher objects
     * @throws PropelException
     */
    public function getInventoryDeliveryVouchers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collInventoryDeliveryVouchersPartial && !$this->isNew();
        if (null === $this->collInventoryDeliveryVouchers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collInventoryDeliveryVouchers) {
                // return empty collection
                $this->initInventoryDeliveryVouchers();
            } else {
                $collInventoryDeliveryVouchers = ChildInventoryDeliveryVoucherQuery::create(null, $criteria)
                    ->filterByWarehouse($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collInventoryDeliveryVouchersPartial && count($collInventoryDeliveryVouchers)) {
                        $this->initInventoryDeliveryVouchers(false);

                        foreach ($collInventoryDeliveryVouchers as $obj) {
                            if (false == $this->collInventoryDeliveryVouchers->contains($obj)) {
                                $this->collInventoryDeliveryVouchers->append($obj);
                            }
                        }

                        $this->collInventoryDeliveryVouchersPartial = true;
                    }

                    return $collInventoryDeliveryVouchers;
                }

                if ($partial && $this->collInventoryDeliveryVouchers) {
                    foreach ($this->collInventoryDeliveryVouchers as $obj) {
                        if ($obj->isNew()) {
                            $collInventoryDeliveryVouchers[] = $obj;
                        }
                    }
                }

                $this->collInventoryDeliveryVouchers = $collInventoryDeliveryVouchers;
                $this->collInventoryDeliveryVouchersPartial = false;
            }
        }

        return $this->collInventoryDeliveryVouchers;
    }

    /**
     * Sets a collection of ChildInventoryDeliveryVoucher objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $inventoryDeliveryVouchers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildWarehouse The current object (for fluent API support)
     */
    public function setInventoryDeliveryVouchers(Collection $inventoryDeliveryVouchers, ConnectionInterface $con = null)
    {
        /** @var ChildInventoryDeliveryVoucher[] $inventoryDeliveryVouchersToDelete */
        $inventoryDeliveryVouchersToDelete = $this->getInventoryDeliveryVouchers(new Criteria(), $con)->diff($inventoryDeliveryVouchers);


        $this->inventoryDeliveryVouchersScheduledForDeletion = $inventoryDeliveryVouchersToDelete;

        foreach ($inventoryDeliveryVouchersToDelete as $inventoryDeliveryVoucherRemoved) {
            $inventoryDeliveryVoucherRemoved->setWarehouse(null);
        }

        $this->collInventoryDeliveryVouchers = null;
        foreach ($inventoryDeliveryVouchers as $inventoryDeliveryVoucher) {
            $this->addInventoryDeliveryVoucher($inventoryDeliveryVoucher);
        }

        $this->collInventoryDeliveryVouchers = $inventoryDeliveryVouchers;
        $this->collInventoryDeliveryVouchersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related InventoryDeliveryVoucher objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related InventoryDeliveryVoucher objects.
     * @throws PropelException
     */
    public function countInventoryDeliveryVouchers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collInventoryDeliveryVouchersPartial && !$this->isNew();
        if (null === $this->collInventoryDeliveryVouchers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInventoryDeliveryVouchers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInventoryDeliveryVouchers());
            }

            $query = ChildInventoryDeliveryVoucherQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByWarehouse($this)
                ->count($con);
        }

        return count($this->collInventoryDeliveryVouchers);
    }

    /**
     * Method called to associate a ChildInventoryDeliveryVoucher object to this object
     * through the ChildInventoryDeliveryVoucher foreign key attribute.
     *
     * @param  ChildInventoryDeliveryVoucher $l ChildInventoryDeliveryVoucher
     * @return $this|\AdvertiserBundle\Model\Warehouse The current object (for fluent API support)
     */
    public function addInventoryDeliveryVoucher(ChildInventoryDeliveryVoucher $l)
    {
        if ($this->collInventoryDeliveryVouchers === null) {
            $this->initInventoryDeliveryVouchers();
            $this->collInventoryDeliveryVouchersPartial = true;
        }

        if (!$this->collInventoryDeliveryVouchers->contains($l)) {
            $this->doAddInventoryDeliveryVoucher($l);

            if ($this->inventoryDeliveryVouchersScheduledForDeletion and $this->inventoryDeliveryVouchersScheduledForDeletion->contains($l)) {
                $this->inventoryDeliveryVouchersScheduledForDeletion->remove($this->inventoryDeliveryVouchersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildInventoryDeliveryVoucher $inventoryDeliveryVoucher The ChildInventoryDeliveryVoucher object to add.
     */
    protected function doAddInventoryDeliveryVoucher(ChildInventoryDeliveryVoucher $inventoryDeliveryVoucher)
    {
        $this->collInventoryDeliveryVouchers[]= $inventoryDeliveryVoucher;
        $inventoryDeliveryVoucher->setWarehouse($this);
    }

    /**
     * @param  ChildInventoryDeliveryVoucher $inventoryDeliveryVoucher The ChildInventoryDeliveryVoucher object to remove.
     * @return $this|ChildWarehouse The current object (for fluent API support)
     */
    public function removeInventoryDeliveryVoucher(ChildInventoryDeliveryVoucher $inventoryDeliveryVoucher)
    {
        if ($this->getInventoryDeliveryVouchers()->contains($inventoryDeliveryVoucher)) {
            $pos = $this->collInventoryDeliveryVouchers->search($inventoryDeliveryVoucher);
            $this->collInventoryDeliveryVouchers->remove($pos);
            if (null === $this->inventoryDeliveryVouchersScheduledForDeletion) {
                $this->inventoryDeliveryVouchersScheduledForDeletion = clone $this->collInventoryDeliveryVouchers;
                $this->inventoryDeliveryVouchersScheduledForDeletion->clear();
            }
            $this->inventoryDeliveryVouchersScheduledForDeletion[]= $inventoryDeliveryVoucher;
            $inventoryDeliveryVoucher->setWarehouse(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related InventoryDeliveryVouchers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInventoryDeliveryVoucher[] List of ChildInventoryDeliveryVoucher objects
     */
    public function getInventoryDeliveryVouchersJoinEmployee(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInventoryDeliveryVoucherQuery::create(null, $criteria);
        $query->joinWith('Employee', $joinBehavior);

        return $this->getInventoryDeliveryVouchers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Warehouse is new, it will return
     * an empty collection; or if this Warehouse has previously
     * been saved, it will retrieve related InventoryDeliveryVouchers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Warehouse.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInventoryDeliveryVoucher[] List of ChildInventoryDeliveryVoucher objects
     */
    public function getInventoryDeliveryVouchersJoinCustomers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInventoryDeliveryVoucherQuery::create(null, $criteria);
        $query->joinWith('Customers', $joinBehavior);

        return $this->getInventoryDeliveryVouchers($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aEmployee) {
            $this->aEmployee->removeWarehouse($this);
        }
        $this->id = null;
        $this->employee_id = null;
        $this->name = null;
        $this->address = null;
        $this->phone = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collInventoryReceivingVouchers) {
                foreach ($this->collInventoryReceivingVouchers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProducts) {
                foreach ($this->collProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collInventoryDeliveryVouchers) {
                foreach ($this->collInventoryDeliveryVouchers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collInventoryReceivingVouchers = null;
        $this->collProducts = null;
        $this->collInventoryDeliveryVouchers = null;
        $this->aEmployee = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(WarehouseTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildWarehouse The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[WarehouseTableMap::COL_UPDATED_AT] = true;

        return $this;
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