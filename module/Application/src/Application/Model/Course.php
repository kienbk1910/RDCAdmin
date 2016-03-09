<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;
/**
* 
*/
class Course 
{
	public $id;
	public $certificate_id;
	public $month;
	public $year;
	public $start;
	public $end;
	public $finish;
	public $create_date;
	public $create_id;
	public $edit_date;
	public $edit_id;
	public function toArray(){
		return   array(
			'certificate_id'=>$this->certificate_id,
			'month'=>$this->month,
			'year'=>$this->year,
			'start'=>$this->start,
			'end'=>$this->end,
			'finish'=>$this->finish,
			'create_date'=>$this->create_date,
			'create_id'=>$this->create_id,
			'edit_date'=>$this->edit_date,
			'edit_id'=>$this->edit_id,		
		 );
	}
}