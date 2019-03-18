<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xovUser;
use QCloud_WeApp_SDK\Model\xovSchool;
use QCloud_WeApp_SDK\Model\xovSchool2Dist;
use QCloud_WeApp_SDK\Model\xovSchoolDist;
use QCloud_WeApp_SDK\Model\xonUserGroupSchool;
use QCloud_WeApp_SDK\Model\xovUserGroupSchools;

class mvvSchool
{

  public static function refresh($schs_id) {
    $group_id = x5on::GROUP_ADMIN_SCHOOL;
    $schos = xovSchool2Dist::getsBy(compact('schs_id'));
    $members = xovUserGroupSchools::getsBy(compact('schs_id', 'group_id'));
    return compact('schos', 'members');
  }

  public static function dist($user_uid, $sch_uid) {
    $user = xovUser::checkByUid($user_uid);
    $user_id = $user->id;
    $school = xovSchool::checkByUid($sch_uid);
    $sch_id = $school->id;
    $schs_id = $school->schs_id;

    // 检测是否已分配
    $group_id = x5on::GROUP_ADMIN_SCHOOL;
    xonUserGroupSchool::existByCustom(compact('sch_id', 'group_id'), '学校已分配管理，请删除再重试');
    xonUserGroupSchool::existByCustom(compact('user_id', 'group_id'), '用户已分配学校管理，不得重复分配');

    // 分配学校组权限
    xonUserGroupSchool::add($sch_id, $user_id, $group_id);
    // 返回数据
    return self::refresh($schs_id);
  }

  public static function del($user_group_school_uid) {
    $user_group_school = xovUserGroupSchools::checkByUid($user_group_school_uid);
    $schs_id = $user_group_school->schs_id;
    // 删除学校用户组
    xonUserGroupSchool::delByUid($user_group_school_uid);
    // 返回数据
    return self::refresh($schs_id);
  }


}
