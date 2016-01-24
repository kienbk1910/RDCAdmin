<?php

namespace Application\Config;

 class Config
 {
    const MAX_ITEM_OF_PAGE = 40;
    const MAX_DAYS_COUNTER =30;
    const USER_ADMIN =1;
    const USER_LEAVE1 =2;
    const USER_LEAVE2 =3;
    const ROLE_AGENCY = 4;

    // process id
    const PROCESS_REC = 1;
    // type pay
    const PAY_CUSTUMER = 1;
    const PAY_PROVIDER = 2;

    const IMAGE_PATH = "/files/users/avatar/origin/";
    const FILE_ATTACHMENT_PATH = "/data/attachment/";

    const PASSWORD_MAX_LEN = 500;
    const PASSWORD_MIN_LEN = 8;
    const USERNAME_MAX_LEN = 500;
    const USERNAME_MIN_LEN = 5;


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


  public static function getMinValue()
  {
    return self::MAX_ITEM_OF_PAGE;
  }
 }
