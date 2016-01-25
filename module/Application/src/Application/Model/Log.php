<?php
namespace Application\Model;

class Log
{
	public $id;
	public $user_id;
	public $task_id;
	public $value;
	public $date;

	public $custumer;
	public $certificate;

	public $agency_id;
	public $cost_sell;
	public $date_open;
	public $date_end;
	public $agency_note;

	public $provider_id;
	public $cost_buy;
	public $date_open_pr;
	public $date_end_pr;
	public $provider_note;

	//public $user_id;
	public $create_date;
	public $last_user_id;
	public $last_update;
	public $process_id;
	public $reporter_id;
	public $assign_id;

	public function toArray(){
		return   array(
			'custumer'=>$this->custumer,
			'certificate'=> $this->certificate,

			'agency_id'=> $this->agency_id,
			'date_open'=> $this->date_open,
			'date_end'=> $this->date_end,
			'cost_sell'=> $this->cost_sell,
			'agency_note'=> $this->agency_note,

			'provider_id'=> $this->provider_id,
			'cost_buy'=> $this->cost_buy,
			'date_open_pr'=> $this->date_open_pr,
			'date_end_pr'=> $this->date_end_pr,
			'provider_note'=> $this->provider_note,

			'user_id'=> $this->user_id,
			'create_date'=> $this->create_date,
			'last_update'=> $this->last_update,
			'last_user_id'=> $this->last_user_id,
			'process_id'=> $this->process_id,
			'reporter_id'=> $this->reporter_id,
			'assign_id'=> $this->assign_id,
		 );
	}
}