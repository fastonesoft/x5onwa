<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonUserGroupSchool;

class mvvUserGroupSchool
{

  // 检测是否学校管理
  public static function schAdmin($user_id, $success)
  {
    // 查找用户对应学校，有多重设置，返回第一个
    $checked = 1;
    xonUserGroupSchool::checkByCustom(compact('user_id', 'checked'), '不属于任何学校，无法操作');

    $group_id = x5on::GROUP_ADMIN_SCHOOL;
    $user_sch_group = xonUserGroupSchool::checkByCustom(compact('group_id', 'user_id', 'checked'), '不是学校管理员，无法操作');
    call_user_func($success, $user_sch_group);
  }

}
