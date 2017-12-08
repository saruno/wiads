<?php

namespace Hotspot\AccessPointBundle\Model\Base;

use \Exception;
use \PDO;
use Hotspot\AccessPointBundle\Model\ApReport as ChildApReport;
use Hotspot\AccessPointBundle\Model\ApReportQuery as ChildApReportQuery;
use Hotspot\AccessPointBundle\Model\Map\ApReportTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ap_report' table.
 *
 *
 *
 * @method     ChildApReportQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildApReportQuery orderByApMacaddr($order = Criteria::ASC) Order by the ap_macaddr column
 * @method     ChildApReportQuery orderByYear($order = Criteria::ASC) Order by the year column
 * @method     ChildApReportQuery orderByMonth($order = Criteria::ASC) Order by the month column
 * @method     ChildApReportQuery orderBy01($order = Criteria::ASC) Order by the 01 column
 * @method     ChildApReportQuery orderBy02($order = Criteria::ASC) Order by the 02 column
 * @method     ChildApReportQuery orderBy03($order = Criteria::ASC) Order by the 03 column
 * @method     ChildApReportQuery orderBy04($order = Criteria::ASC) Order by the 04 column
 * @method     ChildApReportQuery orderBy05($order = Criteria::ASC) Order by the 05 column
 * @method     ChildApReportQuery orderBy06($order = Criteria::ASC) Order by the 06 column
 * @method     ChildApReportQuery orderBy07($order = Criteria::ASC) Order by the 07 column
 * @method     ChildApReportQuery orderBy08($order = Criteria::ASC) Order by the 08 column
 * @method     ChildApReportQuery orderBy09($order = Criteria::ASC) Order by the 09 column
 * @method     ChildApReportQuery orderBy10($order = Criteria::ASC) Order by the 10 column
 * @method     ChildApReportQuery orderBy11($order = Criteria::ASC) Order by the 11 column
 * @method     ChildApReportQuery orderBy12($order = Criteria::ASC) Order by the 12 column
 * @method     ChildApReportQuery orderBy13($order = Criteria::ASC) Order by the 13 column
 * @method     ChildApReportQuery orderBy14($order = Criteria::ASC) Order by the 14 column
 * @method     ChildApReportQuery orderBy15($order = Criteria::ASC) Order by the 15 column
 * @method     ChildApReportQuery orderBy16($order = Criteria::ASC) Order by the 16 column
 * @method     ChildApReportQuery orderBy17($order = Criteria::ASC) Order by the 17 column
 * @method     ChildApReportQuery orderBy18($order = Criteria::ASC) Order by the 18 column
 * @method     ChildApReportQuery orderBy19($order = Criteria::ASC) Order by the 19 column
 * @method     ChildApReportQuery orderBy20($order = Criteria::ASC) Order by the 20 column
 * @method     ChildApReportQuery orderBy21($order = Criteria::ASC) Order by the 21 column
 * @method     ChildApReportQuery orderBy22($order = Criteria::ASC) Order by the 22 column
 * @method     ChildApReportQuery orderBy23($order = Criteria::ASC) Order by the 23 column
 * @method     ChildApReportQuery orderBy24($order = Criteria::ASC) Order by the 24 column
 * @method     ChildApReportQuery orderBy25($order = Criteria::ASC) Order by the 25 column
 * @method     ChildApReportQuery orderBy26($order = Criteria::ASC) Order by the 26 column
 * @method     ChildApReportQuery orderBy27($order = Criteria::ASC) Order by the 27 column
 * @method     ChildApReportQuery orderBy28($order = Criteria::ASC) Order by the 28 column
 * @method     ChildApReportQuery orderBy29($order = Criteria::ASC) Order by the 29 column
 * @method     ChildApReportQuery orderBy30($order = Criteria::ASC) Order by the 30 column
 * @method     ChildApReportQuery orderBy31($order = Criteria::ASC) Order by the 31 column
 * @method     ChildApReportQuery orderBy01Click($order = Criteria::ASC) Order by the 01_click column
 * @method     ChildApReportQuery orderBy02Click($order = Criteria::ASC) Order by the 02_click column
 * @method     ChildApReportQuery orderBy03Click($order = Criteria::ASC) Order by the 03_click column
 * @method     ChildApReportQuery orderBy04Click($order = Criteria::ASC) Order by the 04_click column
 * @method     ChildApReportQuery orderBy05Click($order = Criteria::ASC) Order by the 05_click column
 * @method     ChildApReportQuery orderBy06Click($order = Criteria::ASC) Order by the 06_click column
 * @method     ChildApReportQuery orderBy07Click($order = Criteria::ASC) Order by the 07_click column
 * @method     ChildApReportQuery orderBy08Click($order = Criteria::ASC) Order by the 08_click column
 * @method     ChildApReportQuery orderBy09Click($order = Criteria::ASC) Order by the 09_click column
 * @method     ChildApReportQuery orderBy10Click($order = Criteria::ASC) Order by the 10_click column
 * @method     ChildApReportQuery orderBy11Click($order = Criteria::ASC) Order by the 11_click column
 * @method     ChildApReportQuery orderBy12Click($order = Criteria::ASC) Order by the 12_click column
 * @method     ChildApReportQuery orderBy13Click($order = Criteria::ASC) Order by the 13_click column
 * @method     ChildApReportQuery orderBy14Click($order = Criteria::ASC) Order by the 14_click column
 * @method     ChildApReportQuery orderBy15Click($order = Criteria::ASC) Order by the 15_click column
 * @method     ChildApReportQuery orderBy16Click($order = Criteria::ASC) Order by the 16_click column
 * @method     ChildApReportQuery orderBy17Click($order = Criteria::ASC) Order by the 17_click column
 * @method     ChildApReportQuery orderBy18Click($order = Criteria::ASC) Order by the 18_click column
 * @method     ChildApReportQuery orderBy19Click($order = Criteria::ASC) Order by the 19_click column
 * @method     ChildApReportQuery orderBy20Click($order = Criteria::ASC) Order by the 20_click column
 * @method     ChildApReportQuery orderBy21Click($order = Criteria::ASC) Order by the 21_click column
 * @method     ChildApReportQuery orderBy22Click($order = Criteria::ASC) Order by the 22_click column
 * @method     ChildApReportQuery orderBy23Click($order = Criteria::ASC) Order by the 23_click column
 * @method     ChildApReportQuery orderBy24Click($order = Criteria::ASC) Order by the 24_click column
 * @method     ChildApReportQuery orderBy25Click($order = Criteria::ASC) Order by the 25_click column
 * @method     ChildApReportQuery orderBy26Click($order = Criteria::ASC) Order by the 26_click column
 * @method     ChildApReportQuery orderBy27Click($order = Criteria::ASC) Order by the 27_click column
 * @method     ChildApReportQuery orderBy28Click($order = Criteria::ASC) Order by the 28_click column
 * @method     ChildApReportQuery orderBy29Click($order = Criteria::ASC) Order by the 29_click column
 * @method     ChildApReportQuery orderBy30Click($order = Criteria::ASC) Order by the 30_click column
 * @method     ChildApReportQuery orderBy31Click($order = Criteria::ASC) Order by the 31_click column
 *
 * @method     ChildApReportQuery groupById() Group by the id column
 * @method     ChildApReportQuery groupByApMacaddr() Group by the ap_macaddr column
 * @method     ChildApReportQuery groupByYear() Group by the year column
 * @method     ChildApReportQuery groupByMonth() Group by the month column
 * @method     ChildApReportQuery groupBy01() Group by the 01 column
 * @method     ChildApReportQuery groupBy02() Group by the 02 column
 * @method     ChildApReportQuery groupBy03() Group by the 03 column
 * @method     ChildApReportQuery groupBy04() Group by the 04 column
 * @method     ChildApReportQuery groupBy05() Group by the 05 column
 * @method     ChildApReportQuery groupBy06() Group by the 06 column
 * @method     ChildApReportQuery groupBy07() Group by the 07 column
 * @method     ChildApReportQuery groupBy08() Group by the 08 column
 * @method     ChildApReportQuery groupBy09() Group by the 09 column
 * @method     ChildApReportQuery groupBy10() Group by the 10 column
 * @method     ChildApReportQuery groupBy11() Group by the 11 column
 * @method     ChildApReportQuery groupBy12() Group by the 12 column
 * @method     ChildApReportQuery groupBy13() Group by the 13 column
 * @method     ChildApReportQuery groupBy14() Group by the 14 column
 * @method     ChildApReportQuery groupBy15() Group by the 15 column
 * @method     ChildApReportQuery groupBy16() Group by the 16 column
 * @method     ChildApReportQuery groupBy17() Group by the 17 column
 * @method     ChildApReportQuery groupBy18() Group by the 18 column
 * @method     ChildApReportQuery groupBy19() Group by the 19 column
 * @method     ChildApReportQuery groupBy20() Group by the 20 column
 * @method     ChildApReportQuery groupBy21() Group by the 21 column
 * @method     ChildApReportQuery groupBy22() Group by the 22 column
 * @method     ChildApReportQuery groupBy23() Group by the 23 column
 * @method     ChildApReportQuery groupBy24() Group by the 24 column
 * @method     ChildApReportQuery groupBy25() Group by the 25 column
 * @method     ChildApReportQuery groupBy26() Group by the 26 column
 * @method     ChildApReportQuery groupBy27() Group by the 27 column
 * @method     ChildApReportQuery groupBy28() Group by the 28 column
 * @method     ChildApReportQuery groupBy29() Group by the 29 column
 * @method     ChildApReportQuery groupBy30() Group by the 30 column
 * @method     ChildApReportQuery groupBy31() Group by the 31 column
 * @method     ChildApReportQuery groupBy01Click() Group by the 01_click column
 * @method     ChildApReportQuery groupBy02Click() Group by the 02_click column
 * @method     ChildApReportQuery groupBy03Click() Group by the 03_click column
 * @method     ChildApReportQuery groupBy04Click() Group by the 04_click column
 * @method     ChildApReportQuery groupBy05Click() Group by the 05_click column
 * @method     ChildApReportQuery groupBy06Click() Group by the 06_click column
 * @method     ChildApReportQuery groupBy07Click() Group by the 07_click column
 * @method     ChildApReportQuery groupBy08Click() Group by the 08_click column
 * @method     ChildApReportQuery groupBy09Click() Group by the 09_click column
 * @method     ChildApReportQuery groupBy10Click() Group by the 10_click column
 * @method     ChildApReportQuery groupBy11Click() Group by the 11_click column
 * @method     ChildApReportQuery groupBy12Click() Group by the 12_click column
 * @method     ChildApReportQuery groupBy13Click() Group by the 13_click column
 * @method     ChildApReportQuery groupBy14Click() Group by the 14_click column
 * @method     ChildApReportQuery groupBy15Click() Group by the 15_click column
 * @method     ChildApReportQuery groupBy16Click() Group by the 16_click column
 * @method     ChildApReportQuery groupBy17Click() Group by the 17_click column
 * @method     ChildApReportQuery groupBy18Click() Group by the 18_click column
 * @method     ChildApReportQuery groupBy19Click() Group by the 19_click column
 * @method     ChildApReportQuery groupBy20Click() Group by the 20_click column
 * @method     ChildApReportQuery groupBy21Click() Group by the 21_click column
 * @method     ChildApReportQuery groupBy22Click() Group by the 22_click column
 * @method     ChildApReportQuery groupBy23Click() Group by the 23_click column
 * @method     ChildApReportQuery groupBy24Click() Group by the 24_click column
 * @method     ChildApReportQuery groupBy25Click() Group by the 25_click column
 * @method     ChildApReportQuery groupBy26Click() Group by the 26_click column
 * @method     ChildApReportQuery groupBy27Click() Group by the 27_click column
 * @method     ChildApReportQuery groupBy28Click() Group by the 28_click column
 * @method     ChildApReportQuery groupBy29Click() Group by the 29_click column
 * @method     ChildApReportQuery groupBy30Click() Group by the 30_click column
 * @method     ChildApReportQuery groupBy31Click() Group by the 31_click column
 *
 * @method     ChildApReportQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildApReportQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildApReportQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildApReportQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildApReportQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildApReportQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildApReport findOne(ConnectionInterface $con = null) Return the first ChildApReport matching the query
 * @method     ChildApReport findOneOrCreate(ConnectionInterface $con = null) Return the first ChildApReport matching the query, or a new ChildApReport object populated from the query conditions when no match is found
 *
 * @method     ChildApReport findOneById(int $id) Return the first ChildApReport filtered by the id column
 * @method     ChildApReport findOneByApMacaddr(string $ap_macaddr) Return the first ChildApReport filtered by the ap_macaddr column
 * @method     ChildApReport findOneByYear(int $year) Return the first ChildApReport filtered by the year column
 * @method     ChildApReport findOneByMonth(int $month) Return the first ChildApReport filtered by the month column
 * @method     ChildApReport findOneBy01(string $01) Return the first ChildApReport filtered by the 01 column
 * @method     ChildApReport findOneBy02(string $02) Return the first ChildApReport filtered by the 02 column
 * @method     ChildApReport findOneBy03(string $03) Return the first ChildApReport filtered by the 03 column
 * @method     ChildApReport findOneBy04(string $04) Return the first ChildApReport filtered by the 04 column
 * @method     ChildApReport findOneBy05(string $05) Return the first ChildApReport filtered by the 05 column
 * @method     ChildApReport findOneBy06(string $06) Return the first ChildApReport filtered by the 06 column
 * @method     ChildApReport findOneBy07(string $07) Return the first ChildApReport filtered by the 07 column
 * @method     ChildApReport findOneBy08(string $08) Return the first ChildApReport filtered by the 08 column
 * @method     ChildApReport findOneBy09(string $09) Return the first ChildApReport filtered by the 09 column
 * @method     ChildApReport findOneBy10(string $10) Return the first ChildApReport filtered by the 10 column
 * @method     ChildApReport findOneBy11(string $11) Return the first ChildApReport filtered by the 11 column
 * @method     ChildApReport findOneBy12(string $12) Return the first ChildApReport filtered by the 12 column
 * @method     ChildApReport findOneBy13(string $13) Return the first ChildApReport filtered by the 13 column
 * @method     ChildApReport findOneBy14(string $14) Return the first ChildApReport filtered by the 14 column
 * @method     ChildApReport findOneBy15(string $15) Return the first ChildApReport filtered by the 15 column
 * @method     ChildApReport findOneBy16(string $16) Return the first ChildApReport filtered by the 16 column
 * @method     ChildApReport findOneBy17(string $17) Return the first ChildApReport filtered by the 17 column
 * @method     ChildApReport findOneBy18(string $18) Return the first ChildApReport filtered by the 18 column
 * @method     ChildApReport findOneBy19(string $19) Return the first ChildApReport filtered by the 19 column
 * @method     ChildApReport findOneBy20(string $20) Return the first ChildApReport filtered by the 20 column
 * @method     ChildApReport findOneBy21(string $21) Return the first ChildApReport filtered by the 21 column
 * @method     ChildApReport findOneBy22(string $22) Return the first ChildApReport filtered by the 22 column
 * @method     ChildApReport findOneBy23(string $23) Return the first ChildApReport filtered by the 23 column
 * @method     ChildApReport findOneBy24(string $24) Return the first ChildApReport filtered by the 24 column
 * @method     ChildApReport findOneBy25(string $25) Return the first ChildApReport filtered by the 25 column
 * @method     ChildApReport findOneBy26(string $26) Return the first ChildApReport filtered by the 26 column
 * @method     ChildApReport findOneBy27(string $27) Return the first ChildApReport filtered by the 27 column
 * @method     ChildApReport findOneBy28(string $28) Return the first ChildApReport filtered by the 28 column
 * @method     ChildApReport findOneBy29(string $29) Return the first ChildApReport filtered by the 29 column
 * @method     ChildApReport findOneBy30(string $30) Return the first ChildApReport filtered by the 30 column
 * @method     ChildApReport findOneBy31(string $31) Return the first ChildApReport filtered by the 31 column
 * @method     ChildApReport findOneBy01Click(string $01_click) Return the first ChildApReport filtered by the 01_click column
 * @method     ChildApReport findOneBy02Click(string $02_click) Return the first ChildApReport filtered by the 02_click column
 * @method     ChildApReport findOneBy03Click(string $03_click) Return the first ChildApReport filtered by the 03_click column
 * @method     ChildApReport findOneBy04Click(string $04_click) Return the first ChildApReport filtered by the 04_click column
 * @method     ChildApReport findOneBy05Click(string $05_click) Return the first ChildApReport filtered by the 05_click column
 * @method     ChildApReport findOneBy06Click(string $06_click) Return the first ChildApReport filtered by the 06_click column
 * @method     ChildApReport findOneBy07Click(string $07_click) Return the first ChildApReport filtered by the 07_click column
 * @method     ChildApReport findOneBy08Click(string $08_click) Return the first ChildApReport filtered by the 08_click column
 * @method     ChildApReport findOneBy09Click(string $09_click) Return the first ChildApReport filtered by the 09_click column
 * @method     ChildApReport findOneBy10Click(string $10_click) Return the first ChildApReport filtered by the 10_click column
 * @method     ChildApReport findOneBy11Click(string $11_click) Return the first ChildApReport filtered by the 11_click column
 * @method     ChildApReport findOneBy12Click(string $12_click) Return the first ChildApReport filtered by the 12_click column
 * @method     ChildApReport findOneBy13Click(string $13_click) Return the first ChildApReport filtered by the 13_click column
 * @method     ChildApReport findOneBy14Click(string $14_click) Return the first ChildApReport filtered by the 14_click column
 * @method     ChildApReport findOneBy15Click(string $15_click) Return the first ChildApReport filtered by the 15_click column
 * @method     ChildApReport findOneBy16Click(string $16_click) Return the first ChildApReport filtered by the 16_click column
 * @method     ChildApReport findOneBy17Click(string $17_click) Return the first ChildApReport filtered by the 17_click column
 * @method     ChildApReport findOneBy18Click(string $18_click) Return the first ChildApReport filtered by the 18_click column
 * @method     ChildApReport findOneBy19Click(string $19_click) Return the first ChildApReport filtered by the 19_click column
 * @method     ChildApReport findOneBy20Click(string $20_click) Return the first ChildApReport filtered by the 20_click column
 * @method     ChildApReport findOneBy21Click(string $21_click) Return the first ChildApReport filtered by the 21_click column
 * @method     ChildApReport findOneBy22Click(string $22_click) Return the first ChildApReport filtered by the 22_click column
 * @method     ChildApReport findOneBy23Click(string $23_click) Return the first ChildApReport filtered by the 23_click column
 * @method     ChildApReport findOneBy24Click(string $24_click) Return the first ChildApReport filtered by the 24_click column
 * @method     ChildApReport findOneBy25Click(string $25_click) Return the first ChildApReport filtered by the 25_click column
 * @method     ChildApReport findOneBy26Click(string $26_click) Return the first ChildApReport filtered by the 26_click column
 * @method     ChildApReport findOneBy27Click(string $27_click) Return the first ChildApReport filtered by the 27_click column
 * @method     ChildApReport findOneBy28Click(string $28_click) Return the first ChildApReport filtered by the 28_click column
 * @method     ChildApReport findOneBy29Click(string $29_click) Return the first ChildApReport filtered by the 29_click column
 * @method     ChildApReport findOneBy30Click(string $30_click) Return the first ChildApReport filtered by the 30_click column
 * @method     ChildApReport findOneBy31Click(string $31_click) Return the first ChildApReport filtered by the 31_click column *

 * @method     ChildApReport requirePk($key, ConnectionInterface $con = null) Return the ChildApReport by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOne(ConnectionInterface $con = null) Return the first ChildApReport matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildApReport requireOneById(int $id) Return the first ChildApReport filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneByApMacaddr(string $ap_macaddr) Return the first ChildApReport filtered by the ap_macaddr column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneByYear(int $year) Return the first ChildApReport filtered by the year column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneByMonth(int $month) Return the first ChildApReport filtered by the month column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy01(string $01) Return the first ChildApReport filtered by the 01 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy02(string $02) Return the first ChildApReport filtered by the 02 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy03(string $03) Return the first ChildApReport filtered by the 03 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy04(string $04) Return the first ChildApReport filtered by the 04 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy05(string $05) Return the first ChildApReport filtered by the 05 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy06(string $06) Return the first ChildApReport filtered by the 06 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy07(string $07) Return the first ChildApReport filtered by the 07 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy08(string $08) Return the first ChildApReport filtered by the 08 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy09(string $09) Return the first ChildApReport filtered by the 09 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy10(string $10) Return the first ChildApReport filtered by the 10 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy11(string $11) Return the first ChildApReport filtered by the 11 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy12(string $12) Return the first ChildApReport filtered by the 12 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy13(string $13) Return the first ChildApReport filtered by the 13 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy14(string $14) Return the first ChildApReport filtered by the 14 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy15(string $15) Return the first ChildApReport filtered by the 15 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy16(string $16) Return the first ChildApReport filtered by the 16 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy17(string $17) Return the first ChildApReport filtered by the 17 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy18(string $18) Return the first ChildApReport filtered by the 18 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy19(string $19) Return the first ChildApReport filtered by the 19 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy20(string $20) Return the first ChildApReport filtered by the 20 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy21(string $21) Return the first ChildApReport filtered by the 21 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy22(string $22) Return the first ChildApReport filtered by the 22 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy23(string $23) Return the first ChildApReport filtered by the 23 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy24(string $24) Return the first ChildApReport filtered by the 24 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy25(string $25) Return the first ChildApReport filtered by the 25 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy26(string $26) Return the first ChildApReport filtered by the 26 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy27(string $27) Return the first ChildApReport filtered by the 27 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy28(string $28) Return the first ChildApReport filtered by the 28 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy29(string $29) Return the first ChildApReport filtered by the 29 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy30(string $30) Return the first ChildApReport filtered by the 30 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy31(string $31) Return the first ChildApReport filtered by the 31 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy01Click(string $01_click) Return the first ChildApReport filtered by the 01_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy02Click(string $02_click) Return the first ChildApReport filtered by the 02_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy03Click(string $03_click) Return the first ChildApReport filtered by the 03_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy04Click(string $04_click) Return the first ChildApReport filtered by the 04_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy05Click(string $05_click) Return the first ChildApReport filtered by the 05_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy06Click(string $06_click) Return the first ChildApReport filtered by the 06_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy07Click(string $07_click) Return the first ChildApReport filtered by the 07_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy08Click(string $08_click) Return the first ChildApReport filtered by the 08_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy09Click(string $09_click) Return the first ChildApReport filtered by the 09_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy10Click(string $10_click) Return the first ChildApReport filtered by the 10_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy11Click(string $11_click) Return the first ChildApReport filtered by the 11_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy12Click(string $12_click) Return the first ChildApReport filtered by the 12_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy13Click(string $13_click) Return the first ChildApReport filtered by the 13_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy14Click(string $14_click) Return the first ChildApReport filtered by the 14_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy15Click(string $15_click) Return the first ChildApReport filtered by the 15_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy16Click(string $16_click) Return the first ChildApReport filtered by the 16_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy17Click(string $17_click) Return the first ChildApReport filtered by the 17_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy18Click(string $18_click) Return the first ChildApReport filtered by the 18_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy19Click(string $19_click) Return the first ChildApReport filtered by the 19_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy20Click(string $20_click) Return the first ChildApReport filtered by the 20_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy21Click(string $21_click) Return the first ChildApReport filtered by the 21_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy22Click(string $22_click) Return the first ChildApReport filtered by the 22_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy23Click(string $23_click) Return the first ChildApReport filtered by the 23_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy24Click(string $24_click) Return the first ChildApReport filtered by the 24_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy25Click(string $25_click) Return the first ChildApReport filtered by the 25_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy26Click(string $26_click) Return the first ChildApReport filtered by the 26_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy27Click(string $27_click) Return the first ChildApReport filtered by the 27_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy28Click(string $28_click) Return the first ChildApReport filtered by the 28_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy29Click(string $29_click) Return the first ChildApReport filtered by the 29_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy30Click(string $30_click) Return the first ChildApReport filtered by the 30_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApReport requireOneBy31Click(string $31_click) Return the first ChildApReport filtered by the 31_click column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildApReport[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildApReport objects based on current ModelCriteria
 * @method     ChildApReport[]|ObjectCollection findById(int $id) Return ChildApReport objects filtered by the id column
 * @method     ChildApReport[]|ObjectCollection findByApMacaddr(string $ap_macaddr) Return ChildApReport objects filtered by the ap_macaddr column
 * @method     ChildApReport[]|ObjectCollection findByYear(int $year) Return ChildApReport objects filtered by the year column
 * @method     ChildApReport[]|ObjectCollection findByMonth(int $month) Return ChildApReport objects filtered by the month column
 * @method     ChildApReport[]|ObjectCollection findBy01(string $01) Return ChildApReport objects filtered by the 01 column
 * @method     ChildApReport[]|ObjectCollection findBy02(string $02) Return ChildApReport objects filtered by the 02 column
 * @method     ChildApReport[]|ObjectCollection findBy03(string $03) Return ChildApReport objects filtered by the 03 column
 * @method     ChildApReport[]|ObjectCollection findBy04(string $04) Return ChildApReport objects filtered by the 04 column
 * @method     ChildApReport[]|ObjectCollection findBy05(string $05) Return ChildApReport objects filtered by the 05 column
 * @method     ChildApReport[]|ObjectCollection findBy06(string $06) Return ChildApReport objects filtered by the 06 column
 * @method     ChildApReport[]|ObjectCollection findBy07(string $07) Return ChildApReport objects filtered by the 07 column
 * @method     ChildApReport[]|ObjectCollection findBy08(string $08) Return ChildApReport objects filtered by the 08 column
 * @method     ChildApReport[]|ObjectCollection findBy09(string $09) Return ChildApReport objects filtered by the 09 column
 * @method     ChildApReport[]|ObjectCollection findBy10(string $10) Return ChildApReport objects filtered by the 10 column
 * @method     ChildApReport[]|ObjectCollection findBy11(string $11) Return ChildApReport objects filtered by the 11 column
 * @method     ChildApReport[]|ObjectCollection findBy12(string $12) Return ChildApReport objects filtered by the 12 column
 * @method     ChildApReport[]|ObjectCollection findBy13(string $13) Return ChildApReport objects filtered by the 13 column
 * @method     ChildApReport[]|ObjectCollection findBy14(string $14) Return ChildApReport objects filtered by the 14 column
 * @method     ChildApReport[]|ObjectCollection findBy15(string $15) Return ChildApReport objects filtered by the 15 column
 * @method     ChildApReport[]|ObjectCollection findBy16(string $16) Return ChildApReport objects filtered by the 16 column
 * @method     ChildApReport[]|ObjectCollection findBy17(string $17) Return ChildApReport objects filtered by the 17 column
 * @method     ChildApReport[]|ObjectCollection findBy18(string $18) Return ChildApReport objects filtered by the 18 column
 * @method     ChildApReport[]|ObjectCollection findBy19(string $19) Return ChildApReport objects filtered by the 19 column
 * @method     ChildApReport[]|ObjectCollection findBy20(string $20) Return ChildApReport objects filtered by the 20 column
 * @method     ChildApReport[]|ObjectCollection findBy21(string $21) Return ChildApReport objects filtered by the 21 column
 * @method     ChildApReport[]|ObjectCollection findBy22(string $22) Return ChildApReport objects filtered by the 22 column
 * @method     ChildApReport[]|ObjectCollection findBy23(string $23) Return ChildApReport objects filtered by the 23 column
 * @method     ChildApReport[]|ObjectCollection findBy24(string $24) Return ChildApReport objects filtered by the 24 column
 * @method     ChildApReport[]|ObjectCollection findBy25(string $25) Return ChildApReport objects filtered by the 25 column
 * @method     ChildApReport[]|ObjectCollection findBy26(string $26) Return ChildApReport objects filtered by the 26 column
 * @method     ChildApReport[]|ObjectCollection findBy27(string $27) Return ChildApReport objects filtered by the 27 column
 * @method     ChildApReport[]|ObjectCollection findBy28(string $28) Return ChildApReport objects filtered by the 28 column
 * @method     ChildApReport[]|ObjectCollection findBy29(string $29) Return ChildApReport objects filtered by the 29 column
 * @method     ChildApReport[]|ObjectCollection findBy30(string $30) Return ChildApReport objects filtered by the 30 column
 * @method     ChildApReport[]|ObjectCollection findBy31(string $31) Return ChildApReport objects filtered by the 31 column
 * @method     ChildApReport[]|ObjectCollection findBy01Click(string $01_click) Return ChildApReport objects filtered by the 01_click column
 * @method     ChildApReport[]|ObjectCollection findBy02Click(string $02_click) Return ChildApReport objects filtered by the 02_click column
 * @method     ChildApReport[]|ObjectCollection findBy03Click(string $03_click) Return ChildApReport objects filtered by the 03_click column
 * @method     ChildApReport[]|ObjectCollection findBy04Click(string $04_click) Return ChildApReport objects filtered by the 04_click column
 * @method     ChildApReport[]|ObjectCollection findBy05Click(string $05_click) Return ChildApReport objects filtered by the 05_click column
 * @method     ChildApReport[]|ObjectCollection findBy06Click(string $06_click) Return ChildApReport objects filtered by the 06_click column
 * @method     ChildApReport[]|ObjectCollection findBy07Click(string $07_click) Return ChildApReport objects filtered by the 07_click column
 * @method     ChildApReport[]|ObjectCollection findBy08Click(string $08_click) Return ChildApReport objects filtered by the 08_click column
 * @method     ChildApReport[]|ObjectCollection findBy09Click(string $09_click) Return ChildApReport objects filtered by the 09_click column
 * @method     ChildApReport[]|ObjectCollection findBy10Click(string $10_click) Return ChildApReport objects filtered by the 10_click column
 * @method     ChildApReport[]|ObjectCollection findBy11Click(string $11_click) Return ChildApReport objects filtered by the 11_click column
 * @method     ChildApReport[]|ObjectCollection findBy12Click(string $12_click) Return ChildApReport objects filtered by the 12_click column
 * @method     ChildApReport[]|ObjectCollection findBy13Click(string $13_click) Return ChildApReport objects filtered by the 13_click column
 * @method     ChildApReport[]|ObjectCollection findBy14Click(string $14_click) Return ChildApReport objects filtered by the 14_click column
 * @method     ChildApReport[]|ObjectCollection findBy15Click(string $15_click) Return ChildApReport objects filtered by the 15_click column
 * @method     ChildApReport[]|ObjectCollection findBy16Click(string $16_click) Return ChildApReport objects filtered by the 16_click column
 * @method     ChildApReport[]|ObjectCollection findBy17Click(string $17_click) Return ChildApReport objects filtered by the 17_click column
 * @method     ChildApReport[]|ObjectCollection findBy18Click(string $18_click) Return ChildApReport objects filtered by the 18_click column
 * @method     ChildApReport[]|ObjectCollection findBy19Click(string $19_click) Return ChildApReport objects filtered by the 19_click column
 * @method     ChildApReport[]|ObjectCollection findBy20Click(string $20_click) Return ChildApReport objects filtered by the 20_click column
 * @method     ChildApReport[]|ObjectCollection findBy21Click(string $21_click) Return ChildApReport objects filtered by the 21_click column
 * @method     ChildApReport[]|ObjectCollection findBy22Click(string $22_click) Return ChildApReport objects filtered by the 22_click column
 * @method     ChildApReport[]|ObjectCollection findBy23Click(string $23_click) Return ChildApReport objects filtered by the 23_click column
 * @method     ChildApReport[]|ObjectCollection findBy24Click(string $24_click) Return ChildApReport objects filtered by the 24_click column
 * @method     ChildApReport[]|ObjectCollection findBy25Click(string $25_click) Return ChildApReport objects filtered by the 25_click column
 * @method     ChildApReport[]|ObjectCollection findBy26Click(string $26_click) Return ChildApReport objects filtered by the 26_click column
 * @method     ChildApReport[]|ObjectCollection findBy27Click(string $27_click) Return ChildApReport objects filtered by the 27_click column
 * @method     ChildApReport[]|ObjectCollection findBy28Click(string $28_click) Return ChildApReport objects filtered by the 28_click column
 * @method     ChildApReport[]|ObjectCollection findBy29Click(string $29_click) Return ChildApReport objects filtered by the 29_click column
 * @method     ChildApReport[]|ObjectCollection findBy30Click(string $30_click) Return ChildApReport objects filtered by the 30_click column
 * @method     ChildApReport[]|ObjectCollection findBy31Click(string $31_click) Return ChildApReport objects filtered by the 31_click column
 * @method     ChildApReport[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ApReportQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Hotspot\AccessPointBundle\Model\Base\ApReportQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Hotspot\\AccessPointBundle\\Model\\ApReport', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildApReportQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildApReportQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildApReportQuery) {
            return $criteria;
        }
        $query = new ChildApReportQuery();
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
     * @return ChildApReport|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ApReportTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ApReportTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildApReport A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `ap_macaddr`, `year`, `month`, `01`, `02`, `03`, `04`, `05`, `06`, `07`, `08`, `09`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`, `30`, `31`, `01_click`, `02_click`, `03_click`, `04_click`, `05_click`, `06_click`, `07_click`, `08_click`, `09_click`, `10_click`, `11_click`, `12_click`, `13_click`, `14_click`, `15_click`, `16_click`, `17_click`, `18_click`, `19_click`, `20_click`, `21_click`, `22_click`, `23_click`, `24_click`, `25_click`, `26_click`, `27_click`, `28_click`, `29_click`, `30_click`, `31_click` FROM `ap_report` WHERE `id` = :p0';
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
            /** @var ChildApReport $obj */
            $obj = new ChildApReport();
            $obj->hydrate($row);
            ApReportTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildApReport|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ApReportTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ApReportTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ApReportTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ApReportTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterByApMacaddr($apMacaddr = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($apMacaddr)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_AP_MACADDR, $apMacaddr, $comparison);
    }

    /**
     * Filter the query on the year column
     *
     * Example usage:
     * <code>
     * $query->filterByYear(1234); // WHERE year = 1234
     * $query->filterByYear(array(12, 34)); // WHERE year IN (12, 34)
     * $query->filterByYear(array('min' => 12)); // WHERE year > 12
     * </code>
     *
     * @param     mixed $year The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterByYear($year = null, $comparison = null)
    {
        if (is_array($year)) {
            $useMinMax = false;
            if (isset($year['min'])) {
                $this->addUsingAlias(ApReportTableMap::COL_YEAR, $year['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($year['max'])) {
                $this->addUsingAlias(ApReportTableMap::COL_YEAR, $year['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_YEAR, $year, $comparison);
    }

    /**
     * Filter the query on the month column
     *
     * Example usage:
     * <code>
     * $query->filterByMonth(1234); // WHERE month = 1234
     * $query->filterByMonth(array(12, 34)); // WHERE month IN (12, 34)
     * $query->filterByMonth(array('min' => 12)); // WHERE month > 12
     * </code>
     *
     * @param     mixed $month The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterByMonth($month = null, $comparison = null)
    {
        if (is_array($month)) {
            $useMinMax = false;
            if (isset($month['min'])) {
                $this->addUsingAlias(ApReportTableMap::COL_MONTH, $month['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($month['max'])) {
                $this->addUsingAlias(ApReportTableMap::COL_MONTH, $month['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_MONTH, $month, $comparison);
    }

    /**
     * Filter the query on the 01 column
     *
     * Example usage:
     * <code>
     * $query->filterBy01('fooValue');   // WHERE 01 = 'fooValue'
     * $query->filterBy01('%fooValue%', Criteria::LIKE); // WHERE 01 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $01 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy01($01 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($01)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_01, $01, $comparison);
    }

    /**
     * Filter the query on the 02 column
     *
     * Example usage:
     * <code>
     * $query->filterBy02('fooValue');   // WHERE 02 = 'fooValue'
     * $query->filterBy02('%fooValue%', Criteria::LIKE); // WHERE 02 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $02 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy02($02 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($02)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_02, $02, $comparison);
    }

    /**
     * Filter the query on the 03 column
     *
     * Example usage:
     * <code>
     * $query->filterBy03('fooValue');   // WHERE 03 = 'fooValue'
     * $query->filterBy03('%fooValue%', Criteria::LIKE); // WHERE 03 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $03 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy03($03 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($03)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_03, $03, $comparison);
    }

    /**
     * Filter the query on the 04 column
     *
     * Example usage:
     * <code>
     * $query->filterBy04('fooValue');   // WHERE 04 = 'fooValue'
     * $query->filterBy04('%fooValue%', Criteria::LIKE); // WHERE 04 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $04 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy04($04 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($04)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_04, $04, $comparison);
    }

    /**
     * Filter the query on the 05 column
     *
     * Example usage:
     * <code>
     * $query->filterBy05('fooValue');   // WHERE 05 = 'fooValue'
     * $query->filterBy05('%fooValue%', Criteria::LIKE); // WHERE 05 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $05 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy05($05 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($05)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_05, $05, $comparison);
    }

    /**
     * Filter the query on the 06 column
     *
     * Example usage:
     * <code>
     * $query->filterBy06('fooValue');   // WHERE 06 = 'fooValue'
     * $query->filterBy06('%fooValue%', Criteria::LIKE); // WHERE 06 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $06 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy06($06 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($06)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_06, $06, $comparison);
    }

    /**
     * Filter the query on the 07 column
     *
     * Example usage:
     * <code>
     * $query->filterBy07('fooValue');   // WHERE 07 = 'fooValue'
     * $query->filterBy07('%fooValue%', Criteria::LIKE); // WHERE 07 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $07 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy07($07 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($07)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_07, $07, $comparison);
    }

    /**
     * Filter the query on the 08 column
     *
     * Example usage:
     * <code>
     * $query->filterBy08('fooValue');   // WHERE 08 = 'fooValue'
     * $query->filterBy08('%fooValue%', Criteria::LIKE); // WHERE 08 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $08 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy08($08 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($08)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_08, $08, $comparison);
    }

    /**
     * Filter the query on the 09 column
     *
     * Example usage:
     * <code>
     * $query->filterBy09('fooValue');   // WHERE 09 = 'fooValue'
     * $query->filterBy09('%fooValue%', Criteria::LIKE); // WHERE 09 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $09 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy09($09 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($09)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_09, $09, $comparison);
    }

    /**
     * Filter the query on the 10 column
     *
     * Example usage:
     * <code>
     * $query->filterBy10('fooValue');   // WHERE 10 = 'fooValue'
     * $query->filterBy10('%fooValue%', Criteria::LIKE); // WHERE 10 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $10 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy10($10 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($10)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_10, $10, $comparison);
    }

    /**
     * Filter the query on the 11 column
     *
     * Example usage:
     * <code>
     * $query->filterBy11('fooValue');   // WHERE 11 = 'fooValue'
     * $query->filterBy11('%fooValue%', Criteria::LIKE); // WHERE 11 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $11 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy11($11 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($11)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_11, $11, $comparison);
    }

    /**
     * Filter the query on the 12 column
     *
     * Example usage:
     * <code>
     * $query->filterBy12('fooValue');   // WHERE 12 = 'fooValue'
     * $query->filterBy12('%fooValue%', Criteria::LIKE); // WHERE 12 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $12 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy12($12 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($12)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_12, $12, $comparison);
    }

    /**
     * Filter the query on the 13 column
     *
     * Example usage:
     * <code>
     * $query->filterBy13('fooValue');   // WHERE 13 = 'fooValue'
     * $query->filterBy13('%fooValue%', Criteria::LIKE); // WHERE 13 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $13 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy13($13 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($13)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_13, $13, $comparison);
    }

    /**
     * Filter the query on the 14 column
     *
     * Example usage:
     * <code>
     * $query->filterBy14('fooValue');   // WHERE 14 = 'fooValue'
     * $query->filterBy14('%fooValue%', Criteria::LIKE); // WHERE 14 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $14 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy14($14 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($14)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_14, $14, $comparison);
    }

    /**
     * Filter the query on the 15 column
     *
     * Example usage:
     * <code>
     * $query->filterBy15('fooValue');   // WHERE 15 = 'fooValue'
     * $query->filterBy15('%fooValue%', Criteria::LIKE); // WHERE 15 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $15 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy15($15 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($15)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_15, $15, $comparison);
    }

    /**
     * Filter the query on the 16 column
     *
     * Example usage:
     * <code>
     * $query->filterBy16('fooValue');   // WHERE 16 = 'fooValue'
     * $query->filterBy16('%fooValue%', Criteria::LIKE); // WHERE 16 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $16 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy16($16 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($16)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_16, $16, $comparison);
    }

    /**
     * Filter the query on the 17 column
     *
     * Example usage:
     * <code>
     * $query->filterBy17('fooValue');   // WHERE 17 = 'fooValue'
     * $query->filterBy17('%fooValue%', Criteria::LIKE); // WHERE 17 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $17 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy17($17 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($17)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_17, $17, $comparison);
    }

    /**
     * Filter the query on the 18 column
     *
     * Example usage:
     * <code>
     * $query->filterBy18('fooValue');   // WHERE 18 = 'fooValue'
     * $query->filterBy18('%fooValue%', Criteria::LIKE); // WHERE 18 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $18 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy18($18 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($18)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_18, $18, $comparison);
    }

    /**
     * Filter the query on the 19 column
     *
     * Example usage:
     * <code>
     * $query->filterBy19('fooValue');   // WHERE 19 = 'fooValue'
     * $query->filterBy19('%fooValue%', Criteria::LIKE); // WHERE 19 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $19 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy19($19 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($19)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_19, $19, $comparison);
    }

    /**
     * Filter the query on the 20 column
     *
     * Example usage:
     * <code>
     * $query->filterBy20('fooValue');   // WHERE 20 = 'fooValue'
     * $query->filterBy20('%fooValue%', Criteria::LIKE); // WHERE 20 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $20 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy20($20 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($20)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_20, $20, $comparison);
    }

    /**
     * Filter the query on the 21 column
     *
     * Example usage:
     * <code>
     * $query->filterBy21('fooValue');   // WHERE 21 = 'fooValue'
     * $query->filterBy21('%fooValue%', Criteria::LIKE); // WHERE 21 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $21 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy21($21 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($21)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_21, $21, $comparison);
    }

    /**
     * Filter the query on the 22 column
     *
     * Example usage:
     * <code>
     * $query->filterBy22('fooValue');   // WHERE 22 = 'fooValue'
     * $query->filterBy22('%fooValue%', Criteria::LIKE); // WHERE 22 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $22 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy22($22 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($22)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_22, $22, $comparison);
    }

    /**
     * Filter the query on the 23 column
     *
     * Example usage:
     * <code>
     * $query->filterBy23('fooValue');   // WHERE 23 = 'fooValue'
     * $query->filterBy23('%fooValue%', Criteria::LIKE); // WHERE 23 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $23 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy23($23 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($23)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_23, $23, $comparison);
    }

    /**
     * Filter the query on the 24 column
     *
     * Example usage:
     * <code>
     * $query->filterBy24('fooValue');   // WHERE 24 = 'fooValue'
     * $query->filterBy24('%fooValue%', Criteria::LIKE); // WHERE 24 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $24 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy24($24 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($24)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_24, $24, $comparison);
    }

    /**
     * Filter the query on the 25 column
     *
     * Example usage:
     * <code>
     * $query->filterBy25('fooValue');   // WHERE 25 = 'fooValue'
     * $query->filterBy25('%fooValue%', Criteria::LIKE); // WHERE 25 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $25 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy25($25 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($25)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_25, $25, $comparison);
    }

    /**
     * Filter the query on the 26 column
     *
     * Example usage:
     * <code>
     * $query->filterBy26('fooValue');   // WHERE 26 = 'fooValue'
     * $query->filterBy26('%fooValue%', Criteria::LIKE); // WHERE 26 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $26 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy26($26 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($26)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_26, $26, $comparison);
    }

    /**
     * Filter the query on the 27 column
     *
     * Example usage:
     * <code>
     * $query->filterBy27('fooValue');   // WHERE 27 = 'fooValue'
     * $query->filterBy27('%fooValue%', Criteria::LIKE); // WHERE 27 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $27 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy27($27 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($27)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_27, $27, $comparison);
    }

    /**
     * Filter the query on the 28 column
     *
     * Example usage:
     * <code>
     * $query->filterBy28('fooValue');   // WHERE 28 = 'fooValue'
     * $query->filterBy28('%fooValue%', Criteria::LIKE); // WHERE 28 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $28 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy28($28 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($28)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_28, $28, $comparison);
    }

    /**
     * Filter the query on the 29 column
     *
     * Example usage:
     * <code>
     * $query->filterBy29('fooValue');   // WHERE 29 = 'fooValue'
     * $query->filterBy29('%fooValue%', Criteria::LIKE); // WHERE 29 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $29 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy29($29 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($29)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_29, $29, $comparison);
    }

    /**
     * Filter the query on the 30 column
     *
     * Example usage:
     * <code>
     * $query->filterBy30('fooValue');   // WHERE 30 = 'fooValue'
     * $query->filterBy30('%fooValue%', Criteria::LIKE); // WHERE 30 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $30 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy30($30 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($30)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_30, $30, $comparison);
    }

    /**
     * Filter the query on the 31 column
     *
     * Example usage:
     * <code>
     * $query->filterBy31('fooValue');   // WHERE 31 = 'fooValue'
     * $query->filterBy31('%fooValue%', Criteria::LIKE); // WHERE 31 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $31 The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy31($31 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($31)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_31, $31, $comparison);
    }

    /**
     * Filter the query on the 01_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy01Click('fooValue');   // WHERE 01_click = 'fooValue'
     * $query->filterBy01Click('%fooValue%', Criteria::LIKE); // WHERE 01_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $01Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy01Click($01Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($01Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_01_CLICK, $01Click, $comparison);
    }

    /**
     * Filter the query on the 02_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy02Click('fooValue');   // WHERE 02_click = 'fooValue'
     * $query->filterBy02Click('%fooValue%', Criteria::LIKE); // WHERE 02_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $02Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy02Click($02Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($02Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_02_CLICK, $02Click, $comparison);
    }

    /**
     * Filter the query on the 03_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy03Click('fooValue');   // WHERE 03_click = 'fooValue'
     * $query->filterBy03Click('%fooValue%', Criteria::LIKE); // WHERE 03_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $03Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy03Click($03Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($03Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_03_CLICK, $03Click, $comparison);
    }

    /**
     * Filter the query on the 04_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy04Click('fooValue');   // WHERE 04_click = 'fooValue'
     * $query->filterBy04Click('%fooValue%', Criteria::LIKE); // WHERE 04_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $04Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy04Click($04Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($04Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_04_CLICK, $04Click, $comparison);
    }

    /**
     * Filter the query on the 05_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy05Click('fooValue');   // WHERE 05_click = 'fooValue'
     * $query->filterBy05Click('%fooValue%', Criteria::LIKE); // WHERE 05_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $05Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy05Click($05Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($05Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_05_CLICK, $05Click, $comparison);
    }

    /**
     * Filter the query on the 06_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy06Click('fooValue');   // WHERE 06_click = 'fooValue'
     * $query->filterBy06Click('%fooValue%', Criteria::LIKE); // WHERE 06_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $06Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy06Click($06Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($06Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_06_CLICK, $06Click, $comparison);
    }

    /**
     * Filter the query on the 07_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy07Click('fooValue');   // WHERE 07_click = 'fooValue'
     * $query->filterBy07Click('%fooValue%', Criteria::LIKE); // WHERE 07_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $07Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy07Click($07Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($07Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_07_CLICK, $07Click, $comparison);
    }

    /**
     * Filter the query on the 08_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy08Click('fooValue');   // WHERE 08_click = 'fooValue'
     * $query->filterBy08Click('%fooValue%', Criteria::LIKE); // WHERE 08_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $08Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy08Click($08Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($08Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_08_CLICK, $08Click, $comparison);
    }

    /**
     * Filter the query on the 09_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy09Click('fooValue');   // WHERE 09_click = 'fooValue'
     * $query->filterBy09Click('%fooValue%', Criteria::LIKE); // WHERE 09_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $09Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy09Click($09Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($09Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_09_CLICK, $09Click, $comparison);
    }

    /**
     * Filter the query on the 10_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy10Click('fooValue');   // WHERE 10_click = 'fooValue'
     * $query->filterBy10Click('%fooValue%', Criteria::LIKE); // WHERE 10_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $10Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy10Click($10Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($10Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_10_CLICK, $10Click, $comparison);
    }

    /**
     * Filter the query on the 11_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy11Click('fooValue');   // WHERE 11_click = 'fooValue'
     * $query->filterBy11Click('%fooValue%', Criteria::LIKE); // WHERE 11_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $11Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy11Click($11Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($11Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_11_CLICK, $11Click, $comparison);
    }

    /**
     * Filter the query on the 12_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy12Click('fooValue');   // WHERE 12_click = 'fooValue'
     * $query->filterBy12Click('%fooValue%', Criteria::LIKE); // WHERE 12_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $12Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy12Click($12Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($12Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_12_CLICK, $12Click, $comparison);
    }

    /**
     * Filter the query on the 13_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy13Click('fooValue');   // WHERE 13_click = 'fooValue'
     * $query->filterBy13Click('%fooValue%', Criteria::LIKE); // WHERE 13_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $13Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy13Click($13Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($13Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_13_CLICK, $13Click, $comparison);
    }

    /**
     * Filter the query on the 14_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy14Click('fooValue');   // WHERE 14_click = 'fooValue'
     * $query->filterBy14Click('%fooValue%', Criteria::LIKE); // WHERE 14_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $14Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy14Click($14Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($14Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_14_CLICK, $14Click, $comparison);
    }

    /**
     * Filter the query on the 15_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy15Click('fooValue');   // WHERE 15_click = 'fooValue'
     * $query->filterBy15Click('%fooValue%', Criteria::LIKE); // WHERE 15_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $15Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy15Click($15Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($15Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_15_CLICK, $15Click, $comparison);
    }

    /**
     * Filter the query on the 16_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy16Click('fooValue');   // WHERE 16_click = 'fooValue'
     * $query->filterBy16Click('%fooValue%', Criteria::LIKE); // WHERE 16_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $16Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy16Click($16Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($16Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_16_CLICK, $16Click, $comparison);
    }

    /**
     * Filter the query on the 17_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy17Click('fooValue');   // WHERE 17_click = 'fooValue'
     * $query->filterBy17Click('%fooValue%', Criteria::LIKE); // WHERE 17_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $17Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy17Click($17Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($17Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_17_CLICK, $17Click, $comparison);
    }

    /**
     * Filter the query on the 18_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy18Click('fooValue');   // WHERE 18_click = 'fooValue'
     * $query->filterBy18Click('%fooValue%', Criteria::LIKE); // WHERE 18_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $18Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy18Click($18Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($18Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_18_CLICK, $18Click, $comparison);
    }

    /**
     * Filter the query on the 19_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy19Click('fooValue');   // WHERE 19_click = 'fooValue'
     * $query->filterBy19Click('%fooValue%', Criteria::LIKE); // WHERE 19_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $19Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy19Click($19Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($19Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_19_CLICK, $19Click, $comparison);
    }

    /**
     * Filter the query on the 20_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy20Click('fooValue');   // WHERE 20_click = 'fooValue'
     * $query->filterBy20Click('%fooValue%', Criteria::LIKE); // WHERE 20_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $20Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy20Click($20Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($20Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_20_CLICK, $20Click, $comparison);
    }

    /**
     * Filter the query on the 21_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy21Click('fooValue');   // WHERE 21_click = 'fooValue'
     * $query->filterBy21Click('%fooValue%', Criteria::LIKE); // WHERE 21_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $21Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy21Click($21Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($21Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_21_CLICK, $21Click, $comparison);
    }

    /**
     * Filter the query on the 22_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy22Click('fooValue');   // WHERE 22_click = 'fooValue'
     * $query->filterBy22Click('%fooValue%', Criteria::LIKE); // WHERE 22_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $22Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy22Click($22Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($22Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_22_CLICK, $22Click, $comparison);
    }

    /**
     * Filter the query on the 23_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy23Click('fooValue');   // WHERE 23_click = 'fooValue'
     * $query->filterBy23Click('%fooValue%', Criteria::LIKE); // WHERE 23_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $23Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy23Click($23Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($23Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_23_CLICK, $23Click, $comparison);
    }

    /**
     * Filter the query on the 24_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy24Click('fooValue');   // WHERE 24_click = 'fooValue'
     * $query->filterBy24Click('%fooValue%', Criteria::LIKE); // WHERE 24_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $24Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy24Click($24Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($24Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_24_CLICK, $24Click, $comparison);
    }

    /**
     * Filter the query on the 25_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy25Click('fooValue');   // WHERE 25_click = 'fooValue'
     * $query->filterBy25Click('%fooValue%', Criteria::LIKE); // WHERE 25_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $25Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy25Click($25Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($25Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_25_CLICK, $25Click, $comparison);
    }

    /**
     * Filter the query on the 26_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy26Click('fooValue');   // WHERE 26_click = 'fooValue'
     * $query->filterBy26Click('%fooValue%', Criteria::LIKE); // WHERE 26_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $26Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy26Click($26Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($26Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_26_CLICK, $26Click, $comparison);
    }

    /**
     * Filter the query on the 27_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy27Click('fooValue');   // WHERE 27_click = 'fooValue'
     * $query->filterBy27Click('%fooValue%', Criteria::LIKE); // WHERE 27_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $27Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy27Click($27Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($27Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_27_CLICK, $27Click, $comparison);
    }

    /**
     * Filter the query on the 28_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy28Click('fooValue');   // WHERE 28_click = 'fooValue'
     * $query->filterBy28Click('%fooValue%', Criteria::LIKE); // WHERE 28_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $28Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy28Click($28Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($28Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_28_CLICK, $28Click, $comparison);
    }

    /**
     * Filter the query on the 29_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy29Click('fooValue');   // WHERE 29_click = 'fooValue'
     * $query->filterBy29Click('%fooValue%', Criteria::LIKE); // WHERE 29_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $29Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy29Click($29Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($29Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_29_CLICK, $29Click, $comparison);
    }

    /**
     * Filter the query on the 30_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy30Click('fooValue');   // WHERE 30_click = 'fooValue'
     * $query->filterBy30Click('%fooValue%', Criteria::LIKE); // WHERE 30_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $30Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy30Click($30Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($30Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_30_CLICK, $30Click, $comparison);
    }

    /**
     * Filter the query on the 31_click column
     *
     * Example usage:
     * <code>
     * $query->filterBy31Click('fooValue');   // WHERE 31_click = 'fooValue'
     * $query->filterBy31Click('%fooValue%', Criteria::LIKE); // WHERE 31_click LIKE '%fooValue%'
     * </code>
     *
     * @param     string $31Click The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function filterBy31Click($31Click = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($31Click)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApReportTableMap::COL_31_CLICK, $31Click, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildApReport $apReport Object to remove from the list of results
     *
     * @return $this|ChildApReportQuery The current query, for fluid interface
     */
    public function prune($apReport = null)
    {
        if ($apReport) {
            $this->addUsingAlias(ApReportTableMap::COL_ID, $apReport->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ap_report table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApReportTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ApReportTableMap::clearInstancePool();
            ApReportTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ApReportTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ApReportTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ApReportTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ApReportTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ApReportQuery
