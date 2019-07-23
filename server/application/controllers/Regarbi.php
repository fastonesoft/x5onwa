<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Regarbi extends CI_Controller {
  /**
   * 报名仲裁
   */
  const role_name = 'regarbi';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 招生年级
        $result = Mvv\mvvRegArbi::step($userinfor->unionId);

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

        $result = Mvv\mvvRegArbi::stud($userinfor->unionId, $steps_id, $child_name);

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
        // 报名信息查询
        $param = $_POST;
        $stud_reg_uid = $param['uid'];

        $result = Mvv\mvvRegArbi::parent($userinfor->unionId, $stud_reg_uid);

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
        // 仲裁提交
        $param = $_POST;
        // 表单数据添加
        $result = Mvv\mvvRegArbi::arbiup($userinfor->unionId, $param);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
