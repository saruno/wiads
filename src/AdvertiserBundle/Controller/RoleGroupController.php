<?php

namespace AdvertiserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Common\DbBundle\Model\RoleGroup;
use Common\DbBundle\Model\RoleGroupQuery;
use Common\DbBundle\Model\RoleQuery;
use Symfony\Component\HttpFoundation\Request;

class RoleGroupController extends Controller
{
	public function listAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SYS_ADMIN')){
            return $this->redirectToRoute('advertiser_homepage');
        }
        $list = RoleGroupQuery::create()->find();

    	return $this->render('AdvertiserBundle:RoleGroup:list.html.twig', array(
            'list'      =>  $list
        ));
    }

    public function roleAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SYS_ADMIN')){
            return $this->redirectToRoute('advertiser_homepage');
        }
        $group = RoleGroupQuery::create()->filterById($id)->findOne();
        if($group){

            $role_all = RoleQuery::create()->find();

            $submit = $request->get('sub',0);
            if($submit){
            	$role = $request->get('role',array());
            	$r = implode(';', $role);
            	$group->setRoleId($r);
                if($group->save()){
                    $request->getSession()->getFlashBag()->add('success', 'Thành công!');
                }
                
            }
            $role_active = explode(';', $group->getRoleId());

            return $this->render('AdvertiserBundle:RoleGroup:role.html.twig', array(
                'group'         =>  $group,
                'role_all'      =>  $role_all,
                'role_active'   =>  $role_active,
                'css'			=>	array('/bundles/advertiser/matrix/css/bootstrap-switch.min.css'),
                'js'			=>	array('/bundles/advertiser/matrix/js/bootstrap-switch.min.js')
            ));
        }
    }

    public function editAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SYS_ADMIN')){
            return $this->redirectToRoute('advertiser_homepage');
        }

    	$group = RoleGroupQuery::create()->filterById($id)->findOne();
        if($group){
        	
        	$submit = $request->get('submit', 0);
        	$name = $request->get('name', '');
        	$description = $request->get('description', '');
            
            if($submit){
            	$group->setName($name);
                $group->setDescription($description);
                if($group->save()){
                    $request->getSession()->getFlashBag()->add('success', 'Lưu thành công!');
                }else{
                    
                }
            }	

        	return $this->render('AdvertiserBundle:RoleGroup:edit.html.twig', array(
             	'group'			=>	$group
        	));
        }
    }

    public function addAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SYS_ADMIN')){
            return $this->redirectToRoute('advertiser_homepage');
        }
    	$submit = $request->get('submit', 0);
    	$name = $request->get('name', '');
    	$description = $request->get('description', '');

        $group = new RoleGroup();

        if($submit){
        	$group->setName($name);
            $group->setDescription($description);
            if($group->save()){
                $request->getSession()->getFlashBag()->add('success', 'Lưu thành công!');
            }else{
                
            }
        }	

    	return $this->render('AdvertiserBundle:RoleGroup:add.html.twig', array(
         	'name'			=>	$name,
         	'description'	=>	$description
    	));
        
    }
}