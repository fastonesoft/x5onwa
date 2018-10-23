<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Login extends CI_Controller {
  public function index() {
    Model\xonLogin::login(function ($userinfor) {
      try {
        $datainfor = $userinfor['userinfo'];
        // 记录用户
        Model\xonUser::store($datainfor);
        // 添加默认用户权限（临时用户组）
        // 以用户的unionId + group_id作主键索引
        $user_id = $datainfor->unionId;
        $group_id = Model\x5on::GROUP_TEMP_USER;
        Model\xonUserGroup::first($user_id, $group_id);

        $this->json(['code' => 0, 'data' => $userinfor]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
