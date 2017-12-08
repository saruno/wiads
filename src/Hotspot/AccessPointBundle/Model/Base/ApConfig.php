<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\ApConfig as ChildApConfig;
use Hotspot\AccessPointBundle\Model\ApConfigQuery as ChildApConfigQuery;
use Hotspot\AccessPointBundle\Model\Map\ApConfigTableMap;
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
 * Base class that represents a row from the 'ap_config' table.
 *
 *
 *
 * @package    propel.generator.src.Hotspot.AccessPointBundle.Model.Base
 */
abstract class ApConfig implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Hotspot\\AccessPointBundle\\Model\\Map\\ApConfigTableMap';


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
     * The value for the fw_version_next field.
     *
     * @var        string
     */
    protected $fw_version_next;

    /**
     * The value for the platform field.
     *
     * @var        string
     */
    protected $platform;

    /**
     * The value for the ip field.
     *
     * @var        string
     */
    protected $ip;

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
     * The value for the need_update field.
     *
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $need_update;

    /**
     * The value for the fw_upgrade field.
     *
     * Note: this column has a database default value of: 'option fw_upgrade 0'
     * @var        string
     */
    protected $fw_upgrade;

    /**
     * The value for the fw_file field.
     *
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $fw_file;

    /**
     * The value for the ssid_update field.
     *
     * Note: this column has a database default value of: 'option ssid_update 1'
     * @var        string
     */
    protected $ssid_update;

    /**
     * The value for the ssid_next field.
     *
     * Note: this column has a database default value of: 'option ssid "WiAds Free Wifi"'
     * @var        string
     */
    protected $ssid_next;

    /**
     * The value for the safe_sleep field.
     *
     * Note: this column has a database default value of: 'option safe_sleep 0'
     * @var        string
     */
    protected $safe_sleep;

    /**
     * The value for the reset_need field.
     *
     * Note: this column has a database default value of: 'option reset_to_default 0'
     * @var        string
     */
    protected $reset_need;

    /**
     * The value for the normal_mode field.
     *
     * Note: this column has a database default value of: 'option normal_mode 0'
     * @var        string
     */
    protected $normal_mode;

    /**
     * The value for the update_uamdomains field.
     *
     * Note: this column has a database default value of: 'option update_uamdomains 0'
     * @var        string
     */
    protected $update_uamdomains;

    /**
     * The value for the uamdomains field.
     *
     * Note: this column has a database default value of: '#HS_UAMDOMAINS'
     * @var        string
     */
    protected $uamdomains;

    /**
     * The value for the uamdomains_next field.
     *
     * Note: this column has a database default value of: '#HS_UAMDOMAINS'
     * @var        string
     */
    protected $uamdomains_next;

    /**
     * The value for the update_uamformat field.
     *
     * Note: this column has a database default value of: 'option update_uamformat 0'
     * @var        string
     */
    protected $update_uamformat;

    /**
     * The value for the uamformat field.
     *
     * @var        string
     */
    protected $uamformat;

    /**
     * The value for the uamformat_next field.
     *
     * @var        string
     */
    protected $uamformat_next;

    /**
     * The value for the update_uamhomepage field.
     *
     * Note: this column has a database default value of: 'option update_uamhomepage 0'
     * @var        string
     */
    protected $update_uamhomepage;

    /**
     * The value for the uamhomepage field.
     *
     * @var        string
     */
    protected $uamhomepage;

    /**
     * The value for the uamhomepage_next field.
     *
     * @var        string
     */
    protected $uamhomepage_next;

    /**
     * The value for the update_macauth field.
     *
     * Note: this column has a database default value of: 'option update_macauth 0'
     * @var        string
     */
    protected $update_macauth;

    /**
     * The value for the macauth field.
     *
     * @var        string
     */
    protected $macauth;

    /**
     * The value for the macauth_next field.
     *
     * @var        string
     */
    protected $macauth_next;

    /**
     * The value for the update_channel field.
     *
     * Note: this column has a database default value of: 'option channel_update 0'
     * @var        string
     */
    protected $update_channel;

    /**
     * The value for the channel field.
     *
     * @var        string
     */
    protected $channel;

    /**
     * The value for the channel_next field.
     *
     * @var        string
     */
    protected $channel_next;

    /**
     * The value for the update_hwmode field.
     *
     * Note: this column has a database default value of: 'option hwmode_update 0'
     * @var        string
     */
    protected $update_hwmode;

    /**
     * The value for the hwmode field.
     *
     * @var        string
     */
    protected $hwmode;

    /**
     * The value for the hwmode_next field.
     *
     * @var        string
     */
    protected $hwmode_next;

    /**
     * The value for the update_htmode field.
     *
     * Note: this column has a database default value of: 'option htmode_update 0'
     * @var        string
     */
    protected $update_htmode;

    /**
     * The value for the htmode field.
     *
     * @var        string
     */
    protected $htmode;

    /**
     * The value for the htmode_next field.
     *
     * @var        string
     */
    protected $htmode_next;

    /**
     * The value for the update_noscan field.
     *
     * Note: this column has a database default value of: 'option noscan_update 0'
     * @var        string
     */
    protected $update_noscan;

    /**
     * The value for the noscan field.
     *
     * @var        string
     */
    protected $noscan;

    /**
     * The value for the noscan_next field.
     *
     * @var        string
     */
    protected $noscan_next;

    /**
     * The value for the update_encryption field.
     *
     * Note: this column has a database default value of: 'option encryption_update 0'
     * @var        string
     */
    protected $update_encryption;

    /**
     * The value for the encryption field.
     *
     * @var        string
     */
    protected $encryption;

    /**
     * The value for the encryption_next field.
     *
     * @var        string
     */
    protected $encryption_next;

    /**
     * The value for the update_key field.
     *
     * Note: this column has a database default value of: 'option key_update 0'
     * @var        string
     */
    protected $update_key;

    /**
     * The value for the key field.
     *
     * @var        string
     */
    protected $key;

    /**
     * The value for the key_next field.
     *
     * @var        string
     */
    protected $key_next;

    /**
     * The value for the update_lan_network field.
     *
     * Note: this column has a database default value of: 'option network_lan_update 1'
     * @var        string
     */
    protected $update_lan_network;

    /**
     * The value for the lan_network field.
     *
     * Note: this column has a database default value of: 'option network_lan \'172.16.16.1\''
     * @var        string
     */
    protected $lan_network;

    /**
     * The value for the update_hosts field.
     *
     * Note: this column has a database default value of: 'option hosts_update 0'
     * @var        string
     */
    protected $update_hosts;

    /**
     * The value for the hosts field.
     *
     * @var        string
     */
    protected $hosts;

    /**
     * The value for the iwinfo field.
     *
     * @var        string
     */
    protected $iwinfo;

    /**
     * The value for the need_reboot field.
     *
     * Note: this column has a database default value of: 'option need_reboot 0'
     * @var        string
     */
    protected $need_reboot;

    /**
     * The value for the wifi_enable field.
     *
     * Note: this column has a database default value of: 'active wifi 1'
     * @var        string
     */
    protected $wifi_enable;

    /**
     * The value for the bw_profile_id field.
     *
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $bw_profile_id;

    /**
     * The value for the exclude field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $exclude;

    /**
     * The value for the activated field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $activated;

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
        $this->need_update = 1;
        $this->fw_upgrade = 'option fw_upgrade 0';
        $this->fw_file = '';
        $this->ssid_update = 'option ssid_update 1';
        $this->ssid_next = 'option ssid "WiAds Free Wifi"';
        $this->safe_sleep = 'option safe_sleep 0';
        $this->reset_need = 'option reset_to_default 0';
        $this->normal_mode = 'option normal_mode 0';
        $this->update_uamdomains = 'option update_uamdomains 0';
        $this->uamdomains = '#HS_UAMDOMAINS';
        $this->uamdomains_next = '#HS_UAMDOMAINS';
        $this->update_uamformat = 'option update_uamformat 0';
        $this->update_uamhomepage = 'option update_uamhomepage 0';
        $this->update_macauth = 'option update_macauth 0';
        $this->update_channel = 'option channel_update 0';
        $this->update_hwmode = 'option hwmode_update 0';
        $this->update_htmode = 'option htmode_update 0';
        $this->update_noscan = 'option noscan_update 0';
        $this->update_encryption = 'option encryption_update 0';
        $this->update_key = 'option key_update 0';
        $this->update_lan_network = 'option network_lan_update 1';
        $this->lan_network = 'option network_lan \'172.16.16.1\'';
        $this->update_hosts = 'option hosts_update 0';
        $this->need_reboot = 'option need_reboot 0';
        $this->wifi_enable = 'active wifi 1';
        $this->bw_profile_id = 1;
        $this->exclude = 0;
        $this->activated = 0;
    }

    /**
     * Initializes internal state of Hotspot\AccessPointBundle\Model\Base\ApConfig object.
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
     * Compares this with another <code>ApConfig</code> instance.  If
     * <code>obj</code> is an instance of <code>ApConfig</code>, delegates to
     * <code>equals(ApConfig)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|ApConfig The current object, for fluid interface
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
     * Get the [fw_version_next] column value.
     *
     * @return string
     */
    public function getFwVersionNext()
    {
        return $this->fw_version_next;
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
     * Get the [ip] column value.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
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
     * Get the [need_update] column value.
     *
     * @return int
     */
    public function getNeedUpdate()
    {
        return $this->need_update;
    }

    /**
     * Get the [fw_upgrade] column value.
     *
     * @return string
     */
    public function getFwUpgrade()
    {
        return $this->fw_upgrade;
    }

    /**
     * Get the [fw_file] column value.
     *
     * @return string
     */
    public function getFwFile()
    {
        return $this->fw_file;
    }

    /**
     * Get the [ssid_update] column value.
     *
     * @return string
     */
    public function getSsidUpdate()
    {
        return $this->ssid_update;
    }

    /**
     * Get the [ssid_next] column value.
     *
     * @return string
     */
    public function getSsidNext()
    {
        return $this->ssid_next;
    }

    /**
     * Get the [safe_sleep] column value.
     *
     * @return string
     */
    public function getSafeSleep()
    {
        return $this->safe_sleep;
    }

    /**
     * Get the [reset_need] column value.
     *
     * @return string
     */
    public function getResetNeed()
    {
        return $this->reset_need;
    }

    /**
     * Get the [normal_mode] column value.
     *
     * @return string
     */
    public function getNormalMode()
    {
        return $this->normal_mode;
    }

    /**
     * Get the [update_uamdomains] column value.
     *
     * @return string
     */
    public function getUpdateUamdomains()
    {
        return $this->update_uamdomains;
    }

    /**
     * Get the [uamdomains] column value.
     *
     * @return string
     */
    public function getUamdomains()
    {
        return $this->uamdomains;
    }

    /**
     * Get the [uamdomains_next] column value.
     *
     * @return string
     */
    public function getUamdomainsNext()
    {
        return $this->uamdomains_next;
    }

    /**
     * Get the [update_uamformat] column value.
     *
     * @return string
     */
    public function getUpdateUamformat()
    {
        return $this->update_uamformat;
    }

    /**
     * Get the [uamformat] column value.
     *
     * @return string
     */
    public function getUamformat()
    {
        return $this->uamformat;
    }

    /**
     * Get the [uamformat_next] column value.
     *
     * @return string
     */
    public function getUamformatNext()
    {
        return $this->uamformat_next;
    }

    /**
     * Get the [update_uamhomepage] column value.
     *
     * @return string
     */
    public function getUpdateUamhomepage()
    {
        return $this->update_uamhomepage;
    }

    /**
     * Get the [uamhomepage] column value.
     *
     * @return string
     */
    public function getUamhomepage()
    {
        return $this->uamhomepage;
    }

    /**
     * Get the [uamhomepage_next] column value.
     *
     * @return string
     */
    public function getUamhomepageNext()
    {
        return $this->uamhomepage_next;
    }

    /**
     * Get the [update_macauth] column value.
     *
     * @return string
     */
    public function getUpdateMacauth()
    {
        return $this->update_macauth;
    }

    /**
     * Get the [macauth] column value.
     *
     * @return string
     */
    public function getMacauth()
    {
        return $this->macauth;
    }

    /**
     * Get the [macauth_next] column value.
     *
     * @return string
     */
    public function getMacauthNext()
    {
        return $this->macauth_next;
    }

    /**
     * Get the [update_channel] column value.
     *
     * @return string
     */
    public function getUpdateChannel()
    {
        return $this->update_channel;
    }

    /**
     * Get the [channel] column value.
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Get the [channel_next] column value.
     *
     * @return string
     */
    public function getChannelNext()
    {
        return $this->channel_next;
    }

    /**
     * Get the [update_hwmode] column value.
     *
     * @return string
     */
    public function getUpdateHwmode()
    {
        return $this->update_hwmode;
    }

    /**
     * Get the [hwmode] column value.
     *
     * @return string
     */
    public function getHwmode()
    {
        return $this->hwmode;
    }

    /**
     * Get the [hwmode_next] column value.
     *
     * @return string
     */
    public function getHwmodeNext()
    {
        return $this->hwmode_next;
    }

    /**
     * Get the [update_htmode] column value.
     *
     * @return string
     */
    public function getUpdateHtmode()
    {
        return $this->update_htmode;
    }

    /**
     * Get the [htmode] column value.
     *
     * @return string
     */
    public function getHtmode()
    {
        return $this->htmode;
    }

    /**
     * Get the [htmode_next] column value.
     *
     * @return string
     */
    public function getHtmodeNext()
    {
        return $this->htmode_next;
    }

    /**
     * Get the [update_noscan] column value.
     *
     * @return string
     */
    public function getUpdateNoscan()
    {
        return $this->update_noscan;
    }

    /**
     * Get the [noscan] column value.
     *
     * @return string
     */
    public function getNoscan()
    {
        return $this->noscan;
    }

    /**
     * Get the [noscan_next] column value.
     *
     * @return string
     */
    public function getNoscanNext()
    {
        return $this->noscan_next;
    }

    /**
     * Get the [update_encryption] column value.
     *
     * @return string
     */
    public function getUpdateEncryption()
    {
        return $this->update_encryption;
    }

    /**
     * Get the [encryption] column value.
     *
     * @return string
     */
    public function getEncryption()
    {
        return $this->encryption;
    }

    /**
     * Get the [encryption_next] column value.
     *
     * @return string
     */
    public function getEncryptionNext()
    {
        return $this->encryption_next;
    }

    /**
     * Get the [update_key] column value.
     *
     * @return string
     */
    public function getUpdateKey()
    {
        return $this->update_key;
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
     * Get the [key_next] column value.
     *
     * @return string
     */
    public function getKeyNext()
    {
        return $this->key_next;
    }

    /**
     * Get the [update_lan_network] column value.
     *
     * @return string
     */
    public function getUpdateLanNetwork()
    {
        return $this->update_lan_network;
    }

    /**
     * Get the [lan_network] column value.
     *
     * @return string
     */
    public function getLanNetwork()
    {
        return $this->lan_network;
    }

    /**
     * Get the [update_hosts] column value.
     *
     * @return string
     */
    public function getUpdateHosts()
    {
        return $this->update_hosts;
    }

    /**
     * Get the [hosts] column value.
     *
     * @return string
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * Get the [iwinfo] column value.
     *
     * @return string
     */
    public function getIwinfo()
    {
        return $this->iwinfo;
    }

    /**
     * Get the [need_reboot] column value.
     *
     * @return string
     */
    public function getNeedReboot()
    {
        return $this->need_reboot;
    }

    /**
     * Get the [wifi_enable] column value.
     *
     * @return string
     */
    public function getWifiEnable()
    {
        return $this->wifi_enable;
    }

    /**
     * Get the [bw_profile_id] column value.
     *
     * @return int
     */
    public function getBwProfileId()
    {
        return $this->bw_profile_id;
    }

    /**
     * Get the [exclude] column value.
     *
     * @return int
     */
    public function getExclude()
    {
        return $this->exclude;
    }

    /**
     * Get the [activated] column value.
     *
     * @return int
     */
    public function getActivated()
    {
        return $this->activated;
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
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [ap_macaddr] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setApMacaddr($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ap_macaddr !== $v) {
            $this->ap_macaddr = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_AP_MACADDR] = true;
        }

        return $this;
    } // setApMacaddr()

    /**
     * Set the value of [fw_version] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setFwVersion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fw_version !== $v) {
            $this->fw_version = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_FW_VERSION] = true;
        }

        return $this;
    } // setFwVersion()

    /**
     * Set the value of [fw_version_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setFwVersionNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fw_version_next !== $v) {
            $this->fw_version_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_FW_VERSION_NEXT] = true;
        }

        return $this;
    } // setFwVersionNext()

    /**
     * Set the value of [platform] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setPlatform($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->platform !== $v) {
            $this->platform = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_PLATFORM] = true;
        }

        return $this;
    } // setPlatform()

    /**
     * Set the value of [ip] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ip !== $v) {
            $this->ip = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_IP] = true;
        }

        return $this;
    } // setIp()

    /**
     * Set the value of [isp] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setIsp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->isp !== $v) {
            $this->isp = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_ISP] = true;
        }

        return $this;
    } // setIsp()

    /**
     * Set the value of [ssid] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setSsid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ssid !== $v) {
            $this->ssid = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_SSID] = true;
        }

        return $this;
    } // setSsid()

    /**
     * Set the value of [need_update] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setNeedUpdate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->need_update !== $v) {
            $this->need_update = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_NEED_UPDATE] = true;
        }

        return $this;
    } // setNeedUpdate()

    /**
     * Set the value of [fw_upgrade] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setFwUpgrade($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fw_upgrade !== $v) {
            $this->fw_upgrade = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_FW_UPGRADE] = true;
        }

        return $this;
    } // setFwUpgrade()

    /**
     * Set the value of [fw_file] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setFwFile($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fw_file !== $v) {
            $this->fw_file = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_FW_FILE] = true;
        }

        return $this;
    } // setFwFile()

    /**
     * Set the value of [ssid_update] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setSsidUpdate($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ssid_update !== $v) {
            $this->ssid_update = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_SSID_UPDATE] = true;
        }

        return $this;
    } // setSsidUpdate()

    /**
     * Set the value of [ssid_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setSsidNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ssid_next !== $v) {
            $this->ssid_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_SSID_NEXT] = true;
        }

        return $this;
    } // setSsidNext()

    /**
     * Set the value of [safe_sleep] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setSafeSleep($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->safe_sleep !== $v) {
            $this->safe_sleep = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_SAFE_SLEEP] = true;
        }

        return $this;
    } // setSafeSleep()

    /**
     * Set the value of [reset_need] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setResetNeed($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->reset_need !== $v) {
            $this->reset_need = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_RESET_NEED] = true;
        }

        return $this;
    } // setResetNeed()

    /**
     * Set the value of [normal_mode] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setNormalMode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->normal_mode !== $v) {
            $this->normal_mode = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_NORMAL_MODE] = true;
        }

        return $this;
    } // setNormalMode()

    /**
     * Set the value of [update_uamdomains] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateUamdomains($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_uamdomains !== $v) {
            $this->update_uamdomains = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_UAMDOMAINS] = true;
        }

        return $this;
    } // setUpdateUamdomains()

    /**
     * Set the value of [uamdomains] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUamdomains($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->uamdomains !== $v) {
            $this->uamdomains = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UAMDOMAINS] = true;
        }

        return $this;
    } // setUamdomains()

    /**
     * Set the value of [uamdomains_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUamdomainsNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->uamdomains_next !== $v) {
            $this->uamdomains_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UAMDOMAINS_NEXT] = true;
        }

        return $this;
    } // setUamdomainsNext()

    /**
     * Set the value of [update_uamformat] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateUamformat($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_uamformat !== $v) {
            $this->update_uamformat = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_UAMFORMAT] = true;
        }

        return $this;
    } // setUpdateUamformat()

    /**
     * Set the value of [uamformat] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUamformat($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->uamformat !== $v) {
            $this->uamformat = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UAMFORMAT] = true;
        }

        return $this;
    } // setUamformat()

    /**
     * Set the value of [uamformat_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUamformatNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->uamformat_next !== $v) {
            $this->uamformat_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UAMFORMAT_NEXT] = true;
        }

        return $this;
    } // setUamformatNext()

    /**
     * Set the value of [update_uamhomepage] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateUamhomepage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_uamhomepage !== $v) {
            $this->update_uamhomepage = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_UAMHOMEPAGE] = true;
        }

        return $this;
    } // setUpdateUamhomepage()

    /**
     * Set the value of [uamhomepage] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUamhomepage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->uamhomepage !== $v) {
            $this->uamhomepage = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UAMHOMEPAGE] = true;
        }

        return $this;
    } // setUamhomepage()

    /**
     * Set the value of [uamhomepage_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUamhomepageNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->uamhomepage_next !== $v) {
            $this->uamhomepage_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UAMHOMEPAGE_NEXT] = true;
        }

        return $this;
    } // setUamhomepageNext()

    /**
     * Set the value of [update_macauth] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateMacauth($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_macauth !== $v) {
            $this->update_macauth = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_MACAUTH] = true;
        }

        return $this;
    } // setUpdateMacauth()

    /**
     * Set the value of [macauth] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setMacauth($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->macauth !== $v) {
            $this->macauth = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_MACAUTH] = true;
        }

        return $this;
    } // setMacauth()

    /**
     * Set the value of [macauth_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setMacauthNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->macauth_next !== $v) {
            $this->macauth_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_MACAUTH_NEXT] = true;
        }

        return $this;
    } // setMacauthNext()

    /**
     * Set the value of [update_channel] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateChannel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_channel !== $v) {
            $this->update_channel = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_CHANNEL] = true;
        }

        return $this;
    } // setUpdateChannel()

    /**
     * Set the value of [channel] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setChannel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->channel !== $v) {
            $this->channel = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_CHANNEL] = true;
        }

        return $this;
    } // setChannel()

    /**
     * Set the value of [channel_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setChannelNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->channel_next !== $v) {
            $this->channel_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_CHANNEL_NEXT] = true;
        }

        return $this;
    } // setChannelNext()

    /**
     * Set the value of [update_hwmode] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateHwmode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_hwmode !== $v) {
            $this->update_hwmode = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_HWMODE] = true;
        }

        return $this;
    } // setUpdateHwmode()

    /**
     * Set the value of [hwmode] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setHwmode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hwmode !== $v) {
            $this->hwmode = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_HWMODE] = true;
        }

        return $this;
    } // setHwmode()

    /**
     * Set the value of [hwmode_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setHwmodeNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hwmode_next !== $v) {
            $this->hwmode_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_HWMODE_NEXT] = true;
        }

        return $this;
    } // setHwmodeNext()

    /**
     * Set the value of [update_htmode] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateHtmode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_htmode !== $v) {
            $this->update_htmode = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_HTMODE] = true;
        }

        return $this;
    } // setUpdateHtmode()

    /**
     * Set the value of [htmode] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setHtmode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->htmode !== $v) {
            $this->htmode = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_HTMODE] = true;
        }

        return $this;
    } // setHtmode()

    /**
     * Set the value of [htmode_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setHtmodeNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->htmode_next !== $v) {
            $this->htmode_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_HTMODE_NEXT] = true;
        }

        return $this;
    } // setHtmodeNext()

    /**
     * Set the value of [update_noscan] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateNoscan($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_noscan !== $v) {
            $this->update_noscan = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_NOSCAN] = true;
        }

        return $this;
    } // setUpdateNoscan()

    /**
     * Set the value of [noscan] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setNoscan($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->noscan !== $v) {
            $this->noscan = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_NOSCAN] = true;
        }

        return $this;
    } // setNoscan()

    /**
     * Set the value of [noscan_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setNoscanNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->noscan_next !== $v) {
            $this->noscan_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_NOSCAN_NEXT] = true;
        }

        return $this;
    } // setNoscanNext()

    /**
     * Set the value of [update_encryption] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateEncryption($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_encryption !== $v) {
            $this->update_encryption = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_ENCRYPTION] = true;
        }

        return $this;
    } // setUpdateEncryption()

    /**
     * Set the value of [encryption] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setEncryption($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->encryption !== $v) {
            $this->encryption = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_ENCRYPTION] = true;
        }

        return $this;
    } // setEncryption()

    /**
     * Set the value of [encryption_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setEncryptionNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->encryption_next !== $v) {
            $this->encryption_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_ENCRYPTION_NEXT] = true;
        }

        return $this;
    } // setEncryptionNext()

    /**
     * Set the value of [update_key] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_key !== $v) {
            $this->update_key = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_KEY] = true;
        }

        return $this;
    } // setUpdateKey()

    /**
     * Set the value of [key] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->key !== $v) {
            $this->key = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_KEY] = true;
        }

        return $this;
    } // setKey()

    /**
     * Set the value of [key_next] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setKeyNext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->key_next !== $v) {
            $this->key_next = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_KEY_NEXT] = true;
        }

        return $this;
    } // setKeyNext()

    /**
     * Set the value of [update_lan_network] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateLanNetwork($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_lan_network !== $v) {
            $this->update_lan_network = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_LAN_NETWORK] = true;
        }

        return $this;
    } // setUpdateLanNetwork()

    /**
     * Set the value of [lan_network] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setLanNetwork($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lan_network !== $v) {
            $this->lan_network = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_LAN_NETWORK] = true;
        }

        return $this;
    } // setLanNetwork()

    /**
     * Set the value of [update_hosts] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdateHosts($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->update_hosts !== $v) {
            $this->update_hosts = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_UPDATE_HOSTS] = true;
        }

        return $this;
    } // setUpdateHosts()

    /**
     * Set the value of [hosts] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setHosts($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->hosts !== $v) {
            $this->hosts = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_HOSTS] = true;
        }

        return $this;
    } // setHosts()

    /**
     * Set the value of [iwinfo] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setIwinfo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->iwinfo !== $v) {
            $this->iwinfo = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_IWINFO] = true;
        }

        return $this;
    } // setIwinfo()

    /**
     * Set the value of [need_reboot] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setNeedReboot($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->need_reboot !== $v) {
            $this->need_reboot = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_NEED_REBOOT] = true;
        }

        return $this;
    } // setNeedReboot()

    /**
     * Set the value of [wifi_enable] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setWifiEnable($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->wifi_enable !== $v) {
            $this->wifi_enable = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_WIFI_ENABLE] = true;
        }

        return $this;
    } // setWifiEnable()

    /**
     * Set the value of [bw_profile_id] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setBwProfileId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->bw_profile_id !== $v) {
            $this->bw_profile_id = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_BW_PROFILE_ID] = true;
        }

        return $this;
    } // setBwProfileId()

    /**
     * Set the value of [exclude] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setExclude($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->exclude !== $v) {
            $this->exclude = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_EXCLUDE] = true;
        }

        return $this;
    } // setExclude()

    /**
     * Set the value of [activated] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setActivated($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->activated !== $v) {
            $this->activated = $v;
            $this->modifiedColumns[ApConfigTableMap::COL_ACTIVATED] = true;
        }

        return $this;
    } // setActivated()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ApConfigTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ApConfigTableMap::COL_UPDATED_AT] = true;
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
            if ($this->need_update !== 1) {
                return false;
            }

            if ($this->fw_upgrade !== 'option fw_upgrade 0') {
                return false;
            }

            if ($this->fw_file !== '') {
                return false;
            }

            if ($this->ssid_update !== 'option ssid_update 1') {
                return false;
            }

            if ($this->ssid_next !== 'option ssid "WiAds Free Wifi"') {
                return false;
            }

            if ($this->safe_sleep !== 'option safe_sleep 0') {
                return false;
            }

            if ($this->reset_need !== 'option reset_to_default 0') {
                return false;
            }

            if ($this->normal_mode !== 'option normal_mode 0') {
                return false;
            }

            if ($this->update_uamdomains !== 'option update_uamdomains 0') {
                return false;
            }

            if ($this->uamdomains !== '#HS_UAMDOMAINS') {
                return false;
            }

            if ($this->uamdomains_next !== '#HS_UAMDOMAINS') {
                return false;
            }

            if ($this->update_uamformat !== 'option update_uamformat 0') {
                return false;
            }

            if ($this->update_uamhomepage !== 'option update_uamhomepage 0') {
                return false;
            }

            if ($this->update_macauth !== 'option update_macauth 0') {
                return false;
            }

            if ($this->update_channel !== 'option channel_update 0') {
                return false;
            }

            if ($this->update_hwmode !== 'option hwmode_update 0') {
                return false;
            }

            if ($this->update_htmode !== 'option htmode_update 0') {
                return false;
            }

            if ($this->update_noscan !== 'option noscan_update 0') {
                return false;
            }

            if ($this->update_encryption !== 'option encryption_update 0') {
                return false;
            }

            if ($this->update_key !== 'option key_update 0') {
                return false;
            }

            if ($this->update_lan_network !== 'option network_lan_update 1') {
                return false;
            }

            if ($this->lan_network !== 'option network_lan \'172.16.16.1\'') {
                return false;
            }

            if ($this->update_hosts !== 'option hosts_update 0') {
                return false;
            }

            if ($this->need_reboot !== 'option need_reboot 0') {
                return false;
            }

            if ($this->wifi_enable !== 'active wifi 1') {
                return false;
            }

            if ($this->bw_profile_id !== 1) {
                return false;
            }

            if ($this->exclude !== 0) {
                return false;
            }

            if ($this->activated !== 0) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ApConfigTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ApConfigTableMap::translateFieldName('ApMacaddr', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ap_macaddr = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ApConfigTableMap::translateFieldName('FwVersion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fw_version = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ApConfigTableMap::translateFieldName('FwVersionNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fw_version_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ApConfigTableMap::translateFieldName('Platform', TableMap::TYPE_PHPNAME, $indexType)];
            $this->platform = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ApConfigTableMap::translateFieldName('Ip', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ip = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ApConfigTableMap::translateFieldName('Isp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->isp = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ApConfigTableMap::translateFieldName('Ssid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ssid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ApConfigTableMap::translateFieldName('NeedUpdate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->need_update = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ApConfigTableMap::translateFieldName('FwUpgrade', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fw_upgrade = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ApConfigTableMap::translateFieldName('FwFile', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fw_file = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : ApConfigTableMap::translateFieldName('SsidUpdate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ssid_update = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : ApConfigTableMap::translateFieldName('SsidNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ssid_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : ApConfigTableMap::translateFieldName('SafeSleep', TableMap::TYPE_PHPNAME, $indexType)];
            $this->safe_sleep = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : ApConfigTableMap::translateFieldName('ResetNeed', TableMap::TYPE_PHPNAME, $indexType)];
            $this->reset_need = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : ApConfigTableMap::translateFieldName('NormalMode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->normal_mode = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : ApConfigTableMap::translateFieldName('UpdateUamdomains', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_uamdomains = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : ApConfigTableMap::translateFieldName('Uamdomains', TableMap::TYPE_PHPNAME, $indexType)];
            $this->uamdomains = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : ApConfigTableMap::translateFieldName('UamdomainsNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->uamdomains_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : ApConfigTableMap::translateFieldName('UpdateUamformat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_uamformat = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : ApConfigTableMap::translateFieldName('Uamformat', TableMap::TYPE_PHPNAME, $indexType)];
            $this->uamformat = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : ApConfigTableMap::translateFieldName('UamformatNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->uamformat_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : ApConfigTableMap::translateFieldName('UpdateUamhomepage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_uamhomepage = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : ApConfigTableMap::translateFieldName('Uamhomepage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->uamhomepage = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : ApConfigTableMap::translateFieldName('UamhomepageNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->uamhomepage_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : ApConfigTableMap::translateFieldName('UpdateMacauth', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_macauth = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : ApConfigTableMap::translateFieldName('Macauth', TableMap::TYPE_PHPNAME, $indexType)];
            $this->macauth = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : ApConfigTableMap::translateFieldName('MacauthNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->macauth_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : ApConfigTableMap::translateFieldName('UpdateChannel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_channel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : ApConfigTableMap::translateFieldName('Channel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->channel = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 30 + $startcol : ApConfigTableMap::translateFieldName('ChannelNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->channel_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 31 + $startcol : ApConfigTableMap::translateFieldName('UpdateHwmode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_hwmode = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 32 + $startcol : ApConfigTableMap::translateFieldName('Hwmode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hwmode = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 33 + $startcol : ApConfigTableMap::translateFieldName('HwmodeNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hwmode_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 34 + $startcol : ApConfigTableMap::translateFieldName('UpdateHtmode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_htmode = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 35 + $startcol : ApConfigTableMap::translateFieldName('Htmode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->htmode = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 36 + $startcol : ApConfigTableMap::translateFieldName('HtmodeNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->htmode_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 37 + $startcol : ApConfigTableMap::translateFieldName('UpdateNoscan', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_noscan = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 38 + $startcol : ApConfigTableMap::translateFieldName('Noscan', TableMap::TYPE_PHPNAME, $indexType)];
            $this->noscan = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 39 + $startcol : ApConfigTableMap::translateFieldName('NoscanNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->noscan_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 40 + $startcol : ApConfigTableMap::translateFieldName('UpdateEncryption', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_encryption = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 41 + $startcol : ApConfigTableMap::translateFieldName('Encryption', TableMap::TYPE_PHPNAME, $indexType)];
            $this->encryption = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 42 + $startcol : ApConfigTableMap::translateFieldName('EncryptionNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->encryption_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 43 + $startcol : ApConfigTableMap::translateFieldName('UpdateKey', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_key = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 44 + $startcol : ApConfigTableMap::translateFieldName('Key', TableMap::TYPE_PHPNAME, $indexType)];
            $this->key = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 45 + $startcol : ApConfigTableMap::translateFieldName('KeyNext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->key_next = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 46 + $startcol : ApConfigTableMap::translateFieldName('UpdateLanNetwork', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_lan_network = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 47 + $startcol : ApConfigTableMap::translateFieldName('LanNetwork', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lan_network = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 48 + $startcol : ApConfigTableMap::translateFieldName('UpdateHosts', TableMap::TYPE_PHPNAME, $indexType)];
            $this->update_hosts = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 49 + $startcol : ApConfigTableMap::translateFieldName('Hosts', TableMap::TYPE_PHPNAME, $indexType)];
            $this->hosts = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 50 + $startcol : ApConfigTableMap::translateFieldName('Iwinfo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->iwinfo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 51 + $startcol : ApConfigTableMap::translateFieldName('NeedReboot', TableMap::TYPE_PHPNAME, $indexType)];
            $this->need_reboot = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 52 + $startcol : ApConfigTableMap::translateFieldName('WifiEnable', TableMap::TYPE_PHPNAME, $indexType)];
            $this->wifi_enable = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 53 + $startcol : ApConfigTableMap::translateFieldName('BwProfileId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bw_profile_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 54 + $startcol : ApConfigTableMap::translateFieldName('Exclude', TableMap::TYPE_PHPNAME, $indexType)];
            $this->exclude = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 55 + $startcol : ApConfigTableMap::translateFieldName('Activated', TableMap::TYPE_PHPNAME, $indexType)];
            $this->activated = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 56 + $startcol : ApConfigTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 57 + $startcol : ApConfigTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 58; // 58 = ApConfigTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Hotspot\\AccessPointBundle\\Model\\ApConfig'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ApConfigTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildApConfigQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
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
     * @see ApConfig::setDeleted()
     * @see ApConfig::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApConfigTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildApConfigQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ApConfigTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(ApConfigTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(ApConfigTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ApConfigTableMap::COL_UPDATED_AT)) {
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
                ApConfigTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[ApConfigTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ApConfigTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ApConfigTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_AP_MACADDR)) {
            $modifiedColumns[':p' . $index++]  = '`ap_macaddr`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_FW_VERSION)) {
            $modifiedColumns[':p' . $index++]  = '`fw_version`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_FW_VERSION_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`fw_version_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_PLATFORM)) {
            $modifiedColumns[':p' . $index++]  = '`platform`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_IP)) {
            $modifiedColumns[':p' . $index++]  = '`ip`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_ISP)) {
            $modifiedColumns[':p' . $index++]  = '`isp`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_SSID)) {
            $modifiedColumns[':p' . $index++]  = '`ssid`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_NEED_UPDATE)) {
            $modifiedColumns[':p' . $index++]  = '`need_update`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_FW_UPGRADE)) {
            $modifiedColumns[':p' . $index++]  = '`fw_upgrade`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_FW_FILE)) {
            $modifiedColumns[':p' . $index++]  = '`fw_file`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_SSID_UPDATE)) {
            $modifiedColumns[':p' . $index++]  = '`ssid_update`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_SSID_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`ssid_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_SAFE_SLEEP)) {
            $modifiedColumns[':p' . $index++]  = '`safe_sleep`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_RESET_NEED)) {
            $modifiedColumns[':p' . $index++]  = '`reset_need`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_NORMAL_MODE)) {
            $modifiedColumns[':p' . $index++]  = '`normal_mode`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_UAMDOMAINS)) {
            $modifiedColumns[':p' . $index++]  = '`update_uamdomains`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMDOMAINS)) {
            $modifiedColumns[':p' . $index++]  = '`uamdomains`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMDOMAINS_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`uamdomains_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_UAMFORMAT)) {
            $modifiedColumns[':p' . $index++]  = '`update_uamformat`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMFORMAT)) {
            $modifiedColumns[':p' . $index++]  = '`uamformat`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMFORMAT_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`uamformat_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_UAMHOMEPAGE)) {
            $modifiedColumns[':p' . $index++]  = '`update_uamhomepage`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMHOMEPAGE)) {
            $modifiedColumns[':p' . $index++]  = '`uamhomepage`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMHOMEPAGE_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`uamhomepage_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_MACAUTH)) {
            $modifiedColumns[':p' . $index++]  = '`update_macauth`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_MACAUTH)) {
            $modifiedColumns[':p' . $index++]  = '`macauth`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_MACAUTH_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`macauth_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_CHANNEL)) {
            $modifiedColumns[':p' . $index++]  = '`update_channel`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_CHANNEL)) {
            $modifiedColumns[':p' . $index++]  = '`channel`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_CHANNEL_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`channel_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_HWMODE)) {
            $modifiedColumns[':p' . $index++]  = '`update_hwmode`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_HWMODE)) {
            $modifiedColumns[':p' . $index++]  = '`hwmode`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_HWMODE_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`hwmode_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_HTMODE)) {
            $modifiedColumns[':p' . $index++]  = '`update_htmode`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_HTMODE)) {
            $modifiedColumns[':p' . $index++]  = '`htmode`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_HTMODE_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`htmode_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_NOSCAN)) {
            $modifiedColumns[':p' . $index++]  = '`update_noscan`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_NOSCAN)) {
            $modifiedColumns[':p' . $index++]  = '`noscan`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_NOSCAN_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`noscan_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_ENCRYPTION)) {
            $modifiedColumns[':p' . $index++]  = '`update_encryption`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_ENCRYPTION)) {
            $modifiedColumns[':p' . $index++]  = '`encryption`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_ENCRYPTION_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`encryption_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_KEY)) {
            $modifiedColumns[':p' . $index++]  = '`update_key`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_KEY)) {
            $modifiedColumns[':p' . $index++]  = '`key`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_KEY_NEXT)) {
            $modifiedColumns[':p' . $index++]  = '`key_next`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_LAN_NETWORK)) {
            $modifiedColumns[':p' . $index++]  = '`update_lan_network`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_LAN_NETWORK)) {
            $modifiedColumns[':p' . $index++]  = '`lan_network`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_HOSTS)) {
            $modifiedColumns[':p' . $index++]  = '`update_hosts`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_HOSTS)) {
            $modifiedColumns[':p' . $index++]  = '`hosts`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_IWINFO)) {
            $modifiedColumns[':p' . $index++]  = '`iwinfo`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_NEED_REBOOT)) {
            $modifiedColumns[':p' . $index++]  = '`need_reboot`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_WIFI_ENABLE)) {
            $modifiedColumns[':p' . $index++]  = '`wifi_enable`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_BW_PROFILE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`bw_profile_id`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_EXCLUDE)) {
            $modifiedColumns[':p' . $index++]  = '`exclude`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_ACTIVATED)) {
            $modifiedColumns[':p' . $index++]  = '`activated`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `ap_config` (%s) VALUES (%s)',
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
                    case '`ap_macaddr`':
                        $stmt->bindValue($identifier, $this->ap_macaddr, PDO::PARAM_STR);
                        break;
                    case '`fw_version`':
                        $stmt->bindValue($identifier, $this->fw_version, PDO::PARAM_STR);
                        break;
                    case '`fw_version_next`':
                        $stmt->bindValue($identifier, $this->fw_version_next, PDO::PARAM_STR);
                        break;
                    case '`platform`':
                        $stmt->bindValue($identifier, $this->platform, PDO::PARAM_STR);
                        break;
                    case '`ip`':
                        $stmt->bindValue($identifier, $this->ip, PDO::PARAM_STR);
                        break;
                    case '`isp`':
                        $stmt->bindValue($identifier, $this->isp, PDO::PARAM_STR);
                        break;
                    case '`ssid`':
                        $stmt->bindValue($identifier, $this->ssid, PDO::PARAM_STR);
                        break;
                    case '`need_update`':
                        $stmt->bindValue($identifier, $this->need_update, PDO::PARAM_INT);
                        break;
                    case '`fw_upgrade`':
                        $stmt->bindValue($identifier, $this->fw_upgrade, PDO::PARAM_STR);
                        break;
                    case '`fw_file`':
                        $stmt->bindValue($identifier, $this->fw_file, PDO::PARAM_STR);
                        break;
                    case '`ssid_update`':
                        $stmt->bindValue($identifier, $this->ssid_update, PDO::PARAM_STR);
                        break;
                    case '`ssid_next`':
                        $stmt->bindValue($identifier, $this->ssid_next, PDO::PARAM_STR);
                        break;
                    case '`safe_sleep`':
                        $stmt->bindValue($identifier, $this->safe_sleep, PDO::PARAM_STR);
                        break;
                    case '`reset_need`':
                        $stmt->bindValue($identifier, $this->reset_need, PDO::PARAM_STR);
                        break;
                    case '`normal_mode`':
                        $stmt->bindValue($identifier, $this->normal_mode, PDO::PARAM_STR);
                        break;
                    case '`update_uamdomains`':
                        $stmt->bindValue($identifier, $this->update_uamdomains, PDO::PARAM_STR);
                        break;
                    case '`uamdomains`':
                        $stmt->bindValue($identifier, $this->uamdomains, PDO::PARAM_STR);
                        break;
                    case '`uamdomains_next`':
                        $stmt->bindValue($identifier, $this->uamdomains_next, PDO::PARAM_STR);
                        break;
                    case '`update_uamformat`':
                        $stmt->bindValue($identifier, $this->update_uamformat, PDO::PARAM_STR);
                        break;
                    case '`uamformat`':
                        $stmt->bindValue($identifier, $this->uamformat, PDO::PARAM_STR);
                        break;
                    case '`uamformat_next`':
                        $stmt->bindValue($identifier, $this->uamformat_next, PDO::PARAM_STR);
                        break;
                    case '`update_uamhomepage`':
                        $stmt->bindValue($identifier, $this->update_uamhomepage, PDO::PARAM_STR);
                        break;
                    case '`uamhomepage`':
                        $stmt->bindValue($identifier, $this->uamhomepage, PDO::PARAM_STR);
                        break;
                    case '`uamhomepage_next`':
                        $stmt->bindValue($identifier, $this->uamhomepage_next, PDO::PARAM_STR);
                        break;
                    case '`update_macauth`':
                        $stmt->bindValue($identifier, $this->update_macauth, PDO::PARAM_STR);
                        break;
                    case '`macauth`':
                        $stmt->bindValue($identifier, $this->macauth, PDO::PARAM_STR);
                        break;
                    case '`macauth_next`':
                        $stmt->bindValue($identifier, $this->macauth_next, PDO::PARAM_STR);
                        break;
                    case '`update_channel`':
                        $stmt->bindValue($identifier, $this->update_channel, PDO::PARAM_STR);
                        break;
                    case '`channel`':
                        $stmt->bindValue($identifier, $this->channel, PDO::PARAM_STR);
                        break;
                    case '`channel_next`':
                        $stmt->bindValue($identifier, $this->channel_next, PDO::PARAM_STR);
                        break;
                    case '`update_hwmode`':
                        $stmt->bindValue($identifier, $this->update_hwmode, PDO::PARAM_STR);
                        break;
                    case '`hwmode`':
                        $stmt->bindValue($identifier, $this->hwmode, PDO::PARAM_STR);
                        break;
                    case '`hwmode_next`':
                        $stmt->bindValue($identifier, $this->hwmode_next, PDO::PARAM_STR);
                        break;
                    case '`update_htmode`':
                        $stmt->bindValue($identifier, $this->update_htmode, PDO::PARAM_STR);
                        break;
                    case '`htmode`':
                        $stmt->bindValue($identifier, $this->htmode, PDO::PARAM_STR);
                        break;
                    case '`htmode_next`':
                        $stmt->bindValue($identifier, $this->htmode_next, PDO::PARAM_STR);
                        break;
                    case '`update_noscan`':
                        $stmt->bindValue($identifier, $this->update_noscan, PDO::PARAM_STR);
                        break;
                    case '`noscan`':
                        $stmt->bindValue($identifier, $this->noscan, PDO::PARAM_STR);
                        break;
                    case '`noscan_next`':
                        $stmt->bindValue($identifier, $this->noscan_next, PDO::PARAM_STR);
                        break;
                    case '`update_encryption`':
                        $stmt->bindValue($identifier, $this->update_encryption, PDO::PARAM_STR);
                        break;
                    case '`encryption`':
                        $stmt->bindValue($identifier, $this->encryption, PDO::PARAM_STR);
                        break;
                    case '`encryption_next`':
                        $stmt->bindValue($identifier, $this->encryption_next, PDO::PARAM_STR);
                        break;
                    case '`update_key`':
                        $stmt->bindValue($identifier, $this->update_key, PDO::PARAM_STR);
                        break;
                    case '`key`':
                        $stmt->bindValue($identifier, $this->key, PDO::PARAM_STR);
                        break;
                    case '`key_next`':
                        $stmt->bindValue($identifier, $this->key_next, PDO::PARAM_STR);
                        break;
                    case '`update_lan_network`':
                        $stmt->bindValue($identifier, $this->update_lan_network, PDO::PARAM_STR);
                        break;
                    case '`lan_network`':
                        $stmt->bindValue($identifier, $this->lan_network, PDO::PARAM_STR);
                        break;
                    case '`update_hosts`':
                        $stmt->bindValue($identifier, $this->update_hosts, PDO::PARAM_STR);
                        break;
                    case '`hosts`':
                        $stmt->bindValue($identifier, $this->hosts, PDO::PARAM_STR);
                        break;
                    case '`iwinfo`':
                        $stmt->bindValue($identifier, $this->iwinfo, PDO::PARAM_STR);
                        break;
                    case '`need_reboot`':
                        $stmt->bindValue($identifier, $this->need_reboot, PDO::PARAM_STR);
                        break;
                    case '`wifi_enable`':
                        $stmt->bindValue($identifier, $this->wifi_enable, PDO::PARAM_STR);
                        break;
                    case '`bw_profile_id`':
                        $stmt->bindValue($identifier, $this->bw_profile_id, PDO::PARAM_INT);
                        break;
                    case '`exclude`':
                        $stmt->bindValue($identifier, $this->exclude, PDO::PARAM_INT);
                        break;
                    case '`activated`':
                        $stmt->bindValue($identifier, $this->activated, PDO::PARAM_INT);
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
        $pos = ApConfigTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getApMacaddr();
                break;
            case 2:
                return $this->getFwVersion();
                break;
            case 3:
                return $this->getFwVersionNext();
                break;
            case 4:
                return $this->getPlatform();
                break;
            case 5:
                return $this->getIp();
                break;
            case 6:
                return $this->getIsp();
                break;
            case 7:
                return $this->getSsid();
                break;
            case 8:
                return $this->getNeedUpdate();
                break;
            case 9:
                return $this->getFwUpgrade();
                break;
            case 10:
                return $this->getFwFile();
                break;
            case 11:
                return $this->getSsidUpdate();
                break;
            case 12:
                return $this->getSsidNext();
                break;
            case 13:
                return $this->getSafeSleep();
                break;
            case 14:
                return $this->getResetNeed();
                break;
            case 15:
                return $this->getNormalMode();
                break;
            case 16:
                return $this->getUpdateUamdomains();
                break;
            case 17:
                return $this->getUamdomains();
                break;
            case 18:
                return $this->getUamdomainsNext();
                break;
            case 19:
                return $this->getUpdateUamformat();
                break;
            case 20:
                return $this->getUamformat();
                break;
            case 21:
                return $this->getUamformatNext();
                break;
            case 22:
                return $this->getUpdateUamhomepage();
                break;
            case 23:
                return $this->getUamhomepage();
                break;
            case 24:
                return $this->getUamhomepageNext();
                break;
            case 25:
                return $this->getUpdateMacauth();
                break;
            case 26:
                return $this->getMacauth();
                break;
            case 27:
                return $this->getMacauthNext();
                break;
            case 28:
                return $this->getUpdateChannel();
                break;
            case 29:
                return $this->getChannel();
                break;
            case 30:
                return $this->getChannelNext();
                break;
            case 31:
                return $this->getUpdateHwmode();
                break;
            case 32:
                return $this->getHwmode();
                break;
            case 33:
                return $this->getHwmodeNext();
                break;
            case 34:
                return $this->getUpdateHtmode();
                break;
            case 35:
                return $this->getHtmode();
                break;
            case 36:
                return $this->getHtmodeNext();
                break;
            case 37:
                return $this->getUpdateNoscan();
                break;
            case 38:
                return $this->getNoscan();
                break;
            case 39:
                return $this->getNoscanNext();
                break;
            case 40:
                return $this->getUpdateEncryption();
                break;
            case 41:
                return $this->getEncryption();
                break;
            case 42:
                return $this->getEncryptionNext();
                break;
            case 43:
                return $this->getUpdateKey();
                break;
            case 44:
                return $this->getKey();
                break;
            case 45:
                return $this->getKeyNext();
                break;
            case 46:
                return $this->getUpdateLanNetwork();
                break;
            case 47:
                return $this->getLanNetwork();
                break;
            case 48:
                return $this->getUpdateHosts();
                break;
            case 49:
                return $this->getHosts();
                break;
            case 50:
                return $this->getIwinfo();
                break;
            case 51:
                return $this->getNeedReboot();
                break;
            case 52:
                return $this->getWifiEnable();
                break;
            case 53:
                return $this->getBwProfileId();
                break;
            case 54:
                return $this->getExclude();
                break;
            case 55:
                return $this->getActivated();
                break;
            case 56:
                return $this->getCreatedAt();
                break;
            case 57:
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

        if (isset($alreadyDumpedObjects['ApConfig'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ApConfig'][$this->hashCode()] = true;
        $keys = ApConfigTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getApMacaddr(),
            $keys[2] => $this->getFwVersion(),
            $keys[3] => $this->getFwVersionNext(),
            $keys[4] => $this->getPlatform(),
            $keys[5] => $this->getIp(),
            $keys[6] => $this->getIsp(),
            $keys[7] => $this->getSsid(),
            $keys[8] => $this->getNeedUpdate(),
            $keys[9] => $this->getFwUpgrade(),
            $keys[10] => $this->getFwFile(),
            $keys[11] => $this->getSsidUpdate(),
            $keys[12] => $this->getSsidNext(),
            $keys[13] => $this->getSafeSleep(),
            $keys[14] => $this->getResetNeed(),
            $keys[15] => $this->getNormalMode(),
            $keys[16] => $this->getUpdateUamdomains(),
            $keys[17] => $this->getUamdomains(),
            $keys[18] => $this->getUamdomainsNext(),
            $keys[19] => $this->getUpdateUamformat(),
            $keys[20] => $this->getUamformat(),
            $keys[21] => $this->getUamformatNext(),
            $keys[22] => $this->getUpdateUamhomepage(),
            $keys[23] => $this->getUamhomepage(),
            $keys[24] => $this->getUamhomepageNext(),
            $keys[25] => $this->getUpdateMacauth(),
            $keys[26] => $this->getMacauth(),
            $keys[27] => $this->getMacauthNext(),
            $keys[28] => $this->getUpdateChannel(),
            $keys[29] => $this->getChannel(),
            $keys[30] => $this->getChannelNext(),
            $keys[31] => $this->getUpdateHwmode(),
            $keys[32] => $this->getHwmode(),
            $keys[33] => $this->getHwmodeNext(),
            $keys[34] => $this->getUpdateHtmode(),
            $keys[35] => $this->getHtmode(),
            $keys[36] => $this->getHtmodeNext(),
            $keys[37] => $this->getUpdateNoscan(),
            $keys[38] => $this->getNoscan(),
            $keys[39] => $this->getNoscanNext(),
            $keys[40] => $this->getUpdateEncryption(),
            $keys[41] => $this->getEncryption(),
            $keys[42] => $this->getEncryptionNext(),
            $keys[43] => $this->getUpdateKey(),
            $keys[44] => $this->getKey(),
            $keys[45] => $this->getKeyNext(),
            $keys[46] => $this->getUpdateLanNetwork(),
            $keys[47] => $this->getLanNetwork(),
            $keys[48] => $this->getUpdateHosts(),
            $keys[49] => $this->getHosts(),
            $keys[50] => $this->getIwinfo(),
            $keys[51] => $this->getNeedReboot(),
            $keys[52] => $this->getWifiEnable(),
            $keys[53] => $this->getBwProfileId(),
            $keys[54] => $this->getExclude(),
            $keys[55] => $this->getActivated(),
            $keys[56] => $this->getCreatedAt(),
            $keys[57] => $this->getUpdatedAt(),
        );
        if ($result[$keys[56]] instanceof \DateTimeInterface) {
            $result[$keys[56]] = $result[$keys[56]]->format('c');
        }

        if ($result[$keys[57]] instanceof \DateTimeInterface) {
            $result[$keys[57]] = $result[$keys[57]]->format('c');
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
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ApConfigTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setApMacaddr($value);
                break;
            case 2:
                $this->setFwVersion($value);
                break;
            case 3:
                $this->setFwVersionNext($value);
                break;
            case 4:
                $this->setPlatform($value);
                break;
            case 5:
                $this->setIp($value);
                break;
            case 6:
                $this->setIsp($value);
                break;
            case 7:
                $this->setSsid($value);
                break;
            case 8:
                $this->setNeedUpdate($value);
                break;
            case 9:
                $this->setFwUpgrade($value);
                break;
            case 10:
                $this->setFwFile($value);
                break;
            case 11:
                $this->setSsidUpdate($value);
                break;
            case 12:
                $this->setSsidNext($value);
                break;
            case 13:
                $this->setSafeSleep($value);
                break;
            case 14:
                $this->setResetNeed($value);
                break;
            case 15:
                $this->setNormalMode($value);
                break;
            case 16:
                $this->setUpdateUamdomains($value);
                break;
            case 17:
                $this->setUamdomains($value);
                break;
            case 18:
                $this->setUamdomainsNext($value);
                break;
            case 19:
                $this->setUpdateUamformat($value);
                break;
            case 20:
                $this->setUamformat($value);
                break;
            case 21:
                $this->setUamformatNext($value);
                break;
            case 22:
                $this->setUpdateUamhomepage($value);
                break;
            case 23:
                $this->setUamhomepage($value);
                break;
            case 24:
                $this->setUamhomepageNext($value);
                break;
            case 25:
                $this->setUpdateMacauth($value);
                break;
            case 26:
                $this->setMacauth($value);
                break;
            case 27:
                $this->setMacauthNext($value);
                break;
            case 28:
                $this->setUpdateChannel($value);
                break;
            case 29:
                $this->setChannel($value);
                break;
            case 30:
                $this->setChannelNext($value);
                break;
            case 31:
                $this->setUpdateHwmode($value);
                break;
            case 32:
                $this->setHwmode($value);
                break;
            case 33:
                $this->setHwmodeNext($value);
                break;
            case 34:
                $this->setUpdateHtmode($value);
                break;
            case 35:
                $this->setHtmode($value);
                break;
            case 36:
                $this->setHtmodeNext($value);
                break;
            case 37:
                $this->setUpdateNoscan($value);
                break;
            case 38:
                $this->setNoscan($value);
                break;
            case 39:
                $this->setNoscanNext($value);
                break;
            case 40:
                $this->setUpdateEncryption($value);
                break;
            case 41:
                $this->setEncryption($value);
                break;
            case 42:
                $this->setEncryptionNext($value);
                break;
            case 43:
                $this->setUpdateKey($value);
                break;
            case 44:
                $this->setKey($value);
                break;
            case 45:
                $this->setKeyNext($value);
                break;
            case 46:
                $this->setUpdateLanNetwork($value);
                break;
            case 47:
                $this->setLanNetwork($value);
                break;
            case 48:
                $this->setUpdateHosts($value);
                break;
            case 49:
                $this->setHosts($value);
                break;
            case 50:
                $this->setIwinfo($value);
                break;
            case 51:
                $this->setNeedReboot($value);
                break;
            case 52:
                $this->setWifiEnable($value);
                break;
            case 53:
                $this->setBwProfileId($value);
                break;
            case 54:
                $this->setExclude($value);
                break;
            case 55:
                $this->setActivated($value);
                break;
            case 56:
                $this->setCreatedAt($value);
                break;
            case 57:
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
        $keys = ApConfigTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setApMacaddr($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFwVersion($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setFwVersionNext($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPlatform($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setIp($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setIsp($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setSsid($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setNeedUpdate($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setFwUpgrade($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setFwFile($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setSsidUpdate($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setSsidNext($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setSafeSleep($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setResetNeed($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setNormalMode($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setUpdateUamdomains($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setUamdomains($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setUamdomainsNext($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setUpdateUamformat($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setUamformat($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setUamformatNext($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setUpdateUamhomepage($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->setUamhomepage($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->setUamhomepageNext($arr[$keys[24]]);
        }
        if (array_key_exists($keys[25], $arr)) {
            $this->setUpdateMacauth($arr[$keys[25]]);
        }
        if (array_key_exists($keys[26], $arr)) {
            $this->setMacauth($arr[$keys[26]]);
        }
        if (array_key_exists($keys[27], $arr)) {
            $this->setMacauthNext($arr[$keys[27]]);
        }
        if (array_key_exists($keys[28], $arr)) {
            $this->setUpdateChannel($arr[$keys[28]]);
        }
        if (array_key_exists($keys[29], $arr)) {
            $this->setChannel($arr[$keys[29]]);
        }
        if (array_key_exists($keys[30], $arr)) {
            $this->setChannelNext($arr[$keys[30]]);
        }
        if (array_key_exists($keys[31], $arr)) {
            $this->setUpdateHwmode($arr[$keys[31]]);
        }
        if (array_key_exists($keys[32], $arr)) {
            $this->setHwmode($arr[$keys[32]]);
        }
        if (array_key_exists($keys[33], $arr)) {
            $this->setHwmodeNext($arr[$keys[33]]);
        }
        if (array_key_exists($keys[34], $arr)) {
            $this->setUpdateHtmode($arr[$keys[34]]);
        }
        if (array_key_exists($keys[35], $arr)) {
            $this->setHtmode($arr[$keys[35]]);
        }
        if (array_key_exists($keys[36], $arr)) {
            $this->setHtmodeNext($arr[$keys[36]]);
        }
        if (array_key_exists($keys[37], $arr)) {
            $this->setUpdateNoscan($arr[$keys[37]]);
        }
        if (array_key_exists($keys[38], $arr)) {
            $this->setNoscan($arr[$keys[38]]);
        }
        if (array_key_exists($keys[39], $arr)) {
            $this->setNoscanNext($arr[$keys[39]]);
        }
        if (array_key_exists($keys[40], $arr)) {
            $this->setUpdateEncryption($arr[$keys[40]]);
        }
        if (array_key_exists($keys[41], $arr)) {
            $this->setEncryption($arr[$keys[41]]);
        }
        if (array_key_exists($keys[42], $arr)) {
            $this->setEncryptionNext($arr[$keys[42]]);
        }
        if (array_key_exists($keys[43], $arr)) {
            $this->setUpdateKey($arr[$keys[43]]);
        }
        if (array_key_exists($keys[44], $arr)) {
            $this->setKey($arr[$keys[44]]);
        }
        if (array_key_exists($keys[45], $arr)) {
            $this->setKeyNext($arr[$keys[45]]);
        }
        if (array_key_exists($keys[46], $arr)) {
            $this->setUpdateLanNetwork($arr[$keys[46]]);
        }
        if (array_key_exists($keys[47], $arr)) {
            $this->setLanNetwork($arr[$keys[47]]);
        }
        if (array_key_exists($keys[48], $arr)) {
            $this->setUpdateHosts($arr[$keys[48]]);
        }
        if (array_key_exists($keys[49], $arr)) {
            $this->setHosts($arr[$keys[49]]);
        }
        if (array_key_exists($keys[50], $arr)) {
            $this->setIwinfo($arr[$keys[50]]);
        }
        if (array_key_exists($keys[51], $arr)) {
            $this->setNeedReboot($arr[$keys[51]]);
        }
        if (array_key_exists($keys[52], $arr)) {
            $this->setWifiEnable($arr[$keys[52]]);
        }
        if (array_key_exists($keys[53], $arr)) {
            $this->setBwProfileId($arr[$keys[53]]);
        }
        if (array_key_exists($keys[54], $arr)) {
            $this->setExclude($arr[$keys[54]]);
        }
        if (array_key_exists($keys[55], $arr)) {
            $this->setActivated($arr[$keys[55]]);
        }
        if (array_key_exists($keys[56], $arr)) {
            $this->setCreatedAt($arr[$keys[56]]);
        }
        if (array_key_exists($keys[57], $arr)) {
            $this->setUpdatedAt($arr[$keys[57]]);
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
     * @return $this|\Hotspot\AccessPointBundle\Model\ApConfig The current object, for fluid interface
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
        $criteria = new Criteria(ApConfigTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ApConfigTableMap::COL_ID)) {
            $criteria->add(ApConfigTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_AP_MACADDR)) {
            $criteria->add(ApConfigTableMap::COL_AP_MACADDR, $this->ap_macaddr);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_FW_VERSION)) {
            $criteria->add(ApConfigTableMap::COL_FW_VERSION, $this->fw_version);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_FW_VERSION_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_FW_VERSION_NEXT, $this->fw_version_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_PLATFORM)) {
            $criteria->add(ApConfigTableMap::COL_PLATFORM, $this->platform);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_IP)) {
            $criteria->add(ApConfigTableMap::COL_IP, $this->ip);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_ISP)) {
            $criteria->add(ApConfigTableMap::COL_ISP, $this->isp);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_SSID)) {
            $criteria->add(ApConfigTableMap::COL_SSID, $this->ssid);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_NEED_UPDATE)) {
            $criteria->add(ApConfigTableMap::COL_NEED_UPDATE, $this->need_update);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_FW_UPGRADE)) {
            $criteria->add(ApConfigTableMap::COL_FW_UPGRADE, $this->fw_upgrade);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_FW_FILE)) {
            $criteria->add(ApConfigTableMap::COL_FW_FILE, $this->fw_file);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_SSID_UPDATE)) {
            $criteria->add(ApConfigTableMap::COL_SSID_UPDATE, $this->ssid_update);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_SSID_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_SSID_NEXT, $this->ssid_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_SAFE_SLEEP)) {
            $criteria->add(ApConfigTableMap::COL_SAFE_SLEEP, $this->safe_sleep);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_RESET_NEED)) {
            $criteria->add(ApConfigTableMap::COL_RESET_NEED, $this->reset_need);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_NORMAL_MODE)) {
            $criteria->add(ApConfigTableMap::COL_NORMAL_MODE, $this->normal_mode);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_UAMDOMAINS)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_UAMDOMAINS, $this->update_uamdomains);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMDOMAINS)) {
            $criteria->add(ApConfigTableMap::COL_UAMDOMAINS, $this->uamdomains);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMDOMAINS_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_UAMDOMAINS_NEXT, $this->uamdomains_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_UAMFORMAT)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_UAMFORMAT, $this->update_uamformat);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMFORMAT)) {
            $criteria->add(ApConfigTableMap::COL_UAMFORMAT, $this->uamformat);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMFORMAT_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_UAMFORMAT_NEXT, $this->uamformat_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_UAMHOMEPAGE)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_UAMHOMEPAGE, $this->update_uamhomepage);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMHOMEPAGE)) {
            $criteria->add(ApConfigTableMap::COL_UAMHOMEPAGE, $this->uamhomepage);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UAMHOMEPAGE_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_UAMHOMEPAGE_NEXT, $this->uamhomepage_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_MACAUTH)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_MACAUTH, $this->update_macauth);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_MACAUTH)) {
            $criteria->add(ApConfigTableMap::COL_MACAUTH, $this->macauth);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_MACAUTH_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_MACAUTH_NEXT, $this->macauth_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_CHANNEL)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_CHANNEL, $this->update_channel);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_CHANNEL)) {
            $criteria->add(ApConfigTableMap::COL_CHANNEL, $this->channel);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_CHANNEL_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_CHANNEL_NEXT, $this->channel_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_HWMODE)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_HWMODE, $this->update_hwmode);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_HWMODE)) {
            $criteria->add(ApConfigTableMap::COL_HWMODE, $this->hwmode);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_HWMODE_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_HWMODE_NEXT, $this->hwmode_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_HTMODE)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_HTMODE, $this->update_htmode);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_HTMODE)) {
            $criteria->add(ApConfigTableMap::COL_HTMODE, $this->htmode);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_HTMODE_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_HTMODE_NEXT, $this->htmode_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_NOSCAN)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_NOSCAN, $this->update_noscan);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_NOSCAN)) {
            $criteria->add(ApConfigTableMap::COL_NOSCAN, $this->noscan);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_NOSCAN_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_NOSCAN_NEXT, $this->noscan_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_ENCRYPTION)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_ENCRYPTION, $this->update_encryption);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_ENCRYPTION)) {
            $criteria->add(ApConfigTableMap::COL_ENCRYPTION, $this->encryption);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_ENCRYPTION_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_ENCRYPTION_NEXT, $this->encryption_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_KEY)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_KEY, $this->update_key);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_KEY)) {
            $criteria->add(ApConfigTableMap::COL_KEY, $this->key);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_KEY_NEXT)) {
            $criteria->add(ApConfigTableMap::COL_KEY_NEXT, $this->key_next);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_LAN_NETWORK)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_LAN_NETWORK, $this->update_lan_network);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_LAN_NETWORK)) {
            $criteria->add(ApConfigTableMap::COL_LAN_NETWORK, $this->lan_network);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATE_HOSTS)) {
            $criteria->add(ApConfigTableMap::COL_UPDATE_HOSTS, $this->update_hosts);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_HOSTS)) {
            $criteria->add(ApConfigTableMap::COL_HOSTS, $this->hosts);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_IWINFO)) {
            $criteria->add(ApConfigTableMap::COL_IWINFO, $this->iwinfo);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_NEED_REBOOT)) {
            $criteria->add(ApConfigTableMap::COL_NEED_REBOOT, $this->need_reboot);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_WIFI_ENABLE)) {
            $criteria->add(ApConfigTableMap::COL_WIFI_ENABLE, $this->wifi_enable);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_BW_PROFILE_ID)) {
            $criteria->add(ApConfigTableMap::COL_BW_PROFILE_ID, $this->bw_profile_id);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_EXCLUDE)) {
            $criteria->add(ApConfigTableMap::COL_EXCLUDE, $this->exclude);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_ACTIVATED)) {
            $criteria->add(ApConfigTableMap::COL_ACTIVATED, $this->activated);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_CREATED_AT)) {
            $criteria->add(ApConfigTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(ApConfigTableMap::COL_UPDATED_AT)) {
            $criteria->add(ApConfigTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildApConfigQuery::create();
        $criteria->add(ApConfigTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Hotspot\AccessPointBundle\Model\ApConfig (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setApMacaddr($this->getApMacaddr());
        $copyObj->setFwVersion($this->getFwVersion());
        $copyObj->setFwVersionNext($this->getFwVersionNext());
        $copyObj->setPlatform($this->getPlatform());
        $copyObj->setIp($this->getIp());
        $copyObj->setIsp($this->getIsp());
        $copyObj->setSsid($this->getSsid());
        $copyObj->setNeedUpdate($this->getNeedUpdate());
        $copyObj->setFwUpgrade($this->getFwUpgrade());
        $copyObj->setFwFile($this->getFwFile());
        $copyObj->setSsidUpdate($this->getSsidUpdate());
        $copyObj->setSsidNext($this->getSsidNext());
        $copyObj->setSafeSleep($this->getSafeSleep());
        $copyObj->setResetNeed($this->getResetNeed());
        $copyObj->setNormalMode($this->getNormalMode());
        $copyObj->setUpdateUamdomains($this->getUpdateUamdomains());
        $copyObj->setUamdomains($this->getUamdomains());
        $copyObj->setUamdomainsNext($this->getUamdomainsNext());
        $copyObj->setUpdateUamformat($this->getUpdateUamformat());
        $copyObj->setUamformat($this->getUamformat());
        $copyObj->setUamformatNext($this->getUamformatNext());
        $copyObj->setUpdateUamhomepage($this->getUpdateUamhomepage());
        $copyObj->setUamhomepage($this->getUamhomepage());
        $copyObj->setUamhomepageNext($this->getUamhomepageNext());
        $copyObj->setUpdateMacauth($this->getUpdateMacauth());
        $copyObj->setMacauth($this->getMacauth());
        $copyObj->setMacauthNext($this->getMacauthNext());
        $copyObj->setUpdateChannel($this->getUpdateChannel());
        $copyObj->setChannel($this->getChannel());
        $copyObj->setChannelNext($this->getChannelNext());
        $copyObj->setUpdateHwmode($this->getUpdateHwmode());
        $copyObj->setHwmode($this->getHwmode());
        $copyObj->setHwmodeNext($this->getHwmodeNext());
        $copyObj->setUpdateHtmode($this->getUpdateHtmode());
        $copyObj->setHtmode($this->getHtmode());
        $copyObj->setHtmodeNext($this->getHtmodeNext());
        $copyObj->setUpdateNoscan($this->getUpdateNoscan());
        $copyObj->setNoscan($this->getNoscan());
        $copyObj->setNoscanNext($this->getNoscanNext());
        $copyObj->setUpdateEncryption($this->getUpdateEncryption());
        $copyObj->setEncryption($this->getEncryption());
        $copyObj->setEncryptionNext($this->getEncryptionNext());
        $copyObj->setUpdateKey($this->getUpdateKey());
        $copyObj->setKey($this->getKey());
        $copyObj->setKeyNext($this->getKeyNext());
        $copyObj->setUpdateLanNetwork($this->getUpdateLanNetwork());
        $copyObj->setLanNetwork($this->getLanNetwork());
        $copyObj->setUpdateHosts($this->getUpdateHosts());
        $copyObj->setHosts($this->getHosts());
        $copyObj->setIwinfo($this->getIwinfo());
        $copyObj->setNeedReboot($this->getNeedReboot());
        $copyObj->setWifiEnable($this->getWifiEnable());
        $copyObj->setBwProfileId($this->getBwProfileId());
        $copyObj->setExclude($this->getExclude());
        $copyObj->setActivated($this->getActivated());
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
     * @return \Hotspot\AccessPointBundle\Model\ApConfig Clone of current object.
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
        $this->ap_macaddr = null;
        $this->fw_version = null;
        $this->fw_version_next = null;
        $this->platform = null;
        $this->ip = null;
        $this->isp = null;
        $this->ssid = null;
        $this->need_update = null;
        $this->fw_upgrade = null;
        $this->fw_file = null;
        $this->ssid_update = null;
        $this->ssid_next = null;
        $this->safe_sleep = null;
        $this->reset_need = null;
        $this->normal_mode = null;
        $this->update_uamdomains = null;
        $this->uamdomains = null;
        $this->uamdomains_next = null;
        $this->update_uamformat = null;
        $this->uamformat = null;
        $this->uamformat_next = null;
        $this->update_uamhomepage = null;
        $this->uamhomepage = null;
        $this->uamhomepage_next = null;
        $this->update_macauth = null;
        $this->macauth = null;
        $this->macauth_next = null;
        $this->update_channel = null;
        $this->channel = null;
        $this->channel_next = null;
        $this->update_hwmode = null;
        $this->hwmode = null;
        $this->hwmode_next = null;
        $this->update_htmode = null;
        $this->htmode = null;
        $this->htmode_next = null;
        $this->update_noscan = null;
        $this->noscan = null;
        $this->noscan_next = null;
        $this->update_encryption = null;
        $this->encryption = null;
        $this->encryption_next = null;
        $this->update_key = null;
        $this->key = null;
        $this->key_next = null;
        $this->update_lan_network = null;
        $this->lan_network = null;
        $this->update_hosts = null;
        $this->hosts = null;
        $this->iwinfo = null;
        $this->need_reboot = null;
        $this->wifi_enable = null;
        $this->bw_profile_id = null;
        $this->exclude = null;
        $this->activated = null;
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
        return (string) $this->exportTo(ApConfigTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildApConfig The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[ApConfigTableMap::COL_UPDATED_AT] = true;

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
