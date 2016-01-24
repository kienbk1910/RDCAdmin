<?php
 // Filename: /module/Blog/src/Blog/Mapper/PostMapperInterface.php
 namespace Application\Mapper;
 use Application\Model\Task;
 use Application\Model\Comment;
 use Application\Model\MoneyHistory;
 use Application\Model\FileAttachment;
 interface IndexMapperInterface
 {

      public function getListRoles();
      public function updateAvatar($id_user,$avatar);
      public function changeUserInfo($id_user,$email);
      public function getTotalUsers();
      public function getListUsers($start,$length,$search);
      public function getCountUsers($search);
      public function changePassword($id_user, $password, $old_password);
      public function resetPassword($id_user, $password);
      public function getListByRole($role);
      public function insertTask(Task $task);
      public function getListUserByBaseRole($role);

      public function getInfoTask($id);
      public function changeInfoOfTask($id,$key,$value,$id_user);
      public function insertMoneyHistory(MoneyHistory $money);
      public function getTotalPay($id,$type);
      public function getPayHistory($id,$type);
      public function getTotalTask();
      public function getListTask($start,$length,$search,$columns,$order,$agency_id,$provider_id);
      public function getCountTasksFiltered($start,$length,$search,$columns,$order,$agency_id,$provider_id);
      public function getUserById($id);
      public function deletePayById($id);
      public function addComment(Comment $comment);
      public function getListComment($task_id,$type);
      public function addFileAttachment(FileAttachment $file);
}