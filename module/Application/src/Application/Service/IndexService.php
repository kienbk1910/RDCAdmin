<?php
namespace Application\Service;
use Application\Mapper\IndexMapperInterface;
use Application\Service\IndexServiceInterface;
use Application\Model\User;
use Application\Model\Task;
use Application\Model\MoneyHistory;
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
   public function changeEmail($id_user,$email){
       return $this->databaseMapper->changeEmail($id_user,$email);
   }
   public function getTotalUsers(){
      return $this->databaseMapper->getTotalUsers();
   }
   public function getListUsers($start,$length,$search){
      return $this->databaseMapper->getListUsers($start,$length,$search);
   }
   public function changePassword($id_user, $password, $old_password) {
       return $this->databaseMapper->changePassword($id_user, $password, $old_password);
   }
    public function getListByRole($role){
      return $this->databaseMapper->getListByRole($role);
  }
   public function insertTask(Task $task){
      return $this->databaseMapper->insertTask($task);
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
}
