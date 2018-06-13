<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Tchreg extends CI_Controller {

  /**
   * 不是教师的用户
   * 根据姓名查询出不是教师的用户列表
   */
  public function index() {
    Model\Login::check(function ($user) {
      // 获取参数
      $param = $_POST;
      // 处理数据
      $name = $param["name"];
      $result = DB::select('xovUserNotTeach', ['*'], compact('name'));

      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 用户学校查询
   * 如果是管理员返回[学校列表]
   * 有学校返回[学校]、没有学校返回[]
   */
  public function usersch() {
    Model\Login::check(function ($user) {
      $unionId = $user['unionId'];
      $result = DB::select('xonUserGroup', ['*'], ['user_id' => $unionId, 'group_id' => Model\X5on::GROUP_ADMIN_VALUE]);
      // 检测是否：系统管理员
      if (count($result) === 1) {
        // 显示学校列表
        $result = DB::select('xonSchool', ['id as sch_id', 'name as sch_name']);
      } else {
        // 检查注册学校
        $result = DB::select('xovSchoolTeach', ['sch_id', 'sch_name'], ['user_id' => $unionId]);
      }
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 用户注册学校
   * 根据提交的数据，注册相应的学校
   */
  public function usereg() {
    Model\Login::check(function ($user) {
      // 获取参数
      $param = $_POST;
      // 准备数据
      $sch_id = $param['sch_id'];
      $user_id = $param['user_id'];
      $uid = bin2hex(openssl_random_pseudo_bytes(16));
      // 添加数据
      $result = DB::row('xonSchoolTeach', ['*'], compact('user_id'));
      if ($result === NULL) {
        DB::insert('xonSchoolTeach', compact('uid', 'user_id', 'sch_id'));
      }
      // 返回信息
      $this->json(['code' => 0, 'data' => []]);
    }, function ($error) {
      $this->json($error);
    });
  }
}