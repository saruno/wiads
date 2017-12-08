<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class UsersController extends BaseController 
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
    public function getUsersAction() // "get_users"     [GET] /users
    {   
        
        $user = $this->is_user();

        return new JsonResponse(array(
            'code'      =>  1,
            'message'   => $this->get('translator')->trans('success'),
            'data'      =>  array(
                'id'        =>  $user->getId(),
                'username'  =>  $user->getUsername(),
                'name'      =>  $user->getName(),
                'company'   =>  $user->getCompany(),
                'phone'     =>  $user->getPhone()
            )
        ));  
    } 

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Edit user",
     *      headers={
     *          { "name"="Authorization", "description"="Bearer Token", "required"=true },
     *          { "name"="Content-Type", "description"="application/x-www-form-urlencoded", "required"=true },
     *      },
     *      parameters={
     *          {"name"="name", "dataType"="String", "required"=false, "description"=""},
     *          {"name"="company", "dataType"="String", "required"=false, "description"=""},
     *          {"name"="phone", "dataType"="String", "required"=false, "description"=""}
     *      }     
     * )
     */
    public function postUsersEditAction(Request $request)
    {   

        $name             =   $request->get('name', null);
        $company          =   $request->get('company', null);
        $phone            =   $request->get('phone', null);
        
        $user = $this->is_user();

        $record = \Common\DbBundle\Model\Base\UserQuery::create()->filterById($user->getId())->findOne();

        if($record){
            if(isset($name) && !empty($name)){
                $record->setName($name);
            }
            if(isset($company) && !empty($company)){
                $record->setCompany($company);
            }
            if(isset($phone) && !empty($phone)){
                $record->setPhone($phone);
            }
            $record->save();
            return new JsonResponse(array(
                'code'      =>  1,
                'message'   => $this->get('translator')->trans('success')
            ));  
        }else{
            return new JsonResponse(array(
                'code'      =>  -4,
                'message'   => $this->get('translator')->trans('error_negative_4'),
            ));
        }  
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Change password user",
     *      headers={
     *          { "name"="Authorization", "description"="Bearer Token", "required"=true },
     *          { "name"="Content-Type", "description"="application/x-www-form-urlencoded", "required"=true },
     *      },
     *      parameters={
     *          {"name"="pw_current", "dataType"="String", "required"=true, "description"=""},
     *          {"name"="pw_new", "dataType"="String", "required"=true, "description"=""}
     *      }     
     * )
     */
    public function postUsersChangepassAction(Request $request)
    {
        parse_str(file_get_contents("php://input"),$_PUT); 

        $pw_current         =   $request->get('pw_current', null);
        $pw_new             =   $request->get('pw_new', null);
 
        $user = $this->is_user();

        $record = \Common\DbBundle\Model\Base\UserQuery::create()->filterById($user->getId())->findOne();

        if($record){
            if(isset($pw_current) && isset($pw_current)){
               
                $pw_check = $this->currentPasswordIsValid($record, $pw_current);

                if($pw_check){
                    if(strlen($pw_new) >= 6){
                        $record->setPassword($this->encodePassword($record, $pw_new));
                        $record->save();
                        return new JsonResponse(array(
                            'code'      =>  1,
                            'message'   => $this->get('translator')->trans('success')
                        ));
                    }else{
                        return new JsonResponse(array(
                            'code'      =>  -7,
                            'message'   => $this->get('translator')->trans('error_negative_7'),
                        ));    
                    }
                }else{
                    return new JsonResponse(array(
                        'code'      =>  -6,
                        'message'   => $this->get('translator')->trans('error_negative_6'),
                    ));
                }
            }else{
                return new JsonResponse(array(
                    'code'      =>  -5,
                    'message'   => $this->get('translator')->trans('error_negative_5'),
                ));    
            } 
        }else{
            return new JsonResponse(array(
                'code'      =>  -4,
                'message'   => $this->get('translator')->trans('error_negative_4'),
            ));
        }  
    }
}
