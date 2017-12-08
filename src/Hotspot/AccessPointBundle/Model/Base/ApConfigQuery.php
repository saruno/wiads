<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\ApConfig as ChildApConfig;
use Hotspot\AccessPointBundle\Model\ApConfigQuery as ChildApConfigQuery;
use Hotspot\AccessPointBundle\Model\Map\ApConfigTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ap_config' table.
 *
 *
 *
 * @method     ChildApConfigQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildApConfigQuery orderByApMacaddr($order = Criteria::ASC) Order by the ap_macaddr column
 * @method     ChildApConfigQuery orderByFwVersion($order = Criteria::ASC) Order by the fw_version column
 * @method     ChildApConfigQuery orderByFwVersionNext($order = Criteria::ASC) Order by the fw_version_next column
 * @method     ChildApConfigQuery orderByPlatform($order = Criteria::ASC) Order by the platform column
 * @method     ChildApConfigQuery orderByIp($order = Criteria::ASC) Order by the ip column
 * @method     ChildApConfigQuery orderByIsp($order = Criteria::ASC) Order by the isp column
 * @method     ChildApConfigQuery orderBySsid($order = Criteria::ASC) Order by the ssid column
 * @method     ChildApConfigQuery orderByNeedUpdate($order = Criteria::ASC) Order by the need_update column
 * @method     ChildApConfigQuery orderByFwUpgrade($order = Criteria::ASC) Order by the fw_upgrade column
 * @method     ChildApConfigQuery orderByFwFile($order = Criteria::ASC) Order by the fw_file column
 * @method     ChildApConfigQuery orderBySsidUpdate($order = Criteria::ASC) Order by the ssid_update column
 * @method     ChildApConfigQuery orderBySsidNext($order = Criteria::ASC) Order by the ssid_next column
 * @method     ChildApConfigQuery orderBySafeSleep($order = Criteria::ASC) Order by the safe_sleep column
 * @method     ChildApConfigQuery orderByResetNeed($order = Criteria::ASC) Order by the reset_need column
 * @method     ChildApConfigQuery orderByNormalMode($order = Criteria::ASC) Order by the normal_mode column
 * @method     ChildApConfigQuery orderByUpdateUamdomains($order = Criteria::ASC) Order by the update_uamdomains column
 * @method     ChildApConfigQuery orderByUamdomains($order = Criteria::ASC) Order by the uamdomains column
 * @method     ChildApConfigQuery orderByUamdomainsNext($order = Criteria::ASC) Order by the uamdomains_next column
 * @method     ChildApConfigQuery orderByUpdateUamformat($order = Criteria::ASC) Order by the update_uamformat column
 * @method     ChildApConfigQuery orderByUamformat($order = Criteria::ASC) Order by the uamformat column
 * @method     ChildApConfigQuery orderByUamformatNext($order = Criteria::ASC) Order by the uamformat_next column
 * @method     ChildApConfigQuery orderByUpdateUamhomepage($order = Criteria::ASC) Order by the update_uamhomepage column
 * @method     ChildApConfigQuery orderByUamhomepage($order = Criteria::ASC) Order by the uamhomepage column
 * @method     ChildApConfigQuery orderByUamhomepageNext($order = Criteria::ASC) Order by the uamhomepage_next column
 * @method     ChildApConfigQuery orderByUpdateMacauth($order = Criteria::ASC) Order by the update_macauth column
 * @method     ChildApConfigQuery orderByMacauth($order = Criteria::ASC) Order by the macauth column
 * @method     ChildApConfigQuery orderByMacauthNext($order = Criteria::ASC) Order by the macauth_next column
 * @method     ChildApConfigQuery orderByUpdateChannel($order = Criteria::ASC) Order by the update_channel column
 * @method     ChildApConfigQuery orderByChannel($order = Criteria::ASC) Order by the channel column
 * @method     ChildApConfigQuery orderByChannelNext($order = Criteria::ASC) Order by the channel_next column
 * @method     ChildApConfigQuery orderByUpdateHwmode($order = Criteria::ASC) Order by the update_hwmode column
 * @method     ChildApConfigQuery orderByHwmode($order = Criteria::ASC) Order by the hwmode column
 * @method     ChildApConfigQuery orderByHwmodeNext($order = Criteria::ASC) Order by the hwmode_next column
 * @method     ChildApConfigQuery orderByUpdateHtmode($order = Criteria::ASC) Order by the update_htmode column
 * @method     ChildApConfigQuery orderByHtmode($order = Criteria::ASC) Order by the htmode column
 * @method     ChildApConfigQuery orderByHtmodeNext($order = Criteria::ASC) Order by the htmode_next column
 * @method     ChildApConfigQuery orderByUpdateNoscan($order = Criteria::ASC) Order by the update_noscan column
 * @method     ChildApConfigQuery orderByNoscan($order = Criteria::ASC) Order by the noscan column
 * @method     ChildApConfigQuery orderByNoscanNext($order = Criteria::ASC) Order by the noscan_next column
 * @method     ChildApConfigQuery orderByUpdateEncryption($order = Criteria::ASC) Order by the update_encryption column
 * @method     ChildApConfigQuery orderByEncryption($order = Criteria::ASC) Order by the encryption column
 * @method     ChildApConfigQuery orderByEncryptionNext($order = Criteria::ASC) Order by the encryption_next column
 * @method     ChildApConfigQuery orderByUpdateKey($order = Criteria::ASC) Order by the update_key column
 * @method     ChildApConfigQuery orderByKey($order = Criteria::ASC) Order by the key column
 * @method     ChildApConfigQuery orderByKeyNext($order = Criteria::ASC) Order by the key_next column
 * @method     ChildApConfigQuery orderByUpdateLanNetwork($order = Criteria::ASC) Order by the update_lan_network column
 * @method     ChildApConfigQuery orderByLanNetwork($order = Criteria::ASC) Order by the lan_network column
 * @method     ChildApConfigQuery orderByUpdateHosts($order = Criteria::ASC) Order by the update_hosts column
 * @method     ChildApConfigQuery orderByHosts($order = Criteria::ASC) Order by the hosts column
 * @method     ChildApConfigQuery orderByIwinfo($order = Criteria::ASC) Order by the iwinfo column
 * @method     ChildApConfigQuery orderByNeedReboot($order = Criteria::ASC) Order by the need_reboot column
 * @method     ChildApConfigQuery orderByWifiEnable($order = Criteria::ASC) Order by the wifi_enable column
 * @method     ChildApConfigQuery orderByBwProfileId($order = Criteria::ASC) Order by the bw_profile_id column
 * @method     ChildApConfigQuery orderByExclude($order = Criteria::ASC) Order by the exclude column
 * @method     ChildApConfigQuery orderByActivated($order = Criteria::ASC) Order by the activated column
 * @method     ChildApConfigQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildApConfigQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildApConfigQuery groupById() Group by the id column
 * @method     ChildApConfigQuery groupByApMacaddr() Group by the ap_macaddr column
 * @method     ChildApConfigQuery groupByFwVersion() Group by the fw_version column
 * @method     ChildApConfigQuery groupByFwVersionNext() Group by the fw_version_next column
 * @method     ChildApConfigQuery groupByPlatform() Group by the platform column
 * @method     ChildApConfigQuery groupByIp() Group by the ip column
 * @method     ChildApConfigQuery groupByIsp() Group by the isp column
 * @method     ChildApConfigQuery groupBySsid() Group by the ssid column
 * @method     ChildApConfigQuery groupByNeedUpdate() Group by the need_update column
 * @method     ChildApConfigQuery groupByFwUpgrade() Group by the fw_upgrade column
 * @method     ChildApConfigQuery groupByFwFile() Group by the fw_file column
 * @method     ChildApConfigQuery groupBySsidUpdate() Group by the ssid_update column
 * @method     ChildApConfigQuery groupBySsidNext() Group by the ssid_next column
 * @method     ChildApConfigQuery groupBySafeSleep() Group by the safe_sleep column
 * @method     ChildApConfigQuery groupByResetNeed() Group by the reset_need column
 * @method     ChildApConfigQuery groupByNormalMode() Group by the normal_mode column
 * @method     ChildApConfigQuery groupByUpdateUamdomains() Group by the update_uamdomains column
 * @method     ChildApConfigQuery groupByUamdomains() Group by the uamdomains column
 * @method     ChildApConfigQuery groupByUamdomainsNext() Group by the uamdomains_next column
 * @method     ChildApConfigQuery groupByUpdateUamformat() Group by the update_uamformat column
 * @method     ChildApConfigQuery groupByUamformat() Group by the uamformat column
 * @method     ChildApConfigQuery groupByUamformatNext() Group by the uamformat_next column
 * @method     ChildApConfigQuery groupByUpdateUamhomepage() Group by the update_uamhomepage column
 * @method     ChildApConfigQuery groupByUamhomepage() Group by the uamhomepage column
 * @method     ChildApConfigQuery groupByUamhomepageNext() Group by the uamhomepage_next column
 * @method     ChildApConfigQuery groupByUpdateMacauth() Group by the update_macauth column
 * @method     ChildApConfigQuery groupByMacauth() Group by the macauth column
 * @method     ChildApConfigQuery groupByMacauthNext() Group by the macauth_next column
 * @method     ChildApConfigQuery groupByUpdateChannel() Group by the update_channel column
 * @method     ChildApConfigQuery groupByChannel() Group by the channel column
 * @method     ChildApConfigQuery groupByChannelNext() Group by the channel_next column
 * @method     ChildApConfigQuery groupByUpdateHwmode() Group by the update_hwmode column
 * @method     ChildApConfigQuery groupByHwmode() Group by the hwmode column
 * @method     ChildApConfigQuery groupByHwmodeNext() Group by the hwmode_next column
 * @method     ChildApConfigQuery groupByUpdateHtmode() Group by the update_htmode column
 * @method     ChildApConfigQuery groupByHtmode() Group by the htmode column
 * @method     ChildApConfigQuery groupByHtmodeNext() Group by the htmode_next column
 * @method     ChildApConfigQuery groupByUpdateNoscan() Group by the update_noscan column
 * @method     ChildApConfigQuery groupByNoscan() Group by the noscan column
 * @method     ChildApConfigQuery groupByNoscanNext() Group by the noscan_next column
 * @method     ChildApConfigQuery groupByUpdateEncryption() Group by the update_encryption column
 * @method     ChildApConfigQuery groupByEncryption() Group by the encryption column
 * @method     ChildApConfigQuery groupByEncryptionNext() Group by the encryption_next column
 * @method     ChildApConfigQuery groupByUpdateKey() Group by the update_key column
 * @method     ChildApConfigQuery groupByKey() Group by the key column
 * @method     ChildApConfigQuery groupByKeyNext() Group by the key_next column
 * @method     ChildApConfigQuery groupByUpdateLanNetwork() Group by the update_lan_network column
 * @method     ChildApConfigQuery groupByLanNetwork() Group by the lan_network column
 * @method     ChildApConfigQuery groupByUpdateHosts() Group by the update_hosts column
 * @method     ChildApConfigQuery groupByHosts() Group by the hosts column
 * @method     ChildApConfigQuery groupByIwinfo() Group by the iwinfo column
 * @method     ChildApConfigQuery groupByNeedReboot() Group by the need_reboot column
 * @method     ChildApConfigQuery groupByWifiEnable() Group by the wifi_enable column
 * @method     ChildApConfigQuery groupByBwProfileId() Group by the bw_profile_id column
 * @method     ChildApConfigQuery groupByExclude() Group by the exclude column
 * @method     ChildApConfigQuery groupByActivated() Group by the activated column
 * @method     ChildApConfigQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildApConfigQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildApConfigQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildApConfigQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildApConfigQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildApConfigQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildApConfigQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildApConfigQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildApConfig findOne(ConnectionInterface $con = null) Return the first ChildApConfig matching the query
 * @method     ChildApConfig findOneOrCreate(ConnectionInterface $con = null) Return the first ChildApConfig matching the query, or a new ChildApConfig object populated from the query conditions when no match is found
 *
 * @method     ChildApConfig findOneById(int $id) Return the first ChildApConfig filtered by the id column
 * @method     ChildApConfig findOneByApMacaddr(string $ap_macaddr) Return the first ChildApConfig filtered by the ap_macaddr column
 * @method     ChildApConfig findOneByFwVersion(string $fw_version) Return the first ChildApConfig filtered by the fw_version column
 * @method     ChildApConfig findOneByFwVersionNext(string $fw_version_next) Return the first ChildApConfig filtered by the fw_version_next column
 * @method     ChildApConfig findOneByPlatform(string $platform) Return the first ChildApConfig filtered by the platform column
 * @method     ChildApConfig findOneByIp(string $ip) Return the first ChildApConfig filtered by the ip column
 * @method     ChildApConfig findOneByIsp(string $isp) Return the first ChildApConfig filtered by the isp column
 * @method     ChildApConfig findOneBySsid(string $ssid) Return the first ChildApConfig filtered by the ssid column
 * @method     ChildApConfig findOneByNeedUpdate(int $need_update) Return the first ChildApConfig filtered by the need_update column
 * @method     ChildApConfig findOneByFwUpgrade(string $fw_upgrade) Return the first ChildApConfig filtered by the fw_upgrade column
 * @method     ChildApConfig findOneByFwFile(string $fw_file) Return the first ChildApConfig filtered by the fw_file column
 * @method     ChildApConfig findOneBySsidUpdate(string $ssid_update) Return the first ChildApConfig filtered by the ssid_update column
 * @method     ChildApConfig findOneBySsidNext(string $ssid_next) Return the first ChildApConfig filtered by the ssid_next column
 * @method     ChildApConfig findOneBySafeSleep(string $safe_sleep) Return the first ChildApConfig filtered by the safe_sleep column
 * @method     ChildApConfig findOneByResetNeed(string $reset_need) Return the first ChildApConfig filtered by the reset_need column
 * @method     ChildApConfig findOneByNormalMode(string $normal_mode) Return the first ChildApConfig filtered by the normal_mode column
 * @method     ChildApConfig findOneByUpdateUamdomains(string $update_uamdomains) Return the first ChildApConfig filtered by the update_uamdomains column
 * @method     ChildApConfig findOneByUamdomains(string $uamdomains) Return the first ChildApConfig filtered by the uamdomains column
 * @method     ChildApConfig findOneByUamdomainsNext(string $uamdomains_next) Return the first ChildApConfig filtered by the uamdomains_next column
 * @method     ChildApConfig findOneByUpdateUamformat(string $update_uamformat) Return the first ChildApConfig filtered by the update_uamformat column
 * @method     ChildApConfig findOneByUamformat(string $uamformat) Return the first ChildApConfig filtered by the uamformat column
 * @method     ChildApConfig findOneByUamformatNext(string $uamformat_next) Return the first ChildApConfig filtered by the uamformat_next column
 * @method     ChildApConfig findOneByUpdateUamhomepage(string $update_uamhomepage) Return the first ChildApConfig filtered by the update_uamhomepage column
 * @method     ChildApConfig findOneByUamhomepage(string $uamhomepage) Return the first ChildApConfig filtered by the uamhomepage column
 * @method     ChildApConfig findOneByUamhomepageNext(string $uamhomepage_next) Return the first ChildApConfig filtered by the uamhomepage_next column
 * @method     ChildApConfig findOneByUpdateMacauth(string $update_macauth) Return the first ChildApConfig filtered by the update_macauth column
 * @method     ChildApConfig findOneByMacauth(string $macauth) Return the first ChildApConfig filtered by the macauth column
 * @method     ChildApConfig findOneByMacauthNext(string $macauth_next) Return the first ChildApConfig filtered by the macauth_next column
 * @method     ChildApConfig findOneByUpdateChannel(string $update_channel) Return the first ChildApConfig filtered by the update_channel column
 * @method     ChildApConfig findOneByChannel(string $channel) Return the first ChildApConfig filtered by the channel column
 * @method     ChildApConfig findOneByChannelNext(string $channel_next) Return the first ChildApConfig filtered by the channel_next column
 * @method     ChildApConfig findOneByUpdateHwmode(string $update_hwmode) Return the first ChildApConfig filtered by the update_hwmode column
 * @method     ChildApConfig findOneByHwmode(string $hwmode) Return the first ChildApConfig filtered by the hwmode column
 * @method     ChildApConfig findOneByHwmodeNext(string $hwmode_next) Return the first ChildApConfig filtered by the hwmode_next column
 * @method     ChildApConfig findOneByUpdateHtmode(string $update_htmode) Return the first ChildApConfig filtered by the update_htmode column
 * @method     ChildApConfig findOneByHtmode(string $htmode) Return the first ChildApConfig filtered by the htmode column
 * @method     ChildApConfig findOneByHtmodeNext(string $htmode_next) Return the first ChildApConfig filtered by the htmode_next column
 * @method     ChildApConfig findOneByUpdateNoscan(string $update_noscan) Return the first ChildApConfig filtered by the update_noscan column
 * @method     ChildApConfig findOneByNoscan(string $noscan) Return the first ChildApConfig filtered by the noscan column
 * @method     ChildApConfig findOneByNoscanNext(string $noscan_next) Return the first ChildApConfig filtered by the noscan_next column
 * @method     ChildApConfig findOneByUpdateEncryption(string $update_encryption) Return the first ChildApConfig filtered by the update_encryption column
 * @method     ChildApConfig findOneByEncryption(string $encryption) Return the first ChildApConfig filtered by the encryption column
 * @method     ChildApConfig findOneByEncryptionNext(string $encryption_next) Return the first ChildApConfig filtered by the encryption_next column
 * @method     ChildApConfig findOneByUpdateKey(string $update_key) Return the first ChildApConfig filtered by the update_key column
 * @method     ChildApConfig findOneByKey(string $key) Return the first ChildApConfig filtered by the key column
 * @method     ChildApConfig findOneByKeyNext(string $key_next) Return the first ChildApConfig filtered by the key_next column
 * @method     ChildApConfig findOneByUpdateLanNetwork(string $update_lan_network) Return the first ChildApConfig filtered by the update_lan_network column
 * @method     ChildApConfig findOneByLanNetwork(string $lan_network) Return the first ChildApConfig filtered by the lan_network column
 * @method     ChildApConfig findOneByUpdateHosts(string $update_hosts) Return the first ChildApConfig filtered by the update_hosts column
 * @method     ChildApConfig findOneByHosts(string $hosts) Return the first ChildApConfig filtered by the hosts column
 * @method     ChildApConfig findOneByIwinfo(string $iwinfo) Return the first ChildApConfig filtered by the iwinfo column
 * @method     ChildApConfig findOneByNeedReboot(string $need_reboot) Return the first ChildApConfig filtered by the need_reboot column
 * @method     ChildApConfig findOneByWifiEnable(string $wifi_enable) Return the first ChildApConfig filtered by the wifi_enable column
 * @method     ChildApConfig findOneByBwProfileId(int $bw_profile_id) Return the first ChildApConfig filtered by the bw_profile_id column
 * @method     ChildApConfig findOneByExclude(int $exclude) Return the first ChildApConfig filtered by the exclude column
 * @method     ChildApConfig findOneByActivated(int $activated) Return the first ChildApConfig filtered by the activated column
 * @method     ChildApConfig findOneByCreatedAt(string $created_at) Return the first ChildApConfig filtered by the created_at column
 * @method     ChildApConfig findOneByUpdatedAt(string $updated_at) Return the first ChildApConfig filtered by the updated_at column *

 * @method     ChildApConfig requirePk($key, ConnectionInterface $con = null) Return the ChildApConfig by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOne(ConnectionInterface $con = null) Return the first ChildApConfig matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildApConfig requireOneById(int $id) Return the first ChildApConfig filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByApMacaddr(string $ap_macaddr) Return the first ChildApConfig filtered by the ap_macaddr column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByFwVersion(string $fw_version) Return the first ChildApConfig filtered by the fw_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByFwVersionNext(string $fw_version_next) Return the first ChildApConfig filtered by the fw_version_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByPlatform(string $platform) Return the first ChildApConfig filtered by the platform column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByIp(string $ip) Return the first ChildApConfig filtered by the ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByIsp(string $isp) Return the first ChildApConfig filtered by the isp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneBySsid(string $ssid) Return the first ChildApConfig filtered by the ssid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByNeedUpdate(int $need_update) Return the first ChildApConfig filtered by the need_update column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByFwUpgrade(string $fw_upgrade) Return the first ChildApConfig filtered by the fw_upgrade column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByFwFile(string $fw_file) Return the first ChildApConfig filtered by the fw_file column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneBySsidUpdate(string $ssid_update) Return the first ChildApConfig filtered by the ssid_update column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneBySsidNext(string $ssid_next) Return the first ChildApConfig filtered by the ssid_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneBySafeSleep(string $safe_sleep) Return the first ChildApConfig filtered by the safe_sleep column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByResetNeed(string $reset_need) Return the first ChildApConfig filtered by the reset_need column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByNormalMode(string $normal_mode) Return the first ChildApConfig filtered by the normal_mode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateUamdomains(string $update_uamdomains) Return the first ChildApConfig filtered by the update_uamdomains column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUamdomains(string $uamdomains) Return the first ChildApConfig filtered by the uamdomains column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUamdomainsNext(string $uamdomains_next) Return the first ChildApConfig filtered by the uamdomains_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateUamformat(string $update_uamformat) Return the first ChildApConfig filtered by the update_uamformat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUamformat(string $uamformat) Return the first ChildApConfig filtered by the uamformat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUamformatNext(string $uamformat_next) Return the first ChildApConfig filtered by the uamformat_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateUamhomepage(string $update_uamhomepage) Return the first ChildApConfig filtered by the update_uamhomepage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUamhomepage(string $uamhomepage) Return the first ChildApConfig filtered by the uamhomepage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUamhomepageNext(string $uamhomepage_next) Return the first ChildApConfig filtered by the uamhomepage_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateMacauth(string $update_macauth) Return the first ChildApConfig filtered by the update_macauth column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByMacauth(string $macauth) Return the first ChildApConfig filtered by the macauth column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByMacauthNext(string $macauth_next) Return the first ChildApConfig filtered by the macauth_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateChannel(string $update_channel) Return the first ChildApConfig filtered by the update_channel column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByChannel(string $channel) Return the first ChildApConfig filtered by the channel column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByChannelNext(string $channel_next) Return the first ChildApConfig filtered by the channel_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateHwmode(string $update_hwmode) Return the first ChildApConfig filtered by the update_hwmode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByHwmode(string $hwmode) Return the first ChildApConfig filtered by the hwmode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByHwmodeNext(string $hwmode_next) Return the first ChildApConfig filtered by the hwmode_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateHtmode(string $update_htmode) Return the first ChildApConfig filtered by the update_htmode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByHtmode(string $htmode) Return the first ChildApConfig filtered by the htmode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByHtmodeNext(string $htmode_next) Return the first ChildApConfig filtered by the htmode_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateNoscan(string $update_noscan) Return the first ChildApConfig filtered by the update_noscan column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByNoscan(string $noscan) Return the first ChildApConfig filtered by the noscan column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByNoscanNext(string $noscan_next) Return the first ChildApConfig filtered by the noscan_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateEncryption(string $update_encryption) Return the first ChildApConfig filtered by the update_encryption column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByEncryption(string $encryption) Return the first ChildApConfig filtered by the encryption column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByEncryptionNext(string $encryption_next) Return the first ChildApConfig filtered by the encryption_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateKey(string $update_key) Return the first ChildApConfig filtered by the update_key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByKey(string $key) Return the first ChildApConfig filtered by the key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByKeyNext(string $key_next) Return the first ChildApConfig filtered by the key_next column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateLanNetwork(string $update_lan_network) Return the first ChildApConfig filtered by the update_lan_network column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByLanNetwork(string $lan_network) Return the first ChildApConfig filtered by the lan_network column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdateHosts(string $update_hosts) Return the first ChildApConfig filtered by the update_hosts column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByHosts(string $hosts) Return the first ChildApConfig filtered by the hosts column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByIwinfo(string $iwinfo) Return the first ChildApConfig filtered by the iwinfo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByNeedReboot(string $need_reboot) Return the first ChildApConfig filtered by the need_reboot column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByWifiEnable(string $wifi_enable) Return the first ChildApConfig filtered by the wifi_enable column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByBwProfileId(int $bw_profile_id) Return the first ChildApConfig filtered by the bw_profile_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByExclude(int $exclude) Return the first ChildApConfig filtered by the exclude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByActivated(int $activated) Return the first ChildApConfig filtered by the activated column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByCreatedAt(string $created_at) Return the first ChildApConfig filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApConfig requireOneByUpdatedAt(string $updated_at) Return the first ChildApConfig filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildApConfig[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildApConfig objects based on current ModelCriteria
 * @method     ChildApConfig[]|ObjectCollection findById(int $id) Return ChildApConfig objects filtered by the id column
 * @method     ChildApConfig[]|ObjectCollection findByApMacaddr(string $ap_macaddr) Return ChildApConfig objects filtered by the ap_macaddr column
 * @method     ChildApConfig[]|ObjectCollection findByFwVersion(string $fw_version) Return ChildApConfig objects filtered by the fw_version column
 * @method     ChildApConfig[]|ObjectCollection findByFwVersionNext(string $fw_version_next) Return ChildApConfig objects filtered by the fw_version_next column
 * @method     ChildApConfig[]|ObjectCollection findByPlatform(string $platform) Return ChildApConfig objects filtered by the platform column
 * @method     ChildApConfig[]|ObjectCollection findByIp(string $ip) Return ChildApConfig objects filtered by the ip column
 * @method     ChildApConfig[]|ObjectCollection findByIsp(string $isp) Return ChildApConfig objects filtered by the isp column
 * @method     ChildApConfig[]|ObjectCollection findBySsid(string $ssid) Return ChildApConfig objects filtered by the ssid column
 * @method     ChildApConfig[]|ObjectCollection findByNeedUpdate(int $need_update) Return ChildApConfig objects filtered by the need_update column
 * @method     ChildApConfig[]|ObjectCollection findByFwUpgrade(string $fw_upgrade) Return ChildApConfig objects filtered by the fw_upgrade column
 * @method     ChildApConfig[]|ObjectCollection findByFwFile(string $fw_file) Return ChildApConfig objects filtered by the fw_file column
 * @method     ChildApConfig[]|ObjectCollection findBySsidUpdate(string $ssid_update) Return ChildApConfig objects filtered by the ssid_update column
 * @method     ChildApConfig[]|ObjectCollection findBySsidNext(string $ssid_next) Return ChildApConfig objects filtered by the ssid_next column
 * @method     ChildApConfig[]|ObjectCollection findBySafeSleep(string $safe_sleep) Return ChildApConfig objects filtered by the safe_sleep column
 * @method     ChildApConfig[]|ObjectCollection findByResetNeed(string $reset_need) Return ChildApConfig objects filtered by the reset_need column
 * @method     ChildApConfig[]|ObjectCollection findByNormalMode(string $normal_mode) Return ChildApConfig objects filtered by the normal_mode column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateUamdomains(string $update_uamdomains) Return ChildApConfig objects filtered by the update_uamdomains column
 * @method     ChildApConfig[]|ObjectCollection findByUamdomains(string $uamdomains) Return ChildApConfig objects filtered by the uamdomains column
 * @method     ChildApConfig[]|ObjectCollection findByUamdomainsNext(string $uamdomains_next) Return ChildApConfig objects filtered by the uamdomains_next column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateUamformat(string $update_uamformat) Return ChildApConfig objects filtered by the update_uamformat column
 * @method     ChildApConfig[]|ObjectCollection findByUamformat(string $uamformat) Return ChildApConfig objects filtered by the uamformat column
 * @method     ChildApConfig[]|ObjectCollection findByUamformatNext(string $uamformat_next) Return ChildApConfig objects filtered by the uamformat_next column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateUamhomepage(string $update_uamhomepage) Return ChildApConfig objects filtered by the update_uamhomepage column
 * @method     ChildApConfig[]|ObjectCollection findByUamhomepage(string $uamhomepage) Return ChildApConfig objects filtered by the uamhomepage column
 * @method     ChildApConfig[]|ObjectCollection findByUamhomepageNext(string $uamhomepage_next) Return ChildApConfig objects filtered by the uamhomepage_next column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateMacauth(string $update_macauth) Return ChildApConfig objects filtered by the update_macauth column
 * @method     ChildApConfig[]|ObjectCollection findByMacauth(string $macauth) Return ChildApConfig objects filtered by the macauth column
 * @method     ChildApConfig[]|ObjectCollection findByMacauthNext(string $macauth_next) Return ChildApConfig objects filtered by the macauth_next column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateChannel(string $update_channel) Return ChildApConfig objects filtered by the update_channel column
 * @method     ChildApConfig[]|ObjectCollection findByChannel(string $channel) Return ChildApConfig objects filtered by the channel column
 * @method     ChildApConfig[]|ObjectCollection findByChannelNext(string $channel_next) Return ChildApConfig objects filtered by the channel_next column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateHwmode(string $update_hwmode) Return ChildApConfig objects filtered by the update_hwmode column
 * @method     ChildApConfig[]|ObjectCollection findByHwmode(string $hwmode) Return ChildApConfig objects filtered by the hwmode column
 * @method     ChildApConfig[]|ObjectCollection findByHwmodeNext(string $hwmode_next) Return ChildApConfig objects filtered by the hwmode_next column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateHtmode(string $update_htmode) Return ChildApConfig objects filtered by the update_htmode column
 * @method     ChildApConfig[]|ObjectCollection findByHtmode(string $htmode) Return ChildApConfig objects filtered by the htmode column
 * @method     ChildApConfig[]|ObjectCollection findByHtmodeNext(string $htmode_next) Return ChildApConfig objects filtered by the htmode_next column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateNoscan(string $update_noscan) Return ChildApConfig objects filtered by the update_noscan column
 * @method     ChildApConfig[]|ObjectCollection findByNoscan(string $noscan) Return ChildApConfig objects filtered by the noscan column
 * @method     ChildApConfig[]|ObjectCollection findByNoscanNext(string $noscan_next) Return ChildApConfig objects filtered by the noscan_next column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateEncryption(string $update_encryption) Return ChildApConfig objects filtered by the update_encryption column
 * @method     ChildApConfig[]|ObjectCollection findByEncryption(string $encryption) Return ChildApConfig objects filtered by the encryption column
 * @method     ChildApConfig[]|ObjectCollection findByEncryptionNext(string $encryption_next) Return ChildApConfig objects filtered by the encryption_next column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateKey(string $update_key) Return ChildApConfig objects filtered by the update_key column
 * @method     ChildApConfig[]|ObjectCollection findByKey(string $key) Return ChildApConfig objects filtered by the key column
 * @method     ChildApConfig[]|ObjectCollection findByKeyNext(string $key_next) Return ChildApConfig objects filtered by the key_next column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateLanNetwork(string $update_lan_network) Return ChildApConfig objects filtered by the update_lan_network column
 * @method     ChildApConfig[]|ObjectCollection findByLanNetwork(string $lan_network) Return ChildApConfig objects filtered by the lan_network column
 * @method     ChildApConfig[]|ObjectCollection findByUpdateHosts(string $update_hosts) Return ChildApConfig objects filtered by the update_hosts column
 * @method     ChildApConfig[]|ObjectCollection findByHosts(string $hosts) Return ChildApConfig objects filtered by the hosts column
 * @method     ChildApConfig[]|ObjectCollection findByIwinfo(string $iwinfo) Return ChildApConfig objects filtered by the iwinfo column
 * @method     ChildApConfig[]|ObjectCollection findByNeedReboot(string $need_reboot) Return ChildApConfig objects filtered by the need_reboot column
 * @method     ChildApConfig[]|ObjectCollection findByWifiEnable(string $wifi_enable) Return ChildApConfig objects filtered by the wifi_enable column
 * @method     ChildApConfig[]|ObjectCollection findByBwProfileId(int $bw_profile_id) Return ChildApConfig objects filtered by the bw_profile_id column
 * @method     ChildApConfig[]|ObjectCollection findByExclude(int $exclude) Return ChildApConfig objects filtered by the exclude column
 * @method     ChildApConfig[]|ObjectCollection findByActivated(int $activated) Return ChildApConfig objects filtered by the activated column
 * @method     ChildApConfig[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildApConfig objects filtered by the created_at column
 * @method     ChildApConfig[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildApConfig objects filtered by the updated_at column
 * @method     ChildApConfig[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ApConfigQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Hotspot\AccessPointBundle\Model\Base\ApConfigQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Hotspot\\AccessPointBundle\\Model\\ApConfig', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildApConfigQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildApConfigQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildApConfigQuery) {
            return $criteria;
        }
        $query = new ChildApConfigQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildApConfig|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ApConfigTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ApConfigTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildApConfig A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `ap_macaddr`, `fw_version`, `fw_version_next`, `platform`, `ip`, `isp`, `ssid`, `need_update`, `fw_upgrade`, `fw_file`, `ssid_update`, `ssid_next`, `safe_sleep`, `reset_need`, `normal_mode`, `update_uamdomains`, `uamdomains`, `uamdomains_next`, `update_uamformat`, `uamformat`, `uamformat_next`, `update_uamhomepage`, `uamhomepage`, `uamhomepage_next`, `update_macauth`, `macauth`, `macauth_next`, `update_channel`, `channel`, `channel_next`, `update_hwmode`, `hwmode`, `hwmode_next`, `update_htmode`, `htmode`, `htmode_next`, `update_noscan`, `noscan`, `noscan_next`, `update_encryption`, `encryption`, `encryption_next`, `update_key`, `key`, `key_next`, `update_lan_network`, `lan_network`, `update_hosts`, `hosts`, `iwinfo`, `need_reboot`, `wifi_enable`, `bw_profile_id`, `exclude`, `activated`, `created_at`, `updated_at` FROM `ap_config` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildApConfig $obj */
            $obj = new ChildApConfig();
            $obj->hydrate($row);
            ApConfigTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildApConfig|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ApConfigTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ApConfigTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the ap_macaddr column
     *
     * Example usage:
     * <code>
     * $query->filterByApMacaddr('fooValue');   // WHERE ap_macaddr = 'fooValue'
     * $query->filterByApMacaddr('%fooValue%', Criteria::LIKE); // WHERE ap_macaddr LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apMacaddr The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByApMacaddr($apMacaddr = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apMacaddr)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_AP_MACADDR, $apMacaddr, $comparison);
    }

    /**
     * Filter the query on the fw_version column
     *
     * Example usage:
     * <code>
     * $query->filterByFwVersion('fooValue');   // WHERE fw_version = 'fooValue'
     * $query->filterByFwVersion('%fooValue%', Criteria::LIKE); // WHERE fw_version LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fwVersion The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByFwVersion($fwVersion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fwVersion)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_FW_VERSION, $fwVersion, $comparison);
    }

    /**
     * Filter the query on the fw_version_next column
     *
     * Example usage:
     * <code>
     * $query->filterByFwVersionNext('fooValue');   // WHERE fw_version_next = 'fooValue'
     * $query->filterByFwVersionNext('%fooValue%', Criteria::LIKE); // WHERE fw_version_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fwVersionNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByFwVersionNext($fwVersionNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fwVersionNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_FW_VERSION_NEXT, $fwVersionNext, $comparison);
    }

    /**
     * Filter the query on the platform column
     *
     * Example usage:
     * <code>
     * $query->filterByPlatform('fooValue');   // WHERE platform = 'fooValue'
     * $query->filterByPlatform('%fooValue%', Criteria::LIKE); // WHERE platform LIKE '%fooValue%'
     * </code>
     *
     * @param     string $platform The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByPlatform($platform = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($platform)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_PLATFORM, $platform, $comparison);
    }

    /**
     * Filter the query on the ip column
     *
     * Example usage:
     * <code>
     * $query->filterByIp('fooValue');   // WHERE ip = 'fooValue'
     * $query->filterByIp('%fooValue%', Criteria::LIKE); // WHERE ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ip The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByIp($ip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ip)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_IP, $ip, $comparison);
    }

    /**
     * Filter the query on the isp column
     *
     * Example usage:
     * <code>
     * $query->filterByIsp('fooValue');   // WHERE isp = 'fooValue'
     * $query->filterByIsp('%fooValue%', Criteria::LIKE); // WHERE isp LIKE '%fooValue%'
     * </code>
     *
     * @param     string $isp The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByIsp($isp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($isp)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_ISP, $isp, $comparison);
    }

    /**
     * Filter the query on the ssid column
     *
     * Example usage:
     * <code>
     * $query->filterBySsid('fooValue');   // WHERE ssid = 'fooValue'
     * $query->filterBySsid('%fooValue%', Criteria::LIKE); // WHERE ssid LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ssid The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterBySsid($ssid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ssid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_SSID, $ssid, $comparison);
    }

    /**
     * Filter the query on the need_update column
     *
     * Example usage:
     * <code>
     * $query->filterByNeedUpdate(1234); // WHERE need_update = 1234
     * $query->filterByNeedUpdate(array(12, 34)); // WHERE need_update IN (12, 34)
     * $query->filterByNeedUpdate(array('min' => 12)); // WHERE need_update > 12
     * </code>
     *
     * @param     mixed $needUpdate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByNeedUpdate($needUpdate = null, $comparison = null)
    {
        if (is_array($needUpdate)) {
            $useMinMax = false;
            if (isset($needUpdate['min'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_NEED_UPDATE, $needUpdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($needUpdate['max'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_NEED_UPDATE, $needUpdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_NEED_UPDATE, $needUpdate, $comparison);
    }

    /**
     * Filter the query on the fw_upgrade column
     *
     * Example usage:
     * <code>
     * $query->filterByFwUpgrade('fooValue');   // WHERE fw_upgrade = 'fooValue'
     * $query->filterByFwUpgrade('%fooValue%', Criteria::LIKE); // WHERE fw_upgrade LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fwUpgrade The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByFwUpgrade($fwUpgrade = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fwUpgrade)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_FW_UPGRADE, $fwUpgrade, $comparison);
    }

    /**
     * Filter the query on the fw_file column
     *
     * Example usage:
     * <code>
     * $query->filterByFwFile('fooValue');   // WHERE fw_file = 'fooValue'
     * $query->filterByFwFile('%fooValue%', Criteria::LIKE); // WHERE fw_file LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fwFile The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByFwFile($fwFile = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fwFile)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_FW_FILE, $fwFile, $comparison);
    }

    /**
     * Filter the query on the ssid_update column
     *
     * Example usage:
     * <code>
     * $query->filterBySsidUpdate('fooValue');   // WHERE ssid_update = 'fooValue'
     * $query->filterBySsidUpdate('%fooValue%', Criteria::LIKE); // WHERE ssid_update LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ssidUpdate The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterBySsidUpdate($ssidUpdate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ssidUpdate)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_SSID_UPDATE, $ssidUpdate, $comparison);
    }

    /**
     * Filter the query on the ssid_next column
     *
     * Example usage:
     * <code>
     * $query->filterBySsidNext('fooValue');   // WHERE ssid_next = 'fooValue'
     * $query->filterBySsidNext('%fooValue%', Criteria::LIKE); // WHERE ssid_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ssidNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterBySsidNext($ssidNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ssidNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_SSID_NEXT, $ssidNext, $comparison);
    }

    /**
     * Filter the query on the safe_sleep column
     *
     * Example usage:
     * <code>
     * $query->filterBySafeSleep('fooValue');   // WHERE safe_sleep = 'fooValue'
     * $query->filterBySafeSleep('%fooValue%', Criteria::LIKE); // WHERE safe_sleep LIKE '%fooValue%'
     * </code>
     *
     * @param     string $safeSleep The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterBySafeSleep($safeSleep = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($safeSleep)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_SAFE_SLEEP, $safeSleep, $comparison);
    }

    /**
     * Filter the query on the reset_need column
     *
     * Example usage:
     * <code>
     * $query->filterByResetNeed('fooValue');   // WHERE reset_need = 'fooValue'
     * $query->filterByResetNeed('%fooValue%', Criteria::LIKE); // WHERE reset_need LIKE '%fooValue%'
     * </code>
     *
     * @param     string $resetNeed The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByResetNeed($resetNeed = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($resetNeed)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_RESET_NEED, $resetNeed, $comparison);
    }

    /**
     * Filter the query on the normal_mode column
     *
     * Example usage:
     * <code>
     * $query->filterByNormalMode('fooValue');   // WHERE normal_mode = 'fooValue'
     * $query->filterByNormalMode('%fooValue%', Criteria::LIKE); // WHERE normal_mode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $normalMode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByNormalMode($normalMode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($normalMode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_NORMAL_MODE, $normalMode, $comparison);
    }

    /**
     * Filter the query on the update_uamdomains column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateUamdomains('fooValue');   // WHERE update_uamdomains = 'fooValue'
     * $query->filterByUpdateUamdomains('%fooValue%', Criteria::LIKE); // WHERE update_uamdomains LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateUamdomains The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateUamdomains($updateUamdomains = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateUamdomains)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_UAMDOMAINS, $updateUamdomains, $comparison);
    }

    /**
     * Filter the query on the uamdomains column
     *
     * Example usage:
     * <code>
     * $query->filterByUamdomains('fooValue');   // WHERE uamdomains = 'fooValue'
     * $query->filterByUamdomains('%fooValue%', Criteria::LIKE); // WHERE uamdomains LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uamdomains The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUamdomains($uamdomains = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uamdomains)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UAMDOMAINS, $uamdomains, $comparison);
    }

    /**
     * Filter the query on the uamdomains_next column
     *
     * Example usage:
     * <code>
     * $query->filterByUamdomainsNext('fooValue');   // WHERE uamdomains_next = 'fooValue'
     * $query->filterByUamdomainsNext('%fooValue%', Criteria::LIKE); // WHERE uamdomains_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uamdomainsNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUamdomainsNext($uamdomainsNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uamdomainsNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UAMDOMAINS_NEXT, $uamdomainsNext, $comparison);
    }

    /**
     * Filter the query on the update_uamformat column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateUamformat('fooValue');   // WHERE update_uamformat = 'fooValue'
     * $query->filterByUpdateUamformat('%fooValue%', Criteria::LIKE); // WHERE update_uamformat LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateUamformat The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateUamformat($updateUamformat = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateUamformat)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_UAMFORMAT, $updateUamformat, $comparison);
    }

    /**
     * Filter the query on the uamformat column
     *
     * Example usage:
     * <code>
     * $query->filterByUamformat('fooValue');   // WHERE uamformat = 'fooValue'
     * $query->filterByUamformat('%fooValue%', Criteria::LIKE); // WHERE uamformat LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uamformat The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUamformat($uamformat = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uamformat)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UAMFORMAT, $uamformat, $comparison);
    }

    /**
     * Filter the query on the uamformat_next column
     *
     * Example usage:
     * <code>
     * $query->filterByUamformatNext('fooValue');   // WHERE uamformat_next = 'fooValue'
     * $query->filterByUamformatNext('%fooValue%', Criteria::LIKE); // WHERE uamformat_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uamformatNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUamformatNext($uamformatNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uamformatNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UAMFORMAT_NEXT, $uamformatNext, $comparison);
    }

    /**
     * Filter the query on the update_uamhomepage column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateUamhomepage('fooValue');   // WHERE update_uamhomepage = 'fooValue'
     * $query->filterByUpdateUamhomepage('%fooValue%', Criteria::LIKE); // WHERE update_uamhomepage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateUamhomepage The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateUamhomepage($updateUamhomepage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateUamhomepage)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_UAMHOMEPAGE, $updateUamhomepage, $comparison);
    }

    /**
     * Filter the query on the uamhomepage column
     *
     * Example usage:
     * <code>
     * $query->filterByUamhomepage('fooValue');   // WHERE uamhomepage = 'fooValue'
     * $query->filterByUamhomepage('%fooValue%', Criteria::LIKE); // WHERE uamhomepage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uamhomepage The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUamhomepage($uamhomepage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uamhomepage)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UAMHOMEPAGE, $uamhomepage, $comparison);
    }

    /**
     * Filter the query on the uamhomepage_next column
     *
     * Example usage:
     * <code>
     * $query->filterByUamhomepageNext('fooValue');   // WHERE uamhomepage_next = 'fooValue'
     * $query->filterByUamhomepageNext('%fooValue%', Criteria::LIKE); // WHERE uamhomepage_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uamhomepageNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUamhomepageNext($uamhomepageNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uamhomepageNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UAMHOMEPAGE_NEXT, $uamhomepageNext, $comparison);
    }

    /**
     * Filter the query on the update_macauth column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateMacauth('fooValue');   // WHERE update_macauth = 'fooValue'
     * $query->filterByUpdateMacauth('%fooValue%', Criteria::LIKE); // WHERE update_macauth LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateMacauth The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateMacauth($updateMacauth = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateMacauth)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_MACAUTH, $updateMacauth, $comparison);
    }

    /**
     * Filter the query on the macauth column
     *
     * Example usage:
     * <code>
     * $query->filterByMacauth('fooValue');   // WHERE macauth = 'fooValue'
     * $query->filterByMacauth('%fooValue%', Criteria::LIKE); // WHERE macauth LIKE '%fooValue%'
     * </code>
     *
     * @param     string $macauth The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByMacauth($macauth = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($macauth)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_MACAUTH, $macauth, $comparison);
    }

    /**
     * Filter the query on the macauth_next column
     *
     * Example usage:
     * <code>
     * $query->filterByMacauthNext('fooValue');   // WHERE macauth_next = 'fooValue'
     * $query->filterByMacauthNext('%fooValue%', Criteria::LIKE); // WHERE macauth_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $macauthNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByMacauthNext($macauthNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($macauthNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_MACAUTH_NEXT, $macauthNext, $comparison);
    }

    /**
     * Filter the query on the update_channel column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateChannel('fooValue');   // WHERE update_channel = 'fooValue'
     * $query->filterByUpdateChannel('%fooValue%', Criteria::LIKE); // WHERE update_channel LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateChannel The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateChannel($updateChannel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateChannel)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_CHANNEL, $updateChannel, $comparison);
    }

    /**
     * Filter the query on the channel column
     *
     * Example usage:
     * <code>
     * $query->filterByChannel('fooValue');   // WHERE channel = 'fooValue'
     * $query->filterByChannel('%fooValue%', Criteria::LIKE); // WHERE channel LIKE '%fooValue%'
     * </code>
     *
     * @param     string $channel The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByChannel($channel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($channel)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_CHANNEL, $channel, $comparison);
    }

    /**
     * Filter the query on the channel_next column
     *
     * Example usage:
     * <code>
     * $query->filterByChannelNext('fooValue');   // WHERE channel_next = 'fooValue'
     * $query->filterByChannelNext('%fooValue%', Criteria::LIKE); // WHERE channel_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $channelNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByChannelNext($channelNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($channelNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_CHANNEL_NEXT, $channelNext, $comparison);
    }

    /**
     * Filter the query on the update_hwmode column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateHwmode('fooValue');   // WHERE update_hwmode = 'fooValue'
     * $query->filterByUpdateHwmode('%fooValue%', Criteria::LIKE); // WHERE update_hwmode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateHwmode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateHwmode($updateHwmode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateHwmode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_HWMODE, $updateHwmode, $comparison);
    }

    /**
     * Filter the query on the hwmode column
     *
     * Example usage:
     * <code>
     * $query->filterByHwmode('fooValue');   // WHERE hwmode = 'fooValue'
     * $query->filterByHwmode('%fooValue%', Criteria::LIKE); // WHERE hwmode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hwmode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByHwmode($hwmode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hwmode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_HWMODE, $hwmode, $comparison);
    }

    /**
     * Filter the query on the hwmode_next column
     *
     * Example usage:
     * <code>
     * $query->filterByHwmodeNext('fooValue');   // WHERE hwmode_next = 'fooValue'
     * $query->filterByHwmodeNext('%fooValue%', Criteria::LIKE); // WHERE hwmode_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hwmodeNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByHwmodeNext($hwmodeNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hwmodeNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_HWMODE_NEXT, $hwmodeNext, $comparison);
    }

    /**
     * Filter the query on the update_htmode column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateHtmode('fooValue');   // WHERE update_htmode = 'fooValue'
     * $query->filterByUpdateHtmode('%fooValue%', Criteria::LIKE); // WHERE update_htmode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateHtmode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateHtmode($updateHtmode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateHtmode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_HTMODE, $updateHtmode, $comparison);
    }

    /**
     * Filter the query on the htmode column
     *
     * Example usage:
     * <code>
     * $query->filterByHtmode('fooValue');   // WHERE htmode = 'fooValue'
     * $query->filterByHtmode('%fooValue%', Criteria::LIKE); // WHERE htmode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $htmode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByHtmode($htmode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($htmode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_HTMODE, $htmode, $comparison);
    }

    /**
     * Filter the query on the htmode_next column
     *
     * Example usage:
     * <code>
     * $query->filterByHtmodeNext('fooValue');   // WHERE htmode_next = 'fooValue'
     * $query->filterByHtmodeNext('%fooValue%', Criteria::LIKE); // WHERE htmode_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $htmodeNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByHtmodeNext($htmodeNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($htmodeNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_HTMODE_NEXT, $htmodeNext, $comparison);
    }

    /**
     * Filter the query on the update_noscan column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateNoscan('fooValue');   // WHERE update_noscan = 'fooValue'
     * $query->filterByUpdateNoscan('%fooValue%', Criteria::LIKE); // WHERE update_noscan LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateNoscan The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateNoscan($updateNoscan = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateNoscan)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_NOSCAN, $updateNoscan, $comparison);
    }

    /**
     * Filter the query on the noscan column
     *
     * Example usage:
     * <code>
     * $query->filterByNoscan('fooValue');   // WHERE noscan = 'fooValue'
     * $query->filterByNoscan('%fooValue%', Criteria::LIKE); // WHERE noscan LIKE '%fooValue%'
     * </code>
     *
     * @param     string $noscan The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByNoscan($noscan = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($noscan)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_NOSCAN, $noscan, $comparison);
    }

    /**
     * Filter the query on the noscan_next column
     *
     * Example usage:
     * <code>
     * $query->filterByNoscanNext('fooValue');   // WHERE noscan_next = 'fooValue'
     * $query->filterByNoscanNext('%fooValue%', Criteria::LIKE); // WHERE noscan_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $noscanNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByNoscanNext($noscanNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($noscanNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_NOSCAN_NEXT, $noscanNext, $comparison);
    }

    /**
     * Filter the query on the update_encryption column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateEncryption('fooValue');   // WHERE update_encryption = 'fooValue'
     * $query->filterByUpdateEncryption('%fooValue%', Criteria::LIKE); // WHERE update_encryption LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateEncryption The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateEncryption($updateEncryption = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateEncryption)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_ENCRYPTION, $updateEncryption, $comparison);
    }

    /**
     * Filter the query on the encryption column
     *
     * Example usage:
     * <code>
     * $query->filterByEncryption('fooValue');   // WHERE encryption = 'fooValue'
     * $query->filterByEncryption('%fooValue%', Criteria::LIKE); // WHERE encryption LIKE '%fooValue%'
     * </code>
     *
     * @param     string $encryption The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByEncryption($encryption = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($encryption)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_ENCRYPTION, $encryption, $comparison);
    }

    /**
     * Filter the query on the encryption_next column
     *
     * Example usage:
     * <code>
     * $query->filterByEncryptionNext('fooValue');   // WHERE encryption_next = 'fooValue'
     * $query->filterByEncryptionNext('%fooValue%', Criteria::LIKE); // WHERE encryption_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $encryptionNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByEncryptionNext($encryptionNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($encryptionNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_ENCRYPTION_NEXT, $encryptionNext, $comparison);
    }

    /**
     * Filter the query on the update_key column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateKey('fooValue');   // WHERE update_key = 'fooValue'
     * $query->filterByUpdateKey('%fooValue%', Criteria::LIKE); // WHERE update_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateKey The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateKey($updateKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateKey)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_KEY, $updateKey, $comparison);
    }

    /**
     * Filter the query on the key column
     *
     * Example usage:
     * <code>
     * $query->filterByKey('fooValue');   // WHERE key = 'fooValue'
     * $query->filterByKey('%fooValue%', Criteria::LIKE); // WHERE key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $key The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByKey($key = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($key)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_KEY, $key, $comparison);
    }

    /**
     * Filter the query on the key_next column
     *
     * Example usage:
     * <code>
     * $query->filterByKeyNext('fooValue');   // WHERE key_next = 'fooValue'
     * $query->filterByKeyNext('%fooValue%', Criteria::LIKE); // WHERE key_next LIKE '%fooValue%'
     * </code>
     *
     * @param     string $keyNext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByKeyNext($keyNext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($keyNext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_KEY_NEXT, $keyNext, $comparison);
    }

    /**
     * Filter the query on the update_lan_network column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateLanNetwork('fooValue');   // WHERE update_lan_network = 'fooValue'
     * $query->filterByUpdateLanNetwork('%fooValue%', Criteria::LIKE); // WHERE update_lan_network LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateLanNetwork The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateLanNetwork($updateLanNetwork = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateLanNetwork)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_LAN_NETWORK, $updateLanNetwork, $comparison);
    }

    /**
     * Filter the query on the lan_network column
     *
     * Example usage:
     * <code>
     * $query->filterByLanNetwork('fooValue');   // WHERE lan_network = 'fooValue'
     * $query->filterByLanNetwork('%fooValue%', Criteria::LIKE); // WHERE lan_network LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lanNetwork The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByLanNetwork($lanNetwork = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lanNetwork)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_LAN_NETWORK, $lanNetwork, $comparison);
    }

    /**
     * Filter the query on the update_hosts column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateHosts('fooValue');   // WHERE update_hosts = 'fooValue'
     * $query->filterByUpdateHosts('%fooValue%', Criteria::LIKE); // WHERE update_hosts LIKE '%fooValue%'
     * </code>
     *
     * @param     string $updateHosts The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdateHosts($updateHosts = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($updateHosts)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATE_HOSTS, $updateHosts, $comparison);
    }

    /**
     * Filter the query on the hosts column
     *
     * Example usage:
     * <code>
     * $query->filterByHosts('fooValue');   // WHERE hosts = 'fooValue'
     * $query->filterByHosts('%fooValue%', Criteria::LIKE); // WHERE hosts LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hosts The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByHosts($hosts = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hosts)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_HOSTS, $hosts, $comparison);
    }

    /**
     * Filter the query on the iwinfo column
     *
     * Example usage:
     * <code>
     * $query->filterByIwinfo('fooValue');   // WHERE iwinfo = 'fooValue'
     * $query->filterByIwinfo('%fooValue%', Criteria::LIKE); // WHERE iwinfo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $iwinfo The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByIwinfo($iwinfo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($iwinfo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_IWINFO, $iwinfo, $comparison);
    }

    /**
     * Filter the query on the need_reboot column
     *
     * Example usage:
     * <code>
     * $query->filterByNeedReboot('fooValue');   // WHERE need_reboot = 'fooValue'
     * $query->filterByNeedReboot('%fooValue%', Criteria::LIKE); // WHERE need_reboot LIKE '%fooValue%'
     * </code>
     *
     * @param     string $needReboot The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByNeedReboot($needReboot = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($needReboot)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_NEED_REBOOT, $needReboot, $comparison);
    }

    /**
     * Filter the query on the wifi_enable column
     *
     * Example usage:
     * <code>
     * $query->filterByWifiEnable('fooValue');   // WHERE wifi_enable = 'fooValue'
     * $query->filterByWifiEnable('%fooValue%', Criteria::LIKE); // WHERE wifi_enable LIKE '%fooValue%'
     * </code>
     *
     * @param     string $wifiEnable The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByWifiEnable($wifiEnable = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($wifiEnable)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_WIFI_ENABLE, $wifiEnable, $comparison);
    }

    /**
     * Filter the query on the bw_profile_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBwProfileId(1234); // WHERE bw_profile_id = 1234
     * $query->filterByBwProfileId(array(12, 34)); // WHERE bw_profile_id IN (12, 34)
     * $query->filterByBwProfileId(array('min' => 12)); // WHERE bw_profile_id > 12
     * </code>
     *
     * @param     mixed $bwProfileId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByBwProfileId($bwProfileId = null, $comparison = null)
    {
        if (is_array($bwProfileId)) {
            $useMinMax = false;
            if (isset($bwProfileId['min'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_BW_PROFILE_ID, $bwProfileId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bwProfileId['max'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_BW_PROFILE_ID, $bwProfileId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_BW_PROFILE_ID, $bwProfileId, $comparison);
    }

    /**
     * Filter the query on the exclude column
     *
     * Example usage:
     * <code>
     * $query->filterByExclude(1234); // WHERE exclude = 1234
     * $query->filterByExclude(array(12, 34)); // WHERE exclude IN (12, 34)
     * $query->filterByExclude(array('min' => 12)); // WHERE exclude > 12
     * </code>
     *
     * @param     mixed $exclude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByExclude($exclude = null, $comparison = null)
    {
        if (is_array($exclude)) {
            $useMinMax = false;
            if (isset($exclude['min'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_EXCLUDE, $exclude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($exclude['max'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_EXCLUDE, $exclude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_EXCLUDE, $exclude, $comparison);
    }

    /**
     * Filter the query on the activated column
     *
     * Example usage:
     * <code>
     * $query->filterByActivated(1234); // WHERE activated = 1234
     * $query->filterByActivated(array(12, 34)); // WHERE activated IN (12, 34)
     * $query->filterByActivated(array('min' => 12)); // WHERE activated > 12
     * </code>
     *
     * @param     mixed $activated The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByActivated($activated = null, $comparison = null)
    {
        if (is_array($activated)) {
            $useMinMax = false;
            if (isset($activated['min'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_ACTIVATED, $activated['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($activated['max'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_ACTIVATED, $activated['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_ACTIVATED, $activated, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ApConfigTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildApConfig $apConfig Object to remove from the list of results
     *
     * @return $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function prune($apConfig = null)
    {
        if ($apConfig) {
            $this->addUsingAlias(ApConfigTableMap::COL_ID, $apConfig->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ap_config table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApConfigTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ApConfigTableMap::clearInstancePool();
            ApConfigTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApConfigTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ApConfigTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ApConfigTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ApConfigTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ApConfigTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ApConfigTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ApConfigTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ApConfigTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ApConfigTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildApConfigQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ApConfigTableMap::COL_CREATED_AT);
    }

} // ApConfigQuery
