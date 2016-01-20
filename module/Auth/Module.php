<?php
namespace Auth;
use Auth\Acl\Acl;
// Add this for Table Date Gateway

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

// Add this for SMTP transport
use Zend\ServiceManager\ServiceManager;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

class Module
{

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

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
				// For Yable data Gateway
                'Auth\Model\UsersTable' =>  function($sm) {
                    $tableGateway = $sm->get('UsersTableGateway');
                    $table = new UsersTable($tableGateway);
                    return $table;
                },
                'UsersTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Auth()); // Notice what is set here
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
				// Add this for SMTP transport
				'mail.transport' => function (ServiceManager $serviceManager) {
					$config = $serviceManager->get('Config');
					$transport = new Smtp();
					$transport->setOptions(new SmtpOptions($config['mail']['transport']['options']));
					return $transport;
				},
            ),
        );
    }
    // FOR Authorization
    public function onBootstrap(\Zend\EventManager\EventInterface $e) // use it to attach event listeners
    {
        $application = $e->getApplication();
        $em = $application->getEventManager();
        $em->attach('route', array($this, 'onRoute'), -100);
    }

    // WORKING the main engine for ACL
    public function onRoute(\Zend\EventManager\EventInterface $e) // Event manager of the app
    {
        $application = $e->getApplication();
        $routeMatch = $e->getRouteMatch();
        $sm = $application->getServiceManager();
        $auth = $sm->get('Zend\Authentication\AuthenticationService');
        $config = $sm->get('Config');
        $acl = new Acl($config);
        // everyone is guest untill it gets logged in
        $role = Acl::DEFAULT_ROLE; // The default role is guest $acl

        if ($auth->hasIdentity()) {
            $usr = $auth->getIdentity();
            $usrl_id = $usr->role_id; // Use a view to get the name of the role
            // TODO we don't need that if the names of the roles are comming from the DB
            switch ($usrl_id) {
                case 1 :
                    $role = Acl::ADMIN_ROLE;
                    break;
                case 2 :
                    $role = Acl::MANAGE_ROLE;
                    break;
                case 3 :
                    $role = Acl::SATFF_ROLE;
                    break;
                case 4 :
                    $role = Acl::AGENCY_ROLE;
                    break;
                default :
                    $role = Acl::DEFAULT_ROLE;
                    break;
            }
        }


    }
}