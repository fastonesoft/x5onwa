<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Schrule extends CI_Controller {
  /**
   * 字段规则
   */
  const role_name = 'schrule';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 规则数据提交
        $param = $_POST;
        $uid = $param['uid'];
        $update = $param['update'];
        $value = $param[$update];

        $result = Mvv\mvvSchRule::add($userinfor->unionId, $uid, $update, $value);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
