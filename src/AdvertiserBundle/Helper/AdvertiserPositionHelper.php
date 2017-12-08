<?php

namespace AdvertiserBundle\Helper;


class AdvertiserPositionHelper
{
    static function Item(){
        return array(
            /*'QA0'      =>  'QA0',
            'QA1'      =>  'QA1',
            'QA2'      =>  'QA2',
            'QA0_v4'   =>  'QA0_v4',
            'QA1_v4'   =>  'QA1_v4',
            'QA2_v4'   =>  'QA2_v4',
            'QA3_v4'   =>  'QA3_v4',*/
            'QAF_v4'   =>  'QAF_v4',
        );
    }

    static function getItemDetail($position){
        $list = array(
            /*'QA0'      =>  array('name' => 'QA0',    'width' => 1242, 'heigh' => 698),
            'QA1'      =>  array('name' => 'QA1',    'width' => 842, 'heigh' => 740),
            'QA2'      =>  array('name' => 'QA2',    'width' => 401, 'heigh' => 590),
            'QA0_v4'   =>  array('name' => 'QA0_v4', 'width' => 300, 'heigh' => 600),
            'QA1_v4'   =>  array('name' => 'QA1_v4', 'width' => 336, 'heigh' => 280),
            'QA2_v4'   =>  array('name' => 'QA2_v4', 'width' => 336, 'heigh' => 280),
            'QA3_v4'   =>  array('name' => 'QA3_v4', 'width' => 300, 'heigh' => 250),
            */
            'QAF_v4'   =>  array('name' => 'QAF_v4', 'width' => 640, 'heigh' => 717),
            
        );

        return isset($list[$position]) ? $list[$position] : null;
    }

}