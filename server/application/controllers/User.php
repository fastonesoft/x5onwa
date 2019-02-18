<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class User extends CI_Controller {
  const role_name = 'userset';

  public function index() {
    Mvv\mvvLogin::norolecheck(self::role_name, function ($userinfor) {
      try {
        $user_id = $userinfor->unionId;
        $nick_name = $userinfor->nickName;

        // 更新nick_name
        $result = Model\xonUser::checkById($user_id);
        Model\xonUser::setsById(compact('nick_name'), $user_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function reg() {
    Mvv\mvvLogin::norolecheck(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $name = $param['name'];
        $mobil = $param['mobil'];

        // 记录用户信息
        Model\xonUser::add($userinfor, $name, $mobil);

        // 添加临时权限
        $user_id = $userinfor->unionId;
        $group_id = Model\x5on::GROUP_TEMP_USER;
        Model\xonUserGroup::addTemp($user_id, $group_id);

        // 返回用户信息
        $result = Model\xonUser::getById($user_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
