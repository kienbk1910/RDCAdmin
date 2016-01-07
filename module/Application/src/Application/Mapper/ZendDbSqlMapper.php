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
             'role_id' => $user->getRoleId(),
             'create_date'=> date("Y-m-d H:i:s"),
         );

         $sql = new Sql($this->dbAdapter);
         $insert = $sql->insert('users');
         $insert->values($data);
         $selectString = $sql->getSqlStringForSqlObject($insert);
         $ret;
         try {
             $ret = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
         } catch (\Exception $e) {
             $ret = NULL;
         }
         return $ret;
     }

     public function changeEmail($id_user,$email){
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update('users');
        $update->set(array('email'=>$email));
        $update->Where(array('id = ?' => $id_user));
        $selectString = $sql->getSqlStringForSqlObject($update);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
     }
     public function getTotalUsers(){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('users')
                ->columns(array('COUNT'=>new \Zend\Db\Sql\Expression('COUNT(*)')));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $resultSet =  $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $count = 0;
        foreach ($resultSet as $row) {
            $count = $row->COUNT;
            break;
        }
        return $count;
     }
    public function getListUsers($start,$length,$search){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('users')
                    ->join('roles', 'roles.id = users.role_id', array(
                            'role_name' => 'name'), 'left');
        $select->where->like('users.username', '%' . $search .'%');
        $select->offset($start)
                ->limit($length);
        $selectString = $sql->getSqlStringForSqlObject($select);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
    }

    /* change password */
    public function changePassword($id_user, $new_password, $old_password) {
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update('users');
        $update->set(array('password' => $new_password));
        $string = " id = ". $id_user. " AND password = \"" .$old_password. "\" LIMIT 1";
        $update->Where($string);
        $selectString = $sql->getSqlStringForSqlObject($update);
        $ret;
        try {
            $ret = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
            if ($ret->count() == 1) {
                return $ret;
            } else {
                return NULL;
            }
        } catch (\Exception $e) {
            return NULL;
        }
    }
    public function getListByRole($role){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('users');
        $select->Where(array('users.role_id = ?' => $role));
        $selectString = $sql->getSqlStringForSqlObject($select);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
    }
}
