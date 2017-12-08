<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\Logs as ChildLogs;
use Common\DbBundle\Model\LogsQuery as ChildLogsQuery;
use Common\DbBundle\Model\Map\LogsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'logs' table.
 *
 *
 *
 * @method     ChildLogsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildLogsQuery orderByEditBy($order = Criteria::ASC) Order by the edit_by column
 * @method     ChildLogsQuery orderByTable($order = Criteria::ASC) Order by the table column
 * @method     ChildLogsQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildLogsQuery orderByOld($order = Criteria::ASC) Order by the old column
 * @method     ChildLogsQuery orderByCurrent($order = Criteria::ASC) Order by the current column
 * @method     ChildLogsQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildLogsQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildLogsQuery groupById() Group by the id column
 * @method     ChildLogsQuery groupByEditBy() Group by the edit_by column
 * @method     ChildLogsQuery groupByTable() Group by the table column
 * @method     ChildLogsQuery groupByItemId() Group by the item_id column
 * @method     ChildLogsQuery groupByOld() Group by the old column
 * @method     ChildLogsQuery groupByCurrent() Group by the current column
 * @method     ChildLogsQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildLogsQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildLogsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLogsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLogsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLogsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildLogsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildLogsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildLogs findOne(ConnectionInterface $con = null) Return the first ChildLogs matching the query
 * @method     ChildLogs findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLogs matching the query, or a new ChildLogs object populated from the query conditions when no match is found
 *
 * @method     ChildLogs findOneById(int $id) Return the first ChildLogs filtered by the id column
 * @method     ChildLogs findOneByEditBy(string $edit_by) Return the first ChildLogs filtered by the edit_by column
 * @method     ChildLogs findOneByTable(string $table) Return the first ChildLogs filtered by the table column
 * @method     ChildLogs findOneByItemId(int $item_id) Return the first ChildLogs filtered by the item_id column
 * @method     ChildLogs findOneByOld(string $old) Return the first ChildLogs filtered by the old column
 * @method     ChildLogs findOneByCurrent(string $current) Return the first ChildLogs filtered by the current column
 * @method     ChildLogs findOneByCreatedAt(string $created_at) Return the first ChildLogs filtered by the created_at column
 * @method     ChildLogs findOneByUpdatedAt(string $updated_at) Return the first ChildLogs filtered by the updated_at column *

 * @method     ChildLogs requirePk($key, ConnectionInterface $con = null) Return the ChildLogs by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLogs requireOne(ConnectionInterface $con = null) Return the first ChildLogs matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLogs requireOneById(int $id) Return the first ChildLogs filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLogs requireOneByEditBy(string $edit_by) Return the first ChildLogs filtered by the edit_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLogs requireOneByTable(string $table) Return the first ChildLogs filtered by the table column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLogs requireOneByItemId(int $item_id) Return the first ChildLogs filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLogs requireOneByOld(string $old) Return the first ChildLogs filtered by the old column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLogs requireOneByCurrent(string $current) Return the first ChildLogs filtered by the current column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLogs requireOneByCreatedAt(string $created_at) Return the first ChildLogs filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLogs requireOneByUpdatedAt(string $updated_at) Return the first ChildLogs filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLogs[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildLogs objects based on current ModelCriteria
 * @method     ChildLogs[]|ObjectCollection findById(int $id) Return ChildLogs objects filtered by the id column
 * @method     ChildLogs[]|ObjectCollection findByEditBy(string $edit_by) Return ChildLogs objects filtered by the edit_by column
 * @method     ChildLogs[]|ObjectCollection findByTable(string $table) Return ChildLogs objects filtered by the table column
 * @method     ChildLogs[]|ObjectCollection findByItemId(int $item_id) Return ChildLogs objects filtered by the item_id column
 * @method     ChildLogs[]|ObjectCollection findByOld(string $old) Return ChildLogs objects filtered by the old column
 * @method     ChildLogs[]|ObjectCollection findByCurrent(string $current) Return ChildLogs objects filtered by the current column
 * @method     ChildLogs[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildLogs objects filtered by the created_at column
 * @method     ChildLogs[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildLogs objects filtered by the updated_at column
 * @method     ChildLogs[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class LogsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\LogsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\Logs', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLogsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLogsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildLogsQuery) {
            return $criteria;
        }
        $query = new ChildLogsQuery();
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
     * @return ChildLogs|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LogsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = LogsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildLogs A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `edit_by`, `table`, `item_id`, `old`, `current`, `created_at`, `updated_at` FROM `logs` WHERE `id` = :p0';
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
            /** @var ChildLogs $obj */
            $obj = new ChildLogs();
            $obj->hydrate($row);
            LogsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildLogs|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildLogsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LogsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildLogsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LogsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildLogsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LogsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LogsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the edit_by column
     *
     * Example usage:
     * <code>
     * $query->filterByEditBy('fooValue');   // WHERE edit_by = 'fooValue'
     * $query->filterByEditBy('%fooValue%', Criteria::LIKE); // WHERE edit_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $editBy The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogsQuery The current query, for fluid interface
     */
    public function filterByEditBy($editBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($editBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogsTableMap::COL_EDIT_BY, $editBy, $comparison);
    }

    /**
     * Filter the query on the table column
     *
     * Example usage:
     * <code>
     * $query->filterByTable('fooValue');   // WHERE table = 'fooValue'
     * $query->filterByTable('%fooValue%', Criteria::LIKE); // WHERE table LIKE '%fooValue%'
     * </code>
     *
     * @param     string $table The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogsQuery The current query, for fluid interface
     */
    public function filterByTable($table = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($table)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogsTableMap::COL_TABLE, $table, $comparison);
    }

    /**
     * Filter the query on the item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByItemId(1234); // WHERE item_id = 1234
     * $query->filterByItemId(array(12, 34)); // WHERE item_id IN (12, 34)
     * $query->filterByItemId(array('min' => 12)); // WHERE item_id > 12
     * </code>
     *
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogsQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(LogsTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(LogsTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogsTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the old column
     *
     * Example usage:
     * <code>
     * $query->filterByOld('fooValue');   // WHERE old = 'fooValue'
     * $query->filterByOld('%fooValue%', Criteria::LIKE); // WHERE old LIKE '%fooValue%'
     * </code>
     *
     * @param     string $old The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogsQuery The current query, for fluid interface
     */
    public function filterByOld($old = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($old)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogsTableMap::COL_OLD, $old, $comparison);
    }

    /**
     * Filter the query on the current column
     *
     * Example usage:
     * <code>
     * $query->filterByCurrent('fooValue');   // WHERE current = 'fooValue'
     * $query->filterByCurrent('%fooValue%', Criteria::LIKE); // WHERE current LIKE '%fooValue%'
     * </code>
     *
     * @param     string $current The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogsQuery The current query, for fluid interface
     */
    public function filterByCurrent($current = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($current)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogsTableMap::COL_CURRENT, $current, $comparison);
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
     * @return $this|ChildLogsQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(LogsTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(LogsTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogsTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildLogsQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(LogsTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(LogsTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogsTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildLogs $logs Object to remove from the list of results
     *
     * @return $this|ChildLogsQuery The current query, for fluid interface
     */
    public function prune($logs = null)
    {
        if ($logs) {
            $this->addUsingAlias(LogsTableMap::COL_ID, $logs->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the logs table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LogsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LogsTableMap::clearInstancePool();
            LogsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(LogsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LogsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            LogsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            LogsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildLogsQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(LogsTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildLogsQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(LogsTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildLogsQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(LogsTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildLogsQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(LogsTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildLogsQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(LogsTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildLogsQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(LogsTableMap::COL_CREATED_AT);
    }

} // LogsQuery
