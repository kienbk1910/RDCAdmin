<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;

class UserListItem
{
    public $DT_RowId;
    public $username;
    public $role;
    public $status;
    public $create_date;
    public function __construct($DT_RowId, $username, $role, $status, $create_date)
    {
        $this->DT_RowId = $DT_RowId;
        $this->username = $username;
        $this->role = $role;
        $this->status = $status;
        $this->create_date = $create_date;
    }
}