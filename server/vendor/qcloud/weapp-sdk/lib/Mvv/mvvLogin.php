<?php
namespace QCloud_WeApp_SDK\Mvv;

use \Exception;

use QCloud_WeApp_SDK\Auth\LoginService;
use QCloud_WeApp_SDK\Model\xovUserRole;
use QCloud_WeApp_SDK\Model\xovUserRoleSchool;
use QCloud_WeApp_SDK\Model\xovUserSchool;

class mvvLogin
{

  public static function login ($success, $fail) {
    try {
      $userinforAndskey = LoginService::login();
      // 成功
      call_user_func($success, $userinforAndskey);
    } catch (Exception $e) {
      // 登录异常
      call_user_func($fail, ['code' => -1, 'data' => $e->getMessage()]);
    }
  }

  public static function check ($role_name, $success, $fail) {
    try {
      $userinfor = LoginService::check();
      $user_id = $userinfor->unionId;
      // 权限检测
      xovUserRole::checksByCustom(compact('user_id', 'role_name'), '没有操作权限');
      // 学校权限检测
      $id = $user_id;
      $checked = 1;
      $userschool = xovUserSchool::getBy(compact('id', 'checked'));
      $sch_id = $userschool ? $userschool->sch_id : null;
      xovUserRoleSchool::checksByCustom(compact('user_id', 'sch_id', 'role_name'), '没有操作权限');

      // 成功
      call_user_func($success, $userinfor);
    } catch (Exception $e) {
      // 检测异常
      call_user_func($fail, ['code' => -1, 'data' => $e->getMessage()]);
    }
  }

  // 用户注册使用
  public static function norolecheck ($role_name, $success, $fail) {
    try {
      $userinfor = LoginService::check();
      // 成功
      call_user_func($success, $userinfor);
    } catch (Exception $e) {
      // 检测异常
      call_user_func($fail, ['code' => -1, 'data' => $e->getMessage()]);
    }
  }

}
