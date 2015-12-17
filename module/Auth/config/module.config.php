<?php
return array(
	'static_salt' => 'aFGQ475SDsdfsaf2342', 
	'controllers' => array(
        'invokables' => array(
            'Auth\Controller\Index' => 'Auth\Controller\IndexController',	
        	
        ),
	),
    'router' => array(
        'routes' => array(
			'auth' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/auth',
					'defaults' => array(
						'__NAMESPACE__' => 'Auth\Controller',
						'controller'    => 'Index',
						'action'        => 'Index',
					),
				),
			),
            'logout' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/logout',
					'defaults' => array(
						'__NAMESPACE__' => 'Auth\Controller',
						'controller'    => 'Index',
						'action'        => 'logout',
					),
				),
			),
            'error' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/error',
					'defaults' => array(
						'__NAMESPACE__' => 'Auth\Controller',
						'controller'    => 'Index',
						'action'        => 'error',
					),
				),
			),			
		),
	),
    'view_manager' => array(
//        'template_map' => array(
//            'layout/Auth'           => __DIR__ . '/../view/layout/Auth.phtml',
//        ),
        'template_path_stack' => array(
            'auth' => __DIR__ . '/../view'
        ),
		
		'display_exceptions' => true,
    ),
	'service_manager' => array(
		// added for Authentication and Authorization. Without this each time we have to create a new instance.
		// This code should be moved to a module to allow Doctrine to overwrite it
		'aliases' => array( // !!! aliases not alias
			'Zend\Authentication\AuthenticationService' => 'my_auth_service',
		),
		'invokables' => array(
			'my_auth_service' => 'Zend\Authentication\AuthenticationService',
		),
	),
);