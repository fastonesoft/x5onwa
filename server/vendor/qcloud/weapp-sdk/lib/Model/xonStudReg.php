<?php
namespace QCloud_WeApp_SDK\Model;

class xonStudReg extends cAppinfo
{
  protected static $tableName = 'xonStudReg';
  protected static $tableTitle = '学生注册';

  public static function add($user_id, $child_id, $sch_id, $edu_type_id, $steps_id) {
    // 检测是否超龄
    $edu_type = xonEduType::getById($edu_type_id);
    $begin = $edu_type->begin;
    $end = $edu_type->end;

    $child = xonChild::getById($child_id);
    $child_idc = $child->idc;
    x5on::checkIdc($child_idc, $begin, $end);

    // 报名检测
    xonStudReg::existByCustom(compact('child_id', 'sch_id'), '报名学校已记录，无需重复设置');
    xonStudReg::existByCustom(compact('child_id', 'edu_type_id'), '同一学段学校不得重复报名');

    $uid = x5on::getUid();
    // 默认为非指标生
    $stud_auth = 0;
    xonStudReg::insert(compact('uid', 'user_id', 'child_id', 'sch_id', 'edu_type_id', 'steps_id', 'stud_auth'));

    return xovStudReg::getByUid($uid);
  }
}
