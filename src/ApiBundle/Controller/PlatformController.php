<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class PlatformController extends BaseController 
{
    
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get list customer",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      }
     * )
     */
    public function getPlatformAction() // "get_platform"     [GET] 
    {   
        $result = array();
        $result['code'] = 1;
        $result['message'] = $this->get('translator')->trans('success');
        $data = array();
        
        $list = array(
            'Android'       =>  'Android',
            'iPhone'        =>  'iPhone',
            'iPad'          =>  'iPad',
            'iPod'          =>  'iPod',
            'Windows'       =>  'Windows',
            'Windows Phone' =>  'Windows Phone',
            'BlackBerry'    =>  'BlackBerry',
            'Linux'         =>  'Linux',
            'Macintosh'     =>  'MAC',
            'PlayBook'      =>  'PlayBook',
            'Kindle Fire'   =>  'Kindle Fire',
            'Chrome OS'     =>  'Chrome OS'
        );

        foreach ($list as $key => $value) {
            $obj = new \stdClass();
            $obj->name = $value;
            $obj->code = $key;

            $data[] = $obj;
        }

        $result['data'] = $data;

        return new JsonResponse($result);  
    } 
}