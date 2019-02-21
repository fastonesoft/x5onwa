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
        /**
         * 查询当前用户所能够设置的权限分组的权限
         */
        $user_id = $userinfor->unionId;
        $result = Mvv\mvvGroup::less($user_id);

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
        /**
         * 根据分组编号，查询分组对应的权限设置
         */
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
      try {
        /**
         * 根据参数变更分组权限
         */
        $param = $_POST;
        $result = Mvv\mvvGroupRole::update($param);

        $this->json(['code' => 0, 'data' => $result]);
      } catch (Exception $e) {
        $this->json(['code' => 1, 'data' => $e->getMessage()]);
      }
    }, function ($error) {
      $this->json($error);
    });
  }
}