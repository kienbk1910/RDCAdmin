<?php

namespace Application\Model;

class Certificate {
    public $id;
    public $create_date;
    public $certificate_name;
    public $certificate_note;
    public $create_user_id;
    public $last_user_id;
    public $last_update;
    public function __construct()
    {
    }
}