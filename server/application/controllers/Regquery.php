<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Regquery extends CI_Controller {
  /**
   * 报名查询
   */
  const role_name = 'regquery';
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

  public function count() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 统计报名人数
        $param = $_POST;
        $steps_id = $param['steps_id'];
        $stud_auth = isset($param['stud_auth']) ? $param['stud_auth'] : null;

        $result = Mvv\mvvRegQuery::count($userinfor->unionId, $steps_id, $stud_auth);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function stud() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 报名学生查询
        $param = $_POST;
        $steps_id = $param['steps_id'];
        $child_name = Model\x5on::getLike($param['name']);

        $result = Mvv\mvvRegQuery::stud($userinfor->unionId, $steps_id, $child_name);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function parent() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 报名学生查询
        $param = $_POST;
        $stud_reg_uid = $param['uid'];

        $result = Mvv\mvvRegQuery::parent($userinfor->unionId, $stud_reg_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function arbi() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 报名学生仲裁
        $param = $_POST;
        $stud_reg_uid = $param['uid'];

        $result = Mvv\mvvRegQuery::arbi($userinfor->unionId, $stud_reg_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function arbiup() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 仲裁提交
        $param = $_POST;

        // 表单数据添加
        $result = Mvv\mvvRegQuery::arbiup($userinfor->unionId, $param);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function retrial() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 报名学生重审
        $param = $_POST;
        $stud_reg_uid = $param['uid'];

        $result = Mvv\mvvRegQuery::retry($userinfor->unionId, $stud_reg_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
