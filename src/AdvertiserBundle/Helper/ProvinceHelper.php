<?php

namespace AdvertiserBundle\Helper;
use Common\DbBundle\Model\LocationQuery;
use Propel\Runtime\Propel;

class ProvinceHelper
{
    static public function getProvince()
    {
        $location = LocationQuery::create()->orderById()->find();
        $arr = array();
        foreach ($location as $key => $value){
            $arr[$value->getCode()] = $value->getName();
        }
        return $arr;
    }

    static public function getPlatform()
    {
        return array(
            'Android'   =>  'Android',
            'iPhone'    =>  'iPhone',
            'iPad'    =>  'iPad',
            'iPod'     => 'iPod',
            'Windows' => 'Windows',
            'Windows Phone' => 'Windows Phone',
            'BlackBerry' => 'BlackBerry',
            'Linux' => 'Linux',
            'Macintosh' => 'MAC',
            'PlayBook' => 'PlayBook',
            'Kindle Fire' => 'Kindle Fire',
            'Chrome OS' => 'Chrome OS'
        );
    }

    static public function selectProvince($type = 'add', $province = '')
    {
        $pro = ProvinceHelper::getProvince();
        $str = '';
        if($type == 'add'){
            //$str .= '<option value="ALL" selected>Tất Cả</option>';
            foreach ($pro as $key => $value) {
                $str .= '<option value="'.$key.'" >'.$value.'</option>';
            }
        }else if($type == 'edit'){
            if(!empty($province)){
                $pr = explode(';', $province);
                $selected_all = '';
                if(count($pr) == count($pro)){
                    $selected_all = 'selected';
                }
                //$str .= '<option value="ALL" '.$selected_all.'>Tất Cả</option>';
                
                foreach ($pro as $key => $value) {
                    $selected_item = '';
                    if($selected_all == ''){
                        if(in_array($key, $pr)){
                            $selected_item = 'selected';
                        }
                    }
                    $str .= '<option value="'.$key.'" '.$selected_item.' >'.$value.'</option>';
                }
            }else{
                //$str .= '<option value="ALL" selected>Tất Cả</option>';
                foreach ($pro as $key => $value) {
                    $str .= '<option value="'.$key.'" >'.$value.'</option>';
                }
            }
        }
        return $str;
    }

    static public function selectPlatform($type = 'add', $platform = '')
    {
        $pro = ProvinceHelper::getPlatform();
        $str = '';
        if($type == 'add'){
            $str .= '<option value="ALL" selected>Tất Cả</option>';
            foreach ($pro as $key => $value) {
                $str .= '<option value="'.$key.'" >'.$value.'</option>';
            }
        }else if($type == 'edit'){
            if(!empty($platform)){
                $pr = explode(';', $platform);
                $selected_all = '';
                if(count($pr) == count($pro)){
                    $selected_all = 'selected';
                }
                $str .= '<option value="ALL" '.$selected_all.'>Tất Cả</option>';
                
                foreach ($pro as $key => $value) {
                    $selected_item = '';
                    if($selected_all == ''){
                        if(in_array($key, $pr)){
                            $selected_item = 'selected';
                        }
                    }
                    $str .= '<option value="'.$key.'" '.$selected_item.' >'.$value.'</option>';
                }
            }else{
                $str .= '<option value="ALL" selected>Tất Cả</option>';
                foreach ($pro as $key => $value) {
                    $str .= '<option value="'.$key.'" >'.$value.'</option>';
                }
            }
        }
        return $str;
    }

    static public function getAllProvinceKey()
    {
        $pro = ProvinceHelper::getProvince();
        $all =  implode(';', array_map(
            function ($v, $k) { 
                return $k; 
            }, 
            $pro, 
            array_keys($pro)
        ));
        return $all;
    }


    static public function getAllPlatformKey()
    {
        $plat = ProvinceHelper::getPlatform();
        $all =  implode(';', array_map(
            function ($v, $k) { 
                return $k; 
            }, 
            $plat, 
            array_keys($plat)
        ));
        return $all;
    }

    static public function getLatitude($address, $province){
        $str = $address." ".ProvinceHelper::getProvince()[$province]." Việt Nam";
        $str = str_replace(" ","+",$str);

        $url = "https://maps.googleapis.com/maps/api/geocode/json";

        $params = array(
            'address'   =>  $str,
            'key'       =>  'AIzaSyCEBv_h5gBTdFgGpKTS_54_xVLUh_iwgEM'
        );
        $curl = new  \AdvertiserBundle\Helper\CurlHelper($url, $params);
        $result = $curl->getResult();

        $data = json_decode($result);

        $std = new \stdClass();
        $std->lng = '';
        $std->lat = '';

        if(!empty($data->results)){
            $latitude = $data->results[0]->geometry->location;
            $std->lng = $latitude->lng;
            $std->lat = $latitude->lat;
        }

        return $std;
    }

    static public function getProvinceOwner($post_by){
        $province 			= \AdvertiserBundle\Helper\ProvinceHelper::getProvince();
        $list = array();

        $sql = "SELECT province ";

        $sql .= "FROM accesspoint a, accesspoint_i18n b WHERE 1 = 1 AND a.id = b.id AND province IS NOT NULL ";

        $sql .= "AND post_by = '".$post_by."' ";

        $sql .= "GROUP BY province";


        $connection = Propel::getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(2);

        foreach ($result as $key => $value) {
            $list[$value['province']] = $province[$value['province']];
        }
        return $list;
    }
}