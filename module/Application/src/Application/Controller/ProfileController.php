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
          $request = $this->getRequest();
          $usererror = array();
           $db_users = $this->databaseService->getUserById($this->identity()->id);
           $role_name;
           foreach ($db_users as $db_user) {
               $user = new User($this->identity()->id, $db_user->username, NULL, NULL);
               $user->avatar = $db_user->avatar;
               $user->note = $db_user->note;
               $user->phone = $db_user->phone;
               $user->email = $db_user->email;
               $role_name = $db_user->role_name;
           }
           $usererror = Config::PROCESS_OK;
           return new ViewModel(array(
                   'usererror' => $usererror,
                   'user' => $user,
                   'role_name' => $role_name,
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
         if ($request->isPost()) {
         }
         $db_users = $this->databaseService->getUserById($id);
         $role_name;
         foreach ($db_users as $db_user) {
             $user = new User($id, $db_user->username, NULL, NULL);
             $user->avatar = $db_user->avatar;
             $user->note = $db_user->note;
             $user->phone = $db_user->phone;
             $user->email = $db_user->email;
             $role_name = $db_user->role_name;
         }
         $usererror = Config::PROCESS_OK;
         return new ViewModel(array(
                 'usererror' => $usererror,
                 'user' => $user,
                 'role_name' => $role_name,
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

     public function changeUserInfoAction(){
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
                 $this->databaseService->changeUserInfo($id, $user);
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
     }
}