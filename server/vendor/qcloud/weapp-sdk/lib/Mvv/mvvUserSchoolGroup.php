<?php

namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGroup;
use QCloud_WeApp_SDK\Model\xonUserSchoolGroup;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovUserSchool;
use QCloud_WeApp_SDK\Model\xovUserSchoolGroup;
use QCloud_WeApp_SDK\Model\xovUserSchoolGroupAll;

class mvvUserSchoolGroup
{

  // 检测是否学校管理员
  public static function schAdmin($user_id, $success)
  {
    // 查找用户对应学校，有多重设置，返回第一个
    $checked = 1;
    xovUserSchoolGroupAll::checkByCustom(compact('user_id', 'checked'), '不属于任何学校，无法操作');

    // todo: 上面、下面，这种可能要变成xovUserSchoolGroupAll

    $group_id = x5on::GROUP_ADMIN_SCHOOL;
    $user_sch_group = xovUserSchoolGroupAll::checkByCustom(compact('user_id', 'group_id', 'checked'), '不是学校管理员，无法操作');
    call_user_func($success, $user_sch_group);
  }

  // 学校分组教师分配
  public static function dist($sch_admin_user_id, $user_sch_uid, $group_uid)
  {
    $result = [];
    self::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_sch_uid, $group_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 检测是否为当前学校的分组
      $groups = mvvGroup::groupLess(x5on::GROUP_ADMIN_SCHOOL);
      $group = x5on::checkArr($groups, 'uid', $group_uid);
      $group_id = $group->id;

      // 查询教师对应学校记录
      $user_sch_id = xovUserSchool::checkUid2Id($user_sch_uid);

      xonUserSchoolGroup::add($user_sch_id, $group_id);
      $result = xovUserSchoolGroup::getsBy(compact('sch_id', 'group_id'));
    });
    return $result;
  }


  // 学校分组教师列表
  public static function members($sch_admin_user_id, $group_uid)
  {
    $result = [];
    self::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($group_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 检测是否为当前学校的分组
      $groups = mvvGroup::groupLess(x5on::GROUP_ADMIN_SCHOOL);
      $group = x5on::checkArr($groups, 'uid', $group_uid);
      $group_id = $group->id;

      // 当前组教师列表
      $result = xovUserSchoolGroup::getsBy(compact('sch_id', 'group_id'));
    });
    return $result;
  }

  // 学校分组教师查询
  public static function memfind($sch_admin_user_id, $group_uid, $like_name)
  {
    $result = [];
    self::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($group_uid, $like_name, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 检测是否为当前学校的分组
      $groups = mvvGroup::groupLess(x5on::GROUP_ADMIN_SCHOOL);
      $group = x5on::checkArr($groups, 'uid', $group_uid);
      $group_id = $group->id;

      // 当前组教师查询
      $user_name = x5on::getLike($like_name);
      $result = xovUserSchoolGroup::likesBy(compact('sch_id', 'group_id'), compact('user_name'));
    });
    return $result;
  }

  // 学校分组教师删除
  public static function del($sch_admin_user_id, $user_sch_group_uid)
  {
    $result = [];
    self::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_sch_group_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      // 当前组教师记录
      $user_sch_group_del = xovUserSchoolGroup::checkByUid($user_sch_group_uid);
      $group_id = $user_sch_group_del->group_id;

      // 删除当前组教师记录
      xonUserSchoolGroup::delByUid($user_sch_group_uid);

      // 当前组教师列表
      $result = xovUserSchoolGroup::getsBy(compact('sch_id', 'group_id'));
    });
    return $result;
  }

  // 合并分组列表与教师分组
  private static function doMerge($groups, $sch_groups) {
    $result = [];
    foreach ($groups as $key => $group) {
      $has_role = 0;
      foreach ($sch_groups as $sch_group) {
        if ($group->id === $sch_group->group_id) {
          $has_role = 1;
          break;
        }
      }
      $groups[$key]->has_role = $has_role;
      array_push($result, $groups[$key]);
    }
    return $result;
  }

  // 教师所属分组查询
  public static function groups($sch_admin_user_id, $user_sch_uid)
  {
    $result = [];
    self::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_sch_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $user_sch = xovUserSchool::checkByUid($user_sch_uid);
      $user_sch_id = $user_sch->id;

      $groups = mvvGroup::groupLess(x5on::GROUP_ADMIN_SCHOOL);
      $sch_groups = xonUserSchoolGroup::getsBy(compact('user_sch_id'));

      // 返回合并后的教师分组情况数组
      $result = self::doMerge($groups, $sch_groups);
    });
    return $result;
  }

  private static function doGroups($user_sch_id, $groups, $groups_json) {
    $new_groups = json_decode($groups_json);
    foreach ($new_groups as $uid => $value) {
      foreach ($groups as $group) {
        // 检测是否组成员
        if ($uid === $group->uid) {
          $grp = xonGroup::getByUid($uid);
          $group_id = $grp->id;
          $user_sch_group = xonUserSchoolGroup::getBy(compact('user_sch_id', 'group_id'));

          // 判断为真，不存在，添加
          $value && $user_sch_group === null && xonUserSchoolGroup::add($user_sch_id, $group_id);
          // 判断为假，存在，删除
          !$value && $user_sch_group !== null && xonUserSchoolGroup::delBy(compact('user_sch_id', 'group_id'));
        }
      }
    }
  }

  // 教师所属分组更新
  public static function update($sch_admin_user_id, $user_sch_uid, $groups_json)
  {
    self::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($user_sch_uid, $groups_json) {
      $user_sch = xovUserSchool::checkByUid($user_sch_uid);
      $user_sch_id = $user_sch->id;

      $groups = mvvGroup::groupLess(x5on::GROUP_ADMIN_SCHOOL);

      // 返回合并后的教师分组情况数组
      $result = self::doGroups($user_sch_id, $groups, $groups_json);
    });
  }





}
