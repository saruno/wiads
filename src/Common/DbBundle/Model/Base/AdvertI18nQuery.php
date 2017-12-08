<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\AdvertI18n as ChildAdvertI18n;
use Common\DbBundle\Model\AdvertI18nQuery as ChildAdvertI18nQuery;
use Common\DbBundle\Model\Map\AdvertI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'advert_i18n' table.
 *
 *
 *
 * @method     ChildAdvertI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAdvertI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildAdvertI18nQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildAdvertI18nQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildAdvertI18nQuery orderByCampagin($order = Criteria::ASC) Order by the campagin column
 * @method     ChildAdvertI18nQuery orderByStripTitle($order = Criteria::ASC) Order by the strip_title column
 * @method     ChildAdvertI18nQuery orderByBrief($order = Criteria::ASC) Order by the brief column
 * @method     ChildAdvertI18nQuery orderByTag($order = Criteria::ASC) Order by the tag column
 * @method     ChildAdvertI18nQuery orderByKeyword($order = Criteria::ASC) Order by the keyword column
 * @method     ChildAdvertI18nQuery orderByPostBy($order = Criteria::ASC) Order by the post_by column
 * @method     ChildAdvertI18nQuery orderByEditBy($order = Criteria::ASC) Order by the edit_by column
 * @method     ChildAdvertI18nQuery orderByLink($order = Criteria::ASC) Order by the link column
 * @method     ChildAdvertI18nQuery orderByLinkTo($order = Criteria::ASC) Order by the link_to column
 * @method     ChildAdvertI18nQuery orderByView($order = Criteria::ASC) Order by the view column
 * @method     ChildAdvertI18nQuery orderByLocked($order = Criteria::ASC) Order by the locked column
 * @method     ChildAdvertI18nQuery orderByTrash($order = Criteria::ASC) Order by the trash column
 * @method     ChildAdvertI18nQuery orderByRead($order = Criteria::ASC) Order by the read column
 *
 * @method     ChildAdvertI18nQuery groupById() Group by the id column
 * @method     ChildAdvertI18nQuery groupByLocale() Group by the locale column
 * @method     ChildAdvertI18nQuery groupByTitle() Group by the title column
 * @method     ChildAdvertI18nQuery groupByDescription() Group by the description column
 * @method     ChildAdvertI18nQuery groupByCampagin() Group by the campagin column
 * @method     ChildAdvertI18nQuery groupByStripTitle() Group by the strip_title column
 * @method     ChildAdvertI18nQuery groupByBrief() Group by the brief column
 * @method     ChildAdvertI18nQuery groupByTag() Group by the tag column
 * @method     ChildAdvertI18nQuery groupByKeyword() Group by the keyword column
 * @method     ChildAdvertI18nQuery groupByPostBy() Group by the post_by column
 * @method     ChildAdvertI18nQuery groupByEditBy() Group by the edit_by column
 * @method     ChildAdvertI18nQuery groupByLink() Group by the link column
 * @method     ChildAdvertI18nQuery groupByLinkTo() Group by the link_to column
 * @method     ChildAdvertI18nQuery groupByView() Group by the view column
 * @method     ChildAdvertI18nQuery groupByLocked() Group by the locked column
 * @method     ChildAdvertI18nQuery groupByTrash() Group by the trash column
 * @method     ChildAdvertI18nQuery groupByRead() Group by the read column
 *
 * @method     ChildAdvertI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAdvertI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAdvertI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAdvertI18nQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAdvertI18nQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAdvertI18nQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAdvertI18nQuery leftJoinAdvert($relationAlias = null) Adds a LEFT JOIN clause to the query using the Advert relation
 * @method     ChildAdvertI18nQuery rightJoinAdvert($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Advert relation
 * @method     ChildAdvertI18nQuery innerJoinAdvert($relationAlias = null) Adds a INNER JOIN clause to the query using the Advert relation
 *
 * @method     ChildAdvertI18nQuery joinWithAdvert($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Advert relation
 *
 * @method     ChildAdvertI18nQuery leftJoinWithAdvert() Adds a LEFT JOIN clause and with to the query using the Advert relation
 * @method     ChildAdvertI18nQuery rightJoinWithAdvert() Adds a RIGHT JOIN clause and with to the query using the Advert relation
 * @method     ChildAdvertI18nQuery innerJoinWithAdvert() Adds a INNER JOIN clause and with to the query using the Advert relation
 *
 * @method     \Common\DbBundle\Model\AdvertQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAdvertI18n findOne(ConnectionInterface $con = null) Return the first ChildAdvertI18n matching the query
 * @method     ChildAdvertI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAdvertI18n matching the query, or a new ChildAdvertI18n object populated from the query conditions when no match is found
 *
 * @method     ChildAdvertI18n findOneById(int $id) Return the first ChildAdvertI18n filtered by the id column
 * @method     ChildAdvertI18n findOneByLocale(string $locale) Return the first ChildAdvertI18n filtered by the locale column
 * @method     ChildAdvertI18n findOneByTitle(string $title) Return the first ChildAdvertI18n filtered by the title column
 * @method     ChildAdvertI18n findOneByDescription(string $description) Return the first ChildAdvertI18n filtered by the description column
 * @method     ChildAdvertI18n findOneByCampagin(string $campagin) Return the first ChildAdvertI18n filtered by the campagin column
 * @method     ChildAdvertI18n findOneByStripTitle(string $strip_title) Return the first ChildAdvertI18n filtered by the strip_title column
 * @method     ChildAdvertI18n findOneByBrief(string $brief) Return the first ChildAdvertI18n filtered by the brief column
 * @method     ChildAdvertI18n findOneByTag(string $tag) Return the first ChildAdvertI18n filtered by the tag column
 * @method     ChildAdvertI18n findOneByKeyword(string $keyword) Return the first ChildAdvertI18n filtered by the keyword column
 * @method     ChildAdvertI18n findOneByPostBy(string $post_by) Return the first ChildAdvertI18n filtered by the post_by column
 * @method     ChildAdvertI18n findOneByEditBy(string $edit_by) Return the first ChildAdvertI18n filtered by the edit_by column
 * @method     ChildAdvertI18n findOneByLink(string $link) Return the first ChildAdvertI18n filtered by the link column
 * @method     ChildAdvertI18n findOneByLinkTo(string $link_to) Return the first ChildAdvertI18n filtered by the link_to column
 * @method     ChildAdvertI18n findOneByView(int $view) Return the first ChildAdvertI18n filtered by the view column
 * @method     ChildAdvertI18n findOneByLocked(boolean $locked) Return the first ChildAdvertI18n filtered by the locked column
 * @method     ChildAdvertI18n findOneByTrash(boolean $trash) Return the first ChildAdvertI18n filtered by the trash column
 * @method     ChildAdvertI18n findOneByRead(int $read) Return the first ChildAdvertI18n filtered by the read column *

 * @method     ChildAdvertI18n requirePk($key, ConnectionInterface $con = null) Return the ChildAdvertI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOne(ConnectionInterface $con = null) Return the first ChildAdvertI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdvertI18n requireOneById(int $id) Return the first ChildAdvertI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByLocale(string $locale) Return the first ChildAdvertI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByTitle(string $title) Return the first ChildAdvertI18n filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByDescription(string $description) Return the first ChildAdvertI18n filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByCampagin(string $campagin) Return the first ChildAdvertI18n filtered by the campagin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByStripTitle(string $strip_title) Return the first ChildAdvertI18n filtered by the strip_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByBrief(string $brief) Return the first ChildAdvertI18n filtered by the brief column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByTag(string $tag) Return the first ChildAdvertI18n filtered by the tag column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByKeyword(string $keyword) Return the first ChildAdvertI18n filtered by the keyword column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByPostBy(string $post_by) Return the first ChildAdvertI18n filtered by the post_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByEditBy(string $edit_by) Return the first ChildAdvertI18n filtered by the edit_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByLink(string $link) Return the first ChildAdvertI18n filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByLinkTo(string $link_to) Return the first ChildAdvertI18n filtered by the link_to column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByView(int $view) Return the first ChildAdvertI18n filtered by the view column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByLocked(boolean $locked) Return the first ChildAdvertI18n filtered by the locked column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByTrash(boolean $trash) Return the first ChildAdvertI18n filtered by the trash column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvertI18n requireOneByRead(int $read) Return the first ChildAdvertI18n filtered by the read column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdvertI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAdvertI18n objects based on current ModelCriteria
 * @method     ChildAdvertI18n[]|ObjectCollection findById(int $id) Return ChildAdvertI18n objects filtered by the id column
 * @method     ChildAdvertI18n[]|ObjectCollection findByLocale(string $locale) Return ChildAdvertI18n objects filtered by the locale column
 * @method     ChildAdvertI18n[]|ObjectCollection findByTitle(string $title) Return ChildAdvertI18n objects filtered by the title column
 * @method     ChildAdvertI18n[]|ObjectCollection findByDescription(string $description) Return ChildAdvertI18n objects filtered by the description column
 * @method     ChildAdvertI18n[]|ObjectCollection findByCampagin(string $campagin) Return ChildAdvertI18n objects filtered by the campagin column
 * @method     ChildAdvertI18n[]|ObjectCollection findByStripTitle(string $strip_title) Return ChildAdvertI18n objects filtered by the strip_title column
 * @method     ChildAdvertI18n[]|ObjectCollection findByBrief(string $brief) Return ChildAdvertI18n objects filtered by the brief column
 * @method     ChildAdvertI18n[]|ObjectCollection findByTag(string $tag) Return ChildAdvertI18n objects filtered by the tag column
 * @method     ChildAdvertI18n[]|ObjectCollection findByKeyword(string $keyword) Return ChildAdvertI18n objects filtered by the keyword column
 * @method     ChildAdvertI18n[]|ObjectCollection findByPostBy(string $post_by) Return ChildAdvertI18n objects filtered by the post_by column
 * @method     ChildAdvertI18n[]|ObjectCollection findByEditBy(string $edit_by) Return ChildAdvertI18n objects filtered by the edit_by column
 * @method     ChildAdvertI18n[]|ObjectCollection findByLink(string $link) Return ChildAdvertI18n objects filtered by the link column
 * @method     ChildAdvertI18n[]|ObjectCollection findByLinkTo(string $link_to) Return ChildAdvertI18n objects filtered by the link_to column
 * @method     ChildAdvertI18n[]|ObjectCollection findByView(int $view) Return ChildAdvertI18n objects filtered by the view column
 * @method     ChildAdvertI18n[]|ObjectCollection findByLocked(boolean $locked) Return ChildAdvertI18n objects filtered by the locked column
 * @method     ChildAdvertI18n[]|ObjectCollection findByTrash(boolean $trash) Return ChildAdvertI18n objects filtered by the trash column
 * @method     ChildAdvertI18n[]|ObjectCollection findByRead(int $read) Return ChildAdvertI18n objects filtered by the read column
 * @method     ChildAdvertI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AdvertI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\AdvertI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\AdvertI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAdvertI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAdvertI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAdvertI18nQuery) {
            return $criteria;
        }
        $query = new ChildAdvertI18nQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAdvertI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AdvertI18nTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AdvertI18nTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildAdvertI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `locale`, `title`, `description`, `campagin`, `strip_title`, `brief`, `tag`, `keyword`, `post_by`, `edit_by`, `link`, `link_to`, `view`, `locked`, `trash`, `read` FROM `advert_i18n` WHERE `id` = :p0 AND `locale` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAdvertI18n $obj */
            $obj = new ChildAdvertI18n();
            $obj->hydrate($row);
            AdvertI18nTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildAdvertI18n|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AdvertI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AdvertI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AdvertI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AdvertI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByAdvert()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdvertI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdvertI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_LOCALE, $locale, $comparison);
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
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_TITLE, $title, $comparison);
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
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the campagin column
     *
     * Example usage:
     * <code>
     * $query->filterByCampagin('fooValue');   // WHERE campagin = 'fooValue'
     * $query->filterByCampagin('%fooValue%', Criteria::LIKE); // WHERE campagin LIKE '%fooValue%'
     * </code>
     *
     * @param     string $campagin The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByCampagin($campagin = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($campagin)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_CAMPAGIN, $campagin, $comparison);
    }

    /**
     * Filter the query on the strip_title column
     *
     * Example usage:
     * <code>
     * $query->filterByStripTitle('fooValue');   // WHERE strip_title = 'fooValue'
     * $query->filterByStripTitle('%fooValue%', Criteria::LIKE); // WHERE strip_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stripTitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByStripTitle($stripTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stripTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_STRIP_TITLE, $stripTitle, $comparison);
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
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByBrief($brief = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($brief)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_BRIEF, $brief, $comparison);
    }

    /**
     * Filter the query on the tag column
     *
     * Example usage:
     * <code>
     * $query->filterByTag('fooValue');   // WHERE tag = 'fooValue'
     * $query->filterByTag('%fooValue%', Criteria::LIKE); // WHERE tag LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tag The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByTag($tag = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tag)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_TAG, $tag, $comparison);
    }

    /**
     * Filter the query on the keyword column
     *
     * Example usage:
     * <code>
     * $query->filterByKeyword('fooValue');   // WHERE keyword = 'fooValue'
     * $query->filterByKeyword('%fooValue%', Criteria::LIKE); // WHERE keyword LIKE '%fooValue%'
     * </code>
     *
     * @param     string $keyword The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByKeyword($keyword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($keyword)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_KEYWORD, $keyword, $comparison);
    }

    /**
     * Filter the query on the post_by column
     *
     * Example usage:
     * <code>
     * $query->filterByPostBy('fooValue');   // WHERE post_by = 'fooValue'
     * $query->filterByPostBy('%fooValue%', Criteria::LIKE); // WHERE post_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postBy The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByPostBy($postBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_POST_BY, $postBy, $comparison);
    }

    /**
     * Filter the query on the edit_by column
     *
     * Example usage:
     * <code>
     * $query->filterByEditBy('fooValue');   // WHERE edit_by = 'fooValue'
     * $query->filterByEditBy('%fooValue%', Criteria::LIKE); // WHERE edit_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $editBy The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByEditBy($editBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($editBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_EDIT_BY, $editBy, $comparison);
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
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_LINK, $link, $comparison);
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
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByLinkTo($linkTo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($linkTo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_LINK_TO, $linkTo, $comparison);
    }

    /**
     * Filter the query on the view column
     *
     * Example usage:
     * <code>
     * $query->filterByView(1234); // WHERE view = 1234
     * $query->filterByView(array(12, 34)); // WHERE view IN (12, 34)
     * $query->filterByView(array('min' => 12)); // WHERE view > 12
     * </code>
     *
     * @param     mixed $view The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByView($view = null, $comparison = null)
    {
        if (is_array($view)) {
            $useMinMax = false;
            if (isset($view['min'])) {
                $this->addUsingAlias(AdvertI18nTableMap::COL_VIEW, $view['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($view['max'])) {
                $this->addUsingAlias(AdvertI18nTableMap::COL_VIEW, $view['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_VIEW, $view, $comparison);
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
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByLocked($locked = null, $comparison = null)
    {
        if (is_string($locked)) {
            $locked = in_array(strtolower($locked), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_LOCKED, $locked, $comparison);
    }

    /**
     * Filter the query on the trash column
     *
     * Example usage:
     * <code>
     * $query->filterByTrash(true); // WHERE trash = true
     * $query->filterByTrash('yes'); // WHERE trash = true
     * </code>
     *
     * @param     boolean|string $trash The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByTrash($trash = null, $comparison = null)
    {
        if (is_string($trash)) {
            $trash = in_array(strtolower($trash), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_TRASH, $trash, $comparison);
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
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByRead($read = null, $comparison = null)
    {
        if (is_array($read)) {
            $useMinMax = false;
            if (isset($read['min'])) {
                $this->addUsingAlias(AdvertI18nTableMap::COL_READ, $read['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($read['max'])) {
                $this->addUsingAlias(AdvertI18nTableMap::COL_READ, $read['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertI18nTableMap::COL_READ, $read, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Advert object
     *
     * @param \Common\DbBundle\Model\Advert|ObjectCollection $advert The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function filterByAdvert($advert, $comparison = null)
    {
        if ($advert instanceof \Common\DbBundle\Model\Advert) {
            return $this
                ->addUsingAlias(AdvertI18nTableMap::COL_ID, $advert->getId(), $comparison);
        } elseif ($advert instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvertI18nTableMap::COL_ID, $advert->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function joinAdvert($relationAlias = null, $joinType = 'LEFT JOIN')
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
    public function useAdvertQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinAdvert($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Advert', '\Common\DbBundle\Model\AdvertQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAdvertI18n $advertI18n Object to remove from the list of results
     *
     * @return $this|ChildAdvertI18nQuery The current query, for fluid interface
     */
    public function prune($advertI18n = null)
    {
        if ($advertI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AdvertI18nTableMap::COL_ID), $advertI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AdvertI18nTableMap::COL_LOCALE), $advertI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the advert_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AdvertI18nTableMap::clearInstancePool();
            AdvertI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AdvertI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AdvertI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AdvertI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AdvertI18nQuery
