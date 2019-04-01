<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonRole;
use QCloud_WeApp_SDK\Model\xovUserRole;
use QCloud_WeApp_SDK\Model\xovUserRoleSchool;
use QCloud_WeApp_SDK\Model\xovUserSchoolAll;

class mvvRole
{
  /**
   * 标志出权限列表中我的权限
   * @param $roles        权限列表
   * @param $myroles      我的权限
   * @return mixed        权限列表
   */
  public static function sign($roles, $myroles, $myroleschs)
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
      foreach ($myroleschs as $value) {
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

  // 构造用户、学校权限列表
  public static function cores($user_id) {
    $roles = xonRole::gets();
    $myroles = xovUserRole::getsBy(compact('user_id'));
    // 查询用户学校
    $is_current = 1;
    $userschool = xovUserSchoolAll::getBy(compact('user_id', 'is_current'));
    $sch_id = $userschool ? $userschool->sch_id : null;
    // 用户学校对应权限
    $myroleschs = xovUserRoleSchool::getsBy(compact('user_id', 'sch_id'));

    return self::sign($roles, $myroles, $myroleschs);
  }

  // 检测是否有权限
  public static function checkRole($user_id, $role_name) {
    $cores = self::cores($user_id);
    $res = false;
    foreach ($cores as $role) {
      if ($role->name === $role_name) {
        $res = true;
        break;
      }
    }
    if (!$res) throw new \Exception('没有操作权限');
  }

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
