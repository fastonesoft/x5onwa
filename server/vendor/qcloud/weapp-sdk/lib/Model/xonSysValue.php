<?php
namespace QCloud_WeApp_SDK\Model;

class xonSysValue extends cAppinfo
{
  protected static $tableName = 'xonSysValue';
  protected static $tableTitle = '系统键值对';

  public static function add($key_id, $value, $valuex)
  {
    self::existByCustom(compact('key_id', 'value'), '系统键值对已存在');

    $max_id = self::max('id', compact('key_id'));
    $id = x5on::getMaxId($max_id, $key_id, 4);
    $uid = x5on::getUid();

    self::insert(compact('id', 'uid', 'key_id', 'value', 'valuex'));
    return xonSysValue::getById($id);
  }

}