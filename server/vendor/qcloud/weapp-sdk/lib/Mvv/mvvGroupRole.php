<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGroup;
use QCloud_WeApp_SDK\Model\xonGroupRole;
use QCloud_WeApp_SDK\Model\xonRole;

class mvvGroupRole
{

  /**
   * @param $roles          权限列表
   * @param $group_roles    分组权限
   * @return mixed          分组权限列表
   */
  public static function roles($roles, $group_roles)
  {
    // 检测检测列表当中的权限，是否存在于分组表中
    foreach ($roles as $role) {
      $has_role = 0;
      foreach ($group_roles as $group_role) {
        // 存在，标识为：真
        if ($group_role->role_id === $role->id) {
          $has_role = 1;
          break;
        }
      }
      // 装配
      $role->has_role = $has_role;
    }
    return $roles;
  }

  /**
   * @param $group_uid  分组编号
   * @param $roles      权限列表
   * @return int        变更记录
   */
  public static function update($group_uid, $group_json)
  {
    $result = 0;
    $group = xonGroup::checkByUid($group_uid);
    $group_id = $group->id;

    $groups = json_decode($group_json);
    // 设置权限记录
    foreach ($groups as $uid => $has_role) {
      $role = xonRole::checkByUid($uid);
      $role_id = $role->id;

      $group_role = xonGroupRole::getBy(compact('group_id', 'role_id'));
      if ($group_role !== null && !$has_role) {
        // 有记录，没权限，删除
        $result++;
        $uid = $group_role->uid;
        xonGroupRole::delByUidCustom($uid);
      }
      if ($group_role === null && $has_role) {
        // 没记录，有权限，添加
        $result++;
        $uid = x5on::getUid();
        xonGroupRole::insert(compact('group_id', 'role_id', 'uid'));
      }
    }
    return $result;
  }

}
