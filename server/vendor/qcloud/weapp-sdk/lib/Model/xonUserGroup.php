<?php

namespace QCloud_WeApp_SDK\Model;

class xonUserGroup extends cAppinfo
{
  protected static $tableName = 'xonUserGroup';
  protected static $tableTitle = '用户分组';

  public static function add($user_id, $group_id)
  {
    if ($group_id >= x5on::GROUP_NORMAL_MAX) throw new \Exception('普通用户权限分组有上限');

    $res = self::getBy(compact('user_id', 'group_id'));
    if ($res === null) {
      $uid = x5on::getUid();
      self::insert(compact('user_id', 'group_id', 'uid'));
    }
  }

  // 添加临时用户，有权限记录，不再加
  public static function addTemp($user_id, $group_id)
  {
    $res = self::getBy(compact('user_id'));
    if ($res === null) {
      self::add($user_id, $group_id);
    }
  }

  public static function addArea($user_id, $group_id)
  {
    if ($group_id > x5on::GROUP_ADMIN_AREA) throw new \Exception('地区管理权限分组有上限');

    $res = self::getBy(compact('user_id', 'group_id'));
    if ($res === null) {
      $uid = x5on::getUid();
      self::insert(compact('user_id', 'group_id', 'uid'));
    }
  }

  public static function addSchs($user_id, $group_id)
  {
    if ($group_id > x5on::GROUP_ADMIN_SCHOOLS) throw new \Exception('集团管理权限分组有上限');

    $res = self::getBy(compact('user_id', 'group_id'));
    if ($res === null) {
      $uid = x5on::getUid();
      self::insert(compact('user_id', 'group_id', 'uid'));
    }
  }

  public static function addSch($user_id, $group_id)
  {
    if ($group_id > x5on::GROUP_ADMIN_SCHOOL) throw new \Exception('学校管理权限分组有上限');

    $res = self::getBy(compact('user_id', 'group_id'));
    if ($res === null) {
      $uid = x5on::getUid();
      self::insert(compact('user_id', 'group_id', 'uid'));
    }
  }
}
