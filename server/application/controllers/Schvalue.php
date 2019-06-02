<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Schvalue extends CI_Controller {
  /**
   * 表单数据
   */
  const role_name = 'schvalue';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $form_id = $param['form_id'];

        // 用户级数据获取，不是管理级
        $result = Mvv\mvvSchForm::fields($userinfor->unionId, $form_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
