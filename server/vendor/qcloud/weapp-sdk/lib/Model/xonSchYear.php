<?php
namespace QCloud_WeApp_SDK\Model;

class xonSchYear extends cAppinfo
{
  protected static $tableName = 'xonSchYear';
  protected static $tableTitle = '学校年度';

  public static function add($sch_id, $year, $current_year_string)
  {
    $id = $sch_id . $year;
    self::existById($id);

    $current_year = x5on::getBool($current_year_string);
    if ($current_year) {
      // 清除原来的当前年度
      $current_year = 0;
      self::setsBy(compact('current_year'), compact('sch_id'));
      $current_year = 1;
    }
    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'sch_id', 'year', 'current_year'));
    return xovSchYear::getById($id);
  }

}