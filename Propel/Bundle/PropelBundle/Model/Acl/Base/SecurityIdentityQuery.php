<?php

namespace Propel\Bundle\PropelBundle\Model\Acl\Base;

use \Exception;
use \PDO;
use Propel\Bundle\PropelBundle\Model\Acl\SecurityIdentity as ChildSecurityIdentity;
use Propel\Bundle\PropelBundle\Model\Acl\SecurityIdentityQuery as ChildSecurityIdentityQuery;
use Propel\Bundle\PropelBundle\Model\Acl\Map\SecurityIdentityTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'acl_security_identities' table.
 *
 *
 *
 * @method     ChildSecurityIdentityQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSecurityIdentityQuery orderByIdentifier($order = Criteria::ASC) Order by the identifier column
 * @method     ChildSecurityIdentityQuery orderByUsername($order = Criteria::ASC) Order by the username column
 *
 * @method     ChildSecurityIdentityQuery groupById() Group by the id column
 * @method     ChildSecurityIdentityQuery groupByIdentifier() Group by the identifier column
 * @method     ChildSecurityIdentityQuery groupByUsername() Group by the username column
 *
 * @method     ChildSecurityIdentityQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSecurityIdentityQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSecurityIdentityQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSecurityIdentityQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSecurityIdentityQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSecurityIdentityQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSecurityIdentityQuery leftJoinEntry($relationAlias = null) Adds a LEFT JOIN clause to the query using the Entry relation
 * @method     ChildSecurityIdentityQuery rightJoinEntry($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Entry relation
 * @method     ChildSecurityIdentityQuery innerJoinEntry($relationAlias = null) Adds a INNER JOIN clause to the query using the Entry relation
 *
 * @method     ChildSecurityIdentityQuery joinWithEntry($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Entry relation
 *
 * @method     ChildSecurityIdentityQuery leftJoinWithEntry() Adds a LEFT JOIN clause and with to the query using the Entry relation
 * @method     ChildSecurityIdentityQuery rightJoinWithEntry() Adds a RIGHT JOIN clause and with to the query using the Entry relation
 * @method     ChildSecurityIdentityQuery innerJoinWithEntry() Adds a INNER JOIN clause and with to the query using the Entry relation
 *
 * @method     \Propel\Bundle\PropelBundle\Model\Acl\EntryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSecurityIdentity findOne(ConnectionInterface $con = null) Return the first ChildSecurityIdentity matching the query
 * @method     ChildSecurityIdentity findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSecurityIdentity matching the query, or a new ChildSecurityIdentity object populated from the query conditions when no match is found
 *
 * @method     ChildSecurityIdentity findOneById(int $id) Return the first ChildSecurityIdentity filtered by the id column
 * @method     ChildSecurityIdentity findOneByIdentifier(string $identifier) Return the first ChildSecurityIdentity filtered by the identifier column
 * @method     ChildSecurityIdentity findOneByUsername(boolean $username) Return the first ChildSecurityIdentity filtered by the username column *

 * @method     ChildSecurityIdentity requirePk($key, ConnectionInterface $con = null) Return the ChildSecurityIdentity by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSecurityIdentity requireOne(ConnectionInterface $con = null) Return the first ChildSecurityIdentity matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSecurityIdentity requireOneById(int $id) Return the first ChildSecurityIdentity filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSecurityIdentity requireOneByIdentifier(string $identifier) Return the first ChildSecurityIdentity filtered by the identifier column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSecurityIdentity requireOneByUsername(boolean $username) Return the first ChildSecurityIdentity filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSecurityIdentity[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSecurityIdentity objects based on current ModelCriteria
 * @method     ChildSecurityIdentity[]|ObjectCollection findById(int $id) Return ChildSecurityIdentity objects filtered by the id column
 * @method     ChildSecurityIdentity[]|ObjectCollection findByIdentifier(string $identifier) Return ChildSecurityIdentity objects filtered by the identifier column
 * @method     ChildSecurityIdentity[]|ObjectCollection findByUsername(boolean $username) Return ChildSecurityIdentity objects filtered by the username column
 * @method     ChildSecurityIdentity[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SecurityIdentityQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Bundle\PropelBundle\Model\Acl\Base\SecurityIdentityQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\SecurityIdentity', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSecurityIdentityQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSecurityIdentityQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSecurityIdentityQuery) {
            return $criteria;
        }
        $query = new ChildSecurityIdentityQuery();
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
     * @return ChildSecurityIdentity|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SecurityIdentityTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SecurityIdentityTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildSecurityIdentity A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, identifier, username FROM acl_security_identities WHERE id = :p0';
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
            /** @var ChildSecurityIdentity $obj */
            $obj = new ChildSecurityIdentity();
            $obj->hydrate($row);
            SecurityIdentityTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSecurityIdentity|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSecurityIdentityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SecurityIdentityTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSecurityIdentityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SecurityIdentityTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSecurityIdentityQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SecurityIdentityTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SecurityIdentityTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SecurityIdentityTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the identifier column
     *
     * Example usage:
     * <code>
     * $query->filterByIdentifier('fooValue');   // WHERE identifier = 'fooValue'
     * $query->filterByIdentifier('%fooValue%', Criteria::LIKE); // WHERE identifier LIKE '%fooValue%'
     * </code>
     *
     * @param     string $identifier The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSecurityIdentityQuery The current query, for fluid interface
     */
    public function filterByIdentifier($identifier = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($identifier)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SecurityIdentityTableMap::COL_IDENTIFIER, $identifier, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername(true); // WHERE username = true
     * $query->filterByUsername('yes'); // WHERE username = true
     * </code>
     *
     * @param     boolean|string $username The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSecurityIdentityQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (is_string($username)) {
            $username = in_array(strtolower($username), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SecurityIdentityTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\Entry object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\Entry|ObjectCollection $entry the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSecurityIdentityQuery The current query, for fluid interface
     */
    public function filterByEntry($entry, $comparison = null)
    {
        if ($entry instanceof \Propel\Bundle\PropelBundle\Model\Acl\Entry) {
            return $this
                ->addUsingAlias(SecurityIdentityTableMap::COL_ID, $entry->getSecurityIdentityId(), $comparison);
        } elseif ($entry instanceof ObjectCollection) {
            return $this
                ->useEntryQuery()
                ->filterByPrimaryKeys($entry->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEntry() only accepts arguments of type \Propel\Bundle\PropelBundle\Model\Acl\Entry or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Entry relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSecurityIdentityQuery The current query, for fluid interface
     */
    public function joinEntry($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Entry');

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
            $this->addJoinObject($join, 'Entry');
        }

        return $this;
    }

    /**
     * Use the Entry relation Entry object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Bundle\PropelBundle\Model\Acl\EntryQuery A secondary query class using the current class as primary query
     */
    public function useEntryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEntry($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Entry', '\Propel\Bundle\PropelBundle\Model\Acl\EntryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSecurityIdentity $securityIdentity Object to remove from the list of results
     *
     * @return $this|ChildSecurityIdentityQuery The current query, for fluid interface
     */
    public function prune($securityIdentity = null)
    {
        if ($securityIdentity) {
            $this->addUsingAlias(SecurityIdentityTableMap::COL_ID, $securityIdentity->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the acl_security_identities table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SecurityIdentityTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SecurityIdentityTableMap::clearInstancePool();
            SecurityIdentityTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SecurityIdentityTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SecurityIdentityTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SecurityIdentityTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SecurityIdentityTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SecurityIdentityQuery
