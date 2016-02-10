<?php
namespace Application\Controller;
 use Application\Service\IndexServiceInterface;
 use Application\Controller\BaseController;
 use Zend\View\Model\ViewModel;
 use Zend\View\Model\JsonModel;
 use Application\Model\Task;
 use Application\Config\Config;
 use Zend\Authentication\AuthenticationService;
 class IndexController extends BaseController
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
        $request = $this->getRequest();
        $task = new Task();
        $task->id = NULL;
        $id_user =  $this->auth->getIdentity()->id;
        if($this->isLevel2()){
            $id_user =  null;
        }
        $logs = $this->databaseService->showLog( $id_user, $task);
         $logs->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
          // set the number of items per page to 10
         $logs->setItemCountPerPage(20);
        return new ViewModel( array (
                'logs' => $logs,
        ) );
     }
}