<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\MarkerCategory as ChildMarkerCategory;
use Common\DbBundle\Model\MarkerCategoryI18nQuery as ChildMarkerCategoryI18nQuery;
use Common\DbBundle\Model\MarkerCategoryQuery as ChildMarkerCategoryQuery;
use Common\DbBundle\Model\Map\MarkerCategoryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'marker_category' table.
 *
 *
 *
 * @method     ChildMarkerCategoryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMarkerCategoryQuery orderByIcon($order = Criteria::ASC) Order by the icon column
 *
 * @method     ChildMarkerCategoryQuery groupById() Group by the id column
 * @method     ChildMarkerCategoryQuery groupByIcon() Group by the icon column
 *
 * @method     ChildMarkerCategoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMarkerCategoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMarkerCategoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMarkerCategoryQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMarkerCategoryQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMarkerCategoryQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMarkerCategoryQuery leftJoinMarker($relationAlias = null) Adds a LEFT JOIN clause to the query using the Marker relation
 * @method     ChildMarkerCategoryQuery rightJoinMarker($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Marker relation
 * @method     ChildMarkerCategoryQuery innerJoinMarker($relationAlias = null) Adds a INNER JOIN clause to the query using the Marker relation
 *
 * @method     ChildMarkerCategoryQuery joinWithMarker($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Marker relation
 *
 * @method     ChildMarkerCategoryQuery leftJoinWithMarker() Adds a LEFT JOIN clause and with to the query using the Marker relation
 * @method     ChildMarkerCategoryQuery rightJoinWithMarker() Adds a RIGHT JOIN clause and with to the query using the Marker relation
 * @method     ChildMarkerCategoryQuery innerJoinWithMarker() Adds a INNER JOIN clause and with to the query using the Marker relation
 *
 * @method     ChildMarkerCategoryQuery leftJoinMarkerCategoryI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the MarkerCategoryI18n relation
 * @method     ChildMarkerCategoryQuery rightJoinMarkerCategoryI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MarkerCategoryI18n relation
 * @method     ChildMarkerCategoryQuery innerJoinMarkerCategoryI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the MarkerCategoryI18n relation
 *
 * @method     ChildMarkerCategoryQuery joinWithMarkerCategoryI18n($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MarkerCategoryI18n relation
 *
 * @method     ChildMarkerCategoryQuery leftJoinWithMarkerCategoryI18n() Adds a LEFT JOIN clause and with to the query using the MarkerCategoryI18n relation
 * @method     ChildMarkerCategoryQuery rightJoinWithMarkerCategoryI18n() Adds a RIGHT JOIN clause and with to the query using the MarkerCategoryI18n relation
 * @method     ChildMarkerCategoryQuery innerJoinWithMarkerCategoryI18n() Adds a INNER JOIN clause and with to the query using the MarkerCategoryI18n relation
 *
 * @method     \Common\DbBundle\Model\MarkerQuery|\Common\DbBundle\Model\MarkerCategoryI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMarkerCategory findOne(ConnectionInterface $con = null) Return the first ChildMarkerCategory matching the query
 * @method     ChildMarkerCategory findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMarkerCategory matching the query, or a new ChildMarkerCategory object populated from the query conditions when no match is found
 *
 * @method     ChildMarkerCategory findOneById(int $id) Return the first ChildMarkerCategory filtered by the id column
 * @method     ChildMarkerCategory findOneByIcon(string $icon) Return the first ChildMarkerCategory filtered by the icon column *

 * @method     ChildMarkerCategory requirePk($key, ConnectionInterface $con = null) Return the ChildMarkerCategory by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarkerCategory requireOne(ConnectionInterface $con = null) Return the first ChildMarkerCategory matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMarkerCategory requireOneById(int $id) Return the first ChildMarkerCategory filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarkerCategory requireOneByIcon(string $icon) Return the first ChildMarkerCategory filtered by the icon column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMarkerCategory[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMarkerCategory objects based on current ModelCriteria
 * @method     ChildMarkerCategory[]|ObjectCollection findById(int $id) Return ChildMarkerCategory objects filtered by the id column
 * @method     ChildMarkerCategory[]|ObjectCollection findByIcon(string $icon) Return ChildMarkerCategory objects filtered by the icon column
 * @method     ChildMarkerCategory[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MarkerCategoryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\MarkerCategoryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\MarkerCategory', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMarkerCategoryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMarkerCategoryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMarkerCategoryQuery) {
            return $criteria;
        }
        $query = new ChildMarkerCategoryQuery();
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
     * @return ChildMarkerCategory|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MarkerCategoryTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MarkerCategoryTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMarkerCategory A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `icon` FROM `marker_category` WHERE `id` = :p0';
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
            /** @var ChildMarkerCategory $obj */
            $obj = new ChildMarkerCategory();
            $obj->hydrate($row);
            MarkerCategoryTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMarkerCategory|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMarkerCategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MarkerCategoryTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMarkerCategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MarkerCategoryTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildMarkerCategoryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MarkerCategoryTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MarkerCategoryTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerCategoryTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildMarkerCategoryQuery The current query, for fluid interface
     */
    public function filterByIcon($icon = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($icon)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerCategoryTableMap::COL_ICON, $icon, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Marker object
     *
     * @param \Common\DbBundle\Model\Marker|ObjectCollection $marker the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMarkerCategoryQuery The current query, for fluid interface
     */
    public function filterByMarker($marker, $comparison = null)
    {
        if ($marker instanceof \Common\DbBundle\Model\Marker) {
            return $this
                ->addUsingAlias(MarkerCategoryTableMap::COL_ID, $marker->getCategoryId(), $comparison);
        } elseif ($marker instanceof ObjectCollection) {
            return $this
                ->useMarkerQuery()
                ->filterByPrimaryKeys($marker->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMarker() only accepts arguments of type \Common\DbBundle\Model\Marker or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Marker relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMarkerCategoryQuery The current query, for fluid interface
     */
    public function joinMarker($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Marker');

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
            $this->addJoinObject($join, 'Marker');
        }

        return $this;
    }

    /**
     * Use the Marker relation Marker object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\MarkerQuery A secondary query class using the current class as primary query
     */
    public function useMarkerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMarker($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Marker', '\Common\DbBundle\Model\MarkerQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\MarkerCategoryI18n object
     *
     * @param \Common\DbBundle\Model\MarkerCategoryI18n|ObjectCollection $markerCategoryI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMarkerCategoryQuery The current query, for fluid interface
     */
    public function filterByMarkerCategoryI18n($markerCategoryI18n, $comparison = null)
    {
        if ($markerCategoryI18n instanceof \Common\DbBundle\Model\MarkerCategoryI18n) {
            return $this
                ->addUsingAlias(MarkerCategoryTableMap::COL_ID, $markerCategoryI18n->getId(), $comparison);
        } elseif ($markerCategoryI18n instanceof ObjectCollection) {
            return $this
                ->useMarkerCategoryI18nQuery()
                ->filterByPrimaryKeys($markerCategoryI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMarkerCategoryI18n() only accepts arguments of type \Common\DbBundle\Model\MarkerCategoryI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MarkerCategoryI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMarkerCategoryQuery The current query, for fluid interface
     */
    public function joinMarkerCategoryI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MarkerCategoryI18n');

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
            $this->addJoinObject($join, 'MarkerCategoryI18n');
        }

        return $this;
    }

    /**
     * Use the MarkerCategoryI18n relation MarkerCategoryI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\MarkerCategoryI18nQuery A secondary query class using the current class as primary query
     */
    public function useMarkerCategoryI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinMarkerCategoryI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MarkerCategoryI18n', '\Common\DbBundle\Model\MarkerCategoryI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMarkerCategory $markerCategory Object to remove from the list of results
     *
     * @return $this|ChildMarkerCategoryQuery The current query, for fluid interface
     */
    public function prune($markerCategory = null)
    {
        if ($markerCategory) {
            $this->addUsingAlias(MarkerCategoryTableMap::COL_ID, $markerCategory->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the marker_category table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MarkerCategoryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MarkerCategoryTableMap::clearInstancePool();
            MarkerCategoryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MarkerCategoryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MarkerCategoryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MarkerCategoryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MarkerCategoryTableMap::clearRelatedInstancePool();

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
     * @return    ChildMarkerCategoryQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'MarkerCategoryI18n';

        return $this
            ->joinMarkerCategoryI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildMarkerCategoryQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'vi', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('MarkerCategoryI18n');
        $this->with['MarkerCategoryI18n']->setIsWithOneToMany(false);

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
     * @return    ChildMarkerCategoryI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MarkerCategoryI18n', '\Common\DbBundle\Model\MarkerCategoryI18nQuery');
    }

} // MarkerCategoryQuery