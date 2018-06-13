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
    // 筛选数组
    $result = array_filter($roles, function ($role) {
        // 返回：有权限的 || 看得见的
        return $role->has_role || $role->can_show;
    });
    return $result;
  }

  /**
   * 更新权限列表中“显示”设置
   * @param $roles        变更列表
   * @throws Exception
   */
  public static function update ($roles) {
    // 计数
    $result = 0;
    foreach ($roles as $k => $v) {
      // 对象截取
      $uid = $k;
      $can_show = $v === 'true' ? 1 : 0;
      // 查询记录
      $res = DB::row('xonRole', ['*'], compact('uid', 'can_show'));
      if ($res === NULL) {
        // 更新记录
        DB::update('xonRole', compact('can_show'), compact('uid'));
        $result++;
      }
    }
    return $result;
  }
}
