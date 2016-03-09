<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;

class CertificateListItem
{
    public $DT_RowId;
    public $certificate_name;
    public $certificate_note;
    public $last_user_id;
    public $create_date;
    public $location;
    public function __construct($DT_RowId, $certificate_name, $location,$certificate_note, $last_user_id, $create_date)
    {
        $this->DT_RowId = $DT_RowId;
        $this->certificate_name = $certificate_name;
        $this->certificate_note = $certificate_note;
        $this->last_user_id = $last_user_id;
        $this->create_date = $create_date;
        $this->location = $location;
    }
}