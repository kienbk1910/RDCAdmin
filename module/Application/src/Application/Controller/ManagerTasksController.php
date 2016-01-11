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
        return new ViewModel();
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
        $listprocess = $this->databaseService->getListProcess();
        $users = $this->databaseService->getListByRole(Config::ROLE_AGENCY);

        $agencys = array();
        foreach ($users as $user) {
             array_push($agencys,new User($user->id,$user->username,"",""));

        }
        $pay_custumer = number_format($this->databaseService->getTotalPay($id,Config::PAY_CUSTUMER));
        return new ViewModel(array(
            'task'=> $task,
            'listprocess'=>$listprocess,
            'agencys'=>$agencys,
            'pay_custumer'=>$pay_custumer
            ));
     }
     public function changeinfoAction(){
         $this->checkLevel2();
         $value = $this->getRequest()->getPost('value');
         $name = $this->getRequest()->getPost('name');
         $id = $this->getRequest()->getPost('pk');
         $valid = new \Zend\Validator\NotEmpty();
        $result = new Xeditable();
        if ($valid->isValid($value)) {
            if($name == "date_open" ||$name == "date_end" ){
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
}