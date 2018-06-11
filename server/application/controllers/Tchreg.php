<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Tchreg extends CI_Controller {
  public function index() {
    $result = LoginService::check();
    // 权限判断
    // TODO
    if ($result['loginState'] === Constants::S_AUTH) {
      // 获取参数
      $param = $_POST;      
      // 处理数据
      $name = $param["name"];
      $res = DB::select('xovUserNotTeach', ['*'], ['name' => $name]);

      // 返回信息
      $this->json([
        'code' => 0,
        'data' => $res
      ]);
    } else {
      $this->json([
        'code' => -1,
        'data' => []
      ]);
    }
  }
}