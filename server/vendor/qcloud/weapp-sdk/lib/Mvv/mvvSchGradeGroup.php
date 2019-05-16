<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonClass;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonGradeGroup;
use QCloud_WeApp_SDK\Model\xonSchStep;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovSchEdu;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovSchYear;


class mvvSchGradeGroup
{

  public static function groups($sch_admin_user_id, $grade_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonGradeGroup::getsBy(compact('grade_id'));
    });
    return $result;
  }

  public static function add($sch_admin_user_id, $grade_id, $name) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_id, $name, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonGradeGroup::add($grade_id, $name);
    });
    return $result;
  }

  public static function edit($sch_admin_user_id, $sch_grade_group_uid, $name) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_grade_group_uid, $name, &$result) {
      $sch_id = $user_sch_group->sch_id;

      xonGradeGroup::checkByUid($sch_grade_group_uid);
      xonGradeGroup::setsByUid(compact('name'), $sch_grade_group_uid);
      // 返回记录，前端无刷新变更
      $result = xonGradeGroup::getByUid($sch_grade_group_uid);
    });
    return $result;
  }

  public static function del($sch_admin_user_id, $sch_grade_group_uid) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_grade_group_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      xonGradeGroup::checkByUid($sch_grade_group_uid);
      $result = xonGradeGroup::delByUidCustom($sch_grade_group_uid);
    });
    return $result;
  }

}
