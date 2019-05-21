<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Schrule extends CI_Controller {
  /**
   * 字段规则
   */
  const role_name = 'schrule';
  public function add() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $mode = $param['uid'];
        $field_name = $param['field_name'];
        $value = $param[$field_name];

        $result = Mvv\mvvSchField::add($userinfor->unionId, $form_id, $mode, $name, $label);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
