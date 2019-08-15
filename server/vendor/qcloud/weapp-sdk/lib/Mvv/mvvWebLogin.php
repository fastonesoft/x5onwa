<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;

class mvvWebLogin
{

  public static function login_ci($that, $success, $fail) {
    $userinfor = $that->session->tempdata(x5on::SESSION_WEB_LOGIN);
    if ($userinfor !== null) {
      call_user_func($success, $userinfor);
    } else {
      call_user_func($fail, ['code' => -1, 'data' => '没有登录，无法操作！']);
    }
  }

}
