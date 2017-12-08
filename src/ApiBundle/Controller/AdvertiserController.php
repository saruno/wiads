<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Common\DbBundle\Model\AdvertQuery;
use Hotspot\AccessPointBundle\Model\AdsDailyCountingQuery;

class AdvertiserController extends BaseController 
{
    
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get list advertiser",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      },
     *      parameters={
     *          {"name"="location", "dataType"="String", "required"=false, "description"="Mã tỉnh thành, địa chỉ macaddr"},
     *          {"name"="platform", "dataType"="String", "required"=false, "description"="Mã platform"},
     *          {"name"="status", "dataType"="Integer", "required"=false, "description"="0:Kích hoạt, 1: Đóng"},
     *          {"name"="owner", "dataType"="String", "required"=false, "description"="Người tạo"},
     *          {"name"="customer", "dataType"="String", "required"=false, "description"="Username khách hàng"},
     *          {"name"="from_date", "dataType"="Date","format"="Y-m-d", "required"=false, "description"="Time tạo ads"},
     *          {"name"="to_date", "dataType"="Date","format"="Y-m-d", "required"=false, "description"="Time tạo ads"},
     *          {"name"="page", "dataType"="Integer", "required"=false, "description"=""},
     *          {"name"="limit", "dataType"="Integer", "required"=false, "description"="0 <= limit <= 20"}
     *      }  
     * )
     */
    public function getAdvertiserAction(Request $request) // "get_advertiser"     [GET]
    {   
        $location   = $request->query->get('location', null);
        $platform   = $request->query->get('platform', null);
        $status     = $request->query->get('status', null);
        $owner      = $request->query->get('owner', null);
        $customer   = $request->query->get('customer', null);
        $from_date  = $request->query->get('from_date', null);
        $to_date    = $request->query->get('to_date', null);
        $page       = $request->query->get('page', 1) <= 0 ? 1 : $request->query->get('page', 1); 
        $limit      = $request->query->get('limit', 20) < 0 ? 20 : $request->query->get('limit', 20) > 20 ? 20 : $request->query->get('limit', 20);

        $conditions =  AdvertQuery::create();

        $conditions->where('advert.customer_id != ?', 'NULL');
        $owner != null ? $conditions->useI18nQuery('vi')->filterByPostBy($owner)->endUse() : '';
        $status != null ? $conditions->useI18nQuery('vi')->filterByLocked($status)->endUse() : '';

        if($customer != null){
            $conditions->joinCustomer()->where('customer.username = ?', $customer);
        }

        if($from_date != null && $to_date != null){
            $conditions ->condition('from', 'DATE(advert.published_at) >= DATE(?)', $from_date)
                ->condition('to', 'DATE(advert.published_at) <= DATE(?)', $to_date)
                ->combine(array('from', 'to'), 'and', 'from_to')
                ->where(array('from_to'), 'and');
        }


        $location != null ? $conditions->where('advert.location LIKE ?', '%'.$location.'%') : '';
        $platform != null ? $conditions->where('advert.platform LIKE ?', '%'.$platform.'%') : '';

        $count = $conditions->count();

        $conditions->limit($limit)->offset(($page-1)*$limit)->orderByCreatedAt('desc');

        $list = $conditions->find(); //echo $conditions->toString();die;

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
            $obj->title = $value->getTitle();
            $obj->status = $value->getLocked() == 0 ? 0 : 1;
            $obj->customer = $value->getCustomer()->getUsername();
            $obj->owner = $value->getPostBy();

            //$obj->location = explode(';', $value->getLocation());
            //$obj->platform = explode(';', $value->getPlatform());

            $obj->published_at = strtotime( $value->getPublishedAt()->format("Y-m-d H:i:s")) * 1000;
            $obj->expired_at = strtotime($value->getExpiredAt()->format('Y-m-d H:i:s')) * 1000;
            $obj->created_at = strtotime($value->getCreatedAt()->format('Y-m-d H:i:s')) * 1000;
            $obj->position = 'Full màn hình quảng cáo';

            $data[] = $obj;
        }
        $result['data'] = $data;

        return new JsonResponse($result);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get advertiser detail",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      },
     *      parameters={
     *          {"name"="id", "dataType"="Integer", "required"=true, "description"="ID quảng cáo"},
     *      }  
     * )
     */
    public function getAdvertiserDetailAction(Request $request)
    {
        $id = $request->query->get('id',null);

        $result = array();

        if($id !== null){
            $advert = AdvertQuery::create()->filterById($id)->findOne();
            if($advert){
                $result['code'] = 1;
                $result['message'] = $this->get('translator')->trans('success');

                $obj = new \stdClass();
                $obj->id = $advert->getId();
                $obj->title = $advert->getTitle();
                $obj->status = $advert->getLocked() == 0 ? 0 : 1;
                $obj->customer = $advert->getCustomer()->getUsername();
                $obj->owner = $advert->getPostBy();

                $obj->location = explode(';', $advert->getLocation());
                $obj->platform = explode(';', $advert->getPlatform());

                $obj->published_at = strtotime($advert->getPublishedAt()->format("Y-m-d H:i:s")) * 1000;
                $obj->expired_at = strtotime($advert->getExpiredAt()->format('Y-m-d H:i:s')) * 1000;
                $obj->created_at = strtotime($advert->getCreatedAt()->format('Y-m-d H:i:s')) * 1000;
                $obj->description = $advert->getDescription();
                $obj->campagin = $advert->getCampagin();
                $obj->link = $advert->getLink();

                $imgs = explode(',', $advert->getImgs());
                $http = \ApiBundle\Helper\AdvertiserHelper::getDomain();
                $obj->img_1 =  isset($imgs[0]) ? $http.$imgs[0] : '';
                $obj->img_2 =  isset($imgs[1]) ? $http.$imgs[1] : '';

                $obj->position = 'Full màn hình quảng cáo';

                $result['data'] = $obj;
            }else{
                $result['code'] = -8;
                $result['message'] = $this->get('translator')->trans('error_negative_8');
            }

        }else{
            $result['code'] = -5;
            $result['message'] = $this->get('translator')->trans('error_negative_5');
        }

        return new JsonResponse($result); 
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get advertiser update",
     *      headers={
     *          { "name"="Authorization", "description"="Bearer Token", "required"=true },
     *          { "name"="Content-Type", "description"="application/x-www-form-urlencoded", "required"=true },
     *      },
     *      parameters={
     *          {"name"="id", "dataType"="Integer", "required"=true, "description"="ID quảng cáo"},
     *          {"name"="title", "dataType"="String", "required"=false, "description"="Tên quảng cáo"},
     *          {"name"="campagin", "dataType"="String", "required"=false, "description"="Tên chiến dịch"},
     *          {"name"="description", "dataType"="String", "required"=false, "description"="Mô tả quảng cáo"},
     *          {"name"="location[]", "dataType"="Array", "required"=false, "description"="[HANOI,TTHUE]"},
     *          {"name"="platform[]", "dataType"="Array", "required"=false, "description"="[iPhone,Android]"},
     *          {"name"="published_at", "dataType"="Datetime", "required"=false, "format"="Y-m-d H:i:s", "description"="Ngày bắt đầu chạy ads"},
     *          {"name"="expired_at", "dataType"="Datetime", "required"=false, "format"="Y-m-d H:i:s", "description"="Ngày kết thúc chạy ads"},
     *          {"name"="link", "dataType"="Datetime", "required"=false, "format"="http://", "description"=""},
     *          {"name"="img_1", "dataType"="String", "required"=false, "format"="base64", "description"="width >= 640, heigh >= 717"},
     *          {"name"="img_2", "dataType"="String", "required"=false, "format"="base64", "description"="width >= 640, heigh >= 717"},
     *          {"name"="status", "dataType"="Integer", "required"=false, "description"="0:Kích hoạt, 1: Đóng"},
     *      }  
     * )
     */
    public function postAdvertiserUpdateAction(Request $request)
    {
        $id             =   $request->get('id', null);
        $title          =   $request->get('title', null);
        $campagin       =   $request->get('campagin', null);
        $description    =   $request->get('description', null);
        $location       =   $request->get('location', null);
        $platform       =   $request->get('platform', null);
        $published_at   =   $request->get('published_at', null);
        $expired_at     =   $request->get('expired_at', null);
        $link           =   $request->get('link', null);
        $img_1          =   $request->get('img_1', null);
        $img_2          =   $request->get('img_2', null);
        $status         =   $request->get('status', null);

        //print_r($location);

        $result = array();

        if($id !== null){
            $advert = AdvertQuery::create()->filterById($id)->findOne();
            if($advert){
                $title != null ? $advert->setTitle($title) : '';
                $campagin != null ? $advert->setCampagin() : '';
                $description != null ? $advert->setDescription() : '';
                is_array($location)  ? $advert->setLocation(implode(';', $location)) : '';
                is_array($platform)  ? $advert->setPlatform(implode(';', $platform)) : '';
                $published_at != null ? $advert->setPublishedAt($published_at) : '';
                $expired_at != null ? $advert->setExpiredAt($expired_at) : '';
                $link != null ? $advert->setLink($link) : '';
                $status != null ? $advert->setLocked($status) : '';

                if($img_1 != null){
                    $base64 = new \ApiBundle\Helper\Base64Helper($img_1);
                    if(!$base64->isBase64()){
                        return new JsonResponse(array(
                            'code'      =>  -9,
                            'message'   =>  $this->get('translator')->trans('error_negative_9')
                        )); 
                    }

                    if(!$base64->isImage()){
                        return new JsonResponse(array(
                            'code'      =>  -10,
                            'message'   =>  $this->get('translator')->trans('error_negative_10')
                        ));   
                    }
                    if($base64->getSizeMB() > 5){
                        return new JsonResponse(array(
                            'code'      =>  -11,
                            'message'   =>  $this->get('translator')->trans('error_negative_11')
                        ));   
                    }
                    
                    $re = $base64->Image($this->getParameter('uploads_directory'),'/media/mobile/', rand(1, 1000000));
                    $imgs = explode(',', $advert->getImgs());
                    $imgs_size = explode(',', $advert->getImgsSizes());
                    $img_new = array();
                    $img_size_new = array();
                    if(count($imgs) == 0){
                        $img_new[0] = $re['filename'];
                        $img_size_new[0] = $re['width'].'x'.$re['height'];
                    }elseif(count($imgs) == 1){
                        $img_new[0] = $re['filename'];
                        $img_size_new[0] = $re['width'].'x'.$re['height'];
                    }elseif(count($imgs) == 2){
                        $img_new[0] = $re['filename'];
                        $img_new[1] = $imgs[1]; 
                        $img_size_new[0] = $re['width'].'x'.$re['height'];
                        $img_size_new[1] = $imgs_size[1];
                    }
                    $advert->setImgs(implode(',', $img_new));
                    $advert->setImgsSizes(implode(',', $img_size_new));
                }
                if($img_2 != null){
                    $base64 = new \ApiBundle\Helper\Base64Helper($img_2);
                    if(!$base64->isBase64()){
                        return new JsonResponse(array(
                            'code'      =>  -9,
                            'message'   =>  $this->get('translator')->trans('error_negative_9')
                        )); 
                    }

                    if(!$base64->isImage()){
                        return new JsonResponse(array(
                            'code'      =>  -10,
                            'message'   =>  $this->get('translator')->trans('error_negative_10')
                        ));   
                    }
                    if($base64->getSizeMB() > 5){
                        return new JsonResponse(array(
                            'code'      =>  -11,
                            'message'   =>  $this->get('translator')->trans('error_negative_11')
                        ));   
                    }
                    
                    $re = $base64->Image($this->getParameter('uploads_directory'),'/media/mobile/', rand(1, 1000000));
                    $imgs = explode(',', $advert->getImgs());
                    $imgs_size = explode(',', $advert->getImgsSizes());
                    $img_new = array();
                    $img_size_new = array();
                    if(count($imgs) == 0){
                        $img_new[0] = $re['filename'];
                        $img_size_new[0] = $re['width'].'x'.$re['height'];
                    }elseif(count($imgs) == 1){
                        $img_new[0] = $imgs[0];
                        $img_size_new[0] = $imgs_size[0];
                        $img_new[1] = $re['filename'];
                        $img_size_new[1] = $re['width'].'x'.$re['height'];
                    }elseif(count($imgs) == 2){
                        $img_new[0] = $imgs[0]; 
                        $img_new[1] = $re['filename']; 
                        $img_size_new[0] = $imgs_size[0];
                        $img_size_new[1] = $re['width'].'x'.$re['height'];
                    }
                    $advert->setImgs(implode(',', $img_new));
                    $advert->setImgsSizes(implode(',', $img_size_new));
                }

                $advert->save();

                $result['code'] = 1;
                $result['message'] = $this->get('translator')->trans('success');

            }else{
                $result['code'] = -8;
                $result['message'] = $this->get('translator')->trans('error_negative_8');
            }

        }else{
            $result['code'] = -5;
            $result['message'] = $this->get('translator')->trans('error_negative_5');
        }

        return new JsonResponse($result); 
    }


    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get advertiser analytics",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      },
     *      parameters={
     *          {"name"="macaddr", "dataType"="String", "required"=true, "description"="Địa chỉ macaddr"},
     *          {"name"="from_date", "dataType"="Date","format"="Y-m-d", "required"=true, "description"="Thời gian bắt đầu"},
     *          {"name"="to_date", "dataType"="Date","format"="Y-m-d", "required"=true, "description"="Thơi gian kết thúc"}
     *      }  
     * )
     */
    public function getAdvertiserAnalyticsAction(Request $request)
    {
        $macaddr = $request->query->get('macaddr',null);
        $from_date = $request->query->get('from_date',null);
        $to_date = $request->query->get('to_date',null);
      

        $result = array();

        if($macaddr !== null && $from_date != null && $to_date != null){
            $conditions = AdsDailyCountingQuery::create();
            $conditions->withColumn('SUM(view_count)', 'impression');
            $conditions->withColumn('SUM(click_count)', 'click');
            $conditions->select(array('impression', 'click', 'date', 'advert_id'));
            $conditions->groupBy('ads_daily_counting.date');
            $conditions->filterByApMacaddr($macaddr);

            $conditions ->condition('from', 'DATE(ads_daily_counting.date) >= DATE(?)', $from_date)
                        ->condition('to', 'DATE(ads_daily_counting.date) <= DATE(?)', $to_date)
                        ->combine(array('from', 'to'), 'and', 'from_to')  
                        ->where(array('from_to'), 'and');

            $conditions->orderByDate('asc');

            $list = $conditions->find();

            $result['code'] = 1;
            $result['message'] = $this->get('translator')->trans('success');

            $total_impression = 0;
            $total_click = 0;

            $data = array();
            foreach ($list as $key => $value) {
                $obj = new \stdClass();
                
                $impression = $value['impression'] != null && $value['impression'] >= 0 ? $value['impression'] : 0;
                $click = $value['click'] != null && $value['click'] >= 0 ? $value['click'] : 0;

                $obj->impression = (int)$impression;
                $obj->click = (int)$click;
                $obj->date = $value['date'];
                $obj->advert_id = $value['advert_id'] != null && $value['advert_id'] > 0 ? $value['advert_id'] : null;
                
                $data[] = $obj;

                $total_impression += $impression;
                $total_click += $click;
            }

            $ctr = $total_impression != 0 && $total_impression > 0 ? round($total_click/$total_impression*100, 2) : 0;

            $result['info'] = array(
                'macaddr'       =>  $macaddr,
                'impression'    =>  $total_impression,
                'click'         =>  $total_click,
                'ctr'           =>  $ctr
            );
            
            $result['data'] = $data;
            
        }else{
            $result['code'] = -5;
            $result['message'] = $this->get('translator')->trans('error_negative_5');
        }

        return new JsonResponse($result); 
    }
}

