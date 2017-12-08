<?php

namespace AdvertiserBundle\Datatables;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class Advertiser
{
    private $container;
    protected $authorizationChecker;

    public function __construct($container = null) {
        $this->container = $container;
    }

	public function json_data($option = null){
        
        //$this->authorizationChecker->isGranted('ROLE_ADS_APPROVE_LEVEL_1');

        $json_data = array(
            array(
                "data"=>null,"title"=>'<input type="checkbox" id="check-all" class="flat">',"orderable"=>false,"defaultContent"=>'<td class="a-center"><input type="checkbox" class="flat" name="table_records"></td>',
                "search" => array(
                   "type"   => "button",
                   "id"     => "deleteTriger",
                   "class"  => "btn btn-danger btn-xs btn-delete",
                   "active"   => TRUE,
                )
            ),
            array(
                "data"=>"id","title" => 'ID',
                "search" => array(
                	"active"    => TRUE,
                    "type"    => "text",
                    "width"   => "7%"
                )
            ),
            array(
                "data"=>"title","title" => "Tên quảng cáo",
                "search" => array(
                	"active"    => TRUE,
                    "type"    => "text",
                    "width"   => "15%"
                )
            ),
            array(
                "data"=>"home_position","title" => "Vị trí",
                "search" => array(
                	"active"    => TRUE,
                    "type"    => "text",
                )
            ),
            array(
               "data"=>"username","title" => "Khách hàng",
                "search" => array(
                	"active"   => TRUE,
                    "type"    => "text",
                    "width"   => "4%"  
                )
            ),
            array(
                "data"=>"locked","title" => "Trạng thái",
                "search"    => array(
                    'active'=> TRUE,
                    'type' => 'select',
                    'value'   => array(''=>'','1'=>'Đóng','0'=>'Mở')
                )
            ),
            array(
                "data"=>"action","title"=>"Tùy chọn","orderable"=>false,"width"=>"15%",
            ),
                  
        );
        return $option == null ? preg_replace('/[\[\]]/','',json_encode($json_data)) : $json_data;
    }

}