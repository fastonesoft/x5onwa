<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\x5on;
use QCloud_WeApp_SDK\Model\xonSchStep;
use QCloud_WeApp_SDK\Model\xovSchStep;
use QCloud_WeApp_SDK\Model\xovSchYear;


class mvvSchStep
{

  public static function steps($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovSchStep::getsBy(compact('sch_id'));
    });
    return $result;
  }

  public static function year($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $is_current = 1;
      $result = xovSchYear::getsBy(compact('sch_id', 'is_current'));
    });
    return $result;
  }

  public static function add($sch_admin_user_id, $name, $code, $years_id, $graded_year, $recruit_end, $graduated) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($name, $code, $years_id, $graded_year, $recruit_end, $graduated, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonSchStep::add($name, $code, $years_id, $graded_year, $recruit_end, $graduated);
    });
    return $result;
  }

  public static function edit($sch_admin_user_id, $uid, $graded_year, $recruit_end_string, $graduated_string) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($uid, $graded_year, $recruit_end_string, $graduated_string, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $graduated = x5on::getBool($graduated_string);
      $recruit_end = x5on::getBool($recruit_end_string);

      xonSchStep::setsByUid(compact('graded_year', 'recruit_end', 'graduated'), $uid);
      $result =  xovSchStep::getByUid($uid);
    });
    return $result;
  }

  public static function del($sch_admin_user_id, $sch_step_uid) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_step_uid) {
      $sch_id = $user_sch_group->sch_id;

      xonSchStep::checkByUid($sch_step_uid);
      $result = xonSchStep::delByUidCustom($sch_step_uid);
    });
    return $result;
  }

}
