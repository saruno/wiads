<?php

namespace Hotspot\AccessPointBundle\Model;

use Hotspot\AccessPointBundle\Model\Base\AccesspointQuery as BaseAccesspointQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'accesspoint' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class AccesspointQuery extends BaseAccesspointQuery
{
    private $myOrderByColumns = array();

    /**
     * Add an ORDER BY FIELD clause.
     *
     * @param String $name The field to order by.
     * @param array $elements A list to order the elements by.
     * @return $this
     */
    public function addOrderByField($name, $elements)
    {
        $this->myOrderByColumns[] = ' FIELD(' . $name . ', ' . join(", ", $elements) . ')';
        return $this;
    }

    public function getOrderByColumns(){
        return array_merge( $this->myOrderByColumns, parent::getOrderByColumns() );
    }
}
