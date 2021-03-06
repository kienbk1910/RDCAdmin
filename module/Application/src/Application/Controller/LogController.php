<?php

namespace Application\Controller;

use Application\Service\IndexServiceInterface;
use Application\Controller\BaseController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Application\Config\Config;
use Application\Model\User;
use Application\Model\Comment;
use Application\Model\Task;
use Application\Model\Log;
use Application\Model\DataTablesObject;
use Application\Model\TaskListItem;
use Utility\Date\Date;
use Application\Model\Xeditable;
use Zend\Validator;
use Application\Model\MoneyHistory;
use Utility\String\StringUtility;
use Application\Model\FileAttachment;
use Zend\Http\PhpEnvironment\Request;
use Zend\Filter;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\InputFilter\FileInput;

class LogController extends BaseController {
    public function __construct(IndexServiceInterface $databaseService, AuthenticationService $auth) {
        $this->databaseService = $databaseService;
        $this->auth = $auth;
        $this->user = $auth->getIdentity();
    }

    public function indexAction() {
        $this->checkAuth();
        $request = $this->getRequest();

        $task = new Task();
        /* Get all logs */
        $task->id = NULL;
        $id_user =  $this->auth->getIdentity()->id;
        if($this->isLevel2()){
            $id_user =  null;
        }
        
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set('Lịch Sử Thay Đổi');
        $logs = $this->databaseService->showLog( $id_user, $task);
         $logs->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
          // set the number of items per page to 10
         $logs->setItemCountPerPage(Config::MAX_ITEM_OF_PAGE);
         $id_user =  $this->auth->getIdentity()->id;
        $role =  $this->auth->getIdentity()->role_id;
        return new ViewModel( array (
                'logs' => $logs,
                   'user_id'=>$id_user,
                'role' =>$role
        ) );
    }
  
    public function showlogAction() {
        $this->checkAuth();
        $request = $this->getRequest();
        $task_id = $this->params()->fromRoute( 'id', 0 );
        $task = new Task();
        $task->id = $task_id;
        $id_user =  $this->auth->getIdentity()->id;
        if($this->isLevel2()){
            $id_user =  null;
        }
        
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set($task_id.' - Lịch Sử Thay Đổi');
        $logs = $this->databaseService->showLog( $id_user, $task);
         $logs->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
          // set the number of items per page to 10
         $logs->setItemCountPerPage(Config::MAX_ITEM_OF_PAGE);
        $role =  $this->auth->getIdentity()->id;
         $id_user =  $this->auth->getIdentity()->role_id;
        return new ViewModel( array (
                'logs' => $logs,
                'task_id'=>$task_id,
                'user_id'=>$id_user,
                'role' =>$role
        ) );
    }
}