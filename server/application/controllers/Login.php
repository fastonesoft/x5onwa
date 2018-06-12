<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Login extends CI_Controller {
  public function index() {
    Model\Login::login(function ($userinfor) {
      $datainfor = $userinfor['userinfo'];
      // 记录用户
      Model\xonUser::store($datainfor);
      // 添加默认用户权限（临时用户组）
      // 以用户的unionId + group_id作主键索引
      $user_id = $datainfor->unionId;
      Model\xonUserGroup::first($user_id, Model\X5on::GROUP_TEMP_USER);

      $this->json(['code' => 0, 'data' => $userinfor]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
