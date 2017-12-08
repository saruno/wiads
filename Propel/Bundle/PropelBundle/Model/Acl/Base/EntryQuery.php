<?php

namespace Propel\Bundle\PropelBundle\Model\Acl\Base;

use \Exception;
use \PDO;
use Propel\Bundle\PropelBundle\Model\Acl\Entry as ChildEntry;
use Propel\Bundle\PropelBundle\Model\Acl\EntryQuery as ChildEntryQuery;
use Propel\Bundle\PropelBundle\Model\Acl\Map\EntryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'acl_entries' table.
 *
 *
 *
 * @method     ChildEntryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildEntryQuery orderByClassId($order = Criteria::ASC) Order by the class_id column
 * @method     ChildEntryQuery orderByObjectIdentityId($order = Criteria::ASC) Order by the object_identity_id column
 * @method     ChildEntryQuery orderBySecurityIdentityId($order = Criteria::ASC) Order by the security_identity_id column
 * @method     ChildEntryQuery orderByFieldName($order = Criteria::ASC) Order by the field_name column
 * @method     ChildEntryQuery orderByAceOrder($order = Criteria::ASC) Order by the ace_order column
 * @method     ChildEntryQuery orderByMask($order = Criteria::ASC) Order by the mask column
 * @method     ChildEntryQuery orderByGranting($order = Criteria::ASC) Order by the granting column
 * @method     ChildEntryQuery orderByGrantingStrategy($order = Criteria::ASC) Order by the granting_strategy column
 * @method     ChildEntryQuery orderByAuditSuccess($order = Criteria::ASC) Order by the audit_success column
 * @method     ChildEntryQuery orderByAuditFailure($order = Criteria::ASC) Order by the audit_failure column
 *
 * @method     ChildEntryQuery groupById() Group by the id column
 * @method     ChildEntryQuery groupByClassId() Group by the class_id column
 * @method     ChildEntryQuery groupByObjectIdentityId() Group by the object_identity_id column
 * @method     ChildEntryQuery groupBySecurityIdentityId() Group by the security_identity_id column
 * @method     ChildEntryQuery groupByFieldName() Group by the field_name column
 * @method     ChildEntryQuery groupByAceOrder() Group by the ace_order column
 * @method     ChildEntryQuery groupByMask() Group by the mask column
 * @method     ChildEntryQuery groupByGranting() Group by the granting column
 * @method     ChildEntryQuery groupByGrantingStrategy() Group by the granting_strategy column
 * @method     ChildEntryQuery groupByAuditSuccess() Group by the audit_success column
 * @method     ChildEntryQuery groupByAuditFailure() Group by the audit_failure column
 *
 * @method     ChildEntryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEntryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEntryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEntryQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEntryQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEntryQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEntryQuery leftJoinAclClass($relationAlias = null) Adds a LEFT JOIN clause to the query using the AclClass relation
 * @method     ChildEntryQuery rightJoinAclClass($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AclClass relation
 * @method     ChildEntryQuery innerJoinAclClass($relationAlias = null) Adds a INNER JOIN clause to the query using the AclClass relation
 *
 * @method     ChildEntryQuery joinWithAclClass($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AclClass relation
 *
 * @method     ChildEntryQuery leftJoinWithAclClass() Adds a LEFT JOIN clause and with to the query using the AclClass relation
 * @method     ChildEntryQuery rightJoinWithAclClass() Adds a RIGHT JOIN clause and with to the query using the AclClass relation
 * @method     ChildEntryQuery innerJoinWithAclClass() Adds a INNER JOIN clause and with to the query using the AclClass relation
 *
 * @method     ChildEntryQuery leftJoinObjectIdentity($relationAlias = null) Adds a LEFT JOIN clause to the query using the ObjectIdentity relation
 * @method     ChildEntryQuery rightJoinObjectIdentity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ObjectIdentity relation
 * @method     ChildEntryQuery innerJoinObjectIdentity($relationAlias = null) Adds a INNER JOIN clause to the query using the ObjectIdentity relation
 *
 * @method     ChildEntryQuery joinWithObjectIdentity($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ObjectIdentity relation
 *
 * @method     ChildEntryQuery leftJoinWithObjectIdentity() Adds a LEFT JOIN clause and with to the query using the ObjectIdentity relation
 * @method     ChildEntryQuery rightJoinWithObjectIdentity() Adds a RIGHT JOIN clause and with to the query using the ObjectIdentity relation
 * @method     ChildEntryQuery innerJoinWithObjectIdentity() Adds a INNER JOIN clause and with to the query using the ObjectIdentity relation
 *
 * @method     ChildEntryQuery leftJoinSecurityIdentity($relationAlias = null) Adds a LEFT JOIN clause to the query using the SecurityIdentity relation
 * @method     ChildEntryQuery rightJoinSecurityIdentity($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SecurityIdentity relation
 * @method     ChildEntryQuery innerJoinSecurityIdentity($relationAlias = null) Adds a INNER JOIN clause to the query using the SecurityIdentity relation
 *
 * @method     ChildEntryQuery joinWithSecurityIdentity($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SecurityIdentity relation
 *
 * @method     ChildEntryQuery leftJoinWithSecurityIdentity() Adds a LEFT JOIN clause and with to the query using the SecurityIdentity relation
 * @method     ChildEntryQuery rightJoinWithSecurityIdentity() Adds a RIGHT JOIN clause and with to the query using the SecurityIdentity relation
 * @method     ChildEntryQuery innerJoinWithSecurityIdentity() Adds a INNER JOIN clause and with to the query using the SecurityIdentity relation
 *
 * @method     \Propel\Bundle\PropelBundle\Model\Acl\AclClassQuery|\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery|\Propel\Bundle\PropelBundle\Model\Acl\SecurityIdentityQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEntry findOne(ConnectionInterface $con = null) Return the first ChildEntry matching the query
 * @method     ChildEntry findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEntry matching the query, or a new ChildEntry object populated from the query conditions when no match is found
 *
 * @method     ChildEntry findOneById(int $id) Return the first ChildEntry filtered by the id column
 * @method     ChildEntry findOneByClassId(int $class_id) Return the first ChildEntry filtered by the class_id column
 * @method     ChildEntry findOneByObjectIdentityId(int $object_identity_id) Return the first ChildEntry filtered by the object_identity_id column
 * @method     ChildEntry findOneBySecurityIdentityId(int $security_identity_id) Return the first ChildEntry filtered by the security_identity_id column
 * @method     ChildEntry findOneByFieldName(string $field_name) Return the first ChildEntry filtered by the field_name column
 * @method     ChildEntry findOneByAceOrder(int $ace_order) Return the first ChildEntry filtered by the ace_order column
 * @method     ChildEntry findOneByMask(int $mask) Return the first ChildEntry filtered by the mask column
 * @method     ChildEntry findOneByGranting(boolean $granting) Return the first ChildEntry filtered by the granting column
 * @method     ChildEntry findOneByGrantingStrategy(string $granting_strategy) Return the first ChildEntry filtered by the granting_strategy column
 * @method     ChildEntry findOneByAuditSuccess(boolean $audit_success) Return the first ChildEntry filtered by the audit_success column
 * @method     ChildEntry findOneByAuditFailure(boolean $audit_failure) Return the first ChildEntry filtered by the audit_failure column *

 * @method     ChildEntry requirePk($key, ConnectionInterface $con = null) Return the ChildEntry by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEntry requireOne(ConnectionInterface $con = null) Return the first ChildEntry matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEntry requireOneById(int $id) Return the first ChildEntry filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEntry requireOneByClassId(int $class_id) Return the first ChildEntry filtered by the class_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEntry requireOneByObjectIdentityId(int $object_identity_id) Return the first ChildEntry filtered by the object_identity_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEntry requireOneBySecurityIdentityId(int $security_identity_id) Return the first ChildEntry filtered by the security_identity_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEntry requireOneByFieldName(string $field_name) Return the first ChildEntry filtered by the field_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEntry requireOneByAceOrder(int $ace_order) Return the first ChildEntry filtered by the ace_order column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEntry requireOneByMask(int $mask) Return the first ChildEntry filtered by the mask column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEntry requireOneByGranting(boolean $granting) Return the first ChildEntry filtered by the granting column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEntry requireOneByGrantingStrategy(string $granting_strategy) Return the first ChildEntry filtered by the granting_strategy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEntry requireOneByAuditSuccess(boolean $audit_success) Return the first ChildEntry filtered by the audit_success column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEntry requireOneByAuditFailure(boolean $audit_failure) Return the first ChildEntry filtered by the audit_failure column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEntry[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEntry objects based on current ModelCriteria
 * @method     ChildEntry[]|ObjectCollection findById(int $id) Return ChildEntry objects filtered by the id column
 * @method     ChildEntry[]|ObjectCollection findByClassId(int $class_id) Return ChildEntry objects filtered by the class_id column
 * @method     ChildEntry[]|ObjectCollection findByObjectIdentityId(int $object_identity_id) Return ChildEntry objects filtered by the object_identity_id column
 * @method     ChildEntry[]|ObjectCollection findBySecurityIdentityId(int $security_identity_id) Return ChildEntry objects filtered by the security_identity_id column
 * @method     ChildEntry[]|ObjectCollection findByFieldName(string $field_name) Return ChildEntry objects filtered by the field_name column
 * @method     ChildEntry[]|ObjectCollection findByAceOrder(int $ace_order) Return ChildEntry objects filtered by the ace_order column
 * @method     ChildEntry[]|ObjectCollection findByMask(int $mask) Return ChildEntry objects filtered by the mask column
 * @method     ChildEntry[]|ObjectCollection findByGranting(boolean $granting) Return ChildEntry objects filtered by the granting column
 * @method     ChildEntry[]|ObjectCollection findByGrantingStrategy(string $granting_strategy) Return ChildEntry objects filtered by the granting_strategy column
 * @method     ChildEntry[]|ObjectCollection findByAuditSuccess(boolean $audit_success) Return ChildEntry objects filtered by the audit_success column
 * @method     ChildEntry[]|ObjectCollection findByAuditFailure(boolean $audit_failure) Return ChildEntry objects filtered by the audit_failure column
 * @method     ChildEntry[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EntryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Propel\Bundle\PropelBundle\Model\Acl\Base\EntryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Propel\\Bundle\\PropelBundle\\Model\\Acl\\Entry', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEntryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEntryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEntryQuery) {
            return $criteria;
        }
        $query = new ChildEntryQuery();
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
     * @return ChildEntry|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EntryTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = EntryTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildEntry A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, class_id, object_identity_id, security_identity_id, field_name, ace_order, mask, granting, granting_strategy, audit_success, audit_failure FROM acl_entries WHERE id = :p0';
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
            /** @var ChildEntry $obj */
            $obj = new ChildEntry();
            $obj->hydrate($row);
            EntryTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildEntry|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EntryTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EntryTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(EntryTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(EntryTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EntryTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterByClassId($classId = null, $comparison = null)
    {
        if (is_array($classId)) {
            $useMinMax = false;
            if (isset($classId['min'])) {
                $this->addUsingAlias(EntryTableMap::COL_CLASS_ID, $classId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($classId['max'])) {
                $this->addUsingAlias(EntryTableMap::COL_CLASS_ID, $classId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EntryTableMap::COL_CLASS_ID, $classId, $comparison);
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
     * @see       filterByObjectIdentity()
     *
     * @param     mixed $objectIdentityId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterByObjectIdentityId($objectIdentityId = null, $comparison = null)
    {
        if (is_array($objectIdentityId)) {
            $useMinMax = false;
            if (isset($objectIdentityId['min'])) {
                $this->addUsingAlias(EntryTableMap::COL_OBJECT_IDENTITY_ID, $objectIdentityId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objectIdentityId['max'])) {
                $this->addUsingAlias(EntryTableMap::COL_OBJECT_IDENTITY_ID, $objectIdentityId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EntryTableMap::COL_OBJECT_IDENTITY_ID, $objectIdentityId, $comparison);
    }

    /**
     * Filter the query on the security_identity_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySecurityIdentityId(1234); // WHERE security_identity_id = 1234
     * $query->filterBySecurityIdentityId(array(12, 34)); // WHERE security_identity_id IN (12, 34)
     * $query->filterBySecurityIdentityId(array('min' => 12)); // WHERE security_identity_id > 12
     * </code>
     *
     * @see       filterBySecurityIdentity()
     *
     * @param     mixed $securityIdentityId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterBySecurityIdentityId($securityIdentityId = null, $comparison = null)
    {
        if (is_array($securityIdentityId)) {
            $useMinMax = false;
            if (isset($securityIdentityId['min'])) {
                $this->addUsingAlias(EntryTableMap::COL_SECURITY_IDENTITY_ID, $securityIdentityId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($securityIdentityId['max'])) {
                $this->addUsingAlias(EntryTableMap::COL_SECURITY_IDENTITY_ID, $securityIdentityId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EntryTableMap::COL_SECURITY_IDENTITY_ID, $securityIdentityId, $comparison);
    }

    /**
     * Filter the query on the field_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldName('fooValue');   // WHERE field_name = 'fooValue'
     * $query->filterByFieldName('%fooValue%', Criteria::LIKE); // WHERE field_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fieldName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterByFieldName($fieldName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fieldName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EntryTableMap::COL_FIELD_NAME, $fieldName, $comparison);
    }

    /**
     * Filter the query on the ace_order column
     *
     * Example usage:
     * <code>
     * $query->filterByAceOrder(1234); // WHERE ace_order = 1234
     * $query->filterByAceOrder(array(12, 34)); // WHERE ace_order IN (12, 34)
     * $query->filterByAceOrder(array('min' => 12)); // WHERE ace_order > 12
     * </code>
     *
     * @param     mixed $aceOrder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterByAceOrder($aceOrder = null, $comparison = null)
    {
        if (is_array($aceOrder)) {
            $useMinMax = false;
            if (isset($aceOrder['min'])) {
                $this->addUsingAlias(EntryTableMap::COL_ACE_ORDER, $aceOrder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($aceOrder['max'])) {
                $this->addUsingAlias(EntryTableMap::COL_ACE_ORDER, $aceOrder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EntryTableMap::COL_ACE_ORDER, $aceOrder, $comparison);
    }

    /**
     * Filter the query on the mask column
     *
     * Example usage:
     * <code>
     * $query->filterByMask(1234); // WHERE mask = 1234
     * $query->filterByMask(array(12, 34)); // WHERE mask IN (12, 34)
     * $query->filterByMask(array('min' => 12)); // WHERE mask > 12
     * </code>
     *
     * @param     mixed $mask The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterByMask($mask = null, $comparison = null)
    {
        if (is_array($mask)) {
            $useMinMax = false;
            if (isset($mask['min'])) {
                $this->addUsingAlias(EntryTableMap::COL_MASK, $mask['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mask['max'])) {
                $this->addUsingAlias(EntryTableMap::COL_MASK, $mask['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EntryTableMap::COL_MASK, $mask, $comparison);
    }

    /**
     * Filter the query on the granting column
     *
     * Example usage:
     * <code>
     * $query->filterByGranting(true); // WHERE granting = true
     * $query->filterByGranting('yes'); // WHERE granting = true
     * </code>
     *
     * @param     boolean|string $granting The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterByGranting($granting = null, $comparison = null)
    {
        if (is_string($granting)) {
            $granting = in_array(strtolower($granting), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(EntryTableMap::COL_GRANTING, $granting, $comparison);
    }

    /**
     * Filter the query on the granting_strategy column
     *
     * Example usage:
     * <code>
     * $query->filterByGrantingStrategy('fooValue');   // WHERE granting_strategy = 'fooValue'
     * $query->filterByGrantingStrategy('%fooValue%', Criteria::LIKE); // WHERE granting_strategy LIKE '%fooValue%'
     * </code>
     *
     * @param     string $grantingStrategy The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterByGrantingStrategy($grantingStrategy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($grantingStrategy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EntryTableMap::COL_GRANTING_STRATEGY, $grantingStrategy, $comparison);
    }

    /**
     * Filter the query on the audit_success column
     *
     * Example usage:
     * <code>
     * $query->filterByAuditSuccess(true); // WHERE audit_success = true
     * $query->filterByAuditSuccess('yes'); // WHERE audit_success = true
     * </code>
     *
     * @param     boolean|string $auditSuccess The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterByAuditSuccess($auditSuccess = null, $comparison = null)
    {
        if (is_string($auditSuccess)) {
            $auditSuccess = in_array(strtolower($auditSuccess), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(EntryTableMap::COL_AUDIT_SUCCESS, $auditSuccess, $comparison);
    }

    /**
     * Filter the query on the audit_failure column
     *
     * Example usage:
     * <code>
     * $query->filterByAuditFailure(true); // WHERE audit_failure = true
     * $query->filterByAuditFailure('yes'); // WHERE audit_failure = true
     * </code>
     *
     * @param     boolean|string $auditFailure The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function filterByAuditFailure($auditFailure = null, $comparison = null)
    {
        if (is_string($auditFailure)) {
            $auditFailure = in_array(strtolower($auditFailure), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(EntryTableMap::COL_AUDIT_FAILURE, $auditFailure, $comparison);
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\AclClass object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\AclClass|ObjectCollection $aclClass The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEntryQuery The current query, for fluid interface
     */
    public function filterByAclClass($aclClass, $comparison = null)
    {
        if ($aclClass instanceof \Propel\Bundle\PropelBundle\Model\Acl\AclClass) {
            return $this
                ->addUsingAlias(EntryTableMap::COL_CLASS_ID, $aclClass->getId(), $comparison);
        } elseif ($aclClass instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EntryTableMap::COL_CLASS_ID, $aclClass->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildEntryQuery The current query, for fluid interface
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
     * @return ChildEntryQuery The current query, for fluid interface
     */
    public function filterByObjectIdentity($objectIdentity, $comparison = null)
    {
        if ($objectIdentity instanceof \Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentity) {
            return $this
                ->addUsingAlias(EntryTableMap::COL_OBJECT_IDENTITY_ID, $objectIdentity->getId(), $comparison);
        } elseif ($objectIdentity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EntryTableMap::COL_OBJECT_IDENTITY_ID, $objectIdentity->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function joinObjectIdentity($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useObjectIdentityQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinObjectIdentity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ObjectIdentity', '\Propel\Bundle\PropelBundle\Model\Acl\ObjectIdentityQuery');
    }

    /**
     * Filter the query by a related \Propel\Bundle\PropelBundle\Model\Acl\SecurityIdentity object
     *
     * @param \Propel\Bundle\PropelBundle\Model\Acl\SecurityIdentity|ObjectCollection $securityIdentity The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEntryQuery The current query, for fluid interface
     */
    public function filterBySecurityIdentity($securityIdentity, $comparison = null)
    {
        if ($securityIdentity instanceof \Propel\Bundle\PropelBundle\Model\Acl\SecurityIdentity) {
            return $this
                ->addUsingAlias(EntryTableMap::COL_SECURITY_IDENTITY_ID, $securityIdentity->getId(), $comparison);
        } elseif ($securityIdentity instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EntryTableMap::COL_SECURITY_IDENTITY_ID, $securityIdentity->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySecurityIdentity() only accepts arguments of type \Propel\Bundle\PropelBundle\Model\Acl\SecurityIdentity or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SecurityIdentity relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function joinSecurityIdentity($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SecurityIdentity');

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
            $this->addJoinObject($join, 'SecurityIdentity');
        }

        return $this;
    }

    /**
     * Use the SecurityIdentity relation SecurityIdentity object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Propel\Bundle\PropelBundle\Model\Acl\SecurityIdentityQuery A secondary query class using the current class as primary query
     */
    public function useSecurityIdentityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSecurityIdentity($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SecurityIdentity', '\Propel\Bundle\PropelBundle\Model\Acl\SecurityIdentityQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEntry $entry Object to remove from the list of results
     *
     * @return $this|ChildEntryQuery The current query, for fluid interface
     */
    public function prune($entry = null)
    {
        if ($entry) {
            $this->addUsingAlias(EntryTableMap::COL_ID, $entry->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the acl_entries table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EntryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EntryTableMap::clearInstancePool();
            EntryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EntryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EntryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EntryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EntryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EntryQuery
