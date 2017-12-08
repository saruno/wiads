<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Common\DbBundle\Helper\UserHelper as UserHelper;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class RoleController extends BaseController 
{
    
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get one user",
     *      headers={
     *          {
     *              "name"="Authorization",
     *              "description"="Bearer Token",
     *              "required"=true,
     *          }
     *      },
     * )
     */
    public function getRoleAction() // "get_role"     [GET] 
    {   
        $user = $this->is_user();

        $arrRoleId= array();
        $roles=array();
        UserHelper::getUserRolesAndRoleGroupsById($user->getId(), $arrRoleId, $roles);

        return new JsonResponse(array(
            'code'      =>  1,
            'message'   => $this->get('translator')->trans('success'),
            'data'      =>  $roles
        ));
    } 
}