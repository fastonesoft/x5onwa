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

  public function studcls() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $cls_id = $param['cls_id'];

        // 当前年度
        $result = Mvv\mvvGradeStud::studcls($grade_id, $cls_id);
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
        $cls_id = $param['cls_id'];
        $grade_id = $param['grade_id'];
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

  public function add() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $cls_id = $param['cls_id'];
        $grade_id = $param['grade_id'];
        $stud_idc = $param['stud_idc'];
        $stud_name = $param['stud_name'];
        $come_date = $param['come_date'];

        // 当前年度
        $result = Mvv\mvvGradeStud::add($grade_id, $cls_id, $stud_name, $stud_idc, $come_date);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function type() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        // 学生来源
        $result = Mvv\mvvGradeStud::type();
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function status() {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        // 学籍状态
        $in_sch = 1;
        $result = Mvv\mvvGradeStud::status($in_sch);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
