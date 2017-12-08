<?php

namespace Hotspot\AccessPointBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HotspotAccessPointBundle:Default:index.html.twig');
    }
}
