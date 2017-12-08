<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\NewsI18n as ChildNewsI18n;
use Common\DbBundle\Model\NewsI18nQuery as ChildNewsI18nQuery;
use Common\DbBundle\Model\Map\NewsI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'news_i18n' table.
 *
 *
 *
 * @method     ChildNewsI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildNewsI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildNewsI18nQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildNewsI18nQuery orderByStripTitle($order = Criteria::ASC) Order by the strip_title column
 * @method     ChildNewsI18nQuery orderByBrief($order = Criteria::ASC) Order by the brief column
 * @method     ChildNewsI18nQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildNewsI18nQuery orderByTag($order = Criteria::ASC) Order by the tag column
 * @method     ChildNewsI18nQuery orderByKeyword($order = Criteria::ASC) Order by the keyword column
 * @method     ChildNewsI18nQuery orderByPostBy($order = Criteria::ASC) Order by the post_by column
 * @method     ChildNewsI18nQuery orderByEditBy($order = Criteria::ASC) Order by the edit_by column
 * @method     ChildNewsI18nQuery orderByShortLink($order = Criteria::ASC) Order by the short_link column
 * @method     ChildNewsI18nQuery orderByLink($order = Criteria::ASC) Order by the link column
 * @method     ChildNewsI18nQuery orderByLocked($order = Criteria::ASC) Order by the locked column
 * @method     ChildNewsI18nQuery orderByTrash($order = Criteria::ASC) Order by the trash column
 * @method     ChildNewsI18nQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildNewsI18nQuery orderByPreStatus($order = Criteria::ASC) Order by the pre_status column
 * @method     ChildNewsI18nQuery orderByStatusNote($order = Criteria::ASC) Order by the status_note column
 * @method     ChildNewsI18nQuery orderByDraft($order = Criteria::ASC) Order by the draft column
 * @method     ChildNewsI18nQuery orderByRead($order = Criteria::ASC) Order by the read column
 *
 * @method     ChildNewsI18nQuery groupById() Group by the id column
 * @method     ChildNewsI18nQuery groupByLocale() Group by the locale column
 * @method     ChildNewsI18nQuery groupByTitle() Group by the title column
 * @method     ChildNewsI18nQuery groupByStripTitle() Group by the strip_title column
 * @method     ChildNewsI18nQuery groupByBrief() Group by the brief column
 * @method     ChildNewsI18nQuery groupByContent() Group by the content column
 * @method     ChildNewsI18nQuery groupByTag() Group by the tag column
 * @method     ChildNewsI18nQuery groupByKeyword() Group by the keyword column
 * @method     ChildNewsI18nQuery groupByPostBy() Group by the post_by column
 * @method     ChildNewsI18nQuery groupByEditBy() Group by the edit_by column
 * @method     ChildNewsI18nQuery groupByShortLink() Group by the short_link column
 * @method     ChildNewsI18nQuery groupByLink() Group by the link column
 * @method     ChildNewsI18nQuery groupByLocked() Group by the locked column
 * @method     ChildNewsI18nQuery groupByTrash() Group by the trash column
 * @method     ChildNewsI18nQuery groupByStatus() Group by the status column
 * @method     ChildNewsI18nQuery groupByPreStatus() Group by the pre_status column
 * @method     ChildNewsI18nQuery groupByStatusNote() Group by the status_note column
 * @method     ChildNewsI18nQuery groupByDraft() Group by the draft column
 * @method     ChildNewsI18nQuery groupByRead() Group by the read column
 *
 * @method     ChildNewsI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildNewsI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildNewsI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildNewsI18nQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildNewsI18nQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildNewsI18nQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildNewsI18nQuery leftJoinNews($relationAlias = null) Adds a LEFT JOIN clause to the query using the News relation
 * @method     ChildNewsI18nQuery rightJoinNews($relationAlias = null) Adds a RIGHT JOIN clause to the query using the News relation
 * @method     ChildNewsI18nQuery innerJoinNews($relationAlias = null) Adds a INNER JOIN clause to the query using the News relation
 *
 * @method     ChildNewsI18nQuery joinWithNews($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the News relation
 *
 * @method     ChildNewsI18nQuery leftJoinWithNews() Adds a LEFT JOIN clause and with to the query using the News relation
 * @method     ChildNewsI18nQuery rightJoinWithNews() Adds a RIGHT JOIN clause and with to the query using the News relation
 * @method     ChildNewsI18nQuery innerJoinWithNews() Adds a INNER JOIN clause and with to the query using the News relation
 *
 * @method     \Common\DbBundle\Model\NewsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildNewsI18n findOne(ConnectionInterface $con = null) Return the first ChildNewsI18n matching the query
 * @method     ChildNewsI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildNewsI18n matching the query, or a new ChildNewsI18n object populated from the query conditions when no match is found
 *
 * @method     ChildNewsI18n findOneById(int $id) Return the first ChildNewsI18n filtered by the id column
 * @method     ChildNewsI18n findOneByLocale(string $locale) Return the first ChildNewsI18n filtered by the locale column
 * @method     ChildNewsI18n findOneByTitle(string $title) Return the first ChildNewsI18n filtered by the title column
 * @method     ChildNewsI18n findOneByStripTitle(string $strip_title) Return the first ChildNewsI18n filtered by the strip_title column
 * @method     ChildNewsI18n findOneByBrief(string $brief) Return the first ChildNewsI18n filtered by the brief column
 * @method     ChildNewsI18n findOneByContent(string $content) Return the first ChildNewsI18n filtered by the content column
 * @method     ChildNewsI18n findOneByTag(string $tag) Return the first ChildNewsI18n filtered by the tag column
 * @method     ChildNewsI18n findOneByKeyword(string $keyword) Return the first ChildNewsI18n filtered by the keyword column
 * @method     ChildNewsI18n findOneByPostBy(string $post_by) Return the first ChildNewsI18n filtered by the post_by column
 * @method     ChildNewsI18n findOneByEditBy(string $edit_by) Return the first ChildNewsI18n filtered by the edit_by column
 * @method     ChildNewsI18n findOneByShortLink(string $short_link) Return the first ChildNewsI18n filtered by the short_link column
 * @method     ChildNewsI18n findOneByLink(string $link) Return the first ChildNewsI18n filtered by the link column
 * @method     ChildNewsI18n findOneByLocked(boolean $locked) Return the first ChildNewsI18n filtered by the locked column
 * @method     ChildNewsI18n findOneByTrash(boolean $trash) Return the first ChildNewsI18n filtered by the trash column
 * @method     ChildNewsI18n findOneByStatus(string $status) Return the first ChildNewsI18n filtered by the status column
 * @method     ChildNewsI18n findOneByPreStatus(string $pre_status) Return the first ChildNewsI18n filtered by the pre_status column
 * @method     ChildNewsI18n findOneByStatusNote(string $status_note) Return the first ChildNewsI18n filtered by the status_note column
 * @method     ChildNewsI18n findOneByDraft(boolean $draft) Return the first ChildNewsI18n filtered by the draft column
 * @method     ChildNewsI18n findOneByRead(int $read) Return the first ChildNewsI18n filtered by the read column *

 * @method     ChildNewsI18n requirePk($key, ConnectionInterface $con = null) Return the ChildNewsI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOne(ConnectionInterface $con = null) Return the first ChildNewsI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNewsI18n requireOneById(int $id) Return the first ChildNewsI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByLocale(string $locale) Return the first ChildNewsI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByTitle(string $title) Return the first ChildNewsI18n filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByStripTitle(string $strip_title) Return the first ChildNewsI18n filtered by the strip_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByBrief(string $brief) Return the first ChildNewsI18n filtered by the brief column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByContent(string $content) Return the first ChildNewsI18n filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByTag(string $tag) Return the first ChildNewsI18n filtered by the tag column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByKeyword(string $keyword) Return the first ChildNewsI18n filtered by the keyword column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByPostBy(string $post_by) Return the first ChildNewsI18n filtered by the post_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByEditBy(string $edit_by) Return the first ChildNewsI18n filtered by the edit_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByShortLink(string $short_link) Return the first ChildNewsI18n filtered by the short_link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByLink(string $link) Return the first ChildNewsI18n filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByLocked(boolean $locked) Return the first ChildNewsI18n filtered by the locked column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByTrash(boolean $trash) Return the first ChildNewsI18n filtered by the trash column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByStatus(string $status) Return the first ChildNewsI18n filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByPreStatus(string $pre_status) Return the first ChildNewsI18n filtered by the pre_status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByStatusNote(string $status_note) Return the first ChildNewsI18n filtered by the status_note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByDraft(boolean $draft) Return the first ChildNewsI18n filtered by the draft column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNewsI18n requireOneByRead(int $read) Return the first ChildNewsI18n filtered by the read column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNewsI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildNewsI18n objects based on current ModelCriteria
 * @method     ChildNewsI18n[]|ObjectCollection findById(int $id) Return ChildNewsI18n objects filtered by the id column
 * @method     ChildNewsI18n[]|ObjectCollection findByLocale(string $locale) Return ChildNewsI18n objects filtered by the locale column
 * @method     ChildNewsI18n[]|ObjectCollection findByTitle(string $title) Return ChildNewsI18n objects filtered by the title column
 * @method     ChildNewsI18n[]|ObjectCollection findByStripTitle(string $strip_title) Return ChildNewsI18n objects filtered by the strip_title column
 * @method     ChildNewsI18n[]|ObjectCollection findByBrief(string $brief) Return ChildNewsI18n objects filtered by the brief column
 * @method     ChildNewsI18n[]|ObjectCollection findByContent(string $content) Return ChildNewsI18n objects filtered by the content column
 * @method     ChildNewsI18n[]|ObjectCollection findByTag(string $tag) Return ChildNewsI18n objects filtered by the tag column
 * @method     ChildNewsI18n[]|ObjectCollection findByKeyword(string $keyword) Return ChildNewsI18n objects filtered by the keyword column
 * @method     ChildNewsI18n[]|ObjectCollection findByPostBy(string $post_by) Return ChildNewsI18n objects filtered by the post_by column
 * @method     ChildNewsI18n[]|ObjectCollection findByEditBy(string $edit_by) Return ChildNewsI18n objects filtered by the edit_by column
 * @method     ChildNewsI18n[]|ObjectCollection findByShortLink(string $short_link) Return ChildNewsI18n objects filtered by the short_link column
 * @method     ChildNewsI18n[]|ObjectCollection findByLink(string $link) Return ChildNewsI18n objects filtered by the link column
 * @method     ChildNewsI18n[]|ObjectCollection findByLocked(boolean $locked) Return ChildNewsI18n objects filtered by the locked column
 * @method     ChildNewsI18n[]|ObjectCollection findByTrash(boolean $trash) Return ChildNewsI18n objects filtered by the trash column
 * @method     ChildNewsI18n[]|ObjectCollection findByStatus(string $status) Return ChildNewsI18n objects filtered by the status column
 * @method     ChildNewsI18n[]|ObjectCollection findByPreStatus(string $pre_status) Return ChildNewsI18n objects filtered by the pre_status column
 * @method     ChildNewsI18n[]|ObjectCollection findByStatusNote(string $status_note) Return ChildNewsI18n objects filtered by the status_note column
 * @method     ChildNewsI18n[]|ObjectCollection findByDraft(boolean $draft) Return ChildNewsI18n objects filtered by the draft column
 * @method     ChildNewsI18n[]|ObjectCollection findByRead(int $read) Return ChildNewsI18n objects filtered by the read column
 * @method     ChildNewsI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class NewsI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\NewsI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\NewsI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildNewsI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildNewsI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildNewsI18nQuery) {
            return $criteria;
        }
        $query = new ChildNewsI18nQuery();
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
     * @return ChildNewsI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NewsI18nTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = NewsI18nTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildNewsI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `locale`, `title`, `strip_title`, `brief`, `content`, `tag`, `keyword`, `post_by`, `edit_by`, `short_link`, `link`, `locked`, `trash`, `status`, `pre_status`, `status_note`, `draft`, `read` FROM `news_i18n` WHERE `id` = :p0 AND `locale` = :p1';
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
            /** @var ChildNewsI18n $obj */
            $obj = new ChildNewsI18n();
            $obj->hydrate($row);
            NewsI18nTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildNewsI18n|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(NewsI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(NewsI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(NewsI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(NewsI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterByNews()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(NewsI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(NewsI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_LOCALE, $locale, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_TITLE, $title, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByStripTitle($stripTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stripTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_STRIP_TITLE, $stripTitle, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByBrief($brief = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($brief)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_BRIEF, $brief, $comparison);
    }

    /**
     * Filter the query on the content column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
     * $query->filterByContent('%fooValue%', Criteria::LIKE); // WHERE content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_CONTENT, $content, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByTag($tag = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tag)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_TAG, $tag, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByKeyword($keyword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($keyword)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_KEYWORD, $keyword, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByPostBy($postBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_POST_BY, $postBy, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByEditBy($editBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($editBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_EDIT_BY, $editBy, $comparison);
    }

    /**
     * Filter the query on the short_link column
     *
     * Example usage:
     * <code>
     * $query->filterByShortLink('fooValue');   // WHERE short_link = 'fooValue'
     * $query->filterByShortLink('%fooValue%', Criteria::LIKE); // WHERE short_link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shortLink The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByShortLink($shortLink = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shortLink)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_SHORT_LINK, $shortLink, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_LINK, $link, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByLocked($locked = null, $comparison = null)
    {
        if (is_string($locked)) {
            $locked = in_array(strtolower($locked), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_LOCKED, $locked, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByTrash($trash = null, $comparison = null)
    {
        if (is_string($trash)) {
            $trash = in_array(strtolower($trash), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_TRASH, $trash, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%', Criteria::LIKE); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the pre_status column
     *
     * Example usage:
     * <code>
     * $query->filterByPreStatus('fooValue');   // WHERE pre_status = 'fooValue'
     * $query->filterByPreStatus('%fooValue%', Criteria::LIKE); // WHERE pre_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $preStatus The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByPreStatus($preStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($preStatus)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_PRE_STATUS, $preStatus, $comparison);
    }

    /**
     * Filter the query on the status_note column
     *
     * Example usage:
     * <code>
     * $query->filterByStatusNote('fooValue');   // WHERE status_note = 'fooValue'
     * $query->filterByStatusNote('%fooValue%', Criteria::LIKE); // WHERE status_note LIKE '%fooValue%'
     * </code>
     *
     * @param     string $statusNote The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByStatusNote($statusNote = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($statusNote)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_STATUS_NOTE, $statusNote, $comparison);
    }

    /**
     * Filter the query on the draft column
     *
     * Example usage:
     * <code>
     * $query->filterByDraft(true); // WHERE draft = true
     * $query->filterByDraft('yes'); // WHERE draft = true
     * </code>
     *
     * @param     boolean|string $draft The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByDraft($draft = null, $comparison = null)
    {
        if (is_string($draft)) {
            $draft = in_array(strtolower($draft), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_DRAFT, $draft, $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByRead($read = null, $comparison = null)
    {
        if (is_array($read)) {
            $useMinMax = false;
            if (isset($read['min'])) {
                $this->addUsingAlias(NewsI18nTableMap::COL_READ, $read['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($read['max'])) {
                $this->addUsingAlias(NewsI18nTableMap::COL_READ, $read['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NewsI18nTableMap::COL_READ, $read, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\News object
     *
     * @param \Common\DbBundle\Model\News|ObjectCollection $news The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildNewsI18nQuery The current query, for fluid interface
     */
    public function filterByNews($news, $comparison = null)
    {
        if ($news instanceof \Common\DbBundle\Model\News) {
            return $this
                ->addUsingAlias(NewsI18nTableMap::COL_ID, $news->getId(), $comparison);
        } elseif ($news instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NewsI18nTableMap::COL_ID, $news->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function joinNews($relationAlias = null, $joinType = 'LEFT JOIN')
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
    public function useNewsQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinNews($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'News', '\Common\DbBundle\Model\NewsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildNewsI18n $newsI18n Object to remove from the list of results
     *
     * @return $this|ChildNewsI18nQuery The current query, for fluid interface
     */
    public function prune($newsI18n = null)
    {
        if ($newsI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(NewsI18nTableMap::COL_ID), $newsI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(NewsI18nTableMap::COL_LOCALE), $newsI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the news_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NewsI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            NewsI18nTableMap::clearInstancePool();
            NewsI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(NewsI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(NewsI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            NewsI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            NewsI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // NewsI18nQuery
