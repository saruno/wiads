<?php

namespace AdvertiserBundle\Model\Base;

use \Exception;
use \PDO;
use AdvertiserBundle\Model\InventoryDeliveryVoucher as ChildInventoryDeliveryVoucher;
use AdvertiserBundle\Model\InventoryDeliveryVoucherQuery as ChildInventoryDeliveryVoucherQuery;
use AdvertiserBundle\Model\Map\InventoryDeliveryVoucherTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'inventory_delivery_voucher' table.
 *
 *
 *
 * @method     ChildInventoryDeliveryVoucherQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildInventoryDeliveryVoucherQuery orderByWarehouseId($order = Criteria::ASC) Order by the warehouse_id column
 * @method     ChildInventoryDeliveryVoucherQuery orderByEmployeeId($order = Criteria::ASC) Order by the employee_id column
 * @method     ChildInventoryDeliveryVoucherQuery orderByCustomerId($order = Criteria::ASC) Order by the customer_id column
 * @method     ChildInventoryDeliveryVoucherQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildInventoryDeliveryVoucherQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildInventoryDeliveryVoucherQuery groupById() Group by the id column
 * @method     ChildInventoryDeliveryVoucherQuery groupByWarehouseId() Group by the warehouse_id column
 * @method     ChildInventoryDeliveryVoucherQuery groupByEmployeeId() Group by the employee_id column
 * @method     ChildInventoryDeliveryVoucherQuery groupByCustomerId() Group by the customer_id column
 * @method     ChildInventoryDeliveryVoucherQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildInventoryDeliveryVoucherQuery groupByDescription() Group by the description column
 *
 * @method     ChildInventoryDeliveryVoucherQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInventoryDeliveryVoucherQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInventoryDeliveryVoucherQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInventoryDeliveryVoucherQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildInventoryDeliveryVoucherQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildInventoryDeliveryVoucherQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildInventoryDeliveryVoucherQuery leftJoinWarehouse($relationAlias = null) Adds a LEFT JOIN clause to the query using the Warehouse relation
 * @method     ChildInventoryDeliveryVoucherQuery rightJoinWarehouse($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Warehouse relation
 * @method     ChildInventoryDeliveryVoucherQuery innerJoinWarehouse($relationAlias = null) Adds a INNER JOIN clause to the query using the Warehouse relation
 *
 * @method     ChildInventoryDeliveryVoucherQuery joinWithWarehouse($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Warehouse relation
 *
 * @method     ChildInventoryDeliveryVoucherQuery leftJoinWithWarehouse() Adds a LEFT JOIN clause and with to the query using the Warehouse relation
 * @method     ChildInventoryDeliveryVoucherQuery rightJoinWithWarehouse() Adds a RIGHT JOIN clause and with to the query using the Warehouse relation
 * @method     ChildInventoryDeliveryVoucherQuery innerJoinWithWarehouse() Adds a INNER JOIN clause and with to the query using the Warehouse relation
 *
 * @method     ChildInventoryDeliveryVoucherQuery leftJoinEmployee($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employee relation
 * @method     ChildInventoryDeliveryVoucherQuery rightJoinEmployee($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employee relation
 * @method     ChildInventoryDeliveryVoucherQuery innerJoinEmployee($relationAlias = null) Adds a INNER JOIN clause to the query using the Employee relation
 *
 * @method     ChildInventoryDeliveryVoucherQuery joinWithEmployee($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employee relation
 *
 * @method     ChildInventoryDeliveryVoucherQuery leftJoinWithEmployee() Adds a LEFT JOIN clause and with to the query using the Employee relation
 * @method     ChildInventoryDeliveryVoucherQuery rightJoinWithEmployee() Adds a RIGHT JOIN clause and with to the query using the Employee relation
 * @method     ChildInventoryDeliveryVoucherQuery innerJoinWithEmployee() Adds a INNER JOIN clause and with to the query using the Employee relation
 *
 * @method     ChildInventoryDeliveryVoucherQuery leftJoinCustomers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Customers relation
 * @method     ChildInventoryDeliveryVoucherQuery rightJoinCustomers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Customers relation
 * @method     ChildInventoryDeliveryVoucherQuery innerJoinCustomers($relationAlias = null) Adds a INNER JOIN clause to the query using the Customers relation
 *
 * @method     ChildInventoryDeliveryVoucherQuery joinWithCustomers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Customers relation
 *
 * @method     ChildInventoryDeliveryVoucherQuery leftJoinWithCustomers() Adds a LEFT JOIN clause and with to the query using the Customers relation
 * @method     ChildInventoryDeliveryVoucherQuery rightJoinWithCustomers() Adds a RIGHT JOIN clause and with to the query using the Customers relation
 * @method     ChildInventoryDeliveryVoucherQuery innerJoinWithCustomers() Adds a INNER JOIN clause and with to the query using the Customers relation
 *
 * @method     ChildInventoryDeliveryVoucherQuery leftJoinInventoryDeliveryVoucherDetail($relationAlias = null) Adds a LEFT JOIN clause to the query using the InventoryDeliveryVoucherDetail relation
 * @method     ChildInventoryDeliveryVoucherQuery rightJoinInventoryDeliveryVoucherDetail($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InventoryDeliveryVoucherDetail relation
 * @method     ChildInventoryDeliveryVoucherQuery innerJoinInventoryDeliveryVoucherDetail($relationAlias = null) Adds a INNER JOIN clause to the query using the InventoryDeliveryVoucherDetail relation
 *
 * @method     ChildInventoryDeliveryVoucherQuery joinWithInventoryDeliveryVoucherDetail($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the InventoryDeliveryVoucherDetail relation
 *
 * @method     ChildInventoryDeliveryVoucherQuery leftJoinWithInventoryDeliveryVoucherDetail() Adds a LEFT JOIN clause and with to the query using the InventoryDeliveryVoucherDetail relation
 * @method     ChildInventoryDeliveryVoucherQuery rightJoinWithInventoryDeliveryVoucherDetail() Adds a RIGHT JOIN clause and with to the query using the InventoryDeliveryVoucherDetail relation
 * @method     ChildInventoryDeliveryVoucherQuery innerJoinWithInventoryDeliveryVoucherDetail() Adds a INNER JOIN clause and with to the query using the InventoryDeliveryVoucherDetail relation
 *
 * @method     \AdvertiserBundle\Model\WarehouseQuery|\AdvertiserBundle\Model\EmployeeQuery|\AdvertiserBundle\Model\CustomersQuery|\AdvertiserBundle\Model\InventoryDeliveryVoucherDetailQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInventoryDeliveryVoucher findOne(ConnectionInterface $con = null) Return the first ChildInventoryDeliveryVoucher matching the query
 * @method     ChildInventoryDeliveryVoucher findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInventoryDeliveryVoucher matching the query, or a new ChildInventoryDeliveryVoucher object populated from the query conditions when no match is found
 *
 * @method     ChildInventoryDeliveryVoucher findOneById(int $id) Return the first ChildInventoryDeliveryVoucher filtered by the id column
 * @method     ChildInventoryDeliveryVoucher findOneByWarehouseId(int $warehouse_id) Return the first ChildInventoryDeliveryVoucher filtered by the warehouse_id column
 * @method     ChildInventoryDeliveryVoucher findOneByEmployeeId(int $employee_id) Return the first ChildInventoryDeliveryVoucher filtered by the employee_id column
 * @method     ChildInventoryDeliveryVoucher findOneByCustomerId(int $customer_id) Return the first ChildInventoryDeliveryVoucher filtered by the customer_id column
 * @method     ChildInventoryDeliveryVoucher findOneByCreatedAt(string $created_at) Return the first ChildInventoryDeliveryVoucher filtered by the created_at column
 * @method     ChildInventoryDeliveryVoucher findOneByDescription(string $description) Return the first ChildInventoryDeliveryVoucher filtered by the description column *

 * @method     ChildInventoryDeliveryVoucher requirePk($key, ConnectionInterface $con = null) Return the ChildInventoryDeliveryVoucher by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryDeliveryVoucher requireOne(ConnectionInterface $con = null) Return the first ChildInventoryDeliveryVoucher matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInventoryDeliveryVoucher requireOneById(int $id) Return the first ChildInventoryDeliveryVoucher filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryDeliveryVoucher requireOneByWarehouseId(int $warehouse_id) Return the first ChildInventoryDeliveryVoucher filtered by the warehouse_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryDeliveryVoucher requireOneByEmployeeId(int $employee_id) Return the first ChildInventoryDeliveryVoucher filtered by the employee_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryDeliveryVoucher requireOneByCustomerId(int $customer_id) Return the first ChildInventoryDeliveryVoucher filtered by the customer_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryDeliveryVoucher requireOneByCreatedAt(string $created_at) Return the first ChildInventoryDeliveryVoucher filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryDeliveryVoucher requireOneByDescription(string $description) Return the first ChildInventoryDeliveryVoucher filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInventoryDeliveryVoucher[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInventoryDeliveryVoucher objects based on current ModelCriteria
 * @method     ChildInventoryDeliveryVoucher[]|ObjectCollection findById(int $id) Return ChildInventoryDeliveryVoucher objects filtered by the id column
 * @method     ChildInventoryDeliveryVoucher[]|ObjectCollection findByWarehouseId(int $warehouse_id) Return ChildInventoryDeliveryVoucher objects filtered by the warehouse_id column
 * @method     ChildInventoryDeliveryVoucher[]|ObjectCollection findByEmployeeId(int $employee_id) Return ChildInventoryDeliveryVoucher objects filtered by the employee_id column
 * @method     ChildInventoryDeliveryVoucher[]|ObjectCollection findByCustomerId(int $customer_id) Return ChildInventoryDeliveryVoucher objects filtered by the customer_id column
 * @method     ChildInventoryDeliveryVoucher[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildInventoryDeliveryVoucher objects filtered by the created_at column
 * @method     ChildInventoryDeliveryVoucher[]|ObjectCollection findByDescription(string $description) Return ChildInventoryDeliveryVoucher objects filtered by the description column
 * @method     ChildInventoryDeliveryVoucher[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InventoryDeliveryVoucherQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \AdvertiserBundle\Model\Base\InventoryDeliveryVoucherQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AdvertiserBundle\\Model\\InventoryDeliveryVoucher', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInventoryDeliveryVoucherQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInventoryDeliveryVoucherQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInventoryDeliveryVoucherQuery) {
            return $criteria;
        }
        $query = new ChildInventoryDeliveryVoucherQuery();
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
     * @return ChildInventoryDeliveryVoucher|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InventoryDeliveryVoucherTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = InventoryDeliveryVoucherTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildInventoryDeliveryVoucher A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `warehouse_id`, `employee_id`, `customer_id`, `created_at`, `description` FROM `inventory_delivery_voucher` WHERE `id` = :p0';
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
            /** @var ChildInventoryDeliveryVoucher $obj */
            $obj = new ChildInventoryDeliveryVoucher();
            $obj->hydrate($row);
            InventoryDeliveryVoucherTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildInventoryDeliveryVoucher|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the warehouse_id column
     *
     * Example usage:
     * <code>
     * $query->filterByWarehouseId(1234); // WHERE warehouse_id = 1234
     * $query->filterByWarehouseId(array(12, 34)); // WHERE warehouse_id IN (12, 34)
     * $query->filterByWarehouseId(array('min' => 12)); // WHERE warehouse_id > 12
     * </code>
     *
     * @see       filterByWarehouse()
     *
     * @param     mixed $warehouseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterByWarehouseId($warehouseId = null, $comparison = null)
    {
        if (is_array($warehouseId)) {
            $useMinMax = false;
            if (isset($warehouseId['min'])) {
                $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_WAREHOUSE_ID, $warehouseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($warehouseId['max'])) {
                $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_WAREHOUSE_ID, $warehouseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_WAREHOUSE_ID, $warehouseId, $comparison);
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
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterByEmployeeId($employeeId = null, $comparison = null)
    {
        if (is_array($employeeId)) {
            $useMinMax = false;
            if (isset($employeeId['min'])) {
                $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_EMPLOYEE_ID, $employeeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeeId['max'])) {
                $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_EMPLOYEE_ID, $employeeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_EMPLOYEE_ID, $employeeId, $comparison);
    }

    /**
     * Filter the query on the customer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomerId(1234); // WHERE customer_id = 1234
     * $query->filterByCustomerId(array(12, 34)); // WHERE customer_id IN (12, 34)
     * $query->filterByCustomerId(array('min' => 12)); // WHERE customer_id > 12
     * </code>
     *
     * @see       filterByCustomers()
     *
     * @param     mixed $customerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterByCustomerId($customerId = null, $comparison = null)
    {
        if (is_array($customerId)) {
            $useMinMax = false;
            if (isset($customerId['min'])) {
                $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_CUSTOMER_ID, $customerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customerId['max'])) {
                $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_CUSTOMER_ID, $customerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_CUSTOMER_ID, $customerId, $comparison);
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
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related \AdvertiserBundle\Model\Warehouse object
     *
     * @param \AdvertiserBundle\Model\Warehouse|ObjectCollection $warehouse The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterByWarehouse($warehouse, $comparison = null)
    {
        if ($warehouse instanceof \AdvertiserBundle\Model\Warehouse) {
            return $this
                ->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_WAREHOUSE_ID, $warehouse->getId(), $comparison);
        } elseif ($warehouse instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_WAREHOUSE_ID, $warehouse->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByWarehouse() only accepts arguments of type \AdvertiserBundle\Model\Warehouse or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Warehouse relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function joinWarehouse($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Warehouse');

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
            $this->addJoinObject($join, 'Warehouse');
        }

        return $this;
    }

    /**
     * Use the Warehouse relation Warehouse object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AdvertiserBundle\Model\WarehouseQuery A secondary query class using the current class as primary query
     */
    public function useWarehouseQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWarehouse($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Warehouse', '\AdvertiserBundle\Model\WarehouseQuery');
    }

    /**
     * Filter the query by a related \AdvertiserBundle\Model\Employee object
     *
     * @param \AdvertiserBundle\Model\Employee|ObjectCollection $employee The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterByEmployee($employee, $comparison = null)
    {
        if ($employee instanceof \AdvertiserBundle\Model\Employee) {
            return $this
                ->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_EMPLOYEE_ID, $employee->getId(), $comparison);
        } elseif ($employee instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_EMPLOYEE_ID, $employee->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
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
     * Filter the query by a related \AdvertiserBundle\Model\Customers object
     *
     * @param \AdvertiserBundle\Model\Customers|ObjectCollection $customers The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterByCustomers($customers, $comparison = null)
    {
        if ($customers instanceof \AdvertiserBundle\Model\Customers) {
            return $this
                ->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_CUSTOMER_ID, $customers->getId(), $comparison);
        } elseif ($customers instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_CUSTOMER_ID, $customers->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCustomers() only accepts arguments of type \AdvertiserBundle\Model\Customers or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Customers relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function joinCustomers($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Customers');

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
            $this->addJoinObject($join, 'Customers');
        }

        return $this;
    }

    /**
     * Use the Customers relation Customers object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AdvertiserBundle\Model\CustomersQuery A secondary query class using the current class as primary query
     */
    public function useCustomersQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCustomers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Customers', '\AdvertiserBundle\Model\CustomersQuery');
    }

    /**
     * Filter the query by a related \AdvertiserBundle\Model\InventoryDeliveryVoucherDetail object
     *
     * @param \AdvertiserBundle\Model\InventoryDeliveryVoucherDetail|ObjectCollection $inventoryDeliveryVoucherDetail the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function filterByInventoryDeliveryVoucherDetail($inventoryDeliveryVoucherDetail, $comparison = null)
    {
        if ($inventoryDeliveryVoucherDetail instanceof \AdvertiserBundle\Model\InventoryDeliveryVoucherDetail) {
            return $this
                ->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_ID, $inventoryDeliveryVoucherDetail->getInventoryDeliveryVoucherId(), $comparison);
        } elseif ($inventoryDeliveryVoucherDetail instanceof ObjectCollection) {
            return $this
                ->useInventoryDeliveryVoucherDetailQuery()
                ->filterByPrimaryKeys($inventoryDeliveryVoucherDetail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInventoryDeliveryVoucherDetail() only accepts arguments of type \AdvertiserBundle\Model\InventoryDeliveryVoucherDetail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InventoryDeliveryVoucherDetail relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function joinInventoryDeliveryVoucherDetail($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InventoryDeliveryVoucherDetail');

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
            $this->addJoinObject($join, 'InventoryDeliveryVoucherDetail');
        }

        return $this;
    }

    /**
     * Use the InventoryDeliveryVoucherDetail relation InventoryDeliveryVoucherDetail object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AdvertiserBundle\Model\InventoryDeliveryVoucherDetailQuery A secondary query class using the current class as primary query
     */
    public function useInventoryDeliveryVoucherDetailQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinInventoryDeliveryVoucherDetail($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InventoryDeliveryVoucherDetail', '\AdvertiserBundle\Model\InventoryDeliveryVoucherDetailQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildInventoryDeliveryVoucher $inventoryDeliveryVoucher Object to remove from the list of results
     *
     * @return $this|ChildInventoryDeliveryVoucherQuery The current query, for fluid interface
     */
    public function prune($inventoryDeliveryVoucher = null)
    {
        if ($inventoryDeliveryVoucher) {
            $this->addUsingAlias(InventoryDeliveryVoucherTableMap::COL_ID, $inventoryDeliveryVoucher->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the inventory_delivery_voucher table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InventoryDeliveryVoucherTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InventoryDeliveryVoucherTableMap::clearInstancePool();
            InventoryDeliveryVoucherTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InventoryDeliveryVoucherTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InventoryDeliveryVoucherTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            InventoryDeliveryVoucherTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            InventoryDeliveryVoucherTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // InventoryDeliveryVoucherQuery
