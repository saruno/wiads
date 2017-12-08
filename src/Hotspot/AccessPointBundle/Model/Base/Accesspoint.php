<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Common\DbBundle\Model\Customer;
use Common\DbBundle\Model\CustomerQuery;
use Common\DbBundle\Model\Section;
use Common\DbBundle\Model\SectionQuery;
use Hotspot\AccessPointBundle\Model\Accesspoint as ChildAccesspoint;
use Hotspot\AccessPointBundle\Model\AccesspointCategory as ChildAccesspointCategory;
use Hotspot\AccessPointBundle\Model\AccesspointCategoryQuery as ChildAccesspointCategoryQuery;
use Hotspot\AccessPointBundle\Model\AccesspointI18n as ChildAccesspointI18n;
use Hotspot\AccessPointBundle\Model\AccesspointI18nQuery as ChildAccesspointI18nQuery;
use Hotspot\AccessPointBundle\Model\AccesspointQuery as ChildAccesspointQuery;
use Hotspot\AccessPointBundle\Model\Map\AccesspointI18nTableMap;
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
 * Base class that represents a row from the 'accesspoint' table.
 *
 *
 *
 * @package    propel.generator.src.Hotspot.AccessPointBundle.Model.Base
 */
abstract class Accesspoint implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Hotspot\\AccessPointBundle\\Model\\Map\\AccesspointTableMap';


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
     * The value for the macaddr field.
     *
     * @var        string
     */
    protected $macaddr;

    /**
     * The value for the ap_macaddr field.
     *
     * @var        string
     */
    protected $ap_macaddr;

    /**
     * The value for the fw_version field.
     *
     * @var        string
     */
    protected $fw_version;

    /**
     * The value for the isp field.
     *
     * @var        string
     */
    protected $isp;

    /**
     * The value for the ssid field.
     *
     * @var        string
     */
    protected $ssid;

    /**
     * The value for the key field.
     *
     * @var        string
     */
    protected $key;

    /**
     * The value for the province field.
     *
     * @var        string
     */
    protected $province;

    /**
     * The value for the ads_location field.
     *
     * @var        string
     */
    protected $ads_location;

    /**
     * The value for the login_template field.
     *
     * @var        string
     */
    protected $login_template;

    /**
     * The value for the image field.
     *
     * @var        string
     */
    protected $image;

    /**
     * The value for the category_id field.
     *
     * @var        int
     */
    protected $category_id;

    /**
     * The value for the lng field.
     *
     * @var        string
     */
    protected $lng;

    /**
     * The value for the lat field.
     *
     * @var        string
     */
    protected $lat;

    /**
     * The value for the detail_url_id field.
     *
     * @var        string
     */
    protected $detail_url_id;

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
     * The value for the owner field.
     *
     * @var        string
     */
    protected $owner;

    /**
     * The value for the customer_id field.
     *
     * @var        int
     */
    protected $customer_id;

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
     * @var        Customer
     */
    protected $aCustomer;

    /**
     * @var        Section
     */
    protected $aSection;

    /**
     * @var        ChildAccesspointCategory
     */
    protected $aAccesspointCategory;

    /**
     * @var        ObjectCollection|ChildAccesspointI18n[] Collection to store aggregation of ChildAccesspointI18n objects.
     */
    protected $collAccesspointI18ns;
    protected $collAccesspointI18nsPartial;

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
     * @var        array[ChildAccesspointI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAccesspointI18n[]
     */
    protected $accesspointI18nsScheduledForDeletion = null;

    /**
     * Initializes internal state of Hotspot\AccessPointBundle\Model\Base\Accesspoint object.
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
     * Compares this with another <code>Accesspoint</code> instance.  If
     * <code>obj</code> is an instance of <code>Accesspoint</code>, delegates to
     * <code>equals(Accesspoint)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Accesspoint The current object, for fluid interface
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
     * Get the [macaddr] column value.
     *
     * @return string
     */
    public function getMacaddr()
    {
        return $this->macaddr;
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
     * Get the [fw_version] column value.
     *
     * @return string
     */
    public function getFwVersion()
    {
        return $this->fw_version;
    }

    /**
     * Get the [isp] column value.
     *
     * @return string
     */
    public function getIsp()
    {
        return $this->isp;
    }

    /**
     * Get the [ssid] column value.
     *
     * @return string
     */
    public function getSsid()
    {
        return $this->ssid;
    }

    /**
     * Get the [key] column value.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get the [province] column value.
     *
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Get the [ads_location] column value.
     *
     * @return string
     */
    public function getAdsLocation()
    {
        return $this->ads_location;
    }

    /**
     * Get the [login_template] column value.
     *
     * @return string
     */
    public function getLoginTemplate()
    {
        return $this->login_template;
    }

    /**
     * Get the [image] column value.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get the [category_id] column value.
     *
     * @return int
     */
    public function getCategoryId()
    {
        return $this->category_id;
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
     * Get the [lat] column value.
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Get the [detail_url_id] column value.
     *
     * @return string
     */
    public function getDetailUrlId()
    {
        return $this->detail_url_id;
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
     * Get the [owner] column value.
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
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
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [macaddr] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setMacaddr($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->macaddr !== $v) {
            $this->macaddr = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_MACADDR] = true;
        }

        return $this;
    } // setMacaddr()

    /**
     * Set the value of [ap_macaddr] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setApMacaddr($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ap_macaddr !== $v) {
            $this->ap_macaddr = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_AP_MACADDR] = true;
        }

        return $this;
    } // setApMacaddr()

    /**
     * Set the value of [fw_version] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setFwVersion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fw_version !== $v) {
            $this->fw_version = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_FW_VERSION] = true;
        }

        return $this;
    } // setFwVersion()

    /**
     * Set the value of [isp] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setIsp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->isp !== $v) {
            $this->isp = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_ISP] = true;
        }

        return $this;
    } // setIsp()

    /**
     * Set the value of [ssid] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setSsid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ssid !== $v) {
            $this->ssid = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_SSID] = true;
        }

        return $this;
    } // setSsid()

    /**
     * Set the value of [key] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->key !== $v) {
            $this->key = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_KEY] = true;
        }

        return $this;
    } // setKey()

    /**
     * Set the value of [province] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setProvince($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->province !== $v) {
            $this->province = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_PROVINCE] = true;
        }

        return $this;
    } // setProvince()

    /**
     * Set the value of [ads_location] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setAdsLocation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ads_location !== $v) {
            $this->ads_location = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_ADS_LOCATION] = true;
        }

        return $this;
    } // setAdsLocation()

    /**
     * Set the value of [login_template] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setLoginTemplate($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->login_template !== $v) {
            $this->login_template = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_LOGIN_TEMPLATE] = true;
        }

        return $this;
    } // setLoginTemplate()

    /**
     * Set the value of [image] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setImage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->image !== $v) {
            $this->image = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_IMAGE] = true;
        }

        return $this;
    } // setImage()

    /**
     * Set the value of [category_id] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_CATEGORY_ID] = true;
        }

        if ($this->aAccesspointCategory !== null && $this->aAccesspointCategory->getId() !== $v) {
            $this->aAccesspointCategory = null;
        }

        return $this;
    } // setCategoryId()

    /**
     * Set the value of [lng] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setLng($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lng !== $v) {
            $this->lng = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_LNG] = true;
        }

        return $this;
    } // setLng()

    /**
     * Set the value of [lat] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setLat($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lat !== $v) {
            $this->lat = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_LAT] = true;
        }

        return $this;
    } // setLat()

    /**
     * Set the value of [detail_url_id] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setDetailUrlId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->detail_url_id !== $v) {
            $this->detail_url_id = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_DETAIL_URL_ID] = true;
        }

        return $this;
    } // setDetailUrlId()

    /**
     * Set the value of [section_id] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setSectionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->section_id !== $v) {
            $this->section_id = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_SECTION_ID] = true;
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
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setSubsectionIds($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subsection_ids !== $v) {
            $this->subsection_ids = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_SUBSECTION_IDS] = true;
        }

        return $this;
    } // setSubsectionIds()

    /**
     * Set the value of [orders] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setOrders($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->orders !== $v) {
            $this->orders = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_ORDERS] = true;
        }

        return $this;
    } // setOrders()

    /**
     * Set the value of [suborder_ids] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setSuborderIds($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->suborder_ids !== $v) {
            $this->suborder_ids = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_SUBORDER_IDS] = true;
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
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
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
            $this->modifiedColumns[AccesspointTableMap::COL_FRONT_PAGE] = true;
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
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
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
            $this->modifiedColumns[AccesspointTableMap::COL_HAS_COMMENT] = true;
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
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
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
            $this->modifiedColumns[AccesspointTableMap::COL_CAN_DELETE] = true;
        }

        return $this;
    } // setCanDelete()

    /**
     * Sets the value of [published_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setPublishedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->published_at !== null || $dt !== null) {
            if ($this->published_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->published_at->format("Y-m-d H:i:s.u")) {
                $this->published_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AccesspointTableMap::COL_PUBLISHED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setPublishedAt()

    /**
     * Set the value of [imgs] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setImgs($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->imgs !== $v) {
            $this->imgs = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_IMGS] = true;
        }

        return $this;
    } // setImgs()

    /**
     * Set the value of [relative_news] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setRelativeNews($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->relative_news !== $v) {
            $this->relative_news = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_RELATIVE_NEWS] = true;
        }

        return $this;
    } // setRelativeNews()

    /**
     * Set the value of [owner] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setOwner($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->owner !== $v) {
            $this->owner = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_OWNER] = true;
        }

        return $this;
    } // setOwner()

    /**
     * Set the value of [customer_id] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setCustomerId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->customer_id !== $v) {
            $this->customer_id = $v;
            $this->modifiedColumns[AccesspointTableMap::COL_CUSTOMER_ID] = true;
        }

        if ($this->aCustomer !== null && $this->aCustomer->getId() !== $v) {
            $this->aCustomer = null;
        }

        return $this;
    } // setCustomerId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AccesspointTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AccesspointTableMap::COL_UPDATED_AT] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AccesspointTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AccesspointTableMap::translateFieldName('Macaddr', TableMap::TYPE_PHPNAME, $indexType)];
            $this->macaddr = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AccesspointTableMap::translateFieldName('ApMacaddr', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ap_macaddr = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AccesspointTableMap::translateFieldName('FwVersion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fw_version = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AccesspointTableMap::translateFieldName('Isp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->isp = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AccesspointTableMap::translateFieldName('Ssid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ssid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AccesspointTableMap::translateFieldName('Key', TableMap::TYPE_PHPNAME, $indexType)];
            $this->key = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AccesspointTableMap::translateFieldName('Province', TableMap::TYPE_PHPNAME, $indexType)];
            $this->province = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AccesspointTableMap::translateFieldName('AdsLocation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ads_location = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AccesspointTableMap::translateFieldName('LoginTemplate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->login_template = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : AccesspointTableMap::translateFieldName('Image', TableMap::TYPE_PHPNAME, $indexType)];
            $this->image = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : AccesspointTableMap::translateFieldName('CategoryId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->category_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : AccesspointTableMap::translateFieldName('Lng', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lng = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : AccesspointTableMap::translateFieldName('Lat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lat = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : AccesspointTableMap::translateFieldName('DetailUrlId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->detail_url_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : AccesspointTableMap::translateFieldName('SectionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->section_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : AccesspointTableMap::translateFieldName('SubsectionIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subsection_ids = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : AccesspointTableMap::translateFieldName('Orders', TableMap::TYPE_PHPNAME, $indexType)];
            $this->orders = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : AccesspointTableMap::translateFieldName('SuborderIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->suborder_ids = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : AccesspointTableMap::translateFieldName('FrontPage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->front_page = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : AccesspointTableMap::translateFieldName('HasComment', TableMap::TYPE_PHPNAME, $indexType)];
            $this->has_comment = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : AccesspointTableMap::translateFieldName('CanDelete', TableMap::TYPE_PHPNAME, $indexType)];
            $this->can_delete = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : AccesspointTableMap::translateFieldName('PublishedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->published_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : AccesspointTableMap::translateFieldName('Imgs', TableMap::TYPE_PHPNAME, $indexType)];
            $this->imgs = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : AccesspointTableMap::translateFieldName('RelativeNews', TableMap::TYPE_PHPNAME, $indexType)];
            $this->relative_news = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : AccesspointTableMap::translateFieldName('Owner', TableMap::TYPE_PHPNAME, $indexType)];
            $this->owner = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : AccesspointTableMap::translateFieldName('CustomerId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->customer_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : AccesspointTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : AccesspointTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 29; // 29 = AccesspointTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Hotspot\\AccessPointBundle\\Model\\Accesspoint'), 0, $e);
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
        if ($this->aAccesspointCategory !== null && $this->category_id !== $this->aAccesspointCategory->getId()) {
            $this->aAccesspointCategory = null;
        }
        if ($this->aSection !== null && $this->section_id !== $this->aSection->getId()) {
            $this->aSection = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(AccesspointTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAccesspointQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCustomer = null;
            $this->aSection = null;
            $this->aAccesspointCategory = null;
            $this->collAccesspointI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Accesspoint::setDeleted()
     * @see Accesspoint::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAccesspointQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(AccesspointTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(AccesspointTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(AccesspointTableMap::COL_UPDATED_AT)) {
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
                AccesspointTableMap::addInstanceToPool($this);
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

            if ($this->aCustomer !== null) {
                if ($this->aCustomer->isModified() || $this->aCustomer->isNew()) {
                    $affectedRows += $this->aCustomer->save($con);
                }
                $this->setCustomer($this->aCustomer);
            }

            if ($this->aSection !== null) {
                if ($this->aSection->isModified() || $this->aSection->isNew()) {
                    $affectedRows += $this->aSection->save($con);
                }
                $this->setSection($this->aSection);
            }

            if ($this->aAccesspointCategory !== null) {
                if ($this->aAccesspointCategory->isModified() || $this->aAccesspointCategory->isNew()) {
                    $affectedRows += $this->aAccesspointCategory->save($con);
                }
                $this->setAccesspointCategory($this->aAccesspointCategory);
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

            if ($this->accesspointI18nsScheduledForDeletion !== null) {
                if (!$this->accesspointI18nsScheduledForDeletion->isEmpty()) {
                    \Hotspot\AccessPointBundle\Model\AccesspointI18nQuery::create()
                        ->filterByPrimaryKeys($this->accesspointI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->accesspointI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collAccesspointI18ns !== null) {
                foreach ($this->collAccesspointI18ns as $referrerFK) {
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

        $this->modifiedColumns[AccesspointTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AccesspointTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AccesspointTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_MACADDR)) {
            $modifiedColumns[':p' . $index++]  = '`macaddr`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_AP_MACADDR)) {
            $modifiedColumns[':p' . $index++]  = '`ap_macaddr`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_FW_VERSION)) {
            $modifiedColumns[':p' . $index++]  = '`fw_version`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_ISP)) {
            $modifiedColumns[':p' . $index++]  = '`isp`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_SSID)) {
            $modifiedColumns[':p' . $index++]  = '`ssid`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_KEY)) {
            $modifiedColumns[':p' . $index++]  = '`key`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_PROVINCE)) {
            $modifiedColumns[':p' . $index++]  = '`province`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_ADS_LOCATION)) {
            $modifiedColumns[':p' . $index++]  = '`ads_location`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_LOGIN_TEMPLATE)) {
            $modifiedColumns[':p' . $index++]  = '`login_template`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_IMAGE)) {
            $modifiedColumns[':p' . $index++]  = '`image`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`category_id`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_LNG)) {
            $modifiedColumns[':p' . $index++]  = '`lng`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_LAT)) {
            $modifiedColumns[':p' . $index++]  = '`lat`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_DETAIL_URL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`detail_url_id`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_SECTION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`section_id`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_SUBSECTION_IDS)) {
            $modifiedColumns[':p' . $index++]  = '`subsection_ids`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_ORDERS)) {
            $modifiedColumns[':p' . $index++]  = '`orders`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_SUBORDER_IDS)) {
            $modifiedColumns[':p' . $index++]  = '`suborder_ids`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_FRONT_PAGE)) {
            $modifiedColumns[':p' . $index++]  = '`front_page`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_HAS_COMMENT)) {
            $modifiedColumns[':p' . $index++]  = '`has_comment`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_CAN_DELETE)) {
            $modifiedColumns[':p' . $index++]  = '`can_delete`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_PUBLISHED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`published_at`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_IMGS)) {
            $modifiedColumns[':p' . $index++]  = '`imgs`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_RELATIVE_NEWS)) {
            $modifiedColumns[':p' . $index++]  = '`relative_news`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_OWNER)) {
            $modifiedColumns[':p' . $index++]  = '`owner`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_CUSTOMER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`customer_id`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `accesspoint` (%s) VALUES (%s)',
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
                    case '`macaddr`':
                        $stmt->bindValue($identifier, $this->macaddr, PDO::PARAM_STR);
                        break;
                    case '`ap_macaddr`':
                        $stmt->bindValue($identifier, $this->ap_macaddr, PDO::PARAM_STR);
                        break;
                    case '`fw_version`':
                        $stmt->bindValue($identifier, $this->fw_version, PDO::PARAM_STR);
                        break;
                    case '`isp`':
                        $stmt->bindValue($identifier, $this->isp, PDO::PARAM_STR);
                        break;
                    case '`ssid`':
                        $stmt->bindValue($identifier, $this->ssid, PDO::PARAM_STR);
                        break;
                    case '`key`':
                        $stmt->bindValue($identifier, $this->key, PDO::PARAM_STR);
                        break;
                    case '`province`':
                        $stmt->bindValue($identifier, $this->province, PDO::PARAM_STR);
                        break;
                    case '`ads_location`':
                        $stmt->bindValue($identifier, $this->ads_location, PDO::PARAM_STR);
                        break;
                    case '`login_template`':
                        $stmt->bindValue($identifier, $this->login_template, PDO::PARAM_STR);
                        break;
                    case '`image`':
                        $stmt->bindValue($identifier, $this->image, PDO::PARAM_STR);
                        break;
                    case '`category_id`':
                        $stmt->bindValue($identifier, $this->category_id, PDO::PARAM_INT);
                        break;
                    case '`lng`':
                        $stmt->bindValue($identifier, $this->lng, PDO::PARAM_STR);
                        break;
                    case '`lat`':
                        $stmt->bindValue($identifier, $this->lat, PDO::PARAM_STR);
                        break;
                    case '`detail_url_id`':
                        $stmt->bindValue($identifier, $this->detail_url_id, PDO::PARAM_STR);
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
                    case '`owner`':
                        $stmt->bindValue($identifier, $this->owner, PDO::PARAM_STR);
                        break;
                    case '`customer_id`':
                        $stmt->bindValue($identifier, $this->customer_id, PDO::PARAM_INT);
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
        $pos = AccesspointTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getMacaddr();
                break;
            case 2:
                return $this->getApMacaddr();
                break;
            case 3:
                return $this->getFwVersion();
                break;
            case 4:
                return $this->getIsp();
                break;
            case 5:
                return $this->getSsid();
                break;
            case 6:
                return $this->getKey();
                break;
            case 7:
                return $this->getProvince();
                break;
            case 8:
                return $this->getAdsLocation();
                break;
            case 9:
                return $this->getLoginTemplate();
                break;
            case 10:
                return $this->getImage();
                break;
            case 11:
                return $this->getCategoryId();
                break;
            case 12:
                return $this->getLng();
                break;
            case 13:
                return $this->getLat();
                break;
            case 14:
                return $this->getDetailUrlId();
                break;
            case 15:
                return $this->getSectionId();
                break;
            case 16:
                return $this->getSubsectionIds();
                break;
            case 17:
                return $this->getOrders();
                break;
            case 18:
                return $this->getSuborderIds();
                break;
            case 19:
                return $this->getFrontPage();
                break;
            case 20:
                return $this->getHasComment();
                break;
            case 21:
                return $this->getCanDelete();
                break;
            case 22:
                return $this->getPublishedAt();
                break;
            case 23:
                return $this->getImgs();
                break;
            case 24:
                return $this->getRelativeNews();
                break;
            case 25:
                return $this->getOwner();
                break;
            case 26:
                return $this->getCustomerId();
                break;
            case 27:
                return $this->getCreatedAt();
                break;
            case 28:
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

        if (isset($alreadyDumpedObjects['Accesspoint'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Accesspoint'][$this->hashCode()] = true;
        $keys = AccesspointTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getMacaddr(),
            $keys[2] => $this->getApMacaddr(),
            $keys[3] => $this->getFwVersion(),
            $keys[4] => $this->getIsp(),
            $keys[5] => $this->getSsid(),
            $keys[6] => $this->getKey(),
            $keys[7] => $this->getProvince(),
            $keys[8] => $this->getAdsLocation(),
            $keys[9] => $this->getLoginTemplate(),
            $keys[10] => $this->getImage(),
            $keys[11] => $this->getCategoryId(),
            $keys[12] => $this->getLng(),
            $keys[13] => $this->getLat(),
            $keys[14] => $this->getDetailUrlId(),
            $keys[15] => $this->getSectionId(),
            $keys[16] => $this->getSubsectionIds(),
            $keys[17] => $this->getOrders(),
            $keys[18] => $this->getSuborderIds(),
            $keys[19] => $this->getFrontPage(),
            $keys[20] => $this->getHasComment(),
            $keys[21] => $this->getCanDelete(),
            $keys[22] => $this->getPublishedAt(),
            $keys[23] => $this->getImgs(),
            $keys[24] => $this->getRelativeNews(),
            $keys[25] => $this->getOwner(),
            $keys[26] => $this->getCustomerId(),
            $keys[27] => $this->getCreatedAt(),
            $keys[28] => $this->getUpdatedAt(),
        );
        if ($result[$keys[22]] instanceof \DateTimeInterface) {
            $result[$keys[22]] = $result[$keys[22]]->format('c');
        }

        if ($result[$keys[27]] instanceof \DateTimeInterface) {
            $result[$keys[27]] = $result[$keys[27]]->format('c');
        }

        if ($result[$keys[28]] instanceof \DateTimeInterface) {
            $result[$keys[28]] = $result[$keys[28]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->aAccesspointCategory) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'accesspointCategory';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'accesspoint_category';
                        break;
                    default:
                        $key = 'AccesspointCategory';
                }

                $result[$key] = $this->aAccesspointCategory->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAccesspointI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'accesspointI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'accesspoint_i18ns';
                        break;
                    default:
                        $key = 'AccesspointI18ns';
                }

                $result[$key] = $this->collAccesspointI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AccesspointTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setMacaddr($value);
                break;
            case 2:
                $this->setApMacaddr($value);
                break;
            case 3:
                $this->setFwVersion($value);
                break;
            case 4:
                $this->setIsp($value);
                break;
            case 5:
                $this->setSsid($value);
                break;
            case 6:
                $this->setKey($value);
                break;
            case 7:
                $this->setProvince($value);
                break;
            case 8:
                $this->setAdsLocation($value);
                break;
            case 9:
                $this->setLoginTemplate($value);
                break;
            case 10:
                $this->setImage($value);
                break;
            case 11:
                $this->setCategoryId($value);
                break;
            case 12:
                $this->setLng($value);
                break;
            case 13:
                $this->setLat($value);
                break;
            case 14:
                $this->setDetailUrlId($value);
                break;
            case 15:
                $this->setSectionId($value);
                break;
            case 16:
                $this->setSubsectionIds($value);
                break;
            case 17:
                $this->setOrders($value);
                break;
            case 18:
                $this->setSuborderIds($value);
                break;
            case 19:
                $this->setFrontPage($value);
                break;
            case 20:
                $this->setHasComment($value);
                break;
            case 21:
                $this->setCanDelete($value);
                break;
            case 22:
                $this->setPublishedAt($value);
                break;
            case 23:
                $this->setImgs($value);
                break;
            case 24:
                $this->setRelativeNews($value);
                break;
            case 25:
                $this->setOwner($value);
                break;
            case 26:
                $this->setCustomerId($value);
                break;
            case 27:
                $this->setCreatedAt($value);
                break;
            case 28:
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
        $keys = AccesspointTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setMacaddr($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setApMacaddr($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setFwVersion($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setIsp($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSsid($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setKey($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setProvince($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setAdsLocation($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setLoginTemplate($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setImage($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setCategoryId($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setLng($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setLat($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setDetailUrlId($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setSectionId($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setSubsectionIds($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setOrders($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setSuborderIds($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setFrontPage($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setHasComment($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setCanDelete($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setPublishedAt($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->setImgs($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->setRelativeNews($arr[$keys[24]]);
        }
        if (array_key_exists($keys[25], $arr)) {
            $this->setOwner($arr[$keys[25]]);
        }
        if (array_key_exists($keys[26], $arr)) {
            $this->setCustomerId($arr[$keys[26]]);
        }
        if (array_key_exists($keys[27], $arr)) {
            $this->setCreatedAt($arr[$keys[27]]);
        }
        if (array_key_exists($keys[28], $arr)) {
            $this->setUpdatedAt($arr[$keys[28]]);
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
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object, for fluid interface
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
        $criteria = new Criteria(AccesspointTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AccesspointTableMap::COL_ID)) {
            $criteria->add(AccesspointTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_MACADDR)) {
            $criteria->add(AccesspointTableMap::COL_MACADDR, $this->macaddr);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_AP_MACADDR)) {
            $criteria->add(AccesspointTableMap::COL_AP_MACADDR, $this->ap_macaddr);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_FW_VERSION)) {
            $criteria->add(AccesspointTableMap::COL_FW_VERSION, $this->fw_version);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_ISP)) {
            $criteria->add(AccesspointTableMap::COL_ISP, $this->isp);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_SSID)) {
            $criteria->add(AccesspointTableMap::COL_SSID, $this->ssid);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_KEY)) {
            $criteria->add(AccesspointTableMap::COL_KEY, $this->key);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_PROVINCE)) {
            $criteria->add(AccesspointTableMap::COL_PROVINCE, $this->province);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_ADS_LOCATION)) {
            $criteria->add(AccesspointTableMap::COL_ADS_LOCATION, $this->ads_location);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_LOGIN_TEMPLATE)) {
            $criteria->add(AccesspointTableMap::COL_LOGIN_TEMPLATE, $this->login_template);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_IMAGE)) {
            $criteria->add(AccesspointTableMap::COL_IMAGE, $this->image);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_CATEGORY_ID)) {
            $criteria->add(AccesspointTableMap::COL_CATEGORY_ID, $this->category_id);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_LNG)) {
            $criteria->add(AccesspointTableMap::COL_LNG, $this->lng);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_LAT)) {
            $criteria->add(AccesspointTableMap::COL_LAT, $this->lat);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_DETAIL_URL_ID)) {
            $criteria->add(AccesspointTableMap::COL_DETAIL_URL_ID, $this->detail_url_id);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_SECTION_ID)) {
            $criteria->add(AccesspointTableMap::COL_SECTION_ID, $this->section_id);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_SUBSECTION_IDS)) {
            $criteria->add(AccesspointTableMap::COL_SUBSECTION_IDS, $this->subsection_ids);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_ORDERS)) {
            $criteria->add(AccesspointTableMap::COL_ORDERS, $this->orders);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_SUBORDER_IDS)) {
            $criteria->add(AccesspointTableMap::COL_SUBORDER_IDS, $this->suborder_ids);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_FRONT_PAGE)) {
            $criteria->add(AccesspointTableMap::COL_FRONT_PAGE, $this->front_page);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_HAS_COMMENT)) {
            $criteria->add(AccesspointTableMap::COL_HAS_COMMENT, $this->has_comment);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_CAN_DELETE)) {
            $criteria->add(AccesspointTableMap::COL_CAN_DELETE, $this->can_delete);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_PUBLISHED_AT)) {
            $criteria->add(AccesspointTableMap::COL_PUBLISHED_AT, $this->published_at);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_IMGS)) {
            $criteria->add(AccesspointTableMap::COL_IMGS, $this->imgs);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_RELATIVE_NEWS)) {
            $criteria->add(AccesspointTableMap::COL_RELATIVE_NEWS, $this->relative_news);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_OWNER)) {
            $criteria->add(AccesspointTableMap::COL_OWNER, $this->owner);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_CUSTOMER_ID)) {
            $criteria->add(AccesspointTableMap::COL_CUSTOMER_ID, $this->customer_id);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_CREATED_AT)) {
            $criteria->add(AccesspointTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(AccesspointTableMap::COL_UPDATED_AT)) {
            $criteria->add(AccesspointTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildAccesspointQuery::create();
        $criteria->add(AccesspointTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Hotspot\AccessPointBundle\Model\Accesspoint (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setMacaddr($this->getMacaddr());
        $copyObj->setApMacaddr($this->getApMacaddr());
        $copyObj->setFwVersion($this->getFwVersion());
        $copyObj->setIsp($this->getIsp());
        $copyObj->setSsid($this->getSsid());
        $copyObj->setKey($this->getKey());
        $copyObj->setProvince($this->getProvince());
        $copyObj->setAdsLocation($this->getAdsLocation());
        $copyObj->setLoginTemplate($this->getLoginTemplate());
        $copyObj->setImage($this->getImage());
        $copyObj->setCategoryId($this->getCategoryId());
        $copyObj->setLng($this->getLng());
        $copyObj->setLat($this->getLat());
        $copyObj->setDetailUrlId($this->getDetailUrlId());
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
        $copyObj->setOwner($this->getOwner());
        $copyObj->setCustomerId($this->getCustomerId());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAccesspointI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccesspointI18n($relObj->copy($deepCopy));
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
     * @return \Hotspot\AccessPointBundle\Model\Accesspoint Clone of current object.
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
     * Declares an association between this object and a Customer object.
     *
     * @param  Customer $v
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCustomer(Customer $v = null)
    {
        if ($v === null) {
            $this->setCustomerId(NULL);
        } else {
            $this->setCustomerId($v->getId());
        }

        $this->aCustomer = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Customer object, it will not be re-added.
        if ($v !== null) {
            $v->addAccesspoint($this);
        }


        return $this;
    }


    /**
     * Get the associated Customer object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return Customer The associated Customer object.
     * @throws PropelException
     */
    public function getCustomer(ConnectionInterface $con = null)
    {
        if ($this->aCustomer === null && ($this->customer_id !== null)) {
            $this->aCustomer = CustomerQuery::create()->findPk($this->customer_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCustomer->addAccesspoints($this);
             */
        }

        return $this->aCustomer;
    }

    /**
     * Declares an association between this object and a Section object.
     *
     * @param  Section $v
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSection(Section $v = null)
    {
        if ($v === null) {
            $this->setSectionId(NULL);
        } else {
            $this->setSectionId($v->getId());
        }

        $this->aSection = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Section object, it will not be re-added.
        if ($v !== null) {
            $v->addAccesspoint($this);
        }


        return $this;
    }


    /**
     * Get the associated Section object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return Section The associated Section object.
     * @throws PropelException
     */
    public function getSection(ConnectionInterface $con = null)
    {
        if ($this->aSection === null && ($this->section_id !== null)) {
            $this->aSection = SectionQuery::create()->findPk($this->section_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSection->addAccesspoints($this);
             */
        }

        return $this->aSection;
    }

    /**
     * Declares an association between this object and a ChildAccesspointCategory object.
     *
     * @param  ChildAccesspointCategory $v
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAccesspointCategory(ChildAccesspointCategory $v = null)
    {
        if ($v === null) {
            $this->setCategoryId(NULL);
        } else {
            $this->setCategoryId($v->getId());
        }

        $this->aAccesspointCategory = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAccesspointCategory object, it will not be re-added.
        if ($v !== null) {
            $v->addAccesspoint($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAccesspointCategory object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAccesspointCategory The associated ChildAccesspointCategory object.
     * @throws PropelException
     */
    public function getAccesspointCategory(ConnectionInterface $con = null)
    {
        if ($this->aAccesspointCategory === null && ($this->category_id !== null)) {
            $this->aAccesspointCategory = ChildAccesspointCategoryQuery::create()->findPk($this->category_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAccesspointCategory->addAccesspoints($this);
             */
        }

        return $this->aAccesspointCategory;
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
        if ('AccesspointI18n' == $relationName) {
            $this->initAccesspointI18ns();
            return;
        }
    }

    /**
     * Clears out the collAccesspointI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAccesspointI18ns()
     */
    public function clearAccesspointI18ns()
    {
        $this->collAccesspointI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAccesspointI18ns collection loaded partially.
     */
    public function resetPartialAccesspointI18ns($v = true)
    {
        $this->collAccesspointI18nsPartial = $v;
    }

    /**
     * Initializes the collAccesspointI18ns collection.
     *
     * By default this just sets the collAccesspointI18ns collection to an empty array (like clearcollAccesspointI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAccesspointI18ns($overrideExisting = true)
    {
        if (null !== $this->collAccesspointI18ns && !$overrideExisting) {
            return;
        }

        $collectionClassName = AccesspointI18nTableMap::getTableMap()->getCollectionClassName();

        $this->collAccesspointI18ns = new $collectionClassName;
        $this->collAccesspointI18ns->setModel('\Hotspot\AccessPointBundle\Model\AccesspointI18n');
    }

    /**
     * Gets an array of ChildAccesspointI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAccesspoint is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAccesspointI18n[] List of ChildAccesspointI18n objects
     * @throws PropelException
     */
    public function getAccesspointI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAccesspointI18nsPartial && !$this->isNew();
        if (null === $this->collAccesspointI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAccesspointI18ns) {
                // return empty collection
                $this->initAccesspointI18ns();
            } else {
                $collAccesspointI18ns = ChildAccesspointI18nQuery::create(null, $criteria)
                    ->filterByAccesspoint($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAccesspointI18nsPartial && count($collAccesspointI18ns)) {
                        $this->initAccesspointI18ns(false);

                        foreach ($collAccesspointI18ns as $obj) {
                            if (false == $this->collAccesspointI18ns->contains($obj)) {
                                $this->collAccesspointI18ns->append($obj);
                            }
                        }

                        $this->collAccesspointI18nsPartial = true;
                    }

                    return $collAccesspointI18ns;
                }

                if ($partial && $this->collAccesspointI18ns) {
                    foreach ($this->collAccesspointI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collAccesspointI18ns[] = $obj;
                        }
                    }
                }

                $this->collAccesspointI18ns = $collAccesspointI18ns;
                $this->collAccesspointI18nsPartial = false;
            }
        }

        return $this->collAccesspointI18ns;
    }

    /**
     * Sets a collection of ChildAccesspointI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $accesspointI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAccesspoint The current object (for fluent API support)
     */
    public function setAccesspointI18ns(Collection $accesspointI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildAccesspointI18n[] $accesspointI18nsToDelete */
        $accesspointI18nsToDelete = $this->getAccesspointI18ns(new Criteria(), $con)->diff($accesspointI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->accesspointI18nsScheduledForDeletion = clone $accesspointI18nsToDelete;

        foreach ($accesspointI18nsToDelete as $accesspointI18nRemoved) {
            $accesspointI18nRemoved->setAccesspoint(null);
        }

        $this->collAccesspointI18ns = null;
        foreach ($accesspointI18ns as $accesspointI18n) {
            $this->addAccesspointI18n($accesspointI18n);
        }

        $this->collAccesspointI18ns = $accesspointI18ns;
        $this->collAccesspointI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AccesspointI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AccesspointI18n objects.
     * @throws PropelException
     */
    public function countAccesspointI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAccesspointI18nsPartial && !$this->isNew();
        if (null === $this->collAccesspointI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAccesspointI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAccesspointI18ns());
            }

            $query = ChildAccesspointI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAccesspoint($this)
                ->count($con);
        }

        return count($this->collAccesspointI18ns);
    }

    /**
     * Method called to associate a ChildAccesspointI18n object to this object
     * through the ChildAccesspointI18n foreign key attribute.
     *
     * @param  ChildAccesspointI18n $l ChildAccesspointI18n
     * @return $this|\Hotspot\AccessPointBundle\Model\Accesspoint The current object (for fluent API support)
     */
    public function addAccesspointI18n(ChildAccesspointI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collAccesspointI18ns === null) {
            $this->initAccesspointI18ns();
            $this->collAccesspointI18nsPartial = true;
        }

        if (!$this->collAccesspointI18ns->contains($l)) {
            $this->doAddAccesspointI18n($l);

            if ($this->accesspointI18nsScheduledForDeletion and $this->accesspointI18nsScheduledForDeletion->contains($l)) {
                $this->accesspointI18nsScheduledForDeletion->remove($this->accesspointI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAccesspointI18n $accesspointI18n The ChildAccesspointI18n object to add.
     */
    protected function doAddAccesspointI18n(ChildAccesspointI18n $accesspointI18n)
    {
        $this->collAccesspointI18ns[]= $accesspointI18n;
        $accesspointI18n->setAccesspoint($this);
    }

    /**
     * @param  ChildAccesspointI18n $accesspointI18n The ChildAccesspointI18n object to remove.
     * @return $this|ChildAccesspoint The current object (for fluent API support)
     */
    public function removeAccesspointI18n(ChildAccesspointI18n $accesspointI18n)
    {
        if ($this->getAccesspointI18ns()->contains($accesspointI18n)) {
            $pos = $this->collAccesspointI18ns->search($accesspointI18n);
            $this->collAccesspointI18ns->remove($pos);
            if (null === $this->accesspointI18nsScheduledForDeletion) {
                $this->accesspointI18nsScheduledForDeletion = clone $this->collAccesspointI18ns;
                $this->accesspointI18nsScheduledForDeletion->clear();
            }
            $this->accesspointI18nsScheduledForDeletion[]= clone $accesspointI18n;
            $accesspointI18n->setAccesspoint(null);
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
        if (null !== $this->aCustomer) {
            $this->aCustomer->removeAccesspoint($this);
        }
        if (null !== $this->aSection) {
            $this->aSection->removeAccesspoint($this);
        }
        if (null !== $this->aAccesspointCategory) {
            $this->aAccesspointCategory->removeAccesspoint($this);
        }
        $this->id = null;
        $this->macaddr = null;
        $this->ap_macaddr = null;
        $this->fw_version = null;
        $this->isp = null;
        $this->ssid = null;
        $this->key = null;
        $this->province = null;
        $this->ads_location = null;
        $this->login_template = null;
        $this->image = null;
        $this->category_id = null;
        $this->lng = null;
        $this->lat = null;
        $this->detail_url_id = null;
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
        $this->owner = null;
        $this->customer_id = null;
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
            if ($this->collAccesspointI18ns) {
                foreach ($this->collAccesspointI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'vi';
        $this->currentTranslations = null;

        $this->collAccesspointI18ns = null;
        $this->aCustomer = null;
        $this->aSection = null;
        $this->aAccesspointCategory = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AccesspointTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildAccesspoint The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[AccesspointTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildAccesspoint The current object (for fluent API support)
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
     * @return ChildAccesspointI18n */
    public function getTranslation($locale = 'vi', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collAccesspointI18ns) {
                foreach ($this->collAccesspointI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildAccesspointI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildAccesspointI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addAccesspointI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildAccesspoint The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'vi', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildAccesspointI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collAccesspointI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collAccesspointI18ns[$key]);
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
     * @return ChildAccesspointI18n */
    public function getCurrentTranslation(ConnectionInterface $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [name] column value.
         *
         * @return string
         */
        public function getName()
        {
        return $this->getCurrentTranslation()->getName();
    }


        /**
         * Set the value of [name] column.
         *
         * @param string $v new value
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
         */
        public function setName($v)
        {    $this->getCurrentTranslation()->setName($v);

        return $this;
    }


        /**
         * Get the [address] column value.
         *
         * @return string
         */
        public function getAddress()
        {
        return $this->getCurrentTranslation()->getAddress();
    }


        /**
         * Set the value of [address] column.
         *
         * @param string $v new value
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
         */
        public function setAddress($v)
        {    $this->getCurrentTranslation()->setAddress($v);

        return $this;
    }


        /**
         * Get the [pcontact] column value.
         *
         * @return string
         */
        public function getPcontact()
        {
        return $this->getCurrentTranslation()->getPcontact();
    }


        /**
         * Set the value of [pcontact] column.
         *
         * @param string $v new value
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
         */
        public function setPcontact($v)
        {    $this->getCurrentTranslation()->setPcontact($v);

        return $this;
    }


        /**
         * Get the [detail_url] column value.
         *
         * @return string
         */
        public function getDetailUrl()
        {
        return $this->getCurrentTranslation()->getDetailUrl();
    }


        /**
         * Set the value of [detail_url] column.
         *
         * @param string $v new value
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
         */
        public function setDetailUrl($v)
        {    $this->getCurrentTranslation()->setDetailUrl($v);

        return $this;
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointI18n The current object (for fluent API support)
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
