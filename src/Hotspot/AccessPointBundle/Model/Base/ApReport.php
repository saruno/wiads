<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\ApReportQuery as ChildApReportQuery;
use Hotspot\AccessPointBundle\Model\Map\ApReportTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'ap_report' table.
 *
 *
 *
 * @package    propel.generator.src.Hotspot.AccessPointBundle.Model.Base
 */
abstract class ApReport implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Hotspot\\AccessPointBundle\\Model\\Map\\ApReportTableMap';


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
     * The value for the ap_macaddr field.
     *
     * @var        string
     */
    protected $ap_macaddr;

    /**
     * The value for the year field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $year;

    /**
     * The value for the month field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $month;

    /**
     * The value for the 01 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $01;

    /**
     * The value for the 02 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $02;

    /**
     * The value for the 03 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $03;

    /**
     * The value for the 04 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $04;

    /**
     * The value for the 05 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $05;

    /**
     * The value for the 06 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $06;

    /**
     * The value for the 07 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $07;

    /**
     * The value for the 08 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $08;

    /**
     * The value for the 09 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $09;

    /**
     * The value for the 10 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $10;

    /**
     * The value for the 11 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $11;

    /**
     * The value for the 12 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $12;

    /**
     * The value for the 13 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $13;

    /**
     * The value for the 14 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $14;

    /**
     * The value for the 15 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $15;

    /**
     * The value for the 16 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $16;

    /**
     * The value for the 17 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $17;

    /**
     * The value for the 18 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $18;

    /**
     * The value for the 19 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $19;

    /**
     * The value for the 20 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $20;

    /**
     * The value for the 21 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $21;

    /**
     * The value for the 22 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $22;

    /**
     * The value for the 23 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $23;

    /**
     * The value for the 24 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $24;

    /**
     * The value for the 25 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $25;

    /**
     * The value for the 26 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $26;

    /**
     * The value for the 27 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $27;

    /**
     * The value for the 28 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $28;

    /**
     * The value for the 29 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $29;

    /**
     * The value for the 30 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $30;

    /**
     * The value for the 31 field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $31;

    /**
     * The value for the 01_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $01_click;

    /**
     * The value for the 02_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $02_click;

    /**
     * The value for the 03_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $03_click;

    /**
     * The value for the 04_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $04_click;

    /**
     * The value for the 05_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $05_click;

    /**
     * The value for the 06_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $06_click;

    /**
     * The value for the 07_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $07_click;

    /**
     * The value for the 08_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $08_click;

    /**
     * The value for the 09_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $09_click;

    /**
     * The value for the 10_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $10_click;

    /**
     * The value for the 11_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $11_click;

    /**
     * The value for the 12_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $12_click;

    /**
     * The value for the 13_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $13_click;

    /**
     * The value for the 14_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $14_click;

    /**
     * The value for the 15_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $15_click;

    /**
     * The value for the 16_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $16_click;

    /**
     * The value for the 17_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $17_click;

    /**
     * The value for the 18_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $18_click;

    /**
     * The value for the 19_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $19_click;

    /**
     * The value for the 20_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $20_click;

    /**
     * The value for the 21_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $21_click;

    /**
     * The value for the 22_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $22_click;

    /**
     * The value for the 23_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $23_click;

    /**
     * The value for the 24_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $24_click;

    /**
     * The value for the 25_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $25_click;

    /**
     * The value for the 26_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $26_click;

    /**
     * The value for the 27_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $27_click;

    /**
     * The value for the 28_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $28_click;

    /**
     * The value for the 29_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $29_click;

    /**
     * The value for the 30_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $30_click;

    /**
     * The value for the 31_click field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $31_click;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->year = 0;
        $this->month = 0;
        $this->01 = '0';
        $this->02 = '0';
        $this->03 = '0';
        $this->04 = '0';
        $this->05 = '0';
        $this->06 = '0';
        $this->07 = '0';
        $this->08 = '0';
        $this->09 = '0';
        $this->10 = '0';
        $this->11 = '0';
        $this->12 = '0';
        $this->13 = '0';
        $this->14 = '0';
        $this->15 = '0';
        $this->16 = '0';
        $this->17 = '0';
        $this->18 = '0';
        $this->19 = '0';
        $this->20 = '0';
        $this->21 = '0';
        $this->22 = '0';
        $this->23 = '0';
        $this->24 = '0';
        $this->25 = '0';
        $this->26 = '0';
        $this->27 = '0';
        $this->28 = '0';
        $this->29 = '0';
        $this->30 = '0';
        $this->31 = '0';
        $this->01_click = '0';
        $this->02_click = '0';
        $this->03_click = '0';
        $this->04_click = '0';
        $this->05_click = '0';
        $this->06_click = '0';
        $this->07_click = '0';
        $this->08_click = '0';
        $this->09_click = '0';
        $this->10_click = '0';
        $this->11_click = '0';
        $this->12_click = '0';
        $this->13_click = '0';
        $this->14_click = '0';
        $this->15_click = '0';
        $this->16_click = '0';
        $this->17_click = '0';
        $this->18_click = '0';
        $this->19_click = '0';
        $this->20_click = '0';
        $this->21_click = '0';
        $this->22_click = '0';
        $this->23_click = '0';
        $this->24_click = '0';
        $this->25_click = '0';
        $this->26_click = '0';
        $this->27_click = '0';
        $this->28_click = '0';
        $this->29_click = '0';
        $this->30_click = '0';
        $this->31_click = '0';
    }

    /**
     * Initializes internal state of Hotspot\AccessPointBundle\Model\Base\ApReport object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>ApReport</code> instance.  If
     * <code>obj</code> is an instance of <code>ApReport</code>, delegates to
     * <code>equals(ApReport)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|ApReport The current object, for fluid interface
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
     * Get the [ap_macaddr] column value.
     *
     * @return string
     */
    public function getApMacaddr()
    {
        return $this->ap_macaddr;
    }

    /**
     * Get the [year] column value.
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Get the [month] column value.
     *
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Get the [01] column value.
     *
     * @return string
     */
    public function get01()
    {
        return $this->01;
    }

    /**
     * Get the [02] column value.
     *
     * @return string
     */
    public function get02()
    {
        return $this->02;
    }

    /**
     * Get the [03] column value.
     *
     * @return string
     */
    public function get03()
    {
        return $this->03;
    }

    /**
     * Get the [04] column value.
     *
     * @return string
     */
    public function get04()
    {
        return $this->04;
    }

    /**
     * Get the [05] column value.
     *
     * @return string
     */
    public function get05()
    {
        return $this->05;
    }

    /**
     * Get the [06] column value.
     *
     * @return string
     */
    public function get06()
    {
        return $this->06;
    }

    /**
     * Get the [07] column value.
     *
     * @return string
     */
    public function get07()
    {
        return $this->07;
    }

    /**
     * Get the [08] column value.
     *
     * @return string
     */
    public function get08()
    {
        return $this->08;
    }

    /**
     * Get the [09] column value.
     *
     * @return string
     */
    public function get09()
    {
        return $this->09;
    }

    /**
     * Get the [10] column value.
     *
     * @return string
     */
    public function get10()
    {
        return $this->10;
    }

    /**
     * Get the [11] column value.
     *
     * @return string
     */
    public function get11()
    {
        return $this->11;
    }

    /**
     * Get the [12] column value.
     *
     * @return string
     */
    public function get12()
    {
        return $this->12;
    }

    /**
     * Get the [13] column value.
     *
     * @return string
     */
    public function get13()
    {
        return $this->13;
    }

    /**
     * Get the [14] column value.
     *
     * @return string
     */
    public function get14()
    {
        return $this->14;
    }

    /**
     * Get the [15] column value.
     *
     * @return string
     */
    public function get15()
    {
        return $this->15;
    }

    /**
     * Get the [16] column value.
     *
     * @return string
     */
    public function get16()
    {
        return $this->16;
    }

    /**
     * Get the [17] column value.
     *
     * @return string
     */
    public function get17()
    {
        return $this->17;
    }

    /**
     * Get the [18] column value.
     *
     * @return string
     */
    public function get18()
    {
        return $this->18;
    }

    /**
     * Get the [19] column value.
     *
     * @return string
     */
    public function get19()
    {
        return $this->19;
    }

    /**
     * Get the [20] column value.
     *
     * @return string
     */
    public function get20()
    {
        return $this->20;
    }

    /**
     * Get the [21] column value.
     *
     * @return string
     */
    public function get21()
    {
        return $this->21;
    }

    /**
     * Get the [22] column value.
     *
     * @return string
     */
    public function get22()
    {
        return $this->22;
    }

    /**
     * Get the [23] column value.
     *
     * @return string
     */
    public function get23()
    {
        return $this->23;
    }

    /**
     * Get the [24] column value.
     *
     * @return string
     */
    public function get24()
    {
        return $this->24;
    }

    /**
     * Get the [25] column value.
     *
     * @return string
     */
    public function get25()
    {
        return $this->25;
    }

    /**
     * Get the [26] column value.
     *
     * @return string
     */
    public function get26()
    {
        return $this->26;
    }

    /**
     * Get the [27] column value.
     *
     * @return string
     */
    public function get27()
    {
        return $this->27;
    }

    /**
     * Get the [28] column value.
     *
     * @return string
     */
    public function get28()
    {
        return $this->28;
    }

    /**
     * Get the [29] column value.
     *
     * @return string
     */
    public function get29()
    {
        return $this->29;
    }

    /**
     * Get the [30] column value.
     *
     * @return string
     */
    public function get30()
    {
        return $this->30;
    }

    /**
     * Get the [31] column value.
     *
     * @return string
     */
    public function get31()
    {
        return $this->31;
    }

    /**
     * Get the [01_click] column value.
     *
     * @return string
     */
    public function get01Click()
    {
        return $this->01_click;
    }

    /**
     * Get the [02_click] column value.
     *
     * @return string
     */
    public function get02Click()
    {
        return $this->02_click;
    }

    /**
     * Get the [03_click] column value.
     *
     * @return string
     */
    public function get03Click()
    {
        return $this->03_click;
    }

    /**
     * Get the [04_click] column value.
     *
     * @return string
     */
    public function get04Click()
    {
        return $this->04_click;
    }

    /**
     * Get the [05_click] column value.
     *
     * @return string
     */
    public function get05Click()
    {
        return $this->05_click;
    }

    /**
     * Get the [06_click] column value.
     *
     * @return string
     */
    public function get06Click()
    {
        return $this->06_click;
    }

    /**
     * Get the [07_click] column value.
     *
     * @return string
     */
    public function get07Click()
    {
        return $this->07_click;
    }

    /**
     * Get the [08_click] column value.
     *
     * @return string
     */
    public function get08Click()
    {
        return $this->08_click;
    }

    /**
     * Get the [09_click] column value.
     *
     * @return string
     */
    public function get09Click()
    {
        return $this->09_click;
    }

    /**
     * Get the [10_click] column value.
     *
     * @return string
     */
    public function get10Click()
    {
        return $this->10_click;
    }

    /**
     * Get the [11_click] column value.
     *
     * @return string
     */
    public function get11Click()
    {
        return $this->11_click;
    }

    /**
     * Get the [12_click] column value.
     *
     * @return string
     */
    public function get12Click()
    {
        return $this->12_click;
    }

    /**
     * Get the [13_click] column value.
     *
     * @return string
     */
    public function get13Click()
    {
        return $this->13_click;
    }

    /**
     * Get the [14_click] column value.
     *
     * @return string
     */
    public function get14Click()
    {
        return $this->14_click;
    }

    /**
     * Get the [15_click] column value.
     *
     * @return string
     */
    public function get15Click()
    {
        return $this->15_click;
    }

    /**
     * Get the [16_click] column value.
     *
     * @return string
     */
    public function get16Click()
    {
        return $this->16_click;
    }

    /**
     * Get the [17_click] column value.
     *
     * @return string
     */
    public function get17Click()
    {
        return $this->17_click;
    }

    /**
     * Get the [18_click] column value.
     *
     * @return string
     */
    public function get18Click()
    {
        return $this->18_click;
    }

    /**
     * Get the [19_click] column value.
     *
     * @return string
     */
    public function get19Click()
    {
        return $this->19_click;
    }

    /**
     * Get the [20_click] column value.
     *
     * @return string
     */
    public function get20Click()
    {
        return $this->20_click;
    }

    /**
     * Get the [21_click] column value.
     *
     * @return string
     */
    public function get21Click()
    {
        return $this->21_click;
    }

    /**
     * Get the [22_click] column value.
     *
     * @return string
     */
    public function get22Click()
    {
        return $this->22_click;
    }

    /**
     * Get the [23_click] column value.
     *
     * @return string
     */
    public function get23Click()
    {
        return $this->23_click;
    }

    /**
     * Get the [24_click] column value.
     *
     * @return string
     */
    public function get24Click()
    {
        return $this->24_click;
    }

    /**
     * Get the [25_click] column value.
     *
     * @return string
     */
    public function get25Click()
    {
        return $this->25_click;
    }

    /**
     * Get the [26_click] column value.
     *
     * @return string
     */
    public function get26Click()
    {
        return $this->26_click;
    }

    /**
     * Get the [27_click] column value.
     *
     * @return string
     */
    public function get27Click()
    {
        return $this->27_click;
    }

    /**
     * Get the [28_click] column value.
     *
     * @return string
     */
    public function get28Click()
    {
        return $this->28_click;
    }

    /**
     * Get the [29_click] column value.
     *
     * @return string
     */
    public function get29Click()
    {
        return $this->29_click;
    }

    /**
     * Get the [30_click] column value.
     *
     * @return string
     */
    public function get30Click()
    {
        return $this->30_click;
    }

    /**
     * Get the [31_click] column value.
     *
     * @return string
     */
    public function get31Click()
    {
        return $this->31_click;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ApReportTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [ap_macaddr] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function setApMacaddr($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ap_macaddr !== $v) {
            $this->ap_macaddr = $v;
            $this->modifiedColumns[ApReportTableMap::COL_AP_MACADDR] = true;
        }

        return $this;
    } // setApMacaddr()

    /**
     * Set the value of [year] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function setYear($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->year !== $v) {
            $this->year = $v;
            $this->modifiedColumns[ApReportTableMap::COL_YEAR] = true;
        }

        return $this;
    } // setYear()

    /**
     * Set the value of [month] column.
     *
     * @param int $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function setMonth($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->month !== $v) {
            $this->month = $v;
            $this->modifiedColumns[ApReportTableMap::COL_MONTH] = true;
        }

        return $this;
    } // setMonth()

    /**
     * Set the value of [01] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set01($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->01 !== $v) {
            $this->01 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_01] = true;
        }

        return $this;
    } // set01()

    /**
     * Set the value of [02] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set02($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->02 !== $v) {
            $this->02 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_02] = true;
        }

        return $this;
    } // set02()

    /**
     * Set the value of [03] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set03($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->03 !== $v) {
            $this->03 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_03] = true;
        }

        return $this;
    } // set03()

    /**
     * Set the value of [04] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set04($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->04 !== $v) {
            $this->04 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_04] = true;
        }

        return $this;
    } // set04()

    /**
     * Set the value of [05] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set05($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->05 !== $v) {
            $this->05 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_05] = true;
        }

        return $this;
    } // set05()

    /**
     * Set the value of [06] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set06($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->06 !== $v) {
            $this->06 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_06] = true;
        }

        return $this;
    } // set06()

    /**
     * Set the value of [07] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set07($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->07 !== $v) {
            $this->07 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_07] = true;
        }

        return $this;
    } // set07()

    /**
     * Set the value of [08] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set08($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->08 !== $v) {
            $this->08 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_08] = true;
        }

        return $this;
    } // set08()

    /**
     * Set the value of [09] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set09($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->09 !== $v) {
            $this->09 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_09] = true;
        }

        return $this;
    } // set09()

    /**
     * Set the value of [10] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set10($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->10 !== $v) {
            $this->10 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_10] = true;
        }

        return $this;
    } // set10()

    /**
     * Set the value of [11] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set11($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->11 !== $v) {
            $this->11 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_11] = true;
        }

        return $this;
    } // set11()

    /**
     * Set the value of [12] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set12($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->12 !== $v) {
            $this->12 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_12] = true;
        }

        return $this;
    } // set12()

    /**
     * Set the value of [13] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set13($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->13 !== $v) {
            $this->13 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_13] = true;
        }

        return $this;
    } // set13()

    /**
     * Set the value of [14] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set14($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->14 !== $v) {
            $this->14 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_14] = true;
        }

        return $this;
    } // set14()

    /**
     * Set the value of [15] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set15($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->15 !== $v) {
            $this->15 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_15] = true;
        }

        return $this;
    } // set15()

    /**
     * Set the value of [16] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set16($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->16 !== $v) {
            $this->16 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_16] = true;
        }

        return $this;
    } // set16()

    /**
     * Set the value of [17] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set17($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->17 !== $v) {
            $this->17 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_17] = true;
        }

        return $this;
    } // set17()

    /**
     * Set the value of [18] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set18($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->18 !== $v) {
            $this->18 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_18] = true;
        }

        return $this;
    } // set18()

    /**
     * Set the value of [19] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set19($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->19 !== $v) {
            $this->19 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_19] = true;
        }

        return $this;
    } // set19()

    /**
     * Set the value of [20] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set20($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->20 !== $v) {
            $this->20 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_20] = true;
        }

        return $this;
    } // set20()

    /**
     * Set the value of [21] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set21($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->21 !== $v) {
            $this->21 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_21] = true;
        }

        return $this;
    } // set21()

    /**
     * Set the value of [22] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set22($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->22 !== $v) {
            $this->22 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_22] = true;
        }

        return $this;
    } // set22()

    /**
     * Set the value of [23] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set23($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->23 !== $v) {
            $this->23 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_23] = true;
        }

        return $this;
    } // set23()

    /**
     * Set the value of [24] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set24($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->24 !== $v) {
            $this->24 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_24] = true;
        }

        return $this;
    } // set24()

    /**
     * Set the value of [25] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set25($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->25 !== $v) {
            $this->25 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_25] = true;
        }

        return $this;
    } // set25()

    /**
     * Set the value of [26] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set26($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->26 !== $v) {
            $this->26 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_26] = true;
        }

        return $this;
    } // set26()

    /**
     * Set the value of [27] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set27($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->27 !== $v) {
            $this->27 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_27] = true;
        }

        return $this;
    } // set27()

    /**
     * Set the value of [28] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set28($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->28 !== $v) {
            $this->28 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_28] = true;
        }

        return $this;
    } // set28()

    /**
     * Set the value of [29] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set29($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->29 !== $v) {
            $this->29 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_29] = true;
        }

        return $this;
    } // set29()

    /**
     * Set the value of [30] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set30($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->30 !== $v) {
            $this->30 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_30] = true;
        }

        return $this;
    } // set30()

    /**
     * Set the value of [31] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set31($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->31 !== $v) {
            $this->31 = $v;
            $this->modifiedColumns[ApReportTableMap::COL_31] = true;
        }

        return $this;
    } // set31()

    /**
     * Set the value of [01_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set01Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->01_click !== $v) {
            $this->01_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_01_CLICK] = true;
        }

        return $this;
    } // set01Click()

    /**
     * Set the value of [02_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set02Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->02_click !== $v) {
            $this->02_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_02_CLICK] = true;
        }

        return $this;
    } // set02Click()

    /**
     * Set the value of [03_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set03Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->03_click !== $v) {
            $this->03_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_03_CLICK] = true;
        }

        return $this;
    } // set03Click()

    /**
     * Set the value of [04_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set04Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->04_click !== $v) {
            $this->04_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_04_CLICK] = true;
        }

        return $this;
    } // set04Click()

    /**
     * Set the value of [05_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set05Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->05_click !== $v) {
            $this->05_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_05_CLICK] = true;
        }

        return $this;
    } // set05Click()

    /**
     * Set the value of [06_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set06Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->06_click !== $v) {
            $this->06_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_06_CLICK] = true;
        }

        return $this;
    } // set06Click()

    /**
     * Set the value of [07_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set07Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->07_click !== $v) {
            $this->07_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_07_CLICK] = true;
        }

        return $this;
    } // set07Click()

    /**
     * Set the value of [08_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set08Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->08_click !== $v) {
            $this->08_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_08_CLICK] = true;
        }

        return $this;
    } // set08Click()

    /**
     * Set the value of [09_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set09Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->09_click !== $v) {
            $this->09_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_09_CLICK] = true;
        }

        return $this;
    } // set09Click()

    /**
     * Set the value of [10_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set10Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->10_click !== $v) {
            $this->10_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_10_CLICK] = true;
        }

        return $this;
    } // set10Click()

    /**
     * Set the value of [11_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set11Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->11_click !== $v) {
            $this->11_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_11_CLICK] = true;
        }

        return $this;
    } // set11Click()

    /**
     * Set the value of [12_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set12Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->12_click !== $v) {
            $this->12_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_12_CLICK] = true;
        }

        return $this;
    } // set12Click()

    /**
     * Set the value of [13_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set13Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->13_click !== $v) {
            $this->13_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_13_CLICK] = true;
        }

        return $this;
    } // set13Click()

    /**
     * Set the value of [14_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set14Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->14_click !== $v) {
            $this->14_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_14_CLICK] = true;
        }

        return $this;
    } // set14Click()

    /**
     * Set the value of [15_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set15Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->15_click !== $v) {
            $this->15_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_15_CLICK] = true;
        }

        return $this;
    } // set15Click()

    /**
     * Set the value of [16_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set16Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->16_click !== $v) {
            $this->16_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_16_CLICK] = true;
        }

        return $this;
    } // set16Click()

    /**
     * Set the value of [17_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set17Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->17_click !== $v) {
            $this->17_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_17_CLICK] = true;
        }

        return $this;
    } // set17Click()

    /**
     * Set the value of [18_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set18Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->18_click !== $v) {
            $this->18_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_18_CLICK] = true;
        }

        return $this;
    } // set18Click()

    /**
     * Set the value of [19_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set19Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->19_click !== $v) {
            $this->19_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_19_CLICK] = true;
        }

        return $this;
    } // set19Click()

    /**
     * Set the value of [20_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set20Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->20_click !== $v) {
            $this->20_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_20_CLICK] = true;
        }

        return $this;
    } // set20Click()

    /**
     * Set the value of [21_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set21Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->21_click !== $v) {
            $this->21_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_21_CLICK] = true;
        }

        return $this;
    } // set21Click()

    /**
     * Set the value of [22_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set22Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->22_click !== $v) {
            $this->22_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_22_CLICK] = true;
        }

        return $this;
    } // set22Click()

    /**
     * Set the value of [23_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set23Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->23_click !== $v) {
            $this->23_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_23_CLICK] = true;
        }

        return $this;
    } // set23Click()

    /**
     * Set the value of [24_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set24Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->24_click !== $v) {
            $this->24_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_24_CLICK] = true;
        }

        return $this;
    } // set24Click()

    /**
     * Set the value of [25_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set25Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->25_click !== $v) {
            $this->25_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_25_CLICK] = true;
        }

        return $this;
    } // set25Click()

    /**
     * Set the value of [26_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set26Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->26_click !== $v) {
            $this->26_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_26_CLICK] = true;
        }

        return $this;
    } // set26Click()

    /**
     * Set the value of [27_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set27Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->27_click !== $v) {
            $this->27_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_27_CLICK] = true;
        }

        return $this;
    } // set27Click()

    /**
     * Set the value of [28_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set28Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->28_click !== $v) {
            $this->28_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_28_CLICK] = true;
        }

        return $this;
    } // set28Click()

    /**
     * Set the value of [29_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set29Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->29_click !== $v) {
            $this->29_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_29_CLICK] = true;
        }

        return $this;
    } // set29Click()

    /**
     * Set the value of [30_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set30Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->30_click !== $v) {
            $this->30_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_30_CLICK] = true;
        }

        return $this;
    } // set30Click()

    /**
     * Set the value of [31_click] column.
     *
     * @param string $v new value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object (for fluent API support)
     */
    public function set31Click($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->31_click !== $v) {
            $this->31_click = $v;
            $this->modifiedColumns[ApReportTableMap::COL_31_CLICK] = true;
        }

        return $this;
    } // set31Click()

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
            if ($this->year !== 0) {
                return false;
            }

            if ($this->month !== 0) {
                return false;
            }

            if ($this->01 !== '0') {
                return false;
            }

            if ($this->02 !== '0') {
                return false;
            }

            if ($this->03 !== '0') {
                return false;
            }

            if ($this->04 !== '0') {
                return false;
            }

            if ($this->05 !== '0') {
                return false;
            }

            if ($this->06 !== '0') {
                return false;
            }

            if ($this->07 !== '0') {
                return false;
            }

            if ($this->08 !== '0') {
                return false;
            }

            if ($this->09 !== '0') {
                return false;
            }

            if ($this->10 !== '0') {
                return false;
            }

            if ($this->11 !== '0') {
                return false;
            }

            if ($this->12 !== '0') {
                return false;
            }

            if ($this->13 !== '0') {
                return false;
            }

            if ($this->14 !== '0') {
                return false;
            }

            if ($this->15 !== '0') {
                return false;
            }

            if ($this->16 !== '0') {
                return false;
            }

            if ($this->17 !== '0') {
                return false;
            }

            if ($this->18 !== '0') {
                return false;
            }

            if ($this->19 !== '0') {
                return false;
            }

            if ($this->20 !== '0') {
                return false;
            }

            if ($this->21 !== '0') {
                return false;
            }

            if ($this->22 !== '0') {
                return false;
            }

            if ($this->23 !== '0') {
                return false;
            }

            if ($this->24 !== '0') {
                return false;
            }

            if ($this->25 !== '0') {
                return false;
            }

            if ($this->26 !== '0') {
                return false;
            }

            if ($this->27 !== '0') {
                return false;
            }

            if ($this->28 !== '0') {
                return false;
            }

            if ($this->29 !== '0') {
                return false;
            }

            if ($this->30 !== '0') {
                return false;
            }

            if ($this->31 !== '0') {
                return false;
            }

            if ($this->01_click !== '0') {
                return false;
            }

            if ($this->02_click !== '0') {
                return false;
            }

            if ($this->03_click !== '0') {
                return false;
            }

            if ($this->04_click !== '0') {
                return false;
            }

            if ($this->05_click !== '0') {
                return false;
            }

            if ($this->06_click !== '0') {
                return false;
            }

            if ($this->07_click !== '0') {
                return false;
            }

            if ($this->08_click !== '0') {
                return false;
            }

            if ($this->09_click !== '0') {
                return false;
            }

            if ($this->10_click !== '0') {
                return false;
            }

            if ($this->11_click !== '0') {
                return false;
            }

            if ($this->12_click !== '0') {
                return false;
            }

            if ($this->13_click !== '0') {
                return false;
            }

            if ($this->14_click !== '0') {
                return false;
            }

            if ($this->15_click !== '0') {
                return false;
            }

            if ($this->16_click !== '0') {
                return false;
            }

            if ($this->17_click !== '0') {
                return false;
            }

            if ($this->18_click !== '0') {
                return false;
            }

            if ($this->19_click !== '0') {
                return false;
            }

            if ($this->20_click !== '0') {
                return false;
            }

            if ($this->21_click !== '0') {
                return false;
            }

            if ($this->22_click !== '0') {
                return false;
            }

            if ($this->23_click !== '0') {
                return false;
            }

            if ($this->24_click !== '0') {
                return false;
            }

            if ($this->25_click !== '0') {
                return false;
            }

            if ($this->26_click !== '0') {
                return false;
            }

            if ($this->27_click !== '0') {
                return false;
            }

            if ($this->28_click !== '0') {
                return false;
            }

            if ($this->29_click !== '0') {
                return false;
            }

            if ($this->30_click !== '0') {
                return false;
            }

            if ($this->31_click !== '0') {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ApReportTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ApReportTableMap::translateFieldName('ApMacaddr', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ap_macaddr = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ApReportTableMap::translateFieldName('Year', TableMap::TYPE_PHPNAME, $indexType)];
            $this->year = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ApReportTableMap::translateFieldName('Month', TableMap::TYPE_PHPNAME, $indexType)];
            $this->month = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ApReportTableMap::translateFieldName('01', TableMap::TYPE_PHPNAME, $indexType)];
            $this->01 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ApReportTableMap::translateFieldName('02', TableMap::TYPE_PHPNAME, $indexType)];
            $this->02 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ApReportTableMap::translateFieldName('03', TableMap::TYPE_PHPNAME, $indexType)];
            $this->03 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ApReportTableMap::translateFieldName('04', TableMap::TYPE_PHPNAME, $indexType)];
            $this->04 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ApReportTableMap::translateFieldName('05', TableMap::TYPE_PHPNAME, $indexType)];
            $this->05 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ApReportTableMap::translateFieldName('06', TableMap::TYPE_PHPNAME, $indexType)];
            $this->06 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ApReportTableMap::translateFieldName('07', TableMap::TYPE_PHPNAME, $indexType)];
            $this->07 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : ApReportTableMap::translateFieldName('08', TableMap::TYPE_PHPNAME, $indexType)];
            $this->08 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : ApReportTableMap::translateFieldName('09', TableMap::TYPE_PHPNAME, $indexType)];
            $this->09 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : ApReportTableMap::translateFieldName('10', TableMap::TYPE_PHPNAME, $indexType)];
            $this->10 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : ApReportTableMap::translateFieldName('11', TableMap::TYPE_PHPNAME, $indexType)];
            $this->11 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : ApReportTableMap::translateFieldName('12', TableMap::TYPE_PHPNAME, $indexType)];
            $this->12 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : ApReportTableMap::translateFieldName('13', TableMap::TYPE_PHPNAME, $indexType)];
            $this->13 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : ApReportTableMap::translateFieldName('14', TableMap::TYPE_PHPNAME, $indexType)];
            $this->14 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 18 + $startcol : ApReportTableMap::translateFieldName('15', TableMap::TYPE_PHPNAME, $indexType)];
            $this->15 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 19 + $startcol : ApReportTableMap::translateFieldName('16', TableMap::TYPE_PHPNAME, $indexType)];
            $this->16 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 20 + $startcol : ApReportTableMap::translateFieldName('17', TableMap::TYPE_PHPNAME, $indexType)];
            $this->17 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 21 + $startcol : ApReportTableMap::translateFieldName('18', TableMap::TYPE_PHPNAME, $indexType)];
            $this->18 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 22 + $startcol : ApReportTableMap::translateFieldName('19', TableMap::TYPE_PHPNAME, $indexType)];
            $this->19 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 23 + $startcol : ApReportTableMap::translateFieldName('20', TableMap::TYPE_PHPNAME, $indexType)];
            $this->20 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 24 + $startcol : ApReportTableMap::translateFieldName('21', TableMap::TYPE_PHPNAME, $indexType)];
            $this->21 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 25 + $startcol : ApReportTableMap::translateFieldName('22', TableMap::TYPE_PHPNAME, $indexType)];
            $this->22 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 26 + $startcol : ApReportTableMap::translateFieldName('23', TableMap::TYPE_PHPNAME, $indexType)];
            $this->23 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 27 + $startcol : ApReportTableMap::translateFieldName('24', TableMap::TYPE_PHPNAME, $indexType)];
            $this->24 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 28 + $startcol : ApReportTableMap::translateFieldName('25', TableMap::TYPE_PHPNAME, $indexType)];
            $this->25 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 29 + $startcol : ApReportTableMap::translateFieldName('26', TableMap::TYPE_PHPNAME, $indexType)];
            $this->26 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 30 + $startcol : ApReportTableMap::translateFieldName('27', TableMap::TYPE_PHPNAME, $indexType)];
            $this->27 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 31 + $startcol : ApReportTableMap::translateFieldName('28', TableMap::TYPE_PHPNAME, $indexType)];
            $this->28 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 32 + $startcol : ApReportTableMap::translateFieldName('29', TableMap::TYPE_PHPNAME, $indexType)];
            $this->29 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 33 + $startcol : ApReportTableMap::translateFieldName('30', TableMap::TYPE_PHPNAME, $indexType)];
            $this->30 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 34 + $startcol : ApReportTableMap::translateFieldName('31', TableMap::TYPE_PHPNAME, $indexType)];
            $this->31 = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 35 + $startcol : ApReportTableMap::translateFieldName('01Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->01_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 36 + $startcol : ApReportTableMap::translateFieldName('02Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->02_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 37 + $startcol : ApReportTableMap::translateFieldName('03Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->03_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 38 + $startcol : ApReportTableMap::translateFieldName('04Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->04_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 39 + $startcol : ApReportTableMap::translateFieldName('05Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->05_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 40 + $startcol : ApReportTableMap::translateFieldName('06Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->06_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 41 + $startcol : ApReportTableMap::translateFieldName('07Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->07_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 42 + $startcol : ApReportTableMap::translateFieldName('08Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->08_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 43 + $startcol : ApReportTableMap::translateFieldName('09Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->09_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 44 + $startcol : ApReportTableMap::translateFieldName('10Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->10_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 45 + $startcol : ApReportTableMap::translateFieldName('11Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->11_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 46 + $startcol : ApReportTableMap::translateFieldName('12Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->12_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 47 + $startcol : ApReportTableMap::translateFieldName('13Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->13_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 48 + $startcol : ApReportTableMap::translateFieldName('14Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->14_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 49 + $startcol : ApReportTableMap::translateFieldName('15Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->15_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 50 + $startcol : ApReportTableMap::translateFieldName('16Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->16_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 51 + $startcol : ApReportTableMap::translateFieldName('17Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->17_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 52 + $startcol : ApReportTableMap::translateFieldName('18Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->18_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 53 + $startcol : ApReportTableMap::translateFieldName('19Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->19_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 54 + $startcol : ApReportTableMap::translateFieldName('20Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->20_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 55 + $startcol : ApReportTableMap::translateFieldName('21Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->21_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 56 + $startcol : ApReportTableMap::translateFieldName('22Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->22_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 57 + $startcol : ApReportTableMap::translateFieldName('23Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->23_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 58 + $startcol : ApReportTableMap::translateFieldName('24Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->24_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 59 + $startcol : ApReportTableMap::translateFieldName('25Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->25_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 60 + $startcol : ApReportTableMap::translateFieldName('26Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->26_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 61 + $startcol : ApReportTableMap::translateFieldName('27Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->27_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 62 + $startcol : ApReportTableMap::translateFieldName('28Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->28_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 63 + $startcol : ApReportTableMap::translateFieldName('29Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->29_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 64 + $startcol : ApReportTableMap::translateFieldName('30Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->30_click = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 65 + $startcol : ApReportTableMap::translateFieldName('31Click', TableMap::TYPE_PHPNAME, $indexType)];
            $this->31_click = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 66; // 66 = ApReportTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Hotspot\\AccessPointBundle\\Model\\ApReport'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ApReportTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildApReportQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ApReport::setDeleted()
     * @see ApReport::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApReportTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildApReportQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ApReportTableMap::DATABASE_NAME);
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
                ApReportTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[ApReportTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ApReportTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ApReportTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_AP_MACADDR)) {
            $modifiedColumns[':p' . $index++]  = '`ap_macaddr`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_YEAR)) {
            $modifiedColumns[':p' . $index++]  = '`year`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_MONTH)) {
            $modifiedColumns[':p' . $index++]  = '`month`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_01)) {
            $modifiedColumns[':p' . $index++]  = '`01`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_02)) {
            $modifiedColumns[':p' . $index++]  = '`02`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_03)) {
            $modifiedColumns[':p' . $index++]  = '`03`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_04)) {
            $modifiedColumns[':p' . $index++]  = '`04`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_05)) {
            $modifiedColumns[':p' . $index++]  = '`05`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_06)) {
            $modifiedColumns[':p' . $index++]  = '`06`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_07)) {
            $modifiedColumns[':p' . $index++]  = '`07`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_08)) {
            $modifiedColumns[':p' . $index++]  = '`08`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_09)) {
            $modifiedColumns[':p' . $index++]  = '`09`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_10)) {
            $modifiedColumns[':p' . $index++]  = '`10`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_11)) {
            $modifiedColumns[':p' . $index++]  = '`11`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_12)) {
            $modifiedColumns[':p' . $index++]  = '`12`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_13)) {
            $modifiedColumns[':p' . $index++]  = '`13`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_14)) {
            $modifiedColumns[':p' . $index++]  = '`14`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_15)) {
            $modifiedColumns[':p' . $index++]  = '`15`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_16)) {
            $modifiedColumns[':p' . $index++]  = '`16`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_17)) {
            $modifiedColumns[':p' . $index++]  = '`17`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_18)) {
            $modifiedColumns[':p' . $index++]  = '`18`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_19)) {
            $modifiedColumns[':p' . $index++]  = '`19`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_20)) {
            $modifiedColumns[':p' . $index++]  = '`20`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_21)) {
            $modifiedColumns[':p' . $index++]  = '`21`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_22)) {
            $modifiedColumns[':p' . $index++]  = '`22`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_23)) {
            $modifiedColumns[':p' . $index++]  = '`23`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_24)) {
            $modifiedColumns[':p' . $index++]  = '`24`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_25)) {
            $modifiedColumns[':p' . $index++]  = '`25`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_26)) {
            $modifiedColumns[':p' . $index++]  = '`26`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_27)) {
            $modifiedColumns[':p' . $index++]  = '`27`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_28)) {
            $modifiedColumns[':p' . $index++]  = '`28`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_29)) {
            $modifiedColumns[':p' . $index++]  = '`29`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_30)) {
            $modifiedColumns[':p' . $index++]  = '`30`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_31)) {
            $modifiedColumns[':p' . $index++]  = '`31`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_01_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`01_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_02_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`02_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_03_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`03_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_04_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`04_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_05_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`05_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_06_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`06_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_07_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`07_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_08_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`08_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_09_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`09_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_10_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`10_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_11_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`11_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_12_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`12_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_13_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`13_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_14_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`14_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_15_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`15_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_16_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`16_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_17_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`17_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_18_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`18_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_19_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`19_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_20_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`20_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_21_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`21_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_22_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`22_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_23_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`23_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_24_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`24_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_25_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`25_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_26_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`26_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_27_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`27_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_28_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`28_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_29_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`29_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_30_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`30_click`';
        }
        if ($this->isColumnModified(ApReportTableMap::COL_31_CLICK)) {
            $modifiedColumns[':p' . $index++]  = '`31_click`';
        }

        $sql = sprintf(
            'INSERT INTO `ap_report` (%s) VALUES (%s)',
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
                    case '`ap_macaddr`':
                        $stmt->bindValue($identifier, $this->ap_macaddr, PDO::PARAM_STR);
                        break;
                    case '`year`':
                        $stmt->bindValue($identifier, $this->year, PDO::PARAM_INT);
                        break;
                    case '`month`':
                        $stmt->bindValue($identifier, $this->month, PDO::PARAM_INT);
                        break;
                    case '`01`':
                        $stmt->bindValue($identifier, $this->01, PDO::PARAM_STR);
                        break;
                    case '`02`':
                        $stmt->bindValue($identifier, $this->02, PDO::PARAM_STR);
                        break;
                    case '`03`':
                        $stmt->bindValue($identifier, $this->03, PDO::PARAM_STR);
                        break;
                    case '`04`':
                        $stmt->bindValue($identifier, $this->04, PDO::PARAM_STR);
                        break;
                    case '`05`':
                        $stmt->bindValue($identifier, $this->05, PDO::PARAM_STR);
                        break;
                    case '`06`':
                        $stmt->bindValue($identifier, $this->06, PDO::PARAM_STR);
                        break;
                    case '`07`':
                        $stmt->bindValue($identifier, $this->07, PDO::PARAM_STR);
                        break;
                    case '`08`':
                        $stmt->bindValue($identifier, $this->08, PDO::PARAM_STR);
                        break;
                    case '`09`':
                        $stmt->bindValue($identifier, $this->09, PDO::PARAM_STR);
                        break;
                    case '`10`':
                        $stmt->bindValue($identifier, $this->10, PDO::PARAM_STR);
                        break;
                    case '`11`':
                        $stmt->bindValue($identifier, $this->11, PDO::PARAM_STR);
                        break;
                    case '`12`':
                        $stmt->bindValue($identifier, $this->12, PDO::PARAM_STR);
                        break;
                    case '`13`':
                        $stmt->bindValue($identifier, $this->13, PDO::PARAM_STR);
                        break;
                    case '`14`':
                        $stmt->bindValue($identifier, $this->14, PDO::PARAM_STR);
                        break;
                    case '`15`':
                        $stmt->bindValue($identifier, $this->15, PDO::PARAM_STR);
                        break;
                    case '`16`':
                        $stmt->bindValue($identifier, $this->16, PDO::PARAM_STR);
                        break;
                    case '`17`':
                        $stmt->bindValue($identifier, $this->17, PDO::PARAM_STR);
                        break;
                    case '`18`':
                        $stmt->bindValue($identifier, $this->18, PDO::PARAM_STR);
                        break;
                    case '`19`':
                        $stmt->bindValue($identifier, $this->19, PDO::PARAM_STR);
                        break;
                    case '`20`':
                        $stmt->bindValue($identifier, $this->20, PDO::PARAM_STR);
                        break;
                    case '`21`':
                        $stmt->bindValue($identifier, $this->21, PDO::PARAM_STR);
                        break;
                    case '`22`':
                        $stmt->bindValue($identifier, $this->22, PDO::PARAM_STR);
                        break;
                    case '`23`':
                        $stmt->bindValue($identifier, $this->23, PDO::PARAM_STR);
                        break;
                    case '`24`':
                        $stmt->bindValue($identifier, $this->24, PDO::PARAM_STR);
                        break;
                    case '`25`':
                        $stmt->bindValue($identifier, $this->25, PDO::PARAM_STR);
                        break;
                    case '`26`':
                        $stmt->bindValue($identifier, $this->26, PDO::PARAM_STR);
                        break;
                    case '`27`':
                        $stmt->bindValue($identifier, $this->27, PDO::PARAM_STR);
                        break;
                    case '`28`':
                        $stmt->bindValue($identifier, $this->28, PDO::PARAM_STR);
                        break;
                    case '`29`':
                        $stmt->bindValue($identifier, $this->29, PDO::PARAM_STR);
                        break;
                    case '`30`':
                        $stmt->bindValue($identifier, $this->30, PDO::PARAM_STR);
                        break;
                    case '`31`':
                        $stmt->bindValue($identifier, $this->31, PDO::PARAM_STR);
                        break;
                    case '`01_click`':
                        $stmt->bindValue($identifier, $this->01_click, PDO::PARAM_STR);
                        break;
                    case '`02_click`':
                        $stmt->bindValue($identifier, $this->02_click, PDO::PARAM_STR);
                        break;
                    case '`03_click`':
                        $stmt->bindValue($identifier, $this->03_click, PDO::PARAM_STR);
                        break;
                    case '`04_click`':
                        $stmt->bindValue($identifier, $this->04_click, PDO::PARAM_STR);
                        break;
                    case '`05_click`':
                        $stmt->bindValue($identifier, $this->05_click, PDO::PARAM_STR);
                        break;
                    case '`06_click`':
                        $stmt->bindValue($identifier, $this->06_click, PDO::PARAM_STR);
                        break;
                    case '`07_click`':
                        $stmt->bindValue($identifier, $this->07_click, PDO::PARAM_STR);
                        break;
                    case '`08_click`':
                        $stmt->bindValue($identifier, $this->08_click, PDO::PARAM_STR);
                        break;
                    case '`09_click`':
                        $stmt->bindValue($identifier, $this->09_click, PDO::PARAM_STR);
                        break;
                    case '`10_click`':
                        $stmt->bindValue($identifier, $this->10_click, PDO::PARAM_STR);
                        break;
                    case '`11_click`':
                        $stmt->bindValue($identifier, $this->11_click, PDO::PARAM_STR);
                        break;
                    case '`12_click`':
                        $stmt->bindValue($identifier, $this->12_click, PDO::PARAM_STR);
                        break;
                    case '`13_click`':
                        $stmt->bindValue($identifier, $this->13_click, PDO::PARAM_STR);
                        break;
                    case '`14_click`':
                        $stmt->bindValue($identifier, $this->14_click, PDO::PARAM_STR);
                        break;
                    case '`15_click`':
                        $stmt->bindValue($identifier, $this->15_click, PDO::PARAM_STR);
                        break;
                    case '`16_click`':
                        $stmt->bindValue($identifier, $this->16_click, PDO::PARAM_STR);
                        break;
                    case '`17_click`':
                        $stmt->bindValue($identifier, $this->17_click, PDO::PARAM_STR);
                        break;
                    case '`18_click`':
                        $stmt->bindValue($identifier, $this->18_click, PDO::PARAM_STR);
                        break;
                    case '`19_click`':
                        $stmt->bindValue($identifier, $this->19_click, PDO::PARAM_STR);
                        break;
                    case '`20_click`':
                        $stmt->bindValue($identifier, $this->20_click, PDO::PARAM_STR);
                        break;
                    case '`21_click`':
                        $stmt->bindValue($identifier, $this->21_click, PDO::PARAM_STR);
                        break;
                    case '`22_click`':
                        $stmt->bindValue($identifier, $this->22_click, PDO::PARAM_STR);
                        break;
                    case '`23_click`':
                        $stmt->bindValue($identifier, $this->23_click, PDO::PARAM_STR);
                        break;
                    case '`24_click`':
                        $stmt->bindValue($identifier, $this->24_click, PDO::PARAM_STR);
                        break;
                    case '`25_click`':
                        $stmt->bindValue($identifier, $this->25_click, PDO::PARAM_STR);
                        break;
                    case '`26_click`':
                        $stmt->bindValue($identifier, $this->26_click, PDO::PARAM_STR);
                        break;
                    case '`27_click`':
                        $stmt->bindValue($identifier, $this->27_click, PDO::PARAM_STR);
                        break;
                    case '`28_click`':
                        $stmt->bindValue($identifier, $this->28_click, PDO::PARAM_STR);
                        break;
                    case '`29_click`':
                        $stmt->bindValue($identifier, $this->29_click, PDO::PARAM_STR);
                        break;
                    case '`30_click`':
                        $stmt->bindValue($identifier, $this->30_click, PDO::PARAM_STR);
                        break;
                    case '`31_click`':
                        $stmt->bindValue($identifier, $this->31_click, PDO::PARAM_STR);
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
        $pos = ApReportTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getApMacaddr();
                break;
            case 2:
                return $this->getYear();
                break;
            case 3:
                return $this->getMonth();
                break;
            case 4:
                return $this->get01();
                break;
            case 5:
                return $this->get02();
                break;
            case 6:
                return $this->get03();
                break;
            case 7:
                return $this->get04();
                break;
            case 8:
                return $this->get05();
                break;
            case 9:
                return $this->get06();
                break;
            case 10:
                return $this->get07();
                break;
            case 11:
                return $this->get08();
                break;
            case 12:
                return $this->get09();
                break;
            case 13:
                return $this->get10();
                break;
            case 14:
                return $this->get11();
                break;
            case 15:
                return $this->get12();
                break;
            case 16:
                return $this->get13();
                break;
            case 17:
                return $this->get14();
                break;
            case 18:
                return $this->get15();
                break;
            case 19:
                return $this->get16();
                break;
            case 20:
                return $this->get17();
                break;
            case 21:
                return $this->get18();
                break;
            case 22:
                return $this->get19();
                break;
            case 23:
                return $this->get20();
                break;
            case 24:
                return $this->get21();
                break;
            case 25:
                return $this->get22();
                break;
            case 26:
                return $this->get23();
                break;
            case 27:
                return $this->get24();
                break;
            case 28:
                return $this->get25();
                break;
            case 29:
                return $this->get26();
                break;
            case 30:
                return $this->get27();
                break;
            case 31:
                return $this->get28();
                break;
            case 32:
                return $this->get29();
                break;
            case 33:
                return $this->get30();
                break;
            case 34:
                return $this->get31();
                break;
            case 35:
                return $this->get01Click();
                break;
            case 36:
                return $this->get02Click();
                break;
            case 37:
                return $this->get03Click();
                break;
            case 38:
                return $this->get04Click();
                break;
            case 39:
                return $this->get05Click();
                break;
            case 40:
                return $this->get06Click();
                break;
            case 41:
                return $this->get07Click();
                break;
            case 42:
                return $this->get08Click();
                break;
            case 43:
                return $this->get09Click();
                break;
            case 44:
                return $this->get10Click();
                break;
            case 45:
                return $this->get11Click();
                break;
            case 46:
                return $this->get12Click();
                break;
            case 47:
                return $this->get13Click();
                break;
            case 48:
                return $this->get14Click();
                break;
            case 49:
                return $this->get15Click();
                break;
            case 50:
                return $this->get16Click();
                break;
            case 51:
                return $this->get17Click();
                break;
            case 52:
                return $this->get18Click();
                break;
            case 53:
                return $this->get19Click();
                break;
            case 54:
                return $this->get20Click();
                break;
            case 55:
                return $this->get21Click();
                break;
            case 56:
                return $this->get22Click();
                break;
            case 57:
                return $this->get23Click();
                break;
            case 58:
                return $this->get24Click();
                break;
            case 59:
                return $this->get25Click();
                break;
            case 60:
                return $this->get26Click();
                break;
            case 61:
                return $this->get27Click();
                break;
            case 62:
                return $this->get28Click();
                break;
            case 63:
                return $this->get29Click();
                break;
            case 64:
                return $this->get30Click();
                break;
            case 65:
                return $this->get31Click();
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
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {

        if (isset($alreadyDumpedObjects['ApReport'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ApReport'][$this->hashCode()] = true;
        $keys = ApReportTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getApMacaddr(),
            $keys[2] => $this->getYear(),
            $keys[3] => $this->getMonth(),
            $keys[4] => $this->get01(),
            $keys[5] => $this->get02(),
            $keys[6] => $this->get03(),
            $keys[7] => $this->get04(),
            $keys[8] => $this->get05(),
            $keys[9] => $this->get06(),
            $keys[10] => $this->get07(),
            $keys[11] => $this->get08(),
            $keys[12] => $this->get09(),
            $keys[13] => $this->get10(),
            $keys[14] => $this->get11(),
            $keys[15] => $this->get12(),
            $keys[16] => $this->get13(),
            $keys[17] => $this->get14(),
            $keys[18] => $this->get15(),
            $keys[19] => $this->get16(),
            $keys[20] => $this->get17(),
            $keys[21] => $this->get18(),
            $keys[22] => $this->get19(),
            $keys[23] => $this->get20(),
            $keys[24] => $this->get21(),
            $keys[25] => $this->get22(),
            $keys[26] => $this->get23(),
            $keys[27] => $this->get24(),
            $keys[28] => $this->get25(),
            $keys[29] => $this->get26(),
            $keys[30] => $this->get27(),
            $keys[31] => $this->get28(),
            $keys[32] => $this->get29(),
            $keys[33] => $this->get30(),
            $keys[34] => $this->get31(),
            $keys[35] => $this->get01Click(),
            $keys[36] => $this->get02Click(),
            $keys[37] => $this->get03Click(),
            $keys[38] => $this->get04Click(),
            $keys[39] => $this->get05Click(),
            $keys[40] => $this->get06Click(),
            $keys[41] => $this->get07Click(),
            $keys[42] => $this->get08Click(),
            $keys[43] => $this->get09Click(),
            $keys[44] => $this->get10Click(),
            $keys[45] => $this->get11Click(),
            $keys[46] => $this->get12Click(),
            $keys[47] => $this->get13Click(),
            $keys[48] => $this->get14Click(),
            $keys[49] => $this->get15Click(),
            $keys[50] => $this->get16Click(),
            $keys[51] => $this->get17Click(),
            $keys[52] => $this->get18Click(),
            $keys[53] => $this->get19Click(),
            $keys[54] => $this->get20Click(),
            $keys[55] => $this->get21Click(),
            $keys[56] => $this->get22Click(),
            $keys[57] => $this->get23Click(),
            $keys[58] => $this->get24Click(),
            $keys[59] => $this->get25Click(),
            $keys[60] => $this->get26Click(),
            $keys[61] => $this->get27Click(),
            $keys[62] => $this->get28Click(),
            $keys[63] => $this->get29Click(),
            $keys[64] => $this->get30Click(),
            $keys[65] => $this->get31Click(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
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
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ApReportTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setApMacaddr($value);
                break;
            case 2:
                $this->setYear($value);
                break;
            case 3:
                $this->setMonth($value);
                break;
            case 4:
                $this->set01($value);
                break;
            case 5:
                $this->set02($value);
                break;
            case 6:
                $this->set03($value);
                break;
            case 7:
                $this->set04($value);
                break;
            case 8:
                $this->set05($value);
                break;
            case 9:
                $this->set06($value);
                break;
            case 10:
                $this->set07($value);
                break;
            case 11:
                $this->set08($value);
                break;
            case 12:
                $this->set09($value);
                break;
            case 13:
                $this->set10($value);
                break;
            case 14:
                $this->set11($value);
                break;
            case 15:
                $this->set12($value);
                break;
            case 16:
                $this->set13($value);
                break;
            case 17:
                $this->set14($value);
                break;
            case 18:
                $this->set15($value);
                break;
            case 19:
                $this->set16($value);
                break;
            case 20:
                $this->set17($value);
                break;
            case 21:
                $this->set18($value);
                break;
            case 22:
                $this->set19($value);
                break;
            case 23:
                $this->set20($value);
                break;
            case 24:
                $this->set21($value);
                break;
            case 25:
                $this->set22($value);
                break;
            case 26:
                $this->set23($value);
                break;
            case 27:
                $this->set24($value);
                break;
            case 28:
                $this->set25($value);
                break;
            case 29:
                $this->set26($value);
                break;
            case 30:
                $this->set27($value);
                break;
            case 31:
                $this->set28($value);
                break;
            case 32:
                $this->set29($value);
                break;
            case 33:
                $this->set30($value);
                break;
            case 34:
                $this->set31($value);
                break;
            case 35:
                $this->set01Click($value);
                break;
            case 36:
                $this->set02Click($value);
                break;
            case 37:
                $this->set03Click($value);
                break;
            case 38:
                $this->set04Click($value);
                break;
            case 39:
                $this->set05Click($value);
                break;
            case 40:
                $this->set06Click($value);
                break;
            case 41:
                $this->set07Click($value);
                break;
            case 42:
                $this->set08Click($value);
                break;
            case 43:
                $this->set09Click($value);
                break;
            case 44:
                $this->set10Click($value);
                break;
            case 45:
                $this->set11Click($value);
                break;
            case 46:
                $this->set12Click($value);
                break;
            case 47:
                $this->set13Click($value);
                break;
            case 48:
                $this->set14Click($value);
                break;
            case 49:
                $this->set15Click($value);
                break;
            case 50:
                $this->set16Click($value);
                break;
            case 51:
                $this->set17Click($value);
                break;
            case 52:
                $this->set18Click($value);
                break;
            case 53:
                $this->set19Click($value);
                break;
            case 54:
                $this->set20Click($value);
                break;
            case 55:
                $this->set21Click($value);
                break;
            case 56:
                $this->set22Click($value);
                break;
            case 57:
                $this->set23Click($value);
                break;
            case 58:
                $this->set24Click($value);
                break;
            case 59:
                $this->set25Click($value);
                break;
            case 60:
                $this->set26Click($value);
                break;
            case 61:
                $this->set27Click($value);
                break;
            case 62:
                $this->set28Click($value);
                break;
            case 63:
                $this->set29Click($value);
                break;
            case 64:
                $this->set30Click($value);
                break;
            case 65:
                $this->set31Click($value);
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
        $keys = ApReportTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setApMacaddr($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setYear($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setMonth($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->set01($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->set02($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->set03($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->set04($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->set05($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->set06($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->set07($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->set08($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->set09($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->set10($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->set11($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->set12($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->set13($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->set14($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->set15($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->set16($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->set17($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->set18($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->set19($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->set20($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->set21($arr[$keys[24]]);
        }
        if (array_key_exists($keys[25], $arr)) {
            $this->set22($arr[$keys[25]]);
        }
        if (array_key_exists($keys[26], $arr)) {
            $this->set23($arr[$keys[26]]);
        }
        if (array_key_exists($keys[27], $arr)) {
            $this->set24($arr[$keys[27]]);
        }
        if (array_key_exists($keys[28], $arr)) {
            $this->set25($arr[$keys[28]]);
        }
        if (array_key_exists($keys[29], $arr)) {
            $this->set26($arr[$keys[29]]);
        }
        if (array_key_exists($keys[30], $arr)) {
            $this->set27($arr[$keys[30]]);
        }
        if (array_key_exists($keys[31], $arr)) {
            $this->set28($arr[$keys[31]]);
        }
        if (array_key_exists($keys[32], $arr)) {
            $this->set29($arr[$keys[32]]);
        }
        if (array_key_exists($keys[33], $arr)) {
            $this->set30($arr[$keys[33]]);
        }
        if (array_key_exists($keys[34], $arr)) {
            $this->set31($arr[$keys[34]]);
        }
        if (array_key_exists($keys[35], $arr)) {
            $this->set01Click($arr[$keys[35]]);
        }
        if (array_key_exists($keys[36], $arr)) {
            $this->set02Click($arr[$keys[36]]);
        }
        if (array_key_exists($keys[37], $arr)) {
            $this->set03Click($arr[$keys[37]]);
        }
        if (array_key_exists($keys[38], $arr)) {
            $this->set04Click($arr[$keys[38]]);
        }
        if (array_key_exists($keys[39], $arr)) {
            $this->set05Click($arr[$keys[39]]);
        }
        if (array_key_exists($keys[40], $arr)) {
            $this->set06Click($arr[$keys[40]]);
        }
        if (array_key_exists($keys[41], $arr)) {
            $this->set07Click($arr[$keys[41]]);
        }
        if (array_key_exists($keys[42], $arr)) {
            $this->set08Click($arr[$keys[42]]);
        }
        if (array_key_exists($keys[43], $arr)) {
            $this->set09Click($arr[$keys[43]]);
        }
        if (array_key_exists($keys[44], $arr)) {
            $this->set10Click($arr[$keys[44]]);
        }
        if (array_key_exists($keys[45], $arr)) {
            $this->set11Click($arr[$keys[45]]);
        }
        if (array_key_exists($keys[46], $arr)) {
            $this->set12Click($arr[$keys[46]]);
        }
        if (array_key_exists($keys[47], $arr)) {
            $this->set13Click($arr[$keys[47]]);
        }
        if (array_key_exists($keys[48], $arr)) {
            $this->set14Click($arr[$keys[48]]);
        }
        if (array_key_exists($keys[49], $arr)) {
            $this->set15Click($arr[$keys[49]]);
        }
        if (array_key_exists($keys[50], $arr)) {
            $this->set16Click($arr[$keys[50]]);
        }
        if (array_key_exists($keys[51], $arr)) {
            $this->set17Click($arr[$keys[51]]);
        }
        if (array_key_exists($keys[52], $arr)) {
            $this->set18Click($arr[$keys[52]]);
        }
        if (array_key_exists($keys[53], $arr)) {
            $this->set19Click($arr[$keys[53]]);
        }
        if (array_key_exists($keys[54], $arr)) {
            $this->set20Click($arr[$keys[54]]);
        }
        if (array_key_exists($keys[55], $arr)) {
            $this->set21Click($arr[$keys[55]]);
        }
        if (array_key_exists($keys[56], $arr)) {
            $this->set22Click($arr[$keys[56]]);
        }
        if (array_key_exists($keys[57], $arr)) {
            $this->set23Click($arr[$keys[57]]);
        }
        if (array_key_exists($keys[58], $arr)) {
            $this->set24Click($arr[$keys[58]]);
        }
        if (array_key_exists($keys[59], $arr)) {
            $this->set25Click($arr[$keys[59]]);
        }
        if (array_key_exists($keys[60], $arr)) {
            $this->set26Click($arr[$keys[60]]);
        }
        if (array_key_exists($keys[61], $arr)) {
            $this->set27Click($arr[$keys[61]]);
        }
        if (array_key_exists($keys[62], $arr)) {
            $this->set28Click($arr[$keys[62]]);
        }
        if (array_key_exists($keys[63], $arr)) {
            $this->set29Click($arr[$keys[63]]);
        }
        if (array_key_exists($keys[64], $arr)) {
            $this->set30Click($arr[$keys[64]]);
        }
        if (array_key_exists($keys[65], $arr)) {
            $this->set31Click($arr[$keys[65]]);
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
     * @return $this|\Hotspot\AccessPointBundle\Model\ApReport The current object, for fluid interface
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
        $criteria = new Criteria(ApReportTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ApReportTableMap::COL_ID)) {
            $criteria->add(ApReportTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_AP_MACADDR)) {
            $criteria->add(ApReportTableMap::COL_AP_MACADDR, $this->ap_macaddr);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_YEAR)) {
            $criteria->add(ApReportTableMap::COL_YEAR, $this->year);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_MONTH)) {
            $criteria->add(ApReportTableMap::COL_MONTH, $this->month);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_01)) {
            $criteria->add(ApReportTableMap::COL_01, $this->01);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_02)) {
            $criteria->add(ApReportTableMap::COL_02, $this->02);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_03)) {
            $criteria->add(ApReportTableMap::COL_03, $this->03);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_04)) {
            $criteria->add(ApReportTableMap::COL_04, $this->04);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_05)) {
            $criteria->add(ApReportTableMap::COL_05, $this->05);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_06)) {
            $criteria->add(ApReportTableMap::COL_06, $this->06);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_07)) {
            $criteria->add(ApReportTableMap::COL_07, $this->07);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_08)) {
            $criteria->add(ApReportTableMap::COL_08, $this->08);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_09)) {
            $criteria->add(ApReportTableMap::COL_09, $this->09);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_10)) {
            $criteria->add(ApReportTableMap::COL_10, $this->10);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_11)) {
            $criteria->add(ApReportTableMap::COL_11, $this->11);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_12)) {
            $criteria->add(ApReportTableMap::COL_12, $this->12);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_13)) {
            $criteria->add(ApReportTableMap::COL_13, $this->13);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_14)) {
            $criteria->add(ApReportTableMap::COL_14, $this->14);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_15)) {
            $criteria->add(ApReportTableMap::COL_15, $this->15);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_16)) {
            $criteria->add(ApReportTableMap::COL_16, $this->16);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_17)) {
            $criteria->add(ApReportTableMap::COL_17, $this->17);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_18)) {
            $criteria->add(ApReportTableMap::COL_18, $this->18);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_19)) {
            $criteria->add(ApReportTableMap::COL_19, $this->19);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_20)) {
            $criteria->add(ApReportTableMap::COL_20, $this->20);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_21)) {
            $criteria->add(ApReportTableMap::COL_21, $this->21);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_22)) {
            $criteria->add(ApReportTableMap::COL_22, $this->22);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_23)) {
            $criteria->add(ApReportTableMap::COL_23, $this->23);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_24)) {
            $criteria->add(ApReportTableMap::COL_24, $this->24);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_25)) {
            $criteria->add(ApReportTableMap::COL_25, $this->25);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_26)) {
            $criteria->add(ApReportTableMap::COL_26, $this->26);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_27)) {
            $criteria->add(ApReportTableMap::COL_27, $this->27);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_28)) {
            $criteria->add(ApReportTableMap::COL_28, $this->28);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_29)) {
            $criteria->add(ApReportTableMap::COL_29, $this->29);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_30)) {
            $criteria->add(ApReportTableMap::COL_30, $this->30);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_31)) {
            $criteria->add(ApReportTableMap::COL_31, $this->31);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_01_CLICK)) {
            $criteria->add(ApReportTableMap::COL_01_CLICK, $this->01_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_02_CLICK)) {
            $criteria->add(ApReportTableMap::COL_02_CLICK, $this->02_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_03_CLICK)) {
            $criteria->add(ApReportTableMap::COL_03_CLICK, $this->03_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_04_CLICK)) {
            $criteria->add(ApReportTableMap::COL_04_CLICK, $this->04_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_05_CLICK)) {
            $criteria->add(ApReportTableMap::COL_05_CLICK, $this->05_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_06_CLICK)) {
            $criteria->add(ApReportTableMap::COL_06_CLICK, $this->06_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_07_CLICK)) {
            $criteria->add(ApReportTableMap::COL_07_CLICK, $this->07_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_08_CLICK)) {
            $criteria->add(ApReportTableMap::COL_08_CLICK, $this->08_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_09_CLICK)) {
            $criteria->add(ApReportTableMap::COL_09_CLICK, $this->09_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_10_CLICK)) {
            $criteria->add(ApReportTableMap::COL_10_CLICK, $this->10_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_11_CLICK)) {
            $criteria->add(ApReportTableMap::COL_11_CLICK, $this->11_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_12_CLICK)) {
            $criteria->add(ApReportTableMap::COL_12_CLICK, $this->12_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_13_CLICK)) {
            $criteria->add(ApReportTableMap::COL_13_CLICK, $this->13_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_14_CLICK)) {
            $criteria->add(ApReportTableMap::COL_14_CLICK, $this->14_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_15_CLICK)) {
            $criteria->add(ApReportTableMap::COL_15_CLICK, $this->15_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_16_CLICK)) {
            $criteria->add(ApReportTableMap::COL_16_CLICK, $this->16_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_17_CLICK)) {
            $criteria->add(ApReportTableMap::COL_17_CLICK, $this->17_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_18_CLICK)) {
            $criteria->add(ApReportTableMap::COL_18_CLICK, $this->18_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_19_CLICK)) {
            $criteria->add(ApReportTableMap::COL_19_CLICK, $this->19_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_20_CLICK)) {
            $criteria->add(ApReportTableMap::COL_20_CLICK, $this->20_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_21_CLICK)) {
            $criteria->add(ApReportTableMap::COL_21_CLICK, $this->21_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_22_CLICK)) {
            $criteria->add(ApReportTableMap::COL_22_CLICK, $this->22_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_23_CLICK)) {
            $criteria->add(ApReportTableMap::COL_23_CLICK, $this->23_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_24_CLICK)) {
            $criteria->add(ApReportTableMap::COL_24_CLICK, $this->24_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_25_CLICK)) {
            $criteria->add(ApReportTableMap::COL_25_CLICK, $this->25_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_26_CLICK)) {
            $criteria->add(ApReportTableMap::COL_26_CLICK, $this->26_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_27_CLICK)) {
            $criteria->add(ApReportTableMap::COL_27_CLICK, $this->27_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_28_CLICK)) {
            $criteria->add(ApReportTableMap::COL_28_CLICK, $this->28_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_29_CLICK)) {
            $criteria->add(ApReportTableMap::COL_29_CLICK, $this->29_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_30_CLICK)) {
            $criteria->add(ApReportTableMap::COL_30_CLICK, $this->30_click);
        }
        if ($this->isColumnModified(ApReportTableMap::COL_31_CLICK)) {
            $criteria->add(ApReportTableMap::COL_31_CLICK, $this->31_click);
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
        $criteria = ChildApReportQuery::create();
        $criteria->add(ApReportTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Hotspot\AccessPointBundle\Model\ApReport (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setApMacaddr($this->getApMacaddr());
        $copyObj->setYear($this->getYear());
        $copyObj->setMonth($this->getMonth());
        $copyObj->set01($this->get01());
        $copyObj->set02($this->get02());
        $copyObj->set03($this->get03());
        $copyObj->set04($this->get04());
        $copyObj->set05($this->get05());
        $copyObj->set06($this->get06());
        $copyObj->set07($this->get07());
        $copyObj->set08($this->get08());
        $copyObj->set09($this->get09());
        $copyObj->set10($this->get10());
        $copyObj->set11($this->get11());
        $copyObj->set12($this->get12());
        $copyObj->set13($this->get13());
        $copyObj->set14($this->get14());
        $copyObj->set15($this->get15());
        $copyObj->set16($this->get16());
        $copyObj->set17($this->get17());
        $copyObj->set18($this->get18());
        $copyObj->set19($this->get19());
        $copyObj->set20($this->get20());
        $copyObj->set21($this->get21());
        $copyObj->set22($this->get22());
        $copyObj->set23($this->get23());
        $copyObj->set24($this->get24());
        $copyObj->set25($this->get25());
        $copyObj->set26($this->get26());
        $copyObj->set27($this->get27());
        $copyObj->set28($this->get28());
        $copyObj->set29($this->get29());
        $copyObj->set30($this->get30());
        $copyObj->set31($this->get31());
        $copyObj->set01Click($this->get01Click());
        $copyObj->set02Click($this->get02Click());
        $copyObj->set03Click($this->get03Click());
        $copyObj->set04Click($this->get04Click());
        $copyObj->set05Click($this->get05Click());
        $copyObj->set06Click($this->get06Click());
        $copyObj->set07Click($this->get07Click());
        $copyObj->set08Click($this->get08Click());
        $copyObj->set09Click($this->get09Click());
        $copyObj->set10Click($this->get10Click());
        $copyObj->set11Click($this->get11Click());
        $copyObj->set12Click($this->get12Click());
        $copyObj->set13Click($this->get13Click());
        $copyObj->set14Click($this->get14Click());
        $copyObj->set15Click($this->get15Click());
        $copyObj->set16Click($this->get16Click());
        $copyObj->set17Click($this->get17Click());
        $copyObj->set18Click($this->get18Click());
        $copyObj->set19Click($this->get19Click());
        $copyObj->set20Click($this->get20Click());
        $copyObj->set21Click($this->get21Click());
        $copyObj->set22Click($this->get22Click());
        $copyObj->set23Click($this->get23Click());
        $copyObj->set24Click($this->get24Click());
        $copyObj->set25Click($this->get25Click());
        $copyObj->set26Click($this->get26Click());
        $copyObj->set27Click($this->get27Click());
        $copyObj->set28Click($this->get28Click());
        $copyObj->set29Click($this->get29Click());
        $copyObj->set30Click($this->get30Click());
        $copyObj->set31Click($this->get31Click());
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
     * @return \Hotspot\AccessPointBundle\Model\ApReport Clone of current object.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->ap_macaddr = null;
        $this->year = null;
        $this->month = null;
        $this->01 = null;
        $this->02 = null;
        $this->03 = null;
        $this->04 = null;
        $this->05 = null;
        $this->06 = null;
        $this->07 = null;
        $this->08 = null;
        $this->09 = null;
        $this->10 = null;
        $this->11 = null;
        $this->12 = null;
        $this->13 = null;
        $this->14 = null;
        $this->15 = null;
        $this->16 = null;
        $this->17 = null;
        $this->18 = null;
        $this->19 = null;
        $this->20 = null;
        $this->21 = null;
        $this->22 = null;
        $this->23 = null;
        $this->24 = null;
        $this->25 = null;
        $this->26 = null;
        $this->27 = null;
        $this->28 = null;
        $this->29 = null;
        $this->30 = null;
        $this->31 = null;
        $this->01_click = null;
        $this->02_click = null;
        $this->03_click = null;
        $this->04_click = null;
        $this->05_click = null;
        $this->06_click = null;
        $this->07_click = null;
        $this->08_click = null;
        $this->09_click = null;
        $this->10_click = null;
        $this->11_click = null;
        $this->12_click = null;
        $this->13_click = null;
        $this->14_click = null;
        $this->15_click = null;
        $this->16_click = null;
        $this->17_click = null;
        $this->18_click = null;
        $this->19_click = null;
        $this->20_click = null;
        $this->21_click = null;
        $this->22_click = null;
        $this->23_click = null;
        $this->24_click = null;
        $this->25_click = null;
        $this->26_click = null;
        $this->27_click = null;
        $this->28_click = null;
        $this->29_click = null;
        $this->30_click = null;
        $this->31_click = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
        } // if ($deep)

    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ApReportTableMap::DEFAULT_STRING_FORMAT);
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
