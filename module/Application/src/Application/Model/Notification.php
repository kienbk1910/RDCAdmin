<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;
/**
* 
*/
class Notification 
{
	public $id;
	public $notification;
	public $user_id;
	public $date;
	public function toArray(){
		return   array(
			'notification'=>$this->notification,
			'user_id'=> $this->user_id,
			'date'=> $this->date		
		 );
	}
}