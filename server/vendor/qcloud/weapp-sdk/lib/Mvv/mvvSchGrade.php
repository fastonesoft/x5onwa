<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonGrade;
use QCloud_WeApp_SDK\Model\xonSchStep;
use QCloud_WeApp_SDK\Model\xovGradeCurrent;
use QCloud_WeApp_SDK\Model\xovSchEdu;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovSchYear;


class mvvSchGrade
{

  public static function grades($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovGradeCurrent::getsBy(compact('sch_id'));
    });
    return $result;
  }

  public static function year($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $current_year = 1;
      $result = xovSchYear::getsBy(compact('sch_id', 'current_year'));
    });
    return $result;
  }

  public static function steps($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovSchStep::getsBy(compact('sch_id'));
    });
    return $result;
  }

  public static function edus($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovSchEdu::getsBy(compact('sch_id'));
    });
    return $result;
  }


  public static function add($sch_admin_user_id, $years_id, $steps_id, $edus_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($years_id, $steps_id, $edus_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonGrade::add($sch_id, $years_id, $steps_id, $edus_id);
    });
    return $result;
  }

  public static function del($sch_admin_user_id, $sch_grade_uid) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_grade_uid) {
      $sch_id = $user_sch_group->sch_id;

      xonGrade::checkByUid($sch_grade_uid);
      $result = xonGrade::delByUidCustom($sch_grade_uid);
    });
    return $result;
  }

}
