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
         $this->checkLevel2();
         $users = $this->databaseService->getListByRole(Config::ROLE_AGENCY);
         $agencys = array();
           array_push($agencys,new User(0,"Tất Cả","",""));
        foreach ($users as $user) {
             array_push($agencys,new User($user->id,$user->username,"",""));

        }
        $processes = $this->databaseService->getListProcess();
        return new ViewModel(
             array('agencys'=>$agencys,
                'processes'=>$processes)
            );
     }
      public function getlistAction(){
         $this->checkAuth();
         $request = $this->getRequest();

         $draw = $request->getPost('draw',1);
         $start = $request->getPost('start',0);
         $length = $request->getPost('length',10);
         $search = $request->getPost('search','');
         $columns = $request->getPost('columns','');
         $search = $search['value'];
         $total = $this->databaseService->getTotalTask();
       
         $tasks =$this->databaseService->getListTask($start,$length,$search,$columns,"");
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
            $item->agency_name =$task->agency_name;    
            $item->cost_sell = number_format($task->cost_sell);
            $item->custumer_pay =0;
            $item->date_open = Date::changeDateSQLtoVN($task->date_open);
            $item->date_end = Date::changeDateSQLtoVN($task->date_end);
            $item->process_name =$task->process_name; 

            $item->provider_name =$task->provider_name;    
            $item->cost_buy = number_format($task->cost_buy);
            $item->provider_pay =0;
            $item->date_open_pr = Date::changeDateSQLtoVN($task->date_open_pr);
            $item->date_end_pr = Date::changeDateSQLtoVN($task->date_end_pr);
     
            array_push($data->data,$item);
         }
        echo \Zend\Json\Json::encode($data, false);
        exit;
     }
     public function addAction()
     {
        $this->checkLevel2();
        $request = $this->getRequest();
        if ($request->isPost()) {
            // add task
            $task = new Task();
            // validate 
            // TO DO
            // user id create
            $task->user_id = $this->auth->getIdentity()->id;
            $task->create_date = date('Y-m-d H:i:s');
            $task->last_update = $task->create_date;
            $task->last_user_id =  $this->auth->getIdentity()->id;
            $task->process_id = Config::PROCESS_REC;
            $task->reporter_id = $request->getPost('reporter_id'); 
            // infor
            $task->custumer = $request->getPost('custumer'); 
            $task->certificate = $request->getPost('certificate'); 
            // agency
            $task->agency_id = $request->getPost('agency_id'); 
            $task->cost_sell = str_replace(',','',$request->getPost('cost_sell',0)); 
            $task->date_open = Date::changeVNtoDateSQL($request->getPost('date_open')); 
            $task->date_end  = Date::changeVNtoDateSQL($request->getPost('date_end')); 
            $task->agency_note = $request->getPost('agency_note'); 

            // provider
            $task->provider_id = $request->getPost('provider_id'); 
            $task->cost_buy = str_replace(',','',$request->getPost('cost_buy',0));
            $date_open_pr   = $request->getPost('date_open_rp','');
            if($date_open_pr == ''){
                $task->date_open_pr = $task->date_open;
            }else{
                $task->date_open_pr = Date::changeVNtoDateSQL($request->getPost('date_open_pr'));  
            }
             $date_end_pr   = $request->getPost('date_end_pr','');
            if($date_end_pr == ''){
                $task->date_end_pr = $task->date_end;
            }else{
                $task->date_end_pr = Date::changeVNtoDateSQL($request->getPost('date_end_pr'));  
            }
            $task->provider_note = $request->getPost('provider_note'); 
            $result = $this->databaseService->insertTask($task);
            
            return $this->redirect()->toRoute('manager-tasks/detail',array('id'=>$result->getGeneratedValue()));
        }
        $users = $this->databaseService->getListByRole(Config::ROLE_AGENCY);

        $agencys = array();
        foreach ($users as $user) {
             array_push($agencys,new User($user->id,$user->username,"",""));

        }
        $reporters = $this->databaseService->getListUserByBaseRole(Config::USER_LEAVE1);

        return new ViewModel(array(
            'agencys'=>$agencys,
            'reporters'=>$reporters
            ));
     }
      public function detailAction()
     {
        $this->checkLevel2();
         $id = $this->params()->fromRoute('id', 0);
        $task = $this->databaseService->getInfoTask($id);
        if($task->count() == 0 ){
             return $this->redirect()->toRoute('manager-tasks');
        }
        $task = $task->current();
        $task->date_open = Date::changeDateSQLtoVN($task->date_open);
        $task->date_end = Date::changeDateSQLtoVN($task->date_end);
        $task->date_open_pr = Date::changeDateSQLtoVN($task->date_open_pr);
        $task->date_end_pr = Date::changeDateSQLtoVN($task->date_end_pr);
        $listprocess = $this->databaseService->getListProcess();
        $users = $this->databaseService->getListByRole(Config::ROLE_AGENCY);

        $agencys = array();
        foreach ($users as $user) {
             array_push($agencys,new User($user->id,$user->username,"",""));

        } 
        $pay_custumer = number_format($this->databaseService->getTotalPay($id,Config::PAY_CUSTUMER));
        $pay_provider = number_format($this->databaseService->getTotalPay($id,Config::PAY_PROVIDER));
        $custumer_historys = $this->databaseService->getPayHistory($id,Config::PAY_CUSTUMER);
        $provider_historys = $this->databaseService->getPayHistory($id,Config::PAY_PROVIDER);
        return new ViewModel(array(
            'task'=> $task,
            'listprocess'=>$listprocess,
            'agencys'=>$agencys,
            'pay_custumer'=>$pay_custumer,
            'custumer_historys' =>$custumer_historys,
            'pay_provider'=>$pay_provider,
            'provider_historys'=>$provider_historys
            ));
     }
     public function changeinfoAction(){
         $this->checkLevel2();
         $value = $this->getRequest()->getPost('value');
         $name = $this->getRequest()->getPost('name');
         $id = $this->getRequest()->getPost('pk');
         $user = new User(NULL, NULL, NULL, NULL);
         $user->email = NULL;
         $user->phone = NULL;
         $user->note = NULL;
         if ($name == "pro-email") {
             $result = new Xeditable();
             $validator = new \Zend\Validator\EmailAddress();
             if ($validator->isValid($value)) {
                 $user->email = $value;
                 $this->databaseService->changeUserInfo($this->user->id, $user);
                 $this->user->email = $value;
             }else{
                 $result->setStatus(Xeditable::STATUS_ERROR);
                 $result->setMsg(Xeditable::MSG_DATA_ERROR);
             }
             echo \Zend\Json\Json::encode($result, false);
             exit;
         }

         if ($name == "pro-phone") {
             $result = new Xeditable();
             $validator = new \Zend\Validator\NotEmpty();
             if ($validator->isValid($value)) {
                 $user->phone = $value;
                 $this->databaseService->changeUserInfo($this->user->id, $user);
                 $this->user->phone = $value;
             }else{
                 $result->setStatus(Xeditable::STATUS_ERROR);
                 $result->setMsg(Xeditable::MSG_DATA_ERROR);
             }
             echo \Zend\Json\Json::encode($result, false);
             exit;
         }

         if ($name == "pro-note") {
             $result = new Xeditable();
             $validator = new \Zend\Validator\NotEmpty();
             if ($validator->isValid($value)) {
                 $user->note = $value;
                 $this->databaseService->changeUserInfo($this->user->id, $user);
                 $this->user->note = $value;
             }else{
                 $result->setStatus(Xeditable::STATUS_ERROR);
                 $result->setMsg(Xeditable::MSG_DATA_ERROR);
             }
             echo \Zend\Json\Json::encode($result, false);
             exit;
         }

         $valid = new \Zend\Validator\NotEmpty();
         $result = new Xeditable();
         if ($valid->isValid($value)) {
             if($name == "date_open" || $name == "date_end" || $name == "date_open_pr" || $name == "date_end_pr"){
                $value = Date::changeVNtoDateSQL($value);
             }
             $this->databaseService->changeInfoOfTask($id,$name,$value,$this->auth->getIdentity()->id);

         }else{
             $result->setStatus(Xeditable::STATUS_ERROR);
             $result->setMsg(Xeditable::MSG_DATA_EMPTY);
         }

         echo \Zend\Json\Json::encode($result, false);
         exit;
     }
     public function payAction(){
        $this->checkLevel2();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $pay = new MoneyHistory();
            // validate TODO
            // user info
            $pay->user_id = $this->auth->getIdentity()->id;
            $pay->create_date = date('Y-m-d H:i:s');
            $pay->last_update = $pay->create_date;
            $pay->last_user_id = $this->auth->getIdentity()->id;
            // info pay
            $pay->task_id = $request->getPost('task_id');
            $pay->money = str_replace(',','',$request->getPost('money',0));
            $pay->date_pay = Date::changeVNtoDateSQL($request->getPost('date_pay'));
            $pay->money_option = $request->getPost('money_option');
            $pay->note = $request->getPost('note');
            $pay->type = $request->getPost('type');
            $id = $this->databaseService->insertMoneyHistory($pay);
        }
        return new JsonModel(array(
        
        ));
     }
    public function payhistoryAction(){
        $this->checkLevel2();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $taks_id = $request->getPost('task_id');
            $type = $request->getPost('type');
            $historys = $this->databaseService->getPayHistory($taks_id,$type);
            $result = array();
            foreach ($historys as $history) {
                $item = new MoneyHistory();
                $item->id = $history->id;
                 $item->username = $history->username;
                $item->money = number_format($history->money);
                $item->date_pay = Date::changeDateSQLtoVN($history->date_pay);

                array_push($result,$item);
            }
          
        }
        return new JsonModel($result);
    }
}