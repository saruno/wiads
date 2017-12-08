<?php

namespace Common\DbBundle\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Common\DbBundle\Model\Advert as ChildAdvert;
use Common\DbBundle\Model\AdvertQuery as ChildAdvertQuery;
use Common\DbBundle\Model\Bundle as ChildBundle;
use Common\DbBundle\Model\BundleQuery as ChildBundleQuery;
use Common\DbBundle\Model\Comment as ChildComment;
use Common\DbBundle\Model\CommentQuery as ChildCommentQuery;
use Common\DbBundle\Model\Marker as ChildMarker;
use Common\DbBundle\Model\MarkerQuery as ChildMarkerQuery;
use Common\DbBundle\Model\Menu as ChildMenu;
use Common\DbBundle\Model\MenuQuery as ChildMenuQuery;
use Common\DbBundle\Model\News as ChildNews;
use Common\DbBundle\Model\NewsQuery as ChildNewsQuery;
use Common\DbBundle\Model\Place as ChildPlace;
use Common\DbBundle\Model\PlaceQuery as ChildPlaceQuery;
use Common\DbBundle\Model\Section as ChildSection;
use Common\DbBundle\Model\SectionI18n as ChildSectionI18n;
use Common\DbBundle\Model\SectionI18nQuery as ChildSectionI18nQuery;
use Common\DbBundle\Model\SectionQuery as ChildSectionQuery;
use Common\DbBundle\Model\Map\AdvertTableMap;
use Common\DbBundle\Model\Map\CommentTableMap;
use Common\DbBundle\Model\Map\MarkerTableMap;
use Common\DbBundle\Model\Map\MenuTableMap;
use Common\DbBundle\Model\Map\NewsTableMap;
use Common\DbBundle\Model\Map\PlaceTableMap;
use Common\DbBundle\Model\Map\SectionI18nTableMap;
use Common\DbBundle\Model\Map\SectionTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'section' table.
 *
 *
 *
 * @package    propel.generator.src.Common.DbBundle.Model.Base
 */
abstract class Section implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Common\\DbBundle\\Model\\Map\\SectionTableMap';


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
     * The value for the deep field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $deep;

    /**
     * The value for the parent field.
     *
     * Note: this column has a database default value of: -1
     * @var        int
     */
    protected $parent;

    /**
     * The value for the bundle_id field.
     *
     * Note: this column has a database default value of: -1
     * @var        int
     */
    protected $bundle_id;

    /**
     * The value for the orders field.
     *
     * @var        int
     */
    protected $orders;

    /**
     * The value for the can_delete field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $can_delete;

    /**
     * The value for the locked field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $locked;

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
     * @var        ChildBundle
     */
    protected $aBundle;

    /**
     * @var        ObjectCollection|ChildNews[] Collection to store aggregation of ChildNews objects.
     */
    protected $collNews;
    protected $collNewsPartial;

    /**
     * @var        ObjectCollection|ChildComment[] Collection to store aggregation of ChildComment objects.
     */
    protected $collComments;
    protected $collCommentsPartial;

    /**
     * @var        ObjectCollection|ChildMenu[] Collection to store aggregation of ChildMenu objects.
     */
    protected $collMenus;
    protected $collMenusPartial;

    /**
     * @var        ObjectCollection|ChildAdvert[] Collection to store aggregation of ChildAdvert objects.
     */
    protected $collAdverts;
    protected $collAdvertsPartial;

    /**
     * @var        ObjectCollection|ChildPlace[] Collection to store aggregation of ChildPlace objects.
     */
    protected $collPlaces;
    protected $collPlacesPartial;

    /**
     * @var        ObjectCollection|ChildMarker[] Collection to store aggregation of ChildMarker objects.
     */
    protected $collMarkers;
    protected $collMarkersPartial;

    /**
     * @var        ObjectCollection|Accesspoint[] Collection to store aggregation of Accesspoint objects.
     */
    protected $collAccesspoints;
    protected $collAccesspointsPartial;

    /**
     * @var        ObjectCollection|ChildSectionI18n[] Collection to store aggregation of ChildSectionI18n objects.
     */
    protected $collSectionI18ns;
    protected $collSectionI18nsPartial;

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
     * @var        array[ChildSectionI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildNews[]
     */
    protected $newsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComment[]
     */
    protected $commentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMenu[]
     */
    protected $menusScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAdvert[]
     */
    protected $advertsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlace[]
     */
    protected $placesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMarker[]
     */
    protected $markersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|Accesspoint[]
     */
    protected $accesspointsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSectionI18n[]
     */
    protected $sectionI18nsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->deep = 0;
        $this->parent = -1;
        $this->bundle_id = -1;
        $this->can_delete = false;
        $this->locked = false;
    }

    /**
     * Initializes internal state of Common\DbBundle\Model\Base\Section object.
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
     * Compares this with another <code>Section</code> instance.  If
     * <code>obj</code> is an instance of <code>Section</code>, delegates to
     * <code>equals(Section)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Section The current object, for fluid interface
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
     * Get the [deep] column value.
     *
     * @return int
     */
    public function getDeep()
    {
        return $this->deep;
    }

    /**
     * Get the [parent] column value.
     *
     * @return int
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get the [bundle_id] column value.
     *
     * @return int
     */
    public function getBundleId()
    {
        return $this->bundle_id;
    }

    /**
     * Get the [orders] column value.
     *
     * @return int
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Get the [can_delete] column value.
     *
     * @return boolean
     */
    public function getCanDelete()
    {
        return $this->can_delete;
    }

    /**
     * Get the [can_delete] column value.
     *
     * @return boolean
     */
    public function isCanDelete()
    {
        return $this->getCanDelete();
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
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SectionTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [deep] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function setDeep($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->deep !== $v) {
            $this->deep = $v;
            $this->modifiedColumns[SectionTableMap::COL_DEEP] = true;
        }

        return $this;
    } // setDeep()

    /**
     * Set the value of [parent] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function setParent($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parent !== $v) {
            $this->parent = $v;
            $this->modifiedColumns[SectionTableMap::COL_PARENT] = true;
        }

        return $this;
    } // setParent()

    /**
     * Set the value of [bundle_id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function setBundleId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->bundle_id !== $v) {
            $this->bundle_id = $v;
            $this->modifiedColumns[SectionTableMap::COL_BUNDLE_ID] = true;
        }

        if ($this->aBundle !== null && $this->aBundle->getId() !== $v) {
            $this->aBundle = null;
        }

        return $this;
    } // setBundleId()

    /**
     * Set the value of [orders] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function setOrders($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->orders !== $v) {
            $this->orders = $v;
            $this->modifiedColumns[SectionTableMap::COL_ORDERS] = true;
        }

        return $this;
    } // setOrders()

    /**
     * Sets the value of the [can_delete] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function setCanDelete($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->can_delete !== $v) {
            $this->can_delete = $v;
            $this->modifiedColumns[SectionTableMap::COL_CAN_DELETE] = true;
        }

        return $this;
    } // setCanDelete()

    /**
     * Sets the value of the [locked] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
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
            $this->modifiedColumns[SectionTableMap::COL_LOCKED] = true;
        }

        return $this;
    } // setLocked()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SectionTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SectionTableMap::COL_UPDATED_AT] = true;
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
            if ($this->deep !== 0) {
                return false;
            }

            if ($this->parent !== -1) {
                return false;
            }

            if ($this->bundle_id !== -1) {
                return false;
            }

            if ($this->can_delete !== false) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SectionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SectionTableMap::translateFieldName('Deep', TableMap::TYPE_PHPNAME, $indexType)];
            $this->deep = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SectionTableMap::translateFieldName('Parent', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parent = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SectionTableMap::translateFieldName('BundleId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bundle_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SectionTableMap::translateFieldName('Orders', TableMap::TYPE_PHPNAME, $indexType)];
            $this->orders = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SectionTableMap::translateFieldName('CanDelete', TableMap::TYPE_PHPNAME, $indexType)];
            $this->can_delete = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SectionTableMap::translateFieldName('Locked', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locked = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SectionTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : SectionTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = SectionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Common\\DbBundle\\Model\\Section'), 0, $e);
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
        if ($this->aBundle !== null && $this->bundle_id !== $this->aBundle->getId()) {
            $this->aBundle = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(SectionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSectionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBundle = null;
            $this->collNews = null;

            $this->collComments = null;

            $this->collMenus = null;

            $this->collAdverts = null;

            $this->collPlaces = null;

            $this->collMarkers = null;

            $this->collAccesspoints = null;

            $this->collSectionI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Section::setDeleted()
     * @see Section::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSectionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(SectionTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(SectionTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(SectionTableMap::COL_UPDATED_AT)) {
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
                SectionTableMap::addInstanceToPool($this);
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

            if ($this->aBundle !== null) {
                if ($this->aBundle->isModified() || $this->aBundle->isNew()) {
                    $affectedRows += $this->aBundle->save($con);
                }
                $this->setBundle($this->aBundle);
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

            if ($this->newsScheduledForDeletion !== null) {
                if (!$this->newsScheduledForDeletion->isEmpty()) {
                    foreach ($this->newsScheduledForDeletion as $news) {
                        // need to save related object because we set the relation to null
                        $news->save($con);
                    }
                    $this->newsScheduledForDeletion = null;
                }
            }

            if ($this->collNews !== null) {
                foreach ($this->collNews as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->commentsScheduledForDeletion !== null) {
                if (!$this->commentsScheduledForDeletion->isEmpty()) {
                    foreach ($this->commentsScheduledForDeletion as $comment) {
                        // need to save related object because we set the relation to null
                        $comment->save($con);
                    }
                    $this->commentsScheduledForDeletion = null;
                }
            }

            if ($this->collComments !== null) {
                foreach ($this->collComments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->menusScheduledForDeletion !== null) {
                if (!$this->menusScheduledForDeletion->isEmpty()) {
                    foreach ($this->menusScheduledForDeletion as $menu) {
                        // need to save related object because we set the relation to null
                        $menu->save($con);
                    }
                    $this->menusScheduledForDeletion = null;
                }
            }

            if ($this->collMenus !== null) {
                foreach ($this->collMenus as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

            if ($this->placesScheduledForDeletion !== null) {
                if (!$this->placesScheduledForDeletion->isEmpty()) {
                    foreach ($this->placesScheduledForDeletion as $place) {
                        // need to save related object because we set the relation to null
                        $place->save($con);
                    }
                    $this->placesScheduledForDeletion = null;
                }
            }

            if ($this->collPlaces !== null) {
                foreach ($this->collPlaces as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->markersScheduledForDeletion !== null) {
                if (!$this->markersScheduledForDeletion->isEmpty()) {
                    foreach ($this->markersScheduledForDeletion as $marker) {
                        // need to save related object because we set the relation to null
                        $marker->save($con);
                    }
                    $this->markersScheduledForDeletion = null;
                }
            }

            if ($this->collMarkers !== null) {
                foreach ($this->collMarkers as $referrerFK) {
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

            if ($this->sectionI18nsScheduledForDeletion !== null) {
                if (!$this->sectionI18nsScheduledForDeletion->isEmpty()) {
                    \Common\DbBundle\Model\SectionI18nQuery::create()
                        ->filterByPrimaryKeys($this->sectionI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sectionI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collSectionI18ns !== null) {
                foreach ($this->collSectionI18ns as $referrerFK) {
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

        $this->modifiedColumns[SectionTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SectionTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SectionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(SectionTableMap::COL_DEEP)) {
            $modifiedColumns[':p' . $index++]  = '`deep`';
        }
        if ($this->isColumnModified(SectionTableMap::COL_PARENT)) {
            $modifiedColumns[':p' . $index++]  = '`parent`';
        }
        if ($this->isColumnModified(SectionTableMap::COL_BUNDLE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`bundle_id`';
        }
        if ($this->isColumnModified(SectionTableMap::COL_ORDERS)) {
            $modifiedColumns[':p' . $index++]  = '`orders`';
        }
        if ($this->isColumnModified(SectionTableMap::COL_CAN_DELETE)) {
            $modifiedColumns[':p' . $index++]  = '`can_delete`';
        }
        if ($this->isColumnModified(SectionTableMap::COL_LOCKED)) {
            $modifiedColumns[':p' . $index++]  = '`locked`';
        }
        if ($this->isColumnModified(SectionTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(SectionTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `section` (%s) VALUES (%s)',
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
                    case '`deep`':
                        $stmt->bindValue($identifier, $this->deep, PDO::PARAM_INT);
                        break;
                    case '`parent`':
                        $stmt->bindValue($identifier, $this->parent, PDO::PARAM_INT);
                        break;
                    case '`bundle_id`':
                        $stmt->bindValue($identifier, $this->bundle_id, PDO::PARAM_INT);
                        break;
                    case '`orders`':
                        $stmt->bindValue($identifier, $this->orders, PDO::PARAM_INT);
                        break;
                    case '`can_delete`':
                        $stmt->bindValue($identifier, (int) $this->can_delete, PDO::PARAM_INT);
                        break;
                    case '`locked`':
                        $stmt->bindValue($identifier, (int) $this->locked, PDO::PARAM_INT);
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
        $pos = SectionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getDeep();
                break;
            case 2:
                return $this->getParent();
                break;
            case 3:
                return $this->getBundleId();
                break;
            case 4:
                return $this->getOrders();
                break;
            case 5:
                return $this->getCanDelete();
                break;
            case 6:
                return $this->getLocked();
                break;
            case 7:
                return $this->getCreatedAt();
                break;
            case 8:
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

        if (isset($alreadyDumpedObjects['Section'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Section'][$this->hashCode()] = true;
        $keys = SectionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getDeep(),
            $keys[2] => $this->getParent(),
            $keys[3] => $this->getBundleId(),
            $keys[4] => $this->getOrders(),
            $keys[5] => $this->getCanDelete(),
            $keys[6] => $this->getLocked(),
            $keys[7] => $this->getCreatedAt(),
            $keys[8] => $this->getUpdatedAt(),
        );
        if ($result[$keys[7]] instanceof \DateTimeInterface) {
            $result[$keys[7]] = $result[$keys[7]]->format('c');
        }

        if ($result[$keys[8]] instanceof \DateTimeInterface) {
            $result[$keys[8]] = $result[$keys[8]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aBundle) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bundle';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'bundle';
                        break;
                    default:
                        $key = 'Bundle';
                }

                $result[$key] = $this->aBundle->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collNews) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'news';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'news';
                        break;
                    default:
                        $key = 'News';
                }

                $result[$key] = $this->collNews->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collComments) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'comments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'comments';
                        break;
                    default:
                        $key = 'Comments';
                }

                $result[$key] = $this->collComments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMenus) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'menus';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'menus';
                        break;
                    default:
                        $key = 'Menus';
                }

                $result[$key] = $this->collMenus->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
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
            if (null !== $this->collPlaces) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'places';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'places';
                        break;
                    default:
                        $key = 'Places';
                }

                $result[$key] = $this->collPlaces->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMarkers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'markers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'markers';
                        break;
                    default:
                        $key = 'Markers';
                }

                $result[$key] = $this->collMarkers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collSectionI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sectionI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'section_i18ns';
                        break;
                    default:
                        $key = 'SectionI18ns';
                }

                $result[$key] = $this->collSectionI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Common\DbBundle\Model\Section
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SectionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Common\DbBundle\Model\Section
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setDeep($value);
                break;
            case 2:
                $this->setParent($value);
                break;
            case 3:
                $this->setBundleId($value);
                break;
            case 4:
                $this->setOrders($value);
                break;
            case 5:
                $this->setCanDelete($value);
                break;
            case 6:
                $this->setLocked($value);
                break;
            case 7:
                $this->setCreatedAt($value);
                break;
            case 8:
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
        $keys = SectionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDeep($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setParent($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setBundleId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setOrders($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCanDelete($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setLocked($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCreatedAt($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setUpdatedAt($arr[$keys[8]]);
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
     * @return $this|\Common\DbBundle\Model\Section The current object, for fluid interface
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
        $criteria = new Criteria(SectionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SectionTableMap::COL_ID)) {
            $criteria->add(SectionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SectionTableMap::COL_DEEP)) {
            $criteria->add(SectionTableMap::COL_DEEP, $this->deep);
        }
        if ($this->isColumnModified(SectionTableMap::COL_PARENT)) {
            $criteria->add(SectionTableMap::COL_PARENT, $this->parent);
        }
        if ($this->isColumnModified(SectionTableMap::COL_BUNDLE_ID)) {
            $criteria->add(SectionTableMap::COL_BUNDLE_ID, $this->bundle_id);
        }
        if ($this->isColumnModified(SectionTableMap::COL_ORDERS)) {
            $criteria->add(SectionTableMap::COL_ORDERS, $this->orders);
        }
        if ($this->isColumnModified(SectionTableMap::COL_CAN_DELETE)) {
            $criteria->add(SectionTableMap::COL_CAN_DELETE, $this->can_delete);
        }
        if ($this->isColumnModified(SectionTableMap::COL_LOCKED)) {
            $criteria->add(SectionTableMap::COL_LOCKED, $this->locked);
        }
        if ($this->isColumnModified(SectionTableMap::COL_CREATED_AT)) {
            $criteria->add(SectionTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(SectionTableMap::COL_UPDATED_AT)) {
            $criteria->add(SectionTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildSectionQuery::create();
        $criteria->add(SectionTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Common\DbBundle\Model\Section (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDeep($this->getDeep());
        $copyObj->setParent($this->getParent());
        $copyObj->setBundleId($this->getBundleId());
        $copyObj->setOrders($this->getOrders());
        $copyObj->setCanDelete($this->getCanDelete());
        $copyObj->setLocked($this->getLocked());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getNews() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addNews($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getComments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMenus() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMenu($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdverts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvert($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPlaces() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlace($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMarkers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMarker($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAccesspoints() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccesspoint($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSectionI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSectionI18n($relObj->copy($deepCopy));
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
     * @return \Common\DbBundle\Model\Section Clone of current object.
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
     * Declares an association between this object and a ChildBundle object.
     *
     * @param  ChildBundle $v
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBundle(ChildBundle $v = null)
    {
        if ($v === null) {
            $this->setBundleId(-1);
        } else {
            $this->setBundleId($v->getId());
        }

        $this->aBundle = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBundle object, it will not be re-added.
        if ($v !== null) {
            $v->addSection($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildBundle object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildBundle The associated ChildBundle object.
     * @throws PropelException
     */
    public function getBundle(ConnectionInterface $con = null)
    {
        if ($this->aBundle === null && ($this->bundle_id !== null)) {
            $this->aBundle = ChildBundleQuery::create()->findPk($this->bundle_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBundle->addSections($this);
             */
        }

        return $this->aBundle;
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
        if ('News' == $relationName) {
            $this->initNews();
            return;
        }
        if ('Comment' == $relationName) {
            $this->initComments();
            return;
        }
        if ('Menu' == $relationName) {
            $this->initMenus();
            return;
        }
        if ('Advert' == $relationName) {
            $this->initAdverts();
            return;
        }
        if ('Place' == $relationName) {
            $this->initPlaces();
            return;
        }
        if ('Marker' == $relationName) {
            $this->initMarkers();
            return;
        }
        if ('Accesspoint' == $relationName) {
            $this->initAccesspoints();
            return;
        }
        if ('SectionI18n' == $relationName) {
            $this->initSectionI18ns();
            return;
        }
    }

    /**
     * Clears out the collNews collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addNews()
     */
    public function clearNews()
    {
        $this->collNews = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collNews collection loaded partially.
     */
    public function resetPartialNews($v = true)
    {
        $this->collNewsPartial = $v;
    }

    /**
     * Initializes the collNews collection.
     *
     * By default this just sets the collNews collection to an empty array (like clearcollNews());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initNews($overrideExisting = true)
    {
        if (null !== $this->collNews && !$overrideExisting) {
            return;
        }

        $collectionClassName = NewsTableMap::getTableMap()->getCollectionClassName();

        $this->collNews = new $collectionClassName;
        $this->collNews->setModel('\Common\DbBundle\Model\News');
    }

    /**
     * Gets an array of ChildNews objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSection is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildNews[] List of ChildNews objects
     * @throws PropelException
     */
    public function getNews(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collNewsPartial && !$this->isNew();
        if (null === $this->collNews || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collNews) {
                // return empty collection
                $this->initNews();
            } else {
                $collNews = ChildNewsQuery::create(null, $criteria)
                    ->filterBySection($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collNewsPartial && count($collNews)) {
                        $this->initNews(false);

                        foreach ($collNews as $obj) {
                            if (false == $this->collNews->contains($obj)) {
                                $this->collNews->append($obj);
                            }
                        }

                        $this->collNewsPartial = true;
                    }

                    return $collNews;
                }

                if ($partial && $this->collNews) {
                    foreach ($this->collNews as $obj) {
                        if ($obj->isNew()) {
                            $collNews[] = $obj;
                        }
                    }
                }

                $this->collNews = $collNews;
                $this->collNewsPartial = false;
            }
        }

        return $this->collNews;
    }

    /**
     * Sets a collection of ChildNews objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $news A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function setNews(Collection $news, ConnectionInterface $con = null)
    {
        /** @var ChildNews[] $newsToDelete */
        $newsToDelete = $this->getNews(new Criteria(), $con)->diff($news);


        $this->newsScheduledForDeletion = $newsToDelete;

        foreach ($newsToDelete as $newsRemoved) {
            $newsRemoved->setSection(null);
        }

        $this->collNews = null;
        foreach ($news as $news) {
            $this->addNews($news);
        }

        $this->collNews = $news;
        $this->collNewsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related News objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related News objects.
     * @throws PropelException
     */
    public function countNews(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collNewsPartial && !$this->isNew();
        if (null === $this->collNews || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collNews) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getNews());
            }

            $query = ChildNewsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySection($this)
                ->count($con);
        }

        return count($this->collNews);
    }

    /**
     * Method called to associate a ChildNews object to this object
     * through the ChildNews foreign key attribute.
     *
     * @param  ChildNews $l ChildNews
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function addNews(ChildNews $l)
    {
        if ($this->collNews === null) {
            $this->initNews();
            $this->collNewsPartial = true;
        }

        if (!$this->collNews->contains($l)) {
            $this->doAddNews($l);

            if ($this->newsScheduledForDeletion and $this->newsScheduledForDeletion->contains($l)) {
                $this->newsScheduledForDeletion->remove($this->newsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildNews $news The ChildNews object to add.
     */
    protected function doAddNews(ChildNews $news)
    {
        $this->collNews[]= $news;
        $news->setSection($this);
    }

    /**
     * @param  ChildNews $news The ChildNews object to remove.
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function removeNews(ChildNews $news)
    {
        if ($this->getNews()->contains($news)) {
            $pos = $this->collNews->search($news);
            $this->collNews->remove($pos);
            if (null === $this->newsScheduledForDeletion) {
                $this->newsScheduledForDeletion = clone $this->collNews;
                $this->newsScheduledForDeletion->clear();
            }
            $this->newsScheduledForDeletion[]= $news;
            $news->setSection(null);
        }

        return $this;
    }

    /**
     * Clears out the collComments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addComments()
     */
    public function clearComments()
    {
        $this->collComments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collComments collection loaded partially.
     */
    public function resetPartialComments($v = true)
    {
        $this->collCommentsPartial = $v;
    }

    /**
     * Initializes the collComments collection.
     *
     * By default this just sets the collComments collection to an empty array (like clearcollComments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initComments($overrideExisting = true)
    {
        if (null !== $this->collComments && !$overrideExisting) {
            return;
        }

        $collectionClassName = CommentTableMap::getTableMap()->getCollectionClassName();

        $this->collComments = new $collectionClassName;
        $this->collComments->setModel('\Common\DbBundle\Model\Comment');
    }

    /**
     * Gets an array of ChildComment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSection is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     * @throws PropelException
     */
    public function getComments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsPartial && !$this->isNew();
        if (null === $this->collComments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collComments) {
                // return empty collection
                $this->initComments();
            } else {
                $collComments = ChildCommentQuery::create(null, $criteria)
                    ->filterBySection($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentsPartial && count($collComments)) {
                        $this->initComments(false);

                        foreach ($collComments as $obj) {
                            if (false == $this->collComments->contains($obj)) {
                                $this->collComments->append($obj);
                            }
                        }

                        $this->collCommentsPartial = true;
                    }

                    return $collComments;
                }

                if ($partial && $this->collComments) {
                    foreach ($this->collComments as $obj) {
                        if ($obj->isNew()) {
                            $collComments[] = $obj;
                        }
                    }
                }

                $this->collComments = $collComments;
                $this->collCommentsPartial = false;
            }
        }

        return $this->collComments;
    }

    /**
     * Sets a collection of ChildComment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $comments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function setComments(Collection $comments, ConnectionInterface $con = null)
    {
        /** @var ChildComment[] $commentsToDelete */
        $commentsToDelete = $this->getComments(new Criteria(), $con)->diff($comments);


        $this->commentsScheduledForDeletion = $commentsToDelete;

        foreach ($commentsToDelete as $commentRemoved) {
            $commentRemoved->setSection(null);
        }

        $this->collComments = null;
        foreach ($comments as $comment) {
            $this->addComment($comment);
        }

        $this->collComments = $comments;
        $this->collCommentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Comment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Comment objects.
     * @throws PropelException
     */
    public function countComments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsPartial && !$this->isNew();
        if (null === $this->collComments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collComments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getComments());
            }

            $query = ChildCommentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySection($this)
                ->count($con);
        }

        return count($this->collComments);
    }

    /**
     * Method called to associate a ChildComment object to this object
     * through the ChildComment foreign key attribute.
     *
     * @param  ChildComment $l ChildComment
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function addComment(ChildComment $l)
    {
        if ($this->collComments === null) {
            $this->initComments();
            $this->collCommentsPartial = true;
        }

        if (!$this->collComments->contains($l)) {
            $this->doAddComment($l);

            if ($this->commentsScheduledForDeletion and $this->commentsScheduledForDeletion->contains($l)) {
                $this->commentsScheduledForDeletion->remove($this->commentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildComment $comment The ChildComment object to add.
     */
    protected function doAddComment(ChildComment $comment)
    {
        $this->collComments[]= $comment;
        $comment->setSection($this);
    }

    /**
     * @param  ChildComment $comment The ChildComment object to remove.
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function removeComment(ChildComment $comment)
    {
        if ($this->getComments()->contains($comment)) {
            $pos = $this->collComments->search($comment);
            $this->collComments->remove($pos);
            if (null === $this->commentsScheduledForDeletion) {
                $this->commentsScheduledForDeletion = clone $this->collComments;
                $this->commentsScheduledForDeletion->clear();
            }
            $this->commentsScheduledForDeletion[]= $comment;
            $comment->setSection(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related Comments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsJoinNews(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('News', $joinBehavior);

        return $this->getComments($query, $con);
    }

    /**
     * Clears out the collMenus collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMenus()
     */
    public function clearMenus()
    {
        $this->collMenus = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMenus collection loaded partially.
     */
    public function resetPartialMenus($v = true)
    {
        $this->collMenusPartial = $v;
    }

    /**
     * Initializes the collMenus collection.
     *
     * By default this just sets the collMenus collection to an empty array (like clearcollMenus());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMenus($overrideExisting = true)
    {
        if (null !== $this->collMenus && !$overrideExisting) {
            return;
        }

        $collectionClassName = MenuTableMap::getTableMap()->getCollectionClassName();

        $this->collMenus = new $collectionClassName;
        $this->collMenus->setModel('\Common\DbBundle\Model\Menu');
    }

    /**
     * Gets an array of ChildMenu objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSection is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMenu[] List of ChildMenu objects
     * @throws PropelException
     */
    public function getMenus(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMenusPartial && !$this->isNew();
        if (null === $this->collMenus || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMenus) {
                // return empty collection
                $this->initMenus();
            } else {
                $collMenus = ChildMenuQuery::create(null, $criteria)
                    ->filterBySection($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMenusPartial && count($collMenus)) {
                        $this->initMenus(false);

                        foreach ($collMenus as $obj) {
                            if (false == $this->collMenus->contains($obj)) {
                                $this->collMenus->append($obj);
                            }
                        }

                        $this->collMenusPartial = true;
                    }

                    return $collMenus;
                }

                if ($partial && $this->collMenus) {
                    foreach ($this->collMenus as $obj) {
                        if ($obj->isNew()) {
                            $collMenus[] = $obj;
                        }
                    }
                }

                $this->collMenus = $collMenus;
                $this->collMenusPartial = false;
            }
        }

        return $this->collMenus;
    }

    /**
     * Sets a collection of ChildMenu objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $menus A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function setMenus(Collection $menus, ConnectionInterface $con = null)
    {
        /** @var ChildMenu[] $menusToDelete */
        $menusToDelete = $this->getMenus(new Criteria(), $con)->diff($menus);


        $this->menusScheduledForDeletion = $menusToDelete;

        foreach ($menusToDelete as $menuRemoved) {
            $menuRemoved->setSection(null);
        }

        $this->collMenus = null;
        foreach ($menus as $menu) {
            $this->addMenu($menu);
        }

        $this->collMenus = $menus;
        $this->collMenusPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Menu objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Menu objects.
     * @throws PropelException
     */
    public function countMenus(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMenusPartial && !$this->isNew();
        if (null === $this->collMenus || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMenus) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMenus());
            }

            $query = ChildMenuQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySection($this)
                ->count($con);
        }

        return count($this->collMenus);
    }

    /**
     * Method called to associate a ChildMenu object to this object
     * through the ChildMenu foreign key attribute.
     *
     * @param  ChildMenu $l ChildMenu
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function addMenu(ChildMenu $l)
    {
        if ($this->collMenus === null) {
            $this->initMenus();
            $this->collMenusPartial = true;
        }

        if (!$this->collMenus->contains($l)) {
            $this->doAddMenu($l);

            if ($this->menusScheduledForDeletion and $this->menusScheduledForDeletion->contains($l)) {
                $this->menusScheduledForDeletion->remove($this->menusScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMenu $menu The ChildMenu object to add.
     */
    protected function doAddMenu(ChildMenu $menu)
    {
        $this->collMenus[]= $menu;
        $menu->setSection($this);
    }

    /**
     * @param  ChildMenu $menu The ChildMenu object to remove.
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function removeMenu(ChildMenu $menu)
    {
        if ($this->getMenus()->contains($menu)) {
            $pos = $this->collMenus->search($menu);
            $this->collMenus->remove($pos);
            if (null === $this->menusScheduledForDeletion) {
                $this->menusScheduledForDeletion = clone $this->collMenus;
                $this->menusScheduledForDeletion->clear();
            }
            $this->menusScheduledForDeletion[]= $menu;
            $menu->setSection(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related Menus from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMenu[] List of ChildMenu objects
     */
    public function getMenusJoinBundle(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMenuQuery::create(null, $criteria);
        $query->joinWith('Bundle', $joinBehavior);

        return $this->getMenus($query, $con);
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
     * If this ChildSection is new, it will return
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
                    ->filterBySection($this)
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
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function setAdverts(Collection $adverts, ConnectionInterface $con = null)
    {
        /** @var ChildAdvert[] $advertsToDelete */
        $advertsToDelete = $this->getAdverts(new Criteria(), $con)->diff($adverts);


        $this->advertsScheduledForDeletion = $advertsToDelete;

        foreach ($advertsToDelete as $advertRemoved) {
            $advertRemoved->setSection(null);
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
                ->filterBySection($this)
                ->count($con);
        }

        return count($this->collAdverts);
    }

    /**
     * Method called to associate a ChildAdvert object to this object
     * through the ChildAdvert foreign key attribute.
     *
     * @param  ChildAdvert $l ChildAdvert
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
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
        $advert->setSection($this);
    }

    /**
     * @param  ChildAdvert $advert The ChildAdvert object to remove.
     * @return $this|ChildSection The current object (for fluent API support)
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
            $advert->setSection(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related Adverts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAdvert[] List of ChildAdvert objects
     */
    public function getAdvertsJoinCustomer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAdvertQuery::create(null, $criteria);
        $query->joinWith('Customer', $joinBehavior);

        return $this->getAdverts($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related Adverts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
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
     * Clears out the collPlaces collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPlaces()
     */
    public function clearPlaces()
    {
        $this->collPlaces = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPlaces collection loaded partially.
     */
    public function resetPartialPlaces($v = true)
    {
        $this->collPlacesPartial = $v;
    }

    /**
     * Initializes the collPlaces collection.
     *
     * By default this just sets the collPlaces collection to an empty array (like clearcollPlaces());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPlaces($overrideExisting = true)
    {
        if (null !== $this->collPlaces && !$overrideExisting) {
            return;
        }

        $collectionClassName = PlaceTableMap::getTableMap()->getCollectionClassName();

        $this->collPlaces = new $collectionClassName;
        $this->collPlaces->setModel('\Common\DbBundle\Model\Place');
    }

    /**
     * Gets an array of ChildPlace objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSection is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPlace[] List of ChildPlace objects
     * @throws PropelException
     */
    public function getPlaces(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPlacesPartial && !$this->isNew();
        if (null === $this->collPlaces || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPlaces) {
                // return empty collection
                $this->initPlaces();
            } else {
                $collPlaces = ChildPlaceQuery::create(null, $criteria)
                    ->filterBySection($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPlacesPartial && count($collPlaces)) {
                        $this->initPlaces(false);

                        foreach ($collPlaces as $obj) {
                            if (false == $this->collPlaces->contains($obj)) {
                                $this->collPlaces->append($obj);
                            }
                        }

                        $this->collPlacesPartial = true;
                    }

                    return $collPlaces;
                }

                if ($partial && $this->collPlaces) {
                    foreach ($this->collPlaces as $obj) {
                        if ($obj->isNew()) {
                            $collPlaces[] = $obj;
                        }
                    }
                }

                $this->collPlaces = $collPlaces;
                $this->collPlacesPartial = false;
            }
        }

        return $this->collPlaces;
    }

    /**
     * Sets a collection of ChildPlace objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $places A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function setPlaces(Collection $places, ConnectionInterface $con = null)
    {
        /** @var ChildPlace[] $placesToDelete */
        $placesToDelete = $this->getPlaces(new Criteria(), $con)->diff($places);


        $this->placesScheduledForDeletion = $placesToDelete;

        foreach ($placesToDelete as $placeRemoved) {
            $placeRemoved->setSection(null);
        }

        $this->collPlaces = null;
        foreach ($places as $place) {
            $this->addPlace($place);
        }

        $this->collPlaces = $places;
        $this->collPlacesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Place objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Place objects.
     * @throws PropelException
     */
    public function countPlaces(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPlacesPartial && !$this->isNew();
        if (null === $this->collPlaces || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPlaces) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPlaces());
            }

            $query = ChildPlaceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySection($this)
                ->count($con);
        }

        return count($this->collPlaces);
    }

    /**
     * Method called to associate a ChildPlace object to this object
     * through the ChildPlace foreign key attribute.
     *
     * @param  ChildPlace $l ChildPlace
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function addPlace(ChildPlace $l)
    {
        if ($this->collPlaces === null) {
            $this->initPlaces();
            $this->collPlacesPartial = true;
        }

        if (!$this->collPlaces->contains($l)) {
            $this->doAddPlace($l);

            if ($this->placesScheduledForDeletion and $this->placesScheduledForDeletion->contains($l)) {
                $this->placesScheduledForDeletion->remove($this->placesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPlace $place The ChildPlace object to add.
     */
    protected function doAddPlace(ChildPlace $place)
    {
        $this->collPlaces[]= $place;
        $place->setSection($this);
    }

    /**
     * @param  ChildPlace $place The ChildPlace object to remove.
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function removePlace(ChildPlace $place)
    {
        if ($this->getPlaces()->contains($place)) {
            $pos = $this->collPlaces->search($place);
            $this->collPlaces->remove($pos);
            if (null === $this->placesScheduledForDeletion) {
                $this->placesScheduledForDeletion = clone $this->collPlaces;
                $this->placesScheduledForDeletion->clear();
            }
            $this->placesScheduledForDeletion[]= $place;
            $place->setSection(null);
        }

        return $this;
    }

    /**
     * Clears out the collMarkers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMarkers()
     */
    public function clearMarkers()
    {
        $this->collMarkers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMarkers collection loaded partially.
     */
    public function resetPartialMarkers($v = true)
    {
        $this->collMarkersPartial = $v;
    }

    /**
     * Initializes the collMarkers collection.
     *
     * By default this just sets the collMarkers collection to an empty array (like clearcollMarkers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMarkers($overrideExisting = true)
    {
        if (null !== $this->collMarkers && !$overrideExisting) {
            return;
        }

        $collectionClassName = MarkerTableMap::getTableMap()->getCollectionClassName();

        $this->collMarkers = new $collectionClassName;
        $this->collMarkers->setModel('\Common\DbBundle\Model\Marker');
    }

    /**
     * Gets an array of ChildMarker objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSection is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMarker[] List of ChildMarker objects
     * @throws PropelException
     */
    public function getMarkers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMarkersPartial && !$this->isNew();
        if (null === $this->collMarkers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMarkers) {
                // return empty collection
                $this->initMarkers();
            } else {
                $collMarkers = ChildMarkerQuery::create(null, $criteria)
                    ->filterBySection($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMarkersPartial && count($collMarkers)) {
                        $this->initMarkers(false);

                        foreach ($collMarkers as $obj) {
                            if (false == $this->collMarkers->contains($obj)) {
                                $this->collMarkers->append($obj);
                            }
                        }

                        $this->collMarkersPartial = true;
                    }

                    return $collMarkers;
                }

                if ($partial && $this->collMarkers) {
                    foreach ($this->collMarkers as $obj) {
                        if ($obj->isNew()) {
                            $collMarkers[] = $obj;
                        }
                    }
                }

                $this->collMarkers = $collMarkers;
                $this->collMarkersPartial = false;
            }
        }

        return $this->collMarkers;
    }

    /**
     * Sets a collection of ChildMarker objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $markers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function setMarkers(Collection $markers, ConnectionInterface $con = null)
    {
        /** @var ChildMarker[] $markersToDelete */
        $markersToDelete = $this->getMarkers(new Criteria(), $con)->diff($markers);


        $this->markersScheduledForDeletion = $markersToDelete;

        foreach ($markersToDelete as $markerRemoved) {
            $markerRemoved->setSection(null);
        }

        $this->collMarkers = null;
        foreach ($markers as $marker) {
            $this->addMarker($marker);
        }

        $this->collMarkers = $markers;
        $this->collMarkersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Marker objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Marker objects.
     * @throws PropelException
     */
    public function countMarkers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMarkersPartial && !$this->isNew();
        if (null === $this->collMarkers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMarkers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMarkers());
            }

            $query = ChildMarkerQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySection($this)
                ->count($con);
        }

        return count($this->collMarkers);
    }

    /**
     * Method called to associate a ChildMarker object to this object
     * through the ChildMarker foreign key attribute.
     *
     * @param  ChildMarker $l ChildMarker
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function addMarker(ChildMarker $l)
    {
        if ($this->collMarkers === null) {
            $this->initMarkers();
            $this->collMarkersPartial = true;
        }

        if (!$this->collMarkers->contains($l)) {
            $this->doAddMarker($l);

            if ($this->markersScheduledForDeletion and $this->markersScheduledForDeletion->contains($l)) {
                $this->markersScheduledForDeletion->remove($this->markersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMarker $marker The ChildMarker object to add.
     */
    protected function doAddMarker(ChildMarker $marker)
    {
        $this->collMarkers[]= $marker;
        $marker->setSection($this);
    }

    /**
     * @param  ChildMarker $marker The ChildMarker object to remove.
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function removeMarker(ChildMarker $marker)
    {
        if ($this->getMarkers()->contains($marker)) {
            $pos = $this->collMarkers->search($marker);
            $this->collMarkers->remove($pos);
            if (null === $this->markersScheduledForDeletion) {
                $this->markersScheduledForDeletion = clone $this->collMarkers;
                $this->markersScheduledForDeletion->clear();
            }
            $this->markersScheduledForDeletion[]= $marker;
            $marker->setSection(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related Markers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMarker[] List of ChildMarker objects
     */
    public function getMarkersJoinMarkerCategory(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMarkerQuery::create(null, $criteria);
        $query->joinWith('MarkerCategory', $joinBehavior);

        return $this->getMarkers($query, $con);
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
     * If this ChildSection is new, it will return
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
                    ->filterBySection($this)
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
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function setAccesspoints(Collection $accesspoints, ConnectionInterface $con = null)
    {
        /** @var Accesspoint[] $accesspointsToDelete */
        $accesspointsToDelete = $this->getAccesspoints(new Criteria(), $con)->diff($accesspoints);


        $this->accesspointsScheduledForDeletion = $accesspointsToDelete;

        foreach ($accesspointsToDelete as $accesspointRemoved) {
            $accesspointRemoved->setSection(null);
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
                ->filterBySection($this)
                ->count($con);
        }

        return count($this->collAccesspoints);
    }

    /**
     * Method called to associate a Accesspoint object to this object
     * through the Accesspoint foreign key attribute.
     *
     * @param  Accesspoint $l Accesspoint
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
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
        $accesspoint->setSection($this);
    }

    /**
     * @param  Accesspoint $accesspoint The Accesspoint object to remove.
     * @return $this|ChildSection The current object (for fluent API support)
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
            $accesspoint->setSection(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related Accesspoints from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|Accesspoint[] List of Accesspoint objects
     */
    public function getAccesspointsJoinCustomer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = AccesspointQuery::create(null, $criteria);
        $query->joinWith('Customer', $joinBehavior);

        return $this->getAccesspoints($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Section is new, it will return
     * an empty collection; or if this Section has previously
     * been saved, it will retrieve related Accesspoints from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Section.
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
     * Clears out the collSectionI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSectionI18ns()
     */
    public function clearSectionI18ns()
    {
        $this->collSectionI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSectionI18ns collection loaded partially.
     */
    public function resetPartialSectionI18ns($v = true)
    {
        $this->collSectionI18nsPartial = $v;
    }

    /**
     * Initializes the collSectionI18ns collection.
     *
     * By default this just sets the collSectionI18ns collection to an empty array (like clearcollSectionI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSectionI18ns($overrideExisting = true)
    {
        if (null !== $this->collSectionI18ns && !$overrideExisting) {
            return;
        }

        $collectionClassName = SectionI18nTableMap::getTableMap()->getCollectionClassName();

        $this->collSectionI18ns = new $collectionClassName;
        $this->collSectionI18ns->setModel('\Common\DbBundle\Model\SectionI18n');
    }

    /**
     * Gets an array of ChildSectionI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSection is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSectionI18n[] List of ChildSectionI18n objects
     * @throws PropelException
     */
    public function getSectionI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionI18nsPartial && !$this->isNew();
        if (null === $this->collSectionI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSectionI18ns) {
                // return empty collection
                $this->initSectionI18ns();
            } else {
                $collSectionI18ns = ChildSectionI18nQuery::create(null, $criteria)
                    ->filterBySection($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSectionI18nsPartial && count($collSectionI18ns)) {
                        $this->initSectionI18ns(false);

                        foreach ($collSectionI18ns as $obj) {
                            if (false == $this->collSectionI18ns->contains($obj)) {
                                $this->collSectionI18ns->append($obj);
                            }
                        }

                        $this->collSectionI18nsPartial = true;
                    }

                    return $collSectionI18ns;
                }

                if ($partial && $this->collSectionI18ns) {
                    foreach ($this->collSectionI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collSectionI18ns[] = $obj;
                        }
                    }
                }

                $this->collSectionI18ns = $collSectionI18ns;
                $this->collSectionI18nsPartial = false;
            }
        }

        return $this->collSectionI18ns;
    }

    /**
     * Sets a collection of ChildSectionI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sectionI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function setSectionI18ns(Collection $sectionI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildSectionI18n[] $sectionI18nsToDelete */
        $sectionI18nsToDelete = $this->getSectionI18ns(new Criteria(), $con)->diff($sectionI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sectionI18nsScheduledForDeletion = clone $sectionI18nsToDelete;

        foreach ($sectionI18nsToDelete as $sectionI18nRemoved) {
            $sectionI18nRemoved->setSection(null);
        }

        $this->collSectionI18ns = null;
        foreach ($sectionI18ns as $sectionI18n) {
            $this->addSectionI18n($sectionI18n);
        }

        $this->collSectionI18ns = $sectionI18ns;
        $this->collSectionI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SectionI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SectionI18n objects.
     * @throws PropelException
     */
    public function countSectionI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionI18nsPartial && !$this->isNew();
        if (null === $this->collSectionI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSectionI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSectionI18ns());
            }

            $query = ChildSectionI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySection($this)
                ->count($con);
        }

        return count($this->collSectionI18ns);
    }

    /**
     * Method called to associate a ChildSectionI18n object to this object
     * through the ChildSectionI18n foreign key attribute.
     *
     * @param  ChildSectionI18n $l ChildSectionI18n
     * @return $this|\Common\DbBundle\Model\Section The current object (for fluent API support)
     */
    public function addSectionI18n(ChildSectionI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collSectionI18ns === null) {
            $this->initSectionI18ns();
            $this->collSectionI18nsPartial = true;
        }

        if (!$this->collSectionI18ns->contains($l)) {
            $this->doAddSectionI18n($l);

            if ($this->sectionI18nsScheduledForDeletion and $this->sectionI18nsScheduledForDeletion->contains($l)) {
                $this->sectionI18nsScheduledForDeletion->remove($this->sectionI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSectionI18n $sectionI18n The ChildSectionI18n object to add.
     */
    protected function doAddSectionI18n(ChildSectionI18n $sectionI18n)
    {
        $this->collSectionI18ns[]= $sectionI18n;
        $sectionI18n->setSection($this);
    }

    /**
     * @param  ChildSectionI18n $sectionI18n The ChildSectionI18n object to remove.
     * @return $this|ChildSection The current object (for fluent API support)
     */
    public function removeSectionI18n(ChildSectionI18n $sectionI18n)
    {
        if ($this->getSectionI18ns()->contains($sectionI18n)) {
            $pos = $this->collSectionI18ns->search($sectionI18n);
            $this->collSectionI18ns->remove($pos);
            if (null === $this->sectionI18nsScheduledForDeletion) {
                $this->sectionI18nsScheduledForDeletion = clone $this->collSectionI18ns;
                $this->sectionI18nsScheduledForDeletion->clear();
            }
            $this->sectionI18nsScheduledForDeletion[]= clone $sectionI18n;
            $sectionI18n->setSection(null);
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
        if (null !== $this->aBundle) {
            $this->aBundle->removeSection($this);
        }
        $this->id = null;
        $this->deep = null;
        $this->parent = null;
        $this->bundle_id = null;
        $this->orders = null;
        $this->can_delete = null;
        $this->locked = null;
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
            if ($this->collNews) {
                foreach ($this->collNews as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collComments) {
                foreach ($this->collComments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMenus) {
                foreach ($this->collMenus as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdverts) {
                foreach ($this->collAdverts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPlaces) {
                foreach ($this->collPlaces as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMarkers) {
                foreach ($this->collMarkers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAccesspoints) {
                foreach ($this->collAccesspoints as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSectionI18ns) {
                foreach ($this->collSectionI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'vi';
        $this->currentTranslations = null;

        $this->collNews = null;
        $this->collComments = null;
        $this->collMenus = null;
        $this->collAdverts = null;
        $this->collPlaces = null;
        $this->collMarkers = null;
        $this->collAccesspoints = null;
        $this->collSectionI18ns = null;
        $this->aBundle = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SectionTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildSection The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[SectionTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildSection The current object (for fluent API support)
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
     * @return ChildSectionI18n */
    public function getTranslation($locale = 'vi', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collSectionI18ns) {
                foreach ($this->collSectionI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildSectionI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildSectionI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addSectionI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildSection The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'vi', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildSectionI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collSectionI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collSectionI18ns[$key]);
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
     * @return ChildSectionI18n */
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
         * @return $this|\Common\DbBundle\Model\SectionI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\SectionI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\SectionI18n The current object (for fluent API support)
         */
        public function setBrief($v)
        {    $this->getCurrentTranslation()->setBrief($v);

        return $this;
    }


        /**
         * Get the [content] column value.
         *
         * @return string
         */
        public function getContent()
        {
        return $this->getCurrentTranslation()->getContent();
    }


        /**
         * Set the value of [content] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\SectionI18n The current object (for fluent API support)
         */
        public function setContent($v)
        {    $this->getCurrentTranslation()->setContent($v);

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
         * @return $this|\Common\DbBundle\Model\SectionI18n The current object (for fluent API support)
         */
        public function setLink($v)
        {    $this->getCurrentTranslation()->setLink($v);

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
