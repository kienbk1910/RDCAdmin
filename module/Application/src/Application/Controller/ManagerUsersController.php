<?php
namespace Application\Controller;
 use Application\Service\IndexServiceInterface;
 use Application\Controller\BaseController;
 use Zend\View\Model\ViewModel;
 use Zend\View\Model\JsonModel;
 use Zend\Authentication\AuthenticationService;
 use Application\Model\User;
 use Application\Model\UserListItem;
 use Application\Model\DataTablesObject;
 use Zend\Debug\Debug;
use Application\Config\Config;

 class ManagerUsersController extends BaseController
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
        return new ViewModel();
     }

     public function getlistAction(){
         $this->checkAuth();
         $request = $this->getRequest();

         $draw = $request->getPost('draw',1);
         $start = $request->getPost('start',0);
         $length = $request->getPost('length',10);
         $search = $request->getPost('search','');
         $search = $search['value'];
         $total = $this->databaseService->getTotalUsers();

         $users = $this->databaseService->getListUsers($start,$length,$search);
         $data = new DataTablesObject();
         $data->recordsTotal = $total;
         $data->recordsFiltered = $this->databaseService->getCountUsers($search);
         $data->draw = $draw;
         foreach ($users as $user) {
             array_push($data->data,new UserListItem($user->id,$user->username,$user->role_name,$user->block));
         }
        echo \Zend\Json\Json::encode($data, false);
        exit;
     }

     public function addAction()
     {
        $this->checkAuth();

        $request = $this->getRequest();
        $roles = $this->databaseService->getListRoles();

        if ($request->isPost()) {
            $id = $this->getRequest()->getPost('id', null);
            $username = $this->getRequest ()->getPost('username', null);
            $role_id = $this->getRequest ()->getPost('role', null);
            $tmp_pass = $this->getRequest ()->getPost('password', null);
            $tmp_pass1 = $this->getRequest ()->getPost('password1', null);

            $usererror = array();
            if ($tmp_pass != $tmp_pass1) {
                $usererror['password1'] = Config::PASSWORD_DIFFERENT;
            }
            else if (strlen($tmp_pass) > Config::PASSWORD_MAX_LEN) {
                $usererror['password'] = Config::PASSWORD_EXCEED_MAX_LEN;
            }
            else if (strlen($tmp_pass) < Config::PASSWORD_MIN_LEN) {
                $usererror['password'] = Config::PASSWORD_BENEATH_MIN_LEN;
            }
            else if (strlen($username) > Config::USERNAME_MAX_LEN) {
                $usererror['username'] = Config::USERNAME_EXCEED_MAX_LEN;
            }
            else if (strlen($username) < Config::USERNAME_MIN_LEN) {
                $usererror['username'] = Config::USERNAME_BENEATH_MIN_LEN;
            }

            $password = md5($tmp_pass);
            $user = new User($id, $username, $password, $role_id);
            if (empty($usererror)) {
                $ret = $this->databaseService->addUser($user);
                if ($ret == NULL) {
                    $usererror['username'] = Config::USER_EXIST;
                } else {
                    return $this->redirect()->toRoute('manager-users');
                }
            }

            return new ViewModel(array(
                'usererror' => $usererror,
                'user' => $user,
                'roles' => $roles,
            ));
        }

        return new ViewModel(array(
            'roles' => $roles
        ));
     }
}