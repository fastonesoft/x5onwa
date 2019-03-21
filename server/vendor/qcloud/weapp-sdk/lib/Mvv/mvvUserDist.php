<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonGroup;
use QCloud_WeApp_SDK\Model\xonSchool;
use QCloud_WeApp_SDK\Model\xonUserGroupSchool;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovUserSchoolGroup;

class mvvUserDist
{

  // 学校管理员管辖学校列表
  public static function schos($sch_admin_user_id) {
    $result = [];
    mvvUserGroupSchool::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;
      $result = xonSchool::getsById($sch_id);
    });
    return $result;
  }

  // 只能分配本校
  public static function dist($sch_admin_user_id, $user_uid, $group_uid) {
    mvvUserGroupSchool::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_uid, $group_uid) {
      $sch_id = $user_sch_group->sch_id;
      $user_id = xovUser::checkUid2Id($user_uid);
      $group_id = xonGroup::checkUid2Id($group_uid);
      xonUserGroupSchool::add($sch_id, $user_id, $group_id);
    });
  }

  // 指定学校分配
  public static function dists($sch_admin_user_id, $user_uid, $group_uid, $sch_uid) {
    mvvUserGroupSchool::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_uid, $group_uid, $sch_uid) {
      $sch_id = xonSchool::checkUid2Id($sch_uid);
      $user_id = xovUser::checkUid2Id($user_uid);
      $group_id = xonGroup::checkUid2Id($group_uid);
      xonUserGroupSchool::add($sch_id, $user_id, $group_id);
    });
  }

  // 学校分组成员
  public static function member($sch_admin_user_id, $group_uid, $sch_uid) {
    $result = [];
    mvvUserGroupSchool::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($group_uid, $sch_uid, &$result) {
      $sch_id = xonSchool::checkUid2Id($sch_uid);
      $group_id = xonGroup::checkUid2Id($group_uid);
      $result = xovUserSchoolGroup::getsBy(compact('sch_id', 'group_id'));
    });
    return $result;
  }

  // 学校分组成员查询
  public static function memfind($sch_admin_user_id, $group_uid, $sch_uid, $user_name) {
    $result = [];
    mvvUserGroupSchool::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($group_uid, $sch_uid, $user_name, &$result) {
      $sch_id = xonSchool::checkUid2Id($sch_uid);
      $group_id = xonGroup::checkUid2Id($group_uid);
      $result = xovUserSchoolGroup::likesBy(compact('sch_id', 'group_id'), compact('user_name'));
    });
    return $result;
  }


}
