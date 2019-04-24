<?php
namespace QCloud_WeApp_SDK\Model;

class xonSchStep extends cAppinfo
{
  protected static $tableName = 'xonSchStep';
  protected static $tableTitle = '学校分级';

  public static function add($name, $code, $years_id, $graduated_year, $can_recruit_string, $graduated_string)
  {
    $id = $years_id . $code;
    self::existById($id);

    $uid = x5on::getUid();
    $can_recruit = x5on::getBool($can_recruit_string);
    $graduated = x5on::getBool($graduated_string);
    self::insert(compact('id', 'uid', 'name', 'code', 'years_id', 'graduated_year', 'can_recruit', 'graduated'));
    return xovSchStep::getById($id);
  }

}