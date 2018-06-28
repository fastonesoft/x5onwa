<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Model;

class Rolegroup extends CI_Controller
{
  /**
   * 权限分组
   */
  const role_name = 'rolegroup';
  public function index() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 分组列表
      $result = DB::select('xonGroup', ['id', 'name'], '', 'and', 'order by id');
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function role() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 获取参数
      $param = $_POST;
      // 分组权限
      $group_id = $param['group_id'];
      // 当前分组，对应权限
      $group_roles = DB::select('xonGroupRole', ['role_id'], compact('group_id'));
      // 权限列表
      $roles = DB::select('xonRole', ['id', 'title']);
      // 处理当前分组权限
      $result = Model\xonRoleGroup::work($roles, $group_roles);
      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }

  public function update() {
    Model\xonLogin::check(self::role_name, function ($user) {
      // 获取参数
      $param = $_POST;
      $result = Model\xonRoleGroup::update($param);

      // 返回信息
      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}