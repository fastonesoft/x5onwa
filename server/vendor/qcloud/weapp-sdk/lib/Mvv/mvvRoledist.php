<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonUserGroup;
use QCloud_WeApp_SDK\Model\xovUser;

class mvvRoledist
{

  public static function user($user_id, $name)
  {
    $group_id = x5on::GROUP_ADMIN_VALUE;
    $admin = xonUserGroup::getBy(compact('user_id', 'group_id'));
    if ($admin !== null) {
      // 系统管理员，可以分配非管理级的任意权限组
      $result = xovUser::likes(compact('name'));
    } else {
      // 学校管理员
      // 没有注册学校，报错
      // 注册，返回学校老师查询信息
      $group_id = x5on::GROUP_SCHOOL_ADMIN_VALUE;
      $sch_admin = xonUserGroup::getBy(compact('user_id', 'group_id'));
      if ($sch_admin !== null) {
        // 查询本校老师名单
        $sch_admin_user = xovUser::checkById($user_id);
        $sch_id = $sch_admin_user->sch_id;
        if ($sch_id === null) {
          throw new \Exception('未注册学校，不能分配教师权限');
        }
        $result = xovUser::likesBy(compact('sch_id'), compact('name'));
      }
    }
    return $result;
  }

  public static function add($user_id, $group_id) {
    $uid = bin2hex(openssl_random_pseudo_bytes(16));
    $res = DB::row('xonUserGroup', ['*'], compact('user_id', 'group_id'));
    if ($res === NULL) {
      $num++;
      DB::insert('xonUserGroup', compact('uid', 'user_id', 'group_id'));
    }
    // 返回信息：
    // 一、变更数目
    // 二、刷新列表
    $data = DB::select('xovUserGroup', ['uid', 'user_name', 'nick_name'], compact('group_id'));
    return (object)['num' => $num, 'data' => $data];
  }


  public static function group($sch_id, $group_id) {

  }

  public static function del() {

  }

  public static function member() {

  }

}
