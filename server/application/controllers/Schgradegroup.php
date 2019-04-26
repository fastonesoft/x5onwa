<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Schgradegroup extends CI_Controller {
  /**
   * 年级分组
   */
  const role_name = 'schgradegroup';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $result = Mvv\mvvSchClass::classes($userinfor->unionId, $grade_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function edit() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $uid = $param['uid'];
        $num = $param['num'];

        $result = Mvv\mvvSchClass::edit($userinfor->unionId, $uid, $num);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function add() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $num = $param['num'];

        $result = Mvv\mvvSchClass::add($userinfor->unionId, $grade_id, $num);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function adds() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $grade_id = $param['grade_id'];
        $nums = $param['nums'];

        $result = Mvv\mvvSchClass::adds($userinfor->unionId, $grade_id, $nums);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function del() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $uid = $param['uid'];
        $result = Mvv\mvvSchClass::del($userinfor->unionId, $uid);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
