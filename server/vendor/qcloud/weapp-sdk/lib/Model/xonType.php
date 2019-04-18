<?php
namespace QCloud_WeApp_SDK\Model;

class xonType extends cAppinfo
{
  protected static $tableName = 'xonType';
  protected static $tableTitle = '权限分类';

  public static function add($id, $name) {
    self::existByIdCustom($id, '分类编号已存在');
    self::existByCustom(compact('name'), '分类名称已存在');
    //
    $uid = x5on::getUid();
    return self::insert(compact('id', 'uid', 'name'));
  }
}