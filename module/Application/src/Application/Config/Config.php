<?php

namespace Application\Config;

 class Config
 {
    const MAX_ITEM_OF_PAGE = 20;
    const MAX_DAYS_COUNTER =30;
    const USER_ADMIN =1;
    const USER_LEAVE1 =2;
    const USER_LEAVE2 =3;
    const ROLE_AGENCY = 4;

    // Acction id
    const LOGIN_ACTION = 1;
    const EDIT_ACTION = 2;
    const ADD_ACTION = 3;
    const REMOVE_ACTION = 4;
    const PAY_ACTION = 5;
    const EDIT_PAY_ACTION = 6;
    const DELETE_PAY_ACTION =7;
    const FILE_ACTION = 8;
    const EDIT_FILE_ACTION = 9;
    const DELETE_FILE_ACTION = 10;
    const COMMENT_ACTION = 11;
    // process id
    const PROCESS_REC = 1;
    // type pay
    const PAY_INFO_COMMON = 0;
    const PAY_CUSTUMER = 1;
    const PAY_PROVIDER = 2;

    const IMAGE_PATH = "/files/users/avatar/origin/";
    const FILE_ATTACHMENT_PATH = "/data/attachment/";

    const PASSWORD_MAX_LEN = 500;
    const PASSWORD_MIN_LEN = 8;
    const USERNAME_MAX_LEN = 500;
    const USERNAME_MIN_LEN = 5;

    const FILE_PERMISSION_ERROR    = 0;
    const FILE_PERMISSION_RDC      = 1;
    const FILE_PERMISSION_CUSTUMER = 2;
    const FILE_PERMISSION_PROVIDER = 3;
    const FILE_PERMISSION_ALL = 4;
    const FILE_PERMISSION_CUSTUMER_PROVIDER = 6;
    /* Add user */
    const PROCESS_OK = "Processing successfully";
    const PROCESS_NG = "Genaral error while processing";
    const PASSWORD_DIFFERENT = "Password is not mapping";
    const PASSWORD_IS_THE_SAME = "Password is the same as the old one";
    const PASSWORD_IS_WRONG = "Your password is wrong";
    const USER_EXIST = "Username is exist";
    const USER_IS_NOT_EXIST = "Username is not exist";
    const PASSWORD_EXCEED_MAX_LEN = "Password length exceed maximum length";
    const PASSWORD_BENEATH_MIN_LEN = "Password length beneath minimum length";
    const USERNAME_EXCEED_MAX_LEN = "Username length exceed maximum length";
    const USERNAME_BENEATH_MIN_LEN = "Username length beneath minimum length";

    const AGENCY_TYPE = 0;
    const PROVIDER_TYPE = 1;
    const ASSIGN_REPORTER_TYPE = 2;
    const NOTIFY_CREATE = 0;
    const NOTIFY_MODIFY = 1;

    /* Task database field */
    const custumer_id = "custumer";
    const custumer_name = "Tên Khách Hàng";
    
    const agency_id = "agency_id";
    const agency_name = "Người Gửi (Bên Khách Hàng)";
    
    const agency_note_id = "agency_note";
    const agency_note_name = "Ghi Chú (Bên Khách Hàng)";
    
    const provider_id = "provider_id";
    const provider_name = "Người Gửi (Bên Khách Hàng)";
    
    const reporter_id = "reporter_id";
    const reporter_name = "Người Giám Sát";

    const date_open_id = "date_open";
    const date_open_name = "Ngày Nhận (Bên Khách Hàng)";

    const date_end_id = "date_end";
    const date_end_name = "Ngày Hẹn (Bên Khách Hàng)";
    
    const date_open_pr_id = "date_open_pr";
    const date_open_pr_name = "Ngày Nhận (Bên Nhà Cung Cấp)";
    
    const date_end_pr_id = "date_end_pr";
    const date_end_pr_name = "Ngày Hẹn (Bên Nhà Cung Cấp)";
    
    const provider_note_id = "provider_note";
    const provider_note_name = "Ghi Chú (Bên Nhà Cung Cấp)";
    
    const certificate_id = "certificate";
    const certificate_name = "Tên Sản Phẩm";
    
    const cost_sell_id = "cost_sell";
    const cost_sell_name = "Thoả Thuận (Bên Khách Hàng)";
    
    const cost_buy_id = "cost_buy";
    const cost_buy_name = "Thoả Thuận (Bên Nhà Cung Cấp)";
    
    const process_id = "process_id";
    const process_name = "Trạng Thái";
    
    const assign_id = "assign_id";
    const assign_name = "Người Chịu Trách Nhiệm";

    public static function getMinValue()
    {
        return self::MAX_ITEM_OF_PAGE;
    }
    
    public static function convertFieldID($field_id)
    {
        if ($field_id == Config::custumer_id) return Config::custumer_name;
        if ($field_id == Config::agency_id) return Config::agency_name;
        if ($field_id == Config::provider_id) return Config::provider_name;
        if ($field_id == Config::reporter_id) return Config::reporter_name;
        if ($field_id == Config::date_open_id) return Config::date_open_name;
        if ($field_id == Config::date_open_pr_id) return Config::date_open_pr_name;
        if ($field_id == Config::certificate_id) return Config::certificate_name;
        if ($field_id == Config::cost_sell_id) return Config::cost_sell_name;
        if ($field_id == Config::date_end_id) return Config::date_end_name;
        if ($field_id == Config::date_end_pr_id) return Config::date_end_pr_name;
        if ($field_id == Config::cost_buy_id) return Config::cost_buy_name;
        if ($field_id == Config::process_id) return Config::process_name;
        if ($field_id == Config::assign_id) return Config::assign_name;
        if ($field_id == Config::agency_note_id) return Config::agency_note_name;
        if ($field_id == Config::provider_note_id) return Config::provider_note_name;
        return $field_id;
    }
 }
