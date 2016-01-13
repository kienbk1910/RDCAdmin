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
        if ($request->isPost()) {
            // save image

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
            $inputFilter->add($file)
                ->setData($postData);

            if ($inputFilter->isValid()) {           // FileInput validators are run, but not the filters...

              $data = $inputFilter->getValues();   // This is when the FileInput filters are run.

              $avatar = basename($data['avatar']['tmp_name']);
              $this->databaseService->updateAvatar($this->user->id,$avatar);
               $this->user->avatar = $avatar;
             } else {
                // error
            }
        }
        return new ViewModel();
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
            }
            else if (strlen($new_password) < Config::PASSWORD_MIN_LEN) {
                $usererror = Config::PASSWORD_BENEATH_MIN_LEN;
            }

            if (empty($usererror))
            {
                $new_password_md5 = md5($new_password);
                $old_password_md5 = md5($old_password);
                $usererror = $this->databaseService->changePassword($this->user->id, $new_password_md5, $old_password_md5);
            }

            return new JsonModel(array(
                'usererror'=> $usererror,
            ));
         }
     }
}