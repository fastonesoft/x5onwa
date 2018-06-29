<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonUserGroup
{
  /**
   * 用户权限组首次添加
   * @param     $user_id      用户编号
   * @param     $group_id     权限组编号
   * @throws Exception
   */
  public static function first ($user_id, $group_id) {
    $uid = bin2hex(openssl_random_pseudo_bytes(16));

    // 只要用户已经有权限组，不再添加
    $res = dbs::row('xonUserGroup', ['*'], compact('user_id'));
    if ($res === NULL) {
      dbs::insert('xonUserGroup', compact('user_id', 'group_id', 'uid'));
    }
  }

  /**
   * 用户权限组添加
   * @param     $user_id      用户编号
   * @param     $group_id     用户权限组
   * @throws Exception
   */
  public static function insert ($user_id, $group_id) {
    $uid = bin2hex(openssl_random_pseudo_bytes(16));

    // 如果用户已经进了该组，不再添加
    $res = dbs::row('xonUserGroup', ['*'], compact('user_id'), 'and', compact('group_id'));
    if ($res === NULL) {
      dbs::insert('xonUserGroup', compact('user_id', 'group_id', 'uid'));
    }
  }

  public static function getUserMaxGroupId ($user_id) {
    $group = dbs::row('xovUserGroup', ['group_id'], compact('user_id'), 'and', 'order by group_id desc limit 1');
    return $group === null ? 0 : $group->group_id;
  }
}
