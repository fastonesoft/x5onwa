<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as dbs;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonRoleGroup
{
  /**
   * @param $roles          权限列表
   * @param $group_roles    分组权限
   * @return mixed          分组权限列表
   */
  public static function work ($roles, $group_roles) {
    // 检测检测列表当中的权限，是否存在于分组表中
    foreach ($roles as $value) {
      $has_role = 0;
      foreach ($group_roles as $v) {
        // 存在，标识为：真
        if ($v->role_id === $value->id) {
          $has_role = 1;
          break;
        }
      }
      // 装配
      $value->has_role = $has_role;
    }
    return $roles;
  }

  /**
   * @param $roles       权限列表
   * @return int         变更记录条数
   */
  public static function update ($roles) {
    $result = 0;
    $group_id = $roles['group_id'];
    unset($roles['group_id']);
    foreach ($roles as $k => $v) {
      // 对象截取
      $role_id = $k;
      $has_role = $v === 'true' ? 1 : 0;
      $res = dbs::row('xonGroupRole', ['*'], compact('group_id', 'role_id'));
      // 有权限，没记录  => 添加
      if ($has_role && $res === NULL) {
        $result++;
        $uid = bin2hex(openssl_random_pseudo_bytes(16));
        dbs::insert('xonGroupRole', compact('group_id', 'role_id', 'uid'));
      }
      // 没权限，有记录 => 删除
      if (!$has_role && $res !== NULL) {
        $result++;
        $uid = $res->uid;
        dbs::delete('xonGroupRole', compact('uid'));
      }
    }
    return $result;
  }

  // 添加用户进组
  public static function add ($user_id, $group_id) {
    $res = dbs::row('xonUserGroup', ['*'], compact('user_id', 'group_id'));
    if ( $res === null ) {
      $uid = x5on::getUid();
      dbs::insert('xonUserGroup', compact('user_id', 'group_id', 'uid'));
    }
  }
}
