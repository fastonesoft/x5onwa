<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;
use \QCloud_WeApp_SDK\Mvv;

class Gradestud extends CI_Controller {
  const role_name = 'students';

  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {

        $this->json(['code' => 0, 'data' => $user]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function grade() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $result = Mvv\mvvGradeStud::grades();
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function classes() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];

        $result = Mvv\mvvGradeStud::classes($grade_id);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function query() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $cls_id = $param['cls_id'];
        $stud_name = Model\x5on::getLike($param['stud_name']);

        // 当前年度
        $result = Mvv\mvvGradeStud::query($grade_id, $cls_id, $stud_name);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
