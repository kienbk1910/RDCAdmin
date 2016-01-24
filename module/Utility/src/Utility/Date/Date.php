<?php
namespace Utility\Date;

class Date {
    public static function changeDateSQLtoVN($number)
    {
       return date_format(date_create($number),"d/m/Y");
    }

    public static function changeFullDateSQLtoVN($number)
    {
       return date_format(date_create($number),"h:m d/m/Y");
    }

    public static function changeVNtoDateSQL($date_vn)
    {
        $myDateTime = date_create_from_format ('d/m/Y',$date_vn);
        return date_format($myDateTime,'Y-m-d');
    }

    public static function addDays ($date, $days)
    {
        return date('Y-m-d', strtotime($date. ' + '.$days.' days'));
    }

    public static function subDays ($date, $days)
    {
        return date('Y-m-d', strtotime($date. ' - '.$days.' days'));
    }

    public static function changeToFullDate($number)
    {
        return date_format(date_create($number),"d-M-Y h:m");
    }
}
