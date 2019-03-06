<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGroup;
use QCloud_WeApp_SDK\Model\xonUserGroup;

class mvvGroup
{

  public static function less($user_id)
  {
    // 返回小于当前用户组权限的权限列表
    $id = xonUserGroup::max('group_id', compact('user_id'));
    $groups = xonGroup::customs(compact('id'), '<');

    // 返回学校用户组列表
    $result = [];
    foreach ($groups as $group) {
      $group->id > x5on::GROUP_NORMAL_MAX && array_push($result, $group);
    }
    return $result;
  }

}
