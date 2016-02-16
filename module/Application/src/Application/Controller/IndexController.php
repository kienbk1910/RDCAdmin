<?php
namespace Application\Controller;
 use Application\Service\IndexServiceInterface;
 use Application\Controller\BaseController;
 use Zend\View\Model\ViewModel;
 use Zend\View\Model\JsonModel;
 use Application\Model\Task;
 use Application\Config\Config;
 use Zend\Authentication\AuthenticationService;
 use Application\Model\Notification;
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
     public function statisticAction(){
          return new ViewModel();
     }
    public function addNotificationAction(){
        $this->checkAdmin();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $notification = new Notification();
            $notification->user_id = $this->auth->getIdentity()->id;
            $notification->date = date('Y-m-d H:i:s');
            $notification->notification = $request->getPost('notification',"");
            if( $notification->notification != ""){
                 $this->databaseService->addNotification($notification);
            }
        }
        return new JsonModel(array(

        ));
    }
    public function listNotificationAction(){
        $this->checkAuth();
        $data = $this->databaseService->getNotifications(5);
         return new JsonModel($data);
    }

}