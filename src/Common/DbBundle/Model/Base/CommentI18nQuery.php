<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\CommentI18n as ChildCommentI18n;
use Common\DbBundle\Model\CommentI18nQuery as ChildCommentI18nQuery;
use Common\DbBundle\Model\Map\CommentI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'comment_i18n' table.
 *
 *
 *
 * @method     ChildCommentI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCommentI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildCommentI18nQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildCommentI18nQuery orderByStripTitle($order = Criteria::ASC) Order by the strip_title column
 * @method     ChildCommentI18nQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildCommentI18nQuery orderByNewsLink($order = Criteria::ASC) Order by the news_link column
 * @method     ChildCommentI18nQuery orderByNewsTitle($order = Criteria::ASC) Order by the news_title column
 * @method     ChildCommentI18nQuery orderBySectionTitle($order = Criteria::ASC) Order by the section_title column
 * @method     ChildCommentI18nQuery orderByEditBy($order = Criteria::ASC) Order by the edit_by column
 * @method     ChildCommentI18nQuery orderByLocked($order = Criteria::ASC) Order by the locked column
 *
 * @method     ChildCommentI18nQuery groupById() Group by the id column
 * @method     ChildCommentI18nQuery groupByLocale() Group by the locale column
 * @method     ChildCommentI18nQuery groupByTitle() Group by the title column
 * @method     ChildCommentI18nQuery groupByStripTitle() Group by the strip_title column
 * @method     ChildCommentI18nQuery groupByContent() Group by the content column
 * @method     ChildCommentI18nQuery groupByNewsLink() Group by the news_link column
 * @method     ChildCommentI18nQuery groupByNewsTitle() Group by the news_title column
 * @method     ChildCommentI18nQuery groupBySectionTitle() Group by the section_title column
 * @method     ChildCommentI18nQuery groupByEditBy() Group by the edit_by column
 * @method     ChildCommentI18nQuery groupByLocked() Group by the locked column
 *
 * @method     ChildCommentI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCommentI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCommentI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCommentI18nQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCommentI18nQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCommentI18nQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCommentI18nQuery leftJoinComment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comment relation
 * @method     ChildCommentI18nQuery rightJoinComment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comment relation
 * @method     ChildCommentI18nQuery innerJoinComment($relationAlias = null) Adds a INNER JOIN clause to the query using the Comment relation
 *
 * @method     ChildCommentI18nQuery joinWithComment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Comment relation
 *
 * @method     ChildCommentI18nQuery leftJoinWithComment() Adds a LEFT JOIN clause and with to the query using the Comment relation
 * @method     ChildCommentI18nQuery rightJoinWithComment() Adds a RIGHT JOIN clause and with to the query using the Comment relation
 * @method     ChildCommentI18nQuery innerJoinWithComment() Adds a INNER JOIN clause and with to the query using the Comment relation
 *
 * @method     \Common\DbBundle\Model\CommentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCommentI18n findOne(ConnectionInterface $con = null) Return the first ChildCommentI18n matching the query
 * @method     ChildCommentI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCommentI18n matching the query, or a new ChildCommentI18n object populated from the query conditions when no match is found
 *
 * @method     ChildCommentI18n findOneById(int $id) Return the first ChildCommentI18n filtered by the id column
 * @method     ChildCommentI18n findOneByLocale(string $locale) Return the first ChildCommentI18n filtered by the locale column
 * @method     ChildCommentI18n findOneByTitle(string $title) Return the first ChildCommentI18n filtered by the title column
 * @method     ChildCommentI18n findOneByStripTitle(string $strip_title) Return the first ChildCommentI18n filtered by the strip_title column
 * @method     ChildCommentI18n findOneByContent(string $content) Return the first ChildCommentI18n filtered by the content column
 * @method     ChildCommentI18n findOneByNewsLink(string $news_link) Return the first ChildCommentI18n filtered by the news_link column
 * @method     ChildCommentI18n findOneByNewsTitle(string $news_title) Return the first ChildCommentI18n filtered by the news_title column
 * @method     ChildCommentI18n findOneBySectionTitle(string $section_title) Return the first ChildCommentI18n filtered by the section_title column
 * @method     ChildCommentI18n findOneByEditBy(string $edit_by) Return the first ChildCommentI18n filtered by the edit_by column
 * @method     ChildCommentI18n findOneByLocked(boolean $locked) Return the first ChildCommentI18n filtered by the locked column *

 * @method     ChildCommentI18n requirePk($key, ConnectionInterface $con = null) Return the ChildCommentI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommentI18n requireOne(ConnectionInterface $con = null) Return the first ChildCommentI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCommentI18n requireOneById(int $id) Return the first ChildCommentI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommentI18n requireOneByLocale(string $locale) Return the first ChildCommentI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommentI18n requireOneByTitle(string $title) Return the first ChildCommentI18n filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommentI18n requireOneByStripTitle(string $strip_title) Return the first ChildCommentI18n filtered by the strip_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommentI18n requireOneByContent(string $content) Return the first ChildCommentI18n filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommentI18n requireOneByNewsLink(string $news_link) Return the first ChildCommentI18n filtered by the news_link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommentI18n requireOneByNewsTitle(string $news_title) Return the first ChildCommentI18n filtered by the news_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommentI18n requireOneBySectionTitle(string $section_title) Return the first ChildCommentI18n filtered by the section_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommentI18n requireOneByEditBy(string $edit_by) Return the first ChildCommentI18n filtered by the edit_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCommentI18n requireOneByLocked(boolean $locked) Return the first ChildCommentI18n filtered by the locked column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCommentI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCommentI18n objects based on current ModelCriteria
 * @method     ChildCommentI18n[]|ObjectCollection findById(int $id) Return ChildCommentI18n objects filtered by the id column
 * @method     ChildCommentI18n[]|ObjectCollection findByLocale(string $locale) Return ChildCommentI18n objects filtered by the locale column
 * @method     ChildCommentI18n[]|ObjectCollection findByTitle(string $title) Return ChildCommentI18n objects filtered by the title column
 * @method     ChildCommentI18n[]|ObjectCollection findByStripTitle(string $strip_title) Return ChildCommentI18n objects filtered by the strip_title column
 * @method     ChildCommentI18n[]|ObjectCollection findByContent(string $content) Return ChildCommentI18n objects filtered by the content column
 * @method     ChildCommentI18n[]|ObjectCollection findByNewsLink(string $news_link) Return ChildCommentI18n objects filtered by the news_link column
 * @method     ChildCommentI18n[]|ObjectCollection findByNewsTitle(string $news_title) Return ChildCommentI18n objects filtered by the news_title column
 * @method     ChildCommentI18n[]|ObjectCollection findBySectionTitle(string $section_title) Return ChildCommentI18n objects filtered by the section_title column
 * @method     ChildCommentI18n[]|ObjectCollection findByEditBy(string $edit_by) Return ChildCommentI18n objects filtered by the edit_by column
 * @method     ChildCommentI18n[]|ObjectCollection findByLocked(boolean $locked) Return ChildCommentI18n objects filtered by the locked column
 * @method     ChildCommentI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CommentI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\CommentI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\CommentI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCommentI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCommentI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCommentI18nQuery) {
            return $criteria;
        }
        $query = new ChildCommentI18nQuery();
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
     * @return ChildCommentI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CommentI18nTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CommentI18nTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildCommentI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `locale`, `title`, `strip_title`, `content`, `news_link`, `news_title`, `section_title`, `edit_by`, `locked` FROM `comment_i18n` WHERE `id` = :p0 AND `locale` = :p1';
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
            /** @var ChildCommentI18n $obj */
            $obj = new ChildCommentI18n();
            $obj->hydrate($row);
            CommentI18nTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildCommentI18n|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(CommentI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(CommentI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(CommentI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(CommentI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterByComment()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CommentI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CommentI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentI18nTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentI18nTableMap::COL_LOCALE, $locale, $comparison);
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
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentI18nTableMap::COL_TITLE, $title, $comparison);
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
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterByStripTitle($stripTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stripTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentI18nTableMap::COL_STRIP_TITLE, $stripTitle, $comparison);
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
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentI18nTableMap::COL_CONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the news_link column
     *
     * Example usage:
     * <code>
     * $query->filterByNewsLink('fooValue');   // WHERE news_link = 'fooValue'
     * $query->filterByNewsLink('%fooValue%', Criteria::LIKE); // WHERE news_link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $newsLink The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterByNewsLink($newsLink = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($newsLink)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentI18nTableMap::COL_NEWS_LINK, $newsLink, $comparison);
    }

    /**
     * Filter the query on the news_title column
     *
     * Example usage:
     * <code>
     * $query->filterByNewsTitle('fooValue');   // WHERE news_title = 'fooValue'
     * $query->filterByNewsTitle('%fooValue%', Criteria::LIKE); // WHERE news_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $newsTitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterByNewsTitle($newsTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($newsTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentI18nTableMap::COL_NEWS_TITLE, $newsTitle, $comparison);
    }

    /**
     * Filter the query on the section_title column
     *
     * Example usage:
     * <code>
     * $query->filterBySectionTitle('fooValue');   // WHERE section_title = 'fooValue'
     * $query->filterBySectionTitle('%fooValue%', Criteria::LIKE); // WHERE section_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sectionTitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterBySectionTitle($sectionTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sectionTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentI18nTableMap::COL_SECTION_TITLE, $sectionTitle, $comparison);
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
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterByEditBy($editBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($editBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CommentI18nTableMap::COL_EDIT_BY, $editBy, $comparison);
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
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterByLocked($locked = null, $comparison = null)
    {
        if (is_string($locked)) {
            $locked = in_array(strtolower($locked), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CommentI18nTableMap::COL_LOCKED, $locked, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Comment object
     *
     * @param \Common\DbBundle\Model\Comment|ObjectCollection $comment The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCommentI18nQuery The current query, for fluid interface
     */
    public function filterByComment($comment, $comparison = null)
    {
        if ($comment instanceof \Common\DbBundle\Model\Comment) {
            return $this
                ->addUsingAlias(CommentI18nTableMap::COL_ID, $comment->getId(), $comparison);
        } elseif ($comment instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CommentI18nTableMap::COL_ID, $comment->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function joinComment($relationAlias = null, $joinType = 'LEFT JOIN')
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
    public function useCommentQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinComment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Comment', '\Common\DbBundle\Model\CommentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCommentI18n $commentI18n Object to remove from the list of results
     *
     * @return $this|ChildCommentI18nQuery The current query, for fluid interface
     */
    public function prune($commentI18n = null)
    {
        if ($commentI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(CommentI18nTableMap::COL_ID), $commentI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(CommentI18nTableMap::COL_LOCALE), $commentI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the comment_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommentI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CommentI18nTableMap::clearInstancePool();
            CommentI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CommentI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CommentI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CommentI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CommentI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CommentI18nQuery
