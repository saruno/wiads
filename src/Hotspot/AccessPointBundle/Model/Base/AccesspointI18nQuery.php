<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\AccesspointI18n as ChildAccesspointI18n;
use Hotspot\AccessPointBundle\Model\AccesspointI18nQuery as ChildAccesspointI18nQuery;
use Hotspot\AccessPointBundle\Model\Map\AccesspointI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'accesspoint_i18n' table.
 *
 *
 *
 * @method     ChildAccesspointI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAccesspointI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildAccesspointI18nQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildAccesspointI18nQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildAccesspointI18nQuery orderByPcontact($order = Criteria::ASC) Order by the pcontact column
 * @method     ChildAccesspointI18nQuery orderByDetailUrl($order = Criteria::ASC) Order by the detail_url column
 * @method     ChildAccesspointI18nQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildAccesspointI18nQuery orderByStripTitle($order = Criteria::ASC) Order by the strip_title column
 * @method     ChildAccesspointI18nQuery orderByBrief($order = Criteria::ASC) Order by the brief column
 * @method     ChildAccesspointI18nQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildAccesspointI18nQuery orderByTag($order = Criteria::ASC) Order by the tag column
 * @method     ChildAccesspointI18nQuery orderByKeyword($order = Criteria::ASC) Order by the keyword column
 * @method     ChildAccesspointI18nQuery orderByPostBy($order = Criteria::ASC) Order by the post_by column
 * @method     ChildAccesspointI18nQuery orderByEditBy($order = Criteria::ASC) Order by the edit_by column
 * @method     ChildAccesspointI18nQuery orderByShortLink($order = Criteria::ASC) Order by the short_link column
 * @method     ChildAccesspointI18nQuery orderByLink($order = Criteria::ASC) Order by the link column
 * @method     ChildAccesspointI18nQuery orderByLocked($order = Criteria::ASC) Order by the locked column
 * @method     ChildAccesspointI18nQuery orderByTrash($order = Criteria::ASC) Order by the trash column
 * @method     ChildAccesspointI18nQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildAccesspointI18nQuery orderByPreStatus($order = Criteria::ASC) Order by the pre_status column
 * @method     ChildAccesspointI18nQuery orderByStatusNote($order = Criteria::ASC) Order by the status_note column
 * @method     ChildAccesspointI18nQuery orderByDraft($order = Criteria::ASC) Order by the draft column
 * @method     ChildAccesspointI18nQuery orderByRead($order = Criteria::ASC) Order by the read column
 *
 * @method     ChildAccesspointI18nQuery groupById() Group by the id column
 * @method     ChildAccesspointI18nQuery groupByLocale() Group by the locale column
 * @method     ChildAccesspointI18nQuery groupByName() Group by the name column
 * @method     ChildAccesspointI18nQuery groupByAddress() Group by the address column
 * @method     ChildAccesspointI18nQuery groupByPcontact() Group by the pcontact column
 * @method     ChildAccesspointI18nQuery groupByDetailUrl() Group by the detail_url column
 * @method     ChildAccesspointI18nQuery groupByTitle() Group by the title column
 * @method     ChildAccesspointI18nQuery groupByStripTitle() Group by the strip_title column
 * @method     ChildAccesspointI18nQuery groupByBrief() Group by the brief column
 * @method     ChildAccesspointI18nQuery groupByContent() Group by the content column
 * @method     ChildAccesspointI18nQuery groupByTag() Group by the tag column
 * @method     ChildAccesspointI18nQuery groupByKeyword() Group by the keyword column
 * @method     ChildAccesspointI18nQuery groupByPostBy() Group by the post_by column
 * @method     ChildAccesspointI18nQuery groupByEditBy() Group by the edit_by column
 * @method     ChildAccesspointI18nQuery groupByShortLink() Group by the short_link column
 * @method     ChildAccesspointI18nQuery groupByLink() Group by the link column
 * @method     ChildAccesspointI18nQuery groupByLocked() Group by the locked column
 * @method     ChildAccesspointI18nQuery groupByTrash() Group by the trash column
 * @method     ChildAccesspointI18nQuery groupByStatus() Group by the status column
 * @method     ChildAccesspointI18nQuery groupByPreStatus() Group by the pre_status column
 * @method     ChildAccesspointI18nQuery groupByStatusNote() Group by the status_note column
 * @method     ChildAccesspointI18nQuery groupByDraft() Group by the draft column
 * @method     ChildAccesspointI18nQuery groupByRead() Group by the read column
 *
 * @method     ChildAccesspointI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAccesspointI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAccesspointI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAccesspointI18nQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAccesspointI18nQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAccesspointI18nQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAccesspointI18nQuery leftJoinAccesspoint($relationAlias = null) Adds a LEFT JOIN clause to the query using the Accesspoint relation
 * @method     ChildAccesspointI18nQuery rightJoinAccesspoint($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Accesspoint relation
 * @method     ChildAccesspointI18nQuery innerJoinAccesspoint($relationAlias = null) Adds a INNER JOIN clause to the query using the Accesspoint relation
 *
 * @method     ChildAccesspointI18nQuery joinWithAccesspoint($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Accesspoint relation
 *
 * @method     ChildAccesspointI18nQuery leftJoinWithAccesspoint() Adds a LEFT JOIN clause and with to the query using the Accesspoint relation
 * @method     ChildAccesspointI18nQuery rightJoinWithAccesspoint() Adds a RIGHT JOIN clause and with to the query using the Accesspoint relation
 * @method     ChildAccesspointI18nQuery innerJoinWithAccesspoint() Adds a INNER JOIN clause and with to the query using the Accesspoint relation
 *
 * @method     \Hotspot\AccessPointBundle\Model\AccesspointQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAccesspointI18n findOne(ConnectionInterface $con = null) Return the first ChildAccesspointI18n matching the query
 * @method     ChildAccesspointI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAccesspointI18n matching the query, or a new ChildAccesspointI18n object populated from the query conditions when no match is found
 *
 * @method     ChildAccesspointI18n findOneById(int $id) Return the first ChildAccesspointI18n filtered by the id column
 * @method     ChildAccesspointI18n findOneByLocale(string $locale) Return the first ChildAccesspointI18n filtered by the locale column
 * @method     ChildAccesspointI18n findOneByName(string $name) Return the first ChildAccesspointI18n filtered by the name column
 * @method     ChildAccesspointI18n findOneByAddress(string $address) Return the first ChildAccesspointI18n filtered by the address column
 * @method     ChildAccesspointI18n findOneByPcontact(string $pcontact) Return the first ChildAccesspointI18n filtered by the pcontact column
 * @method     ChildAccesspointI18n findOneByDetailUrl(string $detail_url) Return the first ChildAccesspointI18n filtered by the detail_url column
 * @method     ChildAccesspointI18n findOneByTitle(string $title) Return the first ChildAccesspointI18n filtered by the title column
 * @method     ChildAccesspointI18n findOneByStripTitle(string $strip_title) Return the first ChildAccesspointI18n filtered by the strip_title column
 * @method     ChildAccesspointI18n findOneByBrief(string $brief) Return the first ChildAccesspointI18n filtered by the brief column
 * @method     ChildAccesspointI18n findOneByContent(string $content) Return the first ChildAccesspointI18n filtered by the content column
 * @method     ChildAccesspointI18n findOneByTag(string $tag) Return the first ChildAccesspointI18n filtered by the tag column
 * @method     ChildAccesspointI18n findOneByKeyword(string $keyword) Return the first ChildAccesspointI18n filtered by the keyword column
 * @method     ChildAccesspointI18n findOneByPostBy(string $post_by) Return the first ChildAccesspointI18n filtered by the post_by column
 * @method     ChildAccesspointI18n findOneByEditBy(string $edit_by) Return the first ChildAccesspointI18n filtered by the edit_by column
 * @method     ChildAccesspointI18n findOneByShortLink(string $short_link) Return the first ChildAccesspointI18n filtered by the short_link column
 * @method     ChildAccesspointI18n findOneByLink(string $link) Return the first ChildAccesspointI18n filtered by the link column
 * @method     ChildAccesspointI18n findOneByLocked(boolean $locked) Return the first ChildAccesspointI18n filtered by the locked column
 * @method     ChildAccesspointI18n findOneByTrash(boolean $trash) Return the first ChildAccesspointI18n filtered by the trash column
 * @method     ChildAccesspointI18n findOneByStatus(string $status) Return the first ChildAccesspointI18n filtered by the status column
 * @method     ChildAccesspointI18n findOneByPreStatus(string $pre_status) Return the first ChildAccesspointI18n filtered by the pre_status column
 * @method     ChildAccesspointI18n findOneByStatusNote(string $status_note) Return the first ChildAccesspointI18n filtered by the status_note column
 * @method     ChildAccesspointI18n findOneByDraft(boolean $draft) Return the first ChildAccesspointI18n filtered by the draft column
 * @method     ChildAccesspointI18n findOneByRead(int $read) Return the first ChildAccesspointI18n filtered by the read column *

 * @method     ChildAccesspointI18n requirePk($key, ConnectionInterface $con = null) Return the ChildAccesspointI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOne(ConnectionInterface $con = null) Return the first ChildAccesspointI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccesspointI18n requireOneById(int $id) Return the first ChildAccesspointI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByLocale(string $locale) Return the first ChildAccesspointI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByName(string $name) Return the first ChildAccesspointI18n filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByAddress(string $address) Return the first ChildAccesspointI18n filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByPcontact(string $pcontact) Return the first ChildAccesspointI18n filtered by the pcontact column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByDetailUrl(string $detail_url) Return the first ChildAccesspointI18n filtered by the detail_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByTitle(string $title) Return the first ChildAccesspointI18n filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByStripTitle(string $strip_title) Return the first ChildAccesspointI18n filtered by the strip_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByBrief(string $brief) Return the first ChildAccesspointI18n filtered by the brief column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByContent(string $content) Return the first ChildAccesspointI18n filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByTag(string $tag) Return the first ChildAccesspointI18n filtered by the tag column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByKeyword(string $keyword) Return the first ChildAccesspointI18n filtered by the keyword column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByPostBy(string $post_by) Return the first ChildAccesspointI18n filtered by the post_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByEditBy(string $edit_by) Return the first ChildAccesspointI18n filtered by the edit_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByShortLink(string $short_link) Return the first ChildAccesspointI18n filtered by the short_link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByLink(string $link) Return the first ChildAccesspointI18n filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByLocked(boolean $locked) Return the first ChildAccesspointI18n filtered by the locked column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByTrash(boolean $trash) Return the first ChildAccesspointI18n filtered by the trash column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByStatus(string $status) Return the first ChildAccesspointI18n filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByPreStatus(string $pre_status) Return the first ChildAccesspointI18n filtered by the pre_status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByStatusNote(string $status_note) Return the first ChildAccesspointI18n filtered by the status_note column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByDraft(boolean $draft) Return the first ChildAccesspointI18n filtered by the draft column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspointI18n requireOneByRead(int $read) Return the first ChildAccesspointI18n filtered by the read column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccesspointI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAccesspointI18n objects based on current ModelCriteria
 * @method     ChildAccesspointI18n[]|ObjectCollection findById(int $id) Return ChildAccesspointI18n objects filtered by the id column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByLocale(string $locale) Return ChildAccesspointI18n objects filtered by the locale column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByName(string $name) Return ChildAccesspointI18n objects filtered by the name column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByAddress(string $address) Return ChildAccesspointI18n objects filtered by the address column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByPcontact(string $pcontact) Return ChildAccesspointI18n objects filtered by the pcontact column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByDetailUrl(string $detail_url) Return ChildAccesspointI18n objects filtered by the detail_url column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByTitle(string $title) Return ChildAccesspointI18n objects filtered by the title column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByStripTitle(string $strip_title) Return ChildAccesspointI18n objects filtered by the strip_title column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByBrief(string $brief) Return ChildAccesspointI18n objects filtered by the brief column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByContent(string $content) Return ChildAccesspointI18n objects filtered by the content column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByTag(string $tag) Return ChildAccesspointI18n objects filtered by the tag column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByKeyword(string $keyword) Return ChildAccesspointI18n objects filtered by the keyword column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByPostBy(string $post_by) Return ChildAccesspointI18n objects filtered by the post_by column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByEditBy(string $edit_by) Return ChildAccesspointI18n objects filtered by the edit_by column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByShortLink(string $short_link) Return ChildAccesspointI18n objects filtered by the short_link column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByLink(string $link) Return ChildAccesspointI18n objects filtered by the link column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByLocked(boolean $locked) Return ChildAccesspointI18n objects filtered by the locked column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByTrash(boolean $trash) Return ChildAccesspointI18n objects filtered by the trash column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByStatus(string $status) Return ChildAccesspointI18n objects filtered by the status column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByPreStatus(string $pre_status) Return ChildAccesspointI18n objects filtered by the pre_status column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByStatusNote(string $status_note) Return ChildAccesspointI18n objects filtered by the status_note column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByDraft(boolean $draft) Return ChildAccesspointI18n objects filtered by the draft column
 * @method     ChildAccesspointI18n[]|ObjectCollection findByRead(int $read) Return ChildAccesspointI18n objects filtered by the read column
 * @method     ChildAccesspointI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AccesspointI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Hotspot\AccessPointBundle\Model\Base\AccesspointI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Hotspot\\AccessPointBundle\\Model\\AccesspointI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAccesspointI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAccesspointI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAccesspointI18nQuery) {
            return $criteria;
        }
        $query = new ChildAccesspointI18nQuery();
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
     * @return ChildAccesspointI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AccesspointI18nTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AccesspointI18nTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildAccesspointI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `locale`, `name`, `address`, `pcontact`, `detail_url`, `title`, `strip_title`, `brief`, `content`, `tag`, `keyword`, `post_by`, `edit_by`, `short_link`, `link`, `locked`, `trash`, `status`, `pre_status`, `status_note`, `draft`, `read` FROM `accesspoint_i18n` WHERE `id` = :p0 AND `locale` = :p1';
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
            /** @var ChildAccesspointI18n $obj */
            $obj = new ChildAccesspointI18n();
            $obj->hydrate($row);
            AccesspointI18nTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildAccesspointI18n|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AccesspointI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AccesspointI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AccesspointI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AccesspointI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterByAccesspoint()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AccesspointI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AccesspointI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%', Criteria::LIKE); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the pcontact column
     *
     * Example usage:
     * <code>
     * $query->filterByPcontact('fooValue');   // WHERE pcontact = 'fooValue'
     * $query->filterByPcontact('%fooValue%', Criteria::LIKE); // WHERE pcontact LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pcontact The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByPcontact($pcontact = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pcontact)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_PCONTACT, $pcontact, $comparison);
    }

    /**
     * Filter the query on the detail_url column
     *
     * Example usage:
     * <code>
     * $query->filterByDetailUrl('fooValue');   // WHERE detail_url = 'fooValue'
     * $query->filterByDetailUrl('%fooValue%', Criteria::LIKE); // WHERE detail_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $detailUrl The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByDetailUrl($detailUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($detailUrl)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_DETAIL_URL, $detailUrl, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_TITLE, $title, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByStripTitle($stripTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stripTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_STRIP_TITLE, $stripTitle, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByBrief($brief = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($brief)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_BRIEF, $brief, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_CONTENT, $content, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByTag($tag = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tag)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_TAG, $tag, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByKeyword($keyword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($keyword)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_KEYWORD, $keyword, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByPostBy($postBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_POST_BY, $postBy, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByEditBy($editBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($editBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_EDIT_BY, $editBy, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByShortLink($shortLink = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shortLink)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_SHORT_LINK, $shortLink, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_LINK, $link, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByLocked($locked = null, $comparison = null)
    {
        if (is_string($locked)) {
            $locked = in_array(strtolower($locked), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_LOCKED, $locked, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByTrash($trash = null, $comparison = null)
    {
        if (is_string($trash)) {
            $trash = in_array(strtolower($trash), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_TRASH, $trash, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_STATUS, $status, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByPreStatus($preStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($preStatus)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_PRE_STATUS, $preStatus, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByStatusNote($statusNote = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($statusNote)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_STATUS_NOTE, $statusNote, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByDraft($draft = null, $comparison = null)
    {
        if (is_string($draft)) {
            $draft = in_array(strtolower($draft), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_DRAFT, $draft, $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByRead($read = null, $comparison = null)
    {
        if (is_array($read)) {
            $useMinMax = false;
            if (isset($read['min'])) {
                $this->addUsingAlias(AccesspointI18nTableMap::COL_READ, $read['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($read['max'])) {
                $this->addUsingAlias(AccesspointI18nTableMap::COL_READ, $read['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointI18nTableMap::COL_READ, $read, $comparison);
    }

    /**
     * Filter the query by a related \Hotspot\AccessPointBundle\Model\Accesspoint object
     *
     * @param \Hotspot\AccessPointBundle\Model\Accesspoint|ObjectCollection $accesspoint The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function filterByAccesspoint($accesspoint, $comparison = null)
    {
        if ($accesspoint instanceof \Hotspot\AccessPointBundle\Model\Accesspoint) {
            return $this
                ->addUsingAlias(AccesspointI18nTableMap::COL_ID, $accesspoint->getId(), $comparison);
        } elseif ($accesspoint instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccesspointI18nTableMap::COL_ID, $accesspoint->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function joinAccesspoint($relationAlias = null, $joinType = 'LEFT JOIN')
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
    public function useAccesspointQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinAccesspoint($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Accesspoint', '\Hotspot\AccessPointBundle\Model\AccesspointQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAccesspointI18n $accesspointI18n Object to remove from the list of results
     *
     * @return $this|ChildAccesspointI18nQuery The current query, for fluid interface
     */
    public function prune($accesspointI18n = null)
    {
        if ($accesspointI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AccesspointI18nTableMap::COL_ID), $accesspointI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AccesspointI18nTableMap::COL_LOCALE), $accesspointI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the accesspoint_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AccesspointI18nTableMap::clearInstancePool();
            AccesspointI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AccesspointI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AccesspointI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AccesspointI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AccesspointI18nQuery
