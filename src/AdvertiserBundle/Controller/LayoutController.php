<?php

namespace AdvertiserBundle\Controller;

use AdvertiserBundle\AdvertiserBundle;
use AdvertiserBundle\Helper\ApiHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hotspot\AccessPointBundle\Model\Accesspoint;
use AdvertiserBundle\Form\Type\AccesspointType;
use Symfony\Component\HttpFoundation\Request;

class LayoutController extends Controller
{
    
    public function demo1Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo1.html.twig');
    }

    public function demo2Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo2.html.twig');
    }

    public function demo3Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo3.html.twig');
    }


    public function demo4Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo4.html.twig');
    }

    public function demo5Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo5.html.twig');
    }

    public function demo6Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo6.html.twig');
    }

    public function demo7Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo7.html.twig');
    }

    public function demo8Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo8.html.twig');
    }
    
    public function demo9Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo9.html.twig');
    }

    public function demo10Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo10.html.twig');
    }

    public function demo11Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo11.html.twig');
    }

    public function demo12Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo12.html.twig');
    }

    public function demo13Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo13.html.twig');
    }

    public function demo14Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo14.html.twig');
    }
    public function demo15Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo15.html.twig');
    }
    public function demo16Action(Request $request)
    {
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        $ua_info = parse_user_agent($mobileDetector->getUserAgent());
        $os = $ua_info['platform'];
        $browser = $ua_info['browser']; echo $os;

        return $this->render('AdvertiserBundle:Layout:demo16.html.twig');
    }

    public function demo17Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo17.html.twig');
    }

    public function demo18Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo18.html.twig');
    }

    public function demo19Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo19.html.twig');
    }

    public function demo20Action(Request $request)
    {
        return $this->render('AdvertiserBundle:Layout:demo20.html.twig');
    }

}