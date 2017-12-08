<?php

namespace AdvertiserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Common\DbBundle\Model\Role;
use Common\DbBundle\Model\RoleGroupQuery;
use Common\DbBundle\Model\RoleQuery;

class RoleController extends Controller
{   

    


	public function listAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SYS_ADMIN')){
            return $this->redirectToRoute('advertiser_homepage');
        }

        $list = RoleQuery::create()->find();

    	return $this->render('AdvertiserBundle:Role:list.html.twig', array(
            'list'      =>  $list
        ));
    }

    public function editAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SYS_ADMIN')){
            return $this->redirectToRoute('advertiser_homepage');
        }

        $role = RoleQuery::create()->filterById($id)->findOne();
        if($role){

            $submit = $request->get('submit', 0);
            $name = $request->get('name', '');
            $description = $request->get('description', '');
            
            if($submit){
                $role->setName($name);
                $role->setDescription($description);
                if($role->save()){
                    $request->getSession()->getFlashBag()->add('success', 'Lưu thành công!');
                }else{
                    
                }
            }   

            return $this->render('AdvertiserBundle:Role:edit.html.twig', array(
                'role'      =>  $role
            ));
        }
    }


    public function deleteAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SYS_ADMIN')){
            return $this->redirectToRoute('advertiser_homepage');
        }

        $role = RoleQuery::create()->findOneById($id);
        if($role){
            $role->delete();
            $request->getSession()->getFlashBag()->add('success', 'Xóa thành công!');
        }
        return $this->redirectToRoute('advertiser_permision_role_list');
    }

    public function addAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_SYS_ADMIN')){
            return $this->redirectToRoute('advertiser_homepage');
        }
        
        $submit = $request->get('submit', 0);
        $name = $request->get('name', '');
        $description = $request->get('description', '');

        $role = new Role();

        if($submit){
            $role->setName($name);
            $role->setDescription($description);
            if($role->save()){
                $request->getSession()->getFlashBag()->add('success', 'Lưu thành công!');
            }else{
                
            }
        }   

        return $this->render('AdvertiserBundle:Role:add.html.twig', array(
            'name'          =>  $name,
            'description'   =>  $description
        ));
    }
}