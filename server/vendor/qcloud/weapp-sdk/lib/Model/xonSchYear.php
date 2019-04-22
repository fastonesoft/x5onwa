<?php
namespace QCloud_WeApp_SDK\Model;

class xonSchYear extends cAppinfo
{
  protected static $tableName = 'xonSchYear';
  protected static $tableTitle = '学校年度';

  public static function add($sch_id, $year, $is_current)
  {
    $id = $sch_id . $year;
    self::checkById($id);

    $uid = x5on::getUid();
    return self::insert(compact('id', 'uid', 'sch_id', 'year', 'is_current'));
  }

}