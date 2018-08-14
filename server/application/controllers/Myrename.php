<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Myrename extends CI_Controller {
  const role_name = 'myrename';

  /**
   * 当前年级列表
   */
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      $grades = Model\xovGradeCurrent::getRows();
      $result = compact('grades');

      // 正文内容
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 当前年级班级
   */
  public function classes() {
    Model\xonLogin::check(self::role_name, function ($user) {

      $param = $_POST;
      $grade_id = $param['grade_id'];
      $result = Model\xovClass::getRows4Rename($grade_id);

      // 正文内容
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }


}
