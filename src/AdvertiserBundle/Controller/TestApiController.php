<?php

namespace AdvertiserBundle\Controller;

use AdvertiserBundle\Helper\ApiHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestApiController extends Controller
{
    /**
     *  Hiển thị danh sách quảng cáo
     */
    public function getLinkPortalAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $accesspoint_id = $request->request->get('accesspoint_id');
            $ssid = $request->request->get('ssid');
            $status = $request->request->get('status');
            $fullname = $request->request->get('fullname');
            $wan_ip = $request->getClientIp();
            if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
                $wan_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $address='186 Bạch Đằng, DANANG';
            $geo='108.224291,16.065901';
            $result = ApiHelper::getAdsmeeLinkPortal ($accesspoint_id, $ssid, $fullname,$wan_ip, $address,$geo,$status);
            if(isset($result['status']) && $result['status'] == 1){
                $request->getSession()->getFlashBag()->add('success', json_encode($result));
            } else{
                $request->getSession()->getFlashBag()->add('error', json_encode($result));
            }

        }
        return $this->render('AdvertiserBundle:TestApi:linkportal.html.twig');
    }

    public function testadsAction(){
        return $this->render('AdvertiserBundle:TestApi:testads.html.twig');
    }
}