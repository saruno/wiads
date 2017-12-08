<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class CustomerController extends BaseController 
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
    public function getCustomerAction() // "get_customer"     [GET] 
    {   
        $result = array();
        $result['code'] = 1;
        $result['message'] = $this->get('translator')->trans('success');
        $data = array();
        
        
        $result['data'] = $data;

        return new JsonResponse($result);  
    } 
}