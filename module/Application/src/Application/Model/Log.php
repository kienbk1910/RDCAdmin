<?php

namespace Application\Model;

class Log {
    public $id;
    public $user_id;
    public $task_id;
    public $value;
    public $action_id;
    public $date;

    /*
     * const assign_id = "assign_id";
     * const assign_name = "Người Chịu Trách Nhiệm"; 
     */
    public $key;
    public $key_name;
    
    public $old_value;
    public $old_id;
    
    public $new_value;
    public $new_id;
    
    public $custumer;
}