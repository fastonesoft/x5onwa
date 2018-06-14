<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Roledist extends CI_Controller
{
  /**
   * 权限分配
   * 根据帐号不同权限，查询不同用户
   * 系统管理员，查询所有用户
   * 学校管理员，查询所在学校用户
   */
  public function index() {
    Model\xonLogin::check(function ($user) {
      // 获取参数
      $param = $_POST;
      $name = $param["name"];

      $user_id = $user['unionId'];
      $group_id = Model\X5on::GROUP_ADMIN_VALUE;
      $res = DB::select('xonUserGroup', ['*'], compact('user_id', 'group_id'));
      if (count($res) === 1) {
        // 系统管理员
        // 可以对所有人，分组
        $result = DB::select('xonUser', ['id', 'name', 'nick_name', '0 as checked'], compact('name'));
      } else {
        // 学校管理员
        // 是否？
        //   是：只分配其所在学校
        $group_id = Model\X5on::GROUP_SCHOOL_ADMIN_VALUE;
        $usergroup = DB::select('xonUserGroup', ['*'], compact('user_id', 'group_id'));
        // 管理员所在学校
        $school = DB::select('xovSchoolTeach', ['sch_id'], compact('user_id'));
        if (count($usergroup) === 1 && count($school) === 1) {
          $sch_id = $school[0] -> sch_id;
          $result = DB::select('xovSchoolTeach', ['user_id as id', 'user_name as name', 'nick_name', '0 as checked'], compact('sch_id'));
        } else {
          // 否：不返回数据
          $result = [];
        }
      }
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}