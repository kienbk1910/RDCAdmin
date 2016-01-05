<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;

class UserListItem
{
  
    public $DT_RowId;
    public $username;
    public $role;
    public $status;
    public function __construct($DT_RowId, $username, $role,$status)
    {
        $this->DT_RowId = $DT_RowId;
        $this->username = $username;
        $this->role = $role;
        $this->status = $status;
    }
}