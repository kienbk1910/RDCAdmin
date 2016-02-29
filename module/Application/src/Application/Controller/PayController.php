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
use Application\Model\PayListItem;
use Application\Model\TaskListItem;
use Application\Model\PayAction;
use Application\Model\MoneyHistory;
use Utility\Date\Date;
use Application\Model\User;
use Application\Model\DataTablesObject;
use Application\Model\DataPay;
 class PayController extends BaseController
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
        $this->checkLevel2();
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Lịch Sử Thu Chi");
        $users = $this->databaseService->getListByRole(Config::ROLE_AGENCY);
         $agencys = array();
        array_push($agencys,new User(0,"Tất Cả","",""));
        foreach ($users as $user) {
             array_push($agencys,new User($user->id,$user->username,"",""));

        }
        return new ViewModel(
             array('agencys'=>$agencys,
              )
            );
         
        return new ViewModel( array (
       
        ) );
     }
     public function listAction(){
           $this->checkAuth();
           $this->checkLevel2();
         $request = $this->getRequest();

         $draw = $request->getPost('draw',1);
         $start = $request->getPost('start',0);
         $length = $request->getPost('length',10);
         $search = $request->getPost('search','');
         $columns = $request->getPost('columns','');
         $orders = $request->getPost('order','');

         $search = $search['value'];
         $total = $this->databaseService->getTotalPayAction(null);

         $tasks =$this->databaseService->getListPay($start,$length,$search,$columns,$orders ,null);
         $data = new DataTablesObject();
         $data->recordsTotal = $total;
         $data->recordsFiltered = $this->databaseService->getListPayFiltered($start,$length,$search,$columns,$orders ,null);
         $data->draw = $draw;
         foreach ($tasks as $task) {
            $item = new PayListItem();
            $item->DT_RowId =$task->id;
            $item->title = $task->title;
            $item->username =$task->username;
            $item->date_pay = Date::changeDateSQLtoVN($task->date_pay);
            if($task->type == Config::PAY_CUSTUMER)
             $item->type = "Thu";
             else{
               $item->type = "Chi"; 
             }
            if($task->is_task == Config::PAY_ACTION_IS_TASK){
                 $item->money =  number_format($this->databaseService->getMoneyPayAction($task->id)) ;
            }else{
                $item->money =  number_format($task->cost);
            }
            $item->user_create =$task->user_create;
            array_push($data->data,$item);
         }
        echo \Zend\Json\Json::encode($data, false);
        exit;
     }
     public function payAction(){
        $this->checkAuth();
        $this->checkLevel2();
       $type = $this->params()->fromQuery('type', 1);
       $user_id = $this->params()->fromQuery('user_id', 1);
       $task_list =  $this->params()->fromQuery('id', '');
       if($task_list == ''){
         // TODO
       }
       if($type == Config::PAY_CUSTUMER){
            $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Đại Lý Thanh Toán");
       }else{
            $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Thanh Toán Cho Nhà Cung Cấp");

       }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $count = $request->getPost('count',0);
            $user_id = $request->getPost('user_id',0);
            $type = $request->getPost('type',1);
            $date_pay = Date::changeVNtoDateSQL($request->getPost('date_pay'));
            $money_option = $request->getPost('money_option',1);
            $create_user = $this->auth->getIdentity()->id;
            $create_date = date('Y-m-d H:i:s');
             
            if($count >0){
                $pay = new PayAction();
                $pay->title = $request->getPost('title','');
                $pay->user_id =   $user_id;
                $pay->data = '';
                $pay->cost = 0;
                $pay->date_pay = $date_pay;
                $pay->pay_option = $money_option;
                $pay->create_user = $create_user;
                $pay->create_date = $create_date;
                $pay->type = $type;
                $pay->is_task = Config::PAY_ACTION_IS_TASK;
                $pay_id = $this->databaseService->addPayAction( $pay);
                if($pay_id >0){
                    for($i = 0; $i<$count;$i++){
                        $money = new MoneyHistory();
                        $money->user_id = $create_user;
                        $money->create_date = $create_date;
                        $money->last_update = $create_date;
                        $money->last_user_id = $create_user;
                        $money->task_id = $request->getPost(sprintf('id_%d',$i+1),0);
                        $money->money = str_replace(',','',$request->getPost(sprintf('money_%d',($i+1)),0));
                        $money->date_pay = $date_pay;
                        $money->money_option =  $money_option;
                        $money->note = "";
                        $money->type =$type;
                        $money->pay_action_id = $pay_id;
                        $task = $this->databaseService->getInfoTask($money->task_id)->current();
                        $money->custumer = $task['custumer'];
                        $this->databaseService->payLog($this->auth->getIdentity()->id, $money,$money->type);
                        $id = $this->databaseService->insertMoneyHistory($money);
                    }
                    return $this->redirect()->toRoute('pay/detail',array('id'=> $pay_id));

                }


            }
        }
       $task_list = explode(",",$task_list);
       $data = array();
       $tasks = $this->databaseService->getTaskListForPay($type,$user_id,$task_list);
        foreach ($tasks as $task) {
            $item = new TaskListItem();
            $item->DT_RowId =$task->id;
            $item->custumer =$task->custumer;
            $item->certificate =$task->certificate;
            $item->cost_sell = $task->cost_sell;
            if($type == Config::PAY_CUSTUMER){
                $item->custumer_pay = $this->databaseService->getTotalPay($task->id,Config::PAY_CUSTUMER);
            }else{
               $item->provider_pay = $this->databaseService->getTotalPay($task->id,Config::PAY_PROVIDER);

            }            $item->cost_buy = $task->cost_buy;
            array_push($data,$item);
         }
         $user = $this->databaseService->getUserById($user_id);
         $user = $user->current();
       return new ViewModel(array(
            'tasks' => $data,
             'user' => $user,
             'type' => $type,
        ));
     }
     public function deleteAction(){
        $this->checkAuth();
        $this->checkLevel2();
          $request = $this->getRequest();
        $id = $request->getPost('id',0);
        $old_pays = $this->databaseService->getListMoneyHistoryByPayId($id);
        foreach ($old_pays as $old_pay) {
             $pay = new MoneyHistory();
             $pay->id = $old_pay->id;
             $pay->task_id = $old_pay->task_id;
             $pay->date_pay = $old_pay->date_pay;
             $pay->money = $old_pay->money;
             $pay->money_option = $old_pay->money_option;
             $pay->note = $old_pay->note;
             $pay->type = $old_pay->type;
             $pay->custumer = $old_pay->custumer;
             $this->databaseService->deletePayLog($this->auth->getIdentity()->id, $pay,$pay->type); 
        }
        $this->databaseService->deletePayAction($id);
        $this->databaseService->deleteMoneyHistoryByPayId($id);
        return new JsonModel(array(

        ));
     }

     public function debtAction(){
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Tổng Kết Công Nợ");

         return new ViewModel(array(
      
        )); 
     }
     public function detailAction(){
        $this->checkAuth();
        $request = $this->getRequest();
        $id = $this->params()->fromRoute( 'id', 0 );
         $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set($id."- Chi Tiết Hóa Đơn");
        $pay = $this->databaseService->getPayActionById($id);
        if($pay == NULL){
            return $this->redirect()->toRoute('pay',array());
        }
        if($pay->is_task == Config::PAY_ACTION_NOT_TASK){
            return new ViewModel(array(
            "pay" => $pay
            ));
        }
        $moneys = $this->databaseService->getPayActionDetail($id);
     
        $data = array();
        foreach ($moneys as $money) {
            $item = new TaskListItem();
            $item->DT_RowId =$money->task_id;
            $item->custumer =$money->custumer;
            $item->certificate =$money->certificate;
            $item->cost_sell = $money->cost_sell;
            if($pay->type == Config::PAY_CUSTUMER){
                $item->custumer_pay = $this->databaseService->getTotalPay($money->task_id,Config::PAY_CUSTUMER);
            }else{
               $item->provider_pay = $this->databaseService->getTotalPay($money->task_id,Config::PAY_PROVIDER);

            }
            $item->cost_buy = $money->cost_buy;
            $item->current_pay = $money->money;
            array_push($data,$item);
         }
        return new ViewModel(array(
            "datas"=>$data,
            "pay" => $pay
        ));
     }
     public function newAction(){
         $type = $this->params()->fromRoute('id', 1);
        if($type == Config::PAY_CUSTUMER){
            $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Tạo Phiếu Thu");
       }else{
            $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Tạo Phiếu Chi");
       }
       $request = $this->getRequest();
        if ($request->isPost()) {
            $date_pay = Date::changeVNtoDateSQL($request->getPost('date_pay'));
            $money_option = $request->getPost('money_option',1);
            $create_user = $this->auth->getIdentity()->id;
            $create_date = date('Y-m-d H:i:s');
            $pay = new PayAction();
            $pay->title = $request->getPost('title','');
            $pay->user_id = 0;
            $pay->date_pay = $date_pay;
            $pay->pay_option = $money_option;
            $pay->create_user = $create_user;
            $pay->create_date = $create_date;
            $pay->type = $type;
            $pay->is_task = Config::PAY_ACTION_NOT_TASK;
            $count = $request->getPost('count',0);
            $datas = array();
            $total = 0;
            for($i = 1; $i <= $count;$i++){
                $data = new DataPay();
                $data->code_product = $request->getPost(sprintf('code_product_%d',$i),'');
                $data->name_product = $request->getPost(sprintf('name_product_%d',$i),'');
                $data->name_task = $request->getPost(sprintf('name_task_%d',$i),'');
                $data->cost_1 = str_replace(',','',$request->getPost(sprintf('cost_1_%d',$i),0));
                $data->cost_2 = str_replace(',','',$request->getPost(sprintf('cost_2_%d',$i),0));
                $data->cost_3 = str_replace(',','',$request->getPost(sprintf('cost_3_%d',$i),0));
                $data->cost_4 = str_replace(',','',$request->getPost(sprintf('cost_4_%d',$i),0));
                $total += $data->cost_4;
                array_push($datas,$data);
            
            }
            $pay->cost = $total;
            $pay->data = json_encode($datas);
            
            $pay_id = $this->databaseService->addPayAction( $pay);
             return $this->redirect()->toRoute('pay/detail',array('id'=> $pay_id));
        }
        return new ViewModel(array(
            "type"=>$type,
        ));
     }
}