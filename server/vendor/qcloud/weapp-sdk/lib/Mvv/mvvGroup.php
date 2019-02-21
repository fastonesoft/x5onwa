<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonGroup;
use QCloud_WeApp_SDK\Model\xonUserGroup;

class mvvGroup
{

  public static function less($user_id) {
    // 返回小于当前用户组权限的权限列表
    $id = Model\xonUserGroup::max('group_id', compact('user_id'));
    return Model\xonGroup::customs(compact('id'), '<');
  }

}
