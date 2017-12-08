<?php

namespace AdvertiserBundle\Controller;

use AdvertiserBundle\AdvertiserBundle;
use AppBundle\Helper\Utils;
use Common\DbBundle\Model\User;
use Common\DbBundle\Model\UserQuery;
use Hotspot\AccessPointBundle\Helper\UtilHelper;
use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Common\DbBundle\Model\Advert;
use Common\DbBundle\Model\AdvertQuery;
use AdvertiserBundle\Form\Type\AdvertiserType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use AdvertiserBundle\Helper\AdvertiserHelper;
use AdvertiserBundle\Helper\PaginationHelper;
use Common\DbBundle\Model\CustomerQuery;
use Propel\Runtime\Propel;
use Symfony\Component\HttpFoundation\Response;

class AdvertiserController extends Controller
{

    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('advertiser_login_check'))
            ->setMethod('POST')
            ->getForm();

        return $this->render('AdvertiserBundle:Advertiser:login.html.twig', array(
            // last username entered by the user
            //'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    public function addAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_1')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_2')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_3')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->redirectToRoute('advertiser_notification_session'); 
        }
        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();

    	$submit = $request->get('submit',0);

    	$advertiser = new Advert();
        $form = $this->createForm(new AdvertiserType(), $advertiser);

        $customer = null;
        $company_arr= array();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_1')){
            $customer = CustomerQuery::create()
                ->select(array('id','username'))
                ->find();
            $company = UserQuery::create()
                ->select(array('id','username','company'))
                ->find();
            foreach ($company as $com){
                $company_arr[$com['company']]=$com['company'];
            }
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_2')){
            $customer = CustomerQuery::create()->
            filterByOwner($usr->getUsername())
                ->select(array('id','username'))
                ->find();
            $company = UserQuery::create()
                ->select(array('id','username','company'))
                ->find();
            foreach ($company as $com){
                $company_arr[$com['company']]=$com['company'];
            }
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_3')){
            $customer = CustomerQuery::create()
                ->filterByOwner($usr->getUsername())
                ->select(array('id','username'))
                ->find();
            $company_arr[$usr->getCompany()]=$usr->getCompany();
        }
        $form->remove('customer');
        $customer_arr=array();
        foreach ($customer as $cus){
            $customer_arr[$cus['id']]=$cus['username'];
        }
        $form->add('customer', ChoiceType::class,
            array(
            'choices'=>$customer_arr)
        );
        $form->add('company', ChoiceType::class,
            array(
                'choices'=>$company_arr)
        );


        $published = date('d-m-Y');
        $date = strtotime("+6 days", strtotime($published));
        $expired = date('d-m-Y', strtotime(date("Y-m-d", $date)));

        $error = 0;
        $params = array(
        	'published'	=>	$published,
        	'expired'	=>	$expired,
            'error'     =>  $error,
        );

        if($submit == 1){

            $advert_post = $request->get('advert');
            $location  = $request->get('location');
            $location_mac  = $request->get('location_mac');
            $platform  = $request->get('platform'); 

            if(is_array($platform) && $platform[0] != ''){
                if($location_mac != '' || (is_array($location) && $location[0] != '')){
                    
                    if($location_mac != ''){
                        $location = $location_mac;
                    }else{
                        if(in_array('ALL', $location)){
                            $location = \AdvertiserBundle\Helper\ProvinceHelper::getAllProvinceKey();
                        }else{
                            $location = implode(';', $location);
                        }   
                    }
                    
                
                    if(in_array('ALL', $platform)){
                        $platform = \AdvertiserBundle\Helper\ProvinceHelper::getAllPlatformKey();
                    }else{
                        $platform = implode(';', $platform);
                    }



                    $username = $usr->getUsername();
                    $cus = CustomerQuery::create()->filterByUsername($username)->findOne();

                    $img = array();
                    for ($i = 0; $i < count($_FILES['img']['name']); $i++){
                        $data = array(
                            'name'      =>  $_FILES['img']['name'][$i],
                            'type'      =>  $_FILES['img']['type'][$i],
                            'tmp_name'  =>  $_FILES['img']['tmp_name'][$i],
                            'size'      =>  $_FILES['img']['size'][$i]
                        );
                        $result = \AdvertiserBundle\Helper\FileHelper::uploadFile($data, array(
                            'type_file'     =>  array('image/jpeg','image/png','image/gif','image/jpg'),
                            'root_dir'      =>  $this->getParameter('uploads_directory'),
                            'url_file'      =>  '/media/uploads/'
                        ));
                        if($result != 0){
                            $img[] = $result;
                        }
                    }
                    $imgs = array();
                    $imgs_sizes = array();
                    foreach ($img as $key => $value){
                        $imgs[] = $value['name'];
                        $imgs_sizes[] = $value['width'].'x'.$value['height'];
                    }
                    $imgs = implode(',', $imgs);
                    $imgs_sizes = implode(',', $imgs_sizes);

                    $advertiser = new Advert();
                    $advertiser->setHomePosition($advert_post['home_position']);
                    $advertiser->setViewAtHomepage(1);
                    $advertiser->setLocation($location);
                    $advertiser->setPlatform($platform);
                    $advertiser->setPublishedAt(date('Y-m-d', strtotime($advert_post['published_at'])));
                    $advertiser->setExpiredAt(date('Y-m-d', strtotime($advert_post['expired_at'])));
                    $advertiser->setCustomerId($advert_post['customer']);
                    $advertiser->setImgs($imgs);
                    $advertiser->setImgsSizes($imgs_sizes);
                    $advertiser->setType(2);
                    $advertiser->setLocale('vi');
                    $advertiser->setTitle($advert_post['title']);
                    $advertiser->setDescription($advert_post['description']);
                    $advertiser->setCampagin($advert_post['campagin']);
                    $advertiser->setStripTitle(\AppBundle\Helper\Utils::slugify($advert_post['title']));
                    $advertiser->setPostBy($username);
                    $advertiser->setLink($advert_post['link']);
                    $advertiser->setLocked($advert_post['locked']);

                    $advertiser->save();

                    AdvertiserHelper::approveAds();

                    // Xử lý link
                    if(empty($advert_post['link_to'])){
                        $advertiser->setLinkTo("/ap/success_no_link?id=".$advertiser->getId());
                    } else{
                        $advertiser->setLinkTo($advert_post['link_to']);
                    }

                    $advertiser->save();
                    $request->getSession()->getFlashBag()->add('success', 'Tạo quảng cáo thành công!');
                }else{
                    $request->getSession()->getFlashBag()->add('error', 'Vui lòng chọn địa điểm hoặc quán');
                }
            }else{
                $request->getSession()->getFlashBag()->add('error', 'Vui lòng chọn nền tảng!');
            }
        }

    	return $this->render('AdvertiserBundle:Advertiser:add.html.twig', array(
            'form'               =>  $form->createView(),
            'params'	         =>	 $params,
            'option_province'    =>  \AdvertiserBundle\Helper\ProvinceHelper::selectProvince('add'),
            'option_platform'    =>  \AdvertiserBundle\Helper\ProvinceHelper::selectPlatform('add'),
            'css'                =>  array(),
            'js'                 =>  array(),
        ));
    }

    public function listAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_1')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_2')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_3')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->render('AdvertiserBundle::notification.html.twig');
        }
        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();
        $username = $usr->getUsername();
        $customer = null;
        
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_1')){
            $customer = CustomerQuery::create()->find();
        } elseif ($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_2')){
            $customer = CustomerQuery::create()->
                filterByOwner($username)
                ->find();
        }elseif ($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_3')){
            $customer = CustomerQuery::create()
                ->filterByOwner($username)
                ->find();
        }



        /*$total = AdvertQuery::create()->findByCustomerId($customer->getId())->count();
        $result = AdvertQuery::create()->limit($limit)->setOffset($offset)->findByCustomerId($customer->getId());
        $total = AdvertQuery::create()->join('Customer')->find()->count();
        $result = AdvertQuery::create()->join('Customer')->limit($limit)->setOffset($offset)->orderByCreatedAt('desc')->find();*/

        /*return $this->render('AdvertiserBundle:Advertiser:list.html.twig', array(
            'customer'  =>  $customer,
            'home_position'=>   \AdvertiserBundle\Helper\AdvertiserPositionHelper::Item(),
        ));*/

        //$this->setModel('Advertiser');
        //$this->index();

        $advertiser_m = new \AdvertiserBundle\Datatables\Advertiser();

        $view_data['json_data'] = $advertiser_m->json_data();
        $view_data['column_search'] = $advertiser_m->json_data(1);

        $view_data['post_url'] = $this->get('router')->generate('advertiser_ads_list_get');

        $ad = new \AdvertiserBundle\Datatables\Advertiser($this->container);

        return $this->render('AdvertiserBundle:Advertiser:list.html.twig', $view_data);
    }

    public function getAction(Request $request)
    {
        /*if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_1')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_2')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_3')) {
            return $this->redirectToRoute('advertiser_login');
        }*/
        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();

        $requestData = $_REQUEST;
        $columns = array( 
        // datatable column index  => database column name
            0   =>    'id',
            1   =>    'title', 
            2   =>    'home_position',
            3   =>    'customer_name',
            4   =>    'locked',
        );
        // getting total number records without any search
        $sql = "SELECT A.id, AI.title, A.home_position, C.username, AI.locked ";
        $sql.=" FROM advert AS A JOIN advert_i18n AS AI ON A.id = AI.id JOIN customer AS C ON A.customer_id = C.id WHERE 1 = 1 ";
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_1')){
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_2') || $this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_3') ){
                $sql.= " AND post_by='".$usr->getUsername()."'";
            }    
        }
        
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute(); 
        $totalData = count($stmt->fetchAll(2));
        $totalFiltered = $totalData;

        // getting records as per search parameters
        if( !empty($requestData['columns'][1]['search']['value']) ){   //name
            $sql.=" AND A.id LIKE '".$requestData['columns'][1]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][2]['search']['value']) ){   //name
            $sql.=" AND AI.title LIKE '".$requestData['columns'][2]['search']['value']."%' ";
        }
        if( !empty($requestData['columns'][3]['search']['value']) && $requestData['columns'][3]['search']['value'] != 'all' ){  //salary
            $sql.=" AND A.home_position = '".$requestData['columns'][3]['search']['value']."' ";
        }
        if( !empty($requestData['columns'][4]['search']['value']) && $requestData['columns'][4]['search']['value'] != 'all'){ //age
            $sql.=" AND C.username = '".$requestData['columns'][4]['search']['value']."' ";
        }
        if($requestData['columns'][5]['search']['value'] != '' && $requestData['columns'][5]['search']['value'] != 'all'  ){
            $sql.=" AND AI.locked = '".$requestData['columns'][5]['search']['value']."' ";
        }

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  // adding length

        $stmt = $connection->prepare($sql);
        $stmt->execute(); 

        $query = $stmt->fetchAll(2);
        
        $data = array();
        foreach ($query as $key => $value) {
            $nestedData = new \stdClass();  
            $nestedData->id = $value['id'];
            $nestedData->title = $value['title'];
            $nestedData->home_position = $value['home_position'];
            $nestedData->username = $value['username'];
            $nestedData->locked = $value['locked'] == 0 ? 'Mở' : 'Đóng';
        
            $url_edit = $this->get('router')->generate('advertiser_ads_edit').'/'.$value['id'];
            $url_delete = $this->get('router')->generate('advertiser_ads_delete').'/'.$value['id'];
            $url_show  = $this->get('router')->generate('advertiser_ads_show').'/'.$value['id'];
            $nestedData->action = '<a href="'.$url_show.'" target="_blank" class="btn btn-success btn-xs"><i class="fa fa-search-plus"></i> Xem</a><a href="'.$url_edit.'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Sửa</a> <a href="'.$url_delete.'" class="btn btn-danger btn-xs btn-delete"><i class="fa fa-trash-o"></i> Xóa</a>';
            

            $data[] = $nestedData;
        }
        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
        );
        $response = new Response(json_encode($json_data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function showAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_1')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_2')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_3')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->redirectToRoute('advertiser_notification_session');
        }
        $usr = $this->get('security.context')->getToken()->getUser();
        $username = $usr->getUsername();

        $customer = CustomerQuery::create()->filterByUsername($username)->findOne();

        //$record = AdvertQuery::create()->filterById($id)->filterByCustomerId($customer->getId())->findOne();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_1')){
            $record = AdvertQuery::create()->filterById($id)->findOne();
        }elseif($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_2') || $this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_3')){
            $record = AdvertQuery::create()->useAdvertI18nQuery()->filterByPostBy($username)->endUse()->filterById($id)->findOne();
        }

        //$record = AdvertQuery::create()->filterById($id)->findOne();

        if($record){
            $imgs = explode(',', $record->getImgs());
            return $this->render('AdvertiserBundle:Advertiser:show.html.twig', array(
                'record'    =>  $record,
                'img'       =>  isset($imgs[0]) ? $imgs[0] : '',
                'img_logo'  =>  isset($imgs[1]) ? $imgs[1] : '',
            ));
        }else{
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->redirectToRoute('advertiser_notification_session');
        }
    }

    public function editAction(Request $request,$id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_1')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_2')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_3')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->redirectToRoute('advertiser_notification_session');
        }
        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();
        $username = $usr->getUsername();
        $customer = null;

        $record=null;
        $company_arr= array();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_1')){
            $record = AdvertQuery::create()->filterById($id)->find();
            $customer = CustomerQuery::create()
                ->select(array('id','username'))
                ->find();
            $company = UserQuery::create()
                ->select(array('id','username','company'))
                ->find();
            foreach ($company as $com){
                $company_arr[$com['company']]=$com['company'];
            }
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_2')){
            $customer = CustomerQuery::create()->
            filterByOwner($usr->getUsername())
                ->select(array('id','username'))
                ->find();
            $company = UserQuery::create()
                ->select(array('id','username','company'))
                ->find();
            foreach ($company as $com){
                $company_arr[$com['company']]=$com['company'];
            }

        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADS_APPROVE_LEVEL_3')){
            $customer = CustomerQuery::create()
                ->filterByOwner($usr->getUsername())
                ->select(array('id','username'))
                ->find();
            $company_arr[$usr->getCompany()]=$usr->getCompany();
        }
        $customer_arr=array();
        $cus_id=array();
        foreach ($customer as $cus){
            $customer_arr[$cus['id']]=$cus['username'];
            $cus_id=$cus['id'];
        }
        foreach ($customer as $cus){
            $customer_arr[$cus['id']]=$cus['username'];
        }

        if(empty($record) && !empty($customer_arr))
            $record = AdvertQuery::create()
                ->filterByCustomerId($cus_id,Criteria::IN)
                ->filterById($id)->findOne();
        else{
            $record = AdvertQuery::create()
                ->filterById($id)->findOne();
        }
        if($record && $customer){
            $usr = $this->get('security.context')->getToken()->getUser();
            $submit = $request->get('submit',0);

            $published = $record->getPublishedAt()->format('d-m-Y');
            $expired = $record->getExpiredAt()->format('d-m-Y');

            $error = 0;

            if($submit == 1){

                $advert_post = $request->get('advert');
                $location  = $request->get('location');
                $platform  = $request->get('platform');
                $customer_id = $request->get('customer');

                if(!empty($location) && is_array($location) && $location[0] != '' && is_array($platform) && $platform[0] != ''){
                    if(in_array('ALL', $location)){
                        $location = \AdvertiserBundle\Helper\ProvinceHelper::getAllProvinceKey();
                    }else{
                        $location = implode(';', $location);
                    }

                    if(in_array('ALL', $platform)){
                        $platform = "";//\AdvertiserBundle\Helper\ProvinceHelper::getAllPlatformKey();
                    }else{
                        $platform = implode(';', $platform);
                    }

                    $username = $usr->getUsername();
                    $cus = CustomerQuery::create()->filterByUsername($username)->findOne();

                    $edit_img = 0;
                    if(!empty($_FILES['img']['name'][0]) && !empty($_FILES['img']['name'][1])){
                        $img = array();
                        for ($i = 0; $i < count($_FILES['img']['name']); $i++){
                            $data = array(
                                'name'      =>  $_FILES['img']['name'][$i],
                                'type'      =>  $_FILES['img']['type'][$i],
                                'tmp_name'  =>  $_FILES['img']['tmp_name'][$i],
                                'size'      =>  $_FILES['img']['size'][$i]
                            );
                            $result = \AdvertiserBundle\Helper\FileHelper::uploadFile($data, array(
                                'type_file'     =>  array('image/jpeg','image/png','image/gif','image/jpg'),
                                'root_dir'      =>  $this->getParameter('uploads_directory'),
                                'url_file'      =>  '/media/uploads/'
                            ));
                            if($result != 0){
                                $img[] = $result;
                            }
                        }
                        $imgs = array();
                        $imgs_sizes = array();
                        foreach ($img as $key => $value){
                            $imgs[] = $value['name'];
                            $imgs_sizes[] = $value['width'].'x'.$value['height'];
                        }
                        $imgs = implode(',', $imgs);
                        $imgs_sizes = implode(',', $imgs_sizes);
                        $edit_img = 1;
                    }

                    $record->setHomePosition($advert_post['home_position']);
                    $record->setViewAtHomepage(1);
                    $record->setLocation($location);
                    $record->setPlatform($platform);
                    $record->setPublishedAt(date('Y-m-d', strtotime($advert_post['published_at'])));
                    $record->setExpiredAt(date('Y-m-d', strtotime($advert_post['expired_at'])));
                    $record->setCustomerId($customer_id); //$cus->getId();
                    $edit_img == 1 ? $record->setImgs($imgs) : '';
                    $edit_img == 1 ? $record->setImgsSizes($imgs_sizes) : '';
                    $record->setType(2);
                    $record->setLocale('vi');
                    $record->setTitle($advert_post['title']);
                    $record->setDescription($advert_post['description']);
                    $record->setCampagin($advert_post['campagin']);
                    $record->setStripTitle(Utils::slugify($advert_post['title']));
                    $record->setPostBy($username);
                    $record->setLink($advert_post['link']);
                    $record->setLocked($advert_post['locked']);

                    // Xử lý link
                    if(empty($advert_post['link_to'])){
                        $record->setLinkTo("/ap/success_no_link?id=".$record->getId());
                    } else{
                        $record->setLinkTo($advert_post['link_to']);
                    }
                    $record->save();

	                AdvertiserHelper::approveAds();

                    $request->getSession()->getFlashBag()->add('success', 'Cập nhật quảng cáo thành công!');
                }else{
                    $request->getSession()->getFlashBag()->add('error', 'Vui lòng chọn địa điểm hoặc nền tảng!');
                }
            }

            $advertiser = new Advert();
            $advertiser->setTitle($record->getTitle());
            $advertiser->setCampagin($record->getCampagin());
            $advertiser->setDescription($record->getDescription());
            $advertiser->setLink($record->getLink());
            $advertiser->setHomePosition($record->getHomePosition());
            $advertiser->setLocked($record->getLocked());
            $advertiser->setCustomer($record->getCustomer());
            if($record->getLinkTo() != "/ap/success_no_link?id=".$record->getId()){
                $advertiser->setLinkTo($record->getLinkTo());
            }
            
            $form = $this->createForm(new AdvertiserType(), $advertiser);



            $params = array(
                'published'         =>  $published,
                'expired'           =>  $expired,
                'home_position'     =>  $record->getHomePosition(),
                'option_province'   =>  \AdvertiserBundle\Helper\ProvinceHelper::selectProvince('edit', $record->getLocation()),
                'option_platform'   =>  \AdvertiserBundle\Helper\ProvinceHelper::selectPlatform('edit', $record->getPlatform()),
                'customer'          =>  $customer_arr,
                'company'           =>  $company_arr,
                'error'             =>  $error,
            );

            return $this->render('AdvertiserBundle:Advertiser:edit.bk.html.twig', array(
                'record'        =>  $record,
                'list_position' => \AdvertiserBundle\Helper\AdvertiserPositionHelper::Item(),
                'form'          =>  $form->createView(),
                'params'        =>  $params
            ));
        } else{
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->redirectToRoute('advertiser_notification_session');
        }
    }

    public function deleteAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            return $this->redirectToRoute('advertiser_login');
        }
        $advert = AdvertQuery::create()->findOneById($id);
        if($advert){
            $advert->delete();
            $request->getSession()->getFlashBag()->add('success', 'Xóa quảng cáo thành công!');
        }
        return $this->redirectToRoute('advertiser_ads_list');
    }

}