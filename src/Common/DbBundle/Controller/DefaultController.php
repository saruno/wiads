<?php

namespace Common\DbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CommonDbBundle:Default:index.html.twig');
    }
}
