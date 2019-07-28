<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Childset extends CI_Controller {
  /**
   * 孩子修改
   */
  const role_name = 'childset';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 孩子查询
        $param = $_POST;
        $child_name = Model\x5on::getLike($param['name']);

        $result = Mvv\mvvChildSet::child($child_name);
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
        // 孩子修改
        $param = $_POST;
        $uid = $param['uid'];
        $idc = $param['idc'];
        $name = $param['name'];

        $result = Mvv\mvvChildSet::update($uid, $idc, $name);
        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}
