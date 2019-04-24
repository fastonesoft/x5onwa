<?php
namespace QCloud_WeApp_SDK\Model;

class xonSchEdit extends cAppinfo
{
  protected static $tableName = 'xonSchEdit';
  protected static $tableTitle = '学校学制';

  public static function add($sch_id, $edu_id)
  {
    $id = $sch_id . x5on::setw($edu_id, 2);
    self::existById($id);

    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'sch_id', 'edu_id'));
    return xovSchEdit::getById($id);
  }

}