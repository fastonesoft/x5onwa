<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Userset extends CI_Controller {
  const role_name = 'userset';

  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $user_id = $userinfor->unionId;
        $result = Model\xonUser::checkById($user_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function update() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $name = $param['name'];
        $mobil = $param['mobil'];

        // 变更用户信息
        $user_id = $userinfor->unionId;
        $nick_name = $userinfor->nickName;
        $checked = 1;
        Model\xonUser::setsById(compact('nick_name', 'name', 'mobil', 'checked'), $user_id);

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
