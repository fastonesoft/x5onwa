<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Tchreg extends CI_Controller {
  public function index() {
    Model\Login::check(function ($user) {
      // 获取参数
      $param = $_POST;
      // 处理数据
      $name = $param["name"];
      $result = DB::select('xovUserNotTeach', ['*'], ['name' => $name]);

      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 用户学校查询
   * 没有学校返回[]、如果是管理员返回[学校列表]
   * 有学校返回[学校]
   */
  public function usersch() {
    Model\Login::check(function ($user) {
      $unionId = $user['unionId'];
      $result = DB::select('xovSchUser', ['sch_id', 'sch_name'], ['user_id' => $unionId]);
      // 检测res是否为空
      // 为空，则查找是不是管理员
      if (count($result) === 0) {
        $result = DB::select('xonUserGroup', ['*'], ['user_id' => $unionId, 'group_id' => Model\X5on::ADMIN_GROUP_VALUE]);
        if (count($result) === 1) {
          // 如果确实是“管理员”
          // 显示学校列表
          $result = DB::select('xonSchool', ['id as sch_id', 'name as sch_name']);
        }
      }
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function usereg() {
    Model\Login::check(function ($user) {
      // 获取参数
      $param = $_POST;
      // 准备数据
      $sch_id = $param['sch_id'];
      $user_id = $param['user_id'];
      $uid = bin2hex(openssl_random_pseudo_bytes(16));
      // 添加数据
      $result = DB::row('xonSchUser', ['*'], compact('user_id'));
      if ($result === NULL) {
        DB::insert('xonSchUser', compact('uid', 'user_id', 'sch_id'));
      }
      // 返回信息
      $this->json(['code' => 0, 'data' => []]);
    }, function ($error) {
      $this->json($error);
    });
  }
}