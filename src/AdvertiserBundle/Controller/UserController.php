<?php

namespace AdvertiserBundle\Controller;

use Common\DbBundle\Model\Base\RoleAssignQuery;
use Common\DbBundle\Model\CustomerQuery;
use Hotspot\AccessPointBundle\Helper\ApConfigHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Common\DbBundle\Model\Base\UserQuery;
use Common\DbBundle\Model\User;
use Common\DbBundle\Model\Customer;
use Common\DbBundle\Model\RoleAssign;
use Common\DbBundle\Model\RoleGroupQuery;
use Common\DbBundle\Model\RoleGroup;
use Propel\Runtime\Propel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;

class UserController extends BaseController
{
    
    /*
     * Danh sach tài khoản */
    public function listAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->render('AdvertiserBundle::notification.html.twig');
        }

        $this->setModel('User');
        $this->index();
        $this->view_data['post_url'] = $this->get('router')->generate('advertiser_user_list_get');


        return $this->render('AdvertiserBundle:User:list.html.twig', $this->view_data);
    }


    public function getAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->render('AdvertiserBundle::notification.html.twig');
        }
        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();
        $username = $usr->getUsername();

        $requestData = $_REQUEST;
        $columns = array( 
        // datatable column index  => database column name
            0   =>    'id',
            1   =>    'username', 
            2   =>    'name',
            3   =>    'company',
            4   =>    'type',
            5   =>    'locked',
        );
        // getting total number records without any search
        $sql = "SELECT U.id,U.username, U.name, U.company,C.type, U.locked ";
        $sql.=" FROM user AS U JOIN customer AS C ON U.username = C.username WHERE 1 = 1 AND C.type != 'operator' ";
        if(!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')){
            if ($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02') || $this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')){
                $sql.= " AND owner='".$username."'";
            }
        }
        
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute(); 
        $totalData = count($stmt->fetchAll(2));
        $totalFiltered = $totalData;

        // getting records as per search parameters
        if( !empty($requestData['columns'][1]['search']['value']) ){   //name
            $sql.=" AND U.id LIKE '".$requestData['columns'][1]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){   //name
            $sql.=" AND U.username LIKE '".$requestData['columns'][2]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][3]['search']['value']) ){  //salary
            $sql.=" AND U.name LIKE '".$requestData['columns'][3]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][4]['search']['value']) ){ //age
            $sql.=" AND U.company LIKE '".$requestData['columns'][4]['search']['value']."%' ";
        }
        if($requestData['columns'][5]['search']['value'] != '' && $requestData['columns'][4]['search']['value'] != 'all' ){ //age
            $sql.=" AND C.type = '".$requestData['columns'][5]['search']['value']."' ";
        }
       
        if($requestData['columns'][6]['search']['value'] != '' && $requestData['columns'][6]['search']['value'] != 'all' ){ //age
            $sql.=" AND U.locked = '".$requestData['columns'][6]['search']['value']."' ";
        }
        

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

        $stmt = $connection->prepare($sql);
        $stmt->execute(); 

        $query = $stmt->fetchAll(2);
        
        $data = array();
        foreach ($query as $key => $value) {
            $nestedData = new \stdClass();  
            $nestedData->id = $value['id'];
            $nestedData->username = $value['username'];
            $nestedData->name = $value['name'];
            $nestedData->company = $value['company'];
            if($value['type'] == 'customer'){
                $type = 'Quảng cáo';
            }elseif($value['type'] == 'cafeshop'){
                $type = 'Chủ quán';
            }else{
                $type = 'Chưa xác định';
            }
            $nestedData->type = $type;
            $nestedData->locked = $value['locked'] == 0 ? 'Kích hoạt' : 'Khóa';
            $url_edit = $this->get('router')->generate('advertiser_user_edit').'/'.$value['id'];
            $url_delete = $this->get('router')->generate('advertiser_user_delete').'/'.$value['id'];
            $nestedData->action = '<a href="'.$url_edit.'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Sửa</a> <a href="'.$url_delete.'" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i> Xóa</a>';
            
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   
            "recordsTotal"    => intval( $totalData ), 
            "recordsFiltered" => intval( $totalFiltered ), 
            "data"            => $data   
        );
        $response = new Response(json_encode($json_data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     *  Edit
     */
    public function editAction(Request $request, $id){

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->render('AdvertiserBundle::notification.html.twig');
        }
        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();

        $record = UserQuery::create()->filterById($id)->findOne();
        if($record) {
            
            if($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')){
                $customer = CustomerQuery::create()->filterByUsername($record->getUsername())->findOne();
            }else{
                $customer = CustomerQuery::create()->filterByUsername($record->getUsername())->filterByOwner($usr->getUsername())->findOne();
            }
            $role_assign = RoleAssignQuery::create()->findOneByUserId($record->getId());
            $role_group = RoleGroupQuery::create()->find();
            if($role_assign){
                $role_group_id = $role_assign != '' ? $role_assign->getRoleGroupId() : 0;
            }

            if($customer && $role_assign) {

                $submit = $request->get('submit', 0);

                $email = $request->get('email', $record->getEmail());
                $locked = $request->get('locked', $record->getLocked());
                $name = $request->get('name', $record->getName());
                $phone = $request->get('phone', $record->getPhone());
                $company = $request->get('company', $record->getCompany());
                $role_group_id = $request->get('role_group_id', $role_group_id);
                $type = $request->get('type', '');
                $strUserAccesspoint = $request->get('user_accesspoint', 'miss_request');
                if ($strUserAccesspoint == 'miss_request') {
                    $strUserAccesspoint = '';
                    $recordUserAccesspoint = ApConfigHelper::getUserAccesspoint($record->getUsername());
                    foreach ($recordUserAccesspoint as $oneRecord) {
                        $strUserAccesspoint .= $oneRecord['ap_macaddr'] . ',';
                    }
                    $strUserAccesspoint = substr($strUserAccesspoint, 0, -1);
                }
                $params = array(
                    'id' => $record->getId(),
                    'username' => $record->getUsername(),
                    'locked' => $locked,
                    'email' => $email,
                    'name' => $name,
                    'phone' => $phone,
                    'company' => $company,
                    'user_accesspoint' => $strUserAccesspoint,
                    'customer_type' => $customer->getType()
                );

                if ($submit == 1) {

                    $record->setName($name);
                    $record->setLocked($locked);
                    $record->setEmail($email);
                    $record->setPhone($phone);
                    $record->setCompany($company);
                    $record->save();

                    $customer->setType($type);
                    $customer->save();

                    $role_group_id = $role_group_id == 0 ? '' : $role_group_id;
                    $role_assign->setRoleGroupId($role_group_id);
                    $role_assign->save();

                    ApConfigHelper::deleteUserAccesspoint($record->getUsername());
                    $arrUserAccessPoint = explode(",", $strUserAccesspoint);
                    foreach ($arrUserAccessPoint as $oneAccessP) {
                        if (!empty(trim($oneAccessP))) {
                            ApConfigHelper::insertUserAccesspoint($record->getUsername(), trim($oneAccessP));
                        }
                    }

                    $request->getSession()->getFlashBag()->add('success', 'Hiệu chỉnh tài khoản thành công!');
                }

                return $this->render('AdvertiserBundle:User:edit.html.twig', array(
                    'params' => $params,
                    'customer' => $customer,
                    'role_assign' => $role_assign,
                    'role_group' => $role_group,
                    'role_group_id' => $role_group_id
                ));
            }else{
                $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
                return $this->render('AdvertiserBundle::notification.html.twig');  
            }
        }else{
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->render('AdvertiserBundle::notification.html.twig');  
        }
    }

    /**
     *  Reset Password
     */
    public function resetpassAction(Request $request, $id = 0)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->render('AdvertiserBundle::notification.html.twig');
        }

        if($id == 0) return $this->redirectToRoute('advertiser_homepage');

        $usr = $this->get('security.context')->getToken()->getUser();

        $record = UserQuery::create()->filterById($id)->findOne();
        if($record) {
            $submit = $request->get('submit', 0);
            $passnew = $request->get('passnew', rand(6,40000));

            $params = array(
                'username'  =>  $record->getUsername(),
                'passnew'	=>	$passnew,
            );
            if($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')){
                $customer = CustomerQuery::create()->filterByUsername($record->getUsername())->findOne();
            }else{
                $customer = CustomerQuery::create()->filterByUsername($record->getUsername())->filterByOwner($usr->getUsername())->findOne();
            }
            if($customer){
                if($submit == 1){
                    if(!empty($passnew)){
                        $record->setPassword($this->encodePassword($record, $passnew));
                        $record->save();
                        $request->getSession()->getFlashBag()->add('success', 'Reset mật khẩu thành công! Mật khẩu là: <b>'.$passnew.'</b>');
                    }else{
                        $request->getSession()->getFlashBag()->add('error', 'Mật khẩu không hợp lệ!');
                    }
                }
            }else{
                $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
                return $this->redirectToRoute('advertiser_notification_session'); 
            }

            return $this->render('AdvertiserBundle:User:resetpass.html.twig', array(
                'params'	=>	$params
            ));
        }
    }

    /**
     *  Thêm user
     */
    public function addAction(Request $request)
    {   
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->render('AdvertiserBundle::notification.html.twig');
        }

        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();

    	$submit = $request->get('submit',0);
    	$user = new User();

        $role_group_id = $request->get('role_group_id','');
        $type = $request->get('type','customer');
        $username = $request->get('username','');
        $locked = $request->get('locked','');
        $email = $request->get('email','');
        $name = $request->get('name','');
        $phone = $request->get('phone','');
        $company = $request->get('company','');
        $password = $request->get('password',rand(6,40000));

        $role_group = RoleGroupQuery::create()->find();

        $params = array(
            'type'      =>  $type,
        	'username'	=>	$username,
            'locked'    =>  $locked,
            'email'     =>  $email,
            'name'      =>  $name,
            'phone'     =>  $phone,
            'company'   =>  $company,
        	'password'	=>	$password,
        );

        if($submit == 1){
            $role = ($type == 'customer') ? 6 : 13;  // 6 -> ROLE_ADS_REPORT, 13 -> ROLE_CAFESHOP
        	if(strlen($params['username']) >= 3 && strlen($params['password']) >= 3){
        		$user_one = UserQuery::create()->filterByUsername($username)->findOne();
        		if(!$user_one){
        			$user->setUserName($username);
                    $user->setLocked($locked);
                    $user->setEmail($email);
                    $user->setName($name);
                    $user->setPhone($phone);
                    $user->setCompany($company);
        			$user->setPassword($this->encodePassword($user, $password));
        			if($user->save()){
        				$role_assign = new RoleAssign();
                        $role_assign->setUserId($user->getId());
                        if ($type == 'cafeshop') {
                            $role_assign->setRoleId($role . ";" . "6");
                        } else {
                            $role_assign->setRoleId($role);
                        }
                        $role_group_id = $role_group_id == 0 ? '' : $role_group_id;
                        $role_assign->setRoleGroupId($role_group_id);
                        $role_assign->save();
                        $customer = new Customer();
                        $customer->setName($username);
                        $customer->setUsername($username);
                        $customer->setPhone($phone);
                        $customer->setEmail($email);
                        $customer->setType($type);
                        $customer->setCode($username);
                        $customer->setOwner($usr->getUsername());
                        $customer->save();
                        $request->getSession()->getFlashBag()->add('success', 'Tạo tài khoản thành công!');
        			}
        		}else{
        			$request->getSession()->getFlashBag()->add('error', 'Tài khoản đã tồn tại!');
        		}
        	}else{
        		$request->getSession()->getFlashBag()->add('error', 'Tài khoản hoặc mật khẩu phải hơn 3 ký tự!');
        	}
        }

        $this->view_data['params'] = $params;
        $this->view_data['role_group'] = $role_group;

        return $this->render('AdvertiserBundle:User:add.html.twig', $this->view_data);
    }

    /**
     *  Delete user
     */
    public function deleteAction(Request $request, $id = 0)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->render('AdvertiserBundle::notification.html.twig');
        }

        $usr = $this->get('security.context')->getToken()->getUser();

        $record = UserQuery::create()->filterById($id)->findOne();

        if($record) {

            if($this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')){
                $customer = CustomerQuery::create()->filterByUsername($record->getUsername())->findOne();
            }else{
                $customer = CustomerQuery::create()->filterByUsername($record->getUsername())->filterByOwner($usr->getUsername())->findOne();
            }
            if($customer){
                $role = RoleAssignQuery::create()->findOneByUserId($record->getId());
                if($role){
                    $role->delete();
                }
                //RoleAssignQuery::create()->findOneByUserId($record->getId())->delete();
                CustomerQuery::create()->findOneByUsername($record->getUsername())->delete();

                $record->delete();
                $request->getSession()->getFlashBag()->add('success', 'Xóa tài khoản thành công!');

                return $this->redirectToRoute('advertiser_user_list');
            }else{
                $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
                return $this->redirectToRoute('advertiser_notification_session'); 
            }
        }else{
            $request->getSession()->getFlashBag()->add('error', 'Không hợp lệ!');
        }
    }

    private function encodePassword(User $user, $password)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }
}