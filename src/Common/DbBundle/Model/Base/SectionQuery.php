<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\Section as ChildSection;
use Common\DbBundle\Model\SectionI18nQuery as ChildSectionI18nQuery;
use Common\DbBundle\Model\SectionQuery as ChildSectionQuery;
use Common\DbBundle\Model\Map\SectionTableMap;
use Hotspot\AccessPointBundle\Model\Accesspoint;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'section' table.
 *
 *
 *
 * @method     ChildSectionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSectionQuery orderByDeep($order = Criteria::ASC) Order by the deep column
 * @method     ChildSectionQuery orderByParent($order = Criteria::ASC) Order by the parent column
 * @method     ChildSectionQuery orderByBundleId($order = Criteria::ASC) Order by the bundle_id column
 * @method     ChildSectionQuery orderByOrders($order = Criteria::ASC) Order by the orders column
 * @method     ChildSectionQuery orderByCanDelete($order = Criteria::ASC) Order by the can_delete column
 * @method     ChildSectionQuery orderByLocked($order = Criteria::ASC) Order by the locked column
 * @method     ChildSectionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildSectionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildSectionQuery groupById() Group by the id column
 * @method     ChildSectionQuery groupByDeep() Group by the deep column
 * @method     ChildSectionQuery groupByParent() Group by the parent column
 * @method     ChildSectionQuery groupByBundleId() Group by the bundle_id column
 * @method     ChildSectionQuery groupByOrders() Group by the orders column
 * @method     ChildSectionQuery groupByCanDelete() Group by the can_delete column
 * @method     ChildSectionQuery groupByLocked() Group by the locked column
 * @method     ChildSectionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildSectionQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildSectionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSectionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSectionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSectionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSectionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSectionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSectionQuery leftJoinBundle($relationAlias = null) Adds a LEFT JOIN clause to the query using the Bundle relation
 * @method     ChildSectionQuery rightJoinBundle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Bundle relation
 * @method     ChildSectionQuery innerJoinBundle($relationAlias = null) Adds a INNER JOIN clause to the query using the Bundle relation
 *
 * @method     ChildSectionQuery joinWithBundle($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Bundle relation
 *
 * @method     ChildSectionQuery leftJoinWithBundle() Adds a LEFT JOIN clause and with to the query using the Bundle relation
 * @method     ChildSectionQuery rightJoinWithBundle() Adds a RIGHT JOIN clause and with to the query using the Bundle relation
 * @method     ChildSectionQuery innerJoinWithBundle() Adds a INNER JOIN clause and with to the query using the Bundle relation
 *
 * @method     ChildSectionQuery leftJoinNews($relationAlias = null) Adds a LEFT JOIN clause to the query using the News relation
 * @method     ChildSectionQuery rightJoinNews($relationAlias = null) Adds a RIGHT JOIN clause to the query using the News relation
 * @method     ChildSectionQuery innerJoinNews($relationAlias = null) Adds a INNER JOIN clause to the query using the News relation
 *
 * @method     ChildSectionQuery joinWithNews($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the News relation
 *
 * @method     ChildSectionQuery leftJoinWithNews() Adds a LEFT JOIN clause and with to the query using the News relation
 * @method     ChildSectionQuery rightJoinWithNews() Adds a RIGHT JOIN clause and with to the query using the News relation
 * @method     ChildSectionQuery innerJoinWithNews() Adds a INNER JOIN clause and with to the query using the News relation
 *
 * @method     ChildSectionQuery leftJoinComment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comment relation
 * @method     ChildSectionQuery rightJoinComment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comment relation
 * @method     ChildSectionQuery innerJoinComment($relationAlias = null) Adds a INNER JOIN clause to the query using the Comment relation
 *
 * @method     ChildSectionQuery joinWithComment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Comment relation
 *
 * @method     ChildSectionQuery leftJoinWithComment() Adds a LEFT JOIN clause and with to the query using the Comment relation
 * @method     ChildSectionQuery rightJoinWithComment() Adds a RIGHT JOIN clause and with to the query using the Comment relation
 * @method     ChildSectionQuery innerJoinWithComment() Adds a INNER JOIN clause and with to the query using the Comment relation
 *
 * @method     ChildSectionQuery leftJoinMenu($relationAlias = null) Adds a LEFT JOIN clause to the query using the Menu relation
 * @method     ChildSectionQuery rightJoinMenu($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Menu relation
 * @method     ChildSectionQuery innerJoinMenu($relationAlias = null) Adds a INNER JOIN clause to the query using the Menu relation
 *
 * @method     ChildSectionQuery joinWithMenu($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Menu relation
 *
 * @method     ChildSectionQuery leftJoinWithMenu() Adds a LEFT JOIN clause and with to the query using the Menu relation
 * @method     ChildSectionQuery rightJoinWithMenu() Adds a RIGHT JOIN clause and with to the query using the Menu relation
 * @method     ChildSectionQuery innerJoinWithMenu() Adds a INNER JOIN clause and with to the query using the Menu relation
 *
 * @method     ChildSectionQuery leftJoinAdvert($relationAlias = null) Adds a LEFT JOIN clause to the query using the Advert relation
 * @method     ChildSectionQuery rightJoinAdvert($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Advert relation
 * @method     ChildSectionQuery innerJoinAdvert($relationAlias = null) Adds a INNER JOIN clause to the query using the Advert relation
 *
 * @method     ChildSectionQuery joinWithAdvert($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Advert relation
 *
 * @method     ChildSectionQuery leftJoinWithAdvert() Adds a LEFT JOIN clause and with to the query using the Advert relation
 * @method     ChildSectionQuery rightJoinWithAdvert() Adds a RIGHT JOIN clause and with to the query using the Advert relation
 * @method     ChildSectionQuery innerJoinWithAdvert() Adds a INNER JOIN clause and with to the query using the Advert relation
 *
 * @method     ChildSectionQuery leftJoinPlace($relationAlias = null) Adds a LEFT JOIN clause to the query using the Place relation
 * @method     ChildSectionQuery rightJoinPlace($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Place relation
 * @method     ChildSectionQuery innerJoinPlace($relationAlias = null) Adds a INNER JOIN clause to the query using the Place relation
 *
 * @method     ChildSectionQuery joinWithPlace($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Place relation
 *
 * @method     ChildSectionQuery leftJoinWithPlace() Adds a LEFT JOIN clause and with to the query using the Place relation
 * @method     ChildSectionQuery rightJoinWithPlace() Adds a RIGHT JOIN clause and with to the query using the Place relation
 * @method     ChildSectionQuery innerJoinWithPlace() Adds a INNER JOIN clause and with to the query using the Place relation
 *
 * @method     ChildSectionQuery leftJoinMarker($relationAlias = null) Adds a LEFT JOIN clause to the query using the Marker relation
 * @method     ChildSectionQuery rightJoinMarker($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Marker relation
 * @method     ChildSectionQuery innerJoinMarker($relationAlias = null) Adds a INNER JOIN clause to the query using the Marker relation
 *
 * @method     ChildSectionQuery joinWithMarker($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Marker relation
 *
 * @method     ChildSectionQuery leftJoinWithMarker() Adds a LEFT JOIN clause and with to the query using the Marker relation
 * @method     ChildSectionQuery rightJoinWithMarker() Adds a RIGHT JOIN clause and with to the query using the Marker relation
 * @method     ChildSectionQuery innerJoinWithMarker() Adds a INNER JOIN clause and with to the query using the Marker relation
 *
 * @method     ChildSectionQuery leftJoinAccesspoint($relationAlias = null) Adds a LEFT JOIN clause to the query using the Accesspoint relation
 * @method     ChildSectionQuery rightJoinAccesspoint($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Accesspoint relation
 * @method     ChildSectionQuery innerJoinAccesspoint($relationAlias = null) Adds a INNER JOIN clause to the query using the Accesspoint relation
 *
 * @method     ChildSectionQuery joinWithAccesspoint($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Accesspoint relation
 *
 * @method     ChildSectionQuery leftJoinWithAccesspoint() Adds a LEFT JOIN clause and with to the query using the Accesspoint relation
 * @method     ChildSectionQuery rightJoinWithAccesspoint() Adds a RIGHT JOIN clause and with to the query using the Accesspoint relation
 * @method     ChildSectionQuery innerJoinWithAccesspoint() Adds a INNER JOIN clause and with to the query using the Accesspoint relation
 *
 * @method     ChildSectionQuery leftJoinSectionI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the SectionI18n relation
 * @method     ChildSectionQuery rightJoinSectionI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SectionI18n relation
 * @method     ChildSectionQuery innerJoinSectionI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the SectionI18n relation
 *
 * @method     ChildSectionQuery joinWithSectionI18n($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the SectionI18n relation
 *
 * @method     ChildSectionQuery leftJoinWithSectionI18n() Adds a LEFT JOIN clause and with to the query using the SectionI18n relation
 * @method     ChildSectionQuery rightJoinWithSectionI18n() Adds a RIGHT JOIN clause and with to the query using the SectionI18n relation
 * @method     ChildSectionQuery innerJoinWithSectionI18n() Adds a INNER JOIN clause and with to the query using the SectionI18n relation
 *
 * @method     \Common\DbBundle\Model\BundleQuery|\Common\DbBundle\Model\NewsQuery|\Common\DbBundle\Model\CommentQuery|\Common\DbBundle\Model\MenuQuery|\Common\DbBundle\Model\AdvertQuery|\Common\DbBundle\Model\PlaceQuery|\Common\DbBundle\Model\MarkerQuery|\Hotspot\AccessPointBundle\Model\AccesspointQuery|\Common\DbBundle\Model\SectionI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSection findOne(ConnectionInterface $con = null) Return the first ChildSection matching the query
 * @method     ChildSection findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSection matching the query, or a new ChildSection object populated from the query conditions when no match is found
 *
 * @method     ChildSection findOneById(int $id) Return the first ChildSection filtered by the id column
 * @method     ChildSection findOneByDeep(int $deep) Return the first ChildSection filtered by the deep column
 * @method     ChildSection findOneByParent(int $parent) Return the first ChildSection filtered by the parent column
 * @method     ChildSection findOneByBundleId(int $bundle_id) Return the first ChildSection filtered by the bundle_id column
 * @method     ChildSection findOneByOrders(int $orders) Return the first ChildSection filtered by the orders column
 * @method     ChildSection findOneByCanDelete(boolean $can_delete) Return the first ChildSection filtered by the can_delete column
 * @method     ChildSection findOneByLocked(boolean $locked) Return the first ChildSection filtered by the locked column
 * @method     ChildSection findOneByCreatedAt(string $created_at) Return the first ChildSection filtered by the created_at column
 * @method     ChildSection findOneByUpdatedAt(string $updated_at) Return the first ChildSection filtered by the updated_at column *

 * @method     ChildSection requirePk($key, ConnectionInterface $con = null) Return the ChildSection by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOne(ConnectionInterface $con = null) Return the first ChildSection matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSection requireOneById(int $id) Return the first ChildSection filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByDeep(int $deep) Return the first ChildSection filtered by the deep column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByParent(int $parent) Return the first ChildSection filtered by the parent column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByBundleId(int $bundle_id) Return the first ChildSection filtered by the bundle_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByOrders(int $orders) Return the first ChildSection filtered by the orders column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByCanDelete(boolean $can_delete) Return the first ChildSection filtered by the can_delete column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByLocked(boolean $locked) Return the first ChildSection filtered by the locked column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByCreatedAt(string $created_at) Return the first ChildSection filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSection requireOneByUpdatedAt(string $updated_at) Return the first ChildSection filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSection[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSection objects based on current ModelCriteria
 * @method     ChildSection[]|ObjectCollection findById(int $id) Return ChildSection objects filtered by the id column
 * @method     ChildSection[]|ObjectCollection findByDeep(int $deep) Return ChildSection objects filtered by the deep column
 * @method     ChildSection[]|ObjectCollection findByParent(int $parent) Return ChildSection objects filtered by the parent column
 * @method     ChildSection[]|ObjectCollection findByBundleId(int $bundle_id) Return ChildSection objects filtered by the bundle_id column
 * @method     ChildSection[]|ObjectCollection findByOrders(int $orders) Return ChildSection objects filtered by the orders column
 * @method     ChildSection[]|ObjectCollection findByCanDelete(boolean $can_delete) Return ChildSection objects filtered by the can_delete column
 * @method     ChildSection[]|ObjectCollection findByLocked(boolean $locked) Return ChildSection objects filtered by the locked column
 * @method     ChildSection[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildSection objects filtered by the created_at column
 * @method     ChildSection[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildSection objects filtered by the updated_at column
 * @method     ChildSection[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SectionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\SectionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\Section', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSectionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSectionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSectionQuery) {
            return $criteria;
        }
        $query = new ChildSectionQuery();
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
     * @return ChildSection|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SectionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SectionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildSection A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `deep`, `parent`, `bundle_id`, `orders`, `can_delete`, `locked`, `created_at`, `updated_at` FROM `section` WHERE `id` = :p0';
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
            /** @var ChildSection $obj */
            $obj = new ChildSection();
            $obj->hydrate($row);
            SectionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSection|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SectionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SectionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the deep column
     *
     * Example usage:
     * <code>
     * $query->filterByDeep(1234); // WHERE deep = 1234
     * $query->filterByDeep(array(12, 34)); // WHERE deep IN (12, 34)
     * $query->filterByDeep(array('min' => 12)); // WHERE deep > 12
     * </code>
     *
     * @param     mixed $deep The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByDeep($deep = null, $comparison = null)
    {
        if (is_array($deep)) {
            $useMinMax = false;
            if (isset($deep['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_DEEP, $deep['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deep['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_DEEP, $deep['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_DEEP, $deep, $comparison);
    }

    /**
     * Filter the query on the parent column
     *
     * Example usage:
     * <code>
     * $query->filterByParent(1234); // WHERE parent = 1234
     * $query->filterByParent(array(12, 34)); // WHERE parent IN (12, 34)
     * $query->filterByParent(array('min' => 12)); // WHERE parent > 12
     * </code>
     *
     * @param     mixed $parent The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByParent($parent = null, $comparison = null)
    {
        if (is_array($parent)) {
            $useMinMax = false;
            if (isset($parent['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_PARENT, $parent['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parent['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_PARENT, $parent['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_PARENT, $parent, $comparison);
    }

    /**
     * Filter the query on the bundle_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBundleId(1234); // WHERE bundle_id = 1234
     * $query->filterByBundleId(array(12, 34)); // WHERE bundle_id IN (12, 34)
     * $query->filterByBundleId(array('min' => 12)); // WHERE bundle_id > 12
     * </code>
     *
     * @see       filterByBundle()
     *
     * @param     mixed $bundleId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByBundleId($bundleId = null, $comparison = null)
    {
        if (is_array($bundleId)) {
            $useMinMax = false;
            if (isset($bundleId['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_BUNDLE_ID, $bundleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bundleId['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_BUNDLE_ID, $bundleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_BUNDLE_ID, $bundleId, $comparison);
    }

    /**
     * Filter the query on the orders column
     *
     * Example usage:
     * <code>
     * $query->filterByOrders(1234); // WHERE orders = 1234
     * $query->filterByOrders(array(12, 34)); // WHERE orders IN (12, 34)
     * $query->filterByOrders(array('min' => 12)); // WHERE orders > 12
     * </code>
     *
     * @param     mixed $orders The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByOrders($orders = null, $comparison = null)
    {
        if (is_array($orders)) {
            $useMinMax = false;
            if (isset($orders['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_ORDERS, $orders['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orders['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_ORDERS, $orders['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_ORDERS, $orders, $comparison);
    }

    /**
     * Filter the query on the can_delete column
     *
     * Example usage:
     * <code>
     * $query->filterByCanDelete(true); // WHERE can_delete = true
     * $query->filterByCanDelete('yes'); // WHERE can_delete = true
     * </code>
     *
     * @param     boolean|string $canDelete The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByCanDelete($canDelete = null, $comparison = null)
    {
        if (is_string($canDelete)) {
            $canDelete = in_array(strtolower($canDelete), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SectionTableMap::COL_CAN_DELETE, $canDelete, $comparison);
    }

    /**
     * Filter the query on the locked column
     *
     * Example usage:
     * <code>
     * $query->filterByLocked(true); // WHERE locked = true
     * $query->filterByLocked('yes'); // WHERE locked = true
     * </code>
     *
     * @param     boolean|string $locked The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByLocked($locked = null, $comparison = null)
    {
        if (is_string($locked)) {
            $locked = in_array(strtolower($locked), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SectionTableMap::COL_LOCKED, $locked, $comparison);
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(SectionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(SectionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Bundle object
     *
     * @param \Common\DbBundle\Model\Bundle|ObjectCollection $bundle The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterByBundle($bundle, $comparison = null)
    {
        if ($bundle instanceof \Common\DbBundle\Model\Bundle) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_BUNDLE_ID, $bundle->getId(), $comparison);
        } elseif ($bundle instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SectionTableMap::COL_BUNDLE_ID, $bundle->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBundle() only accepts arguments of type \Common\DbBundle\Model\Bundle or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Bundle relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinBundle($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Bundle');

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
            $this->addJoinObject($join, 'Bundle');
        }

        return $this;
    }

    /**
     * Use the Bundle relation Bundle object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\BundleQuery A secondary query class using the current class as primary query
     */
    public function useBundleQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBundle($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Bundle', '\Common\DbBundle\Model\BundleQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\News object
     *
     * @param \Common\DbBundle\Model\News|ObjectCollection $news the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterByNews($news, $comparison = null)
    {
        if ($news instanceof \Common\DbBundle\Model\News) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_ID, $news->getSectionId(), $comparison);
        } elseif ($news instanceof ObjectCollection) {
            return $this
                ->useNewsQuery()
                ->filterByPrimaryKeys($news->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByNews() only accepts arguments of type \Common\DbBundle\Model\News or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the News relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinNews($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('News');

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
            $this->addJoinObject($join, 'News');
        }

        return $this;
    }

    /**
     * Use the News relation News object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\NewsQuery A secondary query class using the current class as primary query
     */
    public function useNewsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinNews($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'News', '\Common\DbBundle\Model\NewsQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Comment object
     *
     * @param \Common\DbBundle\Model\Comment|ObjectCollection $comment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterByComment($comment, $comparison = null)
    {
        if ($comment instanceof \Common\DbBundle\Model\Comment) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_ID, $comment->getSectionId(), $comparison);
        } elseif ($comment instanceof ObjectCollection) {
            return $this
                ->useCommentQuery()
                ->filterByPrimaryKeys($comment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByComment() only accepts arguments of type \Common\DbBundle\Model\Comment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Comment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinComment($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Comment');

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
            $this->addJoinObject($join, 'Comment');
        }

        return $this;
    }

    /**
     * Use the Comment relation Comment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\CommentQuery A secondary query class using the current class as primary query
     */
    public function useCommentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinComment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Comment', '\Common\DbBundle\Model\CommentQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Menu object
     *
     * @param \Common\DbBundle\Model\Menu|ObjectCollection $menu the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterByMenu($menu, $comparison = null)
    {
        if ($menu instanceof \Common\DbBundle\Model\Menu) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_ID, $menu->getSectionId(), $comparison);
        } elseif ($menu instanceof ObjectCollection) {
            return $this
                ->useMenuQuery()
                ->filterByPrimaryKeys($menu->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMenu() only accepts arguments of type \Common\DbBundle\Model\Menu or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Menu relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinMenu($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Menu');

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
            $this->addJoinObject($join, 'Menu');
        }

        return $this;
    }

    /**
     * Use the Menu relation Menu object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\MenuQuery A secondary query class using the current class as primary query
     */
    public function useMenuQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMenu($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Menu', '\Common\DbBundle\Model\MenuQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Advert object
     *
     * @param \Common\DbBundle\Model\Advert|ObjectCollection $advert the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterByAdvert($advert, $comparison = null)
    {
        if ($advert instanceof \Common\DbBundle\Model\Advert) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_ID, $advert->getSectionId(), $comparison);
        } elseif ($advert instanceof ObjectCollection) {
            return $this
                ->useAdvertQuery()
                ->filterByPrimaryKeys($advert->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvert() only accepts arguments of type \Common\DbBundle\Model\Advert or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Advert relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinAdvert($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Advert');

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
            $this->addJoinObject($join, 'Advert');
        }

        return $this;
    }

    /**
     * Use the Advert relation Advert object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\AdvertQuery A secondary query class using the current class as primary query
     */
    public function useAdvertQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdvert($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Advert', '\Common\DbBundle\Model\AdvertQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Place object
     *
     * @param \Common\DbBundle\Model\Place|ObjectCollection $place the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterByPlace($place, $comparison = null)
    {
        if ($place instanceof \Common\DbBundle\Model\Place) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_ID, $place->getSectionId(), $comparison);
        } elseif ($place instanceof ObjectCollection) {
            return $this
                ->usePlaceQuery()
                ->filterByPrimaryKeys($place->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPlace() only accepts arguments of type \Common\DbBundle\Model\Place or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Place relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinPlace($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Place');

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
            $this->addJoinObject($join, 'Place');
        }

        return $this;
    }

    /**
     * Use the Place relation Place object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\PlaceQuery A secondary query class using the current class as primary query
     */
    public function usePlaceQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPlace($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Place', '\Common\DbBundle\Model\PlaceQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Marker object
     *
     * @param \Common\DbBundle\Model\Marker|ObjectCollection $marker the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterByMarker($marker, $comparison = null)
    {
        if ($marker instanceof \Common\DbBundle\Model\Marker) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_ID, $marker->getSectionId(), $comparison);
        } elseif ($marker instanceof ObjectCollection) {
            return $this
                ->useMarkerQuery()
                ->filterByPrimaryKeys($marker->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMarker() only accepts arguments of type \Common\DbBundle\Model\Marker or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Marker relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinMarker($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Marker');

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
            $this->addJoinObject($join, 'Marker');
        }

        return $this;
    }

    /**
     * Use the Marker relation Marker object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\MarkerQuery A secondary query class using the current class as primary query
     */
    public function useMarkerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMarker($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Marker', '\Common\DbBundle\Model\MarkerQuery');
    }

    /**
     * Filter the query by a related \Hotspot\AccessPointBundle\Model\Accesspoint object
     *
     * @param \Hotspot\AccessPointBundle\Model\Accesspoint|ObjectCollection $accesspoint the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterByAccesspoint($accesspoint, $comparison = null)
    {
        if ($accesspoint instanceof \Hotspot\AccessPointBundle\Model\Accesspoint) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_ID, $accesspoint->getSectionId(), $comparison);
        } elseif ($accesspoint instanceof ObjectCollection) {
            return $this
                ->useAccesspointQuery()
                ->filterByPrimaryKeys($accesspoint->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccesspoint() only accepts arguments of type \Hotspot\AccessPointBundle\Model\Accesspoint or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Accesspoint relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinAccesspoint($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Accesspoint');

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
            $this->addJoinObject($join, 'Accesspoint');
        }

        return $this;
    }

    /**
     * Use the Accesspoint relation Accesspoint object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Hotspot\AccessPointBundle\Model\AccesspointQuery A secondary query class using the current class as primary query
     */
    public function useAccesspointQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAccesspoint($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Accesspoint', '\Hotspot\AccessPointBundle\Model\AccesspointQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\SectionI18n object
     *
     * @param \Common\DbBundle\Model\SectionI18n|ObjectCollection $sectionI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSectionQuery The current query, for fluid interface
     */
    public function filterBySectionI18n($sectionI18n, $comparison = null)
    {
        if ($sectionI18n instanceof \Common\DbBundle\Model\SectionI18n) {
            return $this
                ->addUsingAlias(SectionTableMap::COL_ID, $sectionI18n->getId(), $comparison);
        } elseif ($sectionI18n instanceof ObjectCollection) {
            return $this
                ->useSectionI18nQuery()
                ->filterByPrimaryKeys($sectionI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySectionI18n() only accepts arguments of type \Common\DbBundle\Model\SectionI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SectionI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinSectionI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SectionI18n');

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
            $this->addJoinObject($join, 'SectionI18n');
        }

        return $this;
    }

    /**
     * Use the SectionI18n relation SectionI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\SectionI18nQuery A secondary query class using the current class as primary query
     */
    public function useSectionI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinSectionI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SectionI18n', '\Common\DbBundle\Model\SectionI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSection $section Object to remove from the list of results
     *
     * @return $this|ChildSectionQuery The current query, for fluid interface
     */
    public function prune($section = null)
    {
        if ($section) {
            $this->addUsingAlias(SectionTableMap::COL_ID, $section->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the section table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SectionTableMap::clearInstancePool();
            SectionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SectionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SectionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SectionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SectionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildSectionQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(SectionTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildSectionQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(SectionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildSectionQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(SectionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildSectionQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(SectionTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildSectionQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(SectionTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildSectionQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(SectionTableMap::COL_CREATED_AT);
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildSectionQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'SectionI18n';

        return $this
            ->joinSectionI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildSectionQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'vi', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('SectionI18n');
        $this->with['SectionI18n']->setIsWithOneToMany(false);

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
     * @return    ChildSectionI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SectionI18n', '\Common\DbBundle\Model\SectionI18nQuery');
    }

} // SectionQuery
