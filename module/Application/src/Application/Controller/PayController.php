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
 use Application\Model\TaskListItem;
 use Application\Model\PayAction;
 use Application\Model\MoneyHistory;
 use Utility\Date\Date;
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
        $request = $this->getRequest();
        $task = new Task();
        $task->id = NULL;
        $id_user =  $this->auth->getIdentity()->id;
        $role =  $this->auth->getIdentity()->role_id;
        if($this->isLevel2()){
            $id_user =  null;
        }
        $logs = $this->databaseService->showLog( $id_user, $task);
         $logs->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
          // set the number of items per page to 10
         $logs->setItemCountPerPage(20);
         
        return new ViewModel( array (
                'logs' => $logs,
                'user_id'=>$id_user,
                'role' =>$role
        ) );
     }
     public function payAction(){
        $this->checkAuth();
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
                $pay->user_id =   $user_id;
                $pay->date_pay = $date_pay;
                $pay->pay_option = $money_option;
                $pay->create_user = $create_user;
                $pay->create_date = $create_date;
                $pay->type = $type;
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
     public function detailAction(){
        $this->checkAuth();
        $request = $this->getRequest();
        $id = $this->params()->fromRoute( 'id', 0 );
        $moneys = $this->databaseService->getPayActionDetail($id);
        $pay = $this->databaseService->getPayActionById($id);
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
}