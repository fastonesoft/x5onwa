<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Role extends CI_Controller {
  public function index() {
    $result = LoginService::check();

    if ($result['loginState'] === Constants::S_AUTH) {
      // 查询我的权限
      $userinfor = $result['userinfo'];
      $myrole = DB::select('xovUserRole', ['*'], ['user_id' => $userinfor['unionId']]);

      // 构造权限列表
      $roles = DB::select('xonRole', ['*']);

      // 处理权限结果
      $result = Model\xonRole::sign($roles, $myrole);

      $this->json([
        'code' => 0,
        'data' => $result
      ]);
    } else {
      $this->json([
        'code' => -1,
        'data' => []
      ]);
    }
  }
}