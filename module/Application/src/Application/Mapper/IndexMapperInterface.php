<?php
 // Filename: /module/Blog/src/Blog/Mapper/PostMapperInterface.php
 namespace Application\Mapper;
 use Application\Model\Task;
 use Application\Model\MoneyHistory;
 interface IndexMapperInterface
 {

      public function getListRoles();
 	  public function updateAvatar($id_user,$avatar);
 	  public function changeEmail($id_user,$email);
 	  public function getTotalUsers();
      public function getListUsers($start,$length,$search);
      public function changePassword($id_user, $password, $old_password);
      public function getListByRole($role);
      public function insertTask(Task $task);
      public function getListUserByBaseRole($role);

      public function getInfoTask($id);
      public function changeInfoOfTask($id,$key,$value,$id_user);
      public function insertMoneyHistory(MoneyHistory $money);
      public function getTotalPay($id,$type);
}