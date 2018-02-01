<?php

namespace AdvertiserBundle\Controller;

use AdvertiserBundle\AdvertiserBundle;
use Common\DbBundle\Model\Advert;
use AdvertiserBundle\Form\Type\AdvertiserType;
use Common\DbBundle\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Hotspot\AccessPointBundle\Model\AccesspointQuery;
use Hotspot\AccessPointBundle\Model\Accesspoint;
use AdvertiserBundle\Helper\DashboardHelper;
use Common\DbBundle\Model\CustomerQuery;

class DashboardController extends Controller
{	
    
    public function indexAction(Request $request)
    {   
        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();
        $username = $usr->getUsername();

        $owner = '';
        $customer_id = '';

        $customer = CustomerQuery::create()->filterByUsername($username)->findOne();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')){
            $owner = '';
            $customer_id = '';
        }elseif ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
                 || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')
                 || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_04')
                 || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_05')
        ){
            $owner = $username;
        }else{
            $customer_id = $customer->getId();
            //$request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            //return $this->redirectToRoute('advertiser_notification_session');
        }
    	
        $dashboard = new DashboardHelper($owner, $customer_id); 

        $province_choice = $request->get('province', null);
        
        if($province_choice != null && $province_choice == 'all'){
            $province_choice = null;
        }

    	$d_current = date('Y-m-d');

        $start = $request->get('start', 0);
        $end = $request->get('end', 0);

        $province = $request->get('province', 'all');

        if($start == 0 && $end == 0){
        	$start = strtotime("-29 days", strtotime($d_current));
        	$start = date('Y-m-d', strtotime(date("Y-m-d", $start)));
        	$end = $d_current;
        }else{

        }

    	$time_ = array('start'=>$start, 'end'=>$end);

        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')){
            $province = \AdvertiserBundle\Helper\ProvinceHelper::getProvince();
        }elseif($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
                || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')
                || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_04')
                || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_05')
        ){
            $province = \AdvertiserBundle\Helper\ProvinceHelper::getProvinceOwner($username);
        }
	    if(empty($province)){
		    $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
		    return $this->redirectToRoute('advertiser_notification_session');
	    }
        if($province_choice != null && !array_key_exists($province_choice, $province)){
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->redirectToRoute('advertiser_notification_session');
        }
        
    	//$province = $dashboard->getProvince();

    	$data = $dashboard->getDataIndex($province_choice, $time_); 

        $chart = $dashboard->getChartLineAds($province_choice, $time_);
//        $chart = $dashboard->getChartLineAds2($province_choice, $time_);
        $total_advert = $dashboard->getTotalAdvertiser($province_choice, $time_); 

        $this->view_data['province'] = $province;
        $this->view_data['data'] = $data;
        $this->view_data['chart'] = $chart;
        $this->view_data['total_advert'] = $total_advert['total'];
        $this->view_data['province_choice'] = $province_choice;
        $this->view_data['time'] = $time_; //print_r($time_);

        return $this->render('AdvertiserBundle:Dashboard:index.html.twig', $this->view_data);
    }

}
