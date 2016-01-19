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
use Application\Config\Config;
use Application\Model\Task;
use Application\Model\MoneyHistory;
use Application\Utility\DataTableUtility;
use Utility\Date\Date;
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

     public function changeUserInfo($id_user,$user){
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update('users');
        /* Validate filed */
        if ($user->email != NULL) {
            $update->set(array('email' => $user->email));
        } else if ($user->phone != NULL) {
            $update->set(array('phone' => $user->phone));
        } else if ($user->note != NULL) {
            $update->set(array('note' => $user->note));
        }

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
        $select = $sql->select('users')->Where(array(
                        'id = ? ' => $id_user,
                        'password = ?' => $old_password,
                        ));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $str_ret = Config::PROCESS_OK;
        try {
            $ret = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
            if ($ret->count() == 1) {
                $update = $sql->update('users');
                $update->set(array('password' => $new_password));
                $string = " id = ". $id_user. " AND password = \"" .$old_password. "\" LIMIT 1";
                $update->Where($string);
                $selectString = $sql->getSqlStringForSqlObject($update);

                try {
                    $ret = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
                    if ($ret->count() == 1) {
                        $str_ret = Config::PROCESS_OK;
                    } else {
                        $str_ret =  Config::PASSWORD_IS_THE_SAME;
                    }
                } catch (\Exception $e) {
                    $str_ret = Config::PROCESS_NG;
                }
            } else {
                /* Password is not map */
                $str_ret = Config::PASSWORD_IS_WRONG;
            }
        } catch (Exception $e) {
            $str_ret =  Config::PROCESS_NG;
        }

        return $str_ret;
    }

    public function resetPassword($id_user, $password) {
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update('users');
        $update->set(array('password' => $password));
        $update->Where(array('id = ?' => $id_user));
        $selectString = $sql->getSqlStringForSqlObject($update);
        try {
            $ret = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
            if ($ret->count() == 1) {
                $str_ret = Config::PROCESS_OK;
            } else {
                $str_ret =  Config::PASSWORD_IS_THE_SAME;
            }
        } catch (\Exception $e) {
            $str_ret = Config::PROCESS_NG;
        }
        return $str_ret;
    }

    public function getListByRole($role){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('users');
        $select->Where(array('users.role_id = ?' => $role));
        $selectString = $sql->getSqlStringForSqlObject($select);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
    }

     public function insertTask(Task $task){
        $sql = new Sql($this->dbAdapter);
        $insert = $sql->insert('tasks');
        $newData = $task->toArray();
        $insert->values($newData);
        $selectString = $sql->getSqlStringForSqlObject($insert);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
     }

     public function getListUserByBaseRole($role){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('users');
        $select->Where(array('users.role_id < ?' => $role));
        $selectString = $sql->getSqlStringForSqlObject($select);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
     }

     public function getInfoTask($id){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tasks');
        $select->Where(array('tasks.id = ?' => $id));
        $selectString = $sql->getSqlStringForSqlObject($select);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
     }

     public function changeInfoOfTask($id,$key,$value,$id_user){
        $sql = new Sql($this->dbAdapter);
        $update = $sql->update('tasks');
        $update->set(array($key=>$value,'last_user_id' =>$id_user,'last_update'=>date('Y-m-d H:i:s')));
        $update->Where(array('id = ?' => $id));
        $selectString = $sql->getSqlStringForSqlObject($update);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
     }

     public function getListProcess(){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('process');
        $selectString = $sql->getSqlStringForSqlObject($select);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
     }

    public function insertMoneyHistory(MoneyHistory $money){
        $sql = new Sql($this->dbAdapter);
        $insert = $sql->insert('money_history');
        $newData = $money->toArray();
        $insert->values($newData);
        $selectString = $sql->getSqlStringForSqlObject($insert);
        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
    }

    public function getTotalPay($id,$type){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('money_history');
        $select->Where(array('money_history.task_id = ?' => $id,
            'money_history.type = ?' => $type,
            ));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $result = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $total = 0;
        foreach ($result as $item) {
            $total += $item->money;
        }
        return $total;
    }

     public function getPayHistory($id,$type){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('money_history');
         $select->join('users', 'money_history.user_id = users.id', array('username'=>'username'), 'left')
                ->join('money_option', 'money_history.money_option = money_option.id', array('name'=>'name'), 'left');
        $select->Where(array('money_history.task_id = ?' => $id,
            'money_history.type = ?' => $type,
            ));
        $selectString = $sql->getSqlStringForSqlObject($select);
        return $result = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
     }

      public function getTotalTask(){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tasks')
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
      public function getListTask($start,$length,$search,$columns,$order,$agency_id,$provider_id){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('tasks');
        $select->join('process', 'tasks.process_id = process.id', array('process_name'=>'name'), 'left');
        $select->join('users', 'tasks.agency_id = users.id', array('agency_name'=>'username'), 'left');
        $select->join(array('2users' => 'users'), 'tasks.provider_id = 2users.id', array('provider_name'=>'username'), 'left');
        $select->where->like('tasks.custumer', '%' . $search .'%');
        $agency_seach = DataTableUtility::getSearchValue($columns,"agency_name");
        if($agency_id != null){
            $select->Where(array('users.id' => $agency_id));
        }
        if($provider_id != null){
            $select->Where(array('2users.id' => $provider_id));
        }
        if($agency_seach != "" && $agency_seach != 0){
           $select->Where(array('users.id' => $agency_seach));
        }
        $provider_seach = DataTableUtility::getSearchValue($columns,"provider_name");
        if($provider_seach != "" && $provider_seach != 0){
           $select->Where(array('2users.id' => $provider_seach));
        }

        $process_seach = DataTableUtility::getSearchValue($columns,"process_name");
        if($process_seach != "" && $process_seach != 0){
           $select->Where(array('process.id' => $process_seach));
        }

        $date_open = DataTableUtility::getSearchValue($columns,"date_open");
        $date_open = explode("-", $date_open);
        $date_open_1 ="";
        $date_open_2 ="";
        if( count($date_open) == 2){
            $date_open_1 =$date_open[0];
            $date_open_2 =$date_open[1];
        }
        if ($date_open_1 != "" && $date_open_2 != "") {
            $select->where->lessThanOrEqualTo("tasks.date_open", Date::changeVNtoDateSQL($date_open_2))
                ->and->greaterThanOrEqualTo("tasks.date_open", Date::changeVNtoDateSQL($date_open_1));
        } elseif ($date_open_1 == "" && $date_open_2 != "") {
            $select->where->lessThanOrEqualTo("tasks.date_open", Date::changeVNtoDateSQL($date_open_2));
        } else if ($date_open_1 != "" && $date_open_2 == "") {
             $select->where->greaterThanOrEqualTo("tasks.date_open", Date::changeVNtoDateSQL($date_open_1));
        }

        $date_end = DataTableUtility::getSearchValue($columns,"date_end");
        $date_end = explode("-", $date_end);
        $date_end_1 ="";
        $date_end_2 ="";
        if( count($date_end) == 2){
            $date_end_1 =$date_end[0];
            $date_end_2 =$date_end[1];
        }
        if ($date_end_1 != "" && $date_end_2 != "") {
            $select->where->lessThanOrEqualTo("tasks.date_end", Date::changeVNtoDateSQL($date_end_2))
                ->and->greaterThanOrEqualTo("tasks.date_end", Date::changeVNtoDateSQL($date_end_1));
        } elseif ($date_end_1 == "" && $date_end_2 != "") {
            $select->where->lessThanOrEqualTo("tasks.date_end", Date::changeVNtoDateSQL($date_end_2));
        } else if ($date_end_1 != "" && $date_end_2 == "") {
             $select->where->greaterThanOrEqualTo("tasks.date_end", Date::changeVNtoDateSQL($date_end_1));
        }

        $select->order(array('tasks.last_update DESC'));
        $select->offset($start)
                ->limit($length);
        $selectString = $sql->getSqlStringForSqlObject($select);

        return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
      }

      public function getUserById($id)
      {
          $sql = new Sql($this->dbAdapter);
          $select = $sql->select('users')->join('roles', 'roles.id = users.role_id', array(
                            'role_name' => 'name'), 'left');
          $select->Where(array('users.id = ?' => $id));
          $selectString = $sql->getSqlStringForSqlObject($select);
          return $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
      }
 }
