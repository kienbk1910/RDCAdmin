<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;

class Xeditable
{
    const STATUS_ERROR = "error";
    const MSG_DATA_ERROR = "hông đúng định dạng";
    const ROLE_ERROR = "Không có quyền admin";
    const MSG_DATA_EMPTY = "Dữ liệu rỗng";
    const MSG_DATA_NOT_NUMBER = "Dữ liệu không phải là số";
    const MSG_DATA_NOT_EMAIL = "Không thể send email";
    /**
     *
     * @var string
     */
    public $status;

    /**
     *
     * @var string
     */
    public $msg;


    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;
    }
    public function getMsg()
    {
        return $this->msg;
    }
}