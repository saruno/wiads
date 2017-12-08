<?php

namespace Portal\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PartialController extends Controller{
    public function headAction(Request $request){
        $title = $this->container->getParameter('auth_site_title');
        return $this->render('PortalAdminBundle:Auth:head.html.twig',array('title'=>$title));
    }
    public function footerAction(Request $request){
        return $this->render('PortalAdminBundle:Auth:footer.html.twig');
    }
}