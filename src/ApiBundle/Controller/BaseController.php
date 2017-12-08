<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;


class BaseController extends FOSRestController
{
	public function is_user()
	{
		if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) { 
            return new JsonResponse(array(
                'code'      =>  -1,
                'message'   => $this->get('translator')->trans('error_negative_1')
            ));
        }

        $user = $this->container->get('security.context')->getToken()->getUser();
        if($user) {
            return $user;
        }

        return new JsonResponse(array(
            'code'          =>  $this->get('translator')->trans('error_0'),
            'message'       => 'User is not identified'
        ));
	}

    protected function encodePassword(\Common\DbBundle\Model\User $user, $password)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }

    protected function currentPasswordIsValid(\Common\DbBundle\Model\User $user, $currentPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);

        $isValid = $encoder->isPasswordValid(
            $user->getPassword(), $currentPassword, null
        );

        if (!$isValid) {
            return false;
        }

        return true;
    }

    protected function put($parame = null, $default = null)
    {
        parse_str(file_get_contents("php://input"),$_PUT);

        if($parame == null && $default == null){
            return $_PUT;
        }
        
        if(isset($_PUT[$parame])) return $_PUT[$parame];
        else return $default;
    }
}