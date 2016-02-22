<?php
// Filename: /module/Blog/src/Blog/Factory/ListControllerFactory.php
namespace Application\Factory;

use Application\Controller\ManagerCertificatesController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ManagerCertificatesControllerFactory implements FactoryInterface {
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $postService = $realServiceLocator->get( 'Application\Service\IndexServiceInterface' );
        $auth = $realServiceLocator->get( 'Zend\Authentication\AuthenticationService' );

        return new ManagerCertificatesController( $postService, $auth );
    }
}