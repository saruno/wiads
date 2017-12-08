<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\Advertcache as ChildAdvertcache;
use Common\DbBundle\Model\AdvertcacheQuery as ChildAdvertcacheQuery;
use Common\DbBundle\Model\Map\AdvertcacheTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'advertcache' table.
 *
 *
 *
 * @method     ChildAdvertcacheQuery orderBySectionId($order = Criteria::ASC) Order by the section_id column
 * @method     ChildAdvertcacheQuery orderByAdvertId($order = Criteria::ASC) Order by the advert_id column
 * @method     ChildAdvertcacheQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildAdvertcacheQuery orderBySectionPosition($order = Criteria::ASC) Order by the section_position column
 * @method     ChildAdvertcacheQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildAdvertcacheQuery orderByBrief($order = Criteria::ASC) Order by the brief column
 * @method     ChildAdvertcacheQuery orderByLink($order = Criteria::ASC) Order by the link column
 * @method     ChildAdvertcacheQuery orderByLinkTo($order = Criteria::ASC) Order by the link_to column
 * @method     ChildAdvertcacheQuery orderByRead($order = Criteria::ASC) Order by the read column
 * @method     ChildAdvertcacheQuery orderByImgs($order = Criteria::ASC) Order by the imgs column
 * @method     ChildAdvertcacheQuery orderByImgsSizes($order = Criteria::ASC) Order by the imgs_sizes column
 * @method     ChildAdvertcacheQuery orderByPublishedAt($order = Criteria::ASC) Order by the published_at column
 * @method     ChildAdvertcacheQuery orderByExpiredAt($order = Criteria::ASC) Order by the expired_at column
 * @method     ChildAdvertcacheQuery orderByLocked($order = Criteria::ASC) Order by the locked column
 *
 * @method     ChildAdvertcacheQuery groupBySectionId() Group by the section_id column
 * @method     ChildAdvertcacheQuery groupByAdvertId() Group by the advert_id column
 * @method     ChildAdvertcacheQuery groupByLocale() Group by the locale column
 * @method     ChildAdvertcacheQuery groupBySectionPosition() Group by the section_position column
 * @method     ChildAdvertcacheQuery groupByTitle() Group by the title column
 * @method     ChildAdvertcacheQuery groupByBrief() Group by the brief column
 * @method     ChildAdvertcacheQuery groupByLink() Group by the link column
 * @method     ChildAdvertcacheQuery groupByLinkTo() Group by the link_to column
 * @method     ChildAdvertcacheQuery groupByRead() Group by the read column
 * @method     ChildAdvertcacheQuery groupByImgs() Group by the imgs column
 * @method     ChildAdvertcacheQuery groupByImgsSizes() Group by the imgs_sizes column
 * @method     ChildAdvertcacheQuery groupByPublishedAt() Group by the published_at column
 * @method     ChildAdvertcacheQuery groupByExpiredAt() Group by the expired_at column
 * @method     ChildAdvertcacheQuery groupByLocked() Group by the locked column
 *
 * @method     ChildAdvertcacheQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAdvertcacheQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAdvertcacheQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAdvertcacheQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAdvertcacheQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAdvertcacheQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAdvertcache findOne(ConnectionInterface $con = null) Return the first ChildAdvertcache matching the query
 * @method     ChildAdvertcache findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAdvertcache matching the query, or a new ChildAdvertcache object populated from the query conditions when no match is found
 *
 * @method     ChildAdvertcache findOneBySectionId(int $section_id) Return the first ChildAdvertcache filtered by the section_id column
 * @method     ChildAdvertcache findOneByAdvertId(int $advert_id) Return the first ChildAdvertcache filtered by the advert_id column
 * @method     ChildAdvertcache findOneByLocale(string $locale) Return the first ChildAdvertcache filtered by the locale column
 * @method     ChildAdvertcache findOneBySectionPosition(string $section_position) Return the first ChildAdvertcache filtered by the section_position column
 * @method     ChildAdvertcache findOneByTitle(string $title) Return the first ChildAdvertcache filtered by the title column
 * @method     ChildAdvertcache findOneByBrief(string $brief) Return the first ChildAdvertcache filtered by the brief column
 * @method     ChildAdvertcache findOneByLink(string $link) Return the first ChildAdvertcache filtered by the link column
 * @method     ChildAdvertcache findOneByLinkTo(string $link_to) Return the first ChildAdvertcache filtered by the link_to column
 * @method     ChildAdvertcache findOneByRead(int $read) Return the first ChildAdvertcache filtered by the read column
 * @method     ChildAdvertcache findOneByImgs(string $imgs) Return the first ChildAdvertcache filtered by the imgs column
 * @method     ChildAdvertcache findOneByImgsSizes(string $imgs_sizes) Return the first ChildAdvertcache filtered by the imgs_sizes column
 * @method     ChildAdvertcache findOneByPublishedAt(string $published_at) Return the first ChildAdvertcache filtered by the published_at column
 * @method     ChildAdvertcache findOneByExpiredAt(string $expired_at) Return the first ChildAdvertcache filtered by the expired_at column
 * @method     ChildAdvertcache findOneByLocked(boolean $locked) Return the first ChildAdvertcache filtered by the locked column *

 * @method     ChildAdvertcache requirePk($key, ConnectionInterface $con = null) Return the ChildAdvertcache by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOne(ConnectionInterface $con = null) Return the first ChildAdvertcache matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdvertcache requireOneBySectionId(int $section_id) Return the first ChildAdvertcache filtered by the section_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByAdvertId(int $advert_id) Return the first ChildAdvertcache filtered by the advert_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByLocale(string $locale) Return the first ChildAdvertcache filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneBySectionPosition(string $section_position) Return the first ChildAdvertcache filtered by the section_position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByTitle(string $title) Return the first ChildAdvertcache filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByBrief(string $brief) Return the first ChildAdvertcache filtered by the brief column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByLink(string $link) Return the first ChildAdvertcache filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByLinkTo(string $link_to) Return the first ChildAdvertcache filtered by the link_to column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByRead(int $read) Return the first ChildAdvertcache filtered by the read column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByImgs(string $imgs) Return the first ChildAdvertcache filtered by the imgs column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByImgsSizes(string $imgs_sizes) Return the first ChildAdvertcache filtered by the imgs_sizes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByPublishedAt(string $published_at) Return the first ChildAdvertcache filtered by the published_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByExpiredAt(string $expired_at) Return the first ChildAdvertcache filtered by the expired_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertcache requireOneByLocked(boolean $locked) Return the first ChildAdvertcache filtered by the locked column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdvertcache[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAdvertcache objects based on current ModelCriteria
 * @method     ChildAdvertcache[]|ObjectCollection findBySectionId(int $section_id) Return ChildAdvertcache objects filtered by the section_id column
 * @method     ChildAdvertcache[]|ObjectCollection findByAdvertId(int $advert_id) Return ChildAdvertcache objects filtered by the advert_id column
 * @method     ChildAdvertcache[]|ObjectCollection findByLocale(string $locale) Return ChildAdvertcache objects filtered by the locale column
 * @method     ChildAdvertcache[]|ObjectCollection findBySectionPosition(string $section_position) Return ChildAdvertcache objects filtered by the section_position column
 * @method     ChildAdvertcache[]|ObjectCollection findByTitle(string $title) Return ChildAdvertcache objects filtered by the title column
 * @method     ChildAdvertcache[]|ObjectCollection findByBrief(string $brief) Return ChildAdvertcache objects filtered by the brief column
 * @method     ChildAdvertcache[]|ObjectCollection findByLink(string $link) Return ChildAdvertcache objects filtered by the link column
 * @method     ChildAdvertcache[]|ObjectCollection findByLinkTo(string $link_to) Return ChildAdvertcache objects filtered by the link_to column
 * @method     ChildAdvertcache[]|ObjectCollection findByRead(int $read) Return ChildAdvertcache objects filtered by the read column
 * @method     ChildAdvertcache[]|ObjectCollection findByImgs(string $imgs) Return ChildAdvertcache objects filtered by the imgs column
 * @method     ChildAdvertcache[]|ObjectCollection findByImgsSizes(string $imgs_sizes) Return ChildAdvertcache objects filtered by the imgs_sizes column
 * @method     ChildAdvertcache[]|ObjectCollection findByPublishedAt(string $published_at) Return ChildAdvertcache objects filtered by the published_at column
 * @method     ChildAdvertcache[]|ObjectCollection findByExpiredAt(string $expired_at) Return ChildAdvertcache objects filtered by the expired_at column
 * @method     ChildAdvertcache[]|ObjectCollection findByLocked(boolean $locked) Return ChildAdvertcache objects filtered by the locked column
 * @method     ChildAdvertcache[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AdvertcacheQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\AdvertcacheQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\Advertcache', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAdvertcacheQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAdvertcacheQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAdvertcacheQuery) {
            return $criteria;
        }
        $query = new ChildAdvertcacheQuery();
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
     * @param array[$section_id, $advert_id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAdvertcache|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AdvertcacheTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AdvertcacheTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]))))) {
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
     * @return ChildAdvertcache A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `section_id`, `advert_id`, `locale`, `section_position`, `title`, `brief`, `link`, `link_to`, `read`, `imgs`, `imgs_sizes`, `published_at`, `expired_at`, `locked` FROM `advertcache` WHERE `section_id` = :p0 AND `advert_id` = :p1 AND `locale` = :p2';
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
            /** @var ChildAdvertcache $obj */
            $obj = new ChildAdvertcache();
            $obj->hydrate($row);
            AdvertcacheTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildAdvertcache|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AdvertcacheTableMap::COL_SECTION_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AdvertcacheTableMap::COL_ADVERT_ID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(AdvertcacheTableMap::COL_LOCALE, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AdvertcacheTableMap::COL_SECTION_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AdvertcacheTableMap::COL_ADVERT_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(AdvertcacheTableMap::COL_LOCALE, $key[2], Criteria::EQUAL);
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
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterBySectionId($sectionId = null, $comparison = null)
    {
        if (is_array($sectionId)) {
            $useMinMax = false;
            if (isset($sectionId['min'])) {
                $this->addUsingAlias(AdvertcacheTableMap::COL_SECTION_ID, $sectionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sectionId['max'])) {
                $this->addUsingAlias(AdvertcacheTableMap::COL_SECTION_ID, $sectionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_SECTION_ID, $sectionId, $comparison);
    }

    /**
     * Filter the query on the advert_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAdvertId(1234); // WHERE advert_id = 1234
     * $query->filterByAdvertId(array(12, 34)); // WHERE advert_id IN (12, 34)
     * $query->filterByAdvertId(array('min' => 12)); // WHERE advert_id > 12
     * </code>
     *
     * @param     mixed $advertId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByAdvertId($advertId = null, $comparison = null)
    {
        if (is_array($advertId)) {
            $useMinMax = false;
            if (isset($advertId['min'])) {
                $this->addUsingAlias(AdvertcacheTableMap::COL_ADVERT_ID, $advertId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($advertId['max'])) {
                $this->addUsingAlias(AdvertcacheTableMap::COL_ADVERT_ID, $advertId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_ADVERT_ID, $advertId, $comparison);
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
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the section_position column
     *
     * Example usage:
     * <code>
     * $query->filterBySectionPosition('fooValue');   // WHERE section_position = 'fooValue'
     * $query->filterBySectionPosition('%fooValue%', Criteria::LIKE); // WHERE section_position LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sectionPosition The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterBySectionPosition($sectionPosition = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sectionPosition)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_SECTION_POSITION, $sectionPosition, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the brief column
     *
     * Example usage:
     * <code>
     * $query->filterByBrief('fooValue');   // WHERE brief = 'fooValue'
     * $query->filterByBrief('%fooValue%', Criteria::LIKE); // WHERE brief LIKE '%fooValue%'
     * </code>
     *
     * @param     string $brief The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByBrief($brief = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($brief)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_BRIEF, $brief, $comparison);
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
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_LINK, $link, $comparison);
    }

    /**
     * Filter the query on the link_to column
     *
     * Example usage:
     * <code>
     * $query->filterByLinkTo('fooValue');   // WHERE link_to = 'fooValue'
     * $query->filterByLinkTo('%fooValue%', Criteria::LIKE); // WHERE link_to LIKE '%fooValue%'
     * </code>
     *
     * @param     string $linkTo The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByLinkTo($linkTo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($linkTo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_LINK_TO, $linkTo, $comparison);
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
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByRead($read = null, $comparison = null)
    {
        if (is_array($read)) {
            $useMinMax = false;
            if (isset($read['min'])) {
                $this->addUsingAlias(AdvertcacheTableMap::COL_READ, $read['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($read['max'])) {
                $this->addUsingAlias(AdvertcacheTableMap::COL_READ, $read['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_READ, $read, $comparison);
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
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByImgs($imgs = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imgs)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_IMGS, $imgs, $comparison);
    }

    /**
     * Filter the query on the imgs_sizes column
     *
     * Example usage:
     * <code>
     * $query->filterByImgsSizes('fooValue');   // WHERE imgs_sizes = 'fooValue'
     * $query->filterByImgsSizes('%fooValue%', Criteria::LIKE); // WHERE imgs_sizes LIKE '%fooValue%'
     * </code>
     *
     * @param     string $imgsSizes The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByImgsSizes($imgsSizes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imgsSizes)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_IMGS_SIZES, $imgsSizes, $comparison);
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
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByPublishedAt($publishedAt = null, $comparison = null)
    {
        if (is_array($publishedAt)) {
            $useMinMax = false;
            if (isset($publishedAt['min'])) {
                $this->addUsingAlias(AdvertcacheTableMap::COL_PUBLISHED_AT, $publishedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishedAt['max'])) {
                $this->addUsingAlias(AdvertcacheTableMap::COL_PUBLISHED_AT, $publishedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_PUBLISHED_AT, $publishedAt, $comparison);
    }

    /**
     * Filter the query on the expired_at column
     *
     * Example usage:
     * <code>
     * $query->filterByExpiredAt('2011-03-14'); // WHERE expired_at = '2011-03-14'
     * $query->filterByExpiredAt('now'); // WHERE expired_at = '2011-03-14'
     * $query->filterByExpiredAt(array('max' => 'yesterday')); // WHERE expired_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $expiredAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByExpiredAt($expiredAt = null, $comparison = null)
    {
        if (is_array($expiredAt)) {
            $useMinMax = false;
            if (isset($expiredAt['min'])) {
                $this->addUsingAlias(AdvertcacheTableMap::COL_EXPIRED_AT, $expiredAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expiredAt['max'])) {
                $this->addUsingAlias(AdvertcacheTableMap::COL_EXPIRED_AT, $expiredAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_EXPIRED_AT, $expiredAt, $comparison);
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
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function filterByLocked($locked = null, $comparison = null)
    {
        if (is_string($locked)) {
            $locked = in_array(strtolower($locked), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvertcacheTableMap::COL_LOCKED, $locked, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAdvertcache $advertcache Object to remove from the list of results
     *
     * @return $this|ChildAdvertcacheQuery The current query, for fluid interface
     */
    public function prune($advertcache = null)
    {
        if ($advertcache) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AdvertcacheTableMap::COL_SECTION_ID), $advertcache->getSectionId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AdvertcacheTableMap::COL_ADVERT_ID), $advertcache->getAdvertId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(AdvertcacheTableMap::COL_LOCALE), $advertcache->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the advertcache table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertcacheTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AdvertcacheTableMap::clearInstancePool();
            AdvertcacheTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertcacheTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AdvertcacheTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AdvertcacheTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AdvertcacheTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AdvertcacheQuery
