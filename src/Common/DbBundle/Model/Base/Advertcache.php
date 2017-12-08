<?php

namespace Common\DbBundle\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Common\DbBundle\Model\AdvertcacheQuery as ChildAdvertcacheQuery;
use Common\DbBundle\Model\Map\AdvertcacheTableMap;
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
 * Base class that represents a row from the 'advertcache' table.
 *
 *
 *
 * @package    propel.generator.src.Common.DbBundle.Model.Base
 */
abstract class Advertcache implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Common\\DbBundle\\Model\\Map\\AdvertcacheTableMap';


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
     * The value for the section_id field.
     *
     * @var        int
     */
    protected $section_id;

    /**
     * The value for the advert_id field.
     *
     * @var        int
     */
    protected $advert_id;

    /**
     * The value for the locale field.
     *
     * @var        string
     */
    protected $locale;

    /**
     * The value for the section_position field.
     *
     * @var        string
     */
    protected $section_position;

    /**
     * The value for the title field.
     *
     * @var        string
     */
    protected $title;

    /**
     * The value for the brief field.
     *
     * @var        string
     */
    protected $brief;

    /**
     * The value for the link field.
     *
     * @var        string
     */
    protected $link;

    /**
     * The value for the link_to field.
     *
     * @var        string
     */
    protected $link_to;

    /**
     * The value for the read field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $read;

    /**
     * The value for the imgs field.
     *
     * @var        string
     */
    protected $imgs;

    /**
     * The value for the imgs_sizes field.
     *
     * @var        string
     */
    protected $imgs_sizes;

    /**
     * The value for the published_at field.
     *
     * @var        DateTime
     */
    protected $published_at;

    /**
     * The value for the expired_at field.
     *
     * @var        DateTime
     */
    protected $expired_at;

    /**
     * The value for the locked field.
     *
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $locked;

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
        $this->read = 0;
        $this->locked = true;
    }

    /**
     * Initializes internal state of Common\DbBundle\Model\Base\Advertcache object.
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
     * Compares this with another <code>Advertcache</code> instance.  If
     * <code>obj</code> is an instance of <code>Advertcache</code>, delegates to
     * <code>equals(Advertcache)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Advertcache The current object, for fluid interface
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
     * Get the [section_id] column value.
     *
     * @return int
     */
    public function getSectionId()
    {
        return $this->section_id;
    }

    /**
     * Get the [advert_id] column value.
     *
     * @return int
     */
    public function getAdvertId()
    {
        return $this->advert_id;
    }

    /**
     * Get the [locale] column value.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Get the [section_position] column value.
     *
     * @return string
     */
    public function getSectionPosition()
    {
        return $this->section_position;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [brief] column value.
     *
     * @return string
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Get the [link] column value.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Get the [link_to] column value.
     *
     * @return string
     */
    public function getLinkTo()
    {
        return $this->link_to;
    }

    /**
     * Get the [read] column value.
     *
     * @return int
     */
    public function getRead()
    {
        return $this->read;
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
     * Get the [imgs_sizes] column value.
     *
     * @return string
     */
    public function getImgsSizes()
    {
        return $this->imgs_sizes;
    }

    /**
     * Get the [optionally formatted] temporal [published_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getPublishedAt($format = NULL)
    {
        if ($format === null) {
            return $this->published_at;
        } else {
            return $this->published_at instanceof \DateTimeInterface ? $this->published_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [expired_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getExpiredAt($format = NULL)
    {
        if ($format === null) {
            return $this->expired_at;
        } else {
            return $this->expired_at instanceof \DateTimeInterface ? $this->expired_at->format($format) : null;
        }
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
     * Set the value of [section_id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setSectionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->section_id !== $v) {
            $this->section_id = $v;
            $this->modifiedColumns[AdvertcacheTableMap::COL_SECTION_ID] = true;
        }

        return $this;
    } // setSectionId()

    /**
     * Set the value of [advert_id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setAdvertId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->advert_id !== $v) {
            $this->advert_id = $v;
            $this->modifiedColumns[AdvertcacheTableMap::COL_ADVERT_ID] = true;
        }

        return $this;
    } // setAdvertId()

    /**
     * Set the value of [locale] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setLocale($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->locale !== $v) {
            $this->locale = $v;
            $this->modifiedColumns[AdvertcacheTableMap::COL_LOCALE] = true;
        }

        return $this;
    } // setLocale()

    /**
     * Set the value of [section_position] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setSectionPosition($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->section_position !== $v) {
            $this->section_position = $v;
            $this->modifiedColumns[AdvertcacheTableMap::COL_SECTION_POSITION] = true;
        }

        return $this;
    } // setSectionPosition()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[AdvertcacheTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [brief] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setBrief($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->brief !== $v) {
            $this->brief = $v;
            $this->modifiedColumns[AdvertcacheTableMap::COL_BRIEF] = true;
        }

        return $this;
    } // setBrief()

    /**
     * Set the value of [link] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setLink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->link !== $v) {
            $this->link = $v;
            $this->modifiedColumns[AdvertcacheTableMap::COL_LINK] = true;
        }

        return $this;
    } // setLink()

    /**
     * Set the value of [link_to] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setLinkTo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->link_to !== $v) {
            $this->link_to = $v;
            $this->modifiedColumns[AdvertcacheTableMap::COL_LINK_TO] = true;
        }

        return $this;
    } // setLinkTo()

    /**
     * Set the value of [read] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setRead($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->read !== $v) {
            $this->read = $v;
            $this->modifiedColumns[AdvertcacheTableMap::COL_READ] = true;
        }

        return $this;
    } // setRead()

    /**
     * Set the value of [imgs] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setImgs($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->imgs !== $v) {
            $this->imgs = $v;
            $this->modifiedColumns[AdvertcacheTableMap::COL_IMGS] = true;
        }

        return $this;
    } // setImgs()

    /**
     * Set the value of [imgs_sizes] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setImgsSizes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->imgs_sizes !== $v) {
            $this->imgs_sizes = $v;
            $this->modifiedColumns[AdvertcacheTableMap::COL_IMGS_SIZES] = true;
        }

        return $this;
    } // setImgsSizes()

    /**
     * Sets the value of [published_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setPublishedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->published_at !== null || $dt !== null) {
            if ($this->published_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->published_at->format("Y-m-d H:i:s.u")) {
                $this->published_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AdvertcacheTableMap::COL_PUBLISHED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setPublishedAt()

    /**
     * Sets the value of [expired_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
     */
    public function setExpiredAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->expired_at !== null || $dt !== null) {
            if ($this->expired_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->expired_at->format("Y-m-d H:i:s.u")) {
                $this->expired_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AdvertcacheTableMap::COL_EXPIRED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setExpiredAt()

    /**
     * Sets the value of the [locked] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\Advertcache The current object (for fluent API support)
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
            $this->modifiedColumns[AdvertcacheTableMap::COL_LOCKED] = true;
        }

        return $this;
    } // setLocked()

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
            if ($this->read !== 0) {
                return false;
            }

            if ($this->locked !== true) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AdvertcacheTableMap::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->section_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AdvertcacheTableMap::translateFieldName('AdvertId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->advert_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AdvertcacheTableMap::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locale = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AdvertcacheTableMap::translateFieldName('SectionPosition', TableMap::TYPE_PHPNAME, $indexType)];
            $this->section_position = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AdvertcacheTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AdvertcacheTableMap::translateFieldName('Brief', TableMap::TYPE_PHPNAME, $indexType)];
            $this->brief = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AdvertcacheTableMap::translateFieldName('Link', TableMap::TYPE_PHPNAME, $indexType)];
            $this->link = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AdvertcacheTableMap::translateFieldName('LinkTo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->link_to = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AdvertcacheTableMap::translateFieldName('Read', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AdvertcacheTableMap::translateFieldName('Imgs', TableMap::TYPE_PHPNAME, $indexType)];
            $this->imgs = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : AdvertcacheTableMap::translateFieldName('ImgsSizes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->imgs_sizes = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : AdvertcacheTableMap::translateFieldName('PublishedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->published_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : AdvertcacheTableMap::translateFieldName('ExpiredAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->expired_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : AdvertcacheTableMap::translateFieldName('Locked', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locked = (null !== $col) ? (boolean) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 14; // 14 = AdvertcacheTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Common\\DbBundle\\Model\\Advertcache'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(AdvertcacheTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAdvertcacheQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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
     * @see Advertcache::setDeleted()
     * @see Advertcache::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertcacheTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAdvertcacheQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertcacheTableMap::DATABASE_NAME);
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
                AdvertcacheTableMap::addInstanceToPool($this);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AdvertcacheTableMap::COL_SECTION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`section_id`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_ADVERT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`advert_id`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_LOCALE)) {
            $modifiedColumns[':p' . $index++]  = '`locale`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_SECTION_POSITION)) {
            $modifiedColumns[':p' . $index++]  = '`section_position`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_BRIEF)) {
            $modifiedColumns[':p' . $index++]  = '`brief`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_LINK)) {
            $modifiedColumns[':p' . $index++]  = '`link`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_LINK_TO)) {
            $modifiedColumns[':p' . $index++]  = '`link_to`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_READ)) {
            $modifiedColumns[':p' . $index++]  = '`read`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_IMGS)) {
            $modifiedColumns[':p' . $index++]  = '`imgs`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_IMGS_SIZES)) {
            $modifiedColumns[':p' . $index++]  = '`imgs_sizes`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_PUBLISHED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`published_at`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_EXPIRED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`expired_at`';
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_LOCKED)) {
            $modifiedColumns[':p' . $index++]  = '`locked`';
        }

        $sql = sprintf(
            'INSERT INTO `advertcache` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`section_id`':
                        $stmt->bindValue($identifier, $this->section_id, PDO::PARAM_INT);
                        break;
                    case '`advert_id`':
                        $stmt->bindValue($identifier, $this->advert_id, PDO::PARAM_INT);
                        break;
                    case '`locale`':
                        $stmt->bindValue($identifier, $this->locale, PDO::PARAM_STR);
                        break;
                    case '`section_position`':
                        $stmt->bindValue($identifier, $this->section_position, PDO::PARAM_STR);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`brief`':
                        $stmt->bindValue($identifier, $this->brief, PDO::PARAM_STR);
                        break;
                    case '`link`':
                        $stmt->bindValue($identifier, $this->link, PDO::PARAM_STR);
                        break;
                    case '`link_to`':
                        $stmt->bindValue($identifier, $this->link_to, PDO::PARAM_STR);
                        break;
                    case '`read`':
                        $stmt->bindValue($identifier, $this->read, PDO::PARAM_INT);
                        break;
                    case '`imgs`':
                        $stmt->bindValue($identifier, $this->imgs, PDO::PARAM_STR);
                        break;
                    case '`imgs_sizes`':
                        $stmt->bindValue($identifier, $this->imgs_sizes, PDO::PARAM_STR);
                        break;
                    case '`published_at`':
                        $stmt->bindValue($identifier, $this->published_at ? $this->published_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case '`expired_at`':
                        $stmt->bindValue($identifier, $this->expired_at ? $this->expired_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case '`locked`':
                        $stmt->bindValue($identifier, (int) $this->locked, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = AdvertcacheTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getSectionId();
                break;
            case 1:
                return $this->getAdvertId();
                break;
            case 2:
                return $this->getLocale();
                break;
            case 3:
                return $this->getSectionPosition();
                break;
            case 4:
                return $this->getTitle();
                break;
            case 5:
                return $this->getBrief();
                break;
            case 6:
                return $this->getLink();
                break;
            case 7:
                return $this->getLinkTo();
                break;
            case 8:
                return $this->getRead();
                break;
            case 9:
                return $this->getImgs();
                break;
            case 10:
                return $this->getImgsSizes();
                break;
            case 11:
                return $this->getPublishedAt();
                break;
            case 12:
                return $this->getExpiredAt();
                break;
            case 13:
                return $this->getLocked();
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

        if (isset($alreadyDumpedObjects['Advertcache'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Advertcache'][$this->hashCode()] = true;
        $keys = AdvertcacheTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getSectionId(),
            $keys[1] => $this->getAdvertId(),
            $keys[2] => $this->getLocale(),
            $keys[3] => $this->getSectionPosition(),
            $keys[4] => $this->getTitle(),
            $keys[5] => $this->getBrief(),
            $keys[6] => $this->getLink(),
            $keys[7] => $this->getLinkTo(),
            $keys[8] => $this->getRead(),
            $keys[9] => $this->getImgs(),
            $keys[10] => $this->getImgsSizes(),
            $keys[11] => $this->getPublishedAt(),
            $keys[12] => $this->getExpiredAt(),
            $keys[13] => $this->getLocked(),
        );
        if ($result[$keys[11]] instanceof \DateTimeInterface) {
            $result[$keys[11]] = $result[$keys[11]]->format('c');
        }

        if ($result[$keys[12]] instanceof \DateTimeInterface) {
            $result[$keys[12]] = $result[$keys[12]]->format('c');
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
     * @return $this|\Common\DbBundle\Model\Advertcache
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AdvertcacheTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Common\DbBundle\Model\Advertcache
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setSectionId($value);
                break;
            case 1:
                $this->setAdvertId($value);
                break;
            case 2:
                $this->setLocale($value);
                break;
            case 3:
                $this->setSectionPosition($value);
                break;
            case 4:
                $this->setTitle($value);
                break;
            case 5:
                $this->setBrief($value);
                break;
            case 6:
                $this->setLink($value);
                break;
            case 7:
                $this->setLinkTo($value);
                break;
            case 8:
                $this->setRead($value);
                break;
            case 9:
                $this->setImgs($value);
                break;
            case 10:
                $this->setImgsSizes($value);
                break;
            case 11:
                $this->setPublishedAt($value);
                break;
            case 12:
                $this->setExpiredAt($value);
                break;
            case 13:
                $this->setLocked($value);
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
        $keys = AdvertcacheTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setSectionId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setAdvertId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLocale($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSectionPosition($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTitle($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setBrief($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setLink($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setLinkTo($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setRead($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setImgs($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setImgsSizes($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setPublishedAt($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setExpiredAt($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setLocked($arr[$keys[13]]);
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
     * @return $this|\Common\DbBundle\Model\Advertcache The current object, for fluid interface
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
        $criteria = new Criteria(AdvertcacheTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AdvertcacheTableMap::COL_SECTION_ID)) {
            $criteria->add(AdvertcacheTableMap::COL_SECTION_ID, $this->section_id);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_ADVERT_ID)) {
            $criteria->add(AdvertcacheTableMap::COL_ADVERT_ID, $this->advert_id);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_LOCALE)) {
            $criteria->add(AdvertcacheTableMap::COL_LOCALE, $this->locale);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_SECTION_POSITION)) {
            $criteria->add(AdvertcacheTableMap::COL_SECTION_POSITION, $this->section_position);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_TITLE)) {
            $criteria->add(AdvertcacheTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_BRIEF)) {
            $criteria->add(AdvertcacheTableMap::COL_BRIEF, $this->brief);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_LINK)) {
            $criteria->add(AdvertcacheTableMap::COL_LINK, $this->link);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_LINK_TO)) {
            $criteria->add(AdvertcacheTableMap::COL_LINK_TO, $this->link_to);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_READ)) {
            $criteria->add(AdvertcacheTableMap::COL_READ, $this->read);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_IMGS)) {
            $criteria->add(AdvertcacheTableMap::COL_IMGS, $this->imgs);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_IMGS_SIZES)) {
            $criteria->add(AdvertcacheTableMap::COL_IMGS_SIZES, $this->imgs_sizes);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_PUBLISHED_AT)) {
            $criteria->add(AdvertcacheTableMap::COL_PUBLISHED_AT, $this->published_at);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_EXPIRED_AT)) {
            $criteria->add(AdvertcacheTableMap::COL_EXPIRED_AT, $this->expired_at);
        }
        if ($this->isColumnModified(AdvertcacheTableMap::COL_LOCKED)) {
            $criteria->add(AdvertcacheTableMap::COL_LOCKED, $this->locked);
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
        $criteria = ChildAdvertcacheQuery::create();
        $criteria->add(AdvertcacheTableMap::COL_SECTION_ID, $this->section_id);
        $criteria->add(AdvertcacheTableMap::COL_ADVERT_ID, $this->advert_id);
        $criteria->add(AdvertcacheTableMap::COL_LOCALE, $this->locale);

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
        $validPk = null !== $this->getSectionId() &&
            null !== $this->getAdvertId() &&
            null !== $this->getLocale();

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
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getSectionId();
        $pks[1] = $this->getAdvertId();
        $pks[2] = $this->getLocale();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setSectionId($keys[0]);
        $this->setAdvertId($keys[1]);
        $this->setLocale($keys[2]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getSectionId()) && (null === $this->getAdvertId()) && (null === $this->getLocale());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Common\DbBundle\Model\Advertcache (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSectionId($this->getSectionId());
        $copyObj->setAdvertId($this->getAdvertId());
        $copyObj->setLocale($this->getLocale());
        $copyObj->setSectionPosition($this->getSectionPosition());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setBrief($this->getBrief());
        $copyObj->setLink($this->getLink());
        $copyObj->setLinkTo($this->getLinkTo());
        $copyObj->setRead($this->getRead());
        $copyObj->setImgs($this->getImgs());
        $copyObj->setImgsSizes($this->getImgsSizes());
        $copyObj->setPublishedAt($this->getPublishedAt());
        $copyObj->setExpiredAt($this->getExpiredAt());
        $copyObj->setLocked($this->getLocked());
        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \Common\DbBundle\Model\Advertcache Clone of current object.
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
        $this->section_id = null;
        $this->advert_id = null;
        $this->locale = null;
        $this->section_position = null;
        $this->title = null;
        $this->brief = null;
        $this->link = null;
        $this->link_to = null;
        $this->read = null;
        $this->imgs = null;
        $this->imgs_sizes = null;
        $this->published_at = null;
        $this->expired_at = null;
        $this->locked = null;
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
        return (string) $this->exportTo(AdvertcacheTableMap::DEFAULT_STRING_FORMAT);
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
