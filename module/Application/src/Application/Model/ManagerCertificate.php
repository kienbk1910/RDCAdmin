<?php

namespace Application\Model;

class ManagerCertificate {
    public $id;
    public $certificate_type;
    public $certificate_code;
    public $full_name;
    public $place_of_birth;
    public $start_time;
    public $end_time;
    public $identity_card;
    public $day_of_birth;
    public $last_user_id;
    public $last_update;
    public $note;
    public $create_user_id;
    public function __construct()
    {
    }
}