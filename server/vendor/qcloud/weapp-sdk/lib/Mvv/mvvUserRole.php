<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonRole;

class mvvUserRole
{
  /**
   * 标志出权限列表中我的权限
   * @param $roles        权限列表
   * @param $myroles      我的权限
   * @return mixed        权限列表
   */
  public static function sign($roles, $myroles)
  {
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
  public static function update($roles)
  {
    // 计数
    $result = 0;
    foreach ($roles as $k => $v) {
      // 对象截取
      $uid = $k;
      $can_show = $v === 'true' ? 1 : 0;

      $res = xonRole::getBy(compact('uid', 'can_show'));
      if ($res === null) {
        xonRole::setsByUid(compact('can_show'), $uid);
        $result++;
      }
    }
    return $result;
  }







  /**
   * @param $roles          权限列表
   * @param $group_roles    分组权限
   * @return mixed          分组权限列表
   */
  public static function work($roles, $group_roles)
  {
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
  public static function update1($roles)
  {
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



}
