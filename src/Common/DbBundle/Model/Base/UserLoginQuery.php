<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\UserLogin as ChildUserLogin;
use Common\DbBundle\Model\UserLoginQuery as ChildUserLoginQuery;
use Common\DbBundle\Model\Map\UserLoginTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_login' table.
 *
 *
 *
 * @method     ChildUserLoginQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUserLoginQuery orderByUid($order = Criteria::ASC) Order by the uid column
 * @method     ChildUserLoginQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildUserLoginQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUserLoginQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildUserLoginQuery orderByFullname($order = Criteria::ASC) Order by the fullname column
 * @method     ChildUserLoginQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildUserLoginQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildUserLoginQuery orderByLocation($order = Criteria::ASC) Order by the location column
 * @method     ChildUserLoginQuery orderByApMacaddr($order = Criteria::ASC) Order by the ap_macaddr column
 * @method     ChildUserLoginQuery orderByAdvertId($order = Criteria::ASC) Order by the advert_id column
 * @method     ChildUserLoginQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildUserLoginQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildUserLoginQuery groupById() Group by the id column
 * @method     ChildUserLoginQuery groupByUid() Group by the uid column
 * @method     ChildUserLoginQuery groupByUsername() Group by the username column
 * @method     ChildUserLoginQuery groupByEmail() Group by the email column
 * @method     ChildUserLoginQuery groupByType() Group by the type column
 * @method     ChildUserLoginQuery groupByFullname() Group by the fullname column
 * @method     ChildUserLoginQuery groupByAddress() Group by the address column
 * @method     ChildUserLoginQuery groupByPhone() Group by the phone column
 * @method     ChildUserLoginQuery groupByLocation() Group by the location column
 * @method     ChildUserLoginQuery groupByApMacaddr() Group by the ap_macaddr column
 * @method     ChildUserLoginQuery groupByAdvertId() Group by the advert_id column
 * @method     ChildUserLoginQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildUserLoginQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildUserLoginQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserLoginQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserLoginQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserLoginQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserLoginQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserLoginQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserLogin findOne(ConnectionInterface $con = null) Return the first ChildUserLogin matching the query
 * @method     ChildUserLogin findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserLogin matching the query, or a new ChildUserLogin object populated from the query conditions when no match is found
 *
 * @method     ChildUserLogin findOneById(int $id) Return the first ChildUserLogin filtered by the id column
 * @method     ChildUserLogin findOneByUid(string $uid) Return the first ChildUserLogin filtered by the uid column
 * @method     ChildUserLogin findOneByUsername(string $username) Return the first ChildUserLogin filtered by the username column
 * @method     ChildUserLogin findOneByEmail(string $email) Return the first ChildUserLogin filtered by the email column
 * @method     ChildUserLogin findOneByType(string $type) Return the first ChildUserLogin filtered by the type column
 * @method     ChildUserLogin findOneByFullname(string $fullname) Return the first ChildUserLogin filtered by the fullname column
 * @method     ChildUserLogin findOneByAddress(string $address) Return the first ChildUserLogin filtered by the address column
 * @method     ChildUserLogin findOneByPhone(string $phone) Return the first ChildUserLogin filtered by the phone column
 * @method     ChildUserLogin findOneByLocation(string $location) Return the first ChildUserLogin filtered by the location column
 * @method     ChildUserLogin findOneByApMacaddr(string $ap_macaddr) Return the first ChildUserLogin filtered by the ap_macaddr column
 * @method     ChildUserLogin findOneByAdvertId(int $advert_id) Return the first ChildUserLogin filtered by the advert_id column
 * @method     ChildUserLogin findOneByCreatedAt(string $created_at) Return the first ChildUserLogin filtered by the created_at column
 * @method     ChildUserLogin findOneByUpdatedAt(string $updated_at) Return the first ChildUserLogin filtered by the updated_at column *

 * @method     ChildUserLogin requirePk($key, ConnectionInterface $con = null) Return the ChildUserLogin by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOne(ConnectionInterface $con = null) Return the first ChildUserLogin matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserLogin requireOneById(int $id) Return the first ChildUserLogin filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByUid(string $uid) Return the first ChildUserLogin filtered by the uid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByUsername(string $username) Return the first ChildUserLogin filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByEmail(string $email) Return the first ChildUserLogin filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByType(string $type) Return the first ChildUserLogin filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByFullname(string $fullname) Return the first ChildUserLogin filtered by the fullname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByAddress(string $address) Return the first ChildUserLogin filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByPhone(string $phone) Return the first ChildUserLogin filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByLocation(string $location) Return the first ChildUserLogin filtered by the location column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByApMacaddr(string $ap_macaddr) Return the first ChildUserLogin filtered by the ap_macaddr column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByAdvertId(int $advert_id) Return the first ChildUserLogin filtered by the advert_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByCreatedAt(string $created_at) Return the first ChildUserLogin filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserLogin requireOneByUpdatedAt(string $updated_at) Return the first ChildUserLogin filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserLogin[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserLogin objects based on current ModelCriteria
 * @method     ChildUserLogin[]|ObjectCollection findById(int $id) Return ChildUserLogin objects filtered by the id column
 * @method     ChildUserLogin[]|ObjectCollection findByUid(string $uid) Return ChildUserLogin objects filtered by the uid column
 * @method     ChildUserLogin[]|ObjectCollection findByUsername(string $username) Return ChildUserLogin objects filtered by the username column
 * @method     ChildUserLogin[]|ObjectCollection findByEmail(string $email) Return ChildUserLogin objects filtered by the email column
 * @method     ChildUserLogin[]|ObjectCollection findByType(string $type) Return ChildUserLogin objects filtered by the type column
 * @method     ChildUserLogin[]|ObjectCollection findByFullname(string $fullname) Return ChildUserLogin objects filtered by the fullname column
 * @method     ChildUserLogin[]|ObjectCollection findByAddress(string $address) Return ChildUserLogin objects filtered by the address column
 * @method     ChildUserLogin[]|ObjectCollection findByPhone(string $phone) Return ChildUserLogin objects filtered by the phone column
 * @method     ChildUserLogin[]|ObjectCollection findByLocation(string $location) Return ChildUserLogin objects filtered by the location column
 * @method     ChildUserLogin[]|ObjectCollection findByApMacaddr(string $ap_macaddr) Return ChildUserLogin objects filtered by the ap_macaddr column
 * @method     ChildUserLogin[]|ObjectCollection findByAdvertId(int $advert_id) Return ChildUserLogin objects filtered by the advert_id column
 * @method     ChildUserLogin[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildUserLogin objects filtered by the created_at column
 * @method     ChildUserLogin[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildUserLogin objects filtered by the updated_at column
 * @method     ChildUserLogin[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserLoginQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\UserLoginQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\UserLogin', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserLoginQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserLoginQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserLoginQuery) {
            return $criteria;
        }
        $query = new ChildUserLoginQuery();
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
     * @return ChildUserLogin|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserLoginTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserLoginTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUserLogin A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `uid`, `username`, `email`, `type`, `fullname`, `address`, `phone`, `location`, `ap_macaddr`, `advert_id`, `created_at`, `updated_at` FROM `user_login` WHERE `id` = :p0';
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
            /** @var ChildUserLogin $obj */
            $obj = new ChildUserLogin();
            $obj->hydrate($row);
            UserLoginTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUserLogin|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserLoginTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserLoginTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the uid column
     *
     * Example usage:
     * <code>
     * $query->filterByUid('fooValue');   // WHERE uid = 'fooValue'
     * $query->filterByUid('%fooValue%', Criteria::LIKE); // WHERE uid LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uid The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByUid($uid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_UID, $uid, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%', Criteria::LIKE); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the fullname column
     *
     * Example usage:
     * <code>
     * $query->filterByFullname('fooValue');   // WHERE fullname = 'fooValue'
     * $query->filterByFullname('%fooValue%', Criteria::LIKE); // WHERE fullname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fullname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByFullname($fullname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fullname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_FULLNAME, $fullname, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%', Criteria::LIKE); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%', Criteria::LIKE); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_PHONE, $phone, $comparison);
    }

    /**
     * Filter the query on the location column
     *
     * Example usage:
     * <code>
     * $query->filterByLocation('fooValue');   // WHERE location = 'fooValue'
     * $query->filterByLocation('%fooValue%', Criteria::LIKE); // WHERE location LIKE '%fooValue%'
     * </code>
     *
     * @param     string $location The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByLocation($location = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($location)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_LOCATION, $location, $comparison);
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByApMacaddr($apMacaddr = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apMacaddr)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_AP_MACADDR, $apMacaddr, $comparison);
    }

    /**
     * Filter the query on the advert_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAdvertId(1234); // WHERE advert_id = 1234
     * $query->filterByAdvertId(array(12, 34)); // WHERE advert_id IN (12, 34)
     * $query->filterByAdvertId(array('min' => 12)); // WHERE advert_id > 12
     * </code>
     *
     * @param     mixed $advertId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByAdvertId($advertId = null, $comparison = null)
    {
        if (is_array($advertId)) {
            $useMinMax = false;
            if (isset($advertId['min'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_ADVERT_ID, $advertId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($advertId['max'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_ADVERT_ID, $advertId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_ADVERT_ID, $advertId, $comparison);
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(UserLoginTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserLoginTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserLogin $userLogin Object to remove from the list of results
     *
     * @return $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function prune($userLogin = null)
    {
        if ($userLogin) {
            $this->addUsingAlias(UserLoginTableMap::COL_ID, $userLogin->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_login table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserLoginTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserLoginTableMap::clearInstancePool();
            UserLoginTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserLoginTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserLoginTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserLoginTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UserLoginTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(UserLoginTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserLoginTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserLoginTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserLoginTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(UserLoginTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildUserLoginQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserLoginTableMap::COL_CREATED_AT);
    }

} // UserLoginQuery
