<?php

namespace QCloud_WeApp_SDK\Model;

class xonArea extends cAppinfo
{
  protected static $tableName = 'xonArea';
  protected static $tableTitle = '地区列表';

  public static function add($id, $name)
  {
    self::existByIdCustom($id, '地区编号已存在');
    self::existByCustom(compact('name'), '地区名称已存在');
    //
    $uid = x5on::getUid();
    $user_id = null;
    self::insert(compact('id', 'uid', 'name', 'user_id'));
    return xovAreas2Dist::getByUid($uid);
  }
}