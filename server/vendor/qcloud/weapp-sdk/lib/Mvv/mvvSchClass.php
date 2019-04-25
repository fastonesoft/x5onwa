<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonClass;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonSchStep;
use QCloud_WeApp_SDK\Model\xovClass;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovSchEdu;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovSchYear;


class mvvSchClass
{

  public static function classes($sch_admin_user_id, $grade_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovClass::getsBy(compact('grade_id'));
    });
    return $result;
  }

  public static function add($sch_admin_user_id, $grade_id, $num) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_id, $num, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonClass::add($grade_id, $num);
    });
    return $result;
  }

  public static function adds($sch_admin_user_id, $grade_id, $nums) {
    $result = 0;
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($grade_id, $nums, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonClass::adds($grade_id, $nums);
    });
    return $result;
  }

  public static function edit($sch_admin_user_id, $sch_class_uid, $num) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_class_uid, $num, &$result) {
      $sch_id = $user_sch_group->sch_id;

      xonClass::checkByUid($sch_class_uid);
      $result = xonClass::setsByUid(compact('num'), $sch_class_uid);
    });
    return $result;
  }

  public static function del($sch_admin_user_id, $sch_class_uid) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_class_uid) {
      $sch_id = $user_sch_group->sch_id;

      xonClass::checkByUid($sch_class_uid);
      $result = xonClass::delByUidCustom($sch_class_uid);
    });
    return $result;
  }

}
