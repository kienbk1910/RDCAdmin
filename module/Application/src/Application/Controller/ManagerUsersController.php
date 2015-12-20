<?php
namespace Application\Controller;
 use Application\Service\IndexServiceInterface;
 use Application\Controller\BaseController;
 use Zend\View\Model\ViewModel;
 use Zend\View\Model\JsonModel;
 use Zend\Authentication\AuthenticationService;
 class ManagerUsersController extends BaseController
 {
      protected $databaseService;

     public function __construct(IndexServiceInterface $databaseService,AuthenticationService $auth)
     
     {
        
        $this->databaseService = $databaseService;
        $this->auth = $auth;
        $this->user = $auth->getIdentity();
         
     }

     public function indexAction()
     {
        $this->checkAuth();
        return new ViewModel();
    
        
     }
   
     public function addAction()
     {
        $this->checkAuth();
        $roles = $this->databaseService->getlistRoles();
        return new ViewModel(array(
            'roles' =>$roles 
            ));
     }

}