<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\Bundle as ChildBundle;
use Common\DbBundle\Model\BundleQuery as ChildBundleQuery;
use Common\DbBundle\Model\Map\BundleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'bundle' table.
 *
 *
 *
 * @method     ChildBundleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildBundleQuery orderByLocked($order = Criteria::ASC) Order by the locked column
 * @method     ChildBundleQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildBundleQuery orderByBundle($order = Criteria::ASC) Order by the bundle column
 *
 * @method     ChildBundleQuery groupById() Group by the id column
 * @method     ChildBundleQuery groupByLocked() Group by the locked column
 * @method     ChildBundleQuery groupByTitle() Group by the title column
 * @method     ChildBundleQuery groupByBundle() Group by the bundle column
 *
 * @method     ChildBundleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBundleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBundleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBundleQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBundleQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBundleQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBundleQuery leftJoinSection($relationAlias = null) Adds a LEFT JOIN clause to the query using the Section relation
 * @method     ChildBundleQuery rightJoinSection($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Section relation
 * @method     ChildBundleQuery innerJoinSection($relationAlias = null) Adds a INNER JOIN clause to the query using the Section relation
 *
 * @method     ChildBundleQuery joinWithSection($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Section relation
 *
 * @method     ChildBundleQuery leftJoinWithSection() Adds a LEFT JOIN clause and with to the query using the Section relation
 * @method     ChildBundleQuery rightJoinWithSection() Adds a RIGHT JOIN clause and with to the query using the Section relation
 * @method     ChildBundleQuery innerJoinWithSection() Adds a INNER JOIN clause and with to the query using the Section relation
 *
 * @method     ChildBundleQuery leftJoinMenu($relationAlias = null) Adds a LEFT JOIN clause to the query using the Menu relation
 * @method     ChildBundleQuery rightJoinMenu($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Menu relation
 * @method     ChildBundleQuery innerJoinMenu($relationAlias = null) Adds a INNER JOIN clause to the query using the Menu relation
 *
 * @method     ChildBundleQuery joinWithMenu($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Menu relation
 *
 * @method     ChildBundleQuery leftJoinWithMenu() Adds a LEFT JOIN clause and with to the query using the Menu relation
 * @method     ChildBundleQuery rightJoinWithMenu() Adds a RIGHT JOIN clause and with to the query using the Menu relation
 * @method     ChildBundleQuery innerJoinWithMenu() Adds a INNER JOIN clause and with to the query using the Menu relation
 *
 * @method     ChildBundleQuery leftJoinAdvert($relationAlias = null) Adds a LEFT JOIN clause to the query using the Advert relation
 * @method     ChildBundleQuery rightJoinAdvert($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Advert relation
 * @method     ChildBundleQuery innerJoinAdvert($relationAlias = null) Adds a INNER JOIN clause to the query using the Advert relation
 *
 * @method     ChildBundleQuery joinWithAdvert($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Advert relation
 *
 * @method     ChildBundleQuery leftJoinWithAdvert() Adds a LEFT JOIN clause and with to the query using the Advert relation
 * @method     ChildBundleQuery rightJoinWithAdvert() Adds a RIGHT JOIN clause and with to the query using the Advert relation
 * @method     ChildBundleQuery innerJoinWithAdvert() Adds a INNER JOIN clause and with to the query using the Advert relation
 *
 * @method     \Common\DbBundle\Model\SectionQuery|\Common\DbBundle\Model\MenuQuery|\Common\DbBundle\Model\AdvertQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBundle findOne(ConnectionInterface $con = null) Return the first ChildBundle matching the query
 * @method     ChildBundle findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBundle matching the query, or a new ChildBundle object populated from the query conditions when no match is found
 *
 * @method     ChildBundle findOneById(int $id) Return the first ChildBundle filtered by the id column
 * @method     ChildBundle findOneByLocked(boolean $locked) Return the first ChildBundle filtered by the locked column
 * @method     ChildBundle findOneByTitle(string $title) Return the first ChildBundle filtered by the title column
 * @method     ChildBundle findOneByBundle(string $bundle) Return the first ChildBundle filtered by the bundle column *

 * @method     ChildBundle requirePk($key, ConnectionInterface $con = null) Return the ChildBundle by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBundle requireOne(ConnectionInterface $con = null) Return the first ChildBundle matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBundle requireOneById(int $id) Return the first ChildBundle filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBundle requireOneByLocked(boolean $locked) Return the first ChildBundle filtered by the locked column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBundle requireOneByTitle(string $title) Return the first ChildBundle filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBundle requireOneByBundle(string $bundle) Return the first ChildBundle filtered by the bundle column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBundle[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBundle objects based on current ModelCriteria
 * @method     ChildBundle[]|ObjectCollection findById(int $id) Return ChildBundle objects filtered by the id column
 * @method     ChildBundle[]|ObjectCollection findByLocked(boolean $locked) Return ChildBundle objects filtered by the locked column
 * @method     ChildBundle[]|ObjectCollection findByTitle(string $title) Return ChildBundle objects filtered by the title column
 * @method     ChildBundle[]|ObjectCollection findByBundle(string $bundle) Return ChildBundle objects filtered by the bundle column
 * @method     ChildBundle[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BundleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\BundleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\Bundle', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBundleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBundleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBundleQuery) {
            return $criteria;
        }
        $query = new ChildBundleQuery();
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
     * @return ChildBundle|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BundleTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BundleTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBundle A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `locked`, `title`, `bundle` FROM `bundle` WHERE `id` = :p0';
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
            /** @var ChildBundle $obj */
            $obj = new ChildBundle();
            $obj->hydrate($row);
            BundleTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBundle|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBundleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BundleTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBundleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BundleTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBundleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BundleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BundleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BundleTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the locked column
     *
     * Example usage:
     * <code>
     * $query->filterByLocked(true); // WHERE locked = true
     * $query->filterByLocked('yes'); // WHERE locked = true
     * </code>
     *
     * @param     boolean|string $locked The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBundleQuery The current query, for fluid interface
     */
    public function filterByLocked($locked = null, $comparison = null)
    {
        if (is_string($locked)) {
            $locked = in_array(strtolower($locked), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(BundleTableMap::COL_LOCKED, $locked, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBundleQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BundleTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the bundle column
     *
     * Example usage:
     * <code>
     * $query->filterByBundle('fooValue');   // WHERE bundle = 'fooValue'
     * $query->filterByBundle('%fooValue%', Criteria::LIKE); // WHERE bundle LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bundle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBundleQuery The current query, for fluid interface
     */
    public function filterByBundle($bundle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bundle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BundleTableMap::COL_BUNDLE, $bundle, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Section object
     *
     * @param \Common\DbBundle\Model\Section|ObjectCollection $section the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBundleQuery The current query, for fluid interface
     */
    public function filterBySection($section, $comparison = null)
    {
        if ($section instanceof \Common\DbBundle\Model\Section) {
            return $this
                ->addUsingAlias(BundleTableMap::COL_ID, $section->getBundleId(), $comparison);
        } elseif ($section instanceof ObjectCollection) {
            return $this
                ->useSectionQuery()
                ->filterByPrimaryKeys($section->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySection() only accepts arguments of type \Common\DbBundle\Model\Section or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Section relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBundleQuery The current query, for fluid interface
     */
    public function joinSection($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Section');

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
            $this->addJoinObject($join, 'Section');
        }

        return $this;
    }

    /**
     * Use the Section relation Section object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\SectionQuery A secondary query class using the current class as primary query
     */
    public function useSectionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSection($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Section', '\Common\DbBundle\Model\SectionQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Menu object
     *
     * @param \Common\DbBundle\Model\Menu|ObjectCollection $menu the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBundleQuery The current query, for fluid interface
     */
    public function filterByMenu($menu, $comparison = null)
    {
        if ($menu instanceof \Common\DbBundle\Model\Menu) {
            return $this
                ->addUsingAlias(BundleTableMap::COL_ID, $menu->getBundleId(), $comparison);
        } elseif ($menu instanceof ObjectCollection) {
            return $this
                ->useMenuQuery()
                ->filterByPrimaryKeys($menu->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMenu() only accepts arguments of type \Common\DbBundle\Model\Menu or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Menu relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBundleQuery The current query, for fluid interface
     */
    public function joinMenu($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Menu');

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
            $this->addJoinObject($join, 'Menu');
        }

        return $this;
    }

    /**
     * Use the Menu relation Menu object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\MenuQuery A secondary query class using the current class as primary query
     */
    public function useMenuQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMenu($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Menu', '\Common\DbBundle\Model\MenuQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Advert object
     *
     * @param \Common\DbBundle\Model\Advert|ObjectCollection $advert the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBundleQuery The current query, for fluid interface
     */
    public function filterByAdvert($advert, $comparison = null)
    {
        if ($advert instanceof \Common\DbBundle\Model\Advert) {
            return $this
                ->addUsingAlias(BundleTableMap::COL_ID, $advert->getBundleId(), $comparison);
        } elseif ($advert instanceof ObjectCollection) {
            return $this
                ->useAdvertQuery()
                ->filterByPrimaryKeys($advert->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvert() only accepts arguments of type \Common\DbBundle\Model\Advert or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Advert relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBundleQuery The current query, for fluid interface
     */
    public function joinAdvert($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Advert');

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
            $this->addJoinObject($join, 'Advert');
        }

        return $this;
    }

    /**
     * Use the Advert relation Advert object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\AdvertQuery A secondary query class using the current class as primary query
     */
    public function useAdvertQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdvert($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Advert', '\Common\DbBundle\Model\AdvertQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBundle $bundle Object to remove from the list of results
     *
     * @return $this|ChildBundleQuery The current query, for fluid interface
     */
    public function prune($bundle = null)
    {
        if ($bundle) {
            $this->addUsingAlias(BundleTableMap::COL_ID, $bundle->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the bundle table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BundleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BundleTableMap::clearInstancePool();
            BundleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BundleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BundleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BundleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BundleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BundleQuery
