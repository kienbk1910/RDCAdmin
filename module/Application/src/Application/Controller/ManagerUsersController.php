<?php
namespace Application\Controller;
 use Application\Service\IndexServiceInterface;
 use Application\Controller\BaseController;
 use Zend\View\Model\ViewModel;
 use Zend\View\Model\JsonModel;
 use Zend\Authentication\AuthenticationService;
 use Application\Model\User;
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