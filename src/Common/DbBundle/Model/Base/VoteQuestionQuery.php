<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\VoteQuestion as ChildVoteQuestion;
use Common\DbBundle\Model\VoteQuestionI18nQuery as ChildVoteQuestionI18nQuery;
use Common\DbBundle\Model\VoteQuestionQuery as ChildVoteQuestionQuery;
use Common\DbBundle\Model\Map\VoteQuestionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'vote_question' table.
 *
 *
 *
 * @method     ChildVoteQuestionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildVoteQuestionQuery orderByVoteId($order = Criteria::ASC) Order by the vote_id column
 *
 * @method     ChildVoteQuestionQuery groupById() Group by the id column
 * @method     ChildVoteQuestionQuery groupByVoteId() Group by the vote_id column
 *
 * @method     ChildVoteQuestionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildVoteQuestionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildVoteQuestionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildVoteQuestionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildVoteQuestionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildVoteQuestionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildVoteQuestionQuery leftJoinVote($relationAlias = null) Adds a LEFT JOIN clause to the query using the Vote relation
 * @method     ChildVoteQuestionQuery rightJoinVote($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Vote relation
 * @method     ChildVoteQuestionQuery innerJoinVote($relationAlias = null) Adds a INNER JOIN clause to the query using the Vote relation
 *
 * @method     ChildVoteQuestionQuery joinWithVote($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Vote relation
 *
 * @method     ChildVoteQuestionQuery leftJoinWithVote() Adds a LEFT JOIN clause and with to the query using the Vote relation
 * @method     ChildVoteQuestionQuery rightJoinWithVote() Adds a RIGHT JOIN clause and with to the query using the Vote relation
 * @method     ChildVoteQuestionQuery innerJoinWithVote() Adds a INNER JOIN clause and with to the query using the Vote relation
 *
 * @method     ChildVoteQuestionQuery leftJoinVoteQuestionI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the VoteQuestionI18n relation
 * @method     ChildVoteQuestionQuery rightJoinVoteQuestionI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the VoteQuestionI18n relation
 * @method     ChildVoteQuestionQuery innerJoinVoteQuestionI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the VoteQuestionI18n relation
 *
 * @method     ChildVoteQuestionQuery joinWithVoteQuestionI18n($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the VoteQuestionI18n relation
 *
 * @method     ChildVoteQuestionQuery leftJoinWithVoteQuestionI18n() Adds a LEFT JOIN clause and with to the query using the VoteQuestionI18n relation
 * @method     ChildVoteQuestionQuery rightJoinWithVoteQuestionI18n() Adds a RIGHT JOIN clause and with to the query using the VoteQuestionI18n relation
 * @method     ChildVoteQuestionQuery innerJoinWithVoteQuestionI18n() Adds a INNER JOIN clause and with to the query using the VoteQuestionI18n relation
 *
 * @method     \Common\DbBundle\Model\VoteQuery|\Common\DbBundle\Model\VoteQuestionI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildVoteQuestion findOne(ConnectionInterface $con = null) Return the first ChildVoteQuestion matching the query
 * @method     ChildVoteQuestion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildVoteQuestion matching the query, or a new ChildVoteQuestion object populated from the query conditions when no match is found
 *
 * @method     ChildVoteQuestion findOneById(int $id) Return the first ChildVoteQuestion filtered by the id column
 * @method     ChildVoteQuestion findOneByVoteId(int $vote_id) Return the first ChildVoteQuestion filtered by the vote_id column *

 * @method     ChildVoteQuestion requirePk($key, ConnectionInterface $con = null) Return the ChildVoteQuestion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteQuestion requireOne(ConnectionInterface $con = null) Return the first ChildVoteQuestion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoteQuestion requireOneById(int $id) Return the first ChildVoteQuestion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildVoteQuestion requireOneByVoteId(int $vote_id) Return the first ChildVoteQuestion filtered by the vote_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildVoteQuestion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildVoteQuestion objects based on current ModelCriteria
 * @method     ChildVoteQuestion[]|ObjectCollection findById(int $id) Return ChildVoteQuestion objects filtered by the id column
 * @method     ChildVoteQuestion[]|ObjectCollection findByVoteId(int $vote_id) Return ChildVoteQuestion objects filtered by the vote_id column
 * @method     ChildVoteQuestion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class VoteQuestionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\VoteQuestionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\VoteQuestion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVoteQuestionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildVoteQuestionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildVoteQuestionQuery) {
            return $criteria;
        }
        $query = new ChildVoteQuestionQuery();
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
     * @return ChildVoteQuestion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VoteQuestionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = VoteQuestionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildVoteQuestion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `vote_id` FROM `vote_question` WHERE `id` = :p0';
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
            /** @var ChildVoteQuestion $obj */
            $obj = new ChildVoteQuestion();
            $obj->hydrate($row);
            VoteQuestionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildVoteQuestion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildVoteQuestionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(VoteQuestionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildVoteQuestionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(VoteQuestionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildVoteQuestionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(VoteQuestionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(VoteQuestionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteQuestionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the vote_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVoteId(1234); // WHERE vote_id = 1234
     * $query->filterByVoteId(array(12, 34)); // WHERE vote_id IN (12, 34)
     * $query->filterByVoteId(array('min' => 12)); // WHERE vote_id > 12
     * </code>
     *
     * @see       filterByVote()
     *
     * @param     mixed $voteId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildVoteQuestionQuery The current query, for fluid interface
     */
    public function filterByVoteId($voteId = null, $comparison = null)
    {
        if (is_array($voteId)) {
            $useMinMax = false;
            if (isset($voteId['min'])) {
                $this->addUsingAlias(VoteQuestionTableMap::COL_VOTE_ID, $voteId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($voteId['max'])) {
                $this->addUsingAlias(VoteQuestionTableMap::COL_VOTE_ID, $voteId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(VoteQuestionTableMap::COL_VOTE_ID, $voteId, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Vote object
     *
     * @param \Common\DbBundle\Model\Vote|ObjectCollection $vote The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildVoteQuestionQuery The current query, for fluid interface
     */
    public function filterByVote($vote, $comparison = null)
    {
        if ($vote instanceof \Common\DbBundle\Model\Vote) {
            return $this
                ->addUsingAlias(VoteQuestionTableMap::COL_VOTE_ID, $vote->getId(), $comparison);
        } elseif ($vote instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(VoteQuestionTableMap::COL_VOTE_ID, $vote->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByVote() only accepts arguments of type \Common\DbBundle\Model\Vote or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Vote relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVoteQuestionQuery The current query, for fluid interface
     */
    public function joinVote($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Vote');

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
            $this->addJoinObject($join, 'Vote');
        }

        return $this;
    }

    /**
     * Use the Vote relation Vote object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\VoteQuery A secondary query class using the current class as primary query
     */
    public function useVoteQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinVote($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Vote', '\Common\DbBundle\Model\VoteQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\VoteQuestionI18n object
     *
     * @param \Common\DbBundle\Model\VoteQuestionI18n|ObjectCollection $voteQuestionI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildVoteQuestionQuery The current query, for fluid interface
     */
    public function filterByVoteQuestionI18n($voteQuestionI18n, $comparison = null)
    {
        if ($voteQuestionI18n instanceof \Common\DbBundle\Model\VoteQuestionI18n) {
            return $this
                ->addUsingAlias(VoteQuestionTableMap::COL_ID, $voteQuestionI18n->getId(), $comparison);
        } elseif ($voteQuestionI18n instanceof ObjectCollection) {
            return $this
                ->useVoteQuestionI18nQuery()
                ->filterByPrimaryKeys($voteQuestionI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByVoteQuestionI18n() only accepts arguments of type \Common\DbBundle\Model\VoteQuestionI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the VoteQuestionI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildVoteQuestionQuery The current query, for fluid interface
     */
    public function joinVoteQuestionI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('VoteQuestionI18n');

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
            $this->addJoinObject($join, 'VoteQuestionI18n');
        }

        return $this;
    }

    /**
     * Use the VoteQuestionI18n relation VoteQuestionI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\VoteQuestionI18nQuery A secondary query class using the current class as primary query
     */
    public function useVoteQuestionI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinVoteQuestionI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'VoteQuestionI18n', '\Common\DbBundle\Model\VoteQuestionI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildVoteQuestion $voteQuestion Object to remove from the list of results
     *
     * @return $this|ChildVoteQuestionQuery The current query, for fluid interface
     */
    public function prune($voteQuestion = null)
    {
        if ($voteQuestion) {
            $this->addUsingAlias(VoteQuestionTableMap::COL_ID, $voteQuestion->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the vote_question table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VoteQuestionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VoteQuestionTableMap::clearInstancePool();
            VoteQuestionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VoteQuestionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VoteQuestionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VoteQuestionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            VoteQuestionTableMap::clearRelatedInstancePool();

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
     * @return    ChildVoteQuestionQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'VoteQuestionI18n';

        return $this
            ->joinVoteQuestionI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildVoteQuestionQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'vi', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('VoteQuestionI18n');
        $this->with['VoteQuestionI18n']->setIsWithOneToMany(false);

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
     * @return    ChildVoteQuestionI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'VoteQuestionI18n', '\Common\DbBundle\Model\VoteQuestionI18nQuery');
    }

} // VoteQuestionQuery
