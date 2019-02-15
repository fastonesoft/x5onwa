<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Studreg extends CI_Controller {
  const role_name = 'regstud';

  public function regstud () {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $user_id = $user['unionId'];
        $param = $_POST;
        $sch_id = $param['sch_id'];
        $child_id = $param['child_id'];
        $edu_type_id = $param['edu_type_id'];
        $result = Model\xonStudReg::regStud($user_id, $child_id, $sch_id, $edu_type_id);


        // todo: 将以下内容做一些调整

        // 检测是否已经录取
        $enter = xonStudent::checkStudentEnter($child_id, $sch_id);
        if ($enter !== false) {
          return $enter;
        }

        Model\xovSchoolForm::getStudRegSchoolForm($sch_id);

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
    Mvv\mvvLogin::check(self::role_name, function ($user) {
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
    Mvv\mvvLogin::check(self::role_name, function ($user) {
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
