<?php
 // Filename: /module/Blog/src/Blog/Mapper/PostMapperInterface.php
 namespace Application\Mapper;

 interface IndexMapperInterface
 {

      public function getListRoles();
 	  public function updateAvatar($id_user,$avatar);
 	  public function changeEmail($id_user,$email);
 	  public function getTotalUsers();
      public function getListUsers($start,$length,$search);
      public function changePassword($id_user, $password, $old_password);
}