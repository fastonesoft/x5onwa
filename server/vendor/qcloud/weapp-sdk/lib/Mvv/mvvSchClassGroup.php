<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonClass;
use QCloud_WeApp_SDK\Model\xonClassGroup;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonGradeGroup;
use QCloud_WeApp_SDK\Model\xonSchStep;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovClassGroup2Divi;
use QCloud_WeApp_SDK\Model\xovClassGroupDivi;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovSchEdu;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovSchYear;


class mvvSchClassGroup
{

  public static function groups($sch_admin_user_id, $grade_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonGradeGroup::getsBy(compact('grade_id'));
    });
    return $result;
  }

  public static function classes($sch_admin_user_id, $grade_group_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_group_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovClassGroupDivi::getsBySuff(compact('grade_group_id'), 'order by num');
    });
    return $result;
  }

  public static function class2div($sch_admin_user_id, $grade_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovClassGroup2Divi::getsBySuff(compact('grade_id'), 'order by num');
    });
    return $result;
  }

  public static function adds($sch_admin_user_id, $grade_group_id, $cls_uids) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_group_id, $cls_uids, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonClassGroup::adds($grade_group_id, $cls_uids);
    });
    return $result;
  }

  public static function del($sch_admin_user_id, $sch_class_group_uid) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_class_group_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      xonClassGroup::checkByUid($sch_class_group_uid);
      $result = xonClassGroup::delByUidCustom($sch_class_group_uid);
    });
    return $result;
  }

}
