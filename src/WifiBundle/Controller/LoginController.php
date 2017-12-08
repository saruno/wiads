<?php

namespace WifiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Common\DbBundle\Model\UserQuery;
use Common\DbBundle\Model\User;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\RememberMeToken;

class LoginController extends Controller
{
    public function indexAction(Request $request)
    {
        
        /*if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $usr = $this->get('security.context')->getToken()->getUser();
            print_r($usr);

            $key = $this->container->getParameter('secret');

            $token = new RememberMeToken($usr, 'wifi_area', $key); 
            //$this->get('security.context')->setToken($token);
            echo $token;
        }*/

    	$authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('wifi_login_check'))
            ->setMethod('POST')
            ->getForm();
            
        
        return $this->render('WifiBundle:Login:index.html.twig', array(
        	'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}