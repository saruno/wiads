<?php

namespace AdvertiserBundle\Model\Base;

use \Exception;
use \PDO;
use AdvertiserBundle\Model\InventoryReceivingVoucherDetail as ChildInventoryReceivingVoucherDetail;
use AdvertiserBundle\Model\InventoryReceivingVoucherDetailQuery as ChildInventoryReceivingVoucherDetailQuery;
use AdvertiserBundle\Model\Map\InventoryReceivingVoucherDetailTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'inventory_receiving_voucher_detail' table.
 *
 *
 *
 * @method     ChildInventoryReceivingVoucherDetailQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildInventoryReceivingVoucherDetailQuery orderByInventoryReceivingVoucherId($order = Criteria::ASC) Order by the inventory_receiving_voucher_id column
 * @method     ChildInventoryReceivingVoucherDetailQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildInventoryReceivingVoucherDetailQuery orderByQuantity($order = Criteria::ASC) Order by the quantity column
 * @method     ChildInventoryReceivingVoucherDetailQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method     ChildInventoryReceivingVoucherDetailQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildInventoryReceivingVoucherDetailQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildInventoryReceivingVoucherDetailQuery groupById() Group by the id column
 * @method     ChildInventoryReceivingVoucherDetailQuery groupByInventoryReceivingVoucherId() Group by the inventory_receiving_voucher_id column
 * @method     ChildInventoryReceivingVoucherDetailQuery groupByProductId() Group by the product_id column
 * @method     ChildInventoryReceivingVoucherDetailQuery groupByQuantity() Group by the quantity column
 * @method     ChildInventoryReceivingVoucherDetailQuery groupByPrice() Group by the price column
 * @method     ChildInventoryReceivingVoucherDetailQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildInventoryReceivingVoucherDetailQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildInventoryReceivingVoucherDetailQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInventoryReceivingVoucherDetailQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInventoryReceivingVoucherDetailQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInventoryReceivingVoucherDetailQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildInventoryReceivingVoucherDetailQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildInventoryReceivingVoucherDetailQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildInventoryReceivingVoucherDetailQuery leftJoinInventoryReceivingVoucher($relationAlias = null) Adds a LEFT JOIN clause to the query using the InventoryReceivingVoucher relation
 * @method     ChildInventoryReceivingVoucherDetailQuery rightJoinInventoryReceivingVoucher($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InventoryReceivingVoucher relation
 * @method     ChildInventoryReceivingVoucherDetailQuery innerJoinInventoryReceivingVoucher($relationAlias = null) Adds a INNER JOIN clause to the query using the InventoryReceivingVoucher relation
 *
 * @method     ChildInventoryReceivingVoucherDetailQuery joinWithInventoryReceivingVoucher($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the InventoryReceivingVoucher relation
 *
 * @method     ChildInventoryReceivingVoucherDetailQuery leftJoinWithInventoryReceivingVoucher() Adds a LEFT JOIN clause and with to the query using the InventoryReceivingVoucher relation
 * @method     ChildInventoryReceivingVoucherDetailQuery rightJoinWithInventoryReceivingVoucher() Adds a RIGHT JOIN clause and with to the query using the InventoryReceivingVoucher relation
 * @method     ChildInventoryReceivingVoucherDetailQuery innerJoinWithInventoryReceivingVoucher() Adds a INNER JOIN clause and with to the query using the InventoryReceivingVoucher relation
 *
 * @method     ChildInventoryReceivingVoucherDetailQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method     ChildInventoryReceivingVoucherDetailQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method     ChildInventoryReceivingVoucherDetailQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method     ChildInventoryReceivingVoucherDetailQuery joinWithProduct($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Product relation
 *
 * @method     ChildInventoryReceivingVoucherDetailQuery leftJoinWithProduct() Adds a LEFT JOIN clause and with to the query using the Product relation
 * @method     ChildInventoryReceivingVoucherDetailQuery rightJoinWithProduct() Adds a RIGHT JOIN clause and with to the query using the Product relation
 * @method     ChildInventoryReceivingVoucherDetailQuery innerJoinWithProduct() Adds a INNER JOIN clause and with to the query using the Product relation
 *
 * @method     \AdvertiserBundle\Model\InventoryReceivingVoucherQuery|\AdvertiserBundle\Model\ProductQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInventoryReceivingVoucherDetail findOne(ConnectionInterface $con = null) Return the first ChildInventoryReceivingVoucherDetail matching the query
 * @method     ChildInventoryReceivingVoucherDetail findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInventoryReceivingVoucherDetail matching the query, or a new ChildInventoryReceivingVoucherDetail object populated from the query conditions when no match is found
 *
 * @method     ChildInventoryReceivingVoucherDetail findOneById(int $id) Return the first ChildInventoryReceivingVoucherDetail filtered by the id column
 * @method     ChildInventoryReceivingVoucherDetail findOneByInventoryReceivingVoucherId(int $inventory_receiving_voucher_id) Return the first ChildInventoryReceivingVoucherDetail filtered by the inventory_receiving_voucher_id column
 * @method     ChildInventoryReceivingVoucherDetail findOneByProductId(int $product_id) Return the first ChildInventoryReceivingVoucherDetail filtered by the product_id column
 * @method     ChildInventoryReceivingVoucherDetail findOneByQuantity(int $quantity) Return the first ChildInventoryReceivingVoucherDetail filtered by the quantity column
 * @method     ChildInventoryReceivingVoucherDetail findOneByPrice(string $price) Return the first ChildInventoryReceivingVoucherDetail filtered by the price column
 * @method     ChildInventoryReceivingVoucherDetail findOneByCreatedAt(string $created_at) Return the first ChildInventoryReceivingVoucherDetail filtered by the created_at column
 * @method     ChildInventoryReceivingVoucherDetail findOneByUpdatedAt(string $updated_at) Return the first ChildInventoryReceivingVoucherDetail filtered by the updated_at column *

 * @method     ChildInventoryReceivingVoucherDetail requirePk($key, ConnectionInterface $con = null) Return the ChildInventoryReceivingVoucherDetail by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryReceivingVoucherDetail requireOne(ConnectionInterface $con = null) Return the first ChildInventoryReceivingVoucherDetail matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInventoryReceivingVoucherDetail requireOneById(int $id) Return the first ChildInventoryReceivingVoucherDetail filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryReceivingVoucherDetail requireOneByInventoryReceivingVoucherId(int $inventory_receiving_voucher_id) Return the first ChildInventoryReceivingVoucherDetail filtered by the inventory_receiving_voucher_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryReceivingVoucherDetail requireOneByProductId(int $product_id) Return the first ChildInventoryReceivingVoucherDetail filtered by the product_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryReceivingVoucherDetail requireOneByQuantity(int $quantity) Return the first ChildInventoryReceivingVoucherDetail filtered by the quantity column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryReceivingVoucherDetail requireOneByPrice(string $price) Return the first ChildInventoryReceivingVoucherDetail filtered by the price column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryReceivingVoucherDetail requireOneByCreatedAt(string $created_at) Return the first ChildInventoryReceivingVoucherDetail filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryReceivingVoucherDetail requireOneByUpdatedAt(string $updated_at) Return the first ChildInventoryReceivingVoucherDetail filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInventoryReceivingVoucherDetail[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInventoryReceivingVoucherDetail objects based on current ModelCriteria
 * @method     ChildInventoryReceivingVoucherDetail[]|ObjectCollection findById(int $id) Return ChildInventoryReceivingVoucherDetail objects filtered by the id column
 * @method     ChildInventoryReceivingVoucherDetail[]|ObjectCollection findByInventoryReceivingVoucherId(int $inventory_receiving_voucher_id) Return ChildInventoryReceivingVoucherDetail objects filtered by the inventory_receiving_voucher_id column
 * @method     ChildInventoryReceivingVoucherDetail[]|ObjectCollection findByProductId(int $product_id) Return ChildInventoryReceivingVoucherDetail objects filtered by the product_id column
 * @method     ChildInventoryReceivingVoucherDetail[]|ObjectCollection findByQuantity(int $quantity) Return ChildInventoryReceivingVoucherDetail objects filtered by the quantity column
 * @method     ChildInventoryReceivingVoucherDetail[]|ObjectCollection findByPrice(string $price) Return ChildInventoryReceivingVoucherDetail objects filtered by the price column
 * @method     ChildInventoryReceivingVoucherDetail[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildInventoryReceivingVoucherDetail objects filtered by the created_at column
 * @method     ChildInventoryReceivingVoucherDetail[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildInventoryReceivingVoucherDetail objects filtered by the updated_at column
 * @method     ChildInventoryReceivingVoucherDetail[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InventoryReceivingVoucherDetailQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \AdvertiserBundle\Model\Base\InventoryReceivingVoucherDetailQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AdvertiserBundle\\Model\\InventoryReceivingVoucherDetail', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInventoryReceivingVoucherDetailQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInventoryReceivingVoucherDetailQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInventoryReceivingVoucherDetailQuery) {
            return $criteria;
        }
        $query = new ChildInventoryReceivingVoucherDetailQuery();
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
     * @return ChildInventoryReceivingVoucherDetail|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InventoryReceivingVoucherDetailTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = InventoryReceivingVoucherDetailTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildInventoryReceivingVoucherDetail A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `inventory_receiving_voucher_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at` FROM `inventory_receiving_voucher_detail` WHERE `id` = :p0';
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
            /** @var ChildInventoryReceivingVoucherDetail $obj */
            $obj = new ChildInventoryReceivingVoucherDetail();
            $obj->hydrate($row);
            InventoryReceivingVoucherDetailTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildInventoryReceivingVoucherDetail|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the inventory_receiving_voucher_id column
     *
     * Example usage:
     * <code>
     * $query->filterByInventoryReceivingVoucherId(1234); // WHERE inventory_receiving_voucher_id = 1234
     * $query->filterByInventoryReceivingVoucherId(array(12, 34)); // WHERE inventory_receiving_voucher_id IN (12, 34)
     * $query->filterByInventoryReceivingVoucherId(array('min' => 12)); // WHERE inventory_receiving_voucher_id > 12
     * </code>
     *
     * @see       filterByInventoryReceivingVoucher()
     *
     * @param     mixed $inventoryReceivingVoucherId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function filterByInventoryReceivingVoucherId($inventoryReceivingVoucherId = null, $comparison = null)
    {
        if (is_array($inventoryReceivingVoucherId)) {
            $useMinMax = false;
            if (isset($inventoryReceivingVoucherId['min'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_INVENTORY_RECEIVING_VOUCHER_ID, $inventoryReceivingVoucherId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inventoryReceivingVoucherId['max'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_INVENTORY_RECEIVING_VOUCHER_ID, $inventoryReceivingVoucherId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_INVENTORY_RECEIVING_VOUCHER_ID, $inventoryReceivingVoucherId, $comparison);
    }

    /**
     * Filter the query on the product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductId(1234); // WHERE product_id = 1234
     * $query->filterByProductId(array(12, 34)); // WHERE product_id IN (12, 34)
     * $query->filterByProductId(array('min' => 12)); // WHERE product_id > 12
     * </code>
     *
     * @see       filterByProduct()
     *
     * @param     mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the quantity column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantity(1234); // WHERE quantity = 1234
     * $query->filterByQuantity(array(12, 34)); // WHERE quantity IN (12, 34)
     * $query->filterByQuantity(array('min' => 12)); // WHERE quantity > 12
     * </code>
     *
     * @param     mixed $quantity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function filterByQuantity($quantity = null, $comparison = null)
    {
        if (is_array($quantity)) {
            $useMinMax = false;
            if (isset($quantity['min'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_QUANTITY, $quantity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantity['max'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_QUANTITY, $quantity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_QUANTITY, $quantity, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_PRICE, $price, $comparison);
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
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \AdvertiserBundle\Model\InventoryReceivingVoucher object
     *
     * @param \AdvertiserBundle\Model\InventoryReceivingVoucher|ObjectCollection $inventoryReceivingVoucher The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function filterByInventoryReceivingVoucher($inventoryReceivingVoucher, $comparison = null)
    {
        if ($inventoryReceivingVoucher instanceof \AdvertiserBundle\Model\InventoryReceivingVoucher) {
            return $this
                ->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_INVENTORY_RECEIVING_VOUCHER_ID, $inventoryReceivingVoucher->getId(), $comparison);
        } elseif ($inventoryReceivingVoucher instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_INVENTORY_RECEIVING_VOUCHER_ID, $inventoryReceivingVoucher->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
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
     * @param \AdvertiserBundle\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof \AdvertiserBundle\Model\Product) {
            return $this
                ->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildInventoryReceivingVoucherDetail $inventoryReceivingVoucherDetail Object to remove from the list of results
     *
     * @return $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function prune($inventoryReceivingVoucherDetail = null)
    {
        if ($inventoryReceivingVoucherDetail) {
            $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_ID, $inventoryReceivingVoucherDetail->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the inventory_receiving_voucher_detail table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InventoryReceivingVoucherDetailTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InventoryReceivingVoucherDetailTableMap::clearInstancePool();
            InventoryReceivingVoucherDetailTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InventoryReceivingVoucherDetailTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InventoryReceivingVoucherDetailTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            InventoryReceivingVoucherDetailTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            InventoryReceivingVoucherDetailTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(InventoryReceivingVoucherDetailTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(InventoryReceivingVoucherDetailTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(InventoryReceivingVoucherDetailTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(InventoryReceivingVoucherDetailTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildInventoryReceivingVoucherDetailQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(InventoryReceivingVoucherDetailTableMap::COL_CREATED_AT);
    }

} // InventoryReceivingVoucherDetailQuery
