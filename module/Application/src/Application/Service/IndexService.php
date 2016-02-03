<?php
namespace Application\Service;
use Application\Mapper\IndexMapperInterface;
use Application\Service\IndexServiceInterface;
use Application\Model\User;
use Application\Model\Task;
use Application\Model\Comment;
use Application\Model\MoneyHistory;
use Application\Model\FileAttachment;
use Application\Model\Log;
class IndexService implements IndexServiceInterface
{
    protected $databaseMapper;

    /**
     * @param PostMapperInterface $postMapper
     */
    public function __construct(IndexMapperInterface $databaseMapper)
    {
        $this->databaseMapper = $databaseMapper;
    }
   public function getListRoles(){
   		return $this->databaseMapper->getListRoles();
   }
   public function updateAvatar($id_user,$avatar){
   		return $this->databaseMapper->updateAvatar($id_user,$avatar);
   }

   public function addUser(User $user) {
       return $this->databaseMapper->addUser($user);
   }
   public function changeUserInfo($id_user,$user){
       return $this->databaseMapper->changeUserInfo($id_user,$user);
   }
   public function getTotalUsers(){
      return $this->databaseMapper->getTotalUsers();
   }
   public function getListUsers($start,$length,$search){
      return $this->databaseMapper->getListUsers($start,$length,$search);
   }
   public function getCountUsers($search){
     return $this->databaseMapper->getCountUsers($search);
   }
   public function changePassword($id_user, $password, $old_password) {
       return $this->databaseMapper->changePassword($id_user, $password, $old_password);
   }
   public function resetPassword($id_user, $password) {
       return $this->databaseMapper->resetPassword($id_user, $password);
   }

   public function getListByRole($role){
      return $this->databaseMapper->getListByRole($role);
   }

   public function insertTask(Task $task){
      return $this->databaseMapper->insertTask($task);
   }

   public function showLog($user_id, Task $task) {
       return $this->databaseMapper->showLog($user_id, $task);
   }

   public function insertLog($user_id, Task $task, $action) {
       return $this->databaseMapper->insertLog($user_id, $task, $action);
   }

   public function getListUserByBaseRole($role){
      return $this->databaseMapper->getListUserByBaseRole($role);
   }
  public function getInfoTask($id){
     return $this->databaseMapper->getInfoTask($id);
  }
  public function changeInfoOfTask($id,$key,$value,$id_user){
     return $this->databaseMapper->changeInfoOfTask($id,$key,$value,$id_user);
  }
  public function getListProcess(){
    return $this->databaseMapper->getListProcess();
  }
  public function insertMoneyHistory(MoneyHistory $money){
      return $this->databaseMapper->insertMoneyHistory($money);
  }
  public function getTotalPay($id,$type){
      return $this->databaseMapper->getTotalPay($id,$type);
  }
  public function getPayHistory($id,$type){
      return $this->databaseMapper->getPayHistory($id,$type);
  }
  public function getTotalTask($agency_id,$provider_id){
    return $this->databaseMapper->getTotalTask($agency_id,$provider_id);
  }
  public function getListTask($start,$length,$search,$columns,$order,$agency_id,$provider_id){
      return $this->databaseMapper->getListTask($start,$length,$search,$columns,$order,$agency_id,$provider_id);
  }
  public function getCountTasksFiltered($start,$length,$search,$columns,$order,$agency_id,$provider_id){
        return $this->databaseMapper->getCountTasksFiltered($start,$length,$search,$columns,$order,$agency_id,$provider_id);
  }
  public function getUserById($id){
      return $this->databaseMapper->getUserById($id);
  }
   public function addComment(Comment $comment){
    return $this->databaseMapper->addComment($comment);
   }
   public function getListComment($task_id,$type){
    return $this->databaseMapper->getListComment($task_id,$type);
   }
   public function deletePayById($id){
    return $this->databaseMapper->deletePayById($id);
   }
  public function addFileAttachment(FileAttachment $file){
    return $this->databaseMapper->addFileAttachment($file);
  }
  public function editPermissionFile($file_id,$permission){
      return $this->databaseMapper->editPermissionFile($file_id,$permission);
  }
  public function deleteAttachment($id){
    return $this->databaseMapper->deleteAttachment($id);
  }
  public function getListFileActtacment($task_id,$permission){
     return $this->databaseMapper->getListFileActtacment($task_id,$permission);
  }
  public function getPermissionByTaskid($id_user,$task_id){
  //  public function $this->databaseMapper->getPermissionByTaskid($id_user,$task_id);
  }
   public function getFileAttachment($id){
      return $this->databaseMapper->getFileAttachment($id);
   }
   public function modifyLog(Log $log) {
       return $this->databaseMapper->modifyLog($log);
   }
   public function getUserNameByUserID($user_id) {
       return $this->databaseMapper->getUserNameByUserID($user_id);
   }
   public function getProcessBaseID($get_base_id) {
       return $this->databaseMapper->getProcessBaseID($get_base_id);
   }
}
