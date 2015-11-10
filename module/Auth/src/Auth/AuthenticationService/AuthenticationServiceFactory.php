<?php
/**
 *
 */

namespace Auth\Model\AuthenticationService;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter;

class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adaptersDb = $serviceLocator->get('ZendDbAdapterAdapter');
        $authAdapterDb = new \Zend\Authentication\Adapter\DbTable($adaptersDb);
        $config = $serviceLocator->get('Config');
        $authSetting = $config['authSetting'];
        $authAdapterDb->setTableName($authSetting['tableName'])
            ->setIdentityColumn($authSetting['identityColumn'])
            ->setCredentialColumn($authSetting['credentialColumn']);
        $adaptersStorage = new MyAuthStorage();
        $auth = new \Zend\Authentication\AuthenticationService($adaptersStorage, $authAdapterDb);
        return $auth;
    }
}