<?php
 // Filename: /module/Blog/src/Blog/Factory/PostServiceFactory.php
 namespace Application\Factory;

 use Application\Service\IndexService;
 use Zend\ServiceManager\FactoryInterface;
 use Zend\ServiceManager\ServiceLocatorInterface;

 class IndexServiceFactory implements FactoryInterface
 {
     /**
      * Create service
      *
      * @param ServiceLocatorInterface $serviceLocator
      * @return mixed
      */
     public function createService(ServiceLocatorInterface $serviceLocator)
     {
         return new IndexService(
             $serviceLocator->get('Application\Mapper\IndexMapperInterface')
         );
     }
 }