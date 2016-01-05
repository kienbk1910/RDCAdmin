<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;

class DataTablesObject
{
  
  	public $draw;

    public $recordsTotal;

    public $recordsFiltered;
    public $data;
    public function __construct()
    {
        $this->data = array();
    }
}