<?php
namespace Application\Controller;
 use Application\Service\IndexServiceInterface;
 use Application\Controller\BaseController;
 use Zend\View\Model\ViewModel;
 use Zend\View\Model\JsonModel;
 use Zend\Authentication\AuthenticationService;
 class ProfileController extends BaseController
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
        $request = $this->getRequest();
        if (!$request->isPost()) {
            // save image 

            $avatar = "345.png";
            $this->databaseService->updateAvatar($this->user->id,$avatar);
            
        }
        return new ViewModel();
    
        
     }
   

}