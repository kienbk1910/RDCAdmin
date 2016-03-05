<?php
namespace Application\Controller;
use Application\Service\IndexServiceInterface;
use Application\Controller\BaseController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Authentication\AuthenticationService;
use Zend\Http\PhpEnvironment\Request;
use Zend\Filter;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\InputFilter\FileInput;
use Zend\Validator;
use Application\Model\Xeditable;
use Application\Config\Config;
use Application\Model\User;

 class ProfileController extends BaseController
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
          $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Thông Tin Của Tôi");
          $request = $this->getRequest();
          $usererror = array();
          $db_users = $this->databaseService->getUserById($this->identity()->id);
          foreach ($db_users as $db_user) {
         
              $user = new User($this->identity()->id, $db_user->username, NULL, NULL);
              $user->avatar = $db_user->avatar;
              $user->note = $db_user->note;
              $user->phone = $db_user->phone;
              $user->email = $db_user->email;
              $user->block = $db_user->block;
              $user->role_id = $db_user->role_id;
              $user->name = $db_user->name;
          }

          $usererror = Config::PROCESS_OK;
          return new ViewModel(array(
                  'usererror' => $usererror,
                  'user' => $user,
          ));
     }

     public function uploadImageAction() {
        $this->checkAuth();
        $request = $this->getRequest();
        if ($request->isPost()) {
            // File upload input
            $file = new FileInput('avatar');           // Special File Input type
            $file->getValidatorChain()               // Validators are run first w/ FileInput
            ->attach(new Validator\File\UploadFile());
            $file->getFilterChain()                  // Filters are run second w/ FileInput
            ->attach(new Filter\File\RenameUpload(array(
             'target'    => './public/files/users/avatar/origin/',
             'use_upload_name'=>true,
             'randomize' => true,
            )));

            // Merge $_POST and $_FILES data together
            $request  = new Request();
            $postData = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());

            $inputFilter = new InputFilter();
            $inputFilter->add($file)->setData($postData);

            if ($inputFilter->isValid()) {           // FileInput validators are run, but not the filters...

              $data = $inputFilter->getValues();   // This is when the FileInput filters are run.

              $avatar = basename($data['avatar']['tmp_name']);
              $this->databaseService->updateAvatar($this->user->id,$avatar);
              $this->user->avatar = $avatar;
             } else {
                // error
            }
        }
        return $this->redirect()->toRoute('profile');
     }

     public function changePasswordAction()
     {
         $this->checkAuth();
         $request = $this->getRequest();
         if ($request->isPost()) {
            $old_password = $this->getRequest ()->getPost('old_password', null);
            $new_password = $this->getRequest ()->getPost('new_password', null);
            $new_password1 = $this->getRequest ()->getPost('new_password1', null);
            $usererror;
            if ($new_password != $new_password1) {
                $usererror = Config::PASSWORD_DIFFERENT;
            } else if (strlen($new_password) > Config::PASSWORD_MAX_LEN) {
                $usererror = Config::PASSWORD_EXCEED_MAX_LEN;
            } else if (strlen($new_password) < Config::PASSWORD_MIN_LEN) {
                $usererror = Config::PASSWORD_BENEATH_MIN_LEN;
            }

            if (empty($usererror)) {
                $new_password_md5 = md5($new_password);
                $old_password_md5 = md5($old_password);
                $usererror = $this->databaseService->changePassword($this->user->id, $new_password_md5, $old_password_md5);
            }

            return new JsonModel(array(
                'usererror'=> $usererror,
            ));
         }
     }

     public function userInfoAction()
     {
         $this->checkLevel2();
         $id = $this->params()->fromRoute('id', 0);
         $request = $this->getRequest();
         $usererror = array();

         $db_users = $this->databaseService->getUserById($id);
         foreach ($db_users as $db_user) {
             $user = new User($id, $db_user->username, NULL, NULL);
             $user->avatar = $db_user->avatar;
             $user->note = $db_user->note;
             $user->phone = $db_user->phone;
             $user->email = $db_user->email;
             $user->block = $db_user->block;
             $user->role_id = $db_user->role_id;
             $user->name = $db_user->name;
         }
        $this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set("Thông Tin Của ".$db_user->username);

         $usererror = Config::PROCESS_OK;
         return new ViewModel(array(
                 'usererror' => $usererror,
                 'user' => $user,
         ));
     }

     public function resetPasswordAction()
     {
         $this->checkAuth();
         $request = $this->getRequest();
         if ($request->isPost()) {
             $user_id = $this->getRequest ()->getPost('user_id', null);
             $new_password = $this->getRequest ()->getPost('new_password', null);
             $new_password1 = $this->getRequest ()->getPost('new_password1', null);
             $usererror;
             if ($new_password != $new_password1) {
                 $usererror = Config::PASSWORD_DIFFERENT;
             } else if (strlen($new_password) > Config::PASSWORD_MAX_LEN) {
                 $usererror = Config::PASSWORD_EXCEED_MAX_LEN;
             }
             else if (strlen($new_password) < Config::PASSWORD_MIN_LEN) {
                 $usererror = Config::PASSWORD_BENEATH_MIN_LEN;
             }

             if (empty($usererror))
             {
                 $new_password_md5 = md5($new_password);
                 $usererror = $this->databaseService->resetPassword($user_id, $new_password_md5);
             }

             return new JsonModel(array(
                 'usererror'=> $usererror,
             ));
         }
     }

     public function changeUserInfoAction() {
         /* Only allow Admin */
         if ($this->auth->getIdentity()->role_id != Config::USER_ADMIN) {
             $result = new Xeditable();
             $result->setStatus(Xeditable::STATUS_ERROR);
             $result->setMsg(Xeditable::ROLE_ERROR);
             echo \Zend\Json\Json::encode($result, false);
             exit();
         }

         $value = $this->getRequest()->getPost('value');
         $name = $this->getRequest()->getPost('name');
         $id = $this->getRequest()->getPost('pk');
         $selected_user = new User(NULL, NULL, NULL, NULL);
         $selected_user->email = NULL;
         $selected_user->phone = NULL;
         $selected_user->note = NULL;
         $selected_user->block = NULL;
         $selected_user->name = NULL;
         if ($name == "pro-name") {
             $result = new Xeditable();
             $validator = new \Zend\Validator\NotEmpty();
             if ($validator->isValid($value)) {
                 $selected_user->name = $value;
                 $this->databaseService->changeUserInfo($id, $selected_user);
             }else{
                 $result->setStatus(Xeditable::STATUS_ERROR);
                 $result->setMsg(Xeditable::MSG_DATA_EMPTY);
             }
             echo \Zend\Json\Json::encode($result, false);
             exit;
         }

         if ($name == "pro-email") {
             $result = new Xeditable();
             $validator = new \Zend\Validator\EmailAddress();
             if ($validator->isValid($value)) {
                 $selected_user->email = $value;
                 $this->databaseService->changeUserInfo($id, $selected_user);
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
                 $selected_user->phone = $value;
                 $this->databaseService->changeUserInfo($id, $selected_user);
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
                 $selected_user->note = $value;
                 $this->databaseService->changeUserInfo($id, $selected_user);
             }else{
                 $result->setStatus(Xeditable::STATUS_ERROR);
                 $result->setMsg(Xeditable::MSG_DATA_ERROR);
             }
             echo \Zend\Json\Json::encode($result, false);
             exit;
         }

         if ($name == "block-user") {
             $result = new Xeditable();
             $validator = new \Zend\Validator\NotEmpty();
             if ($validator->isValid($value)) {
                 if ($value == "Block") {
                    $selected_user->block = 0;
                 } else if ($value == "Unblock") {
                    $selected_user->block = 1;
                 } else {
                     $selected_user->block = NULL;
                     $result->setStatus(Xeditable::STATUS_ERROR);
                     $result->setMsg(Xeditable::MSG_DATA_EMPTY);
                     echo \Zend\Json\Json::encode($result, false);
                     exit;
                 }

                 $ret = $this->databaseService->changeUserInfo($id, $selected_user);
                 if ($ret == NULL) {
                     $result->setStatus(Xeditable::STATUS_ERROR);
                     $result->setMsg(Xeditable::MSG_DATA_ERROR);
                 }
             }else{
                 $result->setStatus(Xeditable::STATUS_ERROR);
                 $result->setMsg(Xeditable::MSG_DATA_ERROR);
             }
             echo \Zend\Json\Json::encode($result, false);
             exit;
         }
        $result = new Xeditable();
        $result->setStatus(Xeditable::STATUS_ERROR);
        $result->setMsg(Xeditable::MSG_DATA_EMPTY);
        echo \Zend\Json\Json::encode($result, false);
        exit;
     }

     public function changeMyInfoAction(){
         $this->checkAuth();
         $value = $this->getRequest()->getPost('value');
         $name = $this->getRequest()->getPost('name');
         $id =  $this->auth->getIdentity()->id;
         $selected_user = new User(NULL, NULL, NULL, NULL);
         $selected_user->email = NULL;
         $selected_user->phone = NULL;
         $selected_user->note = NULL;
         $selected_user->name = NULL;
         if ($name == "pro-email") {
             $result = new Xeditable();
             $validator = new \Zend\Validator\EmailAddress();
             if ($validator->isValid($value)) {
                 $selected_user->email = $value;
                 $this->databaseService->changeUserInfo($id, $selected_user);
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
                 $selected_user->phone = $value;
                 $this->databaseService->changeUserInfo($id, $selected_user);
                 $this->user->phone = $value;
             }else{
                 $result->setStatus(Xeditable::STATUS_ERROR);
                 $result->setMsg(Xeditable::MSG_DATA_ERROR);
             }
             echo \Zend\Json\Json::encode($result, false);
             exit;
         }
         if ($name == "pro-name") {
             $result = new Xeditable();
             $validator = new \Zend\Validator\NotEmpty();
             if ($validator->isValid($value)) {
                 $selected_user->name = $value;
                 $this->databaseService->changeUserInfo($id, $selected_user);
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
                 $selected_user->note = $value;
                 $this->databaseService->changeUserInfo($id, $selected_user);
                 $this->user->note = $value;
             }else{
                 $result->setStatus(Xeditable::STATUS_ERROR);
                 $result->setMsg(Xeditable::MSG_DATA_ERROR);
             }
             echo \Zend\Json\Json::encode($result, false);
             exit;
         }
            $result = new Xeditable();
        $result->setStatus(Xeditable::STATUS_ERROR);
        $result->setMsg(Xeditable::MSG_DATA_EMPTY);
        echo \Zend\Json\Json::encode($result, false);
        exit;
     }
}