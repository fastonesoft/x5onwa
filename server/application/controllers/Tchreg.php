<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Tchreg extends CI_Controller {
  public function index() {
    Model\Check::check(function ($user) {
      // 获取参数
      $param = $_POST;
      // 处理数据
      $name = $param["name"];
      $res = DB::select('xovUserNotTeach', ['*'], ['name' => $name]);

      // 返回信息
      $this->json(['code' => 0, 'data' => $res]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function usersch() {
    Model\Check::check(function ($user) {
      $unionId = $user['unionId'];
      $res = DB::row('xovSchUser', ['sch_id', 'sch_name'], ['user_id' => $unionId]);
      // 检测res是否为空
      // 为空，则查找是不是管理员
      $items = [];
      if ($res === NULL) {
        $items = DB::row('xonUserGroup', ['*'], ['user_id' => $unionId, 'group_id' => Model\X5on::ADMIN_GROUP_VALUE]);
        if ($items !== NULL) {
          // 如果确实是“管理员”
          // 显示学校列表
          $items = DB::select('xonSchool', ['id as sch_id', 'name as sch_name']);
        }
      }

      // 返回信息
      $this->json(['code' => 0, 'data' => $res, 'items' => $items]);
    }, function ($error) {
      $this->json($error);
    });
  }
}