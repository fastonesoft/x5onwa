<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Mydivision extends CI_Controller {
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

  public function classes() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 当前年级班级
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $result = Mvv\mvvMyDivi::classes($userinfor->unionId, $grade_id);

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
        $user_name = $param["user_name"];
        $result = Mvv\mvvMyDivi::teachs($userinfor->unionId, $user_name);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function update() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 设置班级分管
        $param = $_POST;
        $user_uid = $param['user_uid'];
        $cls_ids = $param['cls_ids'];
//        $grade_id = Model\xonGradeDivision::setDivision($user_id, $cls_ids);
        $result = Mvv\mvvMyDivi::update($userinfor->unionId, $user_uid, $cls_ids);

        // 正文
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function classed() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 已分管班级
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $result = Mvv\mvvMyDivi::classed($userinfor->unionId, $grade_id);

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
        $param = $_POST;
        $uid = $param['uid'];
//        $grade_id = Model\xonGradeDivision::removeDivision($uid);
        $result = Mvv\mvvMyDivi::remove($userinfor->unionId, $grade_id);

        // 正文
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
