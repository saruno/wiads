<?php

namespace AdvertiserBundle\Controller;

use AdvertiserBundle\AdvertiserBundle;
use AppBundle\Helper\Utils;
use Hotspot\AccessPointBundle\Helper\UtilHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Common\DbBundle\Model\Advert;
use Common\DbBundle\Model\AdvertQuery;
use AdvertiserBundle\Form\Type\AdvertiserType;
use Symfony\Component\HttpFoundation\Request;
use AdvertiserBundle\Helper\AdvertiserHelper;
use AdvertiserBundle\Helper\PaginationHelper;
use Common\DbBundle\Model\CustomerQuery;
use Propel\Runtime\Propel;
use Symfony\Component\HttpFoundation\Response;

class CafeshopController extends Controller
{
	/**
     * Report Ads theo địa chỉ mac
     */
    public function report_adsAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_CAFESHOP')) {
            return $this->redirectToRoute('advertiser_login');
        }

        $page = $request->query->get('page',1);
        $limit = 10;

        $report = $request->query->get('report',0);
        $ap_mac = $request->query->get('mac','');
        
        $params=array(
            'report'    =>  $report,
            'limit'     =>  $limit,
            'offset'    =>  $page == 1 ? 0 : ($page-1)*$limit,
            'ap_mac'    =>  $ap_mac
        );

        $result = null;
        $paging = new PaginationHelper();
        if($report == 1){ 
            
            $total = AdvertiserHelper::getAdsReportApMacTotal($ap_mac, $params);
            $config = array(
                'current_page'  => $page, // Trang hiện tại
                'total_record'  => $total, // Tổng số record
                'limit'         => $limit,// limit
                'link_full'     => "reportmac?report=1&page={page}&mac={$ap_mac}",// Link full có dạng như sau: domain/com/page/{page}
                'link_first'    => "reportmac?report=1&page=1&mac={$ap_mac}",// Link trang đầu tiên
            );
            $result = AdvertiserHelper::getAdsReportApMac($ap_mac, $params);
            
            $paging->init($config);
        }

        return $this->render('AdvertiserBundle:Cafeshop:report_ads.html.twig', array(
            'result'    =>  $result,
            'params'    =>  $params,
            'paging'    =>  $paging,
            'stt'       =>  $page <= 1 ? 0 : ($page*$limit) - $limit
        ));
    }
}