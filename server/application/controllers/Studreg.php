<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Model;

class Studreg extends CI_Controller {
  const role_name = 'regstud';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      $result = Model\xonStudReg::schools();
      // 正文内容
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function regstud () {
    Model\xonLogin::check(self::role_name, function ($user) {
      try {
        $user_id = $user['unionId'];
        $param = $_POST;
        $sch_id = $param['sch_id'];
        $child_id = $param['child_id'];
        $edu_type_id = $param['edu_type_id'];
        $result = Model\xonStudReg::regStud($user_id, $child_id, $sch_id, $edu_type_id);
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
        $result = Model\xonStudReg::regCancel($user_id, $sch_id, $child_id);
        // 正文内容
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function regqrcode () {
//    Model\xonLogin::check(self::role_name, function ($user) {
//      try {
//        $user_id = $user['unionId'];
//        $uid = Model\xonUser::getUidById($user_id);
//        $margin = 2;
//        $errorLevel = 'H';
//        $matrixSize = 10;
//        Model\QRcode::png($uid, false, $errorLevel, $matrixSize, $margin, false);
//      } catch (Exception $e) {
//        $this->json(['code' => 1, 'data' => $e->getMessage()]);
//      }
//    }, function ($error) {
//      $this->json($error);
//    });
    $user_id = $_GET['id'];
    $uid = Model\xonUser::getUidById($user_id);
    if ( $uid === null ) return;
    $margin = 2;
    $errorLevel = 'H';
    $matrixSize = 10;
    Model\QRcode::png($uid, false, $errorLevel, $matrixSize, $margin, false);
  }
}
