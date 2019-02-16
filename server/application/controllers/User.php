<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class User extends CI_Controller {
  const role_name = 'userset';

  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $user = Model\xonUser::checkById($user->unionId);
        $this->json(['code' => 0, 'data' => $user]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function reg() {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        // 记录用户：
        Model\xonUser::store($datainfor);
        // 添加默认用户权限（临时用户组）
        // 以用户的unionId + group_id作主键索引
        $user_id = $datainfor->unionId;
        $group_id = Model\x5on::GROUP_TEMP_USER;
        Model\xonUserGroup::first($user_id, $group_id);
        $this->json(['code' => 0, 'data' => $user]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
