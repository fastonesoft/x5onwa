<?php
namespace QCloud_WeApp_SDK\Model;

class xonSchYear extends cAppinfo
{
  protected static $tableName = 'xonSchYear';
  protected static $tableTitle = '学校年度';

  public static function add($sch_id, $year, $is_current_string)
  {
    $id = $sch_id . $year;
    self::existById($id);

    $is_current = x5on::getBool($is_current_string);
    if ($is_current) {
      // 清除原来的当前年度
      $is_current = 0;
      self::setsBy(compact('is_current'), compact('sch_id'));
      $is_current = 1;
    }
    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'sch_id', 'year', 'is_current'));
    return xovSchYear::getById($id);
  }

}