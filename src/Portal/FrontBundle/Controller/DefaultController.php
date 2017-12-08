<?php

namespace Portal\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PortalFrontBundle:Default:index.html.twig');
    }
}
