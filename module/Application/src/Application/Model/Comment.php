<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;
/**
* 
*/
class Comment 
{
	public $id;
	public $comment;
	public $user_id;
	public $create_date;
	public $task_id;
	public $is_read;
	public $type;

	public function toArray(){
		return   array(
			'comment'=>$this->comment,
			'user_id'=> $this->user_id,

			'create_date'=> $this->create_date,
			'task_id'=> $this->task_id,
			'is_read'=> $this->is_read,
			'type'=> $this->type		
		 );
	}
}