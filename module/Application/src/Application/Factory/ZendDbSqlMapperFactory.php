<?php
 // Filename: /module/Blog/src/Blog/Factory/ZendDbSqlMapperFactory.php
 namespace Application\Factory;

 use Application\Mapper\ZendDbSqlMapper;
 use Zend\ServiceManager\FactoryInterface;
 use Zend\ServiceManager\ServiceLocatorInterface;


 class ZendDbSqlMapperFactory implements FactoryInterface
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
         return new ZendDbSqlMapper(
             $serviceLocator->get('Zend\Db\Adapter\Adapter')
         );
     }
 }