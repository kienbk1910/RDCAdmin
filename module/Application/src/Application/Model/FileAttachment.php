<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;
/**
* 
*/
class FileAttachment 
{
	public $id;
	public $task_id;
	public $file_name;
	public $real_name;
	public $permission_option;
	public $user_create;
	public $date_create;
	public $last_user;
	public $last_date;
	public function toArray(){
		return   array(
			'task_id'=>$this->task_id,
			'file_name'=> $this->file_name,
			'real_name'=> $this->real_name,
			'permission_option'=> $this->permission_option,
			'user_create'=> $this->user_create,
			'date_create'=> $this->date_create,
			'last_user'=> $this->last_user,
			'last_date'=> $this->last_date,		
		 );
	}
}