<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGroup;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xonUserGroup;
use QCloud_WeApp_SDK\Model\xonUserGroupSchool;

class mvvGroup
{

  // 获取当前用户组以下的学校组
  public static function groupLess($my_group_id)
  {
    $id = $my_group_id;
    $res = [];
    $groups = xonGroup::customs(compact('id'), '<');

    foreach ($groups as $group) {
      $group->id >= x5on::GROUP_NORMAL_MAX && array_push($res, $group);
    }
    return $res;
  }

  public static function lessBetween($begin_group_id, $end_group_id) {
    $id = $end_group_id;
    $res = [];
    $groups = xonGroup::customs(compact('id'), '<');

    foreach ($groups as $group) {
      $group->id >= $begin_group_id && array_push($res, $group);
    }
    return $res;
  }

}
