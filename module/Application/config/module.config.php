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
                    'add-notification' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/add-notification',
                             'defaults' => array(
                                 'action' => 'addNotification',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                     'get-report-tasks' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/get-report-tasks',
                             'defaults' => array(
                                 'action' => 'getReportTasks',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                      'get-report-money' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/get-report-money',
                             'defaults' => array(
                                 'action' => 'getReportMoney',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                     'list-notification' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/list-notification',
                             'defaults' => array(
                                 'action' => 'listNotification',
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
//  begin tasks
            'tasks' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/tasks',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Tasks',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'order' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/order',
                             'defaults' => array(
                                 'action' => 'order',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                    'getlisttasks' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/getlisttasks',
                             'defaults' => array(
                                 'action' => 'getlisttasks',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                     'getlistorders' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/getlistorders',
                             'defaults' => array(
                                 'action' => 'getlistorders',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                      'orderdetail' => array(
                         'type' => 'segment',
                           'options' => array(
                             'route'    => '/orderdetail/:id',
                               'defaults' => array(
                                 'action' => 'orderdetail',
                                  'id'=>'0',
                             ),
                             'constraints' => array(
                                 'id'   => '[1-9]\d*',
                             )
                            ),

                     ),
                          'taskdetail' => array(
                         'type' => 'segment',
                           'options' => array(
                             'route'    => '/taskdetail/:id',
                               'defaults' => array(
                                 'action' => 'taskdetail',
                                  'id'=>'0',
                             ),
                             'constraints' => array(
                                 'id'   => '[1-9]\d*',
                             )
                            ),

                     ),

                ),
            ),
// end tasks
//  begin pay
            'pay' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/pay',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Pay',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'pay' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/pay',
                             'defaults' => array(
                                 'action' => 'pay',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                     'detail' => array(
                         'type' => 'segment',
                           'options' => array(
                             'route'    => '/detail/:id',
                               'defaults' => array(
                                 'action' => 'detail',
                                  'id'=>'0',
                             ),
                             'constraints' => array(
                                 'id'   => '[1-9]\d*',
                             )
                            ),

                     ),
                      'list' => array(
                         'type' => 'segment',
                           'options' => array(
                             'route'    => '/list',
                               'defaults' => array(
                                 'action' => 'list',
                                  
                             ),
                             'constraints' => array(
                                
                             )
                            ),

                        ),
                    'delete' => array(
                         'type' => 'segment',
                           'options' => array(
                             'route'    => '/delete',
                               'defaults' => array(
                                 'action' => 'delete',
                                  
                             ),
                             'constraints' => array(
                                
                             )
                            ),

                        ),
                    ),
            ),
// end pay
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
                    'getlist' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/getlist',
                             'defaults' => array(
                                 'action' => 'getlist',
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
                    'showlog' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/showlog/:id',
                            'defaults' => array(
                                'action' => 'showlog',
                                'id'=>'0',
                            ),
                            'constraints' => array(
                                 'id'   => '[1-9]\d*',
                            )
                        ),
                    ),
                    'detail' => array(
                     'type' => 'segment',
                     'options' => array(
                         'route'    => '/detail/:id',
                           'defaults' => array(
                             'action' => 'detail',
                              'id'=>'0',
                         ),
                         'constraints' => array(
                             'id'   => '[1-9]\d*',
                         )
                     ),
                     ),

                    'change-info' => array(
                     'type' => 'segment',
                     'options' => array(
                         'route'    => '/change-info',
                           'defaults' => array(
                             'action' => 'changeinfo',
                         ),
                         'constraints' => array(

                         )
                     ),
                     ),
                    'pay' => array(
                     'type' => 'segment',
                     'options' => array(
                         'route'    => '/pay',
                           'defaults' => array(
                             'action' => 'pay',

                         ),
                         'constraints' => array(

                         )
                     ),
                     ),
                     'deletepay' => array(
                     'type' => 'segment',
                     'options' => array(
                         'route'    => '/deletepay',
                           'defaults' => array(
                             'action' => 'deletepay',

                         ),
                         'constraints' => array(

                         )
                     ),
                     ),
                    'addfile' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/addfile',
                               'defaults' => array(
                                 'action' => 'addfile',

                             ),
                             'constraints' => array(

                             )
                         ),
                     ),
                    'payhistory' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/payhistory',
                               'defaults' => array(
                                 'action' => 'payhistory',

                             ),
                             'constraints' => array(

                             )
                         ),
                     ),
                    'getlist' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/getlist',
                             'defaults' => array(
                                 'action' => 'getlist',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                     'addcomment' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/addcomment',
                             'defaults' => array(
                                 'action' => 'addcomment',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                      'getcomment' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/getcomment',
                             'defaults' => array(
                                 'action' => 'getcomment',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                    //
                      'filelist' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/filelist',
                             'defaults' => array(
                                 'action' => 'filelist',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                    'export-pdf' => array(
                     'type' => 'segment',
                     'options' => array(
                         'route'    => '/export-pdf',
                         'defaults' => array(
                             'action' => 'exportPdf',
                         ),
                         'constraints' => array(
                         )
                     ),

                     ),
                    'editfile' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/editfile',
                             'defaults' => array(
                                 'action' => 'editfile',
                             ),
                             'constraints' => array(
                             )
                         ),

                     ),
                  'deletefile' => array(
                     'type' => 'segment',
                     'options' => array(
                         'route'    => '/deletefile',
                         'defaults' => array(
                             'action' => 'deletefile',
                         ),
                         'constraints' => array(
                         )
                     ),

                 ),
             'downloadfile' => array(
             'type' => 'segment',
             'options' => array(
                 'route'    => '/downloadfile',
                 'defaults' => array(
                     'action' => 'downloadfile',
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
                'user-info' => array(
                     'type' => 'segment',
                     'options' => array(
                         'route'    => '/user-info/:id',
                         'defaults' => array(
                             'action' => 'userInfo',
                             'id'=>'0',
                         ),
                         'constraints' => array(
                              'id'   => '[1-9]\d*',
                         )
                     ),
                 ),
                'change-password' => array(
                    'type' => 'segment',
                    'options' => array(
                        'route'    => '/change-password',
                        'defaults' => array(
                            'action' => 'changePassword',
                        ),
                        'constraints' => array(
                        )
                    ),
                ),
                'upload-image' => array(
                    'type' => 'segment',
                    'options' => array(
                        'route'    => '/upload-image',
                        'defaults' => array(
                            'action' => 'uploadImage',
                        ),
                        'constraints' => array(
                        )
                    ),
                ),
                'reset-password' => array(
                    'type' => 'segment',
                    'options' => array(
                        'route'    => '/reset-password',
                        'defaults' => array(
                            'action' => 'resetPassword',
                         ),
                         'constraints' => array(
                         )
                    ),
                ),
               'change-user-info' => array(
                      'type' => 'segment',
                      'options' => array(
                          'route'    => '/change-user-info',
                          'defaults' => array(
                               'action' => 'changeUserInfo',
                          ),
                          'constraints' => array(
                          )
                      ),
               ),
                'change-my-info' => array(
                    'type' => 'segment',
                    'options' => array(
                        'route'    => '/change-my-info',
                        'defaults' => array(
                            'action' => 'changeMyInfo',
                        ),
                        'constraints' => array(
                        )
                    ),
                ),
            ) /*End child*/
        ), /* End profile */
            /* Start log */
           'log' => array (
            'type' => 'Literal',
            'options' => array (
                'route' => '/log',
                'defaults' => array (
                    '__NAMESPACE__' => 'Application\Controller',
                    'controller' => 'Log',
                    'action' => 'index'
                )
            ),
            'may_terminate' => true,
            'child_routes' => array (
                'showlog' => array(
                     'type' => 'segment',
                     'options' => array(
                         'route'    => '/showlog/:id',
                         'defaults' => array(
                             'action' => 'showlog',
                             'id'=>'0',
                         ),
                         'constraints' => array(
                              'id'   => '[1-9]\d*',
                         )
                     ),
                 ),
            ) /* End child */
            ), /* End log */
            /* Start certificate */
            'manager-certificates' => array (
                'type' => 'Literal',
                'options' => array (
                    'route' => '/manager-certificates',
                    'defaults' => array (
                            '__NAMESPACE__' => 'Application\Controller',
                            'controller' => 'ManagerCertificates',
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
                    'adddetail' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/adddetail',
                            'defaults' => array(
                                'action' => 'adddetail',
                            ),
                            'constraints' => array(
                            )
                        ),
                    ),
                ) /* End child */
            ), /* End certificate */
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
             'Application\Controller\ManagerCertificates' => 'Application\Factory\ManagerCertificatesControllerFactory',
             'Application\Controller\ManagerUsers' => 'Application\Factory\ManagerUsersControllerFactory',
             'Application\Controller\ManagerTasks' => 'Application\Factory\ManagerTasksControllerFactory',
             'Application\Controller\Tasks' => 'Application\Factory\TasksControllerFactory',
             'Application\Controller\Log' => 'Application\Factory\LogControllerFactory',
             'Application\Controller\Pay' => 'Application\Factory\PayControllerFactory',
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
            'label' => 'Tài Chính',
            'uri' => '#',
            'icon' => 'laptop',
            'pages' => array(
                array(
                    'label' => 'Lịch Sử Thu Chi',
                    'uri' => '#',
                      'route' => 'pay',
                    'icon' => 'circle-o'
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
            'label' => 'Quản Lý Chứng Chỉ',
            'icon' => 'edit',
            'route' => 'manager-certificates',
            'pages' => array(
                array(
                    'label' => 'Danh Sách Chứng Chỉ',
                    'uri' => '#',
                    'route' => 'manager-certificates',
                    'icon' => 'circle-o'
                ),
                array(
                    'label' => 'Thêm Chứng Chỉ',
                    'uri' => '#',
                    'route' => 'manager-certificates/add',
                    'icon' => 'circle-o'
                ),
                array(
                    'label' => 'Thêm Hồ Sơ Chứng Chỉ',
                    'uri' => '#',
                    'route' => 'manager-certificates/adddetail',
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
            array(
            'label' => 'Hồ Sơ',
            'uri' => '#',
            'icon' => 'files-o',
            'route' => 'manager-tasks',
            'pages' => array(
                array(
                    'label' => 'Công Việc Của Tôi',
                    'uri' => '#',
                    'icon' => 'circle-o',
                    'route' => 'tasks',
                ),
                array(
                    'label' => 'Đơn Hàng Của Tôi',
                    'uri' => '#',
                    'icon' => 'circle-o',
                    'route' => 'tasks/order',
                ),
            )
        ),
        ),
    ),

);
