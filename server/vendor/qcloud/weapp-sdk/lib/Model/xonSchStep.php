<?php
namespace QCloud_WeApp_SDK\Model;

class xonSchStep extends cAppinfo
{
  protected static $tableName = 'xonSchStep';
  protected static $tableTitle = '学校分级';

  public static function add($name, $code, $years_id, $graded_year, $recruit_end_string, $graduated_string)
  {
    $id = $years_id . $code;
    self::existById($id);

    $uid = x5on::getUid();
    $recruit_end = x5on::getBool($recruit_end_string);
    $graduated = x5on::getBool($graduated_string);
    self::insert(compact('id', 'uid', 'name', 'code', 'years_id', 'graded_year', 'recruit_end', 'graduated'));
    return xovSchStep::getById($id);
  }

}