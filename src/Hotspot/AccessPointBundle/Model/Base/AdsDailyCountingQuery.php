<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\AdsDailyCounting as ChildAdsDailyCounting;
use Hotspot\AccessPointBundle\Model\AdsDailyCountingQuery as ChildAdsDailyCountingQuery;
use Hotspot\AccessPointBundle\Model\Map\AdsDailyCountingTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ads_daily_counting' table.
 *
 *
 *
 * @method     ChildAdsDailyCountingQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAdsDailyCountingQuery orderByAdvertId($order = Criteria::ASC) Order by the advert_id column
 * @method     ChildAdsDailyCountingQuery orderByApMacaddr($order = Criteria::ASC) Order by the ap_macaddr column
 * @method     ChildAdsDailyCountingQuery orderByViewCount($order = Criteria::ASC) Order by the view_count column
 * @method     ChildAdsDailyCountingQuery orderByClickCount($order = Criteria::ASC) Order by the click_count column
 * @method     ChildAdsDailyCountingQuery orderByDate($order = Criteria::ASC) Order by the date column
 *
 * @method     ChildAdsDailyCountingQuery groupById() Group by the id column
 * @method     ChildAdsDailyCountingQuery groupByAdvertId() Group by the advert_id column
 * @method     ChildAdsDailyCountingQuery groupByApMacaddr() Group by the ap_macaddr column
 * @method     ChildAdsDailyCountingQuery groupByViewCount() Group by the view_count column
 * @method     ChildAdsDailyCountingQuery groupByClickCount() Group by the click_count column
 * @method     ChildAdsDailyCountingQuery groupByDate() Group by the date column
 *
 * @method     ChildAdsDailyCountingQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAdsDailyCountingQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAdsDailyCountingQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAdsDailyCountingQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAdsDailyCountingQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAdsDailyCountingQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAdsDailyCounting findOne(ConnectionInterface $con = null) Return the first ChildAdsDailyCounting matching the query
 * @method     ChildAdsDailyCounting findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAdsDailyCounting matching the query, or a new ChildAdsDailyCounting object populated from the query conditions when no match is found
 *
 * @method     ChildAdsDailyCounting findOneById(int $id) Return the first ChildAdsDailyCounting filtered by the id column
 * @method     ChildAdsDailyCounting findOneByAdvertId(int $advert_id) Return the first ChildAdsDailyCounting filtered by the advert_id column
 * @method     ChildAdsDailyCounting findOneByApMacaddr(string $ap_macaddr) Return the first ChildAdsDailyCounting filtered by the ap_macaddr column
 * @method     ChildAdsDailyCounting findOneByViewCount(int $view_count) Return the first ChildAdsDailyCounting filtered by the view_count column
 * @method     ChildAdsDailyCounting findOneByClickCount(int $click_count) Return the first ChildAdsDailyCounting filtered by the click_count column
 * @method     ChildAdsDailyCounting findOneByDate(string $date) Return the first ChildAdsDailyCounting filtered by the date column *

 * @method     ChildAdsDailyCounting requirePk($key, ConnectionInterface $con = null) Return the ChildAdsDailyCounting by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsDailyCounting requireOne(ConnectionInterface $con = null) Return the first ChildAdsDailyCounting matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdsDailyCounting requireOneById(int $id) Return the first ChildAdsDailyCounting filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsDailyCounting requireOneByAdvertId(int $advert_id) Return the first ChildAdsDailyCounting filtered by the advert_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsDailyCounting requireOneByApMacaddr(string $ap_macaddr) Return the first ChildAdsDailyCounting filtered by the ap_macaddr column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsDailyCounting requireOneByViewCount(int $view_count) Return the first ChildAdsDailyCounting filtered by the view_count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsDailyCounting requireOneByClickCount(int $click_count) Return the first ChildAdsDailyCounting filtered by the click_count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdsDailyCounting requireOneByDate(string $date) Return the first ChildAdsDailyCounting filtered by the date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdsDailyCounting[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAdsDailyCounting objects based on current ModelCriteria
 * @method     ChildAdsDailyCounting[]|ObjectCollection findById(int $id) Return ChildAdsDailyCounting objects filtered by the id column
 * @method     ChildAdsDailyCounting[]|ObjectCollection findByAdvertId(int $advert_id) Return ChildAdsDailyCounting objects filtered by the advert_id column
 * @method     ChildAdsDailyCounting[]|ObjectCollection findByApMacaddr(string $ap_macaddr) Return ChildAdsDailyCounting objects filtered by the ap_macaddr column
 * @method     ChildAdsDailyCounting[]|ObjectCollection findByViewCount(int $view_count) Return ChildAdsDailyCounting objects filtered by the view_count column
 * @method     ChildAdsDailyCounting[]|ObjectCollection findByClickCount(int $click_count) Return ChildAdsDailyCounting objects filtered by the click_count column
 * @method     ChildAdsDailyCounting[]|ObjectCollection findByDate(string $date) Return ChildAdsDailyCounting objects filtered by the date column
 * @method     ChildAdsDailyCounting[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AdsDailyCountingQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Hotspot\AccessPointBundle\Model\Base\AdsDailyCountingQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Hotspot\\AccessPointBundle\\Model\\AdsDailyCounting', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAdsDailyCountingQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAdsDailyCountingQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAdsDailyCountingQuery) {
            return $criteria;
        }
        $query = new ChildAdsDailyCountingQuery();
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
     * @return ChildAdsDailyCounting|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AdsDailyCountingTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AdsDailyCountingTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAdsDailyCounting A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `advert_id`, `ap_macaddr`, `view_count`, `click_count`, `date` FROM `ads_daily_counting` WHERE `id` = :p0';
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
            /** @var ChildAdsDailyCounting $obj */
            $obj = new ChildAdsDailyCounting();
            $obj->hydrate($row);
            AdsDailyCountingTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAdsDailyCounting|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAdsDailyCountingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdsDailyCountingTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAdsDailyCountingQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdsDailyCountingTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAdsDailyCountingQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdsDailyCountingTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdsDailyCountingTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsDailyCountingTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildAdsDailyCountingQuery The current query, for fluid interface
     */
    public function filterByAdvertId($advertId = null, $comparison = null)
    {
        if (is_array($advertId)) {
            $useMinMax = false;
            if (isset($advertId['min'])) {
                $this->addUsingAlias(AdsDailyCountingTableMap::COL_ADVERT_ID, $advertId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($advertId['max'])) {
                $this->addUsingAlias(AdsDailyCountingTableMap::COL_ADVERT_ID, $advertId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsDailyCountingTableMap::COL_ADVERT_ID, $advertId, $comparison);
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
     * @return $this|ChildAdsDailyCountingQuery The current query, for fluid interface
     */
    public function filterByApMacaddr($apMacaddr = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apMacaddr)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsDailyCountingTableMap::COL_AP_MACADDR, $apMacaddr, $comparison);
    }

    /**
     * Filter the query on the view_count column
     *
     * Example usage:
     * <code>
     * $query->filterByViewCount(1234); // WHERE view_count = 1234
     * $query->filterByViewCount(array(12, 34)); // WHERE view_count IN (12, 34)
     * $query->filterByViewCount(array('min' => 12)); // WHERE view_count > 12
     * </code>
     *
     * @param     mixed $viewCount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsDailyCountingQuery The current query, for fluid interface
     */
    public function filterByViewCount($viewCount = null, $comparison = null)
    {
        if (is_array($viewCount)) {
            $useMinMax = false;
            if (isset($viewCount['min'])) {
                $this->addUsingAlias(AdsDailyCountingTableMap::COL_VIEW_COUNT, $viewCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($viewCount['max'])) {
                $this->addUsingAlias(AdsDailyCountingTableMap::COL_VIEW_COUNT, $viewCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsDailyCountingTableMap::COL_VIEW_COUNT, $viewCount, $comparison);
    }

    /**
     * Filter the query on the click_count column
     *
     * Example usage:
     * <code>
     * $query->filterByClickCount(1234); // WHERE click_count = 1234
     * $query->filterByClickCount(array(12, 34)); // WHERE click_count IN (12, 34)
     * $query->filterByClickCount(array('min' => 12)); // WHERE click_count > 12
     * </code>
     *
     * @param     mixed $clickCount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsDailyCountingQuery The current query, for fluid interface
     */
    public function filterByClickCount($clickCount = null, $comparison = null)
    {
        if (is_array($clickCount)) {
            $useMinMax = false;
            if (isset($clickCount['min'])) {
                $this->addUsingAlias(AdsDailyCountingTableMap::COL_CLICK_COUNT, $clickCount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clickCount['max'])) {
                $this->addUsingAlias(AdsDailyCountingTableMap::COL_CLICK_COUNT, $clickCount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsDailyCountingTableMap::COL_CLICK_COUNT, $clickCount, $comparison);
    }

    /**
     * Filter the query on the date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('fooValue');   // WHERE date = 'fooValue'
     * $query->filterByDate('%fooValue%', Criteria::LIKE); // WHERE date LIKE '%fooValue%'
     * </code>
     *
     * @param     string $date The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdsDailyCountingQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($date)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdsDailyCountingTableMap::COL_DATE, $date, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAdsDailyCounting $adsDailyCounting Object to remove from the list of results
     *
     * @return $this|ChildAdsDailyCountingQuery The current query, for fluid interface
     */
    public function prune($adsDailyCounting = null)
    {
        if ($adsDailyCounting) {
            $this->addUsingAlias(AdsDailyCountingTableMap::COL_ID, $adsDailyCounting->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ads_daily_counting table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdsDailyCountingTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AdsDailyCountingTableMap::clearInstancePool();
            AdsDailyCountingTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AdsDailyCountingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AdsDailyCountingTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AdsDailyCountingTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AdsDailyCountingTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AdsDailyCountingQuery
