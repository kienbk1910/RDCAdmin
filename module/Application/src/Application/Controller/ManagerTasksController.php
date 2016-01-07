<?php
namespace Application\Controller;
 use Application\Service\IndexServiceInterface;
 use Application\Controller\BaseController;
 use Zend\View\Model\ViewModel;
 use Zend\View\Model\JsonModel;
 use Zend\Authentication\AuthenticationService;
 use Application\Config\Config;
 use Application\Model\User;
 class ManagerTasksController extends BaseController
 {
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
        $users = $this->databaseService->getListByRole(Config::ROLE_AGENCY);
        $agencys = array();
        foreach ($users as $user) {
             array_push($agencys,new User($user->id,$user->username,"",""));

        }
        return new ViewModel(array(
            'agencys'=>$agencys 
            ));
     }
      public function detailAction()
     {
        $this->checkAuth();
        return new ViewModel();
     }
     

}