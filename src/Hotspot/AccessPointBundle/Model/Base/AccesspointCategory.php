<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\Accesspoint as ChildAccesspoint;
use Hotspot\AccessPointBundle\Model\AccesspointCategory as ChildAccesspointCategory;
use Hotspot\AccessPointBundle\Model\AccesspointCategoryI18n as ChildAccesspointCategoryI18n;
use Hotspot\AccessPointBundle\Model\AccesspointCategoryI18nQuery as ChildAccesspointCategoryI18nQuery;
use Hotspot\AccessPointBundle\Model\AccesspointCategoryQuery as ChildAccesspointCategoryQuery;
use Hotspot\AccessPointBundle\Model\AccesspointQuery as ChildAccesspointQuery;
use Hotspot\AccessPointBundle\Model\Map\AccesspointCategoryI18nTableMap;
use Hotspot\AccessPointBundle\Model\Map\AccesspointCategoryTableMap;
use Hotspot\AccessPointBundle\Model\Map\AccesspointTableMap;
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
 * Base class that represents a row from the 'accesspoint_category' table.
 *
 *
 *
 * @package    propel.generator.src.Hotspot.AccessPointBundle.Model.Base
 */
abstract class AccesspointCategory implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Hotspot\\AccessPointBundle\\Model\\Map\\AccesspointCategoryTableMap';


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
     * The value for the icon field.
     *
     * @var        string
     */
    protected $icon;

    /**
     * @var        ObjectCollection|ChildAccesspoint[] Collection to store aggregation of ChildAccesspoint objects.
     */
    protected $collAccesspoints;
    protected $collAccesspointsPartial;

    /**
     * @var        ObjectCollection|ChildAccesspointCategoryI18n[] Collection to store aggregation of ChildAccesspointCategoryI18n objects.
     */
    protected $collAccesspointCategoryI18ns;
    protected $collAccesspointCategoryI18nsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // i18n behavior

    /**
     * Current locale
     * @var        string
     */
    protected $currentLocale = 'vi';

    /**
     * Current translation objects
     * @var        array[ChildAccesspointCategoryI18n]
     */
    protected $currentTranslations;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAccesspoint[]
     */
    protected $accesspointsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAccesspointCategoryI18n[]
     */
    protected $accesspointCategoryI18nsScheduledForDeletion = null;

    /**
     * Initializes internal state of Hotspot\AccessPointBundle\Model\Base\AccesspointCategory object.
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
     * Compares this with another <code>AccesspointCategory</code> instance.  If
     * <code>obj</code> is an instance of <code>AccesspointCategory</code>, delegates to
     * <code>equals(AccesspointCategory)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|AccesspointCategory The current object, for fluid interface
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
     * Get the [icon] column value.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointCategory The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[AccesspointCategoryTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [icon] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointCategory The current object (for fluent API support)
     */
    public function setIcon($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->icon !== $v) {
            $this->icon = $v;
            $this->modifiedColumns[AccesspointCategoryTableMap::COL_ICON] = true;
        }

        return $this;
    } // setIcon()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AccesspointCategoryTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AccesspointCategoryTableMap::translateFieldName('Icon', TableMap::TYPE_PHPNAME, $indexType)];
            $this->icon = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = AccesspointCategoryTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Hotspot\\AccessPointBundle\\Model\\AccesspointCategory'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(AccesspointCategoryTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAccesspointCategoryQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAccesspoints = null;

            $this->collAccesspointCategoryI18ns = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see AccesspointCategory::setDeleted()
     * @see AccesspointCategory::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointCategoryTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAccesspointCategoryQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AccesspointCategoryTableMap::DATABASE_NAME);
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
                AccesspointCategoryTableMap::addInstanceToPool($this);
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

            if ($this->accesspointsScheduledForDeletion !== null) {
                if (!$this->accesspointsScheduledForDeletion->isEmpty()) {
                    \Hotspot\AccessPointBundle\Model\AccesspointQuery::create()
                        ->filterByPrimaryKeys($this->accesspointsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->accesspointsScheduledForDeletion = null;
                }
            }

            if ($this->collAccesspoints !== null) {
                foreach ($this->collAccesspoints as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->accesspointCategoryI18nsScheduledForDeletion !== null) {
                if (!$this->accesspointCategoryI18nsScheduledForDeletion->isEmpty()) {
                    \Hotspot\AccessPointBundle\Model\AccesspointCategoryI18nQuery::create()
                        ->filterByPrimaryKeys($this->accesspointCategoryI18nsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->accesspointCategoryI18nsScheduledForDeletion = null;
                }
            }

            if ($this->collAccesspointCategoryI18ns !== null) {
                foreach ($this->collAccesspointCategoryI18ns as $referrerFK) {
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

        $this->modifiedColumns[AccesspointCategoryTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AccesspointCategoryTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AccesspointCategoryTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(AccesspointCategoryTableMap::COL_ICON)) {
            $modifiedColumns[':p' . $index++]  = '`icon`';
        }

        $sql = sprintf(
            'INSERT INTO `accesspoint_category` (%s) VALUES (%s)',
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
                    case '`icon`':
                        $stmt->bindValue($identifier, $this->icon, PDO::PARAM_STR);
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
        $pos = AccesspointCategoryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIcon();
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

        if (isset($alreadyDumpedObjects['AccesspointCategory'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AccesspointCategory'][$this->hashCode()] = true;
        $keys = AccesspointCategoryTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getIcon(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAccesspoints) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'accesspoints';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'accesspoints';
                        break;
                    default:
                        $key = 'Accesspoints';
                }

                $result[$key] = $this->collAccesspoints->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAccesspointCategoryI18ns) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'accesspointCategoryI18ns';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'accesspoint_category_i18ns';
                        break;
                    default:
                        $key = 'AccesspointCategoryI18ns';
                }

                $result[$key] = $this->collAccesspointCategoryI18ns->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointCategory
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AccesspointCategoryTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointCategory
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setIcon($value);
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
        $keys = AccesspointCategoryTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setIcon($arr[$keys[1]]);
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
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointCategory The current object, for fluid interface
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
        $criteria = new Criteria(AccesspointCategoryTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AccesspointCategoryTableMap::COL_ID)) {
            $criteria->add(AccesspointCategoryTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(AccesspointCategoryTableMap::COL_ICON)) {
            $criteria->add(AccesspointCategoryTableMap::COL_ICON, $this->icon);
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
        $criteria = ChildAccesspointCategoryQuery::create();
        $criteria->add(AccesspointCategoryTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Hotspot\AccessPointBundle\Model\AccesspointCategory (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIcon($this->getIcon());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAccesspoints() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccesspoint($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAccesspointCategoryI18ns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAccesspointCategoryI18n($relObj->copy($deepCopy));
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
     * @return \Hotspot\AccessPointBundle\Model\AccesspointCategory Clone of current object.
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
        if ('Accesspoint' == $relationName) {
            $this->initAccesspoints();
            return;
        }
        if ('AccesspointCategoryI18n' == $relationName) {
            $this->initAccesspointCategoryI18ns();
            return;
        }
    }

    /**
     * Clears out the collAccesspoints collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAccesspoints()
     */
    public function clearAccesspoints()
    {
        $this->collAccesspoints = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAccesspoints collection loaded partially.
     */
    public function resetPartialAccesspoints($v = true)
    {
        $this->collAccesspointsPartial = $v;
    }

    /**
     * Initializes the collAccesspoints collection.
     *
     * By default this just sets the collAccesspoints collection to an empty array (like clearcollAccesspoints());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAccesspoints($overrideExisting = true)
    {
        if (null !== $this->collAccesspoints && !$overrideExisting) {
            return;
        }

        $collectionClassName = AccesspointTableMap::getTableMap()->getCollectionClassName();

        $this->collAccesspoints = new $collectionClassName;
        $this->collAccesspoints->setModel('\Hotspot\AccessPointBundle\Model\Accesspoint');
    }

    /**
     * Gets an array of ChildAccesspoint objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAccesspointCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAccesspoint[] List of ChildAccesspoint objects
     * @throws PropelException
     */
    public function getAccesspoints(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAccesspointsPartial && !$this->isNew();
        if (null === $this->collAccesspoints || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAccesspoints) {
                // return empty collection
                $this->initAccesspoints();
            } else {
                $collAccesspoints = ChildAccesspointQuery::create(null, $criteria)
                    ->filterByAccesspointCategory($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAccesspointsPartial && count($collAccesspoints)) {
                        $this->initAccesspoints(false);

                        foreach ($collAccesspoints as $obj) {
                            if (false == $this->collAccesspoints->contains($obj)) {
                                $this->collAccesspoints->append($obj);
                            }
                        }

                        $this->collAccesspointsPartial = true;
                    }

                    return $collAccesspoints;
                }

                if ($partial && $this->collAccesspoints) {
                    foreach ($this->collAccesspoints as $obj) {
                        if ($obj->isNew()) {
                            $collAccesspoints[] = $obj;
                        }
                    }
                }

                $this->collAccesspoints = $collAccesspoints;
                $this->collAccesspointsPartial = false;
            }
        }

        return $this->collAccesspoints;
    }

    /**
     * Sets a collection of ChildAccesspoint objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $accesspoints A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAccesspointCategory The current object (for fluent API support)
     */
    public function setAccesspoints(Collection $accesspoints, ConnectionInterface $con = null)
    {
        /** @var ChildAccesspoint[] $accesspointsToDelete */
        $accesspointsToDelete = $this->getAccesspoints(new Criteria(), $con)->diff($accesspoints);


        $this->accesspointsScheduledForDeletion = $accesspointsToDelete;

        foreach ($accesspointsToDelete as $accesspointRemoved) {
            $accesspointRemoved->setAccesspointCategory(null);
        }

        $this->collAccesspoints = null;
        foreach ($accesspoints as $accesspoint) {
            $this->addAccesspoint($accesspoint);
        }

        $this->collAccesspoints = $accesspoints;
        $this->collAccesspointsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Accesspoint objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Accesspoint objects.
     * @throws PropelException
     */
    public function countAccesspoints(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAccesspointsPartial && !$this->isNew();
        if (null === $this->collAccesspoints || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAccesspoints) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAccesspoints());
            }

            $query = ChildAccesspointQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAccesspointCategory($this)
                ->count($con);
        }

        return count($this->collAccesspoints);
    }

    /**
     * Method called to associate a ChildAccesspoint object to this object
     * through the ChildAccesspoint foreign key attribute.
     *
     * @param  ChildAccesspoint $l ChildAccesspoint
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointCategory The current object (for fluent API support)
     */
    public function addAccesspoint(ChildAccesspoint $l)
    {
        if ($this->collAccesspoints === null) {
            $this->initAccesspoints();
            $this->collAccesspointsPartial = true;
        }

        if (!$this->collAccesspoints->contains($l)) {
            $this->doAddAccesspoint($l);

            if ($this->accesspointsScheduledForDeletion and $this->accesspointsScheduledForDeletion->contains($l)) {
                $this->accesspointsScheduledForDeletion->remove($this->accesspointsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAccesspoint $accesspoint The ChildAccesspoint object to add.
     */
    protected function doAddAccesspoint(ChildAccesspoint $accesspoint)
    {
        $this->collAccesspoints[]= $accesspoint;
        $accesspoint->setAccesspointCategory($this);
    }

    /**
     * @param  ChildAccesspoint $accesspoint The ChildAccesspoint object to remove.
     * @return $this|ChildAccesspointCategory The current object (for fluent API support)
     */
    public function removeAccesspoint(ChildAccesspoint $accesspoint)
    {
        if ($this->getAccesspoints()->contains($accesspoint)) {
            $pos = $this->collAccesspoints->search($accesspoint);
            $this->collAccesspoints->remove($pos);
            if (null === $this->accesspointsScheduledForDeletion) {
                $this->accesspointsScheduledForDeletion = clone $this->collAccesspoints;
                $this->accesspointsScheduledForDeletion->clear();
            }
            $this->accesspointsScheduledForDeletion[]= $accesspoint;
            $accesspoint->setAccesspointCategory(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AccesspointCategory is new, it will return
     * an empty collection; or if this AccesspointCategory has previously
     * been saved, it will retrieve related Accesspoints from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AccesspointCategory.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAccesspoint[] List of ChildAccesspoint objects
     */
    public function getAccesspointsJoinCustomer(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAccesspointQuery::create(null, $criteria);
        $query->joinWith('Customer', $joinBehavior);

        return $this->getAccesspoints($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AccesspointCategory is new, it will return
     * an empty collection; or if this AccesspointCategory has previously
     * been saved, it will retrieve related Accesspoints from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AccesspointCategory.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAccesspoint[] List of ChildAccesspoint objects
     */
    public function getAccesspointsJoinSection(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAccesspointQuery::create(null, $criteria);
        $query->joinWith('Section', $joinBehavior);

        return $this->getAccesspoints($query, $con);
    }

    /**
     * Clears out the collAccesspointCategoryI18ns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAccesspointCategoryI18ns()
     */
    public function clearAccesspointCategoryI18ns()
    {
        $this->collAccesspointCategoryI18ns = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAccesspointCategoryI18ns collection loaded partially.
     */
    public function resetPartialAccesspointCategoryI18ns($v = true)
    {
        $this->collAccesspointCategoryI18nsPartial = $v;
    }

    /**
     * Initializes the collAccesspointCategoryI18ns collection.
     *
     * By default this just sets the collAccesspointCategoryI18ns collection to an empty array (like clearcollAccesspointCategoryI18ns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAccesspointCategoryI18ns($overrideExisting = true)
    {
        if (null !== $this->collAccesspointCategoryI18ns && !$overrideExisting) {
            return;
        }

        $collectionClassName = AccesspointCategoryI18nTableMap::getTableMap()->getCollectionClassName();

        $this->collAccesspointCategoryI18ns = new $collectionClassName;
        $this->collAccesspointCategoryI18ns->setModel('\Hotspot\AccessPointBundle\Model\AccesspointCategoryI18n');
    }

    /**
     * Gets an array of ChildAccesspointCategoryI18n objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAccesspointCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAccesspointCategoryI18n[] List of ChildAccesspointCategoryI18n objects
     * @throws PropelException
     */
    public function getAccesspointCategoryI18ns(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAccesspointCategoryI18nsPartial && !$this->isNew();
        if (null === $this->collAccesspointCategoryI18ns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAccesspointCategoryI18ns) {
                // return empty collection
                $this->initAccesspointCategoryI18ns();
            } else {
                $collAccesspointCategoryI18ns = ChildAccesspointCategoryI18nQuery::create(null, $criteria)
                    ->filterByAccesspointCategory($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAccesspointCategoryI18nsPartial && count($collAccesspointCategoryI18ns)) {
                        $this->initAccesspointCategoryI18ns(false);

                        foreach ($collAccesspointCategoryI18ns as $obj) {
                            if (false == $this->collAccesspointCategoryI18ns->contains($obj)) {
                                $this->collAccesspointCategoryI18ns->append($obj);
                            }
                        }

                        $this->collAccesspointCategoryI18nsPartial = true;
                    }

                    return $collAccesspointCategoryI18ns;
                }

                if ($partial && $this->collAccesspointCategoryI18ns) {
                    foreach ($this->collAccesspointCategoryI18ns as $obj) {
                        if ($obj->isNew()) {
                            $collAccesspointCategoryI18ns[] = $obj;
                        }
                    }
                }

                $this->collAccesspointCategoryI18ns = $collAccesspointCategoryI18ns;
                $this->collAccesspointCategoryI18nsPartial = false;
            }
        }

        return $this->collAccesspointCategoryI18ns;
    }

    /**
     * Sets a collection of ChildAccesspointCategoryI18n objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $accesspointCategoryI18ns A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAccesspointCategory The current object (for fluent API support)
     */
    public function setAccesspointCategoryI18ns(Collection $accesspointCategoryI18ns, ConnectionInterface $con = null)
    {
        /** @var ChildAccesspointCategoryI18n[] $accesspointCategoryI18nsToDelete */
        $accesspointCategoryI18nsToDelete = $this->getAccesspointCategoryI18ns(new Criteria(), $con)->diff($accesspointCategoryI18ns);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->accesspointCategoryI18nsScheduledForDeletion = clone $accesspointCategoryI18nsToDelete;

        foreach ($accesspointCategoryI18nsToDelete as $accesspointCategoryI18nRemoved) {
            $accesspointCategoryI18nRemoved->setAccesspointCategory(null);
        }

        $this->collAccesspointCategoryI18ns = null;
        foreach ($accesspointCategoryI18ns as $accesspointCategoryI18n) {
            $this->addAccesspointCategoryI18n($accesspointCategoryI18n);
        }

        $this->collAccesspointCategoryI18ns = $accesspointCategoryI18ns;
        $this->collAccesspointCategoryI18nsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AccesspointCategoryI18n objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AccesspointCategoryI18n objects.
     * @throws PropelException
     */
    public function countAccesspointCategoryI18ns(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAccesspointCategoryI18nsPartial && !$this->isNew();
        if (null === $this->collAccesspointCategoryI18ns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAccesspointCategoryI18ns) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAccesspointCategoryI18ns());
            }

            $query = ChildAccesspointCategoryI18nQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAccesspointCategory($this)
                ->count($con);
        }

        return count($this->collAccesspointCategoryI18ns);
    }

    /**
     * Method called to associate a ChildAccesspointCategoryI18n object to this object
     * through the ChildAccesspointCategoryI18n foreign key attribute.
     *
     * @param  ChildAccesspointCategoryI18n $l ChildAccesspointCategoryI18n
     * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointCategory The current object (for fluent API support)
     */
    public function addAccesspointCategoryI18n(ChildAccesspointCategoryI18n $l)
    {
        if ($l && $locale = $l->getLocale()) {
            $this->setLocale($locale);
            $this->currentTranslations[$locale] = $l;
        }
        if ($this->collAccesspointCategoryI18ns === null) {
            $this->initAccesspointCategoryI18ns();
            $this->collAccesspointCategoryI18nsPartial = true;
        }

        if (!$this->collAccesspointCategoryI18ns->contains($l)) {
            $this->doAddAccesspointCategoryI18n($l);

            if ($this->accesspointCategoryI18nsScheduledForDeletion and $this->accesspointCategoryI18nsScheduledForDeletion->contains($l)) {
                $this->accesspointCategoryI18nsScheduledForDeletion->remove($this->accesspointCategoryI18nsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAccesspointCategoryI18n $accesspointCategoryI18n The ChildAccesspointCategoryI18n object to add.
     */
    protected function doAddAccesspointCategoryI18n(ChildAccesspointCategoryI18n $accesspointCategoryI18n)
    {
        $this->collAccesspointCategoryI18ns[]= $accesspointCategoryI18n;
        $accesspointCategoryI18n->setAccesspointCategory($this);
    }

    /**
     * @param  ChildAccesspointCategoryI18n $accesspointCategoryI18n The ChildAccesspointCategoryI18n object to remove.
     * @return $this|ChildAccesspointCategory The current object (for fluent API support)
     */
    public function removeAccesspointCategoryI18n(ChildAccesspointCategoryI18n $accesspointCategoryI18n)
    {
        if ($this->getAccesspointCategoryI18ns()->contains($accesspointCategoryI18n)) {
            $pos = $this->collAccesspointCategoryI18ns->search($accesspointCategoryI18n);
            $this->collAccesspointCategoryI18ns->remove($pos);
            if (null === $this->accesspointCategoryI18nsScheduledForDeletion) {
                $this->accesspointCategoryI18nsScheduledForDeletion = clone $this->collAccesspointCategoryI18ns;
                $this->accesspointCategoryI18nsScheduledForDeletion->clear();
            }
            $this->accesspointCategoryI18nsScheduledForDeletion[]= clone $accesspointCategoryI18n;
            $accesspointCategoryI18n->setAccesspointCategory(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->icon = null;
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
            if ($this->collAccesspoints) {
                foreach ($this->collAccesspoints as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAccesspointCategoryI18ns) {
                foreach ($this->collAccesspointCategoryI18ns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        // i18n behavior
        $this->currentLocale = 'vi';
        $this->currentTranslations = null;

        $this->collAccesspoints = null;
        $this->collAccesspointCategoryI18ns = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AccesspointCategoryTableMap::DEFAULT_STRING_FORMAT);
    }

    // i18n behavior

    /**
     * Sets the locale for translations
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     *
     * @return    $this|ChildAccesspointCategory The current object (for fluent API support)
     */
    public function setLocale($locale = 'vi')
    {
        $this->currentLocale = $locale;

        return $this;
    }

    /**
     * Gets the locale for translations
     *
     * @return    string $locale Locale to use for the translation, e.g. 'fr_FR'
     */
    public function getLocale()
    {
        return $this->currentLocale;
    }

    /**
     * Returns the current translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildAccesspointCategoryI18n */
    public function getTranslation($locale = 'vi', ConnectionInterface $con = null)
    {
        if (!isset($this->currentTranslations[$locale])) {
            if (null !== $this->collAccesspointCategoryI18ns) {
                foreach ($this->collAccesspointCategoryI18ns as $translation) {
                    if ($translation->getLocale() == $locale) {
                        $this->currentTranslations[$locale] = $translation;

                        return $translation;
                    }
                }
            }
            if ($this->isNew()) {
                $translation = new ChildAccesspointCategoryI18n();
                $translation->setLocale($locale);
            } else {
                $translation = ChildAccesspointCategoryI18nQuery::create()
                    ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                    ->findOneOrCreate($con);
                $this->currentTranslations[$locale] = $translation;
            }
            $this->addAccesspointCategoryI18n($translation);
        }

        return $this->currentTranslations[$locale];
    }

    /**
     * Remove the translation for a given locale
     *
     * @param     string $locale Locale to use for the translation, e.g. 'fr_FR'
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return    $this|ChildAccesspointCategory The current object (for fluent API support)
     */
    public function removeTranslation($locale = 'vi', ConnectionInterface $con = null)
    {
        if (!$this->isNew()) {
            ChildAccesspointCategoryI18nQuery::create()
                ->filterByPrimaryKey(array($this->getPrimaryKey(), $locale))
                ->delete($con);
        }
        if (isset($this->currentTranslations[$locale])) {
            unset($this->currentTranslations[$locale]);
        }
        foreach ($this->collAccesspointCategoryI18ns as $key => $translation) {
            if ($translation->getLocale() == $locale) {
                unset($this->collAccesspointCategoryI18ns[$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * Returns the current translation
     *
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ChildAccesspointCategoryI18n */
    public function getCurrentTranslation(ConnectionInterface $con = null)
    {
        return $this->getTranslation($this->getLocale(), $con);
    }


        /**
         * Get the [name] column value.
         *
         * @return string
         */
        public function getName()
        {
        return $this->getCurrentTranslation()->getName();
    }


        /**
         * Set the value of [name] column.
         *
         * @param string $v new value
         * @return $this|\Hotspot\AccessPointBundle\Model\AccesspointCategoryI18n The current object (for fluent API support)
         */
        public function setName($v)
        {    $this->getCurrentTranslation()->setName($v);

        return $this;
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
