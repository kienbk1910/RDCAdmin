<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;

class Xeditable
{
    const STATUS_ERROR = "error";
    const MSG_DATA_ERROR = "không đúng định dạng";
    const MSG_DATA_EMPTY = "Dữ liệu rỗng";
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