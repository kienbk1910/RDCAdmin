<?php
namespace Application\Controller;
 use Application\Service\IndexServiceInterface;
 use Application\Controller\BaseController;
 use Zend\View\Model\ViewModel;
 use Zend\View\Model\JsonModel;
 use Zend\Authentication\AuthenticationService;
 class ManagerTasksController extends BaseController
 {
      protected $couponService;

     public function __construct(IndexServiceInterface $couponService,AuthenticationService $auth)
     
     {
        
        $this->couponService = $couponService;
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
        return new ViewModel();
     }

}