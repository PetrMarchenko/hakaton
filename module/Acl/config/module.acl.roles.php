<?php
return array(
    'acl' => array(
        'role' => array(
            'VISITOR' => array(
//                'Courses\Controller\Index' => array('index'),
            ),
            'INVESTOR' => array(
//                'Courses\Controller\Index' => array(),
            ),
            'ADVISER' => array(
//                'Courses\Controller\Index' => array('index'),
            ),
            'SUPER_USER' => array(
                'Admin\Controller\Categories' => array('index', 'move', 'add', 'edit', 'delete'),
            ),
        ),
        'inheritance' => array(
            'VISITOR' => array(null),
            'ADVISER' => array('VISITOR'),
            'INVESTOR' => array('ADVISER'),
            'SUPER_USER' => array('INVESTOR')
        ),

    ),
);
