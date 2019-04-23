<?php
namespace QCloud_WeApp_SDK\Model;

class xonSchStep extends cAppinfo
{
  protected static $tableName = 'xonSchStep';
  protected static $tableTitle = '学校分级';

  public static function add($name, $code, $years_id, $graded_year, $recruit_end, $graduated)
  {
    $id = $years_id . $code;
    self::existById($id);

    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'name', 'code', 'years_id', 'graded_year', 'recruit_end', 'graduated'));
    return xovSchStep::getById($id);
  }

}