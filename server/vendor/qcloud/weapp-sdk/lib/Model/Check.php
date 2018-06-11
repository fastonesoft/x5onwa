<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Constants;
use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use \Exception;

class Check
{
  public static function check ($success, $fail) {
    $result = LoginService::check();
    if ($result['loginState'] === Constants::S_AUTH) {
      call_user_func($success, $result['userinfo']);
    } else {
      call_user_func($fail, ['code' => -1, 'data' => []]);
    }
  }

  public static function nocheck ($success, $fail) {
    call_user_func($success, $result['userinfo']);
  }
}
