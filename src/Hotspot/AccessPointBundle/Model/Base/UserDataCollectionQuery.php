<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\UserDataCollection as ChildUserDataCollection;
use Hotspot\AccessPointBundle\Model\UserDataCollectionQuery as ChildUserDataCollectionQuery;
use Hotspot\AccessPointBundle\Model\Map\UserDataCollectionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_data_collection' table.
 *
 *
 *
 * @method     ChildUserDataCollectionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUserDataCollectionQuery orderByAdvertId($order = Criteria::ASC) Order by the advert_id column
 * @method     ChildUserDataCollectionQuery orderByData($order = Criteria::ASC) Order by the data column
 * @method     ChildUserDataCollectionQuery orderByDeviceMac($order = Criteria::ASC) Order by the device_mac column
 * @method     ChildUserDataCollectionQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildUserDataCollectionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildUserDataCollectionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildUserDataCollectionQuery groupById() Group by the id column
 * @method     ChildUserDataCollectionQuery groupByAdvertId() Group by the advert_id column
 * @method     ChildUserDataCollectionQuery groupByData() Group by the data column
 * @method     ChildUserDataCollectionQuery groupByDeviceMac() Group by the device_mac column
 * @method     ChildUserDataCollectionQuery groupByStatus() Group by the status column
 * @method     ChildUserDataCollectionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildUserDataCollectionQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildUserDataCollectionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserDataCollectionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserDataCollectionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserDataCollectionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserDataCollectionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserDataCollectionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserDataCollection findOne(ConnectionInterface $con = null) Return the first ChildUserDataCollection matching the query
 * @method     ChildUserDataCollection findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserDataCollection matching the query, or a new ChildUserDataCollection object populated from the query conditions when no match is found
 *
 * @method     ChildUserDataCollection findOneById(int $id) Return the first ChildUserDataCollection filtered by the id column
 * @method     ChildUserDataCollection findOneByAdvertId(int $advert_id) Return the first ChildUserDataCollection filtered by the advert_id column
 * @method     ChildUserDataCollection findOneByData(string $data) Return the first ChildUserDataCollection filtered by the data column
 * @method     ChildUserDataCollection findOneByDeviceMac(string $device_mac) Return the first ChildUserDataCollection filtered by the device_mac column
 * @method     ChildUserDataCollection findOneByStatus(int $status) Return the first ChildUserDataCollection filtered by the status column
 * @method     ChildUserDataCollection findOneByCreatedAt(string $created_at) Return the first ChildUserDataCollection filtered by the created_at column
 * @method     ChildUserDataCollection findOneByUpdatedAt(string $updated_at) Return the first ChildUserDataCollection filtered by the updated_at column *

 * @method     ChildUserDataCollection requirePk($key, ConnectionInterface $con = null) Return the ChildUserDataCollection by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserDataCollection requireOne(ConnectionInterface $con = null) Return the first ChildUserDataCollection matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserDataCollection requireOneById(int $id) Return the first ChildUserDataCollection filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserDataCollection requireOneByAdvertId(int $advert_id) Return the first ChildUserDataCollection filtered by the advert_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserDataCollection requireOneByData(string $data) Return the first ChildUserDataCollection filtered by the data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserDataCollection requireOneByDeviceMac(string $device_mac) Return the first ChildUserDataCollection filtered by the device_mac column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserDataCollection requireOneByStatus(int $status) Return the first ChildUserDataCollection filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserDataCollection requireOneByCreatedAt(string $created_at) Return the first ChildUserDataCollection filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserDataCollection requireOneByUpdatedAt(string $updated_at) Return the first ChildUserDataCollection filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserDataCollection[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserDataCollection objects based on current ModelCriteria
 * @method     ChildUserDataCollection[]|ObjectCollection findById(int $id) Return ChildUserDataCollection objects filtered by the id column
 * @method     ChildUserDataCollection[]|ObjectCollection findByAdvertId(int $advert_id) Return ChildUserDataCollection objects filtered by the advert_id column
 * @method     ChildUserDataCollection[]|ObjectCollection findByData(string $data) Return ChildUserDataCollection objects filtered by the data column
 * @method     ChildUserDataCollection[]|ObjectCollection findByDeviceMac(string $device_mac) Return ChildUserDataCollection objects filtered by the device_mac column
 * @method     ChildUserDataCollection[]|ObjectCollection findByStatus(int $status) Return ChildUserDataCollection objects filtered by the status column
 * @method     ChildUserDataCollection[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildUserDataCollection objects filtered by the created_at column
 * @method     ChildUserDataCollection[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildUserDataCollection objects filtered by the updated_at column
 * @method     ChildUserDataCollection[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserDataCollectionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Hotspot\AccessPointBundle\Model\Base\UserDataCollectionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Hotspot\\AccessPointBundle\\Model\\UserDataCollection', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserDataCollectionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserDataCollectionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserDataCollectionQuery) {
            return $criteria;
        }
        $query = new ChildUserDataCollectionQuery();
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
     * @return ChildUserDataCollection|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserDataCollectionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserDataCollectionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUserDataCollection A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `advert_id`, `data`, `device_mac`, `status`, `created_at`, `updated_at` FROM `user_data_collection` WHERE `id` = :p0';
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
            /** @var ChildUserDataCollection $obj */
            $obj = new ChildUserDataCollection();
            $obj->hydrate($row);
            UserDataCollectionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUserDataCollection|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserDataCollectionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserDataCollectionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UserDataCollectionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UserDataCollectionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserDataCollectionTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function filterByAdvertId($advertId = null, $comparison = null)
    {
        if (is_array($advertId)) {
            $useMinMax = false;
            if (isset($advertId['min'])) {
                $this->addUsingAlias(UserDataCollectionTableMap::COL_ADVERT_ID, $advertId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($advertId['max'])) {
                $this->addUsingAlias(UserDataCollectionTableMap::COL_ADVERT_ID, $advertId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserDataCollectionTableMap::COL_ADVERT_ID, $advertId, $comparison);
    }

    /**
     * Filter the query on the data column
     *
     * Example usage:
     * <code>
     * $query->filterByData('fooValue');   // WHERE data = 'fooValue'
     * $query->filterByData('%fooValue%', Criteria::LIKE); // WHERE data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $data The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function filterByData($data = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($data)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserDataCollectionTableMap::COL_DATA, $data, $comparison);
    }

    /**
     * Filter the query on the device_mac column
     *
     * Example usage:
     * <code>
     * $query->filterByDeviceMac('fooValue');   // WHERE device_mac = 'fooValue'
     * $query->filterByDeviceMac('%fooValue%', Criteria::LIKE); // WHERE device_mac LIKE '%fooValue%'
     * </code>
     *
     * @param     string $deviceMac The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function filterByDeviceMac($deviceMac = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($deviceMac)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserDataCollectionTableMap::COL_DEVICE_MAC, $deviceMac, $comparison);
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
     * @return $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(UserDataCollectionTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(UserDataCollectionTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserDataCollectionTableMap::COL_STATUS, $status, $comparison);
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
     * @return $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UserDataCollectionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UserDataCollectionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserDataCollectionTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(UserDataCollectionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(UserDataCollectionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserDataCollectionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserDataCollection $userDataCollection Object to remove from the list of results
     *
     * @return $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function prune($userDataCollection = null)
    {
        if ($userDataCollection) {
            $this->addUsingAlias(UserDataCollectionTableMap::COL_ID, $userDataCollection->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_data_collection table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserDataCollectionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserDataCollectionTableMap::clearInstancePool();
            UserDataCollectionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserDataCollectionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserDataCollectionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserDataCollectionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UserDataCollectionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(UserDataCollectionTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserDataCollectionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserDataCollectionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserDataCollectionTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(UserDataCollectionTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildUserDataCollectionQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserDataCollectionTableMap::COL_CREATED_AT);
    }

} // UserDataCollectionQuery
