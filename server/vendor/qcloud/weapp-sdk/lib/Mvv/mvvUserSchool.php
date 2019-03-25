<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonSchool;
use QCloud_WeApp_SDK\Model\xonUserSchool;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovUserSchool;

class mvvUserSchool
{

  // 学校管理员管辖学校列表
  public static function schos($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = xonSchool::getsById($sch_id);
    });
    return $result;
  }

  // 本校教师分配
  public static function distTch($sch_admin_user_id, $user_uid) {
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_uid) {
      $sch_id = $user_sch_group->sch_id;
      $user_id = xovUser::checkUid2Id($user_uid);
      xonUserSchool::add($user_id, $sch_id);
    });
  }

  // 学校教师分配
  public static function distSchTch($sch_admin_user_id, $user_uid, $sch_uid) {
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_uid, $sch_uid) {
      $sch_id = xonSchool::checkUid2Id($sch_uid);
      $user_id = xovUser::checkUid2Id($user_uid);
      xonUserSchool::add($user_id, $sch_id);
    });
  }

  // 本校成员列表
  public static function memberTch($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = xovUserSchool::getsBy(compact('sch_id'));
    });
    return $result;
  }

  // 学校成员列表
  public static function memberSchTch($sch_admin_user_id, $sch_uid) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_uid, &$result) {
      $sch_id = xonSchool::checkUid2Id($sch_uid);
      $result = xovUserSchool::getsBy(compact('sch_id'));
    });
    return $result;
  }

  // 本校成员查询
  public static function memfindTch($sch_admin_user_id, $user_name) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_name, &$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = xovUserSchool::likesBy(compact('sch_id'), compact('user_name'));
    });
    return $result;
  }

  // 学校成员查询
  public static function memfindSchTch($sch_admin_user_id, $sch_uid, $user_name) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_uid, $user_name, &$result) {
      $sch_id = xonSchool::checkUid2Id($sch_uid);
      $result = xovUserSchool::likesBy(compact('sch_id'), compact('user_name'));
    });
    return $result;
  }

  // 教师学校切换
  public static function changeSchool($user_group_uid) {
    // 一、查询编号对应记录
    $user_group = xonUserGroupSchool::checkByUid($user_group_uid);
    $user_id = $user_group->user_id;
    // 二、清除编号对应用户的状态
    $checked = 0;
    xonUserGroupSchool::setsBy(compact('checked'), compact('user_id'));
    // 三、更新编号对应记录
    $checked = 1;
    return xonUserGroupSchool::setsByUid(compact('checked'), $user_group_uid);
  }



}
