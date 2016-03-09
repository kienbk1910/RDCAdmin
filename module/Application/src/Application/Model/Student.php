<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;
/**
* 
*/
class Student 
{
	public $id;
	public $course_id;
	public $name;
	public $address;
	public $card_id;
	public $course_name;
	public $code;
	public $birth_of_date;
	public $create_date;
	public $create_id;
	public $edit_date;
	public $edit_id;
	public function toArray(){
		return   array(
			'course_id'=>$this->course_id,
			'name'=>$this->name,
			'address'=>$this->address,
			'card_id'=>$this->card_id,
			'course_name'=>$this->course_name,
			'code'=>$this->code,
			'birth_of_date'=>$this->birth_of_date,
			'create_date'=>$this->create_date,
			'create_id'=>$this->create_id,
			'edit_date'=>$this->edit_date,
			'edit_id'=>$this->edit_id,		
		 );
	}
}