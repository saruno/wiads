<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\Accesspoint as ChildAccesspoint;
use Hotspot\AccessPointBundle\Model\AccesspointI18nQuery as ChildAccesspointI18nQuery;
use Hotspot\AccessPointBundle\Model\AccesspointQuery as ChildAccesspointQuery;
use Hotspot\AccessPointBundle\Model\Map\AccesspointI18nTableMap;
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
 * Base class that represents a row from the 'accesspoint_i18n' table.
 *
 *
 *
 * @package    propel.generator.src.Hotspot.AccessPointBundle.Model.Base
 */
abstract class AccesspointI18n implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Hotspot\\AccessPointBundle\\Model\\Map\\AccesspointI18nTableMap';


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
     * The value for the locale field.
     *
     * Note: this column has a database default value of: 'vi'
     * @var        string
     */
    protected $locale;

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
     * The value for the pcontact field.
     *
     * @var        string
     */
    protected $pcontact;

    /**
     * The value for the detail_url field.
     *
     * @var        string
     */
    protected $detail_url;

    /**
     * The value for the title field.
     *
     * @var        string
     */
    protected $title;

    /**
     * The value for the strip_title field.
     *
     * @var        string
     */
    protected $strip_title;

    /**
     * The value for the brief field.
     *
     * @var        string
     */
    protected $brief;

    /**
     * The value for the content field.
     *
     * @var        string
     */
    protected $content;

    /**
     * The value for the tag field.
     *
     * @var        string
     */
    protected $tag;

    /**
     * The value for the keyword field.
     *
     * @var        string
     */
    protected $keyword;

    /**
     * The value for the post_by field.
     *
     * @var        string
     */
    protected $post_by;

    /**
     * The value for the edit_by field.
     *
     * @var        string
     */
    protected $edit_by;

    /**
     * The value for the short_link field.
     *
     * @var        string
     */
    protected $short_link;

    /**
     * The value for the link field.
     *
     * @var        string
     */
    protected $link;

    /**
     * The value for the locked field.
     *
     * @var        boolean
     */
    protected $locked;

    /**
     * The value for the trash field.
     *
     * @var        boolean
     */
    protected $trash;

    /**
     * The value for the status field.
     *
     * @var        string
     */
    protected $status;

    /**
     * The value for the pre_status field.
     *
     * @var        string
     */
    protected $pre_status;

    /**
     * The value for the status_note field.
     *
     * @var        string
     */
    protected $status_note;

    /**
     * The value for the draft field.
     *
     * @var        boolean
     */
    protected $draft;

    /**
     * The value for the read field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $read;

    /**
     * @var        ChildAccesspoint
     */
    protected $aAccesspoint;

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
        $this->locale = 'vi';
        $this->read = 0;
    }

    /**
     * Initializes internal state of Hotspot\AccessPointBundle\Model\Base\AccesspointI18n object.
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
     * Compares this with another <code>AccesspointI18n</code> instance.  If
     * <code>obj</code> is an instance of <code>AccesspointI18n</code>, delegates to
     * <code>equals(AccesspointI18n)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|AccesspointI18n The current object, for fluid interface
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
     * Get the [locale] column value.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
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
     * Get the [pcontact] column value.
     *
     * @return string
     */
    public function getPcontact()
    {
        return $this->pcontact;
    }

    /**
     * Get the [detail_url] column value.
     *
     * @return string
     */
    public function getDetailUrl()
    {
        return $this->detail_url;
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
     * Get the [strip_title] column value.
     *
     * @return string
     */
    public function getStripTitle()
    {
        return $this->strip_title;
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
     * Get the [content] column value.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the [tag] column value.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Get the [keyword] column value.
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Get the [post_by] column value.
     *
     * @return string
     */
    public function getPostBy()
    {
        return $this->post_by;
    }

    /**
     * Get the [edit_by] column value.
     *
     * @return string
     */
    public function getEditBy()
    {
        return $this->edit_by;
    }

    /**
     * Get the [short_link] column value.
     *
     * @return string
     */
    public function getShortLink()
    {
        return $this->short_link;
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
     * Get the [trash] column value.
     *
     * @return boolean
     */
    public function getTrash()
    {
        return $this->trash;
    }

    /**
     * Get the [trash] column value.
     *
     * @return boolean
     */
    public function isTrash()
    {
        return $this->getTrash();
    }

    /**
     * Get the [status] column value.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [pre_status] column value.
     *
     * @return string
     */
    public function getPreStatus()
    {
        return $this->pre_status;
    }

    /**
     * Get the [status_note] column value.
     *
     * @return string
     */
    public function getStatusNote()
    {
        return $this->status_note;
    }

    /**
     * Get the [draft] column value.
     *
     * @return boolean
     */
    public function getDraft()
    {
        return $this->draft;
    }

    /**
     * Get the [draft] column value.
     *
     * @return boolean
     */
    public function isDraft()
    {
        return $this->getDraft();
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_ID] = true;
        }

        if ($this->aAccesspoint !== null && $this->aAccesspoint->getId() !== $v) {
            $this->aAccesspoint = null;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [locale] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setLocale($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->locale !== $v) {
            $this->locale = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_LOCALE] = true;
        }

        return $this;
    } // setLocale()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [address] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Set the value of [pcontact] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setPcontact($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pcontact !== $v) {
            $this->pcontact = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_PCONTACT] = true;
        }

        return $this;
    } // setPcontact()

    /**
     * Set the value of [detail_url] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setDetailUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->detail_url !== $v) {
            $this->detail_url = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_DETAIL_URL] = true;
        }

        return $this;
    } // setDetailUrl()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [strip_title] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setStripTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->strip_title !== $v) {
            $this->strip_title = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_STRIP_TITLE] = true;
        }

        return $this;
    } // setStripTitle()

    /**
     * Set the value of [brief] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setBrief($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->brief !== $v) {
            $this->brief = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_BRIEF] = true;
        }

        return $this;
    } // setBrief()

    /**
     * Set the value of [content] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setContent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->content !== $v) {
            $this->content = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_CONTENT] = true;
        }

        return $this;
    } // setContent()

    /**
     * Set the value of [tag] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setTag($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tag !== $v) {
            $this->tag = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_TAG] = true;
        }

        return $this;
    } // setTag()

    /**
     * Set the value of [keyword] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setKeyword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->keyword !== $v) {
            $this->keyword = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_KEYWORD] = true;
        }

        return $this;
    } // setKeyword()

    /**
     * Set the value of [post_by] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setPostBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->post_by !== $v) {
            $this->post_by = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_POST_BY] = true;
        }

        return $this;
    } // setPostBy()

    /**
     * Set the value of [edit_by] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setEditBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->edit_by !== $v) {
            $this->edit_by = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_EDIT_BY] = true;
        }

        return $this;
    } // setEditBy()

    /**
     * Set the value of [short_link] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setShortLink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->short_link !== $v) {
            $this->short_link = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_SHORT_LINK] = true;
        }

        return $this;
    } // setShortLink()

    /**
     * Set the value of [link] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setLink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->link !== $v) {
            $this->link = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_LINK] = true;
        }

        return $this;
    } // setLink()

    /**
     * Sets the value of the [locked] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
            $this->modifiedColumns[AccesspointI18nTableMap::COL_LOCKED] = true;
        }

        return $this;
    } // setLocked()

    /**
     * Sets the value of the [trash] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setTrash($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->trash !== $v) {
            $this->trash = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_TRASH] = true;
        }

        return $this;
    } // setTrash()

    /**
     * Set the value of [status] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [pre_status] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setPreStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pre_status !== $v) {
            $this->pre_status = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_PRE_STATUS] = true;
        }

        return $this;
    } // setPreStatus()

    /**
     * Set the value of [status_note] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setStatusNote($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status_note !== $v) {
            $this->status_note = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_STATUS_NOTE] = true;
        }

        return $this;
    } // setStatusNote()

    /**
     * Sets the value of the [draft] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setDraft($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->draft !== $v) {
            $this->draft = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_DRAFT] = true;
        }

        return $this;
    } // setDraft()

    /**
     * Set the value of [read] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     */
    public function setRead($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->read !== $v) {
            $this->read = $v;
            $this->modifiedColumns[AccesspointI18nTableMap::COL_READ] = true;
        }

        return $this;
    } // setRead()

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
            if ($this->locale !== 'vi') {
                return false;
            }

            if ($this->read !== 0) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AccesspointI18nTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AccesspointI18nTableMap::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locale = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AccesspointI18nTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AccesspointI18nTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AccesspointI18nTableMap::translateFieldName('Pcontact', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pcontact = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AccesspointI18nTableMap::translateFieldName('DetailUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->detail_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AccesspointI18nTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AccesspointI18nTableMap::translateFieldName('StripTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->strip_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AccesspointI18nTableMap::translateFieldName('Brief', TableMap::TYPE_PHPNAME, $indexType)];
            $this->brief = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AccesspointI18nTableMap::translateFieldName('Content', TableMap::TYPE_PHPNAME, $indexType)];
            $this->content = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : AccesspointI18nTableMap::translateFieldName('Tag', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tag = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : AccesspointI18nTableMap::translateFieldName('Keyword', TableMap::TYPE_PHPNAME, $indexType)];
            $this->keyword = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : AccesspointI18nTableMap::translateFieldName('PostBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->post_by = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : AccesspointI18nTableMap::translateFieldName('EditBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->edit_by = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : AccesspointI18nTableMap::translateFieldName('ShortLink', TableMap::TYPE_PHPNAME, $indexType)];
            $this->short_link = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : AccesspointI18nTableMap::translateFieldName('Link', TableMap::TYPE_PHPNAME, $indexType)];
            $this->link = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : AccesspointI18nTableMap::translateFieldName('Locked', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locked = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : AccesspointI18nTableMap::translateFieldName('Trash', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trash = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : AccesspointI18nTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : AccesspointI18nTableMap::translateFieldName('PreStatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pre_status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : AccesspointI18nTableMap::translateFieldName('StatusNote', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status_note = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : AccesspointI18nTableMap::translateFieldName('Draft', TableMap::TYPE_PHPNAME, $indexType)];
            $this->draft = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : AccesspointI18nTableMap::translateFieldName('Read', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 23; // 23 = AccesspointI18nTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Hotspot\\AccessPointBundle\\Model\\AccesspointI18n'), 0, $e);
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
        if ($this->aAccesspoint !== null && $this->id !== $this->aAccesspoint->getId()) {
            $this->aAccesspoint = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(AccesspointI18nTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAccesspointI18nQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAccesspoint = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see AccesspointI18n::setDeleted()
     * @see AccesspointI18n::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointI18nTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAccesspointI18nQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointI18nTableMap::DATABASE_NAME);
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
                AccesspointI18nTableMap::addInstanceToPool($this);
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

            if ($this->aAccesspoint !== null) {
                if ($this->aAccesspoint->isModified() || $this->aAccesspoint->isNew()) {
                    $affectedRows += $this->aAccesspoint->save($con);
                }
                $this->setAccesspoint($this->aAccesspoint);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_LOCALE)) {
            $modifiedColumns[':p' . $index++]  = '`locale`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = '`address`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_PCONTACT)) {
            $modifiedColumns[':p' . $index++]  = '`pcontact`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_DETAIL_URL)) {
            $modifiedColumns[':p' . $index++]  = '`detail_url`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_STRIP_TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`strip_title`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_BRIEF)) {
            $modifiedColumns[':p' . $index++]  = '`brief`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = '`content`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_TAG)) {
            $modifiedColumns[':p' . $index++]  = '`tag`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_KEYWORD)) {
            $modifiedColumns[':p' . $index++]  = '`keyword`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_POST_BY)) {
            $modifiedColumns[':p' . $index++]  = '`post_by`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_EDIT_BY)) {
            $modifiedColumns[':p' . $index++]  = '`edit_by`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_SHORT_LINK)) {
            $modifiedColumns[':p' . $index++]  = '`short_link`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_LINK)) {
            $modifiedColumns[':p' . $index++]  = '`link`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_LOCKED)) {
            $modifiedColumns[':p' . $index++]  = '`locked`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_TRASH)) {
            $modifiedColumns[':p' . $index++]  = '`trash`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`status`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_PRE_STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`pre_status`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_STATUS_NOTE)) {
            $modifiedColumns[':p' . $index++]  = '`status_note`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_DRAFT)) {
            $modifiedColumns[':p' . $index++]  = '`draft`';
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_READ)) {
            $modifiedColumns[':p' . $index++]  = '`read`';
        }

        $sql = sprintf(
            'INSERT INTO `accesspoint_i18n` (%s) VALUES (%s)',
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
                    case '`locale`':
                        $stmt->bindValue($identifier, $this->locale, PDO::PARAM_STR);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`address`':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case '`pcontact`':
                        $stmt->bindValue($identifier, $this->pcontact, PDO::PARAM_STR);
                        break;
                    case '`detail_url`':
                        $stmt->bindValue($identifier, $this->detail_url, PDO::PARAM_STR);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`strip_title`':
                        $stmt->bindValue($identifier, $this->strip_title, PDO::PARAM_STR);
                        break;
                    case '`brief`':
                        $stmt->bindValue($identifier, $this->brief, PDO::PARAM_STR);
                        break;
                    case '`content`':
                        $stmt->bindValue($identifier, $this->content, PDO::PARAM_STR);
                        break;
                    case '`tag`':
                        $stmt->bindValue($identifier, $this->tag, PDO::PARAM_STR);
                        break;
                    case '`keyword`':
                        $stmt->bindValue($identifier, $this->keyword, PDO::PARAM_STR);
                        break;
                    case '`post_by`':
                        $stmt->bindValue($identifier, $this->post_by, PDO::PARAM_STR);
                        break;
                    case '`edit_by`':
                        $stmt->bindValue($identifier, $this->edit_by, PDO::PARAM_STR);
                        break;
                    case '`short_link`':
                        $stmt->bindValue($identifier, $this->short_link, PDO::PARAM_STR);
                        break;
                    case '`link`':
                        $stmt->bindValue($identifier, $this->link, PDO::PARAM_STR);
                        break;
                    case '`locked`':
                        $stmt->bindValue($identifier, (int) $this->locked, PDO::PARAM_INT);
                        break;
                    case '`trash`':
                        $stmt->bindValue($identifier, (int) $this->trash, PDO::PARAM_INT);
                        break;
                    case '`status`':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case '`pre_status`':
                        $stmt->bindValue($identifier, $this->pre_status, PDO::PARAM_STR);
                        break;
                    case '`status_note`':
                        $stmt->bindValue($identifier, $this->status_note, PDO::PARAM_STR);
                        break;
                    case '`draft`':
                        $stmt->bindValue($identifier, (int) $this->draft, PDO::PARAM_INT);
                        break;
                    case '`read`':
                        $stmt->bindValue($identifier, $this->read, PDO::PARAM_INT);
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
        $pos = AccesspointI18nTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getLocale();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getAddress();
                break;
            case 4:
                return $this->getPcontact();
                break;
            case 5:
                return $this->getDetailUrl();
                break;
            case 6:
                return $this->getTitle();
                break;
            case 7:
                return $this->getStripTitle();
                break;
            case 8:
                return $this->getBrief();
                break;
            case 9:
                return $this->getContent();
                break;
            case 10:
                return $this->getTag();
                break;
            case 11:
                return $this->getKeyword();
                break;
            case 12:
                return $this->getPostBy();
                break;
            case 13:
                return $this->getEditBy();
                break;
            case 14:
                return $this->getShortLink();
                break;
            case 15:
                return $this->getLink();
                break;
            case 16:
                return $this->getLocked();
                break;
            case 17:
                return $this->getTrash();
                break;
            case 18:
                return $this->getStatus();
                break;
            case 19:
                return $this->getPreStatus();
                break;
            case 20:
                return $this->getStatusNote();
                break;
            case 21:
                return $this->getDraft();
                break;
            case 22:
                return $this->getRead();
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

        if (isset($alreadyDumpedObjects['AccesspointI18n'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AccesspointI18n'][$this->hashCode()] = true;
        $keys = AccesspointI18nTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getLocale(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getAddress(),
            $keys[4] => $this->getPcontact(),
            $keys[5] => $this->getDetailUrl(),
            $keys[6] => $this->getTitle(),
            $keys[7] => $this->getStripTitle(),
            $keys[8] => $this->getBrief(),
            $keys[9] => $this->getContent(),
            $keys[10] => $this->getTag(),
            $keys[11] => $this->getKeyword(),
            $keys[12] => $this->getPostBy(),
            $keys[13] => $this->getEditBy(),
            $keys[14] => $this->getShortLink(),
            $keys[15] => $this->getLink(),
            $keys[16] => $this->getLocked(),
            $keys[17] => $this->getTrash(),
            $keys[18] => $this->getStatus(),
            $keys[19] => $this->getPreStatus(),
            $keys[20] => $this->getStatusNote(),
            $keys[21] => $this->getDraft(),
            $keys[22] => $this->getRead(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAccesspoint) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'accesspoint';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'accesspoint';
                        break;
                    default:
                        $key = 'Accesspoint';
                }

                $result[$key] = $this->aAccesspoint->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AccesspointI18nTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setLocale($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setAddress($value);
                break;
            case 4:
                $this->setPcontact($value);
                break;
            case 5:
                $this->setDetailUrl($value);
                break;
            case 6:
                $this->setTitle($value);
                break;
            case 7:
                $this->setStripTitle($value);
                break;
            case 8:
                $this->setBrief($value);
                break;
            case 9:
                $this->setContent($value);
                break;
            case 10:
                $this->setTag($value);
                break;
            case 11:
                $this->setKeyword($value);
                break;
            case 12:
                $this->setPostBy($value);
                break;
            case 13:
                $this->setEditBy($value);
                break;
            case 14:
                $this->setShortLink($value);
                break;
            case 15:
                $this->setLink($value);
                break;
            case 16:
                $this->setLocked($value);
                break;
            case 17:
                $this->setTrash($value);
                break;
            case 18:
                $this->setStatus($value);
                break;
            case 19:
                $this->setPreStatus($value);
                break;
            case 20:
                $this->setStatusNote($value);
                break;
            case 21:
                $this->setDraft($value);
                break;
            case 22:
                $this->setRead($value);
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
        $keys = AccesspointI18nTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLocale($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setAddress($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPcontact($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDetailUrl($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setTitle($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setStripTitle($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setBrief($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setContent($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setTag($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setKeyword($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setPostBy($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setEditBy($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setShortLink($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setLink($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setLocked($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setTrash($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setStatus($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setPreStatus($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setStatusNote($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setDraft($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setRead($arr[$keys[22]]);
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
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object, for fluid interface
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
        $criteria = new Criteria(AccesspointI18nTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AccesspointI18nTableMap::COL_ID)) {
            $criteria->add(AccesspointI18nTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_LOCALE)) {
            $criteria->add(AccesspointI18nTableMap::COL_LOCALE, $this->locale);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_NAME)) {
            $criteria->add(AccesspointI18nTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_ADDRESS)) {
            $criteria->add(AccesspointI18nTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_PCONTACT)) {
            $criteria->add(AccesspointI18nTableMap::COL_PCONTACT, $this->pcontact);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_DETAIL_URL)) {
            $criteria->add(AccesspointI18nTableMap::COL_DETAIL_URL, $this->detail_url);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_TITLE)) {
            $criteria->add(AccesspointI18nTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_STRIP_TITLE)) {
            $criteria->add(AccesspointI18nTableMap::COL_STRIP_TITLE, $this->strip_title);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_BRIEF)) {
            $criteria->add(AccesspointI18nTableMap::COL_BRIEF, $this->brief);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_CONTENT)) {
            $criteria->add(AccesspointI18nTableMap::COL_CONTENT, $this->content);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_TAG)) {
            $criteria->add(AccesspointI18nTableMap::COL_TAG, $this->tag);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_KEYWORD)) {
            $criteria->add(AccesspointI18nTableMap::COL_KEYWORD, $this->keyword);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_POST_BY)) {
            $criteria->add(AccesspointI18nTableMap::COL_POST_BY, $this->post_by);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_EDIT_BY)) {
            $criteria->add(AccesspointI18nTableMap::COL_EDIT_BY, $this->edit_by);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_SHORT_LINK)) {
            $criteria->add(AccesspointI18nTableMap::COL_SHORT_LINK, $this->short_link);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_LINK)) {
            $criteria->add(AccesspointI18nTableMap::COL_LINK, $this->link);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_LOCKED)) {
            $criteria->add(AccesspointI18nTableMap::COL_LOCKED, $this->locked);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_TRASH)) {
            $criteria->add(AccesspointI18nTableMap::COL_TRASH, $this->trash);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_STATUS)) {
            $criteria->add(AccesspointI18nTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_PRE_STATUS)) {
            $criteria->add(AccesspointI18nTableMap::COL_PRE_STATUS, $this->pre_status);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_STATUS_NOTE)) {
            $criteria->add(AccesspointI18nTableMap::COL_STATUS_NOTE, $this->status_note);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_DRAFT)) {
            $criteria->add(AccesspointI18nTableMap::COL_DRAFT, $this->draft);
        }
        if ($this->isColumnModified(AccesspointI18nTableMap::COL_READ)) {
            $criteria->add(AccesspointI18nTableMap::COL_READ, $this->read);
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
        $criteria = ChildAccesspointI18nQuery::create();
        $criteria->add(AccesspointI18nTableMap::COL_ID, $this->id);
        $criteria->add(AccesspointI18nTableMap::COL_LOCALE, $this->locale);

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
        $validPk = null !== $this->getId() &&
            null !== $this->getLocale();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation accesspoint_i18n_fk_085207 to table accesspoint
        if ($this->aAccesspoint && $hash = spl_object_hash($this->aAccesspoint)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

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
        $pks[0] = $this->getId();
        $pks[1] = $this->getLocale();

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
        $this->setId($keys[0]);
        $this->setLocale($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getId()) && (null === $this->getLocale());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Hotspot\AccessPointBundle\Model\AccesspointI18n (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setLocale($this->getLocale());
        $copyObj->setName($this->getName());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setPcontact($this->getPcontact());
        $copyObj->setDetailUrl($this->getDetailUrl());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setStripTitle($this->getStripTitle());
        $copyObj->setBrief($this->getBrief());
        $copyObj->setContent($this->getContent());
        $copyObj->setTag($this->getTag());
        $copyObj->setKeyword($this->getKeyword());
        $copyObj->setPostBy($this->getPostBy());
        $copyObj->setEditBy($this->getEditBy());
        $copyObj->setShortLink($this->getShortLink());
        $copyObj->setLink($this->getLink());
        $copyObj->setLocked($this->getLocked());
        $copyObj->setTrash($this->getTrash());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setPreStatus($this->getPreStatus());
        $copyObj->setStatusNote($this->getStatusNote());
        $copyObj->setDraft($this->getDraft());
        $copyObj->setRead($this->getRead());
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
     * @return \Hotspot\AccessPointBundle\Model\AccesspointI18n Clone of current object.
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
     * Declares an association between this object and a ChildAccesspoint object.
     *
     * @param  ChildAccesspoint $v
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAccesspoint(ChildAccesspoint $v = null)
    {
        if ($v === null) {
            $this->setId(NULL);
        } else {
            $this->setId($v->getId());
        }

        $this->aAccesspoint = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAccesspoint object, it will not be re-added.
        if ($v !== null) {
            $v->addAccesspointI18n($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAccesspoint object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAccesspoint The associated ChildAccesspoint object.
     * @throws PropelException
     */
    public function getAccesspoint(ConnectionInterface $con = null)
    {
        if ($this->aAccesspoint === null && ($this->id !== null)) {
            $this->aAccesspoint = ChildAccesspointQuery::create()->findPk($this->id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAccesspoint->addAccesspointI18ns($this);
             */
        }

        return $this->aAccesspoint;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aAccesspoint) {
            $this->aAccesspoint->removeAccesspointI18n($this);
        }
        $this->id = null;
        $this->locale = null;
        $this->name = null;
        $this->address = null;
        $this->pcontact = null;
        $this->detail_url = null;
        $this->title = null;
        $this->strip_title = null;
        $this->brief = null;
        $this->content = null;
        $this->tag = null;
        $this->keyword = null;
        $this->post_by = null;
        $this->edit_by = null;
        $this->short_link = null;
        $this->link = null;
        $this->locked = null;
        $this->trash = null;
        $this->status = null;
        $this->pre_status = null;
        $this->status_note = null;
        $this->draft = null;
        $this->read = null;
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

        $this->aAccesspoint = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'title' column
     */
    public function __toString()
    {
        return (string) $this->getTitle();
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
