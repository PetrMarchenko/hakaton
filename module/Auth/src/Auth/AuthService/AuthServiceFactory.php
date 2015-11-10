<?php
/**
 *
 */

namespace Auth\Model\AuthService;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter;

class AuthServiceFactory implements FactoryInterface
{
    /**
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticationService = $serviceLocator->get('AuthenticationService');
        return new Auth($authenticationService);
    }
}