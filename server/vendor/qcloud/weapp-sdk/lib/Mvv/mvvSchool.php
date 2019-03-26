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

    // 分配教师学校
    $user_sch_id = xonUserSchool::add($user_id, $sch_id);

    // 分配教师学校组
    $group_id = x5on::GROUP_ADMIN_SCHOOL;
    $userschgroup_uid = xonUserSchoolGroup::add($user_sch_id, $group_id);

    // 返回数据
    return self::refresh($schs_id);
  }

  public static function del($user_sch_id) {
    $user_sch = xovUserSchool::checkById($user_sch_id);
    $schs_id = $user_sch->schs_id;
    // 删除管理组用户记录
    $group_id = x5on::GROUP_ADMIN_SCHOOL;
    xonUserSchoolGroup::delBy(compact('user_sch_id', 'group_id'));
    // 删除学校用户管理员记录
    xonUserSchool::delById($user_sch_id);
    // 返回数据
    return self::refresh($schs_id);
  }


}
