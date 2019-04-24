<?php
namespace QCloud_WeApp_SDK\Model;

class xonGrade extends cAppinfo
{
  protected static $tableName = 'xonGrade';
  protected static $tableTitle = '学校年级';

  public static function add($sch_id, $years_id, $steps_id, $edus_id) {
    self::existByCustom(compact('steps_id', 'edus_id'), '当前分级、学制设置已存在');

    $uid = x5on::getUid();
    $id = $steps_id . str_replace('', $sch_id, $edus_id);
    self::insert(compact('id', 'uid', 'years_id', 'steps_id', 'edus_id'));
    return xovGrade::getByUid($uid);
  }
}