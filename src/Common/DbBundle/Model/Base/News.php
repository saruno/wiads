<?php

namespace Common\DbBundle\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Common\DbBundle\Model\Comment as ChildComment;
use Common\DbBundle\Model\CommentQuery as ChildCommentQuery;
use Common\DbBundle\Model\News as ChildNews;
use Common\DbBundle\Model\NewsI18n as ChildNewsI18n;
use Common\DbBundle\Model\NewsI18nQuery as ChildNewsI18nQuery;
use Common\DbBundle\Model\NewsQuery as ChildNewsQuery;
use Common\DbBundle\Model\Section as ChildSection;
use Common\DbBundle\Model\SectionQuery as ChildSectionQuery;
use Common\DbBundle\Model\Map\CommentTableMap;
use Common\DbBundle\Model\Map\NewsI18nTableMap;
use Common\DbBundle\Model\Map\NewsTableMap;
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
 * Base class that represents a row from the 'news' table.
 *
 *
 *
 * @package    propel.generator.src.Common.DbBundle.Model.Base
 */
abstract class News implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Common\\DbBundle\\Model\\Map\\NewsTableMap';


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
     * The value for the subsection_ids field.
     *
     * @var        string
     */
    protected $subsection_ids;

    /**
     * The value for the orders field.
     *
     * @var        int
     */
    protected $orders;

    /**
     * The value for the suborder_ids field.
     *
     * @var        string
     */
    protected $suborder_ids;

    /**
     * The value for the front_page field.
     *
     * @var        boolean
     */
    protected $front_page;

    /**
     * The value for the has_comment field.
     *
     * @var        boolean
     */
    protected $has_comment;

    /**
     * The value for the can_delete field.
     *
     * @var        boolean
     */
    protected $can_delete;

    /**
     * The value for the published_at field.
     *
     * @var        DateTime
     */
    protected $published_at;

    /**
     * The value for the imgs field.
     *
     * @var        string
     */
    protected $imgs;

    /**
     * The value for the relative_news field.
     *
     * @var        string
     */
    protected $relative_news;

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
     * @var        ObjectCollection|ChildComment[] Collection to store aggregation of ChildComment objects.
     */
    protected $collComments;
    protected $collCommentsPartial;

    /**
     * @var        ObjectCollection|ChildNewsI18n[] Collection to store aggregation of ChildNewsI18n objects.
     */
    protected $collNewsI18ns;
    protected $collNewsI18nsPartial;

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
    protected $currentLocale = 'en_US';

    /**
     * Current translation objects
     * @var        array[ChildNewsI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComment[]
     */
    protected $commentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildNewsI18n[]
     */
    protected $newsI18nsScheduledForDeletion = null;

    /**
     * Initializes internal state of Common\DbBundle\Model\Base\News object.
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
     * Compares this with another <code>News</code> instance.  If
     * <code>obj</code> is an instance of <code>News</code>, delegates to
     * <code>equals(News)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|News The current object, for fluid interface
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
     * Get the [subsection_ids] column value.
     *
     * @return string
     */
    public function getSubsectionIds()
    {
        return $this->subsection_ids;
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
     * Get the [suborder_ids] column value.
     *
     * @return string
     */
    public function getSuborderIds()
    {
        return $this->suborder_ids;
    }

    /**
     * Get the [front_page] column value.
     *
     * @return boolean
     */
    public function getFrontPage()
    {
        return $this->front_page;
    }

    /**
     * Get the [front_page] column value.
     *
     * @return boolean
     */
    public function isFrontPage()
    {
        return $this->getFrontPage();
    }

    /**
     * Get the [has_comment] column value.
     *
     * @return boolean
     */
    public function getHasComment()
    {
        return $this->has_comment;
    }

    /**
     * Get the [has_comment] column value.
     *
     * @return boolean
     */
    public function hasComment()
    {
        return $this->getHasComment();
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
     * Get the [imgs] column value.
     *
     * @return string
     */
    public function getImgs()
    {
        return $this->imgs;
    }

    /**
     * Get the [relative_news] column value.
     *
     * @return string
     */
    public function getRelativeNews()
    {
        return $this->relative_news;
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
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[NewsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [section_id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setSectionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->section_id !== $v) {
            $this->section_id = $v;
            $this->modifiedColumns[NewsTableMap::COL_SECTION_ID] = true;
        }

        if ($this->aSection !== null && $this->aSection->getId() !== $v) {
            $this->aSection = null;
        }

        return $this;
    } // setSectionId()

    /**
     * Set the value of [subsection_ids] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setSubsectionIds($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subsection_ids !== $v) {
            $this->subsection_ids = $v;
            $this->modifiedColumns[NewsTableMap::COL_SUBSECTION_IDS] = true;
        }

        return $this;
    } // setSubsectionIds()

    /**
     * Set the value of [orders] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setOrders($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->orders !== $v) {
            $this->orders = $v;
            $this->modifiedColumns[NewsTableMap::COL_ORDERS] = true;
        }

        return $this;
    } // setOrders()

    /**
     * Set the value of [suborder_ids] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setSuborderIds($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->suborder_ids !== $v) {
            $this->suborder_ids = $v;
            $this->modifiedColumns[NewsTableMap::COL_SUBORDER_IDS] = true;
        }

        return $this;
    } // setSuborderIds()

    /**
     * Sets the value of the [front_page] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setFrontPage($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->front_page !== $v) {
            $this->front_page = $v;
            $this->modifiedColumns[NewsTableMap::COL_FRONT_PAGE] = true;
        }

        return $this;
    } // setFrontPage()

    /**
     * Sets the value of the [has_comment] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setHasComment($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->has_comment !== $v) {
            $this->has_comment = $v;
            $this->modifiedColumns[NewsTableMap::COL_HAS_COMMENT] = true;
        }

        return $this;
    } // setHasComment()

    /**
     * Sets the value of the [can_delete] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
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
            $this->modifiedColumns[NewsTableMap::COL_CAN_DELETE] = true;
        }

        return $this;
    } // setCanDelete()

    /**
     * Sets the value of [published_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setPublishedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->published_at !== null || $dt !== null) {
            if ($this->published_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->published_at->format("Y-m-d H:i:s.u")) {
                $this->published_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[NewsTableMap::COL_PUBLISHED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setPublishedAt()

    /**
     * Set the value of [imgs] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setImgs($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->imgs !== $v) {
            $this->imgs = $v;
            $this->modifiedColumns[NewsTableMap::COL_IMGS] = true;
        }

        return $this;
    } // setImgs()

    /**
     * Set the value of [relative_news] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setRelativeNews($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->relative_news !== $v) {
            $this->relative_news = $v;
            $this->modifiedColumns[NewsTableMap::COL_RELATIVE_NEWS] = true;
        }

        return $this;
    } // setRelativeNews()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[NewsTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[NewsTableMap::COL_UPDATED_AT] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : NewsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : NewsTableMap::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->section_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : NewsTableMap::translateFieldName('SubsectionIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subsection_ids = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : NewsTableMap::translateFieldName('Orders', TableMap::TYPE_PHPNAME, $indexType)];
            $this->orders = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : NewsTableMap::translateFieldName('SuborderIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->suborder_ids = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : NewsTableMap::translateFieldName('FrontPage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->front_page = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : NewsTableMap::translateFieldName('HasComment', TableMap::TYPE_PHPNAME, $indexType)];
            $this->has_comment = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : NewsTableMap::translateFieldName('CanDelete', TableMap::TYPE_PHPNAME, $indexType)];
            $this->can_delete = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : NewsTableMap::translateFieldName('PublishedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->published_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : NewsTableMap::translateFieldName('Imgs', TableMap::TYPE_PHPNAME, $indexType)];
            $this->imgs = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : NewsTableMap::translateFieldName('RelativeNews', TableMap::TYPE_PHPNAME, $indexType)];
            $this->relative_news = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : NewsTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : NewsTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 13; // 13 = NewsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Common\\DbBundle\\Model\\News'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(NewsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildNewsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSection = null;
            $this->collComments = null;

            $this->collNewsI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see News::setDeleted()
     * @see News::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(NewsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildNewsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(NewsTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(NewsTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(NewsTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(NewsTableMap::COL_UPDATED_AT)) {
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
                NewsTableMap::addInstanceToPool($this);
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

            if ($this->newsI18nsScheduledForDeletion !== null) {
                if (!$this->newsI18nsScheduledForDeletion->isEmpty()) {
                    \Common\DbBundle\Model\NewsI18nQuery::create()
                        ->filterByPrimaryKeys($this->newsI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->newsI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collNewsI18ns !== null) {
                foreach ($this->collNewsI18ns as $referrerFK) {
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

        $this->modifiedColumns[NewsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . NewsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(NewsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_SECTION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`section_id`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_SUBSECTION_IDS)) {
            $modifiedColumns[':p' . $index++]  = '`subsection_ids`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_ORDERS)) {
            $modifiedColumns[':p' . $index++]  = '`orders`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_SUBORDER_IDS)) {
            $modifiedColumns[':p' . $index++]  = '`suborder_ids`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_FRONT_PAGE)) {
            $modifiedColumns[':p' . $index++]  = '`front_page`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_HAS_COMMENT)) {
            $modifiedColumns[':p' . $index++]  = '`has_comment`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_CAN_DELETE)) {
            $modifiedColumns[':p' . $index++]  = '`can_delete`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_PUBLISHED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`published_at`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_IMGS)) {
            $modifiedColumns[':p' . $index++]  = '`imgs`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_RELATIVE_NEWS)) {
            $modifiedColumns[':p' . $index++]  = '`relative_news`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(NewsTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `news` (%s) VALUES (%s)',
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
                    case '`subsection_ids`':
                        $stmt->bindValue($identifier, $this->subsection_ids, PDO::PARAM_STR);
                        break;
                    case '`orders`':
                        $stmt->bindValue($identifier, $this->orders, PDO::PARAM_INT);
                        break;
                    case '`suborder_ids`':
                        $stmt->bindValue($identifier, $this->suborder_ids, PDO::PARAM_STR);
                        break;
                    case '`front_page`':
                        $stmt->bindValue($identifier, (int) $this->front_page, PDO::PARAM_INT);
                        break;
                    case '`has_comment`':
                        $stmt->bindValue($identifier, (int) $this->has_comment, PDO::PARAM_INT);
                        break;
                    case '`can_delete`':
                        $stmt->bindValue($identifier, (int) $this->can_delete, PDO::PARAM_INT);
                        break;
                    case '`published_at`':
                        $stmt->bindValue($identifier, $this->published_at ? $this->published_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case '`imgs`':
                        $stmt->bindValue($identifier, $this->imgs, PDO::PARAM_STR);
                        break;
                    case '`relative_news`':
                        $stmt->bindValue($identifier, $this->relative_news, PDO::PARAM_STR);
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
        $pos = NewsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getSubsectionIds();
                break;
            case 3:
                return $this->getOrders();
                break;
            case 4:
                return $this->getSuborderIds();
                break;
            case 5:
                return $this->getFrontPage();
                break;
            case 6:
                return $this->getHasComment();
                break;
            case 7:
                return $this->getCanDelete();
                break;
            case 8:
                return $this->getPublishedAt();
                break;
            case 9:
                return $this->getImgs();
                break;
            case 10:
                return $this->getRelativeNews();
                break;
            case 11:
                return $this->getCreatedAt();
                break;
            case 12:
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

        if (isset($alreadyDumpedObjects['News'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['News'][$this->hashCode()] = true;
        $keys = NewsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getSectionId(),
            $keys[2] => $this->getSubsectionIds(),
            $keys[3] => $this->getOrders(),
            $keys[4] => $this->getSuborderIds(),
            $keys[5] => $this->getFrontPage(),
            $keys[6] => $this->getHasComment(),
            $keys[7] => $this->getCanDelete(),
            $keys[8] => $this->getPublishedAt(),
            $keys[9] => $this->getImgs(),
            $keys[10] => $this->getRelativeNews(),
            $keys[11] => $this->getCreatedAt(),
            $keys[12] => $this->getUpdatedAt(),
        );
        if ($result[$keys[8]] instanceof \DateTimeInterface) {
            $result[$keys[8]] = $result[$keys[8]]->format('c');
        }

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
            if (null !== $this->collNewsI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'newsI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'news_i18ns';
                        break;
                    default:
                        $key = 'NewsI18ns';
                }

                $result[$key] = $this->collNewsI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Common\DbBundle\Model\News
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = NewsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Common\DbBundle\Model\News
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
                $this->setSubsectionIds($value);
                break;
            case 3:
                $this->setOrders($value);
                break;
            case 4:
                $this->setSuborderIds($value);
                break;
            case 5:
                $this->setFrontPage($value);
                break;
            case 6:
                $this->setHasComment($value);
                break;
            case 7:
                $this->setCanDelete($value);
                break;
            case 8:
                $this->setPublishedAt($value);
                break;
            case 9:
                $this->setImgs($value);
                break;
            case 10:
                $this->setRelativeNews($value);
                break;
            case 11:
                $this->setCreatedAt($value);
                break;
            case 12:
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
        $keys = NewsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setSectionId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSubsectionIds($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setOrders($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setSuborderIds($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setFrontPage($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setHasComment($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCanDelete($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setPublishedAt($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setImgs($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setRelativeNews($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setCreatedAt($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setUpdatedAt($arr[$keys[12]]);
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
     * @return $this|\Common\DbBundle\Model\News The current object, for fluid interface
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
        $criteria = new Criteria(NewsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(NewsTableMap::COL_ID)) {
            $criteria->add(NewsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(NewsTableMap::COL_SECTION_ID)) {
            $criteria->add(NewsTableMap::COL_SECTION_ID, $this->section_id);
        }
        if ($this->isColumnModified(NewsTableMap::COL_SUBSECTION_IDS)) {
            $criteria->add(NewsTableMap::COL_SUBSECTION_IDS, $this->subsection_ids);
        }
        if ($this->isColumnModified(NewsTableMap::COL_ORDERS)) {
            $criteria->add(NewsTableMap::COL_ORDERS, $this->orders);
        }
        if ($this->isColumnModified(NewsTableMap::COL_SUBORDER_IDS)) {
            $criteria->add(NewsTableMap::COL_SUBORDER_IDS, $this->suborder_ids);
        }
        if ($this->isColumnModified(NewsTableMap::COL_FRONT_PAGE)) {
            $criteria->add(NewsTableMap::COL_FRONT_PAGE, $this->front_page);
        }
        if ($this->isColumnModified(NewsTableMap::COL_HAS_COMMENT)) {
            $criteria->add(NewsTableMap::COL_HAS_COMMENT, $this->has_comment);
        }
        if ($this->isColumnModified(NewsTableMap::COL_CAN_DELETE)) {
            $criteria->add(NewsTableMap::COL_CAN_DELETE, $this->can_delete);
        }
        if ($this->isColumnModified(NewsTableMap::COL_PUBLISHED_AT)) {
            $criteria->add(NewsTableMap::COL_PUBLISHED_AT, $this->published_at);
        }
        if ($this->isColumnModified(NewsTableMap::COL_IMGS)) {
            $criteria->add(NewsTableMap::COL_IMGS, $this->imgs);
        }
        if ($this->isColumnModified(NewsTableMap::COL_RELATIVE_NEWS)) {
            $criteria->add(NewsTableMap::COL_RELATIVE_NEWS, $this->relative_news);
        }
        if ($this->isColumnModified(NewsTableMap::COL_CREATED_AT)) {
            $criteria->add(NewsTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(NewsTableMap::COL_UPDATED_AT)) {
            $criteria->add(NewsTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildNewsQuery::create();
        $criteria->add(NewsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Common\DbBundle\Model\News (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSectionId($this->getSectionId());
        $copyObj->setSubsectionIds($this->getSubsectionIds());
        $copyObj->setOrders($this->getOrders());
        $copyObj->setSuborderIds($this->getSuborderIds());
        $copyObj->setFrontPage($this->getFrontPage());
        $copyObj->setHasComment($this->getHasComment());
        $copyObj->setCanDelete($this->getCanDelete());
        $copyObj->setPublishedAt($this->getPublishedAt());
        $copyObj->setImgs($this->getImgs());
        $copyObj->setRelativeNews($this->getRelativeNews());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getComments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getNewsI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addNewsI18n($relObj->copy($deepCopy));
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
     * @return \Common\DbBundle\Model\News Clone of current object.
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
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
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
            $v->addNews($this);
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
                $this->aSection->addNews($this);
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
        if ('Comment' == $relationName) {
            $this->initComments();
            return;
        }
        if ('NewsI18n' == $relationName) {
            $this->initNewsI18ns();
            return;
        }
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
     * If this ChildNews is new, it will return
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
                    ->filterByNews($this)
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
     * @return $this|ChildNews The current object (for fluent API support)
     */
    public function setComments(Collection $comments, ConnectionInterface $con = null)
    {
        /** @var ChildComment[] $commentsToDelete */
        $commentsToDelete = $this->getComments(new Criteria(), $con)->diff($comments);


        $this->commentsScheduledForDeletion = $commentsToDelete;

        foreach ($commentsToDelete as $commentRemoved) {
            $commentRemoved->setNews(null);
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
                ->filterByNews($this)
                ->count($con);
        }

        return count($this->collComments);
    }

    /**
     * Method called to associate a ChildComment object to this object
     * through the ChildComment foreign key attribute.
     *
     * @param  ChildComment $l ChildComment
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
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
        $comment->setNews($this);
    }

    /**
     * @param  ChildComment $comment The ChildComment object to remove.
     * @return $this|ChildNews The current object (for fluent API support)
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
            $comment->setNews(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this News is new, it will return
     * an empty collection; or if this News has previously
     * been saved, it will retrieve related Comments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in News.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     */
    public function getCommentsJoinSection(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('Section', $joinBehavior);

        return $this->getComments($query, $con);
    }

    /**
     * Clears out the collNewsI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addNewsI18ns()
     */
    public function clearNewsI18ns()
    {
        $this->collNewsI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collNewsI18ns collection loaded partially.
     */
    public function resetPartialNewsI18ns($v = true)
    {
        $this->collNewsI18nsPartial = $v;
    }

    /**
     * Initializes the collNewsI18ns collection.
     *
     * By default this just sets the collNewsI18ns collection to an empty array (like clearcollNewsI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initNewsI18ns($overrideExisting = true)
    {
        if (null !== $this->collNewsI18ns && !$overrideExisting) {
            return;
        }

        $collectionClassName = NewsI18nTableMap::getTableMap()->getCollectionClassName();

        $this->collNewsI18ns = new $collectionClassName;
        $this->collNewsI18ns->setModel('\Common\DbBundle\Model\NewsI18n');
    }

    /**
     * Gets an array of ChildNewsI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildNews is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildNewsI18n[] List of ChildNewsI18n objects
     * @throws PropelException
     */
    public function getNewsI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collNewsI18nsPartial && !$this->isNew();
        if (null === $this->collNewsI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collNewsI18ns) {
                // return empty collection
                $this->initNewsI18ns();
            } else {
                $collNewsI18ns = ChildNewsI18nQuery::create(null, $criteria)
                    ->filterByNews($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collNewsI18nsPartial && count($collNewsI18ns)) {
                        $this->initNewsI18ns(false);

                        foreach ($collNewsI18ns as $obj) {
                            if (false == $this->collNewsI18ns->contains($obj)) {
                                $this->collNewsI18ns->append($obj);
                            }
                        }

                        $this->collNewsI18nsPartial = true;
                    }

                    return $collNewsI18ns;
                }

                if ($partial && $this->collNewsI18ns) {
                    foreach ($this->collNewsI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collNewsI18ns[] = $obj;
                        }
                    }
                }

                $this->collNewsI18ns = $collNewsI18ns;
                $this->collNewsI18nsPartial = false;
            }
        }

        return $this->collNewsI18ns;
    }

    /**
     * Sets a collection of ChildNewsI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $newsI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildNews The current object (for fluent API support)
     */
    public function setNewsI18ns(Collection $newsI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildNewsI18n[] $newsI18nsToDelete */
        $newsI18nsToDelete = $this->getNewsI18ns(new Criteria(), $con)->diff($newsI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->newsI18nsScheduledForDeletion = clone $newsI18nsToDelete;

        foreach ($newsI18nsToDelete as $newsI18nRemoved) {
            $newsI18nRemoved->setNews(null);
        }

        $this->collNewsI18ns = null;
        foreach ($newsI18ns as $newsI18n) {
            $this->addNewsI18n($newsI18n);
        }

        $this->collNewsI18ns = $newsI18ns;
        $this->collNewsI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related NewsI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related NewsI18n objects.
     * @throws PropelException
     */
    public function countNewsI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collNewsI18nsPartial && !$this->isNew();
        if (null === $this->collNewsI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collNewsI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getNewsI18ns());
            }

            $query = ChildNewsI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByNews($this)
                ->count($con);
        }

        return count($this->collNewsI18ns);
    }

    /**
     * Method called to associate a ChildNewsI18n object to this object
     * through the ChildNewsI18n foreign key attribute.
     *
     * @param  ChildNewsI18n $l ChildNewsI18n
     * @return $this|\Common\DbBundle\Model\News The current object (for fluent API support)
     */
    public function addNewsI18n(ChildNewsI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collNewsI18ns === null) {
            $this->initNewsI18ns();
            $this->collNewsI18nsPartial = true;
        }

        if (!$this->collNewsI18ns->contains($l)) {
            $this->doAddNewsI18n($l);

            if ($this->newsI18nsScheduledForDeletion and $this->newsI18nsScheduledForDeletion->contains($l)) {
                $this->newsI18nsScheduledForDeletion->remove($this->newsI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildNewsI18n $newsI18n The ChildNewsI18n object to add.
     */
    protected function doAddNewsI18n(ChildNewsI18n $newsI18n)
    {
        $this->collNewsI18ns[]= $newsI18n;
        $newsI18n->setNews($this);
    }

    /**
     * @param  ChildNewsI18n $newsI18n The ChildNewsI18n object to remove.
     * @return $this|ChildNews The current object (for fluent API support)
     */
    public function removeNewsI18n(ChildNewsI18n $newsI18n)
    {
        if ($this->getNewsI18ns()->contains($newsI18n)) {
            $pos = $this->collNewsI18ns->search($newsI18n);
            $this->collNewsI18ns->remove($pos);
            if (null === $this->newsI18nsScheduledForDeletion) {
                $this->newsI18nsScheduledForDeletion = clone $this->collNewsI18ns;
                $this->newsI18nsScheduledForDeletion->clear();
            }
            $this->newsI18nsScheduledForDeletion[]= clone $newsI18n;
            $newsI18n->setNews(null);
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
            $this->aSection->removeNews($this);
        }
        $this->id = null;
        $this->section_id = null;
        $this->subsection_ids = null;
        $this->orders = null;
        $this->suborder_ids = null;
        $this->front_page = null;
        $this->has_comment = null;
        $this->can_delete = null;
        $this->published_at = null;
        $this->imgs = null;
        $this->relative_news = null;
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
            if ($this->collComments) {
                foreach ($this->collComments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collNewsI18ns) {
                foreach ($this->collNewsI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'en_US';
        $this->currentTranslations = null;

        $this->collComments = null;
        $this->collNewsI18ns = null;
        $this->aSection = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(NewsTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildNews The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[NewsTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildNews The current object (for fluent API support)
     */
    public function setLocale($locale = 'en_US')
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
     * @return ChildNewsI18n */
    public function getTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collNewsI18ns) {
                foreach ($this->collNewsI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildNewsI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildNewsI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addNewsI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildNews The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'en_US', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildNewsI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collNewsI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collNewsI18ns[$key]);
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
     * @return ChildNewsI18n */
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
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
         */
        public function setContent($v)
        {    $this->getCurrentTranslation()->setContent($v);

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
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
         */
        public function setEditBy($v)
        {    $this->getCurrentTranslation()->setEditBy($v);

        return $this;
    }


        /**
         * Get the [short_link] column value.
         *
         * @return string
         */
        public function getShortLink()
        {
        return $this->getCurrentTranslation()->getShortLink();
    }


        /**
         * Set the value of [short_link] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
         */
        public function setShortLink($v)
        {    $this->getCurrentTranslation()->setShortLink($v);

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
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
         */
        public function setLink($v)
        {    $this->getCurrentTranslation()->setLink($v);

        return $this;
    }


        /**
         * Get the [locked] column value.
         *
         * @return boolean
         */
        public function getLocked()
        {
        return $this->getCurrentTranslation()->getLocked();
    }


        /**
         * Set the value of [locked] column.
         *
         * @param boolean $v new value
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
         */
        public function setLocked($v)
        {    $this->getCurrentTranslation()->setLocked($v);

        return $this;
    }


        /**
         * Get the [trash] column value.
         *
         * @return boolean
         */
        public function getTrash()
        {
        return $this->getCurrentTranslation()->getTrash();
    }


        /**
         * Set the value of [trash] column.
         *
         * @param boolean $v new value
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
         */
        public function setTrash($v)
        {    $this->getCurrentTranslation()->setTrash($v);

        return $this;
    }


        /**
         * Get the [status] column value.
         *
         * @return string
         */
        public function getStatus()
        {
        return $this->getCurrentTranslation()->getStatus();
    }


        /**
         * Set the value of [status] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
         */
        public function setStatus($v)
        {    $this->getCurrentTranslation()->setStatus($v);

        return $this;
    }


        /**
         * Get the [pre_status] column value.
         *
         * @return string
         */
        public function getPreStatus()
        {
        return $this->getCurrentTranslation()->getPreStatus();
    }


        /**
         * Set the value of [pre_status] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
         */
        public function setPreStatus($v)
        {    $this->getCurrentTranslation()->setPreStatus($v);

        return $this;
    }


        /**
         * Get the [status_note] column value.
         *
         * @return string
         */
        public function getStatusNote()
        {
        return $this->getCurrentTranslation()->getStatusNote();
    }


        /**
         * Set the value of [status_note] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
         */
        public function setStatusNote($v)
        {    $this->getCurrentTranslation()->setStatusNote($v);

        return $this;
    }


        /**
         * Get the [draft] column value.
         *
         * @return boolean
         */
        public function getDraft()
        {
        return $this->getCurrentTranslation()->getDraft();
    }


        /**
         * Set the value of [draft] column.
         *
         * @param boolean $v new value
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
         */
        public function setDraft($v)
        {    $this->getCurrentTranslation()->setDraft($v);

        return $this;
    }


        /**
         * Get the [read] column value.
         *
         * @return int
         */
        public function getRead()
        {
        return $this->getCurrentTranslation()->getRead();
    }


        /**
         * Set the value of [read] column.
         *
         * @param int $v new value
         * @return $this|\Common\DbBundle\Model\NewsI18n The current object (for fluent API support)
         */
        public function setRead($v)
        {    $this->getCurrentTranslation()->setRead($v);

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
