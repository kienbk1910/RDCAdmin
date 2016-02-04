<?php
 namespace Application\Controller;
 use Application\Config\Config;
 use Zend\Authentication\AuthenticationService;
 use Zend\Paginator\Paginator;
 use Zend\Mvc\Controller\AbstractActionController;
 abstract class BaseController extends AbstractActionController
 {
      protected $auth;
      protected $user;
      protected $databaseService;
      protected function checkAuth(){
        if(!$this->auth->hasIdentity()){
               return $this->redirect()->toRoute('auth');
        }
      }
      protected function checkAdmin(){
         $this->checkRole(Config::USER_ADMIN);
      }
      protected function checkLevel1(){
              $this->checkRole(Config::USER_LEAVE1);
      }
      protected function checkLevel2(){
        if($this->isLevel2() != true)
              $this->checkRole(Config::USER_LEAVE2);
      }
      protected function isLevel2(){
          if($this->auth->getIdentity()->role_id > Config::USER_LEAVE2){
            return false;
          }
           return true;
      }
      public function checkRole($role){
           $this->checkAuth();
          if($this->auth->getIdentity()->role_id > $role){
               exit();
          }
      }
      

}