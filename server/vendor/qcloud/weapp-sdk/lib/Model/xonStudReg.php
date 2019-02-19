<?php
namespace QCloud_WeApp_SDK\Model;

class xonStudReg extends cAppinfo
{
  protected static $tableName = 'xonStudReg';
  protected static $tableTitle = '学生注册';

  public static function add($user_id, $child_id, $sch_id, $edu_type_id) {
    xonStudReg::existByCustom(compact('child_id', 'sch_id'), '报名学校已记录，无需重复设置');
    xonStudReg::existByCustom(compact('child_id', 'edu_type_id'), '同一学段学校不得重复报名');

    $checked = 0;
    $uid = x5on::getUid();
    xonStudReg::insert(compact('uid', 'user_id', 'child_id', 'sch_id', 'edu_type_id', 'checked'));

    return xovStudReg::getByUid($uid);
  }
}
