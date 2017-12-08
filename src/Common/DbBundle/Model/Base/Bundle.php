<?php

namespace Common\DbBundle\Model\Base;

use \Exception;
use \PDO;
use Common\DbBundle\Model\Advert as ChildAdvert;
use Common\DbBundle\Model\AdvertQuery as ChildAdvertQuery;
use Common\DbBundle\Model\Bundle as ChildBundle;
use Common\DbBundle\Model\BundleQuery as ChildBundleQuery;
use Common\DbBundle\Model\Menu as ChildMenu;
use Common\DbBundle\Model\MenuQuery as ChildMenuQuery;
use Common\DbBundle\Model\Section as ChildSection;
use Common\DbBundle\Model\SectionQuery as ChildSectionQuery;
use Common\DbBundle\Model\Map\AdvertTableMap;
use Common\DbBundle\Model\Map\BundleTableMap;
use Common\DbBundle\Model\Map\MenuTableMap;
use Common\DbBundle\Model\Map\SectionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'bundle' table.
 *
 *
 *
 * @package    propel.generator.src.Common.DbBundle.Model.Base
 */
abstract class Bundle implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Common\\DbBundle\\Model\\Map\\BundleTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the locked field.
     *
     * @var        boolean
     */
    protected $locked;

    /**
     * The value for the title field.
     *
     * @var        string
     */
    protected $title;

    /**
     * The value for the bundle field.
     *
     * @var        string
     */
    protected $bundle;

    /**
     * @var        ObjectCollection|ChildSection[] Collection to store aggregation of ChildSection objects.
     */
    protected $collSections;
    protected $collSectionsPartial;

    /**
     * @var        ObjectCollection|ChildMenu[] Collection to store aggregation of ChildMenu objects.
     */
    protected $collMenus;
    protected $collMenusPartial;

    /**
     * @var        ObjectCollection|ChildAdvert[] Collection to store aggregation of ChildAdvert objects.
     */
    protected $collAdverts;
    protected $collAdvertsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSection[]
     */
    protected $sectionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMenu[]
     */
    protected $menusScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAdvert[]
     */
    protected $advertsScheduledForDeletion = null;

    /**
     * Initializes internal state of Common\DbBundle\Model\Base\Bundle object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Bundle</code> instance.  If
     * <code>obj</code> is an instance of <code>Bundle</code>, delegates to
     * <code>equals(Bundle)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Bundle The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [locked] column value.
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Get the [locked] column value.
     *
     * @return boolean
     */
    public function isLocked()
    {
        return $this->getLocked();
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [bundle] column value.
     *
     * @return string
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Common\DbBundle\Model\Bundle The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[BundleTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Sets the value of the [locked] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Common\DbBundle\Model\Bundle The current object (for fluent API support)
     */
    public function setLocked($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->locked !== $v) {
            $this->locked = $v;
            $this->modifiedColumns[BundleTableMap::COL_LOCKED] = true;
        }

        return $this;
    } // setLocked()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Bundle The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[BundleTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [bundle] column.
     *
     * @param string $v new value
     * @return $this|\Common\DbBundle\Model\Bundle The current object (for fluent API support)
     */
    public function setBundle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->bundle !== $v) {
            $this->bundle = $v;
            $this->modifiedColumns[BundleTableMap::COL_BUNDLE] = true;
        }

        return $this;
    } // setBundle()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BundleTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BundleTableMap::translateFieldName('Locked', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locked = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BundleTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BundleTableMap::translateFieldName('Bundle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->bundle = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = BundleTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Common\\DbBundle\\Model\\Bundle'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BundleTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBundleQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collSections = null;

            $this->collMenus = null;

            $this->collAdverts = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Bundle::setDeleted()
     * @see Bundle::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BundleTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildBundleQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BundleTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                BundleTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->sectionsScheduledForDeletion !== null) {
                if (!$this->sectionsScheduledForDeletion->isEmpty()) {
                    foreach ($this->sectionsScheduledForDeletion as $section) {
                        // need to save related object because we set the relation to null
                        $section->save($con);
                    }
                    $this->sectionsScheduledForDeletion = null;
                }
            }

            if ($this->collSections !== null) {
                foreach ($this->collSections as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->menusScheduledForDeletion !== null) {
                if (!$this->menusScheduledForDeletion->isEmpty()) {
                    foreach ($this->menusScheduledForDeletion as $menu) {
                        // need to save related object because we set the relation to null
                        $menu->save($con);
                    }
                    $this->menusScheduledForDeletion = null;
                }
            }

            if ($this->collMenus !== null) {
                foreach ($this->collMenus as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->advertsScheduledForDeletion !== null) {
                if (!$this->advertsScheduledForDeletion->isEmpty()) {
                    foreach ($this->advertsScheduledForDeletion as $advert) {
                        // need to save related object because we set the relation to null
                        $advert->save($con);
                    }
                    $this->advertsScheduledForDeletion = null;
                }
            }

            if ($this->collAdverts !== null) {
                foreach ($this->collAdverts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[BundleTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BundleTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BundleTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(BundleTableMap::COL_LOCKED)) {
            $modifiedColumns[':p' . $index++]  = '`locked`';
        }
        if ($this->isColumnModified(BundleTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(BundleTableMap::COL_BUNDLE)) {
            $modifiedColumns[':p' . $index++]  = '`bundle`';
        }

        $sql = sprintf(
            'INSERT INTO `bundle` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`locked`':
                        $stmt->bindValue($identifier, (int) $this->locked, PDO::PARAM_INT);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`bundle`':
                        $stmt->bindValue($identifier, $this->bundle, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BundleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getLocked();
                break;
            case 2:
                return $this->getTitle();
                break;
            case 3:
                return $this->getBundle();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Bundle'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Bundle'][$this->hashCode()] = true;
        $keys = BundleTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getLocked(),
            $keys[2] => $this->getTitle(),
            $keys[3] => $this->getBundle(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collSections) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sections';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sections';
                        break;
                    default:
                        $key = 'Sections';
                }

                $result[$key] = $this->collSections->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMenus) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'menus';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'menus';
                        break;
                    default:
                        $key = 'Menus';
                }

                $result[$key] = $this->collMenus->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdverts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'adverts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'adverts';
                        break;
                    default:
                        $key = 'Adverts';
                }

                $result[$key] = $this->collAdverts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Common\DbBundle\Model\Bundle
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BundleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Common\DbBundle\Model\Bundle
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setLocked($value);
                break;
            case 2:
                $this->setTitle($value);
                break;
            case 3:
                $this->setBundle($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = BundleTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLocked($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTitle($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setBundle($arr[$keys[3]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Common\DbBundle\Model\Bundle The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(BundleTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BundleTableMap::COL_ID)) {
            $criteria->add(BundleTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(BundleTableMap::COL_LOCKED)) {
            $criteria->add(BundleTableMap::COL_LOCKED, $this->locked);
        }
        if ($this->isColumnModified(BundleTableMap::COL_TITLE)) {
            $criteria->add(BundleTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(BundleTableMap::COL_BUNDLE)) {
            $criteria->add(BundleTableMap::COL_BUNDLE, $this->bundle);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildBundleQuery::create();
        $criteria->add(BundleTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Common\DbBundle\Model\Bundle (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setLocked($this->getLocked());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setBundle($this->getBundle());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSections() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSection($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMenus() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMenu($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdverts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvert($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Common\DbBundle\Model\Bundle Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Section' == $relationName) {
            $this->initSections();
            return;
        }
        if ('Menu' == $relationName) {
            $this->initMenus();
            return;
        }
        if ('Advert' == $relationName) {
            $this->initAdverts();
            return;
        }
    }

    /**
     * Clears out the collSections collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSections()
     */
    public function clearSections()
    {
        $this->collSections = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSections collection loaded partially.
     */
    public function resetPartialSections($v = true)
    {
        $this->collSectionsPartial = $v;
    }

    /**
     * Initializes the collSections collection.
     *
     * By default this just sets the collSections collection to an empty array (like clearcollSections());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSections($overrideExisting = true)
    {
        if (null !== $this->collSections && !$overrideExisting) {
            return;
        }

        $collectionClassName = SectionTableMap::getTableMap()->getCollectionClassName();

        $this->collSections = new $collectionClassName;
        $this->collSections->setModel('\Common\DbBundle\Model\Section');
    }

    /**
     * Gets an array of ChildSection objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBundle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSection[] List of ChildSection objects
     * @throws PropelException
     */
    public function getSections(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionsPartial && !$this->isNew();
        if (null === $this->collSections || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSections) {
                // return empty collection
                $this->initSections();
            } else {
                $collSections = ChildSectionQuery::create(null, $criteria)
                    ->filterByBundle($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSectionsPartial && count($collSections)) {
                        $this->initSections(false);

                        foreach ($collSections as $obj) {
                            if (false == $this->collSections->contains($obj)) {
                                $this->collSections->append($obj);
                            }
                        }

                        $this->collSectionsPartial = true;
                    }

                    return $collSections;
                }

                if ($partial && $this->collSections) {
                    foreach ($this->collSections as $obj) {
                        if ($obj->isNew()) {
                            $collSections[] = $obj;
                        }
                    }
                }

                $this->collSections = $collSections;
                $this->collSectionsPartial = false;
            }
        }

        return $this->collSections;
    }

    /**
     * Sets a collection of ChildSection objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sections A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBundle The current object (for fluent API support)
     */
    public function setSections(Collection $sections, ConnectionInterface $con = null)
    {
        /** @var ChildSection[] $sectionsToDelete */
        $sectionsToDelete = $this->getSections(new Criteria(), $con)->diff($sections);


        $this->sectionsScheduledForDeletion = $sectionsToDelete;

        foreach ($sectionsToDelete as $sectionRemoved) {
            $sectionRemoved->setBundle(null);
        }

        $this->collSections = null;
        foreach ($sections as $section) {
            $this->addSection($section);
        }

        $this->collSections = $sections;
        $this->collSectionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Section objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Section objects.
     * @throws PropelException
     */
    public function countSections(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSectionsPartial && !$this->isNew();
        if (null === $this->collSections || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSections) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSections());
            }

            $query = ChildSectionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBundle($this)
                ->count($con);
        }

        return count($this->collSections);
    }

    /**
     * Method called to associate a ChildSection object to this object
     * through the ChildSection foreign key attribute.
     *
     * @param  ChildSection $l ChildSection
     * @return $this|\Common\DbBundle\Model\Bundle The current object (for fluent API support)
     */
    public function addSection(ChildSection $l)
    {
        if ($this->collSections === null) {
            $this->initSections();
            $this->collSectionsPartial = true;
        }

        if (!$this->collSections->contains($l)) {
            $this->doAddSection($l);

            if ($this->sectionsScheduledForDeletion and $this->sectionsScheduledForDeletion->contains($l)) {
                $this->sectionsScheduledForDeletion->remove($this->sectionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSection $section The ChildSection object to add.
     */
    protected function doAddSection(ChildSection $section)
    {
        $this->collSections[]= $section;
        $section->setBundle($this);
    }

    /**
     * @param  ChildSection $section The ChildSection object to remove.
     * @return $this|ChildBundle The current object (for fluent API support)
     */
    public function removeSection(ChildSection $section)
    {
        if ($this->getSections()->contains($section)) {
            $pos = $this->collSections->search($section);
            $this->collSections->remove($pos);
            if (null === $this->sectionsScheduledForDeletion) {
                $this->sectionsScheduledForDeletion = clone $this->collSections;
                $this->sectionsScheduledForDeletion->clear();
            }
            $this->sectionsScheduledForDeletion[]= $section;
            $section->setBundle(null);
        }

        return $this;
    }

    /**
     * Clears out the collMenus collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMenus()
     */
    public function clearMenus()
    {
        $this->collMenus = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMenus collection loaded partially.
     */
    public function resetPartialMenus($v = true)
    {
        $this->collMenusPartial = $v;
    }

    /**
     * Initializes the collMenus collection.
     *
     * By default this just sets the collMenus collection to an empty array (like clearcollMenus());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMenus($overrideExisting = true)
    {
        if (null !== $this->collMenus && !$overrideExisting) {
            return;
        }

        $collectionClassName = MenuTableMap::getTableMap()->getCollectionClassName();

        $this->collMenus = new $collectionClassName;
        $this->collMenus->setModel('\Common\DbBundle\Model\Menu');
    }

    /**
     * Gets an array of ChildMenu objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBundle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMenu[] List of ChildMenu objects
     * @throws PropelException
     */
    public function getMenus(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMenusPartial && !$this->isNew();
        if (null === $this->collMenus || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMenus) {
                // return empty collection
                $this->initMenus();
            } else {
                $collMenus = ChildMenuQuery::create(null, $criteria)
                    ->filterByBundle($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMenusPartial && count($collMenus)) {
                        $this->initMenus(false);

                        foreach ($collMenus as $obj) {
                            if (false == $this->collMenus->contains($obj)) {
                                $this->collMenus->append($obj);
                            }
                        }

                        $this->collMenusPartial = true;
                    }

                    return $collMenus;
                }

                if ($partial && $this->collMenus) {
                    foreach ($this->collMenus as $obj) {
                        if ($obj->isNew()) {
                            $collMenus[] = $obj;
                        }
                    }
                }

                $this->collMenus = $collMenus;
                $this->collMenusPartial = false;
            }
        }

        return $this->collMenus;
    }

    /**
     * Sets a collection of ChildMenu objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $menus A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBundle The current object (for fluent API support)
     */
    public function setMenus(Collection $menus, ConnectionInterface $con = null)
    {
        /** @var ChildMenu[] $menusToDelete */
        $menusToDelete = $this->getMenus(new Criteria(), $con)->diff($menus);


        $this->menusScheduledForDeletion = $menusToDelete;

        foreach ($menusToDelete as $menuRemoved) {
            $menuRemoved->setBundle(null);
        }

        $this->collMenus = null;
        foreach ($menus as $menu) {
            $this->addMenu($menu);
        }

        $this->collMenus = $menus;
        $this->collMenusPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Menu objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Menu objects.
     * @throws PropelException
     */
    public function countMenus(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMenusPartial && !$this->isNew();
        if (null === $this->collMenus || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMenus) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMenus());
            }

            $query = ChildMenuQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBundle($this)
                ->count($con);
        }

        return count($this->collMenus);
    }

    /**
     * Method called to associate a ChildMenu object to this object
     * through the ChildMenu foreign key attribute.
     *
     * @param  ChildMenu $l ChildMenu
     * @return $this|\Common\DbBundle\Model\Bundle The current object (for fluent API support)
     */
    public function addMenu(ChildMenu $l)
    {
        if ($this->collMenus === null) {
            $this->initMenus();
            $this->collMenusPartial = true;
        }

        if (!$this->collMenus->contains($l)) {
            $this->doAddMenu($l);

            if ($this->menusScheduledForDeletion and $this->menusScheduledForDeletion->contains($l)) {
                $this->menusScheduledForDeletion->remove($this->menusScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMenu $menu The ChildMenu object to add.
     */
    protected function doAddMenu(ChildMenu $menu)
    {
        $this->collMenus[]= $menu;
        $menu->setBundle($this);
    }

    /**
     * @param  ChildMenu $menu The ChildMenu object to remove.
     * @return $this|ChildBundle The current object (for fluent API support)
     */
    public function removeMenu(ChildMenu $menu)
    {
        if ($this->getMenus()->contains($menu)) {
            $pos = $this->collMenus->search($menu);
            $this->collMenus->remove($pos);
            if (null === $this->menusScheduledForDeletion) {
                $this->menusScheduledForDeletion = clone $this->collMenus;
                $this->menusScheduledForDeletion->clear();
            }
            $this->menusScheduledForDeletion[]= $menu;
            $menu->setBundle(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Bundle is new, it will return
     * an empty collection; or if this Bundle has previously
     * been saved, it will retrieve related Menus from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Bundle.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMenu[] List of ChildMenu objects
     */
    public function getMenusJoinSection(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMenuQuery::create(null, $criteria);
        $query->joinWith('Section', $joinBehavior);

        return $this->getMenus($query, $con);
    }

    /**
     * Clears out the collAdverts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAdverts()
     */
    public function clearAdverts()
    {
        $this->collAdverts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAdverts collection loaded partially.
     */
    public function resetPartialAdverts($v = true)
    {
        $this->collAdvertsPartial = $v;
    }

    /**
     * Initializes the collAdverts collection.
     *
     * By default this just sets the collAdverts collection to an empty array (like clearcollAdverts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdverts($overrideExisting = true)
    {
        if (null !== $this->collAdverts && !$overrideExisting) {
            return;
        }

        $collectionClassName = AdvertTableMap::getTableMap()->getCollectionClassName();

        $this->collAdverts = new $collectionClassName;
        $this->collAdverts->setModel('\Common\DbBundle\Model\Advert');
    }

    /**
     * Gets an array of ChildAdvert objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBundle is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAdvert[] List of ChildAdvert objects
     * @throws PropelException
     */
    public function getAdverts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAdvertsPartial && !$this->isNew();
        if (null === $this->collAdverts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdverts) {
                // return empty collection
                $this->initAdverts();
            } else {
                $collAdverts = ChildAdvertQuery::create(null, $criteria)
                    ->filterByBundle($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAdvertsPartial && count($collAdverts)) {
                        $this->initAdverts(false);

                        foreach ($collAdverts as $obj) {
                            if (false == $this->collAdverts->contains($obj)) {
                                $this->collAdverts->append($obj);
                            }
                        }

                        $this->collAdvertsPartial = true;
                    }

                    return $collAdverts;
                }

                if ($partial && $this->collAdverts) {
                    foreach ($this->collAdverts as $obj) {
                        if ($obj->isNew()) {
                            $collAdverts[] = $obj;
                        }
                    }
                }

                $this->collAdverts = $collAdverts;
                $this->collAdvertsPartial = false;
            }
        }

        return $this->collAdverts;
    }

    /**
     * Sets a collection of ChildAdvert objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $adverts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBundle The current object (for fluent API support)
     */
    public function setAdverts(Collection $adverts, ConnectionInterface $con = null)
    {
        /** @var ChildAdvert[] $advertsToDelete */
        $advertsToDelete = $this->getAdverts(new Criteria(), $con)->diff($adverts);


        $this->advertsScheduledForDeletion = $advertsToDelete;

        foreach ($advertsToDelete as $advertRemoved) {
            $advertRemoved->setBundle(null);
        }

        $this->collAdverts = null;
        foreach ($adverts as $advert) {
            $this->addAdvert($advert);
        }

        $this->collAdverts = $adverts;
        $this->collAdvertsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Advert objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Advert objects.
     * @throws PropelException
     */
    public function countAdverts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAdvertsPartial && !$this->isNew();
        if (null === $this->collAdverts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdverts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdverts());
            }

            $query = ChildAdvertQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBundle($this)
                ->count($con);
        }

        return count($this->collAdverts);
    }

    /**
     * Method called to associate a ChildAdvert object to this object
     * through the ChildAdvert foreign key attribute.
     *
     * @param  ChildAdvert $l ChildAdvert
     * @return $this|\Common\DbBundle\Model\Bundle The current object (for fluent API support)
     */
    public function addAdvert(ChildAdvert $l)
    {
        if ($this->collAdverts === null) {
            $this->initAdverts();
            $this->collAdvertsPartial = true;
        }

        if (!$this->collAdverts->contains($l)) {
            $this->doAddAdvert($l);

            if ($this->advertsScheduledForDeletion and $this->advertsScheduledForDeletion->contains($l)) {
                $this->advertsScheduledForDeletion->remove($this->advertsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAdvert $advert The ChildAdvert object to add.
     */
    protected function doAddAdvert(ChildAdvert $advert)
    {
        $this->collAdverts[]= $advert;
        $advert->setBundle($this);
    }

    /**
     * @param  ChildAdvert $advert The ChildAdvert object to remove.
     * @return $this|ChildBundle The current object (for fluent API support)
     */
    public function removeAdvert(ChildAdvert $advert)
    {
        if ($this->getAdverts()->contains($advert)) {
            $pos = $this->collAdverts->search($advert);
            $this->collAdverts->remove($pos);
            if (null === $this->advertsScheduledForDeletion) {
                $this->advertsScheduledForDeletion = clone $this->collAdverts;
                $this->advertsScheduledForDeletion->clear();
            }
            $this->advertsScheduledForDeletion[]= $advert;
            $advert->setBundle(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Bundle is new, it will return
     * an empty collection; or if this Bundle has previously
     * been saved, it will retrieve related Adverts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Bundle.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAdvert[] List of ChildAdvert objects
     */
    public function getAdvertsJoinSection(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAdvertQuery::create(null, $criteria);
        $query->joinWith('Section', $joinBehavior);

        return $this->getAdverts($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Bundle is new, it will return
     * an empty collection; or if this Bundle has previously
     * been saved, it will retrieve related Adverts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Bundle.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAdvert[] List of ChildAdvert objects
     */
    public function getAdvertsJoinCustomer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAdvertQuery::create(null, $criteria);
        $query->joinWith('Customer', $joinBehavior);

        return $this->getAdverts($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->locked = null;
        $this->title = null;
        $this->bundle = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collSections) {
                foreach ($this->collSections as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMenus) {
                foreach ($this->collMenus as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdverts) {
                foreach ($this->collAdverts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSections = null;
        $this->collMenus = null;
        $this->collAdverts = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string The value of the 'title' column
     */
    public function __toString()
    {
        return (string) $this->getTitle();
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
