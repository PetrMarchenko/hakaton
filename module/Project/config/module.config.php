<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Project\Controller\Index' => 'Project\Controller\IndexController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'project' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/project[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Project\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'users' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'users/layout' => __DIR__ . '/../view/layout/layout.phtml',
        ),
    ),
);