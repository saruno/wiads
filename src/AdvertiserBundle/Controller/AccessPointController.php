<?php

namespace AdvertiserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hotspot\AccessPointBundle\Model\Accesspoint;
use AdvertiserBundle\Form\Type\AccesspointType;
use Symfony\Component\HttpFoundation\Request;
use Hotspot\AccessPointBundle\Model\AccesspointQuery;

class AccessPointController extends Controller
{
    
    public function listAction()
    {

        return $this->render('AdvertiserBundle:AccessPoint:list.html.twig');
    }

    public function addAction(Request $request){

        return $this->redirectToRoute('advertiser_dashboard');

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_01')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_02')
            && !$this->get('security.authorization_checker')->isGranted('ROLE_OPERATOR_LEVEl_03')) {
            return $this->redirectToRoute('advertiser_login');
        }

        $accesspoint = new Accesspoint();
        $form = $this->createForm(new AccesspointType(), $accesspoint);

        if ($request->getMethod() == 'POST') {
            $file = $_FILES['image'];
            $accp =  $request->request->get('accesspoint');
            
            $image = null;
            if(isset($file['name']) && !empty($file['name'])){
                $pram_file = array(
                    'name'      =>  $file['name'],
                    'type'      =>  $file['type'],
                    'tmp_name'  =>  $file['tmp_name'],
                    'size'      =>  $file['size']
                );
                $result = \AdvertiserBundle\Helper\FileHelper::uploadFile($pram_file, array(
                    'type_file'     =>  array('image/jpeg','image/png','image/gif','image/jpg'),
                    'root_dir'      =>  $this->getParameter('uploads_directory'),
                    'url_file'      =>  '/media/uploads/'
                ));
                $image = $result['name'];
            }

            if($accp['macaddr'] != '' && $accp['ssid'] != '' && $accp['name'] != '' && $accp['address']){
                $mac = trim(strtoupper($accp['macaddr']));
                $ap = AccesspointQuery::create()->filterByMacaddr($mac)->joinWithI18n('vi')->findOne();
                if(empty($ap)){

                    $latitude = \AdvertiserBundle\Helper\ProvinceHelper::getLatitude($accp['address'], $accp['province']);

                    $accesspoint->setMacaddr($mac);
                    $accesspoint->setApMacaddr($mac);
                    $accesspoint->setSsid('"'.$accp['ssid'].'"');
                    $key = !empty($accp['key']) ? '"'.$accp['key'].'"' : '';
                    $accesspoint->setKey($key);
                    $accesspoint->setIsp($accp['isp']);
                    $accesspoint->setProvince($accp['province']);
                    $accesspoint->setAdsLocation($accp['province']);
                    $accesspoint->setName($accp['name']);
                    $accesspoint->setAddress($accp['address']);
                    $accesspoint->setLocale('vi');
                    $accesspoint->setImage($image);
                    $accesspoint->setLng($latitude->lng);
                    $accesspoint->setLat($latitude->lat);
                    $accesspoint->setDetailUrl($accp['detail_url']);
                    if($accesspoint->save()){
                        $request->getSession()->getFlashBag()->add('success', 'Tạo điểm truy cập thành công!');
                    } else{
                        $request->getSession()->getFlashBag()->add('error', 'Có lỗi xảy ra!');
                    }
                }else{
                    $request->getSession()->getFlashBag()->add('error', 'Macaddr này đã tồn tại trên hệ thống!');
                }
            }else{
                $request->getSession()->getFlashBag()->add('error', 'Vui lòng nhập dữ liệu!');
            }
        }

        return $this->render('AdvertiserBundle:AccessPoint:add.html.twig', array(
            'form'      =>  $form->createView(),
            'js'        =>  array("/bundles/advertiser/assets/js/jquery.mask.js")
        ));
    }
    
}