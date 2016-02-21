<?php
namespace Application\Service;
use Application\Mapper\IndexMapperInterface;
use Application\Service\IndexServiceInterface;
use Application\Model\User;
use Application\Model\Certificate;
use Application\Model\Task;
use Application\Model\Comment;
use Application\Model\MoneyHistory;
use Application\Model\FileAttachment;
use Application\Model\Log;
use Application\Model\Notification;
use Application\Model\PayAction;
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
   
   public function addCertificate(Certificate $certificate){
       return $this->databaseMapper->addCertificate($certificate);
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

   public function insertLog($user_id, Task $task,$type) {
       return $this->databaseMapper->insertLog($user_id, $task,$type);
   }
   
   public function payLog($user_id, MoneyHistory $money,$type) {
       return $this->databaseMapper->payLog($user_id, $money,$type);
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
   public function modifyLog(Log $log,$type) {
       return $this->databaseMapper->modifyLog($log,$type);
   }
   public function getUserNameByUserID($user_id) {
       return $this->databaseMapper->getUserNameByUserID($user_id);
   }
   public function getProcessBaseID($get_base_id) {
       return $this->databaseMapper->getProcessBaseID($get_base_id);
   }
    public function getPermissionUser($task_id,$user_id){
       return $this->databaseMapper->getPermissionUser($task_id,$user_id);      
    }
  public function getPayById($id){
       return $this->databaseMapper->getPayById($id);      
  }

  public function deletePayLog($user_id, MoneyHistory $money,$type){
        return $this->databaseMapper->deletePayLog($user_id ,  $money, $type);
  }
  public function modifyPayLog($user_id, MoneyHistory $old,MoneyHistory $new,$type){  
    return $this->databaseMapper->modifyPayLog($user_id ,  $old ,  $new,$type);
  }
  public function addFileLog($user_id,FileAttachment $file,$type){
    return $this->databaseMapper->addFileLog($user_id, $file,$type);
  }
  public function changeFileLog($user_id,FileAttachment $old,FileAttachment $value,$type){

  }
  public function deleteFileLog($user_id,FileAttachment $file,$type){
    return $this->databaseMapper->deleteFileLog($user_id, $file,$type);
  }
  public function addCommentLog($user_id,Comment $comment,$type){
       return $this->databaseMapper->addCommentLog($user_id, $comment,$type);
  }
  public function addNotification(Notification $notification){
    return $this->databaseMapper->addNotification($notification);
  }
  public function deteteNotification($id){
    return $this->databaseMapper->deteteNotification($id);
  }
  public function getNotifications($limit){
    return $this->databaseMapper->getNotifications($limit);
  }
  public function getReportTasks($id_user){
    return $this->databaseMapper->getReportTasks($id_user); 
  }
   public function getTotalAgency(){
    return $this->databaseMapper->getTotalAgency(); 
   }
  public function getTotalCurrentMoney($type){
    return $this->databaseMapper->getTotalCurrentMoney($type); 
  }
  public function getTotalAgencyById($id_user,$type){
    return $this->databaseMapper->getTotalAgencyById($id_user,$type); 
  }
  public function getTotalCurrentMoneyById($id_user,$type){
    return $this->databaseMapper->getTotalCurrentMoneyById($id_user,$type); 
  }
  public function getTaskListForPay($type,$user_id,$task_list){
    return $this->databaseMapper->getTaskListForPay($type,$user_id,$task_list);
  }
  public function addPayAction(PayAction $pay){
      return $this->databaseMapper->addPayAction($pay);

  }
  public function getPayActionById($id){
    return $this->databaseMapper->getPayActionById($id);   
  }
   public function getPayActionDetail($id){
    return $this->databaseMapper->getPayActionDetail($id);  
   }
  public function getTotalPayAction($user_id){
    return $this->databaseMapper->getTotalPayAction($user_id); 
  }
  public function getListPay($start,$length,$search,$columns,$orders,$user_id){
    return $this->databaseMapper->getListPay($start,$length,$search,$columns,$orders,$user_id); 
  }
  public function getListPayFiltered($start,$length,$search,$columns,$orders,$user_id){
    return $this->databaseMapper->getListPayFiltered($start,$length,$search,$columns,$orders,$user_id); 
  }
  public function getMoneyPayAction($id){
     return $this->databaseMapper->getMoneyPayAction($id); 
  }
  public function getListMoneyHistoryByPayId($id){
      return $this->databaseMapper->getListMoneyHistoryByPayId($id); 
  }
  public function deletePayAction($id){
    return $this->databaseMapper->deletePayAction($id); 
  }
  public function deleteMoneyHistoryByPayId($id){
    return $this->databaseMapper->deleteMoneyHistoryByPayId($id); 
  }
}
