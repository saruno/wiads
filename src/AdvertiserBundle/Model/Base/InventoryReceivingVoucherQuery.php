<?php

namespace AdvertiserBundle\Model\Base;

use \Exception;
use \PDO;
use AdvertiserBundle\Model\InventoryReceivingVoucher as ChildInventoryReceivingVoucher;
use AdvertiserBundle\Model\InventoryReceivingVoucherQuery as ChildInventoryReceivingVoucherQuery;
use AdvertiserBundle\Model\Map\InventoryReceivingVoucherTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'inventory_receiving_voucher' table.
 *
 *
 *
 * @method     ChildInventoryReceivingVoucherQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildInventoryReceivingVoucherQuery orderByProviderId($order = Criteria::ASC) Order by the provider_id column
 * @method     ChildInventoryReceivingVoucherQuery orderByWarehouseId($order = Criteria::ASC) Order by the warehouse_id column
 * @method     ChildInventoryReceivingVoucherQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildInventoryReceivingVoucherQuery groupById() Group by the id column
 * @method     ChildInventoryReceivingVoucherQuery groupByProviderId() Group by the provider_id column
 * @method     ChildInventoryReceivingVoucherQuery groupByWarehouseId() Group by the warehouse_id column
 * @method     ChildInventoryReceivingVoucherQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildInventoryReceivingVoucherQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInventoryReceivingVoucherQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInventoryReceivingVoucherQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInventoryReceivingVoucherQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildInventoryReceivingVoucherQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildInventoryReceivingVoucherQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildInventoryReceivingVoucherQuery leftJoinProvider($relationAlias = null) Adds a LEFT JOIN clause to the query using the Provider relation
 * @method     ChildInventoryReceivingVoucherQuery rightJoinProvider($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Provider relation
 * @method     ChildInventoryReceivingVoucherQuery innerJoinProvider($relationAlias = null) Adds a INNER JOIN clause to the query using the Provider relation
 *
 * @method     ChildInventoryReceivingVoucherQuery joinWithProvider($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Provider relation
 *
 * @method     ChildInventoryReceivingVoucherQuery leftJoinWithProvider() Adds a LEFT JOIN clause and with to the query using the Provider relation
 * @method     ChildInventoryReceivingVoucherQuery rightJoinWithProvider() Adds a RIGHT JOIN clause and with to the query using the Provider relation
 * @method     ChildInventoryReceivingVoucherQuery innerJoinWithProvider() Adds a INNER JOIN clause and with to the query using the Provider relation
 *
 * @method     ChildInventoryReceivingVoucherQuery leftJoinWarehouse($relationAlias = null) Adds a LEFT JOIN clause to the query using the Warehouse relation
 * @method     ChildInventoryReceivingVoucherQuery rightJoinWarehouse($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Warehouse relation
 * @method     ChildInventoryReceivingVoucherQuery innerJoinWarehouse($relationAlias = null) Adds a INNER JOIN clause to the query using the Warehouse relation
 *
 * @method     ChildInventoryReceivingVoucherQuery joinWithWarehouse($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Warehouse relation
 *
 * @method     ChildInventoryReceivingVoucherQuery leftJoinWithWarehouse() Adds a LEFT JOIN clause and with to the query using the Warehouse relation
 * @method     ChildInventoryReceivingVoucherQuery rightJoinWithWarehouse() Adds a RIGHT JOIN clause and with to the query using the Warehouse relation
 * @method     ChildInventoryReceivingVoucherQuery innerJoinWithWarehouse() Adds a INNER JOIN clause and with to the query using the Warehouse relation
 *
 * @method     ChildInventoryReceivingVoucherQuery leftJoinInventoryReceivingVoucherDetail($relationAlias = null) Adds a LEFT JOIN clause to the query using the InventoryReceivingVoucherDetail relation
 * @method     ChildInventoryReceivingVoucherQuery rightJoinInventoryReceivingVoucherDetail($relationAlias = null) Adds a RIGHT JOIN clause to the query using the InventoryReceivingVoucherDetail relation
 * @method     ChildInventoryReceivingVoucherQuery innerJoinInventoryReceivingVoucherDetail($relationAlias = null) Adds a INNER JOIN clause to the query using the InventoryReceivingVoucherDetail relation
 *
 * @method     ChildInventoryReceivingVoucherQuery joinWithInventoryReceivingVoucherDetail($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the InventoryReceivingVoucherDetail relation
 *
 * @method     ChildInventoryReceivingVoucherQuery leftJoinWithInventoryReceivingVoucherDetail() Adds a LEFT JOIN clause and with to the query using the InventoryReceivingVoucherDetail relation
 * @method     ChildInventoryReceivingVoucherQuery rightJoinWithInventoryReceivingVoucherDetail() Adds a RIGHT JOIN clause and with to the query using the InventoryReceivingVoucherDetail relation
 * @method     ChildInventoryReceivingVoucherQuery innerJoinWithInventoryReceivingVoucherDetail() Adds a INNER JOIN clause and with to the query using the InventoryReceivingVoucherDetail relation
 *
 * @method     \AdvertiserBundle\Model\ProviderQuery|\AdvertiserBundle\Model\WarehouseQuery|\AdvertiserBundle\Model\InventoryReceivingVoucherDetailQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInventoryReceivingVoucher findOne(ConnectionInterface $con = null) Return the first ChildInventoryReceivingVoucher matching the query
 * @method     ChildInventoryReceivingVoucher findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInventoryReceivingVoucher matching the query, or a new ChildInventoryReceivingVoucher object populated from the query conditions when no match is found
 *
 * @method     ChildInventoryReceivingVoucher findOneById(int $id) Return the first ChildInventoryReceivingVoucher filtered by the id column
 * @method     ChildInventoryReceivingVoucher findOneByProviderId(int $provider_id) Return the first ChildInventoryReceivingVoucher filtered by the provider_id column
 * @method     ChildInventoryReceivingVoucher findOneByWarehouseId(int $warehouse_id) Return the first ChildInventoryReceivingVoucher filtered by the warehouse_id column
 * @method     ChildInventoryReceivingVoucher findOneByCreatedAt(string $created_at) Return the first ChildInventoryReceivingVoucher filtered by the created_at column *

 * @method     ChildInventoryReceivingVoucher requirePk($key, ConnectionInterface $con = null) Return the ChildInventoryReceivingVoucher by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryReceivingVoucher requireOne(ConnectionInterface $con = null) Return the first ChildInventoryReceivingVoucher matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInventoryReceivingVoucher requireOneById(int $id) Return the first ChildInventoryReceivingVoucher filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryReceivingVoucher requireOneByProviderId(int $provider_id) Return the first ChildInventoryReceivingVoucher filtered by the provider_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryReceivingVoucher requireOneByWarehouseId(int $warehouse_id) Return the first ChildInventoryReceivingVoucher filtered by the warehouse_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventoryReceivingVoucher requireOneByCreatedAt(string $created_at) Return the first ChildInventoryReceivingVoucher filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInventoryReceivingVoucher[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInventoryReceivingVoucher objects based on current ModelCriteria
 * @method     ChildInventoryReceivingVoucher[]|ObjectCollection findById(int $id) Return ChildInventoryReceivingVoucher objects filtered by the id column
 * @method     ChildInventoryReceivingVoucher[]|ObjectCollection findByProviderId(int $provider_id) Return ChildInventoryReceivingVoucher objects filtered by the provider_id column
 * @method     ChildInventoryReceivingVoucher[]|ObjectCollection findByWarehouseId(int $warehouse_id) Return ChildInventoryReceivingVoucher objects filtered by the warehouse_id column
 * @method     ChildInventoryReceivingVoucher[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildInventoryReceivingVoucher objects filtered by the created_at column
 * @method     ChildInventoryReceivingVoucher[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InventoryReceivingVoucherQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \AdvertiserBundle\Model\Base\InventoryReceivingVoucherQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\AdvertiserBundle\\Model\\InventoryReceivingVoucher', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInventoryReceivingVoucherQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInventoryReceivingVoucherQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInventoryReceivingVoucherQuery) {
            return $criteria;
        }
        $query = new ChildInventoryReceivingVoucherQuery();
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
     * @return ChildInventoryReceivingVoucher|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InventoryReceivingVoucherTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = InventoryReceivingVoucherTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildInventoryReceivingVoucher A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `provider_id`, `warehouse_id`, `created_at` FROM `inventory_receiving_voucher` WHERE `id` = :p0';
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
            /** @var ChildInventoryReceivingVoucher $obj */
            $obj = new ChildInventoryReceivingVoucher();
            $obj->hydrate($row);
            InventoryReceivingVoucherTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildInventoryReceivingVoucher|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the provider_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProviderId(1234); // WHERE provider_id = 1234
     * $query->filterByProviderId(array(12, 34)); // WHERE provider_id IN (12, 34)
     * $query->filterByProviderId(array('min' => 12)); // WHERE provider_id > 12
     * </code>
     *
     * @see       filterByProvider()
     *
     * @param     mixed $providerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function filterByProviderId($providerId = null, $comparison = null)
    {
        if (is_array($providerId)) {
            $useMinMax = false;
            if (isset($providerId['min'])) {
                $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_PROVIDER_ID, $providerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($providerId['max'])) {
                $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_PROVIDER_ID, $providerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_PROVIDER_ID, $providerId, $comparison);
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
     * @return $this|ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function filterByWarehouseId($warehouseId = null, $comparison = null)
    {
        if (is_array($warehouseId)) {
            $useMinMax = false;
            if (isset($warehouseId['min'])) {
                $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_WAREHOUSE_ID, $warehouseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($warehouseId['max'])) {
                $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_WAREHOUSE_ID, $warehouseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_WAREHOUSE_ID, $warehouseId, $comparison);
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
     * @return $this|ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \AdvertiserBundle\Model\Provider object
     *
     * @param \AdvertiserBundle\Model\Provider|ObjectCollection $provider The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function filterByProvider($provider, $comparison = null)
    {
        if ($provider instanceof \AdvertiserBundle\Model\Provider) {
            return $this
                ->addUsingAlias(InventoryReceivingVoucherTableMap::COL_PROVIDER_ID, $provider->getId(), $comparison);
        } elseif ($provider instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InventoryReceivingVoucherTableMap::COL_PROVIDER_ID, $provider->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProvider() only accepts arguments of type \AdvertiserBundle\Model\Provider or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Provider relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function joinProvider($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Provider');

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
            $this->addJoinObject($join, 'Provider');
        }

        return $this;
    }

    /**
     * Use the Provider relation Provider object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AdvertiserBundle\Model\ProviderQuery A secondary query class using the current class as primary query
     */
    public function useProviderQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProvider($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Provider', '\AdvertiserBundle\Model\ProviderQuery');
    }

    /**
     * Filter the query by a related \AdvertiserBundle\Model\Warehouse object
     *
     * @param \AdvertiserBundle\Model\Warehouse|ObjectCollection $warehouse The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function filterByWarehouse($warehouse, $comparison = null)
    {
        if ($warehouse instanceof \AdvertiserBundle\Model\Warehouse) {
            return $this
                ->addUsingAlias(InventoryReceivingVoucherTableMap::COL_WAREHOUSE_ID, $warehouse->getId(), $comparison);
        } elseif ($warehouse instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InventoryReceivingVoucherTableMap::COL_WAREHOUSE_ID, $warehouse->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildInventoryReceivingVoucherQuery The current query, for fluid interface
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
     * Filter the query by a related \AdvertiserBundle\Model\InventoryReceivingVoucherDetail object
     *
     * @param \AdvertiserBundle\Model\InventoryReceivingVoucherDetail|ObjectCollection $inventoryReceivingVoucherDetail the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function filterByInventoryReceivingVoucherDetail($inventoryReceivingVoucherDetail, $comparison = null)
    {
        if ($inventoryReceivingVoucherDetail instanceof \AdvertiserBundle\Model\InventoryReceivingVoucherDetail) {
            return $this
                ->addUsingAlias(InventoryReceivingVoucherTableMap::COL_ID, $inventoryReceivingVoucherDetail->getInventoryReceivingVoucherId(), $comparison);
        } elseif ($inventoryReceivingVoucherDetail instanceof ObjectCollection) {
            return $this
                ->useInventoryReceivingVoucherDetailQuery()
                ->filterByPrimaryKeys($inventoryReceivingVoucherDetail->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInventoryReceivingVoucherDetail() only accepts arguments of type \AdvertiserBundle\Model\InventoryReceivingVoucherDetail or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the InventoryReceivingVoucherDetail relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function joinInventoryReceivingVoucherDetail($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('InventoryReceivingVoucherDetail');

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
            $this->addJoinObject($join, 'InventoryReceivingVoucherDetail');
        }

        return $this;
    }

    /**
     * Use the InventoryReceivingVoucherDetail relation InventoryReceivingVoucherDetail object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AdvertiserBundle\Model\InventoryReceivingVoucherDetailQuery A secondary query class using the current class as primary query
     */
    public function useInventoryReceivingVoucherDetailQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinInventoryReceivingVoucherDetail($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'InventoryReceivingVoucherDetail', '\AdvertiserBundle\Model\InventoryReceivingVoucherDetailQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildInventoryReceivingVoucher $inventoryReceivingVoucher Object to remove from the list of results
     *
     * @return $this|ChildInventoryReceivingVoucherQuery The current query, for fluid interface
     */
    public function prune($inventoryReceivingVoucher = null)
    {
        if ($inventoryReceivingVoucher) {
            $this->addUsingAlias(InventoryReceivingVoucherTableMap::COL_ID, $inventoryReceivingVoucher->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the inventory_receiving_voucher table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InventoryReceivingVoucherTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InventoryReceivingVoucherTableMap::clearInstancePool();
            InventoryReceivingVoucherTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InventoryReceivingVoucherTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InventoryReceivingVoucherTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            InventoryReceivingVoucherTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            InventoryReceivingVoucherTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // InventoryReceivingVoucherQuery
