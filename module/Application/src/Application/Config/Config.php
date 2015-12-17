<?php 
namespace Application\Config;

 class Config
 {
    const MAX_ITEM_OF_PAGE = 40;
    const MAX_DAYS_COUNTER =30;
    const USER_ADMIN =1;
    const USER_LEAVE1 =2;
    const USER_LEVEL2 =3;
  public static function getMinValue()
  {
    return self::MAX_ITEM_OF_PAGE;
  }
 }