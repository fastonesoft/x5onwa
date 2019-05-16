<?php
namespace QCloud_WeApp_SDK\Mvv;

use QCloud_WeApp_SDK\Model\xonEdu;
use QCloud_WeApp_SDK\Model\xonSchEdu;
use QCloud_WeApp_SDK\Model\xovSchEdu;

class mvvSchEdu
{

  public static function edus($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xovSchEdu::getsBy(compact('sch_id'));
    });
    return $result;
  }

  public static function edu($sch_admin_user_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use (&$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonEdu::gets();
    });
    return $result;
  }


  public static function add($sch_admin_user_id, $edu_id) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($edu_id, &$result) {
      $sch_id = $user_sch_group->sch_id;

      $result = xonSchEdu::add($sch_id, $edu_id);
    });
    return $result;
  }

  public static function del($sch_admin_user_id, $sch_edu_uid) {
    $result = [];
    mvvUserSchoolGroup::schAdmin($sch_admin_user_id, function ($user_sch_group) use ($sch_edu_uid, &$result) {
      $sch_id = $user_sch_group->sch_id;

      xonSchEdu::checkByUid($sch_edu_uid);
      $result = xonSchEdu::delByUidCustom($sch_edu_uid);
    });
    return $result;
  }

}
