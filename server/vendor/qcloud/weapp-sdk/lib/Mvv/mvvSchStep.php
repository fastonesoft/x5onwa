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

      $current_year = 1;
      $result = xovSchYear::getsBy(compact('sch_id', 'current_year'));
    });
    return $result;
  }

  public static function add($sch_admin_user_id, $name, $code, $years_id, $graduated_year, $can_recruit, $graduated) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($name, $code, $years_id, $graduated_year, $can_recruit, $graduated, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonSchStep::add($name, $code, $years_id, $graduated_year, $can_recruit, $graduated);
    });
    return $result;
  }

  public static function edit($sch_admin_user_id, $uid, $graduated_year, $can_recruit_string, $graduated_string) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($uid, $graduated_year, $can_recruit_string, $graduated_string, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $graduated = x5on::getBool($graduated_string);
      $can_recruit = x5on::getBool($can_recruit_string);

      xonSchStep::setsByUid(compact('graduated_year', 'can_recruit', 'graduated'), $uid);
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
