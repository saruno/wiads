<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class CompanyController extends BaseController 
{
    
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get list company",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      }
     * )
     */
    public function getCompanyAction() // "get_company"     [GET] 
    {   
        $result = array();
        $result['code'] = 1;
        $result['message'] = $this->get('translator')->trans('success');
        $data = array();
        
        $obj = new \stdClass();
        $obj->name = 'WiAds';
        $obj->code = 'wiads';
        $data[] = $obj;
        
        $result['data'] = $data;

        return new JsonResponse($result);  
    } 
}