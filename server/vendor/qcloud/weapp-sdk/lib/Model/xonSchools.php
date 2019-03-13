<?php
namespace QCloud_WeApp_SDK\Model;

class xonSchools extends cAppinfo
{
  protected static $tableName = 'xonSchools';
  protected static $tableTitle = '集团列表';

  public static function add($code, $name, $full_name, $area_id) {
    $id = $area_id . $code;
    self::existByIdCustom($id, '集团编号已存在');

    $uid = x5on::getUid();
    $user_id = null;
    return self::insert(compact('id', 'uid', 'code', 'name', 'full_name', 'area_id', 'user_id'));
  }
}