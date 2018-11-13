<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Constants;
use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use \Exception;

class xonLogin
{
  public static function login ($success, $fail) {
    $result = LoginService::login();
    if ($result['loginState'] === Constants::S_AUTH) {
      call_user_func($success, $result['userinfo']);
    } else {
      call_user_func($fail, ['code' => -1, 'data' => $result['error']]);
    }
  }

  public static function check ($role_name, $success, $fail) {
    $result = LoginService::check();

    if ($result['loginState'] === Constants::S_AUTH) {
      // 增加权限检测
      $user_id = $result['userinfo']['unionId'];
      $res = xonRole::check($user_id, $role_name);
      if ( $res !== NULL ) {
        // 没有权限
        call_user_func($fail, ['code' => 1, 'data' => $res['message']]);
      } else {
        // 成功
        call_user_func($success, $result['userinfo']);
      }
    } else {
      //
      call_user_func($fail, ['code' => -1, 'data' => $result['error']]);
    }
  }

  // 测试用的
  public static function nocheck ($success, $fail) {
    call_user_func($success, $result['userinfo']);
  }
}
