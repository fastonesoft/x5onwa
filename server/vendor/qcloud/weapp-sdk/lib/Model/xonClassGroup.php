<?php

namespace QCloud_WeApp_SDK\Model;

class xonClassGroup extends cAppinfo
{
  protected static $tableName = 'xonClassGroup';
  protected static $tableTitle = '班级分组';

  public static function add($grade_group_id, $cls_id) {
    self::existByCustom(compact('grade_group_id', 'cls_id'), '当前班级分组已存在');

    $uid = x5on::getUid();
    self::insert(compact('uid', 'grade_group_id', 'cls_id'));
    return self::getByUid($uid);
  }

  public static function adds($grade_group_id, $cls_uids) {
    return 1;
  }

}
