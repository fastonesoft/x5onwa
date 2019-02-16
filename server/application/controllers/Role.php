<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Role extends CI_Controller {
  /**
   * 这只是用户功能列表
   * 不能涉及“权限”操作
   */
  const role_name = 'userset';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      $user_id = $userinfor->unionId;
      $myroles = Model\xovUserRole::getsBy(compact('user_id'));

      // 构造权限列表
      $roles = Model\xonRole::gets();
      // 处理权限结果
      $result = Mvv\mvvUserRole::sign($roles, $myroles);

      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}