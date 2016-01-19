<?php
namespace Application\Controller;
 use Application\Service\IndexServiceInterface;
 use Application\Controller\BaseController;
 use Zend\View\Model\ViewModel;
 use Zend\View\Model\JsonModel;
 use Zend\Authentication\AuthenticationService;
 use Application\Config\Config;
 use Application\Model\User;
 use Application\Model\Task;
 use Application\Model\DataTablesObject;
 use Application\Model\TaskListItem;
 use Utility\Date\Date;
 use Application\Model\Xeditable;
 use Zend\Validator;
 use Application\Model\MoneyHistory;
 use Utility\String\StringUtility;

 class TasksController extends BaseController
 {


     public function __construct(IndexServiceInterface $databaseService,AuthenticationService $auth)
     
     {
        
        $this->databaseService = $databaseService;
        $this->auth = $auth;
        $this->user = $auth->getIdentity();
         
     }
     public function getlisttasksAction(){
         $this->checkAuth();
         $request = $this->getRequest();

         $draw = $request->getPost('draw',1);
         $start = $request->getPost('start',0);
         $length = $request->getPost('length',10);
         $search = $request->getPost('search','');
         $columns = $request->getPost('columns','');
         $search = $search['value'];
         $total = $this->databaseService->getTotalTask();
       
         $tasks =$this->databaseService->getListTask($start,$length,$search,$columns,"", $this->user->id);
         $data = new DataTablesObject();
         $data->recordsTotal = $total;
         $data->recordsFiltered = $total;
         $data->draw = $draw;
         foreach ($tasks as $task) {
            $item = new TaskListItem();
            $item->DT_RowId =$task->id;
            $item->custumer =$task->custumer;
            $item->certificate =$task->certificate;
            $item->process_name =$task->process_name;    
            $item->cost_buy = number_format($task->cost_buy);
            $item->provider_pay = number_format($this->databaseService->getTotalPay($task->id,Config::PAY_PROVIDER));
            $item->date_open_pr = Date::changeDateSQLtoVN($task->date_open_pr);
            $item->date_end_pr = Date::changeDateSQLtoVN($task->date_end_pr);
            array_push($data->data,$item);
         }
        echo \Zend\Json\Json::encode($data, false);
        exit;
     }
     public function getlistordersAction(){
         $this->checkAuth();
         $request = $this->getRequest();

         $draw = $request->getPost('draw',1);
         $start = $request->getPost('start',0);
         $length = $request->getPost('length',10);
         $search = $request->getPost('search','');
         $columns = $request->getPost('columns','');
         $search = $search['value'];
         $total = $this->databaseService->getTotalTask();
       
         $tasks =$this->databaseService->getListTask($start,$length,$search,$columns,"",$this->user->id,null);
         $data = new DataTablesObject();
         $data->recordsTotal = $total;
         $data->recordsFiltered = $total;
         $data->draw = $draw;
         foreach ($tasks as $task) {
            $item = new TaskListItem();
            $item->DT_RowId =$task->id;
            $item->custumer =$task->custumer;
            $item->certificate =$task->certificate;
            $item->process_name =$task->process_name; 
            $item->cost_sell = number_format($task->cost_sell);
            $item->custumer_pay = number_format($this->databaseService->getTotalPay($task->id,Config::PAY_CUSTUMER));
            $item->date_open = Date::changeDateSQLtoVN($task->date_open);
            $item->date_end = Date::changeDateSQLtoVN($task->date_end);
            $item->process_name =$task->process_name; 
            array_push($data->data,$item);
         }
        echo \Zend\Json\Json::encode($data, false);
        exit;
     }
     public function indexAction()
     {
        $this->checkAuth();
        
        $processes = $this->databaseService->getListProcess();
        return new ViewModel( array(
                'processes'=>$processes)
            );
     }
    public function orderAction()
     {
        $this->checkAuth();
         $processes = $this->databaseService->getListProcess();
        return new ViewModel( array(
                'processes'=>$processes)
            ); 
     }
     public function orderdetailAction()
     {
        $this->checkAuth();
        
        return new ViewModel( array(
                )
        ); 
     }
}