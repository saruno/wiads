<?php

namespace Common\DbBundle\Model\Map;

use Common\DbBundle\Model\News;
use Common\DbBundle\Model\NewsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'news' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class NewsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Common.DbBundle.Model.Map.NewsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'news';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Common\\DbBundle\\Model\\News';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Common.DbBundle.Model.News';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the id field
     */
    const COL_ID = 'news.id';

    /**
     * the column name for the section_id field
     */
    const COL_SECTION_ID = 'news.section_id';

    /**
     * the column name for the subsection_ids field
     */
    const COL_SUBSECTION_IDS = 'news.subsection_ids';

    /**
     * the column name for the orders field
     */
    const COL_ORDERS = 'news.orders';

    /**
     * the column name for the suborder_ids field
     */
    const COL_SUBORDER_IDS = 'news.suborder_ids';

    /**
     * the column name for the front_page field
     */
    const COL_FRONT_PAGE = 'news.front_page';

    /**
     * the column name for the has_comment field
     */
    const COL_HAS_COMMENT = 'news.has_comment';

    /**
     * the column name for the can_delete field
     */
    const COL_CAN_DELETE = 'news.can_delete';

    /**
     * the column name for the published_at field
     */
    const COL_PUBLISHED_AT = 'news.published_at';

    /**
     * the column name for the imgs field
     */
    const COL_IMGS = 'news.imgs';

    /**
     * the column name for the relative_news field
     */
    const COL_RELATIVE_NEWS = 'news.relative_news';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'news.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'news.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    // i18n behavior

    /**
     * The default locale to use for translations.
     *
     * @var string
     */
    const DEFAULT_LOCALE = 'en_US';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'SectionId', 'SubsectionIds', 'Orders', 'SuborderIds', 'FrontPage', 'HasComment', 'CanDelete', 'PublishedAt', 'Imgs', 'RelativeNews', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'sectionId', 'subsectionIds', 'orders', 'suborderIds', 'frontPage', 'hasComment', 'canDelete', 'publishedAt', 'imgs', 'relativeNews', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(NewsTableMap::COL_ID, NewsTableMap::COL_SECTION_ID, NewsTableMap::COL_SUBSECTION_IDS, NewsTableMap::COL_ORDERS, NewsTableMap::COL_SUBORDER_IDS, NewsTableMap::COL_FRONT_PAGE, NewsTableMap::COL_HAS_COMMENT, NewsTableMap::COL_CAN_DELETE, NewsTableMap::COL_PUBLISHED_AT, NewsTableMap::COL_IMGS, NewsTableMap::COL_RELATIVE_NEWS, NewsTableMap::COL_CREATED_AT, NewsTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'section_id', 'subsection_ids', 'orders', 'suborder_ids', 'front_page', 'has_comment', 'can_delete', 'published_at', 'imgs', 'relative_news', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'SectionId' => 1, 'SubsectionIds' => 2, 'Orders' => 3, 'SuborderIds' => 4, 'FrontPage' => 5, 'HasComment' => 6, 'CanDelete' => 7, 'PublishedAt' => 8, 'Imgs' => 9, 'RelativeNews' => 10, 'CreatedAt' => 11, 'UpdatedAt' => 12, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'sectionId' => 1, 'subsectionIds' => 2, 'orders' => 3, 'suborderIds' => 4, 'frontPage' => 5, 'hasComment' => 6, 'canDelete' => 7, 'publishedAt' => 8, 'imgs' => 9, 'relativeNews' => 10, 'createdAt' => 11, 'updatedAt' => 12, ),
        self::TYPE_COLNAME       => array(NewsTableMap::COL_ID => 0, NewsTableMap::COL_SECTION_ID => 1, NewsTableMap::COL_SUBSECTION_IDS => 2, NewsTableMap::COL_ORDERS => 3, NewsTableMap::COL_SUBORDER_IDS => 4, NewsTableMap::COL_FRONT_PAGE => 5, NewsTableMap::COL_HAS_COMMENT => 6, NewsTableMap::COL_CAN_DELETE => 7, NewsTableMap::COL_PUBLISHED_AT => 8, NewsTableMap::COL_IMGS => 9, NewsTableMap::COL_RELATIVE_NEWS => 10, NewsTableMap::COL_CREATED_AT => 11, NewsTableMap::COL_UPDATED_AT => 12, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'section_id' => 1, 'subsection_ids' => 2, 'orders' => 3, 'suborder_ids' => 4, 'front_page' => 5, 'has_comment' => 6, 'can_delete' => 7, 'published_at' => 8, 'imgs' => 9, 'relative_news' => 10, 'created_at' => 11, 'updated_at' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('news');
        $this->setPhpName('News');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Common\\DbBundle\\Model\\News');
        $this->setPackage('src.Common.DbBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('section_id', 'SectionId', 'INTEGER', 'section', 'id', false, null, null);
        $this->addColumn('subsection_ids', 'SubsectionIds', 'VARCHAR', false, 1000, null);
        $this->addColumn('orders', 'Orders', 'INTEGER', false, null, null);
        $this->addColumn('suborder_ids', 'SuborderIds', 'VARCHAR', false, 1000, null);
        $this->addColumn('front_page', 'FrontPage', 'BOOLEAN', false, 1, null);
        $this->addColumn('has_comment', 'HasComment', 'BOOLEAN', false, 1, null);
        $this->addColumn('can_delete', 'CanDelete', 'BOOLEAN', false, 1, null);
        $this->addColumn('published_at', 'PublishedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('imgs', 'Imgs', 'VARCHAR', false, 1000, null);
        $this->addColumn('relative_news', 'RelativeNews', 'VARCHAR', false, 1000, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Section', '\\Common\\DbBundle\\Model\\Section', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':section_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', null, false);
        $this->addRelation('Comment', '\\Common\\DbBundle\\Model\\Comment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':news_id',
    1 => ':id',
  ),
), 'SET NULL', 'CASCADE', 'Comments', false);
        $this->addRelation('NewsI18n', '\\Common\\DbBundle\\Model\\NewsI18n', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, 'NewsI18ns', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
            'i18n' => array('i18n_table' => '%TABLE%_i18n', 'i18n_phpname' => '%PHPNAME%I18n', 'i18n_columns' => 'title, strip_title, brief, content, tag, keyword, post_by, edit_by,short_link,link,locked,trash, status, pre_status, status_note,draft,read', 'i18n_pk_column' => '', 'locale_column' => 'locale', 'locale_length' => '5', 'default_locale' => '', 'locale_alias' => '', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to news     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CommentTableMap::clearInstancePool();
        NewsI18nTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? NewsTableMap::CLASS_DEFAULT : NewsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (News object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = NewsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = NewsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + NewsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = NewsTableMap::OM_CLASS;
            /** @var News $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            NewsTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = NewsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = NewsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var News $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                NewsTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(NewsTableMap::COL_ID);
            $criteria->addSelectColumn(NewsTableMap::COL_SECTION_ID);
            $criteria->addSelectColumn(NewsTableMap::COL_SUBSECTION_IDS);
            $criteria->addSelectColumn(NewsTableMap::COL_ORDERS);
            $criteria->addSelectColumn(NewsTableMap::COL_SUBORDER_IDS);
            $criteria->addSelectColumn(NewsTableMap::COL_FRONT_PAGE);
            $criteria->addSelectColumn(NewsTableMap::COL_HAS_COMMENT);
            $criteria->addSelectColumn(NewsTableMap::COL_CAN_DELETE);
            $criteria->addSelectColumn(NewsTableMap::COL_PUBLISHED_AT);
            $criteria->addSelectColumn(NewsTableMap::COL_IMGS);
            $criteria->addSelectColumn(NewsTableMap::COL_RELATIVE_NEWS);
            $criteria->addSelectColumn(NewsTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(NewsTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.section_id');
            $criteria->addSelectColumn($alias . '.subsection_ids');
            $criteria->addSelectColumn($alias . '.orders');
            $criteria->addSelectColumn($alias . '.suborder_ids');
            $criteria->addSelectColumn($alias . '.front_page');
            $criteria->addSelectColumn($alias . '.has_comment');
            $criteria->addSelectColumn($alias . '.can_delete');
            $criteria->addSelectColumn($alias . '.published_at');
            $criteria->addSelectColumn($alias . '.imgs');
            $criteria->addSelectColumn($alias . '.relative_news');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(NewsTableMap::DATABASE_NAME)->getTable(NewsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(NewsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(NewsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new NewsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a News or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or News object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NewsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Common\DbBundle\Model\News) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(NewsTableMap::DATABASE_NAME);
            $criteria->add(NewsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = NewsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            NewsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                NewsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the news table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return NewsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a News or Criteria object.
     *
     * @param mixed               $criteria Criteria or News object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NewsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from News object
        }

        if ($criteria->containsKey(NewsTableMap::COL_ID) && $criteria->keyContainsValue(NewsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.NewsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = NewsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // NewsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
NewsTableMap::buildTableMap();
