<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\Advert as ChildAdvert;
use Common\DbBundle\Model\AdvertQuery as ChildAdvertQuery;
use Common\DbBundle\Model\Customer as ChildCustomer;
use Common\DbBundle\Model\CustomerQuery as ChildCustomerQuery;
use Common\DbBundle\Model\Giftcode as ChildGiftcode;
use Common\DbBundle\Model\GiftcodeQuery as ChildGiftcodeQuery;
use Common\DbBundle\Model\Map\AdvertTableMap;
use Common\DbBundle\Model\Map\CustomerTableMap;
use Common\DbBundle\Model\Map\GiftcodeTableMap;
use Hotspot\AccessPointBundle\Model\Accesspoint;
use Hotspot\AccessPointBundle\Model\AccesspointQuery;
use Hotspot\AccessPointBundle\Model\Base\Accesspoint as BaseAccesspoint;
use Hotspot\AccessPointBundle\Model\Map\AccesspointTableMap;
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
 * Base class that represents a row from the 'customer' table.
 *
 *
 *
 * @package    propel.generator.src.Common.DbBundle.Model.Base
 */
abstract class Customer implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Common\\DbBundle\\Model\\Map\\CustomerTableMap';


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
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the username field.
     *
     * @var        string
     */
    protected $username;

    /**
     * The value for the owner field.
     *
     * @var        string
     */
    protected $owner;

    /**
     * The value for the code field.
     *
     * @var        string
     */
    protected $code;

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
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

    /**
     * The value for the type field.
     *
     * @var        string
     */
    protected $type;

    /**
     * @var        ObjectCollection|ChildAdvert[] Collection to store aggregation of ChildAdvert objects.
     */
    protected $collAdverts;
    protected $collAdvertsPartial;

    /**
     * @var        ObjectCollection|ChildGiftcode[] Collection to store aggregation of ChildGiftcode objects.
     */
    protected $collGiftcodes;
    protected $collGiftcodesPartial;

    /**
     * @var        ObjectCollection|Accesspoint[] Collection to store aggregation of Accesspoint objects.
     */
    protected $collAccesspoints;
    protected $collAccesspointsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAdvert[]
     */
    protected $advertsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGiftcode[]
     */
    protected $giftcodesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Accesspoint[]
     */
    protected $accesspointsScheduledForDeletion = null;

    /**
     * Initializes internal state of Common\DbBundle\Model\Base\Customer object.
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
     * Compares this with another <code>Customer</code> instance.  If
     * <code>obj</code> is an instance of <code>Customer</code>, delegates to
     * <code>equals(Customer)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Customer The current object, for fluid interface
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [owner] column value.
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Get the [code] column value.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
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
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CustomerTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[CustomerTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[CustomerTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [owner] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function setOwner($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->owner !== $v) {
            $this->owner = $v;
            $this->modifiedColumns[CustomerTableMap::COL_OWNER] = true;
        }

        return $this;
    } // setOwner()

    /**
     * Set the value of [code] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[CustomerTableMap::COL_CODE] = true;
        }

        return $this;
    } // setCode()

    /**
     * Set the value of [address] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[CustomerTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Set the value of [phone] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[CustomerTableMap::COL_PHONE] = true;
        }

        return $this;
    } // setPhone()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[CustomerTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [type] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[CustomerTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CustomerTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CustomerTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CustomerTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CustomerTableMap::translateFieldName('Owner', TableMap::TYPE_PHPNAME, $indexType)];
            $this->owner = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CustomerTableMap::translateFieldName('Code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CustomerTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CustomerTableMap::translateFieldName('Phone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : CustomerTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : CustomerTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = CustomerTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Common\\DbBundle\\Model\\Customer'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(CustomerTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCustomerQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAdverts = null;

            $this->collGiftcodes = null;

            $this->collAccesspoints = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Customer::setDeleted()
     * @see Customer::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCustomerQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
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
                CustomerTableMap::addInstanceToPool($this);
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

            if ($this->advertsScheduledForDeletion !== null) {
                if (!$this->advertsScheduledForDeletion->isEmpty()) {
                    foreach ($this->advertsScheduledForDeletion as $advert) {
                        // need to save related object because we set the relation to null
                        $advert->save($con);
                    }
                    $this->advertsScheduledForDeletion = null;
                }
            }

            if ($this->collAdverts !== null) {
                foreach ($this->collAdverts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->giftcodesScheduledForDeletion !== null) {
                if (!$this->giftcodesScheduledForDeletion->isEmpty()) {
                    foreach ($this->giftcodesScheduledForDeletion as $giftcode) {
                        // need to save related object because we set the relation to null
                        $giftcode->save($con);
                    }
                    $this->giftcodesScheduledForDeletion = null;
                }
            }

            if ($this->collGiftcodes !== null) {
                foreach ($this->collGiftcodes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->accesspointsScheduledForDeletion !== null) {
                if (!$this->accesspointsScheduledForDeletion->isEmpty()) {
                    foreach ($this->accesspointsScheduledForDeletion as $accesspoint) {
                        // need to save related object because we set the relation to null
                        $accesspoint->save($con);
                    }
                    $this->accesspointsScheduledForDeletion = null;
                }
            }

            if ($this->collAccesspoints !== null) {
                foreach ($this->collAccesspoints as $referrerFK) {
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

        $this->modifiedColumns[CustomerTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CustomerTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CustomerTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(CustomerTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(CustomerTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = '`username`';
        }
        if ($this->isColumnModified(CustomerTableMap::COL_OWNER)) {
            $modifiedColumns[':p' . $index++]  = '`owner`';
        }
        if ($this->isColumnModified(CustomerTableMap::COL_CODE)) {
            $modifiedColumns[':p' . $index++]  = '`code`';
        }
        if ($this->isColumnModified(CustomerTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = '`address`';
        }
        if ($this->isColumnModified(CustomerTableMap::COL_PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`phone`';
        }
        if ($this->isColumnModified(CustomerTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`email`';
        }
        if ($this->isColumnModified(CustomerTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }

        $sql = sprintf(
            'INSERT INTO `customer` (%s) VALUES (%s)',
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
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`username`':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case '`owner`':
                        $stmt->bindValue($identifier, $this->owner, PDO::PARAM_STR);
                        break;
                    case '`code`':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
                        break;
                    case '`address`':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case '`phone`':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case '`email`':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
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
        $pos = CustomerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getUsername();
                break;
            case 3:
                return $this->getOwner();
                break;
            case 4:
                return $this->getCode();
                break;
            case 5:
                return $this->getAddress();
                break;
            case 6:
                return $this->getPhone();
                break;
            case 7:
                return $this->getEmail();
                break;
            case 8:
                return $this->getType();
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

        if (isset($alreadyDumpedObjects['Customer'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Customer'][$this->hashCode()] = true;
        $keys = CustomerTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getUsername(),
            $keys[3] => $this->getOwner(),
            $keys[4] => $this->getCode(),
            $keys[5] => $this->getAddress(),
            $keys[6] => $this->getPhone(),
            $keys[7] => $this->getEmail(),
            $keys[8] => $this->getType(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAdverts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'adverts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'adverts';
                        break;
                    default:
                        $key = 'Adverts';
                }

                $result[$key] = $this->collAdverts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGiftcodes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'giftcodes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'giftcodes';
                        break;
                    default:
                        $key = 'Giftcodes';
                }

                $result[$key] = $this->collGiftcodes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAccesspoints) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'accesspoints';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'accesspoints';
                        break;
                    default:
                        $key = 'Accesspoints';
                }

                $result[$key] = $this->collAccesspoints->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Common\DbBundle\Model\Customer
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CustomerTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Common\DbBundle\Model\Customer
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setUsername($value);
                break;
            case 3:
                $this->setOwner($value);
                break;
            case 4:
                $this->setCode($value);
                break;
            case 5:
                $this->setAddress($value);
                break;
            case 6:
                $this->setPhone($value);
                break;
            case 7:
                $this->setEmail($value);
                break;
            case 8:
                $this->setType($value);
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
        $keys = CustomerTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUsername($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setOwner($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCode($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAddress($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPhone($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setEmail($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setType($arr[$keys[8]]);
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
     * @return $this|\Common\DbBundle\Model\Customer The current object, for fluid interface
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
        $criteria = new Criteria(CustomerTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CustomerTableMap::COL_ID)) {
            $criteria->add(CustomerTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(CustomerTableMap::COL_NAME)) {
            $criteria->add(CustomerTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(CustomerTableMap::COL_USERNAME)) {
            $criteria->add(CustomerTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(CustomerTableMap::COL_OWNER)) {
            $criteria->add(CustomerTableMap::COL_OWNER, $this->owner);
        }
        if ($this->isColumnModified(CustomerTableMap::COL_CODE)) {
            $criteria->add(CustomerTableMap::COL_CODE, $this->code);
        }
        if ($this->isColumnModified(CustomerTableMap::COL_ADDRESS)) {
            $criteria->add(CustomerTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(CustomerTableMap::COL_PHONE)) {
            $criteria->add(CustomerTableMap::COL_PHONE, $this->phone);
        }
        if ($this->isColumnModified(CustomerTableMap::COL_EMAIL)) {
            $criteria->add(CustomerTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(CustomerTableMap::COL_TYPE)) {
            $criteria->add(CustomerTableMap::COL_TYPE, $this->type);
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
        $criteria = ChildCustomerQuery::create();
        $criteria->add(CustomerTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Common\DbBundle\Model\Customer (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setUsername($this->getUsername());
        $copyObj->setOwner($this->getOwner());
        $copyObj->setCode($this->getCode());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setType($this->getType());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAdverts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvert($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGiftcodes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGiftcode($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAccesspoints() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccesspoint($relObj->copy($deepCopy));
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
     * @return \Common\DbBundle\Model\Customer Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Advert' == $relationName) {
            $this->initAdverts();
            return;
        }
        if ('Giftcode' == $relationName) {
            $this->initGiftcodes();
            return;
        }
        if ('Accesspoint' == $relationName) {
            $this->initAccesspoints();
            return;
        }
    }

    /**
     * Clears out the collAdverts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAdverts()
     */
    public function clearAdverts()
    {
        $this->collAdverts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAdverts collection loaded partially.
     */
    public function resetPartialAdverts($v = true)
    {
        $this->collAdvertsPartial = $v;
    }

    /**
     * Initializes the collAdverts collection.
     *
     * By default this just sets the collAdverts collection to an empty array (like clearcollAdverts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdverts($overrideExisting = true)
    {
        if (null !== $this->collAdverts && !$overrideExisting) {
            return;
        }

        $collectionClassName = AdvertTableMap::getTableMap()->getCollectionClassName();

        $this->collAdverts = new $collectionClassName;
        $this->collAdverts->setModel('\Common\DbBundle\Model\Advert');
    }

    /**
     * Gets an array of ChildAdvert objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCustomer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAdvert[] List of ChildAdvert objects
     * @throws PropelException
     */
    public function getAdverts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAdvertsPartial && !$this->isNew();
        if (null === $this->collAdverts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdverts) {
                // return empty collection
                $this->initAdverts();
            } else {
                $collAdverts = ChildAdvertQuery::create(null, $criteria)
                    ->filterByCustomer($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAdvertsPartial && count($collAdverts)) {
                        $this->initAdverts(false);

                        foreach ($collAdverts as $obj) {
                            if (false == $this->collAdverts->contains($obj)) {
                                $this->collAdverts->append($obj);
                            }
                        }

                        $this->collAdvertsPartial = true;
                    }

                    return $collAdverts;
                }

                if ($partial && $this->collAdverts) {
                    foreach ($this->collAdverts as $obj) {
                        if ($obj->isNew()) {
                            $collAdverts[] = $obj;
                        }
                    }
                }

                $this->collAdverts = $collAdverts;
                $this->collAdvertsPartial = false;
            }
        }

        return $this->collAdverts;
    }

    /**
     * Sets a collection of ChildAdvert objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $adverts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCustomer The current object (for fluent API support)
     */
    public function setAdverts(Collection $adverts, ConnectionInterface $con = null)
    {
        /** @var ChildAdvert[] $advertsToDelete */
        $advertsToDelete = $this->getAdverts(new Criteria(), $con)->diff($adverts);


        $this->advertsScheduledForDeletion = $advertsToDelete;

        foreach ($advertsToDelete as $advertRemoved) {
            $advertRemoved->setCustomer(null);
        }

        $this->collAdverts = null;
        foreach ($adverts as $advert) {
            $this->addAdvert($advert);
        }

        $this->collAdverts = $adverts;
        $this->collAdvertsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Advert objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Advert objects.
     * @throws PropelException
     */
    public function countAdverts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAdvertsPartial && !$this->isNew();
        if (null === $this->collAdverts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdverts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdverts());
            }

            $query = ChildAdvertQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomer($this)
                ->count($con);
        }

        return count($this->collAdverts);
    }

    /**
     * Method called to associate a ChildAdvert object to this object
     * through the ChildAdvert foreign key attribute.
     *
     * @param  ChildAdvert $l ChildAdvert
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function addAdvert(ChildAdvert $l)
    {
        if ($this->collAdverts === null) {
            $this->initAdverts();
            $this->collAdvertsPartial = true;
        }

        if (!$this->collAdverts->contains($l)) {
            $this->doAddAdvert($l);

            if ($this->advertsScheduledForDeletion and $this->advertsScheduledForDeletion->contains($l)) {
                $this->advertsScheduledForDeletion->remove($this->advertsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAdvert $advert The ChildAdvert object to add.
     */
    protected function doAddAdvert(ChildAdvert $advert)
    {
        $this->collAdverts[]= $advert;
        $advert->setCustomer($this);
    }

    /**
     * @param  ChildAdvert $advert The ChildAdvert object to remove.
     * @return $this|ChildCustomer The current object (for fluent API support)
     */
    public function removeAdvert(ChildAdvert $advert)
    {
        if ($this->getAdverts()->contains($advert)) {
            $pos = $this->collAdverts->search($advert);
            $this->collAdverts->remove($pos);
            if (null === $this->advertsScheduledForDeletion) {
                $this->advertsScheduledForDeletion = clone $this->collAdverts;
                $this->advertsScheduledForDeletion->clear();
            }
            $this->advertsScheduledForDeletion[]= $advert;
            $advert->setCustomer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Customer is new, it will return
     * an empty collection; or if this Customer has previously
     * been saved, it will retrieve related Adverts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Customer.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAdvert[] List of ChildAdvert objects
     */
    public function getAdvertsJoinSection(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAdvertQuery::create(null, $criteria);
        $query->joinWith('Section', $joinBehavior);

        return $this->getAdverts($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Customer is new, it will return
     * an empty collection; or if this Customer has previously
     * been saved, it will retrieve related Adverts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Customer.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAdvert[] List of ChildAdvert objects
     */
    public function getAdvertsJoinBundle(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAdvertQuery::create(null, $criteria);
        $query->joinWith('Bundle', $joinBehavior);

        return $this->getAdverts($query, $con);
    }

    /**
     * Clears out the collGiftcodes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGiftcodes()
     */
    public function clearGiftcodes()
    {
        $this->collGiftcodes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGiftcodes collection loaded partially.
     */
    public function resetPartialGiftcodes($v = true)
    {
        $this->collGiftcodesPartial = $v;
    }

    /**
     * Initializes the collGiftcodes collection.
     *
     * By default this just sets the collGiftcodes collection to an empty array (like clearcollGiftcodes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGiftcodes($overrideExisting = true)
    {
        if (null !== $this->collGiftcodes && !$overrideExisting) {
            return;
        }

        $collectionClassName = GiftcodeTableMap::getTableMap()->getCollectionClassName();

        $this->collGiftcodes = new $collectionClassName;
        $this->collGiftcodes->setModel('\Common\DbBundle\Model\Giftcode');
    }

    /**
     * Gets an array of ChildGiftcode objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCustomer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGiftcode[] List of ChildGiftcode objects
     * @throws PropelException
     */
    public function getGiftcodes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGiftcodesPartial && !$this->isNew();
        if (null === $this->collGiftcodes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGiftcodes) {
                // return empty collection
                $this->initGiftcodes();
            } else {
                $collGiftcodes = ChildGiftcodeQuery::create(null, $criteria)
                    ->filterByCustomer($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGiftcodesPartial && count($collGiftcodes)) {
                        $this->initGiftcodes(false);

                        foreach ($collGiftcodes as $obj) {
                            if (false == $this->collGiftcodes->contains($obj)) {
                                $this->collGiftcodes->append($obj);
                            }
                        }

                        $this->collGiftcodesPartial = true;
                    }

                    return $collGiftcodes;
                }

                if ($partial && $this->collGiftcodes) {
                    foreach ($this->collGiftcodes as $obj) {
                        if ($obj->isNew()) {
                            $collGiftcodes[] = $obj;
                        }
                    }
                }

                $this->collGiftcodes = $collGiftcodes;
                $this->collGiftcodesPartial = false;
            }
        }

        return $this->collGiftcodes;
    }

    /**
     * Sets a collection of ChildGiftcode objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $giftcodes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCustomer The current object (for fluent API support)
     */
    public function setGiftcodes(Collection $giftcodes, ConnectionInterface $con = null)
    {
        /** @var ChildGiftcode[] $giftcodesToDelete */
        $giftcodesToDelete = $this->getGiftcodes(new Criteria(), $con)->diff($giftcodes);


        $this->giftcodesScheduledForDeletion = $giftcodesToDelete;

        foreach ($giftcodesToDelete as $giftcodeRemoved) {
            $giftcodeRemoved->setCustomer(null);
        }

        $this->collGiftcodes = null;
        foreach ($giftcodes as $giftcode) {
            $this->addGiftcode($giftcode);
        }

        $this->collGiftcodes = $giftcodes;
        $this->collGiftcodesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Giftcode objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Giftcode objects.
     * @throws PropelException
     */
    public function countGiftcodes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGiftcodesPartial && !$this->isNew();
        if (null === $this->collGiftcodes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGiftcodes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGiftcodes());
            }

            $query = ChildGiftcodeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomer($this)
                ->count($con);
        }

        return count($this->collGiftcodes);
    }

    /**
     * Method called to associate a ChildGiftcode object to this object
     * through the ChildGiftcode foreign key attribute.
     *
     * @param  ChildGiftcode $l ChildGiftcode
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function addGiftcode(ChildGiftcode $l)
    {
        if ($this->collGiftcodes === null) {
            $this->initGiftcodes();
            $this->collGiftcodesPartial = true;
        }

        if (!$this->collGiftcodes->contains($l)) {
            $this->doAddGiftcode($l);

            if ($this->giftcodesScheduledForDeletion and $this->giftcodesScheduledForDeletion->contains($l)) {
                $this->giftcodesScheduledForDeletion->remove($this->giftcodesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildGiftcode $giftcode The ChildGiftcode object to add.
     */
    protected function doAddGiftcode(ChildGiftcode $giftcode)
    {
        $this->collGiftcodes[]= $giftcode;
        $giftcode->setCustomer($this);
    }

    /**
     * @param  ChildGiftcode $giftcode The ChildGiftcode object to remove.
     * @return $this|ChildCustomer The current object (for fluent API support)
     */
    public function removeGiftcode(ChildGiftcode $giftcode)
    {
        if ($this->getGiftcodes()->contains($giftcode)) {
            $pos = $this->collGiftcodes->search($giftcode);
            $this->collGiftcodes->remove($pos);
            if (null === $this->giftcodesScheduledForDeletion) {
                $this->giftcodesScheduledForDeletion = clone $this->collGiftcodes;
                $this->giftcodesScheduledForDeletion->clear();
            }
            $this->giftcodesScheduledForDeletion[]= $giftcode;
            $giftcode->setCustomer(null);
        }

        return $this;
    }

    /**
     * Clears out the collAccesspoints collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAccesspoints()
     */
    public function clearAccesspoints()
    {
        $this->collAccesspoints = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAccesspoints collection loaded partially.
     */
    public function resetPartialAccesspoints($v = true)
    {
        $this->collAccesspointsPartial = $v;
    }

    /**
     * Initializes the collAccesspoints collection.
     *
     * By default this just sets the collAccesspoints collection to an empty array (like clearcollAccesspoints());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAccesspoints($overrideExisting = true)
    {
        if (null !== $this->collAccesspoints && !$overrideExisting) {
            return;
        }

        $collectionClassName = AccesspointTableMap::getTableMap()->getCollectionClassName();

        $this->collAccesspoints = new $collectionClassName;
        $this->collAccesspoints->setModel('\Hotspot\AccessPointBundle\Model\Accesspoint');
    }

    /**
     * Gets an array of Accesspoint objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCustomer is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|Accesspoint[] List of Accesspoint objects
     * @throws PropelException
     */
    public function getAccesspoints(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAccesspointsPartial && !$this->isNew();
        if (null === $this->collAccesspoints || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAccesspoints) {
                // return empty collection
                $this->initAccesspoints();
            } else {
                $collAccesspoints = AccesspointQuery::create(null, $criteria)
                    ->filterByCustomer($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAccesspointsPartial && count($collAccesspoints)) {
                        $this->initAccesspoints(false);

                        foreach ($collAccesspoints as $obj) {
                            if (false == $this->collAccesspoints->contains($obj)) {
                                $this->collAccesspoints->append($obj);
                            }
                        }

                        $this->collAccesspointsPartial = true;
                    }

                    return $collAccesspoints;
                }

                if ($partial && $this->collAccesspoints) {
                    foreach ($this->collAccesspoints as $obj) {
                        if ($obj->isNew()) {
                            $collAccesspoints[] = $obj;
                        }
                    }
                }

                $this->collAccesspoints = $collAccesspoints;
                $this->collAccesspointsPartial = false;
            }
        }

        return $this->collAccesspoints;
    }

    /**
     * Sets a collection of Accesspoint objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $accesspoints A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCustomer The current object (for fluent API support)
     */
    public function setAccesspoints(Collection $accesspoints, ConnectionInterface $con = null)
    {
        /** @var Accesspoint[] $accesspointsToDelete */
        $accesspointsToDelete = $this->getAccesspoints(new Criteria(), $con)->diff($accesspoints);


        $this->accesspointsScheduledForDeletion = $accesspointsToDelete;

        foreach ($accesspointsToDelete as $accesspointRemoved) {
            $accesspointRemoved->setCustomer(null);
        }

        $this->collAccesspoints = null;
        foreach ($accesspoints as $accesspoint) {
            $this->addAccesspoint($accesspoint);
        }

        $this->collAccesspoints = $accesspoints;
        $this->collAccesspointsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BaseAccesspoint objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related BaseAccesspoint objects.
     * @throws PropelException
     */
    public function countAccesspoints(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAccesspointsPartial && !$this->isNew();
        if (null === $this->collAccesspoints || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAccesspoints) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAccesspoints());
            }

            $query = AccesspointQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCustomer($this)
                ->count($con);
        }

        return count($this->collAccesspoints);
    }

    /**
     * Method called to associate a Accesspoint object to this object
     * through the Accesspoint foreign key attribute.
     *
     * @param  Accesspoint $l Accesspoint
     * @return $this|\Common\DbBundle\Model\Customer The current object (for fluent API support)
     */
    public function addAccesspoint(Accesspoint $l)
    {
        if ($this->collAccesspoints === null) {
            $this->initAccesspoints();
            $this->collAccesspointsPartial = true;
        }

        if (!$this->collAccesspoints->contains($l)) {
            $this->doAddAccesspoint($l);

            if ($this->accesspointsScheduledForDeletion and $this->accesspointsScheduledForDeletion->contains($l)) {
                $this->accesspointsScheduledForDeletion->remove($this->accesspointsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param Accesspoint $accesspoint The Accesspoint object to add.
     */
    protected function doAddAccesspoint(Accesspoint $accesspoint)
    {
        $this->collAccesspoints[]= $accesspoint;
        $accesspoint->setCustomer($this);
    }

    /**
     * @param  Accesspoint $accesspoint The Accesspoint object to remove.
     * @return $this|ChildCustomer The current object (for fluent API support)
     */
    public function removeAccesspoint(Accesspoint $accesspoint)
    {
        if ($this->getAccesspoints()->contains($accesspoint)) {
            $pos = $this->collAccesspoints->search($accesspoint);
            $this->collAccesspoints->remove($pos);
            if (null === $this->accesspointsScheduledForDeletion) {
                $this->accesspointsScheduledForDeletion = clone $this->collAccesspoints;
                $this->accesspointsScheduledForDeletion->clear();
            }
            $this->accesspointsScheduledForDeletion[]= $accesspoint;
            $accesspoint->setCustomer(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Customer is new, it will return
     * an empty collection; or if this Customer has previously
     * been saved, it will retrieve related Accesspoints from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Customer.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|Accesspoint[] List of Accesspoint objects
     */
    public function getAccesspointsJoinSection(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = AccesspointQuery::create(null, $criteria);
        $query->joinWith('Section', $joinBehavior);

        return $this->getAccesspoints($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Customer is new, it will return
     * an empty collection; or if this Customer has previously
     * been saved, it will retrieve related Accesspoints from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Customer.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|Accesspoint[] List of Accesspoint objects
     */
    public function getAccesspointsJoinAccesspointCategory(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = AccesspointQuery::create(null, $criteria);
        $query->joinWith('AccesspointCategory', $joinBehavior);

        return $this->getAccesspoints($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->username = null;
        $this->owner = null;
        $this->code = null;
        $this->address = null;
        $this->phone = null;
        $this->email = null;
        $this->type = null;
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
            if ($this->collAdverts) {
                foreach ($this->collAdverts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGiftcodes) {
                foreach ($this->collGiftcodes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAccesspoints) {
                foreach ($this->collAccesspoints as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAdverts = null;
        $this->collGiftcodes = null;
        $this->collAccesspoints = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CustomerTableMap::DEFAULT_STRING_FORMAT);
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
