<?php

namespace AdvertiserBundle\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use AdvertiserBundle\Model\InventoryReceivingVoucher as ChildInventoryReceivingVoucher;
use AdvertiserBundle\Model\InventoryReceivingVoucherDetail as ChildInventoryReceivingVoucherDetail;
use AdvertiserBundle\Model\InventoryReceivingVoucherDetailQuery as ChildInventoryReceivingVoucherDetailQuery;
use AdvertiserBundle\Model\InventoryReceivingVoucherQuery as ChildInventoryReceivingVoucherQuery;
use AdvertiserBundle\Model\Provider as ChildProvider;
use AdvertiserBundle\Model\ProviderQuery as ChildProviderQuery;
use AdvertiserBundle\Model\Warehouse as ChildWarehouse;
use AdvertiserBundle\Model\WarehouseQuery as ChildWarehouseQuery;
use AdvertiserBundle\Model\Map\InventoryReceivingVoucherDetailTableMap;
use AdvertiserBundle\Model\Map\InventoryReceivingVoucherTableMap;
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
 * Base class that represents a row from the 'inventory_receiving_voucher' table.
 *
 *
 *
 * @package    propel.generator.src.AdvertiserBundle.Model.Base
 */
abstract class InventoryReceivingVoucher implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\AdvertiserBundle\\Model\\Map\\InventoryReceivingVoucherTableMap';


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
     * The value for the provider_id field.
     *
     * @var        int
     */
    protected $provider_id;

    /**
     * The value for the warehouse_id field.
     *
     * @var        int
     */
    protected $warehouse_id;

    /**
     * The value for the created_at field.
     *
     * @var        DateTime
     */
    protected $created_at;

    /**
     * @var        ChildProvider
     */
    protected $aProvider;

    /**
     * @var        ChildWarehouse
     */
    protected $aWarehouse;

    /**
     * @var        ObjectCollection|ChildInventoryReceivingVoucherDetail[] Collection to store aggregation of ChildInventoryReceivingVoucherDetail objects.
     */
    protected $collInventoryReceivingVoucherDetails;
    protected $collInventoryReceivingVoucherDetailsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInventoryReceivingVoucherDetail[]
     */
    protected $inventoryReceivingVoucherDetailsScheduledForDeletion = null;

    /**
     * Initializes internal state of AdvertiserBundle\Model\Base\InventoryReceivingVoucher object.
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
     * Compares this with another <code>InventoryReceivingVoucher</code> instance.  If
     * <code>obj</code> is an instance of <code>InventoryReceivingVoucher</code>, delegates to
     * <code>equals(InventoryReceivingVoucher)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|InventoryReceivingVoucher The current object, for fluid interface
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
     * Get the [provider_id] column value.
     *
     * @return int
     */
    public function getProviderId()
    {
        return $this->provider_id;
    }

    /**
     * Get the [warehouse_id] column value.
     *
     * @return int
     */
    public function getWarehouseId()
    {
        return $this->warehouse_id;
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\AdvertiserBundle\Model\InventoryReceivingVoucher The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[InventoryReceivingVoucherTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [provider_id] column.
     *
     * @param int $v new value
     * @return $this|\AdvertiserBundle\Model\InventoryReceivingVoucher The current object (for fluent API support)
     */
    public function setProviderId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->provider_id !== $v) {
            $this->provider_id = $v;
            $this->modifiedColumns[InventoryReceivingVoucherTableMap::COL_PROVIDER_ID] = true;
        }

        if ($this->aProvider !== null && $this->aProvider->getId() !== $v) {
            $this->aProvider = null;
        }

        return $this;
    } // setProviderId()

    /**
     * Set the value of [warehouse_id] column.
     *
     * @param int $v new value
     * @return $this|\AdvertiserBundle\Model\InventoryReceivingVoucher The current object (for fluent API support)
     */
    public function setWarehouseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->warehouse_id !== $v) {
            $this->warehouse_id = $v;
            $this->modifiedColumns[InventoryReceivingVoucherTableMap::COL_WAREHOUSE_ID] = true;
        }

        if ($this->aWarehouse !== null && $this->aWarehouse->getId() !== $v) {
            $this->aWarehouse = null;
        }

        return $this;
    } // setWarehouseId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\AdvertiserBundle\Model\InventoryReceivingVoucher The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[InventoryReceivingVoucherTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : InventoryReceivingVoucherTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : InventoryReceivingVoucherTableMap::translateFieldName('ProviderId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->provider_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : InventoryReceivingVoucherTableMap::translateFieldName('WarehouseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->warehouse_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : InventoryReceivingVoucherTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = InventoryReceivingVoucherTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\AdvertiserBundle\\Model\\InventoryReceivingVoucher'), 0, $e);
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
        if ($this->aProvider !== null && $this->provider_id !== $this->aProvider->getId()) {
            $this->aProvider = null;
        }
        if ($this->aWarehouse !== null && $this->warehouse_id !== $this->aWarehouse->getId()) {
            $this->aWarehouse = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(InventoryReceivingVoucherTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildInventoryReceivingVoucherQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProvider = null;
            $this->aWarehouse = null;
            $this->collInventoryReceivingVoucherDetails = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see InventoryReceivingVoucher::setDeleted()
     * @see InventoryReceivingVoucher::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(InventoryReceivingVoucherTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildInventoryReceivingVoucherQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(InventoryReceivingVoucherTableMap::DATABASE_NAME);
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
                InventoryReceivingVoucherTableMap::addInstanceToPool($this);
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

            if ($this->aProvider !== null) {
                if ($this->aProvider->isModified() || $this->aProvider->isNew()) {
                    $affectedRows += $this->aProvider->save($con);
                }
                $this->setProvider($this->aProvider);
            }

            if ($this->aWarehouse !== null) {
                if ($this->aWarehouse->isModified() || $this->aWarehouse->isNew()) {
                    $affectedRows += $this->aWarehouse->save($con);
                }
                $this->setWarehouse($this->aWarehouse);
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

            if ($this->inventoryReceivingVoucherDetailsScheduledForDeletion !== null) {
                if (!$this->inventoryReceivingVoucherDetailsScheduledForDeletion->isEmpty()) {
                    foreach ($this->inventoryReceivingVoucherDetailsScheduledForDeletion as $inventoryReceivingVoucherDetail) {
                        // need to save related object because we set the relation to null
                        $inventoryReceivingVoucherDetail->save($con);
                    }
                    $this->inventoryReceivingVoucherDetailsScheduledForDeletion = null;
                }
            }

            if ($this->collInventoryReceivingVoucherDetails !== null) {
                foreach ($this->collInventoryReceivingVoucherDetails as $referrerFK) {
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

        $this->modifiedColumns[InventoryReceivingVoucherTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . InventoryReceivingVoucherTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(InventoryReceivingVoucherTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(InventoryReceivingVoucherTableMap::COL_PROVIDER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`provider_id`';
        }
        if ($this->isColumnModified(InventoryReceivingVoucherTableMap::COL_WAREHOUSE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`warehouse_id`';
        }
        if ($this->isColumnModified(InventoryReceivingVoucherTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }

        $sql = sprintf(
            'INSERT INTO `inventory_receiving_voucher` (%s) VALUES (%s)',
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
                    case '`provider_id`':
                        $stmt->bindValue($identifier, $this->provider_id, PDO::PARAM_INT);
                        break;
                    case '`warehouse_id`':
                        $stmt->bindValue($identifier, $this->warehouse_id, PDO::PARAM_INT);
                        break;
                    case '`created_at`':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $pos = InventoryReceivingVoucherTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getProviderId();
                break;
            case 2:
                return $this->getWarehouseId();
                break;
            case 3:
                return $this->getCreatedAt();
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

        if (isset($alreadyDumpedObjects['InventoryReceivingVoucher'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['InventoryReceivingVoucher'][$this->hashCode()] = true;
        $keys = InventoryReceivingVoucherTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getProviderId(),
            $keys[2] => $this->getWarehouseId(),
            $keys[3] => $this->getCreatedAt(),
        );
        if ($result[$keys[3]] instanceof \DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aProvider) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'provider';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'provider';
                        break;
                    default:
                        $key = 'Provider';
                }

                $result[$key] = $this->aProvider->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aWarehouse) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'warehouse';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'warehouse';
                        break;
                    default:
                        $key = 'Warehouse';
                }

                $result[$key] = $this->aWarehouse->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collInventoryReceivingVoucherDetails) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'inventoryReceivingVoucherDetails';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'inventory_receiving_voucher_details';
                        break;
                    default:
                        $key = 'InventoryReceivingVoucherDetails';
                }

                $result[$key] = $this->collInventoryReceivingVoucherDetails->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\AdvertiserBundle\Model\InventoryReceivingVoucher
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = InventoryReceivingVoucherTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\AdvertiserBundle\Model\InventoryReceivingVoucher
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setProviderId($value);
                break;
            case 2:
                $this->setWarehouseId($value);
                break;
            case 3:
                $this->setCreatedAt($value);
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
        $keys = InventoryReceivingVoucherTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setProviderId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setWarehouseId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCreatedAt($arr[$keys[3]]);
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
     * @return $this|\AdvertiserBundle\Model\InventoryReceivingVoucher The current object, for fluid interface
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
        $criteria = new Criteria(InventoryReceivingVoucherTableMap::DATABASE_NAME);

        if ($this->isColumnModified(InventoryReceivingVoucherTableMap::COL_ID)) {
            $criteria->add(InventoryReceivingVoucherTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(InventoryReceivingVoucherTableMap::COL_PROVIDER_ID)) {
            $criteria->add(InventoryReceivingVoucherTableMap::COL_PROVIDER_ID, $this->provider_id);
        }
        if ($this->isColumnModified(InventoryReceivingVoucherTableMap::COL_WAREHOUSE_ID)) {
            $criteria->add(InventoryReceivingVoucherTableMap::COL_WAREHOUSE_ID, $this->warehouse_id);
        }
        if ($this->isColumnModified(InventoryReceivingVoucherTableMap::COL_CREATED_AT)) {
            $criteria->add(InventoryReceivingVoucherTableMap::COL_CREATED_AT, $this->created_at);
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
        $criteria = ChildInventoryReceivingVoucherQuery::create();
        $criteria->add(InventoryReceivingVoucherTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \AdvertiserBundle\Model\InventoryReceivingVoucher (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProviderId($this->getProviderId());
        $copyObj->setWarehouseId($this->getWarehouseId());
        $copyObj->setCreatedAt($this->getCreatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getInventoryReceivingVoucherDetails() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInventoryReceivingVoucherDetail($relObj->copy($deepCopy));
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
     * @return \AdvertiserBundle\Model\InventoryReceivingVoucher Clone of current object.
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
     * Declares an association between this object and a ChildProvider object.
     *
     * @param  ChildProvider $v
     * @return $this|\AdvertiserBundle\Model\InventoryReceivingVoucher The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProvider(ChildProvider $v = null)
    {
        if ($v === null) {
            $this->setProviderId(NULL);
        } else {
            $this->setProviderId($v->getId());
        }

        $this->aProvider = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildProvider object, it will not be re-added.
        if ($v !== null) {
            $v->addInventoryReceivingVoucher($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildProvider object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildProvider The associated ChildProvider object.
     * @throws PropelException
     */
    public function getProvider(ConnectionInterface $con = null)
    {
        if ($this->aProvider === null && ($this->provider_id !== null)) {
            $this->aProvider = ChildProviderQuery::create()->findPk($this->provider_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProvider->addInventoryReceivingVouchers($this);
             */
        }

        return $this->aProvider;
    }

    /**
     * Declares an association between this object and a ChildWarehouse object.
     *
     * @param  ChildWarehouse $v
     * @return $this|\AdvertiserBundle\Model\InventoryReceivingVoucher The current object (for fluent API support)
     * @throws PropelException
     */
    public function setWarehouse(ChildWarehouse $v = null)
    {
        if ($v === null) {
            $this->setWarehouseId(NULL);
        } else {
            $this->setWarehouseId($v->getId());
        }

        $this->aWarehouse = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildWarehouse object, it will not be re-added.
        if ($v !== null) {
            $v->addInventoryReceivingVoucher($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildWarehouse object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildWarehouse The associated ChildWarehouse object.
     * @throws PropelException
     */
    public function getWarehouse(ConnectionInterface $con = null)
    {
        if ($this->aWarehouse === null && ($this->warehouse_id !== null)) {
            $this->aWarehouse = ChildWarehouseQuery::create()->findPk($this->warehouse_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aWarehouse->addInventoryReceivingVouchers($this);
             */
        }

        return $this->aWarehouse;
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
        if ('InventoryReceivingVoucherDetail' == $relationName) {
            $this->initInventoryReceivingVoucherDetails();
            return;
        }
    }

    /**
     * Clears out the collInventoryReceivingVoucherDetails collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInventoryReceivingVoucherDetails()
     */
    public function clearInventoryReceivingVoucherDetails()
    {
        $this->collInventoryReceivingVoucherDetails = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collInventoryReceivingVoucherDetails collection loaded partially.
     */
    public function resetPartialInventoryReceivingVoucherDetails($v = true)
    {
        $this->collInventoryReceivingVoucherDetailsPartial = $v;
    }

    /**
     * Initializes the collInventoryReceivingVoucherDetails collection.
     *
     * By default this just sets the collInventoryReceivingVoucherDetails collection to an empty array (like clearcollInventoryReceivingVoucherDetails());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInventoryReceivingVoucherDetails($overrideExisting = true)
    {
        if (null !== $this->collInventoryReceivingVoucherDetails && !$overrideExisting) {
            return;
        }

        $collectionClassName = InventoryReceivingVoucherDetailTableMap::getTableMap()->getCollectionClassName();

        $this->collInventoryReceivingVoucherDetails = new $collectionClassName;
        $this->collInventoryReceivingVoucherDetails->setModel('\AdvertiserBundle\Model\InventoryReceivingVoucherDetail');
    }

    /**
     * Gets an array of ChildInventoryReceivingVoucherDetail objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildInventoryReceivingVoucher is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildInventoryReceivingVoucherDetail[] List of ChildInventoryReceivingVoucherDetail objects
     * @throws PropelException
     */
    public function getInventoryReceivingVoucherDetails(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collInventoryReceivingVoucherDetailsPartial && !$this->isNew();
        if (null === $this->collInventoryReceivingVoucherDetails || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collInventoryReceivingVoucherDetails) {
                // return empty collection
                $this->initInventoryReceivingVoucherDetails();
            } else {
                $collInventoryReceivingVoucherDetails = ChildInventoryReceivingVoucherDetailQuery::create(null, $criteria)
                    ->filterByInventoryReceivingVoucher($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collInventoryReceivingVoucherDetailsPartial && count($collInventoryReceivingVoucherDetails)) {
                        $this->initInventoryReceivingVoucherDetails(false);

                        foreach ($collInventoryReceivingVoucherDetails as $obj) {
                            if (false == $this->collInventoryReceivingVoucherDetails->contains($obj)) {
                                $this->collInventoryReceivingVoucherDetails->append($obj);
                            }
                        }

                        $this->collInventoryReceivingVoucherDetailsPartial = true;
                    }

                    return $collInventoryReceivingVoucherDetails;
                }

                if ($partial && $this->collInventoryReceivingVoucherDetails) {
                    foreach ($this->collInventoryReceivingVoucherDetails as $obj) {
                        if ($obj->isNew()) {
                            $collInventoryReceivingVoucherDetails[] = $obj;
                        }
                    }
                }

                $this->collInventoryReceivingVoucherDetails = $collInventoryReceivingVoucherDetails;
                $this->collInventoryReceivingVoucherDetailsPartial = false;
            }
        }

        return $this->collInventoryReceivingVoucherDetails;
    }

    /**
     * Sets a collection of ChildInventoryReceivingVoucherDetail objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $inventoryReceivingVoucherDetails A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildInventoryReceivingVoucher The current object (for fluent API support)
     */
    public function setInventoryReceivingVoucherDetails(Collection $inventoryReceivingVoucherDetails, ConnectionInterface $con = null)
    {
        /** @var ChildInventoryReceivingVoucherDetail[] $inventoryReceivingVoucherDetailsToDelete */
        $inventoryReceivingVoucherDetailsToDelete = $this->getInventoryReceivingVoucherDetails(new Criteria(), $con)->diff($inventoryReceivingVoucherDetails);


        $this->inventoryReceivingVoucherDetailsScheduledForDeletion = $inventoryReceivingVoucherDetailsToDelete;

        foreach ($inventoryReceivingVoucherDetailsToDelete as $inventoryReceivingVoucherDetailRemoved) {
            $inventoryReceivingVoucherDetailRemoved->setInventoryReceivingVoucher(null);
        }

        $this->collInventoryReceivingVoucherDetails = null;
        foreach ($inventoryReceivingVoucherDetails as $inventoryReceivingVoucherDetail) {
            $this->addInventoryReceivingVoucherDetail($inventoryReceivingVoucherDetail);
        }

        $this->collInventoryReceivingVoucherDetails = $inventoryReceivingVoucherDetails;
        $this->collInventoryReceivingVoucherDetailsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related InventoryReceivingVoucherDetail objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related InventoryReceivingVoucherDetail objects.
     * @throws PropelException
     */
    public function countInventoryReceivingVoucherDetails(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collInventoryReceivingVoucherDetailsPartial && !$this->isNew();
        if (null === $this->collInventoryReceivingVoucherDetails || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInventoryReceivingVoucherDetails) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInventoryReceivingVoucherDetails());
            }

            $query = ChildInventoryReceivingVoucherDetailQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByInventoryReceivingVoucher($this)
                ->count($con);
        }

        return count($this->collInventoryReceivingVoucherDetails);
    }

    /**
     * Method called to associate a ChildInventoryReceivingVoucherDetail object to this object
     * through the ChildInventoryReceivingVoucherDetail foreign key attribute.
     *
     * @param  ChildInventoryReceivingVoucherDetail $l ChildInventoryReceivingVoucherDetail
     * @return $this|\AdvertiserBundle\Model\InventoryReceivingVoucher The current object (for fluent API support)
     */
    public function addInventoryReceivingVoucherDetail(ChildInventoryReceivingVoucherDetail $l)
    {
        if ($this->collInventoryReceivingVoucherDetails === null) {
            $this->initInventoryReceivingVoucherDetails();
            $this->collInventoryReceivingVoucherDetailsPartial = true;
        }

        if (!$this->collInventoryReceivingVoucherDetails->contains($l)) {
            $this->doAddInventoryReceivingVoucherDetail($l);

            if ($this->inventoryReceivingVoucherDetailsScheduledForDeletion and $this->inventoryReceivingVoucherDetailsScheduledForDeletion->contains($l)) {
                $this->inventoryReceivingVoucherDetailsScheduledForDeletion->remove($this->inventoryReceivingVoucherDetailsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildInventoryReceivingVoucherDetail $inventoryReceivingVoucherDetail The ChildInventoryReceivingVoucherDetail object to add.
     */
    protected function doAddInventoryReceivingVoucherDetail(ChildInventoryReceivingVoucherDetail $inventoryReceivingVoucherDetail)
    {
        $this->collInventoryReceivingVoucherDetails[]= $inventoryReceivingVoucherDetail;
        $inventoryReceivingVoucherDetail->setInventoryReceivingVoucher($this);
    }

    /**
     * @param  ChildInventoryReceivingVoucherDetail $inventoryReceivingVoucherDetail The ChildInventoryReceivingVoucherDetail object to remove.
     * @return $this|ChildInventoryReceivingVoucher The current object (for fluent API support)
     */
    public function removeInventoryReceivingVoucherDetail(ChildInventoryReceivingVoucherDetail $inventoryReceivingVoucherDetail)
    {
        if ($this->getInventoryReceivingVoucherDetails()->contains($inventoryReceivingVoucherDetail)) {
            $pos = $this->collInventoryReceivingVoucherDetails->search($inventoryReceivingVoucherDetail);
            $this->collInventoryReceivingVoucherDetails->remove($pos);
            if (null === $this->inventoryReceivingVoucherDetailsScheduledForDeletion) {
                $this->inventoryReceivingVoucherDetailsScheduledForDeletion = clone $this->collInventoryReceivingVoucherDetails;
                $this->inventoryReceivingVoucherDetailsScheduledForDeletion->clear();
            }
            $this->inventoryReceivingVoucherDetailsScheduledForDeletion[]= $inventoryReceivingVoucherDetail;
            $inventoryReceivingVoucherDetail->setInventoryReceivingVoucher(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this InventoryReceivingVoucher is new, it will return
     * an empty collection; or if this InventoryReceivingVoucher has previously
     * been saved, it will retrieve related InventoryReceivingVoucherDetails from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in InventoryReceivingVoucher.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildInventoryReceivingVoucherDetail[] List of ChildInventoryReceivingVoucherDetail objects
     */
    public function getInventoryReceivingVoucherDetailsJoinProduct(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildInventoryReceivingVoucherDetailQuery::create(null, $criteria);
        $query->joinWith('Product', $joinBehavior);

        return $this->getInventoryReceivingVoucherDetails($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aProvider) {
            $this->aProvider->removeInventoryReceivingVoucher($this);
        }
        if (null !== $this->aWarehouse) {
            $this->aWarehouse->removeInventoryReceivingVoucher($this);
        }
        $this->id = null;
        $this->provider_id = null;
        $this->warehouse_id = null;
        $this->created_at = null;
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
            if ($this->collInventoryReceivingVoucherDetails) {
                foreach ($this->collInventoryReceivingVoucherDetails as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collInventoryReceivingVoucherDetails = null;
        $this->aProvider = null;
        $this->aWarehouse = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(InventoryReceivingVoucherTableMap::DEFAULT_STRING_FORMAT);
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