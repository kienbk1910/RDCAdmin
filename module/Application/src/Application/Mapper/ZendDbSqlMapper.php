<?php
// Filename: /module/Blog/src/Blog/Mapper/ZendDbSqlMapper.php
namespace Application\Mapper;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate\Like;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Application\Mapper\IndexMapperInterface;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\ResultSet;
use Application\Model\User;

class ZendDbSqlMapper implements IndexMapperInterface
{

    protected $dbAdapter;

    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;

    }
     public function getListRoles()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('roles');
        $selectString = $sql->getSqlStringForSqlObject($select);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
    }
     public function updateAvatar($id_user,$avatar){
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update('users');
        $update->set(array('avatar'=>$avatar));
        $update->Where(array('id = ?' => $id_user));
        $selectString = $sql->getSqlStringForSqlObject($update);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
     }

     public function addUser(User $user){
         $data = array(
             'id' => $user->getId(),
             'username' => $user->getUsername(),
             'password' => $user->getPassword(),
         );

         $sql = new Sql($this->dbAdapter);
         $insert = $sql->insert('users');
         $insert->values($data);
         $selectString = $sql->getSqlStringForSqlObject($insert);
         return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
     }
}
