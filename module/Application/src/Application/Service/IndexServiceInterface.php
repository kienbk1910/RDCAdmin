<?php
// Filename: /module/Blog/src/Blog/Service/PostServiceInterface.php
namespace Application\Service;
use Application\Model\User;
use Application\Model\Certificate;
use Application\Model\ManagerCertificate;
use Application\Model\Task;
use Application\Model\Comment;
use Application\Model\MoneyHistory;
use Application\Model\FileAttachment;
use Application\Model\Log;
use Application\Model\Notification;
use Application\Model\PayAction;
use Application\Model\Course;
use Application\Model\Student;
interface IndexServiceInterface
{
     public function getListRoles();
     public function updateAvatar($id_user,$avatar);
     public function addUser(User $user);
     public function changeUserInfo($id_user,$user);
     public function getTotalUsers();
     public function getListUsers($start,$length,$search);
     public function getCountUsers($search);
     
     public function addCertificate(Certificate $certificate);
     public function updateCertificate(Certificate $certificate);
     
     public function addDetailCertificate(ManagerCertificate $certificate);
     public function updateDetailCertificate(ManagerCertificate $certificate);
     
     public function getListCertificates();
     public function getCertificateByID($id);
     public function getTotalCertificates();
     public function getListCertificatesAll($start,$length,$search);
     public function getCountCertificates($search);
     
     public function getTotalManagerCertificates();
     public function getManagerCertificateByID($id);
     public function getListManagerCertificatesAll($start,$length,$search);
     public function getCountManagerCertificates($search);
     
     public function changePassword($id_user, $password, $old_password);
     public function resetPassword($id_user, $password);
     public function getListByRole($role);
     public function insertTask(Task $task);

     public function showLog($user_id, Task $task);
     public function insertLog($user_id, Task $task,$type);
     public function payLog($user_id, MoneyHistory $money,$type);
     public function getListUserByBaseRole($role);
     public function getInfoTask($id);

     public function changeInfoOfTask($id,$key,$value,$id_user);
     public function getListProcess();
     public function insertMoneyHistory(MoneyHistory $money);
     public function getTotalPay($id,$type);
     public function getPayHistory($id,$type);
     public function deletePayById($id);

     public function getTotalTask($agency_id,$provider_id);
     public function getListTask($start,$length,$search,$columns,$order,$agency_id,$provider_id);
     public function getCountTasksFiltered($start,$length,$search,$columns,$order,$agency_id,$provider_id);
     public function getUserById($id);

     public function addComment(Comment $comment);
     public function getListComment($task_id,$type);

     public function addFileAttachment(FileAttachment $file);
     public function editPermissionFile($file_id,$permission);
     public function deleteAttachment($id);
     public function getListFileActtacment($task_id,$permission);
     public function getPermissionByTaskid($id_user,$task_id);
     public function getFileAttachment($id);
     public function modifyLog(Log $log,$type);
     public function getUserNameByUserID($user_id);
     public function getProcessBaseID($get_base_id);
     public function getPermissionUser($task_id,$user_id);

     public function getPayById($id);
     public function modifyPayLog($user_id, MoneyHistory $old,MoneyHistory $new,$type);
     public function deletePayLog($user_id, MoneyHistory $money,$type);
     public function addFileLog($user_id,FileAttachment $file,$type);
     public function changeFileLog($user_id,FileAttachment $old,FileAttachment $value,$type);
     public function deleteFileLog($user_id,FileAttachment $file,$type);
     public function addCommentLog($user_id,Comment $comment,$type);

     public function addNotification(Notification $notification);
     public function deteteNotification($id);
     public function getNotifications($limit);

     public function getReportTasks($id_user);
     public function getTotalAgency();
     public function getTotalCurrentMoney($type);

     public function getTotalAgencyById($id_user,$type);
     public function getTotalCurrentMoneyById($id_user,$type);

     public function getTaskListForPay($type,$user_id,$task_list);

     public function addPayAction(PayAction $pay);
     public function getPayActionById($id);
     public function getPayActionDetail($id);

     public function getTotalPayAction($user_id);
     public function getListPay($start,$length,$search,$columns,$orders,$user_id);
     public function getListPayFiltered($start,$length,$search,$columns,$orders,$user_id);

     public function getMoneyPayAction($id);

     public function getListMoneyHistoryByPayId($id);
     public function deletePayAction($id);
     public function deleteMoneyHistoryByPayId($id);

     public function getTotalNumberAgency();
     public function getListAgency($start,$length,$search);
     public function getListAgencyFiltered($start,$length,$search);

     public function addCourse(Course $course);
     public function getCourseById($id);

     public function getTotalCourse($id);
     public function getListCourse($start,$length,$search,$columns,$order,$id);
     public function getCountCourseFiltered($start,$length,$search,$columns,$order,$id);

     public function addStudent(Student $Student);
     public function deleteStudent($id);
     public function getTotalStudent($id);
     public function getListStudent($start,$length,$search,$columns,$order,$id);
     public function getCountStudentFiltered($start,$length,$search,$columns,$order,$id);
  
 }