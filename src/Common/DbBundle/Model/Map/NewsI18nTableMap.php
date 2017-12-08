<?php

namespace Common\DbBundle\Model\Map;

use Common\DbBundle\Model\NewsI18n;
use Common\DbBundle\Model\NewsI18nQuery;
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
 * This class defines the structure of the 'news_i18n' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class NewsI18nTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Common.DbBundle.Model.Map.NewsI18nTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'news_i18n';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Common\\DbBundle\\Model\\NewsI18n';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Common.DbBundle.Model.NewsI18n';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 19;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 19;

    /**
     * the column name for the id field
     */
    const COL_ID = 'news_i18n.id';

    /**
     * the column name for the locale field
     */
    const COL_LOCALE = 'news_i18n.locale';

    /**
     * the column name for the title field
     */
    const COL_TITLE = 'news_i18n.title';

    /**
     * the column name for the strip_title field
     */
    const COL_STRIP_TITLE = 'news_i18n.strip_title';

    /**
     * the column name for the brief field
     */
    const COL_BRIEF = 'news_i18n.brief';

    /**
     * the column name for the content field
     */
    const COL_CONTENT = 'news_i18n.content';

    /**
     * the column name for the tag field
     */
    const COL_TAG = 'news_i18n.tag';

    /**
     * the column name for the keyword field
     */
    const COL_KEYWORD = 'news_i18n.keyword';

    /**
     * the column name for the post_by field
     */
    const COL_POST_BY = 'news_i18n.post_by';

    /**
     * the column name for the edit_by field
     */
    const COL_EDIT_BY = 'news_i18n.edit_by';

    /**
     * the column name for the short_link field
     */
    const COL_SHORT_LINK = 'news_i18n.short_link';

    /**
     * the column name for the link field
     */
    const COL_LINK = 'news_i18n.link';

    /**
     * the column name for the locked field
     */
    const COL_LOCKED = 'news_i18n.locked';

    /**
     * the column name for the trash field
     */
    const COL_TRASH = 'news_i18n.trash';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'news_i18n.status';

    /**
     * the column name for the pre_status field
     */
    const COL_PRE_STATUS = 'news_i18n.pre_status';

    /**
     * the column name for the status_note field
     */
    const COL_STATUS_NOTE = 'news_i18n.status_note';

    /**
     * the column name for the draft field
     */
    const COL_DRAFT = 'news_i18n.draft';

    /**
     * the column name for the read field
     */
    const COL_READ = 'news_i18n.read';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Locale', 'Title', 'StripTitle', 'Brief', 'Content', 'Tag', 'Keyword', 'PostBy', 'EditBy', 'ShortLink', 'Link', 'Locked', 'Trash', 'Status', 'PreStatus', 'StatusNote', 'Draft', 'Read', ),
        self::TYPE_CAMELNAME     => array('id', 'locale', 'title', 'stripTitle', 'brief', 'content', 'tag', 'keyword', 'postBy', 'editBy', 'shortLink', 'link', 'locked', 'trash', 'status', 'preStatus', 'statusNote', 'draft', 'read', ),
        self::TYPE_COLNAME       => array(NewsI18nTableMap::COL_ID, NewsI18nTableMap::COL_LOCALE, NewsI18nTableMap::COL_TITLE, NewsI18nTableMap::COL_STRIP_TITLE, NewsI18nTableMap::COL_BRIEF, NewsI18nTableMap::COL_CONTENT, NewsI18nTableMap::COL_TAG, NewsI18nTableMap::COL_KEYWORD, NewsI18nTableMap::COL_POST_BY, NewsI18nTableMap::COL_EDIT_BY, NewsI18nTableMap::COL_SHORT_LINK, NewsI18nTableMap::COL_LINK, NewsI18nTableMap::COL_LOCKED, NewsI18nTableMap::COL_TRASH, NewsI18nTableMap::COL_STATUS, NewsI18nTableMap::COL_PRE_STATUS, NewsI18nTableMap::COL_STATUS_NOTE, NewsI18nTableMap::COL_DRAFT, NewsI18nTableMap::COL_READ, ),
        self::TYPE_FIELDNAME     => array('id', 'locale', 'title', 'strip_title', 'brief', 'content', 'tag', 'keyword', 'post_by', 'edit_by', 'short_link', 'link', 'locked', 'trash', 'status', 'pre_status', 'status_note', 'draft', 'read', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Locale' => 1, 'Title' => 2, 'StripTitle' => 3, 'Brief' => 4, 'Content' => 5, 'Tag' => 6, 'Keyword' => 7, 'PostBy' => 8, 'EditBy' => 9, 'ShortLink' => 10, 'Link' => 11, 'Locked' => 12, 'Trash' => 13, 'Status' => 14, 'PreStatus' => 15, 'StatusNote' => 16, 'Draft' => 17, 'Read' => 18, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'locale' => 1, 'title' => 2, 'stripTitle' => 3, 'brief' => 4, 'content' => 5, 'tag' => 6, 'keyword' => 7, 'postBy' => 8, 'editBy' => 9, 'shortLink' => 10, 'link' => 11, 'locked' => 12, 'trash' => 13, 'status' => 14, 'preStatus' => 15, 'statusNote' => 16, 'draft' => 17, 'read' => 18, ),
        self::TYPE_COLNAME       => array(NewsI18nTableMap::COL_ID => 0, NewsI18nTableMap::COL_LOCALE => 1, NewsI18nTableMap::COL_TITLE => 2, NewsI18nTableMap::COL_STRIP_TITLE => 3, NewsI18nTableMap::COL_BRIEF => 4, NewsI18nTableMap::COL_CONTENT => 5, NewsI18nTableMap::COL_TAG => 6, NewsI18nTableMap::COL_KEYWORD => 7, NewsI18nTableMap::COL_POST_BY => 8, NewsI18nTableMap::COL_EDIT_BY => 9, NewsI18nTableMap::COL_SHORT_LINK => 10, NewsI18nTableMap::COL_LINK => 11, NewsI18nTableMap::COL_LOCKED => 12, NewsI18nTableMap::COL_TRASH => 13, NewsI18nTableMap::COL_STATUS => 14, NewsI18nTableMap::COL_PRE_STATUS => 15, NewsI18nTableMap::COL_STATUS_NOTE => 16, NewsI18nTableMap::COL_DRAFT => 17, NewsI18nTableMap::COL_READ => 18, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'locale' => 1, 'title' => 2, 'strip_title' => 3, 'brief' => 4, 'content' => 5, 'tag' => 6, 'keyword' => 7, 'post_by' => 8, 'edit_by' => 9, 'short_link' => 10, 'link' => 11, 'locked' => 12, 'trash' => 13, 'status' => 14, 'pre_status' => 15, 'status_note' => 16, 'draft' => 17, 'read' => 18, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
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
        $this->setName('news_i18n');
        $this->setPhpName('NewsI18n');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Common\\DbBundle\\Model\\NewsI18n');
        $this->setPackage('src.Common.DbBundle.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id', 'Id', 'INTEGER' , 'news', 'id', true, null, null);
        $this->addPrimaryKey('locale', 'Locale', 'VARCHAR', true, 5, 'en_US');
        $this->addColumn('title', 'Title', 'VARCHAR', false, 1000, null);
        $this->getColumn('title')->setPrimaryString(true);
        $this->addColumn('strip_title', 'StripTitle', 'VARCHAR', false, 1000, null);
        $this->getColumn('strip_title')->setPrimaryString(true);
        $this->addColumn('brief', 'Brief', 'LONGVARCHAR', false, null, null);
        $this->addColumn('content', 'Content', 'CLOB', false, null, null);
        $this->addColumn('tag', 'Tag', 'VARCHAR', false, 1000, null);
        $this->addColumn('keyword', 'Keyword', 'VARCHAR', false, 1000, null);
        $this->addColumn('post_by', 'PostBy', 'VARCHAR', false, 1000, null);
        $this->addColumn('edit_by', 'EditBy', 'VARCHAR', false, 1000, null);
        $this->addColumn('short_link', 'ShortLink', 'VARCHAR', false, 1000, null);
        $this->addColumn('link', 'Link', 'VARCHAR', false, 1000, null);
        $this->addColumn('locked', 'Locked', 'BOOLEAN', false, 1, null);
        $this->addColumn('trash', 'Trash', 'BOOLEAN', false, 1, null);
        $this->addColumn('status', 'Status', 'VARCHAR', false, 255, null);
        $this->addColumn('pre_status', 'PreStatus', 'VARCHAR', false, 255, null);
        $this->addColumn('status_note', 'StatusNote', 'VARCHAR', false, 1000, null);
        $this->addColumn('draft', 'Draft', 'BOOLEAN', false, 1, null);
        $this->addColumn('read', 'Read', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('News', '\\Common\\DbBundle\\Model\\News', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \Common\DbBundle\Model\NewsI18n $obj A \Common\DbBundle\Model\NewsI18n object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getId() || is_scalar($obj->getId()) || is_callable([$obj->getId(), '__toString']) ? (string) $obj->getId() : $obj->getId()), (null === $obj->getLocale() || is_scalar($obj->getLocale()) || is_callable([$obj->getLocale(), '__toString']) ? (string) $obj->getLocale() : $obj->getLocale())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \Common\DbBundle\Model\NewsI18n object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Common\DbBundle\Model\NewsI18n) {
                $key = serialize([(null === $value->getId() || is_scalar($value->getId()) || is_callable([$value->getId(), '__toString']) ? (string) $value->getId() : $value->getId()), (null === $value->getLocale() || is_scalar($value->getLocale()) || is_callable([$value->getLocale(), '__toString']) ? (string) $value->getLocale() : $value->getLocale())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Common\DbBundle\Model\NewsI18n object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)])]);
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
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
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
        return $withPrefix ? NewsI18nTableMap::CLASS_DEFAULT : NewsI18nTableMap::OM_CLASS;
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
     * @return array           (NewsI18n object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = NewsI18nTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = NewsI18nTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + NewsI18nTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = NewsI18nTableMap::OM_CLASS;
            /** @var NewsI18n $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            NewsI18nTableMap::addInstanceToPool($obj, $key);
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
            $key = NewsI18nTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = NewsI18nTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var NewsI18n $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                NewsI18nTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(NewsI18nTableMap::COL_ID);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_LOCALE);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_TITLE);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_STRIP_TITLE);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_BRIEF);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_CONTENT);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_TAG);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_KEYWORD);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_POST_BY);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_EDIT_BY);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_SHORT_LINK);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_LINK);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_LOCKED);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_TRASH);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_STATUS);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_PRE_STATUS);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_STATUS_NOTE);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_DRAFT);
            $criteria->addSelectColumn(NewsI18nTableMap::COL_READ);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.locale');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.strip_title');
            $criteria->addSelectColumn($alias . '.brief');
            $criteria->addSelectColumn($alias . '.content');
            $criteria->addSelectColumn($alias . '.tag');
            $criteria->addSelectColumn($alias . '.keyword');
            $criteria->addSelectColumn($alias . '.post_by');
            $criteria->addSelectColumn($alias . '.edit_by');
            $criteria->addSelectColumn($alias . '.short_link');
            $criteria->addSelectColumn($alias . '.link');
            $criteria->addSelectColumn($alias . '.locked');
            $criteria->addSelectColumn($alias . '.trash');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.pre_status');
            $criteria->addSelectColumn($alias . '.status_note');
            $criteria->addSelectColumn($alias . '.draft');
            $criteria->addSelectColumn($alias . '.read');
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
        return Propel::getServiceContainer()->getDatabaseMap(NewsI18nTableMap::DATABASE_NAME)->getTable(NewsI18nTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(NewsI18nTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(NewsI18nTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new NewsI18nTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a NewsI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or NewsI18n object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(NewsI18nTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Common\DbBundle\Model\NewsI18n) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(NewsI18nTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(NewsI18nTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(NewsI18nTableMap::COL_LOCALE, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = NewsI18nQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            NewsI18nTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                NewsI18nTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the news_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return NewsI18nQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a NewsI18n or Criteria object.
     *
     * @param mixed               $criteria Criteria or NewsI18n object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NewsI18nTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from NewsI18n object
        }


        // Set the correct dbName
        $query = NewsI18nQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // NewsI18nTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
NewsI18nTableMap::buildTableMap();
