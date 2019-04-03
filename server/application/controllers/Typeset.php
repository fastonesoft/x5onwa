<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Typeset extends CI_Controller {
  /**
   * 分类设置
   */
  const role_name = 'typeset';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 分类设置
        $param = $_POST;
        $id = $param['id'];
        $name = $param['name'];
        $result = Mvv\mvvMyDivi::remove($userinfor->unionId, $class_div_uid);

        $this->json(['code' => 0, 'data' => []]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
