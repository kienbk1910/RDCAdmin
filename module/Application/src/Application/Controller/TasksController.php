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
         $orders = $request->getPost('order','');
         $user_id = $this->auth->getIdentity()->id;
   
         $search = $search['value'];
         $total = $this->databaseService->getTotalTask(null,$user_id);

         $tasks =$this->databaseService->getListTask($start,$length,$search,$columns,$orders ,null,$user_id);
         $data = new DataTablesObject();
         $data->recordsTotal = $total;
         $data->recordsFiltered = $this->databaseService->getCountTasksFiltered($start,$length,$search,$columns,$orders,null,$user_id);
         $data->draw = $draw;
         foreach ($tasks as $task) {
            $item = new TaskListItem();
            $item->DT_RowId =$task->id;
            $item->custumer =$task->custumer;
            $item->certificate =$task->certificate;
            $item->process_name =$task->process_name;
            $item->agency_name =$task->agency_name;
            $item->cost_sell = number_format($task->cost_sell);
            $item->custumer_pay = number_format($this->databaseService->getTotalPay($task->id,Config::PAY_CUSTUMER));
            $item->date_open = Date::changeDateSQLtoVN($task->date_open);
            $item->date_end = Date::changeDateSQLtoVN($task->date_end);
            $item->process_name =$task->process_name;

            $item->provider_name =$task->provider_name;
            $item->cost_buy = number_format($task->cost_buy);
            $item->provider_pay = number_format($this->databaseService->getTotalPay($task->id,Config::PAY_PROVIDER));
            $item->date_open_pr = Date::changeDateSQLtoVN($task->date_open_pr);
            $item->date_end_pr = Date::changeDateSQLtoVN($task->date_end_pr);
            $item->assign_name =$task->assign_name;
            $item->reporter_name =$task->reporter_name;
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
         $orders = $request->getPost('order','');
         $user_id = $this->auth->getIdentity()->id;
   
         $search = $search['value'];
         $total = $this->databaseService->getTotalTask($user_id,null);

         $tasks =$this->databaseService->getListTask($start,$length,$search,$columns,$orders ,$user_id,null);
         $data = new DataTablesObject();
         $data->recordsTotal = $total;
         $data->recordsFiltered = $this->databaseService->getCountTasksFiltered($start,$length,$search,$columns,$orders,$user_id,null);
         $data->draw = $draw;
         foreach ($tasks as $task) {
            $item = new TaskListItem();
            $item->DT_RowId =$task->id;
            $item->custumer =$task->custumer;
            $item->certificate =$task->certificate;
            $item->process_name =$task->process_name;
            $item->agency_name =$task->agency_name;
            $item->cost_sell = number_format($task->cost_sell);
            $item->custumer_pay = number_format($this->databaseService->getTotalPay($task->id,Config::PAY_CUSTUMER));
            $item->date_open = Date::changeDateSQLtoVN($task->date_open);
            $item->date_end = Date::changeDateSQLtoVN($task->date_end);
            $item->process_name =$task->process_name;

            $item->provider_name =$task->provider_name;
            $item->cost_buy = number_format($task->cost_buy);
            $item->provider_pay = number_format($this->databaseService->getTotalPay($task->id,Config::PAY_PROVIDER));
            $item->date_open_pr = Date::changeDateSQLtoVN($task->date_open_pr);
            $item->date_end_pr = Date::changeDateSQLtoVN($task->date_end_pr);
            $item->assign_name =$task->assign_name;
            $item->reporter_name =$task->reporter_name;
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
        $id = $this->params()->fromRoute('id', 0);
        $task = $this->databaseService->getInfoTask($id);
        if($task->count() == 0 ){
             return $this->redirect()->toRoute('tasks');
        }
        $task = $task->current();
        $task->date_open = Date::changeDateSQLtoVN($task->date_open);
        $task->date_end = Date::changeDateSQLtoVN($task->date_end);
        $task->date_open_pr = Date::changeDateSQLtoVN($task->date_open_pr);
        $task->date_end_pr = Date::changeDateSQLtoVN($task->date_end_pr);
        $task->last_update = Date::changeDateSQLtoVN($task->last_update);
        $listprocess = $this->databaseService->getListProcess();
        $users = $this->databaseService->getListByRole(Config::ROLE_AGENCY);

        $agencys = array();
        foreach ($users as $user) {
             array_push($agencys,new User($user->id,$user->username,"",""));

        }
        $users = $this->databaseService->getListUserByBaseRole(Config::USER_LEAVE2);
        $staffs = array();
        foreach ($users as $user) {
             array_push($staffs,new User($user->id,$user->username,"",""));

        }
        $pay_custumer = $this->databaseService->getTotalPay($id,Config::PAY_CUSTUMER);
        $custumer_debt = number_format($task->cost_sell - $pay_custumer);
        $pay_custumer = number_format( $pay_custumer);
        $pay_provider = $this->databaseService->getTotalPay($id,Config::PAY_PROVIDER);
        $provider_debt = number_format($task->cost_buy - $pay_provider);
        $pay_provider = number_format( $pay_provider);
        $custumer_historys = $this->databaseService->getPayHistory($id,Config::PAY_CUSTUMER);
        $provider_historys = $this->databaseService->getPayHistory($id,Config::PAY_PROVIDER);

        return new ViewModel(array(
            'task'=> $task,
            'listprocess'=>$listprocess,
            'agencys'=>$agencys,
             'staffs'=>$staffs,
            'pay_custumer'=>$pay_custumer,
            'custumer_historys' =>$custumer_historys,
            'pay_provider'=>$pay_provider,
            'provider_historys'=>$provider_historys,
             'custumer_debt'=> $custumer_debt,
             'provider_debt'=> $provider_debt
            ));
     } 
      public function taskdetailAction()
     {
        $this->checkAuth();
        $id = $this->params()->fromRoute('id', 0);
        $task = $this->databaseService->getInfoTask($id);
        if($task->count() == 0 ){
             return $this->redirect()->toRoute('tasks');
        }
        $task = $task->current();
        $task->date_open = Date::changeDateSQLtoVN($task->date_open);
        $task->date_end = Date::changeDateSQLtoVN($task->date_end);
        $task->date_open_pr = Date::changeDateSQLtoVN($task->date_open_pr);
        $task->date_end_pr = Date::changeDateSQLtoVN($task->date_end_pr);
        $task->last_update = Date::changeDateSQLtoVN($task->last_update);
        $listprocess = $this->databaseService->getListProcess();
        $users = $this->databaseService->getListByRole(Config::ROLE_AGENCY);

        $agencys = array();
        foreach ($users as $user) {
             array_push($agencys,new User($user->id,$user->username,"",""));

        }
        $users = $this->databaseService->getListUserByBaseRole(Config::USER_LEAVE2);
        $staffs = array();
        foreach ($users as $user) {
             array_push($staffs,new User($user->id,$user->username,"",""));

        }
        $pay_custumer = $this->databaseService->getTotalPay($id,Config::PAY_CUSTUMER);
        $custumer_debt = number_format($task->cost_sell - $pay_custumer);
        $pay_custumer = number_format( $pay_custumer);
        $pay_provider = $this->databaseService->getTotalPay($id,Config::PAY_PROVIDER);
        $provider_debt = number_format($task->cost_buy - $pay_provider);
        $pay_provider = number_format( $pay_provider);
        $custumer_historys = $this->databaseService->getPayHistory($id,Config::PAY_CUSTUMER);
        $provider_historys = $this->databaseService->getPayHistory($id,Config::PAY_PROVIDER);

        return new ViewModel(array(
            'task'=> $task,
            'listprocess'=>$listprocess,
            'agencys'=>$agencys,
             'staffs'=>$staffs,
            'pay_custumer'=>$pay_custumer,
            'custumer_historys' =>$custumer_historys,
            'pay_provider'=>$pay_provider,
            'provider_historys'=>$provider_historys,
             'custumer_debt'=> $custumer_debt,
             'provider_debt'=> $provider_debt
            ));
     } 
}