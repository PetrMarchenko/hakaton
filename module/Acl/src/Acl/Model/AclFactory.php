<?php
/**
 *
 */

namespace Acl\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Acl\Model\Acl;

class AclFactory implements FactoryInterface
{
    /**
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $aclService = $serviceLocator->get('AclService');
        return new Acl($aclService);

    }
}