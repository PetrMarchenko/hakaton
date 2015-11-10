<?php
/**
 *
 */

namespace Acl\Model;

class Acl
{
    /**
     *
     */
    protected $aclService;

    public function __construct($aclService)
    {
        $this->aclService = $aclService;
    }

    public function getAclService(){
        return $this->aclService;
    }


    public function check($role, $resource, $access = true){

        if ($this->getAclService()->hasResource($resource)){
            if (!$this->aclService -> isAllowed($role, $resource)) {
                return false;
            } else {
                return true;
            }
        } else {
            return $access;
        }
    }

    public function getResource($routeMatch){
        $controller = $routeMatch->getParam('controller');
        $action = $routeMatch->getParam('action');
        return $resource = $controller . '/' . $action;
    }

}