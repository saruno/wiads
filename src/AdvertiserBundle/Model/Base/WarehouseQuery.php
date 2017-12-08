<?php

namespace AdvertiserBundle\Model\Base;

use \Exception;
use \PDO;
use AdvertiserBundle\Model\Warehouse as ChildWarehouse;
use AdvertiserBundle\Model\WarehouseQuery as ChildWarehouseQuery;
use AdvertiserBundle\Model\Map\WarehouseTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'warehouse' table.
 *
 *
 *
 * @method     ChildWarehouseQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWarehouseQuery orderByEmployeeId($order = Criteria::ASC) Order by the employee_id column
 * @method     ChildWarehouseQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildWarehouseQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildWarehouseQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildWarehouseQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildWarehouseQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildWarehouseQuery groupById() Group by the id column
 * @method     ChildWarehouseQuery groupByEmployeeId() Group by the employee_id column
 * @method     ChildWarehouseQuery groupByName() Group by the name column
 * @method     ChildWarehouseQuery groupByAddress() Group by the address column
 * @method     ChildWarehouseQuery groupByPhone() Group by the phone column
 * @method     ChildWarehouseQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildWarehouseQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildWarehouseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWarehouseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWarehouseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWarehouseQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildWarehouseQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildWarehouseQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildWarehouseQuery leftJoinEmployee($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employee relation
 * @method     ChildWarehouseQuery rightJoinEmployee($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employee relation
 * @method     ChildWarehouseQuery innerJoinEmployee($relationAlias = null) Adds a INNER JOIN clause to the query using the Employee relation
 *
 * @method     ChildWarehouseQuery joinWithEmployee($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employee relation
 *
 * @method     ChildWarehouseQuery leftJoinWithEmployee() Adds a LEFT JOIN clause and with to the query using the Employee relation
 * @method     ChildWarehouseQuery rightJoinWithEmployee() Adds a RIGHT JOIN clause and with to the query using the Employee relation
 * @method     ChildWarehouseQuery innerJoinWithEmployee() Adds a INNER JOIN clause and with to the query using the Employee relation
 *
 * @method     ChildWarehouseQuery leftJoinInventoryReceivingVoucher($relationAlias = null) Adds a LEFT JOIN clause to the query using the InventoryReceivingVoucher relation
 * @method     ChildWarehouseQuery rightJoinInventoryReceivingVoucher($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InventoryReceivingVoucher relation
 * @method     ChildWarehouseQuery innerJoinInventoryReceivingVoucher($relationAlias = null) Adds a INNER JOIN clause to the query using the InventoryReceivingVoucher relation
 *
 * @method     ChildWarehouseQuery joinWithInventoryReceivingVoucher($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the InventoryReceivingVoucher relation
 *
 * @method     ChildWarehouseQuery leftJoinWithInventoryReceivingVoucher() Adds a LEFT JOIN clause and with to the query using the InventoryReceivingVoucher relation
 * @method     ChildWarehouseQuery rightJoinWithInventoryReceivingVoucher() Adds a RIGHT JOIN clause and with to the query using the InventoryReceivingVoucher relation
 * @method     ChildWarehouseQuery innerJoinWithInventoryReceivingVoucher() Adds a INNER JOIN clause and with to the query using the InventoryReceivingVoucher relation
 *
 * @method     ChildWarehouseQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildWarehouseQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildWarehouseQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildWarehouseQuery joinWithProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Product relation
 *
 * @method     ChildWarehouseQuery leftJoinWithProduct() Adds a LEFT JOIN clause and with to the query using the Product relation
 * @method     ChildWarehouseQuery rightJoinWithProduct() Adds a RIGHT JOIN clause and with to the query using the Product relation
 * @method     ChildWarehouseQuery innerJoinWithProduct() Adds a INNER JOIN clause and with to the query using the Product relation
 *
 * @method     ChildWarehouseQuery leftJoinInventoryDeliveryVoucher($relationAlias = null) Adds a LEFT JOIN clause to the query using the InventoryDeliveryVoucher relation
 * @method     ChildWarehouseQuery rightJoinInventoryDeliveryVoucher($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InventoryDeliveryVoucher relation
 * @method     ChildWarehouseQuery innerJoinInventoryDeliveryVoucher($relationAlias = null) Adds a INNER JOIN clause to the query using the InventoryDeliveryVoucher relation
 *
 * @method     ChildWarehouseQuery joinWithInventoryDeliveryVoucher($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the InventoryDeliveryVoucher relation
 *
 * @method     ChildWarehouseQuery leftJoinWithInventoryDeliveryVoucher() Adds a LEFT JOIN clause and with to the query using the InventoryDeliveryVoucher relation
 * @method     ChildWarehouseQuery rightJoinWithInventoryDeliveryVoucher() Adds a RIGHT JOIN clause and with to the query using the InventoryDeliveryVoucher relation
 * @method     ChildWarehouseQuery innerJoinWithInventoryDeliveryVoucher() Adds a INNER JOIN clause and with to the query using the InventoryDeliveryVoucher relation
 *
 * @method     \AdvertiserBundle\Model\EmployeeQuery|\AdvertiserBundle\Model\InventoryReceivingVoucherQuery|\AdvertiserBundle\Model\ProductQuery|\AdvertiserBundle\Model\InventoryDeliveryVoucherQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildWarehouse findOne(ConnectionInterface $con = null) Return the first ChildWarehouse matching the query
 * @method     ChildWarehouse findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWarehouse matching the query, or a new ChildWarehouse object populated from the query conditions when no match is found
 *
 * @method     ChildWarehouse findOneById(int $id) Return the first ChildWarehouse filtered by the id column
 * @method     ChildWarehouse findOneByEmployeeId(int $employee_id) Return the first ChildWarehouse filtered by the employee_id column
 * @method     ChildWarehouse findOneByName(string $name) Return the first ChildWarehouse filtered by the name column
 * @method     ChildWarehouse findOneByAddress(string $address) Return the first ChildWarehouse filtered by the address column
 * @method     ChildWarehouse findOneByPhone(string $phone) Return the first ChildWarehouse filtered by the phone column
 * @method     ChildWarehouse findOneByCreatedAt(string $created_at) Return the first ChildWarehouse filtered by the created_at column
 * @method     ChildWarehouse findOneByUpdatedAt(string $updated_at) Return the first ChildWarehouse filtered by the updated_at column *

 * @method     ChildWarehouse requirePk($key, ConnectionInterface $con = null) Return the ChildWarehouse by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouse requireOne(ConnectionInterface $con = null) Return the first ChildWarehouse matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWarehouse requireOneById(int $id) Return the first ChildWarehouse filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouse requireOneByEmployeeId(int $employee_id) Return the first ChildWarehouse filtered by the employee_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouse requireOneByName(string $name) Return the first ChildWarehouse filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouse requireOneByAddress(string $address) Return the first ChildWarehouse filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouse requireOneByPhone(string $phone) Return the first ChildWarehouse filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouse requireOneByCreatedAt(string $created_at) Return the first ChildWarehouse filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWarehouse requireOneByUpdatedAt(string $updated_at) Return the first ChildWarehouse filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWarehouse[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildWarehouse objects based on current ModelCriteria
 * @method     ChildWarehouse[]|ObjectCollection findById(int $id) Return ChildWarehouse objects filtered by the id column
 * @method     ChildWarehouse[]|ObjectCollection findByEmployeeId(int $employee_id) Return ChildWarehouse objects filtered by the employee_id column
 * @method     ChildWarehouse[]|ObjectCollection findByName(string $name) Return ChildWarehouse objects filtered by the name column
 * @method     ChildWarehouse[]|ObjectCollection findByAddress(string $address) Return ChildWarehouse objects filtered by the address column
 * @method     ChildWarehouse[]|ObjectCollection findByPhone(string $phone) Return ChildWarehouse objects filtered by the phone column
 * @method     ChildWarehouse[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildWarehouse objects filtered by the created_at column
 * @method     ChildWarehouse[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildWarehouse objects filtered by the updated_at column
 * @method     ChildWarehouse[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class WarehouseQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \AdvertiserBundle\Model\Base\WarehouseQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AdvertiserBundle\\Model\\Warehouse', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWarehouseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWarehouseQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildWarehouseQuery) {
            return $criteria;
        }
        $query = new ChildWarehouseQuery();
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
     * @return ChildWarehouse|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WarehouseTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = WarehouseTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildWarehouse A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `employee_id`, `name`, `address`, `phone`, `created_at`, `updated_at` FROM `warehouse` WHERE `id` = :p0';
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
            /** @var ChildWarehouse $obj */
            $obj = new ChildWarehouse();
            $obj->hydrate($row);
            WarehouseTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildWarehouse|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WarehouseTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WarehouseTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(WarehouseTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WarehouseTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WarehouseTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the employee_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEmployeeId(1234); // WHERE employee_id = 1234
     * $query->filterByEmployeeId(array(12, 34)); // WHERE employee_id IN (12, 34)
     * $query->filterByEmployeeId(array('min' => 12)); // WHERE employee_id > 12
     * </code>
     *
     * @see       filterByEmployee()
     *
     * @param     mixed $employeeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByEmployeeId($employeeId = null, $comparison = null)
    {
        if (is_array($employeeId)) {
            $useMinMax = false;
            if (isset($employeeId['min'])) {
                $this->addUsingAlias(WarehouseTableMap::COL_EMPLOYEE_ID, $employeeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeeId['max'])) {
                $this->addUsingAlias(WarehouseTableMap::COL_EMPLOYEE_ID, $employeeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WarehouseTableMap::COL_EMPLOYEE_ID, $employeeId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WarehouseTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%', Criteria::LIKE); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WarehouseTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%', Criteria::LIKE); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WarehouseTableMap::COL_PHONE, $phone, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(WarehouseTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(WarehouseTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WarehouseTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(WarehouseTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(WarehouseTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WarehouseTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \AdvertiserBundle\Model\Employee object
     *
     * @param \AdvertiserBundle\Model\Employee|ObjectCollection $employee The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByEmployee($employee, $comparison = null)
    {
        if ($employee instanceof \AdvertiserBundle\Model\Employee) {
            return $this
                ->addUsingAlias(WarehouseTableMap::COL_EMPLOYEE_ID, $employee->getId(), $comparison);
        } elseif ($employee instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WarehouseTableMap::COL_EMPLOYEE_ID, $employee->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByEmployee() only accepts arguments of type \AdvertiserBundle\Model\Employee or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Employee relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function joinEmployee($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Employee');

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
            $this->addJoinObject($join, 'Employee');
        }

        return $this;
    }

    /**
     * Use the Employee relation Employee object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AdvertiserBundle\Model\EmployeeQuery A secondary query class using the current class as primary query
     */
    public function useEmployeeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEmployee($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Employee', '\AdvertiserBundle\Model\EmployeeQuery');
    }

    /**
     * Filter the query by a related \AdvertiserBundle\Model\InventoryReceivingVoucher object
     *
     * @param \AdvertiserBundle\Model\InventoryReceivingVoucher|ObjectCollection $inventoryReceivingVoucher the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByInventoryReceivingVoucher($inventoryReceivingVoucher, $comparison = null)
    {
        if ($inventoryReceivingVoucher instanceof \AdvertiserBundle\Model\InventoryReceivingVoucher) {
            return $this
                ->addUsingAlias(WarehouseTableMap::COL_ID, $inventoryReceivingVoucher->getWarehouseId(), $comparison);
        } elseif ($inventoryReceivingVoucher instanceof ObjectCollection) {
            return $this
                ->useInventoryReceivingVoucherQuery()
                ->filterByPrimaryKeys($inventoryReceivingVoucher->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInventoryReceivingVoucher() only accepts arguments of type \AdvertiserBundle\Model\InventoryReceivingVoucher or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InventoryReceivingVoucher relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function joinInventoryReceivingVoucher($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InventoryReceivingVoucher');

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
            $this->addJoinObject($join, 'InventoryReceivingVoucher');
        }

        return $this;
    }

    /**
     * Use the InventoryReceivingVoucher relation InventoryReceivingVoucher object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AdvertiserBundle\Model\InventoryReceivingVoucherQuery A secondary query class using the current class as primary query
     */
    public function useInventoryReceivingVoucherQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinInventoryReceivingVoucher($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InventoryReceivingVoucher', '\AdvertiserBundle\Model\InventoryReceivingVoucherQuery');
    }

    /**
     * Filter the query by a related \AdvertiserBundle\Model\Product object
     *
     * @param \AdvertiserBundle\Model\Product|ObjectCollection $product the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \AdvertiserBundle\Model\Product) {
            return $this
                ->addUsingAlias(WarehouseTableMap::COL_ID, $product->getWarehouseId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            return $this
                ->useProductQuery()
                ->filterByPrimaryKeys($product->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type \AdvertiserBundle\Model\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

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
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation Product object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AdvertiserBundle\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\AdvertiserBundle\Model\ProductQuery');
    }

    /**
     * Filter the query by a related \AdvertiserBundle\Model\InventoryDeliveryVoucher object
     *
     * @param \AdvertiserBundle\Model\InventoryDeliveryVoucher|ObjectCollection $inventoryDeliveryVoucher the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWarehouseQuery The current query, for fluid interface
     */
    public function filterByInventoryDeliveryVoucher($inventoryDeliveryVoucher, $comparison = null)
    {
        if ($inventoryDeliveryVoucher instanceof \AdvertiserBundle\Model\InventoryDeliveryVoucher) {
            return $this
                ->addUsingAlias(WarehouseTableMap::COL_ID, $inventoryDeliveryVoucher->getWarehouseId(), $comparison);
        } elseif ($inventoryDeliveryVoucher instanceof ObjectCollection) {
            return $this
                ->useInventoryDeliveryVoucherQuery()
                ->filterByPrimaryKeys($inventoryDeliveryVoucher->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInventoryDeliveryVoucher() only accepts arguments of type \AdvertiserBundle\Model\InventoryDeliveryVoucher or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InventoryDeliveryVoucher relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function joinInventoryDeliveryVoucher($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InventoryDeliveryVoucher');

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
            $this->addJoinObject($join, 'InventoryDeliveryVoucher');
        }

        return $this;
    }

    /**
     * Use the InventoryDeliveryVoucher relation InventoryDeliveryVoucher object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AdvertiserBundle\Model\InventoryDeliveryVoucherQuery A secondary query class using the current class as primary query
     */
    public function useInventoryDeliveryVoucherQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinInventoryDeliveryVoucher($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InventoryDeliveryVoucher', '\AdvertiserBundle\Model\InventoryDeliveryVoucherQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildWarehouse $warehouse Object to remove from the list of results
     *
     * @return $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function prune($warehouse = null)
    {
        if ($warehouse) {
            $this->addUsingAlias(WarehouseTableMap::COL_ID, $warehouse->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the warehouse table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WarehouseTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            WarehouseTableMap::clearInstancePool();
            WarehouseTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(WarehouseTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WarehouseTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            WarehouseTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            WarehouseTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(WarehouseTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(WarehouseTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(WarehouseTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(WarehouseTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(WarehouseTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildWarehouseQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(WarehouseTableMap::COL_CREATED_AT);
    }

} // WarehouseQuery
