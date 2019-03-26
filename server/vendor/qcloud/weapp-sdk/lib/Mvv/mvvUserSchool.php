<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonSchool;
use QCloud_WeApp_SDK\Model\xonUserSchool;
use QCloud_WeApp_SDK\Model\xonUserSchoolGroup;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovUserSchool;

class mvvUserSchool
{

  // 学校管理员管辖学校列表
  // 注：学校管理员，一学校只能设一个

  // 本校教师分配
  public static function dist($sch_admin_user_id, $user_uid)
  {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;
      $user_id = xovUser::checkUid2Id($user_uid);
      $user_sch_id = xonUserSchool::add($user_id, $sch_id);
      $result = xovUserSchool::getsById($user_sch_id);
    });
    return $result;
  }

  // 本校成员记录
  public static function member($sch_admin_user_id, $user_id)
  {
    $result = null;
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_id, &$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = xovUserSchool::getBy(compact('user_id', 'sch_id'));
    });
    return $result;
  }

  // 本校成员列表
  public static function members($sch_admin_user_id)
  {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = xovUserSchool::getsBy(compact('sch_id'));
    });
    return $result;
  }

  // 本校成员查询
  public static function memfind($sch_admin_user_id, $like_name)
  {
    $result = [];
    $user_name = x5on::getLike($like_name);
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_name, &$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = xovUserSchool::likesBy(compact('sch_id'), compact('user_name'));
    });
    return $result;
  }

  // 删除本校成员
  public static function del($sch_admin_user_id, $user_sch_uid)
  {
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_sch_uid) {
      $user_sch = xonUserSchool::checkByUid($user_sch_uid);
      $user_sch_id = $user_sch->id;
      // 删除学校权限组所有记录
      xonUserSchoolGroup::delBy(compact('user_sch_id'));
      // 删除学校用户
      xonUserSchool::delById($user_sch_id);
    });
  }

  // 教师学校切换
  public static function changeSchool($user_sch_uid)
  {
    // 一、查询编号对应记录
    $user_sch = xonUserSchool::checkByUid($user_sch_uid);
    // 二、清除编号对应用户的状态
    $checked = 0;
    xonUserSchool::setsBy(compact('checked'), compact('user_id'));
    // 三、更新编号对应记录
    $checked = 1;
    return xonUserSchool::setsByUid(compact('checked'), $user_sch_uid);
  }


}
