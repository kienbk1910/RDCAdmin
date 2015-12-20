<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'statistic' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/statistic',
                             'defaults' => array(
                                 'action' => 'statistic',
                             ),
                             'constraints' => array(
                             )
                         ),
                        
                     ),
                    'test' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/test',
                             'defaults' => array(
                                 'action' => 'test',
                             ),
                             'constraints' => array(
                             )
                         ),
                        
                     ),
                    'staff' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/staff',
                             'defaults' => array(
                                 'action' => 'staff',
                             ),
                             'constraints' => array(
                             )
                         ),
                        
                     ),

                ),
            ),
            'manager-users' => array (
				'type' => 'Literal',
				'options' => array (
					'route' => '/manager-users',
					'defaults' => array (
						'__NAMESPACE__' => 'Application\Controller',
						'controller' => 'ManagerUsers',
						'action' => 'index'
					)
				),
				'may_terminate' => true,
				    'child_routes' => array (
                    'add' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/add',
                             'defaults' => array(
                                 'action' => 'add',
                             ),
                             'constraints' => array(
                             )
                         ),
                        
                     ),
                )
			),
            // tasks
              'manager-tasks' => array (
                'type' => 'Literal',
                'options' => array (
                    'route' => '/manager-tasks',
                    'defaults' => array (
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'ManagerTasks',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array (
                    'add' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/add',
                             'defaults' => array(
                                 'action' => 'add',
                             ),
                             'constraints' => array(
                             )
                         ),
                        
                     ),
                    'detail' => array(
                     'type' => 'segment',
                     'options' => array(
                         'route'    => '/detail',
                         'defaults' => array(
                             'action' => 'detail',
                         ),
                         'constraints' => array(
                         )
                     ),
                        
                     ),
                )
            ),
            // profile
           'profile' => array (
            'type' => 'Literal',
            'options' => array (
                'route' => '/profile',
                'defaults' => array (
                    '__NAMESPACE__' => 'Application\Controller',
                    'controller' => 'Profile',
                    'action' => 'index'
                )
            ),
            'may_terminate' => true,
            'child_routes' => array (
                'add' => array(
                     'type' => 'segment',
                     'options' => array(
                         'route'    => '/add',
                         'defaults' => array(
                             'action' => 'add',
                         ),
                         'constraints' => array(
                         )
                     ),
                    
                 ),
            )
        )   
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'agency_navigation' => 'Application\Navigation\Service\AgencyNavigationFactory',
            'Application\Mapper\IndexMapperInterface'   => 'Application\Factory\ZendDbSqlMapperFactory',
            'Application\Service\IndexServiceInterface' => 'Application\Factory\IndexServiceFactory'

        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
     
        ),
         'factories' => array(
             'Application\Controller\Index' => 'Application\Factory\IndexControllerFactory',
             'Application\Controller\Profile' => 'Application\Factory\ProfileControllerFactory',
             'Application\Controller\ManagerUsers' => 'Application\Factory\ManagerUsersControllerFactory',
              'Application\Controller\ManagerTasks' => 'Application\Factory\ManagerTasksControllerFactory'
         )
    ),
    'navigation_helpers' => array (
        'invokables' => array(
            // override or add a view helper
           // 'menu' => '\TwitterBootstrapAPI\View\Helper\Navigation\Menu',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'layout/login'           => __DIR__ . '/../view/layout/login.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy'
         ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

    'navigation' => array(
    'default' => array(
        array(
            'label' => 'Bảng Tin',
            'route' => 'application',
            'icon' => 'dashboard',
            'pages' => array(
                array(
                    'label' => 'Tin Tức',
                    'uri' => '#',
                    'icon' => 'circle-o',
                    'route' => 'application',
                    'action' => 'index',
                ),
                array(
                    'label' => 'Thông Kê',
                    'uri' => '#',
                    'icon' => 'circle-o',
                    'route' => 'application/statistic',
                    'action' => 'statistic',
                ),
            )
        ),
        array(
            'label' => 'Hồ Sơ',
            'uri' => '#',
            'icon' => 'files-o',
            'route' => 'manager-tasks',
            'pages' => array(
                array(
                    'label' => 'Danh Sách Hồ Sơ',
                    'uri' => '#',
                    'icon' => 'circle-o',
                    'route' => 'manager-tasks',
                ),
                array(
                    'label' => 'Thêm Hồ Sơ',
                    'uri' => '#',
                    'icon' => 'circle-o',
                    'route' => 'manager-tasks/add',
                ),
            )
        ),
         array(
            'label' => 'Quản lý Users',
            'icon' => 'pie-chart',
            'route' => 'manager-users',
            'pages' => array(
                array(
                    'label' => 'Danh Sách Users',
                     'route' => 'manager-users',
                    'icon' => 'circle-o'
                ),
                array(
                    'label' => 'Thêm User',
                    'uri' => '#',
                    'route' => 'manager-users/add',
                    'icon' => 'circle-o'
                ),
            )
        ),
         array(
            'label' => 'Quản Lý Học Viên',
            'uri' => '#',
            'icon' => 'laptop',
            'pages' => array(
                array(
                    'label' => 'Dánh Sách Học Viên',
                    'uri' => '#',
                    'icon' => 'circle-o'
                ),
                array(
                    'label' => ' Thêm Học Viên',
                    'uri' => '#',
                    'icon' => 'circle-o'
                ),
            )
        ),
         array(
            'label' => 'Quản Lý Chứng Chỉ',
            'uri' => '#',
            'icon' => 'edit',
            'pages' => array(
                array(
                    'label' => 'Danh Sách Chứng Chỉ',
                    'uri' => '#',
                    'icon' => 'circle-o'
                ),
                array(
                    'label' => 'Thêm Chứng Chỉ',
                    'uri' => '#',
                    'icon' => 'circle-o'
                ),
            )
        ),
    ),
 // agency navigation
        'agency' => array(
            array(
                'label' => 'Bảng Tin',
                'route' => 'application',
                'icon' => 'dashboard',
                'pages' => array(
                    array(
                        'label' => 'Tin Tức',
                        'uri' => '#',
                        'icon' => 'circle-o',
                        'route' => 'application',
                        'action' => 'index',
                    ),
                    array(
                        'label' => 'Thông Kê',
                        'uri' => '#',
                        'icon' => 'circle-o',
                        'route' => 'application/statistic',
                        'action' => 'statistic',
                    ),
                )
            ),
        ), 
    ),

);
