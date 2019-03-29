<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Myrename extends CI_Controller {
  const role_name = 'myrename';

  /**
   * 当前年级列表
   */
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $grades = Model\xovGradeCurrent::gets();
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
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $result = Model\xovClass::getRows4Rename($grade_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 变更班级序号
   */
  public function update() {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $result = Model\xonClass::update($param);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
