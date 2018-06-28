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
  const role_name = 'roledist';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 获取参数
      $param = $_POST;
      $name = $param["name"];

      $user_id = $user['unionId'];
      $group_id = Model\x5on::GROUP_ADMIN_VALUE;
      $res = DB::select('xonUserGroup', ['*'], compact('user_id', 'group_id'));
      if (count($res) === 1) {
        // 系统管理员
        // 可以对所有人，分组
        $result = DB::select('xovUser', ['id', 'name', 'nick_name', '0 as checked'], compact('name'));
      } else {
        // 学校管理员
        // 是否？
        //   是：只分配其所在学校
        $group_id = Model\x5on::GROUP_SCHOOL_ADMIN_VALUE;
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

  /**
   * 请求部分用户组列表 >学生家长
   */
  public function group() {
    Model\xonLogin::check(self::role_name, function ($user) {
      $user_id = $user['unionId'];
      $user_max_group_id = Model\xonUserGroup::getUserMaxGroupId($user_id);
      $conditions = sprintf('id>%s and id<%s', Model\x5on::GROUP_STUDENT_PARENT, $user_max_group_id);
var_dump($conditions);
      $result = DB::select('xonGroup', ['id', 'name'], $conditions, 'and', 'order by id');

      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 添加用户进组
   */
  public function update() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 获取参数
      $param = $_POST;
      // 准备数据
      $num = 0;
      $user_id = $param['user_id'];
      $group_id = $param['group_id'];
      $uid = bin2hex(openssl_random_pseudo_bytes(16));
      $res = DB::row('xonUserGroup', ['*'], compact('user_id', 'group_id'));
      if ($res === NULL) {
        $num++;
        DB::insert('xonUserGroup', compact('uid', 'user_id', 'group_id'));
      }
      // 返回信息：
      // 一、变更数目
      // 二、刷新列表
      $data = DB::select('xovUserGroup', ['uid', 'user_name', 'nick_name'], compact('group_id'));
      $result = (object)['num' => $num, 'data' => $data];

      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 获取当前组下用户列表
   */
  public function groupuser() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 获取参数
      $param = $_POST;
      // 准备数据
      $group_id = $param['group_id'];
      $result = DB::select('xovUserGroup', ['uid', 'user_name', 'nick_name'], compact('group_id'));
      $result = Model\x5on::addIndex($result);
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  /**
   * 删除选中用户
   */
  public function deleteuser() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 获取参数
      $param = $_POST;
      $uid = $param['uid'];
      $result = DB::delete('xonUserGroup', compact('uid'));
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

}