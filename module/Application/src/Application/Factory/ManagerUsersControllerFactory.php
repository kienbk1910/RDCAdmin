<?php
 // Filename: /module/Blog/src/Blog/Factory/ListControllerFactory.php
 namespace Application\Factory;

 use Application\Controller\ManagerUsersController;
 use Zend\ServiceManager\FactoryInterface;
 use Zend\ServiceManager\ServiceLocatorInterface;

 class ManagerUsersControllerFactory implements FactoryInterface
 {
     /**
      * Create service
      *
      * @param ServiceLocatorInterface $serviceLocator
      *
      * @return mixed
      */
     public function createService(ServiceLocatorInterface $serviceLocator)
     {
          $realServiceLocator = $serviceLocator->getServiceLocator();
         $postService        = $realServiceLocator->get('Application\Service\IndexServiceInterface');
         $auth               = $realServiceLocator->get('Zend\Authentication\AuthenticationService');

         return new ManagerUsersController($postService,$auth);
     }
 }