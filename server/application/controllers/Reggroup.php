<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Reggroup extends CI_Controller {
  /**
   * 报名分组
   */
  const role_name = 'reggroup';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 招生年级
        $result = Mvv\mvvRegGroup::step($userinfor->unionId);

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

        $result = Mvv\mvvRegGroup::stud($userinfor->unionId, $steps_id, $child_name);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function group() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 分组提交
        $param = $_POST;
        $steps_id = $param['steps_id'];
        $group_name = $param['group_name'];
        $stud_reg_uid = $param['stud_reg_uid'];

        $result = Mvv\mvvRegGroup::group($userinfor->unionId, $steps_id, $group_name, $stud_reg_uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
