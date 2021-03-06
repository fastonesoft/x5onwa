<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Regrexam extends CI_Controller {
  /**
   * 报名复核
   */
  const role_name = 'regrexam';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 地区选择
        $result = Mvv\mvvRegRexam::step($userinfor->unionId);

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
        $steps_id = $param['steps_id'];
        $result = Mvv\mvvRegRexam::fields($userinfor->unionId, $stud_reg_uid, $steps_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function rexam() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 根据报名学生编号，审核
        $param = $_POST;
        $stud_reg_uid = $param['uid'];
        $steps_id = $param['steps_id'];
        $group_name = $param['group_name'];
        $result = Mvv\mvvRegRexam::rexam($userinfor->unionId, $stud_reg_uid, $steps_id, $group_name);

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
        $result = Mvv\mvvRegRexam::reject($userinfor->unionId, $stud_reg_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
