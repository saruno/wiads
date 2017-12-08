<?php

namespace Common\DbBundle\Helper;

use Common\DbBundle\Model\RoleGroupQuery;
use Common\DbBundle\Model\RoleAssign;
use Common\DbBundle\Model\RoleAssignQuery;
use Common\DbBundle\Model\RoleQuery;
use Common\DbBundle\Model\User;
use Common\DbBundle\Model\UserQuery;

class UserHelper
{
	static public  function getUserByUsername($username){
		return UserQuery::create()->filterByUsername($username)->findOne();
	}
	static public function getUserRolesAndRoleGroupsById($id,&$arrRoleId,&$arrRoleName){
		//1. GET ROLE_GROUP'
		$r=RoleAssignQuery::create()
		->filterByUserId($id)
		->findOne();
		if(!$r) return null;

		$myRoleGroups=$r->getRoleGroupId();
		$myRoles=$r->getRoleId();
		/////////////////////////////////////
		$arrRoleGroupId=explode(";", $myRoleGroups);

		foreach ($arrRoleGroupId as $roleGroup){
			if($roleGroup!=""){
				$r= RoleGroupQuery::create()
				->findOneById($roleGroup);
				if($r){
					$arrRoleName[]=$r->getName();
                    /*--------*/
                    $arrRoleId = explode(";", $r->getRoleId());
                    foreach ($arrRoleId as $role){
                        $r = RoleQuery::create()->findOneById($role);
                        if($r){
                            $arrRoleName[]=$r->getName();
                        }
                    }
                    /*-------*/
				}
			}
		}
		////////////////////////////////////
		//2.JOIN WITH OTHER ROLES
		$arrRoleId=explode(";", $myRoles);
		foreach ($arrRoleId as $role){
			if($role!=""){
				$r= RoleQuery::create()
				->findOneById($role);
				if($r){
					$arrRoleName[]=$r->getName();
				}
			}
		}
	}
	static public function getUserRolesAndRoleGroupsByUsername($username,&$arrRoleId,&$arrRoleName){
		//0. Get userId from username
		$user=UserQuery::create()->filterByUsername($username)->findOne();
		if($user==null) return null;
		$id=$user->getId();
		//1. GET ROLE_GROUP'
		$r=RoleAssignQuery::create()
		->filterByUserId($id)
		->findOne();
		if(!$r) return null;

		$myRoleGroups=$r->getRoleGroupId();
		$myRoles=$r->getRoleId();
		/////////////////////////////////////
		$arrRoleGroupId=explode(";", $myRoleGroups);

		foreach ($arrRoleGroupId as $roleGroup){
			if($roleGroup!=""){
				$r= RoleGroupQuery::create()
				->findOneById($roleGroup);
				if($r){
					$arrRoleName[]=$r->getName();
				}
			}
		}
		////////////////////////////////////
		//2.JOIN WITH OTHER ROLES
		$arrRoleId=explode(";", $myRoles);
		foreach ($arrRoleId as $role){
			if($role!=""){
				$r= RoleQuery::create()
				->findOneById($role);
				if($r){
					$arrRoleName[]=$r->getName();
				}
			}
		}
	}
	static public function getUserRolesIdsById($id){
		$r=RoleAssignQuery::create()
		->filterByUserId($id)
		->findOne();
		if($r) return null;
		$myRoles=$r->getRoleId();
		$arrRoleId=explode(";", $myRole);
		return $arrRoleId;
	}
	static public function getUserRolesNamesById($id,&$arrRoleId,&$arrRoleName){
		$r=RoleAssignQuery::create()
		->filterByUserId($id)
		->findOne();
		if(!$r) return null;

		$myRoles=$r->getRoleId();

		$arrRoleId=explode(";", $myRoles);
		foreach ($arrRoleId as $role){
			if($role!=""){
				$r= RoleQuery::create()
				->findOneById($role);
				if($r){
					$arrRoleName[]=$r->getName();
				}
			}
		}
	}
	static public function getUserRolesDescriptionById($id,&$arrRoleId,&$arrRoleName){
		$r=RoleAssignQuery::create()
		->filterByUserId($id)
		->findOne();
		if(!$r) return null;

		$myRoles=$r->getRoleId();

		$arrRoleId=explode(";", $myRoles);
		foreach ($arrRoleId as $role){
			if($role!=""){
				$r= RoleQuery::create()
				->findOneById($role);
				if($r){
					$arrRoleName[]=$r->getDescription();
				}
			}
		}
	}
	static public function getUserRolesGroupsById($id){
		$r=RoleAssignQuery::create()
		->filterByUserId($id)
		->findOne();
		if(!$r) return null;
		$myRoleGroup=$r->getRoleGroupId();
		$arrRoleGroupId=explode(";", $myRoleGroup);
		return $arrRoleGroupId;
	}
	static public function getUserRoleGroupsNames($id,&$arrRoleGroupId,&$arrRoleGroupName){
		$r=RoleAssignQuery::create()
		->filterByUserId($id)
		->findOne();
		if(!$r) return null;
		foreach ($arrRoleGroupId as $roleGroup){
			if($roleGroup!=""){
				$r= RoleGroupQuery::create()
				->findOneById($roleGroup);
				if($r){
					$arrRoleName[]=$r->getName();
				}
			}
		}
	}
	static public function getUserRoleGroupsDescription($id,&$arrRoleGroupId,&$arrRoleGroupName){
		$r=RoleAssignQuery::create()
		->filterByUserId($id)
		->findOne();
		if(!$r) return null;
		foreach ($arrRoleGroupId as $roleGroup){
			if($roleGroup!=""){
				$r= RoleGroupQuery::create()
				->findOneById($roleGroup);
				if($r){
					$arrRoleName[]=$r->getDescription();
				}
			}
		}
	}
	static public function getRoleTable($type=-1){
		if($type<0) return null;
		return RoleQuery::create()
		->filterByType($type)
		->find();
	}
	static public function updateUserRoles($id,$accName,$email, $roles,$type){
		$user=UserQuery::create()->filterById($id)->findOne();
		$user->setLastname($accName);
		$user->setEmail($email);
		$user->setType($type);
		$user->save();
		//
		$roleAssgn=RoleAssignQuery::create()->filterByUserId($id)->findOne();
		$roleAssgn->setRoleId($roles);
		$roleAssgn->save();
	}
	static public function userExists($id){
		$c=UserQuery::create()->filterById($id)->count();
		if ($c==0) return false;
		return true;
	}
	static public function userExistsByUsername($username){
		$c=UserQuery::create()->filterByUsername($username)->count();
		if ($c==0) return false;
		return true;
	}
	static public function addUser($acc,$accName,$email,$password, $roles,$type=1){
		$count=UserQuery::create()->filterByUsername($acc)->count();
		if($count>0) return -1;

		$user = new User();
		$user->setUsername($acc);
		$user->setLastname($accName);
		$user->setEmail($email);
		$user->setPassword(md5($password));
		$user->setType($type);
		$user->save();

		$id=$user->getId();

		$roleAssgn=new RoleAssign();

		$roleAssgn->setUserId($id);
		$roleAssgn->setRoleId($roles);
		$roleAssgn->save();

		return 0;
	}
	static public function removeUser($id)
	{
		$user=UserQuery::create()->filterById($id)->findOne();
		$user->delete();
		$roles=RoleAssignQuery::create()->filterByUserId($id)->find();
		foreach ($roles as $role)
			$role->delete();
	}
}