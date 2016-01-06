<?php
 // Filename: /module/Blog/src/Blog/Service/PostServiceInterface.php
 namespace Application\Service;
 use Application\Model\User;

 interface IndexServiceInterface
 {
     public function getListRoles();
     public function updateAvatar($id_user,$avatar);
     public function addUser(User $user);
     public function changeEmail($id_user,$email);
     public function getTotalUsers();
     public function getListUsers($start,$length,$search);
     public function changePassword($id_user, $password, $old_password);
 }