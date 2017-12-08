<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\MenuI18n as ChildMenuI18n;
use Common\DbBundle\Model\MenuI18nQuery as ChildMenuI18nQuery;
use Common\DbBundle\Model\Map\MenuI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'menu_i18n' table.
 *
 *
 *
 * @method     ChildMenuI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMenuI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildMenuI18nQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildMenuI18nQuery orderByStripTitle($order = Criteria::ASC) Order by the strip_title column
 * @method     ChildMenuI18nQuery orderByBrief($order = Criteria::ASC) Order by the brief column
 * @method     ChildMenuI18nQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildMenuI18nQuery orderByLinkTo($order = Criteria::ASC) Order by the link_to column
 *
 * @method     ChildMenuI18nQuery groupById() Group by the id column
 * @method     ChildMenuI18nQuery groupByLocale() Group by the locale column
 * @method     ChildMenuI18nQuery groupByTitle() Group by the title column
 * @method     ChildMenuI18nQuery groupByStripTitle() Group by the strip_title column
 * @method     ChildMenuI18nQuery groupByBrief() Group by the brief column
 * @method     ChildMenuI18nQuery groupByContent() Group by the content column
 * @method     ChildMenuI18nQuery groupByLinkTo() Group by the link_to column
 *
 * @method     ChildMenuI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMenuI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMenuI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMenuI18nQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMenuI18nQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMenuI18nQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMenuI18nQuery leftJoinMenu($relationAlias = null) Adds a LEFT JOIN clause to the query using the Menu relation
 * @method     ChildMenuI18nQuery rightJoinMenu($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Menu relation
 * @method     ChildMenuI18nQuery innerJoinMenu($relationAlias = null) Adds a INNER JOIN clause to the query using the Menu relation
 *
 * @method     ChildMenuI18nQuery joinWithMenu($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Menu relation
 *
 * @method     ChildMenuI18nQuery leftJoinWithMenu() Adds a LEFT JOIN clause and with to the query using the Menu relation
 * @method     ChildMenuI18nQuery rightJoinWithMenu() Adds a RIGHT JOIN clause and with to the query using the Menu relation
 * @method     ChildMenuI18nQuery innerJoinWithMenu() Adds a INNER JOIN clause and with to the query using the Menu relation
 *
 * @method     \Common\DbBundle\Model\MenuQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMenuI18n findOne(ConnectionInterface $con = null) Return the first ChildMenuI18n matching the query
 * @method     ChildMenuI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMenuI18n matching the query, or a new ChildMenuI18n object populated from the query conditions when no match is found
 *
 * @method     ChildMenuI18n findOneById(int $id) Return the first ChildMenuI18n filtered by the id column
 * @method     ChildMenuI18n findOneByLocale(string $locale) Return the first ChildMenuI18n filtered by the locale column
 * @method     ChildMenuI18n findOneByTitle(string $title) Return the first ChildMenuI18n filtered by the title column
 * @method     ChildMenuI18n findOneByStripTitle(string $strip_title) Return the first ChildMenuI18n filtered by the strip_title column
 * @method     ChildMenuI18n findOneByBrief(string $brief) Return the first ChildMenuI18n filtered by the brief column
 * @method     ChildMenuI18n findOneByContent(string $content) Return the first ChildMenuI18n filtered by the content column
 * @method     ChildMenuI18n findOneByLinkTo(string $link_to) Return the first ChildMenuI18n filtered by the link_to column *

 * @method     ChildMenuI18n requirePk($key, ConnectionInterface $con = null) Return the ChildMenuI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenuI18n requireOne(ConnectionInterface $con = null) Return the first ChildMenuI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMenuI18n requireOneById(int $id) Return the first ChildMenuI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenuI18n requireOneByLocale(string $locale) Return the first ChildMenuI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenuI18n requireOneByTitle(string $title) Return the first ChildMenuI18n filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenuI18n requireOneByStripTitle(string $strip_title) Return the first ChildMenuI18n filtered by the strip_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenuI18n requireOneByBrief(string $brief) Return the first ChildMenuI18n filtered by the brief column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenuI18n requireOneByContent(string $content) Return the first ChildMenuI18n filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMenuI18n requireOneByLinkTo(string $link_to) Return the first ChildMenuI18n filtered by the link_to column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMenuI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMenuI18n objects based on current ModelCriteria
 * @method     ChildMenuI18n[]|ObjectCollection findById(int $id) Return ChildMenuI18n objects filtered by the id column
 * @method     ChildMenuI18n[]|ObjectCollection findByLocale(string $locale) Return ChildMenuI18n objects filtered by the locale column
 * @method     ChildMenuI18n[]|ObjectCollection findByTitle(string $title) Return ChildMenuI18n objects filtered by the title column
 * @method     ChildMenuI18n[]|ObjectCollection findByStripTitle(string $strip_title) Return ChildMenuI18n objects filtered by the strip_title column
 * @method     ChildMenuI18n[]|ObjectCollection findByBrief(string $brief) Return ChildMenuI18n objects filtered by the brief column
 * @method     ChildMenuI18n[]|ObjectCollection findByContent(string $content) Return ChildMenuI18n objects filtered by the content column
 * @method     ChildMenuI18n[]|ObjectCollection findByLinkTo(string $link_to) Return ChildMenuI18n objects filtered by the link_to column
 * @method     ChildMenuI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MenuI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\MenuI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\MenuI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMenuI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMenuI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMenuI18nQuery) {
            return $criteria;
        }
        $query = new ChildMenuI18nQuery();
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
     * @return ChildMenuI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MenuI18nTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MenuI18nTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildMenuI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `locale`, `title`, `strip_title`, `brief`, `content`, `link_to` FROM `menu_i18n` WHERE `id` = :p0 AND `locale` = :p1';
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
            /** @var ChildMenuI18n $obj */
            $obj = new ChildMenuI18n();
            $obj->hydrate($row);
            MenuI18nTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildMenuI18n|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMenuI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(MenuI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(MenuI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMenuI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(MenuI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(MenuI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterByMenu()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMenuI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MenuI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MenuI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuI18nTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildMenuI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuI18nTableMap::COL_LOCALE, $locale, $comparison);
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
     * @return $this|ChildMenuI18nQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuI18nTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the strip_title column
     *
     * Example usage:
     * <code>
     * $query->filterByStripTitle('fooValue');   // WHERE strip_title = 'fooValue'
     * $query->filterByStripTitle('%fooValue%', Criteria::LIKE); // WHERE strip_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stripTitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMenuI18nQuery The current query, for fluid interface
     */
    public function filterByStripTitle($stripTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stripTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuI18nTableMap::COL_STRIP_TITLE, $stripTitle, $comparison);
    }

    /**
     * Filter the query on the brief column
     *
     * Example usage:
     * <code>
     * $query->filterByBrief('fooValue');   // WHERE brief = 'fooValue'
     * $query->filterByBrief('%fooValue%', Criteria::LIKE); // WHERE brief LIKE '%fooValue%'
     * </code>
     *
     * @param     string $brief The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMenuI18nQuery The current query, for fluid interface
     */
    public function filterByBrief($brief = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($brief)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuI18nTableMap::COL_BRIEF, $brief, $comparison);
    }

    /**
     * Filter the query on the content column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
     * $query->filterByContent('%fooValue%', Criteria::LIKE); // WHERE content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMenuI18nQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuI18nTableMap::COL_CONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the link_to column
     *
     * Example usage:
     * <code>
     * $query->filterByLinkTo('fooValue');   // WHERE link_to = 'fooValue'
     * $query->filterByLinkTo('%fooValue%', Criteria::LIKE); // WHERE link_to LIKE '%fooValue%'
     * </code>
     *
     * @param     string $linkTo The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMenuI18nQuery The current query, for fluid interface
     */
    public function filterByLinkTo($linkTo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($linkTo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuI18nTableMap::COL_LINK_TO, $linkTo, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Menu object
     *
     * @param \Common\DbBundle\Model\Menu|ObjectCollection $menu The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMenuI18nQuery The current query, for fluid interface
     */
    public function filterByMenu($menu, $comparison = null)
    {
        if ($menu instanceof \Common\DbBundle\Model\Menu) {
            return $this
                ->addUsingAlias(MenuI18nTableMap::COL_ID, $menu->getId(), $comparison);
        } elseif ($menu instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MenuI18nTableMap::COL_ID, $menu->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildMenuI18nQuery The current query, for fluid interface
     */
    public function joinMenu($relationAlias = null, $joinType = 'LEFT JOIN')
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
    public function useMenuQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinMenu($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Menu', '\Common\DbBundle\Model\MenuQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMenuI18n $menuI18n Object to remove from the list of results
     *
     * @return $this|ChildMenuI18nQuery The current query, for fluid interface
     */
    public function prune($menuI18n = null)
    {
        if ($menuI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(MenuI18nTableMap::COL_ID), $menuI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(MenuI18nTableMap::COL_LOCALE), $menuI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the menu_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenuI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MenuI18nTableMap::clearInstancePool();
            MenuI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MenuI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MenuI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MenuI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MenuI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MenuI18nQuery
