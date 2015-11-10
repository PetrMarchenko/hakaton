<?php
/**
 *
 */

namespace Acl\Model\AclService;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Permissions\Acl\Acl;

class AclServiceFactory implements FactoryInterface
{
    /**
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $aclConfig = $config['acl'];
        $acl = new Acl();

        foreach ($aclConfig['inheritance'] as $role => $parents){
            $role = new \Zend\Permissions\Acl\Role\GenericRole($role);
            if ($parents['0'] == null){
                $acl->addRole($role);
            } else {
                $acl->addRole($role, $parents);
            }
        }

        foreach ($aclConfig['role'] as $role => $resources) {
            foreach ($resources as $controller => $actions) {
                foreach ($actions as $action) {
                    $resource = $controller . '/' . $action;
                    if (!$acl->hasResource($resource)) {
                        $acl->addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
                        $acl->allow($role, $resource);
                    }
                }
            }
        }
        ;

        return $acl;
    }
}