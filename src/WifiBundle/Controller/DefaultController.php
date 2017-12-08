<?php

namespace WifiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {	
   		if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $usr = $this->get('security.context')->getToken()->getUser();
        }
    	
    	

        return $this->render('WifiBundle:Default:index.html.twig');
    }
}
