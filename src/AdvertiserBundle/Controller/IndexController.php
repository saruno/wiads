<?php

namespace AdvertiserBundle\Controller;

use AdvertiserBundle\AdvertiserBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Common\DbBundle\Model\Advert;
use AdvertiserBundle\Form\Type\AdvertiserType;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    
    public function indexAction()
    {
        return $this->redirectToRoute('advertiser_dashboard');
    }


}
