<?php
 // Filename: /module/Blog/src/Blog/Service/PostServiceInterface.php
 namespace Application\Service;
 use Application\Model\User;

 interface IndexServiceInterface
 {
     public function getListRoles();
     public function updateAvatar($id_user,$avatar);
     public function addUser(User $user);
 }