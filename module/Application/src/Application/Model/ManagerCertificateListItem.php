<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;

class ManagerCertificateListItem
{
    public $DT_RowId;
    public $certificate_name;
    public $full_name;
    public $identity_card;
    public $certificate_code;
    public function __construct($DT_RowId, $certificate_name, $full_name, $identity_card, $certificate_code)
    {
        $this->DT_RowId = $DT_RowId;
        $this->certificate_name = $certificate_name;
        $this->full_name = $full_name;
        $this->identity_card = $identity_card;
        $this->certificate_code = $certificate_code;
    }
}