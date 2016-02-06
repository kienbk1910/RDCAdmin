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
        return new ViewModel(
             array('agencys'=>$agencys,
                'processes'=>$processes,
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
            $task->reporter_id = $request->getPost('reporter_id');
            $task->assign_id = $request->getPost('assign_id');
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
            $date_open_pr = $request->getPost('date_open_rp','');
            if($date_open_pr == ''){
                $task->date_open_pr = $task->date_open;
            }else{
                $task->date_open_pr = Date::changeVNtoDateSQL($request->getPost('date_open_pr'));
            }
             $date_end_pr = $request->getPost('date_end_pr','');
            if($date_end_pr == ''){
                $task->date_end_pr = $task->date_end;
            }else{
                $task->date_end_pr = Date::changeVNtoDateSQL($request->getPost('date_end_pr'));
            }
            $task->provider_note = $request->getPost('provider_note');
            $result = $this->databaseService->insertTask($task);
            $task->id = $result->getGeneratedValue();
            $this->databaseService->insertLog($this->auth->getIdentity()->id, $task, Config::ADD_ACTION);

            /* Add send mail */
            $mail = new MailHelper();
            $receiver['reporter'] = $this->databaseService->getUserById($task->reporter_id)->current();
            $receiver['assign'] = $this->databaseService->getUserById($task->assign_id)->current();
            $receiver['agency'] = $this->databaseService->getUserById($task->agency_id)->current();
            $receiver['provider'] = $this->databaseService->getUserById($task->provider_id)->current();
            $mail->notify_create($task, $receiver, Config::ASSIGN_REPORTER_TYPE);

            // agency
            $mail->notify_create($task, $receiver, Config::AGENCY_TYPE);

            // provider
            $mail->notify_create($task, $receiver, Config::PROVIDER_TYPE);

            return $this->redirect()->toRoute('manager-tasks/detail',array('id'=> $task->id));
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
             if($name == "date_open" || $name == "date_end" || $name == "date_open_pr" || $name == "date_end_pr"){
                $value = Date::changeVNtoDateSQL($value);
             }
             $validator = new \Zend\Validator\Digits();
             if(($name == "cost_sell" || $name == "cost_buy") && !$validator->isValid($value)){
                     $result->setStatus(Xeditable::STATUS_ERROR);
                     $result->setMsg(Xeditable::MSG_DATA_NOT_NUMBER);
             }else{
                $log = new Log();
                $log->action_id = Config::EDIT_ACTION;
                $log->user_id = $this->auth->getIdentity()->id;
                $log->task_id = $id;
                $log->key = $name;
                $log->new_id = $value;
                /* Get old value of task */
                $task = $this->databaseService->getInfoTask($id);
                $array = $task->current();
                $log->old_id = $array[$name];
                $log->custumer = $array['custumer'];
                
                $this->databaseService->modifyLog($log);
                $this->databaseService->changeInfoOfTask($id,$name,$value,$this->auth->getIdentity()->id);
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
        $id = $this->databaseService->deletePayById($id);
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
                   $type = Config::PAY_CUSTUMER;
                }
                if($permission == Config::FILE_PERMISSION_PROVIDER){
                   $type = Config::PAY_PROVIDER;
                }
            }
            $comment = $this->databaseService->addComment($comment);
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
              $this->databaseService->addFileAttachment($file_attach);
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
}