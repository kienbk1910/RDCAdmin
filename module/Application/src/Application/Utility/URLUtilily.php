<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Utility;

class URLUtilily
{
     
     const URL_AGENCY 	= "/tasks/orderdetail/%s";
     const URL_PROVIDER = "/tasks/taskdetail/%s";
     const URL_STAFF = "/manager-tasks/detail/%s";
  	 public  static  function getUrl($user_id,$role,$taks_id,$agency_id,$provider_id)
    {
    	if($role <=3){
    		return $subject = sprintf(URLUtilily::URL_STAFF,$taks_id);
    	}
    	if($user_id == $agency_id){
    		return $subject = sprintf(URLUtilily::URL_AGENCY,$taks_id);
    	}
       	if($user_id == $provider_id){
    		return $subject = sprintf(URLUtilily::URL_PROVIDER,$taks_id);
    	}
    	return "";
    }
    public  static function test(){

    }
    
}