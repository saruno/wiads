<?php

namespace Common\DbBundle\Model;

use Common\DbBundle\Model\Base\User as BaseUser;


use Common\DbBundle\Helper\UserHelper as UserHelper;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Skeleton subclass for representing a row from the 'user' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class User extends BaseUser implements AdvancedUserInterface, \Serializable
{
    protected $roles=array();

    public function getSalt(){
        return "";
    }
    public function getRoles(){
        return self::getRolesAndRoleGroups();
    }
    private function getRolesAndRoleGroups(){

        $arrRoleId= array();

        $this->roles=array();
        UserHelper::getUserRolesAndRoleGroupsById($this->getId(), $arrRoleId, $this->roles);
        unset($arrRoleId);
        return $this->roles;
    }
    public function getRolesIds(){
        return UserHelper::getUserRolesIdsById($this->getId());
    }
    public function getRolesNames(){

        $arrRoleId= array();

        $this->rolesNames=array();
        UserHelper::getUserRolesNamesById($this->getId(), $arrRoleId, $this->rolesNames);
        unset($arrRoleId);
        return $this->rolesNames;
    }
    public function getRolesDescription(){

        $arrRoleId= array();

        $this->rolesNames=array();
        UserHelper::getUserRolesDescriptionById($this->getId(), $arrRoleId, $this->rolesNames);
        unset($arrRoleId);
        return $this->rolesNames;
    }
    public function getRolesGroups(){
        return UserHelper::getUserRolesGroupsById($this->getId());
    }
    public function getRoleGroupsNames(){

        $arrRoleId= array();

        $this->roleGroups=array();
        UserHelper::getUserRoleGroupsNames($this->getId(), $arrRoleId, $this->roleGroups);
        unset($arrRoleId);
        return $this->roleGroups;
    }
    public function getRoleGroupsDescription(){

        $arrRoleId= array();

        $this->roleGroupsNames=array();
        UserHelper::getUserRoleGroupsDescription($this->getId(), $arrRoleId, $this->roleGroupsNames);
        unset($arrRoleId);
        return $this->roleGroupsNames;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getUsername(){
        return $this->username;
    }
    public function eraseCredentials(){
        //$this->roles=array();
        if(isset($_SESSION["ROLE_MEDIA_POST"])) unset ($_SESSION["ROLE_MEDIA_POST"]);
        unset($this->roles);
        $this->password = null;
    }

    //////////
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return !$this->locked;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }


    public function isEnabled()
    {
        return $this->is_active;
    }

    // serialize and unserialize must be updated - see below
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->is_active,
            // see section on salt below
            $this->salt,
        ));
    }
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->is_active,
            // see section on salt below
            $this->salt
            ) = unserialize($serialized);
    }
}
