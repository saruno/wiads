<?php

namespace AdvertiserBundle\Datatables;


class User
{
	public function json_data($option = null){

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
                "data"=>"username","title" => "Tài khoản",
                "search" => array(
                	"active"    => TRUE,
                    "type"    => "text",
                    "width"   => "15%"
                )
            ),
            array(
                "data"=>"name","title" => "Họ tên",
                "search" => array(
                	"active"    => TRUE,
                    "type"    => "text",
                )
            ),
            array(
               "data"=>"company","title" => "Công ty",
                "search" => array(
                	"active"   => TRUE,
                    "type"    => "text",
                    "width"   => "4%"  
                )
            ),
            array(
                "data"=>"type","title" => "Loại",

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