<?php

namespace Hotspot\AccessPointBundle\Model\Map;

use Hotspot\AccessPointBundle\Model\ApConfig;
use Hotspot\AccessPointBundle\Model\ApConfigQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'ap_config' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ApConfigTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Hotspot.AccessPointBundle.Model.Map.ApConfigTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'ap_config';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Hotspot\\AccessPointBundle\\Model\\ApConfig';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Hotspot.AccessPointBundle.Model.ApConfig';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 58;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 58;

    /**
     * the column name for the id field
     */
    const COL_ID = 'ap_config.id';

    /**
     * the column name for the ap_macaddr field
     */
    const COL_AP_MACADDR = 'ap_config.ap_macaddr';

    /**
     * the column name for the fw_version field
     */
    const COL_FW_VERSION = 'ap_config.fw_version';

    /**
     * the column name for the fw_version_next field
     */
    const COL_FW_VERSION_NEXT = 'ap_config.fw_version_next';

    /**
     * the column name for the platform field
     */
    const COL_PLATFORM = 'ap_config.platform';

    /**
     * the column name for the ip field
     */
    const COL_IP = 'ap_config.ip';

    /**
     * the column name for the isp field
     */
    const COL_ISP = 'ap_config.isp';

    /**
     * the column name for the ssid field
     */
    const COL_SSID = 'ap_config.ssid';

    /**
     * the column name for the need_update field
     */
    const COL_NEED_UPDATE = 'ap_config.need_update';

    /**
     * the column name for the fw_upgrade field
     */
    const COL_FW_UPGRADE = 'ap_config.fw_upgrade';

    /**
     * the column name for the fw_file field
     */
    const COL_FW_FILE = 'ap_config.fw_file';

    /**
     * the column name for the ssid_update field
     */
    const COL_SSID_UPDATE = 'ap_config.ssid_update';

    /**
     * the column name for the ssid_next field
     */
    const COL_SSID_NEXT = 'ap_config.ssid_next';

    /**
     * the column name for the safe_sleep field
     */
    const COL_SAFE_SLEEP = 'ap_config.safe_sleep';

    /**
     * the column name for the reset_need field
     */
    const COL_RESET_NEED = 'ap_config.reset_need';

    /**
     * the column name for the normal_mode field
     */
    const COL_NORMAL_MODE = 'ap_config.normal_mode';

    /**
     * the column name for the update_uamdomains field
     */
    const COL_UPDATE_UAMDOMAINS = 'ap_config.update_uamdomains';

    /**
     * the column name for the uamdomains field
     */
    const COL_UAMDOMAINS = 'ap_config.uamdomains';

    /**
     * the column name for the uamdomains_next field
     */
    const COL_UAMDOMAINS_NEXT = 'ap_config.uamdomains_next';

    /**
     * the column name for the update_uamformat field
     */
    const COL_UPDATE_UAMFORMAT = 'ap_config.update_uamformat';

    /**
     * the column name for the uamformat field
     */
    const COL_UAMFORMAT = 'ap_config.uamformat';

    /**
     * the column name for the uamformat_next field
     */
    const COL_UAMFORMAT_NEXT = 'ap_config.uamformat_next';

    /**
     * the column name for the update_uamhomepage field
     */
    const COL_UPDATE_UAMHOMEPAGE = 'ap_config.update_uamhomepage';

    /**
     * the column name for the uamhomepage field
     */
    const COL_UAMHOMEPAGE = 'ap_config.uamhomepage';

    /**
     * the column name for the uamhomepage_next field
     */
    const COL_UAMHOMEPAGE_NEXT = 'ap_config.uamhomepage_next';

    /**
     * the column name for the update_macauth field
     */
    const COL_UPDATE_MACAUTH = 'ap_config.update_macauth';

    /**
     * the column name for the macauth field
     */
    const COL_MACAUTH = 'ap_config.macauth';

    /**
     * the column name for the macauth_next field
     */
    const COL_MACAUTH_NEXT = 'ap_config.macauth_next';

    /**
     * the column name for the update_channel field
     */
    const COL_UPDATE_CHANNEL = 'ap_config.update_channel';

    /**
     * the column name for the channel field
     */
    const COL_CHANNEL = 'ap_config.channel';

    /**
     * the column name for the channel_next field
     */
    const COL_CHANNEL_NEXT = 'ap_config.channel_next';

    /**
     * the column name for the update_hwmode field
     */
    const COL_UPDATE_HWMODE = 'ap_config.update_hwmode';

    /**
     * the column name for the hwmode field
     */
    const COL_HWMODE = 'ap_config.hwmode';

    /**
     * the column name for the hwmode_next field
     */
    const COL_HWMODE_NEXT = 'ap_config.hwmode_next';

    /**
     * the column name for the update_htmode field
     */
    const COL_UPDATE_HTMODE = 'ap_config.update_htmode';

    /**
     * the column name for the htmode field
     */
    const COL_HTMODE = 'ap_config.htmode';

    /**
     * the column name for the htmode_next field
     */
    const COL_HTMODE_NEXT = 'ap_config.htmode_next';

    /**
     * the column name for the update_noscan field
     */
    const COL_UPDATE_NOSCAN = 'ap_config.update_noscan';

    /**
     * the column name for the noscan field
     */
    const COL_NOSCAN = 'ap_config.noscan';

    /**
     * the column name for the noscan_next field
     */
    const COL_NOSCAN_NEXT = 'ap_config.noscan_next';

    /**
     * the column name for the update_encryption field
     */
    const COL_UPDATE_ENCRYPTION = 'ap_config.update_encryption';

    /**
     * the column name for the encryption field
     */
    const COL_ENCRYPTION = 'ap_config.encryption';

    /**
     * the column name for the encryption_next field
     */
    const COL_ENCRYPTION_NEXT = 'ap_config.encryption_next';

    /**
     * the column name for the update_key field
     */
    const COL_UPDATE_KEY = 'ap_config.update_key';

    /**
     * the column name for the key field
     */
    const COL_KEY = 'ap_config.key';

    /**
     * the column name for the key_next field
     */
    const COL_KEY_NEXT = 'ap_config.key_next';

    /**
     * the column name for the update_lan_network field
     */
    const COL_UPDATE_LAN_NETWORK = 'ap_config.update_lan_network';

    /**
     * the column name for the lan_network field
     */
    const COL_LAN_NETWORK = 'ap_config.lan_network';

    /**
     * the column name for the update_hosts field
     */
    const COL_UPDATE_HOSTS = 'ap_config.update_hosts';

    /**
     * the column name for the hosts field
     */
    const COL_HOSTS = 'ap_config.hosts';

    /**
     * the column name for the iwinfo field
     */
    const COL_IWINFO = 'ap_config.iwinfo';

    /**
     * the column name for the need_reboot field
     */
    const COL_NEED_REBOOT = 'ap_config.need_reboot';

    /**
     * the column name for the wifi_enable field
     */
    const COL_WIFI_ENABLE = 'ap_config.wifi_enable';

    /**
     * the column name for the bw_profile_id field
     */
    const COL_BW_PROFILE_ID = 'ap_config.bw_profile_id';

    /**
     * the column name for the exclude field
     */
    const COL_EXCLUDE = 'ap_config.exclude';

    /**
     * the column name for the activated field
     */
    const COL_ACTIVATED = 'ap_config.activated';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'ap_config.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'ap_config.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'ApMacaddr', 'FwVersion', 'FwVersionNext', 'Platform', 'Ip', 'Isp', 'Ssid', 'NeedUpdate', 'FwUpgrade', 'FwFile', 'SsidUpdate', 'SsidNext', 'SafeSleep', 'ResetNeed', 'NormalMode', 'UpdateUamdomains', 'Uamdomains', 'UamdomainsNext', 'UpdateUamformat', 'Uamformat', 'UamformatNext', 'UpdateUamhomepage', 'Uamhomepage', 'UamhomepageNext', 'UpdateMacauth', 'Macauth', 'MacauthNext', 'UpdateChannel', 'Channel', 'ChannelNext', 'UpdateHwmode', 'Hwmode', 'HwmodeNext', 'UpdateHtmode', 'Htmode', 'HtmodeNext', 'UpdateNoscan', 'Noscan', 'NoscanNext', 'UpdateEncryption', 'Encryption', 'EncryptionNext', 'UpdateKey', 'Key', 'KeyNext', 'UpdateLanNetwork', 'LanNetwork', 'UpdateHosts', 'Hosts', 'Iwinfo', 'NeedReboot', 'WifiEnable', 'BwProfileId', 'Exclude', 'Activated', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'apMacaddr', 'fwVersion', 'fwVersionNext', 'platform', 'ip', 'isp', 'ssid', 'needUpdate', 'fwUpgrade', 'fwFile', 'ssidUpdate', 'ssidNext', 'safeSleep', 'resetNeed', 'normalMode', 'updateUamdomains', 'uamdomains', 'uamdomainsNext', 'updateUamformat', 'uamformat', 'uamformatNext', 'updateUamhomepage', 'uamhomepage', 'uamhomepageNext', 'updateMacauth', 'macauth', 'macauthNext', 'updateChannel', 'channel', 'channelNext', 'updateHwmode', 'hwmode', 'hwmodeNext', 'updateHtmode', 'htmode', 'htmodeNext', 'updateNoscan', 'noscan', 'noscanNext', 'updateEncryption', 'encryption', 'encryptionNext', 'updateKey', 'key', 'keyNext', 'updateLanNetwork', 'lanNetwork', 'updateHosts', 'hosts', 'iwinfo', 'needReboot', 'wifiEnable', 'bwProfileId', 'exclude', 'activated', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(ApConfigTableMap::COL_ID, ApConfigTableMap::COL_AP_MACADDR, ApConfigTableMap::COL_FW_VERSION, ApConfigTableMap::COL_FW_VERSION_NEXT, ApConfigTableMap::COL_PLATFORM, ApConfigTableMap::COL_IP, ApConfigTableMap::COL_ISP, ApConfigTableMap::COL_SSID, ApConfigTableMap::COL_NEED_UPDATE, ApConfigTableMap::COL_FW_UPGRADE, ApConfigTableMap::COL_FW_FILE, ApConfigTableMap::COL_SSID_UPDATE, ApConfigTableMap::COL_SSID_NEXT, ApConfigTableMap::COL_SAFE_SLEEP, ApConfigTableMap::COL_RESET_NEED, ApConfigTableMap::COL_NORMAL_MODE, ApConfigTableMap::COL_UPDATE_UAMDOMAINS, ApConfigTableMap::COL_UAMDOMAINS, ApConfigTableMap::COL_UAMDOMAINS_NEXT, ApConfigTableMap::COL_UPDATE_UAMFORMAT, ApConfigTableMap::COL_UAMFORMAT, ApConfigTableMap::COL_UAMFORMAT_NEXT, ApConfigTableMap::COL_UPDATE_UAMHOMEPAGE, ApConfigTableMap::COL_UAMHOMEPAGE, ApConfigTableMap::COL_UAMHOMEPAGE_NEXT, ApConfigTableMap::COL_UPDATE_MACAUTH, ApConfigTableMap::COL_MACAUTH, ApConfigTableMap::COL_MACAUTH_NEXT, ApConfigTableMap::COL_UPDATE_CHANNEL, ApConfigTableMap::COL_CHANNEL, ApConfigTableMap::COL_CHANNEL_NEXT, ApConfigTableMap::COL_UPDATE_HWMODE, ApConfigTableMap::COL_HWMODE, ApConfigTableMap::COL_HWMODE_NEXT, ApConfigTableMap::COL_UPDATE_HTMODE, ApConfigTableMap::COL_HTMODE, ApConfigTableMap::COL_HTMODE_NEXT, ApConfigTableMap::COL_UPDATE_NOSCAN, ApConfigTableMap::COL_NOSCAN, ApConfigTableMap::COL_NOSCAN_NEXT, ApConfigTableMap::COL_UPDATE_ENCRYPTION, ApConfigTableMap::COL_ENCRYPTION, ApConfigTableMap::COL_ENCRYPTION_NEXT, ApConfigTableMap::COL_UPDATE_KEY, ApConfigTableMap::COL_KEY, ApConfigTableMap::COL_KEY_NEXT, ApConfigTableMap::COL_UPDATE_LAN_NETWORK, ApConfigTableMap::COL_LAN_NETWORK, ApConfigTableMap::COL_UPDATE_HOSTS, ApConfigTableMap::COL_HOSTS, ApConfigTableMap::COL_IWINFO, ApConfigTableMap::COL_NEED_REBOOT, ApConfigTableMap::COL_WIFI_ENABLE, ApConfigTableMap::COL_BW_PROFILE_ID, ApConfigTableMap::COL_EXCLUDE, ApConfigTableMap::COL_ACTIVATED, ApConfigTableMap::COL_CREATED_AT, ApConfigTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'ap_macaddr', 'fw_version', 'fw_version_next', 'platform', 'ip', 'isp', 'ssid', 'need_update', 'fw_upgrade', 'fw_file', 'ssid_update', 'ssid_next', 'safe_sleep', 'reset_need', 'normal_mode', 'update_uamdomains', 'uamdomains', 'uamdomains_next', 'update_uamformat', 'uamformat', 'uamformat_next', 'update_uamhomepage', 'uamhomepage', 'uamhomepage_next', 'update_macauth', 'macauth', 'macauth_next', 'update_channel', 'channel', 'channel_next', 'update_hwmode', 'hwmode', 'hwmode_next', 'update_htmode', 'htmode', 'htmode_next', 'update_noscan', 'noscan', 'noscan_next', 'update_encryption', 'encryption', 'encryption_next', 'update_key', 'key', 'key_next', 'update_lan_network', 'lan_network', 'update_hosts', 'hosts', 'iwinfo', 'need_reboot', 'wifi_enable', 'bw_profile_id', 'exclude', 'activated', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ApMacaddr' => 1, 'FwVersion' => 2, 'FwVersionNext' => 3, 'Platform' => 4, 'Ip' => 5, 'Isp' => 6, 'Ssid' => 7, 'NeedUpdate' => 8, 'FwUpgrade' => 9, 'FwFile' => 10, 'SsidUpdate' => 11, 'SsidNext' => 12, 'SafeSleep' => 13, 'ResetNeed' => 14, 'NormalMode' => 15, 'UpdateUamdomains' => 16, 'Uamdomains' => 17, 'UamdomainsNext' => 18, 'UpdateUamformat' => 19, 'Uamformat' => 20, 'UamformatNext' => 21, 'UpdateUamhomepage' => 22, 'Uamhomepage' => 23, 'UamhomepageNext' => 24, 'UpdateMacauth' => 25, 'Macauth' => 26, 'MacauthNext' => 27, 'UpdateChannel' => 28, 'Channel' => 29, 'ChannelNext' => 30, 'UpdateHwmode' => 31, 'Hwmode' => 32, 'HwmodeNext' => 33, 'UpdateHtmode' => 34, 'Htmode' => 35, 'HtmodeNext' => 36, 'UpdateNoscan' => 37, 'Noscan' => 38, 'NoscanNext' => 39, 'UpdateEncryption' => 40, 'Encryption' => 41, 'EncryptionNext' => 42, 'UpdateKey' => 43, 'Key' => 44, 'KeyNext' => 45, 'UpdateLanNetwork' => 46, 'LanNetwork' => 47, 'UpdateHosts' => 48, 'Hosts' => 49, 'Iwinfo' => 50, 'NeedReboot' => 51, 'WifiEnable' => 52, 'BwProfileId' => 53, 'Exclude' => 54, 'Activated' => 55, 'CreatedAt' => 56, 'UpdatedAt' => 57, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'apMacaddr' => 1, 'fwVersion' => 2, 'fwVersionNext' => 3, 'platform' => 4, 'ip' => 5, 'isp' => 6, 'ssid' => 7, 'needUpdate' => 8, 'fwUpgrade' => 9, 'fwFile' => 10, 'ssidUpdate' => 11, 'ssidNext' => 12, 'safeSleep' => 13, 'resetNeed' => 14, 'normalMode' => 15, 'updateUamdomains' => 16, 'uamdomains' => 17, 'uamdomainsNext' => 18, 'updateUamformat' => 19, 'uamformat' => 20, 'uamformatNext' => 21, 'updateUamhomepage' => 22, 'uamhomepage' => 23, 'uamhomepageNext' => 24, 'updateMacauth' => 25, 'macauth' => 26, 'macauthNext' => 27, 'updateChannel' => 28, 'channel' => 29, 'channelNext' => 30, 'updateHwmode' => 31, 'hwmode' => 32, 'hwmodeNext' => 33, 'updateHtmode' => 34, 'htmode' => 35, 'htmodeNext' => 36, 'updateNoscan' => 37, 'noscan' => 38, 'noscanNext' => 39, 'updateEncryption' => 40, 'encryption' => 41, 'encryptionNext' => 42, 'updateKey' => 43, 'key' => 44, 'keyNext' => 45, 'updateLanNetwork' => 46, 'lanNetwork' => 47, 'updateHosts' => 48, 'hosts' => 49, 'iwinfo' => 50, 'needReboot' => 51, 'wifiEnable' => 52, 'bwProfileId' => 53, 'exclude' => 54, 'activated' => 55, 'createdAt' => 56, 'updatedAt' => 57, ),
        self::TYPE_COLNAME       => array(ApConfigTableMap::COL_ID => 0, ApConfigTableMap::COL_AP_MACADDR => 1, ApConfigTableMap::COL_FW_VERSION => 2, ApConfigTableMap::COL_FW_VERSION_NEXT => 3, ApConfigTableMap::COL_PLATFORM => 4, ApConfigTableMap::COL_IP => 5, ApConfigTableMap::COL_ISP => 6, ApConfigTableMap::COL_SSID => 7, ApConfigTableMap::COL_NEED_UPDATE => 8, ApConfigTableMap::COL_FW_UPGRADE => 9, ApConfigTableMap::COL_FW_FILE => 10, ApConfigTableMap::COL_SSID_UPDATE => 11, ApConfigTableMap::COL_SSID_NEXT => 12, ApConfigTableMap::COL_SAFE_SLEEP => 13, ApConfigTableMap::COL_RESET_NEED => 14, ApConfigTableMap::COL_NORMAL_MODE => 15, ApConfigTableMap::COL_UPDATE_UAMDOMAINS => 16, ApConfigTableMap::COL_UAMDOMAINS => 17, ApConfigTableMap::COL_UAMDOMAINS_NEXT => 18, ApConfigTableMap::COL_UPDATE_UAMFORMAT => 19, ApConfigTableMap::COL_UAMFORMAT => 20, ApConfigTableMap::COL_UAMFORMAT_NEXT => 21, ApConfigTableMap::COL_UPDATE_UAMHOMEPAGE => 22, ApConfigTableMap::COL_UAMHOMEPAGE => 23, ApConfigTableMap::COL_UAMHOMEPAGE_NEXT => 24, ApConfigTableMap::COL_UPDATE_MACAUTH => 25, ApConfigTableMap::COL_MACAUTH => 26, ApConfigTableMap::COL_MACAUTH_NEXT => 27, ApConfigTableMap::COL_UPDATE_CHANNEL => 28, ApConfigTableMap::COL_CHANNEL => 29, ApConfigTableMap::COL_CHANNEL_NEXT => 30, ApConfigTableMap::COL_UPDATE_HWMODE => 31, ApConfigTableMap::COL_HWMODE => 32, ApConfigTableMap::COL_HWMODE_NEXT => 33, ApConfigTableMap::COL_UPDATE_HTMODE => 34, ApConfigTableMap::COL_HTMODE => 35, ApConfigTableMap::COL_HTMODE_NEXT => 36, ApConfigTableMap::COL_UPDATE_NOSCAN => 37, ApConfigTableMap::COL_NOSCAN => 38, ApConfigTableMap::COL_NOSCAN_NEXT => 39, ApConfigTableMap::COL_UPDATE_ENCRYPTION => 40, ApConfigTableMap::COL_ENCRYPTION => 41, ApConfigTableMap::COL_ENCRYPTION_NEXT => 42, ApConfigTableMap::COL_UPDATE_KEY => 43, ApConfigTableMap::COL_KEY => 44, ApConfigTableMap::COL_KEY_NEXT => 45, ApConfigTableMap::COL_UPDATE_LAN_NETWORK => 46, ApConfigTableMap::COL_LAN_NETWORK => 47, ApConfigTableMap::COL_UPDATE_HOSTS => 48, ApConfigTableMap::COL_HOSTS => 49, ApConfigTableMap::COL_IWINFO => 50, ApConfigTableMap::COL_NEED_REBOOT => 51, ApConfigTableMap::COL_WIFI_ENABLE => 52, ApConfigTableMap::COL_BW_PROFILE_ID => 53, ApConfigTableMap::COL_EXCLUDE => 54, ApConfigTableMap::COL_ACTIVATED => 55, ApConfigTableMap::COL_CREATED_AT => 56, ApConfigTableMap::COL_UPDATED_AT => 57, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'ap_macaddr' => 1, 'fw_version' => 2, 'fw_version_next' => 3, 'platform' => 4, 'ip' => 5, 'isp' => 6, 'ssid' => 7, 'need_update' => 8, 'fw_upgrade' => 9, 'fw_file' => 10, 'ssid_update' => 11, 'ssid_next' => 12, 'safe_sleep' => 13, 'reset_need' => 14, 'normal_mode' => 15, 'update_uamdomains' => 16, 'uamdomains' => 17, 'uamdomains_next' => 18, 'update_uamformat' => 19, 'uamformat' => 20, 'uamformat_next' => 21, 'update_uamhomepage' => 22, 'uamhomepage' => 23, 'uamhomepage_next' => 24, 'update_macauth' => 25, 'macauth' => 26, 'macauth_next' => 27, 'update_channel' => 28, 'channel' => 29, 'channel_next' => 30, 'update_hwmode' => 31, 'hwmode' => 32, 'hwmode_next' => 33, 'update_htmode' => 34, 'htmode' => 35, 'htmode_next' => 36, 'update_noscan' => 37, 'noscan' => 38, 'noscan_next' => 39, 'update_encryption' => 40, 'encryption' => 41, 'encryption_next' => 42, 'update_key' => 43, 'key' => 44, 'key_next' => 45, 'update_lan_network' => 46, 'lan_network' => 47, 'update_hosts' => 48, 'hosts' => 49, 'iwinfo' => 50, 'need_reboot' => 51, 'wifi_enable' => 52, 'bw_profile_id' => 53, 'exclude' => 54, 'activated' => 55, 'created_at' => 56, 'updated_at' => 57, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('ap_config');
        $this->setPhpName('ApConfig');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Hotspot\\AccessPointBundle\\Model\\ApConfig');
        $this->setPackage('src.Hotspot.AccessPointBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('ap_macaddr', 'ApMacaddr', 'VARCHAR', false, 50, null);
        $this->addColumn('fw_version', 'FwVersion', 'VARCHAR', false, 50, null);
        $this->addColumn('fw_version_next', 'FwVersionNext', 'VARCHAR', false, 50, null);
        $this->addColumn('platform', 'Platform', 'VARCHAR', false, 1000, null);
        $this->addColumn('ip', 'Ip', 'VARCHAR', false, 255, null);
        $this->addColumn('isp', 'Isp', 'VARCHAR', false, 255, null);
        $this->addColumn('ssid', 'Ssid', 'VARCHAR', false, 100, null);
        $this->addColumn('need_update', 'NeedUpdate', 'INTEGER', false, null, 1);
        $this->addColumn('fw_upgrade', 'FwUpgrade', 'VARCHAR', false, 50, 'option fw_upgrade 0');
        $this->addColumn('fw_file', 'FwFile', 'VARCHAR', false, 100, '');
        $this->addColumn('ssid_update', 'SsidUpdate', 'VARCHAR', false, 50, 'option ssid_update 1');
        $this->addColumn('ssid_next', 'SsidNext', 'VARCHAR', false, 100, 'option ssid "WiAds Free Wifi"');
        $this->addColumn('safe_sleep', 'SafeSleep', 'VARCHAR', false, 50, 'option safe_sleep 0');
        $this->addColumn('reset_need', 'ResetNeed', 'VARCHAR', false, 50, 'option reset_to_default 0');
        $this->addColumn('normal_mode', 'NormalMode', 'VARCHAR', false, 50, 'option normal_mode 0');
        $this->addColumn('update_uamdomains', 'UpdateUamdomains', 'VARCHAR', false, 50, 'option update_uamdomains 0');
        $this->addColumn('uamdomains', 'Uamdomains', 'VARCHAR', false, 500, '#HS_UAMDOMAINS');
        $this->addColumn('uamdomains_next', 'UamdomainsNext', 'VARCHAR', false, 500, '#HS_UAMDOMAINS');
        $this->addColumn('update_uamformat', 'UpdateUamformat', 'VARCHAR', false, 50, 'option update_uamformat 0');
        $this->addColumn('uamformat', 'Uamformat', 'VARCHAR', false, 100, null);
        $this->addColumn('uamformat_next', 'UamformatNext', 'VARCHAR', false, 100, null);
        $this->addColumn('update_uamhomepage', 'UpdateUamhomepage', 'VARCHAR', false, 50, 'option update_uamhomepage 0');
        $this->addColumn('uamhomepage', 'Uamhomepage', 'VARCHAR', false, 100, null);
        $this->addColumn('uamhomepage_next', 'UamhomepageNext', 'VARCHAR', false, 100, null);
        $this->addColumn('update_macauth', 'UpdateMacauth', 'VARCHAR', false, 50, 'option update_macauth 0');
        $this->addColumn('macauth', 'Macauth', 'VARCHAR', false, 100, null);
        $this->addColumn('macauth_next', 'MacauthNext', 'VARCHAR', false, 100, null);
        $this->addColumn('update_channel', 'UpdateChannel', 'VARCHAR', false, 50, 'option channel_update 0');
        $this->addColumn('channel', 'Channel', 'VARCHAR', false, 100, null);
        $this->addColumn('channel_next', 'ChannelNext', 'VARCHAR', false, 100, null);
        $this->addColumn('update_hwmode', 'UpdateHwmode', 'VARCHAR', false, 50, 'option hwmode_update 0');
        $this->addColumn('hwmode', 'Hwmode', 'VARCHAR', false, 100, null);
        $this->addColumn('hwmode_next', 'HwmodeNext', 'VARCHAR', false, 100, null);
        $this->addColumn('update_htmode', 'UpdateHtmode', 'VARCHAR', false, 50, 'option htmode_update 0');
        $this->addColumn('htmode', 'Htmode', 'VARCHAR', false, 100, null);
        $this->addColumn('htmode_next', 'HtmodeNext', 'VARCHAR', false, 100, null);
        $this->addColumn('update_noscan', 'UpdateNoscan', 'VARCHAR', false, 50, 'option noscan_update 0');
        $this->addColumn('noscan', 'Noscan', 'VARCHAR', false, 100, null);
        $this->addColumn('noscan_next', 'NoscanNext', 'VARCHAR', false, 100, null);
        $this->addColumn('update_encryption', 'UpdateEncryption', 'VARCHAR', false, 50, 'option encryption_update 0');
        $this->addColumn('encryption', 'Encryption', 'VARCHAR', false, 100, null);
        $this->addColumn('encryption_next', 'EncryptionNext', 'VARCHAR', false, 100, null);
        $this->addColumn('update_key', 'UpdateKey', 'VARCHAR', false, 50, 'option key_update 0');
        $this->addColumn('key', 'Key', 'VARCHAR', false, 100, null);
        $this->addColumn('key_next', 'KeyNext', 'VARCHAR', false, 100, null);
        $this->addColumn('update_lan_network', 'UpdateLanNetwork', 'VARCHAR', false, 100, 'option network_lan_update 1');
        $this->addColumn('lan_network', 'LanNetwork', 'VARCHAR', false, 100, 'option network_lan \'172.16.16.1\'');
        $this->addColumn('update_hosts', 'UpdateHosts', 'VARCHAR', false, 50, 'option hosts_update 0');
        $this->addColumn('hosts', 'Hosts', 'VARCHAR', false, 100, null);
        $this->addColumn('iwinfo', 'Iwinfo', 'VARCHAR', false, 3000, null);
        $this->addColumn('need_reboot', 'NeedReboot', 'VARCHAR', false, 50, 'option need_reboot 0');
        $this->addColumn('wifi_enable', 'WifiEnable', 'VARCHAR', false, 50, 'active wifi 1');
        $this->addColumn('bw_profile_id', 'BwProfileId', 'INTEGER', false, null, 1);
        $this->addColumn('exclude', 'Exclude', 'INTEGER', false, null, 0);
        $this->addColumn('activated', 'Activated', 'INTEGER', false, null, 0);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? ApConfigTableMap::CLASS_DEFAULT : ApConfigTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (ApConfig object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ApConfigTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ApConfigTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ApConfigTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ApConfigTableMap::OM_CLASS;
            /** @var ApConfig $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ApConfigTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = ApConfigTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ApConfigTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ApConfig $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ApConfigTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ApConfigTableMap::COL_ID);
            $criteria->addSelectColumn(ApConfigTableMap::COL_AP_MACADDR);
            $criteria->addSelectColumn(ApConfigTableMap::COL_FW_VERSION);
            $criteria->addSelectColumn(ApConfigTableMap::COL_FW_VERSION_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_PLATFORM);
            $criteria->addSelectColumn(ApConfigTableMap::COL_IP);
            $criteria->addSelectColumn(ApConfigTableMap::COL_ISP);
            $criteria->addSelectColumn(ApConfigTableMap::COL_SSID);
            $criteria->addSelectColumn(ApConfigTableMap::COL_NEED_UPDATE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_FW_UPGRADE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_FW_FILE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_SSID_UPDATE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_SSID_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_SAFE_SLEEP);
            $criteria->addSelectColumn(ApConfigTableMap::COL_RESET_NEED);
            $criteria->addSelectColumn(ApConfigTableMap::COL_NORMAL_MODE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_UAMDOMAINS);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UAMDOMAINS);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UAMDOMAINS_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_UAMFORMAT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UAMFORMAT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UAMFORMAT_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_UAMHOMEPAGE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UAMHOMEPAGE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UAMHOMEPAGE_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_MACAUTH);
            $criteria->addSelectColumn(ApConfigTableMap::COL_MACAUTH);
            $criteria->addSelectColumn(ApConfigTableMap::COL_MACAUTH_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_CHANNEL);
            $criteria->addSelectColumn(ApConfigTableMap::COL_CHANNEL);
            $criteria->addSelectColumn(ApConfigTableMap::COL_CHANNEL_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_HWMODE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_HWMODE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_HWMODE_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_HTMODE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_HTMODE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_HTMODE_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_NOSCAN);
            $criteria->addSelectColumn(ApConfigTableMap::COL_NOSCAN);
            $criteria->addSelectColumn(ApConfigTableMap::COL_NOSCAN_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_ENCRYPTION);
            $criteria->addSelectColumn(ApConfigTableMap::COL_ENCRYPTION);
            $criteria->addSelectColumn(ApConfigTableMap::COL_ENCRYPTION_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_KEY);
            $criteria->addSelectColumn(ApConfigTableMap::COL_KEY);
            $criteria->addSelectColumn(ApConfigTableMap::COL_KEY_NEXT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_LAN_NETWORK);
            $criteria->addSelectColumn(ApConfigTableMap::COL_LAN_NETWORK);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATE_HOSTS);
            $criteria->addSelectColumn(ApConfigTableMap::COL_HOSTS);
            $criteria->addSelectColumn(ApConfigTableMap::COL_IWINFO);
            $criteria->addSelectColumn(ApConfigTableMap::COL_NEED_REBOOT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_WIFI_ENABLE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_BW_PROFILE_ID);
            $criteria->addSelectColumn(ApConfigTableMap::COL_EXCLUDE);
            $criteria->addSelectColumn(ApConfigTableMap::COL_ACTIVATED);
            $criteria->addSelectColumn(ApConfigTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(ApConfigTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.ap_macaddr');
            $criteria->addSelectColumn($alias . '.fw_version');
            $criteria->addSelectColumn($alias . '.fw_version_next');
            $criteria->addSelectColumn($alias . '.platform');
            $criteria->addSelectColumn($alias . '.ip');
            $criteria->addSelectColumn($alias . '.isp');
            $criteria->addSelectColumn($alias . '.ssid');
            $criteria->addSelectColumn($alias . '.need_update');
            $criteria->addSelectColumn($alias . '.fw_upgrade');
            $criteria->addSelectColumn($alias . '.fw_file');
            $criteria->addSelectColumn($alias . '.ssid_update');
            $criteria->addSelectColumn($alias . '.ssid_next');
            $criteria->addSelectColumn($alias . '.safe_sleep');
            $criteria->addSelectColumn($alias . '.reset_need');
            $criteria->addSelectColumn($alias . '.normal_mode');
            $criteria->addSelectColumn($alias . '.update_uamdomains');
            $criteria->addSelectColumn($alias . '.uamdomains');
            $criteria->addSelectColumn($alias . '.uamdomains_next');
            $criteria->addSelectColumn($alias . '.update_uamformat');
            $criteria->addSelectColumn($alias . '.uamformat');
            $criteria->addSelectColumn($alias . '.uamformat_next');
            $criteria->addSelectColumn($alias . '.update_uamhomepage');
            $criteria->addSelectColumn($alias . '.uamhomepage');
            $criteria->addSelectColumn($alias . '.uamhomepage_next');
            $criteria->addSelectColumn($alias . '.update_macauth');
            $criteria->addSelectColumn($alias . '.macauth');
            $criteria->addSelectColumn($alias . '.macauth_next');
            $criteria->addSelectColumn($alias . '.update_channel');
            $criteria->addSelectColumn($alias . '.channel');
            $criteria->addSelectColumn($alias . '.channel_next');
            $criteria->addSelectColumn($alias . '.update_hwmode');
            $criteria->addSelectColumn($alias . '.hwmode');
            $criteria->addSelectColumn($alias . '.hwmode_next');
            $criteria->addSelectColumn($alias . '.update_htmode');
            $criteria->addSelectColumn($alias . '.htmode');
            $criteria->addSelectColumn($alias . '.htmode_next');
            $criteria->addSelectColumn($alias . '.update_noscan');
            $criteria->addSelectColumn($alias . '.noscan');
            $criteria->addSelectColumn($alias . '.noscan_next');
            $criteria->addSelectColumn($alias . '.update_encryption');
            $criteria->addSelectColumn($alias . '.encryption');
            $criteria->addSelectColumn($alias . '.encryption_next');
            $criteria->addSelectColumn($alias . '.update_key');
            $criteria->addSelectColumn($alias . '.key');
            $criteria->addSelectColumn($alias . '.key_next');
            $criteria->addSelectColumn($alias . '.update_lan_network');
            $criteria->addSelectColumn($alias . '.lan_network');
            $criteria->addSelectColumn($alias . '.update_hosts');
            $criteria->addSelectColumn($alias . '.hosts');
            $criteria->addSelectColumn($alias . '.iwinfo');
            $criteria->addSelectColumn($alias . '.need_reboot');
            $criteria->addSelectColumn($alias . '.wifi_enable');
            $criteria->addSelectColumn($alias . '.bw_profile_id');
            $criteria->addSelectColumn($alias . '.exclude');
            $criteria->addSelectColumn($alias . '.activated');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(ApConfigTableMap::DATABASE_NAME)->getTable(ApConfigTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ApConfigTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ApConfigTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ApConfigTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ApConfig or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ApConfig object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApConfigTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Hotspot\AccessPointBundle\Model\ApConfig) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ApConfigTableMap::DATABASE_NAME);
            $criteria->add(ApConfigTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ApConfigQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ApConfigTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ApConfigTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ap_config table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ApConfigQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ApConfig or Criteria object.
     *
     * @param mixed               $criteria Criteria or ApConfig object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApConfigTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ApConfig object
        }

        if ($criteria->containsKey(ApConfigTableMap::COL_ID) && $criteria->keyContainsValue(ApConfigTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ApConfigTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ApConfigQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ApConfigTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ApConfigTableMap::buildTableMap();
