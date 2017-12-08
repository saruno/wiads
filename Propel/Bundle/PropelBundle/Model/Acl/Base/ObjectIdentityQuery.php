<?php

namespace Propel\Bundle\PropelBundle\Model\Acl\Base;

use \Exception;
use \PDO;
use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity as ChildObjectIdentity;
use Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery as ChildObjectIdentityQuery;
use Propel\Bundle\PropelBundle\Model\Acl\Map\ObjectIdentityTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'acl_object_identities' table.
 *
 *
 *
 * @method     ChildObjectIdentityQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildObjectIdentityQuery orderByClassId($order = Criteria::ASC) Order by the class_id column
 * @method     ChildObjectIdentityQuery orderByIdentifier($order = Criteria::ASC) Order by the object_identifier column
 * @method     ChildObjectIdentityQuery orderByParentObjectIdentityId($order = Criteria::ASC) Order by the parent_object_identity_id column
 * @method     ChildObjectIdentityQuery orderByEntriesInheriting($order = Criteria::ASC) Order by the entries_inheriting column
 *
 * @method     ChildObjectIdentityQuery groupById() Group by the id column
 * @method     ChildObjectIdentityQuery groupByClassId() Group by the class_id column
 * @method     ChildObjectIdentityQuery groupByIdentifier() Group by the object_identifier column
 * @method     ChildObjectIdentityQuery groupByParentObjectIdentityId() Group by the parent_object_identity_id column
 * @method     ChildObjectIdentityQuery groupByEntriesInheriting() Group by the entries_inheriting column
 *
 * @method     ChildObjectIdentityQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildObjectIdentityQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildObjectIdentityQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildObjectIdentityQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildObjectIdentityQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildObjectIdentityQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildObjectIdentityQuery leftJoinAclClass($relationAlias = null) Adds a LEFT JOIN clause to the query using the AclClass relation
 * @method     ChildObjectIdentityQuery rightJoinAclClass($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AclClass relation
 * @method     ChildObjectIdentityQuery innerJoinAclClass($relationAlias = null) Adds a INNER JOIN clause to the query using the AclClass relation
 *
 * @method     ChildObjectIdentityQuery joinWithAclClass($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AclClass relation
 *
 * @method     ChildObjectIdentityQuery leftJoinWithAclClass() Adds a LEFT JOIN clause and with to the query using the AclClass relation
 * @method     ChildObjectIdentityQuery rightJoinWithAclClass() Adds a RIGHT JOIN clause and with to the query using the AclClass relation
 * @method     ChildObjectIdentityQuery innerJoinWithAclClass() Adds a INNER JOIN clause and with to the query using the AclClass relation
 *
 * @method     ChildObjectIdentityQuery leftJoinObjectIdentityRelatedByParentObjectIdentityId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ObjectIdentityRelatedByParentObjectIdentityId relation
 * @method     ChildObjectIdentityQuery rightJoinObjectIdentityRelatedByParentObjectIdentityId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ObjectIdentityRelatedByParentObjectIdentityId relation
 * @method     ChildObjectIdentityQuery innerJoinObjectIdentityRelatedByParentObjectIdentityId($relationAlias = null) Adds a INNER JOIN clause to the query using the ObjectIdentityRelatedByParentObjectIdentityId relation
 *
 * @method     ChildObjectIdentityQuery joinWithObjectIdentityRelatedByParentObjectIdentityId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ObjectIdentityRelatedByParentObjectIdentityId relation
 *
 * @method     ChildObjectIdentityQuery leftJoinWithObjectIdentityRelatedByParentObjectIdentityId() Adds a LEFT JOIN clause and with to the query using the ObjectIdentityRelatedByParentObjectIdentityId relation
 * @method     ChildObjectIdentityQuery rightJoinWithObjectIdentityRelatedByParentObjectIdentityId() Adds a RIGHT JOIN clause and with to the query using the ObjectIdentityRelatedByParentObjectIdentityId relation
 * @method     ChildObjectIdentityQuery innerJoinWithObjectIdentityRelatedByParentObjectIdentityId() Adds a INNER JOIN clause and with to the query using the ObjectIdentityRelatedByParentObjectIdentityId relation
 *
 * @method     ChildObjectIdentityQuery leftJoinObjectIdentityRelatedById($relationAlias = null) Adds a LEFT JOIN clause to the query using the ObjectIdentityRelatedById relation
 * @method     ChildObjectIdentityQuery rightJoinObjectIdentityRelatedById($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ObjectIdentityRelatedById relation
 * @method     ChildObjectIdentityQuery innerJoinObjectIdentityRelatedById($relationAlias = null) Adds a INNER JOIN clause to the query using the ObjectIdentityRelatedById relation
 *
 * @method     ChildObjectIdentityQuery joinWithObjectIdentityRelatedById($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ObjectIdentityRelatedById relation
 *
 * @method     ChildObjectIdentityQuery leftJoinWithObjectIdentityRelatedById() Adds a LEFT JOIN clause and with to the query using the ObjectIdentityRelatedById relation
 * @method     ChildObjectIdentityQuery rightJoinWithObjectIdentityRelatedById() Adds a RIGHT JOIN clause and with to the query using the ObjectIdentityRelatedById relation
 * @method     ChildObjectIdentityQuery innerJoinWithObjectIdentityRelatedById() Adds a INNER JOIN clause and with to the query using the ObjectIdentityRelatedById relation
 *
 * @method     ChildObjectIdentityQuery leftJoinObjectIdentityAncestorRelatedByObjectIdentityId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ObjectIdentityAncestorRelatedByObjectIdentityId relation
 * @method     ChildObjectIdentityQuery rightJoinObjectIdentityAncestorRelatedByObjectIdentityId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ObjectIdentityAncestorRelatedByObjectIdentityId relation
 * @method     ChildObjectIdentityQuery innerJoinObjectIdentityAncestorRelatedByObjectIdentityId($relationAlias = null) Adds a INNER JOIN clause to the query using the ObjectIdentityAncestorRelatedByObjectIdentityId relation
 *
 * @method     ChildObjectIdentityQuery joinWithObjectIdentityAncestorRelatedByObjectIdentityId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ObjectIdentityAncestorRelatedByObjectIdentityId relation
 *
 * @method     ChildObjectIdentityQuery leftJoinWithObjectIdentityAncestorRelatedByObjectIdentityId() Adds a LEFT JOIN clause and with to the query using the ObjectIdentityAncestorRelatedByObjectIdentityId relation
 * @method     ChildObjectIdentityQuery rightJoinWithObjectIdentityAncestorRelatedByObjectIdentityId() Adds a RIGHT JOIN clause and with to the query using the ObjectIdentityAncestorRelatedByObjectIdentityId relation
 * @method     ChildObjectIdentityQuery innerJoinWithObjectIdentityAncestorRelatedByObjectIdentityId() Adds a INNER JOIN clause and with to the query using the ObjectIdentityAncestorRelatedByObjectIdentityId relation
 *
 * @method     ChildObjectIdentityQuery leftJoinObjectIdentityAncestorRelatedByAncestorId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ObjectIdentityAncestorRelatedByAncestorId relation
 * @method     ChildObjectIdentityQuery rightJoinObjectIdentityAncestorRelatedByAncestorId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ObjectIdentityAncestorRelatedByAncestorId relation
 * @method     ChildObjectIdentityQuery innerJoinObjectIdentityAncestorRelatedByAncestorId($relationAlias = null) Adds a INNER JOIN clause to the query using the ObjectIdentityAncestorRelatedByAncestorId relation
 *
 * @method     ChildObjectIdentityQuery joinWithObjectIdentityAncestorRelatedByAncestorId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ObjectIdentityAncestorRelatedByAncestorId relation
 *
 * @method     ChildObjectIdentityQuery leftJoinWithObjectIdentityAncestorRelatedByAncestorId() Adds a LEFT JOIN clause and with to the query using the ObjectIdentityAncestorRelatedByAncestorId relation
 * @method     ChildObjectIdentityQuery rightJoinWithObjectIdentityAncestorRelatedByAncestorId() Adds a RIGHT JOIN clause and with to the query using the ObjectIdentityAncestorRelatedByAncestorId relation
 * @method     ChildObjectIdentityQuery innerJoinWithObjectIdentityAncestorRelatedByAncestorId() Adds a INNER JOIN clause and with to the query using the ObjectIdentityAncestorRelatedByAncestorId relation
 *
 * @method     ChildObjectIdentityQuery leftJoinEntry($relationAlias = null) Adds a LEFT JOIN clause to the query using the Entry relation
 * @method     ChildObjectIdentityQuery rightJoinEntry($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Entry relation
 * @method     ChildObjectIdentityQuery innerJoinEntry($relationAlias = null) Adds a INNER JOIN clause to the query using the Entry relation
 *
 * @method     ChildObjectIdentityQuery joinWithEntry($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Entry relation
 *
 * @method     ChildObjectIdentityQuery leftJoinWithEntry() Adds a LEFT JOIN clause and with to the query using the Entry relation
 * @method     ChildObjectIdentityQuery rightJoinWithEntry() Adds a RIGHT JOIN clause and with to the query using the Entry relation
 * @method     ChildObjectIdentityQuery innerJoinWithEntry() Adds a INNER JOIN clause and with to the query using the Entry relation
 *
 * @method     \Propel\Bundle\PropelBundle\Model\Acl\AclClassQuery|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestorQuery|\Propel\Bundle\PropelBundle\Model\Acl\EntryQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildObjectIdentity findOne(ConnectionInterface $con = null) Return the first ChildObjectIdentity matching the query
 * @method     ChildObjectIdentity findOneOrCreate(ConnectionInterface $con = null) Return the first ChildObjectIdentity matching the query, or a new ChildObjectIdentity object populated from the query conditions when no match is found
 *
 * @method     ChildObjectIdentity findOneById(int $id) Return the first ChildObjectIdentity filtered by the id column
 * @method     ChildObjectIdentity findOneByClassId(int $class_id) Return the first ChildObjectIdentity filtered by the class_id column
 * @method     ChildObjectIdentity findOneByIdentifier(string $object_identifier) Return the first ChildObjectIdentity filtered by the object_identifier column
 * @method     ChildObjectIdentity findOneByParentObjectIdentityId(int $parent_object_identity_id) Return the first ChildObjectIdentity filtered by the parent_object_identity_id column
 * @method     ChildObjectIdentity findOneByEntriesInheriting(boolean $entries_inheriting) Return the first ChildObjectIdentity filtered by the entries_inheriting column *

 * @method     ChildObjectIdentity requirePk($key, ConnectionInterface $con = null) Return the ChildObjectIdentity by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildObjectIdentity requireOne(ConnectionInterface $con = null) Return the first ChildObjectIdentity matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildObjectIdentity requireOneById(int $id) Return the first ChildObjectIdentity filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildObjectIdentity requireOneByClassId(int $class_id) Return the first ChildObjectIdentity filtered by the class_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildObjectIdentity requireOneByIdentifier(string $object_identifier) Return the first ChildObjectIdentity filtered by the object_identifier column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildObjectIdentity requireOneByParentObjectIdentityId(int $parent_object_identity_id) Return the first ChildObjectIdentity filtered by the parent_object_identity_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildObjectIdentity requireOneByEntriesInheriting(boolean $entries_inheriting) Return the first ChildObjectIdentity filtered by the entries_inheriting column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildObjectIdentity[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildObjectIdentity objects based on current ModelCriteria
 * @method     ChildObjectIdentity[]|ObjectCollection findById(int $id) Return ChildObjectIdentity objects filtered by the id column
 * @method     ChildObjectIdentity[]|ObjectCollection findByClassId(int $class_id) Return ChildObjectIdentity objects filtered by the class_id column
 * @method     ChildObjectIdentity[]|ObjectCollection findByIdentifier(string $object_identifier) Return ChildObjectIdentity objects filtered by the object_identifier column
 * @method     ChildObjectIdentity[]|ObjectCollection findByParentObjectIdentityId(int $parent_object_identity_id) Return ChildObjectIdentity objects filtered by the parent_object_identity_id column
 * @method     ChildObjectIdentity[]|ObjectCollection findByEntriesInheriting(boolean $entries_inheriting) Return ChildObjectIdentity objects filtered by the entries_inheriting column
 * @method     ChildObjectIdentity[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ObjectIdentityQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Bundle\PropelBundle\Model\Acl\Base\ObjectIdentityQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\ObjectIdentity', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildObjectIdentityQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildObjectIdentityQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildObjectIdentityQuery) {
            return $criteria;
        }
        $query = new ChildObjectIdentityQuery();
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
     * @return ChildObjectIdentity|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ObjectIdentityTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ObjectIdentityTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildObjectIdentity A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, class_id, object_identifier, parent_object_identity_id, entries_inheriting FROM acl_object_identities WHERE id = :p0';
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
            /** @var ChildObjectIdentity $obj */
            $obj = new ChildObjectIdentity();
            $obj->hydrate($row);
            ObjectIdentityTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildObjectIdentity|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ObjectIdentityTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ObjectIdentityTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ObjectIdentityTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ObjectIdentityTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ObjectIdentityTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the class_id column
     *
     * Example usage:
     * <code>
     * $query->filterByClassId(1234); // WHERE class_id = 1234
     * $query->filterByClassId(array(12, 34)); // WHERE class_id IN (12, 34)
     * $query->filterByClassId(array('min' => 12)); // WHERE class_id > 12
     * </code>
     *
     * @see       filterByAclClass()
     *
     * @param     mixed $classId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByClassId($classId = null, $comparison = null)
    {
        if (is_array($classId)) {
            $useMinMax = false;
            if (isset($classId['min'])) {
                $this->addUsingAlias(ObjectIdentityTableMap::COL_CLASS_ID, $classId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($classId['max'])) {
                $this->addUsingAlias(ObjectIdentityTableMap::COL_CLASS_ID, $classId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ObjectIdentityTableMap::COL_CLASS_ID, $classId, $comparison);
    }

    /**
     * Filter the query on the object_identifier column
     *
     * Example usage:
     * <code>
     * $query->filterByIdentifier('fooValue');   // WHERE object_identifier = 'fooValue'
     * $query->filterByIdentifier('%fooValue%', Criteria::LIKE); // WHERE object_identifier LIKE '%fooValue%'
     * </code>
     *
     * @param     string $identifier The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByIdentifier($identifier = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($identifier)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ObjectIdentityTableMap::COL_OBJECT_IDENTIFIER, $identifier, $comparison);
    }

    /**
     * Filter the query on the parent_object_identity_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParentObjectIdentityId(1234); // WHERE parent_object_identity_id = 1234
     * $query->filterByParentObjectIdentityId(array(12, 34)); // WHERE parent_object_identity_id IN (12, 34)
     * $query->filterByParentObjectIdentityId(array('min' => 12)); // WHERE parent_object_identity_id > 12
     * </code>
     *
     * @see       filterByObjectIdentityRelatedByParentObjectIdentityId()
     *
     * @param     mixed $parentObjectIdentityId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByParentObjectIdentityId($parentObjectIdentityId = null, $comparison = null)
    {
        if (is_array($parentObjectIdentityId)) {
            $useMinMax = false;
            if (isset($parentObjectIdentityId['min'])) {
                $this->addUsingAlias(ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID, $parentObjectIdentityId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentObjectIdentityId['max'])) {
                $this->addUsingAlias(ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID, $parentObjectIdentityId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID, $parentObjectIdentityId, $comparison);
    }

    /**
     * Filter the query on the entries_inheriting column
     *
     * Example usage:
     * <code>
     * $query->filterByEntriesInheriting(true); // WHERE entries_inheriting = true
     * $query->filterByEntriesInheriting('yes'); // WHERE entries_inheriting = true
     * </code>
     *
     * @param     boolean|string $entriesInheriting The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByEntriesInheriting($entriesInheriting = null, $comparison = null)
    {
        if (is_string($entriesInheriting)) {
            $entriesInheriting = in_array(strtolower($entriesInheriting), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ObjectIdentityTableMap::COL_ENTRIES_INHERITING, $entriesInheriting, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\AclClass object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\AclClass|ObjectCollection $aclClass The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByAclClass($aclClass, $comparison = null)
    {
        if ($aclClass instanceof \Propel\Bundle\PropelBundle\Model\Acl\AclClass) {
            return $this
                ->addUsingAlias(ObjectIdentityTableMap::COL_CLASS_ID, $aclClass->getId(), $comparison);
        } elseif ($aclClass instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ObjectIdentityTableMap::COL_CLASS_ID, $aclClass->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAclClass() only accepts arguments of type \Propel\Bundle\PropelBundle\Model\Acl\AclClass or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AclClass relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function joinAclClass($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AclClass');

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
            $this->addJoinObject($join, 'AclClass');
        }

        return $this;
    }

    /**
     * Use the AclClass relation AclClass object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Bundle\PropelBundle\Model\Acl\AclClassQuery A secondary query class using the current class as primary query
     */
    public function useAclClassQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAclClass($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AclClass', '\Propel\Bundle\PropelBundle\Model\Acl\AclClassQuery');
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity|ObjectCollection $objectIdentity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByObjectIdentityRelatedByParentObjectIdentityId($objectIdentity, $comparison = null)
    {
        if ($objectIdentity instanceof \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity) {
            return $this
                ->addUsingAlias(ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID, $objectIdentity->getId(), $comparison);
        } elseif ($objectIdentity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ObjectIdentityTableMap::COL_PARENT_OBJECT_IDENTITY_ID, $objectIdentity->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByObjectIdentityRelatedByParentObjectIdentityId() only accepts arguments of type \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ObjectIdentityRelatedByParentObjectIdentityId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function joinObjectIdentityRelatedByParentObjectIdentityId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ObjectIdentityRelatedByParentObjectIdentityId');

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
            $this->addJoinObject($join, 'ObjectIdentityRelatedByParentObjectIdentityId');
        }

        return $this;
    }

    /**
     * Use the ObjectIdentityRelatedByParentObjectIdentityId relation ObjectIdentity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery A secondary query class using the current class as primary query
     */
    public function useObjectIdentityRelatedByParentObjectIdentityIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinObjectIdentityRelatedByParentObjectIdentityId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ObjectIdentityRelatedByParentObjectIdentityId', '\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery');
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity|ObjectCollection $objectIdentity the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByObjectIdentityRelatedById($objectIdentity, $comparison = null)
    {
        if ($objectIdentity instanceof \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity) {
            return $this
                ->addUsingAlias(ObjectIdentityTableMap::COL_ID, $objectIdentity->getParentObjectIdentityId(), $comparison);
        } elseif ($objectIdentity instanceof ObjectCollection) {
            return $this
                ->useObjectIdentityRelatedByIdQuery()
                ->filterByPrimaryKeys($objectIdentity->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByObjectIdentityRelatedById() only accepts arguments of type \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ObjectIdentityRelatedById relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function joinObjectIdentityRelatedById($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ObjectIdentityRelatedById');

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
            $this->addJoinObject($join, 'ObjectIdentityRelatedById');
        }

        return $this;
    }

    /**
     * Use the ObjectIdentityRelatedById relation ObjectIdentity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery A secondary query class using the current class as primary query
     */
    public function useObjectIdentityRelatedByIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinObjectIdentityRelatedById($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ObjectIdentityRelatedById', '\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery');
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor|ObjectCollection $objectIdentityAncestor the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByObjectIdentityAncestorRelatedByObjectIdentityId($objectIdentityAncestor, $comparison = null)
    {
        if ($objectIdentityAncestor instanceof \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor) {
            return $this
                ->addUsingAlias(ObjectIdentityTableMap::COL_ID, $objectIdentityAncestor->getObjectIdentityId(), $comparison);
        } elseif ($objectIdentityAncestor instanceof ObjectCollection) {
            return $this
                ->useObjectIdentityAncestorRelatedByObjectIdentityIdQuery()
                ->filterByPrimaryKeys($objectIdentityAncestor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByObjectIdentityAncestorRelatedByObjectIdentityId() only accepts arguments of type \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ObjectIdentityAncestorRelatedByObjectIdentityId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function joinObjectIdentityAncestorRelatedByObjectIdentityId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ObjectIdentityAncestorRelatedByObjectIdentityId');

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
            $this->addJoinObject($join, 'ObjectIdentityAncestorRelatedByObjectIdentityId');
        }

        return $this;
    }

    /**
     * Use the ObjectIdentityAncestorRelatedByObjectIdentityId relation ObjectIdentityAncestor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestorQuery A secondary query class using the current class as primary query
     */
    public function useObjectIdentityAncestorRelatedByObjectIdentityIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinObjectIdentityAncestorRelatedByObjectIdentityId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ObjectIdentityAncestorRelatedByObjectIdentityId', '\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestorQuery');
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor|ObjectCollection $objectIdentityAncestor the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByObjectIdentityAncestorRelatedByAncestorId($objectIdentityAncestor, $comparison = null)
    {
        if ($objectIdentityAncestor instanceof \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor) {
            return $this
                ->addUsingAlias(ObjectIdentityTableMap::COL_ID, $objectIdentityAncestor->getAncestorId(), $comparison);
        } elseif ($objectIdentityAncestor instanceof ObjectCollection) {
            return $this
                ->useObjectIdentityAncestorRelatedByAncestorIdQuery()
                ->filterByPrimaryKeys($objectIdentityAncestor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByObjectIdentityAncestorRelatedByAncestorId() only accepts arguments of type \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ObjectIdentityAncestorRelatedByAncestorId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function joinObjectIdentityAncestorRelatedByAncestorId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ObjectIdentityAncestorRelatedByAncestorId');

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
            $this->addJoinObject($join, 'ObjectIdentityAncestorRelatedByAncestorId');
        }

        return $this;
    }

    /**
     * Use the ObjectIdentityAncestorRelatedByAncestorId relation ObjectIdentityAncestor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestorQuery A secondary query class using the current class as primary query
     */
    public function useObjectIdentityAncestorRelatedByAncestorIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinObjectIdentityAncestorRelatedByAncestorId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ObjectIdentityAncestorRelatedByAncestorId', '\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityAncestorQuery');
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\Entry object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\Entry|ObjectCollection $entry the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function filterByEntry($entry, $comparison = null)
    {
        if ($entry instanceof \Propel\Bundle\PropelBundle\Model\Acl\Entry) {
            return $this
                ->addUsingAlias(ObjectIdentityTableMap::COL_ID, $entry->getObjectIdentityId(), $comparison);
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
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function joinEntry($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useEntryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEntry($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Entry', '\Propel\Bundle\PropelBundle\Model\Acl\EntryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildObjectIdentity $objectIdentity Object to remove from the list of results
     *
     * @return $this|ChildObjectIdentityQuery The current query, for fluid interface
     */
    public function prune($objectIdentity = null)
    {
        if ($objectIdentity) {
            $this->addUsingAlias(ObjectIdentityTableMap::COL_ID, $objectIdentity->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the acl_object_identities table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ObjectIdentityTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ObjectIdentityTableMap::clearInstancePool();
            ObjectIdentityTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ObjectIdentityTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ObjectIdentityTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ObjectIdentityTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ObjectIdentityTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ObjectIdentityQuery
