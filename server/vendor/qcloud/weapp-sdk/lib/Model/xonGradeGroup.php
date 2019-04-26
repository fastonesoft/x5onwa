<?php

namespace QCloud_WeApp_SDK\Model;

class xonGradeGroup extends cAppinfo
{
  protected static $tableName = 'xonGradeGroup';
  protected static $tableTitle = '年级分组';

  public static function add($grade_id, $name) {
    $max_id = self::max('id', compact('grade_id'));
    $id = x5on::getMaxId($max_id, $grade_id, 2);

    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'grade_id', 'name'));
    return self::getByUid($uid);
  }

}
