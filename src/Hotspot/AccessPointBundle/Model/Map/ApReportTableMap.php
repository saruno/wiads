<?php

namespace Hotspot\AccessPointBundle\Model\Map;

use Hotspot\AccessPointBundle\Model\ApReport;
use Hotspot\AccessPointBundle\Model\ApReportQuery;
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
 * This class defines the structure of the 'ap_report' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ApReportTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Hotspot.AccessPointBundle.Model.Map.ApReportTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'ap_report';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Hotspot\\AccessPointBundle\\Model\\ApReport';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.Hotspot.AccessPointBundle.Model.ApReport';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 66;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 66;

    /**
     * the column name for the id field
     */
    const COL_ID = 'ap_report.id';

    /**
     * the column name for the ap_macaddr field
     */
    const COL_AP_MACADDR = 'ap_report.ap_macaddr';

    /**
     * the column name for the year field
     */
    const COL_YEAR = 'ap_report.year';

    /**
     * the column name for the month field
     */
    const COL_MONTH = 'ap_report.month';

    /**
     * the column name for the 01 field
     */
    const COL_01 = 'ap_report.01';

    /**
     * the column name for the 02 field
     */
    const COL_02 = 'ap_report.02';

    /**
     * the column name for the 03 field
     */
    const COL_03 = 'ap_report.03';

    /**
     * the column name for the 04 field
     */
    const COL_04 = 'ap_report.04';

    /**
     * the column name for the 05 field
     */
    const COL_05 = 'ap_report.05';

    /**
     * the column name for the 06 field
     */
    const COL_06 = 'ap_report.06';

    /**
     * the column name for the 07 field
     */
    const COL_07 = 'ap_report.07';

    /**
     * the column name for the 08 field
     */
    const COL_08 = 'ap_report.08';

    /**
     * the column name for the 09 field
     */
    const COL_09 = 'ap_report.09';

    /**
     * the column name for the 10 field
     */
    const COL_10 = 'ap_report.10';

    /**
     * the column name for the 11 field
     */
    const COL_11 = 'ap_report.11';

    /**
     * the column name for the 12 field
     */
    const COL_12 = 'ap_report.12';

    /**
     * the column name for the 13 field
     */
    const COL_13 = 'ap_report.13';

    /**
     * the column name for the 14 field
     */
    const COL_14 = 'ap_report.14';

    /**
     * the column name for the 15 field
     */
    const COL_15 = 'ap_report.15';

    /**
     * the column name for the 16 field
     */
    const COL_16 = 'ap_report.16';

    /**
     * the column name for the 17 field
     */
    const COL_17 = 'ap_report.17';

    /**
     * the column name for the 18 field
     */
    const COL_18 = 'ap_report.18';

    /**
     * the column name for the 19 field
     */
    const COL_19 = 'ap_report.19';

    /**
     * the column name for the 20 field
     */
    const COL_20 = 'ap_report.20';

    /**
     * the column name for the 21 field
     */
    const COL_21 = 'ap_report.21';

    /**
     * the column name for the 22 field
     */
    const COL_22 = 'ap_report.22';

    /**
     * the column name for the 23 field
     */
    const COL_23 = 'ap_report.23';

    /**
     * the column name for the 24 field
     */
    const COL_24 = 'ap_report.24';

    /**
     * the column name for the 25 field
     */
    const COL_25 = 'ap_report.25';

    /**
     * the column name for the 26 field
     */
    const COL_26 = 'ap_report.26';

    /**
     * the column name for the 27 field
     */
    const COL_27 = 'ap_report.27';

    /**
     * the column name for the 28 field
     */
    const COL_28 = 'ap_report.28';

    /**
     * the column name for the 29 field
     */
    const COL_29 = 'ap_report.29';

    /**
     * the column name for the 30 field
     */
    const COL_30 = 'ap_report.30';

    /**
     * the column name for the 31 field
     */
    const COL_31 = 'ap_report.31';

    /**
     * the column name for the 01_click field
     */
    const COL_01_CLICK = 'ap_report.01_click';

    /**
     * the column name for the 02_click field
     */
    const COL_02_CLICK = 'ap_report.02_click';

    /**
     * the column name for the 03_click field
     */
    const COL_03_CLICK = 'ap_report.03_click';

    /**
     * the column name for the 04_click field
     */
    const COL_04_CLICK = 'ap_report.04_click';

    /**
     * the column name for the 05_click field
     */
    const COL_05_CLICK = 'ap_report.05_click';

    /**
     * the column name for the 06_click field
     */
    const COL_06_CLICK = 'ap_report.06_click';

    /**
     * the column name for the 07_click field
     */
    const COL_07_CLICK = 'ap_report.07_click';

    /**
     * the column name for the 08_click field
     */
    const COL_08_CLICK = 'ap_report.08_click';

    /**
     * the column name for the 09_click field
     */
    const COL_09_CLICK = 'ap_report.09_click';

    /**
     * the column name for the 10_click field
     */
    const COL_10_CLICK = 'ap_report.10_click';

    /**
     * the column name for the 11_click field
     */
    const COL_11_CLICK = 'ap_report.11_click';

    /**
     * the column name for the 12_click field
     */
    const COL_12_CLICK = 'ap_report.12_click';

    /**
     * the column name for the 13_click field
     */
    const COL_13_CLICK = 'ap_report.13_click';

    /**
     * the column name for the 14_click field
     */
    const COL_14_CLICK = 'ap_report.14_click';

    /**
     * the column name for the 15_click field
     */
    const COL_15_CLICK = 'ap_report.15_click';

    /**
     * the column name for the 16_click field
     */
    const COL_16_CLICK = 'ap_report.16_click';

    /**
     * the column name for the 17_click field
     */
    const COL_17_CLICK = 'ap_report.17_click';

    /**
     * the column name for the 18_click field
     */
    const COL_18_CLICK = 'ap_report.18_click';

    /**
     * the column name for the 19_click field
     */
    const COL_19_CLICK = 'ap_report.19_click';

    /**
     * the column name for the 20_click field
     */
    const COL_20_CLICK = 'ap_report.20_click';

    /**
     * the column name for the 21_click field
     */
    const COL_21_CLICK = 'ap_report.21_click';

    /**
     * the column name for the 22_click field
     */
    const COL_22_CLICK = 'ap_report.22_click';

    /**
     * the column name for the 23_click field
     */
    const COL_23_CLICK = 'ap_report.23_click';

    /**
     * the column name for the 24_click field
     */
    const COL_24_CLICK = 'ap_report.24_click';

    /**
     * the column name for the 25_click field
     */
    const COL_25_CLICK = 'ap_report.25_click';

    /**
     * the column name for the 26_click field
     */
    const COL_26_CLICK = 'ap_report.26_click';

    /**
     * the column name for the 27_click field
     */
    const COL_27_CLICK = 'ap_report.27_click';

    /**
     * the column name for the 28_click field
     */
    const COL_28_CLICK = 'ap_report.28_click';

    /**
     * the column name for the 29_click field
     */
    const COL_29_CLICK = 'ap_report.29_click';

    /**
     * the column name for the 30_click field
     */
    const COL_30_CLICK = 'ap_report.30_click';

    /**
     * the column name for the 31_click field
     */
    const COL_31_CLICK = 'ap_report.31_click';

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
        self::TYPE_PHPNAME       => array('Id', 'ApMacaddr', 'Year', 'Month', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '01Click', '02Click', '03Click', '04Click', '05Click', '06Click', '07Click', '08Click', '09Click', '10Click', '11Click', '12Click', '13Click', '14Click', '15Click', '16Click', '17Click', '18Click', '19Click', '20Click', '21Click', '22Click', '23Click', '24Click', '25Click', '26Click', '27Click', '28Click', '29Click', '30Click', '31Click', ),
        self::TYPE_CAMELNAME     => array('id', 'apMacaddr', 'year', 'month', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '01Click', '02Click', '03Click', '04Click', '05Click', '06Click', '07Click', '08Click', '09Click', '10Click', '11Click', '12Click', '13Click', '14Click', '15Click', '16Click', '17Click', '18Click', '19Click', '20Click', '21Click', '22Click', '23Click', '24Click', '25Click', '26Click', '27Click', '28Click', '29Click', '30Click', '31Click', ),
        self::TYPE_COLNAME       => array(ApReportTableMap::COL_ID, ApReportTableMap::COL_AP_MACADDR, ApReportTableMap::COL_YEAR, ApReportTableMap::COL_MONTH, ApReportTableMap::COL_01, ApReportTableMap::COL_02, ApReportTableMap::COL_03, ApReportTableMap::COL_04, ApReportTableMap::COL_05, ApReportTableMap::COL_06, ApReportTableMap::COL_07, ApReportTableMap::COL_08, ApReportTableMap::COL_09, ApReportTableMap::COL_10, ApReportTableMap::COL_11, ApReportTableMap::COL_12, ApReportTableMap::COL_13, ApReportTableMap::COL_14, ApReportTableMap::COL_15, ApReportTableMap::COL_16, ApReportTableMap::COL_17, ApReportTableMap::COL_18, ApReportTableMap::COL_19, ApReportTableMap::COL_20, ApReportTableMap::COL_21, ApReportTableMap::COL_22, ApReportTableMap::COL_23, ApReportTableMap::COL_24, ApReportTableMap::COL_25, ApReportTableMap::COL_26, ApReportTableMap::COL_27, ApReportTableMap::COL_28, ApReportTableMap::COL_29, ApReportTableMap::COL_30, ApReportTableMap::COL_31, ApReportTableMap::COL_01_CLICK, ApReportTableMap::COL_02_CLICK, ApReportTableMap::COL_03_CLICK, ApReportTableMap::COL_04_CLICK, ApReportTableMap::COL_05_CLICK, ApReportTableMap::COL_06_CLICK, ApReportTableMap::COL_07_CLICK, ApReportTableMap::COL_08_CLICK, ApReportTableMap::COL_09_CLICK, ApReportTableMap::COL_10_CLICK, ApReportTableMap::COL_11_CLICK, ApReportTableMap::COL_12_CLICK, ApReportTableMap::COL_13_CLICK, ApReportTableMap::COL_14_CLICK, ApReportTableMap::COL_15_CLICK, ApReportTableMap::COL_16_CLICK, ApReportTableMap::COL_17_CLICK, ApReportTableMap::COL_18_CLICK, ApReportTableMap::COL_19_CLICK, ApReportTableMap::COL_20_CLICK, ApReportTableMap::COL_21_CLICK, ApReportTableMap::COL_22_CLICK, ApReportTableMap::COL_23_CLICK, ApReportTableMap::COL_24_CLICK, ApReportTableMap::COL_25_CLICK, ApReportTableMap::COL_26_CLICK, ApReportTableMap::COL_27_CLICK, ApReportTableMap::COL_28_CLICK, ApReportTableMap::COL_29_CLICK, ApReportTableMap::COL_30_CLICK, ApReportTableMap::COL_31_CLICK, ),
        self::TYPE_FIELDNAME     => array('id', 'ap_macaddr', 'year', 'month', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '01_click', '02_click', '03_click', '04_click', '05_click', '06_click', '07_click', '08_click', '09_click', '10_click', '11_click', '12_click', '13_click', '14_click', '15_click', '16_click', '17_click', '18_click', '19_click', '20_click', '21_click', '22_click', '23_click', '24_click', '25_click', '26_click', '27_click', '28_click', '29_click', '30_click', '31_click', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ApMacaddr' => 1, 'Year' => 2, 'Month' => 3, '01' => 4, '02' => 5, '03' => 6, '04' => 7, '05' => 8, '06' => 9, '07' => 10, '08' => 11, '09' => 12, '10' => 13, '11' => 14, '12' => 15, '13' => 16, '14' => 17, '15' => 18, '16' => 19, '17' => 20, '18' => 21, '19' => 22, '20' => 23, '21' => 24, '22' => 25, '23' => 26, '24' => 27, '25' => 28, '26' => 29, '27' => 30, '28' => 31, '29' => 32, '30' => 33, '31' => 34, '01Click' => 35, '02Click' => 36, '03Click' => 37, '04Click' => 38, '05Click' => 39, '06Click' => 40, '07Click' => 41, '08Click' => 42, '09Click' => 43, '10Click' => 44, '11Click' => 45, '12Click' => 46, '13Click' => 47, '14Click' => 48, '15Click' => 49, '16Click' => 50, '17Click' => 51, '18Click' => 52, '19Click' => 53, '20Click' => 54, '21Click' => 55, '22Click' => 56, '23Click' => 57, '24Click' => 58, '25Click' => 59, '26Click' => 60, '27Click' => 61, '28Click' => 62, '29Click' => 63, '30Click' => 64, '31Click' => 65, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'apMacaddr' => 1, 'year' => 2, 'month' => 3, '01' => 4, '02' => 5, '03' => 6, '04' => 7, '05' => 8, '06' => 9, '07' => 10, '08' => 11, '09' => 12, '10' => 13, '11' => 14, '12' => 15, '13' => 16, '14' => 17, '15' => 18, '16' => 19, '17' => 20, '18' => 21, '19' => 22, '20' => 23, '21' => 24, '22' => 25, '23' => 26, '24' => 27, '25' => 28, '26' => 29, '27' => 30, '28' => 31, '29' => 32, '30' => 33, '31' => 34, '01Click' => 35, '02Click' => 36, '03Click' => 37, '04Click' => 38, '05Click' => 39, '06Click' => 40, '07Click' => 41, '08Click' => 42, '09Click' => 43, '10Click' => 44, '11Click' => 45, '12Click' => 46, '13Click' => 47, '14Click' => 48, '15Click' => 49, '16Click' => 50, '17Click' => 51, '18Click' => 52, '19Click' => 53, '20Click' => 54, '21Click' => 55, '22Click' => 56, '23Click' => 57, '24Click' => 58, '25Click' => 59, '26Click' => 60, '27Click' => 61, '28Click' => 62, '29Click' => 63, '30Click' => 64, '31Click' => 65, ),
        self::TYPE_COLNAME       => array(ApReportTableMap::COL_ID => 0, ApReportTableMap::COL_AP_MACADDR => 1, ApReportTableMap::COL_YEAR => 2, ApReportTableMap::COL_MONTH => 3, ApReportTableMap::COL_01 => 4, ApReportTableMap::COL_02 => 5, ApReportTableMap::COL_03 => 6, ApReportTableMap::COL_04 => 7, ApReportTableMap::COL_05 => 8, ApReportTableMap::COL_06 => 9, ApReportTableMap::COL_07 => 10, ApReportTableMap::COL_08 => 11, ApReportTableMap::COL_09 => 12, ApReportTableMap::COL_10 => 13, ApReportTableMap::COL_11 => 14, ApReportTableMap::COL_12 => 15, ApReportTableMap::COL_13 => 16, ApReportTableMap::COL_14 => 17, ApReportTableMap::COL_15 => 18, ApReportTableMap::COL_16 => 19, ApReportTableMap::COL_17 => 20, ApReportTableMap::COL_18 => 21, ApReportTableMap::COL_19 => 22, ApReportTableMap::COL_20 => 23, ApReportTableMap::COL_21 => 24, ApReportTableMap::COL_22 => 25, ApReportTableMap::COL_23 => 26, ApReportTableMap::COL_24 => 27, ApReportTableMap::COL_25 => 28, ApReportTableMap::COL_26 => 29, ApReportTableMap::COL_27 => 30, ApReportTableMap::COL_28 => 31, ApReportTableMap::COL_29 => 32, ApReportTableMap::COL_30 => 33, ApReportTableMap::COL_31 => 34, ApReportTableMap::COL_01_CLICK => 35, ApReportTableMap::COL_02_CLICK => 36, ApReportTableMap::COL_03_CLICK => 37, ApReportTableMap::COL_04_CLICK => 38, ApReportTableMap::COL_05_CLICK => 39, ApReportTableMap::COL_06_CLICK => 40, ApReportTableMap::COL_07_CLICK => 41, ApReportTableMap::COL_08_CLICK => 42, ApReportTableMap::COL_09_CLICK => 43, ApReportTableMap::COL_10_CLICK => 44, ApReportTableMap::COL_11_CLICK => 45, ApReportTableMap::COL_12_CLICK => 46, ApReportTableMap::COL_13_CLICK => 47, ApReportTableMap::COL_14_CLICK => 48, ApReportTableMap::COL_15_CLICK => 49, ApReportTableMap::COL_16_CLICK => 50, ApReportTableMap::COL_17_CLICK => 51, ApReportTableMap::COL_18_CLICK => 52, ApReportTableMap::COL_19_CLICK => 53, ApReportTableMap::COL_20_CLICK => 54, ApReportTableMap::COL_21_CLICK => 55, ApReportTableMap::COL_22_CLICK => 56, ApReportTableMap::COL_23_CLICK => 57, ApReportTableMap::COL_24_CLICK => 58, ApReportTableMap::COL_25_CLICK => 59, ApReportTableMap::COL_26_CLICK => 60, ApReportTableMap::COL_27_CLICK => 61, ApReportTableMap::COL_28_CLICK => 62, ApReportTableMap::COL_29_CLICK => 63, ApReportTableMap::COL_30_CLICK => 64, ApReportTableMap::COL_31_CLICK => 65, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'ap_macaddr' => 1, 'year' => 2, 'month' => 3, '01' => 4, '02' => 5, '03' => 6, '04' => 7, '05' => 8, '06' => 9, '07' => 10, '08' => 11, '09' => 12, '10' => 13, '11' => 14, '12' => 15, '13' => 16, '14' => 17, '15' => 18, '16' => 19, '17' => 20, '18' => 21, '19' => 22, '20' => 23, '21' => 24, '22' => 25, '23' => 26, '24' => 27, '25' => 28, '26' => 29, '27' => 30, '28' => 31, '29' => 32, '30' => 33, '31' => 34, '01_click' => 35, '02_click' => 36, '03_click' => 37, '04_click' => 38, '05_click' => 39, '06_click' => 40, '07_click' => 41, '08_click' => 42, '09_click' => 43, '10_click' => 44, '11_click' => 45, '12_click' => 46, '13_click' => 47, '14_click' => 48, '15_click' => 49, '16_click' => 50, '17_click' => 51, '18_click' => 52, '19_click' => 53, '20_click' => 54, '21_click' => 55, '22_click' => 56, '23_click' => 57, '24_click' => 58, '25_click' => 59, '26_click' => 60, '27_click' => 61, '28_click' => 62, '29_click' => 63, '30_click' => 64, '31_click' => 65, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, )
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
        $this->setName('ap_report');
        $this->setPhpName('ApReport');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Hotspot\\AccessPointBundle\\Model\\ApReport');
        $this->setPackage('src.Hotspot.AccessPointBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('ap_macaddr', 'ApMacaddr', 'VARCHAR', false, 50, null);
        $this->addColumn('year', 'Year', 'INTEGER', false, null, 0);
        $this->addColumn('month', 'Month', 'INTEGER', false, null, 0);
        $this->addColumn('01', '01', 'VARCHAR', false, 50, '0');
        $this->addColumn('02', '02', 'VARCHAR', false, 50, '0');
        $this->addColumn('03', '03', 'VARCHAR', false, 50, '0');
        $this->addColumn('04', '04', 'VARCHAR', false, 50, '0');
        $this->addColumn('05', '05', 'VARCHAR', false, 50, '0');
        $this->addColumn('06', '06', 'VARCHAR', false, 50, '0');
        $this->addColumn('07', '07', 'VARCHAR', false, 50, '0');
        $this->addColumn('08', '08', 'VARCHAR', false, 50, '0');
        $this->addColumn('09', '09', 'VARCHAR', false, 50, '0');
        $this->addColumn('10', '10', 'VARCHAR', false, 50, '0');
        $this->addColumn('11', '11', 'VARCHAR', false, 50, '0');
        $this->addColumn('12', '12', 'VARCHAR', false, 50, '0');
        $this->addColumn('13', '13', 'VARCHAR', false, 50, '0');
        $this->addColumn('14', '14', 'VARCHAR', false, 50, '0');
        $this->addColumn('15', '15', 'VARCHAR', false, 50, '0');
        $this->addColumn('16', '16', 'VARCHAR', false, 50, '0');
        $this->addColumn('17', '17', 'VARCHAR', false, 50, '0');
        $this->addColumn('18', '18', 'VARCHAR', false, 50, '0');
        $this->addColumn('19', '19', 'VARCHAR', false, 50, '0');
        $this->addColumn('20', '20', 'VARCHAR', false, 50, '0');
        $this->addColumn('21', '21', 'VARCHAR', false, 50, '0');
        $this->addColumn('22', '22', 'VARCHAR', false, 50, '0');
        $this->addColumn('23', '23', 'VARCHAR', false, 50, '0');
        $this->addColumn('24', '24', 'VARCHAR', false, 50, '0');
        $this->addColumn('25', '25', 'VARCHAR', false, 50, '0');
        $this->addColumn('26', '26', 'VARCHAR', false, 50, '0');
        $this->addColumn('27', '27', 'VARCHAR', false, 50, '0');
        $this->addColumn('28', '28', 'VARCHAR', false, 50, '0');
        $this->addColumn('29', '29', 'VARCHAR', false, 50, '0');
        $this->addColumn('30', '30', 'VARCHAR', false, 50, '0');
        $this->addColumn('31', '31', 'VARCHAR', false, 50, '0');
        $this->addColumn('01_click', '01Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('02_click', '02Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('03_click', '03Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('04_click', '04Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('05_click', '05Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('06_click', '06Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('07_click', '07Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('08_click', '08Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('09_click', '09Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('10_click', '10Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('11_click', '11Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('12_click', '12Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('13_click', '13Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('14_click', '14Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('15_click', '15Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('16_click', '16Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('17_click', '17Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('18_click', '18Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('19_click', '19Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('20_click', '20Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('21_click', '21Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('22_click', '22Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('23_click', '23Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('24_click', '24Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('25_click', '25Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('26_click', '26Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('27_click', '27Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('28_click', '28Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('29_click', '29Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('30_click', '30Click', 'VARCHAR', false, 50, '0');
        $this->addColumn('31_click', '31Click', 'VARCHAR', false, 50, '0');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

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
        return $withPrefix ? ApReportTableMap::CLASS_DEFAULT : ApReportTableMap::OM_CLASS;
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
     * @return array           (ApReport object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ApReportTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ApReportTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ApReportTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ApReportTableMap::OM_CLASS;
            /** @var ApReport $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ApReportTableMap::addInstanceToPool($obj, $key);
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
            $key = ApReportTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ApReportTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ApReport $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ApReportTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ApReportTableMap::COL_ID);
            $criteria->addSelectColumn(ApReportTableMap::COL_AP_MACADDR);
            $criteria->addSelectColumn(ApReportTableMap::COL_YEAR);
            $criteria->addSelectColumn(ApReportTableMap::COL_MONTH);
            $criteria->addSelectColumn(ApReportTableMap::COL_01);
            $criteria->addSelectColumn(ApReportTableMap::COL_02);
            $criteria->addSelectColumn(ApReportTableMap::COL_03);
            $criteria->addSelectColumn(ApReportTableMap::COL_04);
            $criteria->addSelectColumn(ApReportTableMap::COL_05);
            $criteria->addSelectColumn(ApReportTableMap::COL_06);
            $criteria->addSelectColumn(ApReportTableMap::COL_07);
            $criteria->addSelectColumn(ApReportTableMap::COL_08);
            $criteria->addSelectColumn(ApReportTableMap::COL_09);
            $criteria->addSelectColumn(ApReportTableMap::COL_10);
            $criteria->addSelectColumn(ApReportTableMap::COL_11);
            $criteria->addSelectColumn(ApReportTableMap::COL_12);
            $criteria->addSelectColumn(ApReportTableMap::COL_13);
            $criteria->addSelectColumn(ApReportTableMap::COL_14);
            $criteria->addSelectColumn(ApReportTableMap::COL_15);
            $criteria->addSelectColumn(ApReportTableMap::COL_16);
            $criteria->addSelectColumn(ApReportTableMap::COL_17);
            $criteria->addSelectColumn(ApReportTableMap::COL_18);
            $criteria->addSelectColumn(ApReportTableMap::COL_19);
            $criteria->addSelectColumn(ApReportTableMap::COL_20);
            $criteria->addSelectColumn(ApReportTableMap::COL_21);
            $criteria->addSelectColumn(ApReportTableMap::COL_22);
            $criteria->addSelectColumn(ApReportTableMap::COL_23);
            $criteria->addSelectColumn(ApReportTableMap::COL_24);
            $criteria->addSelectColumn(ApReportTableMap::COL_25);
            $criteria->addSelectColumn(ApReportTableMap::COL_26);
            $criteria->addSelectColumn(ApReportTableMap::COL_27);
            $criteria->addSelectColumn(ApReportTableMap::COL_28);
            $criteria->addSelectColumn(ApReportTableMap::COL_29);
            $criteria->addSelectColumn(ApReportTableMap::COL_30);
            $criteria->addSelectColumn(ApReportTableMap::COL_31);
            $criteria->addSelectColumn(ApReportTableMap::COL_01_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_02_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_03_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_04_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_05_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_06_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_07_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_08_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_09_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_10_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_11_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_12_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_13_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_14_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_15_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_16_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_17_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_18_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_19_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_20_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_21_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_22_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_23_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_24_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_25_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_26_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_27_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_28_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_29_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_30_CLICK);
            $criteria->addSelectColumn(ApReportTableMap::COL_31_CLICK);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.ap_macaddr');
            $criteria->addSelectColumn($alias . '.year');
            $criteria->addSelectColumn($alias . '.month');
            $criteria->addSelectColumn($alias . '.01');
            $criteria->addSelectColumn($alias . '.02');
            $criteria->addSelectColumn($alias . '.03');
            $criteria->addSelectColumn($alias . '.04');
            $criteria->addSelectColumn($alias . '.05');
            $criteria->addSelectColumn($alias . '.06');
            $criteria->addSelectColumn($alias . '.07');
            $criteria->addSelectColumn($alias . '.08');
            $criteria->addSelectColumn($alias . '.09');
            $criteria->addSelectColumn($alias . '.10');
            $criteria->addSelectColumn($alias . '.11');
            $criteria->addSelectColumn($alias . '.12');
            $criteria->addSelectColumn($alias . '.13');
            $criteria->addSelectColumn($alias . '.14');
            $criteria->addSelectColumn($alias . '.15');
            $criteria->addSelectColumn($alias . '.16');
            $criteria->addSelectColumn($alias . '.17');
            $criteria->addSelectColumn($alias . '.18');
            $criteria->addSelectColumn($alias . '.19');
            $criteria->addSelectColumn($alias . '.20');
            $criteria->addSelectColumn($alias . '.21');
            $criteria->addSelectColumn($alias . '.22');
            $criteria->addSelectColumn($alias . '.23');
            $criteria->addSelectColumn($alias . '.24');
            $criteria->addSelectColumn($alias . '.25');
            $criteria->addSelectColumn($alias . '.26');
            $criteria->addSelectColumn($alias . '.27');
            $criteria->addSelectColumn($alias . '.28');
            $criteria->addSelectColumn($alias . '.29');
            $criteria->addSelectColumn($alias . '.30');
            $criteria->addSelectColumn($alias . '.31');
            $criteria->addSelectColumn($alias . '.01_click');
            $criteria->addSelectColumn($alias . '.02_click');
            $criteria->addSelectColumn($alias . '.03_click');
            $criteria->addSelectColumn($alias . '.04_click');
            $criteria->addSelectColumn($alias . '.05_click');
            $criteria->addSelectColumn($alias . '.06_click');
            $criteria->addSelectColumn($alias . '.07_click');
            $criteria->addSelectColumn($alias . '.08_click');
            $criteria->addSelectColumn($alias . '.09_click');
            $criteria->addSelectColumn($alias . '.10_click');
            $criteria->addSelectColumn($alias . '.11_click');
            $criteria->addSelectColumn($alias . '.12_click');
            $criteria->addSelectColumn($alias . '.13_click');
            $criteria->addSelectColumn($alias . '.14_click');
            $criteria->addSelectColumn($alias . '.15_click');
            $criteria->addSelectColumn($alias . '.16_click');
            $criteria->addSelectColumn($alias . '.17_click');
            $criteria->addSelectColumn($alias . '.18_click');
            $criteria->addSelectColumn($alias . '.19_click');
            $criteria->addSelectColumn($alias . '.20_click');
            $criteria->addSelectColumn($alias . '.21_click');
            $criteria->addSelectColumn($alias . '.22_click');
            $criteria->addSelectColumn($alias . '.23_click');
            $criteria->addSelectColumn($alias . '.24_click');
            $criteria->addSelectColumn($alias . '.25_click');
            $criteria->addSelectColumn($alias . '.26_click');
            $criteria->addSelectColumn($alias . '.27_click');
            $criteria->addSelectColumn($alias . '.28_click');
            $criteria->addSelectColumn($alias . '.29_click');
            $criteria->addSelectColumn($alias . '.30_click');
            $criteria->addSelectColumn($alias . '.31_click');
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
        return Propel::getServiceContainer()->getDatabaseMap(ApReportTableMap::DATABASE_NAME)->getTable(ApReportTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ApReportTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ApReportTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ApReportTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ApReport or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ApReport object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ApReportTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Hotspot\AccessPointBundle\Model\ApReport) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ApReportTableMap::DATABASE_NAME);
            $criteria->add(ApReportTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ApReportQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ApReportTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ApReportTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ap_report table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ApReportQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ApReport or Criteria object.
     *
     * @param mixed               $criteria Criteria or ApReport object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApReportTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ApReport object
        }

        if ($criteria->containsKey(ApReportTableMap::COL_ID) && $criteria->keyContainsValue(ApReportTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ApReportTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ApReportQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ApReportTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ApReportTableMap::buildTableMap();
