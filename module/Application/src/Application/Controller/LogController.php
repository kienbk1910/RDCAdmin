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
        if ($request->isPost()) {
        }
        $task_id = $this->params()->fromRoute( 'id', 0 );
        $task_id = 25;
        $task = new Task();
        $task->id = $task_id;
        $log = new Log();
        $datas = $this->databaseService->showLog( $this->auth->getIdentity()->id, $task, $log );

        foreach ($datas as $data) {
            $modified_task = json_decode( $data->value, false );

            $tasks = $this->databaseService->getInfoTask($task_id);
            foreach ($tasks as $task) {
                $current_task = $task;
                return new ViewModel( array (
                        'modified_task' => $modified_task,
                        'current_task' => $current_task,
                ) );
                break;
            }
            break;
        }
    }

    public function showlogAction() {
        $this->checkAuth();
        $request = $this->getRequest();
        if ($request->isPost()) {
        }
        $task_id = $this->params()->fromRoute( 'id', 0 );
        $task = new Task();
        $task->id = $task_id;
        $log = new Log();
        $datas = $this->databaseService->showLog( $this->auth->getIdentity()->id, $task, $log );
        foreach ($datas as $data) {
            $obj = json_decode( $data->value, false );
            var_dump( $obj );
            exit();
        }

        return new JsonModel( array () );
    }
}