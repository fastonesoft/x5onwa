<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Role extends CI_Controller {
  const role_name = 'userset';

  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $user_id = $userinfor->unionId;
        $myroles = Model\xovUserRole::getsBy(compact('user_id'));

        // 构造权限列表
        $roles = Model\xonRole::gets();
        // 处理权限结果
        $result = Mvv\mvvUserRole::sign($roles, $myroles);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}