<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Mvv;
use QCloud_WeApp_SDK\Model;

class Rolegroup extends CI_Controller
{
  /**
   * 权限分组（系统管理员权限）
   */
  const role_name = 'rolegroup';
  public function index()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        // 当前用户最大权限组
        $user_id = $userinfor->unionId;
        $group_id = Model\xonUserGroup::max('group_id', compact('user_id'));

        // 返回小于当前用户组权限的权限列表
//        $result = Model\xonGroup::customs(compact('group_id'), '<');
        $result = Model\xonGroup::gets();

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function role()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      try {
        $param = $_POST;
        $group_uid = $param['uid'];

        // 查询组编号
        $group = Model\xonGroup::checkByUid($group_uid);
        $group_id = $group->id;

        // 当前用户最大权限组
        $user_id = $userinfor->unionId;
        $my_group_id = Model\xonUserGroup::max('group_id', compact('user_id'));
        if ($group_id > $my_group_id) {
          throw new \Exception('无法设置高阶权限组权限');
        }

        // 组装分组权限
        $roles = Model\xonRole::gets();
        $group_roles = Model\xonGroupRole::getsBy(compact('group_id'));

        $result = Mvv\mvvGroupRole::roles($roles, $group_roles);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }

  public function update()
  {
    Mvv\mvvLogin::check(self::role_name, function ($userinfor) {
      $param = $_POST;

      // 根据参数变更分组权限
      $result = Mvv\mvvGroupRole::update($param);

      $this->json(['code' => 0, 'data' => $result]);
    }, function ($error) {
      $this->json($error);
    });
  }
}