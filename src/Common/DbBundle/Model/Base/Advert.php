<?php

namespace Common\DbBundle\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Common\DbBundle\Model\Advert as ChildAdvert;
use Common\DbBundle\Model\AdvertI18n as ChildAdvertI18n;
use Common\DbBundle\Model\AdvertI18nQuery as ChildAdvertI18nQuery;
use Common\DbBundle\Model\AdvertQuery as ChildAdvertQuery;
use Common\DbBundle\Model\Bundle as ChildBundle;
use Common\DbBundle\Model\BundleQuery as ChildBundleQuery;
use Common\DbBundle\Model\Customer as ChildCustomer;
use Common\DbBundle\Model\CustomerQuery as ChildCustomerQuery;
use Common\DbBundle\Model\Section as ChildSection;
use Common\DbBundle\Model\SectionQuery as ChildSectionQuery;
use Common\DbBundle\Model\Map\AdvertI18nTableMap;
use Common\DbBundle\Model\Map\AdvertTableMap;
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
 * Base class that represents a row from the 'advert' table.
 *
 *
 *
 * @package    propel.generator.src.Common.DbBundle.Model.Base
 */
abstract class Advert implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Common\\DbBundle\\Model\\Map\\AdvertTableMap';


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
     * The value for the bundle_id field.
     *
     * @var        int
     */
    protected $bundle_id;

    /**
     * The value for the section_link_id field.
     *
     * @var        int
     */
    protected $section_link_id;

    /**
     * The value for the bundle_link_id field.
     *
     * @var        int
     */
    protected $bundle_link_id;

    /**
     * The value for the view_at_homepage field.
     *
     * @var        boolean
     */
    protected $view_at_homepage;

    /**
     * The value for the home_position field.
     *
     * @var        string
     */
    protected $home_position;

    /**
     * The value for the view_at_section field.
     *
     * @var        boolean
     */
    protected $view_at_section;

    /**
     * The value for the section_position field.
     *
     * @var        string
     */
    protected $section_position;

    /**
     * The value for the location field.
     *
     * @var        string
     */
    protected $location;

    /**
     * The value for the company field.
     *
     * @var        string
     */
    protected $company;

    /**
     * The value for the platform field.
     *
     * @var        string
     */
    protected $platform;

    /**
     * The value for the platform_version field.
     *
     * @var        string
     */
    protected $platform_version;

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
     * The value for the expired_at field.
     *
     * @var        DateTime
     */
    protected $expired_at;

    /**
     * The value for the customer_id field.
     *
     * @var        int
     */
    protected $customer_id;

    /**
     * The value for the ratio field.
     *
     * Note: this column has a database default value of: 1.0
     * @var        double
     */
    protected $ratio;

    /**
     * The value for the daily_limit field.
     *
     * @var        int
     */
    protected $daily_limit;

    /**
     * The value for the draft field.
     *
     * @var        boolean
     */
    protected $draft;

    /**
     * The value for the img field.
     *
     * @var        string
     */
    protected $img;

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
     * The value for the type field.
     *
     * @var        int
     */
    protected $type;

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
     * @var        ChildCustomer
     */
    protected $aCustomer;

    /**
     * @var        ChildBundle
     */
    protected $aBundle;

    /**
     * @var        ObjectCollection|ChildAdvertI18n[] Collection to store aggregation of ChildAdvertI18n objects.
     */
    protected $collAdvertI18ns;
    protected $collAdvertI18nsPartial;

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
     * @var        array[ChildAdvertI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAdvertI18n[]
     */
    protected $advertI18nsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->ratio = 1.0;
    }

    /**
     * Initializes internal state of Common\DbBundle\Model\Base\Advert object.
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
     * Compares this with another <code>Advert</code> instance.  If
     * <code>obj</code> is an instance of <code>Advert</code>, delegates to
     * <code>equals(Advert)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Advert The current object, for fluid interface
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
     * Get the [bundle_id] column value.
     *
     * @return int
     */
    public function getBundleId()
    {
        return $this->bundle_id;
    }

    /**
     * Get the [section_link_id] column value.
     *
     * @return int
     */
    public function getSectionLinkId()
    {
        return $this->section_link_id;
    }

    /**
     * Get the [bundle_link_id] column value.
     *
     * @return int
     */
    public function getBundleLinkId()
    {
        return $this->bundle_link_id;
    }

    /**
     * Get the [view_at_homepage] column value.
     *
     * @return boolean
     */
    public function getViewAtHomepage()
    {
        return $this->view_at_homepage;
    }

    /**
     * Get the [view_at_homepage] column value.
     *
     * @return boolean
     */
    public function isViewAtHomepage()
    {
        return $this->getViewAtHomepage();
    }

    /**
     * Get the [home_position] column value.
     *
     * @return string
     */
    public function getHomePosition()
    {
        return $this->home_position;
    }

    /**
     * Get the [view_at_section] column value.
     *
     * @return boolean
     */
    public function getViewAtSection()
    {
        return $this->view_at_section;
    }

    /**
     * Get the [view_at_section] column value.
     *
     * @return boolean
     */
    public function isViewAtSection()
    {
        return $this->getViewAtSection();
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
     * Get the [location] column value.
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get the [company] column value.
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Get the [platform] column value.
     *
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Get the [platform_version] column value.
     *
     * @return string
     */
    public function getPlatformVersion()
    {
        return $this->platform_version;
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
     * Get the [customer_id] column value.
     *
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Get the [ratio] column value.
     *
     * @return double
     */
    public function getRatio()
    {
        return $this->ratio;
    }

    /**
     * Get the [daily_limit] column value.
     *
     * @return int
     */
    public function getDailyLimit()
    {
        return $this->daily_limit;
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
     * Get the [img] column value.
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
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
     * Get the [type] column value.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
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
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[AdvertTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [section_id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setSectionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->section_id !== $v) {
            $this->section_id = $v;
            $this->modifiedColumns[AdvertTableMap::COL_SECTION_ID] = true;
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
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setSubsectionIds($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subsection_ids !== $v) {
            $this->subsection_ids = $v;
            $this->modifiedColumns[AdvertTableMap::COL_SUBSECTION_IDS] = true;
        }

        return $this;
    } // setSubsectionIds()

    /**
     * Set the value of [bundle_id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setBundleId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->bundle_id !== $v) {
            $this->bundle_id = $v;
            $this->modifiedColumns[AdvertTableMap::COL_BUNDLE_ID] = true;
        }

        if ($this->aBundle !== null && $this->aBundle->getId() !== $v) {
            $this->aBundle = null;
        }

        return $this;
    } // setBundleId()

    /**
     * Set the value of [section_link_id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setSectionLinkId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->section_link_id !== $v) {
            $this->section_link_id = $v;
            $this->modifiedColumns[AdvertTableMap::COL_SECTION_LINK_ID] = true;
        }

        return $this;
    } // setSectionLinkId()

    /**
     * Set the value of [bundle_link_id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setBundleLinkId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->bundle_link_id !== $v) {
            $this->bundle_link_id = $v;
            $this->modifiedColumns[AdvertTableMap::COL_BUNDLE_LINK_ID] = true;
        }

        return $this;
    } // setBundleLinkId()

    /**
     * Sets the value of the [view_at_homepage] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setViewAtHomepage($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->view_at_homepage !== $v) {
            $this->view_at_homepage = $v;
            $this->modifiedColumns[AdvertTableMap::COL_VIEW_AT_HOMEPAGE] = true;
        }

        return $this;
    } // setViewAtHomepage()

    /**
     * Set the value of [home_position] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setHomePosition($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->home_position !== $v) {
            $this->home_position = $v;
            $this->modifiedColumns[AdvertTableMap::COL_HOME_POSITION] = true;
        }

        return $this;
    } // setHomePosition()

    /**
     * Sets the value of the [view_at_section] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setViewAtSection($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->view_at_section !== $v) {
            $this->view_at_section = $v;
            $this->modifiedColumns[AdvertTableMap::COL_VIEW_AT_SECTION] = true;
        }

        return $this;
    } // setViewAtSection()

    /**
     * Set the value of [section_position] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setSectionPosition($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->section_position !== $v) {
            $this->section_position = $v;
            $this->modifiedColumns[AdvertTableMap::COL_SECTION_POSITION] = true;
        }

        return $this;
    } // setSectionPosition()

    /**
     * Set the value of [location] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setLocation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->location !== $v) {
            $this->location = $v;
            $this->modifiedColumns[AdvertTableMap::COL_LOCATION] = true;
        }

        return $this;
    } // setLocation()

    /**
     * Set the value of [company] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setCompany($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->company !== $v) {
            $this->company = $v;
            $this->modifiedColumns[AdvertTableMap::COL_COMPANY] = true;
        }

        return $this;
    } // setCompany()

    /**
     * Set the value of [platform] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setPlatform($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->platform !== $v) {
            $this->platform = $v;
            $this->modifiedColumns[AdvertTableMap::COL_PLATFORM] = true;
        }

        return $this;
    } // setPlatform()

    /**
     * Set the value of [platform_version] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setPlatformVersion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->platform_version !== $v) {
            $this->platform_version = $v;
            $this->modifiedColumns[AdvertTableMap::COL_PLATFORM_VERSION] = true;
        }

        return $this;
    } // setPlatformVersion()

    /**
     * Sets the value of the [can_delete] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
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
            $this->modifiedColumns[AdvertTableMap::COL_CAN_DELETE] = true;
        }

        return $this;
    } // setCanDelete()

    /**
     * Sets the value of [published_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setPublishedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->published_at !== null || $dt !== null) {
            if ($this->published_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->published_at->format("Y-m-d H:i:s.u")) {
                $this->published_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AdvertTableMap::COL_PUBLISHED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setPublishedAt()

    /**
     * Sets the value of [expired_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setExpiredAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->expired_at !== null || $dt !== null) {
            if ($this->expired_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->expired_at->format("Y-m-d H:i:s.u")) {
                $this->expired_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AdvertTableMap::COL_EXPIRED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setExpiredAt()

    /**
     * Set the value of [customer_id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setCustomerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->customer_id !== $v) {
            $this->customer_id = $v;
            $this->modifiedColumns[AdvertTableMap::COL_CUSTOMER_ID] = true;
        }

        if ($this->aCustomer !== null && $this->aCustomer->getId() !== $v) {
            $this->aCustomer = null;
        }

        return $this;
    } // setCustomerId()

    /**
     * Set the value of [ratio] column.
     *
     * @param double $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setRatio($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->ratio !== $v) {
            $this->ratio = $v;
            $this->modifiedColumns[AdvertTableMap::COL_RATIO] = true;
        }

        return $this;
    } // setRatio()

    /**
     * Set the value of [daily_limit] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setDailyLimit($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->daily_limit !== $v) {
            $this->daily_limit = $v;
            $this->modifiedColumns[AdvertTableMap::COL_DAILY_LIMIT] = true;
        }

        return $this;
    } // setDailyLimit()

    /**
     * Sets the value of the [draft] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
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
            $this->modifiedColumns[AdvertTableMap::COL_DRAFT] = true;
        }

        return $this;
    } // setDraft()

    /**
     * Set the value of [img] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setImg($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->img !== $v) {
            $this->img = $v;
            $this->modifiedColumns[AdvertTableMap::COL_IMG] = true;
        }

        return $this;
    } // setImg()

    /**
     * Set the value of [imgs] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setImgs($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->imgs !== $v) {
            $this->imgs = $v;
            $this->modifiedColumns[AdvertTableMap::COL_IMGS] = true;
        }

        return $this;
    } // setImgs()

    /**
     * Set the value of [imgs_sizes] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setImgsSizes($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->imgs_sizes !== $v) {
            $this->imgs_sizes = $v;
            $this->modifiedColumns[AdvertTableMap::COL_IMGS_SIZES] = true;
        }

        return $this;
    } // setImgsSizes()

    /**
     * Set the value of [type] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[AdvertTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AdvertTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AdvertTableMap::COL_UPDATED_AT] = true;
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
            if ($this->ratio !== 1.0) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AdvertTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AdvertTableMap::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->section_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AdvertTableMap::translateFieldName('SubsectionIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subsection_ids = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AdvertTableMap::translateFieldName('BundleId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bundle_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AdvertTableMap::translateFieldName('SectionLinkId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->section_link_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AdvertTableMap::translateFieldName('BundleLinkId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bundle_link_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AdvertTableMap::translateFieldName('ViewAtHomepage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->view_at_homepage = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AdvertTableMap::translateFieldName('HomePosition', TableMap::TYPE_PHPNAME, $indexType)];
            $this->home_position = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AdvertTableMap::translateFieldName('ViewAtSection', TableMap::TYPE_PHPNAME, $indexType)];
            $this->view_at_section = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AdvertTableMap::translateFieldName('SectionPosition', TableMap::TYPE_PHPNAME, $indexType)];
            $this->section_position = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : AdvertTableMap::translateFieldName('Location', TableMap::TYPE_PHPNAME, $indexType)];
            $this->location = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : AdvertTableMap::translateFieldName('Company', TableMap::TYPE_PHPNAME, $indexType)];
            $this->company = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : AdvertTableMap::translateFieldName('Platform', TableMap::TYPE_PHPNAME, $indexType)];
            $this->platform = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : AdvertTableMap::translateFieldName('PlatformVersion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->platform_version = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : AdvertTableMap::translateFieldName('CanDelete', TableMap::TYPE_PHPNAME, $indexType)];
            $this->can_delete = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : AdvertTableMap::translateFieldName('PublishedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->published_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : AdvertTableMap::translateFieldName('ExpiredAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->expired_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : AdvertTableMap::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->customer_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : AdvertTableMap::translateFieldName('Ratio', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ratio = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : AdvertTableMap::translateFieldName('DailyLimit', TableMap::TYPE_PHPNAME, $indexType)];
            $this->daily_limit = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : AdvertTableMap::translateFieldName('Draft', TableMap::TYPE_PHPNAME, $indexType)];
            $this->draft = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : AdvertTableMap::translateFieldName('Img', TableMap::TYPE_PHPNAME, $indexType)];
            $this->img = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : AdvertTableMap::translateFieldName('Imgs', TableMap::TYPE_PHPNAME, $indexType)];
            $this->imgs = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : AdvertTableMap::translateFieldName('ImgsSizes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->imgs_sizes = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : AdvertTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : AdvertTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : AdvertTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 27; // 27 = AdvertTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Common\\DbBundle\\Model\\Advert'), 0, $e);
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
        if ($this->aBundle !== null && $this->bundle_id !== $this->aBundle->getId()) {
            $this->aBundle = null;
        }
        if ($this->aCustomer !== null && $this->customer_id !== $this->aCustomer->getId()) {
            $this->aCustomer = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(AdvertTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAdvertQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSection = null;
            $this->aCustomer = null;
            $this->aBundle = null;
            $this->collAdvertI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Advert::setDeleted()
     * @see Advert::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAdvertQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(AdvertTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(AdvertTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(AdvertTableMap::COL_UPDATED_AT)) {
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
                AdvertTableMap::addInstanceToPool($this);
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

            if ($this->aCustomer !== null) {
                if ($this->aCustomer->isModified() || $this->aCustomer->isNew()) {
                    $affectedRows += $this->aCustomer->save($con);
                }
                $this->setCustomer($this->aCustomer);
            }

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

            if ($this->advertI18nsScheduledForDeletion !== null) {
                if (!$this->advertI18nsScheduledForDeletion->isEmpty()) {
                    \Common\DbBundle\Model\AdvertI18nQuery::create()
                        ->filterByPrimaryKeys($this->advertI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->advertI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collAdvertI18ns !== null) {
                foreach ($this->collAdvertI18ns as $referrerFK) {
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

        $this->modifiedColumns[AdvertTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AdvertTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AdvertTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_SECTION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`section_id`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_SUBSECTION_IDS)) {
            $modifiedColumns[':p' . $index++]  = '`subsection_ids`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_BUNDLE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`bundle_id`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_SECTION_LINK_ID)) {
            $modifiedColumns[':p' . $index++]  = '`section_link_id`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_BUNDLE_LINK_ID)) {
            $modifiedColumns[':p' . $index++]  = '`bundle_link_id`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_VIEW_AT_HOMEPAGE)) {
            $modifiedColumns[':p' . $index++]  = '`view_at_homepage`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_HOME_POSITION)) {
            $modifiedColumns[':p' . $index++]  = '`home_position`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_VIEW_AT_SECTION)) {
            $modifiedColumns[':p' . $index++]  = '`view_at_section`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_SECTION_POSITION)) {
            $modifiedColumns[':p' . $index++]  = '`section_position`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_LOCATION)) {
            $modifiedColumns[':p' . $index++]  = '`location`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_COMPANY)) {
            $modifiedColumns[':p' . $index++]  = '`company`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_PLATFORM)) {
            $modifiedColumns[':p' . $index++]  = '`platform`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_PLATFORM_VERSION)) {
            $modifiedColumns[':p' . $index++]  = '`platform_version`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_CAN_DELETE)) {
            $modifiedColumns[':p' . $index++]  = '`can_delete`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_PUBLISHED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`published_at`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_EXPIRED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`expired_at`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_CUSTOMER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`customer_id`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_RATIO)) {
            $modifiedColumns[':p' . $index++]  = '`ratio`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_DAILY_LIMIT)) {
            $modifiedColumns[':p' . $index++]  = '`daily_limit`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_DRAFT)) {
            $modifiedColumns[':p' . $index++]  = '`draft`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_IMG)) {
            $modifiedColumns[':p' . $index++]  = '`img`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_IMGS)) {
            $modifiedColumns[':p' . $index++]  = '`imgs`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_IMGS_SIZES)) {
            $modifiedColumns[':p' . $index++]  = '`imgs_sizes`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(AdvertTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `advert` (%s) VALUES (%s)',
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
                    case '`bundle_id`':
                        $stmt->bindValue($identifier, $this->bundle_id, PDO::PARAM_INT);
                        break;
                    case '`section_link_id`':
                        $stmt->bindValue($identifier, $this->section_link_id, PDO::PARAM_INT);
                        break;
                    case '`bundle_link_id`':
                        $stmt->bindValue($identifier, $this->bundle_link_id, PDO::PARAM_INT);
                        break;
                    case '`view_at_homepage`':
                        $stmt->bindValue($identifier, (int) $this->view_at_homepage, PDO::PARAM_INT);
                        break;
                    case '`home_position`':
                        $stmt->bindValue($identifier, $this->home_position, PDO::PARAM_STR);
                        break;
                    case '`view_at_section`':
                        $stmt->bindValue($identifier, (int) $this->view_at_section, PDO::PARAM_INT);
                        break;
                    case '`section_position`':
                        $stmt->bindValue($identifier, $this->section_position, PDO::PARAM_STR);
                        break;
                    case '`location`':
                        $stmt->bindValue($identifier, $this->location, PDO::PARAM_STR);
                        break;
                    case '`company`':
                        $stmt->bindValue($identifier, $this->company, PDO::PARAM_STR);
                        break;
                    case '`platform`':
                        $stmt->bindValue($identifier, $this->platform, PDO::PARAM_STR);
                        break;
                    case '`platform_version`':
                        $stmt->bindValue($identifier, $this->platform_version, PDO::PARAM_STR);
                        break;
                    case '`can_delete`':
                        $stmt->bindValue($identifier, (int) $this->can_delete, PDO::PARAM_INT);
                        break;
                    case '`published_at`':
                        $stmt->bindValue($identifier, $this->published_at ? $this->published_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case '`expired_at`':
                        $stmt->bindValue($identifier, $this->expired_at ? $this->expired_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case '`customer_id`':
                        $stmt->bindValue($identifier, $this->customer_id, PDO::PARAM_INT);
                        break;
                    case '`ratio`':
                        $stmt->bindValue($identifier, $this->ratio, PDO::PARAM_STR);
                        break;
                    case '`daily_limit`':
                        $stmt->bindValue($identifier, $this->daily_limit, PDO::PARAM_INT);
                        break;
                    case '`draft`':
                        $stmt->bindValue($identifier, (int) $this->draft, PDO::PARAM_INT);
                        break;
                    case '`img`':
                        $stmt->bindValue($identifier, $this->img, PDO::PARAM_STR);
                        break;
                    case '`imgs`':
                        $stmt->bindValue($identifier, $this->imgs, PDO::PARAM_STR);
                        break;
                    case '`imgs_sizes`':
                        $stmt->bindValue($identifier, $this->imgs_sizes, PDO::PARAM_STR);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
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
        $pos = AdvertTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getBundleId();
                break;
            case 4:
                return $this->getSectionLinkId();
                break;
            case 5:
                return $this->getBundleLinkId();
                break;
            case 6:
                return $this->getViewAtHomepage();
                break;
            case 7:
                return $this->getHomePosition();
                break;
            case 8:
                return $this->getViewAtSection();
                break;
            case 9:
                return $this->getSectionPosition();
                break;
            case 10:
                return $this->getLocation();
                break;
            case 11:
                return $this->getCompany();
                break;
            case 12:
                return $this->getPlatform();
                break;
            case 13:
                return $this->getPlatformVersion();
                break;
            case 14:
                return $this->getCanDelete();
                break;
            case 15:
                return $this->getPublishedAt();
                break;
            case 16:
                return $this->getExpiredAt();
                break;
            case 17:
                return $this->getCustomerId();
                break;
            case 18:
                return $this->getRatio();
                break;
            case 19:
                return $this->getDailyLimit();
                break;
            case 20:
                return $this->getDraft();
                break;
            case 21:
                return $this->getImg();
                break;
            case 22:
                return $this->getImgs();
                break;
            case 23:
                return $this->getImgsSizes();
                break;
            case 24:
                return $this->getType();
                break;
            case 25:
                return $this->getCreatedAt();
                break;
            case 26:
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

        if (isset($alreadyDumpedObjects['Advert'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Advert'][$this->hashCode()] = true;
        $keys = AdvertTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getSectionId(),
            $keys[2] => $this->getSubsectionIds(),
            $keys[3] => $this->getBundleId(),
            $keys[4] => $this->getSectionLinkId(),
            $keys[5] => $this->getBundleLinkId(),
            $keys[6] => $this->getViewAtHomepage(),
            $keys[7] => $this->getHomePosition(),
            $keys[8] => $this->getViewAtSection(),
            $keys[9] => $this->getSectionPosition(),
            $keys[10] => $this->getLocation(),
            $keys[11] => $this->getCompany(),
            $keys[12] => $this->getPlatform(),
            $keys[13] => $this->getPlatformVersion(),
            $keys[14] => $this->getCanDelete(),
            $keys[15] => $this->getPublishedAt(),
            $keys[16] => $this->getExpiredAt(),
            $keys[17] => $this->getCustomerId(),
            $keys[18] => $this->getRatio(),
            $keys[19] => $this->getDailyLimit(),
            $keys[20] => $this->getDraft(),
            $keys[21] => $this->getImg(),
            $keys[22] => $this->getImgs(),
            $keys[23] => $this->getImgsSizes(),
            $keys[24] => $this->getType(),
            $keys[25] => $this->getCreatedAt(),
            $keys[26] => $this->getUpdatedAt(),
        );
        if ($result[$keys[15]] instanceof \DateTimeInterface) {
            $result[$keys[15]] = $result[$keys[15]]->format('c');
        }

        if ($result[$keys[16]] instanceof \DateTimeInterface) {
            $result[$keys[16]] = $result[$keys[16]]->format('c');
        }

        if ($result[$keys[25]] instanceof \DateTimeInterface) {
            $result[$keys[25]] = $result[$keys[25]]->format('c');
        }

        if ($result[$keys[26]] instanceof \DateTimeInterface) {
            $result[$keys[26]] = $result[$keys[26]]->format('c');
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
            if (null !== $this->aCustomer) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'customer';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'customer';
                        break;
                    default:
                        $key = 'Customer';
                }

                $result[$key] = $this->aCustomer->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
            if (null !== $this->collAdvertI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'advertI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'advert_i18ns';
                        break;
                    default:
                        $key = 'AdvertI18ns';
                }

                $result[$key] = $this->collAdvertI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Common\DbBundle\Model\Advert
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AdvertTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Common\DbBundle\Model\Advert
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
                $this->setBundleId($value);
                break;
            case 4:
                $this->setSectionLinkId($value);
                break;
            case 5:
                $this->setBundleLinkId($value);
                break;
            case 6:
                $this->setViewAtHomepage($value);
                break;
            case 7:
                $this->setHomePosition($value);
                break;
            case 8:
                $this->setViewAtSection($value);
                break;
            case 9:
                $this->setSectionPosition($value);
                break;
            case 10:
                $this->setLocation($value);
                break;
            case 11:
                $this->setCompany($value);
                break;
            case 12:
                $this->setPlatform($value);
                break;
            case 13:
                $this->setPlatformVersion($value);
                break;
            case 14:
                $this->setCanDelete($value);
                break;
            case 15:
                $this->setPublishedAt($value);
                break;
            case 16:
                $this->setExpiredAt($value);
                break;
            case 17:
                $this->setCustomerId($value);
                break;
            case 18:
                $this->setRatio($value);
                break;
            case 19:
                $this->setDailyLimit($value);
                break;
            case 20:
                $this->setDraft($value);
                break;
            case 21:
                $this->setImg($value);
                break;
            case 22:
                $this->setImgs($value);
                break;
            case 23:
                $this->setImgsSizes($value);
                break;
            case 24:
                $this->setType($value);
                break;
            case 25:
                $this->setCreatedAt($value);
                break;
            case 26:
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
        $keys = AdvertTableMap::getFieldNames($keyType);

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
            $this->setBundleId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setSectionLinkId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setBundleLinkId($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setViewAtHomepage($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setHomePosition($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setViewAtSection($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setSectionPosition($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setLocation($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setCompany($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setPlatform($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setPlatformVersion($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setCanDelete($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setPublishedAt($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setExpiredAt($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setCustomerId($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setRatio($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setDailyLimit($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setDraft($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setImg($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setImgs($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->setImgsSizes($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->setType($arr[$keys[24]]);
        }
        if (array_key_exists($keys[25], $arr)) {
            $this->setCreatedAt($arr[$keys[25]]);
        }
        if (array_key_exists($keys[26], $arr)) {
            $this->setUpdatedAt($arr[$keys[26]]);
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
     * @return $this|\Common\DbBundle\Model\Advert The current object, for fluid interface
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
        $criteria = new Criteria(AdvertTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AdvertTableMap::COL_ID)) {
            $criteria->add(AdvertTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_SECTION_ID)) {
            $criteria->add(AdvertTableMap::COL_SECTION_ID, $this->section_id);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_SUBSECTION_IDS)) {
            $criteria->add(AdvertTableMap::COL_SUBSECTION_IDS, $this->subsection_ids);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_BUNDLE_ID)) {
            $criteria->add(AdvertTableMap::COL_BUNDLE_ID, $this->bundle_id);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_SECTION_LINK_ID)) {
            $criteria->add(AdvertTableMap::COL_SECTION_LINK_ID, $this->section_link_id);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_BUNDLE_LINK_ID)) {
            $criteria->add(AdvertTableMap::COL_BUNDLE_LINK_ID, $this->bundle_link_id);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_VIEW_AT_HOMEPAGE)) {
            $criteria->add(AdvertTableMap::COL_VIEW_AT_HOMEPAGE, $this->view_at_homepage);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_HOME_POSITION)) {
            $criteria->add(AdvertTableMap::COL_HOME_POSITION, $this->home_position);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_VIEW_AT_SECTION)) {
            $criteria->add(AdvertTableMap::COL_VIEW_AT_SECTION, $this->view_at_section);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_SECTION_POSITION)) {
            $criteria->add(AdvertTableMap::COL_SECTION_POSITION, $this->section_position);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_LOCATION)) {
            $criteria->add(AdvertTableMap::COL_LOCATION, $this->location);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_COMPANY)) {
            $criteria->add(AdvertTableMap::COL_COMPANY, $this->company);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_PLATFORM)) {
            $criteria->add(AdvertTableMap::COL_PLATFORM, $this->platform);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_PLATFORM_VERSION)) {
            $criteria->add(AdvertTableMap::COL_PLATFORM_VERSION, $this->platform_version);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_CAN_DELETE)) {
            $criteria->add(AdvertTableMap::COL_CAN_DELETE, $this->can_delete);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_PUBLISHED_AT)) {
            $criteria->add(AdvertTableMap::COL_PUBLISHED_AT, $this->published_at);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_EXPIRED_AT)) {
            $criteria->add(AdvertTableMap::COL_EXPIRED_AT, $this->expired_at);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_CUSTOMER_ID)) {
            $criteria->add(AdvertTableMap::COL_CUSTOMER_ID, $this->customer_id);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_RATIO)) {
            $criteria->add(AdvertTableMap::COL_RATIO, $this->ratio);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_DAILY_LIMIT)) {
            $criteria->add(AdvertTableMap::COL_DAILY_LIMIT, $this->daily_limit);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_DRAFT)) {
            $criteria->add(AdvertTableMap::COL_DRAFT, $this->draft);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_IMG)) {
            $criteria->add(AdvertTableMap::COL_IMG, $this->img);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_IMGS)) {
            $criteria->add(AdvertTableMap::COL_IMGS, $this->imgs);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_IMGS_SIZES)) {
            $criteria->add(AdvertTableMap::COL_IMGS_SIZES, $this->imgs_sizes);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_TYPE)) {
            $criteria->add(AdvertTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_CREATED_AT)) {
            $criteria->add(AdvertTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(AdvertTableMap::COL_UPDATED_AT)) {
            $criteria->add(AdvertTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildAdvertQuery::create();
        $criteria->add(AdvertTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Common\DbBundle\Model\Advert (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSectionId($this->getSectionId());
        $copyObj->setSubsectionIds($this->getSubsectionIds());
        $copyObj->setBundleId($this->getBundleId());
        $copyObj->setSectionLinkId($this->getSectionLinkId());
        $copyObj->setBundleLinkId($this->getBundleLinkId());
        $copyObj->setViewAtHomepage($this->getViewAtHomepage());
        $copyObj->setHomePosition($this->getHomePosition());
        $copyObj->setViewAtSection($this->getViewAtSection());
        $copyObj->setSectionPosition($this->getSectionPosition());
        $copyObj->setLocation($this->getLocation());
        $copyObj->setCompany($this->getCompany());
        $copyObj->setPlatform($this->getPlatform());
        $copyObj->setPlatformVersion($this->getPlatformVersion());
        $copyObj->setCanDelete($this->getCanDelete());
        $copyObj->setPublishedAt($this->getPublishedAt());
        $copyObj->setExpiredAt($this->getExpiredAt());
        $copyObj->setCustomerId($this->getCustomerId());
        $copyObj->setRatio($this->getRatio());
        $copyObj->setDailyLimit($this->getDailyLimit());
        $copyObj->setDraft($this->getDraft());
        $copyObj->setImg($this->getImg());
        $copyObj->setImgs($this->getImgs());
        $copyObj->setImgsSizes($this->getImgsSizes());
        $copyObj->setType($this->getType());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAdvertI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvertI18n($relObj->copy($deepCopy));
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
     * @return \Common\DbBundle\Model\Advert Clone of current object.
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
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
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
            $v->addAdvert($this);
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
                $this->aSection->addAdverts($this);
             */
        }

        return $this->aSection;
    }

    /**
     * Declares an association between this object and a ChildCustomer object.
     *
     * @param  ChildCustomer $v
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCustomer(ChildCustomer $v = null)
    {
        if ($v === null) {
            $this->setCustomerId(NULL);
        } else {
            $this->setCustomerId($v->getId());
        }

        $this->aCustomer = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCustomer object, it will not be re-added.
        if ($v !== null) {
            $v->addAdvert($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCustomer object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCustomer The associated ChildCustomer object.
     * @throws PropelException
     */
    public function getCustomer(ConnectionInterface $con = null)
    {
        if ($this->aCustomer === null && ($this->customer_id !== null)) {
            $this->aCustomer = ChildCustomerQuery::create()->findPk($this->customer_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCustomer->addAdverts($this);
             */
        }

        return $this->aCustomer;
    }

    /**
     * Declares an association between this object and a ChildBundle object.
     *
     * @param  ChildBundle $v
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBundle(ChildBundle $v = null)
    {
        if ($v === null) {
            $this->setBundleId(NULL);
        } else {
            $this->setBundleId($v->getId());
        }

        $this->aBundle = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildBundle object, it will not be re-added.
        if ($v !== null) {
            $v->addAdvert($this);
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
                $this->aBundle->addAdverts($this);
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
        if ('AdvertI18n' == $relationName) {
            $this->initAdvertI18ns();
            return;
        }
    }

    /**
     * Clears out the collAdvertI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAdvertI18ns()
     */
    public function clearAdvertI18ns()
    {
        $this->collAdvertI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAdvertI18ns collection loaded partially.
     */
    public function resetPartialAdvertI18ns($v = true)
    {
        $this->collAdvertI18nsPartial = $v;
    }

    /**
     * Initializes the collAdvertI18ns collection.
     *
     * By default this just sets the collAdvertI18ns collection to an empty array (like clearcollAdvertI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdvertI18ns($overrideExisting = true)
    {
        if (null !== $this->collAdvertI18ns && !$overrideExisting) {
            return;
        }

        $collectionClassName = AdvertI18nTableMap::getTableMap()->getCollectionClassName();

        $this->collAdvertI18ns = new $collectionClassName;
        $this->collAdvertI18ns->setModel('\Common\DbBundle\Model\AdvertI18n');
    }

    /**
     * Gets an array of ChildAdvertI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAdvert is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAdvertI18n[] List of ChildAdvertI18n objects
     * @throws PropelException
     */
    public function getAdvertI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAdvertI18nsPartial && !$this->isNew();
        if (null === $this->collAdvertI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvertI18ns) {
                // return empty collection
                $this->initAdvertI18ns();
            } else {
                $collAdvertI18ns = ChildAdvertI18nQuery::create(null, $criteria)
                    ->filterByAdvert($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAdvertI18nsPartial && count($collAdvertI18ns)) {
                        $this->initAdvertI18ns(false);

                        foreach ($collAdvertI18ns as $obj) {
                            if (false == $this->collAdvertI18ns->contains($obj)) {
                                $this->collAdvertI18ns->append($obj);
                            }
                        }

                        $this->collAdvertI18nsPartial = true;
                    }

                    return $collAdvertI18ns;
                }

                if ($partial && $this->collAdvertI18ns) {
                    foreach ($this->collAdvertI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collAdvertI18ns[] = $obj;
                        }
                    }
                }

                $this->collAdvertI18ns = $collAdvertI18ns;
                $this->collAdvertI18nsPartial = false;
            }
        }

        return $this->collAdvertI18ns;
    }

    /**
     * Sets a collection of ChildAdvertI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $advertI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAdvert The current object (for fluent API support)
     */
    public function setAdvertI18ns(Collection $advertI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildAdvertI18n[] $advertI18nsToDelete */
        $advertI18nsToDelete = $this->getAdvertI18ns(new Criteria(), $con)->diff($advertI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->advertI18nsScheduledForDeletion = clone $advertI18nsToDelete;

        foreach ($advertI18nsToDelete as $advertI18nRemoved) {
            $advertI18nRemoved->setAdvert(null);
        }

        $this->collAdvertI18ns = null;
        foreach ($advertI18ns as $advertI18n) {
            $this->addAdvertI18n($advertI18n);
        }

        $this->collAdvertI18ns = $advertI18ns;
        $this->collAdvertI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdvertI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AdvertI18n objects.
     * @throws PropelException
     */
    public function countAdvertI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAdvertI18nsPartial && !$this->isNew();
        if (null === $this->collAdvertI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdvertI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdvertI18ns());
            }

            $query = ChildAdvertI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdvert($this)
                ->count($con);
        }

        return count($this->collAdvertI18ns);
    }

    /**
     * Method called to associate a ChildAdvertI18n object to this object
     * through the ChildAdvertI18n foreign key attribute.
     *
     * @param  ChildAdvertI18n $l ChildAdvertI18n
     * @return $this|\Common\DbBundle\Model\Advert The current object (for fluent API support)
     */
    public function addAdvertI18n(ChildAdvertI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collAdvertI18ns === null) {
            $this->initAdvertI18ns();
            $this->collAdvertI18nsPartial = true;
        }

        if (!$this->collAdvertI18ns->contains($l)) {
            $this->doAddAdvertI18n($l);

            if ($this->advertI18nsScheduledForDeletion and $this->advertI18nsScheduledForDeletion->contains($l)) {
                $this->advertI18nsScheduledForDeletion->remove($this->advertI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAdvertI18n $advertI18n The ChildAdvertI18n object to add.
     */
    protected function doAddAdvertI18n(ChildAdvertI18n $advertI18n)
    {
        $this->collAdvertI18ns[]= $advertI18n;
        $advertI18n->setAdvert($this);
    }

    /**
     * @param  ChildAdvertI18n $advertI18n The ChildAdvertI18n object to remove.
     * @return $this|ChildAdvert The current object (for fluent API support)
     */
    public function removeAdvertI18n(ChildAdvertI18n $advertI18n)
    {
        if ($this->getAdvertI18ns()->contains($advertI18n)) {
            $pos = $this->collAdvertI18ns->search($advertI18n);
            $this->collAdvertI18ns->remove($pos);
            if (null === $this->advertI18nsScheduledForDeletion) {
                $this->advertI18nsScheduledForDeletion = clone $this->collAdvertI18ns;
                $this->advertI18nsScheduledForDeletion->clear();
            }
            $this->advertI18nsScheduledForDeletion[]= clone $advertI18n;
            $advertI18n->setAdvert(null);
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
            $this->aSection->removeAdvert($this);
        }
        if (null !== $this->aCustomer) {
            $this->aCustomer->removeAdvert($this);
        }
        if (null !== $this->aBundle) {
            $this->aBundle->removeAdvert($this);
        }
        $this->id = null;
        $this->section_id = null;
        $this->subsection_ids = null;
        $this->bundle_id = null;
        $this->section_link_id = null;
        $this->bundle_link_id = null;
        $this->view_at_homepage = null;
        $this->home_position = null;
        $this->view_at_section = null;
        $this->section_position = null;
        $this->location = null;
        $this->company = null;
        $this->platform = null;
        $this->platform_version = null;
        $this->can_delete = null;
        $this->published_at = null;
        $this->expired_at = null;
        $this->customer_id = null;
        $this->ratio = null;
        $this->daily_limit = null;
        $this->draft = null;
        $this->img = null;
        $this->imgs = null;
        $this->imgs_sizes = null;
        $this->type = null;
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
            if ($this->collAdvertI18ns) {
                foreach ($this->collAdvertI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'vi';
        $this->currentTranslations = null;

        $this->collAdvertI18ns = null;
        $this->aSection = null;
        $this->aCustomer = null;
        $this->aBundle = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AdvertTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildAdvert The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[AdvertTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildAdvert The current object (for fluent API support)
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
     * @return ChildAdvertI18n */
    public function getTranslation($locale = 'vi', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collAdvertI18ns) {
                foreach ($this->collAdvertI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildAdvertI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildAdvertI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addAdvertI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildAdvert The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'vi', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildAdvertI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collAdvertI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collAdvertI18ns[$key]);
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
     * @return ChildAdvertI18n */
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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
         */
        public function setTitle($v)
        {    $this->getCurrentTranslation()->setTitle($v);

        return $this;
    }


        /**
         * Get the [description] column value.
         *
         * @return string
         */
        public function getDescription()
        {
        return $this->getCurrentTranslation()->getDescription();
    }


        /**
         * Set the value of [description] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
         */
        public function setDescription($v)
        {    $this->getCurrentTranslation()->setDescription($v);

        return $this;
    }


        /**
         * Get the [campagin] column value.
         *
         * @return string
         */
        public function getCampagin()
        {
        return $this->getCurrentTranslation()->getCampagin();
    }


        /**
         * Set the value of [campagin] column.
         *
         * @param string $v new value
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
         */
        public function setCampagin($v)
        {    $this->getCurrentTranslation()->setCampagin($v);

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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
         */
        public function setLinkTo($v)
        {    $this->getCurrentTranslation()->setLinkTo($v);

        return $this;
    }


        /**
         * Get the [view] column value.
         *
         * @return int
         */
        public function getView()
        {
        return $this->getCurrentTranslation()->getView();
    }


        /**
         * Set the value of [view] column.
         *
         * @param int $v new value
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
         */
        public function setView($v)
        {    $this->getCurrentTranslation()->setView($v);

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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
         */
        public function setTrash($v)
        {    $this->getCurrentTranslation()->setTrash($v);

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
         * @return $this|\Common\DbBundle\Model\AdvertI18n The current object (for fluent API support)
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
