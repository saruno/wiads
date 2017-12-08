<?php

namespace AdvertiserBundle\Helper;


class ApiHelper
{
    /**
     * @param $accesspoint_id : pubid của wiads (*)
     * @param $ssid : id quản lý các địa điểm hotspot của wiads (*)
     * @param $status : Trạng thái wifi ON => Mở , OFF => Đóng (*)
     * @param $fullname : Tên định danh của hotspot (*)
     * @return array
     */
    public static function getAdsmeeLinkPortal($accesspoint_id, $ssid, $fullname,$ip, $address,$geo,$status = 'ON')
    {
        $url = 'http://api.wbonus.net/pub/UpdateSub';
        //$ip = '';
        $data = array(
            'id'			=>  $accesspoint_id,
            'sid' 			=>  $ssid,
            'address'       =>  $address,
            'geo'           =>  $geo,
            'status' 		=>  $status,
            'fullname'  	=>  $fullname,
            'sign'  		=>  md5($accesspoint_id.$ssid.$ip.$fullname.$status),
            'image'         =>  ''
        );
        //dump($data);
        $token = self::do_post_request($url, $data);

        $result = json_decode($token, true);
        return $result;
    }

    static function do_post_request($url, $data) {
        $query = http_build_query($data);
        $ch = curl_init(); // Init cURL

        curl_setopt($ch, CURLOPT_URL, $url); // Post location
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 1 = Return data, 0 = No return
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ignore HTTPS
        curl_setopt($ch, CURLOPT_POST, 1); // This is POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query); // Add the data to the request

        $response = curl_exec($ch); // Execute the request
        curl_close($ch); // Finish the request

        if ($response) {
            return $response;
        } else {
            return NULL;
        }
    }
}