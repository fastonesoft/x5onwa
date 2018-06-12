<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Constants;
use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use \Exception;

class Login
{
  public static function login ($success, $fail) {
    $result = LoginService::login();
    if ($result['loginState'] === Constants::S_AUTH) {
      call_user_func($success, $result['userinfo']);
    } else {
      call_user_func($fail, ['code' => -1, 'data' => $result['error']]);
    }
  }

  public static function check ($success, $fail) {
    $result = LoginService::check();
    if ($result['loginState'] === Constants::S_AUTH) {
      // 增加权限检测
      // 失败 call_user_func($fail, ['code' => -1, 'data' => []]);
      call_user_func($success, $result['userinfo']);
    } else {
      call_user_func($fail, ['code' => -1, 'data' => []]);
    }
  }

  public static function nocheck ($success, $fail) {
    call_user_func($success, $result['userinfo']);
  }
}
