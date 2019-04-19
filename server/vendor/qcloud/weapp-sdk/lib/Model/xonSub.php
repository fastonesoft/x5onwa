<?php
namespace QCloud_WeApp_SDK\Model;

class xonSub extends cAppinfo
{
  protected static $tableName = 'xonSub';
  protected static $tableTitle = '学科设置';

  public static function add($id, $name, $short) {
    self::existByIdCustom($id, '学科编号已存在');
    self::existByCustom(compact('name'), '学科名称已存在');
    self::existByCustom(compact('short'), '学科简称已存在');
    //
    $uid = x5on::getUid();
    self::insert(compact('id', 'uid', 'name', 'short'));
    return self::getByUid($uid);
  }

}