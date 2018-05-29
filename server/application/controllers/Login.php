<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Model;

class Login extends CI_Controller {
  public function index() {
    $result = LoginService::login();

    if ($result['loginState'] === Constants::S_AUTH) {
      $userinfor = $result['userinfo'];

      // 测试数据
      $datainfor = $userinfor['userinfo'];

      // 记录用户
      Model\xonUser::store($datainfor);
      // 用户权限
      Model\xonUserGroup::first($datainfor, 1);

      // 输出结果
      $this->json([
        'code' => 0,
        'data' => $userinfor
      ]);
    } else {
      $this->json([
        'code' => -1,
        'error' => $result['error']
      ]);
    }
  }
}
