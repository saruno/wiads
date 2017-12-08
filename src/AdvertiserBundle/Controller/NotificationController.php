<?php

namespace AdvertiserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Common\DbBundle\Model\Role;
use Common\DbBundle\Model\RoleGroupQuery;
use Common\DbBundle\Model\RoleQuery;

class NotificationController extends Controller
{
	public function SessionAction(Request $request)
	{
		return $this->render('AdvertiserBundle:Notification:session.html.twig');
	}
}