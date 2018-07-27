<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Studreg extends CI_Controller {
  const role_name = 'regstud';

  public function regstud () {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $user_id = $user['unionId'];
        $param = $_POST;
        $sch_id = $param['sch_id'];
        $child_id = $param['child_id'];
        $edu_type_id = $param['edu_type_id'];
        $forms = Model\xonStudReg::regStud($user_id, $child_id, $sch_id, $edu_type_id);
        $result = compact('forms');
        // 正文内容
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  // 检测是否报名
  public function regcheck () {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $user_id = $user['unionId'];

        $result = Model\xonStudReg::regCheck($user_id);
        // 正文内容
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function regcancel () {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $user_id = $user['unionId'];
        $param = $_POST;
        $sch_id = $param['sch_id'];
        $child_id = $param['child_id'];
        Model\xonStudReg::regCancel($user_id, $sch_id, $child_id);
        $result = Model\xonStudReg::regCancelData($user_id);
        // 正文内容
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

}
