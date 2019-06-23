<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Regexam extends CI_Controller {
  /**
   * 报名初审
   */
  const role_name = 'regexam';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 地区选择、学生类别
        $result = Mvv\mvvRegExam::step_auth($userinfor->unionId);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function fields() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 根据报名学生编号，获取报名表格
        $param = $_POST;
        $stud_reg_uid = $param['uid'];
        $step_id = $param['step_id'];
        $result = Mvv\mvvRegExam::fields($userinfor->unionId, $stud_reg_uid, $step_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function exam() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 根据报名学生编号，审核
        $param = $_POST;
        $stud_auth = $param['stud_auth'];
        $stud_reg_uid = $param['uid'];
        $result = Mvv\mvvRegExam::exam($userinfor->unionId, $stud_reg_uid, $stud_auth);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function reject() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 根据报名学生编号，退回
        $param = $_POST;
        $stud_reg_uid = $param['uid'];
        $result = Mvv\mvvRegExam::reject($userinfor->unionId, $stud_reg_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
