<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Roleset extends CI_Controller
{
  /**
   * 权限设置
   */
  const role_name = 'roleset';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 获取权限列表
        $result = Model\xonRole::gets();

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
        $param = $_POST;

        // 设置权限状态
        $result = Mvv\mvvRoleset::update($param);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}