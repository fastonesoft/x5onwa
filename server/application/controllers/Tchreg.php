<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Tchreg extends CI_Controller {
  /**
   * 不是教师的用户
   * 根据姓名查询出不是教师的用户列表
   */
  const role_name = 'tchreg';
  public function index() {
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      try {
        $param = $_POST;
        $name = $param['name'];
        $result = DB::select('xovUserNotTeach', ['*'], compact('name'));

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
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
    Mvv\mvvLogin::check(self::role_name, function ($user) {
      $user_id = $user['unionId'];
      $group_id = Model\x5on::GROUP_ADMIN_VALUE;
      $result = DB::select('xonUserGroup', ['*'], compact('user_id', 'group_id'));
      // 检测是否：系统管理员
      if (count($result) === 1) {
        // 显示学校列表
        $result = DB::select('xonSchool', ['id as sch_id', 'name as sch_name']);
      } else {
        // 检查注册学校
        $result = DB::select('xovSchoolTeach', ['sch_id', 'sch_name'], compact('user_id'));
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
    Mvv\mvvLogin::check(self::role_name, function ($user) {
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