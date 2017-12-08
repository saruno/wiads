<?php

namespace AdvertiserBundle\Controller;

use Common\DbBundle\Model\CustomerQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Common\DbBundle\Model\Base\PromotionQuery;
use Common\DbBundle\Model\Promotion;

class CodePromotionController extends Controller
{
    public function indexAction(Request $request)
    {
        $customer = urldecode(trim($request->query->get('customer')));
        if(!empty($customer)){
            return $this->render('AdvertiserBundle:CodePromotion:index.html.twig', array(
                'customer'  =>  $customer
            ));
        } else{
            echo "Error";
            exit;
        }
    }

    public function getCodePromotionAction(Request $request){
        $customer = $request->request->get('customer');
        $result = array();
        if(!empty($customer)){
            $i = 0;
            while (true){
                $i++;
                if($i >= 5){
                    $code = strtoupper($customer).rand(0, 999999);
                }else{
                    $code = strtoupper($customer).rand(0, 9999);
                }
                $one = PromotionQuery::create()->filterByArray(array('code' => $code, 'customer' => $customer))->findOne();
                if(!$one){
                    break;
                }
            }

            $promotion = new Promotion();
            $promotion->setCode($code);
            $promotion->setCustomer($customer);
            $promotion->setType(1);
            $promotion->setStatus(0);
            $promotion->save();

            $result['status'] = 1;
            $result['code']   = $code;
        }else{
            $result['status'] = 0;
        }
        die(json_encode($result));
    }
    /**
     *  Quản lý mã khuyến mãi ứng với mỗi khách hàng
     */
    public function managerAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        $username=$usr->getUsername();
        //$customer = $usr->getUsername();
        $customer="";
        $cus=CustomerQuery::create()->filterByUsername($username)->findOne();
        if(count($cus)>0)
            $customer=$cus->getCode();
        //dump($customer);
        $status = 0;
        if ($request->getMethod() == 'POST') {

            $code = $request->request->get('code');
            if($request->request->get('check_code')){
                if(!empty($code)){
                    $one = PromotionQuery::create()->filterByArray(array('customer' => $customer, 'code' => $code))->findOne();
                    if($one){
                        if($one->getStatus() == 0){
                            $status = 1;
                            $request->getSession()->getFlashBag()->add('success', 'Mã khuyến mãi hợp lệ');
                        } else if($one->getStatus() == 1){
                            $request->getSession()->getFlashBag()->add('error', 'Mã khuyến mãi đã sử dụng');
                        }
                    }else{
                        $request->getSession()->getFlashBag()->add('error', 'Mã khuyến mãi không tồn tại trên hệ thống');
                    }
                    if($request->request->get('fullname')){

                    }
                }
            } elseif($request->request->get('_update')){
                $code = $request->request->get('code');
                $fullname = $request->request->get('fullname');
                $phone = $request->request->get('phone');
                $address = $request->request->get('address');

                $up = PromotionQuery::create()->filterByCode($code)->findOne();
                if($up){
                    $up->setStatus(1);
                    $up->setFullname($fullname);
                    $up->setPhone($phone);
                    $up->setAddress($address);
                    $up->save();
                    $request->getSession()->getFlashBag()->add('success', 'Cập nhật thành công');
                    $status = 1;
                } else{
                    $request->getSession()->getFlashBag()->add('error', 'Cập nhật thất bại');
                }
            }
        }
        return $this->render('AdvertiserBundle:CodePromotion:manager.html.twig', array(
            'code'      =>  isset($code) ? $code : '',
            'status'    =>  $status,
            'fullname'  =>  isset($fullname) ? $fullname : '',
            'phone'     =>  isset($phone) ? $phone : '',
            'address'   =>  isset($address) ? $address : '',
        ));
    }

    /**
     * List Ma khuyen mai
     */
    public function listAction(Request $request)
    {
        $usr= $this->get('security.context')->getToken()->getUser();
        $customer = $usr->getUsername();

        $aaData = array();
        $list = PromotionQuery::create()->filterByCustomer($customer)->find();

        //$pager = $this->getPager('table', $q, $request->getParameter('page', $this->getPage()), $request->getParameter('iDisplayLength'));
        foreach ($list as $key => $value){

            $aaData[] = array(
                "id"            => $value->getId(),
                "customer"      => $value->getCustomer(),
                "code"          => $value->getCode(),
                "phone"         => $value->getPhone(),
                "fullname"      => $value->getFullname(),
                "status"        => $value->getStatus() == 0 ? 'Chưa sử dụng' : 'Đã sử dụng',
                "cretead_at"    => '',
            );
        }

        //$result['data'] = $data;

        $output = array(
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => 10,//$request->getParameter('iDisplayLength'),
            "aaData" => $aaData,
        );

        die(json_encode($output));
    }
}