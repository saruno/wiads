<?php

namespace AdvertiserBundle\Controller;

use AdvertiserBundle\AdvertiserBundle;
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

class LocationController extends Controller
{

	/*
     * List location */
    public function listAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->redirectToRoute('advertiser_notification_session'); 
        }

        return $this->render('AdvertiserBundle:Location:list.html.twig');
    }

    public function getAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')) {
            $request->getSession()->getFlashBag()->add('error', 'Không có quyền truy cập!');
            return $this->redirectToRoute('advertiser_notification_session'); 
        }
        /** @var User $usr */
        $usr = $this->get('security.context')->getToken()->getUser();
        $username = $usr->getUsername();

        $requestData = $_REQUEST;
        $columns = array( 
        // datatable column index  => database column name
            0   =>    'id',
            1   =>    'name', 
            2   =>    'code'
        );
        // getting total number records without any search
        $sql = "SELECT id,name,code FROM location WHERE 1 = 1 ";
        
        $connection = Propel::getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute(); 
        $totalData = count($stmt->fetchAll(2));
        $totalFiltered = $totalData;


        $stmt = $connection->prepare($sql);
        $stmt->execute(); 

        $query = $stmt->fetchAll(2);
        
        $data = array();
        foreach ($query as $key => $value) {
            $nestedData = array(); 
            $nestedData[] = $value['id'];
            $nestedData[] = $value['name'];
            $nestedData[] = $value['code'];
            
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
}
