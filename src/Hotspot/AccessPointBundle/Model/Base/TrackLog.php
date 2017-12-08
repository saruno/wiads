<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\TrackLog as ChildTrackLog;
use Hotspot\AccessPointBundle\Model\TrackLogQuery as ChildTrackLogQuery;
use Hotspot\AccessPointBundle\Model\Map\TrackLogTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'track_log' table.
 *
 *
 *
 * @package    propel.generator.src.Hotspot.AccessPointBundle.Model.Base
 */
abstract class TrackLog implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Hotspot\\AccessPointBundle\\Model\\Map\\TrackLogTableMap';


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
     * The value for the ads_id field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $ads_id;

    /**
     * The value for the ap_macaddr field.
     *
     * @var        string
     */
    protected $ap_macaddr;

    /**
     * The value for the device_macaddr field.
     *
     * @var        string
     */
    protected $device_macaddr;

    /**
     * The value for the device field.
     *
     * @var        string
     */
    protected $device;

    /**
     * The value for the wan_ip field.
     *
     * @var        string
     */
    protected $wan_ip;

    /**
     * The value for the device_ip field.
     *
     * @var        string
     */
    protected $device_ip;

    /**
     * The value for the ap_sessionid field.
     *
     * @var        string
     */
    protected $ap_sessionid;

    /**
     * The value for the web_session field.
     *
     * @var        string
     */
    protected $web_session;

    /**
     * The value for the user_url field.
     *
     * @var        string
     */
    protected $user_url;

    /**
     * The value for the is_mobile field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $is_mobile;

    /**
     * The value for the os field.
     *
     * @var        string
     */
    protected $os;

    /**
     * The value for the browser field.
     *
     * @var        string
     */
    protected $browser;

    /**
     * The value for the user_agent field.
     *
     * @var        string
     */
    protected $user_agent;

    /**
     * The value for the phase field.
     *
     * @var        string
     */
    protected $phase;

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
        $this->ads_id = 0;
        $this->is_mobile = 0;
    }

    /**
     * Initializes internal state of Hotspot\AccessPointBundle\Model\Base\TrackLog object.
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
     * Compares this with another <code>TrackLog</code> instance.  If
     * <code>obj</code> is an instance of <code>TrackLog</code>, delegates to
     * <code>equals(TrackLog)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|TrackLog The current object, for fluid interface
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
     * Get the [ads_id] column value.
     *
     * @return int
     */
    public function getAdsId()
    {
        return $this->ads_id;
    }

    /**
     * Get the [ap_macaddr] column value.
     *
     * @return string
     */
    public function getApMacaddr()
    {
        return $this->ap_macaddr;
    }

    /**
     * Get the [device_macaddr] column value.
     *
     * @return string
     */
    public function getDeviceMacaddr()
    {
        return $this->device_macaddr;
    }

    /**
     * Get the [device] column value.
     *
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Get the [wan_ip] column value.
     *
     * @return string
     */
    public function getWanIp()
    {
        return $this->wan_ip;
    }

    /**
     * Get the [device_ip] column value.
     *
     * @return string
     */
    public function getDeviceIp()
    {
        return $this->device_ip;
    }

    /**
     * Get the [ap_sessionid] column value.
     *
     * @return string
     */
    public function getApSessionid()
    {
        return $this->ap_sessionid;
    }

    /**
     * Get the [web_session] column value.
     *
     * @return string
     */
    public function getWebSession()
    {
        return $this->web_session;
    }

    /**
     * Get the [user_url] column value.
     *
     * @return string
     */
    public function getUserUrl()
    {
        return $this->user_url;
    }

    /**
     * Get the [is_mobile] column value.
     *
     * @return int
     */
    public function getIsMobile()
    {
        return $this->is_mobile;
    }

    /**
     * Get the [os] column value.
     *
     * @return string
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * Get the [browser] column value.
     *
     * @return string
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Get the [user_agent] column value.
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->user_agent;
    }

    /**
     * Get the [phase] column value.
     *
     * @return string
     */
    public function getPhase()
    {
        return $this->phase;
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
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [ads_id] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setAdsId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ads_id !== $v) {
            $this->ads_id = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_ADS_ID] = true;
        }

        return $this;
    } // setAdsId()

    /**
     * Set the value of [ap_macaddr] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setApMacaddr($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ap_macaddr !== $v) {
            $this->ap_macaddr = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_AP_MACADDR] = true;
        }

        return $this;
    } // setApMacaddr()

    /**
     * Set the value of [device_macaddr] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setDeviceMacaddr($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->device_macaddr !== $v) {
            $this->device_macaddr = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_DEVICE_MACADDR] = true;
        }

        return $this;
    } // setDeviceMacaddr()

    /**
     * Set the value of [device] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setDevice($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->device !== $v) {
            $this->device = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_DEVICE] = true;
        }

        return $this;
    } // setDevice()

    /**
     * Set the value of [wan_ip] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setWanIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->wan_ip !== $v) {
            $this->wan_ip = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_WAN_IP] = true;
        }

        return $this;
    } // setWanIp()

    /**
     * Set the value of [device_ip] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setDeviceIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->device_ip !== $v) {
            $this->device_ip = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_DEVICE_IP] = true;
        }

        return $this;
    } // setDeviceIp()

    /**
     * Set the value of [ap_sessionid] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setApSessionid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ap_sessionid !== $v) {
            $this->ap_sessionid = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_AP_SESSIONID] = true;
        }

        return $this;
    } // setApSessionid()

    /**
     * Set the value of [web_session] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setWebSession($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->web_session !== $v) {
            $this->web_session = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_WEB_SESSION] = true;
        }

        return $this;
    } // setWebSession()

    /**
     * Set the value of [user_url] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setUserUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_url !== $v) {
            $this->user_url = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_USER_URL] = true;
        }

        return $this;
    } // setUserUrl()

    /**
     * Set the value of [is_mobile] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setIsMobile($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->is_mobile !== $v) {
            $this->is_mobile = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_IS_MOBILE] = true;
        }

        return $this;
    } // setIsMobile()

    /**
     * Set the value of [os] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setOs($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->os !== $v) {
            $this->os = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_OS] = true;
        }

        return $this;
    } // setOs()

    /**
     * Set the value of [browser] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setBrowser($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->browser !== $v) {
            $this->browser = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_BROWSER] = true;
        }

        return $this;
    } // setBrowser()

    /**
     * Set the value of [user_agent] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setUserAgent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_agent !== $v) {
            $this->user_agent = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_USER_AGENT] = true;
        }

        return $this;
    } // setUserAgent()

    /**
     * Set the value of [phase] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setPhase($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phase !== $v) {
            $this->phase = $v;
            $this->modifiedColumns[TrackLogTableMap::COL_PHASE] = true;
        }

        return $this;
    } // setPhase()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TrackLogTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TrackLogTableMap::COL_UPDATED_AT] = true;
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
            if ($this->ads_id !== 0) {
                return false;
            }

            if ($this->is_mobile !== 0) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TrackLogTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TrackLogTableMap::translateFieldName('AdsId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ads_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TrackLogTableMap::translateFieldName('ApMacaddr', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ap_macaddr = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TrackLogTableMap::translateFieldName('DeviceMacaddr', TableMap::TYPE_PHPNAME, $indexType)];
            $this->device_macaddr = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TrackLogTableMap::translateFieldName('Device', TableMap::TYPE_PHPNAME, $indexType)];
            $this->device = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TrackLogTableMap::translateFieldName('WanIp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->wan_ip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TrackLogTableMap::translateFieldName('DeviceIp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->device_ip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TrackLogTableMap::translateFieldName('ApSessionid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ap_sessionid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : TrackLogTableMap::translateFieldName('WebSession', TableMap::TYPE_PHPNAME, $indexType)];
            $this->web_session = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : TrackLogTableMap::translateFieldName('UserUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : TrackLogTableMap::translateFieldName('IsMobile', TableMap::TYPE_PHPNAME, $indexType)];
            $this->is_mobile = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : TrackLogTableMap::translateFieldName('Os', TableMap::TYPE_PHPNAME, $indexType)];
            $this->os = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : TrackLogTableMap::translateFieldName('Browser', TableMap::TYPE_PHPNAME, $indexType)];
            $this->browser = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : TrackLogTableMap::translateFieldName('UserAgent', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_agent = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : TrackLogTableMap::translateFieldName('Phase', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phase = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : TrackLogTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : TrackLogTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 17; // 17 = TrackLogTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Hotspot\\AccessPointBundle\\Model\\TrackLog'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(TrackLogTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTrackLogQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see TrackLog::setDeleted()
     * @see TrackLog::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TrackLogTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTrackLogQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(TrackLogTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(TrackLogTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(TrackLogTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(TrackLogTableMap::COL_UPDATED_AT)) {
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
                TrackLogTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[TrackLogTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TrackLogTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TrackLogTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_ADS_ID)) {
            $modifiedColumns[':p' . $index++]  = '`ads_id`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_AP_MACADDR)) {
            $modifiedColumns[':p' . $index++]  = '`ap_macaddr`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_DEVICE_MACADDR)) {
            $modifiedColumns[':p' . $index++]  = '`device_macaddr`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_DEVICE)) {
            $modifiedColumns[':p' . $index++]  = '`device`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_WAN_IP)) {
            $modifiedColumns[':p' . $index++]  = '`wan_ip`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_DEVICE_IP)) {
            $modifiedColumns[':p' . $index++]  = '`device_ip`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_AP_SESSIONID)) {
            $modifiedColumns[':p' . $index++]  = '`ap_sessionid`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_WEB_SESSION)) {
            $modifiedColumns[':p' . $index++]  = '`web_session`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_USER_URL)) {
            $modifiedColumns[':p' . $index++]  = '`user_url`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_IS_MOBILE)) {
            $modifiedColumns[':p' . $index++]  = '`is_mobile`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_OS)) {
            $modifiedColumns[':p' . $index++]  = '`os`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_BROWSER)) {
            $modifiedColumns[':p' . $index++]  = '`browser`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_USER_AGENT)) {
            $modifiedColumns[':p' . $index++]  = '`user_agent`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_PHASE)) {
            $modifiedColumns[':p' . $index++]  = '`phase`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `track_log` (%s) VALUES (%s)',
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
                    case '`ads_id`':
                        $stmt->bindValue($identifier, $this->ads_id, PDO::PARAM_INT);
                        break;
                    case '`ap_macaddr`':
                        $stmt->bindValue($identifier, $this->ap_macaddr, PDO::PARAM_STR);
                        break;
                    case '`device_macaddr`':
                        $stmt->bindValue($identifier, $this->device_macaddr, PDO::PARAM_STR);
                        break;
                    case '`device`':
                        $stmt->bindValue($identifier, $this->device, PDO::PARAM_STR);
                        break;
                    case '`wan_ip`':
                        $stmt->bindValue($identifier, $this->wan_ip, PDO::PARAM_STR);
                        break;
                    case '`device_ip`':
                        $stmt->bindValue($identifier, $this->device_ip, PDO::PARAM_STR);
                        break;
                    case '`ap_sessionid`':
                        $stmt->bindValue($identifier, $this->ap_sessionid, PDO::PARAM_STR);
                        break;
                    case '`web_session`':
                        $stmt->bindValue($identifier, $this->web_session, PDO::PARAM_STR);
                        break;
                    case '`user_url`':
                        $stmt->bindValue($identifier, $this->user_url, PDO::PARAM_STR);
                        break;
                    case '`is_mobile`':
                        $stmt->bindValue($identifier, $this->is_mobile, PDO::PARAM_INT);
                        break;
                    case '`os`':
                        $stmt->bindValue($identifier, $this->os, PDO::PARAM_STR);
                        break;
                    case '`browser`':
                        $stmt->bindValue($identifier, $this->browser, PDO::PARAM_STR);
                        break;
                    case '`user_agent`':
                        $stmt->bindValue($identifier, $this->user_agent, PDO::PARAM_STR);
                        break;
                    case '`phase`':
                        $stmt->bindValue($identifier, $this->phase, PDO::PARAM_STR);
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
        $pos = TrackLogTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getAdsId();
                break;
            case 2:
                return $this->getApMacaddr();
                break;
            case 3:
                return $this->getDeviceMacaddr();
                break;
            case 4:
                return $this->getDevice();
                break;
            case 5:
                return $this->getWanIp();
                break;
            case 6:
                return $this->getDeviceIp();
                break;
            case 7:
                return $this->getApSessionid();
                break;
            case 8:
                return $this->getWebSession();
                break;
            case 9:
                return $this->getUserUrl();
                break;
            case 10:
                return $this->getIsMobile();
                break;
            case 11:
                return $this->getOs();
                break;
            case 12:
                return $this->getBrowser();
                break;
            case 13:
                return $this->getUserAgent();
                break;
            case 14:
                return $this->getPhase();
                break;
            case 15:
                return $this->getCreatedAt();
                break;
            case 16:
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
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {

        if (isset($alreadyDumpedObjects['TrackLog'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['TrackLog'][$this->hashCode()] = true;
        $keys = TrackLogTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getAdsId(),
            $keys[2] => $this->getApMacaddr(),
            $keys[3] => $this->getDeviceMacaddr(),
            $keys[4] => $this->getDevice(),
            $keys[5] => $this->getWanIp(),
            $keys[6] => $this->getDeviceIp(),
            $keys[7] => $this->getApSessionid(),
            $keys[8] => $this->getWebSession(),
            $keys[9] => $this->getUserUrl(),
            $keys[10] => $this->getIsMobile(),
            $keys[11] => $this->getOs(),
            $keys[12] => $this->getBrowser(),
            $keys[13] => $this->getUserAgent(),
            $keys[14] => $this->getPhase(),
            $keys[15] => $this->getCreatedAt(),
            $keys[16] => $this->getUpdatedAt(),
        );
        if ($result[$keys[15]] instanceof \DateTimeInterface) {
            $result[$keys[15]] = $result[$keys[15]]->format('c');
        }

        if ($result[$keys[16]] instanceof \DateTimeInterface) {
            $result[$keys[16]] = $result[$keys[16]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
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
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TrackLogTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setAdsId($value);
                break;
            case 2:
                $this->setApMacaddr($value);
                break;
            case 3:
                $this->setDeviceMacaddr($value);
                break;
            case 4:
                $this->setDevice($value);
                break;
            case 5:
                $this->setWanIp($value);
                break;
            case 6:
                $this->setDeviceIp($value);
                break;
            case 7:
                $this->setApSessionid($value);
                break;
            case 8:
                $this->setWebSession($value);
                break;
            case 9:
                $this->setUserUrl($value);
                break;
            case 10:
                $this->setIsMobile($value);
                break;
            case 11:
                $this->setOs($value);
                break;
            case 12:
                $this->setBrowser($value);
                break;
            case 13:
                $this->setUserAgent($value);
                break;
            case 14:
                $this->setPhase($value);
                break;
            case 15:
                $this->setCreatedAt($value);
                break;
            case 16:
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
        $keys = TrackLogTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setAdsId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setApMacaddr($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDeviceMacaddr($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDevice($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setWanIp($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDeviceIp($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setApSessionid($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setWebSession($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setUserUrl($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setIsMobile($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setOs($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setBrowser($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setUserAgent($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setPhase($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setCreatedAt($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setUpdatedAt($arr[$keys[16]]);
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
     * @return $this|\Hotspot\AccessPointBundle\Model\TrackLog The current object, for fluid interface
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
        $criteria = new Criteria(TrackLogTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TrackLogTableMap::COL_ID)) {
            $criteria->add(TrackLogTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_ADS_ID)) {
            $criteria->add(TrackLogTableMap::COL_ADS_ID, $this->ads_id);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_AP_MACADDR)) {
            $criteria->add(TrackLogTableMap::COL_AP_MACADDR, $this->ap_macaddr);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_DEVICE_MACADDR)) {
            $criteria->add(TrackLogTableMap::COL_DEVICE_MACADDR, $this->device_macaddr);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_DEVICE)) {
            $criteria->add(TrackLogTableMap::COL_DEVICE, $this->device);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_WAN_IP)) {
            $criteria->add(TrackLogTableMap::COL_WAN_IP, $this->wan_ip);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_DEVICE_IP)) {
            $criteria->add(TrackLogTableMap::COL_DEVICE_IP, $this->device_ip);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_AP_SESSIONID)) {
            $criteria->add(TrackLogTableMap::COL_AP_SESSIONID, $this->ap_sessionid);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_WEB_SESSION)) {
            $criteria->add(TrackLogTableMap::COL_WEB_SESSION, $this->web_session);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_USER_URL)) {
            $criteria->add(TrackLogTableMap::COL_USER_URL, $this->user_url);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_IS_MOBILE)) {
            $criteria->add(TrackLogTableMap::COL_IS_MOBILE, $this->is_mobile);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_OS)) {
            $criteria->add(TrackLogTableMap::COL_OS, $this->os);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_BROWSER)) {
            $criteria->add(TrackLogTableMap::COL_BROWSER, $this->browser);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_USER_AGENT)) {
            $criteria->add(TrackLogTableMap::COL_USER_AGENT, $this->user_agent);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_PHASE)) {
            $criteria->add(TrackLogTableMap::COL_PHASE, $this->phase);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_CREATED_AT)) {
            $criteria->add(TrackLogTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(TrackLogTableMap::COL_UPDATED_AT)) {
            $criteria->add(TrackLogTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildTrackLogQuery::create();
        $criteria->add(TrackLogTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Hotspot\AccessPointBundle\Model\TrackLog (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAdsId($this->getAdsId());
        $copyObj->setApMacaddr($this->getApMacaddr());
        $copyObj->setDeviceMacaddr($this->getDeviceMacaddr());
        $copyObj->setDevice($this->getDevice());
        $copyObj->setWanIp($this->getWanIp());
        $copyObj->setDeviceIp($this->getDeviceIp());
        $copyObj->setApSessionid($this->getApSessionid());
        $copyObj->setWebSession($this->getWebSession());
        $copyObj->setUserUrl($this->getUserUrl());
        $copyObj->setIsMobile($this->getIsMobile());
        $copyObj->setOs($this->getOs());
        $copyObj->setBrowser($this->getBrowser());
        $copyObj->setUserAgent($this->getUserAgent());
        $copyObj->setPhase($this->getPhase());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
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
     * @return \Hotspot\AccessPointBundle\Model\TrackLog Clone of current object.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->ads_id = null;
        $this->ap_macaddr = null;
        $this->device_macaddr = null;
        $this->device = null;
        $this->wan_ip = null;
        $this->device_ip = null;
        $this->ap_sessionid = null;
        $this->web_session = null;
        $this->user_url = null;
        $this->is_mobile = null;
        $this->os = null;
        $this->browser = null;
        $this->user_agent = null;
        $this->phase = null;
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
        } // if ($deep)

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TrackLogTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildTrackLog The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[TrackLogTableMap::COL_UPDATED_AT] = true;

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
