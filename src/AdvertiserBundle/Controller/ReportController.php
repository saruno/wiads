<?php

namespace AdvertiserBundle\Controller;

use AdvertiserBundle\AdvertiserBundle;
use Common\DbBundle\Model\User;
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

class ReportController extends Controller
{

	public function adsAction(Request $request){
		
		$submit = $request->get('submit', 0);
		$customer_id = $request->get('customer_id', '');
		$date_from = $request->get('date_from', 0);
		$date_to = $request->get('date_to', date('Y-m-d'));



        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();
        $username = $usr->getUsername();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            ){
            $customer = CustomerQuery::create()->filterByOwner($username)->find();
        }
        else {
            $customer = CustomerQuery::create()->find();
        }

        if($date_from == 0){
        	$date_from = strtotime("-6 days", strtotime($date_to));
        	$date_from = date('Y-m-d', strtotime(date("Y-m-d", $date_from)));
    	}
    	
    	$result = '';

        if($submit){
        	if(strtotime($date_from) <= strtotime($date_to)){
        		$date_from = date('Y-m-d', strtotime($date_from));
        		$date_to = date('Y-m-d', strtotime($date_to));
        		$result = \AdvertiserBundle\Helper\AdvertiserHelper::getAdsReport($customer_id, array('from_0' => $date_from, 'to' => $date_to));
        	}else{
        		$request->getSession()->getFlashBag()->add('error', 'Chọn ngày không hợp lệ!');
        	}
        }

		return $this->render('AdvertiserBundle:Report:ads.html.twig', array(
			'submit'		=>	$submit,			
            'customer'  	=>  $customer,
            'customer_id'	=>	$customer_id,
            'date_from' 	=>  date('d-m-Y', strtotime($date_from)),
            'date_to'		=>  date('d-m-Y', strtotime($date_to)),
            'result'		=>	$result,
        ));
	}

    public function indexAction(Request $request){


        return $this->render('HotspotAccessPointBundle:APConnect:report_v3.html.twig');
    }
}