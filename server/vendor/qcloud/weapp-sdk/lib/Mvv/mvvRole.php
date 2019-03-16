<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonRole;

class mvvRole
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
    $result = [];
    foreach ($roles as $k => $v) {
      $has_role = 0;
      foreach ($myroles as $value) {
        if ($v->id === $value->role_id) {
          $has_role = 1;
          break;
        }
      }
      $roles[$k]->has_role = $has_role;
      if ($roles[$k]->has_role || $roles[$k]->can_show) {
        array_push($result, $roles[$k]);
      }
    }
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
    foreach ($roles as $uid => $v) {
      // 对象截取
      $can_show = $v === 'true' ? 1 : 0;

      $res = xonRole::getBy(compact('uid', 'can_show'));
      if ($res === null) {
        xonRole::setsByUid(compact('can_show'), $uid);
        $result++;
      }
    }
    return $result;
  }

}
