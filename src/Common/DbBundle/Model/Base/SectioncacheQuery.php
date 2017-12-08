<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\Sectioncache as ChildSectioncache;
use Common\DbBundle\Model\SectioncacheQuery as ChildSectioncacheQuery;
use Common\DbBundle\Model\Map\SectioncacheTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sectioncache' table.
 *
 *
 *
 * @method     ChildSectioncacheQuery orderBySectionId($order = Criteria::ASC) Order by the section_id column
 * @method     ChildSectioncacheQuery orderByNewsId($order = Criteria::ASC) Order by the news_id column
 * @method     ChildSectioncacheQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildSectioncacheQuery orderByLink($order = Criteria::ASC) Order by the link column
 * @method     ChildSectioncacheQuery orderByOrders($order = Criteria::ASC) Order by the orders column
 * @method     ChildSectioncacheQuery orderByRead($order = Criteria::ASC) Order by the read column
 * @method     ChildSectioncacheQuery orderByPublishedAt($order = Criteria::ASC) Order by the published_at column
 * @method     ChildSectioncacheQuery orderByLocked($order = Criteria::ASC) Order by the locked column
 * @method     ChildSectioncacheQuery orderByFrontPage($order = Criteria::ASC) Order by the front_page column
 *
 * @method     ChildSectioncacheQuery groupBySectionId() Group by the section_id column
 * @method     ChildSectioncacheQuery groupByNewsId() Group by the news_id column
 * @method     ChildSectioncacheQuery groupByLocale() Group by the locale column
 * @method     ChildSectioncacheQuery groupByLink() Group by the link column
 * @method     ChildSectioncacheQuery groupByOrders() Group by the orders column
 * @method     ChildSectioncacheQuery groupByRead() Group by the read column
 * @method     ChildSectioncacheQuery groupByPublishedAt() Group by the published_at column
 * @method     ChildSectioncacheQuery groupByLocked() Group by the locked column
 * @method     ChildSectioncacheQuery groupByFrontPage() Group by the front_page column
 *
 * @method     ChildSectioncacheQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSectioncacheQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSectioncacheQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSectioncacheQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSectioncacheQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSectioncacheQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSectioncache findOne(ConnectionInterface $con = null) Return the first ChildSectioncache matching the query
 * @method     ChildSectioncache findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSectioncache matching the query, or a new ChildSectioncache object populated from the query conditions when no match is found
 *
 * @method     ChildSectioncache findOneBySectionId(int $section_id) Return the first ChildSectioncache filtered by the section_id column
 * @method     ChildSectioncache findOneByNewsId(int $news_id) Return the first ChildSectioncache filtered by the news_id column
 * @method     ChildSectioncache findOneByLocale(string $locale) Return the first ChildSectioncache filtered by the locale column
 * @method     ChildSectioncache findOneByLink(string $link) Return the first ChildSectioncache filtered by the link column
 * @method     ChildSectioncache findOneByOrders(int $orders) Return the first ChildSectioncache filtered by the orders column
 * @method     ChildSectioncache findOneByRead(int $read) Return the first ChildSectioncache filtered by the read column
 * @method     ChildSectioncache findOneByPublishedAt(string $published_at) Return the first ChildSectioncache filtered by the published_at column
 * @method     ChildSectioncache findOneByLocked(boolean $locked) Return the first ChildSectioncache filtered by the locked column
 * @method     ChildSectioncache findOneByFrontPage(boolean $front_page) Return the first ChildSectioncache filtered by the front_page column *

 * @method     ChildSectioncache requirePk($key, ConnectionInterface $con = null) Return the ChildSectioncache by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectioncache requireOne(ConnectionInterface $con = null) Return the first ChildSectioncache matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSectioncache requireOneBySectionId(int $section_id) Return the first ChildSectioncache filtered by the section_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectioncache requireOneByNewsId(int $news_id) Return the first ChildSectioncache filtered by the news_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectioncache requireOneByLocale(string $locale) Return the first ChildSectioncache filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectioncache requireOneByLink(string $link) Return the first ChildSectioncache filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectioncache requireOneByOrders(int $orders) Return the first ChildSectioncache filtered by the orders column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectioncache requireOneByRead(int $read) Return the first ChildSectioncache filtered by the read column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectioncache requireOneByPublishedAt(string $published_at) Return the first ChildSectioncache filtered by the published_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectioncache requireOneByLocked(boolean $locked) Return the first ChildSectioncache filtered by the locked column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectioncache requireOneByFrontPage(boolean $front_page) Return the first ChildSectioncache filtered by the front_page column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSectioncache[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSectioncache objects based on current ModelCriteria
 * @method     ChildSectioncache[]|ObjectCollection findBySectionId(int $section_id) Return ChildSectioncache objects filtered by the section_id column
 * @method     ChildSectioncache[]|ObjectCollection findByNewsId(int $news_id) Return ChildSectioncache objects filtered by the news_id column
 * @method     ChildSectioncache[]|ObjectCollection findByLocale(string $locale) Return ChildSectioncache objects filtered by the locale column
 * @method     ChildSectioncache[]|ObjectCollection findByLink(string $link) Return ChildSectioncache objects filtered by the link column
 * @method     ChildSectioncache[]|ObjectCollection findByOrders(int $orders) Return ChildSectioncache objects filtered by the orders column
 * @method     ChildSectioncache[]|ObjectCollection findByRead(int $read) Return ChildSectioncache objects filtered by the read column
 * @method     ChildSectioncache[]|ObjectCollection findByPublishedAt(string $published_at) Return ChildSectioncache objects filtered by the published_at column
 * @method     ChildSectioncache[]|ObjectCollection findByLocked(boolean $locked) Return ChildSectioncache objects filtered by the locked column
 * @method     ChildSectioncache[]|ObjectCollection findByFrontPage(boolean $front_page) Return ChildSectioncache objects filtered by the front_page column
 * @method     ChildSectioncache[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SectioncacheQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\SectioncacheQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\Sectioncache', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSectioncacheQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSectioncacheQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSectioncacheQuery) {
            return $criteria;
        }
        $query = new ChildSectioncacheQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$section_id, $news_id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSectioncache|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SectioncacheTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SectioncacheTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]))))) {
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
     * @return ChildSectioncache A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `section_id`, `news_id`, `locale`, `link`, `orders`, `read`, `published_at`, `locked`, `front_page` FROM `sectioncache` WHERE `section_id` = :p0 AND `news_id` = :p1 AND `locale` = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSectioncache $obj */
            $obj = new ChildSectioncache();
            $obj->hydrate($row);
            SectioncacheTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildSectioncache|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SectioncacheTableMap::COL_SECTION_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SectioncacheTableMap::COL_NEWS_ID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(SectioncacheTableMap::COL_LOCALE, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SectioncacheTableMap::COL_SECTION_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SectioncacheTableMap::COL_NEWS_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(SectioncacheTableMap::COL_LOCALE, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
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
     * @param     mixed $sectionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function filterBySectionId($sectionId = null, $comparison = null)
    {
        if (is_array($sectionId)) {
            $useMinMax = false;
            if (isset($sectionId['min'])) {
                $this->addUsingAlias(SectioncacheTableMap::COL_SECTION_ID, $sectionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sectionId['max'])) {
                $this->addUsingAlias(SectioncacheTableMap::COL_SECTION_ID, $sectionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectioncacheTableMap::COL_SECTION_ID, $sectionId, $comparison);
    }

    /**
     * Filter the query on the news_id column
     *
     * Example usage:
     * <code>
     * $query->filterByNewsId(1234); // WHERE news_id = 1234
     * $query->filterByNewsId(array(12, 34)); // WHERE news_id IN (12, 34)
     * $query->filterByNewsId(array('min' => 12)); // WHERE news_id > 12
     * </code>
     *
     * @param     mixed $newsId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function filterByNewsId($newsId = null, $comparison = null)
    {
        if (is_array($newsId)) {
            $useMinMax = false;
            if (isset($newsId['min'])) {
                $this->addUsingAlias(SectioncacheTableMap::COL_NEWS_ID, $newsId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($newsId['max'])) {
                $this->addUsingAlias(SectioncacheTableMap::COL_NEWS_ID, $newsId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectioncacheTableMap::COL_NEWS_ID, $newsId, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%', Criteria::LIKE); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectioncacheTableMap::COL_LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the link column
     *
     * Example usage:
     * <code>
     * $query->filterByLink('fooValue');   // WHERE link = 'fooValue'
     * $query->filterByLink('%fooValue%', Criteria::LIKE); // WHERE link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $link The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectioncacheTableMap::COL_LINK, $link, $comparison);
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
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function filterByOrders($orders = null, $comparison = null)
    {
        if (is_array($orders)) {
            $useMinMax = false;
            if (isset($orders['min'])) {
                $this->addUsingAlias(SectioncacheTableMap::COL_ORDERS, $orders['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orders['max'])) {
                $this->addUsingAlias(SectioncacheTableMap::COL_ORDERS, $orders['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectioncacheTableMap::COL_ORDERS, $orders, $comparison);
    }

    /**
     * Filter the query on the read column
     *
     * Example usage:
     * <code>
     * $query->filterByRead(1234); // WHERE read = 1234
     * $query->filterByRead(array(12, 34)); // WHERE read IN (12, 34)
     * $query->filterByRead(array('min' => 12)); // WHERE read > 12
     * </code>
     *
     * @param     mixed $read The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function filterByRead($read = null, $comparison = null)
    {
        if (is_array($read)) {
            $useMinMax = false;
            if (isset($read['min'])) {
                $this->addUsingAlias(SectioncacheTableMap::COL_READ, $read['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($read['max'])) {
                $this->addUsingAlias(SectioncacheTableMap::COL_READ, $read['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectioncacheTableMap::COL_READ, $read, $comparison);
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
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function filterByPublishedAt($publishedAt = null, $comparison = null)
    {
        if (is_array($publishedAt)) {
            $useMinMax = false;
            if (isset($publishedAt['min'])) {
                $this->addUsingAlias(SectioncacheTableMap::COL_PUBLISHED_AT, $publishedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishedAt['max'])) {
                $this->addUsingAlias(SectioncacheTableMap::COL_PUBLISHED_AT, $publishedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectioncacheTableMap::COL_PUBLISHED_AT, $publishedAt, $comparison);
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
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function filterByLocked($locked = null, $comparison = null)
    {
        if (is_string($locked)) {
            $locked = in_array(strtolower($locked), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SectioncacheTableMap::COL_LOCKED, $locked, $comparison);
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
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function filterByFrontPage($frontPage = null, $comparison = null)
    {
        if (is_string($frontPage)) {
            $frontPage = in_array(strtolower($frontPage), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SectioncacheTableMap::COL_FRONT_PAGE, $frontPage, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSectioncache $sectioncache Object to remove from the list of results
     *
     * @return $this|ChildSectioncacheQuery The current query, for fluid interface
     */
    public function prune($sectioncache = null)
    {
        if ($sectioncache) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SectioncacheTableMap::COL_SECTION_ID), $sectioncache->getSectionId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SectioncacheTableMap::COL_NEWS_ID), $sectioncache->getNewsId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(SectioncacheTableMap::COL_LOCALE), $sectioncache->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sectioncache table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SectioncacheTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SectioncacheTableMap::clearInstancePool();
            SectioncacheTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SectioncacheTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SectioncacheTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SectioncacheTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SectioncacheTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SectioncacheQuery
