<?php
namespace QCloud_WeApp_SDK\Model;

class xonUserSchool extends cAppinfo
{
  protected static $tableName = 'xonUserSchool';
  protected static $tableTitle = '用户注册学校';

  public static function add($user_id, $sch_id)
  {
    self::existByCustom(compact('user_id'), '已注册学校，不能重复操作');

    $uid = x5on::getUid();
    self::insert(compact('uid', 'user_id', 'sch_id'));
  }

}