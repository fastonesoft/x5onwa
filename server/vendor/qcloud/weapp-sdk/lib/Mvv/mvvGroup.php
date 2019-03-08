<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGroup;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xonUserGroup;
use QCloud_WeApp_SDK\Model\xonUserGroupSchool;

class mvvGroup
{

  public static function less($user_id)
  {
    $result = [];
    // 系统管理
    self::admin_area($user_id, x5on::GROUP_ADMIN, function ($usergroup) use (&$result) {
      $result = self::groupLess($usergroup->group_id);
    });
    if (count($result) > 0) return $result;

    // 地区管理
    self::admin_area($user_id, x5on::GROUP_ADMIN_AREA, function ($usergroup) use (&$result) {
      $result = self::groupLess($usergroup->group_id);
    });
    if (count($result) > 0) return $result;

    // 学校管理
    self::adminSchool($user_id, x5on::GROUP_ADMIN_SCHOOL, function ($usergroup) use (&$result) {
      $result = self::groupLess($usergroup->group_id);
    });
    return $result;
  }

  // 获取当前用户组以下的学校组
  public static function groupLess($my_group_id)
  {
    $id = $my_group_id;
    $res = [];
    $groups = xonGroup::customs(compact('id'), '<');

    foreach ($groups as $group) {
      $group->id > x5on::GROUP_NORMAL_MAX && array_push($res, $group);
    }
    return $res;
  }

  // 检测是否管理、区域管理
  public static function admin_area($user_id, $group_id, $success)
  {
    $usergroup = xonUserGroup::getBy(compact('group_id', 'user_id'));
    if ($usergroup !== null) {
      call_user_func($success, $usergroup);
    }
  }

  // 检测是否学校管理
  public static function adminSchool($user_id, $group_id, $success)
  {
    // 查找用户对应学校，有多重设置，返回第一个
    $checked = 1;
    $user = xonUserGroupSchool::checkByCustom(compact('user_id', 'checked'), '当前用户不属于任何学校，没有操作权限');
    $sch_id = $user->sch_id;

    $usergroup = xonUserGroupSchool::getBy(compact('group_id', 'user_id', 'sch_id'));
    if ($usergroup !== null) {
      call_user_func($success, $usergroup);
    }
  }

}
