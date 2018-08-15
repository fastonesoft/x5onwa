<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Mytuning extends CI_Controller {
  const role_name = 'mytuning';

  /**
   * 当前年级列表
   */
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $grades = Model\xovGradeCurrent::getRows();
        $result = compact('grades');

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 当前年级班级
   */
  public function classes() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $result = Model\xovClass::getRows4Tuning($grade_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 调动学生查询
   */
  public function studmoves() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $stud_name = $param['name'];
        $result = Model\xovGradeStud::getRowsByStudName($stud_name);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
