<?php
 // Filename: /module/Blog/src/Blog/Mapper/PostMapperInterface.php
 namespace Application\Mapper;
 
 interface IndexMapperInterface
 {
     
      public function getListRoles();
 	  public function updateAvatar($id_user,$avatar);
 	  public function changeEmail($id_user,$email);
}