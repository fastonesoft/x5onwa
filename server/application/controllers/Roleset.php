<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Roleset extends CI_Controller
{
  /**
   * 权限列表
   */
  const role_name = 'roleset';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 权限列表
      $result = DB::select('xonRole', ['uid', 'title', 'can_show']);
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 权限设置
   */
  public function update() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 获取参数
      $param = $_POST;
      $result = Model\xonRole::update($param);

      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}