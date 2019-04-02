<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonUserSchool;
use QCloud_WeApp_SDK\Model\xonUserSchoolGroup;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovSchool;
use QCloud_WeApp_SDK\Model\xovSchool2Dist;
use QCloud_WeApp_SDK\Model\xovSchoolDist;
use QCloud_WeApp_SDK\Model\xonUserGroupSchool;
use QCloud_WeApp_SDK\Model\xovUserSchool;
use QCloud_WeApp_SDK\Model\xovUserSchoolGroup;
use QCloud_WeApp_SDK\Model\xovUserSchoolGroupAll;

class mvvSchool
{

  public static function refresh($schs_id) {
    $group_id = x5on::GROUP_ADMIN_SCHOOL;
    $schos = xovSchool2Dist::getsBy(compact('schs_id'));
    $members = xovUserSchoolGroupAll::getsBy(compact('schs_id', 'group_id'));
    return compact('schos', 'members');
  }

  public static function dist($user_uid, $sch_uid) {
    $user = xovUser::checkByUid($user_uid);
    $user_id = $user->id;
    $scho = xovSchool::checkByUid($sch_uid);
    $sch_id = $scho->id;
    $schs_id = $scho->schs_id;

    // 查询教师是否注册，否，添加
    $user_sch = xonUserSchool::getBy(compact('user_id', 'sch_id'));
    if ($user_sch === null) {
      $user_sch_id = xonUserSchool::add($user_id, $sch_id);
      $user_sch = xonUserSchool::getById($user_sch_id);
    }
    $user_sch_id = $user_sch->id;

    // 查询教师是否分配管理
    $group_id = x5on::GROUP_ADMIN_SCHOOL;
    $user_sch_group = xovUserSchoolGroupAll::existByCustom(compact('user_id', 'group_id'), '已经是学校管理员，不能重复设置');
    xonUserSchoolGroup::add($user_sch_id, $group_id);

    // 返回数据
    return self::refresh($schs_id);
  }

  // 学校管理删除
  public static function del($user_sch_group_uid) {
    // 查询管理员记录
    $user_sch_group = xovUserSchoolGroupAll::checkByUid($user_sch_group_uid);
    $schs_id = $user_sch_group->schs_id;
    $user_sch_id = $user_sch_group->user_sch_id;

    // 删除管理组用户记录
    $group_id = x5on::GROUP_ADMIN_SCHOOL;
    xonUserSchoolGroup::delBy(compact('user_sch_id', 'group_id'));

    // 返回数据
    return self::refresh($schs_id);
  }


}
