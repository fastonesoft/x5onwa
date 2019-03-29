<?php
namespace QCloud_WeApp_SDK\Model;

class xonClassDivi extends cAppinfo
{
  protected static $tableName = 'xonClassDivi';
  protected static $tableTitle = '班级分管';

  public static function add($cls_id, $user_id)
  {
    $uid = x5on::getUid();
    $res = self::getBy(compact('cls_id', 'user_id'));
    if ($res === NULL) {
      self::insert(compact('uid', 'cls_id', 'user_id'));
    }
  }

}