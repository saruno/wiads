<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\SectionI18n as ChildSectionI18n;
use Common\DbBundle\Model\SectionI18nQuery as ChildSectionI18nQuery;
use Common\DbBundle\Model\Map\SectionI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'section_i18n' table.
 *
 *
 *
 * @method     ChildSectionI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSectionI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildSectionI18nQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildSectionI18nQuery orderByStripTitle($order = Criteria::ASC) Order by the strip_title column
 * @method     ChildSectionI18nQuery orderByBrief($order = Criteria::ASC) Order by the brief column
 * @method     ChildSectionI18nQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildSectionI18nQuery orderByLink($order = Criteria::ASC) Order by the link column
 *
 * @method     ChildSectionI18nQuery groupById() Group by the id column
 * @method     ChildSectionI18nQuery groupByLocale() Group by the locale column
 * @method     ChildSectionI18nQuery groupByTitle() Group by the title column
 * @method     ChildSectionI18nQuery groupByStripTitle() Group by the strip_title column
 * @method     ChildSectionI18nQuery groupByBrief() Group by the brief column
 * @method     ChildSectionI18nQuery groupByContent() Group by the content column
 * @method     ChildSectionI18nQuery groupByLink() Group by the link column
 *
 * @method     ChildSectionI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSectionI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSectionI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSectionI18nQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSectionI18nQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSectionI18nQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSectionI18nQuery leftJoinSection($relationAlias = null) Adds a LEFT JOIN clause to the query using the Section relation
 * @method     ChildSectionI18nQuery rightJoinSection($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Section relation
 * @method     ChildSectionI18nQuery innerJoinSection($relationAlias = null) Adds a INNER JOIN clause to the query using the Section relation
 *
 * @method     ChildSectionI18nQuery joinWithSection($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Section relation
 *
 * @method     ChildSectionI18nQuery leftJoinWithSection() Adds a LEFT JOIN clause and with to the query using the Section relation
 * @method     ChildSectionI18nQuery rightJoinWithSection() Adds a RIGHT JOIN clause and with to the query using the Section relation
 * @method     ChildSectionI18nQuery innerJoinWithSection() Adds a INNER JOIN clause and with to the query using the Section relation
 *
 * @method     \Common\DbBundle\Model\SectionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSectionI18n findOne(ConnectionInterface $con = null) Return the first ChildSectionI18n matching the query
 * @method     ChildSectionI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSectionI18n matching the query, or a new ChildSectionI18n object populated from the query conditions when no match is found
 *
 * @method     ChildSectionI18n findOneById(int $id) Return the first ChildSectionI18n filtered by the id column
 * @method     ChildSectionI18n findOneByLocale(string $locale) Return the first ChildSectionI18n filtered by the locale column
 * @method     ChildSectionI18n findOneByTitle(string $title) Return the first ChildSectionI18n filtered by the title column
 * @method     ChildSectionI18n findOneByStripTitle(string $strip_title) Return the first ChildSectionI18n filtered by the strip_title column
 * @method     ChildSectionI18n findOneByBrief(string $brief) Return the first ChildSectionI18n filtered by the brief column
 * @method     ChildSectionI18n findOneByContent(string $content) Return the first ChildSectionI18n filtered by the content column
 * @method     ChildSectionI18n findOneByLink(string $link) Return the first ChildSectionI18n filtered by the link column *

 * @method     ChildSectionI18n requirePk($key, ConnectionInterface $con = null) Return the ChildSectionI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionI18n requireOne(ConnectionInterface $con = null) Return the first ChildSectionI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSectionI18n requireOneById(int $id) Return the first ChildSectionI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionI18n requireOneByLocale(string $locale) Return the first ChildSectionI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionI18n requireOneByTitle(string $title) Return the first ChildSectionI18n filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionI18n requireOneByStripTitle(string $strip_title) Return the first ChildSectionI18n filtered by the strip_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionI18n requireOneByBrief(string $brief) Return the first ChildSectionI18n filtered by the brief column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionI18n requireOneByContent(string $content) Return the first ChildSectionI18n filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSectionI18n requireOneByLink(string $link) Return the first ChildSectionI18n filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSectionI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSectionI18n objects based on current ModelCriteria
 * @method     ChildSectionI18n[]|ObjectCollection findById(int $id) Return ChildSectionI18n objects filtered by the id column
 * @method     ChildSectionI18n[]|ObjectCollection findByLocale(string $locale) Return ChildSectionI18n objects filtered by the locale column
 * @method     ChildSectionI18n[]|ObjectCollection findByTitle(string $title) Return ChildSectionI18n objects filtered by the title column
 * @method     ChildSectionI18n[]|ObjectCollection findByStripTitle(string $strip_title) Return ChildSectionI18n objects filtered by the strip_title column
 * @method     ChildSectionI18n[]|ObjectCollection findByBrief(string $brief) Return ChildSectionI18n objects filtered by the brief column
 * @method     ChildSectionI18n[]|ObjectCollection findByContent(string $content) Return ChildSectionI18n objects filtered by the content column
 * @method     ChildSectionI18n[]|ObjectCollection findByLink(string $link) Return ChildSectionI18n objects filtered by the link column
 * @method     ChildSectionI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SectionI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\SectionI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\SectionI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSectionI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSectionI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSectionI18nQuery) {
            return $criteria;
        }
        $query = new ChildSectionI18nQuery();
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
     * @return ChildSectionI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SectionI18nTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SectionI18nTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildSectionI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `locale`, `title`, `strip_title`, `brief`, `content`, `link` FROM `section_i18n` WHERE `id` = :p0 AND `locale` = :p1';
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
            /** @var ChildSectionI18n $obj */
            $obj = new ChildSectionI18n();
            $obj->hydrate($row);
            SectionI18nTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildSectionI18n|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSectionI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SectionI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SectionI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSectionI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SectionI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SectionI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
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
     * @see       filterBySection()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSectionI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SectionI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SectionI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionI18nTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildSectionI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionI18nTableMap::COL_LOCALE, $locale, $comparison);
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
     * @return $this|ChildSectionI18nQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionI18nTableMap::COL_TITLE, $title, $comparison);
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
     * @return $this|ChildSectionI18nQuery The current query, for fluid interface
     */
    public function filterByStripTitle($stripTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stripTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionI18nTableMap::COL_STRIP_TITLE, $stripTitle, $comparison);
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
     * @return $this|ChildSectionI18nQuery The current query, for fluid interface
     */
    public function filterByBrief($brief = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($brief)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionI18nTableMap::COL_BRIEF, $brief, $comparison);
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
     * @return $this|ChildSectionI18nQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionI18nTableMap::COL_CONTENT, $content, $comparison);
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
     * @return $this|ChildSectionI18nQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SectionI18nTableMap::COL_LINK, $link, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Section object
     *
     * @param \Common\DbBundle\Model\Section|ObjectCollection $section The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSectionI18nQuery The current query, for fluid interface
     */
    public function filterBySection($section, $comparison = null)
    {
        if ($section instanceof \Common\DbBundle\Model\Section) {
            return $this
                ->addUsingAlias(SectionI18nTableMap::COL_ID, $section->getId(), $comparison);
        } elseif ($section instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SectionI18nTableMap::COL_ID, $section->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSectionI18nQuery The current query, for fluid interface
     */
    public function joinSection($relationAlias = null, $joinType = 'LEFT JOIN')
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
    public function useSectionQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinSection($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Section', '\Common\DbBundle\Model\SectionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSectionI18n $sectionI18n Object to remove from the list of results
     *
     * @return $this|ChildSectionI18nQuery The current query, for fluid interface
     */
    public function prune($sectionI18n = null)
    {
        if ($sectionI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SectionI18nTableMap::COL_ID), $sectionI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SectionI18nTableMap::COL_LOCALE), $sectionI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the section_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SectionI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SectionI18nTableMap::clearInstancePool();
            SectionI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SectionI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SectionI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SectionI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SectionI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SectionI18nQuery
