<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ProvinceController extends BaseController 
{
    
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get list province",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      }
     * )
     */
    public function getProvinceAction() // "get_province"     [GET] 
    {   
        $province = \Common\DbBundle\Model\Base\LocationQuery::create()->find();
        $result = array();
        $result['code'] = 1;
        $result['message'] = $this->get('translator')->trans('success');
        $data = array();
        foreach ($province as $key => $value) {
            $obj = new \stdClass();
            $obj->name = $value->getName();
            $obj->code = $value->getCode();
            $data[] = $obj;
        }
        $result['data'] = $data;

        return new JsonResponse($result);  
    } 
}