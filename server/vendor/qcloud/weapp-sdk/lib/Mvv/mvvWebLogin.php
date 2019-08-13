<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;

class mvvWebLogin
{
  public static function login($success, $fail)
  {
    // 登录检测
    session_start();
    $userinfor = isset($_SESSION[x5on::SESSION_WEB_LOGIN]) ? $_SESSION[x5on::SESSION_WEB_LOGIN] : null;
    if ($userinfor) {
      call_user_func($success, $userinfor);
    } else {
      call_user_func($fail, ['code' => -1, 'data' => '没有登录，无法操作！']);
    }
  }

}
