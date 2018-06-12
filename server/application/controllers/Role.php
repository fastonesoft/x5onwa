<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Role extends CI_Controller {
  public function index() {
    Model\Login::check(function ($user) {
      $user_id = $user['unionId'];
      $myrole = DB::select('xovUserRole', ['*'], compact('user_id'));
      // 构造权限列表
      $roles = DB::select('xonRole', ['*']);

      // 处理权限结果
      $result = Model\xonRole::sign($roles, $myrole);

      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}