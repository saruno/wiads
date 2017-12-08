<?php

namespace Propel\Bundle\PropelBundle\Model\Acl\Base;

use \Exception;
use \PDO;
use Propel\Bundle\PropelBundle\Model\Acl\AclClass as ChildAclClass;
use Propel\Bundle\PropelBundle\Model\Acl\AclClassQuery as ChildAclClassQuery;
use Propel\Bundle\PropelBundle\Model\Acl\Map\AclClassTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'acl_classes' table.
 *
 *
 *
 * @method     ChildAclClassQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAclClassQuery orderByType($order = Criteria::ASC) Order by the class_type column
 *
 * @method     ChildAclClassQuery groupById() Group by the id column
 * @method     ChildAclClassQuery groupByType() Group by the class_type column
 *
 * @method     ChildAclClassQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAclClassQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAclClassQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAclClassQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAclClassQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAclClassQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAclClassQuery leftJoinObjectIdentity($relationAlias = null) Adds a LEFT JOIN clause to the query using the ObjectIdentity relation
 * @method     ChildAclClassQuery rightJoinObjectIdentity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ObjectIdentity relation
 * @method     ChildAclClassQuery innerJoinObjectIdentity($relationAlias = null) Adds a INNER JOIN clause to the query using the ObjectIdentity relation
 *
 * @method     ChildAclClassQuery joinWithObjectIdentity($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ObjectIdentity relation
 *
 * @method     ChildAclClassQuery leftJoinWithObjectIdentity() Adds a LEFT JOIN clause and with to the query using the ObjectIdentity relation
 * @method     ChildAclClassQuery rightJoinWithObjectIdentity() Adds a RIGHT JOIN clause and with to the query using the ObjectIdentity relation
 * @method     ChildAclClassQuery innerJoinWithObjectIdentity() Adds a INNER JOIN clause and with to the query using the ObjectIdentity relation
 *
 * @method     ChildAclClassQuery leftJoinEntry($relationAlias = null) Adds a LEFT JOIN clause to the query using the Entry relation
 * @method     ChildAclClassQuery rightJoinEntry($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Entry relation
 * @method     ChildAclClassQuery innerJoinEntry($relationAlias = null) Adds a INNER JOIN clause to the query using the Entry relation
 *
 * @method     ChildAclClassQuery joinWithEntry($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Entry relation
 *
 * @method     ChildAclClassQuery leftJoinWithEntry() Adds a LEFT JOIN clause and with to the query using the Entry relation
 * @method     ChildAclClassQuery rightJoinWithEntry() Adds a RIGHT JOIN clause and with to the query using the Entry relation
 * @method     ChildAclClassQuery innerJoinWithEntry() Adds a INNER JOIN clause and with to the query using the Entry relation
 *
 * @method     \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery|\Propel\Bundle\PropelBundle\Model\Acl\EntryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAclClass findOne(ConnectionInterface $con = null) Return the first ChildAclClass matching the query
 * @method     ChildAclClass findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAclClass matching the query, or a new ChildAclClass object populated from the query conditions when no match is found
 *
 * @method     ChildAclClass findOneById(int $id) Return the first ChildAclClass filtered by the id column
 * @method     ChildAclClass findOneByType(string $class_type) Return the first ChildAclClass filtered by the class_type column *

 * @method     ChildAclClass requirePk($key, ConnectionInterface $con = null) Return the ChildAclClass by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAclClass requireOne(ConnectionInterface $con = null) Return the first ChildAclClass matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAclClass requireOneById(int $id) Return the first ChildAclClass filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAclClass requireOneByType(string $class_type) Return the first ChildAclClass filtered by the class_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAclClass[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAclClass objects based on current ModelCriteria
 * @method     ChildAclClass[]|ObjectCollection findById(int $id) Return ChildAclClass objects filtered by the id column
 * @method     ChildAclClass[]|ObjectCollection findByType(string $class_type) Return ChildAclClass objects filtered by the class_type column
 * @method     ChildAclClass[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AclClassQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Bundle\PropelBundle\Model\Acl\Base\AclClassQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\AclClass', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAclClassQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAclClassQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAclClassQuery) {
            return $criteria;
        }
        $query = new ChildAclClassQuery();
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
     * @return ChildAclClass|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AclClassTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AclClassTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAclClass A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, class_type FROM acl_classes WHERE id = :p0';
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
            /** @var ChildAclClass $obj */
            $obj = new ChildAclClass();
            $obj->hydrate($row);
            AclClassTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAclClass|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAclClassQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AclClassTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAclClassQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AclClassTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAclClassQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AclClassTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AclClassTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AclClassTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the class_type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE class_type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE class_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAclClassQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AclClassTableMap::COL_CLASS_TYPE, $type, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity|ObjectCollection $objectIdentity the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAclClassQuery The current query, for fluid interface
     */
    public function filterByObjectIdentity($objectIdentity, $comparison = null)
    {
        if ($objectIdentity instanceof \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity) {
            return $this
                ->addUsingAlias(AclClassTableMap::COL_ID, $objectIdentity->getClassId(), $comparison);
        } elseif ($objectIdentity instanceof ObjectCollection) {
            return $this
                ->useObjectIdentityQuery()
                ->filterByPrimaryKeys($objectIdentity->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByObjectIdentity() only accepts arguments of type \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ObjectIdentity relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAclClassQuery The current query, for fluid interface
     */
    public function joinObjectIdentity($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ObjectIdentity');

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
            $this->addJoinObject($join, 'ObjectIdentity');
        }

        return $this;
    }

    /**
     * Use the ObjectIdentity relation ObjectIdentity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery A secondary query class using the current class as primary query
     */
    public function useObjectIdentityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinObjectIdentity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ObjectIdentity', '\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery');
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\Entry object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\Entry|ObjectCollection $entry the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAclClassQuery The current query, for fluid interface
     */
    public function filterByEntry($entry, $comparison = null)
    {
        if ($entry instanceof \Propel\Bundle\PropelBundle\Model\Acl\Entry) {
            return $this
                ->addUsingAlias(AclClassTableMap::COL_ID, $entry->getClassId(), $comparison);
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
     * @return $this|ChildAclClassQuery The current query, for fluid interface
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
     * @param   ChildAclClass $aclClass Object to remove from the list of results
     *
     * @return $this|ChildAclClassQuery The current query, for fluid interface
     */
    public function prune($aclClass = null)
    {
        if ($aclClass) {
            $this->addUsingAlias(AclClassTableMap::COL_ID, $aclClass->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the acl_classes table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AclClassTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AclClassTableMap::clearInstancePool();
            AclClassTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AclClassTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AclClassTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AclClassTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AclClassTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AclClassQuery
