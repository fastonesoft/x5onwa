<?php

namespace QCloud_WeApp_SDK\Model;

class xonChild extends cAppinfo
{
  protected static $tableName = 'xonChild';
  protected static $tableTitle = '孩子表';

  // 新的孩子信息，直接添加
  // 根据身份证号确认是否为新的孩子信息
  public static function add($idc, $name)
  {
    // 检测身份证
    x5on::checkIdc($idc, 7, 18);
    $res = self::getBy(compact('idc'));
    if ($res === null) {
      // 添加孩子
      $id = $idc;
      $uid = x5on::getUid();
      self::insert(compact('id', 'uid', 'idc', 'name'));
      //
      return self::getById($id);
    }
    return $res;
  }
}
