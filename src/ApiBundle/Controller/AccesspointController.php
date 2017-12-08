<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Hotspot\AccessPointBundle\Model\AccesspointQuery;
use Hotspot\AccessPointBundle\Helper\ApConfigHelper;
use ApiBundle\Helper\DefinedHelper;

class AccesspointController extends BaseController 
{
    
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get list accesspoint",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      },
     *      parameters={
     *          {"name"="province", "dataType"="String", "required"=false, "description"="Mã tỉnh thành"},
     *          {"name"="macaddr", "dataType"="String", "required"=false, "description"="Macaddr"},
     *          {"name"="text", "dataType"="String", "required"=false, "description"="Từ khóa tìm kiếm (Địa chỉ mac, tên quán, ssid, địa chỉ)"},
     *          {"name"="owner", "dataType"="String", "required"=false, "description"="Người tạo"},
     *          {"name"="from_date", "dataType"="Date","format"="Y-m-d", "required"=false, "description"=""},
     *          {"name"="to_date", "dataType"="Date","format"="Y-m-d", "required"=false, "description"=""},
     *          {"name"="page", "dataType"="Integer", "required"=false, "description"=""},
     *          {"name"="limit", "dataType"="Integer", "required"=false, "description"="0 <= limit <= 20"}
     *      }  
     * )
     */
    public function getAccesspointAction(Request $request) // "get_accesspoint"     [GET] 
    {
        $lprovince = \Common\DbBundle\Model\LocationQuery::create()->find();
        $ds_province = array();
        foreach ($lprovince as $key => $value){
            $ds_province[$value->getCode()] = $value->getName();
        }

        $province   = $request->query->get('province', null);
        $macaddr    = $request->query->get('macaddr', null);
        $text       = $request->query->get('text', null);
        $owner      = $request->query->get('owner', null);
        $from_date  = $request->query->get('from_date', null);
        $to_date    = $request->query->get('to_date', null);
        $page       = $request->query->get('page', 1) <= 0 ? 1 : $request->query->get('page', 1); 
        $limit      = $request->query->get('limit', 20) < 0 ? 20 : $request->query->get('limit', 20) > 20 ? 20 : $request->query->get('limit', 20);

        $conditions =  AccesspointQuery::create();

        $province != null ? $conditions->filterByProvince($province) : '';
        $owner != null ? $conditions->useI18nQuery('vi')->filterByPostBy($owner)->endUse() : '';
        $macaddr != null ? $conditions->filterByMacaddr($macaddr) : '';

        if($from_date != null && $to_date != null){
            $conditions ->condition('from', 'DATE(accesspoint.created_at) >= DATE(?)', $from_date)
                        ->condition('to', 'DATE(accesspoint.created_at) <= DATE(?)', $to_date)
                        ->combine(array('from', 'to'), 'and', 'from_to')  
                        ->where(array('from_to'), 'and');
        }

        if($text != null){
            $conditions->joinWithI18n('vi');
            $conditions ->condition('like_macaddr', 'accesspoint.macaddr LIKE ?', '%'.$text.'%')
                        ->condition('like_ssid', 'accesspoint.ssid LIKE ?', '%'.$text.'%')
                        ->condition('like_name', 'accesspoint_i18n.name LIKE ?', '%'.$text.'%')
                        ->condition('like_address', 'accesspoint_i18n.address LIKE ?', '%'.$text.'%')
                        ->combine(array('like_macaddr', 'like_ssid', 'like_name', 'like_address'), 'or', 'text_search')
                        ->where(array('text_search'), 'and');
        }
        $conditions->useI18nQuery('vi')->filterByTrash(0)->endUse();

        $count = $conditions->count();

        $conditions->limit($limit)->offset(($page-1)*$limit)->orderByCreatedAt('desc');

        $list = $conditions->find();

        $total_page = ceil($count / $limit);

        $result = array();

        $result['code'] = 1;
        $result['message'] = $this->get('translator')->trans('success');

        //page_info
        $page_info = array(
            'total'         =>  $total_page,
            'current'       =>  $page,
            'limit'         =>  $limit
        );
        $result['page_info'] = $page_info; 

        $data = array();
        foreach ($list as $key => $value) {
            $obj = new \stdClass();
            $obj->id = $value->getId();
            $obj->macaddr = $value->getMacaddr();
            $obj->name = $value->getName();
            $obj->address = $value->getAddress();
            $obj->province = isset($ds_province[$value->getProvince()]) ? $ds_province[$value->getProvince()] : null;
            $obj->ssid = str_replace("'",'', $value->getSsid());
            $obj->key = str_replace("'",'', $value->getKey());
            $obj->lat = (double)$value->getLat();
            $obj->lng = (double)$value->getLng();
            $obj->created_at = strtotime($value->getCreatedAt()->format('Y-m-d H:i:s')) * 1000;
            $obj->last_online = strtotime($value->getUpdatedAt()->format('Y-m-d H:i:s')) * 1000;

            $data[] = $obj;
        }
        
        $result['data'] = $data;

        return new JsonResponse($result);  
    } 

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get info one accesspoint",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      },
     *      parameters={
     *          {"name"="macaddr", "dataType"="String", "required"=true, "description"=""},
     *      }  
     * )
     */
    public function getAccesspointInfoAction(Request $request) // "get_accesspoint_info"     [GET] 
    {
        $mac = $request->query->get('macaddr',null);

        $result = array();

        if($mac !== null){
            $lprovince = \Common\DbBundle\Model\LocationQuery::create()->find();
            $ds_province = array();
            foreach ($lprovince as $key => $value){
                $ds_province[$value->getCode()] = $value->getName();
            }

            $ap = ApConfigHelper::getAPInfo($mac);
            /** @var ApConfig $apConfig */
            $apConfig = ApConfigHelper::getAPConfig($mac);
            $isUsingKey = ApConfigHelper::isUsingKey($mac);

            $result['code'] = 1;
            $result['message'] = $this->get('translator')->trans('success');

            $data = array(); 

            if(empty($apConfig)){

            }else {
                $key=str_replace('"', '', $ap->getKey());
                $key=str_replace("'", '', $key);

                $login_template = $ap->getLoginTemplate();

                $templates = DefinedHelper::getTemplatesLogin();
                $mode      = DefinedHelper::getMode();

                if ($login_template==$ap->getApMacaddr().'.html.twig')
                    $login_template='mac.html.twig';

                $data = array(
                    'macaddr'           => $ap->getMacaddr(),
                    'fw_version'        => $apConfig->getFwVersion(),
                    'last_online'       => strtotime(date_format($ap->getUpdatedAt(), 'Y-m-d H:i:s')) * 1000,
                    'key'               => $key,
                    'name'              => $ap->getName(),
                    'address'           => $ap->getAddress(),
                    'province'          => isset($ds_province[$ap->getProvince()]) ? $ds_province[$ap->getProvince()] : "-1",
                    'owner'             => empty($ap->getOwner())? "-1" : $ap->getOwner(),
                    'isUsingKey'        => $isUsingKey,
                    'trash'             => $ap->getTrash(),
                    'mode'              => isset($mode[$apConfig->getNormalMode()]) ? $mode[$apConfig->getNormalMode()] : "-1",
                    'bw_profile'        => $apConfig->getBwProfileId(),
                    'login_template'    => isset($templates[$login_template]) ? $templates[$login_template] : "-1",
                    'detail_url'        => $ap->getDetailUrl()
                );
            }
            $result['data'] = $data;
        }else{
            $result['code'] = -5;
            $result['message'] = $this->get('translator')->trans('error_negative_5');
        }

        return new JsonResponse($result);  
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update accesspoint",
     *      headers={
     *          { "name"="Authorization", "description"="Bearer Token", "required"=true },
     *          { "name"="Content-Type", "description"="application/x-www-form-urlencoded", "required"=true },
     *      },
     *      parameters={
     *          {"name"="macaddr", "dataType"="String", "required"=true, "description"=""},
     *      }  
     * )
     */
    public function postAccesspointUpdateAction(Request $request)
    {
        $result = array();

        $result['status'] = 1;
        $result['message'] = $this->get('translator')->trans('error_negative_12');

        return new JsonResponse($result); 
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update accesspoint",
     *      headers={
     *          { "name"="Authorization", "description"="Bearer Token", "required"=true },
     *          { "name"="Content-Type", "description"="application/x-www-form-urlencoded", "required"=true },
     *      },
     *      parameters={
     *          {"name"="macaddr", "dataType"="String", "required"=true, "description"=""},
     *      }  
     * )
     */
    public function postAccesspointRebootAction(Request $request)
    {
        $result = array();

        $result['status'] = 1;
        $result['message'] = $this->get('translator')->trans('error_negative_12');

        return new JsonResponse($result); 
    }


    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get accesspoint location",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      },
     *      parameters={
     *          {"name"="lat", "dataType"="Double", "required"=true, "description"=""},
     *          {"name"="lng", "dataType"="Double", "required"=true, "description"=""},
     *          {"name"="radius", "dataType"="Integer", "required"=false, "format"="(km)", "description"="Default = 50, Max = 50"},
     *          {"name"="page", "dataType"="Integer", "required"=true, "description"="Default = 1"},
     *          {"name"="limit", "dataType"="Integer", "required"=true, "description"="Default = 20, Max:20"},
     *      }  
     * )
     */
    public function getAccesspointLocationAction(Request $request)
    {   
        $lat = (double) $request->query->get('lat',null);
        $lng = (double) $request->query->get('lng',null);
        $radius = $request->query->get('radius', 10000);
        $page = $request->query->get('page', 1);
        $limit  = $request->query->get('limit', 20) < 0 ? 20 : $request->query->get('limit', 20) > 20 ? 20 : $request->query->get('limit', 20);

        $result = array();

        if($lat != null && $lng != null){
            $lprovince = \Common\DbBundle\Model\LocationQuery::create()->find();
            $ds_province = array();
            foreach ($lprovince as $key => $value){
                $ds_province[$value->getCode()] = $value->getName();
            }

            $total_records = \ApiBundle\Helper\AccesspointHelper::getCountAccesspointLocation($lat, $lng, $radius);
            
            $total_page = ceil($total_records / $limit);
            $start = ($page - 1) * $limit;
            $list = \ApiBundle\Helper\AccesspointHelper::getAccesspointLocation($lat, $lng, $radius, $start, $limit);

            $result['code'] = 1;
            $result['message'] = $this->get('translator')->trans('success');

            //page_info
            $page_info = array(
                'total'         =>  $total_page,
                'current'       =>  $page,
                'limit'         =>  $limit
            );
            $result['page_info'] = $page_info; 
            
            $data = array();
            foreach ($list as $key => $value) {
                $obj = new \stdClass();
                $obj->id = $value['id'];
                $obj->macaddr = $value['macaddr'];
                $obj->name = $value['name'];
                $obj->address = $value['address'];
                $obj->province = isset($ds_province[$value['province']]) ? $ds_province[$value['province']] : null;
                $obj->ssid = str_replace("'",'', $value['ssid']);
                $obj->key = str_replace("'",'', $value['key']);
                $obj->lat = (double)$value['lat'];
                $obj->lng = (double)$value['lng'];
                $obj->created_at = strtotime($value['created_at']) * 1000;
                $obj->distance = round($value['distance'], 2);
                $obj->last_online = strtotime($value['updated_at']) * 1000;

                $data[] = $obj;
            }
            $result['data'] = $data;
            
        
        }else{
            $result['code'] = -5;
            $result['message'] = $this->get('translator')->trans('error_negative_5');
        }

        return new JsonResponse($result);
    }


    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get accesspoint firmware",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      }  
     * )
     */
    public function getAccesspointFirmwareAction(Request $request)
    {
        $result = array();
        $result['code'] = 1;
        $result['message'] = $this->get('translator')->trans('success');

        $data = array();

        $list = \Hotspot\AccessPointBundle\Model\FirmwareQuery::create()->find();

        foreach ($list as $key => $value){
            $obj = new \stdClass();
            $obj->name = $value->getFwVersion().' - '.$value->getName();
            $obj->code = $value->getFile();

            $data[] = $obj;
        }
        $result['data'] = $data;

        return new JsonResponse($result);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get accesspoint mode",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      }  
     * )
     */
    public function getAccesspointModeAction(Request $request)
    {
        $result = array();
        $result['code'] = 1;
        $result['message'] = $this->get('translator')->trans('success');
        $data = array();

        foreach (DefinedHelper::getMode() as $key => $value) {
            $obj = new \stdClass();
            $obj->name = $value;
            $obj->code = $key;

            $data[] = $obj;
        }
        $result['data'] = $data;

        return new JsonResponse($result);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get accesspoint Bw profile (Danh sách các tốc độ và thời gian sử dụng)",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      }  
     * )
     */
    public function getAccesspointBwprofileAction(Request $request)
    {
        $result = array();
        $result['code'] = 1;
        $result['message'] = $this->get('translator')->trans('success');
        
        $list = \Hotspot\AccessPointBundle\Model\Base\BwProfileQuery::create()->find();

        $data = array();
        foreach ($list as $key => $value){
            $obj = new \stdClass();
            $obj->name = $value->getTitle();
            $obj->code = $value->getId();

            $data[] = $obj;
        }
        
        $result['data'] = $data;

        return new JsonResponse($result);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get accesspoint template login (Danh sách màn hình login)",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      }  
     * )
     */
    public function getAccesspointTemplateloginAction(Request $request)
    {
        $result = array();
        $result['code'] = 1;
        $result['message'] = $this->get('translator')->trans('success');
        

        $data = array();
        foreach (DefinedHelper::getTemplatesLogin() as $key => $value){
            $obj = new \stdClass();
            $obj->name = $value;
            $obj->code = $key;

            $data[] = $obj;
        }
        
        $result['data'] = $data;

        return new JsonResponse($result);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get accesspoint total",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      },
     *      parameters={
     *          {"name"="province", "dataType"="String", "required"=true, "description"="Mã tỉnh thành"},
     *          {"name"="company", "dataType"="String", "required"=false, "description"="Mã công ty"},
     *      }  
     * )
     */
    public function getAccesspointTotalAction(Request $request)
    { 
        $province   = $request->query->get('province', null);
        $company    = $request->query->get('company', null);

        if($province != null){
            
            // Tổng số accesspoint
            $total =  AccesspointQuery::create()
            ->withColumn('COUNT(*)', 'Count')
            ->select(array('Count'))
            ->filterByProvince($province)
            ->useI18nQuery('vi')->filterByTrash(0)->endUse()
            ->findOne();
            
            // Tổng số accesspoint online
            $online  =  AccesspointQuery::create()
            ->withColumn('COUNT(*)', 'Count')
            ->select(array('Count'))
            ->filterByProvince($province)
            ->useI18nQuery('vi')->filterByTrash(0)->endUse()
            ->where("accesspoint.updated_at >= DATE_SUB(NOW(),INTERVAL ? HOUR)", 2, \PDO::PARAM_INT)
            ->findOne();

            // Tổng số accesspoint offline từ hôm qua
            $offline_yesterday  =  AccesspointQuery::create()
            ->withColumn('COUNT(*)', 'Count')
            ->select(array('Count'))
            ->filterByProvince($province)
            ->useI18nQuery('vi')->filterByTrash(0)->endUse()
            ->where("DATE(accesspoint.updated_at) <= DATE_SUB(CURDATE(),INTERVAL ? DAY)", 1, \PDO::PARAM_INT)
            ->findOne();  

           // echo $offline_yesterday->toString();die; 

            // Accesspoint offline trong hôm nay (Cách đây 2h)
            $offline_twohour  =  AccesspointQuery::create()
            ->withColumn('COUNT(*)', 'Count')
            ->select(array('Count'))
            ->filterByProvince($province)
            ->useI18nQuery('vi')->filterByTrash(0)->endUse()
            ->where("CURDATE() <= accesspoint.updated_at AND accesspoint.updated_at <= DATE_SUB(NOW(),INTERVAL ? HOUR)", 2, \PDO::PARAM_INT)
            ->findOne();                     
            

            $result['code'] = 1;
            $result['message'] = $this->get('translator')->trans('success');

         
            $data = array();
            
            $obj = new \stdClass();
            $obj->total = $total;
            $obj->online = $online;
            $obj->offline_yesterday = $offline_yesterday;
            $obj->offline_today = $offline_twohour;
                
            $data = $obj;
            
            $result['data'] = $data;
            
        
        }else{
            $result['code'] = -5;
            $result['message'] = $this->get('translator')->trans('error_negative_5');
        }

        return new JsonResponse($result);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get list accesspoint status device",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      },
     *      parameters={
     *          {"name"="province", "dataType"="String", "required"=true, "description"="Mã tỉnh thành"},
     *          {"name"="company", "dataType"="String", "required"=false, "description"="Mã công ty"},
     *          {"name"="status", "dataType"="Integer", "required"=true, "description"="Trạng thái thiết bị:  0:online, 1: offline hôm nay, 2:offline từ hôm qua"},
     *          {"name"="page", "dataType"="Integer", "required"=false, "description"=""},
     *          {"name"="limit", "dataType"="Integer", "required"=false, "description"="0 <= limit <= 20"}
     *      }  
     * )
     */
    public function getAccesspointTotalDetailAction(Request $request) // "get_accesspoint"     [GET] 
    {
        $lprovince = \Common\DbBundle\Model\LocationQuery::create()->find();
        $ds_province = array();
        foreach ($lprovince as $key => $value){
            $ds_province[$value->getCode()] = $value->getName();
        }

        $province   = $request->query->get('province', null);
        $company    = $request->query->get('company', null);
        $status     = $request->query->get('status', null);
        $page       = $request->query->get('page', 1) <= 0 ? 1 : $request->query->get('page', 1); 
        $limit      = $request->query->get('limit', 20) < 0 ? 20 : $request->query->get('limit', 20) > 20 ? 20 : $request->query->get('limit', 20);

        if($province != null && $status != null){
            $conditions =  AccesspointQuery::create();

            $conditions->filterByProvince($province);
            
            if($status == 0){ // Online
                $conditions->where("accesspoint.updated_at >= DATE_SUB(NOW(),INTERVAL ? HOUR)", 2, \PDO::PARAM_INT);
            }elseif($status == 1){ // Offline hôm nay (Cách đây 2h)
                $conditions->where("CURDATE() <= accesspoint.updated_at AND accesspoint.updated_at <= DATE_SUB(NOW(),INTERVAL ? HOUR)", 2, \PDO::PARAM_INT);
            }elseif($status == 2){ // Offline từ hôm qua
                $conditions->where("DATE(accesspoint.updated_at) <= DATE_SUB(CURDATE(),INTERVAL ? DAY)", 1, \PDO::PARAM_INT);
            }

            $count = $conditions->count();

            $conditions->limit($limit)->offset(($page-1)*$limit)->orderByUpdatedAt('desc');

            $list = $conditions->find();

            $total_page = ceil($count / $limit);

            $result = array();

            $result['code'] = 1;
            $result['message'] = $this->get('translator')->trans('success');

            //page_info
            $page_info = array(
                'total'         =>  $total_page,
                'current'       =>  $page,
                'limit'         =>  $limit
            );
            $result['page_info'] = $page_info; 

            $data = array();
            foreach ($list as $key => $value) {
                $obj = new \stdClass();
                $obj->id = $value->getId();
                $obj->macaddr = $value->getMacaddr();
                $obj->name = $value->getName();
                $obj->address = $value->getAddress();
                $obj->province = isset($ds_province[$value->getProvince()]) ? $ds_province[$value->getProvince()] : null;
                $obj->ssid = str_replace("'",'', $value->getSsid());
                $obj->key = str_replace("'",'', $value->getKey());
                $obj->lat = (double)$value->getLat();
                $obj->lng = (double)$value->getLng();
                $obj->created_at = strtotime($value->getCreatedAt()->format('Y-m-d H:i:s')) * 1000;
                $obj->last_online = strtotime($value->getUpdatedAt()->format('Y-m-d H:i:s')) * 1000;
                
                $data[] = $obj;
            }
            
            $result['data'] = $data;
        }else{
            $result['code'] = -5;
            $result['message'] = $this->get('translator')->trans('error_negative_5');
        }

        return new JsonResponse($result);  
    } 

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Kiểm tra accesspoint theo IP",
     *      headers={
     *          { "name"="Authorization", "description"="Bearer Token", "required"=true },
     *          { "name"="Content-Type", "description"="application/x-www-form-urlencoded", "required"=true },
     *      },
     *      parameters={
     *          {"name"="ip", "dataType"="String", "required"=true, "description"=""},
     *      }  
     * )
     */
    public function postAccesspointCheckIpAction(Request $request)
    {   
        $lprovince = \Common\DbBundle\Model\LocationQuery::create()->find();
        $ds_province = array();
        foreach ($lprovince as $key => $value){
            $ds_province[$value->getCode()] = $value->getName();
        }

        $ip   = $request->get('ip', null);

        $result = array();

        if($ip != null){
            
            $result['code'] = 1;
            $result['message'] = $this->get('translator')->trans('success');

            $accesspont = \Hotspot\AccessPointBundle\Model\ApConfigQuery::create()->select(array('id','ip','ap_macaddr'))->filterByIp($ip)->find();

            $data = array();

            foreach ($accesspont as $kc => $ac) {
                
                $one = AccesspointQuery::create()->filterByMacaddr($ac['ap_macaddr'])->findOne();
                if($one){
                    $obj = new \stdClass();
                    $obj->id = $one->getId();
                    $obj->macaddr = $one->getMacaddr();
                    $obj->name = $one->getName();
                    $obj->address = $one->getAddress();
                    $obj->province = isset($ds_province[$one->getProvince()]) ? $ds_province[$one->getProvince()] : null;
                    $obj->ssid = str_replace("'",'', $one->getSsid());
                    $obj->key = str_replace("'",'', $one->getKey());
                    $obj->lat = (double)$one->getLat();
                    $obj->lng = (double)$one->getLng();
                    $obj->created_at = strtotime($value->getCreatedAt()->format('Y-m-d H:i:s')) * 1000;
                    $obj->last_online = strtotime($value->getUpdatedAt()->format('Y-m-d H:i:s')) * 1000;
                    $obj->ip = $ac['ip'];

                    $data[] = $obj;
                }
            }

            $result['data'] = $data;

        }else{
            $result['code'] = -5;
            $result['message'] = $this->get('translator')->trans('error_negative_5');
        }

    
        return new JsonResponse($result); 
    }
}
