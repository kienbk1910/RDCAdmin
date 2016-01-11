<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;
/**
* 
*/
class MoneyHistory 
{
	public $id;
	public $task_id;
	public $user_id;
	public $money;
	public $date_pay;
	public $create_date;
	public $money_option;
	public $last_user_id;
	public $last_update;
	public $note;
	public $type;
	public function toArray(){
		return   array(
			'task_id'=>$this->task_id,
			'money'=> $this->money,
			'date_pay'=> $this->date_pay,
			'money_option'=> $this->money_option,
			'note'=> $this->note,
			'type'=> $this->type,

			'user_id'=> $this->user_id,
			'create_date'=> $this->create_date,
			'last_update'=> $this->last_update,
			'last_user_id'=> $this->last_user_id,		
		 );
	}	
}