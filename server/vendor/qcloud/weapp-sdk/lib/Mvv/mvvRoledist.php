<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGroup;
use QCloud_WeApp_SDK\Model\xonUser;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xonUserGroup;
use QCloud_WeApp_SDK\Model\xovUserGroup;

class mvvRoledist
{

  public static function school($user_id) {

  }

  public static function user($user_id, $name)
  {
    $group_id = x5on::GROUP_ADMIN_VALUE;
    $admin = xonUserGroup::getBy(compact('user_id', 'group_id'));
    if ($admin !== null) {
      // 系统管理员，可以分配任意权限组
      $result = xovUser::likes(compact('name'));
    } else {
      // 学校管理员
      // 没有注册学校，报错
      // 注册，返回学校老师查询信息
      $group_id = x5on::GROUP_SCHOOL_ADMIN_VALUE;
      xonUserGroup::checkByCustom(compact('user_id', 'group_id'), '不是管理员，不能查询教师名单');
      // 查询本校老师名单
      $sch_admin_user = xovUser::checkById($user_id);
      $sch_id = $sch_admin_user->sch_id;
      if ($sch_id === null) {
        throw new \Exception('未注册学校，不能查询教师名单');
      }
      $result = xovUser::likesBy(compact('sch_id'), compact('name'));
    }
    return $result;
  }

  public static function add($user_uid, $group_uid) {
    $user = xonUser::checkByUid($user_uid);
    $group = xonGroup::checkByUid($group_uid);
    $user_id = $user->id;
    $group_id = $group->id;
    xonUserGroup::existByCustom(compact('user_id', 'group_id'), '用户分组权限已设置');

    $uid = x5on::getUid();
    xonUserGroup::insert(compact('uid', 'user_id', 'group_id'));

    return xovUserGroup::getsBy(compact('group_id'));
  }

  public static function del($uid) {
    $usergroup = xonUserGroup::checkByUid($uid);
    $group_id = $usergroup->group_id;

    xonUserGroup::delByUid($uid);
    return xovUserGroup::getsBy(compact('group_id'));
  }

  /**
   * @param $user_id
   * @param $group_uid
   * @return array
   * @throws \Exception
   */
  public static function member($user_id, $group_uid) {






    $result = [];
    mvvUser::admins($user_id, function ($group_uid) use ($result) {
      $group = xonGroup::checkByUid($group_uid);
      $group_id = $group->id;
      $result =  xovUserGroup::getsBy(compact('group_id'));
      return $result;
    }, function () {

    }, $group_uid);
    return $result;
  }

  public static function memfind($group_uid, $user_name) {
    $group = xonGroup::checkByUid($group_uid);
    $group_id = $group->id;
    return xovUserGroup::likesBy(compact('group_id'), compact('user_name'));
  }

}
