<?php
namespace QCloud_WeApp_SDK\Model;

class xonSysKey extends cAppinfo
{
  protected static $tableName = 'xonSysKey';
  protected static $tableTitle = '系统键值';

  public static function add($id, $name)
  {
    $uid = x5on::getUid();
    self::existByIdCustom($id, '系统键值已存在');
    self::existByIdCustom($name, '系统键值名称已存在');

    self::insert(compact('id', 'uid', 'name'));
    return xonSysKey::getById($id);
  }

}