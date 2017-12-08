<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\VoteQuestionI18n as ChildVoteQuestionI18n;
use Common\DbBundle\Model\VoteQuestionI18nQuery as ChildVoteQuestionI18nQuery;
use Common\DbBundle\Model\Map\VoteQuestionI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'vote_question_i18n' table.
 *
 *
 *
 * @method     ChildVoteQuestionI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildVoteQuestionI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildVoteQuestionI18nQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildVoteQuestionI18nQuery orderByCount($order = Criteria::ASC) Order by the count column
 * @method     ChildVoteQuestionI18nQuery orderByTotal($order = Criteria::ASC) Order by the total column
 *
 * @method     ChildVoteQuestionI18nQuery groupById() Group by the id column
 * @method     ChildVoteQuestionI18nQuery groupByLocale() Group by the locale column
 * @method     ChildVoteQuestionI18nQuery groupByContent() Group by the content column
 * @method     ChildVoteQuestionI18nQuery groupByCount() Group by the count column
 * @method     ChildVoteQuestionI18nQuery groupByTotal() Group by the total column
 *
 * @method     ChildVoteQuestionI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVoteQuestionI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVoteQuestionI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVoteQuestionI18nQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVoteQuestionI18nQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVoteQuestionI18nQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVoteQuestionI18nQuery leftJoinVoteQuestion($relationAlias = null) Adds a LEFT JOIN clause to the query using the VoteQuestion relation
 * @method     ChildVoteQuestionI18nQuery rightJoinVoteQuestion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the VoteQuestion relation
 * @method     ChildVoteQuestionI18nQuery innerJoinVoteQuestion($relationAlias = null) Adds a INNER JOIN clause to the query using the VoteQuestion relation
 *
 * @method     ChildVoteQuestionI18nQuery joinWithVoteQuestion($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the VoteQuestion relation
 *
 * @method     ChildVoteQuestionI18nQuery leftJoinWithVoteQuestion() Adds a LEFT JOIN clause and with to the query using the VoteQuestion relation
 * @method     ChildVoteQuestionI18nQuery rightJoinWithVoteQuestion() Adds a RIGHT JOIN clause and with to the query using the VoteQuestion relation
 * @method     ChildVoteQuestionI18nQuery innerJoinWithVoteQuestion() Adds a INNER JOIN clause and with to the query using the VoteQuestion relation
 *
 * @method     \Common\DbBundle\Model\VoteQuestionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVoteQuestionI18n findOne(ConnectionInterface $con = null) Return the first ChildVoteQuestionI18n matching the query
 * @method     ChildVoteQuestionI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVoteQuestionI18n matching the query, or a new ChildVoteQuestionI18n object populated from the query conditions when no match is found
 *
 * @method     ChildVoteQuestionI18n findOneById(int $id) Return the first ChildVoteQuestionI18n filtered by the id column
 * @method     ChildVoteQuestionI18n findOneByLocale(string $locale) Return the first ChildVoteQuestionI18n filtered by the locale column
 * @method     ChildVoteQuestionI18n findOneByContent(string $content) Return the first ChildVoteQuestionI18n filtered by the content column
 * @method     ChildVoteQuestionI18n findOneByCount(int $count) Return the first ChildVoteQuestionI18n filtered by the count column
 * @method     ChildVoteQuestionI18n findOneByTotal(int $total) Return the first ChildVoteQuestionI18n filtered by the total column *

 * @method     ChildVoteQuestionI18n requirePk($key, ConnectionInterface $con = null) Return the ChildVoteQuestionI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteQuestionI18n requireOne(ConnectionInterface $con = null) Return the first ChildVoteQuestionI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoteQuestionI18n requireOneById(int $id) Return the first ChildVoteQuestionI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteQuestionI18n requireOneByLocale(string $locale) Return the first ChildVoteQuestionI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteQuestionI18n requireOneByContent(string $content) Return the first ChildVoteQuestionI18n filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteQuestionI18n requireOneByCount(int $count) Return the first ChildVoteQuestionI18n filtered by the count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteQuestionI18n requireOneByTotal(int $total) Return the first ChildVoteQuestionI18n filtered by the total column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoteQuestionI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVoteQuestionI18n objects based on current ModelCriteria
 * @method     ChildVoteQuestionI18n[]|ObjectCollection findById(int $id) Return ChildVoteQuestionI18n objects filtered by the id column
 * @method     ChildVoteQuestionI18n[]|ObjectCollection findByLocale(string $locale) Return ChildVoteQuestionI18n objects filtered by the locale column
 * @method     ChildVoteQuestionI18n[]|ObjectCollection findByContent(string $content) Return ChildVoteQuestionI18n objects filtered by the content column
 * @method     ChildVoteQuestionI18n[]|ObjectCollection findByCount(int $count) Return ChildVoteQuestionI18n objects filtered by the count column
 * @method     ChildVoteQuestionI18n[]|ObjectCollection findByTotal(int $total) Return ChildVoteQuestionI18n objects filtered by the total column
 * @method     ChildVoteQuestionI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VoteQuestionI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\VoteQuestionI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\VoteQuestionI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVoteQuestionI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVoteQuestionI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVoteQuestionI18nQuery) {
            return $criteria;
        }
        $query = new ChildVoteQuestionI18nQuery();
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
     * @return ChildVoteQuestionI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VoteQuestionI18nTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = VoteQuestionI18nTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildVoteQuestionI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `locale`, `content`, `count`, `total` FROM `vote_question_i18n` WHERE `id` = :p0 AND `locale` = :p1';
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
            /** @var ChildVoteQuestionI18n $obj */
            $obj = new ChildVoteQuestionI18n();
            $obj->hydrate($row);
            VoteQuestionI18nTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildVoteQuestionI18n|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildVoteQuestionI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(VoteQuestionI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(VoteQuestionI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVoteQuestionI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(VoteQuestionI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(VoteQuestionI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterByVoteQuestion()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteQuestionI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VoteQuestionI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VoteQuestionI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteQuestionI18nTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildVoteQuestionI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteQuestionI18nTableMap::COL_LOCALE, $locale, $comparison);
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
     * @return $this|ChildVoteQuestionI18nQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteQuestionI18nTableMap::COL_CONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the count column
     *
     * Example usage:
     * <code>
     * $query->filterByCount(1234); // WHERE count = 1234
     * $query->filterByCount(array(12, 34)); // WHERE count IN (12, 34)
     * $query->filterByCount(array('min' => 12)); // WHERE count > 12
     * </code>
     *
     * @param     mixed $count The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteQuestionI18nQuery The current query, for fluid interface
     */
    public function filterByCount($count = null, $comparison = null)
    {
        if (is_array($count)) {
            $useMinMax = false;
            if (isset($count['min'])) {
                $this->addUsingAlias(VoteQuestionI18nTableMap::COL_COUNT, $count['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($count['max'])) {
                $this->addUsingAlias(VoteQuestionI18nTableMap::COL_COUNT, $count['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteQuestionI18nTableMap::COL_COUNT, $count, $comparison);
    }

    /**
     * Filter the query on the total column
     *
     * Example usage:
     * <code>
     * $query->filterByTotal(1234); // WHERE total = 1234
     * $query->filterByTotal(array(12, 34)); // WHERE total IN (12, 34)
     * $query->filterByTotal(array('min' => 12)); // WHERE total > 12
     * </code>
     *
     * @param     mixed $total The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteQuestionI18nQuery The current query, for fluid interface
     */
    public function filterByTotal($total = null, $comparison = null)
    {
        if (is_array($total)) {
            $useMinMax = false;
            if (isset($total['min'])) {
                $this->addUsingAlias(VoteQuestionI18nTableMap::COL_TOTAL, $total['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($total['max'])) {
                $this->addUsingAlias(VoteQuestionI18nTableMap::COL_TOTAL, $total['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteQuestionI18nTableMap::COL_TOTAL, $total, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\VoteQuestion object
     *
     * @param \Common\DbBundle\Model\VoteQuestion|ObjectCollection $voteQuestion The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoteQuestionI18nQuery The current query, for fluid interface
     */
    public function filterByVoteQuestion($voteQuestion, $comparison = null)
    {
        if ($voteQuestion instanceof \Common\DbBundle\Model\VoteQuestion) {
            return $this
                ->addUsingAlias(VoteQuestionI18nTableMap::COL_ID, $voteQuestion->getId(), $comparison);
        } elseif ($voteQuestion instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoteQuestionI18nTableMap::COL_ID, $voteQuestion->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByVoteQuestion() only accepts arguments of type \Common\DbBundle\Model\VoteQuestion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the VoteQuestion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVoteQuestionI18nQuery The current query, for fluid interface
     */
    public function joinVoteQuestion($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('VoteQuestion');

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
            $this->addJoinObject($join, 'VoteQuestion');
        }

        return $this;
    }

    /**
     * Use the VoteQuestion relation VoteQuestion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\VoteQuestionQuery A secondary query class using the current class as primary query
     */
    public function useVoteQuestionQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinVoteQuestion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'VoteQuestion', '\Common\DbBundle\Model\VoteQuestionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVoteQuestionI18n $voteQuestionI18n Object to remove from the list of results
     *
     * @return $this|ChildVoteQuestionI18nQuery The current query, for fluid interface
     */
    public function prune($voteQuestionI18n = null)
    {
        if ($voteQuestionI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(VoteQuestionI18nTableMap::COL_ID), $voteQuestionI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(VoteQuestionI18nTableMap::COL_LOCALE), $voteQuestionI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the vote_question_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoteQuestionI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VoteQuestionI18nTableMap::clearInstancePool();
            VoteQuestionI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VoteQuestionI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VoteQuestionI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VoteQuestionI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VoteQuestionI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // VoteQuestionI18nQuery
