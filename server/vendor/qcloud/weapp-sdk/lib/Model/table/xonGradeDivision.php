<?php
namespace QCloud_WeApp_SDK\Model;

use QCloud_WeApp_SDK\Mysql\Mysql as dbs;

class xonGradeDivision
{
  public static function getSchoolTeach ($sch_id, $user_name) {
    return dbs::select('xovSchoolTeach', ['*'], compact('sch_id', 'user_name'));
  }

  public static function setDivision ($user_id, $cls_ids) {
    // 取第一个，查询年级信息
    $cls_ids = explode(',', $cls_ids);
    $id = $cls_ids[0];
    $class = dbs::row('xonClass', ['*'], compact('id'));
    $grade_id = $class->grade_id;
    // 交换学生更改班级
    foreach ($cls_ids as $cls_id) {
      $uid = x5on::getUid();
      dbs::insert('xonGradeDivision', compact('uid', 'grade_id', 'cls_id', 'user_id'));
    }
    return $grade_id;
  }

  public static function removeDivision ($uid) {
    $res = dbs::row('xonGradeDivision', ['*'], compact('uid'));
    if ( $res !== null ) {
      dbs::delete('xonGradeDivision', compact('uid'));
      return $grade_id = $res->grade_id;
    }
  }

}
