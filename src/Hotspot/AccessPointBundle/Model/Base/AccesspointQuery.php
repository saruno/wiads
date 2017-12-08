<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\Customer;
use Common\DbBundle\Model\Section;
use Hotspot\AccessPointBundle\Model\Accesspoint as ChildAccesspoint;
use Hotspot\AccessPointBundle\Model\AccesspointI18nQuery as ChildAccesspointI18nQuery;
use Hotspot\AccessPointBundle\Model\AccesspointQuery as ChildAccesspointQuery;
use Hotspot\AccessPointBundle\Model\Map\AccesspointTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'accesspoint' table.
 *
 *
 *
 * @method     ChildAccesspointQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAccesspointQuery orderByMacaddr($order = Criteria::ASC) Order by the macaddr column
 * @method     ChildAccesspointQuery orderByApMacaddr($order = Criteria::ASC) Order by the ap_macaddr column
 * @method     ChildAccesspointQuery orderByFwVersion($order = Criteria::ASC) Order by the fw_version column
 * @method     ChildAccesspointQuery orderByIsp($order = Criteria::ASC) Order by the isp column
 * @method     ChildAccesspointQuery orderBySsid($order = Criteria::ASC) Order by the ssid column
 * @method     ChildAccesspointQuery orderByKey($order = Criteria::ASC) Order by the key column
 * @method     ChildAccesspointQuery orderByProvince($order = Criteria::ASC) Order by the province column
 * @method     ChildAccesspointQuery orderByAdsLocation($order = Criteria::ASC) Order by the ads_location column
 * @method     ChildAccesspointQuery orderByLoginTemplate($order = Criteria::ASC) Order by the login_template column
 * @method     ChildAccesspointQuery orderByImage($order = Criteria::ASC) Order by the image column
 * @method     ChildAccesspointQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method     ChildAccesspointQuery orderByLng($order = Criteria::ASC) Order by the lng column
 * @method     ChildAccesspointQuery orderByLat($order = Criteria::ASC) Order by the lat column
 * @method     ChildAccesspointQuery orderByDetailUrlId($order = Criteria::ASC) Order by the detail_url_id column
 * @method     ChildAccesspointQuery orderBySectionId($order = Criteria::ASC) Order by the section_id column
 * @method     ChildAccesspointQuery orderBySubsectionIds($order = Criteria::ASC) Order by the subsection_ids column
 * @method     ChildAccesspointQuery orderByOrders($order = Criteria::ASC) Order by the orders column
 * @method     ChildAccesspointQuery orderBySuborderIds($order = Criteria::ASC) Order by the suborder_ids column
 * @method     ChildAccesspointQuery orderByFrontPage($order = Criteria::ASC) Order by the front_page column
 * @method     ChildAccesspointQuery orderByHasComment($order = Criteria::ASC) Order by the has_comment column
 * @method     ChildAccesspointQuery orderByCanDelete($order = Criteria::ASC) Order by the can_delete column
 * @method     ChildAccesspointQuery orderByPublishedAt($order = Criteria::ASC) Order by the published_at column
 * @method     ChildAccesspointQuery orderByImgs($order = Criteria::ASC) Order by the imgs column
 * @method     ChildAccesspointQuery orderByRelativeNews($order = Criteria::ASC) Order by the relative_news column
 * @method     ChildAccesspointQuery orderByOwner($order = Criteria::ASC) Order by the owner column
 * @method     ChildAccesspointQuery orderByCustomerId($order = Criteria::ASC) Order by the customer_id column
 * @method     ChildAccesspointQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildAccesspointQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildAccesspointQuery groupById() Group by the id column
 * @method     ChildAccesspointQuery groupByMacaddr() Group by the macaddr column
 * @method     ChildAccesspointQuery groupByApMacaddr() Group by the ap_macaddr column
 * @method     ChildAccesspointQuery groupByFwVersion() Group by the fw_version column
 * @method     ChildAccesspointQuery groupByIsp() Group by the isp column
 * @method     ChildAccesspointQuery groupBySsid() Group by the ssid column
 * @method     ChildAccesspointQuery groupByKey() Group by the key column
 * @method     ChildAccesspointQuery groupByProvince() Group by the province column
 * @method     ChildAccesspointQuery groupByAdsLocation() Group by the ads_location column
 * @method     ChildAccesspointQuery groupByLoginTemplate() Group by the login_template column
 * @method     ChildAccesspointQuery groupByImage() Group by the image column
 * @method     ChildAccesspointQuery groupByCategoryId() Group by the category_id column
 * @method     ChildAccesspointQuery groupByLng() Group by the lng column
 * @method     ChildAccesspointQuery groupByLat() Group by the lat column
 * @method     ChildAccesspointQuery groupByDetailUrlId() Group by the detail_url_id column
 * @method     ChildAccesspointQuery groupBySectionId() Group by the section_id column
 * @method     ChildAccesspointQuery groupBySubsectionIds() Group by the subsection_ids column
 * @method     ChildAccesspointQuery groupByOrders() Group by the orders column
 * @method     ChildAccesspointQuery groupBySuborderIds() Group by the suborder_ids column
 * @method     ChildAccesspointQuery groupByFrontPage() Group by the front_page column
 * @method     ChildAccesspointQuery groupByHasComment() Group by the has_comment column
 * @method     ChildAccesspointQuery groupByCanDelete() Group by the can_delete column
 * @method     ChildAccesspointQuery groupByPublishedAt() Group by the published_at column
 * @method     ChildAccesspointQuery groupByImgs() Group by the imgs column
 * @method     ChildAccesspointQuery groupByRelativeNews() Group by the relative_news column
 * @method     ChildAccesspointQuery groupByOwner() Group by the owner column
 * @method     ChildAccesspointQuery groupByCustomerId() Group by the customer_id column
 * @method     ChildAccesspointQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildAccesspointQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildAccesspointQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAccesspointQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAccesspointQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAccesspointQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAccesspointQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAccesspointQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAccesspointQuery leftJoinCustomer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Customer relation
 * @method     ChildAccesspointQuery rightJoinCustomer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Customer relation
 * @method     ChildAccesspointQuery innerJoinCustomer($relationAlias = null) Adds a INNER JOIN clause to the query using the Customer relation
 *
 * @method     ChildAccesspointQuery joinWithCustomer($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Customer relation
 *
 * @method     ChildAccesspointQuery leftJoinWithCustomer() Adds a LEFT JOIN clause and with to the query using the Customer relation
 * @method     ChildAccesspointQuery rightJoinWithCustomer() Adds a RIGHT JOIN clause and with to the query using the Customer relation
 * @method     ChildAccesspointQuery innerJoinWithCustomer() Adds a INNER JOIN clause and with to the query using the Customer relation
 *
 * @method     ChildAccesspointQuery leftJoinSection($relationAlias = null) Adds a LEFT JOIN clause to the query using the Section relation
 * @method     ChildAccesspointQuery rightJoinSection($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Section relation
 * @method     ChildAccesspointQuery innerJoinSection($relationAlias = null) Adds a INNER JOIN clause to the query using the Section relation
 *
 * @method     ChildAccesspointQuery joinWithSection($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Section relation
 *
 * @method     ChildAccesspointQuery leftJoinWithSection() Adds a LEFT JOIN clause and with to the query using the Section relation
 * @method     ChildAccesspointQuery rightJoinWithSection() Adds a RIGHT JOIN clause and with to the query using the Section relation
 * @method     ChildAccesspointQuery innerJoinWithSection() Adds a INNER JOIN clause and with to the query using the Section relation
 *
 * @method     ChildAccesspointQuery leftJoinAccesspointCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccesspointCategory relation
 * @method     ChildAccesspointQuery rightJoinAccesspointCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccesspointCategory relation
 * @method     ChildAccesspointQuery innerJoinAccesspointCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the AccesspointCategory relation
 *
 * @method     ChildAccesspointQuery joinWithAccesspointCategory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccesspointCategory relation
 *
 * @method     ChildAccesspointQuery leftJoinWithAccesspointCategory() Adds a LEFT JOIN clause and with to the query using the AccesspointCategory relation
 * @method     ChildAccesspointQuery rightJoinWithAccesspointCategory() Adds a RIGHT JOIN clause and with to the query using the AccesspointCategory relation
 * @method     ChildAccesspointQuery innerJoinWithAccesspointCategory() Adds a INNER JOIN clause and with to the query using the AccesspointCategory relation
 *
 * @method     ChildAccesspointQuery leftJoinAccesspointI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the AccesspointI18n relation
 * @method     ChildAccesspointQuery rightJoinAccesspointI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AccesspointI18n relation
 * @method     ChildAccesspointQuery innerJoinAccesspointI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the AccesspointI18n relation
 *
 * @method     ChildAccesspointQuery joinWithAccesspointI18n($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AccesspointI18n relation
 *
 * @method     ChildAccesspointQuery leftJoinWithAccesspointI18n() Adds a LEFT JOIN clause and with to the query using the AccesspointI18n relation
 * @method     ChildAccesspointQuery rightJoinWithAccesspointI18n() Adds a RIGHT JOIN clause and with to the query using the AccesspointI18n relation
 * @method     ChildAccesspointQuery innerJoinWithAccesspointI18n() Adds a INNER JOIN clause and with to the query using the AccesspointI18n relation
 *
 * @method     \Common\DbBundle\Model\CustomerQuery|\Common\DbBundle\Model\SectionQuery|\Hotspot\AccessPointBundle\Model\AccesspointCategoryQuery|\Hotspot\AccessPointBundle\Model\AccesspointI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAccesspoint findOne(ConnectionInterface $con = null) Return the first ChildAccesspoint matching the query
 * @method     ChildAccesspoint findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAccesspoint matching the query, or a new ChildAccesspoint object populated from the query conditions when no match is found
 *
 * @method     ChildAccesspoint findOneById(int $id) Return the first ChildAccesspoint filtered by the id column
 * @method     ChildAccesspoint findOneByMacaddr(string $macaddr) Return the first ChildAccesspoint filtered by the macaddr column
 * @method     ChildAccesspoint findOneByApMacaddr(string $ap_macaddr) Return the first ChildAccesspoint filtered by the ap_macaddr column
 * @method     ChildAccesspoint findOneByFwVersion(string $fw_version) Return the first ChildAccesspoint filtered by the fw_version column
 * @method     ChildAccesspoint findOneByIsp(string $isp) Return the first ChildAccesspoint filtered by the isp column
 * @method     ChildAccesspoint findOneBySsid(string $ssid) Return the first ChildAccesspoint filtered by the ssid column
 * @method     ChildAccesspoint findOneByKey(string $key) Return the first ChildAccesspoint filtered by the key column
 * @method     ChildAccesspoint findOneByProvince(string $province) Return the first ChildAccesspoint filtered by the province column
 * @method     ChildAccesspoint findOneByAdsLocation(string $ads_location) Return the first ChildAccesspoint filtered by the ads_location column
 * @method     ChildAccesspoint findOneByLoginTemplate(string $login_template) Return the first ChildAccesspoint filtered by the login_template column
 * @method     ChildAccesspoint findOneByImage(string $image) Return the first ChildAccesspoint filtered by the image column
 * @method     ChildAccesspoint findOneByCategoryId(int $category_id) Return the first ChildAccesspoint filtered by the category_id column
 * @method     ChildAccesspoint findOneByLng(string $lng) Return the first ChildAccesspoint filtered by the lng column
 * @method     ChildAccesspoint findOneByLat(string $lat) Return the first ChildAccesspoint filtered by the lat column
 * @method     ChildAccesspoint findOneByDetailUrlId(string $detail_url_id) Return the first ChildAccesspoint filtered by the detail_url_id column
 * @method     ChildAccesspoint findOneBySectionId(int $section_id) Return the first ChildAccesspoint filtered by the section_id column
 * @method     ChildAccesspoint findOneBySubsectionIds(string $subsection_ids) Return the first ChildAccesspoint filtered by the subsection_ids column
 * @method     ChildAccesspoint findOneByOrders(int $orders) Return the first ChildAccesspoint filtered by the orders column
 * @method     ChildAccesspoint findOneBySuborderIds(string $suborder_ids) Return the first ChildAccesspoint filtered by the suborder_ids column
 * @method     ChildAccesspoint findOneByFrontPage(boolean $front_page) Return the first ChildAccesspoint filtered by the front_page column
 * @method     ChildAccesspoint findOneByHasComment(boolean $has_comment) Return the first ChildAccesspoint filtered by the has_comment column
 * @method     ChildAccesspoint findOneByCanDelete(boolean $can_delete) Return the first ChildAccesspoint filtered by the can_delete column
 * @method     ChildAccesspoint findOneByPublishedAt(string $published_at) Return the first ChildAccesspoint filtered by the published_at column
 * @method     ChildAccesspoint findOneByImgs(string $imgs) Return the first ChildAccesspoint filtered by the imgs column
 * @method     ChildAccesspoint findOneByRelativeNews(string $relative_news) Return the first ChildAccesspoint filtered by the relative_news column
 * @method     ChildAccesspoint findOneByOwner(string $owner) Return the first ChildAccesspoint filtered by the owner column
 * @method     ChildAccesspoint findOneByCustomerId(int $customer_id) Return the first ChildAccesspoint filtered by the customer_id column
 * @method     ChildAccesspoint findOneByCreatedAt(string $created_at) Return the first ChildAccesspoint filtered by the created_at column
 * @method     ChildAccesspoint findOneByUpdatedAt(string $updated_at) Return the first ChildAccesspoint filtered by the updated_at column *

 * @method     ChildAccesspoint requirePk($key, ConnectionInterface $con = null) Return the ChildAccesspoint by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOne(ConnectionInterface $con = null) Return the first ChildAccesspoint matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccesspoint requireOneById(int $id) Return the first ChildAccesspoint filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByMacaddr(string $macaddr) Return the first ChildAccesspoint filtered by the macaddr column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByApMacaddr(string $ap_macaddr) Return the first ChildAccesspoint filtered by the ap_macaddr column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByFwVersion(string $fw_version) Return the first ChildAccesspoint filtered by the fw_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByIsp(string $isp) Return the first ChildAccesspoint filtered by the isp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneBySsid(string $ssid) Return the first ChildAccesspoint filtered by the ssid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByKey(string $key) Return the first ChildAccesspoint filtered by the key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByProvince(string $province) Return the first ChildAccesspoint filtered by the province column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByAdsLocation(string $ads_location) Return the first ChildAccesspoint filtered by the ads_location column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByLoginTemplate(string $login_template) Return the first ChildAccesspoint filtered by the login_template column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByImage(string $image) Return the first ChildAccesspoint filtered by the image column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByCategoryId(int $category_id) Return the first ChildAccesspoint filtered by the category_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByLng(string $lng) Return the first ChildAccesspoint filtered by the lng column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByLat(string $lat) Return the first ChildAccesspoint filtered by the lat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByDetailUrlId(string $detail_url_id) Return the first ChildAccesspoint filtered by the detail_url_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneBySectionId(int $section_id) Return the first ChildAccesspoint filtered by the section_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneBySubsectionIds(string $subsection_ids) Return the first ChildAccesspoint filtered by the subsection_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByOrders(int $orders) Return the first ChildAccesspoint filtered by the orders column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneBySuborderIds(string $suborder_ids) Return the first ChildAccesspoint filtered by the suborder_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByFrontPage(boolean $front_page) Return the first ChildAccesspoint filtered by the front_page column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByHasComment(boolean $has_comment) Return the first ChildAccesspoint filtered by the has_comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByCanDelete(boolean $can_delete) Return the first ChildAccesspoint filtered by the can_delete column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByPublishedAt(string $published_at) Return the first ChildAccesspoint filtered by the published_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByImgs(string $imgs) Return the first ChildAccesspoint filtered by the imgs column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByRelativeNews(string $relative_news) Return the first ChildAccesspoint filtered by the relative_news column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByOwner(string $owner) Return the first ChildAccesspoint filtered by the owner column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByCustomerId(int $customer_id) Return the first ChildAccesspoint filtered by the customer_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByCreatedAt(string $created_at) Return the first ChildAccesspoint filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccesspoint requireOneByUpdatedAt(string $updated_at) Return the first ChildAccesspoint filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccesspoint[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAccesspoint objects based on current ModelCriteria
 * @method     ChildAccesspoint[]|ObjectCollection findById(int $id) Return ChildAccesspoint objects filtered by the id column
 * @method     ChildAccesspoint[]|ObjectCollection findByMacaddr(string $macaddr) Return ChildAccesspoint objects filtered by the macaddr column
 * @method     ChildAccesspoint[]|ObjectCollection findByApMacaddr(string $ap_macaddr) Return ChildAccesspoint objects filtered by the ap_macaddr column
 * @method     ChildAccesspoint[]|ObjectCollection findByFwVersion(string $fw_version) Return ChildAccesspoint objects filtered by the fw_version column
 * @method     ChildAccesspoint[]|ObjectCollection findByIsp(string $isp) Return ChildAccesspoint objects filtered by the isp column
 * @method     ChildAccesspoint[]|ObjectCollection findBySsid(string $ssid) Return ChildAccesspoint objects filtered by the ssid column
 * @method     ChildAccesspoint[]|ObjectCollection findByKey(string $key) Return ChildAccesspoint objects filtered by the key column
 * @method     ChildAccesspoint[]|ObjectCollection findByProvince(string $province) Return ChildAccesspoint objects filtered by the province column
 * @method     ChildAccesspoint[]|ObjectCollection findByAdsLocation(string $ads_location) Return ChildAccesspoint objects filtered by the ads_location column
 * @method     ChildAccesspoint[]|ObjectCollection findByLoginTemplate(string $login_template) Return ChildAccesspoint objects filtered by the login_template column
 * @method     ChildAccesspoint[]|ObjectCollection findByImage(string $image) Return ChildAccesspoint objects filtered by the image column
 * @method     ChildAccesspoint[]|ObjectCollection findByCategoryId(int $category_id) Return ChildAccesspoint objects filtered by the category_id column
 * @method     ChildAccesspoint[]|ObjectCollection findByLng(string $lng) Return ChildAccesspoint objects filtered by the lng column
 * @method     ChildAccesspoint[]|ObjectCollection findByLat(string $lat) Return ChildAccesspoint objects filtered by the lat column
 * @method     ChildAccesspoint[]|ObjectCollection findByDetailUrlId(string $detail_url_id) Return ChildAccesspoint objects filtered by the detail_url_id column
 * @method     ChildAccesspoint[]|ObjectCollection findBySectionId(int $section_id) Return ChildAccesspoint objects filtered by the section_id column
 * @method     ChildAccesspoint[]|ObjectCollection findBySubsectionIds(string $subsection_ids) Return ChildAccesspoint objects filtered by the subsection_ids column
 * @method     ChildAccesspoint[]|ObjectCollection findByOrders(int $orders) Return ChildAccesspoint objects filtered by the orders column
 * @method     ChildAccesspoint[]|ObjectCollection findBySuborderIds(string $suborder_ids) Return ChildAccesspoint objects filtered by the suborder_ids column
 * @method     ChildAccesspoint[]|ObjectCollection findByFrontPage(boolean $front_page) Return ChildAccesspoint objects filtered by the front_page column
 * @method     ChildAccesspoint[]|ObjectCollection findByHasComment(boolean $has_comment) Return ChildAccesspoint objects filtered by the has_comment column
 * @method     ChildAccesspoint[]|ObjectCollection findByCanDelete(boolean $can_delete) Return ChildAccesspoint objects filtered by the can_delete column
 * @method     ChildAccesspoint[]|ObjectCollection findByPublishedAt(string $published_at) Return ChildAccesspoint objects filtered by the published_at column
 * @method     ChildAccesspoint[]|ObjectCollection findByImgs(string $imgs) Return ChildAccesspoint objects filtered by the imgs column
 * @method     ChildAccesspoint[]|ObjectCollection findByRelativeNews(string $relative_news) Return ChildAccesspoint objects filtered by the relative_news column
 * @method     ChildAccesspoint[]|ObjectCollection findByOwner(string $owner) Return ChildAccesspoint objects filtered by the owner column
 * @method     ChildAccesspoint[]|ObjectCollection findByCustomerId(int $customer_id) Return ChildAccesspoint objects filtered by the customer_id column
 * @method     ChildAccesspoint[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildAccesspoint objects filtered by the created_at column
 * @method     ChildAccesspoint[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildAccesspoint objects filtered by the updated_at column
 * @method     ChildAccesspoint[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AccesspointQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Hotspot\AccessPointBundle\Model\Base\AccesspointQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Hotspot\\AccessPointBundle\\Model\\Accesspoint', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAccesspointQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAccesspointQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAccesspointQuery) {
            return $criteria;
        }
        $query = new ChildAccesspointQuery();
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
     * @return ChildAccesspoint|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AccesspointTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AccesspointTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAccesspoint A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `macaddr`, `ap_macaddr`, `fw_version`, `isp`, `ssid`, `key`, `province`, `ads_location`, `login_template`, `image`, `category_id`, `lng`, `lat`, `detail_url_id`, `section_id`, `subsection_ids`, `orders`, `suborder_ids`, `front_page`, `has_comment`, `can_delete`, `published_at`, `imgs`, `relative_news`, `owner`, `customer_id`, `created_at`, `updated_at` FROM `accesspoint` WHERE `id` = :p0';
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
            /** @var ChildAccesspoint $obj */
            $obj = new ChildAccesspoint();
            $obj->hydrate($row);
            AccesspointTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAccesspoint|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AccesspointTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AccesspointTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the macaddr column
     *
     * Example usage:
     * <code>
     * $query->filterByMacaddr('fooValue');   // WHERE macaddr = 'fooValue'
     * $query->filterByMacaddr('%fooValue%', Criteria::LIKE); // WHERE macaddr LIKE '%fooValue%'
     * </code>
     *
     * @param     string $macaddr The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByMacaddr($macaddr = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($macaddr)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_MACADDR, $macaddr, $comparison);
    }

    /**
     * Filter the query on the ap_macaddr column
     *
     * Example usage:
     * <code>
     * $query->filterByApMacaddr('fooValue');   // WHERE ap_macaddr = 'fooValue'
     * $query->filterByApMacaddr('%fooValue%', Criteria::LIKE); // WHERE ap_macaddr LIKE '%fooValue%'
     * </code>
     *
     * @param     string $apMacaddr The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByApMacaddr($apMacaddr = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apMacaddr)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_AP_MACADDR, $apMacaddr, $comparison);
    }

    /**
     * Filter the query on the fw_version column
     *
     * Example usage:
     * <code>
     * $query->filterByFwVersion('fooValue');   // WHERE fw_version = 'fooValue'
     * $query->filterByFwVersion('%fooValue%', Criteria::LIKE); // WHERE fw_version LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fwVersion The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByFwVersion($fwVersion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fwVersion)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_FW_VERSION, $fwVersion, $comparison);
    }

    /**
     * Filter the query on the isp column
     *
     * Example usage:
     * <code>
     * $query->filterByIsp('fooValue');   // WHERE isp = 'fooValue'
     * $query->filterByIsp('%fooValue%', Criteria::LIKE); // WHERE isp LIKE '%fooValue%'
     * </code>
     *
     * @param     string $isp The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByIsp($isp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($isp)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_ISP, $isp, $comparison);
    }

    /**
     * Filter the query on the ssid column
     *
     * Example usage:
     * <code>
     * $query->filterBySsid('fooValue');   // WHERE ssid = 'fooValue'
     * $query->filterBySsid('%fooValue%', Criteria::LIKE); // WHERE ssid LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ssid The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterBySsid($ssid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ssid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_SSID, $ssid, $comparison);
    }

    /**
     * Filter the query on the key column
     *
     * Example usage:
     * <code>
     * $query->filterByKey('fooValue');   // WHERE key = 'fooValue'
     * $query->filterByKey('%fooValue%', Criteria::LIKE); // WHERE key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $key The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByKey($key = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($key)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_KEY, $key, $comparison);
    }

    /**
     * Filter the query on the province column
     *
     * Example usage:
     * <code>
     * $query->filterByProvince('fooValue');   // WHERE province = 'fooValue'
     * $query->filterByProvince('%fooValue%', Criteria::LIKE); // WHERE province LIKE '%fooValue%'
     * </code>
     *
     * @param     string $province The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByProvince($province = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($province)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_PROVINCE, $province, $comparison);
    }

    /**
     * Filter the query on the ads_location column
     *
     * Example usage:
     * <code>
     * $query->filterByAdsLocation('fooValue');   // WHERE ads_location = 'fooValue'
     * $query->filterByAdsLocation('%fooValue%', Criteria::LIKE); // WHERE ads_location LIKE '%fooValue%'
     * </code>
     *
     * @param     string $adsLocation The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByAdsLocation($adsLocation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($adsLocation)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_ADS_LOCATION, $adsLocation, $comparison);
    }

    /**
     * Filter the query on the login_template column
     *
     * Example usage:
     * <code>
     * $query->filterByLoginTemplate('fooValue');   // WHERE login_template = 'fooValue'
     * $query->filterByLoginTemplate('%fooValue%', Criteria::LIKE); // WHERE login_template LIKE '%fooValue%'
     * </code>
     *
     * @param     string $loginTemplate The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByLoginTemplate($loginTemplate = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($loginTemplate)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_LOGIN_TEMPLATE, $loginTemplate, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByImage($image = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($image)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_IMAGE, $image, $comparison);
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
     * @see       filterByAccesspointCategory()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the lng column
     *
     * Example usage:
     * <code>
     * $query->filterByLng('fooValue');   // WHERE lng = 'fooValue'
     * $query->filterByLng('%fooValue%', Criteria::LIKE); // WHERE lng LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lng The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByLng($lng = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lng)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_LNG, $lng, $comparison);
    }

    /**
     * Filter the query on the lat column
     *
     * Example usage:
     * <code>
     * $query->filterByLat('fooValue');   // WHERE lat = 'fooValue'
     * $query->filterByLat('%fooValue%', Criteria::LIKE); // WHERE lat LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lat The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByLat($lat = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lat)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_LAT, $lat, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByDetailUrlId($detailUrlId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($detailUrlId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_DETAIL_URL_ID, $detailUrlId, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterBySectionId($sectionId = null, $comparison = null)
    {
        if (is_array($sectionId)) {
            $useMinMax = false;
            if (isset($sectionId['min'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_SECTION_ID, $sectionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sectionId['max'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_SECTION_ID, $sectionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_SECTION_ID, $sectionId, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterBySubsectionIds($subsectionIds = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subsectionIds)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_SUBSECTION_IDS, $subsectionIds, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByOrders($orders = null, $comparison = null)
    {
        if (is_array($orders)) {
            $useMinMax = false;
            if (isset($orders['min'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_ORDERS, $orders['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orders['max'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_ORDERS, $orders['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_ORDERS, $orders, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterBySuborderIds($suborderIds = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($suborderIds)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_SUBORDER_IDS, $suborderIds, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByFrontPage($frontPage = null, $comparison = null)
    {
        if (is_string($frontPage)) {
            $frontPage = in_array(strtolower($frontPage), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_FRONT_PAGE, $frontPage, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByHasComment($hasComment = null, $comparison = null)
    {
        if (is_string($hasComment)) {
            $hasComment = in_array(strtolower($hasComment), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_HAS_COMMENT, $hasComment, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByCanDelete($canDelete = null, $comparison = null)
    {
        if (is_string($canDelete)) {
            $canDelete = in_array(strtolower($canDelete), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_CAN_DELETE, $canDelete, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByPublishedAt($publishedAt = null, $comparison = null)
    {
        if (is_array($publishedAt)) {
            $useMinMax = false;
            if (isset($publishedAt['min'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_PUBLISHED_AT, $publishedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishedAt['max'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_PUBLISHED_AT, $publishedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_PUBLISHED_AT, $publishedAt, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByImgs($imgs = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imgs)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_IMGS, $imgs, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByRelativeNews($relativeNews = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($relativeNews)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_RELATIVE_NEWS, $relativeNews, $comparison);
    }

    /**
     * Filter the query on the owner column
     *
     * Example usage:
     * <code>
     * $query->filterByOwner('fooValue');   // WHERE owner = 'fooValue'
     * $query->filterByOwner('%fooValue%', Criteria::LIKE); // WHERE owner LIKE '%fooValue%'
     * </code>
     *
     * @param     string $owner The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByOwner($owner = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($owner)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_OWNER, $owner, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByCustomerId($customerId = null, $comparison = null)
    {
        if (is_array($customerId)) {
            $useMinMax = false;
            if (isset($customerId['min'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_CUSTOMER_ID, $customerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($customerId['max'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_CUSTOMER_ID, $customerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_CUSTOMER_ID, $customerId, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(AccesspointTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccesspointTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Common\DbBundle\Model\Customer object
     *
     * @param \Common\DbBundle\Model\Customer|ObjectCollection $customer The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByCustomer($customer, $comparison = null)
    {
        if ($customer instanceof \Common\DbBundle\Model\Customer) {
            return $this
                ->addUsingAlias(AccesspointTableMap::COL_CUSTOMER_ID, $customer->getId(), $comparison);
        } elseif ($customer instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccesspointTableMap::COL_CUSTOMER_ID, $customer->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
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
     * Filter the query by a related \Common\DbBundle\Model\Section object
     *
     * @param \Common\DbBundle\Model\Section|ObjectCollection $section The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterBySection($section, $comparison = null)
    {
        if ($section instanceof \Common\DbBundle\Model\Section) {
            return $this
                ->addUsingAlias(AccesspointTableMap::COL_SECTION_ID, $section->getId(), $comparison);
        } elseif ($section instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccesspointTableMap::COL_SECTION_ID, $section->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
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
     * Filter the query by a related \Hotspot\AccessPointBundle\Model\AccesspointCategory object
     *
     * @param \Hotspot\AccessPointBundle\Model\AccesspointCategory|ObjectCollection $accesspointCategory The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByAccesspointCategory($accesspointCategory, $comparison = null)
    {
        if ($accesspointCategory instanceof \Hotspot\AccessPointBundle\Model\AccesspointCategory) {
            return $this
                ->addUsingAlias(AccesspointTableMap::COL_CATEGORY_ID, $accesspointCategory->getId(), $comparison);
        } elseif ($accesspointCategory instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccesspointTableMap::COL_CATEGORY_ID, $accesspointCategory->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAccesspointCategory() only accepts arguments of type \Hotspot\AccessPointBundle\Model\AccesspointCategory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccesspointCategory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function joinAccesspointCategory($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccesspointCategory');

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
            $this->addJoinObject($join, 'AccesspointCategory');
        }

        return $this;
    }

    /**
     * Use the AccesspointCategory relation AccesspointCategory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Hotspot\AccessPointBundle\Model\AccesspointCategoryQuery A secondary query class using the current class as primary query
     */
    public function useAccesspointCategoryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAccesspointCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccesspointCategory', '\Hotspot\AccessPointBundle\Model\AccesspointCategoryQuery');
    }

    /**
     * Filter the query by a related \Hotspot\AccessPointBundle\Model\AccesspointI18n object
     *
     * @param \Hotspot\AccessPointBundle\Model\AccesspointI18n|ObjectCollection $accesspointI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAccesspointQuery The current query, for fluid interface
     */
    public function filterByAccesspointI18n($accesspointI18n, $comparison = null)
    {
        if ($accesspointI18n instanceof \Hotspot\AccessPointBundle\Model\AccesspointI18n) {
            return $this
                ->addUsingAlias(AccesspointTableMap::COL_ID, $accesspointI18n->getId(), $comparison);
        } elseif ($accesspointI18n instanceof ObjectCollection) {
            return $this
                ->useAccesspointI18nQuery()
                ->filterByPrimaryKeys($accesspointI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccesspointI18n() only accepts arguments of type \Hotspot\AccessPointBundle\Model\AccesspointI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AccesspointI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function joinAccesspointI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AccesspointI18n');

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
            $this->addJoinObject($join, 'AccesspointI18n');
        }

        return $this;
    }

    /**
     * Use the AccesspointI18n relation AccesspointI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Hotspot\AccessPointBundle\Model\AccesspointI18nQuery A secondary query class using the current class as primary query
     */
    public function useAccesspointI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinAccesspointI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccesspointI18n', '\Hotspot\AccessPointBundle\Model\AccesspointI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAccesspoint $accesspoint Object to remove from the list of results
     *
     * @return $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function prune($accesspoint = null)
    {
        if ($accesspoint) {
            $this->addUsingAlias(AccesspointTableMap::COL_ID, $accesspoint->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the accesspoint table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AccesspointTableMap::clearInstancePool();
            AccesspointTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AccesspointTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AccesspointTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AccesspointTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(AccesspointTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(AccesspointTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(AccesspointTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(AccesspointTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(AccesspointTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(AccesspointTableMap::COL_CREATED_AT);
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildAccesspointQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'AccesspointI18n';

        return $this
            ->joinAccesspointI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this|ChildAccesspointQuery The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'vi', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('AccesspointI18n');
        $this->with['AccesspointI18n']->setIsWithOneToMany(false);

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
     * @return    ChildAccesspointI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'vi', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AccesspointI18n', '\Hotspot\AccessPointBundle\Model\AccesspointI18nQuery');
    }

} // AccesspointQuery
