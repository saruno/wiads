<?php

namespace AdvertiserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdvertiserBundle:Default:index.html.twig');
    }
}
