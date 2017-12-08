<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\Advert as ChildAdvert;
use Common\DbBundle\Model\AdvertI18nQuery as ChildAdvertI18nQuery;
use Common\DbBundle\Model\AdvertQuery as ChildAdvertQuery;
use Common\DbBundle\Model\Map\AdvertTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'advert' table.
 *
 *
 *
 * @method     ChildAdvertQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAdvertQuery orderBySectionId($order = Criteria::ASC) Order by the section_id column
 * @method     ChildAdvertQuery orderBySubsectionIds($order = Criteria::ASC) Order by the subsection_ids column
 * @method     ChildAdvertQuery orderByBundleId($order = Criteria::ASC) Order by the bundle_id column
 * @method     ChildAdvertQuery orderBySectionLinkId($order = Criteria::ASC) Order by the section_link_id column
 * @method     ChildAdvertQuery orderByBundleLinkId($order = Criteria::ASC) Order by the bundle_link_id column
 * @method     ChildAdvertQuery orderByViewAtHomepage($order = Criteria::ASC) Order by the view_at_homepage column
 * @method     ChildAdvertQuery orderByHomePosition($order = Criteria::ASC) Order by the home_position column
 * @method     ChildAdvertQuery orderByViewAtSection($order = Criteria::ASC) Order by the view_at_section column
 * @method     ChildAdvertQuery orderBySectionPosition($order = Criteria::ASC) Order by the section_position column
 * @method     ChildAdvertQuery orderByLocation($order = Criteria::ASC) Order by the location column
 * @method     ChildAdvertQuery orderByCompany($order = Criteria::ASC) Order by the company column
 * @method     ChildAdvertQuery orderByPlatform($order = Criteria::ASC) Order by the platform column
 * @method     ChildAdvertQuery orderByPlatformVersion($order = Criteria::ASC) Order by the platform_version column
 * @method     ChildAdvertQuery orderByCanDelete($order = Criteria::ASC) Order by the can_delete column
 * @method     ChildAdvertQuery orderByPublishedAt($order = Criteria::ASC) Order by the published_at column
 * @method     ChildAdvertQuery orderByExpiredAt($order = Criteria::ASC) Order by the expired_at column
 * @method     ChildAdvertQuery orderByCustomerId($order = Criteria::ASC) Order by the customer_id column
 * @method     ChildAdvertQuery orderByRatio($order = Criteria::ASC) Order by the ratio column
 * @method     ChildAdvertQuery orderByDailyLimit($order = Criteria::ASC) Order by the daily_limit column
 * @method     ChildAdvertQuery orderByDraft($order = Criteria::ASC) Order by the draft column
 * @method     ChildAdvertQuery orderByImg($order = Criteria::ASC) Order by the img column
 * @method     ChildAdvertQuery orderByImgs($order = Criteria::ASC) Order by the imgs column
 * @method     ChildAdvertQuery orderByImgsSizes($order = Criteria::ASC) Order by the imgs_sizes column
 * @method     ChildAdvertQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildAdvertQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildAdvertQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildAdvertQuery groupById() Group by the id column
 * @method     ChildAdvertQuery groupBySectionId() Group by the section_id column
 * @method     ChildAdvertQuery groupBySubsectionIds() Group by the subsection_ids column
 * @method     ChildAdvertQuery groupByBundleId() Group by the bundle_id column
 * @method     ChildAdvertQuery groupBySectionLinkId() Group by the section_link_id column
 * @method     ChildAdvertQuery groupByBundleLinkId() Group by the bundle_link_id column
 * @method     ChildAdvertQuery groupByViewAtHomepage() Group by the view_at_homepage column
 * @method     ChildAdvertQuery groupByHomePosition() Group by the home_position column
 * @method     ChildAdvertQuery groupByViewAtSection() Group by the view_at_section column
 * @method     ChildAdvertQuery groupBySectionPosition() Group by the section_position column
 * @method     ChildAdvertQuery groupByLocation() Group by the location column
 * @method     ChildAdvertQuery groupByCompany() Group by the company column
 * @method     ChildAdvertQuery groupByPlatform() Group by the platform column
 * @method     ChildAdvertQuery groupByPlatformVersion() Group by the platform_version column
 * @method     ChildAdvertQuery groupByCanDelete() Group by the can_delete column
 * @method     ChildAdvertQuery groupByPublishedAt() Group by the published_at column
 * @method     ChildAdvertQuery groupByExpiredAt() Group by the expired_at column
 * @method     ChildAdvertQuery groupByCustomerId() Group by the customer_id column
 * @method     ChildAdvertQuery groupByRatio() Group by the ratio column
 * @method     ChildAdvertQuery groupByDailyLimit() Group by the daily_limit column
 * @method     ChildAdvertQuery groupByDraft() Group by the draft column
 * @method     ChildAdvertQuery groupByImg() Group by the img column
 * @method     ChildAdvertQuery groupByImgs() Group by the imgs column
 * @method     ChildAdvertQuery groupByImgsSizes() Group by the imgs_sizes column
 * @method     ChildAdvertQuery groupByType() Group by the type column
 * @method     ChildAdvertQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildAdvertQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildAdvertQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAdvertQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAdvertQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAdvertQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAdvertQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAdvertQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAdvertQuery leftJoinSection($relationAlias = null) Adds a LEFT JOIN clause to the query using the Section relation
 * @method     ChildAdvertQuery rightJoinSection($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Section relation
 * @method     ChildAdvertQuery innerJoinSection($relationAlias = null) Adds a INNER JOIN clause to the query using the Section relation
 *
 * @method     ChildAdvertQuery joinWithSection($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Section relation
 *
 * @method     ChildAdvertQuery leftJoinWithSection() Adds a LEFT JOIN clause and with to the query using the Section relation
 * @method     ChildAdvertQuery rightJoinWithSection() Adds a RIGHT JOIN clause and with to the query using the Section relation
 * @method     ChildAdvertQuery innerJoinWithSection() Adds a INNER JOIN clause and with to the query using the Section relation
 *
 * @method     ChildAdvertQuery leftJoinCustomer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Customer relation
 * @method     ChildAdvertQuery rightJoinCustomer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Customer relation
 * @method     ChildAdvertQuery innerJoinCustomer($relationAlias = null) Adds a INNER JOIN clause to the query using the Customer relation
 *
 * @method     ChildAdvertQuery joinWithCustomer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Customer relation
 *
 * @method     ChildAdvertQuery leftJoinWithCustomer() Adds a LEFT JOIN clause and with to the query using the Customer relation
 * @method     ChildAdvertQuery rightJoinWithCustomer() Adds a RIGHT JOIN clause and with to the query using the Customer relation
 * @method     ChildAdvertQuery innerJoinWithCustomer() Adds a INNER JOIN clause and with to the query using the Customer relation
 *
 * @method     ChildAdvertQuery leftJoinBundle($relationAlias = null) Adds a LEFT JOIN clause to the query using the Bundle relation
 * @method     ChildAdvertQuery rightJoinBundle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Bundle relation
 * @method     ChildAdvertQuery innerJoinBundle($relationAlias = null) Adds a INNER JOIN clause to the query using the Bundle relation
 *
 * @method     ChildAdvertQuery joinWithBundle($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Bundle relation
 *
 * @method     ChildAdvertQuery leftJoinWithBundle() Adds a LEFT JOIN clause and with to the query using the Bundle relation
 * @method     ChildAdvertQuery rightJoinWithBundle() Adds a RIGHT JOIN clause and with to the query using the Bundle relation
 * @method     ChildAdvertQuery innerJoinWithBundle() Adds a INNER JOIN clause and with to the query using the Bundle relation
 *
 * @method     ChildAdvertQuery leftJoinAdvertI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvertI18n relation
 * @method     ChildAdvertQuery rightJoinAdvertI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvertI18n relation
 * @method     ChildAdvertQuery innerJoinAdvertI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvertI18n relation
 *
 * @method     ChildAdvertQuery joinWithAdvertI18n($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AdvertI18n relation
 *
 * @method     ChildAdvertQuery leftJoinWithAdvertI18n() Adds a LEFT JOIN clause and with to the query using the AdvertI18n relation
 * @method     ChildAdvertQuery rightJoinWithAdvertI18n() Adds a RIGHT JOIN clause and with to the query using the AdvertI18n relation
 * @method     ChildAdvertQuery innerJoinWithAdvertI18n() Adds a INNER JOIN clause and with to the query using the AdvertI18n relation
 *
 * @method     \Common\DbBundle\Model\SectionQuery|\Common\DbBundle\Model\CustomerQuery|\Common\DbBundle\Model\BundleQuery|\Common\DbBundle\Model\AdvertI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAdvert findOne(ConnectionInterface $con = null) Return the first ChildAdvert matching the query
 * @method     ChildAdvert findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAdvert matching the query, or a new ChildAdvert object populated from the query conditions when no match is found
 *
 * @method     ChildAdvert findOneById(int $id) Return the first ChildAdvert filtered by the id column
 * @method     ChildAdvert findOneBySectionId(int $section_id) Return the first ChildAdvert filtered by the section_id column
 * @method     ChildAdvert findOneBySubsectionIds(string $subsection_ids) Return the first ChildAdvert filtered by the subsection_ids column
 * @method     ChildAdvert findOneByBundleId(int $bundle_id) Return the first ChildAdvert filtered by the bundle_id column
 * @method     ChildAdvert findOneBySectionLinkId(int $section_link_id) Return the first ChildAdvert filtered by the section_link_id column
 * @method     ChildAdvert findOneByBundleLinkId(int $bundle_link_id) Return the first ChildAdvert filtered by the bundle_link_id column
 * @method     ChildAdvert findOneByViewAtHomepage(boolean $view_at_homepage) Return the first ChildAdvert filtered by the view_at_homepage column
 * @method     ChildAdvert findOneByHomePosition(string $home_position) Return the first ChildAdvert filtered by the home_position column
 * @method     ChildAdvert findOneByViewAtSection(boolean $view_at_section) Return the first ChildAdvert filtered by the view_at_section column
 * @method     ChildAdvert findOneBySectionPosition(string $section_position) Return the first ChildAdvert filtered by the section_position column
 * @method     ChildAdvert findOneByLocation(string $location) Return the first ChildAdvert filtered by the location column
 * @method     ChildAdvert findOneByCompany(string $company) Return the first ChildAdvert filtered by the company column
 * @method     ChildAdvert findOneByPlatform(string $platform) Return the first ChildAdvert filtered by the platform column
 * @method     ChildAdvert findOneByPlatformVersion(string $platform_version) Return the first ChildAdvert filtered by the platform_version column
 * @method     ChildAdvert findOneByCanDelete(boolean $can_delete) Return the first ChildAdvert filtered by the can_delete column
 * @method     ChildAdvert findOneByPublishedAt(string $published_at) Return the first ChildAdvert filtered by the published_at column
 * @method     ChildAdvert findOneByExpiredAt(string $expired_at) Return the first ChildAdvert filtered by the expired_at column
 * @method     ChildAdvert findOneByCustomerId(int $customer_id) Return the first ChildAdvert filtered by the customer_id column
 * @method     ChildAdvert findOneByRatio(double $ratio) Return the first ChildAdvert filtered by the ratio column
 * @method     ChildAdvert findOneByDailyLimit(int $daily_limit) Return the first ChildAdvert filtered by the daily_limit column
 * @method     ChildAdvert findOneByDraft(boolean $draft) Return the first ChildAdvert filtered by the draft column
 * @method     ChildAdvert findOneByImg(string $img) Return the first ChildAdvert filtered by the img column
 * @method     ChildAdvert findOneByImgs(string $imgs) Return the first ChildAdvert filtered by the imgs column
 * @method     ChildAdvert findOneByImgsSizes(string $imgs_sizes) Return the first ChildAdvert filtered by the imgs_sizes column
 * @method     ChildAdvert findOneByType(int $type) Return the first ChildAdvert filtered by the type column
 * @method     ChildAdvert findOneByCreatedAt(string $created_at) Return the first ChildAdvert filtered by the created_at column
 * @method     ChildAdvert findOneByUpdatedAt(string $updated_at) Return the first ChildAdvert filtered by the updated_at column *

 * @method     ChildAdvert requirePk($key, ConnectionInterface $con = null) Return the ChildAdvert by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOne(ConnectionInterface $con = null) Return the first ChildAdvert matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdvert requireOneById(int $id) Return the first ChildAdvert filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneBySectionId(int $section_id) Return the first ChildAdvert filtered by the section_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneBySubsectionIds(string $subsection_ids) Return the first ChildAdvert filtered by the subsection_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByBundleId(int $bundle_id) Return the first ChildAdvert filtered by the bundle_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneBySectionLinkId(int $section_link_id) Return the first ChildAdvert filtered by the section_link_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByBundleLinkId(int $bundle_link_id) Return the first ChildAdvert filtered by the bundle_link_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByViewAtHomepage(boolean $view_at_homepage) Return the first ChildAdvert filtered by the view_at_homepage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByHomePosition(string $home_position) Return the first ChildAdvert filtered by the home_position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByViewAtSection(boolean $view_at_section) Return the first ChildAdvert filtered by the view_at_section column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneBySectionPosition(string $section_position) Return the first ChildAdvert filtered by the section_position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByLocation(string $location) Return the first ChildAdvert filtered by the location column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByCompany(string $company) Return the first ChildAdvert filtered by the company column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByPlatform(string $platform) Return the first ChildAdvert filtered by the platform column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByPlatformVersion(string $platform_version) Return the first ChildAdvert filtered by the platform_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByCanDelete(boolean $can_delete) Return the first ChildAdvert filtered by the can_delete column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByPublishedAt(string $published_at) Return the first ChildAdvert filtered by the published_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByExpiredAt(string $expired_at) Return the first ChildAdvert filtered by the expired_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByCustomerId(int $customer_id) Return the first ChildAdvert filtered by the customer_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByRatio(double $ratio) Return the first ChildAdvert filtered by the ratio column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByDailyLimit(int $daily_limit) Return the first ChildAdvert filtered by the daily_limit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByDraft(boolean $draft) Return the first ChildAdvert filtered by the draft column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByImg(string $img) Return the first ChildAdvert filtered by the img column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByImgs(string $imgs) Return the first ChildAdvert filtered by the imgs column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByImgsSizes(string $imgs_sizes) Return the first ChildAdvert filtered by the imgs_sizes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByType(int $type) Return the first ChildAdvert filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByCreatedAt(string $created_at) Return the first ChildAdvert filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdvert requireOneByUpdatedAt(string $updated_at) Return the first ChildAdvert filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdvert[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAdvert objects based on current ModelCriteria
 * @method     ChildAdvert[]|ObjectCollection findById(int $id) Return ChildAdvert objects filtered by the id column
 * @method     ChildAdvert[]|ObjectCollection findBySectionId(int $section_id) Return ChildAdvert objects filtered by the section_id column
 * @method     ChildAdvert[]|ObjectCollection findBySubsectionIds(string $subsection_ids) Return ChildAdvert objects filtered by the subsection_ids column
 * @method     ChildAdvert[]|ObjectCollection findByBundleId(int $bundle_id) Return ChildAdvert objects filtered by the bundle_id column
 * @method     ChildAdvert[]|ObjectCollection findBySectionLinkId(int $section_link_id) Return ChildAdvert objects filtered by the section_link_id column
 * @method     ChildAdvert[]|ObjectCollection findByBundleLinkId(int $bundle_link_id) Return ChildAdvert objects filtered by the bundle_link_id column
 * @method     ChildAdvert[]|ObjectCollection findByViewAtHomepage(boolean $view_at_homepage) Return ChildAdvert objects filtered by the view_at_homepage column
 * @method     ChildAdvert[]|ObjectCollection findByHomePosition(string $home_position) Return ChildAdvert objects filtered by the home_position column
 * @method     ChildAdvert[]|ObjectCollection findByViewAtSection(boolean $view_at_section) Return ChildAdvert objects filtered by the view_at_section column
 * @method     ChildAdvert[]|ObjectCollection findBySectionPosition(string $section_position) Return ChildAdvert objects filtered by the section_position column
 * @method     ChildAdvert[]|ObjectCollection findByLocation(string $location) Return ChildAdvert objects filtered by the location column
 * @method     ChildAdvert[]|ObjectCollection findByCompany(string $company) Return ChildAdvert objects filtered by the company column
 * @method     ChildAdvert[]|ObjectCollection findByPlatform(string $platform) Return ChildAdvert objects filtered by the platform column
 * @method     ChildAdvert[]|ObjectCollection findByPlatformVersion(string $platform_version) Return ChildAdvert objects filtered by the platform_version column
 * @method     ChildAdvert[]|ObjectCollection findByCanDelete(boolean $can_delete) Return ChildAdvert objects filtered by the can_delete column
 * @method     ChildAdvert[]|ObjectCollection findByPublishedAt(string $published_at) Return ChildAdvert objects filtered by the published_at column
 * @method     ChildAdvert[]|ObjectCollection findByExpiredAt(string $expired_at) Return ChildAdvert objects filtered by the expired_at column
 * @method     ChildAdvert[]|ObjectCollection findByCustomerId(int $customer_id) Return ChildAdvert objects filtered by the customer_id column
 * @method     ChildAdvert[]|ObjectCollection findByRatio(double $ratio) Return ChildAdvert objects filtered by the ratio column
 * @method     ChildAdvert[]|ObjectCollection findByDailyLimit(int $daily_limit) Return ChildAdvert objects filtered by the daily_limit column
 * @method     ChildAdvert[]|ObjectCollection findByDraft(boolean $draft) Return ChildAdvert objects filtered by the draft column
 * @method     ChildAdvert[]|ObjectCollection findByImg(string $img) Return ChildAdvert objects filtered by the img column
 * @method     ChildAdvert[]|ObjectCollection findByImgs(string $imgs) Return ChildAdvert objects filtered by the imgs column
 * @method     ChildAdvert[]|ObjectCollection findByImgsSizes(string $imgs_sizes) Return ChildAdvert objects filtered by the imgs_sizes column
 * @method     ChildAdvert[]|ObjectCollection findByType(int $type) Return ChildAdvert objects filtered by the type column
 * @method     ChildAdvert[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildAdvert objects filtered by the created_at column
 * @method     ChildAdvert[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildAdvert objects filtered by the updated_at column
 * @method     ChildAdvert[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AdvertQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Common\DbBundle\Model\Base\AdvertQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Common\\DbBundle\\Model\\Advert', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAdvertQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAdvertQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAdvertQuery) {
            return $criteria;
        }
        $query = new ChildAdvertQuery();
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
     * @return ChildAdvert|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AdvertTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AdvertTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAdvert A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `section_id`, `subsection_ids`, `bundle_id`, `section_link_id`, `bundle_link_id`, `view_at_homepage`, `home_position`, `view_at_section`, `section_position`, `location`, `company`, `platform`, `platform_version`, `can_delete`, `published_at`, `expired_at`, `customer_id`, `ratio`, `daily_limit`, `draft`, `img`, `imgs`, `imgs_sizes`, `type`, `created_at`, `updated_at` FROM `advert` WHERE `id` = :p0';
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
            /** @var ChildAdvert $obj */
            $obj = new ChildAdvert();
            $obj->hydrate($row);
            AdvertTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAdvert|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdvertTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdvertTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterBySectionId($sectionId = null, $comparison = null)
    {
        if (is_array($sectionId)) {
            $useMinMax = false;
            if (isset($sectionId['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_SECTION_ID, $sectionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sectionId['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_SECTION_ID, $sectionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_SECTION_ID, $sectionId, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterBySubsectionIds($subsectionIds = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subsectionIds)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_SUBSECTION_IDS, $subsectionIds, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByBundleId($bundleId = null, $comparison = null)
    {
        if (is_array($bundleId)) {
            $useMinMax = false;
            if (isset($bundleId['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_BUNDLE_ID, $bundleId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bundleId['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_BUNDLE_ID, $bundleId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_BUNDLE_ID, $bundleId, $comparison);
    }

    /**
     * Filter the query on the section_link_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySectionLinkId(1234); // WHERE section_link_id = 1234
     * $query->filterBySectionLinkId(array(12, 34)); // WHERE section_link_id IN (12, 34)
     * $query->filterBySectionLinkId(array('min' => 12)); // WHERE section_link_id > 12
     * </code>
     *
     * @param     mixed $sectionLinkId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterBySectionLinkId($sectionLinkId = null, $comparison = null)
    {
        if (is_array($sectionLinkId)) {
            $useMinMax = false;
            if (isset($sectionLinkId['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_SECTION_LINK_ID, $sectionLinkId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sectionLinkId['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_SECTION_LINK_ID, $sectionLinkId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_SECTION_LINK_ID, $sectionLinkId, $comparison);
    }

    /**
     * Filter the query on the bundle_link_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBundleLinkId(1234); // WHERE bundle_link_id = 1234
     * $query->filterByBundleLinkId(array(12, 34)); // WHERE bundle_link_id IN (12, 34)
     * $query->filterByBundleLinkId(array('min' => 12)); // WHERE bundle_link_id > 12
     * </code>
     *
     * @param     mixed $bundleLinkId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByBundleLinkId($bundleLinkId = null, $comparison = null)
    {
        if (is_array($bundleLinkId)) {
            $useMinMax = false;
            if (isset($bundleLinkId['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_BUNDLE_LINK_ID, $bundleLinkId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bundleLinkId['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_BUNDLE_LINK_ID, $bundleLinkId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_BUNDLE_LINK_ID, $bundleLinkId, $comparison);
    }

    /**
     * Filter the query on the view_at_homepage column
     *
     * Example usage:
     * <code>
     * $query->filterByViewAtHomepage(true); // WHERE view_at_homepage = true
     * $query->filterByViewAtHomepage('yes'); // WHERE view_at_homepage = true
     * </code>
     *
     * @param     boolean|string $viewAtHomepage The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByViewAtHomepage($viewAtHomepage = null, $comparison = null)
    {
        if (is_string($viewAtHomepage)) {
            $viewAtHomepage = in_array(strtolower($viewAtHomepage), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvertTableMap::COL_VIEW_AT_HOMEPAGE, $viewAtHomepage, $comparison);
    }

    /**
     * Filter the query on the home_position column
     *
     * Example usage:
     * <code>
     * $query->filterByHomePosition('fooValue');   // WHERE home_position = 'fooValue'
     * $query->filterByHomePosition('%fooValue%', Criteria::LIKE); // WHERE home_position LIKE '%fooValue%'
     * </code>
     *
     * @param     string $homePosition The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByHomePosition($homePosition = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($homePosition)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_HOME_POSITION, $homePosition, $comparison);
    }

    /**
     * Filter the query on the view_at_section column
     *
     * Example usage:
     * <code>
     * $query->filterByViewAtSection(true); // WHERE view_at_section = true
     * $query->filterByViewAtSection('yes'); // WHERE view_at_section = true
     * </code>
     *
     * @param     boolean|string $viewAtSection The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByViewAtSection($viewAtSection = null, $comparison = null)
    {
        if (is_string($viewAtSection)) {
            $viewAtSection = in_array(strtolower($viewAtSection), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvertTableMap::COL_VIEW_AT_SECTION, $viewAtSection, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterBySectionPosition($sectionPosition = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sectionPosition)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_SECTION_POSITION, $sectionPosition, $comparison);
    }

    /**
     * Filter the query on the location column
     *
     * Example usage:
     * <code>
     * $query->filterByLocation('fooValue');   // WHERE location = 'fooValue'
     * $query->filterByLocation('%fooValue%', Criteria::LIKE); // WHERE location LIKE '%fooValue%'
     * </code>
     *
     * @param     string $location The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByLocation($location = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($location)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_LOCATION, $location, $comparison);
    }

    /**
     * Filter the query on the company column
     *
     * Example usage:
     * <code>
     * $query->filterByCompany('fooValue');   // WHERE company = 'fooValue'
     * $query->filterByCompany('%fooValue%', Criteria::LIKE); // WHERE company LIKE '%fooValue%'
     * </code>
     *
     * @param     string $company The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByCompany($company = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($company)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_COMPANY, $company, $comparison);
    }

    /**
     * Filter the query on the platform column
     *
     * Example usage:
     * <code>
     * $query->filterByPlatform('fooValue');   // WHERE platform = 'fooValue'
     * $query->filterByPlatform('%fooValue%', Criteria::LIKE); // WHERE platform LIKE '%fooValue%'
     * </code>
     *
     * @param     string $platform The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByPlatform($platform = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($platform)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_PLATFORM, $platform, $comparison);
    }

    /**
     * Filter the query on the platform_version column
     *
     * Example usage:
     * <code>
     * $query->filterByPlatformVersion('fooValue');   // WHERE platform_version = 'fooValue'
     * $query->filterByPlatformVersion('%fooValue%', Criteria::LIKE); // WHERE platform_version LIKE '%fooValue%'
     * </code>
     *
     * @param     string $platformVersion The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByPlatformVersion($platformVersion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($platformVersion)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_PLATFORM_VERSION, $platformVersion, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByCanDelete($canDelete = null, $comparison = null)
    {
        if (is_string($canDelete)) {
            $canDelete = in_array(strtolower($canDelete), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvertTableMap::COL_CAN_DELETE, $canDelete, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByPublishedAt($publishedAt = null, $comparison = null)
    {
        if (is_array($publishedAt)) {
            $useMinMax = false;
            if (isset($publishedAt['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_PUBLISHED_AT, $publishedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishedAt['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_PUBLISHED_AT, $publishedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_PUBLISHED_AT, $publishedAt, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByExpiredAt($expiredAt = null, $comparison = null)
    {
        if (is_array($expiredAt)) {
            $useMinMax = false;
            if (isset($expiredAt['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_EXPIRED_AT, $expiredAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expiredAt['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_EXPIRED_AT, $expiredAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_EXPIRED_AT, $expiredAt, $comparison);
    }

    /**
     * Filter the query on the customer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCustomerId(1234); // WHERE customer_id = 1234
     * $query->filterByCustomerId(array(12, 34)); // WHERE customer_id IN (12, 34)
     * $query->filterByCustomerId(array('min' => 12)); // WHERE customer_id > 12
     * </code>
     *
     * @see       filterByCustomer()
     *
     * @param     mixed $customerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByCustomerId($customerId = null, $comparison = null)
    {
        if (is_array($customerId)) {
            $useMinMax = false;
            if (isset($customerId['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_CUSTOMER_ID, $customerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customerId['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_CUSTOMER_ID, $customerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_CUSTOMER_ID, $customerId, $comparison);
    }

    /**
     * Filter the query on the ratio column
     *
     * Example usage:
     * <code>
     * $query->filterByRatio(1234); // WHERE ratio = 1234
     * $query->filterByRatio(array(12, 34)); // WHERE ratio IN (12, 34)
     * $query->filterByRatio(array('min' => 12)); // WHERE ratio > 12
     * </code>
     *
     * @param     mixed $ratio The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByRatio($ratio = null, $comparison = null)
    {
        if (is_array($ratio)) {
            $useMinMax = false;
            if (isset($ratio['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_RATIO, $ratio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ratio['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_RATIO, $ratio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_RATIO, $ratio, $comparison);
    }

    /**
     * Filter the query on the daily_limit column
     *
     * Example usage:
     * <code>
     * $query->filterByDailyLimit(1234); // WHERE daily_limit = 1234
     * $query->filterByDailyLimit(array(12, 34)); // WHERE daily_limit IN (12, 34)
     * $query->filterByDailyLimit(array('min' => 12)); // WHERE daily_limit > 12
     * </code>
     *
     * @param     mixed $dailyLimit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByDailyLimit($dailyLimit = null, $comparison = null)
    {
        if (is_array($dailyLimit)) {
            $useMinMax = false;
            if (isset($dailyLimit['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_DAILY_LIMIT, $dailyLimit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dailyLimit['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_DAILY_LIMIT, $dailyLimit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_DAILY_LIMIT, $dailyLimit, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByDraft($draft = null, $comparison = null)
    {
        if (is_string($draft)) {
            $draft = in_array(strtolower($draft), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvertTableMap::COL_DRAFT, $draft, $comparison);
    }

    /**
     * Filter the query on the img column
     *
     * Example usage:
     * <code>
     * $query->filterByImg('fooValue');   // WHERE img = 'fooValue'
     * $query->filterByImg('%fooValue%', Criteria::LIKE); // WHERE img LIKE '%fooValue%'
     * </code>
     *
     * @param     string $img The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByImg($img = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($img)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_IMG, $img, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByImgs($imgs = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imgs)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_IMGS, $imgs, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByImgsSizes($imgsSizes = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imgsSizes)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_IMGS_SIZES, $imgsSizes, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType(1234); // WHERE type = 1234
     * $query->filterByType(array(12, 34)); // WHERE type IN (12, 34)
     * $query->filterByType(array('min' => 12)); // WHERE type > 12
     * </code>
     *
     * @param     mixed $type The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_array($type)) {
            $useMinMax = false;
            if (isset($type['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_TYPE, $type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($type['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_TYPE, $type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_TYPE, $type, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(AdvertTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(AdvertTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvertTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Section object
     *
     * @param \Common\DbBundle\Model\Section|ObjectCollection $section The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAdvertQuery The current query, for fluid interface
     */
    public function filterBySection($section, $comparison = null)
    {
        if ($section instanceof \Common\DbBundle\Model\Section) {
            return $this
                ->addUsingAlias(AdvertTableMap::COL_SECTION_ID, $section->getId(), $comparison);
        } elseif ($section instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvertTableMap::COL_SECTION_ID, $section->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
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
     * Filter the query by a related \Common\DbBundle\Model\Customer object
     *
     * @param \Common\DbBundle\Model\Customer|ObjectCollection $customer The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByCustomer($customer, $comparison = null)
    {
        if ($customer instanceof \Common\DbBundle\Model\Customer) {
            return $this
                ->addUsingAlias(AdvertTableMap::COL_CUSTOMER_ID, $customer->getId(), $comparison);
        } elseif ($customer instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvertTableMap::COL_CUSTOMER_ID, $customer->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCustomer() only accepts arguments of type \Common\DbBundle\Model\Customer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Customer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function joinCustomer($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Customer');

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
            $this->addJoinObject($join, 'Customer');
        }

        return $this;
    }

    /**
     * Use the Customer relation Customer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\CustomerQuery A secondary query class using the current class as primary query
     */
    public function useCustomerQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCustomer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Customer', '\Common\DbBundle\Model\CustomerQuery');
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Bundle object
     *
     * @param \Common\DbBundle\Model\Bundle|ObjectCollection $bundle The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByBundle($bundle, $comparison = null)
    {
        if ($bundle instanceof \Common\DbBundle\Model\Bundle) {
            return $this
                ->addUsingAlias(AdvertTableMap::COL_BUNDLE_ID, $bundle->getId(), $comparison);
        } elseif ($bundle instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvertTableMap::COL_BUNDLE_ID, $bundle->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAdvertQuery The current query, for fluid interface
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
     * Filter the query by a related \Common\DbBundle\Model\AdvertI18n object
     *
     * @param \Common\DbBundle\Model\AdvertI18n|ObjectCollection $advertI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAdvertQuery The current query, for fluid interface
     */
    public function filterByAdvertI18n($advertI18n, $comparison = null)
    {
        if ($advertI18n instanceof \Common\DbBundle\Model\AdvertI18n) {
            return $this
                ->addUsingAlias(AdvertTableMap::COL_ID, $advertI18n->getId(), $comparison);
        } elseif ($advertI18n instanceof ObjectCollection) {
            return $this
                ->useAdvertI18nQuery()
                ->filterByPrimaryKeys($advertI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvertI18n() only accepts arguments of type \Common\DbBundle\Model\AdvertI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdvertI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function joinAdvertI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdvertI18n');

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
            $this->addJoinObject($join, 'AdvertI18n');
        }

        return $this;
    }

    /**
     * Use the AdvertI18n relation AdvertI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Common\DbBundle\Model\AdvertI18nQuery A secondary query class using the current class as primary query
     */
    public function useAdvertI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinAdvertI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvertI18n', '\Common\DbBundle\Model\AdvertI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAdvert $advert Object to remove from the list of results
     *
     * @return $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function prune($advert = null)
    {
        if ($advert) {
            $this->addUsingAlias(AdvertTableMap::COL_ID, $advert->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the advert table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AdvertTableMap::clearInstancePool();
            AdvertTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AdvertTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AdvertTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AdvertTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AdvertTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(AdvertTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(AdvertTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(AdvertTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(AdvertTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(AdvertTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(AdvertTableMap::COL_CREATED_AT);
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildAdvertQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'AdvertI18n';

        return $this
            ->joinAdvertI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildAdvertQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'vi', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('AdvertI18n');
        $this->with['AdvertI18n']->setIsWithOneToMany(false);

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
     * @return    ChildAdvertI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvertI18n', '\Common\DbBundle\Model\AdvertI18nQuery');
    }

} // AdvertQuery
