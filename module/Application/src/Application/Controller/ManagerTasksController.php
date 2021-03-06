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
use Application\Email\MailHelper;
use DOMPDFModule\View\Model\PdfModel;
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
       
         $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Danh Sách Hồ Sơ");
         $this->checkLevel2();
         $users = $this->databaseService->getListByRole(Config::ROLE_AGENCY);
         $agencys = array();
           array_push($agencys,new User(0,"Tất Cả","",""));
        foreach ($users as $user) {
             array_push($agencys,new User($user->id,$user->username,"",""));

        }
         $users = $this->databaseService->getListUserByBaseRole(Config::USER_LEAVE2);
        $staffs = array();
        foreach ($users as $user) {
             array_push($staffs,new User($user->id,$user->username,"",""));

        }
        $processes = $this->databaseService->getListProcess();
        $processes_s = array();
        foreach ($processes as $user) {
             array_push($processes_s,new User($user->id,$user->name,"",""));

        }
       
        return new ViewModel(
             array('agencys'=>$agencys,
                'processes'=>$processes_s,
                 'staffs'=>$staffs)
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
         $orders = $request->getPost('order','');

         $search = $search['value'];
         $total = $this->databaseService->getTotalTask(null,null);

         $tasks =$this->databaseService->getListTask($start,$length,$search,$columns,$orders ,null,null);
         $data = new DataTablesObject();
         $data->recordsTotal = $total;
         $data->recordsFiltered = $this->databaseService->getCountTasksFiltered($start,$length,$search,$columns,$orders,null,null);
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
             $item->process_id =  $task->process_id;
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
     public  function exportPdfAction(){
        $pdf = new PdfModel();
        $pdf->setOption('filename', 'monthly-report'); // Triggers PDF download, automatically appends ".pdf"
        $pdf->setOption('paperSize', 'a4'); // Defaults to "8x11"
        $pdf->setOption('paperOrientation', 'landscape'); // Defaults to "portrait"
 
        $pdf->setVariables(array(
          'message' => 'Hello'
        ));
 
        return $pdf;
        $this->checkAuth();
         $request = $this->getRequest();

         $draw = $request->getPost('draw',1);
         $start = $request->getPost('start',0);
         $length = $request->getPost('length',10);
         $search = $request->getPost('search','');
         $columns = $request->getPost('columns','');
         $orders = $request->getPost('order','');
          $search = $search['value'];
         $tasks =$this->databaseService->getListTask(null,null,$search,$columns,$orders ,null,null);
         $data = new DataTablesObject();
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
     public function addAction()
     { 
        $this->checkLevel2();
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Thêm Hồ Sơ");
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
            $task->reporter_id = $request->getPost('reporter_id',Config::ID_REPORTER_DEFAULT);
            $task->assign_id = $request->getPost('assign_id',Config::ID_ASSIGN_DEFAULT);
            // infor
            $task->custumer = $request->getPost('custumer');
            $task->certificate = $request->getPost('certificate');
            // agency
            $task->agency_id = $request->getPost('agency_id');
            $task->cost_sell = str_replace(',','',$request->getPost('cost_sell',0));
            $task->date_open = Date::changeVNtoDateSQL($request->getPost('date_open'));
            if($task->date_end != ''){
                $task->date_end  = Date::changeVNtoDateSQL($request->getPost('date_end'));
            }
        
            $task->agency_note = $request->getPost('agency_note');

            // provider
            $task->provider_id = $request->getPost('provider_id');
            $task->cost_buy = str_replace(',','',$request->getPost('cost_buy',0));
            /* Viet change */
            $date_open_pr = $request->getPost('date_open_pr','');
            if($date_open_pr != ''){
                $task->date_open_pr = Date::changeVNtoDateSQL($date_open_pr);
            }
            $date_end_pr = $request->getPost('date_end_pr','');
            if($date_end_pr != ''){
                $task->date_end_pr = Date::changeVNtoDateSQL($date_end_pr);
            }
            /* Viet End change */

            $task->provider_note = $request->getPost('provider_note');
            $result = $this->databaseService->insertTask($task);
            $task->id = $result->getGeneratedValue();
            $this->databaseService->insertLog($this->auth->getIdentity()->id, $task,Config::PAY_INFO_COMMON);

            /* Add send mail */
            $mail = new MailHelper();
            $receiver['reporter'] = $this->databaseService->getUserById($task->reporter_id)->current();
            $receiver['assign'] = $this->databaseService->getUserById($task->assign_id)->current();
            $receiver['agency'] = $this->databaseService->getUserById($task->agency_id)->current();
            $receiver['provider'] = $this->databaseService->getUserById($task->provider_id)->current();
            $mail->notify_to_admin($task->toArray(), $receiver, Config::NOTIFY_CREATE);

            // agency
            $mail->notify_to_user($task->toArray(), $receiver, Config::AGENCY_TYPE, Config::NOTIFY_CREATE);

            // provider
            $mail->notify_to_user($task->toArray(), $receiver, Config::PROVIDER_TYPE, Config::NOTIFY_CREATE);
            $ajax = $request->getPost('ajax',0);
            if($ajax == 0){
                 return $this->redirect()->toRoute('manager-tasks/detail',array('id'=> $task->id));
            }
            $task = $this->databaseService->getInfoTask($task->id);
            if($task->count() == 0 ){
                return new JsonModel(array('id'=> 0));
            }
            $task = $task->current();
            $task->date_open = Date::changeDateSQLtoVN($task->date_open);
            $task->date_end = Date::changeDateSQLtoVN($task->date_end);
            $task->date_open_pr = Date::changeDateSQLtoVN($task->date_open_pr);
            $task->date_end_pr = Date::changeDateSQLtoVN($task->date_end_pr);
            $task->last_update = Date::changeDateSQLtoVN($task->last_update);
            $task->cost_sell = number_format($task->cost_sell);
            $task->cost_buy = number_format($task->cost_buy);
            return new JsonModel(array(
                'task'=> $task
            ));
        
        }
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
        return new ViewModel(array(
            'agencys'=>$agencys,
            'staffs'=>$staffs
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
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set($task->id." - ".$task->custumer);
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
     public function changeinfoAction(){
         $this->checkLevel2();
         $value = $this->getRequest()->getPost('value');
         $name = $this->getRequest()->getPost('name');
         $id = $this->getRequest()->getPost('pk');

         $valid = new \Zend\Validator\NotEmpty();
         $result = new Xeditable();
         if ($valid->isValid($value)) {
            $log = new Log();
            $log->action_id = Config::EDIT_ACTION;
            $log->user_id = $this->auth->getIdentity()->id;
            $log->task_id = $id;
            $log->key = $name;
            $log->new_id = $value;
            /* Get old value of task */
            $detail_task = $this->databaseService->getInfoTask($id)->current();
            $log->old_id = $detail_task[$name];
            $log->custumer = $detail_task['custumer'];
            
            /* Backup value */
            $new_value = $value;
            $old_value = $log->old_id;
            /* Get pay history */
            $tmp_pay_custumer = $this->databaseService->getTotalPay($id,Config::PAY_CUSTUMER);
            $pay_custumer = number_format($tmp_pay_custumer);
            $detail_task['pay_custumer'] = $pay_custumer;
            /* Convert new pay history */
            if ($name == Config::cost_sell_id) {
                $custumer_debt = number_format($new_value - $tmp_pay_custumer);
                $detail_task['custumer_debt'] = $custumer_debt;
            } else {
                $custumer_debt = number_format($detail_task->cost_sell - $tmp_pay_custumer);
                $detail_task['custumer_debt'] = $custumer_debt;
            }

            $tmp_pay_provider = $this->databaseService->getTotalPay($id,Config::PAY_PROVIDER);
            $pay_provider = number_format($tmp_pay_provider);
            $detail_task['pay_provider'] = $pay_provider;
            /* Convert new pay history */
            if ($name == Config::cost_buy_id) {
                $provider_debt = number_format($new_value - $tmp_pay_provider);
                $detail_task['provider_debt'] = $provider_debt;
            } else {
                $provider_debt = number_format($detail_task->cost_buy - $tmp_pay_provider);
                $detail_task['provider_debt'] = $provider_debt;
            }
            /* Convert number to readable value */
            if ($name == Config::cost_sell_id || $name == Config::cost_buy_id) {
                $old_value = number_format($old_value);
                $new_value = number_format($new_value);
            }
            /* Convert process_id */
            if ($name == Config::process_id) {
                $old_value= $this->databaseService->getProcessBaseID($old_value)->current()['name'];
                $new_value= $this->databaseService->getProcessBaseID($new_value)->current()['name'];
            }
             if($name == "date_open" || $name == "date_end" || $name == "date_open_pr" || $name == "date_end_pr"){
                $value = Date::changeVNtoDateSQL($value);
                $old_value = Date::changeDateSQLtoVN($log->old_id);
             }

             $validator = new \Zend\Validator\Digits();
             if (($name == "cost_sell" || $name == "cost_buy") && !$validator->isValid($value)) {
                 $result->setStatus(Xeditable::STATUS_ERROR);
                 $result->setMsg(Xeditable::MSG_DATA_NOT_NUMBER);
             } else {
                $type = Config::PAY_INFO_COMMON;
                if($name == "date_open" || $name == "date_end" ||$name == "cost_sell" ||$name == "agency_note" ||$name == "agency_id" ){
                   $type = Config::PAY_CUSTUMER;  
                }
                if($name == "date_open_pr" || $name == "date_end_pr" ||$name == "cost_buy" ||$name == "provider_note" ||$name == "provider_id"){
                    $type = Config::PAY_PROVIDER; 
                }

                /* Add log */
                $this->databaseService->modifyLog($log,$type);
                $this->databaseService->changeInfoOfTask($id,$name,$value,$this->auth->getIdentity()->id);
                
                /* Add send mail */
                $mail = new MailHelper();
                $receiver['reporter'] = $this->databaseService->getUserById($detail_task['reporter_id'])->current();
                $receiver['assign'] = $this->databaseService->getUserById($detail_task['assign_id'])->current();
                $receiver['agency'] = $this->databaseService->getUserById($detail_task['agency_id'])->current();
                $receiver['provider'] = $this->databaseService->getUserById($detail_task['provider_id'])->current();

                /* Convert new user_id to user_name */
                if ($name == Config::reporter_id || $name == Config::assign_id || $name == Config::agency_id || $name == Config::provider_id) {
                    $new_value = $this->databaseService->getUserById($value)->current()->username;
                    $old_value = $this->databaseService->getUserById($log->old_id)->current()->username;
                }

                $ret = NULL;
                if ($name == Config::agency_id
                        || $name == Config::cost_sell_id
                        || $name == Config::date_open_id
                        || $name == Config::date_end_id
                        || $name == Config::agency_note_id
                        || $name == Config::custumer_id
                        || $name == Config::certificate_id
                        || $name == Config::process_id
                        || $name == Config::reporter_id
                        || $name == Config::assign_id) {
                    /* For agency: agency_id, cost_sell, date_open, date_end, agency_note */
                    $mail->notify_modify_to_agency($detail_task, $receiver, $name, $old_value, $new_value);
                } 
                if ($name == Config::provider_id
                        || $name == Config::cost_buy_id
                        || $name == Config::date_open_pr_id
                        || $name == Config::date_end_pr_id
                        || $name == Config::provider_note_id
                        || $name == Config::custumer_id
                        || $name == Config::certificate_id
                        || $name == Config::process_id
                        || $name == Config::reporter_id
                        || $name == Config::assign_id) {
                    /* For provider: provider_id, cost_buy, date_open_pr, date_end_pr, provider_note */
                    $mail->notify_modify_to_provider($detail_task, $receiver, $name, $old_value, $new_value);
                }
                $mail->notify_modify_to_admin($detail_task, $receiver, $name, $old_value, $new_value);
            }
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
            $pay->id = $request->getPost('id',0);

            $task = $this->databaseService->getInfoTask($pay->task_id)->current();
             $email = new MailHelper();
            $pay->custumer = $task['custumer'];
            if($pay->id != 0){
                $old_pay = $this->databaseService->getPayById($pay->id);
                if($old_pay != null){
                     $this->databaseService->modifyPayLog($this->auth->getIdentity()->id, $old_pay,$pay,$pay->type);
                     $email->notify_edit_pay($task,$this->auth->getIdentity()->username,$old_pay,$pay,$pay->type); 
                }
            }else{
               $this->databaseService->payLog($this->auth->getIdentity()->id, $pay,$pay->type);
               $email->notify_add_pay($task,$this->auth->getIdentity()->username, $pay,$pay->type); 
            }
            /* viet add */
            /* Get task (get custumer) */
       
            
            $id = $this->databaseService->insertMoneyHistory($pay);
        }
        return new JsonModel(array(

        ));
     }
    public function deletepayAction(){
        $this->checkLevel2();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $id = $request->getPost('id',0);
             $old_pay = $this->databaseService->getPayById($id);
             if($old_pay !=null){
                $task = $this->databaseService->getInfoTask($old_pay->task_id)->current();
                $old_pay->custumer = $task['custumer'];
                $this->databaseService->deletePayLog($this->auth->getIdentity()->id, $old_pay,$old_pay->type); 
                $id = $this->databaseService->deletePayById($id);
                $mail = new MailHelper();
                $mail->notify_delete_pay($task,$this->auth->getIdentity()->username, $old_pay,$old_pay->type); 
             }
           
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
    public function addcommentAction(){
        $this->checkAuth();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $comment = new Comment();
            $comment->user_id = $this->auth->getIdentity()->id;
            $comment->create_date = date('Y-m-d H:i:s');
            $comment->task_id = $request->getPost('task_id');
            $comment->comment = $request->getPost('comment');
            $comment->type = $request->getPost('type');
            $comment->is_read = 0;
            if($this->isLevel2() != true){
                $permission = $this->databaseService->getPermissionUser($comment->task_id,$this->auth->getIdentity()->id);
                if($permission == Config::FILE_PERMISSION_ERROR){
                      return new JsonModel(array());
                }
                if($permission == Config::FILE_PERMISSION_CUSTUMER){
                   $comment->type = Config::PAY_CUSTUMER;
                }
                if($permission == Config::FILE_PERMISSION_PROVIDER){
                    $comment->type  = Config::PAY_PROVIDER;
                }
            }
            $this->databaseService->addCommentLog($this->auth->getIdentity()->id,$comment,$comment->type );
            $this->databaseService->addComment($comment);
            $task = $this->databaseService->getInfoTask($comment->task_id)->current();
            $email = new MailHelper();
            $email->notify_add_comment($task,$this->auth->getIdentity()->username, $comment->comment,$comment->type); 
        }
        return new JsonModel(array(

        ));
    }
    public function getcommentAction(){
        $this->checkAuth();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $task_id = $request->getPost('task_id');
            $type = $request->getPost('type');
             if($this->isLevel2() != true){
                $permission = $this->databaseService->getPermissionUser($task_id,$this->auth->getIdentity()->id);
                if($permission == Config::FILE_PERMISSION_ERROR){
                      return new JsonModel(array());
                }
                if($permission == Config::FILE_PERMISSION_CUSTUMER){
                   $type = Config::PAY_CUSTUMER;
                }
                if($permission == Config::FILE_PERMISSION_PROVIDER){
                   $type = Config::PAY_PROVIDER;
                }
            }
            $data = $this->databaseService->getListComment($task_id,$type);

        }
        return new JsonModel($data);
    }
    public function addfileAction(){
        $this->checkAuth();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $file_attach = new FileAttachment();
            $file_attach->user_create = $this->auth->getIdentity()->id;
            $file_attach->date_create = date('Y-m-d H:i:s');
            $file_attach->last_date = $file_attach->date_create ;
            $file_attach->last_user = $this->auth->getIdentity()->id;
            // info pay
            $file_attach->task_id = $request->getPost('task_id');
            $file_attach->permission_option = $request->getPost('permission_option');
            if($this->isLevel2() != true){
                $permission = $this->databaseService->getPermissionUser($file_attach->task_id,$file_attach->user_create);
                if($permission == Config::FILE_PERMISSION_ERROR){
                      return new JsonModel(array());
                }
                if($permission == Config::FILE_PERMISSION_CUSTUMER){
                   $file_attach->permission_option = Config::FILE_PERMISSION_CUSTUMER; 
                }
                if($permission == Config::FILE_PERMISSION_PROVIDER){
                   $file_attach->permission_option = Config::FILE_PERMISSION_PROVIDER; 
                }
            }
            // File upload input
            $file = new FileInput('file_name');           // Special File Input type
            $file->getValidatorChain()               // Validators are run first w/ FileInput
            ->attach(new Validator\File\UploadFile());
            $file->getFilterChain()                  // Filters are run second w/ FileInput
            ->attach(new Filter\File\RenameUpload(array(
             'target'    => '.'.Config::FILE_ATTACHMENT_PATH.$file_attach->task_id,
             'use_upload_name'=>true,
             'randomize' => true,
            )));
            if (!file_exists('.'.Config::FILE_ATTACHMENT_PATH.$file_attach->task_id)) {
                 mkdir('.'.Config::FILE_ATTACHMENT_PATH.$file_attach->task_id, 0700, true);
            }
            // Merge $_POST and $_FILES data together

            $request  = new Request();
            $postData = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());

            $inputFilter = new InputFilter();
            $inputFilter->add($file)->setData($postData);
            if ($inputFilter->isValid()) {           // FileInput validators are run, but not the filters...

              $data = $inputFilter->getValues();   // This is when the FileInput filters are run.

              $file_attach->real_name = basename($data['file_name']['tmp_name']);
              $file_attach->file_name = basename($data['file_name']['name']);
              $result = $this->databaseService->addFileAttachment($file_attach);
              $file_attach->id  = $result->getGeneratedValue();
              $this->databaseService->addFileLog($this->auth->getIdentity()->id,$file_attach,Config::PAY_INFO_COMMON);
            }
        }
          return new JsonModel(array());
    }
    public function filelistAction(){
        $this->checkAuth();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $task_id = $request->getPost('task_id');
            if($this->isLevel2() != true){
                $permission = $this->databaseService->getPermissionUser($task_id, $this->auth->getIdentity()->id);
                if($permission == Config::FILE_PERMISSION_ERROR){
                      return new JsonModel(array());
                }
                if($permission == Config::FILE_PERMISSION_CUSTUMER){
                   $permission= Config::FILE_PERMISSION_CUSTUMER; 
                }
                if($permission == Config::FILE_PERMISSION_PROVIDER){
                   $permission = Config::FILE_PERMISSION_PROVIDER; 
                }
            }else{
                $permission = Config::FILE_PERMISSION_RDC; 
            }
            $files = $this->databaseService->getListFileActtacment($task_id,$permission );
            return new JsonModel($files);
        }
    }
     public function editfileAction(){
        $this->checkLevel2();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $id = $request->getPost('id');
            $permission = $request->getPost('permission');
            $files = $this->databaseService->editPermissionFile($id,$permission);
            return new JsonModel();
        }
    }
   public function deletefileAction(){
        $this->checkAuth();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $id = $request->getPost('id');
            $attachment = $this->databaseService->getFileAttachment($id);
            $files = $this->databaseService->deleteAttachment($id);
            if($attachment != null){
                unlink('.'.Config::FILE_ATTACHMENT_PATH.$attachment->task_id.'/'.$attachment->real_name);
                $file = new FileAttachment();
                 $file->file_name = $attachment->file_name;
                  $file->task_id = $attachment->task_id;
                $this->databaseService->deleteFileLog($this->auth->getIdentity()->id,$file,Config::PAY_INFO_COMMON);
            }
            return new JsonModel();
        }
    }
     public function downloadfileAction(){
        $this->checkAuth();
        $id = $this->params()->fromQuery('id', 0);
        $attachment = $this->databaseService->getFileAttachment($id);
        $file = '.'.Config::FILE_ATTACHMENT_PATH.$attachment->task_id.'/'.$attachment->real_name;

        $response = new \Zend\Http\Response\Stream();
        $response->setStream(fopen($file, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($file));
        $headers = new \Zend\Http\Headers();
        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($attachment->file_name) .'"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($file),
            'Expires' => '@0', // @0, because zf2 parses date as string to \DateTime() object
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public'
        ));
        $response->setHeaders($headers);
        return $response;
    }
    public function addFastAction(){
        $this->checkLevel2();
         $agencys = $this->databaseService->getListByRole(Config::ROLE_AGENCY);
         return new ViewModel(array(
            'agencys' =>$agencys
        )); 
    }
}