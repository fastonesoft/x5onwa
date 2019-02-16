<?php
namespace QCloud_WeApp_SDK\Mvv;

use \Exception;

use QCloud_WeApp_SDK\Auth\LoginService;

class mvvLogin
{

  public static function login ($success, $fail) {
    try {
      $result = LoginService::login();
      // 成功
      call_user_func($success, $result);
    } catch (Exception $e) {
      // 登录异常
      call_user_func($fail, ['code' => -1, 'data' => $e->getMessage()]);
    }
  }

  public static function check ($role_name, $success, $fail) {
    try {
      $user = LoginService::check();
      // 权限检测
      mvvUserRole::check($user->unionId, $role_name);
      // 成功
      call_user_func($success, $user);
    } catch (Exception $e) {
      // 检测异常
      call_user_func($fail, ['code' => -1, 'data' => $e->getMessage()]);
    }
  }

}
