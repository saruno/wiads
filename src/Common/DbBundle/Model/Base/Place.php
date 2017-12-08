<?php

namespace Common\DbBundle\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Common\DbBundle\Model\Place as ChildPlace;
use Common\DbBundle\Model\PlaceI18n as ChildPlaceI18n;
use Common\DbBundle\Model\PlaceI18nQuery as ChildPlaceI18nQuery;
use Common\DbBundle\Model\PlaceQuery as ChildPlaceQuery;
use Common\DbBundle\Model\Section as ChildSection;
use Common\DbBundle\Model\SectionQuery as ChildSectionQuery;
use Common\DbBundle\Model\Map\PlaceI18nTableMap;
use Common\DbBundle\Model\Map\PlaceTableMap;
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
 * Base class that represents a row from the 'place' table.
 *
 *
 *
 * @package    propel.generator.src.Common.DbBundle.Model.Base
 */
abstract class Place implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Common\\DbBundle\\Model\\Map\\PlaceTableMap';


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
     * The value for the section_id field.
     *
     * @var        int
     */
    protected $section_id;

    /**
     * The value for the orders_id field.
     *
     * @var        string
     */
    protected $orders_id;

    /**
     * The value for the locked field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $locked;

    /**
     * The value for the imgs field.
     *
     * @var        string
     */
    protected $imgs;

    /**
     * The value for the address field.
     *
     * @var        string
     */
    protected $address;

    /**
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

    /**
     * The value for the phone field.
     *
     * @var        string
     */
    protected $phone;

    /**
     * The value for the lat field.
     *
     * @var        string
     */
    protected $lat;

    /**
     * The value for the lng field.
     *
     * @var        string
     */
    protected $lng;

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
     * @var        ChildSection
     */
    protected $aSection;

    /**
     * @var        ObjectCollection|ChildPlaceI18n[] Collection to store aggregation of ChildPlaceI18n objects.
     */
    protected $collPlaceI18ns;
    protected $collPlaceI18nsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // i18n behavior

    /**
     * Current locale
     * @var        string
     */
    protected $currentLocale = 'vi';

    /**
     * Current translation objects
     * @var        array[ChildPlaceI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlaceI18n[]
     */
    protected $placeI18nsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->locked = false;
    }

    /**
     * Initializes internal state of Common\DbBundle\Model\Base\Place object.
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
     * Compares this with another <code>Place</code> instance.  If
     * <code>obj</code> is an instance of <code>Place</code>, delegates to
     * <code>equals(Place)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Place The current object, for fluid interface
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
     * Get the [section_id] column value.
     *
     * @return int
     */
    public function getSectionId()
    {
        return $this->section_id;
    }

    /**
     * Get the [orders_id] column value.
     *
     * @return string
     */
    public function getOrdersId()
    {
        return $this->orders_id;
    }

    /**
     * Get the [locked] column value.
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Get the [locked] column value.
     *
     * @return boolean
     */
    public function isLocked()
    {
        return $this->getLocked();
    }

    /**
     * Get the [imgs] column value.
     *
     * @return string
     */
    public function getImgs()
    {
        return $this->imgs;
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
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Get the [lat] column value.
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Get the [lng] column value.
     *
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
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
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PlaceTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [section_id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setSectionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->section_id !== $v) {
            $this->section_id = $v;
            $this->modifiedColumns[PlaceTableMap::COL_SECTION_ID] = true;
        }

        if ($this->aSection !== null && $this->aSection->getId() !== $v) {
            $this->aSection = null;
        }

        return $this;
    } // setSectionId()

    /**
     * Set the value of [orders_id] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setOrdersId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->orders_id !== $v) {
            $this->orders_id = $v;
            $this->modifiedColumns[PlaceTableMap::COL_ORDERS_ID] = true;
        }

        return $this;
    } // setOrdersId()

    /**
     * Sets the value of the [locked] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setLocked($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->locked !== $v) {
            $this->locked = $v;
            $this->modifiedColumns[PlaceTableMap::COL_LOCKED] = true;
        }

        return $this;
    } // setLocked()

    /**
     * Set the value of [imgs] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setImgs($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->imgs !== $v) {
            $this->imgs = $v;
            $this->modifiedColumns[PlaceTableMap::COL_IMGS] = true;
        }

        return $this;
    } // setImgs()

    /**
     * Set the value of [address] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[PlaceTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[PlaceTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [phone] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[PlaceTableMap::COL_PHONE] = true;
        }

        return $this;
    } // setPhone()

    /**
     * Set the value of [lat] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setLat($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lat !== $v) {
            $this->lat = $v;
            $this->modifiedColumns[PlaceTableMap::COL_LAT] = true;
        }

        return $this;
    } // setLat()

    /**
     * Set the value of [lng] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setLng($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lng !== $v) {
            $this->lng = $v;
            $this->modifiedColumns[PlaceTableMap::COL_LNG] = true;
        }

        return $this;
    } // setLng()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PlaceTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PlaceTableMap::COL_UPDATED_AT] = true;
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
            if ($this->locked !== false) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PlaceTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PlaceTableMap::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->section_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PlaceTableMap::translateFieldName('OrdersId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->orders_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PlaceTableMap::translateFieldName('Locked', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locked = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PlaceTableMap::translateFieldName('Imgs', TableMap::TYPE_PHPNAME, $indexType)];
            $this->imgs = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PlaceTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PlaceTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PlaceTableMap::translateFieldName('Phone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PlaceTableMap::translateFieldName('Lat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lat = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PlaceTableMap::translateFieldName('Lng', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lng = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : PlaceTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : PlaceTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = PlaceTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Common\\DbBundle\\Model\\Place'), 0, $e);
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
        if ($this->aSection !== null && $this->section_id !== $this->aSection->getId()) {
            $this->aSection = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(PlaceTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPlaceQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSection = null;
            $this->collPlaceI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Place::setDeleted()
     * @see Place::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlaceTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPlaceQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PlaceTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(PlaceTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(PlaceTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(PlaceTableMap::COL_UPDATED_AT)) {
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
                PlaceTableMap::addInstanceToPool($this);
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

            if ($this->aSection !== null) {
                if ($this->aSection->isModified() || $this->aSection->isNew()) {
                    $affectedRows += $this->aSection->save($con);
                }
                $this->setSection($this->aSection);
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

            if ($this->placeI18nsScheduledForDeletion !== null) {
                if (!$this->placeI18nsScheduledForDeletion->isEmpty()) {
                    \Common\DbBundle\Model\PlaceI18nQuery::create()
                        ->filterByPrimaryKeys($this->placeI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->placeI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collPlaceI18ns !== null) {
                foreach ($this->collPlaceI18ns as $referrerFK) {
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

        $this->modifiedColumns[PlaceTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PlaceTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PlaceTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_SECTION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`section_id`';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_ORDERS_ID)) {
            $modifiedColumns[':p' . $index++]  = '`orders_id`';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_LOCKED)) {
            $modifiedColumns[':p' . $index++]  = '`locked`';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_IMGS)) {
            $modifiedColumns[':p' . $index++]  = '`imgs`';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = '`address`';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`email`';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`phone`';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_LAT)) {
            $modifiedColumns[':p' . $index++]  = '`lat`';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_LNG)) {
            $modifiedColumns[':p' . $index++]  = '`lng`';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `place` (%s) VALUES (%s)',
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
                    case '`section_id`':
                        $stmt->bindValue($identifier, $this->section_id, PDO::PARAM_INT);
                        break;
                    case '`orders_id`':
                        $stmt->bindValue($identifier, $this->orders_id, PDO::PARAM_STR);
                        break;
                    case '`locked`':
                        $stmt->bindValue($identifier, (int) $this->locked, PDO::PARAM_INT);
                        break;
                    case '`imgs`':
                        $stmt->bindValue($identifier, $this->imgs, PDO::PARAM_STR);
                        break;
                    case '`address`':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case '`email`':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case '`phone`':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case '`lat`':
                        $stmt->bindValue($identifier, $this->lat, PDO::PARAM_STR);
                        break;
                    case '`lng`':
                        $stmt->bindValue($identifier, $this->lng, PDO::PARAM_STR);
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
        $pos = PlaceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getSectionId();
                break;
            case 2:
                return $this->getOrdersId();
                break;
            case 3:
                return $this->getLocked();
                break;
            case 4:
                return $this->getImgs();
                break;
            case 5:
                return $this->getAddress();
                break;
            case 6:
                return $this->getEmail();
                break;
            case 7:
                return $this->getPhone();
                break;
            case 8:
                return $this->getLat();
                break;
            case 9:
                return $this->getLng();
                break;
            case 10:
                return $this->getCreatedAt();
                break;
            case 11:
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

        if (isset($alreadyDumpedObjects['Place'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Place'][$this->hashCode()] = true;
        $keys = PlaceTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getSectionId(),
            $keys[2] => $this->getOrdersId(),
            $keys[3] => $this->getLocked(),
            $keys[4] => $this->getImgs(),
            $keys[5] => $this->getAddress(),
            $keys[6] => $this->getEmail(),
            $keys[7] => $this->getPhone(),
            $keys[8] => $this->getLat(),
            $keys[9] => $this->getLng(),
            $keys[10] => $this->getCreatedAt(),
            $keys[11] => $this->getUpdatedAt(),
        );
        if ($result[$keys[10]] instanceof \DateTimeInterface) {
            $result[$keys[10]] = $result[$keys[10]]->format('c');
        }

        if ($result[$keys[11]] instanceof \DateTimeInterface) {
            $result[$keys[11]] = $result[$keys[11]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aSection) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'section';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'section';
                        break;
                    default:
                        $key = 'Section';
                }

                $result[$key] = $this->aSection->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPlaceI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'placeI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'place_i18ns';
                        break;
                    default:
                        $key = 'PlaceI18ns';
                }

                $result[$key] = $this->collPlaceI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Common\DbBundle\Model\Place
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PlaceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Common\DbBundle\Model\Place
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setSectionId($value);
                break;
            case 2:
                $this->setOrdersId($value);
                break;
            case 3:
                $this->setLocked($value);
                break;
            case 4:
                $this->setImgs($value);
                break;
            case 5:
                $this->setAddress($value);
                break;
            case 6:
                $this->setEmail($value);
                break;
            case 7:
                $this->setPhone($value);
                break;
            case 8:
                $this->setLat($value);
                break;
            case 9:
                $this->setLng($value);
                break;
            case 10:
                $this->setCreatedAt($value);
                break;
            case 11:
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
        $keys = PlaceTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setSectionId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setOrdersId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLocked($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setImgs($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAddress($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setEmail($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPhone($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setLat($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setLng($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCreatedAt($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setUpdatedAt($arr[$keys[11]]);
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
     * @return $this|\Common\DbBundle\Model\Place The current object, for fluid interface
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
        $criteria = new Criteria(PlaceTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PlaceTableMap::COL_ID)) {
            $criteria->add(PlaceTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_SECTION_ID)) {
            $criteria->add(PlaceTableMap::COL_SECTION_ID, $this->section_id);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_ORDERS_ID)) {
            $criteria->add(PlaceTableMap::COL_ORDERS_ID, $this->orders_id);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_LOCKED)) {
            $criteria->add(PlaceTableMap::COL_LOCKED, $this->locked);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_IMGS)) {
            $criteria->add(PlaceTableMap::COL_IMGS, $this->imgs);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_ADDRESS)) {
            $criteria->add(PlaceTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_EMAIL)) {
            $criteria->add(PlaceTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_PHONE)) {
            $criteria->add(PlaceTableMap::COL_PHONE, $this->phone);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_LAT)) {
            $criteria->add(PlaceTableMap::COL_LAT, $this->lat);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_LNG)) {
            $criteria->add(PlaceTableMap::COL_LNG, $this->lng);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_CREATED_AT)) {
            $criteria->add(PlaceTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_UPDATED_AT)) {
            $criteria->add(PlaceTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildPlaceQuery::create();
        $criteria->add(PlaceTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Common\DbBundle\Model\Place (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSectionId($this->getSectionId());
        $copyObj->setOrdersId($this->getOrdersId());
        $copyObj->setLocked($this->getLocked());
        $copyObj->setImgs($this->getImgs());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setLat($this->getLat());
        $copyObj->setLng($this->getLng());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPlaceI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlaceI18n($relObj->copy($deepCopy));
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
     * @return \Common\DbBundle\Model\Place Clone of current object.
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
     * Declares an association between this object and a ChildSection object.
     *
     * @param  ChildSection $v
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSection(ChildSection $v = null)
    {
        if ($v === null) {
            $this->setSectionId(NULL);
        } else {
            $this->setSectionId($v->getId());
        }

        $this->aSection = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSection object, it will not be re-added.
        if ($v !== null) {
            $v->addPlace($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSection object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSection The associated ChildSection object.
     * @throws PropelException
     */
    public function getSection(ConnectionInterface $con = null)
    {
        if ($this->aSection === null && ($this->section_id !== null)) {
            $this->aSection = ChildSectionQuery::create()->findPk($this->section_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSection->addPlaces($this);
             */
        }

        return $this->aSection;
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
        if ('PlaceI18n' == $relationName) {
            $this->initPlaceI18ns();
            return;
        }
    }

    /**
     * Clears out the collPlaceI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPlaceI18ns()
     */
    public function clearPlaceI18ns()
    {
        $this->collPlaceI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPlaceI18ns collection loaded partially.
     */
    public function resetPartialPlaceI18ns($v = true)
    {
        $this->collPlaceI18nsPartial = $v;
    }

    /**
     * Initializes the collPlaceI18ns collection.
     *
     * By default this just sets the collPlaceI18ns collection to an empty array (like clearcollPlaceI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPlaceI18ns($overrideExisting = true)
    {
        if (null !== $this->collPlaceI18ns && !$overrideExisting) {
            return;
        }

        $collectionClassName = PlaceI18nTableMap::getTableMap()->getCollectionClassName();

        $this->collPlaceI18ns = new $collectionClassName;
        $this->collPlaceI18ns->setModel('\Common\DbBundle\Model\PlaceI18n');
    }

    /**
     * Gets an array of ChildPlaceI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlace is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPlaceI18n[] List of ChildPlaceI18n objects
     * @throws PropelException
     */
    public function getPlaceI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPlaceI18nsPartial && !$this->isNew();
        if (null === $this->collPlaceI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPlaceI18ns) {
                // return empty collection
                $this->initPlaceI18ns();
            } else {
                $collPlaceI18ns = ChildPlaceI18nQuery::create(null, $criteria)
                    ->filterByPlace($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPlaceI18nsPartial && count($collPlaceI18ns)) {
                        $this->initPlaceI18ns(false);

                        foreach ($collPlaceI18ns as $obj) {
                            if (false == $this->collPlaceI18ns->contains($obj)) {
                                $this->collPlaceI18ns->append($obj);
                            }
                        }

                        $this->collPlaceI18nsPartial = true;
                    }

                    return $collPlaceI18ns;
                }

                if ($partial && $this->collPlaceI18ns) {
                    foreach ($this->collPlaceI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collPlaceI18ns[] = $obj;
                        }
                    }
                }

                $this->collPlaceI18ns = $collPlaceI18ns;
                $this->collPlaceI18nsPartial = false;
            }
        }

        return $this->collPlaceI18ns;
    }

    /**
     * Sets a collection of ChildPlaceI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $placeI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlace The current object (for fluent API support)
     */
    public function setPlaceI18ns(Collection $placeI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildPlaceI18n[] $placeI18nsToDelete */
        $placeI18nsToDelete = $this->getPlaceI18ns(new Criteria(), $con)->diff($placeI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->placeI18nsScheduledForDeletion = clone $placeI18nsToDelete;

        foreach ($placeI18nsToDelete as $placeI18nRemoved) {
            $placeI18nRemoved->setPlace(null);
        }

        $this->collPlaceI18ns = null;
        foreach ($placeI18ns as $placeI18n) {
            $this->addPlaceI18n($placeI18n);
        }

        $this->collPlaceI18ns = $placeI18ns;
        $this->collPlaceI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PlaceI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PlaceI18n objects.
     * @throws PropelException
     */
    public function countPlaceI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPlaceI18nsPartial && !$this->isNew();
        if (null === $this->collPlaceI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPlaceI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPlaceI18ns());
            }

            $query = ChildPlaceI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlace($this)
                ->count($con);
        }

        return count($this->collPlaceI18ns);
    }

    /**
     * Method called to associate a ChildPlaceI18n object to this object
     * through the ChildPlaceI18n foreign key attribute.
     *
     * @param  ChildPlaceI18n $l ChildPlaceI18n
     * @return $this|\Common\DbBundle\Model\Place The current object (for fluent API support)
     */
    public function addPlaceI18n(ChildPlaceI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collPlaceI18ns === null) {
            $this->initPlaceI18ns();
            $this->collPlaceI18nsPartial = true;
        }

        if (!$this->collPlaceI18ns->contains($l)) {
            $this->doAddPlaceI18n($l);

            if ($this->placeI18nsScheduledForDeletion and $this->placeI18nsScheduledForDeletion->contains($l)) {
                $this->placeI18nsScheduledForDeletion->remove($this->placeI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPlaceI18n $placeI18n The ChildPlaceI18n object to add.
     */
    protected function doAddPlaceI18n(ChildPlaceI18n $placeI18n)
    {
        $this->collPlaceI18ns[]= $placeI18n;
        $placeI18n->setPlace($this);
    }

    /**
     * @param  ChildPlaceI18n $placeI18n The ChildPlaceI18n object to remove.
     * @return $this|ChildPlace The current object (for fluent API support)
     */
    public function removePlaceI18n(ChildPlaceI18n $placeI18n)
    {
        if ($this->getPlaceI18ns()->contains($placeI18n)) {
            $pos = $this->collPlaceI18ns->search($placeI18n);
            $this->collPlaceI18ns->remove($pos);
            if (null === $this->placeI18nsScheduledForDeletion) {
                $this->placeI18nsScheduledForDeletion = clone $this->collPlaceI18ns;
                $this->placeI18nsScheduledForDeletion->clear();
            }
            $this->placeI18nsScheduledForDeletion[]= clone $placeI18n;
            $placeI18n->setPlace(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSection) {
            $this->aSection->removePlace($this);
        }
        $this->id = null;
        $this->section_id = null;
        $this->orders_id = null;
        $this->locked = null;
        $this->imgs = null;
        $this->address = null;
        $this->email = null;
        $this->phone = null;
        $this->lat = null;
        $this->lng = null;
        $this->created_at = null;
        $this->updated_at = null;
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
            if ($this->collPlaceI18ns) {
                foreach ($this->collPlaceI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'vi';
        $this->currentTranslations = null;

        $this->collPlaceI18ns = null;
        $this->aSection = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PlaceTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildPlace The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[PlaceTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildPlace The current object (for fluent API support)
     */
    public function setLocale($locale = 'vi')
    {
        $this->currentLocale = $locale;

        return $this;
    }

    /**
     * Gets the locale for translations
     *
     * @return    string $locale Locale to use for the translation, e.g. 'fr_FR'
     */
    public function getLocale()
    {
        return $this->currentLocale;
    }

    /**
     * Returns the current translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildPlaceI18n */
    public function getTranslation($locale = 'vi', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collPlaceI18ns) {
                foreach ($this->collPlaceI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildPlaceI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildPlaceI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addPlaceI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildPlace The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'vi', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildPlaceI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collPlaceI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collPlaceI18ns[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Returns the current translation
     *
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildPlaceI18n */
    public function getCurrentTranslation(ConnectionInterface $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [title] column value.
         *
         * @return string
         */
        public function getTitle()
        {
        return $this->getCurrentTranslation()->getTitle();
    }


        /**
         * Set the value of [title] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\PlaceI18n The current object (for fluent API support)
         */
        public function setTitle($v)
        {    $this->getCurrentTranslation()->setTitle($v);

        return $this;
    }


        /**
         * Get the [strip_title] column value.
         *
         * @return string
         */
        public function getStripTitle()
        {
        return $this->getCurrentTranslation()->getStripTitle();
    }


        /**
         * Set the value of [strip_title] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\PlaceI18n The current object (for fluent API support)
         */
        public function setStripTitle($v)
        {    $this->getCurrentTranslation()->setStripTitle($v);

        return $this;
    }


        /**
         * Get the [brief] column value.
         *
         * @return string
         */
        public function getBrief()
        {
        return $this->getCurrentTranslation()->getBrief();
    }


        /**
         * Set the value of [brief] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\PlaceI18n The current object (for fluent API support)
         */
        public function setBrief($v)
        {    $this->getCurrentTranslation()->setBrief($v);

        return $this;
    }


        /**
         * Get the [tag] column value.
         *
         * @return string
         */
        public function getTag()
        {
        return $this->getCurrentTranslation()->getTag();
    }


        /**
         * Set the value of [tag] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\PlaceI18n The current object (for fluent API support)
         */
        public function setTag($v)
        {    $this->getCurrentTranslation()->setTag($v);

        return $this;
    }


        /**
         * Get the [keyword] column value.
         *
         * @return string
         */
        public function getKeyword()
        {
        return $this->getCurrentTranslation()->getKeyword();
    }


        /**
         * Set the value of [keyword] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\PlaceI18n The current object (for fluent API support)
         */
        public function setKeyword($v)
        {    $this->getCurrentTranslation()->setKeyword($v);

        return $this;
    }


        /**
         * Get the [post_by] column value.
         *
         * @return string
         */
        public function getPostBy()
        {
        return $this->getCurrentTranslation()->getPostBy();
    }


        /**
         * Set the value of [post_by] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\PlaceI18n The current object (for fluent API support)
         */
        public function setPostBy($v)
        {    $this->getCurrentTranslation()->setPostBy($v);

        return $this;
    }


        /**
         * Get the [edit_by] column value.
         *
         * @return string
         */
        public function getEditBy()
        {
        return $this->getCurrentTranslation()->getEditBy();
    }


        /**
         * Set the value of [edit_by] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\PlaceI18n The current object (for fluent API support)
         */
        public function setEditBy($v)
        {    $this->getCurrentTranslation()->setEditBy($v);

        return $this;
    }


        /**
         * Get the [link] column value.
         *
         * @return string
         */
        public function getLink()
        {
        return $this->getCurrentTranslation()->getLink();
    }


        /**
         * Set the value of [link] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\PlaceI18n The current object (for fluent API support)
         */
        public function setLink($v)
        {    $this->getCurrentTranslation()->setLink($v);

        return $this;
    }


        /**
         * Get the [link_to] column value.
         *
         * @return string
         */
        public function getLinkTo()
        {
        return $this->getCurrentTranslation()->getLinkTo();
    }


        /**
         * Set the value of [link_to] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\PlaceI18n The current object (for fluent API support)
         */
        public function setLinkTo($v)
        {    $this->getCurrentTranslation()->setLinkTo($v);

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
