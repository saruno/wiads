<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\Marker as ChildMarker;
use Common\DbBundle\Model\MarkerI18nQuery as ChildMarkerI18nQuery;
use Common\DbBundle\Model\MarkerQuery as ChildMarkerQuery;
use Common\DbBundle\Model\Map\MarkerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'marker' table.
 *
 *
 *
 * @method     ChildMarkerQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMarkerQuery orderByImage($order = Criteria::ASC) Order by the image column
 * @method     ChildMarkerQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method     ChildMarkerQuery orderByLongitude($order = Criteria::ASC) Order by the longitude column
 * @method     ChildMarkerQuery orderByLatitude($order = Criteria::ASC) Order by the latitude column
 * @method     ChildMarkerQuery orderByDetailUrlId($order = Criteria::ASC) Order by the detail_url_id column
 * @method     ChildMarkerQuery orderBySectionId($order = Criteria::ASC) Order by the section_id column
 * @method     ChildMarkerQuery orderBySubsectionIds($order = Criteria::ASC) Order by the subsection_ids column
 * @method     ChildMarkerQuery orderByOrders($order = Criteria::ASC) Order by the orders column
 * @method     ChildMarkerQuery orderBySuborderIds($order = Criteria::ASC) Order by the suborder_ids column
 * @method     ChildMarkerQuery orderByFrontPage($order = Criteria::ASC) Order by the front_page column
 * @method     ChildMarkerQuery orderByHasComment($order = Criteria::ASC) Order by the has_comment column
 * @method     ChildMarkerQuery orderByCanDelete($order = Criteria::ASC) Order by the can_delete column
 * @method     ChildMarkerQuery orderByPublishedAt($order = Criteria::ASC) Order by the published_at column
 * @method     ChildMarkerQuery orderByImgs($order = Criteria::ASC) Order by the imgs column
 * @method     ChildMarkerQuery orderByRelativeNews($order = Criteria::ASC) Order by the relative_news column
 * @method     ChildMarkerQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildMarkerQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildMarkerQuery groupById() Group by the id column
 * @method     ChildMarkerQuery groupByImage() Group by the image column
 * @method     ChildMarkerQuery groupByCategoryId() Group by the category_id column
 * @method     ChildMarkerQuery groupByLongitude() Group by the longitude column
 * @method     ChildMarkerQuery groupByLatitude() Group by the latitude column
 * @method     ChildMarkerQuery groupByDetailUrlId() Group by the detail_url_id column
 * @method     ChildMarkerQuery groupBySectionId() Group by the section_id column
 * @method     ChildMarkerQuery groupBySubsectionIds() Group by the subsection_ids column
 * @method     ChildMarkerQuery groupByOrders() Group by the orders column
 * @method     ChildMarkerQuery groupBySuborderIds() Group by the suborder_ids column
 * @method     ChildMarkerQuery groupByFrontPage() Group by the front_page column
 * @method     ChildMarkerQuery groupByHasComment() Group by the has_comment column
 * @method     ChildMarkerQuery groupByCanDelete() Group by the can_delete column
 * @method     ChildMarkerQuery groupByPublishedAt() Group by the published_at column
 * @method     ChildMarkerQuery groupByImgs() Group by the imgs column
 * @method     ChildMarkerQuery groupByRelativeNews() Group by the relative_news column
 * @method     ChildMarkerQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildMarkerQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildMarkerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMarkerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMarkerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMarkerQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMarkerQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMarkerQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMarkerQuery leftJoinSection($relationAlias = null) Adds a LEFT JOIN clause to the query using the Section relation
 * @method     ChildMarkerQuery rightJoinSection($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Section relation
 * @method     ChildMarkerQuery innerJoinSection($relationAlias = null) Adds a INNER JOIN clause to the query using the Section relation
 *
 * @method     ChildMarkerQuery joinWithSection($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Section relation
 *
 * @method     ChildMarkerQuery leftJoinWithSection() Adds a LEFT JOIN clause and with to the query using the Section relation
 * @method     ChildMarkerQuery rightJoinWithSection() Adds a RIGHT JOIN clause and with to the query using the Section relation
 * @method     ChildMarkerQuery innerJoinWithSection() Adds a INNER JOIN clause and with to the query using the Section relation
 *
 * @method     ChildMarkerQuery leftJoinMarkerCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the MarkerCategory relation
 * @method     ChildMarkerQuery rightJoinMarkerCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MarkerCategory relation
 * @method     ChildMarkerQuery innerJoinMarkerCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the MarkerCategory relation
 *
 * @method     ChildMarkerQuery joinWithMarkerCategory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MarkerCategory relation
 *
 * @method     ChildMarkerQuery leftJoinWithMarkerCategory() Adds a LEFT JOIN clause and with to the query using the MarkerCategory relation
 * @method     ChildMarkerQuery rightJoinWithMarkerCategory() Adds a RIGHT JOIN clause and with to the query using the MarkerCategory relation
 * @method     ChildMarkerQuery innerJoinWithMarkerCategory() Adds a INNER JOIN clause and with to the query using the MarkerCategory relation
 *
 * @method     ChildMarkerQuery leftJoinMarkerI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the MarkerI18n relation
 * @method     ChildMarkerQuery rightJoinMarkerI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MarkerI18n relation
 * @method     ChildMarkerQuery innerJoinMarkerI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the MarkerI18n relation
 *
 * @method     ChildMarkerQuery joinWithMarkerI18n($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MarkerI18n relation
 *
 * @method     ChildMarkerQuery leftJoinWithMarkerI18n() Adds a LEFT JOIN clause and with to the query using the MarkerI18n relation
 * @method     ChildMarkerQuery rightJoinWithMarkerI18n() Adds a RIGHT JOIN clause and with to the query using the MarkerI18n relation
 * @method     ChildMarkerQuery innerJoinWithMarkerI18n() Adds a INNER JOIN clause and with to the query using the MarkerI18n relation
 *
 * @method     \Common\DbBundle\Model\SectionQuery|\Common\DbBundle\Model\MarkerCategoryQuery|\Common\DbBundle\Model\MarkerI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMarker findOne(ConnectionInterface $con = null) Return the first ChildMarker matching the query
 * @method     ChildMarker findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMarker matching the query, or a new ChildMarker object populated from the query conditions when no match is found
 *
 * @method     ChildMarker findOneById(int $id) Return the first ChildMarker filtered by the id column
 * @method     ChildMarker findOneByImage(string $image) Return the first ChildMarker filtered by the image column
 * @method     ChildMarker findOneByCategoryId(int $category_id) Return the first ChildMarker filtered by the category_id column
 * @method     ChildMarker findOneByLongitude(string $longitude) Return the first ChildMarker filtered by the longitude column
 * @method     ChildMarker findOneByLatitude(string $latitude) Return the first ChildMarker filtered by the latitude column
 * @method     ChildMarker findOneByDetailUrlId(string $detail_url_id) Return the first ChildMarker filtered by the detail_url_id column
 * @method     ChildMarker findOneBySectionId(int $section_id) Return the first ChildMarker filtered by the section_id column
 * @method     ChildMarker findOneBySubsectionIds(string $subsection_ids) Return the first ChildMarker filtered by the subsection_ids column
 * @method     ChildMarker findOneByOrders(int $orders) Return the first ChildMarker filtered by the orders column
 * @method     ChildMarker findOneBySuborderIds(string $suborder_ids) Return the first ChildMarker filtered by the suborder_ids column
 * @method     ChildMarker findOneByFrontPage(boolean $front_page) Return the first ChildMarker filtered by the front_page column
 * @method     ChildMarker findOneByHasComment(boolean $has_comment) Return the first ChildMarker filtered by the has_comment column
 * @method     ChildMarker findOneByCanDelete(boolean $can_delete) Return the first ChildMarker filtered by the can_delete column
 * @method     ChildMarker findOneByPublishedAt(string $published_at) Return the first ChildMarker filtered by the published_at column
 * @method     ChildMarker findOneByImgs(string $imgs) Return the first ChildMarker filtered by the imgs column
 * @method     ChildMarker findOneByRelativeNews(string $relative_news) Return the first ChildMarker filtered by the relative_news column
 * @method     ChildMarker findOneByCreatedAt(string $created_at) Return the first ChildMarker filtered by the created_at column
 * @method     ChildMarker findOneByUpdatedAt(string $updated_at) Return the first ChildMarker filtered by the updated_at column *

 * @method     ChildMarker requirePk($key, ConnectionInterface $con = null) Return the ChildMarker by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOne(ConnectionInterface $con = null) Return the first ChildMarker matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMarker requireOneById(int $id) Return the first ChildMarker filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByImage(string $image) Return the first ChildMarker filtered by the image column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByCategoryId(int $category_id) Return the first ChildMarker filtered by the category_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByLongitude(string $longitude) Return the first ChildMarker filtered by the longitude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByLatitude(string $latitude) Return the first ChildMarker filtered by the latitude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByDetailUrlId(string $detail_url_id) Return the first ChildMarker filtered by the detail_url_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneBySectionId(int $section_id) Return the first ChildMarker filtered by the section_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneBySubsectionIds(string $subsection_ids) Return the first ChildMarker filtered by the subsection_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByOrders(int $orders) Return the first ChildMarker filtered by the orders column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneBySuborderIds(string $suborder_ids) Return the first ChildMarker filtered by the suborder_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByFrontPage(boolean $front_page) Return the first ChildMarker filtered by the front_page column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByHasComment(boolean $has_comment) Return the first ChildMarker filtered by the has_comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByCanDelete(boolean $can_delete) Return the first ChildMarker filtered by the can_delete column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByPublishedAt(string $published_at) Return the first ChildMarker filtered by the published_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByImgs(string $imgs) Return the first ChildMarker filtered by the imgs column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByRelativeNews(string $relative_news) Return the first ChildMarker filtered by the relative_news column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByCreatedAt(string $created_at) Return the first ChildMarker filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMarker requireOneByUpdatedAt(string $updated_at) Return the first ChildMarker filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMarker[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMarker objects based on current ModelCriteria
 * @method     ChildMarker[]|ObjectCollection findById(int $id) Return ChildMarker objects filtered by the id column
 * @method     ChildMarker[]|ObjectCollection findByImage(string $image) Return ChildMarker objects filtered by the image column
 * @method     ChildMarker[]|ObjectCollection findByCategoryId(int $category_id) Return ChildMarker objects filtered by the category_id column
 * @method     ChildMarker[]|ObjectCollection findByLongitude(string $longitude) Return ChildMarker objects filtered by the longitude column
 * @method     ChildMarker[]|ObjectCollection findByLatitude(string $latitude) Return ChildMarker objects filtered by the latitude column
 * @method     ChildMarker[]|ObjectCollection findByDetailUrlId(string $detail_url_id) Return ChildMarker objects filtered by the detail_url_id column
 * @method     ChildMarker[]|ObjectCollection findBySectionId(int $section_id) Return ChildMarker objects filtered by the section_id column
 * @method     ChildMarker[]|ObjectCollection findBySubsectionIds(string $subsection_ids) Return ChildMarker objects filtered by the subsection_ids column
 * @method     ChildMarker[]|ObjectCollection findByOrders(int $orders) Return ChildMarker objects filtered by the orders column
 * @method     ChildMarker[]|ObjectCollection findBySuborderIds(string $suborder_ids) Return ChildMarker objects filtered by the suborder_ids column
 * @method     ChildMarker[]|ObjectCollection findByFrontPage(boolean $front_page) Return ChildMarker objects filtered by the front_page column
 * @method     ChildMarker[]|ObjectCollection findByHasComment(boolean $has_comment) Return ChildMarker objects filtered by the has_comment column
 * @method     ChildMarker[]|ObjectCollection findByCanDelete(boolean $can_delete) Return ChildMarker objects filtered by the can_delete column
 * @method     ChildMarker[]|ObjectCollection findByPublishedAt(string $published_at) Return ChildMarker objects filtered by the published_at column
 * @method     ChildMarker[]|ObjectCollection findByImgs(string $imgs) Return ChildMarker objects filtered by the imgs column
 * @method     ChildMarker[]|ObjectCollection findByRelativeNews(string $relative_news) Return ChildMarker objects filtered by the relative_news column
 * @method     ChildMarker[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildMarker objects filtered by the created_at column
 * @method     ChildMarker[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildMarker objects filtered by the updated_at column
 * @method     ChildMarker[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MarkerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\MarkerQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\Marker', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMarkerQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMarkerQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMarkerQuery) {
            return $criteria;
        }
        $query = new ChildMarkerQuery();
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
     * @return ChildMarker|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MarkerTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MarkerTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMarker A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `image`, `category_id`, `longitude`, `latitude`, `detail_url_id`, `section_id`, `subsection_ids`, `orders`, `suborder_ids`, `front_page`, `has_comment`, `can_delete`, `published_at`, `imgs`, `relative_news`, `created_at`, `updated_at` FROM `marker` WHERE `id` = :p0';
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
            /** @var ChildMarker $obj */
            $obj = new ChildMarker();
            $obj->hydrate($row);
            MarkerTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMarker|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MarkerTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MarkerTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MarkerTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MarkerTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the image column
     *
     * Example usage:
     * <code>
     * $query->filterByImage('fooValue');   // WHERE image = 'fooValue'
     * $query->filterByImage('%fooValue%', Criteria::LIKE); // WHERE image LIKE '%fooValue%'
     * </code>
     *
     * @param     string $image The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByImage($image = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($image)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_IMAGE, $image, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id > 12
     * </code>
     *
     * @see       filterByMarkerCategory()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(MarkerTableMap::COL_CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(MarkerTableMap::COL_CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the longitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLongitude('fooValue');   // WHERE longitude = 'fooValue'
     * $query->filterByLongitude('%fooValue%', Criteria::LIKE); // WHERE longitude LIKE '%fooValue%'
     * </code>
     *
     * @param     string $longitude The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByLongitude($longitude = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($longitude)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_LONGITUDE, $longitude, $comparison);
    }

    /**
     * Filter the query on the latitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLatitude('fooValue');   // WHERE latitude = 'fooValue'
     * $query->filterByLatitude('%fooValue%', Criteria::LIKE); // WHERE latitude LIKE '%fooValue%'
     * </code>
     *
     * @param     string $latitude The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByLatitude($latitude = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($latitude)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_LATITUDE, $latitude, $comparison);
    }

    /**
     * Filter the query on the detail_url_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDetailUrlId('fooValue');   // WHERE detail_url_id = 'fooValue'
     * $query->filterByDetailUrlId('%fooValue%', Criteria::LIKE); // WHERE detail_url_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $detailUrlId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByDetailUrlId($detailUrlId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($detailUrlId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_DETAIL_URL_ID, $detailUrlId, $comparison);
    }

    /**
     * Filter the query on the section_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySectionId(1234); // WHERE section_id = 1234
     * $query->filterBySectionId(array(12, 34)); // WHERE section_id IN (12, 34)
     * $query->filterBySectionId(array('min' => 12)); // WHERE section_id > 12
     * </code>
     *
     * @see       filterBySection()
     *
     * @param     mixed $sectionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterBySectionId($sectionId = null, $comparison = null)
    {
        if (is_array($sectionId)) {
            $useMinMax = false;
            if (isset($sectionId['min'])) {
                $this->addUsingAlias(MarkerTableMap::COL_SECTION_ID, $sectionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sectionId['max'])) {
                $this->addUsingAlias(MarkerTableMap::COL_SECTION_ID, $sectionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_SECTION_ID, $sectionId, $comparison);
    }

    /**
     * Filter the query on the subsection_ids column
     *
     * Example usage:
     * <code>
     * $query->filterBySubsectionIds('fooValue');   // WHERE subsection_ids = 'fooValue'
     * $query->filterBySubsectionIds('%fooValue%', Criteria::LIKE); // WHERE subsection_ids LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subsectionIds The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterBySubsectionIds($subsectionIds = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subsectionIds)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_SUBSECTION_IDS, $subsectionIds, $comparison);
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
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByOrders($orders = null, $comparison = null)
    {
        if (is_array($orders)) {
            $useMinMax = false;
            if (isset($orders['min'])) {
                $this->addUsingAlias(MarkerTableMap::COL_ORDERS, $orders['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orders['max'])) {
                $this->addUsingAlias(MarkerTableMap::COL_ORDERS, $orders['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_ORDERS, $orders, $comparison);
    }

    /**
     * Filter the query on the suborder_ids column
     *
     * Example usage:
     * <code>
     * $query->filterBySuborderIds('fooValue');   // WHERE suborder_ids = 'fooValue'
     * $query->filterBySuborderIds('%fooValue%', Criteria::LIKE); // WHERE suborder_ids LIKE '%fooValue%'
     * </code>
     *
     * @param     string $suborderIds The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterBySuborderIds($suborderIds = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($suborderIds)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_SUBORDER_IDS, $suborderIds, $comparison);
    }

    /**
     * Filter the query on the front_page column
     *
     * Example usage:
     * <code>
     * $query->filterByFrontPage(true); // WHERE front_page = true
     * $query->filterByFrontPage('yes'); // WHERE front_page = true
     * </code>
     *
     * @param     boolean|string $frontPage The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByFrontPage($frontPage = null, $comparison = null)
    {
        if (is_string($frontPage)) {
            $frontPage = in_array(strtolower($frontPage), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MarkerTableMap::COL_FRONT_PAGE, $frontPage, $comparison);
    }

    /**
     * Filter the query on the has_comment column
     *
     * Example usage:
     * <code>
     * $query->filterByHasComment(true); // WHERE has_comment = true
     * $query->filterByHasComment('yes'); // WHERE has_comment = true
     * </code>
     *
     * @param     boolean|string $hasComment The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByHasComment($hasComment = null, $comparison = null)
    {
        if (is_string($hasComment)) {
            $hasComment = in_array(strtolower($hasComment), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MarkerTableMap::COL_HAS_COMMENT, $hasComment, $comparison);
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
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByCanDelete($canDelete = null, $comparison = null)
    {
        if (is_string($canDelete)) {
            $canDelete = in_array(strtolower($canDelete), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MarkerTableMap::COL_CAN_DELETE, $canDelete, $comparison);
    }

    /**
     * Filter the query on the published_at column
     *
     * Example usage:
     * <code>
     * $query->filterByPublishedAt('2011-03-14'); // WHERE published_at = '2011-03-14'
     * $query->filterByPublishedAt('now'); // WHERE published_at = '2011-03-14'
     * $query->filterByPublishedAt(array('max' => 'yesterday')); // WHERE published_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $publishedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByPublishedAt($publishedAt = null, $comparison = null)
    {
        if (is_array($publishedAt)) {
            $useMinMax = false;
            if (isset($publishedAt['min'])) {
                $this->addUsingAlias(MarkerTableMap::COL_PUBLISHED_AT, $publishedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishedAt['max'])) {
                $this->addUsingAlias(MarkerTableMap::COL_PUBLISHED_AT, $publishedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_PUBLISHED_AT, $publishedAt, $comparison);
    }

    /**
     * Filter the query on the imgs column
     *
     * Example usage:
     * <code>
     * $query->filterByImgs('fooValue');   // WHERE imgs = 'fooValue'
     * $query->filterByImgs('%fooValue%', Criteria::LIKE); // WHERE imgs LIKE '%fooValue%'
     * </code>
     *
     * @param     string $imgs The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByImgs($imgs = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imgs)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_IMGS, $imgs, $comparison);
    }

    /**
     * Filter the query on the relative_news column
     *
     * Example usage:
     * <code>
     * $query->filterByRelativeNews('fooValue');   // WHERE relative_news = 'fooValue'
     * $query->filterByRelativeNews('%fooValue%', Criteria::LIKE); // WHERE relative_news LIKE '%fooValue%'
     * </code>
     *
     * @param     string $relativeNews The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByRelativeNews($relativeNews = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($relativeNews)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_RELATIVE_NEWS, $relativeNews, $comparison);
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
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MarkerTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MarkerTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MarkerTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MarkerTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MarkerTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Section object
     *
     * @param \Common\DbBundle\Model\Section|ObjectCollection $section The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMarkerQuery The current query, for fluid interface
     */
    public function filterBySection($section, $comparison = null)
    {
        if ($section instanceof \Common\DbBundle\Model\Section) {
            return $this
                ->addUsingAlias(MarkerTableMap::COL_SECTION_ID, $section->getId(), $comparison);
        } elseif ($section instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MarkerTableMap::COL_SECTION_ID, $section->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySection() only accepts arguments of type \Common\DbBundle\Model\Section or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Section relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function joinSection($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Section');

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
            $this->addJoinObject($join, 'Section');
        }

        return $this;
    }

    /**
     * Use the Section relation Section object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\SectionQuery A secondary query class using the current class as primary query
     */
    public function useSectionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSection($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Section', '\Common\DbBundle\Model\SectionQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\MarkerCategory object
     *
     * @param \Common\DbBundle\Model\MarkerCategory|ObjectCollection $markerCategory The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByMarkerCategory($markerCategory, $comparison = null)
    {
        if ($markerCategory instanceof \Common\DbBundle\Model\MarkerCategory) {
            return $this
                ->addUsingAlias(MarkerTableMap::COL_CATEGORY_ID, $markerCategory->getId(), $comparison);
        } elseif ($markerCategory instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MarkerTableMap::COL_CATEGORY_ID, $markerCategory->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMarkerCategory() only accepts arguments of type \Common\DbBundle\Model\MarkerCategory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MarkerCategory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function joinMarkerCategory($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MarkerCategory');

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
            $this->addJoinObject($join, 'MarkerCategory');
        }

        return $this;
    }

    /**
     * Use the MarkerCategory relation MarkerCategory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\MarkerCategoryQuery A secondary query class using the current class as primary query
     */
    public function useMarkerCategoryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMarkerCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MarkerCategory', '\Common\DbBundle\Model\MarkerCategoryQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\MarkerI18n object
     *
     * @param \Common\DbBundle\Model\MarkerI18n|ObjectCollection $markerI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMarkerQuery The current query, for fluid interface
     */
    public function filterByMarkerI18n($markerI18n, $comparison = null)
    {
        if ($markerI18n instanceof \Common\DbBundle\Model\MarkerI18n) {
            return $this
                ->addUsingAlias(MarkerTableMap::COL_ID, $markerI18n->getId(), $comparison);
        } elseif ($markerI18n instanceof ObjectCollection) {
            return $this
                ->useMarkerI18nQuery()
                ->filterByPrimaryKeys($markerI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMarkerI18n() only accepts arguments of type \Common\DbBundle\Model\MarkerI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MarkerI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function joinMarkerI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MarkerI18n');

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
            $this->addJoinObject($join, 'MarkerI18n');
        }

        return $this;
    }

    /**
     * Use the MarkerI18n relation MarkerI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\MarkerI18nQuery A secondary query class using the current class as primary query
     */
    public function useMarkerI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinMarkerI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MarkerI18n', '\Common\DbBundle\Model\MarkerI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMarker $marker Object to remove from the list of results
     *
     * @return $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function prune($marker = null)
    {
        if ($marker) {
            $this->addUsingAlias(MarkerTableMap::COL_ID, $marker->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the marker table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MarkerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MarkerTableMap::clearInstancePool();
            MarkerTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MarkerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MarkerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MarkerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MarkerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(MarkerTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(MarkerTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(MarkerTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(MarkerTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(MarkerTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(MarkerTableMap::COL_CREATED_AT);
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildMarkerQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'MarkerI18n';

        return $this
            ->joinMarkerI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildMarkerQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'vi', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('MarkerI18n');
        $this->with['MarkerI18n']->setIsWithOneToMany(false);

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
     * @return    ChildMarkerI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MarkerI18n', '\Common\DbBundle\Model\MarkerI18nQuery');
    }

} // MarkerQuery
