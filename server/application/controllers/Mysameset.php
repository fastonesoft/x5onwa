<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Mysameset extends CI_Controller {
  const role_name = 'mysameset';

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
      $result = Model\xovClass::getRows($grade_id);

      // 正文内容
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 当前班级学生
   */
  public function students() {
    Model\xonLogin::check(self::role_name, function ($user) {

      $param = $_POST;
      $cls_id = $param['cls_id'];
      $result = Model\xovClass::getRows($cls_id);

      // 正文内容
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}
