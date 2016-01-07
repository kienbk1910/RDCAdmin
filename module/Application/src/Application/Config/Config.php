<?php

namespace Application\Config;

 class Config
 {
    const MAX_ITEM_OF_PAGE = 40;
    const MAX_DAYS_COUNTER =30;
    const USER_ADMIN =1;
    const USER_LEAVE1 =2;
    const USER_LEVEL2 =3;
    const ROLE_AGENCY = 4;
    const IMAGE_PATH = "/files/users/avatar/origin/";

    const PASSWORD_MAX_LEN = 500;
    const PASSWORD_MIN_LEN = 8;
    const USERNAME_MAX_LEN = 500;
    const USERNAME_MIN_LEN = 5;


    /* Add user */
    const PROCESS_OK = "ok";
    const PASSWORD_DIFFERENT = "Password is not mapping";
    const PASSWORD_IS_WRONG = "Your password is wrong or the same password";
    const USER_EXIST = "Username is exist";
    const PASSWORD_EXCEED_MAX_LEN = "Password length exceed maximum length";
    const PASSWORD_BENEATH_MIN_LEN = "Password length beneath minimum length";
    const USERNAME_EXCEED_MAX_LEN = "Username length exceed maximum length";
    const USERNAME_BENEATH_MIN_LEN = "Username length beneath minimum length";
  

  public static function getMinValue()
  {
    return self::MAX_ITEM_OF_PAGE;
  }
 }
