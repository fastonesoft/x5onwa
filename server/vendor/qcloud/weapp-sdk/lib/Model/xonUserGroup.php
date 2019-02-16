<?php
namespace QCloud_WeApp_SDK\Model;

use \Exception;

class xonUserGroup extends cAppinfo
{
  protected static $tableName = 'xonUserGroup';
  protected static $tableTitle = '用户分组';

  public static function add ($user_id, $group_id) {
    $uid = x5on::getUid();
    self::insert(compact('user_id', 'group_id', 'uid'));
  }

  public static function addTemp ($user_id, $group_id) {
    $res = self::getBy(compact('user_id'));
    if ($res === null) {
      self::add($user_id, $group_id);
    }
  }



  public static function getUserMaxGroupId ($user_id) {
    $group = dbs::row('xovUserGroup', ['group_id'], compact('user_id'), 'and', 'order by group_id desc');
    return $group === null ? 0 : $group->group_id;
  }
}
