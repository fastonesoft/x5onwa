<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonGroup;
use QCloud_WeApp_SDK\Model\xonUserGroup;

class mvvGroup
{

  public static function less($user_id) {
    // 返回小于当前用户组权限的权限列表
    $id = xonUserGroup::max('group_id', compact('user_id'));
    return xonGroup::customs(compact('id'), '<');
  }

}
