<?php

namespace Propel\Bundle\PropelBundle\Model\Acl\Base;

use \Exception;
use \PDO;
use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor as ChildObjectIdentityAncestor;
use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestorQuery as ChildObjectIdentityAncestorQuery;
use Propel\Bundle\PropelBundle\Model\Acl\Map\ObjectIdentityAncestorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'acl_object_identity_ancestors' table.
 *
 *
 *
 * @method     ChildObjectIdentityAncestorQuery orderByObjectIdentityId($order = Criteria::ASC) Order by the object_identity_id column
 * @method     ChildObjectIdentityAncestorQuery orderByAncestorId($order = Criteria::ASC) Order by the ancestor_id column
 *
 * @method     ChildObjectIdentityAncestorQuery groupByObjectIdentityId() Group by the object_identity_id column
 * @method     ChildObjectIdentityAncestorQuery groupByAncestorId() Group by the ancestor_id column
 *
 * @method     ChildObjectIdentityAncestorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildObjectIdentityAncestorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildObjectIdentityAncestorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildObjectIdentityAncestorQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildObjectIdentityAncestorQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildObjectIdentityAncestorQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildObjectIdentityAncestorQuery leftJoinObjectIdentityRelatedByObjectIdentityId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ObjectIdentityRelatedByObjectIdentityId relation
 * @method     ChildObjectIdentityAncestorQuery rightJoinObjectIdentityRelatedByObjectIdentityId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ObjectIdentityRelatedByObjectIdentityId relation
 * @method     ChildObjectIdentityAncestorQuery innerJoinObjectIdentityRelatedByObjectIdentityId($relationAlias = null) Adds a INNER JOIN clause to the query using the ObjectIdentityRelatedByObjectIdentityId relation
 *
 * @method     ChildObjectIdentityAncestorQuery joinWithObjectIdentityRelatedByObjectIdentityId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ObjectIdentityRelatedByObjectIdentityId relation
 *
 * @method     ChildObjectIdentityAncestorQuery leftJoinWithObjectIdentityRelatedByObjectIdentityId() Adds a LEFT JOIN clause and with to the query using the ObjectIdentityRelatedByObjectIdentityId relation
 * @method     ChildObjectIdentityAncestorQuery rightJoinWithObjectIdentityRelatedByObjectIdentityId() Adds a RIGHT JOIN clause and with to the query using the ObjectIdentityRelatedByObjectIdentityId relation
 * @method     ChildObjectIdentityAncestorQuery innerJoinWithObjectIdentityRelatedByObjectIdentityId() Adds a INNER JOIN clause and with to the query using the ObjectIdentityRelatedByObjectIdentityId relation
 *
 * @method     ChildObjectIdentityAncestorQuery leftJoinObjectIdentityRelatedByAncestorId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ObjectIdentityRelatedByAncestorId relation
 * @method     ChildObjectIdentityAncestorQuery rightJoinObjectIdentityRelatedByAncestorId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ObjectIdentityRelatedByAncestorId relation
 * @method     ChildObjectIdentityAncestorQuery innerJoinObjectIdentityRelatedByAncestorId($relationAlias = null) Adds a INNER JOIN clause to the query using the ObjectIdentityRelatedByAncestorId relation
 *
 * @method     ChildObjectIdentityAncestorQuery joinWithObjectIdentityRelatedByAncestorId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ObjectIdentityRelatedByAncestorId relation
 *
 * @method     ChildObjectIdentityAncestorQuery leftJoinWithObjectIdentityRelatedByAncestorId() Adds a LEFT JOIN clause and with to the query using the ObjectIdentityRelatedByAncestorId relation
 * @method     ChildObjectIdentityAncestorQuery rightJoinWithObjectIdentityRelatedByAncestorId() Adds a RIGHT JOIN clause and with to the query using the ObjectIdentityRelatedByAncestorId relation
 * @method     ChildObjectIdentityAncestorQuery innerJoinWithObjectIdentityRelatedByAncestorId() Adds a INNER JOIN clause and with to the query using the ObjectIdentityRelatedByAncestorId relation
 *
 * @method     \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildObjectIdentityAncestor findOne(ConnectionInterface $con = null) Return the first ChildObjectIdentityAncestor matching the query
 * @method     ChildObjectIdentityAncestor findOneOrCreate(ConnectionInterface $con = null) Return the first ChildObjectIdentityAncestor matching the query, or a new ChildObjectIdentityAncestor object populated from the query conditions when no match is found
 *
 * @method     ChildObjectIdentityAncestor findOneByObjectIdentityId(int $object_identity_id) Return the first ChildObjectIdentityAncestor filtered by the object_identity_id column
 * @method     ChildObjectIdentityAncestor findOneByAncestorId(int $ancestor_id) Return the first ChildObjectIdentityAncestor filtered by the ancestor_id column *

 * @method     ChildObjectIdentityAncestor requirePk($key, ConnectionInterface $con = null) Return the ChildObjectIdentityAncestor by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildObjectIdentityAncestor requireOne(ConnectionInterface $con = null) Return the first ChildObjectIdentityAncestor matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildObjectIdentityAncestor requireOneByObjectIdentityId(int $object_identity_id) Return the first ChildObjectIdentityAncestor filtered by the object_identity_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildObjectIdentityAncestor requireOneByAncestorId(int $ancestor_id) Return the first ChildObjectIdentityAncestor filtered by the ancestor_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildObjectIdentityAncestor[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildObjectIdentityAncestor objects based on current ModelCriteria
 * @method     ChildObjectIdentityAncestor[]|ObjectCollection findByObjectIdentityId(int $object_identity_id) Return ChildObjectIdentityAncestor objects filtered by the object_identity_id column
 * @method     ChildObjectIdentityAncestor[]|ObjectCollection findByAncestorId(int $ancestor_id) Return ChildObjectIdentityAncestor objects filtered by the ancestor_id column
 * @method     ChildObjectIdentityAncestor[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ObjectIdentityAncestorQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Bundle\PropelBundle\Model\Acl\Base\ObjectIdentityAncestorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\ObjectIdentityAncestor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildObjectIdentityAncestorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildObjectIdentityAncestorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildObjectIdentityAncestorQuery) {
            return $criteria;
        }
        $query = new ChildObjectIdentityAncestorQuery();
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
     * @param array[$object_identity_id, $ancestor_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildObjectIdentityAncestor|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ObjectIdentityAncestorTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ObjectIdentityAncestorTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildObjectIdentityAncestor A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT object_identity_id, ancestor_id FROM acl_object_identity_ancestors WHERE object_identity_id = :p0 AND ancestor_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildObjectIdentityAncestor $obj */
            $obj = new ChildObjectIdentityAncestor();
            $obj->hydrate($row);
            ObjectIdentityAncestorTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildObjectIdentityAncestor|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildObjectIdentityAncestorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ObjectIdentityAncestorTableMap::COL_OBJECT_IDENTITY_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ObjectIdentityAncestorTableMap::COL_ANCESTOR_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildObjectIdentityAncestorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ObjectIdentityAncestorTableMap::COL_OBJECT_IDENTITY_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ObjectIdentityAncestorTableMap::COL_ANCESTOR_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the object_identity_id column
     *
     * Example usage:
     * <code>
     * $query->filterByObjectIdentityId(1234); // WHERE object_identity_id = 1234
     * $query->filterByObjectIdentityId(array(12, 34)); // WHERE object_identity_id IN (12, 34)
     * $query->filterByObjectIdentityId(array('min' => 12)); // WHERE object_identity_id > 12
     * </code>
     *
     * @see       filterByObjectIdentityRelatedByObjectIdentityId()
     *
     * @param     mixed $objectIdentityId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildObjectIdentityAncestorQuery The current query, for fluid interface
     */
    public function filterByObjectIdentityId($objectIdentityId = null, $comparison = null)
    {
        if (is_array($objectIdentityId)) {
            $useMinMax = false;
            if (isset($objectIdentityId['min'])) {
                $this->addUsingAlias(ObjectIdentityAncestorTableMap::COL_OBJECT_IDENTITY_ID, $objectIdentityId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objectIdentityId['max'])) {
                $this->addUsingAlias(ObjectIdentityAncestorTableMap::COL_OBJECT_IDENTITY_ID, $objectIdentityId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ObjectIdentityAncestorTableMap::COL_OBJECT_IDENTITY_ID, $objectIdentityId, $comparison);
    }

    /**
     * Filter the query on the ancestor_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAncestorId(1234); // WHERE ancestor_id = 1234
     * $query->filterByAncestorId(array(12, 34)); // WHERE ancestor_id IN (12, 34)
     * $query->filterByAncestorId(array('min' => 12)); // WHERE ancestor_id > 12
     * </code>
     *
     * @see       filterByObjectIdentityRelatedByAncestorId()
     *
     * @param     mixed $ancestorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildObjectIdentityAncestorQuery The current query, for fluid interface
     */
    public function filterByAncestorId($ancestorId = null, $comparison = null)
    {
        if (is_array($ancestorId)) {
            $useMinMax = false;
            if (isset($ancestorId['min'])) {
                $this->addUsingAlias(ObjectIdentityAncestorTableMap::COL_ANCESTOR_ID, $ancestorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ancestorId['max'])) {
                $this->addUsingAlias(ObjectIdentityAncestorTableMap::COL_ANCESTOR_ID, $ancestorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ObjectIdentityAncestorTableMap::COL_ANCESTOR_ID, $ancestorId, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity|ObjectCollection $objectIdentity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildObjectIdentityAncestorQuery The current query, for fluid interface
     */
    public function filterByObjectIdentityRelatedByObjectIdentityId($objectIdentity, $comparison = null)
    {
        if ($objectIdentity instanceof \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity) {
            return $this
                ->addUsingAlias(ObjectIdentityAncestorTableMap::COL_OBJECT_IDENTITY_ID, $objectIdentity->getId(), $comparison);
        } elseif ($objectIdentity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ObjectIdentityAncestorTableMap::COL_OBJECT_IDENTITY_ID, $objectIdentity->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByObjectIdentityRelatedByObjectIdentityId() only accepts arguments of type \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ObjectIdentityRelatedByObjectIdentityId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildObjectIdentityAncestorQuery The current query, for fluid interface
     */
    public function joinObjectIdentityRelatedByObjectIdentityId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ObjectIdentityRelatedByObjectIdentityId');

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
            $this->addJoinObject($join, 'ObjectIdentityRelatedByObjectIdentityId');
        }

        return $this;
    }

    /**
     * Use the ObjectIdentityRelatedByObjectIdentityId relation ObjectIdentity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery A secondary query class using the current class as primary query
     */
    public function useObjectIdentityRelatedByObjectIdentityIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinObjectIdentityRelatedByObjectIdentityId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ObjectIdentityRelatedByObjectIdentityId', '\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery');
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity|ObjectCollection $objectIdentity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildObjectIdentityAncestorQuery The current query, for fluid interface
     */
    public function filterByObjectIdentityRelatedByAncestorId($objectIdentity, $comparison = null)
    {
        if ($objectIdentity instanceof \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity) {
            return $this
                ->addUsingAlias(ObjectIdentityAncestorTableMap::COL_ANCESTOR_ID, $objectIdentity->getId(), $comparison);
        } elseif ($objectIdentity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ObjectIdentityAncestorTableMap::COL_ANCESTOR_ID, $objectIdentity->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByObjectIdentityRelatedByAncestorId() only accepts arguments of type \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ObjectIdentityRelatedByAncestorId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildObjectIdentityAncestorQuery The current query, for fluid interface
     */
    public function joinObjectIdentityRelatedByAncestorId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ObjectIdentityRelatedByAncestorId');

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
            $this->addJoinObject($join, 'ObjectIdentityRelatedByAncestorId');
        }

        return $this;
    }

    /**
     * Use the ObjectIdentityRelatedByAncestorId relation ObjectIdentity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery A secondary query class using the current class as primary query
     */
    public function useObjectIdentityRelatedByAncestorIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinObjectIdentityRelatedByAncestorId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ObjectIdentityRelatedByAncestorId', '\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildObjectIdentityAncestor $objectIdentityAncestor Object to remove from the list of results
     *
     * @return $this|ChildObjectIdentityAncestorQuery The current query, for fluid interface
     */
    public function prune($objectIdentityAncestor = null)
    {
        if ($objectIdentityAncestor) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ObjectIdentityAncestorTableMap::COL_OBJECT_IDENTITY_ID), $objectIdentityAncestor->getObjectIdentityId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ObjectIdentityAncestorTableMap::COL_ANCESTOR_ID), $objectIdentityAncestor->getAncestorId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the acl_object_identity_ancestors table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ObjectIdentityAncestorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ObjectIdentityAncestorTableMap::clearInstancePool();
            ObjectIdentityAncestorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ObjectIdentityAncestorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ObjectIdentityAncestorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ObjectIdentityAncestorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ObjectIdentityAncestorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ObjectIdentityAncestorQuery
