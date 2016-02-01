<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Utility;

class DataTableUtility
{
  
  	 public  static  function getSearchValue($columns,$data)
    {
       foreach ($columns as $column ){
       	if($column['data'] == $data ){
       		return $column['search']['value'];
       	}
       }
   		return "";
    }
    
    
}