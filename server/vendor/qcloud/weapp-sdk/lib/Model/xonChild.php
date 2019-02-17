<?php

namespace QCloud_WeApp_SDK\Model;

class xonChild extends cAppinfo
{
  protected static $tableName = 'xonChild';
  protected static $tableTitle = '孩子表';

  public static function add($idc, $name)
  {
    $id = $idc;
    // 检测身份证
    x5on::checkIdc($idc, 7, 18);
    $res = self::getById($id);
    if ($res === null) {
      // 添加孩子
      $uid = x5on::getUid();
      self::insert(compact('id', 'uid', 'idc', 'name'));
    }
    return self::getById($id);
  }
}
