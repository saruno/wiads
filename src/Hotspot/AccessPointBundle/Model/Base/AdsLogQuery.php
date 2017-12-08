<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\AdsLog as ChildAdsLog;
use Hotspot\AccessPointBundle\Model\AdsLogQuery as ChildAdsLogQuery;
use Hotspot\AccessPointBundle\Model\Map\AdsLogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ads_log' table.
 *
 *
 *
 * @method     ChildAdsLogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAdsLogQuery orderByApMacaddr($order = Criteria::ASC) Order by the ap_macaddr column
 * @method     ChildAdsLogQuery orderByDeviceMacaddr($order = Criteria::ASC) Order by the device_macaddr column
 * @method     ChildAdsLogQuery orderByDevice($order = Criteria::ASC) Order by the device column
 * @method     ChildAdsLogQuery orderByWanIp($order = Criteria::ASC) Order by the wan_ip column
 * @method     ChildAdsLogQuery orderByDeviceIp($order = Criteria::ASC) Order by the device_ip column
 * @method     ChildAdsLogQuery orderByApSessionid($order = Criteria::ASC) Order by the ap_sessionid column
 * @method     ChildAdsLogQuery orderByWebSession($order = Criteria::ASC) Order by the web_session column
 * @method     ChildAdsLogQuery orderByUserUrl($order = Criteria::ASC) Order by the user_url column
 * @method     ChildAdsLogQuery orderByIsMobile($order = Criteria::ASC) Order by the is_mobile column
 * @method     ChildAdsLogQuery orderByOs($order = Criteria::ASC) Order by the os column
 * @method     ChildAdsLogQuery orderByBrowser($order = Criteria::ASC) Order by the browser column
 * @method     ChildAdsLogQuery orderByUserAgent($order = Criteria::ASC) Order by the user_agent column
 * @method     ChildAdsLogQuery orderByPhase($order = Criteria::ASC) Order by the phase column
 * @method     ChildAdsLogQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildAdsLogQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildAdsLogQuery groupById() Group by the id column
 * @method     ChildAdsLogQuery groupByApMacaddr() Group by the ap_macaddr column
 * @method     ChildAdsLogQuery groupByDeviceMacaddr() Group by the device_macaddr column
 * @method     ChildAdsLogQuery groupByDevice() Group by the device column
 * @method     ChildAdsLogQuery groupByWanIp() Group by the wan_ip column
 * @method     ChildAdsLogQuery groupByDeviceIp() Group by the device_ip column
 * @method     ChildAdsLogQuery groupByApSessionid() Group by the ap_sessionid column
 * @method     ChildAdsLogQuery groupByWebSession() Group by the web_session column
 * @method     ChildAdsLogQuery groupByUserUrl() Group by the user_url column
 * @method     ChildAdsLogQuery groupByIsMobile() Group by the is_mobile column
 * @method     ChildAdsLogQuery groupByOs() Group by the os column
 * @method     ChildAdsLogQuery groupByBrowser() Group by the browser column
 * @method     ChildAdsLogQuery groupByUserAgent() Group by the user_agent column
 * @method     ChildAdsLogQuery groupByPhase() Group by the phase column
 * @method     ChildAdsLogQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildAdsLogQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildAdsLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAdsLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAdsLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAdsLogQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAdsLogQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAdsLogQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAdsLog findOne(ConnectionInterface $con = null) Return the first ChildAdsLog matching the query
 * @method     ChildAdsLog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAdsLog matching the query, or a new ChildAdsLog object populated from the query conditions when no match is found
 *
 * @method     ChildAdsLog findOneById(int $id) Return the first ChildAdsLog filtered by the id column
 * @method     ChildAdsLog findOneByApMacaddr(string $ap_macaddr) Return the first ChildAdsLog filtered by the ap_macaddr column
 * @method     ChildAdsLog findOneByDeviceMacaddr(string $device_macaddr) Return the first ChildAdsLog filtered by the device_macaddr column
 * @method     ChildAdsLog findOneByDevice(string $device) Return the first ChildAdsLog filtered by the device column
 * @method     ChildAdsLog findOneByWanIp(string $wan_ip) Return the first ChildAdsLog filtered by the wan_ip column
 * @method     ChildAdsLog findOneByDeviceIp(string $device_ip) Return the first ChildAdsLog filtered by the device_ip column
 * @method     ChildAdsLog findOneByApSessionid(string $ap_sessionid) Return the first ChildAdsLog filtered by the ap_sessionid column
 * @method     ChildAdsLog findOneByWebSession(string $web_session) Return the first ChildAdsLog filtered by the web_session column
 * @method     ChildAdsLog findOneByUserUrl(string $user_url) Return the first ChildAdsLog filtered by the user_url column
 * @method     ChildAdsLog findOneByIsMobile(int $is_mobile) Return the first ChildAdsLog filtered by the is_mobile column
 * @method     ChildAdsLog findOneByOs(string $os) Return the first ChildAdsLog filtered by the os column
 * @method     ChildAdsLog findOneByBrowser(string $browser) Return the first ChildAdsLog filtered by the browser column
 * @method     ChildAdsLog findOneByUserAgent(string $user_agent) Return the first ChildAdsLog filtered by the user_agent column
 * @method     ChildAdsLog findOneByPhase(string $phase) Return the first ChildAdsLog filtered by the phase column
 * @method     ChildAdsLog findOneByCreatedAt(string $created_at) Return the first ChildAdsLog filtered by the created_at column
 * @method     ChildAdsLog findOneByUpdatedAt(string $updated_at) Return the first ChildAdsLog filtered by the updated_at column *

 * @method     ChildAdsLog requirePk($key, ConnectionInterface $con = null) Return the ChildAdsLog by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOne(ConnectionInterface $con = null) Return the first ChildAdsLog matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdsLog requireOneById(int $id) Return the first ChildAdsLog filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByApMacaddr(string $ap_macaddr) Return the first ChildAdsLog filtered by the ap_macaddr column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByDeviceMacaddr(string $device_macaddr) Return the first ChildAdsLog filtered by the device_macaddr column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByDevice(string $device) Return the first ChildAdsLog filtered by the device column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByWanIp(string $wan_ip) Return the first ChildAdsLog filtered by the wan_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByDeviceIp(string $device_ip) Return the first ChildAdsLog filtered by the device_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByApSessionid(string $ap_sessionid) Return the first ChildAdsLog filtered by the ap_sessionid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByWebSession(string $web_session) Return the first ChildAdsLog filtered by the web_session column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByUserUrl(string $user_url) Return the first ChildAdsLog filtered by the user_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByIsMobile(int $is_mobile) Return the first ChildAdsLog filtered by the is_mobile column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByOs(string $os) Return the first ChildAdsLog filtered by the os column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByBrowser(string $browser) Return the first ChildAdsLog filtered by the browser column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByUserAgent(string $user_agent) Return the first ChildAdsLog filtered by the user_agent column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByPhase(string $phase) Return the first ChildAdsLog filtered by the phase column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByCreatedAt(string $created_at) Return the first ChildAdsLog filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsLog requireOneByUpdatedAt(string $updated_at) Return the first ChildAdsLog filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdsLog[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAdsLog objects based on current ModelCriteria
 * @method     ChildAdsLog[]|ObjectCollection findById(int $id) Return ChildAdsLog objects filtered by the id column
 * @method     ChildAdsLog[]|ObjectCollection findByApMacaddr(string $ap_macaddr) Return ChildAdsLog objects filtered by the ap_macaddr column
 * @method     ChildAdsLog[]|ObjectCollection findByDeviceMacaddr(string $device_macaddr) Return ChildAdsLog objects filtered by the device_macaddr column
 * @method     ChildAdsLog[]|ObjectCollection findByDevice(string $device) Return ChildAdsLog objects filtered by the device column
 * @method     ChildAdsLog[]|ObjectCollection findByWanIp(string $wan_ip) Return ChildAdsLog objects filtered by the wan_ip column
 * @method     ChildAdsLog[]|ObjectCollection findByDeviceIp(string $device_ip) Return ChildAdsLog objects filtered by the device_ip column
 * @method     ChildAdsLog[]|ObjectCollection findByApSessionid(string $ap_sessionid) Return ChildAdsLog objects filtered by the ap_sessionid column
 * @method     ChildAdsLog[]|ObjectCollection findByWebSession(string $web_session) Return ChildAdsLog objects filtered by the web_session column
 * @method     ChildAdsLog[]|ObjectCollection findByUserUrl(string $user_url) Return ChildAdsLog objects filtered by the user_url column
 * @method     ChildAdsLog[]|ObjectCollection findByIsMobile(int $is_mobile) Return ChildAdsLog objects filtered by the is_mobile column
 * @method     ChildAdsLog[]|ObjectCollection findByOs(string $os) Return ChildAdsLog objects filtered by the os column
 * @method     ChildAdsLog[]|ObjectCollection findByBrowser(string $browser) Return ChildAdsLog objects filtered by the browser column
 * @method     ChildAdsLog[]|ObjectCollection findByUserAgent(string $user_agent) Return ChildAdsLog objects filtered by the user_agent column
 * @method     ChildAdsLog[]|ObjectCollection findByPhase(string $phase) Return ChildAdsLog objects filtered by the phase column
 * @method     ChildAdsLog[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildAdsLog objects filtered by the created_at column
 * @method     ChildAdsLog[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildAdsLog objects filtered by the updated_at column
 * @method     ChildAdsLog[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AdsLogQuery extends ModelCriteria
{

    // query_cache behavior
    protected $queryKey = '';
    protected static $cacheBackend;
                protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Hotspot\AccessPointBundle\Model\Base\AdsLogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Hotspot\\AccessPointBundle\\Model\\AdsLog', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAdsLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAdsLogQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAdsLogQuery) {
            return $criteria;
        }
        $query = new ChildAdsLogQuery();
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
     * @return ChildAdsLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AdsLogTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AdsLogTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAdsLog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `ap_macaddr`, `device_macaddr`, `device`, `wan_ip`, `device_ip`, `ap_sessionid`, `web_session`, `user_url`, `is_mobile`, `os`, `browser`, `user_agent`, `phase`, `created_at`, `updated_at` FROM `ads_log` WHERE `id` = :p0';
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
            /** @var ChildAdsLog $obj */
            $obj = new ChildAdsLog();
            $obj->hydrate($row);
            AdsLogTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAdsLog|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdsLogTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdsLogTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdsLogTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdsLogTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByApMacaddr($apMacaddr = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apMacaddr)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_AP_MACADDR, $apMacaddr, $comparison);
    }

    /**
     * Filter the query on the device_macaddr column
     *
     * Example usage:
     * <code>
     * $query->filterByDeviceMacaddr('fooValue');   // WHERE device_macaddr = 'fooValue'
     * $query->filterByDeviceMacaddr('%fooValue%', Criteria::LIKE); // WHERE device_macaddr LIKE '%fooValue%'
     * </code>
     *
     * @param     string $deviceMacaddr The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByDeviceMacaddr($deviceMacaddr = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($deviceMacaddr)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_DEVICE_MACADDR, $deviceMacaddr, $comparison);
    }

    /**
     * Filter the query on the device column
     *
     * Example usage:
     * <code>
     * $query->filterByDevice('fooValue');   // WHERE device = 'fooValue'
     * $query->filterByDevice('%fooValue%', Criteria::LIKE); // WHERE device LIKE '%fooValue%'
     * </code>
     *
     * @param     string $device The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByDevice($device = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($device)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_DEVICE, $device, $comparison);
    }

    /**
     * Filter the query on the wan_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByWanIp('fooValue');   // WHERE wan_ip = 'fooValue'
     * $query->filterByWanIp('%fooValue%', Criteria::LIKE); // WHERE wan_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $wanIp The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByWanIp($wanIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($wanIp)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_WAN_IP, $wanIp, $comparison);
    }

    /**
     * Filter the query on the device_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByDeviceIp('fooValue');   // WHERE device_ip = 'fooValue'
     * $query->filterByDeviceIp('%fooValue%', Criteria::LIKE); // WHERE device_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $deviceIp The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByDeviceIp($deviceIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($deviceIp)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_DEVICE_IP, $deviceIp, $comparison);
    }

    /**
     * Filter the query on the ap_sessionid column
     *
     * Example usage:
     * <code>
     * $query->filterByApSessionid('fooValue');   // WHERE ap_sessionid = 'fooValue'
     * $query->filterByApSessionid('%fooValue%', Criteria::LIKE); // WHERE ap_sessionid LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apSessionid The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByApSessionid($apSessionid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apSessionid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_AP_SESSIONID, $apSessionid, $comparison);
    }

    /**
     * Filter the query on the web_session column
     *
     * Example usage:
     * <code>
     * $query->filterByWebSession('fooValue');   // WHERE web_session = 'fooValue'
     * $query->filterByWebSession('%fooValue%', Criteria::LIKE); // WHERE web_session LIKE '%fooValue%'
     * </code>
     *
     * @param     string $webSession The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByWebSession($webSession = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($webSession)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_WEB_SESSION, $webSession, $comparison);
    }

    /**
     * Filter the query on the user_url column
     *
     * Example usage:
     * <code>
     * $query->filterByUserUrl('fooValue');   // WHERE user_url = 'fooValue'
     * $query->filterByUserUrl('%fooValue%', Criteria::LIKE); // WHERE user_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userUrl The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByUserUrl($userUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userUrl)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_USER_URL, $userUrl, $comparison);
    }

    /**
     * Filter the query on the is_mobile column
     *
     * Example usage:
     * <code>
     * $query->filterByIsMobile(1234); // WHERE is_mobile = 1234
     * $query->filterByIsMobile(array(12, 34)); // WHERE is_mobile IN (12, 34)
     * $query->filterByIsMobile(array('min' => 12)); // WHERE is_mobile > 12
     * </code>
     *
     * @param     mixed $isMobile The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByIsMobile($isMobile = null, $comparison = null)
    {
        if (is_array($isMobile)) {
            $useMinMax = false;
            if (isset($isMobile['min'])) {
                $this->addUsingAlias(AdsLogTableMap::COL_IS_MOBILE, $isMobile['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isMobile['max'])) {
                $this->addUsingAlias(AdsLogTableMap::COL_IS_MOBILE, $isMobile['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_IS_MOBILE, $isMobile, $comparison);
    }

    /**
     * Filter the query on the os column
     *
     * Example usage:
     * <code>
     * $query->filterByOs('fooValue');   // WHERE os = 'fooValue'
     * $query->filterByOs('%fooValue%', Criteria::LIKE); // WHERE os LIKE '%fooValue%'
     * </code>
     *
     * @param     string $os The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByOs($os = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($os)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_OS, $os, $comparison);
    }

    /**
     * Filter the query on the browser column
     *
     * Example usage:
     * <code>
     * $query->filterByBrowser('fooValue');   // WHERE browser = 'fooValue'
     * $query->filterByBrowser('%fooValue%', Criteria::LIKE); // WHERE browser LIKE '%fooValue%'
     * </code>
     *
     * @param     string $browser The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByBrowser($browser = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($browser)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_BROWSER, $browser, $comparison);
    }

    /**
     * Filter the query on the user_agent column
     *
     * Example usage:
     * <code>
     * $query->filterByUserAgent('fooValue');   // WHERE user_agent = 'fooValue'
     * $query->filterByUserAgent('%fooValue%', Criteria::LIKE); // WHERE user_agent LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userAgent The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByUserAgent($userAgent = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userAgent)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_USER_AGENT, $userAgent, $comparison);
    }

    /**
     * Filter the query on the phase column
     *
     * Example usage:
     * <code>
     * $query->filterByPhase('fooValue');   // WHERE phase = 'fooValue'
     * $query->filterByPhase('%fooValue%', Criteria::LIKE); // WHERE phase LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phase The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByPhase($phase = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phase)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_PHASE, $phase, $comparison);
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
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(AdsLogTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(AdsLogTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(AdsLogTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(AdsLogTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsLogTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAdsLog $adsLog Object to remove from the list of results
     *
     * @return $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function prune($adsLog = null)
    {
        if ($adsLog) {
            $this->addUsingAlias(AdsLogTableMap::COL_ID, $adsLog->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ads_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdsLogTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AdsLogTableMap::clearInstancePool();
            AdsLogTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AdsLogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AdsLogTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AdsLogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AdsLogTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // query_cache behavior

    public function setQueryKey($key)
    {
        $this->queryKey = $key;

        return $this;
    }

    public function getQueryKey()
    {
        return $this->queryKey;
    }

    public function cacheContains($key)
    {
        throw new PropelException('You must override the cacheContains(), cacheStore(), and cacheFetch() methods to enable query cache');
    }

    public function cacheFetch($key)
    {
        throw new PropelException('You must override the cacheContains(), cacheStore(), and cacheFetch() methods to enable query cache');
    }

    public function cacheStore($key, $value, $lifetime = 600)
    {
        throw new PropelException('You must override the cacheContains(), cacheStore(), and cacheFetch() methods to enable query cache');
    }

    public function doSelect(ConnectionInterface $con = null)
    {
        // check that the columns of the main class are already added (if this is the primary ModelCriteria)
        if (!$this->hasSelectClause() && !$this->getPrimaryCriteria()) {
            $this->addSelfSelectColumns();
        }
        $this->configureSelectColumns();

        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AdsLogTableMap::DATABASE_NAME);
        $db = Propel::getServiceContainer()->getAdapter(AdsLogTableMap::DATABASE_NAME);

        $key = $this->getQueryKey();
        if ($key && $this->cacheContains($key)) {
            $params = $this->getParams();
            $sql = $this->cacheFetch($key);
        } else {
            $params = array();
            $sql = $this->createSelectSql($params);
        }

        try {
            $stmt = $con->prepare($sql);
            $db->bindValues($stmt, $params, $dbMap);
            $stmt->execute();
            } catch (Exception $e) {
                Propel::log($e->getMessage(), Propel::LOG_ERR);
                throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
            }

        if ($key && !$this->cacheContains($key)) {
                $this->cacheStore($key, $sql);
        }

        return $con->getDataFetcher($stmt);
    }

    public function doCount(ConnectionInterface $con = null)
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap($this->getDbName());
        $db = Propel::getServiceContainer()->getAdapter($this->getDbName());

        $key = $this->getQueryKey();
        if ($key && $this->cacheContains($key)) {
            $params = $this->getParams();
            $sql = $this->cacheFetch($key);
        } else {
            // check that the columns of the main class are already added (if this is the primary ModelCriteria)
            if (!$this->hasSelectClause() && !$this->getPrimaryCriteria()) {
                $this->addSelfSelectColumns();
            }

            $this->configureSelectColumns();

            $needsComplexCount = $this->getGroupByColumns()
                || $this->getOffset()
                || $this->getLimit() >= 0
                || $this->getHaving()
                || in_array(Criteria::DISTINCT, $this->getSelectModifiers())
                || count($this->selectQueries) > 0
            ;

            $params = array();
            if ($needsComplexCount) {
                if ($this->needsSelectAliases()) {
                    if ($this->getHaving()) {
                        throw new PropelException('Propel cannot create a COUNT query when using HAVING and  duplicate column names in the SELECT part');
                    }
                    $db->turnSelectColumnsToAliases($this);
                }
                $selectSql = $this->createSelectSql($params);
                $sql = 'SELECT COUNT(*) FROM (' . $selectSql . ') propelmatch4cnt';
            } else {
                // Replace SELECT columns with COUNT(*)
                $this->clearSelectColumns()->addSelectColumn('COUNT(*)');
                $sql = $this->createSelectSql($params);
            }
        }

        try {
            $stmt = $con->prepare($sql);
            $db->bindValues($stmt, $params, $dbMap);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute COUNT statement [%s]', $sql), 0, $e);
        }

        if ($key && !$this->cacheContains($key)) {
                $this->cacheStore($key, $sql);
        }


        return $con->getDataFetcher($stmt);
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(AdsLogTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(AdsLogTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(AdsLogTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(AdsLogTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(AdsLogTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildAdsLogQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(AdsLogTableMap::COL_CREATED_AT);
    }

} // AdsLogQuery
