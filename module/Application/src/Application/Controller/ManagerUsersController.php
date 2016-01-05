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

 class ManagerUsersController extends BaseController
 {
      protected $databaseService;

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
         $total = $this->databaseService->getTotalUsers();
         
         $users =$this->databaseService->getListUsers($start,$length,"");
         $data = new DataTablesObject();
         $data->recordsTotal = $total;
         $data->recordsFiltered = $total;
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
            $tmp_pass = $this->getRequest ()->getPost('password', null);
            $password = md5($tmp_pass);
            $user = new User($id, $username, $password);

            $user = $this->databaseService->addUser($user);
            return new ViewModel(array(
                'roles' => $roles,
                'user' => $user,
            ));
        }

        return new ViewModel(array(
            'roles' => $roles
        ));
     }

}