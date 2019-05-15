<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Schform extends CI_Controller {
  /**
   * 模板名称
   */
  const role_name = 'schform';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $result = Mvv\mvvSchForm::types($userinfor->unionId);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function forms() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $type_id = $param['type_id'];
        $steps_id = $param['steps_id'];
        $years_id = $param['years_id'];

        $result = Mvv\mvvSchForm::forms($userinfor->unionId, $type_id, $steps_id, $years_id);

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
        $title = $param['title'];
        $type_id = $param['type_id'];
        $steps_id = $param['steps_id'];
        $years_id = $param['years_id'];

        $result = Mvv\mvvSchForm::add($userinfor->unionId, $title, $type_id, $steps_id, $years_id);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }


}
