<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonFormField;
use QCloud_WeApp_SDK\Model\xonFormValue;
use QCloud_WeApp_SDK\Model\xonStudReg;
use QCloud_WeApp_SDK\Model\xovFormField;
use QCloud_WeApp_SDK\Model\xovFormUser;
use QCloud_WeApp_SDK\Model\xovFormValue;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovStudReg;
use QCloud_WeApp_SDK\Model\xovUserChilds;

class mvvRegGroup
{

  // 学校分级
  public static function step($sch_user_id) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      // 可以招生的学校分级
      $can_recruit = 1;
      $result = xovSchStep::getsBy(compact('sch_id', 'can_recruit'));
    });
    return $result;
  }

  // 报名学生查询
  public static function stud($sch_user_id, $steps_id, $child_name) {
    $result = [];
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, $child_name, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 只能查询审核通过的学生
      $passed = 1;
      $result = xovStudReg::likesBy(compact('steps_id', 'passed'), compact('child_name'));
    });
    return $result;
  }

  // 提交分组
  public static function group($sch_user_id, $steps_id, $group_name, $stud_reg_uid) {
    $result = null;
    mvvUserSchoolGroup::schUser($sch_user_id, function ($user_sch_group) use ($steps_id, $group_name, $stud_reg_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 四、查看分组最大值
      $ord = xonStudReg::max('group_ord', compact('steps_id', 'group_name'));
      $group_ord = x5on::getMaxId($ord, '', 3);

      // 五、确认分组
      xonStudReg::setsByUid(compact('group_name', 'group_ord'), $stud_reg_uid);
      $result = xovStudReg::getByUid($stud_reg_uid);
    });
    return $result;
  }


}
