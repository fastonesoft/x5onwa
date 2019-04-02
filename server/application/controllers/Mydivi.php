<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Mydivi extends CI_Controller {
  /**
   * 班级分管
   */
  const role_name = 'mydivi';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 当前年级
        $result = Mvv\mvvMyDivi::grades($userinfor->unionId);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function clsdiv() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 年级已分管、未分管班级
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $result = Mvv\mvvMyDivi::clsdiv($userinfor->unionId, $grade_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function teachs() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 教师查询
        $param = $_POST;
        $user_name = $param['user_name'];
        $result = Mvv\mvvMyDivi::teachs($userinfor->unionId, $user_name);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function dist() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 设置班级分管
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $user_uid = $param['user_uid'];
        $cls_uid_jsons = $param['cls_uid_jsons'];
        $result = Mvv\mvvMyDivi::dist($userinfor->unionId, $grade_id, $user_uid, $cls_uid_jsons);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function remove() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 删除班级分管
        $param = $_POST;
        $class_div_uid = $param['class_div_uid'];
        $result = Mvv\mvvMyDivi::remove($userinfor->unionId, $class_div_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
