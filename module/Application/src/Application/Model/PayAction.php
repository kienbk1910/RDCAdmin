<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;
/**
* 
*/
class PayAction 
{
	public $id;
	public $user_id;
	public $date_pay;
	public $pay_option;
	public $create_user;
	public $create_date;
	public $type;
	public $title;
	public $data;
	public $cost;

	public function toArray(){
		return array(
			'user_id'=>$this->user_id,
			'date_pay'=> $this->date_pay,
			'pay_option'=> $this->pay_option,
			'create_user'=> $this->create_user,
			'create_date'=> $this->create_date,
			'type'=> $this->type,
			'title'=> $this->title,
			'is_task'=> $this->is_task,
			'cost'=> $this->cost,
			'data'=> $this->data,
		);
	}
	public function toArrayUpdate(){
		return array(
					
		 );
	}	
}