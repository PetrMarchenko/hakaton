<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $e->getApplication()->getEventManager()->attach('route', array($this, 'checkAcl'));

        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, function($e) {
            $controller = $e->getTarget();
            if (method_exists($controller,'init')) {
                $controller->init();
            }
        });
    }

    public function checkAcl(MvcEvent $e)
    {
        $auth = $e->getApplication()->getServiceManager()->get('AuthService');
        $role = User::getRoleNameById($auth->getUserRole());

        $acl = $e->getApplication()->getServiceManager()->get('Acl');
        $resource = $acl->getResource($e->getRouteMatch());

        if (!$acl->check($role, $resource)) {
            $response = $e -> getResponse();
            $response -> getHeaders() -> addHeaderLine('Location', $e -> getRequest() -> getBaseUrl().'/');
            $response -> setStatusCode(303);
        } else {

        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
