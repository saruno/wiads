<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\AccesspointCategoryI18n as ChildAccesspointCategoryI18n;
use Hotspot\AccessPointBundle\Model\AccesspointCategoryI18nQuery as ChildAccesspointCategoryI18nQuery;
use Hotspot\AccessPointBundle\Model\Map\AccesspointCategoryI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'accesspoint_category_i18n' table.
 *
 *
 *
 * @method     ChildAccesspointCategoryI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAccesspointCategoryI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildAccesspointCategoryI18nQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildAccesspointCategoryI18nQuery groupById() Group by the id column
 * @method     ChildAccesspointCategoryI18nQuery groupByLocale() Group by the locale column
 * @method     ChildAccesspointCategoryI18nQuery groupByName() Group by the name column
 *
 * @method     ChildAccesspointCategoryI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAccesspointCategoryI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAccesspointCategoryI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAccesspointCategoryI18nQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAccesspointCategoryI18nQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAccesspointCategoryI18nQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAccesspointCategoryI18nQuery leftJoinAccesspointCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccesspointCategory relation
 * @method     ChildAccesspointCategoryI18nQuery rightJoinAccesspointCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccesspointCategory relation
 * @method     ChildAccesspointCategoryI18nQuery innerJoinAccesspointCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the AccesspointCategory relation
 *
 * @method     ChildAccesspointCategoryI18nQuery joinWithAccesspointCategory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccesspointCategory relation
 *
 * @method     ChildAccesspointCategoryI18nQuery leftJoinWithAccesspointCategory() Adds a LEFT JOIN clause and with to the query using the AccesspointCategory relation
 * @method     ChildAccesspointCategoryI18nQuery rightJoinWithAccesspointCategory() Adds a RIGHT JOIN clause and with to the query using the AccesspointCategory relation
 * @method     ChildAccesspointCategoryI18nQuery innerJoinWithAccesspointCategory() Adds a INNER JOIN clause and with to the query using the AccesspointCategory relation
 *
 * @method     \Hotspot\AccessPointBundle\Model\AccesspointCategoryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAccesspointCategoryI18n findOne(ConnectionInterface $con = null) Return the first ChildAccesspointCategoryI18n matching the query
 * @method     ChildAccesspointCategoryI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAccesspointCategoryI18n matching the query, or a new ChildAccesspointCategoryI18n object populated from the query conditions when no match is found
 *
 * @method     ChildAccesspointCategoryI18n findOneById(int $id) Return the first ChildAccesspointCategoryI18n filtered by the id column
 * @method     ChildAccesspointCategoryI18n findOneByLocale(string $locale) Return the first ChildAccesspointCategoryI18n filtered by the locale column
 * @method     ChildAccesspointCategoryI18n findOneByName(string $name) Return the first ChildAccesspointCategoryI18n filtered by the name column *

 * @method     ChildAccesspointCategoryI18n requirePk($key, ConnectionInterface $con = null) Return the ChildAccesspointCategoryI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointCategoryI18n requireOne(ConnectionInterface $con = null) Return the first ChildAccesspointCategoryI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccesspointCategoryI18n requireOneById(int $id) Return the first ChildAccesspointCategoryI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointCategoryI18n requireOneByLocale(string $locale) Return the first ChildAccesspointCategoryI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointCategoryI18n requireOneByName(string $name) Return the first ChildAccesspointCategoryI18n filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccesspointCategoryI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAccesspointCategoryI18n objects based on current ModelCriteria
 * @method     ChildAccesspointCategoryI18n[]|ObjectCollection findById(int $id) Return ChildAccesspointCategoryI18n objects filtered by the id column
 * @method     ChildAccesspointCategoryI18n[]|ObjectCollection findByLocale(string $locale) Return ChildAccesspointCategoryI18n objects filtered by the locale column
 * @method     ChildAccesspointCategoryI18n[]|ObjectCollection findByName(string $name) Return ChildAccesspointCategoryI18n objects filtered by the name column
 * @method     ChildAccesspointCategoryI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AccesspointCategoryI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Hotspot\AccessPointBundle\Model\Base\AccesspointCategoryI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Hotspot\\AccessPointBundle\\Model\\AccesspointCategoryI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAccesspointCategoryI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAccesspointCategoryI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAccesspointCategoryI18nQuery) {
            return $criteria;
        }
        $query = new ChildAccesspointCategoryI18nQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAccesspointCategoryI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AccesspointCategoryI18nTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AccesspointCategoryI18nTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildAccesspointCategoryI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `locale`, `name` FROM `accesspoint_category_i18n` WHERE `id` = :p0 AND `locale` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAccesspointCategoryI18n $obj */
            $obj = new ChildAccesspointCategoryI18n();
            $obj->hydrate($row);
            AccesspointCategoryI18nTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildAccesspointCategoryI18n|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildAccesspointCategoryI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AccesspointCategoryI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AccesspointCategoryI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAccesspointCategoryI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AccesspointCategoryI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AccesspointCategoryI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByAccesspointCategory()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointCategoryI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AccesspointCategoryI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AccesspointCategoryI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointCategoryI18nTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%', Criteria::LIKE); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointCategoryI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointCategoryI18nTableMap::COL_LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointCategoryI18nQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointCategoryI18nTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \Hotspot\AccessPointBundle\Model\AccesspointCategory object
     *
     * @param \Hotspot\AccessPointBundle\Model\AccesspointCategory|ObjectCollection $accesspointCategory The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAccesspointCategoryI18nQuery The current query, for fluid interface
     */
    public function filterByAccesspointCategory($accesspointCategory, $comparison = null)
    {
        if ($accesspointCategory instanceof \Hotspot\AccessPointBundle\Model\AccesspointCategory) {
            return $this
                ->addUsingAlias(AccesspointCategoryI18nTableMap::COL_ID, $accesspointCategory->getId(), $comparison);
        } elseif ($accesspointCategory instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccesspointCategoryI18nTableMap::COL_ID, $accesspointCategory->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAccesspointCategory() only accepts arguments of type \Hotspot\AccessPointBundle\Model\AccesspointCategory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccesspointCategory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccesspointCategoryI18nQuery The current query, for fluid interface
     */
    public function joinAccesspointCategory($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccesspointCategory');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AccesspointCategory');
        }

        return $this;
    }

    /**
     * Use the AccesspointCategory relation AccesspointCategory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Hotspot\AccessPointBundle\Model\AccesspointCategoryQuery A secondary query class using the current class as primary query
     */
    public function useAccesspointCategoryQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinAccesspointCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccesspointCategory', '\Hotspot\AccessPointBundle\Model\AccesspointCategoryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAccesspointCategoryI18n $accesspointCategoryI18n Object to remove from the list of results
     *
     * @return $this|ChildAccesspointCategoryI18nQuery The current query, for fluid interface
     */
    public function prune($accesspointCategoryI18n = null)
    {
        if ($accesspointCategoryI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AccesspointCategoryI18nTableMap::COL_ID), $accesspointCategoryI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AccesspointCategoryI18nTableMap::COL_LOCALE), $accesspointCategoryI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the accesspoint_category_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointCategoryI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AccesspointCategoryI18nTableMap::clearInstancePool();
            AccesspointCategoryI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointCategoryI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AccesspointCategoryI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AccesspointCategoryI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AccesspointCategoryI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AccesspointCategoryI18nQuery
