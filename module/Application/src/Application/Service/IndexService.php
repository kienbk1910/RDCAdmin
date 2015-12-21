<?php
namespace Application\Service;
use Application\Mapper\IndexMapperInterface;
use Application\Service\IndexServiceInterface;
use Application\Model\User;

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
}
