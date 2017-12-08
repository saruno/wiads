<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\AccesspointCategory as ChildAccesspointCategory;
use Hotspot\AccessPointBundle\Model\AccesspointCategoryI18nQuery as ChildAccesspointCategoryI18nQuery;
use Hotspot\AccessPointBundle\Model\AccesspointCategoryQuery as ChildAccesspointCategoryQuery;
use Hotspot\AccessPointBundle\Model\Map\AccesspointCategoryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'accesspoint_category' table.
 *
 *
 *
 * @method     ChildAccesspointCategoryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAccesspointCategoryQuery orderByIcon($order = Criteria::ASC) Order by the icon column
 *
 * @method     ChildAccesspointCategoryQuery groupById() Group by the id column
 * @method     ChildAccesspointCategoryQuery groupByIcon() Group by the icon column
 *
 * @method     ChildAccesspointCategoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAccesspointCategoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAccesspointCategoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAccesspointCategoryQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAccesspointCategoryQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAccesspointCategoryQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAccesspointCategoryQuery leftJoinAccesspoint($relationAlias = null) Adds a LEFT JOIN clause to the query using the Accesspoint relation
 * @method     ChildAccesspointCategoryQuery rightJoinAccesspoint($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Accesspoint relation
 * @method     ChildAccesspointCategoryQuery innerJoinAccesspoint($relationAlias = null) Adds a INNER JOIN clause to the query using the Accesspoint relation
 *
 * @method     ChildAccesspointCategoryQuery joinWithAccesspoint($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Accesspoint relation
 *
 * @method     ChildAccesspointCategoryQuery leftJoinWithAccesspoint() Adds a LEFT JOIN clause and with to the query using the Accesspoint relation
 * @method     ChildAccesspointCategoryQuery rightJoinWithAccesspoint() Adds a RIGHT JOIN clause and with to the query using the Accesspoint relation
 * @method     ChildAccesspointCategoryQuery innerJoinWithAccesspoint() Adds a INNER JOIN clause and with to the query using the Accesspoint relation
 *
 * @method     ChildAccesspointCategoryQuery leftJoinAccesspointCategoryI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccesspointCategoryI18n relation
 * @method     ChildAccesspointCategoryQuery rightJoinAccesspointCategoryI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccesspointCategoryI18n relation
 * @method     ChildAccesspointCategoryQuery innerJoinAccesspointCategoryI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the AccesspointCategoryI18n relation
 *
 * @method     ChildAccesspointCategoryQuery joinWithAccesspointCategoryI18n($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccesspointCategoryI18n relation
 *
 * @method     ChildAccesspointCategoryQuery leftJoinWithAccesspointCategoryI18n() Adds a LEFT JOIN clause and with to the query using the AccesspointCategoryI18n relation
 * @method     ChildAccesspointCategoryQuery rightJoinWithAccesspointCategoryI18n() Adds a RIGHT JOIN clause and with to the query using the AccesspointCategoryI18n relation
 * @method     ChildAccesspointCategoryQuery innerJoinWithAccesspointCategoryI18n() Adds a INNER JOIN clause and with to the query using the AccesspointCategoryI18n relation
 *
 * @method     \Hotspot\AccessPointBundle\Model\AccesspointQuery|\Hotspot\AccessPointBundle\Model\AccesspointCategoryI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAccesspointCategory findOne(ConnectionInterface $con = null) Return the first ChildAccesspointCategory matching the query
 * @method     ChildAccesspointCategory findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAccesspointCategory matching the query, or a new ChildAccesspointCategory object populated from the query conditions when no match is found
 *
 * @method     ChildAccesspointCategory findOneById(int $id) Return the first ChildAccesspointCategory filtered by the id column
 * @method     ChildAccesspointCategory findOneByIcon(string $icon) Return the first ChildAccesspointCategory filtered by the icon column *

 * @method     ChildAccesspointCategory requirePk($key, ConnectionInterface $con = null) Return the ChildAccesspointCategory by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointCategory requireOne(ConnectionInterface $con = null) Return the first ChildAccesspointCategory matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccesspointCategory requireOneById(int $id) Return the first ChildAccesspointCategory filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointCategory requireOneByIcon(string $icon) Return the first ChildAccesspointCategory filtered by the icon column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccesspointCategory[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAccesspointCategory objects based on current ModelCriteria
 * @method     ChildAccesspointCategory[]|ObjectCollection findById(int $id) Return ChildAccesspointCategory objects filtered by the id column
 * @method     ChildAccesspointCategory[]|ObjectCollection findByIcon(string $icon) Return ChildAccesspointCategory objects filtered by the icon column
 * @method     ChildAccesspointCategory[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AccesspointCategoryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Hotspot\AccessPointBundle\Model\Base\AccesspointCategoryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Hotspot\\AccessPointBundle\\Model\\AccesspointCategory', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAccesspointCategoryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAccesspointCategoryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAccesspointCategoryQuery) {
            return $criteria;
        }
        $query = new ChildAccesspointCategoryQuery();
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
     * @return ChildAccesspointCategory|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AccesspointCategoryTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AccesspointCategoryTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAccesspointCategory A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `icon` FROM `accesspoint_category` WHERE `id` = :p0';
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
            /** @var ChildAccesspointCategory $obj */
            $obj = new ChildAccesspointCategory();
            $obj->hydrate($row);
            AccesspointCategoryTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAccesspointCategory|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAccesspointCategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AccesspointCategoryTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAccesspointCategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AccesspointCategoryTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAccesspointCategoryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AccesspointCategoryTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AccesspointCategoryTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointCategoryTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the icon column
     *
     * Example usage:
     * <code>
     * $query->filterByIcon('fooValue');   // WHERE icon = 'fooValue'
     * $query->filterByIcon('%fooValue%', Criteria::LIKE); // WHERE icon LIKE '%fooValue%'
     * </code>
     *
     * @param     string $icon The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointCategoryQuery The current query, for fluid interface
     */
    public function filterByIcon($icon = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($icon)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointCategoryTableMap::COL_ICON, $icon, $comparison);
    }

    /**
     * Filter the query by a related \Hotspot\AccessPointBundle\Model\Accesspoint object
     *
     * @param \Hotspot\AccessPointBundle\Model\Accesspoint|ObjectCollection $accesspoint the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccesspointCategoryQuery The current query, for fluid interface
     */
    public function filterByAccesspoint($accesspoint, $comparison = null)
    {
        if ($accesspoint instanceof \Hotspot\AccessPointBundle\Model\Accesspoint) {
            return $this
                ->addUsingAlias(AccesspointCategoryTableMap::COL_ID, $accesspoint->getCategoryId(), $comparison);
        } elseif ($accesspoint instanceof ObjectCollection) {
            return $this
                ->useAccesspointQuery()
                ->filterByPrimaryKeys($accesspoint->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccesspoint() only accepts arguments of type \Hotspot\AccessPointBundle\Model\Accesspoint or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Accesspoint relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccesspointCategoryQuery The current query, for fluid interface
     */
    public function joinAccesspoint($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Accesspoint');

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
            $this->addJoinObject($join, 'Accesspoint');
        }

        return $this;
    }

    /**
     * Use the Accesspoint relation Accesspoint object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Hotspot\AccessPointBundle\Model\AccesspointQuery A secondary query class using the current class as primary query
     */
    public function useAccesspointQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAccesspoint($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Accesspoint', '\Hotspot\AccessPointBundle\Model\AccesspointQuery');
    }

    /**
     * Filter the query by a related \Hotspot\AccessPointBundle\Model\AccesspointCategoryI18n object
     *
     * @param \Hotspot\AccessPointBundle\Model\AccesspointCategoryI18n|ObjectCollection $accesspointCategoryI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccesspointCategoryQuery The current query, for fluid interface
     */
    public function filterByAccesspointCategoryI18n($accesspointCategoryI18n, $comparison = null)
    {
        if ($accesspointCategoryI18n instanceof \Hotspot\AccessPointBundle\Model\AccesspointCategoryI18n) {
            return $this
                ->addUsingAlias(AccesspointCategoryTableMap::COL_ID, $accesspointCategoryI18n->getId(), $comparison);
        } elseif ($accesspointCategoryI18n instanceof ObjectCollection) {
            return $this
                ->useAccesspointCategoryI18nQuery()
                ->filterByPrimaryKeys($accesspointCategoryI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccesspointCategoryI18n() only accepts arguments of type \Hotspot\AccessPointBundle\Model\AccesspointCategoryI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccesspointCategoryI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccesspointCategoryQuery The current query, for fluid interface
     */
    public function joinAccesspointCategoryI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccesspointCategoryI18n');

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
            $this->addJoinObject($join, 'AccesspointCategoryI18n');
        }

        return $this;
    }

    /**
     * Use the AccesspointCategoryI18n relation AccesspointCategoryI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Hotspot\AccessPointBundle\Model\AccesspointCategoryI18nQuery A secondary query class using the current class as primary query
     */
    public function useAccesspointCategoryI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinAccesspointCategoryI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccesspointCategoryI18n', '\Hotspot\AccessPointBundle\Model\AccesspointCategoryI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAccesspointCategory $accesspointCategory Object to remove from the list of results
     *
     * @return $this|ChildAccesspointCategoryQuery The current query, for fluid interface
     */
    public function prune($accesspointCategory = null)
    {
        if ($accesspointCategory) {
            $this->addUsingAlias(AccesspointCategoryTableMap::COL_ID, $accesspointCategory->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the accesspoint_category table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointCategoryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AccesspointCategoryTableMap::clearInstancePool();
            AccesspointCategoryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointCategoryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AccesspointCategoryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AccesspointCategoryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AccesspointCategoryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildAccesspointCategoryQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'AccesspointCategoryI18n';

        return $this
            ->joinAccesspointCategoryI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildAccesspointCategoryQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'vi', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('AccesspointCategoryI18n');
        $this->with['AccesspointCategoryI18n']->setIsWithOneToMany(false);

        return $this;
    }

    /**
     * Use the I18n relation query object
     *
     * @see       useQuery()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildAccesspointCategoryI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccesspointCategoryI18n', '\Hotspot\AccessPointBundle\Model\AccesspointCategoryI18nQuery');
    }

} // AccesspointCategoryQuery
