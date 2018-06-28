<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Role extends CI_Controller {
  /**
   * 这只是用户功能列表
   * 不能涉及“权限”操作
   */
  const role_name = 'userset';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      $user_id = $user['unionId'];
      $myrole = DB::select('xovUserRole', ['*'], compact('user_id'));
      // 构造权限列表
      $roles = DB::select('xonRole', ['*']);

      // 处理权限结果
      $result = Model\xonRole::sign($roles, $myrole);

      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}