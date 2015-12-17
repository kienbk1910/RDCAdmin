<?php
// http://p0l0.binware.org/index.php/2012/02/18/zend-framework-2-authentication-acl-using-eventmanager/
// First I created an extra config for ACL (could be also in module.config.php, but I prefer to have it in a separated file)
return array(
    'acl' => array(
        'roles' => array(
            'guest'   => null,
            'agency'  => 'guest',
            'satff'  => 'agency',
            'manage'  => 'satff',
            'admin'  => 'manage',
            

        ),
        'resources' => array(
            'allow' => array(
				'Application\Controller\Index' => array(
					'index'	=> 'agency',
					
				),
				'Auth\Controller\Index' => array(
					'index'	=> 'guest',
					'logout'	=> 'guest'
				),

				// for CMS articles
				'Public Resource' => array(
					'view'	=> 'guest',					
				),
				'Private Resource' => array(
					'view'	=> 'agency',					
				),
				'Admin Resource' => array(
					'view'	=> 'admin',					
				),
            )
        )
    )
);