<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\Promotion as ChildPromotion;
use Common\DbBundle\Model\PromotionQuery as ChildPromotionQuery;
use Common\DbBundle\Model\Map\PromotionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'promotion' table.
 *
 *
 *
 * @method     ChildPromotionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPromotionQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method     ChildPromotionQuery orderByCustomer($order = Criteria::ASC) Order by the customer column
 * @method     ChildPromotionQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method     ChildPromotionQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildPromotionQuery orderByFullname($order = Criteria::ASC) Order by the fullname column
 * @method     ChildPromotionQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildPromotionQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildPromotionQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildPromotionQuery orderByUsedAt($order = Criteria::ASC) Order by the used_at column
 * @method     ChildPromotionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPromotionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildPromotionQuery groupById() Group by the id column
 * @method     ChildPromotionQuery groupByCode() Group by the code column
 * @method     ChildPromotionQuery groupByCustomer() Group by the customer column
 * @method     ChildPromotionQuery groupByUrl() Group by the url column
 * @method     ChildPromotionQuery groupByPhone() Group by the phone column
 * @method     ChildPromotionQuery groupByFullname() Group by the fullname column
 * @method     ChildPromotionQuery groupByAddress() Group by the address column
 * @method     ChildPromotionQuery groupByType() Group by the type column
 * @method     ChildPromotionQuery groupByStatus() Group by the status column
 * @method     ChildPromotionQuery groupByUsedAt() Group by the used_at column
 * @method     ChildPromotionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPromotionQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildPromotionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPromotionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPromotionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPromotionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPromotionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPromotionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPromotion findOne(ConnectionInterface $con = null) Return the first ChildPromotion matching the query
 * @method     ChildPromotion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPromotion matching the query, or a new ChildPromotion object populated from the query conditions when no match is found
 *
 * @method     ChildPromotion findOneById(int $id) Return the first ChildPromotion filtered by the id column
 * @method     ChildPromotion findOneByCode(string $code) Return the first ChildPromotion filtered by the code column
 * @method     ChildPromotion findOneByCustomer(string $customer) Return the first ChildPromotion filtered by the customer column
 * @method     ChildPromotion findOneByUrl(string $url) Return the first ChildPromotion filtered by the url column
 * @method     ChildPromotion findOneByPhone(string $phone) Return the first ChildPromotion filtered by the phone column
 * @method     ChildPromotion findOneByFullname(string $fullname) Return the first ChildPromotion filtered by the fullname column
 * @method     ChildPromotion findOneByAddress(string $address) Return the first ChildPromotion filtered by the address column
 * @method     ChildPromotion findOneByType(string $type) Return the first ChildPromotion filtered by the type column
 * @method     ChildPromotion findOneByStatus(int $status) Return the first ChildPromotion filtered by the status column
 * @method     ChildPromotion findOneByUsedAt(string $used_at) Return the first ChildPromotion filtered by the used_at column
 * @method     ChildPromotion findOneByCreatedAt(string $created_at) Return the first ChildPromotion filtered by the created_at column
 * @method     ChildPromotion findOneByUpdatedAt(string $updated_at) Return the first ChildPromotion filtered by the updated_at column *

 * @method     ChildPromotion requirePk($key, ConnectionInterface $con = null) Return the ChildPromotion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOne(ConnectionInterface $con = null) Return the first ChildPromotion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPromotion requireOneById(int $id) Return the first ChildPromotion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOneByCode(string $code) Return the first ChildPromotion filtered by the code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOneByCustomer(string $customer) Return the first ChildPromotion filtered by the customer column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOneByUrl(string $url) Return the first ChildPromotion filtered by the url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOneByPhone(string $phone) Return the first ChildPromotion filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOneByFullname(string $fullname) Return the first ChildPromotion filtered by the fullname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOneByAddress(string $address) Return the first ChildPromotion filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOneByType(string $type) Return the first ChildPromotion filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOneByStatus(int $status) Return the first ChildPromotion filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOneByUsedAt(string $used_at) Return the first ChildPromotion filtered by the used_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOneByCreatedAt(string $created_at) Return the first ChildPromotion filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPromotion requireOneByUpdatedAt(string $updated_at) Return the first ChildPromotion filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPromotion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPromotion objects based on current ModelCriteria
 * @method     ChildPromotion[]|ObjectCollection findById(int $id) Return ChildPromotion objects filtered by the id column
 * @method     ChildPromotion[]|ObjectCollection findByCode(string $code) Return ChildPromotion objects filtered by the code column
 * @method     ChildPromotion[]|ObjectCollection findByCustomer(string $customer) Return ChildPromotion objects filtered by the customer column
 * @method     ChildPromotion[]|ObjectCollection findByUrl(string $url) Return ChildPromotion objects filtered by the url column
 * @method     ChildPromotion[]|ObjectCollection findByPhone(string $phone) Return ChildPromotion objects filtered by the phone column
 * @method     ChildPromotion[]|ObjectCollection findByFullname(string $fullname) Return ChildPromotion objects filtered by the fullname column
 * @method     ChildPromotion[]|ObjectCollection findByAddress(string $address) Return ChildPromotion objects filtered by the address column
 * @method     ChildPromotion[]|ObjectCollection findByType(string $type) Return ChildPromotion objects filtered by the type column
 * @method     ChildPromotion[]|ObjectCollection findByStatus(int $status) Return ChildPromotion objects filtered by the status column
 * @method     ChildPromotion[]|ObjectCollection findByUsedAt(string $used_at) Return ChildPromotion objects filtered by the used_at column
 * @method     ChildPromotion[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPromotion objects filtered by the created_at column
 * @method     ChildPromotion[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildPromotion objects filtered by the updated_at column
 * @method     ChildPromotion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PromotionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\PromotionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\Promotion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPromotionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPromotionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPromotionQuery) {
            return $criteria;
        }
        $query = new ChildPromotionQuery();
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
     * @return ChildPromotion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PromotionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PromotionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPromotion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `code`, `customer`, `url`, `phone`, `fullname`, `address`, `type`, `status`, `used_at`, `created_at`, `updated_at` FROM `promotion` WHERE `id` = :p0';
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
            /** @var ChildPromotion $obj */
            $obj = new ChildPromotion();
            $obj->hydrate($row);
            PromotionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPromotion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PromotionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PromotionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PromotionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PromotionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%', Criteria::LIKE); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_CODE, $code, $comparison);
    }

    /**
     * Filter the query on the customer column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomer('fooValue');   // WHERE customer = 'fooValue'
     * $query->filterByCustomer('%fooValue%', Criteria::LIKE); // WHERE customer LIKE '%fooValue%'
     * </code>
     *
     * @param     string $customer The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByCustomer($customer = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($customer)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_CUSTOMER, $customer, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%', Criteria::LIKE); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_URL, $url, $comparison);
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
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_PHONE, $phone, $comparison);
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
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByFullname($fullname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fullname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_FULLNAME, $fullname, $comparison);
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
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_ADDRESS, $address, $comparison);
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
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(1234); // WHERE status = 1234
     * $query->filterByStatus(array(12, 34)); // WHERE status IN (12, 34)
     * $query->filterByStatus(array('min' => 12)); // WHERE status > 12
     * </code>
     *
     * @param     mixed $status The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(PromotionTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(PromotionTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the used_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUsedAt('2011-03-14'); // WHERE used_at = '2011-03-14'
     * $query->filterByUsedAt('now'); // WHERE used_at = '2011-03-14'
     * $query->filterByUsedAt(array('max' => 'yesterday')); // WHERE used_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $usedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByUsedAt($usedAt = null, $comparison = null)
    {
        if (is_array($usedAt)) {
            $useMinMax = false;
            if (isset($usedAt['min'])) {
                $this->addUsingAlias(PromotionTableMap::COL_USED_AT, $usedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($usedAt['max'])) {
                $this->addUsingAlias(PromotionTableMap::COL_USED_AT, $usedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_USED_AT, $usedAt, $comparison);
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
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PromotionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PromotionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PromotionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PromotionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromotionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPromotion $promotion Object to remove from the list of results
     *
     * @return $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function prune($promotion = null)
    {
        if ($promotion) {
            $this->addUsingAlias(PromotionTableMap::COL_ID, $promotion->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the promotion table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PromotionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PromotionTableMap::clearInstancePool();
            PromotionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PromotionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PromotionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PromotionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PromotionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(PromotionTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(PromotionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(PromotionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PromotionTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PromotionTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildPromotionQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PromotionTableMap::COL_CREATED_AT);
    }

} // PromotionQuery
