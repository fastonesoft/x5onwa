<?php
namespace QCloud_WeApp_SDK\Model;

use Guzzle\Cache\NullCacheAdapter;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Constants;
use \Exception;

class xonRole
{
  /**
   * 标志出权限列表中我的权限
   * @param $roles        权限列表
   * @param $myroles      我的权限
   * @return mixed        权限列表中我的权限
   */
  public static function sign ($roles, $myroles) {
    // 按照权限列表，逐一检测是否有权限：
    // 有，则标志为1，没有标志为0
    foreach ($roles as $k => $v) {
      $has_role = 0;
      foreach ($myroles as $value) {
        if ($v->id === $value->role_id) {
          $has_role = 1;
          break;
        }
      }
      $roles[$k]->has_role = $has_role;
    }
    return $roles;
  }
}
