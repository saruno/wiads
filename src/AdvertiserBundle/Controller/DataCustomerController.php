<?php

namespace AdvertiserBundle\Controller;

use AdvertiserBundle\AdvertiserBundle;
use AppBundle\Helper\Utils;
use Common\DbBundle\Model\User;
use Hotspot\AccessPointBundle\Helper\UtilHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Common\DbBundle\Model\Advert;
use Common\DbBundle\Model\AdvertQuery;
use AdvertiserBundle\Form\Type\AdvertiserType;
use Symfony\Component\HttpFoundation\Request;
use AdvertiserBundle\Helper\AdvertiserHelper;
use AdvertiserBundle\Helper\PaginationHelper;
use Common\DbBundle\Model\CustomerQuery;
use Common\DbBundle\Model\GiftcodeQuery;
use Propel\Runtime\Propel as Propel;
use Symfony\Component\HttpFoundation\Response;
use Hotspot\AccessPointBundle\Model\AccesspointQuery;
use Common\DbBundle\Model\UserLoginQuery;


class DataCustomerController extends Controller
{
	
    public function giftcodeAction(Request $request)
    {

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->redirectToRoute('advertiser_notification_session'); 
        }
        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();
        
    	$giftcode_1 = $request->get('giftcode_1', 0);
 		$advert_id = $request->get('advert', 0);
 		$customer_id = $request->get('customer', 0);




        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            ||
            $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')
        ){
            $list_advert = AdvertQuery::create()->useAdvertI18nQuery()
                ->filterByPostBy($usr->getUsername())
                ->endUse()
                ->find();
            $list_customer = CustomerQuery::create()
                ->filterByOwner($usr->getUsername())
                ->find();
            $advert = AdvertQuery::create()->filterById($advert_id)
                ->useAdvertI18nQuery()
                ->filterByPostBy($usr->getUsername())
                ->endUse()
                ->findOne();
        }
 		else{
            $list_advert = AdvertQuery::create()->find();
            $list_customer = CustomerQuery::create()->find();
            $advert = AdvertQuery::create()->filterById($advert_id)->findOne();
        }
 		$customer = CustomerQuery::create()->filterById($customer_id)->findOne();

 		if($giftcode_1 == 1 && ($advert || $customer) ){

 			$advert_sql = $advert ? " AND advert_id = {$advert_id} " : "";
 			$customer_sql = $customer ? " AND customer_id = {$customer_id} " : "";


 			$day = date('d');
 			$month = date('m');
 			$year = date('Y');

 			$sql = "SELECT DATE(updated_at) AS date,YEAR(updated_at) AS year, MONTH(updated_at) AS month, DAY(updated_at) AS day , COUNT(id) AS count FROM giftcode WHERE status = 1 AND MONTH(updated_at) = {$month} AND YEAR(updated_at) = {$year} {$advert_sql} {$customer_sql} GROUP BY YEAR(updated_at),MONTH(updated_at), DAY(updated_at)";
 			$connection = Propel::getConnection();
			$stmt = $connection->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll(2);
			

 			$point = array();

 			for($i = 1; $i <= \AdvertiserBundle\Helper\SyntheticHelper::getNumberDayOnMonth($month); $i++){
 				$pxy = new \stdClass();
 				$pxy->x = $i;
 				$pxy->y = 0;

 				foreach ($result as $key => $value) {
 					if($value['day'] == $i){
 						$pxy->y = $value['count'];
 						break;
 					}
 				}

 				if($i == $day){
 					$pxy->markerColor = "red";
 				}
	 		
	 			$point[] = $pxy;
 			}

 			$point =  json_encode($point);

            // Lấy danh sách email đã nhận giftcode
            $d_current = date('Y-m-d');
            $d_from = strtotime("-6 days", strtotime($d_current));
            $d_from = date('Y-m-d', strtotime(date("Y-m-d", $d_from)));

            $sql = "SELECT G.id AS gid, G.email, G.value, G.type, G.customer_id,G.updated_at, A.id AS aid, A.title, (SELECT username FROM customer WHERE id = G.customer_id) AS customer  FROM giftcode AS G LEFT JOIN advert_i18n AS A ON G.advert_id = A.id  WHERE status = 1 AND ( DATE(G.updated_at) >= DATE('{$d_from}') AND DATE(G.updated_at) <= DATE('{$d_current}') ) {$advert_sql} {$customer_sql} ORDER BY updated_at ASC";
            $connection = Propel::getConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $list_email = $stmt->fetchAll(2);

 			
 			
 		    return $this->render('AdvertiserBundle:DataCustomer:giftcode_report.html.twig', array(
        	    'advert'  	=>  $advert,
        	    'customer'	=>	$customer,
        	    'day'		=>	$day,
        	    'month'		=>	$month,
        	    'year'		=>	$year,
        	    'point'		=>	$point,
                'd_current' =>  date('d-m-Y', strtotime($d_current)),
                'd_from'    =>  date('d-m-Y', strtotime($d_from)),
                'list_email'=>  $list_email,
        	    'js'		=>	array('/bundles/advertiser/matrix/js/canvasjs.min.js')
            ));
        }else{
        	return $this->render('AdvertiserBundle:DataCustomer:giftcode.html.twig', array(
        	    'list_advert' =>  $list_advert,
                'list_customer' =>  $list_customer
            ));
        }
    }

    public function giftcode_ajaxAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            return $this->redirectToRoute('advertiser_login');
        }
        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();

        $result = array();

        $type = $request->request->get('type');
        $month = $request->request->get('month');
        $year = $request->request->get('year');
        $advert_id = $request->request->get('advert');
        $customer_id = $request->request->get('customer');

        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            ||
            $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')
        ){
            $advert = AdvertQuery::create()->filterById($advert_id)
                ->useAdvertI18nQuery()
                ->filterByPostBy($usr->getUsername())
                ->endUse()
                ->findOne();
        }
        else{
            $advert = AdvertQuery::create()->filterById($advert_id)->findOne();
        }
        $customer = CustomerQuery::create()->filterById($customer_id)->findOne();

        if($advert || $customer){

 			$advert_sql = $advert  ? " AND advert_id = {$advert_id} " : "";
 			$customer_sql = $customer ? " AND customer_id = {$customer_id} " : "";
 		
            $day = date('d');
            
            if($type != 'ALL'){
                $type = "AND type = {$type}";
            }else{
                $type = "";
            }

            $sql = "SELECT DATE(updated_at) AS date,YEAR(updated_at) AS year, MONTH(updated_at) AS month, DAY(updated_at) AS day , COUNT(id) AS count FROM giftcode WHERE status = 1 AND MONTH(updated_at) = {$month} AND YEAR(updated_at) = {$year} {$type} {$advert_sql} {$customer_sql} GROUP BY YEAR(updated_at),MONTH(updated_at), DAY(updated_at)";
        
            $connection = Propel::getConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $res = $stmt->fetchAll(2);
            

            $point = array();

            for($i = 1; $i <= 31; $i++){
                $pxy = new \stdClass();
                $pxy->x = $i;
                $pxy->y = 0;

                foreach ($res as $key => $value) {
                    if($value['day'] == $i){
                        $pxy->y = $value['count'];
                        break;
                    }
                }

                if($i == $day){
                    $pxy->markerColor = "red";
                }
            
                $point[] = $pxy;
            }
            $result['code'] = 1;
            $result['data'] = $point;
        }else{
            $result['code'] = 0;
        }
        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function giftcode_email_ajaxAction(Request $request)
    {
        $result = array();

        $type = $request->request->get('type');
        $month = $request->request->get('month');
        $year = $request->request->get('year');
        $advert_id = $request->request->get('advert');
        $customer_id = $request->request->get('customer');
        $d_current = $request->request->get('date_to');
        $d_from = $request->request->get('date_from');

        $advert = AdvertQuery::create()->filterById($advert_id)->findOne();
        $customer = CustomerQuery::create()->filterById($customer_id)->findOne();

        if($advert || $customer){

            $advert_sql = $advert  ? " AND advert_id = {$advert_id} " : "";
            $customer_sql = $customer ? " AND customer_id = {$customer_id} " : "";
        
      
            $type = $type != 'ALL' ? "AND type = {$type} " : "";

            // Lấy danh sách email đã nhận giftcode
            $d_current = date('Y-m-d', strtotime($d_current));
            $d_from = date('Y-m-d', strtotime($d_from));

            $sql = "SELECT G.id AS gid, G.email, G.value, G.type, G.customer_id,G.updated_at, A.id AS aid, A.title, (SELECT username FROM customer WHERE id = G.customer_id) AS customer  FROM giftcode AS G LEFT JOIN advert_i18n AS A ON G.advert_id = A.id  WHERE status = 1 AND ( DATE(G.updated_at) >= DATE('{$d_from}') AND DATE(G.updated_at) <= DATE('{$d_current}') ) {$type} {$advert_sql} {$customer_sql} ORDER BY updated_at ASC";
            $connection = Propel::getConnection();
            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $list_email = $stmt->fetchAll(2);

            $result['code'] = 1;
            $result['data'] = $list_email;
        }else{
            $result['code'] = 0;
        }

        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /** ---------------------------------------------------
        --------------------------------------------------- ***/

    /* Tra cứu thông tin User Login bằng facebook và form */
    public function main_user_loginAction(Request $request){

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->redirectToRoute('advertiser_notification_session'); 
        }

        $params = array();

        $usr = $this->get('security.context')->getToken()->getUser();
        $username = $usr->getUsername();

        $arr_province = array();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')){
            $arr_province = \AdvertiserBundle\Helper\ProvinceHelper::getProvince();
        }elseif($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02') || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')){
            $arr_province = \AdvertiserBundle\Helper\ProvinceHelper::getProvinceOwner($username);
        }

        $params['province'] = $arr_province;

        $d_current = date('Y-m-d');
        $d_from = strtotime("-6 days", strtotime($d_current));
        $d_from = date('Y-m-d', strtotime(date("Y-m-d", $d_from)));

        $ap = AccesspointQuery::create()
            ->select(array('ap_macaddr'))
            ->filterByOwner($username)
            ->find();

        return $this->render('AdvertiserBundle:DataCustomer:main_user_login.html.twig', array(
            'params'        =>  $params,
            'd_from'        =>  date('Y-m-d', strtotime($d_from)),
            'css'           =>  array('/bundles/advertiser/matrix/daterangepicker/daterangepicker.css', '/bundles/advertiser/matrix/daterangepicker/bootstrap_pic.css'),
            'js'            =>  array('/bundles/advertiser/matrix/daterangepicker/moment.min.js', '/bundles/advertiser/matrix/daterangepicker/daterangepicker.js', '/bundles/advertiser/matrix/js/canvasjs.min.js')
        ));
    }

    public function user_login_requestAction(Request $request){
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            exit;
        }

        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();
        $username = $usr->getUsername();

        $province       = $request->get('province', '');
        $type           = $request->get('type', 'all');
        $date_choice    = $request->get('d_from', date('Y-m-d'));
        
        $sub_start      = $request->get('sub_start', date('Y-m-d'));
        $sub_end        = $request->get('sub_end', date('Y-m-d'));
        
        $sub_start      = date('Y-m-d', strtotime($sub_start));
        $sub_end        = date('Y-m-d', strtotime($sub_end));

        $page           = $request->get('page', 1);
        $limit          = 10;


        if($province != '') {
            $result = array();
            $list_mac = array();

            if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')) {
              
            } elseif ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02') || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {

            }
            $mac = AccesspointQuery::create()->select(array('ap_macaddr'))
                ->filterByProvince($province)
                ->useAccesspointI18nQuery()
                    ->filterByPostBy($username)
                ->endUse()->find(); 
            foreach ($mac as $key => $value){
                $list_mac[$key] = $value;
            } 
            $list_mac = array_unique($list_mac);
            $con = 0;
            if($type == 'all') {
                $dt = UserLoginQuery::create()
                    ->select(array('id','uid','email','type','fullname','username','phone','ap_macaddr','created_at'))
                    ->where('user_login.ap_macaddr IN ?', $list_mac)
                    //->where('user_login.created_at >= ?', $sub_start)
                    ->condition('cond2', 'DATE(user_login.created_at) >= DATE(?)', $sub_start)
                    ->condition('cond3', 'DATE(user_login.created_at) <= DATE(?)', $sub_end)
                    ->combine(array('cond2', 'cond3'), 'and', 'cond23')  
                    ->where(array('cond23'), 'and')
                    ->limit($limit)
                    ->offset($page-1)
                    ->find();
                    //$c = Propel::getConnection()->getLastExecutedQuery(); // Returns fully qualified SQL
                    //echo $c;die;
                $q = UserLoginQuery::create()
                    ->select(array('id'))
                    ->where('user_login.ap_macaddr IN ?', $list_mac)
                    //->where('user_login.created_at >= ?', $sub_start)
                    ->condition('cond2', 'DATE(user_login.created_at) >= DATE(?)', $sub_start)
                    ->condition('cond3', 'DATE(user_login.created_at) <= DATE(?)', $sub_end)
                    ->combine(array('cond2', 'cond3'), 'and', 'cond23')  
                    ->where(array('cond23'), 'and')
                    ->find();
                $con = $q->count();
                
            }else{
                $dt = UserLoginQuery::create()
                    ->select(array('id','uid','email','type','fullname','username','phone','ap_macaddr','created_at'))
                    ->where('user_login.ap_macaddr IN ?', $list_mac)
                    //->where('user_login.created_at >= ?', $day_form)
                    ->condition('cond2', 'DATE(user_login.created_at) >= DATE(?)', $sub_start)
                    ->condition('cond3', 'DATE(user_login.created_at) <= DATE(?)', $sub_end)
                    ->combine(array('cond2', 'cond3'), 'and', 'cond23')  
                    ->where(array('cond23'), 'and')
                    ->filterByType($type)
                    ->limit($limit)
                    ->offset($page-1)
                    ->find();

                $q = UserLoginQuery::create()
                    ->select(array('id'))
                    ->where('user_login.ap_macaddr IN ?', $list_mac)
                    //->where('user_login.created_at >= ?', $day_form)
                    ->condition('cond2', 'DATE(user_login.created_at) >= DATE(?)', $sub_start)
                    ->condition('cond3', 'DATE(user_login.created_at) <= DATE(?)', $sub_end)
                    ->combine(array('cond2', 'cond3'), 'and', 'cond23')  
                    ->where(array('cond23'), 'and')
                    ->filterByType($type)
                    ->find();
                $con = $q->count();
            }

            if($page == 1){   
                $i = 1;    
            }else{
                $i = $page * $limit - ($limit - 1);
            }
            $data = array();
            foreach ($dt as $key => $value){ 
                $row = array();
                $row['stt']            = $i;
                $row['uid']            = $value['uid'] != null ? $value['uid'] : '';
                $row['email']          = $value['email'];
                $row['type']           = ucwords($value['type']);
                $row['fullname']       = $value['fullname'];
                $row['phone']          = $value['phone'] != null ? $value['phone'] : '';
                $row['app_macaddr']    = $value['ap_macaddr'];
                $row['created_at']     = date("d-m-Y", strtotime($value['created_at']));

                $data[] = $row;
                
                $i++;
            }
            
            $pagin = array(
                'page'      =>  $page,
                'total'     =>  ceil($con/$limit)
            );
            

            $result['data']  = $data;
            $result['pagin'] = $pagin;


            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }
}