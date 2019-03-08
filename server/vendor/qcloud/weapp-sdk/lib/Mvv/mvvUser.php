<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonUser;
use QCloud_WeApp_SDK\Model\xonUserGroup;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovUserGroup;
use QCloud_WeApp_SDK\Model\xovUserGroupSchool;

class mvvUser
{

  /**
   * @param $user_id
   * @param $name
   * @param $mobil
   * @param $confirmed
   * @throws \Exception
   */
  public static function update($user_id, $name, $mobil, $confirmed)
  {
    // 检测手机号，是否存在；存在：看看用户名是不是自已，不是自己提示出错
    $user = xonUser::getBy(compact('mobil'));
    if ($user !== null) {
      if ($user->id !== $user_id) {
        throw new \Exception('手机号码已存在');
      }
    }
    // 手机号码不存在、存在，但是自己登记的，可以更新用户记录
    xonUser::setsById(compact('name', 'mobil', 'confirmed'), $user_id);
  }

  public static function fixed($user_id, $fixed)
  {
    xonUser::checkById($user_id);
    xonUser::setsById(compact('fixed'), $user_id);
  }

  /**
   * 可能要逐步放弃的功能
   * @param $user_id
   * @param $success_admin
   * @param $success_school
   * @throws \Exception
   */
  public static function admins($user_id, $success_admin, $success_school, $param = '')
  {
    $group_id = x5on::GROUP_ADMIN;
    $admin = xonUserGroup::getBy(compact('user_id', 'group_id'));
    if ($admin !== null) {
      // 系统管理员
      call_user_func($success_admin, $param);
    } else {
      // 学校管理员
      $group_id = x5on::GROUP_ADMIN_SCHOOL;
      xonUserGroup::checkByCustom(compact('user_id', 'group_id'), '不是学校管理员，不能操作');
      // 查询本校名单
      $sch_admin_user = xovUser::checkById($user_id);
      $sch_id = $sch_admin_user->sch_id;
      if ($sch_id === null) {
        throw new \Exception('未注册学校，不能操作');
      }
      call_user_func($success_school, $sch_admin_user, $param);
    }
  }



}
